<?php

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Schedule\Models\EmployeeSchedule;

class Shift extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
        'break_minutes',
        'break_as_overtime_enabled',
        'clock_in_from',
        'clock_in_to',
        'clock_out_from',
        'clock_out_to',
        'max_late_minutes',
        'max_early_leave_minutes',
        'workday_value',
        'standard_work_minutes',
        'requires_clock_in',
        'requires_clock_out',
        'overtime_before_shift_enabled',
        'overtime_before_shift_min_minutes',
        'overtime_after_shift_enabled',
        'overtime_after_shift_min_minutes',
        'display_color',
        'status',
        'description',
    ];

    protected $casts = [
        'break_minutes' => 'integer',
        'break_as_overtime_enabled' => 'boolean',
        'workday_value' => 'decimal:2',
        'requires_clock_in' => 'boolean',
        'requires_clock_out' => 'boolean',
        'overtime_before_shift_enabled' => 'boolean',
        'overtime_before_shift_min_minutes' => 'integer',
        'overtime_after_shift_enabled' => 'boolean',
        'overtime_after_shift_min_minutes' => 'integer',
    ];

    /**
     * List employee schedules that reference this shift.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(EmployeeSchedule::class);
    }

    /**
     * List the break windows configured for this shift.
     */
    public function breaks(): HasMany
    {
        return $this->hasMany(ShiftBreak::class);
    }

    /**
     * List the attendance rules configured for this shift.
     */
    public function rules(): HasMany
    {
        return $this->hasMany(ShiftRule::class);
    }
}
