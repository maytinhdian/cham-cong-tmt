<?php

namespace Modules\Shift\DTOs;

class ShiftBreakData
{
    public function __construct(
        public int $shiftId,
        public ?string $name,
        public string $startTime,
        public string $endTime,
        public int $breakMinutes = 0,
        public bool $isPaid = true,
        public string $status = 'active',
        public ?string $description = null,
    ) {
    }

    /**
     * Convert break input into database attributes for persistence.
     */
    public function toArray(): array
    {
        return [
            'shift_id' => $this->shiftId,
            'name' => $this->name,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'break_minutes' => $this->breakMinutes,
            'is_paid' => $this->isPaid,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
