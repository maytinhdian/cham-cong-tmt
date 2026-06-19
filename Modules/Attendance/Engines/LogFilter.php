<?php

namespace Modules\Attendance\Engines;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Shift\Models\Shift;

class LogFilter
{
    /**
     * Narrow a day's raw logs down to the records that belong to the matched shift window.
     */
    public function filter(Collection $logs, ?Shift $shift, CarbonInterface $workDate): Collection
    {
        if ($logs->isEmpty()) {
            return collect();
        }

        $filtered = $logs->filter(function (RawAttendanceLog $log) use ($shift, $workDate): bool {
            if (! $shift) {
                return true;
            }

            [$windowStart, $windowEnd] = $this->shiftWindow($workDate, $shift);

            return $log->punch_time?->greaterThanOrEqualTo($windowStart)
                && $log->punch_time?->lessThanOrEqualTo($windowEnd);
        });

        return $this->deduplicate($filtered->values());
    }

    /**
     * Build the active time window for one shift and work date.
     */
    private function shiftWindow(CarbonInterface $workDate, Shift $shift): array
    {
        $start = Carbon::parse($workDate->toDateString().' '.substr((string) ($shift->clock_in_from ?: $shift->start_time), 0, 8));
        $end = Carbon::parse($workDate->toDateString().' '.substr((string) ($shift->clock_out_to ?: $shift->end_time), 0, 8));

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        return [$start, $end];
    }

    /**
     * Remove duplicate logs that were imported more than once for the same device punch.
     */
    private function deduplicate(Collection $logs): Collection
    {
        return $logs
            ->unique(function (RawAttendanceLog $log): string {
                return implode('|', [
                    (string) $log->attendance_device_id,
                    (string) $log->device_user_code,
                    (string) optional($log->punch_time)->format('Y-m-d H:i:s'),
                    (string) $log->punch_type,
                ]);
            })
            ->values();
    }
}
