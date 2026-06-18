<?php

namespace Modules\Schedule\DTOs;

class EmployeeScheduleData
{
    public function __construct(
        public int $employeeId,
        public ?int $shiftId,
        public string $workDate,
        public string $scheduleType = 'work',
        public string $status = 'planned',
        public ?string $note = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'employee_id' => $this->employeeId,
            'shift_id' => $this->shiftId,
            'work_date' => $this->workDate,
            'schedule_type' => $this->scheduleType,
            'status' => $this->status,
            'note' => $this->note,
        ];
    }
}
