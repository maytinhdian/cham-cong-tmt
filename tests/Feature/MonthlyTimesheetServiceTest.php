<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Attendance\Models\DailyAttendanceResult;
use Modules\Attendance\Models\MonthlyTimesheet;
use Modules\Attendance\Services\MonthlyTimesheetService;
use Modules\User\Models\Employee;
use Tests\TestCase;

class MonthlyTimesheetServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It aggregates daily attendance results into one employee monthly row.
     */
    public function test_it_generates_monthly_timesheet_from_daily_results(): void
    {
        $employee = Employee::query()->create([
            'employee_code' => 'EMP-MONTH',
            'full_name' => 'Monthly Employee',
            'work_status' => 'active',
        ]);

        DailyAttendanceResult::query()->create([
            'employee_id' => $employee->id,
            'work_date' => '2026-06-01',
            'work_minutes' => 420,
            'break_minutes' => 30,
            'attendance_value' => 1,
            'late_minutes' => 5,
            'early_leave_minutes' => 0,
            'overtime_minutes' => 60,
            'missing_log_count' => 0,
            'status' => 'complete',
        ]);

        DailyAttendanceResult::query()->create([
            'employee_id' => $employee->id,
            'work_date' => '2026-06-02',
            'work_minutes' => 0,
            'break_minutes' => 0,
            'attendance_value' => 0,
            'late_minutes' => 0,
            'early_leave_minutes' => 0,
            'overtime_minutes' => 0,
            'missing_log_count' => 2,
            'status' => 'absent',
        ]);

        $generatedCount = app(MonthlyTimesheetService::class)->generate('2026-06');
        $monthlyTimesheet = MonthlyTimesheet::query()->first();

        $this->assertSame(1, $generatedCount);
        $this->assertSame('2026-06-01', $monthlyTimesheet->period_month->toDateString());
        $this->assertSame(2, $monthlyTimesheet->total_days);
        $this->assertSame(1, $monthlyTimesheet->work_days);
        $this->assertSame(1, $monthlyTimesheet->absent_days);
        $this->assertSame(2, $monthlyTimesheet->missing_log_count);
        $this->assertSame(420, $monthlyTimesheet->work_minutes);
        $this->assertSame('1.00', $monthlyTimesheet->attendance_value);
        $this->assertSame(60, $monthlyTimesheet->overtime_minutes);
        $this->assertSame('draft', $monthlyTimesheet->status);
    }
}
