<?php

namespace Modules\Device\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceDevice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'device_type',
        'ip_address',
        'port',
        'location',
        'connection_status',
        'sync_status',
        'last_connected_at',
        'last_synced_at',
        'note',
    ];

    protected $casts = [
        'last_connected_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];
}
