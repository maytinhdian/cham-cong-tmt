<?php

namespace Modules\Attendance\Actions;

use Modules\Attendance\DTOs\DailyTimesheetAdjustmentData;
use Modules\Attendance\Models\DailyTimesheetAdjustment;
use Modules\Attendance\Services\DailyTimesheetAdjustmentService;

class AdjustDailyTimesheetAction
{
    /**
     * Prepare the action with the service that applies daily timesheet corrections.
     */
    public function __construct(private readonly DailyTimesheetAdjustmentService $adjustmentService)
    {
    }

    /**
     * Apply a manual daily timesheet correction and return its history record.
     */
    public function execute(DailyTimesheetAdjustmentData $data): DailyTimesheetAdjustment
    {
        return $this->adjustmentService->adjust($data);
    }
}
