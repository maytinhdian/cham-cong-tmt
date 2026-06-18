<?php

namespace Modules\Device\DTOs;

class AttendanceDeviceUserMapData
{
    public function __construct(
        public int $attendanceDeviceId,
        public int $employeeId,
        public string $deviceUserCode,
        public ?string $deviceUserName = null,
        public string $status = 'active',
        public ?string $note = null,
    ) {
    }

    /**
     * Convert mapping form data into database columns.
     */
    public function toArray(): array
    {
        return [
            'attendance_device_id' => $this->attendanceDeviceId,
            'employee_id' => $this->employeeId,
            'device_user_code' => $this->deviceUserCode,
            'device_user_name' => $this->deviceUserName,
            'status' => $this->status,
            'note' => $this->note,
        ];
    }
}
