<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;
use Modules\User\Models\Employee;

class Detail extends Component
{
    public Employee $employee;

    public function mount(Employee $employee): void
    {
        $this->employee = $employee->load(['department', 'position']);
    }

    public function render()
    {
        return view('livewire.pages.employees.detail', [
            'employee' => $this->employee,
        ]);
    }
}
