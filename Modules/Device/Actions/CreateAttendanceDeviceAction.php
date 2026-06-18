<?php

namespace Modules\Device\Actions;

use Modules\Device\DTOs\AttendanceDeviceData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Services\AttendanceDeviceService;

class CreateAttendanceDeviceAction
{
    public function __construct(private readonly AttendanceDeviceService $deviceService)
    {
    }

    /**
     * Create a device record from the attendance device management screen.
     */
    public function execute(AttendanceDeviceData $data): AttendanceDevice
    {
        return $this->deviceService->create($data);
    }
}
