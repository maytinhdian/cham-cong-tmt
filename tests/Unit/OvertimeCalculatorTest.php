<?php

namespace Tests\Unit;

use Carbon\Carbon;
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
}
