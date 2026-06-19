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

    public string $displayColor = '#2563EB';

    public string $status = 'active';

    public string $description = '';

    /**
     * Prepare the shift form with sensible defaults for a new shift.
     */
    public function mount(): void
    {
        $this->resetForm();
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
            'clockInFrom' => ['nullable', 'date_format:H:i'],
            'clockInTo' => ['nullable', 'date_format:H:i'],
            'clockOutFrom' => ['nullable', 'date_format:H:i'],
            'clockOutTo' => ['nullable', 'date_format:H:i'],
            'maxLateMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'maxEarlyLeaveMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'workdayValue' => ['required', 'numeric', 'min:0', 'max:3'],
            'standardWorkMinutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'requiresClockIn' => ['boolean'],
            'requiresClockOut' => ['boolean'],
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
            clockInFrom: $validated['clockInFrom'] ?: null,
            clockInTo: $validated['clockInTo'] ?: null,
            clockOutFrom: $validated['clockOutFrom'] ?: null,
            clockOutTo: $validated['clockOutTo'] ?: null,
            maxLateMinutes: (int) $validated['maxLateMinutes'],
            maxEarlyLeaveMinutes: (int) $validated['maxEarlyLeaveMinutes'],
            workdayValue: (float) $validated['workdayValue'],
            standardWorkMinutes: (int) $validated['standardWorkMinutes'],
            requiresClockIn: (bool) $validated['requiresClockIn'],
            requiresClockOut: (bool) $validated['requiresClockOut'],
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
    }

    /**
     * Render active shift definitions from real database records.
     */
    public function render()
    {
        return view('livewire.pages.attendance.shift-definition', [
            'shifts' => Shift::query()->withCount('schedules')->orderBy('start_time')->orderBy('code')->get(),
        ]);
    }

    /**
     * Format stored time values for native time inputs.
     */
    private function timeForInput(?string $time): string
    {
        return $time ? substr($time, 0, 5) : '';
    }
}
