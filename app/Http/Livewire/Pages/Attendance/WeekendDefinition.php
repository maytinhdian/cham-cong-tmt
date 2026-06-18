<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Schedule\Actions\SaveHolidayAction;
use Modules\Schedule\Actions\SyncWeekendSettingsAction;
use Modules\Schedule\DTOs\HolidayCalendarData;
use Modules\Schedule\Models\HolidayCalendar;
use Modules\Schedule\Models\WeekendSetting;

class WeekendDefinition extends Component
{
    public array $weekendDays = ['6', '7'];

    public string $holidayDate = '';

    public string $holidayName = '';

    public string $holidayType = 'holiday';

    public bool $isPaid = true;

    public string $workdayValue = '1';

    public ?string $note = null;

    public function mount(): void
    {
        if (WeekendSetting::query()->exists()) {
            $this->weekendDays = WeekendSetting::query()
                ->where('is_weekend', true)
                ->orderBy('weekday')
                ->pluck('weekday')
                ->map(fn ($weekday) => (string) $weekday)
                ->all();
        } else {
            app(SyncWeekendSettingsAction::class)->execute($this->weekendDays);
        }

        $this->holidayDate = now()->toDateString();
    }

    public function saveWeekendSettings(): void
    {
        $this->validate([
            'weekendDays' => ['array'],
            'weekendDays.*' => ['string', 'in:1,2,3,4,5,6,7'],
        ]);

        app(SyncWeekendSettingsAction::class)->execute($this->weekendDays);

        session()->flash('success', 'Đã lưu cấu hình ngày cuối tuần.');
    }

    public function saveHoliday(): void
    {
        $validated = $this->validate([
            'holidayDate' => ['required', 'date'],
            'holidayName' => ['required', 'string', 'max:255'],
            'holidayType' => ['required', 'string', 'max:40'],
            'isPaid' => ['boolean'],
            'workdayValue' => ['required', 'numeric', 'min:0', 'max:2'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'holidayDate.required' => 'Vui lòng chọn ngày nghỉ.',
            'holidayName.required' => 'Vui lòng nhập tên ngày nghỉ.',
        ]);

        app(SaveHolidayAction::class)->execute(new HolidayCalendarData(
            date: $validated['holidayDate'],
            name: $validated['holidayName'],
            type: $validated['holidayType'],
            isPaid: (bool) $validated['isPaid'],
            workdayValue: (float) $validated['workdayValue'],
            note: $validated['note'] ?: null,
        ));

        session()->flash('success', 'Đã lưu ngày nghỉ/lễ.');

        $this->reset(['holidayName', 'note']);
        $this->holidayDate = now()->toDateString();
        $this->holidayType = 'holiday';
        $this->isPaid = true;
        $this->workdayValue = '1';
    }

    public function deleteHoliday(int $holidayId): void
    {
        HolidayCalendar::query()->findOrFail($holidayId)->delete();

        session()->flash('success', 'Đã xóa ngày nghỉ/lễ.');
    }

    public function render()
    {
        return view('livewire.pages.attendance.weekend-definition', [
            'holidays' => HolidayCalendar::query()
                ->orderBy('date')
                ->get(),
            'weekendSettings' => WeekendSetting::query()
                ->orderBy('weekday')
                ->get(),
        ]);
    }
}
