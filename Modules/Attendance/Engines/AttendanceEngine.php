<?php

namespace Modules\Attendance\Engines;

class AttendanceEngine
{
    public function __construct(
        private readonly ShiftMatcher $shiftMatcher,
        private readonly WorkHourCalculator $workHourCalculator,
        private readonly LateCalculator $lateCalculator,
        private readonly OvertimeCalculator $overtimeCalculator,
    ) {
    }
}
