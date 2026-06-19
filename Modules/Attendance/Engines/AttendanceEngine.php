<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Modules\Attendance\DTOs\AttendanceDayContext;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Attendance\Services\AttendanceDayResolver;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;

class AttendanceEngine
{
    /**
     * Prepare calculators used to turn raw logs into daily attendance results.
     */
    public function __construct(
        private readonly LogFilter $logFilter,
        private readonly LogPairing $logPairing,
        private readonly AttendanceDayResolver $dayResolver,
        private readonly ShiftMatcher $shiftMatcher,
        private readonly BreakCalculator $breakCalculator,
        private readonly AttendanceCalculator $attendanceCalculator,
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
        $dayContext = $this->dayResolver->resolve($employee, $date);
        $schedule = $this->shiftMatcher->match($employee, $date);
        $shift = $schedule?->shift;
        $rawLogs = $this->rawLogsForDay($employee, $date, $shift);
        $filteredLogs = $this->logFilter->filter($rawLogs, $shift, $date);
        $pairing = $this->logPairing->pair($filteredLogs);

        $clockIn = $pairing->clockIn;
        $clockOut = $pairing->clockOut;
        $isApprovedLeave = $dayContext->dayType === 'leave';
        $grossWorkMinutes = $isApprovedLeave ? 0 : $this->workHourCalculator->calculate($clockIn, $clockOut);
        $breakMinutes = $isApprovedLeave ? 0 : $this->breakCalculator->calculate($clockIn, $clockOut, $shift, $date);
        $workMinutes = max(0, $grossWorkMinutes - $breakMinutes);
        $missingLogCount = $this->missingLogCount($clockIn, $clockOut, $shift, $dayContext, $schedule);
        $lateMinutes = $this->lateMinutes($clockIn, $shift, $date, $dayContext, $schedule);
        $earlyLeaveMinutes = $this->earlyLeaveMinutes($clockOut, $shift, $date, $dayContext, $schedule);
        $attendanceValue = $this->attendanceCalculator->calculate($shift, $dayContext, $workMinutes);

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
                'work_minutes' => $workMinutes,
                'break_minutes' => $breakMinutes,
                'attendance_value' => $attendanceValue,
                'late_minutes' => $isApprovedLeave ? 0 : $lateMinutes,
                'early_leave_minutes' => $isApprovedLeave ? 0 : $earlyLeaveMinutes,
                'overtime_minutes' => $this->overtimeMinutes($clockIn, $clockOut, $shift, $date, $dayContext, $workMinutes),
                'missing_log_count' => $missingLogCount,
                'status' => $this->statusFor($schedule, $shift, $rawLogs, $missingLogCount, $lateMinutes, $earlyLeaveMinutes, $dayContext),
                'note' => $this->noteFor($schedule, $shift, $rawLogs, $missingLogCount, $dayContext),
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
    private function missingLogCount(
        mixed $clockIn,
        mixed $clockOut,
        ?Shift $shift,
        AttendanceDayContext $dayContext,
        ?EmployeeSchedule $schedule
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        $requiresClockIn = $shift?->requires_clock_in ?? true;
        $requiresClockOut = $shift?->requires_clock_out ?? true;

        return (int) ($requiresClockIn && ! $clockIn) + (int) ($requiresClockOut && ! $clockOut);
    }

    /**
     * Calculate late minutes with special-day awareness.
     */
    private function lateMinutes(
        ?CarbonInterface $clockIn,
        ?Shift $shift,
        CarbonInterface $workDate,
        AttendanceDayContext $dayContext,
        ?EmployeeSchedule $schedule
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        return $this->lateCalculator->calculateLate($clockIn, $shift, $workDate);
    }

    /**
     * Calculate early-leave minutes with special-day awareness.
     */
    private function earlyLeaveMinutes(
        ?CarbonInterface $clockOut,
        ?Shift $shift,
        CarbonInterface $workDate,
        AttendanceDayContext $dayContext,
        ?EmployeeSchedule $schedule
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        return $this->lateCalculator->calculateEarlyLeave($clockOut, $shift, $workDate);
    }

    /**
     * Calculate overtime, treating special non-working days as overtime-only when no shift is assigned.
     */
    private function overtimeMinutes(
        ?CarbonInterface $clockIn,
        ?CarbonInterface $clockOut,
        ?Shift $shift,
        CarbonInterface $workDate,
        AttendanceDayContext $dayContext,
        int $workMinutes
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($shift) {
            return $this->overtimeCalculator->calculate($clockOut, $shift, $workDate);
        }

        if ($dayContext->isSpecialDay() && $clockIn && $clockOut) {
            return $workMinutes;
        }

        return 0;
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
        int $earlyLeaveMinutes,
        AttendanceDayContext $dayContext
    ): string {
        if ($dayContext->dayType === 'leave') {
            return 'leave';
        }

        if (! $schedule || ! $shift) {
            if ($dayContext->dayType === 'holiday') {
                return 'holiday';
            }

            if ($dayContext->dayType === 'weekend') {
                return 'weekend';
            }

            return 'no_schedule';
        }

        if ($rawLogs->isEmpty()) {
            if ($dayContext->dayType === 'leave') {
                return 'leave';
            }

            if ($dayContext->dayType === 'holiday') {
                return 'holiday';
            }

            if ($dayContext->dayType === 'weekend') {
                return 'weekend';
            }

            return 'absent';
        }

        return $missingLogCount > 0 || $lateMinutes > 0 || $earlyLeaveMinutes > 0 ? 'exception' : 'complete';
    }

    /**
     * Build a short audit note explaining the daily processing outcome.
     */
    private function noteFor(
        ?EmployeeSchedule $schedule,
        ?Shift $shift,
        Collection $rawLogs,
        int $missingLogCount,
        AttendanceDayContext $dayContext
    ): ?string {
        if ($dayContext->dayType === 'holiday' && ! $schedule) {
            return $rawLogs->isEmpty()
                ? 'Ngày nghỉ lễ theo lịch công ty.'
                : 'Chấm công trong ngày nghỉ lễ.';
        }

        if ($dayContext->dayType === 'leave') {
            return $dayContext->leave?->leave_type
                ? 'Ngày nghỉ phép đã được duyệt: '.$dayContext->leave->leave_type.'.'
                : 'Ngày nghỉ phép đã được duyệt.';
        }

        if ($dayContext->dayType === 'weekend' && ! $schedule) {
            return $rawLogs->isEmpty()
                ? 'Ngày cuối tuần theo cấu hình hệ thống.'
                : 'Chấm công trong ngày cuối tuần.';
        }

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
