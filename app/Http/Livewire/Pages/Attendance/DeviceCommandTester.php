<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Core\Services\ActivityLogger;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceCommand;
use Modules\Device\Services\AttendanceDeviceCommandService;

class DeviceCommandTester extends Component
{
    use AuthorizesRequests;

    private const COMMAND_TYPES = [
        'range_attlog',
        'log',
        'check',
        'reload_options',
        'set_option',
        'query_biodata',
        'delete_user',
        'delete_all_users',
        'delete_biodata_pin',
        'delete_biodata_type',
        'delete_biodata_no',
        'clear_biodata',
        'custom',
    ];

    private const DESTRUCTIVE_COMMAND_TYPES = [
        'delete_user',
        'delete_all_users',
        'delete_biodata_pin',
        'delete_biodata_type',
        'delete_biodata_no',
        'clear_biodata',
    ];

    public ?int $attendanceDeviceId = null;

    public string $commandType = 'range_attlog';

    public string $startTime = '';

    public string $endTime = '';

    public string $customCommand = '';

    public string $customPayload = '';

    public string $optionKey = 'ATTLOGStamp';

    public string $optionValue = '0';

    public string $deviceUserPin = '';

    public string $biodataType = '1';

    public string $biodataNo = '';

    public string $deleteConfirmation = '';

    public array $selectedCommandIds = [];

    /**
     * Prepare default test values for querying today's attendance logs.
     */
    public function mount(): void
    {
        $this->attendanceDeviceId = AttendanceDevice::query()->orderBy('code')->value('id');
        $this->startTime = now()->startOfDay()->format('Y-m-d\TH:i');
        $this->endTime = now()->endOfDay()->format('Y-m-d\TH:i');
    }

    /**
     * Queue the selected PUSH command for the next device polling cycle.
     */
    public function queueCommand(): void
    {
        $this->authorize('attendance.devices.manage');

        $validated = $this->validateCommand();
        $device = AttendanceDevice::query()->findOrFail($validated['attendanceDeviceId']);
        $commandService = app(AttendanceDeviceCommandService::class);

        $queuedCommand = match ($validated['commandType']) {
            'log' => $commandService->queueLogSync($device),
            'check' => $commandService->queueCheckSync($device),
            'reload_options' => $commandService->queueReloadOptions($device),
            'set_option' => $commandService->queueSetOption(
                $device,
                trim($validated['optionKey']),
                trim($validated['optionValue'])
            ),
            'range_attlog' => $commandService->queueAttendanceLogQuery(
                $device,
                $this->formatDeviceDateTime($validated['startTime']),
                $this->formatDeviceDateTime($validated['endTime'])
            ),
            'query_biodata' => $commandService->queueBiodataQuery(
                $device,
                trim($validated['biodataType']),
                trim((string) ($validated['deviceUserPin'] ?? '')) ?: null,
                trim((string) ($validated['biodataNo'] ?? '')) ?: null
            ),
            'delete_user' => $commandService->queueDeleteUserInfo($device, trim($validated['deviceUserPin'])),
            'delete_all_users' => $commandService->queueDeleteAllUsers($device),
            'delete_biodata_pin' => $commandService->queueDeleteBiodata($device, trim($validated['deviceUserPin'])),
            'delete_biodata_type' => $commandService->queueDeleteBiodata(
                $device,
                trim($validated['deviceUserPin']),
                trim($validated['biodataType'])
            ),
            'delete_biodata_no' => $commandService->queueDeleteBiodata(
                $device,
                trim($validated['deviceUserPin']),
                trim($validated['biodataType']),
                trim($validated['biodataNo'])
            ),
            'clear_biodata' => $commandService->queueClearBiodata($device),
            'custom' => $commandService->queuePushCommand(
                $device,
                trim($validated['customCommand']),
                trim((string) ($validated['customPayload'] ?? '')) ?: null
            ),
        };

        app(ActivityLogger::class)->logForCurrentRequest(
            'device',
            'device.test_command_queued',
            $device,
            'Attendance device test command was queued.',
            null,
            null,
            [
                'command_key' => $queuedCommand->command_key,
                'command' => $queuedCommand->command,
                'payload' => $queuedCommand->payload,
                'is_destructive' => $this->isDestructiveCommand(),
            ]
        );

        session()->flash('success', 'Đã xếp lệnh test. Máy sẽ nhận lệnh ở lần gọi /iclock/getrequest tiếp theo.');

        $this->deleteConfirmation = '';
    }

    /**
     * Delete selected test commands from the local command queue and history.
     */
    public function deleteSelectedCommands(): void
    {
        $this->authorize('attendance.devices.manage');

        $validated = $this->validate([
            'selectedCommandIds' => ['required', 'array', 'min:1'],
            'selectedCommandIds.*' => ['integer', 'exists:attendance_device_commands,id'],
        ], [
            'selectedCommandIds.required' => 'Vui lòng chọn ít nhất một lệnh cần xóa.',
            'selectedCommandIds.min' => 'Vui lòng chọn ít nhất một lệnh cần xóa.',
        ]);

        $commands = AttendanceDeviceCommand::query()
            ->whereIn('id', $validated['selectedCommandIds'])
            ->get();

        $deletedCount = $commands->count();
        $commandSummary = $commands
            ->map(fn (AttendanceDeviceCommand $command) => [
                'id' => $command->id,
                'command_key' => $command->command_key,
                'command' => $command->command,
                'status' => $command->status,
            ])
            ->values()
            ->all();

        AttendanceDeviceCommand::query()
            ->whereIn('id', $commands->pluck('id'))
            ->delete();

        app(ActivityLogger::class)->logForCurrentRequest(
            'device',
            'device.test_commands_deleted',
            null,
            'Attendance device test commands were deleted from local queue/history.',
            null,
            null,
            ['deleted_count' => $deletedCount, 'commands' => $commandSummary]
        );

        $this->selectedCommandIds = [];

        session()->flash('success', "Đã xóa {$deletedCount} lệnh test khỏi danh sách.");
    }

