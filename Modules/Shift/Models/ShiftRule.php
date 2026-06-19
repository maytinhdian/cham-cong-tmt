<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftRule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shift_id',
        'rule_key',
        'rule_value',
        'rule_type',
        'sort_order',
        'status',
        'description',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Link the rule back to its owning shift.
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
