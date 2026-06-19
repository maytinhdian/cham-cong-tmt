<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shift\Models\Shift;

class ShiftSeeder extends Seeder
{
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
            Shift::query()->updateOrCreate(
                ['code' => $shift['code']],
                $shift + [
                    'requires_clock_in' => true,
                    'requires_clock_out' => true,
                    'status' => 'active',
                ]
            );
        }
    }
}
