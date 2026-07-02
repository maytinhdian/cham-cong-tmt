<?php

namespace Modules\Device\Services;

use Illuminate\Support\Str;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceCommand;

class AttendanceDeviceCommandService
{
    /**
     * Queue any PUSH command so device operations stay inside the getrequest flow.
     */
    public function queuePushCommand(AttendanceDevice $device, string $command, ?string $payload = null): AttendanceDeviceCommand
    {
        $queuedCommand = AttendanceDeviceCommand::query()->create([
            'attendance_device_id' => $device->id,
            'command_key' => $this->makeCommandKey(),
            'command' => $command,
            'payload' => $payload,
            'status' => 'pending',
        ]);

        $device->update(['sync_status' => 'syncing']);

        return $queuedCommand;
    }

    /**
     * Queue a command that asks the device to check and upload new attendance logs.
     */
    public function queueLogSync(AttendanceDevice $device): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'LOG');
    }

    /**
     * Queue a time-range ATTLOG query so the device uploads matching attendance records.
     */
    public function queueAttendanceLogQuery(AttendanceDevice $device, string $startTime, string $endTime): AttendanceDeviceCommand
    {
        return $this->queuePushCommand(
            $device,
            'DATA QUERY ATTLOG',
            "StartTime={$startTime}\tEndTime={$endTime}"
        );
    }

    /**
     * Queue a command that asks the device to reload options and resend data by stamp rules.
     */
    public function queueCheckSync(AttendanceDevice $device): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'CHECK');
    }

    /**
     * Queue a command that asks the device to reload its PUSH option set.
     */
    public function queueReloadOptions(AttendanceDevice $device): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'RELOAD OPTIONS');
    }

    /**
     * Queue a single device option update through the PUSH protocol.
     */
    public function queueSetOption(AttendanceDevice $device, string $key, string $value): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'SET OPTION', "{$key}={$value}");
    }

    /**
     * Queue a BIODATA query for template testing by type and optional person fields.
     */
    public function queueBiodataQuery(AttendanceDevice $device, string $type, ?string $pin = null, ?string $number = null): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'DATA QUERY BIODATA', $this->biodataPayload($type, $pin, $number));
    }

    /**
     * Queue a command that deletes one user record from a PUSH attendance device.
     */
    public function queueDeleteUserInfo(AttendanceDevice $device, string $pin): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'DATA DELETE USERINFO', 'PIN=' . $pin);
    }

    /**
     * Queue a PUSH command that asks the device to delete all local user records.
     */
    public function queueDeleteAllUsers(AttendanceDevice $device): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'DATA DELETE USERINFO');
    }

    /**
     * Queue a command that deletes BIODATA templates by PIN and optional biometric filters.
     */
    public function queueDeleteBiodata(AttendanceDevice $device, string $pin, ?string $type = null, ?string $number = null): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'DATA DELETE BIODATA', $this->biodataDeletePayload($pin, $type, $number));
    }

    /**
     * Queue a command that clears all unified biometric templates on the device.
     */
    public function queueClearBiodata(AttendanceDevice $device): AttendanceDeviceCommand
    {
        return $this->queuePushCommand($device, 'CLEAR BIODATA');
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

        $payload = trim((string) $command->payload);
        $commandText = trim($command->command . ($payload !== '' ? ' ' . $payload : ''));

        return 'C: ' . $command->command_key . ': ' . $commandText;
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

    /**
     * Generate a compact protocol-safe command id for device acknowledgement.
     */
    private function makeCommandKey(): string
    {
        do {
            $key = strtoupper(Str::random(12));
        } while (AttendanceDeviceCommand::query()->where('command_key', $key)->exists());

        return $key;
    }

    /**
     * Build tab-separated BIODATA command conditions for query and delete operations.
     */
    private function biodataPayload(?string $type = null, ?string $pin = null, ?string $number = null): string
    {
        return collect([
            $type ? 'Type=' . $type : null,
            $pin ? 'PIN=' . $pin : null,
            $number ? 'No=' . $number : null,
        ])->filter()->implode("\t");
    }

    /**
     * Build tab-separated BIODATA delete conditions in the documented PIN-first order.
     */
    private function biodataDeletePayload(string $pin, ?string $type = null, ?string $number = null): string
    {
        return collect([
            'Pin=' . $pin,
            $type ? 'Type=' . $type : null,
            $number ? 'No=' . $number : null,
        ])->filter()->implode("\t");
    }
}
