<?php

namespace Modules\Schedule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekendSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekday',
        'label',
        'is_weekend',
        'note',
    ];

    protected $casts = [
        'is_weekend' => 'boolean',
    ];
}
