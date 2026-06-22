<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Modules\Attendance\Models\AttendanceRule;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\MonthlyTimesheet;
use Modules\Attendance\Models\RawAttendanceLog;
use Modules\Attendance\Services\AttendanceProcessingService;
use Modules\Attendance\Services\MonthlyTimesheetService;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\Schedule\DTOs\EmployeeScheduleData;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Schedule\Services\EmployeeScheduleService;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;
use RuntimeException;

class TestAttendanceDataSeeder extends Seeder
{
    /**
     * Seed reusable employees, schedules, and raw logs for attendance testing.
     */
    public function run(): void
    {
        $departments = Department::query()->whereIn('code', ['HR', 'PROD', 'TECH'])->get()->keyBy('code');
        $staffPosition = Position::query()->where('code', 'STAFF')->first();
        $leaderPosition = Position::query()->where('code', 'LEADER')->first() ?: $staffPosition;
        $shifts = Shift::query()->whereIn('code', ['HC', 'DAY_12H', 'NIGHT_12H'])->get()->keyBy('code');

        if ($departments->count() < 3 || ! $staffPosition || $shifts->count() < 3) {
            throw new RuntimeException('Missing department, position, or shift seed data.');
        }

        $employeeInputs = [
            ['code' => 'TEST-001', 'name' => 'Nguyen Van An', 'department' => 'HR', 'position_id' => $staffPosition->id, 'shift' => 'HC'],
            ['code' => 'TEST-002', 'name' => 'Tran Thi Binh', 'department' => 'TECH', 'position_id' => $leaderPosition->id, 'shift' => 'HC'],
            ['code' => 'TEST-003', 'name' => 'Le Minh Chau', 'department' => 'PROD', 'position_id' => $staffPosition->id, 'shift' => 'DAY_12H'],
            ['code' => 'TEST-004', 'name' => 'Pham Quoc Dung', 'department' => 'PROD', 'position_id' => $staffPosition->id, 'shift' => 'DAY_12H'],
            ['code' => 'TEST-005', 'name' => 'Hoang Thi Ha', 'department' => 'PROD', 'position_id' => $staffPosition->id, 'shift' => 'NIGHT_12H'],
            ['code' => 'TEST-006', 'name' => 'Do Thanh Khoa', 'department' => 'PROD', 'position_id' => $staffPosition->id, 'shift' => 'NIGHT_12H'],
        ];

        $employees = $this->seedEmployees($employeeInputs, $departments);
        $this->clearAttendanceTestData($employees->pluck('id')->all());
        $this->useSecondDayOvernightPolicy();
        $this->seedSchedules($employeeInputs, $employees, $shifts);
        $this->seedRawLogs($employeeInputs, $employees);

        foreach ($employees as $employee) {
            app(AttendanceProcessingService::class)->processDateRange('2026-06-01', '2026-06-22', $employee->id);
        }

        app(MonthlyTimesheetService::class)->generate('2026-06');

        $this->command?->info('Seeded attendance test data for TEST-001 to TEST-006.');
        $this->command?->info('Schedules: '.EmployeeSchedule::query()->whereIn('employee_id', $employees->pluck('id'))->count());
        $this->command?->info('Raw logs: '.RawAttendanceLog::query()->whereIn('employee_id', $employees->pluck('id'))->count());
        $this->command?->info('Daily results: '.DailyAttendanceResult::query()->whereIn('employee_id', $employees->pluck('id'))->count());
    }

    /**
     * Remove generated attendance rows so the seeder can be run repeatedly.
     */
    private function clearAttendanceTestData(array $employeeIds): void
    {
        MonthlyTimesheet::query()->whereIn('employee_id', $employeeIds)->delete();
        DailyAttendanceResult::query()->whereIn('employee_id', $employeeIds)->delete();
        RawAttendanceLog::query()->whereIn('employee_id', $employeeIds)->where('source', 'test_seed')->delete();
        EmployeeSchedule::query()->whereIn('employee_id', $employeeIds)->delete();
    }

    /**
     * Keep the seeded overnight shifts aligned with the selected business policy.
     */
    private function useSecondDayOvernightPolicy(): void
    {
        AttendanceRule::query()->updateOrCreate(
            ['rule_key' => 'two_day_shift_policy'],
            [
                'rule_value' => 'second_day',
                'rule_type' => 'string',
                'group_key' => 'matching',
                'sort_order' => 80,
                'status' => 'active',
                'description' => 'Cach ghi nhan ca keo dai qua hai ngay.',
            ]
        );
    }

