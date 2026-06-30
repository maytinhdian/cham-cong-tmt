<?php

namespace App\Http\Livewire\Pages\Employees;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;
use Modules\User\Services\EmployeeAccountService;
use Modules\User\Services\EmployeeService;

class Index extends Component
{
    use AuthorizesRequests;

    public string $search = '';

    public $departmentFilter = '';

    public string $statusFilter = '';

    public $editingEmployeeId = null;

    public string $fullName = '';

    public string $employeeCode = '';

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $gender = null;

    public ?string $dateOfBirth = null;

    public $departmentId = null;

    public $positionId = null;

    public ?string $hireDate = null;

    public string $workStatus = 'active';

    public ?string $note = null;

    public ?string $accountPassword = null;

    public $accountRoleId = null;

    /**
     * Load one employee profile into the quick edit form.
     */
    public function editEmployee(int $employeeId): void
    {
        $this->authorize('employees.manage');

        $employee = Employee::query()->with('account')->findOrFail($employeeId);

        $this->editingEmployeeId = $employee->id;
        $this->fullName = $employee->full_name;
        $this->employeeCode = $employee->employee_code;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->gender = $employee->gender;
        $this->dateOfBirth = $employee->date_of_birth?->format('Y-m-d');
        $this->departmentId = $employee->department_id;
        $this->positionId = $employee->position_id;
        $this->hireDate = $employee->hire_date?->format('Y-m-d');
        $this->workStatus = $employee->work_status;
        $this->note = $employee->note;
        $this->accountPassword = null;
        $this->accountRoleId = $employee->account?->role_id ?: app(EmployeeAccountService::class)->memberRoleId();
    }

    /**
     * Update the selected employee's HR profile data.
     */
    public function updateEmployee(): void
    {
        $this->authorize('employees.manage');

        if (! $this->editingEmployeeId) {
            return;
        }

        $validated = $this->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'employeeCode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_code')->ignore($this->editingEmployeeId),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($this->editingEmployeeId),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'max:20'],
            'dateOfBirth' => ['nullable', 'date'],
            'departmentId' => ['nullable', 'exists:departments,id'],
            'positionId' => ['nullable', 'exists:positions,id'],
            'hireDate' => ['nullable', 'date'],
            'workStatus' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'fullName.required' => 'Vui lòng nhập họ và tên nhân viên.',
            'employeeCode.required' => 'Vui lòng nhập mã nhân viên.',
            'employeeCode.unique' => 'Mã nhân viên này đã tồn tại.',
            'email.email' => 'Email chưa đúng định dạng.',
            'email.unique' => 'Email này đã được dùng cho nhân viên khác.',
        ]);

        $employee = Employee::query()->findOrFail($this->editingEmployeeId);

        app(EmployeeService::class)->update($employee, new EmployeeData(
            userId: $employee->user_id,
            departmentId: $this->nullableInt($validated['departmentId']),
            positionId: $this->nullableInt($validated['positionId']),
            employeeCode: $validated['employeeCode'],
            fullName: $validated['fullName'],
            email: $validated['email'] ?: null,
            phone: $validated['phone'] ?: null,
            gender: $validated['gender'] ?: null,
            dateOfBirth: $validated['dateOfBirth'] ?: null,
            hireDate: $validated['hireDate'] ?: null,
            avatar: $employee->avatar,
            workStatus: $validated['workStatus'],
            note: $validated['note'] ?: null,
        ));

        session()->flash('success', 'Đã cập nhật nhân viên thành công.');

        $this->cancelEdit();
    }

    /**
     * Soft delete an employee from active HR management.
     */
    public function deleteEmployee(int $employeeId): void
    {
        $this->authorize('employees.manage');

        Employee::query()->findOrFail($employeeId)->delete();

        if ((int) $this->editingEmployeeId === $employeeId) {
            $this->cancelEdit();
        }

        session()->flash('success', 'Đã xóa nhân viên khỏi danh sách.');
    }

    /**
     * Create or update the login account linked to the selected employee.
     */
    public function provisionEmployeeAccount(EmployeeAccountService $employeeAccountService): void
    {
        $this->authorize('authorization.manage');

        if (! $this->editingEmployeeId) {
            return;
        }

        $validated = $this->validate([
            'accountPassword' => ['required', 'string', 'min:7'],
            'accountRoleId' => ['required', 'exists:roles,id'],
        ], [
            'accountPassword.required' => 'Vui lòng nhập mật khẩu cấp cho nhân viên.',
            'accountPassword.min' => 'Mật khẩu cần ít nhất 7 ký tự.',
            'accountRoleId.required' => 'Vui lòng chọn vai trò đăng nhập.',
        ]);

        $employee = Employee::query()->with('account')->findOrFail($this->editingEmployeeId);

        $employeeAccountService->provision(
            $employee,
            $validated['accountPassword'],
            $this->nullableInt($validated['accountRoleId'])
        );

        $this->accountPassword = null;

        session()->flash('success', 'Đã cấp/cập nhật tài khoản đăng nhập cho nhân viên.');
    }

    /**
     * Clear the employee edit form and account provisioning fields.
     */
    public function cancelEdit(): void
    {
        $this->reset([
            'editingEmployeeId',
            'fullName',
            'employeeCode',
            'email',
            'phone',
            'gender',
            'dateOfBirth',
            'departmentId',
            'positionId',
            'hireDate',
            'note',
            'accountPassword',
            'accountRoleId',
        ]);

        $this->workStatus = 'active';
        $this->resetValidation();
    }

    /**
     * Render the employee list, filters, edit form, and account role options.
     */
    public function render()
    {
        $employees = Employee::query()
            ->with(['account.role', 'department', 'position'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('employee_code', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->departmentFilter, fn ($query) => $query->where('department_id', $this->departmentFilter))
            ->when($this->statusFilter, fn ($query) => $query->where('work_status', $this->statusFilter))
            ->orderBy('employee_code')
            ->get();

        return view('livewire.pages.employees.index', [
            'employees' => $employees,
            'departments' => Department::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'positions' => Position::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Convert blank Livewire select values into nullable integer foreign keys.
     */
    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
