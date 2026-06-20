<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Shift\DTOs\ShiftData;
use Modules\Shift\Models\Shift;
use Modules\Shift\Services\ShiftService;

class ShiftDefinition extends Component
{
    public ?int $editingShiftId = null;

    public string $code = '';

    public string $name = '';

    public string $startTime = '08:00';

    public string $endTime = '17:00';

    public string $breakStartTime = '';

    public string $breakEndTime = '';

    public $breakMinutes = 0;

    public string $clockInFrom = '';

    public string $clockInTo = '';

    public string $clockOutFrom = '';

    public string $clockOutTo = '';

    public $maxLateMinutes = 0;

    public $maxEarlyLeaveMinutes = 0;

    public $workdayValue = 1;

    public $standardWorkMinutes = 480;

    public bool $requiresClockIn = true;

    public bool $requiresClockOut = true;

    public string $attendanceRequirement = 'both';

    public bool $overtimeBeforeShiftEnabled = false;

    public $overtimeBeforeShiftMinMinutes = 0;

    public bool $overtimeAfterShiftEnabled = false;

    public $overtimeAfterShiftMinMinutes = 0;

    public string $displayColor = '#2563EB';

    public string $status = 'active';

    public int $tableRefreshKey = 0;

    public string $description = '';

    /**
     * Prepare the shift form with sensible defaults for a new shift.
     */
    public function mount(): void
    {
        $this->resetForm();
        $this->refreshShiftTable();
    }

    /**
     * Clear the form and return to create mode.
     */
    public function resetForm(): void
    {
        $this->resetValidation();

        $this->editingShiftId = null;
        $this->code = '';
        $this->name = '';
        $this->startTime = '08:00';
        $this->endTime = '17:00';
        $this->breakStartTime = '';
        $this->breakEndTime = '';
        $this->breakMinutes = 0;
        $this->clockInFrom = '';
        $this->clockInTo = '';
        $this->clockOutFrom = '';
        $this->clockOutTo = '';
        $this->maxLateMinutes = 0;
        $this->maxEarlyLeaveMinutes = 0;
        $this->workdayValue = 1;
        $this->standardWorkMinutes = 480;
        $this->requiresClockIn = true;
        $this->requiresClockOut = true;
        $this->attendanceRequirement = 'both';
        $this->overtimeBeforeShiftEnabled = false;
        $this->overtimeBeforeShiftMinMinutes = 0;
        $this->overtimeAfterShiftEnabled = false;
        $this->overtimeAfterShiftMinMinutes = 0;
        $this->displayColor = '#2563EB';
        $this->status = 'active';
        $this->description = '';
    }

    /**
     * Load a selected shift into the edit form.
     */
    public function editShift(int $shiftId): void
    {
        $shift = Shift::query()->findOrFail($shiftId);

        $this->resetValidation();
        $this->editingShiftId = $shift->id;
        $this->code = $shift->code;
        $this->name = $shift->name;
        $this->startTime = $this->timeForInput($shift->start_time);
        $this->endTime = $this->timeForInput($shift->end_time);
        $this->breakStartTime = $this->timeForInput($shift->break_start_time);
        $this->breakEndTime = $this->timeForInput($shift->break_end_time);
        $this->breakMinutes = (int) $shift->break_minutes;
        $this->clockInFrom = $this->timeForInput($shift->clock_in_from);
        $this->clockInTo = $this->timeForInput($shift->clock_in_to);
        $this->clockOutFrom = $this->timeForInput($shift->clock_out_from);
        $this->clockOutTo = $this->timeForInput($shift->clock_out_to);
        $this->maxLateMinutes = (int) $shift->max_late_minutes;
        $this->maxEarlyLeaveMinutes = (int) $shift->max_early_leave_minutes;
        $this->workdayValue = (float) $shift->workday_value;
        $this->standardWorkMinutes = (int) $shift->standard_work_minutes;
        $this->requiresClockIn = (bool) $shift->requires_clock_in;
        $this->requiresClockOut = (bool) $shift->requires_clock_out;
        $this->attendanceRequirement = $this->attendanceRequirementForShift($shift);
        $this->overtimeBeforeShiftEnabled = (bool) $shift->overtime_before_shift_enabled;
        $this->overtimeBeforeShiftMinMinutes = (int) $shift->overtime_before_shift_min_minutes;
        $this->overtimeAfterShiftEnabled = (bool) $shift->overtime_after_shift_enabled;
        $this->overtimeAfterShiftMinMinutes = (int) $shift->overtime_after_shift_min_minutes;
        $this->displayColor = $shift->display_color ?: '#2563EB';
        $this->status = $shift->status;
        $this->description = $shift->description ?? '';
    }

    /**
     * Save a shift definition used by schedules and attendance rules.
     */
    public function saveShift(ShiftService $shiftService): void
    {
        $validated = $this->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('shifts', 'code')->ignore($this->editingShiftId)->whereNull('deleted_at'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'startTime' => ['required', 'date_format:H:i'],
            'endTime' => ['required', 'date_format:H:i'],
            'breakStartTime' => ['nullable', 'date_format:H:i'],
            'breakEndTime' => ['nullable', 'date_format:H:i'],
            'breakMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'clockInFrom' => ['nullable', 'date_format:H:i'],
            'clockInTo' => ['nullable', 'date_format:H:i'],
            'clockOutFrom' => ['nullable', 'date_format:H:i'],
            'clockOutTo' => ['nullable', 'date_format:H:i'],
            'maxLateMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'maxEarlyLeaveMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'workdayValue' => ['required', 'numeric', 'min:0', 'max:3'],
            'standardWorkMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'attendanceRequirement' => ['required', Rule::in(['both', 'one', 'none'])],
            'overtimeBeforeShiftEnabled' => ['boolean'],
            'overtimeBeforeShiftMinMinutes' => ['required_if:overtimeBeforeShiftEnabled,true', 'integer', 'min:0', 'max:1440'],
            'overtimeAfterShiftEnabled' => ['boolean'],
            'overtimeAfterShiftMinMinutes' => ['required_if:overtimeAfterShiftEnabled,true', 'integer', 'min:0', 'max:1440'],
            'displayColor' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'code.required' => 'Vui lòng nhập mã ca.',
            'code.unique' => 'Mã ca đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên ca.',
            'startTime.required' => 'Vui lòng nhập giờ vào ca.',
            'endTime.required' => 'Vui lòng nhập giờ ra ca.',
            'displayColor.regex' => 'Màu hiển thị cần có dạng #RRGGBB.',
        ]);

