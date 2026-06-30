<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles() as $role) {
            Role::query()->updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }

    /**
     * Define legacy template roles and TMT business roles in one seed list.
     */
    private function roles(): array
    {
        return [
            ['name' => 'Admin', 'description' => 'This is the administration role'],
            ['name' => 'Creator', 'description' => 'This is the creator role'],
            ['name' => 'Member', 'description' => 'This is the member role'],
            ['name' => 'Super Admin', 'description' => 'Full system administration role'],
            ['name' => 'HR Manager', 'description' => 'Manages HR, attendance, reports, and timesheet operations'],
            ['name' => 'HR Staff', 'description' => 'Handles daily HR and attendance operations'],
            ['name' => 'Department Manager', 'description' => 'Reviews department attendance and reports'],
            ['name' => 'Employee', 'description' => 'Reviews personal attendance information'],
        ];
    }
}
