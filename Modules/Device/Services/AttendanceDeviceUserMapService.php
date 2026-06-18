<?php

namespace Modules\Device\Services;

use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Device\DTOs\AttendanceDeviceUserMapData;
use Modules\Device\Models\AttendanceDeviceUserMap;

class AttendanceDeviceUserMapService
{
    /**
     * Create or replace the employee mapping for one device user code.
     */
    public function save(AttendanceDeviceUserMapData $data): AttendanceDeviceUserMap
    {
        return AttendanceDeviceUserMap::query()->updateOrCreate(
            [
                'attendance_device_id' => $data->attendanceDeviceId,
                'device_user_code' => $data->deviceUserCode,
            ],
            $data->toArray()
        );
    }

    /**
     * Apply one mapping to existing raw logs that were not mapped to employees yet.
     */
    public function applyToRawLogs(AttendanceDeviceUserMap $mapping): int
    {
        return RawAttendanceLog::query()
            ->where('attendance_device_id', $mapping->attendance_device_id)
            ->where('device_user_code', $mapping->device_user_code)
            ->whereNull('employee_id')
            ->update(['employee_id' => $mapping->employee_id]);
    }
}
