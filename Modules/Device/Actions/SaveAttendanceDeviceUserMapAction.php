<?php

namespace Modules\Device\Actions;

use Modules\Device\DTOs\AttendanceDeviceUserMapData;
use Modules\Device\Models\AttendanceDeviceUserMap;
use Modules\Device\Services\AttendanceDeviceUserMapService;

class SaveAttendanceDeviceUserMapAction
{
    public function __construct(private readonly AttendanceDeviceUserMapService $mappingService)
    {
    }

    /**
     * Save a device-user mapping from the mapping management screen.
     */
    public function execute(AttendanceDeviceUserMapData $data): AttendanceDeviceUserMap
    {
        return $this->mappingService->save($data);
    }
}
