<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\User\Models\Employee;

class ShiftMatcher
{
    /**
     * Find the planned employee schedule that should be used for one work date.
     */
    public function match(Employee $employee, CarbonInterface|string $workDate): ?EmployeeSchedule
    {
        $date = is_string($workDate) ? $workDate : $workDate->toDateString();

        return EmployeeSchedule::query()
            ->with(['shift.breaks'])
            ->where('employee_id', $employee->id)
            ->whereDate('work_date', $date)
            ->first();
    }

    /**
     * Find the previous day's schedule when its shift continues into this work date.
     */
    public function previousOvernight(Employee $employee, CarbonInterface|string $workDate): ?EmployeeSchedule
    {
        $date = is_string($workDate)
            ? Carbon::parse($workDate)->subDay()->toDateString()
            : $workDate->copy()->subDay()->toDateString();

        return EmployeeSchedule::query()
            ->with(['shift.breaks'])
            ->where('employee_id', $employee->id)
            ->whereDate('work_date', $date)
            ->whereHas('shift', fn ($query) => $query->whereColumn('end_time', '<=', 'start_time'))
            ->first();
    }
}
