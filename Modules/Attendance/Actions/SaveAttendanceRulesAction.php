<?php

namespace Modules\Attendance\Actions;

use Modules\Attendance\Services\AttendanceRuleService;

class SaveAttendanceRulesAction
{
    public function __construct(private readonly AttendanceRuleService $attendanceRuleService)
    {
    }

    /**
     * Save the global attendance settings edited from the rules screen.
     */
    public function execute(array $rules, array $definitions): void
    {
        $this->attendanceRuleService->sync($rules, $definitions);
    }
}
