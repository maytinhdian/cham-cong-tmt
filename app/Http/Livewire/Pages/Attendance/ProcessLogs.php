<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Attendance\Actions\ProcessRawLogsAction;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Attendance\Services\AttendanceProcessingService;
use Modules\User\Models\Employee;

class ProcessLogs extends Component
{
    public string $dateFrom = '';

    public string $dateTo = '';

    public $employeeId = '';

    public string $statusFilter = '';

    /**
     * Prepare default processing filters for the current attendance window.
     */
    public function mount(): void
    {
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    /**
     * Run raw-log processing and write daily attendance results.
     */
    public function processLogs(ProcessRawLogsAction $processRawLogsAction): void
    {
        $validated = $this->validate([
            'dateFrom' => ['required', 'date'],
            'dateTo' => ['required', 'date'],
            'employeeId' => ['nullable', 'exists:employees,id'],
        ], [
            'dateFrom.required' => 'Vui lòng chọn ngày bắt đầu.',
            'dateTo.required' => 'Vui lòng chọn ngày kết thúc.',
        ]);

        $processedCount = $processRawLogsAction->execute(
            $validated['dateFrom'],
            $validated['dateTo'],
            $this->nullableInt($validated['employeeId'])
        );

        session()->flash('success', "Đã xử lý {$processedCount} dòng ngày công.");
    }

    /**
     * Render the processing page with summary cards and daily result rows.
     */
    public function render(AttendanceProcessingService $processingService)
    {
        $employeeId = $this->nullableInt($this->employeeId);
        $results = $processingService->results(
            $this->dateFrom,
            $this->dateTo,
            $employeeId,
            $this->statusFilter ?: null
        );

        return view('livewire.pages.attendance.process-logs', [
            'employees' => Employee::query()->with('department')->orderBy('employee_code')->get(),
            'exceptionCount' => DailyAttendanceResult::query()->where('status', 'exception')->count(),
            'pendingRawLogCount' => RawAttendanceLog::query()->where('processing_status', 'pending')->count(),
            'processedResultCount' => DailyAttendanceResult::query()->count(),
            'results' => $results,
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
