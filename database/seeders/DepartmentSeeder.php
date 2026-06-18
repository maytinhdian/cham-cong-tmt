<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Org\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'code' => 'BOD',
                'name' => 'Ban giám đốc',
                'manager_name' => 'Nguyễn Minh Quân',
                'sort_order' => 1,
                'description' => 'Điều hành chung toàn công ty.',
            ],
            [
                'code' => 'HR',
                'name' => 'Nhân sự',
                'manager_name' => 'Trần Thu Hà',
                'sort_order' => 2,
                'description' => 'Quản lý hồ sơ nhân sự, chấm công và chính sách lao động.',
            ],
            [
                'code' => 'PROD',
                'name' => 'Sản xuất',
                'manager_name' => 'Lê Quốc Bảo',
                'sort_order' => 3,
                'description' => 'Vận hành sản xuất theo ca.',
            ],
            [
                'code' => 'TECH',
                'name' => 'Công nghệ',
                'manager_name' => 'Phạm Hoàng Nam',
                'sort_order' => 4,
                'description' => 'Quản lý hệ thống và dữ liệu nội bộ.',
            ],
        ];

        foreach ($departments as $department) {
            Department::query()->updateOrCreate(
                ['code' => $department['code']],
                $department + ['status' => 'active']
            );
        }
    }
}
