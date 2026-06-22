<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Modules\Attendance\DTOs\AttendanceRuleContext;
use Modules\Attendance\Engines\OvertimeCalculator;
use Modules\Shift\Models\Shift;
use PHPUnit\Framework\TestCase;

class OvertimeCalculatorTest extends TestCase
{
    /**
     * It counts early arrival as overtime only when the shift allows before-shift overtime.
     */
    public function test_it_counts_before_shift_overtime_when_enabled(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'overtime_before_shift_enabled' => true,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => false,
            'overtime_after_shift_min_minutes' => 0,
        ]);

        $minutes = $calculator->calculate(
            Carbon::parse('2026-06-20 07:15:00'),
            Carbon::parse('2026-06-20 17:00:00'),
            $shift,
            Carbon::parse('2026-06-20')
        );

        $this->assertSame(45, $minutes);
    }

    /**
     * It ignores after-shift overtime until the shift threshold is reached.
     */
    public function test_it_requires_after_shift_threshold_before_counting_overtime(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'overtime_before_shift_enabled' => false,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => true,
            'overtime_after_shift_min_minutes' => 30,
        ]);

        $underThreshold = $calculator->calculate(
            Carbon::parse('2026-06-20 08:00:00'),
            Carbon::parse('2026-06-20 17:20:00'),
            $shift,
            Carbon::parse('2026-06-20')
        );

        $atThreshold = $calculator->calculate(
            Carbon::parse('2026-06-20 08:00:00'),
            Carbon::parse('2026-06-20 17:30:00'),
            $shift,
            Carbon::parse('2026-06-20')
        );

        $this->assertSame(0, $underThreshold);
        $this->assertSame(30, $atThreshold);
    }

    /**
     * It ignores overtime after shift end when the shift switch is disabled.
     */
    public function test_it_ignores_after_shift_overtime_when_disabled(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'overtime_before_shift_enabled' => false,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => false,
            'overtime_after_shift_min_minutes' => 30,
        ]);

        $minutes = $calculator->calculate(
            Carbon::parse('2026-06-20 08:00:00'),
            Carbon::parse('2026-06-20 18:00:00'),
            $shift,
            Carbon::parse('2026-06-20')
        );

        $this->assertSame(0, $minutes);
    }

    /**
     * It can count deducted break minutes as overtime for shifts that enable the rule.
     */
    public function test_it_counts_break_minutes_as_overtime_when_enabled(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'break_as_overtime_enabled' => true,
            'overtime_before_shift_enabled' => false,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => false,
            'overtime_after_shift_min_minutes' => 0,
        ]);

        $minutes = $calculator->calculate(
            Carbon::parse('2026-06-20 08:00:00'),
            Carbon::parse('2026-06-20 17:00:00'),
            $shift,
            Carbon::parse('2026-06-20'),
            null,
            60
        );

        $this->assertSame(60, $minutes);
    }

    /**
     * It caps before-shift overtime with the saved company-wide limit.
     */
    public function test_it_limits_before_shift_overtime_with_global_rule(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'overtime_before_shift_enabled' => true,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => false,
            'overtime_after_shift_min_minutes' => 0,
        ]);

        $minutes = $calculator->calculate(
            Carbon::parse('2026-06-20 06:00:00'),
            Carbon::parse('2026-06-20 17:00:00'),
            $shift,
            Carbon::parse('2026-06-20'),
            $this->ruleContext([
                'limit_before_in_enabled' => true,
                'max_before_in_minutes' => 45,
            ])
        );

        $this->assertSame(45, $minutes);
    }

    /**
     * It caps after-shift overtime with the saved company-wide limit.
     */
    public function test_it_limits_after_shift_overtime_with_global_rule(): void
    {
        $calculator = new OvertimeCalculator();
        $shift = new Shift([
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'overtime_before_shift_enabled' => false,
            'overtime_before_shift_min_minutes' => 0,
            'overtime_after_shift_enabled' => true,
            'overtime_after_shift_min_minutes' => 0,
        ]);

        $minutes = $calculator->calculate(
            Carbon::parse('2026-06-20 08:00:00'),
            Carbon::parse('2026-06-20 19:00:00'),
            $shift,
            Carbon::parse('2026-06-20'),
            $this->ruleContext([
                'limit_after_out_enabled' => true,
                'max_after_out_minutes' => 60,
            ])
        );

        $this->assertSame(60, $minutes);
    }

    /**
     * Build attendance rules for focused overtime calculator tests.
     */
    private function ruleContext(array ...$overrides): AttendanceRuleContext
    {
        $values = array_replace([
            'standard_work_minutes' => 420,
            'late_threshold_minutes' => 0,
            'early_threshold_minutes' => 0,
            'no_in_enabled' => true,
            'no_in_policy' => 'late',
            'no_in_minutes' => 60,
            'no_out_enabled' => true,
            'no_out_policy' => 'early',
            'no_out_minutes' => 60,
            'late_absent_enabled' => false,
            'late_absent_minutes' => 100,
            'early_absent_enabled' => false,
            'early_absent_minutes' => 100,
            'min_overtime_minutes' => 0,
            'limit_before_in_enabled' => false,
            'max_before_in_minutes' => 60,
            'limit_after_out_enabled' => false,
            'max_after_out_minutes' => 60,
            'limit_total_overtime_enabled' => false,
            'max_total_overtime_minutes' => 120,
            'weekend_count_as_ot' => false,
            'two_day_shift_policy' => 'first_day',
        ], ...$overrides);

        return AttendanceRuleContext::fromValues($values);
    }
}
