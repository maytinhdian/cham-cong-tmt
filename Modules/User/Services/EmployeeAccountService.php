<?php

namespace Modules\User\Services;

use App\Models\Role;
use App\Models\User;
use Modules\Core\Services\ActivityLogger;
use Modules\User\Models\Employee;

class EmployeeAccountService
{
    /**
     * Create or update the login account linked to one employee profile.
     */
    public function provision(Employee $employee, string $password, ?int $roleId = null): User
    {
        $roleId = $roleId ?: $this->memberRoleId();
        $account = $employee->account ?: new User();

        $account->fill([
            'name' => $employee->full_name,
            'email' => $this->accountEmail($employee, $account),
            'username' => $employee->employee_code,
            'password' => $password,
            'role_id' => $roleId,
            'phone' => $employee->phone,
        ]);

        $account->save();

        if ((int) $employee->user_id !== (int) $account->id) {
            $employee->forceFill(['user_id' => $account->id])->save();
        }

        app(ActivityLogger::class)->logForCurrentRequest(
            'authorization',
            'employee_account.provisioned',
            $employee,
            'Employee login account was provisioned from employee management.',
            null,
            [
                'user_id' => $account->id,
                'username' => $account->username,
                'role_id' => $account->role_id,
            ]
        );

        return $account->refresh();
    }

    /**
     * Resolve the default minimum role for employee login accounts.
     */
    public function memberRoleId(): int
    {
        return (int) Role::query()
            ->where('name', 'Member')
            ->value('id');
    }

    /**
     * Pick a unique email value for Laravel's existing required user email field.
     */
    private function accountEmail(Employee $employee, User $account): string
    {
        $candidate = $employee->email ?: strtolower($employee->employee_code).'@employee.local';

        $emailIsUsed = User::query()
            ->where('email', $candidate)
            ->when($account->exists, fn ($query) => $query->whereKeyNot($account->id))
            ->exists();

        return $emailIsUsed
            ? strtolower($employee->employee_code).'@employee.local'
            : $candidate;
    }
}
