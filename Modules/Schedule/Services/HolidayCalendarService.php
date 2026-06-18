<?php

namespace Modules\Schedule\Services;

use Modules\Schedule\DTOs\HolidayCalendarData;
use Modules\Schedule\Models\HolidayCalendar;
use Modules\Schedule\Models\WeekendSetting;

class HolidayCalendarService
{
    public function saveHoliday(HolidayCalendarData $data): HolidayCalendar
    {
        return HolidayCalendar::query()->updateOrCreate(
            ['date' => $data->date],
            $data->toArray()
        );
    }

    public function syncWeekends(array $weekdays): void
    {
        $labels = [
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
            7 => 'Chủ nhật',
        ];

        foreach ($labels as $weekday => $label) {
            WeekendSetting::query()->updateOrCreate(
                ['weekday' => $weekday],
                [
                    'label' => $label,
                    'is_weekend' => in_array((string) $weekday, $weekdays, true),
                ]
            );
        }
    }
}
