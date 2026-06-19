<?php

namespace Modules\Leave\Services;

use Modules\Leave\DTOs\ApprovedLeaveData;
use Modules\Leave\Models\ApprovedLeave;

class ApprovedLeaveService
{
    /**
     * Create or replace one approved leave record for an employee and date.
     */
    public function save(ApprovedLeaveData $data): ApprovedLeave
    {
        return ApprovedLeave::query()->updateOrCreate(
            [
                'employee_id' => $data->employeeId,
                'leave_date' => $data->leaveDate,
            ],
            $data->toArray()
        );
    }

    /**
     * Remove an approved leave record when it is cancelled.
     */
    public function delete(ApprovedLeave $leave): void
    {
        $leave->delete();
    }
}