    /**
     * Render the device command tester with recent commands and imported logs.
     */
    public function render()
    {
        $devices = AttendanceDevice::query()
            ->withCount([
                'commands as pending_commands_count' => fn ($query) => $query->where('status', 'pending'),
                'rawLogs as received_today_count' => fn ($query) => $query->whereDate('created_at', now()->toDateString()),
            ])
            ->orderBy('code')
            ->get();

        $recentCommands = AttendanceDeviceCommand::query()
            ->with('device')
            ->when($this->attendanceDeviceId, fn ($query) => $query->where('attendance_device_id', $this->attendanceDeviceId))
            ->latest()
            ->limit(30)
            ->get();

        $recentLogs = RawAttendanceLog::query()
            ->with(['device', 'employee'])
            ->when($this->attendanceDeviceId, fn ($query) => $query->where('attendance_device_id', $this->attendanceDeviceId))
            ->where('source', 'zkteco_push')
            ->latest()
            ->limit(15)
            ->get();

        return view('livewire.pages.attendance.device-command-tester', [
            'devices' => $devices,
            'recentCommands' => $recentCommands,
            'recentLogs' => $recentLogs,
            'selectedDevice' => $devices->firstWhere('id', $this->attendanceDeviceId),
            'isDestructiveCommand' => $this->isDestructiveCommand(),
            'getRequestEndpoint' => url('/iclock/getrequest'),
            'uploadEndpoint' => url('/iclock/cdata'),
        ]);
    }

    /**
     * Validate the selected command and its required conditions before queueing.
     */
    private function validateCommand(): array
    {
        return $this->validate([
            'attendanceDeviceId' => ['required', 'exists:attendance_devices,id'],
            'commandType' => ['required', Rule::in(self::COMMAND_TYPES)],
            'startTime' => ['required_if:commandType,range_attlog', 'date'],
            'endTime' => ['required_if:commandType,range_attlog', 'date', 'after_or_equal:startTime'],
            'optionKey' => ['required_if:commandType,set_option', 'nullable', 'string', 'max:80'],
            'optionValue' => ['required_if:commandType,set_option', 'nullable', 'string', 'max:255'],
            'deviceUserPin' => [
                Rule::requiredIf(fn () => in_array($this->commandType, [
                    'query_biodata',
                    'delete_user',
                    'delete_biodata_pin',
                    'delete_biodata_type',
                    'delete_biodata_no',
                ], true) && $this->commandType !== 'query_biodata'),
                'nullable',
                'string',
                'max:80',
            ],
            'biodataType' => [
                Rule::requiredIf(fn () => in_array($this->commandType, [
                    'query_biodata',
                    'delete_biodata_type',
                    'delete_biodata_no',
                ], true)),
                'nullable',
                'string',
                'max:20',
            ],
            'biodataNo' => ['required_if:commandType,delete_biodata_no', 'nullable', 'string', 'max:20'],
            'deleteConfirmation' => [Rule::requiredIf(fn () => $this->isDestructiveCommand()), 'nullable', 'in:XOA'],
            'customCommand' => ['required_if:commandType,custom', 'nullable', 'string', 'max:80'],
            'customPayload' => ['nullable', 'string', 'max:1000'],
        ], [
            'attendanceDeviceId.required' => 'Vui lòng chọn thiết bị.',
            'startTime.required_if' => 'Vui lòng chọn thời gian bắt đầu.',
            'endTime.required_if' => 'Vui lòng chọn thời gian kết thúc.',
            'endTime.after_or_equal' => 'Thời gian kết thúc phải sau hoặc bằng thời gian bắt đầu.',
            'optionKey.required_if' => 'Vui lòng nhập tên option.',
            'optionValue.required_if' => 'Vui lòng nhập giá trị option.',
            'deviceUserPin.required' => 'Vui lòng nhập PIN người dùng trên máy.',
            'biodataType.required' => 'Vui lòng nhập loại BIODATA.',
            'biodataNo.required_if' => 'Vui lòng nhập số mẫu BIODATA.',
            'deleteConfirmation.required' => 'Vui lòng nhập XOA để xác nhận lệnh xóa.',
            'deleteConfirmation.in' => 'Vui lòng nhập đúng XOA để xác nhận lệnh xóa.',
            'customCommand.required_if' => 'Vui lòng nhập lệnh tùy chỉnh.',
        ]);
    }

    /**
     * Convert browser datetime-local input into the ZKTeco command timestamp format.
     */
    private function formatDeviceDateTime(string $value): string
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Identify commands that can remove data from the physical attendance device.
     */
    private function isDestructiveCommand(): bool
    {
        return in_array($this->commandType, self::DESTRUCTIVE_COMMAND_TYPES, true);
    }
}
