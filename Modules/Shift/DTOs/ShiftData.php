<?php

namespace Modules\Shift\DTOs;

class ShiftData
{
    public function __construct(
        public string $code,
        public string $name,
        public string $startTime,
        public string $endTime,
        public ?string $clockInFrom = null,
        public ?string $clockInTo = null,
        public ?string $clockOutFrom = null,
        public ?string $clockOutTo = null,
        public int $maxLateMinutes = 0,
        public int $maxEarlyLeaveMinutes = 0,
        public float $workdayValue = 1,
        public int $standardWorkMinutes = 480,
        public bool $requiresClockIn = true,
        public bool $requiresClockOut = true,
        public string $displayColor = '#3b82f6',
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'clock_in_from' => $this->clockInFrom,
            'clock_in_to' => $this->clockInTo,
            'clock_out_from' => $this->clockOutFrom,
            'clock_out_to' => $this->clockOutTo,
            'max_late_minutes' => $this->maxLateMinutes,
            'max_early_leave_minutes' => $this->maxEarlyLeaveMinutes,
            'workday_value' => $this->workdayValue,
            'standard_work_minutes' => $this->standardWorkMinutes,
            'requires_clock_in' => $this->requiresClockIn,
            'requires_clock_out' => $this->requiresClockOut,
            'display_color' => $this->displayColor,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
