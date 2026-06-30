<?php

namespace App\Http\Livewire\Pages\Attendance;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Attendance\Services\AttendanceRuleService;
use Modules\Schedule\Actions\SyncWeekendSettingsAction;
use Modules\Schedule\Models\WeekendSetting;

class Settings extends Component
{
    use AuthorizesRequests;

    public array $rules = [];

    public array $weekendDays = ['6', '7'];

    /**
     * Load saved attendance rules before the settings form is displayed.
     */
    public function mount(AttendanceRuleService $attendanceRuleService): void
    {
        $definitions = $attendanceRuleService->valuesWithDefaults($attendanceRuleService->definitions());

        $this->rules = collect($definitions)
            ->mapWithKeys(fn (array $definition, string $key) => [$key => $definition['value']])
            ->all();

        if (WeekendSetting::query()->exists()) {
            $this->weekendDays = WeekendSetting::query()
                ->where('is_weekend', true)
                ->orderBy('weekday')
                ->pluck('weekday')
                ->map(fn ($weekday) => (string) $weekday)
                ->all();
        }
    }

    /**
     * Persist attendance calculation rules and weekend selections from the form.
     */
    public function saveRules(): void
    {
        $this->authorize('attendance.settings.manage');

        $this->validate([
            'rules.company_name' => ['required', 'string', 'max:255'],
            'rules.company_short_name' => ['required', 'string', 'max:255'],
            'rules.week_starts_on' => ['required', 'string', 'in:monday,sunday'],
            'rules.month_starts_day' => ['required', 'integer', 'min:1', 'max:31'],
            'rules.max_shift_minutes' => ['required', 'integer', 'min:1', 'max:2880'],
            'rules.min_overtime_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.min_shift_gap_minutes' => ['required', 'integer', 'min:0', 'max:240'],
            'rules.two_day_shift_policy' => ['required', 'string', 'in:first_day,second_day'],
            'rules.out_state_policy' => ['required', 'string', 'in:ignore,out,business,audit'],
            'rules.ot_state_policy' => ['required', 'string', 'in:ignore,direct,audit'],
            'rules.standard_work_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'rules.late_threshold_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.early_threshold_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.no_in_enabled' => ['boolean'],
            'rules.no_in_policy' => ['required', 'string', 'in:late,absent,missing_log'],
            'rules.no_in_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.no_out_enabled' => ['boolean'],
            'rules.no_out_policy' => ['required', 'string', 'in:early,absent,missing_log'],
            'rules.no_out_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.late_absent_enabled' => ['boolean'],
            'rules.late_absent_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.early_absent_enabled' => ['boolean'],
            'rules.early_absent_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.leave_interval_as_ot' => ['boolean'],
            'rules.leave_min_ot_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.leave_ot_interval_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.before_in_interval_as_ot' => ['boolean'],
            'rules.before_in_ot_interval_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.limit_before_in_enabled' => ['boolean'],
            'rules.max_before_in_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.limit_after_out_enabled' => ['boolean'],
            'rules.max_after_out_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.limit_total_overtime_enabled' => ['boolean'],
            'rules.max_total_overtime_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'rules.stat_min_unit' => ['required', 'numeric', 'min:0', 'max:10'],
            'rules.stat_unit' => ['required', 'string', 'in:workday,hour,minute'],
            'rules.stat_report_symbol' => ['required', 'string', 'max:20'],
            'rules.rounding_policy' => ['required', 'string', 'in:down,nearest,up'],
            'rules.accumulate_by_times' => ['boolean'],
            'rules.round_at_accumulation' => ['boolean'],
            'rules.group_by_time_periods' => ['boolean'],
            'rules.weekend_count_as_ot' => ['boolean'],
            'rules.weekend_symbol' => ['required', 'string', 'max:20'],
            'rules.weekend_color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'weekendDays' => ['array'],
            'weekendDays.*' => ['string', 'in:1,2,3,4,5,6,7'],
        ], [
            'rules.company_name.required' => 'Vui lòng nhập tên đơn vị.',
            'rules.company_short_name.required' => 'Vui lòng nhập tên viết tắt.',
            'rules.weekend_color.regex' => 'Màu cuối tuần không hợp lệ.',
        ]);

        app(\Modules\Attendance\Actions\SaveAttendanceRulesAction::class)->execute(
            $this->rules,
            app(AttendanceRuleService::class)->definitions()
        );
        app(SyncWeekendSettingsAction::class)->execute($this->weekendDays);

        session()->flash('success', 'Đã lưu quy tắc tính công.');
    }

    /**
     * Render attendance rule settings grouped by the legacy rule dialog tabs.
     */
    public function render()
    {
        return view('livewire.pages.attendance.settings', [
            'weekdays' => [
                1 => 'Thứ hai',
                2 => 'Thứ ba',
                3 => 'Thứ tư',
                4 => 'Thứ năm',
                5 => 'Thứ sáu',
                6 => 'Thứ bảy',
                7 => 'Chủ nhật',
            ],
            'statisticItems' => [
                'BLeave',
                'Normal',
                'Late',
                'Early',
                'Aff',
                'Absent',
                'OT',
                'Rest',
                'N/In',
                'N/Out',
                'ROT',
                'BOUT',
                'OUT',
                'FOT',
            ],
        ]);
    }

}
