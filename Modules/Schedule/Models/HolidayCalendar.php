<?php

namespace Modules\Schedule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'type',
        'is_paid',
        'workday_value',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'is_paid' => 'boolean',
        'workday_value' => 'decimal:2',
    ];
}
