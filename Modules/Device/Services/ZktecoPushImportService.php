<?php

namespace Modules\Device\Services;

use Modules\Attendance\DTOs\RawAttendanceLogData;
use Modules\Attendance\Services\RawAttendanceLogService;
use Modules\Device\DTOs\ZktecoPushAttendanceLogData;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceUserMap;

class ZktecoPushImportService
{
    public function __construct(
        private readonly RawAttendanceLogService $rawAttendanceLogService,
    ) {
    }

    /**
     * Store all attendance records pushed by one physical device.
     */
    public function import(string $serialNumber, array $logs): int
    {
        $device = $this->findOrCreateDevice($serialNumber);
        $count = 0;

        foreach ($logs as $log) {
            if (! $log instanceof ZktecoPushAttendanceLogData) {
                continue;
            }

            $mapping = $this->findEmployeeMapping($device, $log->deviceUserCode);

            $this->rawAttendanceLogService->save(new RawAttendanceLogData(
                attendanceDeviceId: $device->id,
                employeeId: $mapping?->employee_id,
                deviceUserCode: $log->deviceUserCode,
                punchTime: $log->punchTime,
                punchType: $this->mapPunchType($log->status),
                verifyType: $log->verifyType,
                source: 'zkteco_push',
                processingStatus: 'pending',
                rawPayload: $log->toRawPayload(),
            ));

            $count++;
        }

        $device->update([
            'connection_status' => 'online',
            'sync_status' => 'synced',
            'last_connected_at' => now(),
            'last_synced_at' => now(),
        ]);

        return $count;
    }

    /**
     * Mark that a device contacted the server even when it did not send logs.
     */
    public function touchDevice(string $serialNumber): AttendanceDevice
    {
        $device = $this->findOrCreateDevice($serialNumber);

        $device->update([
            'connection_status' => 'online',
            'last_connected_at' => now(),
        ]);

        return $device->refresh();
    }

    /**
     * Find the device by serial number, using the project device code as the serial key.
     */
    private function findOrCreateDevice(string $serialNumber): AttendanceDevice
    {
        return AttendanceDevice::query()->firstOrCreate(
            ['code' => $serialNumber],
            [
                'name' => 'ZKTeco ' . $serialNumber,
                'device_type' => 'zkteco',
                'connection_status' => 'online',
                'sync_status' => 'idle',
            ]
        );
    }

    /**
     * Match a pushed device PIN to an internal employee when a mapping exists.
     */
    private function findEmployeeMapping(AttendanceDevice $device, string $deviceUserCode): ?AttendanceDeviceUserMap
    {
        return AttendanceDeviceUserMap::query()
            ->where('attendance_device_id', $device->id)
            ->where('device_user_code', $deviceUserCode)
            ->where('status', 'active')
            ->first();
    }

    /**
     * Translate ZKTeco attendance status codes into the app's punch direction labels.
     */
    private function mapPunchType(string $status): string
    {
        return match ($status) {
            '0' => 'in',
            '1' => 'out',
            '2' => 'break_out',
            '3' => 'break_in',
            '4' => 'overtime_in',
            '5' => 'overtime_out',
            default => 'unknown',
        };
    }
}
