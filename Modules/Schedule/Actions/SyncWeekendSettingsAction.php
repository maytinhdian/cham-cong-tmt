<?php

namespace Modules\Schedule\Actions;

use Modules\Schedule\Services\HolidayCalendarService;

class SyncWeekendSettingsAction
{
    public function __construct(private readonly HolidayCalendarService $holidayService)
    {
    }

    public function execute(array $weekdays): void
    {
        $this->holidayService->syncWeekends($weekdays);
    }
}
