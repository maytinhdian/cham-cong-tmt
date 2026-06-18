<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Org\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            [
                'code' => 'CEO',
                'name' => 'Giám đốc',
                'level' => 'Executive',
                'sort_order' => 1,
            ],
            [
                'code' => 'MANAGER',
                'name' => 'Trưởng phòng',
                'level' => 'Manager',
                'sort_order' => 2,
            ],
            [
                'code' => 'LEADER',
                'name' => 'Tổ trưởng',
                'level' => 'Lead',
                'sort_order' => 3,
            ],
            [
                'code' => 'STAFF',
                'name' => 'Nhân viên',
                'level' => 'Staff',
                'sort_order' => 4,
            ],
        ];

        foreach ($positions as $position) {
            Position::query()->updateOrCreate(
                ['code' => $position['code']],
                $position + ['status' => 'active']
            );
        }
    }
}
