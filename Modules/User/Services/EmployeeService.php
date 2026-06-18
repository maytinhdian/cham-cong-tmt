<?php

namespace Modules\User\Services;

use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;

class EmployeeService
{
    public function create(EmployeeData $data): Employee
    {
        return Employee::query()->create($data->toArray());
    }

    public function update(Employee $employee, EmployeeData $data): Employee
    {
        $employee->update($data->toArray());

        return $employee->refresh();
    }
}