    /**
     * Create or update the employees used by attendance test scenarios.
     */
    private function seedEmployees(array $employeeInputs, $departments)
    {
        return collect($employeeInputs)
            ->mapWithKeys(function (array $item) use ($departments) {
                $employee = Employee::query()->updateOrCreate(
                    ['employee_code' => $item['code']],
                    [
                        'department_id' => $departments[$item['department']]->id,
                        'position_id' => $item['position_id'],
                        'full_name' => $item['name'],
                        'email' => strtolower(str_replace('-', '', $item['code'])).'@tmt.test',
                        'phone' => '090'.substr($item['code'], -3).'000',
                        'gender' => str_contains($item['name'], 'Thi') ? 'female' : 'male',
                        'hire_date' => '2026-06-01',
                        'work_status' => 'active',
                        'note' => 'Nhan vien test du lieu cham cong thang 06/2026.',
                    ]
                );

                return [$item['code'] => $employee];
            });
    }

    /**
     * Assign approved schedules for the reusable June 2026 test period.
     */
    private function seedSchedules(array $employeeInputs, $employees, $shifts): void
    {
        $scheduleService = app(EmployeeScheduleService::class);

        foreach (CarbonPeriod::create('2026-06-01', '2026-06-21') as $date) {
            if ($date->isSunday()) {
                continue;
            }

            foreach ($employeeInputs as $item) {
                $scheduleService->assign(new EmployeeScheduleData(
                    employeeId: $employees[$item['code']]->id,
                    shiftId: $shifts[$item['shift']]->id,
                    workDate: $date->toDateString(),
                    scheduleType: 'work',
                    status: 'approved',
                    note: 'Lich test tu dong cho thang 06/2026.'
                ));
            }
        }
    }

    /**
     * Create raw punch logs with complete, late, early, missing, absent, and night-shift cases.
     */
    private function seedRawLogs(array $employeeInputs, $employees): void
    {
        foreach (CarbonPeriod::create('2026-06-01', '2026-06-21') as $date) {
            if ($date->isSunday()) {
                continue;
            }

            $day = (int) $date->format('d');

            foreach ($employeeInputs as $item) {
                $employee = $employees[$item['code']];

                if ($item['code'] === 'TEST-004' && in_array($day, [8, 15], true)) {
                    continue;
                }

                if ($item['shift'] === 'HC') {
                    $in = $item['code'] === 'TEST-001' && in_array($day, [3, 10, 17], true) ? '08:22:00' : '08:00:00';
                    $out = $item['code'] === 'TEST-002' && in_array($day, [5, 12], true) ? '17:00:00' : '17:30:00';

                    $this->punch($employee->id, $item['code'], $date->toDateString().' '.$in, 'in');
                    $this->punch($employee->id, $item['code'], $date->toDateString().' '.$out, 'out');
                    continue;
                }

                if ($item['shift'] === 'DAY_12H') {
                    if ($item['code'] === 'TEST-004' && $day === 6) {
                        $this->punch($employee->id, $item['code'], $date->toDateString().' 07:00:00', 'in', 'Intentional missing checkout for test.');
                        continue;
                    }

                    $out = $item['code'] === 'TEST-003' && in_array($day, [4, 11, 18], true) ? '20:30:00' : '19:00:00';

                    $this->punch($employee->id, $item['code'], $date->toDateString().' 07:00:00', 'in');
                    $this->punch($employee->id, $item['code'], $date->toDateString().' '.$out, 'out');
                    continue;
                }

                if ($item['shift'] === 'NIGHT_12H') {
                    if ($item['code'] === 'TEST-006' && $day === 13) {
                        $this->punch($employee->id, $item['code'], $date->toDateString().' 19:00:00', 'in', 'Intentional missing night checkout for test.');
                        continue;
                    }

                    $in = $item['code'] === 'TEST-005' && in_array($day, [2, 9, 16], true) ? '18:15:00' : '19:00:00';

                    $this->punch($employee->id, $item['code'], $date->toDateString().' '.$in, 'in');
                    $this->punch($employee->id, $item['code'], $date->copy()->addDay()->toDateString().' 07:00:00', 'out');
                }
            }
        }
    }

    /**
     * Create or update one raw punch log for a test employee.
     */
    private function punch(int $employeeId, string $employeeCode, string $time, string $type, ?string $note = null): void
    {
        RawAttendanceLog::query()->create([
            'attendance_device_id' => null,
            'employee_id' => $employeeId,
            'device_user_code' => $employeeCode,
            'punch_time' => Carbon::parse($time),
            'punch_type' => $type,
            'verify_type' => 'fingerprint',
            'source' => 'test_seed',
            'processing_status' => 'pending',
            'note' => $note,
            'raw_payload' => ['seed' => 'test-attendance-2026-06'],
        ]);
    }
}
