<?php

namespace Modules\Attendance\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\MonthlyTimesheet;
use Modules\User\Models\Employee;

class MonthlyTimesheetService
{
    /**
     * Generate monthly attendance summaries from processed daily results.
     */
    public function generate(string $periodMonth, ?int $departmentId = null): int
    {
        $month = Carbon::parse($periodMonth.'-01')->startOfMonth();
        $dateFrom = $month->toDateString();
        $dateTo = $month->copy()->endOfMonth()->toDateString();
        $generatedCount = 0;

        $employees = Employee::query()
            ->with('department')
            ->whereHas('dailyAttendanceResults', function ($query) use ($dateFrom, $dateTo) {
                $query->whereDate('work_date', '>=', $dateFrom)
                    ->whereDate('work_date', '<=', $dateTo);
            })
            ->when($departmentId, fn ($query) => $query->where('department_id', $departmentId))
            ->orderBy('employee_code')
            ->get();

        foreach ($employees as $employee) {
            $dailyRows = DailyAttendanceResult::query()
                ->where('employee_id', $employee->id)
                ->whereDate('work_date', '>=', $dateFrom)
                ->whereDate('work_date', '<=', $dateTo)
                ->get();

            if ($dailyRows->isEmpty()) {
                continue;
            }

            MonthlyTimesheet::query()->updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'period_month' => $month->toDateString(),
                ],
                $this->summaryAttributes($dailyRows, $employee)
            );

            $generatedCount++;
        }

        return $generatedCount;
    }

    /**
     * Return monthly summaries for the review page filters.
     */
    public function results(array $filters): Collection
    {
        return $this->baseQuery($filters)
            ->orderByDesc('period_month')
            ->orderBy('employee_id')
            ->limit(500)
            ->get();
    }

    /**
     * Return total metrics for the current monthly review filters.
     */
    public function summary(array $filters): array
    {
        $query = $this->baseQuery($filters);

        return [
            'total' => (clone $query)->count(),
            'work_minutes' => (int) (clone $query)->sum('work_minutes'),
            'attendance_value' => round((float) (clone $query)->sum('attendance_value'), 2),
            'overtime_minutes' => (int) (clone $query)->sum('overtime_minutes'),
            'exception_days' => (int) (clone $query)->sum('exception_days'),
            'absent_days' => (int) (clone $query)->sum('absent_days'),
            'missing_logs' => (int) (clone $query)->sum('missing_log_count'),
        ];
    }

    /**
     * Build persisted summary fields from one employee's daily results.
     */
    private function summaryAttributes(Collection $dailyRows, Employee $employee): array
    {
        return [
            'department_id' => $employee->department_id,
            'total_days' => $dailyRows->count(),
            'work_days' => $dailyRows->whereIn('status', ['complete', 'adjusted'])->count(),
            'adjusted_days' => $dailyRows->where('status', 'adjusted')->count(),
            'exception_days' => $dailyRows->where('status', 'exception')->count(),
            'absent_days' => $dailyRows->where('status', 'absent')->count(),
            'leave_days' => $dailyRows->where('status', 'leave')->count(),
            'weekend_days' => $dailyRows->where('status', 'weekend')->count(),
            'holiday_days' => $dailyRows->where('status', 'holiday')->count(),
            'missing_log_count' => (int) $dailyRows->sum('missing_log_count'),
            'work_minutes' => (int) $dailyRows->sum('work_minutes'),
            'break_minutes' => (int) $dailyRows->sum('break_minutes'),
            'attendance_value' => round((float) $dailyRows->sum('attendance_value'), 2),
            'late_minutes' => (int) $dailyRows->sum('late_minutes'),
            'early_leave_minutes' => (int) $dailyRows->sum('early_leave_minutes'),
            'overtime_minutes' => (int) $dailyRows->sum('overtime_minutes'),
            'status' => 'draft',
            'generated_at' => now(),
            'note' => null,
        ];
    }

    /**
     * Build the shared query used by monthly timesheet lists and summaries.
     */
    private function baseQuery(array $filters): Builder
    {
        return MonthlyTimesheet::query()
            ->with(['employee.department', 'department'])
            ->when($filters['period_month'] ?? null, function ($query, $month) {
                $query->whereDate('period_month', Carbon::parse($month.'-01')->startOfMonth()->toDateString());
            })
            ->when($filters['department_id'] ?? null, fn ($query, $departmentId) => $query->where('department_id', $departmentId))
            ->when($filters['employee_id'] ?? null, fn ($query, $employeeId) => $query->where('employee_id', $employeeId))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status));
    }
}
