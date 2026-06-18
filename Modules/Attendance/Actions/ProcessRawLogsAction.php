<?php

namespace Modules\Attendance\Actions;

use Modules\Attendance\Services\AttendanceProcessingService;

class ProcessRawLogsAction
{
    /**
     * Prepare the action with the attendance processing service.
     */
    public function __construct(private readonly AttendanceProcessingService $processingService)
    {
    }

    /**
     * Process raw logs into daily attendance results for a date range.
     */
    public function execute(string $dateFrom, string $dateTo, ?int $employeeId = null): int
    {
        return $this->processingService->processDateRange($dateFrom, $dateTo, $employeeId);
    }
}
