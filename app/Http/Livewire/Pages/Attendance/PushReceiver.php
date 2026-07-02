<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Core\Services\ActivityLogger;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceCommand;
use Modules\Device\Services\AttendanceDeviceCommandService;

class PushReceiver extends Component
{
    use AuthorizesRequests;

    public string $deviceFilter = '';

    /**
     * Queue a PUSH log request for one device from the receiver monitor.
     */
    public function queueLogSync(int $deviceId): void
    {
        $this->authorize('attendance.devices.manage');

        $device = AttendanceDevice::query()->findOrFail($deviceId);
        app(AttendanceDeviceCommandService::class)->queueLogSync($device);

        app(ActivityLogger::class)->logForCurrentRequest(
            'device',
            'device.receiver_log_sync_queued',
            $device,
            'Attendance device log sync command was queued from the PUSH receiver page.'
        );

        session()->flash('success', 'Đã xếp lệnh LOG. Máy sẽ nhận lệnh ở lần gọi /iclock/getrequest tiếp theo.');
    }

    /**
     * Render the PUSH receiver monitor using real device, log, and command data.
     */
    public function render()
    {
        $recentlyConnectedAfter = now()->subMinutes(15);

        $devices = AttendanceDevice::query()
            ->withCount([
                'rawLogs as received_today_count' => fn ($query) => $query->whereDate('created_at', now()->toDateString()),
                'commands as pending_commands_count' => fn ($query) => $query->where('status', 'pending'),
            ])
            ->orderBy('code')
            ->get();
        $deviceRows = $this->deviceFilter ? $devices->where('id', (int) $this->deviceFilter) : $devices;

        $recentLogs = RawAttendanceLog::query()
            ->with(['device', 'employee'])
            ->when($this->deviceFilter, fn ($query) => $query->where('attendance_device_id', $this->deviceFilter))
            ->where('source', 'zkteco_push')
            ->orderByDesc('created_at')
            ->limit(80)
            ->get();

        $recentCommands = AttendanceDeviceCommand::query()
            ->with('device')
            ->when($this->deviceFilter, fn ($query) => $query->where('attendance_device_id', $this->deviceFilter))
            ->latest()
            ->limit(20)
            ->get();

        return view('livewire.pages.attendance.push-receiver', [
            'devices' => $devices,
            'deviceRows' => $deviceRows,
            'recentLogs' => $recentLogs,
            'recentCommands' => $recentCommands,
            'recentlyConnectedAfter' => $recentlyConnectedAfter,
            'onlineCount' => $devices->filter(fn ($device) => $device->last_connected_at?->greaterThanOrEqualTo($recentlyConnectedAfter))->count(),
            'receivedTodayCount' => RawAttendanceLog::query()->where('source', 'zkteco_push')->whereDate('created_at', now()->toDateString())->count(),
            'pendingCommandCount' => AttendanceDeviceCommand::query()->where('status', 'pending')->count(),
            'cdataEndpoint' => url('/iclock/cdata'),
            'getRequestEndpoint' => url('/iclock/getrequest'),
            'deviceCmdEndpoint' => url('/iclock/devicecmd'),
        ]);
    }
}
