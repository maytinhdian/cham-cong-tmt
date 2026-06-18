<?php

namespace Modules\Attendance\Services;

use Modules\Attendance\DTOs\RawAttendanceLogData;
use Modules\Attendance\Models\RawAttendanceLog;

class RawAttendanceLogService
{
    /**
     * Store or update one raw device punch without calculating timesheets yet.
     */
    public function save(RawAttendanceLogData $data): RawAttendanceLog
    {
        return RawAttendanceLog::query()->updateOrCreate(
            [
                'attendance_device_id' => $data->attendanceDeviceId,
                'device_user_code' => $data->deviceUserCode,
                'punch_time' => $data->punchTime,
            ],
            $data->toArray()
        );
    }

    /**
     * Mark a raw log as ignored so processing engines skip it later.
     */
    public function ignore(RawAttendanceLog $rawLog): RawAttendanceLog
    {
        $rawLog->update(['processing_status' => 'ignored']);

        return $rawLog->refresh();
    }
}
