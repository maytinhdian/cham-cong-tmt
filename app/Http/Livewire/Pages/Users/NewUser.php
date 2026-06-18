<?php

namespace App\Http\Livewire\Pages\Users;

use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\Shift\Models\Shift;
use Modules\User\Actions\CreateEmployeeAction;
use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;

class NewUser extends Component
{
    public string $formMode = 'wizard';

    public string $fullName = '';

    public string $employeeCode = '';

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $gender = null;

    public ?string $dateOfBirth = null;

    public $departmentId = null;

    public $positionId = null;

    public $shiftId = null;

    public ?string $hireDate = null;

    public string $workStatus = 'active';

    public ?string $note = null;

    public function mount(): void
    {
        $this->departmentId = Department::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->positionId = Position::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->hireDate = now()->toDateString();
    }

    public function saveEmployee(): void
    {
        $validated = $this->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'employeeCode' => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'email' => ['nullable', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'max:20'],
            'dateOfBirth' => ['nullable', 'date'],
            'departmentId' => ['nullable', 'exists:departments,id'],
            'positionId' => ['nullable', 'exists:positions,id'],
            'shiftId' => ['nullable', 'exists:shifts,id'],
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

        app(CreateEmployeeAction::class)->execute(new EmployeeData(
            userId: null,
            departmentId: $this->nullableInt($validated['departmentId']),
            positionId: $this->nullableInt($validated['positionId']),
            employeeCode: $validated['employeeCode'],
            fullName: $validated['fullName'],
            email: $validated['email'] ?: null,
            phone: $validated['phone'] ?: null,
            gender: $validated['gender'] ?: null,
            dateOfBirth: $validated['dateOfBirth'] ?: null,
            hireDate: $validated['hireDate'] ?: null,
            workStatus: $validated['workStatus'],
            note: $this->buildEmployeeNote($validated['note'] ?: null),
        ));

        session()->flash('success', 'Đã tạo nhân viên mới thành công.');

        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'fullName',
            'employeeCode',
            'email',
            'phone',
            'gender',
            'dateOfBirth',
            'note',
        ]);

        $this->departmentId = Department::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->positionId = Position::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->hireDate = now()->toDateString();
        $this->workStatus = 'active';
    }

    private function buildEmployeeNote(?string $note): ?string
    {
        $shift = $this->shiftId ? Shift::query()->find($this->shiftId) : null;

        if (! $shift) {
            return $note;
        }

        return trim(($note ? $note . PHP_EOL : '') . 'Ca làm ban đầu: ' . $shift->name);
    }

    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }

    public function render()
    {
        return view('livewire.pages.users.new-user', [
            'departments' => Department::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'employeeCount' => Employee::query()->count(),
            'positions' => Position::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'shifts' => Shift::query()
                ->orderBy('start_time')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