        $data = new ShiftData(
            code: strtoupper(trim($validated['code'])),
            name: trim($validated['name']),
            startTime: $validated['startTime'],
            endTime: $validated['endTime'],
            breakStartTime: $validated['breakStartTime'] ?: null,
            breakEndTime: $validated['breakEndTime'] ?: null,
            breakMinutes: (int) $validated['breakMinutes'],
            clockInFrom: $validated['clockInFrom'] ?: null,
            clockInTo: $validated['clockInTo'] ?: null,
            clockOutFrom: $validated['clockOutFrom'] ?: null,
            clockOutTo: $validated['clockOutTo'] ?: null,
            maxLateMinutes: (int) $validated['maxLateMinutes'],
            maxEarlyLeaveMinutes: (int) $validated['maxEarlyLeaveMinutes'],
            workdayValue: (float) $validated['workdayValue'],
            standardWorkMinutes: (int) $validated['standardWorkMinutes'],
            requiresClockIn: $this->requiresClockInForRequirement($validated['attendanceRequirement']),
            requiresClockOut: $this->requiresClockOutForRequirement($validated['attendanceRequirement']),
            overtimeBeforeShiftEnabled: (bool) $validated['overtimeBeforeShiftEnabled'],
            overtimeBeforeShiftMinMinutes: (bool) $validated['overtimeBeforeShiftEnabled']
                ? (int) $validated['overtimeBeforeShiftMinMinutes']
                : 0,
            overtimeAfterShiftEnabled: (bool) $validated['overtimeAfterShiftEnabled'],
            overtimeAfterShiftMinMinutes: (bool) $validated['overtimeAfterShiftEnabled']
                ? (int) $validated['overtimeAfterShiftMinMinutes']
                : 0,
            displayColor: $validated['displayColor'],
            status: $validated['status'],
            description: $validated['description'] ?: null,
        );

        if ($this->editingShiftId) {
            $shiftService->update(Shift::query()->findOrFail($this->editingShiftId), $data);
            session()->flash('success', 'Đã cập nhật ca làm việc.');
        } else {
            $shiftService->create($data);
            session()->flash('success', 'Đã thêm ca làm việc.');
        }

        $this->resetForm();
        $this->refreshShiftTable();
    }

    /**
     * Delete an unused shift or ask the user to disable it when assigned.
     */
    public function deleteShift(int $shiftId, ShiftService $shiftService): void
    {
        $shift = Shift::query()->withCount('schedules')->findOrFail($shiftId);

        if ($shift->schedules_count > 0) {
            session()->flash('error', 'Ca đã được gán lịch, không thể xóa. Hãy chuyển trạng thái sang Tạm ngưng.');

            return;
        }

        $shiftService->delete($shift);

        if ($this->editingShiftId === $shiftId) {
            $this->resetForm();
        }

        session()->flash('success', 'Đã xóa ca làm việc.');
        $this->refreshShiftTable();
    }

    /**
     * Render active shift definitions from real database records.
     */
    public function render()
    {
        return view('livewire.pages.attendance.shift-definition', [
            'shifts' => Shift::query()->withCount('schedules')->orderBy('start_time')->orderBy('code')->get(),
            'isOvernightShift' => $this->isOvernightTimeRange($this->startTime, $this->endTime),
        ]);
    }

    /**
     * Format stored time values for native time inputs.
     */
    private function timeForInput(?string $time): string
    {
        return $time ? substr($time, 0, 5) : '';
    }

    /**
     * Determine whether an input time range crosses into the next calendar day.
     */
    private function isOvernightTimeRange(?string $startTime, ?string $endTime): bool
    {
        return filled($startTime) && filled($endTime) && substr($endTime, 0, 5) <= substr($startTime, 0, 5);
    }

    /**
     * Convert stored punch requirements into the form's business mode.
     */
    private function attendanceRequirementForShift(Shift $shift): string
    {
        if (! $shift->requires_clock_in && ! $shift->requires_clock_out) {
            return 'none';
        }

        if ($shift->requires_clock_in && ! $shift->requires_clock_out) {
            return 'one';
        }

        return 'both';
    }

    /**
     * Map the selected requirement mode to the stored clock-in flag.
     */
    private function requiresClockInForRequirement(string $attendanceRequirement): bool
    {
        return in_array($attendanceRequirement, ['both', 'one'], true);
    }

    /**
     * Map the selected requirement mode to the stored clock-out flag.
     */
    private function requiresClockOutForRequirement(string $attendanceRequirement): bool
    {
        return $attendanceRequirement === 'both';
    }

    /**
     * Force Livewire to rebuild the table DOM after status-changing actions.
     */
    private function refreshShiftTable(): void
    {
        $this->tableRefreshKey++;
    }
}
