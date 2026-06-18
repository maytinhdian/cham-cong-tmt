<?php

namespace Modules\Attendance\Engines;

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
            ->with('shift')
            ->where('employee_id', $employee->id)
            ->whereDate('work_date', $date)
            ->first();
    }
}
