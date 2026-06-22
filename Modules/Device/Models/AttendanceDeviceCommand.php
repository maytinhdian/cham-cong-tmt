<?php

namespace Modules\Device\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceDeviceCommand extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_device_id',
        'command_key',
        'command',
        'status',
        'payload',
        'sent_at',
        'responded_at',
        'response_payload',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'responded_at' => 'datetime',
        'response_payload' => 'array',
    ];

    /**
     * Link the queued command to the attendance device that must execute it.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(AttendanceDevice::class, 'attendance_device_id');
    }
}
