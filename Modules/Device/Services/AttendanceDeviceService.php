<?php

namespace Modules\Device\Services;

use Modules\Device\DTOs\AttendanceDeviceData;
use Modules\Device\Models\AttendanceDevice;

class AttendanceDeviceService
{
    /**
     * Register a new attendance device that can later be used for log sync.
     */
    public function create(AttendanceDeviceData $data): AttendanceDevice
    {
        return AttendanceDevice::query()->create($data->toArray());
    }

    /**
     * Update connection and identity information for an existing device.
     */
    public function update(AttendanceDevice $device, AttendanceDeviceData $data): AttendanceDevice
    {
        $device->update($data->toArray());

        return $device->refresh();
    }

    /**
     * Store a simulated connection check result until real device integration exists.
     */
    public function markConnectionChecked(AttendanceDevice $device, bool $online): AttendanceDevice
    {
        $device->update([
            'connection_status' => $online ? 'online' : 'offline',
            'last_connected_at' => now(),
        ]);

        return $device->refresh();
    }

    /**
     * Store a simulated sync timestamp until raw log synchronization is implemented.
     */
    public function markSynced(AttendanceDevice $device): AttendanceDevice
    {
        $device->update([
            'sync_status' => 'synced',
            'last_synced_at' => now(),
        ]);

        return $device->refresh();
    }
}
