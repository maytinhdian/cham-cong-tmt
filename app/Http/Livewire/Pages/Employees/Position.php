<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;
use Modules\Org\Models\Department as DepartmentModel;
use Modules\Org\Models\Position as PositionModel;
use Modules\User\Models\Employee;

class Position extends Component
{
    public ?int $selectedDepartmentId = null;

    public ?int $selectedPositionId = null;

    public function mount(): void
    {
        $this->selectedDepartmentId = DepartmentModel::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->value('id');

        $this->selectedPositionId = PositionModel::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->value('id');
    }

    public function selectDepartment(int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
    }

    public function selectPosition(int $positionId): void
    {
        $this->selectedPositionId = $positionId;
    }

    public function assignPosition(int $employeeId): void
    {
        if (! $this->selectedPositionId) {
            return;
        }

        Employee::query()
            ->whereKey($employeeId)
            ->update(['position_id' => $this->selectedPositionId]);
    }

    public function removePosition(int $employeeId): void
    {
        Employee::query()
            ->whereKey($employeeId)
            ->update(['position_id' => null]);
    }

    public function render()
    {
        $departments = DepartmentModel::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $positions = PositionModel::query()
            ->withCount('employees')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if (! $this->selectedDepartmentId && $departments->isNotEmpty()) {
            $this->selectedDepartmentId = $departments->first()->id;
        }

        if (! $this->selectedPositionId && $positions->isNotEmpty()) {
            $this->selectedPositionId = $positions->first()->id;
        }

        $selectedDepartment = $departments->firstWhere('id', $this->selectedDepartmentId);
        $selectedPosition = $positions->firstWhere('id', $this->selectedPositionId);

        $positionEmployees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->selectedPositionId, fn ($query) => $query->where('position_id', $this->selectedPositionId))
            ->when($this->selectedDepartmentId, fn ($query) => $query->where('department_id', $this->selectedDepartmentId))
            ->orderBy('employee_code')
            ->get();

        $availableEmployees = Employee::query()
            ->with(['department', 'position'])
            ->when($this->selectedDepartmentId, fn ($query) => $query->where('department_id', $this->selectedDepartmentId))
            ->when($this->selectedPositionId, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->whereNull('position_id')
                        ->orWhere('position_id', '!=', $this->selectedPositionId);
                });
            })
            ->orderBy('employee_code')
            ->get();

        $managementPositionCount = $positions
            ->filter(fn ($position) => in_array($position->level, ['Executive', 'Manager', 'Lead'], true))
            ->count();

        return view('livewire.pages.employees.position', [
            'availableEmployees' => $availableEmployees,
            'departmentEmployees' => $selectedDepartment
                ? Employee::query()->where('department_id', $selectedDepartment->id)->count()
                : 0,
            'departments' => $departments,
            'managementPositionCount' => $managementPositionCount,
            'popularPosition' => $positions->sortByDesc('employees_count')->first(),
            'positionEmployees' => $positionEmployees,
            'positions' => $positions,
            'selectedDepartment' => $selectedDepartment,
            'selectedPosition' => $selectedPosition,
        ]);
    }
}
