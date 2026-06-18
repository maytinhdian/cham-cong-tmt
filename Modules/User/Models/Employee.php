<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User as Account;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'position_id',
        'employee_code',
        'full_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'hire_date',
        'avatar',
        'work_status',
        'note',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'user_id');
    }
}
