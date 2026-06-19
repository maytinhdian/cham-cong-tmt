<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftBreak extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shift_id',
        'name',
        'start_time',
        'end_time',
        'break_minutes',
        'is_paid',
        'status',
        'description',
    ];

    protected $casts = [
        'break_minutes' => 'integer',
        'is_paid' => 'boolean',
    ];

    /**
     * Link the break window back to its owning shift.
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
