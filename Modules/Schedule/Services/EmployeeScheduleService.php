<?php

namespace Modules\Schedule\Services;

use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;

class EmployeeScheduleService
{
    public function assign(EmployeeScheduleData $data): EmployeeSchedule
    {
        return EmployeeSchedule::query()->updateOrCreate(
            [
                'employee_id' => $data->employeeId,
                'work_date' => $data->workDate,
            ],
            $data->toArray()
        );
    }
}
