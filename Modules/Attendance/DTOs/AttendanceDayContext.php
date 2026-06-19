<?php

namespace Modules\Attendance\DTOs;

use Modules\Schedule\Models\HolidayCalendar;

readonly class AttendanceDayContext
{
    public function __construct(
        public string $dayType,
        public ?HolidayCalendar $holiday = null,
    ) {
    }

    /**
     * Determine whether the work date is treated as a special non-working day.
     */
    public function isSpecialDay(): bool
    {
        return in_array($this->dayType, ['weekend', 'holiday'], true);
    }
}
