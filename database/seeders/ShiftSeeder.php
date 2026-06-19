<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shift\Models\Shift;
use Modules\Shift\Models\ShiftBreak;
use Modules\Shift\Models\ShiftRule;

class ShiftSeeder extends Seeder
{
    /**
     * Seed standard shifts together with their break and rule records.
     */
    public function run(): void
    {
        $shifts = [
            [
                'code' => 'DAY_12H',
                'name' => 'Ca ngày 12 tiếng',
                'start_time' => '07:00',
                'end_time' => '19:00',
                'break_start_time' => '11:30',
                'break_end_time' => '12:30',
                'break_minutes' => 60,
                'clock_in_from' => '06:30',
                'clock_in_to' => '07:30',
                'clock_out_from' => '18:30',
                'clock_out_to' => '19:30',
                'max_late_minutes' => 5,
                'max_early_leave_minutes' => 5,
                'workday_value' => 1,
                'standard_work_minutes' => 480,
                'display_color' => '#3b82f6',
                'description' => 'Ca ngày cho bộ phận sản xuất.',
            ],
            [
                'code' => 'NIGHT_12H',
                'name' => 'Ca đêm 12 tiếng',
                'start_time' => '19:00',
                'end_time' => '07:00',
                'break_start_time' => '23:30',
                'break_end_time' => '00:30',
                'break_minutes' => 60,
                'clock_in_from' => '18:30',
                'clock_in_to' => '19:30',
                'clock_out_from' => '06:30',
                'clock_out_to' => '07:30',
                'max_late_minutes' => 5,
                'max_early_leave_minutes' => 5,
                'workday_value' => 1,
                'standard_work_minutes' => 480,
                'display_color' => '#111827',
                'description' => 'Ca đêm qua ngày cho bộ phận sản xuất.',
            ],
            [
                'code' => 'HC',
                'name' => 'Ca hành chính',
                'start_time' => '08:00',
                'end_time' => '17:30',
                'break_start_time' => '12:00',
                'break_end_time' => '13:00',
                'break_minutes' => 60,
                'clock_in_from' => '07:45',
                'clock_in_to' => '08:15',
                'clock_out_from' => '17:15',
                'clock_out_to' => '18:00',
                'max_late_minutes' => 5,
                'max_early_leave_minutes' => 5,
                'workday_value' => 1,
                'standard_work_minutes' => 480,
                'display_color' => '#0ea5e9',
                'description' => 'Ca hành chính cho khối văn phòng.',
            ],
        ];

        foreach ($shifts as $shift) {
            $shiftModel = Shift::query()->updateOrCreate(
                ['code' => $shift['code']],
                $shift + [
                    'requires_clock_in' => true,
                    'requires_clock_out' => true,
                    'status' => 'active',
                ]
            );

            ShiftBreak::query()->updateOrCreate(
                ['shift_id' => $shiftModel->id, 'name' => 'Lunch break'],
                [
                    'start_time' => $shift['break_start_time'],
                    'end_time' => $shift['break_end_time'],
                    'break_minutes' => $shift['break_minutes'],
                    'is_paid' => true,
                    'status' => 'active',
                    'description' => 'Bá»¯a nghá»‰ trÆ°a tiÃªu chuáº©n cho ca lÃ m viá»‡c.',
                ]
            );

            $rules = [
                ['late_grace_minutes', (string) $shift['max_late_minutes'], 'integer', 10],
                ['early_leave_grace_minutes', (string) $shift['max_early_leave_minutes'], 'integer', 20],
                ['standard_work_minutes', (string) $shift['standard_work_minutes'], 'integer', 30],
                ['requires_clock_in', $shiftModel->requires_clock_in ? '1' : '0', 'boolean', 40],
                ['requires_clock_out', $shiftModel->requires_clock_out ? '1' : '0', 'boolean', 50],
            ];

            foreach ($rules as [$ruleKey, $ruleValue, $ruleType, $sortOrder]) {
                ShiftRule::query()->updateOrCreate(
                    ['shift_id' => $shiftModel->id, 'rule_key' => $ruleKey],
                    [
                        'rule_value' => $ruleValue,
                        'rule_type' => $ruleType,
                        'sort_order' => $sortOrder,
                        'status' => 'active',
                        'description' => 'Quy táº¯c khá»›i táº¡o cho ca lÃ m viá»‡c.',
                    ]
                );
            }
        }
    }
}
