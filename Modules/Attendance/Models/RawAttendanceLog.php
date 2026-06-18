<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Device\Models\AttendanceDevice;
use Modules\User\Models\Employee;

class RawAttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_device_id',
        'employee_id',
        'device_user_code',
        'punch_time',
        'punch_type',
        'verify_type',
        'source',
        'processing_status',
        'raw_payload',
        'note',
    ];

    protected $casts = [
        'punch_time' => 'datetime',
        'raw_payload' => 'array',
    ];

    /**
     * Link the raw log to the device that produced it.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(AttendanceDevice::class, 'attendance_device_id');
    }

    /**
     * Link the raw log to an employee after mapping by device user code.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
