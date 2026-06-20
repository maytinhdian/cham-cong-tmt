<?php

namespace Modules\Shift\DTOs;

class ShiftData
{
    public function __construct(
        public string $code,
        public string $name,
        public string $startTime,
        public string $endTime,
        public ?string $breakStartTime = null,
        public ?string $breakEndTime = null,
        public int $breakMinutes = 0,
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
        public bool $overtimeBeforeShiftEnabled = false,
        public int $overtimeAfterShiftMinMinutes = 0,
        public string $displayColor = '#3b82f6',
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    /**
     * Convert shift input into database attributes for persistence.
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'break_start_time' => $this->breakStartTime,
            'break_end_time' => $this->breakEndTime,
            'break_minutes' => $this->breakMinutes,
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
            'overtime_before_shift_enabled' => $this->overtimeBeforeShiftEnabled,
            'overtime_after_shift_min_minutes' => $this->overtimeAfterShiftMinMinutes,
            'display_color' => $this->displayColor,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
