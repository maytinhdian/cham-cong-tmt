<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_key',
        'rule_value',
        'rule_type',
        'group_key',
        'sort_order',
        'status',
        'description',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
