<?php

namespace Modules\Attendance\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\DTOs\DailyTimesheetAdjustmentData;
use Modules\Attendance\Engines\AttendanceCalculator;
use Modules\Attendance\Engines\BreakCalculator;
use Modules\Attendance\Engines\LateCalculator;
use Modules\Attendance\Engines\OvertimeCalculator;
use Modules\Attendance\Engines\WorkHourCalculator;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\DailyTimesheetAdjustment;
use Modules\Core\Services\ActivityLogger;
use Modules\Attendance\Services\AttendanceDayResolver;
use Modules\User\Models\Employee;

class DailyTimesheetAdjustmentService
{
    /**
     * Prepare calculators and audit logger for manual daily timesheet corrections.
     */
    public function __construct(
        private readonly WorkHourCalculator $workHourCalculator,
        private readonly BreakCalculator $breakCalculator,
        private readonly AttendanceCalculator $attendanceCalculator,
        private readonly AttendanceDayResolver $dayResolver,
        private readonly LateCalculator $lateCalculator,
        private readonly OvertimeCalculator $overtimeCalculator,
        private readonly ActivityLogger $activityLogger,
    ) {
    }

    /**
     * Apply a manual correction, preserve history, and write a Core audit log.
     */
    public function adjust(DailyTimesheetAdjustmentData $data): DailyTimesheetAdjustment
    {
        return DB::transaction(function () use ($data) {
            $dailyResult = DailyAttendanceResult::query()
                ->with('shift')
                ->lockForUpdate()
                ->findOrFail($data->dailyAttendanceResultId);

            $oldValues = $this->trackedValues($dailyResult);
            $clockInAt = $this->parseDateTime($data->clockInAt);
            $clockOutAt = $this->parseDateTime($data->clockOutAt);
            $missingLogCount = (int) (! $clockInAt) + (int) (! $clockOutAt);
            $shift = $dailyResult->shift;
            $employee = Employee::query()->findOrFail($dailyResult->employee_id);
            $dayContext = $this->dayResolver->resolve($employee, $dailyResult->work_date);
            $breakMinutes = $this->breakCalculator->calculate($clockInAt, $clockOutAt, $shift, $dailyResult->work_date);
            $workMinutes = max(0, $this->workHourCalculator->calculate($clockInAt, $clockOutAt) - $breakMinutes);

            $newValues = [
                'clock_in_at' => $clockInAt?->toDateTimeString(),
                'clock_out_at' => $clockOutAt?->toDateTimeString(),
                'work_minutes' => $workMinutes,
                'break_minutes' => $breakMinutes,
                'attendance_value' => $this->attendanceCalculator->calculate($shift, $dayContext, $workMinutes),
                'late_minutes' => $this->lateCalculator->calculateLate($clockInAt, $shift, $dailyResult->work_date),
                'early_leave_minutes' => $this->lateCalculator->calculateEarlyLeave($clockOutAt, $shift, $dailyResult->work_date),
                'overtime_minutes' => $this->overtimeCalculator->calculate($clockOutAt, $shift, $dailyResult->work_date),
                'missing_log_count' => $missingLogCount,
                'status' => $missingLogCount > 0 ? 'exception' : 'adjusted',
                'note' => $data->note ?: $dailyResult->note,
            ];

            $adjustment = DailyTimesheetAdjustment::query()->create([
                'daily_attendance_result_id' => $dailyResult->id,
                'employee_id' => $dailyResult->employee_id,
                'adjusted_by' => auth()->id(),
                'work_date' => $dailyResult->work_date,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'reason' => $data->reason,
                'status' => 'applied',
            ]);

            $dailyResult->update($newValues);

            $this->activityLogger->logForCurrentRequest(
                module: 'Attendance',
                action: 'daily_timesheet_adjusted',
                subject: $dailyResult,
                description: 'Điều chỉnh bảng công ngày.',
                oldValues: $oldValues,
                newValues: $newValues,
                metadata: [
                    'adjustment_id' => $adjustment->id,
                    'reason' => $data->reason,
                ]
            );

            return $adjustment->refresh();
        });
    }

    /**
     * Extract values that must be preserved before a manual timesheet correction.
     */
    private function trackedValues(DailyAttendanceResult $dailyResult): array
    {
        return [
            'clock_in_at' => $dailyResult->clock_in_at?->toDateTimeString(),
            'clock_out_at' => $dailyResult->clock_out_at?->toDateTimeString(),
            'work_minutes' => $dailyResult->work_minutes,
            'break_minutes' => $dailyResult->break_minutes,
            'attendance_value' => $dailyResult->attendance_value,
            'late_minutes' => $dailyResult->late_minutes,
            'early_leave_minutes' => $dailyResult->early_leave_minutes,
            'overtime_minutes' => $dailyResult->overtime_minutes,
            'missing_log_count' => $dailyResult->missing_log_count,
            'status' => $dailyResult->status,
            'note' => $dailyResult->note,
        ];
    }

    /**
     * Convert a form datetime value into a Carbon instance or null.
     */
    private function parseDateTime(?string $value): ?Carbon
    {
        return blank($value) ? null : Carbon::parse($value);
    }
}
