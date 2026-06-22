<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Attendance\Actions\GenerateMonthlyTimesheetAction;
use Modules\Attendance\Services\MonthlyTimesheetService;
use Modules\Org\Models\Department;
use Modules\User\Models\Employee;

class MonthlyTimesheet extends Component
{
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

        return view('livewire.pages.attendance.monthly-timesheet', [
            'departments' => Department::query()->orderBy('sort_order')->orderBy('name')->get(),
            'employees' => Employee::query()
                ->with('department')
                ->when($this->nullableInt($this->departmentId), fn ($query, $departmentId) => $query->where('department_id', $departmentId))
                ->orderBy('employee_code')
                ->get(),
            'results' => $monthlyTimesheetService->results($filters),
            'summary' => $monthlyTimesheetService->summary($filters),
        ]);
    }

    /**
     * Normalize Livewire filter state for the monthly timesheet service.
     */
    private function filters(): array
    {
        return [
            'period_month' => $this->periodMonth,
            'department_id' => $this->nullableInt($this->departmentId),
            'employee_id' => $this->nullableInt($this->employeeId),
            'status' => $this->statusFilter ?: null,
        ];
    }

    /**
     * Convert blank Livewire select values into nullable integer foreign keys.
     */
    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }
}
