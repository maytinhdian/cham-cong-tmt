<?php

namespace Modules\Attendance\Services;

use Carbon\CarbonInterface;
use Modules\Attendance\DTOs\AttendanceDayContext;
use Modules\Leave\Models\ApprovedLeave;
use Modules\Schedule\Models\HolidayCalendar;
use Modules\Schedule\Models\WeekendSetting;
use Modules\User\Models\Employee;

class AttendanceDayResolver
{
    /**
     * Resolve whether one calendar date is a normal workday, weekend, or holiday.
     */
    public function resolve(Employee $employee, CarbonInterface $workDate): AttendanceDayContext
    {
        $leave = ApprovedLeave::query()
            ->where('employee_id', $employee->id)
            ->whereDate('leave_date', $workDate->toDateString())
            ->where('status', 'approved')
            ->first();

        if ($leave) {
            return new AttendanceDayContext('leave', null, $leave);
        }

        $holiday = HolidayCalendar::query()
            ->whereDate('date', $workDate->toDateString())
            ->first();

        if ($holiday) {
            return new AttendanceDayContext('holiday', $holiday);
        }

        $weekday = (int) $workDate->dayOfWeekIso;
        $isWeekend = WeekendSetting::query()
            ->where('weekday', $weekday)
            ->where('is_weekend', true)
            ->exists();

        return new AttendanceDayContext($isWeekend ? 'weekend' : 'working');
    }
}
