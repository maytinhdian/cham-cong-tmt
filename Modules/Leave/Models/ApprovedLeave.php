<?php

namespace Modules\Leave\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\Employee;

class ApprovedLeave extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'leave_date',
        'leave_type',
        'workday_value',
        'status',
        'note',
    ];

    protected $casts = [
        'leave_date' => 'date',
        'workday_value' => 'decimal:2',
    ];

    /**
     * Link the leave record to the employee who requested or received it.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
