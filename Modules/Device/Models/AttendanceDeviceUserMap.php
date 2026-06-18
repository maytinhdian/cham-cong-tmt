<?php

namespace Modules\Device\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\Employee;

class AttendanceDeviceUserMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_device_id',
        'employee_id',
        'device_user_code',
        'device_user_name',
        'status',
        'note',
    ];

    /**
     * Link the mapped user code to the physical attendance device.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(AttendanceDevice::class, 'attendance_device_id');
    }

    /**
     * Link the mapped device user code to an internal employee record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
