<?php

namespace Modules\Device\DTOs;

class ZktecoPushAttendanceLogData
{
    public function __construct(
        public string $deviceUserCode,
        public string $punchTime,
        public string $status,
        public ?string $verifyType,
        public ?string $workCode,
        public ?array $reserved = null,
        public ?string $rawLine = null,
    ) {
    }

    /**
     * Convert one parsed device line into a payload kept with the raw log.
     */
    public function toRawPayload(): array
    {
        return [
            'protocol' => 'zkteco_push',
            'status' => $this->status,
            'verify' => $this->verifyType,
            'work_code' => $this->workCode,
            'reserved' => $this->reserved,
            'raw_line' => $this->rawLine,
        ];
    }
}
