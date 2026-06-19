<?php

namespace Modules\Attendance\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Attendance\Models\DailyAttendanceResult;

class DailyTimesheetService
{
    /**
     * Return daily timesheet rows with employee, department, shift, and filter context.
     */
    public function results(array $filters): Collection
    {
        return $this->baseQuery($filters)
            ->withCount('adjustments')
            ->orderByDesc('work_date')
            ->orderBy('employee_id')
            ->limit(500)
            ->get();
    }

    /**
     * Return summary counters for the current daily timesheet filter.
     */
    public function summary(array $filters): array
    {
        $query = $this->baseQuery($filters);

        return [
            'total' => (clone $query)->count(),
            'complete' => (clone $query)->where('status', 'complete')->count(),
            'adjusted' => (clone $query)->where('status', 'adjusted')->count(),
            'exception' => (clone $query)->where('status', 'exception')->count(),
            'absent' => (clone $query)->where('status', 'absent')->count(),
            'leave' => (clone $query)->where('status', 'leave')->count(),
            'weekend' => (clone $query)->where('status', 'weekend')->count(),
            'holiday' => (clone $query)->where('status', 'holiday')->count(),
            'missing_logs' => (int) (clone $query)->sum('missing_log_count'),
            'work_minutes' => (int) (clone $query)->sum('work_minutes'),
            'break_minutes' => (int) (clone $query)->sum('break_minutes'),
            'attendance_value' => round((float) (clone $query)->sum('attendance_value'), 2),
            'late_minutes' => (int) (clone $query)->sum('late_minutes'),
            'overtime_minutes' => (int) (clone $query)->sum('overtime_minutes'),
        ];
    }

    /**
     * Build the shared query used by daily timesheet lists and summaries.
     */
    private function baseQuery(array $filters): Builder
    {
        return DailyAttendanceResult::query()
            ->with(['employee.department', 'shift'])
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->whereDate('work_date', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->whereDate('work_date', '<=', $date))
            ->when($filters['employee_id'] ?? null, fn ($query, $employeeId) => $query->where('employee_id', $employeeId))
            ->when($filters['department_id'] ?? null, function ($query, $departmentId) {
                $query->whereHas('employee', fn ($employeeQuery) => $employeeQuery->where('department_id', $departmentId));
            })
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status));
    }
}
