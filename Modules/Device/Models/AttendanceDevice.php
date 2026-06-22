<?php

namespace Modules\Device\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attendance\Models\RawAttendanceLog;

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

    /**
     * List raw attendance logs imported from this device.
     */
    public function rawLogs(): HasMany
    {
        return $this->hasMany(RawAttendanceLog::class);
    }

    /**
     * List device user codes mapped to internal employees for this device.
     */
    public function userMaps(): HasMany
    {
        return $this->hasMany(AttendanceDeviceUserMap::class);
    }

    /**
     * List commands waiting for or returned by this PUSH attendance device.
     */
    public function commands(): HasMany
    {
        return $this->hasMany(AttendanceDeviceCommand::class);
    }
}
