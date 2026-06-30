<?php

namespace App\Http\Livewire\LaravelExamples\Roles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use AuthorizesRequests;
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 10;

    protected $queryString = ['sortField', 'sortDirection',];
    protected $paginationTheme = 'bootstrap';

    /**
     * Sort the role list by a selected column.
     */
    public function sortBy($field){
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }


    /**
     * Delete a role only when no users are currently assigned to it.
     */
    public function destroy($id){
        $this->authorize('manage-users', User::class);

        if (!Role::find($id)->user->isEmpty()) {
            return back()->with('error', 'This role has users attached and can\'t be deleted.');
        }
        Role::find($id)->delete();
        return redirect(route('role-management'))->with('status', 'Role successfully deleted.');
    }

    /**
     * Render the role list with user and permission counts.
     */
    public function render()
    {
        $this->authorize('manage-users', User::class);
        
        return view('livewire.laravel-examples.roles.index', [
            'roles' => Role::query()
                ->withCount(['permissions', 'user as users_count'])
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
