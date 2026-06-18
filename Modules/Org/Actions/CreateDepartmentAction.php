<?php

namespace Modules\Org\Actions;

use Modules\Org\DTOs\DepartmentData;
use Modules\Org\Models\Department;
use Modules\Org\Services\DepartmentService;

class CreateDepartmentAction
{
    public function __construct(private readonly DepartmentService $departmentService)
    {
    }

    public function execute(DepartmentData $data): Department
    {
        return $this->departmentService->create($data);
    }
}
