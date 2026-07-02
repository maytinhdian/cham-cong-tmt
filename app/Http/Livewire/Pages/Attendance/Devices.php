<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Device\Actions\CreateAttendanceDeviceAction;
use Modules\Device\Actions\UpdateAttendanceDeviceAction;
use Modules\Device\DTOs\AttendanceDeviceData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Services\AttendanceDeviceCommandService;
use Modules\Device\Services\AttendanceDeviceService;
use Modules\Core\Services\ActivityLogger;

class Devices extends Component
{
    use AuthorizesRequests;

    public $editingDeviceId = null;

    public string $code = '';

    public string $name = '';

    public string $deviceType = 'zkteco';

    public ?string $ipAddress = null;

    public int|string $port = 4370;

    public ?string $location = null;

    public string $connectionStatus = 'unknown';

    public string $syncStatus = 'idle';

    public ?string $note = null;

    public string $statusFilter = '';

    /**
     * Persist a new device or update the selected device from the form panel.
     */
    public function saveDevice(): void
    {
        $this->authorize('attendance.devices.manage');

        $validated = $this->validateDevice();

        $data = $this->makeDeviceData($validated);

        if ($this->editingDeviceId) {
            $device = AttendanceDevice::query()->findOrFail($this->editingDeviceId);
            app(UpdateAttendanceDeviceAction::class)->execute($device, $data);
            app(ActivityLogger::class)->logForCurrentRequest('device', 'device.updated', $device, 'Attendance device was updated.');
            session()->flash('success', 'Đã cập nhật thiết bị chấm công.');
        } else {
            $device = app(CreateAttendanceDeviceAction::class)->execute($data);
            app(ActivityLogger::class)->logForCurrentRequest('device', 'device.created', $device, 'Attendance device was created.');
            session()->flash('success', 'Đã thêm thiết bị chấm công.');
        }

        $this->resetForm();
    }

    /**
     * Load an existing device into the side form for quick editing.
     */
    public function editDevice(int $deviceId): void
    {
        $this->authorize('attendance.devices.manage');

        $device = AttendanceDevice::query()->findOrFail($deviceId);

        $this->editingDeviceId = $device->id;
        $this->code = $device->code;
        $this->name = $device->name;
        $this->deviceType = $device->device_type;
        $this->ipAddress = $device->ip_address;
        $this->port = $device->port;
        $this->location = $device->location;
        $this->connectionStatus = $device->connection_status;
        $this->syncStatus = $device->sync_status;
        $this->note = $device->note;
    }

    /**
     * Soft delete a device from the active attendance device registry.
     */
    public function deleteDevice(int $deviceId): void
    {
        $this->authorize('attendance.devices.manage');

        $device = AttendanceDevice::query()->findOrFail($deviceId);
        $device->delete();

        app(ActivityLogger::class)->logForCurrentRequest('device', 'device.deleted', $device, 'Attendance device was deleted.');

        if ((int) $this->editingDeviceId === $deviceId) {
            $this->resetForm();
        }

        session()->flash('success', 'Đã xóa thiết bị chấm công.');
    }

    /**
     * Check whether a PUSH device has contacted the server recently.
     */
    public function checkConnection(int $deviceId): void
    {
        $this->authorize('attendance.devices.manage');

        $device = AttendanceDevice::query()->findOrFail($deviceId);
        $online = $device->last_connected_at?->greaterThanOrEqualTo(now()->subMinutes(15)) ?? false;

        app(AttendanceDeviceService::class)->markConnectionChecked($device, $online);

        app(ActivityLogger::class)->logForCurrentRequest(
            'device',
            'device.connection_checked',
            $device,
            'Attendance device connection was checked.',
            null,
            ['connection_status' => $online ? 'online' : 'offline']
        );

        session()->flash(
            'success',
            $online
                ? 'Đã kiểm tra kết nối: thiết bị vừa gọi server qua PUSH.'
                : 'Chưa thấy thiết bị gọi server trong 15 phút gần đây. Vui lòng kiểm tra cấu hình ADMS/PUSH.'
        );
    }

