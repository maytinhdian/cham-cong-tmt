<?php

namespace App\Http\Livewire\LaravelExamples\Roles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Core\Models\Permission;

class Edit extends Component
{
    use AuthorizesRequests;

    public Role $role;

    public array $selectedPermissions = [];

    protected function rules(){
        return [
            'role.name' => 'required|unique:roles,name,'.$this->role->id,
            'role.description' => 'required',
            'selectedPermissions' => 'array',
            'selectedPermissions.*' => 'exists:permissions,id',
        ];
    }

    /**
     * Load the role and its assigned permissions for editing.
     */
    public function mount($id) {

        $this->role = Role::query()->with('permissions')->findOrFail($id);
        $this->selectedPermissions = $this->role->permissions
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();
    }

    /**
     * Validate one field as the role edit form changes.
     */
    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    /**
     * Update role details and replace its business permissions.
     */
    public function edit(){
        $this->authorize('manage-users', User::class);

        $this->validate();
        $this->role->update();
        $this->role->permissions()->sync($this->selectedPermissions);

        return redirect(route('role-management'))->with('status', 'Role successfully updated.');
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
     * Render the role edit form with grouped permission controls.
     */
    public function render()
    {
        $this->authorize('manage-users', User::class);
        return view('livewire.laravel-examples.roles.edit', [
            'permissionGroups' => $this->permissionGroups(),
        ]);
    }

    /**
     * Build permission groups from the seeded permission table.
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
