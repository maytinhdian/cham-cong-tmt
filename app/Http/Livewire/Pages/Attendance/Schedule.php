<?php

namespace App\Http\Livewire\Pages\Attendance;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Schedule\Actions\AssignShiftAction;
use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;

class Schedule extends Component
{
    public array $employeeIds = [];

    public $assignDepartmentId = '';

    public $shiftId = null;

    public string $assignDateFrom = '';

    public string $assignDateTo = '';

    public string $scheduleType = 'work';

    public string $status = 'planned';

    public ?string $note = null;

    public $departmentFilter = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    /**
     * Prepare default schedule assignment and calendar filters.
     */
    public function mount(): void
    {
        $firstEmployeeId = Employee::query()->orderBy('employee_code')->value('id');

        $this->employeeIds = $firstEmployeeId ? [(string) $firstEmployeeId] : [];
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->assignDateFrom = now()->toDateString();
        $this->assignDateTo = now()->toDateString();
        $this->dateFrom = now()->startOfWeek()->toDateString();
        $this->dateTo = now()->endOfWeek()->toDateString();
    }

    /**
     * Assign one schedule setup to a department or selected employees across a date range.
     */
    public function assignSchedule(): void
    {
        $validated = $this->validate([
            'assignDepartmentId' => ['nullable', 'exists:departments,id'],
            'employeeIds' => ['array'],
            'employeeIds.*' => ['integer', 'exists:employees,id'],
            'shiftId' => ['nullable', 'exists:shifts,id'],
            'assignDateFrom' => ['required', 'date'],
            'assignDateTo' => ['required', 'date', 'after_or_equal:assignDateFrom'],
            'scheduleType' => ['required', 'string', 'max:40'],
            'status' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'assignDateFrom.required' => 'Vui lòng chọn ngày bắt đầu.',
            'assignDateTo.required' => 'Vui lòng chọn ngày kết thúc.',
            'assignDateTo.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
        ]);

        $employeeIds = $this->targetEmployeeIds($validated);

        if ($employeeIds->isEmpty()) {
            $this->addError('employeeIds', 'Vui lòng chọn phòng ban hoặc ít nhất một nhân viên để phân ca.');

            return;
        }

        $dates = $this->assignmentDates($validated['assignDateFrom'], $validated['assignDateTo']);
        $assignShift = app(AssignShiftAction::class);

        foreach ($employeeIds as $employeeId) {
            foreach ($dates as $date) {
                $assignShift->execute(new EmployeeScheduleData(
                    employeeId: (int) $employeeId,
                    shiftId: $this->nullableInt($validated['shiftId']),
                    workDate: $date,
                    scheduleType: $validated['scheduleType'],
                    status: $validated['status'],
                    note: $validated['note'] ?: null,
                ));
            }
        }

        $this->departmentFilter = $this->assignDepartmentId ?: $this->departmentFilter;
        $this->dateFrom = $validated['assignDateFrom'];
        $this->dateTo = $validated['assignDateTo'];

        session()->flash('success', sprintf(
            'Đã cập nhật %d dòng lịch làm việc cho %d nhân viên.',
            $employeeIds->count() * count($dates),
            $employeeIds->count()
        ));
    }

    /**
     * Delete one declared employee schedule row.
     */
    public function deleteSchedule(int $scheduleId): void
    {
        EmployeeSchedule::query()->findOrFail($scheduleId)->delete();

        session()->flash('success', 'Đã xóa dòng lịch làm việc.');
    }

    /**
     * Render schedule assignment controls, the compact grid, and declared schedule rows.
     */
    public function render()
    {
        $employees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->departmentFilter, fn ($query) => $query->where('department_id', $this->departmentFilter))
            ->orderBy('employee_code')
            ->get();

        $schedules = EmployeeSchedule::query()
            ->with(['employee.department', 'employee.position', 'shift'])
            ->when($this->departmentFilter, function ($query) {
                $query->whereHas('employee', fn ($employeeQuery) => $employeeQuery->where('department_id', $this->departmentFilter));
            })
            ->when($this->dateFrom, fn ($query) => $query->whereDate('work_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($query) => $query->whereDate('work_date', '<=', $this->dateTo))
            ->orderBy('work_date')
            ->orderBy('employee_id')
            ->get();

        $assignmentEmployees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->assignDepartmentId, fn ($query) => $query->where('department_id', $this->assignDepartmentId))
            ->orderBy('employee_code')
            ->get();

        return view('livewire.pages.attendance.schedule', [
            'departments' => Department::query()->orderBy('sort_order')->orderBy('name')->get(),
            'assignmentEmployees' => $assignmentEmployees,
            'employees' => $employees,
            'scheduleDays' => $this->scheduleDays(),
            'schedules' => $schedules,
            'shifts' => Shift::query()->orderBy('start_time')->orderBy('name')->get(),
        ]);
    }

    /**
     * Build the visible calendar day headers, capped to keep the grid compact.
     */
    private function scheduleDays(): array
    {
        $start = Carbon::parse($this->dateFrom ?: now()->startOfWeek());
        $end = Carbon::parse($this->dateTo ?: now()->endOfWeek());

        if ($start->diffInDays($end) > 13) {
            $end = $start->copy()->addDays(13);
        }

        $days = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[] = $date->copy();
        }

        return $days;
    }

    /**
     * Convert empty Livewire select values into nullable integers.
     */
    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }

    /**
     * Resolve the employee targets from the selected department or explicit employee list.
     */
    private function targetEmployeeIds(array $validated): Collection
    {
        if (! empty($validated['assignDepartmentId'])) {
            return Employee::query()
                ->where('department_id', $validated['assignDepartmentId'])
                ->orderBy('employee_code')
                ->pluck('id');
        }

        return collect($validated['employeeIds'] ?? [])
            ->filter()
            ->map(fn ($employeeId) => (int) $employeeId)
            ->unique()
            ->values();
    }

    /**
     * Build all assignment dates between the selected start and end date.
     */
    private function assignmentDates(string $dateFrom, string $dateTo): array
    {
        return collect(CarbonPeriod::create($dateFrom, $dateTo))
            ->map(fn (Carbon $date) => $date->toDateString())
            ->all();
    }
}
