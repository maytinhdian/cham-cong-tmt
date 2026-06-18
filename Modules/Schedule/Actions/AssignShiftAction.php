<?php

namespace Modules\Schedule\Actions;

use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Schedule\Services\EmployeeScheduleService;

class AssignShiftAction
{
    public function __construct(private readonly EmployeeScheduleService $scheduleService)
    {
    }

    public function execute(EmployeeScheduleData $data): EmployeeSchedule
    {
        return $this->scheduleService->assign($data);
    }
}
