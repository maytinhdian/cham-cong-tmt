<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Attendance\Actions\AdjustDailyTimesheetAction;
use Modules\Attendance\DTOs\DailyTimesheetAdjustmentData;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Services\DailyTimesheetService;
use Modules\Org\Models\Department;
use Modules\User\Models\Employee;

class DailyTimesheet extends Component
{
    use AuthorizesRequests;

    public string $dateFrom = '';

    public string $dateTo = '';

    public $departmentId = '';

    public $employeeId = '';

    public string $statusFilter = '';

    public ?int $adjustingResultId = null;

    public string $adjustClockInAt = '';

    public string $adjustClockOutAt = '';

    public string $adjustReason = '';

    public string $adjustNote = '';

    /**
     * Prepare the default daily timesheet period for review.
     */
    public function mount(): void
    {
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    /**
     * Clear filters back to the current month review window.
     */
    public function resetFilters(): void
    {
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
        $this->departmentId = '';
        $this->employeeId = '';
        $this->statusFilter = '';
        $this->cancelAdjustment();
    }

    /**
     * Load one daily timesheet row into the manual adjustment form.
     */
    public function openAdjustment(int $dailyAttendanceResultId): void
    {
        $this->authorize('attendance.timesheet.adjust');

        $dailyResult = DailyAttendanceResult::query()->findOrFail($dailyAttendanceResultId);

        $this->adjustingResultId = $dailyResult->id;
        $this->adjustClockInAt = $dailyResult->clock_in_at?->format('Y-m-d\TH:i') ?? '';
        $this->adjustClockOutAt = $dailyResult->clock_out_at?->format('Y-m-d\TH:i') ?? '';
        $this->adjustReason = '';
        $this->adjustNote = $dailyResult->note ?? '';
    }

    /**
     * Hide the manual adjustment form and clear its temporary values.
     */
    public function cancelAdjustment(): void
    {
        $this->adjustingResultId = null;
        $this->adjustClockInAt = '';
        $this->adjustClockOutAt = '';
        $this->adjustReason = '';
        $this->adjustNote = '';
    }

    /**
     * Apply a manual correction to the selected daily timesheet row.
     */
    public function saveAdjustment(AdjustDailyTimesheetAction $adjustDailyTimesheetAction): void
    {
        $this->authorize('attendance.timesheet.adjust');

        $validated = $this->validate([
            'adjustingResultId' => ['required', 'exists:daily_attendance_results,id'],
            'adjustClockInAt' => ['nullable', 'date'],
            'adjustClockOutAt' => ['nullable', 'date', 'after_or_equal:adjustClockInAt'],
            'adjustReason' => ['required', 'string', 'min:5', 'max:1000'],
            'adjustNote' => ['nullable', 'string', 'max:1000'],
        ], [
            'adjustReason.required' => 'Vui lòng nhập lý do điều chỉnh.',
            'adjustReason.min' => 'Lý do điều chỉnh cần ít nhất 5 ký tự.',
            'adjustClockOutAt.after_or_equal' => 'Giờ ra phải lớn hơn hoặc bằng giờ vào.',
        ]);

        $adjustDailyTimesheetAction->execute(new DailyTimesheetAdjustmentData(
            dailyAttendanceResultId: (int) $validated['adjustingResultId'],
            clockInAt: $validated['adjustClockInAt'] ?: null,
            clockOutAt: $validated['adjustClockOutAt'] ?: null,
            reason: $validated['adjustReason'],
            note: $validated['adjustNote'] ?: null,
        ));

        session()->flash('success', 'Đã điều chỉnh bảng công ngày và ghi nhật ký thao tác.');

        $this->cancelAdjustment();
    }

    /**
     * Render daily timesheet results and summary metrics from processed attendance data.
     */
    public function render(DailyTimesheetService $dailyTimesheetService)
    {
        $filters = $this->filters();
        $canViewAllTimesheets = $this->canViewAllTimesheets();

        return view('livewire.pages.attendance.daily-timesheet', [
            'canViewAllTimesheets' => $canViewAllTimesheets,
            'departments' => $canViewAllTimesheets
                ? Department::query()->orderBy('sort_order')->orderBy('name')->get()
                : collect(),
            'employees' => $canViewAllTimesheets
                ? Employee::query()
                    ->with('department')
                    ->when($this->nullableInt($this->departmentId), fn ($query, $departmentId) => $query->where('department_id', $departmentId))
                    ->orderBy('employee_code')
                    ->get()
                : collect(),
            'results' => $dailyTimesheetService->results($filters),
            'summary' => $dailyTimesheetService->summary($filters),
            'adjustingResult' => $this->adjustingResultId
                ? DailyAttendanceResult::query()->with(['employee.department', 'shift'])->find($this->adjustingResultId)
                : null,
        ]);
    }

    /**
     * Normalize Livewire filter state before passing it into the service layer.
     */
    private function filters(): array
    {
        $canViewAllTimesheets = $this->canViewAllTimesheets();

        return [
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'department_id' => $canViewAllTimesheets ? $this->nullableInt($this->departmentId) : null,
            'employee_id' => $canViewAllTimesheets
                ? $this->nullableInt($this->employeeId)
                : ($this->currentEmployeeId() ?? 0),
            'status' => $this->statusFilter ?: null,
        ];
    }

    /**
     * Determine whether the current user can review every employee's timesheet.
     */
    private function canViewAllTimesheets(): bool
    {
        return (bool) auth()->user()?->can('attendance.timesheet.view_all');
    }

    /**
     * Resolve the employee profile linked to the current login account.
     */
    private function currentEmployeeId(): ?int
    {
        return auth()->user()?->employeeProfile()->value('id');
    }

    /**
     * Convert blank Livewire select values into nullable integer foreign keys.
     */
    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
