<?php

namespace App\Http\Livewire\Pages\Attendance;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Schedule\Actions\AssignShiftAction;
use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;

class Schedule extends Component
{
    public $employeeId = null;

    public $shiftId = null;

    public string $workDate = '';

    public string $scheduleType = 'work';

    public string $status = 'planned';

    public ?string $note = null;

    public $departmentFilter = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function mount(): void
    {
        $this->employeeId = Employee::query()->orderBy('employee_code')->value('id');
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->workDate = now()->toDateString();
        $this->dateFrom = now()->startOfWeek()->toDateString();
        $this->dateTo = now()->endOfWeek()->toDateString();
    }

    public function assignSchedule(): void
    {
        $validated = $this->validate([
            'employeeId' => ['required', 'exists:employees,id'],
            'shiftId' => ['nullable', 'exists:shifts,id'],
            'workDate' => ['required', 'date'],
            'scheduleType' => ['required', 'string', 'max:40'],
            'status' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'employeeId.required' => 'Vui lòng chọn nhân viên cần phân ca.',
            'workDate.required' => 'Vui lòng chọn ngày làm việc.',
        ]);

        app(AssignShiftAction::class)->execute(new EmployeeScheduleData(
            employeeId: (int) $validated['employeeId'],
            shiftId: $this->nullableInt($validated['shiftId']),
            workDate: $validated['workDate'],
            scheduleType: $validated['scheduleType'],
            status: $validated['status'],
            note: $validated['note'] ?: null,
        ));

        session()->flash('success', 'Đã cập nhật lịch làm việc cho nhân viên.');
    }

    public function deleteSchedule(int $scheduleId): void
    {
        EmployeeSchedule::query()->findOrFail($scheduleId)->delete();

        session()->flash('success', 'Đã xóa dòng lịch làm việc.');
    }

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

        return view('livewire.pages.attendance.schedule', [
            'departments' => Department::query()->orderBy('sort_order')->orderBy('name')->get(),
            'employees' => $employees,
            'scheduleDays' => $this->scheduleDays(),
            'schedules' => $schedules,
            'shifts' => Shift::query()->orderBy('start_time')->orderBy('name')->get(),
        ]);
    }

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

    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
