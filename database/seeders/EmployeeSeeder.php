<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Org\Models\Department;
use Modules\Org\Models\Position;
use Modules\User\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::query()->pluck('id', 'code');
        $positions = Position::query()->pluck('id', 'code');

        $employees = [
            [
                'employee_code' => 'EMP-001',
                'full_name' => 'Nguyễn Minh Quân',
                'email' => 'quan.nguyen@tmt.local',
                'phone' => '0901000001',
                'gender' => 'male',
                'hire_date' => '2024-01-15',
                'department_code' => 'BOD',
                'position_code' => 'CEO',
            ],
            [
                'employee_code' => 'EMP-002',
                'full_name' => 'Trần Thu Hà',
                'email' => 'ha.tran@tmt.local',
                'phone' => '0901000002',
                'gender' => 'female',
                'hire_date' => '2024-03-01',
                'department_code' => 'HR',
                'position_code' => 'MANAGER',
            ],
            [
                'employee_code' => 'EMP-003',
                'full_name' => 'Lê Quốc Bảo',
                'email' => 'bao.le@tmt.local',
                'phone' => '0901000003',
                'gender' => 'male',
                'hire_date' => '2024-05-20',
                'department_code' => 'PROD',
                'position_code' => 'LEADER',
            ],
            [
                'employee_code' => 'EMP-004',
                'full_name' => 'Phạm Thị Mai',
                'email' => 'mai.pham@tmt.local',
                'phone' => '0901000004',
                'gender' => 'female',
                'hire_date' => '2024-08-05',
                'department_code' => 'TECH',
                'position_code' => 'STAFF',
            ],
        ];

        foreach ($employees as $employee) {
            $departmentCode = $employee['department_code'];
            $positionCode = $employee['position_code'];

            unset($employee['department_code'], $employee['position_code']);

            Employee::query()->updateOrCreate(
                ['employee_code' => $employee['employee_code']],
                $employee + [
                    'department_id' => $departments[$departmentCode] ?? null,
                    'position_id' => $positions[$positionCode] ?? null,
                    'work_status' => 'active',
                ]
            );
        }
    }
}
