<?php

namespace Modules\Device\DTOs;

class AttendanceDeviceData
{
    public function __construct(
        public string $code,
        public string $name,
        public string $deviceType = 'zkteco',
        public ?string $ipAddress = null,
        public int $port = 4370,
        public ?string $location = null,
        public string $connectionStatus = 'unknown',
        public string $syncStatus = 'idle',
        public ?string $lastConnectedAt = null,
        public ?string $lastSyncedAt = null,
        public ?string $note = null,
    ) {
    }

    /**
     * Convert validated device form data into columns for persistence.
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'device_type' => $this->deviceType,
            'ip_address' => $this->ipAddress,
            'port' => $this->port,
            'location' => $this->location,
            'connection_status' => $this->connectionStatus,
            'sync_status' => $this->syncStatus,
            'last_connected_at' => $this->lastConnectedAt,
            'last_synced_at' => $this->lastSyncedAt,
            'note' => $this->note,
        ];
    }
}
