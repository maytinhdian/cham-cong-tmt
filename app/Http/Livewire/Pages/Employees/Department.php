<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;
use Modules\Org\Models\Department as DepartmentModel;
use Modules\User\Models\Employee;

class Department extends Component
{
    public ?int $selectedDepartmentId = null;

    public function mount(): void
    {
        $this->selectedDepartmentId = DepartmentModel::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->value('id');
    }

    public function selectDepartment(int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
    }

    public function assignEmployee(int $employeeId): void
    {
        if (! $this->selectedDepartmentId) {
            return;
        }

        Employee::query()
            ->whereKey($employeeId)
            ->update(['department_id' => $this->selectedDepartmentId]);
    }

    public function removeEmployee(int $employeeId): void
    {
        Employee::query()
            ->whereKey($employeeId)
            ->update(['department_id' => null]);
    }

    public function render()
    {
        $departments = DepartmentModel::query()
            ->withCount('employees')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if (! $this->selectedDepartmentId && $departments->isNotEmpty()) {
            $this->selectedDepartmentId = $departments->first()->id;
        }

        $selectedDepartment = $departments->firstWhere('id', $this->selectedDepartmentId);

        $departmentEmployees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->selectedDepartmentId, fn ($query) => $query->where('department_id', $this->selectedDepartmentId))
            ->orderBy('employee_code')
            ->get();

        $availableEmployees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->selectedDepartmentId, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->whereNull('department_id')
                        ->orWhere('department_id', '!=', $this->selectedDepartmentId);
                });
            })
            ->orderBy('employee_code')
            ->get();

        return view('livewire.pages.employees.department', [
            'availableEmployees' => $availableEmployees,
            'departmentEmployees' => $departmentEmployees,
            'departments' => $departments,
            'selectedDepartment' => $selectedDepartment,
        ]);
    }
}
