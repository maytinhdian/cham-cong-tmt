<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;
use Modules\Org\Models\Department;
use Modules\User\Models\Employee;

class Index extends Component
{
    public function render()
    {
        return view('livewire.pages.employees.index', [
            'employees' => Employee::query()
                ->with(['department', 'position'])
                ->orderBy('employee_code')
                ->get(),
            'departments' => Department::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
