<?php

namespace App\Http\Livewire\LaravelExamples\Roles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Core\Models\Permission;

class Create extends Component
{
    use AuthorizesRequests;

    public $name = '';

    public $description = '';

    public array $selectedPermissions = [];

    protected $rules = [

        'name' => 'required|max:255|unique:roles,name',
        'description' =>'required|min:5',
        'selectedPermissions' => 'array',
        'selectedPermissions.*' => 'exists:permissions,id',
    ];

    /**
     * Create a role and attach the selected business permissions.
     */
    public function store(){
        $this->authorize('manage-users', User::class);

        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        return redirect(route('role-management'))->with('status','Role successfully created.');
    }

    /**
     * Select every permission inside one business module group.
     */
    public function selectModule(string $module): void
    {
        $modulePermissionIds = Permission::query()
            ->where('module', $module)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $this->selectedPermissions = collect($this->selectedPermissions)
            ->merge($modulePermissionIds)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Clear selected permissions inside one business module group.
     */
    public function clearModule(string $module): void
    {
        $modulePermissionIds = Permission::query()
            ->where('module', $module)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $this->selectedPermissions = collect($this->selectedPermissions)
            ->reject(fn ($permissionId) => in_array((string) $permissionId, $modulePermissionIds, true))
            ->values()
            ->all();
    }

    /**
     * Render the role creation form with grouped permission controls.
     */
    public function render()
    {
        $this->authorize('manage-users', User::class);

        return view('livewire.laravel-examples.roles.create', [
            'permissionGroups' => $this->permissionGroups(),
        ]);
    }

    /**
     * Build permission groups from the seeded permission registry.
     */
    private function permissionGroups(): array
    {
        return Permission::query()
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module')
            ->map(fn ($permissions, string $module) => [
                'module' => $module,
                'label' => $this->moduleLabels()[$module] ?? ucfirst($module),
                'permissions' => $permissions,
            ])
            ->all();
    }

    /**
     * Provide Vietnamese labels for business permission groups.
     */
    private function moduleLabels(): array
    {
        return [
            'attendance' => 'Chấm công',
            'authorization' => 'Phân quyền',
            'employees' => 'Nhân sự',
            'reports' => 'Báo cáo',
        ];
    }
}
