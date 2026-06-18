<?php

namespace Modules\Schedule\DTOs;

class HolidayCalendarData
{
    public function __construct(
        public string $date,
        public string $name,
        public string $type = 'holiday',
        public bool $isPaid = true,
        public float $workdayValue = 1,
        public ?string $note = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'name' => $this->name,
            'type' => $this->type,
            'is_paid' => $this->isPaid,
            'workday_value' => $this->workdayValue,
            'note' => $this->note,
        ];
    }
}
