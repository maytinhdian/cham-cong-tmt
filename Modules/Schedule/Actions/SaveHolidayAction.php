<?php

namespace Modules\Schedule\Actions;

use Modules\Schedule\DTOs\HolidayCalendarData;
use Modules\Schedule\Models\HolidayCalendar;
use Modules\Schedule\Services\HolidayCalendarService;

class SaveHolidayAction
{
    public function __construct(private readonly HolidayCalendarService $holidayService)
    {
    }

    public function execute(HolidayCalendarData $data): HolidayCalendar
    {
        return $this->holidayService->saveHoliday($data);
    }
}
