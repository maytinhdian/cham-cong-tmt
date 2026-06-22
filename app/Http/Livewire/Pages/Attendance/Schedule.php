<?php

namespace App\Http\Livewire\Pages\Attendance;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Attendance\Services\AttendanceRuleService;
use Modules\Org\Models\Department;
use Modules\Schedule\Actions\AssignShiftAction;
use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Schedule\Models\WeekendSetting;
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

    public string $scheduleMonth = '';

    public string $employeeSortDirection = 'asc';

    public bool $showAllDeclaredSchedules = false;

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
        $this->scheduleMonth = now()->format('Y-m');
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
        $this->scheduleMonth = Carbon::parse($validated['assignDateFrom'])->format('Y-m');

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
     * Move the monthly schedule grid back by one month.
     */
    public function previousScheduleMonth(): void
    {
        $this->scheduleMonth = $this->scheduleMonthStart()->subMonth()->format('Y-m');
    }

    /**
     * Toggle the detailed declared schedule list between compact and full view.
     */
    public function toggleDeclaredSchedules(): void
    {
        $this->showAllDeclaredSchedules = ! $this->showAllDeclaredSchedules;
    }

    /**
     * Collapse the declared schedule list when the department filter changes.
     */
    public function updatedDepartmentFilter(): void
    {
        $this->showAllDeclaredSchedules = false;
    }

    /**
     * Collapse the declared schedule list when the start date filter changes.
     */
    public function updatedDateFrom(): void
    {
        $this->showAllDeclaredSchedules = false;
    }

    /**
     * Collapse the declared schedule list when the end date filter changes.
     */
    public function updatedDateTo(): void
    {
        $this->showAllDeclaredSchedules = false;
    }

    /**
     * Move the monthly schedule grid forward by one month.
     */
    public function nextScheduleMonth(): void
    {
        $this->scheduleMonth = $this->scheduleMonthStart()->addMonth()->format('Y-m');
    }

    /**
     * Return the monthly schedule grid to the current month.
     */
    public function goToCurrentScheduleMonth(): void
    {
        $this->scheduleMonth = now()->format('Y-m');
    }

    /**
     * Toggle employee ordering in the monthly schedule matrix.
     */
    public function toggleEmployeeSort(): void
    {
        $this->employeeSortDirection = $this->employeeSortDirection === 'asc' ? 'desc' : 'asc';
    }

    /**
     * Render schedule assignment controls, the compact grid, and declared schedule rows.
     */
    public function render()
    {
        $monthStart = $this->scheduleMonthStart();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $employees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->departmentFilter, fn ($query) => $query->where('department_id', $this->departmentFilter))
            ->orderBy('full_name', $this->employeeSortDirection === 'desc' ? 'desc' : 'asc')
            ->orderBy('employee_code')
            ->get();

        $monthlySchedules = EmployeeSchedule::query()
            ->with(['employee.department', 'employee.position', 'shift'])
            ->when($this->departmentFilter, function ($query) {
                $query->whereHas('employee', fn ($employeeQuery) => $employeeQuery->where('department_id', $this->departmentFilter));
            })
            ->whereBetween('work_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->orderBy('work_date')
            ->orderBy('employee_id')
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
            'weekendHighlightColor' => $this->weekendHighlightColor(),
            'weekendHighlightBackground' => $this->weekendHighlightBackground(),
            'weekendWeekdays' => $this->weekendWeekdays(),
            'scheduleDays' => $this->scheduleDays(),
            'monthlyScheduleByEmployeeDate' => $this->monthlyScheduleLookup($monthlySchedules),
            'schedules' => $schedules,
            'shifts' => Shift::query()->orderBy('start_time')->orderBy('name')->get(),
        ]);
    }

    /**
     * Build every visible day in the selected monthly schedule grid.
     */
    private function scheduleDays(): array
    {
        $start = $this->scheduleMonthStart();
        $end = $start->copy()->endOfMonth();

        $days = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[] = $date->copy();
        }

        return $days;
    }

    /**
     * Resolve the selected work schedule month, falling back to the current month.
     */
    private function scheduleMonthStart(): Carbon
    {
        $month = $this->scheduleMonth ?: now()->format('Y-m');

        try {
            return Carbon::createFromFormat('Y-m-d', $month.'-01')->startOfMonth();
        } catch (\Throwable) {
            return now()->startOfMonth();
        }
    }

    /**
     * Index monthly schedules by employee and work date for fast calendar rendering.
     */
    private function monthlyScheduleLookup(Collection $monthlySchedules): array
    {
        $lookup = [];

        foreach ($monthlySchedules as $schedule) {
            $lookup[$schedule->employee_id][$schedule->work_date->toDateString()] = $schedule;
        }

        return $lookup;
    }

    /**
     * Return weekend weekdays using the same ISO weekday values as attendance processing.
     */
    private function weekendWeekdays(): array
    {
        $weekdays = WeekendSetting::query()
            ->where('is_weekend', true)
            ->pluck('weekday')
            ->map(fn ($weekday) => (int) $weekday)
            ->all();

        return $weekdays ?: [7];
    }

    /**
     * Resolve the configurable weekend highlight color for the monthly schedule grid.
     */
    private function weekendHighlightColor(): string
    {
        $ruleService = app(AttendanceRuleService::class);
        $rules = $ruleService->valuesWithDefaults($ruleService->definitions());
        $color = (string) ($rules['weekend_color']['value'] ?? '#f44335');

        return preg_match('/^#[0-9A-Fa-f]{6}$/', $color) ? $color : '#f44335';
    }

    /**
     * Convert the configured weekend color into a visible translucent cell background.
     */
    private function weekendHighlightBackground(): string
    {
        $color = ltrim($this->weekendHighlightColor(), '#');
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));

        return sprintf('rgba(%d, %d, %d, 0.16)', $red, $green, $blue);
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
