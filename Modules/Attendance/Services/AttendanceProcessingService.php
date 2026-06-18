<?php

namespace Modules\Attendance\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Attendance\Engines\AttendanceEngine;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\User\Models\Employee;

class AttendanceProcessingService
{
    /**
     * Prepare the processing service with the raw-log attendance engine.
     */
    public function __construct(private readonly AttendanceEngine $attendanceEngine)
    {
    }

    /**
     * Process employees across a date range and return the number of daily rows produced.
     */
    public function processDateRange(string $dateFrom, string $dateTo, ?int $employeeId = null): int
    {
        $from = Carbon::parse($dateFrom)->startOfDay();
        $to = Carbon::parse($dateTo)->startOfDay();

        if ($to->lessThan($from)) {
            [$from, $to] = [$to, $from];
        }

        $processedCount = 0;
        $employees = Employee::query()
            ->when($employeeId, fn ($query) => $query->whereKey($employeeId))
            ->orderBy('employee_code')
            ->get();

        foreach ($employees as $employee) {
            for ($date = $from->copy(); $date->lessThanOrEqualTo($to); $date->addDay()) {
                $this->attendanceEngine->processEmployeeDay($employee, $date);
                $processedCount++;
            }
        }

        return $processedCount;
    }

    /**
     * Return processed daily results with the filters needed by the UI page.
     */
    public function results(string $dateFrom, string $dateTo, ?int $employeeId = null, ?string $status = null): Collection
    {
        return DailyAttendanceResult::query()
            ->with(['employee.department', 'shift'])
            ->whereDate('work_date', '>=', $dateFrom)
            ->whereDate('work_date', '<=', $dateTo)
            ->when($employeeId, fn ($query) => $query->where('employee_id', $employeeId))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('work_date')
            ->orderBy('employee_id')
            ->limit(300)
            ->get();
    }
}
