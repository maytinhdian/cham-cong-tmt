<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Shift\Models\Shift;

class OvertimeCalculator
{
    /**
     * Calculate overtime minutes after the planned shift end.
     */
    public function calculate(?CarbonInterface $clockOut, ?Shift $shift, CarbonInterface $workDate): int
    {
        if (! $clockOut || ! $shift) {
            return 0;
        }

        $shiftStart = $this->shiftDateTime($workDate, $shift->start_time);
        $shiftEnd = $this->shiftDateTime($workDate, $shift->end_time);

        if ($shiftEnd->lessThanOrEqualTo($shiftStart)) {
            $shiftEnd->addDay();
        }

        return max(0, (int) $shiftEnd->diffInMinutes($clockOut, false));
    }

    /**
     * Build a shift timestamp from a work date and a database time value.
     */
    private function shiftDateTime(CarbonInterface $workDate, mixed $time): Carbon
    {
        return Carbon::parse($workDate->toDateString().' '.substr((string) $time, 0, 8));
    }
}
