<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;

class AttendanceEngine
{
    /**
     * Prepare calculators used to turn raw logs into daily attendance results.
     */
    public function __construct(
        private readonly ShiftMatcher $shiftMatcher,
        private readonly WorkHourCalculator $workHourCalculator,
        private readonly LateCalculator $lateCalculator,
        private readonly OvertimeCalculator $overtimeCalculator,
    ) {
    }

    /**
     * Process all usable raw logs of one employee on one work date.
     */
    public function processEmployeeDay(Employee $employee, CarbonInterface|string $workDate): DailyAttendanceResult
    {
        $date = is_string($workDate) ? Carbon::parse($workDate)->startOfDay() : $workDate->copy()->startOfDay();
        $schedule = $this->shiftMatcher->match($employee, $date);
        $shift = $schedule?->shift;
        $rawLogs = $this->rawLogsForDay($employee, $date, $shift);

        $clockIn = $rawLogs->first()?->punch_time;
        $clockOut = $rawLogs->count() > 1 ? $rawLogs->last()?->punch_time : null;
        $missingLogCount = $this->missingLogCount($clockIn, $clockOut, $shift);
        $lateMinutes = $this->lateCalculator->calculateLate($clockIn, $shift, $date);
        $earlyLeaveMinutes = $this->lateCalculator->calculateEarlyLeave($clockOut, $shift, $date);

        $dailyResult = DailyAttendanceResult::query()->updateOrCreate(
            [
                'employee_id' => $employee->id,
                'work_date' => $date->toDateString(),
            ],
            [
                'employee_schedule_id' => $schedule?->id,
                'shift_id' => $shift?->id,
                'clock_in_at' => $clockIn,
                'clock_out_at' => $clockOut,
                'work_minutes' => $this->workHourCalculator->calculate($clockIn, $clockOut),
                'late_minutes' => $lateMinutes,
                'early_leave_minutes' => $earlyLeaveMinutes,
                'overtime_minutes' => $this->overtimeCalculator->calculate($clockOut, $shift, $date),
                'missing_log_count' => $missingLogCount,
                'status' => $this->statusFor($schedule, $shift, $rawLogs, $missingLogCount, $lateMinutes, $earlyLeaveMinutes),
                'note' => $this->noteFor($schedule, $shift, $rawLogs, $missingLogCount),
            ]
        );

        if ($rawLogs->isNotEmpty()) {
            RawAttendanceLog::query()
                ->whereKey($rawLogs->pluck('id'))
                ->update(['processing_status' => 'processed']);
        }

        return $dailyResult->refresh();
    }

    /**
     * Read logs within a normal day or an overnight-shift window.
     */
    private function rawLogsForDay(Employee $employee, CarbonInterface $workDate, ?Shift $shift): Collection
    {
        $from = $workDate->copy()->startOfDay();
        $to = $workDate->copy()->endOfDay();

        if ($shift && $this->isOvernightShift($shift)) {
            $to = $workDate->copy()->addDay()->endOfDay();
        }

        return RawAttendanceLog::query()
            ->where('employee_id', $employee->id)
            ->where('processing_status', '!=', 'ignored')
            ->whereBetween('punch_time', [$from, $to])
            ->orderBy('punch_time')
            ->get();
    }

    /**
     * Count required punches that are missing for the matched shift.
     */
    private function missingLogCount(mixed $clockIn, mixed $clockOut, ?Shift $shift): int
    {
        $requiresClockIn = $shift?->requires_clock_in ?? true;
        $requiresClockOut = $shift?->requires_clock_out ?? true;

        return (int) ($requiresClockIn && ! $clockIn) + (int) ($requiresClockOut && ! $clockOut);
    }

    /**
     * Decide the daily processing status from schedule, logs, and exceptions.
     */
    private function statusFor(
        ?EmployeeSchedule $schedule,
        ?Shift $shift,
        Collection $rawLogs,
        int $missingLogCount,
        int $lateMinutes,
        int $earlyLeaveMinutes
    ): string {
        if (! $schedule || ! $shift) {
            return 'no_schedule';
        }

        if ($rawLogs->isEmpty()) {
            return 'absent';
        }

        return $missingLogCount > 0 || $lateMinutes > 0 || $earlyLeaveMinutes > 0 ? 'exception' : 'complete';
    }

    /**
     * Build a short audit note explaining the daily processing outcome.
     */
    private function noteFor(?EmployeeSchedule $schedule, ?Shift $shift, Collection $rawLogs, int $missingLogCount): ?string
    {
        if (! $schedule || ! $shift) {
            return $rawLogs->isEmpty()
                ? 'Chưa có lịch/ca làm để xử lý ngày công.'
                : 'Có log nhưng chưa có lịch/ca làm tương ứng.';
        }

        if ($rawLogs->isEmpty()) {
            return 'Không có log chấm công trong ngày làm việc.';
        }

        if ($missingLogCount > 0) {
            return 'Thiếu log vào hoặc log ra theo cấu hình ca.';
        }

        return null;
    }

    /**
     * Detect whether shift end belongs to the next calendar day.
     */
    private function isOvernightShift(Shift $shift): bool
    {
        return Carbon::parse((string) $shift->end_time)->lessThanOrEqualTo(Carbon::parse((string) $shift->start_time));
    }
}
