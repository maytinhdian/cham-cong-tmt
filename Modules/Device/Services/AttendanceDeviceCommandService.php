<?php

namespace Modules\Device\Services;

use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceCommand;

class AttendanceDeviceCommandService
{
    /**
     * Queue a command that asks the device to check and upload new attendance logs.
     */
    public function queueLogSync(AttendanceDevice $device): AttendanceDeviceCommand
    {
        $command = AttendanceDeviceCommand::query()->create([
            'attendance_device_id' => $device->id,
            'command_key' => uniqid('log', true),
            'command' => 'LOG',
            'status' => 'pending',
        ]);

        $device->update(['sync_status' => 'syncing']);

        return $command;
    }

    /**
     * Return the next pending command in ZKTeco's getrequest text format.
     */
    public function dispatchNext(AttendanceDevice $device): ?string
    {
        $command = AttendanceDeviceCommand::query()
            ->where('attendance_device_id', $device->id)
            ->where('status', 'pending')
            ->oldest()
            ->first();

        if (! $command) {
            return null;
        }

        $command->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return 'C:' . $command->command_key . ':' . $command->command;
    }

    /**
     * Record command replies so operators can see whether the device accepted a sync request.
     */
    public function recordReplies(AttendanceDevice $device, string $payload): int
    {
        $count = 0;

        foreach (preg_split('/\r\n|\r|\n/', trim($payload)) ?: [] as $line) {
            parse_str(str_replace("\t", '&', trim($line)), $reply);

            if (! isset($reply['ID'])) {
                continue;
            }

            $updated = AttendanceDeviceCommand::query()
                ->where('attendance_device_id', $device->id)
                ->where('command_key', $reply['ID'])
                ->update([
                    'status' => ((string) ($reply['Return'] ?? '') === '0') ? 'acknowledged' : 'failed',
                    'responded_at' => now(),
                    'response_payload' => $reply,
                ]);

            $count += $updated;
        }

        if ($count > 0) {
            $device->update(['sync_status' => 'synced']);
        }

        return $count;
    }
}
