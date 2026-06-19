<?php

namespace Modules\Attendance\Engines;

use Modules\Attendance\DTOs\AttendanceDayContext;
use Modules\Shift\Models\Shift;

class AttendanceCalculator
{
    /**
     * Convert net worked minutes and day context into a payable attendance value.
     */
    public function calculate(?Shift $shift, AttendanceDayContext $dayContext, int $netWorkMinutes): float
    {
        if ($dayContext->dayType === 'leave') {
            return (float) ($dayContext->leave?->workday_value ?? 0);
        }

        if ($dayContext->dayType === 'holiday') {
            return (float) ($dayContext->holiday?->workday_value ?? 0);
        }

        if (! $shift || $netWorkMinutes <= 0) {
            return 0.0;
        }

        $standardMinutes = max(1, (int) $shift->standard_work_minutes);
        $targetValue = (float) $shift->workday_value;
        $ratio = min(1, $netWorkMinutes / $standardMinutes);

        return round($targetValue * $ratio, 2);
    }
}
