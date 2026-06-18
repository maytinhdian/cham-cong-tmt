<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Schedule\Models\EmployeeSchedule;
use Modules\Shift\Models\Shift;
use Modules\User\Models\Employee;

class DailyAttendanceResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_schedule_id',
        'shift_id',
        'work_date',
        'clock_in_at',
        'clock_out_at',
        'work_minutes',
        'late_minutes',
        'early_leave_minutes',
        'overtime_minutes',
        'missing_log_count',
        'status',
        'note',
    ];

    protected $casts = [
        'work_date' => 'date',
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
    ];

    /**
     * Link the processed daily result to its employee.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Link the processed result to the schedule used for matching.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(EmployeeSchedule::class, 'employee_schedule_id');
    }

    /**
     * Link the processed result to the shift rules used for calculation.
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * List manual corrections that have been applied to this daily result.
     */
    public function adjustments(): HasMany
    {
        return $this->hasMany(DailyTimesheetAdjustment::class);
    }
}