    /**
     * Queue a PUSH command so the device uploads new logs on its next poll.
     */
    public function syncDevice(int $deviceId): void
    {
        $this->authorize('attendance.devices.manage');

        $device = AttendanceDevice::query()->findOrFail($deviceId);

        app(AttendanceDeviceCommandService::class)->queueLogSync($device);

        app(ActivityLogger::class)->logForCurrentRequest('device', 'device.log_sync_queued', $device, 'Attendance device log sync command was queued.');

        session()->flash('success', 'Đã gửi yêu cầu đồng bộ. Thiết bị sẽ đẩy log lên ở lần kết nối tiếp theo.');
    }

    /**
     * Clear the editing form so the next submit creates a new device.
     */
    public function resetForm(): void
    {
        $this->reset([
            'editingDeviceId',
            'code',
            'name',
            'ipAddress',
            'location',
            'note',
        ]);

        $this->deviceType = 'zkteco';
        $this->port = 4370;
        $this->connectionStatus = 'unknown';
        $this->syncStatus = 'idle';
        $this->resetValidation();
    }

    /**
     * Render the device management screen with filtered device statistics.
     */
    public function render()
    {
        $recentlyConnectedAfter = now()->subMinutes(15);

        $devices = AttendanceDevice::query()
            ->when(
                $this->statusFilter === 'online',
                fn ($query) => $query->where('last_connected_at', '>=', $recentlyConnectedAfter)
            )
            ->when(
                $this->statusFilter === 'offline',
                fn ($query) => $query->where(function ($query) use ($recentlyConnectedAfter) {
                    $query->whereNull('last_connected_at')
                        ->orWhere('last_connected_at', '<', $recentlyConnectedAfter);
                })
            )
            ->when(
                $this->statusFilter === 'unknown',
                fn ($query) => $query->where('connection_status', 'unknown')->whereNull('last_connected_at')
            )
            ->orderBy('code')
            ->get();

        return view('livewire.pages.attendance.devices', [
            'devices' => $devices,
            'onlineCount' => $devices->filter(fn ($device) => $device->last_connected_at?->greaterThanOrEqualTo($recentlyConnectedAfter))->count(),
            'offlineCount' => $devices->filter(fn ($device) => ! $device->last_connected_at || $device->last_connected_at->lessThan($recentlyConnectedAfter))->count(),
            'latestSyncedDevice' => $devices->whereNotNull('last_synced_at')->sortByDesc('last_synced_at')->first(),
            'recentlyConnectedAfter' => $recentlyConnectedAfter,
        ]);
    }

    /**
     * Validate device form data for create and update operations.
     */
    private function validateDevice(): array
    {
        return $this->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('attendance_devices', 'code')->ignore($this->editingDeviceId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'deviceType' => ['required', 'string', 'max:80'],
            'ipAddress' => ['nullable', 'ip'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'location' => ['nullable', 'string', 'max:255'],
            'connectionStatus' => ['required', 'string', 'max:40'],
            'syncStatus' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'code.required' => 'Vui lòng nhập mã thiết bị.',
            'code.unique' => 'Mã thiết bị này đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên thiết bị.',
            'ipAddress.ip' => 'IP thiết bị chưa đúng định dạng.',
        ]);
    }

    /**
     * Build the module DTO used by device service actions.
     */
    private function makeDeviceData(array $validated): AttendanceDeviceData
    {
        return new AttendanceDeviceData(
            code: $validated['code'],
            name: $validated['name'],
            deviceType: $validated['deviceType'],
            ipAddress: $validated['ipAddress'] ?: null,
            port: (int) $validated['port'],
            location: $validated['location'] ?: null,
            connectionStatus: $validated['connectionStatus'],
            syncStatus: $validated['syncStatus'],
            note: $validated['note'] ?: null,
        );
    }
}
