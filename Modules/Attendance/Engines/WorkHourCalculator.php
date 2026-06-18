<?php

namespace Modules\Attendance\Engines;

use Carbon\CarbonInterface;

class WorkHourCalculator
{
    /**
     * Calculate worked minutes from the first valid in punch to the last valid out punch.
     */
    public function calculate(?CarbonInterface $clockIn, ?CarbonInterface $clockOut): int
    {
        if (! $clockIn || ! $clockOut || $clockOut->lessThanOrEqualTo($clockIn)) {
            return 0;
        }

        return (int) $clockIn->diffInMinutes($clockOut);
    }
}
