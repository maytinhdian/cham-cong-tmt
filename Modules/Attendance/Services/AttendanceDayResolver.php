<?php

namespace Modules\Attendance\Services;

use Carbon\CarbonInterface;
use Modules\Attendance\DTOs\AttendanceDayContext;
use Modules\Schedule\Models\HolidayCalendar;
use Modules\Schedule\Models\WeekendSetting;

class AttendanceDayResolver
{
    /**
     * Resolve whether one calendar date is a normal workday, weekend, or holiday.
     */
    public function resolve(CarbonInterface $workDate): AttendanceDayContext
    {
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
