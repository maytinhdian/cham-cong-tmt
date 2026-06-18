<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Attendance\Actions\SaveRawAttendanceLogAction;
use Modules\Attendance\DTOs\RawAttendanceLogData;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Device\Models\AttendanceDevice;
use Modules\User\Models\Employee;

class RawLogs extends Component
{
    public $attendanceDeviceId = null;

    public $employeeId = null;

    public string $deviceUserCode = '';

    public string $punchTime = '';

    public string $punchType = 'unknown';

    public ?string $verifyType = null;

    public string $source = 'manual';

    public string $processingStatus = 'pending';

    public ?string $note = null;

    public string $dateFrom = '';

    public string $dateTo = '';

    public $deviceFilter = '';

    public $employeeFilter = '';

    public string $statusFilter = '';

    /**
     * Prepare default filter and manual-entry values for raw attendance logs.
     */
    public function mount(): void
    {
        $this->attendanceDeviceId = AttendanceDevice::query()->orderBy('code')->value('id');
        $this->employeeId = Employee::query()->orderBy('employee_code')->value('id');
        $this->punchTime = now()->format('Y-m-d\TH:i');
        $this->dateFrom = now()->startOfDay()->toDateString();
        $this->dateTo = now()->endOfDay()->toDateString();
    }

    /**
     * Save a manual raw log entry without running attendance calculations.
     */
    public function saveRawLog(): void
    {
        $validated = $this->validate([
            'attendanceDeviceId' => ['nullable', 'exists:attendance_devices,id'],
            'employeeId' => ['nullable', 'exists:employees,id'],
            'deviceUserCode' => ['required', 'string', 'max:100'],
            'punchTime' => ['required', 'date'],
            'punchType' => ['required', 'string', 'max:40'],
            'verifyType' => ['nullable', 'string', 'max:80'],
            'source' => ['required', 'string', 'max:80'],
            'processingStatus' => ['required', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'deviceUserCode.required' => 'Vui lòng nhập mã người dùng trên máy.',
            'punchTime.required' => 'Vui lòng nhập thời gian chấm công.',
        ]);

        app(SaveRawAttendanceLogAction::class)->execute(new RawAttendanceLogData(
            attendanceDeviceId: $this->nullableInt($validated['attendanceDeviceId']),
            employeeId: $this->nullableInt($validated['employeeId']),
            deviceUserCode: $validated['deviceUserCode'],
            punchTime: $validated['punchTime'],
            punchType: $validated['punchType'],
            verifyType: $validated['verifyType'] ?: null,
            source: $validated['source'],
            processingStatus: $validated['processingStatus'],
            rawPayload: [
                'entry_source' => 'manual_ui',
            ],
            note: $validated['note'] ?: null,
        ));

        session()->flash('success', 'Đã lưu log chấm công thô.');

        $this->reset(['deviceUserCode', 'note', 'verifyType']);
        $this->punchType = 'unknown';
        $this->source = 'manual';
        $this->processingStatus = 'pending';
        $this->punchTime = now()->format('Y-m-d\TH:i');
    }

    /**
     * Delete a raw log that should not be processed into timesheets.
     */
    public function deleteRawLog(int $rawLogId): void
    {
        RawAttendanceLog::query()->findOrFail($rawLogId)->delete();

        session()->flash('success', 'Đã xóa log chấm công thô.');
    }

    /**
     * Mark a raw log as ignored while preserving it for audit review.
     */
    public function ignoreRawLog(int $rawLogId): void
    {
        RawAttendanceLog::query()
            ->findOrFail($rawLogId)
            ->update(['processing_status' => 'ignored']);

        session()->flash('success', 'Đã đánh dấu bỏ qua log chấm công.');
    }

    /**
     * Render the raw log page with date/device/employee/status filters.
     */
    public function render()
    {
        $rawLogs = RawAttendanceLog::query()
            ->with(['device', 'employee.department'])
            ->when($this->dateFrom, fn ($query) => $query->whereDate('punch_time', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($query) => $query->whereDate('punch_time', '<=', $this->dateTo))
            ->when($this->deviceFilter, fn ($query) => $query->where('attendance_device_id', $this->deviceFilter))
            ->when($this->employeeFilter, fn ($query) => $query->where('employee_id', $this->employeeFilter))
            ->when($this->statusFilter, fn ($query) => $query->where('processing_status', $this->statusFilter))
            ->orderByDesc('punch_time')
            ->limit(300)
            ->get();

        return view('livewire.pages.attendance.raw-logs', [
            'devices' => AttendanceDevice::query()->orderBy('code')->get(),
            'employees' => Employee::query()->with('department')->orderBy('employee_code')->get(),
            'pendingCount' => RawAttendanceLog::query()->where('processing_status', 'pending')->count(),
            'rawLogs' => $rawLogs,
            'todayCount' => RawAttendanceLog::query()->whereDate('punch_time', now()->toDateString())->count(),
            'totalCount' => RawAttendanceLog::query()->count(),
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
