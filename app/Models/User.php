<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Models\Employee;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role_id',
        'location',
        'phone',
        'picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Check if the user is admin
     */
    public function isAdmin() {
        return $this->role_id === 1;
    }

    /**
     * Check if the user is creator
     */
    public function isCreator() {
        return $this->role_id === 2;
    }

    /**
     * Check if the user is member
     */
    public function isMember() {
        return $this->role_id === 3;
    }

    /**
     * Check whether the user belongs to a role name, case-insensitively.
     */
    public function hasRoleName(string $roleName): bool
    {
        return strcasecmp((string) $this->role?->name, $roleName) === 0;
    }

    /**
     * Check whether this user should bypass detailed business permissions.
     */
    public function isSuperRole(): bool
    {
        return $this->isAdmin() || $this->hasRoleName('Admin') || $this->hasRoleName('Super Admin');
    }

    /**
     * Check whether the user's role grants a module/action permission.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperRole()) {
            return true;
        }

        return $this->role?->permissions()
            ->where('name', $permission)
            ->exists() ?? false;
    }

    public function role(){

        return $this->belongsTo(Role::class);
    }

    /**
     * Link this login account back to the employee profile it belongs to.
     */
    public function employeeProfile(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
}
