<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Modules\Attendance\DTOs\AttendanceDayContext;
use Modules\Attendance\DTOs\AttendanceRuleContext;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Attendance\Services\AttendanceDayResolver;
use Modules\Attendance\Services\AttendanceRuleService;
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
        private readonly AttendanceRuleService $attendanceRuleService,
    ) {
    }

    /**
     * Process all usable raw logs of one employee on one work date.
     */
    public function processEmployeeDay(Employee $employee, CarbonInterface|string $workDate): DailyAttendanceResult
    {
        $date = is_string($workDate) ? Carbon::parse($workDate)->startOfDay() : $workDate->copy()->startOfDay();
        $ruleContext = $this->attendanceRuleService->context();
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
        $missingLogCount = $this->missingLogCount($clockIn, $clockOut, $shift, $dayContext, $schedule, $ruleContext);
        $lateMinutes = $this->lateMinutes($clockIn, $shift, $date, $dayContext, $schedule, $ruleContext);
        $earlyLeaveMinutes = $this->earlyLeaveMinutes($clockOut, $shift, $date, $dayContext, $schedule, $ruleContext);
        $attendanceValue = $this->attendanceCalculator->calculate($shift, $dayContext, $workMinutes, $ruleContext);

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
                'overtime_minutes' => $this->overtimeMinutes($clockIn, $clockOut, $shift, $date, $dayContext, $workMinutes, $breakMinutes, $ruleContext),
                'missing_log_count' => $missingLogCount,
                'status' => $this->statusFor($schedule, $shift, $rawLogs, $missingLogCount, $lateMinutes, $earlyLeaveMinutes, $dayContext, $clockIn, $clockOut, $ruleContext),
                'note' => $this->noteFor($schedule, $shift, $rawLogs, $missingLogCount, $dayContext, $clockIn, $clockOut, $ruleContext),
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

        $logs = RawAttendanceLog::query()
            ->where('employee_id', $employee->id)
            ->where('processing_status', '!=', 'ignored')
            ->whereBetween('punch_time', [$from, $to])
            ->orderBy('punch_time')
            ->get();

        return $this->withoutPreviousOvernightLogs($logs, $employee, $workDate);
    }

    /**
     * Remove punches that already belong to the previous day's overnight shift.
     */
    private function withoutPreviousOvernightLogs(Collection $logs, Employee $employee, CarbonInterface $workDate): Collection
    {
        if ($logs->isEmpty()) {
            return $logs;
        }

        $previousSchedule = $this->shiftMatcher->previousOvernight($employee, $workDate);
        $previousShift = $previousSchedule?->shift;

        if (! $previousSchedule || ! $previousShift) {
            return $logs;
        }

        [$windowStart, $windowEnd] = $this->shiftWindow($previousSchedule->work_date, $previousShift);

        return $logs
            ->reject(fn (RawAttendanceLog $log): bool => $log->punch_time
                && $log->punch_time->greaterThanOrEqualTo($windowStart)
                && $log->punch_time->lessThanOrEqualTo($windowEnd))
            ->values();
    }

    /**
     * Count required punches that are missing for the matched shift.
     */
    private function missingLogCount(
        mixed $clockIn,
        mixed $clockOut,
        ?Shift $shift,
        AttendanceDayContext $dayContext,
        ?EmployeeSchedule $schedule,
        AttendanceRuleContext $ruleContext
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        $requiresClockIn = ($shift?->requires_clock_in ?? true) && $ruleContext->noInEnabled;
        $requiresClockOut = ($shift?->requires_clock_out ?? true) && $ruleContext->noOutEnabled;

        if ($requiresClockIn && ! $requiresClockOut) {
            return (! $clockIn && ! $clockOut) ? 1 : 0;
        }

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
        ?EmployeeSchedule $schedule,
        AttendanceRuleContext $ruleContext
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        if (! $clockIn && $shift && $ruleContext->noInEnabled && $ruleContext->noInPolicy === 'late') {
            return $ruleContext->noInMinutes;
        }

        return $this->lateCalculator->calculateLate($clockIn, $shift, $workDate, $ruleContext);
    }

    /**
     * Calculate early-leave minutes with special-day awareness.
     */
    private function earlyLeaveMinutes(
        ?CarbonInterface $clockOut,
        ?Shift $shift,
        CarbonInterface $workDate,
        AttendanceDayContext $dayContext,
        ?EmployeeSchedule $schedule,
        AttendanceRuleContext $ruleContext
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($dayContext->isSpecialDay() && ! $schedule) {
            return 0;
        }

        if (! $clockOut && $shift && $ruleContext->noOutEnabled && $ruleContext->noOutPolicy === 'early') {
            return $ruleContext->noOutMinutes;
        }

        return $this->lateCalculator->calculateEarlyLeave($clockOut, $shift, $workDate, $ruleContext);
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
        int $workMinutes,
        int $breakMinutes,
        AttendanceRuleContext $ruleContext
    ): int {
        if ($dayContext->dayType === 'leave') {
            return 0;
        }

        if ($shift) {
            return $this->overtimeCalculator->calculate($clockIn, $clockOut, $shift, $workDate, $ruleContext, $breakMinutes);
        }

        if ($dayContext->dayType === 'weekend' && ! $ruleContext->weekendCountAsOt) {
            return 0;
        }

        if ($dayContext->isSpecialDay() && $clockIn && $clockOut) {
            return $this->overtimeCalculator->applyRuleLimits($workMinutes, $ruleContext);
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
        AttendanceDayContext $dayContext,
        ?CarbonInterface $clockIn,
        ?CarbonInterface $clockOut,
        AttendanceRuleContext $ruleContext
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

        if ($this->shouldMarkAbsent($clockIn, $clockOut, $lateMinutes, $earlyLeaveMinutes, $ruleContext)) {
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
        AttendanceDayContext $dayContext,
        ?CarbonInterface $clockIn,
        ?CarbonInterface $clockOut,
        AttendanceRuleContext $ruleContext
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
            if (! $clockIn && $ruleContext->noInEnabled) {
                return $this->missingLogNote('giờ vào', $ruleContext->noInPolicy, $ruleContext->noInMinutes);
            }

            if (! $clockOut && $ruleContext->noOutEnabled) {
                return $this->missingLogNote('giờ ra', $ruleContext->noOutPolicy, $ruleContext->noOutMinutes);
            }

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

    /**
     * Build the absolute matching window used to identify one scheduled shift's logs.
     */
    private function shiftWindow(CarbonInterface $workDate, Shift $shift): array
    {
        $shiftStart = Carbon::parse($workDate->toDateString().' '.substr((string) $shift->start_time, 0, 8));
        $windowStart = $shift->clock_in_from
            ? Carbon::parse($workDate->toDateString().' '.substr((string) $shift->clock_in_from, 0, 8))
            : $shiftStart->copy();

        if (! $shift->clock_in_from && $shift->overtime_before_shift_enabled) {
            $windowStart = $workDate->copy()->startOfDay();
        }

        $windowEnd = Carbon::parse($workDate->toDateString().' '.substr((string) ($shift->clock_out_to ?: $shift->end_time), 0, 8));

        if ($windowEnd->lessThanOrEqualTo($shiftStart)) {
            $windowEnd->addDay();
        }

        return [$windowStart, $windowEnd];
    }

    /**
     * Determine whether rule thresholds should convert an exception into absence.
     */
    private function shouldMarkAbsent(
        ?CarbonInterface $clockIn,
        ?CarbonInterface $clockOut,
        int $lateMinutes,
        int $earlyLeaveMinutes,
        AttendanceRuleContext $ruleContext
    ): bool {
        if (! $clockIn && $ruleContext->noInEnabled && $ruleContext->noInPolicy === 'absent') {
            return true;
        }

        if (! $clockOut && $ruleContext->noOutEnabled && $ruleContext->noOutPolicy === 'absent') {
            return true;
        }

        if ($ruleContext->lateAbsentEnabled && $lateMinutes >= $ruleContext->lateAbsentMinutes) {
            return true;
        }

        return $ruleContext->earlyAbsentEnabled && $earlyLeaveMinutes >= $ruleContext->earlyAbsentMinutes;
    }

    /**
     * Explain how a saved rule handled a missing punch.
     */
    private function missingLogNote(string $missingLabel, string $policy, int $minutes): string
    {
        return match ($policy) {
            'late' => 'Thiếu '.$missingLabel.', đã tính '.$minutes.' phút đi trễ theo quy tắc.',
            'early' => 'Thiếu '.$missingLabel.', đã tính '.$minutes.' phút về sớm theo quy tắc.',
            'absent' => 'Thiếu '.$missingLabel.', đã chuyển thành vắng theo quy tắc.',
            default => 'Thiếu '.$missingLabel.', chỉ ghi nhận là thiếu log theo quy tắc.',
        };
    }
}
