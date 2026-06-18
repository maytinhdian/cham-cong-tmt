<?php

namespace Modules\Device\Actions;

use Modules\Device\DTOs\AttendanceDeviceData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Services\AttendanceDeviceService;

class UpdateAttendanceDeviceAction
{
    public function __construct(private readonly AttendanceDeviceService $deviceService)
    {
    }

    /**
     * Update a device record from the attendance device management screen.
     */
    public function execute(AttendanceDevice $device, AttendanceDeviceData $data): AttendanceDevice
    {
        return $this->deviceService->update($device, $data);
    }
}
