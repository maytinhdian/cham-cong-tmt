<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Attendance\Actions\GenerateMonthlyTimesheetAction;
use Modules\Attendance\Services\MonthlyTimesheetService;
use Modules\Core\Services\ActivityLogger;
use Modules\Org\Models\Department;
use Modules\User\Models\Employee;

class MonthlyTimesheet extends Component
{
    use AuthorizesRequests;

    public string $periodMonth = '';

    public $departmentId = '';

    public $employeeId = '';

    public string $statusFilter = '';

    /**
     * Prepare the default monthly timesheet period for review.
     */
    public function mount(): void
    {
        $this->periodMonth = now()->format('Y-m');
    }

    /**
     * Generate monthly payroll-ready rows from processed daily timesheets.
     */
    public function generateMonthlyTimesheet(GenerateMonthlyTimesheetAction $generateMonthlyTimesheetAction): void
    {
        $this->authorize('attendance.timesheet.generate');

        $validated = $this->validate([
            'periodMonth' => ['required', 'date_format:Y-m'],
            'departmentId' => ['nullable', 'exists:departments,id'],
        ], [
            'periodMonth.required' => 'Vui lòng chọn tháng cần tổng hợp.',
            'periodMonth.date_format' => 'Tháng tổng hợp không hợp lệ.',
        ]);

        $generatedCount = $generateMonthlyTimesheetAction->execute(
            $validated['periodMonth'],
            $this->nullableInt($validated['departmentId'])
        );

        app(ActivityLogger::class)->logForCurrentRequest(
            'attendance',
            'monthly_timesheet.generated',
            null,
            'Monthly timesheet rows were generated from daily attendance results.',
            null,
            null,
            [
                'period_month' => $validated['periodMonth'],
                'department_id' => $this->nullableInt($validated['departmentId']),
                'generated_count' => $generatedCount,
            ]
        );

        session()->flash('success', "Đã tổng hợp {$generatedCount} dòng bảng công tháng.");
    }

    /**
     * Clear monthly review filters back to the current month.
     */
    public function resetFilters(): void
    {
        $this->periodMonth = now()->format('Y-m');
        $this->departmentId = '';
        $this->employeeId = '';
        $this->statusFilter = '';
    }

    /**
     * Render generated monthly timesheets with summary metrics.
     */
    public function render(MonthlyTimesheetService $monthlyTimesheetService)
    {
        $filters = $this->filters();
        $canViewAllTimesheets = $this->canViewAllTimesheets();

        return view('livewire.pages.attendance.monthly-timesheet', [
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
            'results' => $monthlyTimesheetService->results($filters),
            'summary' => $monthlyTimesheetService->summary($filters),
        ]);
    }

    /**
     * Normalize Livewire filter state for the monthly timesheet service.
     */
    private function filters(): array
    {
        $canViewAllTimesheets = $this->canViewAllTimesheets();

        return [
            'period_month' => $this->periodMonth,
            'department_id' => $canViewAllTimesheets ? $this->nullableInt($this->departmentId) : null,
            'employee_id' => $canViewAllTimesheets
                ? $this->nullableInt($this->employeeId)
                : ($this->currentEmployeeId() ?? 0),
            'status' => $this->statusFilter ?: null,
        ];
    }

    /**
     * Determine whether the current user can review every employee's monthly timesheet.
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
