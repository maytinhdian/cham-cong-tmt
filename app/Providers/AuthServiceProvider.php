<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Authorization\PermissionRegistry;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, string $ability): ?bool {
            return $user->isSuperRole() ? true : null;
        });

        foreach (PermissionRegistry::names() as $permission) {
            Gate::define($permission, fn ($user, ...$arguments): bool => $user->hasPermission($permission));
        }

        Gate::define('manage-users', fn ($user, ...$arguments): bool => $user->hasPermission('authorization.manage'));
        Gate::define('manage-items', fn ($user, ...$arguments): bool => $user->isAdmin() || $user->isCreator());
    }
}
