<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Modules\Core\Authorization\PermissionRegistry;
use Modules\Core\Models\Permission;

class AuthorizationSeeder extends Seeder
{
    /**
     * Seed business permissions and attach default permission sets to each role.
     */
    public function run(): void
    {
        $permissionsByName = collect(PermissionRegistry::permissions())
            ->mapWithKeys(function (array $permission, string $name): array {
                $model = Permission::query()->updateOrCreate(
                    ['name' => $name],
                    [
                        'label' => $permission['label'],
                        'module' => $permission['module'],
                        'description' => $permission['description'] ?? null,
                    ]
                );

                return [$name => $model];
            });

        foreach (PermissionRegistry::rolePermissions() as $roleName => $permissionNames) {
            $role = Role::query()->firstOrCreate(
                ['name' => $roleName],
                ['description' => "Business role: {$roleName}"]
            );

            $role->permissions()->sync(
                collect($permissionNames)
                    ->map(fn (string $permissionName) => $permissionsByName[$permissionName]->id)
                    ->all()
            );
        }
    }
}
