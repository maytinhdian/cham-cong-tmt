<?php

namespace Modules\Attendance\DTOs;

class AttendanceRuleContext
{
    public function __construct(
        public int $standardWorkMinutes,
        public int $lateThresholdMinutes,
        public int $earlyThresholdMinutes,
        public bool $noInEnabled,
        public string $noInPolicy,
        public int $noInMinutes,
        public bool $noOutEnabled,
        public string $noOutPolicy,
        public int $noOutMinutes,
        public bool $lateAbsentEnabled,
        public int $lateAbsentMinutes,
        public bool $earlyAbsentEnabled,
        public int $earlyAbsentMinutes,
        public int $minOvertimeMinutes,
        public bool $limitTotalOvertimeEnabled,
        public int $maxTotalOvertimeMinutes,
        public bool $weekendCountAsOt,
    ) {
    }

    /**
     * Build typed attendance processing rules from saved settings.
     */
    public static function fromValues(array $rules): self
    {
        return new self(
            standardWorkMinutes: (int) $rules['standard_work_minutes'],
            lateThresholdMinutes: (int) $rules['late_threshold_minutes'],
            earlyThresholdMinutes: (int) $rules['early_threshold_minutes'],
            noInEnabled: (bool) $rules['no_in_enabled'],
            noInPolicy: (string) $rules['no_in_policy'],
            noInMinutes: (int) $rules['no_in_minutes'],
            noOutEnabled: (bool) $rules['no_out_enabled'],
            noOutPolicy: (string) $rules['no_out_policy'],
            noOutMinutes: (int) $rules['no_out_minutes'],
            lateAbsentEnabled: (bool) $rules['late_absent_enabled'],
            lateAbsentMinutes: (int) $rules['late_absent_minutes'],
            earlyAbsentEnabled: (bool) $rules['early_absent_enabled'],
            earlyAbsentMinutes: (int) $rules['early_absent_minutes'],
            minOvertimeMinutes: (int) $rules['min_overtime_minutes'],
            limitTotalOvertimeEnabled: (bool) $rules['limit_total_overtime_enabled'],
            maxTotalOvertimeMinutes: (int) $rules['max_total_overtime_minutes'],
            weekendCountAsOt: (bool) $rules['weekend_count_as_ot'],
        );
    }
}
