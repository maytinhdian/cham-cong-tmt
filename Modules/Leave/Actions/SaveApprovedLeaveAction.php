<?php

namespace Modules\Leave\Actions;

use Modules\Leave\DTOs\ApprovedLeaveData;
use Modules\Leave\Models\ApprovedLeave;
use Modules\Leave\Services\ApprovedLeaveService;

class SaveApprovedLeaveAction
{
    public function __construct(private readonly ApprovedLeaveService $leaveService)
    {
    }

    /**
     * Persist one approved leave record used by attendance processing.
     */
    public function execute(ApprovedLeaveData $data): ApprovedLeave
    {
        return $this->leaveService->save($data);
    }
}
