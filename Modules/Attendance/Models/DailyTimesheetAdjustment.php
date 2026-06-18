<?php

namespace Modules\Attendance\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\Employee;

class DailyTimesheetAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_attendance_result_id',
        'employee_id',
        'adjusted_by',
        'work_date',
        'old_values',
        'new_values',
        'reason',
        'status',
    ];

    protected $casts = [
        'work_date' => 'date',
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Link the adjustment to the daily result it corrected.
     */
    public function dailyAttendanceResult(): BelongsTo
    {
        return $this->belongsTo(DailyAttendanceResult::class);
    }

    /**
     * Link the adjustment to the employee whose timesheet was corrected.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Link the adjustment to the user who applied the correction.
     */
    public function adjustedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }
}
