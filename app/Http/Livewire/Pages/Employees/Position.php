<?php

namespace App\Http\Livewire\Pages\Employees;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Core\Services\ActivityLogger;
use Modules\Org\Actions\CreatePositionAction;
use Modules\Org\DTOs\PositionData;
use Modules\Org\Models\Department as DepartmentModel;
use Modules\Org\Models\Position as PositionModel;
use Modules\Org\Services\PositionService;
use Modules\User\Models\Employee;

class Position extends Component
{
    use AuthorizesRequests;

    public ?int $selectedDepartmentId = null;

    public ?int $selectedPositionId = null;

    public ?int $editingPositionId = null;

    public string $code = '';

    public string $name = '';

    public ?string $level = null;

    public int|string $sortOrder = 0;

    public string $status = 'active';

    public ?string $description = null;

    /**
     * Select default filters when opening the position management page.
     */
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

    /**
     * Choose the department used to filter assignment lists.
     */
    public function selectDepartment(int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
    }

    /**
     * Choose the position used by the assignment panels.
     */
    public function selectPosition(int $positionId): void
    {
        $this->selectedPositionId = $positionId;
    }

    /**
     * Save a new position or update the position being edited.
     */
    public function savePosition(): void
    {
        $this->authorize('employees.manage');

        $validated = $this->validatePosition();
        $data = $this->makePositionData($validated);

        if ($this->editingPositionId) {
            $position = PositionModel::query()->findOrFail($this->editingPositionId);
            app(PositionService::class)->update($position, $data);

            app(ActivityLogger::class)->logForCurrentRequest(
                'organization',
                'position.updated',
                $position,
                'Position was updated from the position management page.'
            );

            session()->flash('success', 'Đã cập nhật chức vụ.');
        } else {
            $position = app(CreatePositionAction::class)->execute($data);

            app(ActivityLogger::class)->logForCurrentRequest(
                'organization',
                'position.created',
                $position,
                'Position was created from the position management page.'
            );

            session()->flash('success', 'Đã tạo chức vụ mới.');
        }

        $this->selectedPositionId = $position->id;
        $this->resetPositionForm();
    }

    /**
     * Load a position into the form for quick editing.
     */
    public function editPosition(int $positionId): void
    {
        $this->authorize('employees.manage');

        $position = PositionModel::query()->findOrFail($positionId);

        $this->editingPositionId = $position->id;
        $this->code = $position->code;
        $this->name = $position->name;
        $this->level = $position->level;
        $this->sortOrder = $position->sort_order;
        $this->status = $position->status;
        $this->description = $position->description;
        $this->selectedPositionId = $position->id;
    }

    /**
     * Delete an unused position after confirming no employee is assigned to it.
     */
    public function deletePosition(int $positionId): void
    {
        $this->authorize('employees.manage');

        $position = PositionModel::query()
            ->withCount('employees')
            ->findOrFail($positionId);

        if ($position->employees_count > 0) {
            session()->flash('error', 'Không thể xóa chức vụ đang có nhân viên.');

            return;
        }

        $position->delete();

        app(ActivityLogger::class)->logForCurrentRequest(
            'organization',
            'position.deleted',
            $position,
            'Position was deleted from the position management page.'
        );

        if ((int) $this->selectedPositionId === $positionId) {
            $this->selectedPositionId = PositionModel::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->value('id');
        }

        if ((int) $this->editingPositionId === $positionId) {
            $this->resetPositionForm();
        }

        session()->flash('success', 'Đã xóa chức vụ.');
    }

    /**
     * Clear position form fields so the next save creates a new position.
     */
    public function resetPositionForm(): void
    {
        $this->reset([
            'editingPositionId',
            'code',
            'name',
            'level',
            'description',
        ]);

        $this->sortOrder = 0;
        $this->status = 'active';
        $this->resetValidation();
    }

    /**
     * Assign an employee to the currently selected position.
     */
    public function assignPosition(int $employeeId): void
    {
        $this->authorize('employees.manage');

        if (! $this->selectedPositionId) {
            return;
        }

        Employee::query()
            ->whereKey($employeeId)
            ->update(['position_id' => $this->selectedPositionId]);
    }

    /**
     * Remove an employee from their current position assignment.
     */
    public function removePosition(int $employeeId): void
    {
        $this->authorize('employees.manage');

        Employee::query()
            ->whereKey($employeeId)
            ->update(['position_id' => null]);
    }

    /**
     * Render position management with filters, assignment lists, and edit form.
     */
    public function render()
    {
        $departments = DepartmentModel::query()
            ->withCount('employees')
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

    /**
     * Validate position create and update form input.
     */
    private function validatePosition(): array
    {
        return $this->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('positions', 'code')->ignore($this->editingPositionId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:80'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:999999'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'code.required' => 'Vui lòng nhập mã chức vụ.',
            'code.unique' => 'Mã chức vụ này đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên chức vụ.',
        ]);
    }

    /**
     * Build position DTO from validated Livewire form data.
     */
    private function makePositionData(array $validated): PositionData
    {
        return new PositionData(
            code: $validated['code'],
            name: $validated['name'],
            level: $validated['level'] ?: null,
            sortOrder: (int) $validated['sortOrder'],
            status: $validated['status'],
            description: $validated['description'] ?: null,
        );
    }
}
