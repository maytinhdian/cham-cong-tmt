<?php

namespace Modules\Attendance\Actions;

use Modules\Attendance\Services\MonthlyTimesheetService;

class GenerateMonthlyTimesheetAction
{
    /**
     * Prepare the action with the monthly aggregation service.
     */
    public function __construct(private readonly MonthlyTimesheetService $monthlyTimesheetService)
    {
    }

    /**
     * Generate monthly timesheet rows for one period and optional department.
     */
    public function execute(string $periodMonth, ?int $departmentId = null): int
    {
        return $this->monthlyTimesheetService->generate($periodMonth, $departmentId);
    }
}
