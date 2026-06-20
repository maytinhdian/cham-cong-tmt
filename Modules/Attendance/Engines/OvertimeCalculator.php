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
        ?AttendanceRuleContext $ruleContext = null
    ): int {
        if (! $shift) {
            return 0;
        }

        $shiftStart = $this->shiftDateTime($workDate, $shift->start_time);
        $shiftEnd = $this->shiftDateTime($workDate, $shift->end_time);

        if ($shiftEnd->lessThanOrEqualTo($shiftStart)) {
            $shiftEnd->addDay();
        }

        $beforeShiftMinutes = $this->beforeShiftMinutes($clockIn, $shiftStart, $shift);
        $afterShiftMinutes = $this->afterShiftMinutes($clockOut, $shiftEnd, $shift);

        return $this->applyRuleLimits($beforeShiftMinutes + $afterShiftMinutes, $ruleContext);
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

        return (int) $clockIn->diffInMinutes($shiftStart);
    }

    /**
     * Calculate overtime after the planned shift end once the shift threshold is reached.
     */
    private function afterShiftMinutes(?CarbonInterface $clockOut, CarbonInterface $shiftEnd, Shift $shift): int
    {
        if (! $clockOut) {
            return 0;
        }

        if ($clockOut->lessThanOrEqualTo($shiftEnd)) {
            return 0;
        }

        $afterShiftMinutes = (int) $shiftEnd->diffInMinutes($clockOut);
        $thresholdMinutes = (int) $shift->overtime_after_shift_min_minutes;

        return $afterShiftMinutes < $thresholdMinutes ? 0 : $afterShiftMinutes;
    }
}
