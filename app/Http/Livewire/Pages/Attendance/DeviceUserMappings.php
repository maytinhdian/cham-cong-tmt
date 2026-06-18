<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Device\Actions\SaveAttendanceDeviceUserMapAction;
use Modules\Device\DTOs\AttendanceDeviceUserMapData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceUserMap;
use Modules\Device\Services\AttendanceDeviceUserMapService;
use Modules\User\Models\Employee;

class DeviceUserMappings extends Component
{
    public $editingMappingId = null;

    public $attendanceDeviceId = null;

    public $employeeId = null;

    public string $deviceUserCode = '';

    public ?string $deviceUserName = null;

    public string $status = 'active';

    public ?string $note = null;

    public $deviceFilter = '';

    public string $statusFilter = '';

    /**
     * Prepare default values for the device-user mapping form.
     */
    public function mount(): void
    {
        $this->attendanceDeviceId = AttendanceDevice::query()->orderBy('code')->value('id');
        $this->employeeId = Employee::query()->orderBy('employee_code')->value('id');
    }

    /**
     * Save a mapping between a device user code and an internal employee.
     */
    public function saveMapping(): void
    {
        $validated = $this->validate([
            'attendanceDeviceId' => ['required', 'exists:attendance_devices,id'],
            'employeeId' => ['required', 'exists:employees,id'],
            'deviceUserCode' => ['required', 'string', 'max:100'],
            'deviceUserName' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'attendanceDeviceId.required' => 'Vui lòng chọn thiết bị.',
            'employeeId.required' => 'Vui lòng chọn nhân viên.',
            'deviceUserCode.required' => 'Vui lòng nhập mã người dùng trên máy.',
        ]);

        app(SaveAttendanceDeviceUserMapAction::class)->execute(new AttendanceDeviceUserMapData(
            attendanceDeviceId: (int) $validated['attendanceDeviceId'],
            employeeId: (int) $validated['employeeId'],
            deviceUserCode: $validated['deviceUserCode'],
            deviceUserName: $validated['deviceUserName'] ?: null,
            status: $validated['status'],
            note: $validated['note'] ?: null,
        ));

        session()->flash('success', 'Đã lưu mapping người dùng trên máy.');

        $this->resetForm();
    }

    /**
     * Load one mapping into the form for editing.
     */
    public function editMapping(int $mappingId): void
    {
        $mapping = AttendanceDeviceUserMap::query()->findOrFail($mappingId);

        $this->editingMappingId = $mapping->id;
        $this->attendanceDeviceId = $mapping->attendance_device_id;
        $this->employeeId = $mapping->employee_id;
        $this->deviceUserCode = $mapping->device_user_code;
        $this->deviceUserName = $mapping->device_user_name;
        $this->status = $mapping->status;
        $this->note = $mapping->note;
    }

    /**
     * Apply one mapping to existing raw logs that still lack employee mapping.
     */
    public function applyMapping(int $mappingId): void
    {
        $mapping = AttendanceDeviceUserMap::query()->findOrFail($mappingId);
        $updatedRows = app(AttendanceDeviceUserMapService::class)->applyToRawLogs($mapping);

        session()->flash('success', "Đã áp dụng mapping cho {$updatedRows} log thô.");
    }

    /**
     * Delete a device-user mapping from the active mapping list.
     */
    public function deleteMapping(int $mappingId): void
    {
        AttendanceDeviceUserMap::query()->findOrFail($mappingId)->delete();

        if ((int) $this->editingMappingId === $mappingId) {
            $this->resetForm();
        }

        session()->flash('success', 'Đã xóa mapping người dùng trên máy.');
    }

    /**
     * Reset the form so the next save creates a fresh mapping.
     */
    public function resetForm(): void
    {
        $this->reset([
            'editingMappingId',
            'deviceUserCode',
            'deviceUserName',
            'note',
        ]);

        $this->attendanceDeviceId = AttendanceDevice::query()->orderBy('code')->value('id');
        $this->employeeId = Employee::query()->orderBy('employee_code')->value('id');
        $this->status = 'active';
        $this->resetValidation();
    }

    /**
     * Render the mapping screen with device/status filters.
     */
    public function render()
    {
        $mappings = AttendanceDeviceUserMap::query()
            ->with(['device', 'employee.department'])
            ->when($this->deviceFilter, fn ($query) => $query->where('attendance_device_id', $this->deviceFilter))
            ->when($this->statusFilter, fn ($query) => $query->where('status', $this->statusFilter))
            ->orderByDesc('updated_at')
            ->get();

        return view('livewire.pages.attendance.device-user-mappings', [
            'devices' => AttendanceDevice::query()->orderBy('code')->get(),
            'employees' => Employee::query()->with('department')->orderBy('employee_code')->get(),
            'mappings' => $mappings,
        ]);
    }
}
