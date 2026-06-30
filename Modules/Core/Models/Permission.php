<?php

namespace Modules\Core\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'module',
        'description',
    ];

    /**
     * Return roles that receive this module/action permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')->withTimestamps();
    }
}
