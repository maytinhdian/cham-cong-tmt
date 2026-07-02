<?php

namespace App\Http\Livewire\Pages\Employees;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Core\Services\ActivityLogger;
use Modules\Org\Actions\CreateDepartmentAction;
use Modules\Org\DTOs\DepartmentData;
use Modules\Org\Models\Department as DepartmentModel;
use Modules\Org\Services\DepartmentService;
use Modules\User\Models\Employee;

class Department extends Component
{
    use AuthorizesRequests;

    public ?int $selectedDepartmentId = null;

    public ?int $editingDepartmentId = null;

    public int|string|null $parentId = null;

    public string $code = '';

    public string $name = '';

    public ?string $managerName = null;

    public ?string $phone = null;

    public ?string $email = null;

    public int|string $sortOrder = 0;

    public string $status = 'active';

    public ?string $description = null;

    /**
     * Select the first available department when opening the management page.
     */
    public function mount(): void
    {
        $this->selectedDepartmentId = DepartmentModel::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->value('id');
    }

    /**
     * Choose the department used by the assignment panels.
     */
    public function selectDepartment(int $departmentId): void
    {
        $this->selectedDepartmentId = $departmentId;
    }

    /**
     * Save a new department or update the department being edited.
     */
    public function saveDepartment(): void
    {
        $this->authorize('employees.manage');

        $validated = $this->validateDepartment();
        $data = $this->makeDepartmentData($validated);

        if ($this->editingDepartmentId) {
            $department = DepartmentModel::query()->findOrFail($this->editingDepartmentId);
            app(DepartmentService::class)->update($department, $data);

            app(ActivityLogger::class)->logForCurrentRequest(
                'organization',
                'department.updated',
                $department,
                'Department was updated from the department management page.'
            );

            session()->flash('success', 'Đã cập nhật phòng ban.');
        } else {
            $department = app(CreateDepartmentAction::class)->execute($data);

            app(ActivityLogger::class)->logForCurrentRequest(
                'organization',
                'department.created',
                $department,
                'Department was created from the department management page.'
            );

            session()->flash('success', 'Đã tạo phòng ban mới.');
        }

        $this->selectedDepartmentId = $department->id;
        $this->resetDepartmentForm();
    }

    /**
     * Load a department into the form for quick editing.
     */
    public function editDepartment(int $departmentId): void
    {
        $this->authorize('employees.manage');

        $department = DepartmentModel::query()->findOrFail($departmentId);

        $this->editingDepartmentId = $department->id;
        $this->parentId = $department->parent_id;
        $this->code = $department->code;
        $this->name = $department->name;
        $this->managerName = $department->manager_name;
        $this->phone = $department->phone;
        $this->email = $department->email;
        $this->sortOrder = $department->sort_order;
        $this->status = $department->status;
        $this->description = $department->description;
        $this->selectedDepartmentId = $department->id;
    }

    /**
     * Delete an empty department after confirming it has no employees or child departments.
     */
    public function deleteDepartment(int $departmentId): void
    {
        $this->authorize('employees.manage');

        $department = DepartmentModel::query()
            ->withCount(['employees', 'children'])
            ->findOrFail($departmentId);

        if ($department->employees_count > 0) {
            session()->flash('error', 'Không thể xóa phòng ban đang có nhân viên.');

            return;
        }

        if ($department->children_count > 0) {
            session()->flash('error', 'Không thể xóa phòng ban đang có phòng ban con.');

            return;
        }

        $department->delete();

        app(ActivityLogger::class)->logForCurrentRequest(
            'organization',
            'department.deleted',
            $department,
            'Department was deleted from the department management page.'
        );

        if ((int) $this->selectedDepartmentId === $departmentId) {
            $this->selectedDepartmentId = DepartmentModel::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->value('id');
        }

        if ((int) $this->editingDepartmentId === $departmentId) {
            $this->resetDepartmentForm();
        }

        session()->flash('success', 'Đã xóa phòng ban.');
    }

    /**
     * Clear department form fields so the next save creates a new department.
     */
    public function resetDepartmentForm(): void
    {
        $this->reset([
            'editingDepartmentId',
            'parentId',
            'code',
            'name',
            'managerName',
            'phone',
            'email',
            'description',
        ]);

        $this->sortOrder = 0;
        $this->status = 'active';
        $this->resetValidation();
    }

    /**
     * Assign an employee to the currently selected department.
     */
    public function assignEmployee(int $employeeId): void
    {
        $this->authorize('employees.manage');

        if (! $this->selectedDepartmentId) {
            return;
        }

        Employee::query()
            ->whereKey($employeeId)
            ->update(['department_id' => $this->selectedDepartmentId]);
    }

    /**
     * Remove an employee from their current department assignment.
     */
    public function removeEmployee(int $employeeId): void
    {
        $this->authorize('employees.manage');

        Employee::query()
            ->whereKey($employeeId)
            ->update(['department_id' => null]);
    }

    /**
     * Render department management with assignment lists and the edit form.
     */
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

    /**
     * Validate department create and update form input.
     */
    private function validateDepartment(): array
    {
        return $this->validate([
            'parentId' => [
                'nullable',
                'integer',
                Rule::exists('departments', 'id'),
                Rule::notIn(array_filter([$this->editingDepartmentId])),
            ],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('departments', 'code')->ignore($this->editingDepartmentId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'managerName' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:999999'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'code.required' => 'Vui lòng nhập mã phòng ban.',
            'code.unique' => 'Mã phòng ban này đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên phòng ban.',
            'email.email' => 'Email phòng ban chưa đúng định dạng.',
            'parentId.not_in' => 'Phòng ban cha không được trùng với phòng ban đang sửa.',
        ]);
    }

    /**
     * Build department DTO from validated Livewire form data.
     */
    private function makeDepartmentData(array $validated): DepartmentData
    {
        return new DepartmentData(
            parentId: $validated['parentId'] ? (int) $validated['parentId'] : null,
            code: $validated['code'],
            name: $validated['name'],
            managerName: $validated['managerName'] ?: null,
            phone: $validated['phone'] ?: null,
            email: $validated['email'] ?: null,
            sortOrder: (int) $validated['sortOrder'],
            status: $validated['status'],
            description: $validated['description'] ?: null,
        );
    }
}
