<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Attendance\DTOs\AttendanceRuleContext;
use Modules\Shift\Models\Shift;

class LateCalculator
{
    /**
     * Calculate late minutes after applying the allowed late tolerance of the shift.
     */
    public function calculateLate(
        ?CarbonInterface $clockIn,
        ?Shift $shift,
        CarbonInterface $workDate,
        ?AttendanceRuleContext $ruleContext = null
    ): int {
        if (! $clockIn || ! $shift) {
            return 0;
        }

        $shiftStart = $this->shiftDateTime($workDate, $shift->start_time);
        $lateMinutes = max(0, (int) $shiftStart->diffInMinutes($clockIn, false));

        $tolerance = $ruleContext?->lateThresholdMinutes ?? (int) $shift->max_late_minutes;

        return max(0, $lateMinutes - $tolerance);
    }

    /**
     * Calculate early-leave minutes after applying the allowed early-leave tolerance.
     */
    public function calculateEarlyLeave(
        ?CarbonInterface $clockOut,
        ?Shift $shift,
        CarbonInterface $workDate,
        ?AttendanceRuleContext $ruleContext = null
    ): int {
        if (! $clockOut || ! $shift) {
            return 0;
        }

        $shiftStart = $this->shiftDateTime($workDate, $shift->start_time);
        $shiftEnd = $this->shiftDateTime($workDate, $shift->end_time);

        if ($shiftEnd->lessThanOrEqualTo($shiftStart)) {
            $shiftEnd->addDay();
        }

        $earlyMinutes = max(0, (int) $clockOut->diffInMinutes($shiftEnd, false));

        $tolerance = $ruleContext?->earlyThresholdMinutes ?? (int) $shift->max_early_leave_minutes;

        return max(0, $earlyMinutes - $tolerance);
    }

    /**
     * Build a shift timestamp from a work date and a database time value.
     */
    private function shiftDateTime(CarbonInterface $workDate, mixed $time): Carbon
    {
        return Carbon::parse($workDate->toDateString().' '.substr((string) $time, 0, 8));
    }
}
