<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Modules\Shift\Models\Shift;

class BreakCalculator
{
    /**
     * Calculate how many break minutes should be deducted from the gross work span.
     */
    public function calculate(?CarbonInterface $clockIn, ?CarbonInterface $clockOut, ?Shift $shift, CarbonInterface $workDate): int
    {
        if (! $clockIn || ! $clockOut || $clockOut->lessThanOrEqualTo($clockIn) || ! $shift) {
            return 0;
        }

        $breakWindows = $this->breakWindows($shift, $workDate);
        $breakMinutes = 0;

        foreach ($breakWindows as $window) {
            $overlap = $this->overlapMinutes($clockIn, $clockOut, $window['start'], $window['end']);
            $breakMinutes += min($overlap, $window['minutes']);
        }

        return max(0, $breakMinutes);
    }

    /**
     * Resolve configured break windows from the shift, falling back to legacy break columns.
     */
    private function breakWindows(Shift $shift, CarbonInterface $workDate): array
    {
        $windows = [];

        $shift->loadMissing('breaks');

        if ($shift->breaks->isNotEmpty()) {
            foreach ($shift->breaks as $break) {
                $windows[] = $this->windowFor($workDate, $break->start_time, $break->end_time, (int) $break->break_minutes);
            }

            return $windows;
        }

        if ($shift->break_start_time && $shift->break_end_time) {
            $windows[] = $this->windowFor($workDate, $shift->break_start_time, $shift->break_end_time, (int) $shift->break_minutes);
        }

        return $windows;
    }

    /**
     * Create a break window with absolute timestamps for one work date.
     */
    private function windowFor(CarbonInterface $workDate, mixed $startTime, mixed $endTime, int $minutes): array
    {
        $start = Carbon::parse($workDate->toDateString().' '.substr((string) $startTime, 0, 8));
        $end = Carbon::parse($workDate->toDateString().' '.substr((string) $endTime, 0, 8));

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        return [
            'start' => $start,
            'end' => $end,
            'minutes' => max(0, $minutes),
        ];
    }

    /**
     * Measure the overlap between the worked span and one break window.
     */
    private function overlapMinutes(CarbonInterface $clockIn, CarbonInterface $clockOut, CarbonInterface $breakStart, CarbonInterface $breakEnd): int
    {
        $start = $clockIn->greaterThan($breakStart) ? $clockIn : $breakStart;
        $end = $clockOut->lessThan($breakEnd) ? $clockOut : $breakEnd;

        if ($end->lessThanOrEqualTo($start)) {
            return 0;
        }

        return (int) $start->diffInMinutes($end);
    }
}
