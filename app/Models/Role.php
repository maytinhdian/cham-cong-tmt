<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Core\Models\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function user(){

        return $this->hasMany(User::class);

    }

    /**
     * Return module/action permissions assigned to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')->withTimestamps();
    }
}
