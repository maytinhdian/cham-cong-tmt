<?php

namespace Modules\Org\Services;

use Modules\Org\DTOs\DepartmentData;
use Modules\Org\Models\Department;

class DepartmentService
{
    /**
     * Persist a new department used for employee assignment and reporting.
     */
    public function create(DepartmentData $data): Department
    {
        return Department::query()->create($data->toArray());
    }

    /**
     * Update department identity and contact details used by HR workflows.
     */
    public function update(Department $department, DepartmentData $data): Department
    {
        $department->update($data->toArray());

        return $department->refresh();
    }
}
