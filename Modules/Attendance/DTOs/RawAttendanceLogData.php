<?php

namespace Modules\Attendance\DTOs;

class RawAttendanceLogData
{
    public function __construct(
        public ?int $attendanceDeviceId,
        public ?int $employeeId,
        public string $deviceUserCode,
        public string $punchTime,
        public string $punchType = 'unknown',
        public ?string $verifyType = null,
        public string $source = 'device',
        public string $processingStatus = 'pending',
        public ?array $rawPayload = null,
        public ?string $note = null,
    ) {
    }

    /**
     * Convert a raw punch log transfer object into database columns.
     */
    public function toArray(): array
    {
        return [
            'attendance_device_id' => $this->attendanceDeviceId,
            'employee_id' => $this->employeeId,
            'device_user_code' => $this->deviceUserCode,
            'punch_time' => $this->punchTime,
            'punch_type' => $this->punchType,
            'verify_type' => $this->verifyType,
            'source' => $this->source,
            'processing_status' => $this->processingStatus,
            'raw_payload' => $this->rawPayload,
            'note' => $this->note,
        ];
    }
}
