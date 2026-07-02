<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Device\Models\AttendanceDevice;
use Modules\Device\Models\AttendanceDeviceCommand;
use Modules\Device\Models\AttendanceDeviceUserMap;
use Modules\Device\Services\AttendanceDeviceCommandService;
use Modules\User\Models\Employee;
use Tests\TestCase;

class ZktecoPushProtocolTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It returns PUSH options that instruct the device to upload attendance logs.
     */
    public function test_it_returns_zkteco_push_options(): void
    {
        $response = $this->get('/iclock/cdata?SN=DEV-PUSH-01&options=all&pushver=2.4.1');

        $response->assertOk();
        $response->assertSeeText('GET OPTION FROM: DEV-PUSH-01');
        $response->assertSeeText('TransFlag=TransData AttLog');
        $response->assertSeeText('Realtime=1');

        $this->assertDatabaseHas('attendance_devices', [
            'code' => 'DEV-PUSH-01',
            'connection_status' => 'online',
        ]);
    }

    /**
     * It stores pushed ATTLOG lines as raw attendance logs for later processing.
     */
    public function test_it_imports_attendance_logs_pushed_by_device(): void
    {
        $device = AttendanceDevice::query()->create([
            'code' => 'DEV-PUSH-02',
            'name' => 'Main Gate',
            'device_type' => 'zkteco',
        ]);
        $employee = Employee::query()->create([
            'employee_code' => 'EMP-PUSH',
            'full_name' => 'Push Employee',
            'work_status' => 'active',
        ]);
        AttendanceDeviceUserMap::query()->create([
            'attendance_device_id' => $device->id,
            'employee_id' => $employee->id,
            'device_user_code' => '1452',
            'status' => 'active',
        ]);

        $payload = implode("\n", [
            "1452\t2015-07-30 15:16:28\t0\t1\t0\t0\t0",
            "1452\t2015-07-30 18:02:01\t1\t1\t0\t0\t0",
        ]);

        $response = $this->call('POST', '/iclock/cdata?SN=DEV-PUSH-02&table=ATTLOG&Stamp=9999', [], [], [], [], $payload);

        $response->assertOk();
        $response->assertSeeText('OK: 2');

        $this->assertSame(2, RawAttendanceLog::query()->count());
        $this->assertDatabaseHas('raw_attendance_logs', [
            'attendance_device_id' => $device->id,
            'employee_id' => $employee->id,
            'device_user_code' => '1452',
            'punch_time' => '2015-07-30 15:16:28',
            'punch_type' => 'in',
            'verify_type' => 'fingerprint',
            'source' => 'zkteco_push',
            'processing_status' => 'pending',
        ]);
        $this->assertDatabaseHas('raw_attendance_logs', [
            'attendance_device_id' => $device->id,
            'employee_id' => $employee->id,
            'device_user_code' => '1452',
            'punch_time' => '2015-07-30 18:02:01',
            'punch_type' => 'out',
        ]);
    }

    /**
     * It dispatches a queued LOG command when the device polls getrequest.
     */
    public function test_it_dispatches_queued_log_command_to_device(): void
    {
        $device = AttendanceDevice::query()->create([
            'code' => 'DEV-PUSH-03',
            'name' => 'Warehouse Gate',
            'device_type' => 'zkteco',
        ]);

        $command = app(AttendanceDeviceCommandService::class)->queueLogSync($device);

        $response = $this->get('/iclock/getrequest?SN=DEV-PUSH-03');

        $response->assertOk();
        $response->assertSeeText('C: ' . $command->command_key . ': LOG');
        $this->assertMatchesRegularExpression('/^[A-Z0-9]{12}$/', $command->command_key);

        $this->assertDatabaseHas('attendance_device_commands', [
            'id' => $command->id,
            'status' => 'sent',
        ]);

        $reply = 'ID=' . $command->command_key . '&Return=0&CMD=LOG';
        $this->call('POST', '/iclock/devicecmd?SN=DEV-PUSH-03', [], [], [], [], $reply)->assertOk();

        $this->assertSame('acknowledged', AttendanceDeviceCommand::query()->find($command->id)->status);
    }

    /**
     * It dispatches a queued ATTLOG range query using the ZKTeco DATA command format.
     */
    public function test_it_dispatches_attlog_range_query_to_device(): void
    {
        $device = AttendanceDevice::query()->create([
            'code' => 'DEV-PUSH-04',
            'name' => 'Factory Gate',
            'device_type' => 'zkteco',
        ]);

        $command = app(AttendanceDeviceCommandService::class)->queueAttendanceLogQuery(
            $device,
            '2026-07-01 00:00:00',
            '2026-07-31 23:59:59'
        );

        $response = $this->get('/iclock/getrequest?SN=DEV-PUSH-04');

        $response->assertOk();
        $response->assertSeeText('C: ' . $command->command_key . ': DATA QUERY ATTLOG StartTime=2026-07-01 00:00:00');
        $response->assertSeeText("EndTime=2026-07-31 23:59:59");

        $this->assertDatabaseHas('attendance_device_commands', [
            'id' => $command->id,
            'command' => 'DATA QUERY ATTLOG',
            'payload' => "StartTime=2026-07-01 00:00:00\tEndTime=2026-07-31 23:59:59",
            'status' => 'sent',
        ]);
    }

    /**
     * It dispatches queued destructive device commands in documented PUSH format.
     */
    public function test_it_dispatches_destructive_device_commands(): void
    {
        $device = AttendanceDevice::query()->create([
            'code' => 'DEV-PUSH-05',
            'name' => 'Office Gate',
            'device_type' => 'zkteco',
        ]);

        $commandService = app(AttendanceDeviceCommandService::class);
        $deleteUser = $commandService->queueDeleteUserInfo($device, '1452');
        $deleteBiodata = $commandService->queueDeleteBiodata($device, '1452', '1', '2');
        $clearBiodata = $commandService->queueClearBiodata($device);

        $firstResponse = $this->get('/iclock/getrequest?SN=DEV-PUSH-05');
        $firstResponse->assertOk();
        $firstResponse->assertSeeText('C: ' . $deleteUser->command_key . ': DATA DELETE USERINFO PIN=1452');

        $secondResponse = $this->get('/iclock/getrequest?SN=DEV-PUSH-05');
        $secondResponse->assertOk();
        $secondResponse->assertSeeText('C: ' . $deleteBiodata->command_key . ': DATA DELETE BIODATA Pin=1452');
        $secondResponse->assertSeeText('Type=1');
        $secondResponse->assertSeeText('No=2');

        $thirdResponse = $this->get('/iclock/getrequest?SN=DEV-PUSH-05');
        $thirdResponse->assertOk();
        $thirdResponse->assertSeeText('C: ' . $clearBiodata->command_key . ': CLEAR BIODATA');
    }
}
