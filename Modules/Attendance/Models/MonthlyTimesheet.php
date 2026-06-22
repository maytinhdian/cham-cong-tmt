<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Org\Models\Department;
use Modules\User\Models\Employee;

class MonthlyTimesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'department_id',
        'period_month',
        'total_days',
        'work_days',
        'adjusted_days',
        'exception_days',
        'absent_days',
        'leave_days',
        'weekend_days',
        'holiday_days',
        'missing_log_count',
        'work_minutes',
        'break_minutes',
        'attendance_value',
        'late_minutes',
        'early_leave_minutes',
        'overtime_minutes',
        'status',
        'generated_at',
        'note',
    ];

    protected $casts = [
        'period_month' => 'date',
        'attendance_value' => 'decimal:2',
        'generated_at' => 'datetime',
    ];

    /**
     * Link the monthly summary to the employee being reviewed for payroll.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Link the monthly summary to the employee department at generation time.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
