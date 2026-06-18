<?php

namespace App\Http\Livewire\Pages\Employees;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;
use Modules\User\Services\EmployeeService;

class Index extends Component
{
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

    public function editEmployee(int $employeeId): void
    {
        $employee = Employee::query()->findOrFail($employeeId);

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
    }

    public function updateEmployee(): void
    {
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

    public function deleteEmployee(int $employeeId): void
    {
        Employee::query()->findOrFail($employeeId)->delete();

        if ((int) $this->editingEmployeeId === $employeeId) {
            $this->cancelEdit();
        }

        session()->flash('success', 'Đã xóa nhân viên khỏi danh sách.');
    }

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
        ]);

        $this->workStatus = 'active';
        $this->resetValidation();
    }

    public function render()
    {
        $employees = Employee::query()
            ->with(['department', 'position'])
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
        ]);
    }

    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
