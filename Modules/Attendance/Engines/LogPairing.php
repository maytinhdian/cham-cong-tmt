<?php

namespace Modules\Attendance\Engines;

use Illuminate\Support\Collection;
use Modules\Attendance\DTOs\LogPairingResult;
use Modules\Attendance\Models\RawAttendanceLog;

class LogPairing
{
    /**
     * Pair filtered logs into the most likely clock-in and clock-out timestamps.
     */
    public function pair(Collection $logs): LogPairingResult
    {
        $orderedLogs = $logs
            ->sortBy(fn (RawAttendanceLog $log) => $log->punch_time?->getTimestamp() ?? 0)
            ->values();

        $clockIn = $this->findClockIn($orderedLogs);
        $clockOut = $this->findClockOut($orderedLogs);

        return new LogPairingResult(
            logs: $orderedLogs,
            clockIn: $clockIn?->punch_time,
            clockOut: $clockOut?->punch_time,
            matchedLogCount: $orderedLogs->count(),
        );
    }

    /**
     * Prefer the earliest punch that looks like a clock-in event.
     */
    private function findClockIn(Collection $logs): ?RawAttendanceLog
    {
        return $logs->first(function (RawAttendanceLog $log): bool {
            return $this->isClockInType($log->punch_type);
        }) ?? $logs->first();
    }

    /**
     * Prefer the latest punch that looks like a clock-out event.
     */
    private function findClockOut(Collection $logs): ?RawAttendanceLog
    {
        return $logs->reverse()->first(function (RawAttendanceLog $log): bool {
            return $this->isClockOutType($log->punch_type);
        }) ?? $logs->last();
    }

    /**
     * Detect punch types commonly used for check-in events.
     */
    private function isClockInType(?string $punchType): bool
    {
        return in_array(strtolower((string) $punchType), ['in', 'clock_in', 'check_in', 'entry'], true);
    }

    /**
     * Detect punch types commonly used for check-out events.
     */
    private function isClockOutType(?string $punchType): bool
    {
        return in_array(strtolower((string) $punchType), ['out', 'clock_out', 'check_out', 'exit'], true);
    }
}
