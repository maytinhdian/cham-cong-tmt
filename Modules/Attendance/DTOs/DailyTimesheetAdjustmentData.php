<?php

namespace Modules\Attendance\DTOs;

readonly class DailyTimesheetAdjustmentData
{
    /**
     * Carry requested manual corrections for one processed daily attendance result.
     */
    public function __construct(
        public int $dailyAttendanceResultId,
        public ?string $clockInAt,
        public ?string $clockOutAt,
        public string $reason,
        public ?string $note = null,
    ) {
    }
}
