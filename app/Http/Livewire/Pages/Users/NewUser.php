<?php

namespace App\Http\Livewire\Pages\Users;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\Shift\Models\Shift;
use Modules\Device\DTOs\AttendanceDeviceUserMapData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceUserMap;
use Modules\Device\Services\AttendanceDeviceUserMapService;
use Modules\User\Actions\CreateEmployeeAction;
use Modules\User\DTOs\EmployeeData;
use Modules\User\Models\Employee;
use Modules\User\Services\EmployeeAccountService;

class NewUser extends Component
{
    use AuthorizesRequests;

    public string $formMode = 'wizard';

    public string $fullName = '';

    public string $employeeCode = '';

    public ?string $attendanceCode = null;

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

    public bool $createLoginAccount = false;

    public ?string $accountPassword = null;

    public $accountRoleId = null;

    /**
     * Load default organization, shift, and account role values for the new employee form.
     */
    public function mount(EmployeeAccountService $employeeAccountService): void
    {
        $this->departmentId = Department::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->positionId = Position::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->hireDate = now()->toDateString();
        $this->accountRoleId = $employeeAccountService->memberRoleId();
    }

    /**
     * Refresh account fields immediately when HR toggles login provisioning.
     */
    public function updatedCreateLoginAccount(bool $enabled): void
    {
        if (! $enabled) {
            $this->accountPassword = null;
        }

        $this->resetValidation([
            'accountPassword',
            'accountRoleId',
        ]);
    }

    /**
     * Create a new employee profile and optionally provision its login account.
     */
    public function saveEmployee(): void
    {
        $employeeAccountService = app(EmployeeAccountService::class);

        $rules = [
            'fullName' => ['required', 'string', 'max:255'],
            'employeeCode' => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'attendanceCode' => ['nullable', 'integer', 'min:1'],
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
        ];

        if ($this->createLoginAccount) {
            $this->authorize('authorization.manage');

            $rules['accountPassword'] = ['required', 'string', 'min:7'];
            $rules['accountRoleId'] = ['required', 'exists:roles,id'];
        }

        $validated = $this->validate($rules, [
            'fullName.required' => 'Vui lòng nhập họ và tên nhân viên.',
            'employeeCode.required' => 'Vui lòng nhập mã nhân viên.',
            'employeeCode.unique' => 'Mã nhân viên này đã tồn tại.',
            'attendanceCode.integer' => 'Mã chấm công chỉ được nhập số nguyên.',
            'attendanceCode.min' => 'Mã chấm công phải lớn hơn 0.',
            'email.email' => 'Email chưa đúng định dạng.',
            'email.unique' => 'Email này đã được dùng cho nhân viên khác.',
            'accountPassword.required' => 'Vui lòng nhập mật khẩu cấp cho nhân viên.',
            'accountPassword.min' => 'Mật khẩu cần ít nhất 7 ký tự.',
            'accountRoleId.required' => 'Vui lòng chọn vai trò đăng nhập.',
        ]);

        $attendanceCode = $this->normalizedAttendanceCode($validated['attendanceCode'] ?? null);

        if ($attendanceCode && AttendanceDeviceUserMap::query()->where('device_user_code', $attendanceCode)->exists()) {
            $this->addError('attendanceCode', 'Mã chấm công này đã được liên kết với nhân viên khác.');

            return;
        }

        $employee = app(CreateEmployeeAction::class)->execute(new EmployeeData(
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

        if ($this->createLoginAccount) {
            $employeeAccountService->provision(
                $employee,
                $validated['accountPassword'],
                $this->nullableInt($validated['accountRoleId'])
            );
        }

        $mappingCount = $attendanceCode
            ? $this->saveAttendanceCodeMappings($employee, $attendanceCode, app(AttendanceDeviceUserMapService::class))
            : 0;

        $successMessage = $this->createLoginAccount
            ? 'Đã tạo nhân viên mới và cấp tài khoản đăng nhập'
            : 'Đã tạo nhân viên mới';

        $successMessage .= $mappingCount > 0
            ? ' và liên kết mã chấm công trên ' . $mappingCount . ' thiết bị.'
            : ' thành công.';

        if ($attendanceCode && $mappingCount === 0) {
            $successMessage .= ' Chưa có máy chấm công nên mã chấm công chưa được tạo mapping.';
        }

        session()->flash('success', $successMessage);

        $this->resetForm($employeeAccountService);
    }

    /**
     * Reset the form to defaults after successfully creating an employee.
     */
    private function resetForm(EmployeeAccountService $employeeAccountService): void
    {
        $this->reset([
            'fullName',
            'employeeCode',
            'attendanceCode',
            'email',
            'phone',
            'gender',
            'dateOfBirth',
            'note',
            'createLoginAccount',
            'accountPassword',
        ]);

        $this->departmentId = Department::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->positionId = Position::query()->orderBy('sort_order')->orderBy('name')->value('id');
        $this->shiftId = Shift::query()->orderBy('start_time')->orderBy('name')->value('id');
        $this->hireDate = now()->toDateString();
        $this->workStatus = 'active';
        $this->accountRoleId = $employeeAccountService->memberRoleId();
    }

    /**
     * Append the initial shift note to the employee note stored on the profile.
     */
    private function buildEmployeeNote(?string $note): ?string
    {
        $shift = $this->shiftId ? Shift::query()->find($this->shiftId) : null;

        if (! $shift) {
            return $note;
        }

        return trim(($note ? $note . PHP_EOL : '') . 'Ca làm ban đầu: ' . $shift->name);
    }

    /**
     * Save the same attendance code for every active device so PUSH logs can map automatically.
     */
    private function saveAttendanceCodeMappings(Employee $employee, string $attendanceCode, AttendanceDeviceUserMapService $mappingService): int
    {
        $count = 0;

        AttendanceDevice::query()
            ->orderBy('name')
            ->get()
            ->each(function (AttendanceDevice $device) use ($employee, $attendanceCode, $mappingService, &$count): void {
                $mapping = $mappingService->save(new AttendanceDeviceUserMapData(
                    attendanceDeviceId: $device->id,
                    employeeId: $employee->id,
                    deviceUserCode: $attendanceCode,
                    deviceUserName: $employee->full_name,
                    status: 'active',
                    note: 'Tạo tự động khi thêm nhân viên.',
                ));

                $mappingService->applyToRawLogs($mapping);
                $count++;
            });

        return $count;
    }

    /**
     * Normalize an optional attendance code into the integer string stored by devices.
     */
    private function normalizedAttendanceCode(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (string) ((int) $value);
    }

    /**
     * Convert optional select values into nullable integer identifiers.
     */
    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }

    /**
     * Render the employee creation form with organization, shift, and role choices.
     */
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
            'roles' => Role::query()
                ->orderBy('name')
                ->get(),
            'shifts' => Shift::query()
                ->orderBy('start_time')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
