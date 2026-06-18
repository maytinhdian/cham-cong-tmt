<?php

namespace Modules\Attendance\Actions;

use Modules\Attendance\DTOs\RawAttendanceLogData;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Attendance\Services\RawAttendanceLogService;

class SaveRawAttendanceLogAction
{
    public function __construct(private readonly RawAttendanceLogService $rawLogService)
    {
    }

    /**
     * Save one raw attendance punch from a manual entry or device sync.
     */
    public function execute(RawAttendanceLogData $data): RawAttendanceLog
    {
        return $this->rawLogService->save($data);
    }
}
