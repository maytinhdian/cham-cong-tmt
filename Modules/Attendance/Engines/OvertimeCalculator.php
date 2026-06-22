<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Attendance\DTOs\AttendanceRuleContext;
use Modules\Shift\Models\Shift;

class OvertimeCalculator
{
    /**
     * Calculate overtime minutes before shift start and after planned shift end.
     */
    public function calculate(
        ?CarbonInterface $clockIn,
        ?CarbonInterface $clockOut,
        ?Shift $shift,
        CarbonInterface $workDate,
        ?AttendanceRuleContext $ruleContext = null,
        int $breakMinutes = 0
    ): int {
        if (! $shift) {
            return 0;
        }

        $shiftStart = $this->shiftDateTime($workDate, $shift->start_time);
        $shiftEnd = $this->shiftDateTime($workDate, $shift->end_time);

        if ($shiftEnd->lessThanOrEqualTo($shiftStart)) {
            $shiftEnd->addDay();
        }

        $beforeShiftMinutes = $this->limitedBeforeShiftMinutes($this->beforeShiftMinutes($clockIn, $shiftStart, $shift), $ruleContext);
        $afterShiftMinutes = $this->limitedAfterShiftMinutes($this->afterShiftMinutes($clockOut, $shiftEnd, $shift), $ruleContext);
        $breakOvertimeMinutes = $shift->break_as_overtime_enabled ? max(0, $breakMinutes) : 0;

        return $this->applyRuleLimits($beforeShiftMinutes + $afterShiftMinutes + $breakOvertimeMinutes, $ruleContext);
    }

    /**
     * Apply configured minimum and maximum overtime thresholds.
     */
    public function applyRuleLimits(int $overtimeMinutes, ?AttendanceRuleContext $ruleContext = null): int
    {
        if (! $ruleContext) {
            return $overtimeMinutes;
        }

        if ($overtimeMinutes < $ruleContext->minOvertimeMinutes) {
            return 0;
        }

        if ($ruleContext->limitTotalOvertimeEnabled) {
            return min($overtimeMinutes, $ruleContext->maxTotalOvertimeMinutes);
        }

        return $overtimeMinutes;
    }

    /**
     * Build a shift timestamp from a work date and a database time value.
     */
    private function shiftDateTime(CarbonInterface $workDate, mixed $time): Carbon
    {
        return Carbon::parse($workDate->toDateString().' '.substr((string) $time, 0, 8));
    }

    /**
     * Calculate allowed overtime before the planned shift start.
     */
    private function beforeShiftMinutes(?CarbonInterface $clockIn, CarbonInterface $shiftStart, Shift $shift): int
    {
        if (! $clockIn || ! $shift->overtime_before_shift_enabled) {
            return 0;
        }

        if ($clockIn->greaterThanOrEqualTo($shiftStart)) {
            return 0;
        }

        $beforeShiftMinutes = (int) $clockIn->diffInMinutes($shiftStart);
        $thresholdMinutes = (int) $shift->overtime_before_shift_min_minutes;

        return $beforeShiftMinutes < $thresholdMinutes ? 0 : $beforeShiftMinutes;
    }

    /**
     * Apply the company-wide cap for overtime before the planned shift start.
     */
    private function limitedBeforeShiftMinutes(int $minutes, ?AttendanceRuleContext $ruleContext): int
    {
        if (! $ruleContext?->limitBeforeInEnabled) {
            return $minutes;
        }

        return min($minutes, $ruleContext->maxBeforeInMinutes);
    }

    /**
     * Calculate overtime after the planned shift end once the shift threshold is reached.
     */
    private function afterShiftMinutes(?CarbonInterface $clockOut, CarbonInterface $shiftEnd, Shift $shift): int
    {
        if (! $clockOut || ! $shift->overtime_after_shift_enabled) {
            return 0;
        }

        if ($clockOut->lessThanOrEqualTo($shiftEnd)) {
            return 0;
        }

        $afterShiftMinutes = (int) $shiftEnd->diffInMinutes($clockOut);
        $thresholdMinutes = (int) $shift->overtime_after_shift_min_minutes;

        return $afterShiftMinutes < $thresholdMinutes ? 0 : $afterShiftMinutes;
    }

    /**
     * Apply the company-wide cap for overtime after the planned shift end.
     */
    private function limitedAfterShiftMinutes(int $minutes, ?AttendanceRuleContext $ruleContext): int
    {
        if (! $ruleContext?->limitAfterOutEnabled) {
            return $minutes;
        }

        return min($minutes, $ruleContext->maxAfterOutMinutes);
    }
}
