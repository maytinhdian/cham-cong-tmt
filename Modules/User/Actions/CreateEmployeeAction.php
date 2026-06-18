<?php

namespace Modules\User\Actions;

use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;
use Modules\User\Services\EmployeeService;

class CreateEmployeeAction
{
    public function __construct(private readonly EmployeeService $employeeService)
    {
    }

    public function execute(EmployeeData $data): Employee
    {
        return $this->employeeService->create($data);
    }
}
