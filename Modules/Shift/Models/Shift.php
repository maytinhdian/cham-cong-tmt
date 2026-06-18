<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'start_time',
        'end_time',
        'clock_in_from',
        'clock_in_to',
        'clock_out_from',
        'clock_out_to',
        'max_late_minutes',
        'max_early_leave_minutes',
        'workday_value',
        'standard_work_minutes',
        'requires_clock_in',
        'requires_clock_out',
        'display_color',
        'status',
        'description',
    ];

    protected $casts = [
        'workday_value' => 'decimal:2',
        'requires_clock_in' => 'boolean',
        'requires_clock_out' => 'boolean',
    ];
}
