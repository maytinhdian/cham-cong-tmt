<?php

namespace Modules\Leave\DTOs;

class ApprovedLeaveData
{
    public function __construct(
        public int $employeeId,
        public string $leaveDate,
        public string $leaveType = 'leave',
        public float $workdayValue = 0,
        public string $status = 'approved',
        public ?string $note = null,
    ) {
    }

    /**
     * Convert approved leave input into database attributes for persistence.
     */
    public function toArray(): array
    {
        return [
            'employee_id' => $this->employeeId,
            'leave_date' => $this->leaveDate,
            'leave_type' => $this->leaveType,
            'workday_value' => $this->workdayValue,
            'status' => $this->status,
            'note' => $this->note,
        ];
    }
}
