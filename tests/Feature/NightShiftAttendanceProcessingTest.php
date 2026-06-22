<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Attendance\Engines\AttendanceEngine;
use Modules\Attendance\Models\AttendanceRule;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;
use Tests\TestCase;

class NightShiftAttendanceProcessingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Configure feature tests to use an isolated in-memory database.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
    }

    /**
     * It assigns the next-day checkout to the previous overnight work date.
     */
    public function test_it_keeps_next_day_checkout_on_previous_overnight_shift(): void
    {
        AttendanceRule::query()->create([
            'rule_key' => 'two_day_shift_policy',
            'rule_value' => 'first_day',
            'rule_type' => 'string',
            'group_key' => 'matching',
            'sort_order' => 80,
            'status' => 'active',
        ]);

        [$employee] = $this->createNightShiftScenario();

        $engine = app(AttendanceEngine::class);
        $nightResult = $engine->processEmployeeDay($employee, Carbon::parse('2026-06-05'));
        $nextDayResult = $engine->processEmployeeDay($employee, Carbon::parse('2026-06-06'));

        $this->assertSame('2026-06-05 22:00:00', $nightResult->clock_in_at?->format('Y-m-d H:i:s'));
        $this->assertSame('2026-06-06 06:00:00', $nightResult->clock_out_at?->format('Y-m-d H:i:s'));
        $this->assertSame(480, $nightResult->work_minutes);
        $this->assertSame('complete', $nightResult->status);

        $this->assertNull($nextDayResult->clock_in_at);
        $this->assertNull($nextDayResult->clock_out_at);
        $this->assertSame('no_schedule', $nextDayResult->status);
    }

    /**
     * It can record an overnight shift on the second calendar day when configured.
     */
    public function test_it_records_overnight_shift_on_second_day_by_default(): void
    {
        [$employee] = $this->createNightShiftScenario();

        $resultFromStartDate = app(AttendanceEngine::class)
            ->processEmployeeDay($employee, Carbon::parse('2026-06-05'));
        $resultFromSecondDate = app(AttendanceEngine::class)
            ->processEmployeeDay($employee, Carbon::parse('2026-06-06'));

        $this->assertSame('2026-06-06', $resultFromStartDate->work_date->toDateString());
        $this->assertSame($resultFromStartDate->id, $resultFromSecondDate->id);
        $this->assertSame('2026-06-05 22:00:00', $resultFromSecondDate->clock_in_at?->format('Y-m-d H:i:s'));
        $this->assertSame('2026-06-06 06:00:00', $resultFromSecondDate->clock_out_at?->format('Y-m-d H:i:s'));
        $this->assertSame(480, $resultFromSecondDate->work_minutes);
        $this->assertSame('complete', $resultFromSecondDate->status);
        $this->assertFalse(DailyAttendanceResult::query()->whereDate('work_date', '2026-06-05')->exists());
    }

    /**
     * Create an employee with one 22:00-06:00 scheduled shift and matching logs.
     */
    private function createNightShiftScenario(): array
    {
        $employee = Employee::query()->create([
            'employee_code' => 'EMP-NIGHT',
            'full_name' => 'Night Shift Employee',
            'work_status' => 'active',
        ]);

        $shift = Shift::query()->create([
            'code' => 'NIGHT',
            'name' => 'Night shift',
            'start_time' => '22:00:00',
            'end_time' => '06:00:00',
            'clock_in_from' => '21:30:00',
            'clock_out_to' => '06:30:00',
            'max_late_minutes' => 0,
            'max_early_leave_minutes' => 0,
            'workday_value' => 1,
            'standard_work_minutes' => 480,
            'requires_clock_in' => true,
            'requires_clock_out' => true,
            'display_color' => '#22c55e',
            'status' => 'active',
        ]);

        EmployeeSchedule::query()->create([
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'work_date' => '2026-06-05',
            'schedule_type' => 'work',
            'status' => 'approved',
        ]);

        RawAttendanceLog::query()->create([
            'employee_id' => $employee->id,
            'device_user_code' => 'EMP-NIGHT',
            'punch_time' => '2026-06-05 22:00:00',
            'punch_type' => 'in',
            'source' => 'manual',
            'processing_status' => 'pending',
        ]);

        RawAttendanceLog::query()->create([
            'employee_id' => $employee->id,
            'device_user_code' => 'EMP-NIGHT',
            'punch_time' => '2026-06-06 06:00:00',
            'punch_type' => 'out',
            'source' => 'manual',
            'processing_status' => 'pending',
        ]);

        return [$employee, $shift];
    }
}
