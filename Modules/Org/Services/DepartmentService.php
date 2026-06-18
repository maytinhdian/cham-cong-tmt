<?php

namespace Modules\Org\Services;

use Modules\Org\DTOs\DepartmentData;
use Modules\Org\Models\Department;

class DepartmentService
{
    public function create(DepartmentData $data): Department
    {
        return Department::query()->create($data->toArray());
    }

    public function update(Department $department, DepartmentData $data): Department
    {
        $department->update($data->toArray());

        return $department->refresh();
    }
}
