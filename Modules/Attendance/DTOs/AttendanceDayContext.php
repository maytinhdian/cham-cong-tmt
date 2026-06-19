<?php

namespace Modules\Attendance\DTOs;

use Modules\Schedule\Models\HolidayCalendar;
use Modules\Leave\Models\ApprovedLeave;

readonly class AttendanceDayContext
{
    public function __construct(
        public string $dayType,
        public ?HolidayCalendar $holiday = null,
        public ?ApprovedLeave $leave = null,
    ) {
    }

    /**
     * Determine whether the work date is treated as a special non-working day.
     */
    public function isSpecialDay(): bool
    {
        return in_array($this->dayType, ['weekend', 'holiday', 'leave'], true);
    }
}
