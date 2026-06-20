<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;
use Modules\Attendance\Services\AttendanceRuleService;
use Modules\Schedule\Actions\SyncWeekendSettingsAction;
use Modules\Schedule\Models\WeekendSetting;

class Settings extends Component
{
    public array $rules = [];

    public array $weekendDays = ['6', '7'];

    /**
     * Load saved attendance rules before the settings form is displayed.
     */
    public function mount(AttendanceRuleService $attendanceRuleService): void
    {
        $definitions = $attendanceRuleService->valuesWithDefaults($this->ruleDefinitions());

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

        app(\Modules\Attendance\Actions\SaveAttendanceRulesAction::class)->execute($this->rules, $this->ruleDefinitions());
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

    /**
     * Define defaults, storage types, and UI grouping for global attendance rules.
     */
    private function ruleDefinitions(): array
    {
        return [
            'company_name' => $this->definition('OUR COMPANY', 'string', 'basic', 10, 'Tên đơn vị hiển thị trên báo cáo.'),
            'company_short_name' => $this->definition('OUR COMPANY', 'string', 'basic', 20, 'Tên viết tắt của đơn vị.'),
            'week_starts_on' => $this->definition('monday', 'string', 'period', 30, 'Ngày bắt đầu tuần công.'),
            'month_starts_day' => $this->definition(1, 'integer', 'period', 40, 'Ngày bắt đầu tháng công.'),
            'max_shift_minutes' => $this->definition(1200, 'integer', 'matching', 50, 'Giới hạn dài nhất khi nhận diện ca.'),
            'min_overtime_minutes' => $this->definition(120, 'integer', 'matching', 60, 'Ngưỡng ngắn nhất vượt ca.'),
            'min_shift_gap_minutes' => $this->definition(5, 'integer', 'matching', 70, 'Khoảng lệch ca tối thiểu.'),
            'two_day_shift_policy' => $this->definition('first_day', 'string', 'matching', 80, 'Cách ghi nhận ca kéo dài qua hai ngày.'),
            'out_state_policy' => $this->definition('audit', 'string', 'state', 90, 'Cách xử lý trạng thái ra ngoài.'),
            'ot_state_policy' => $this->definition('audit', 'string', 'state', 100, 'Cách xử lý trạng thái tăng ca từ máy chấm công.'),
            'standard_work_minutes' => $this->definition(420, 'integer', 'calculation', 110, 'Số phút tương ứng một ngày công chuẩn.'),
            'late_threshold_minutes' => $this->definition(10, 'integer', 'calculation', 120, 'Số phút quá giờ vào để tính đi trễ.'),
            'early_threshold_minutes' => $this->definition(5, 'integer', 'calculation', 130, 'Số phút ra sớm để tính về sớm.'),
            'no_in_enabled' => $this->definition(true, 'boolean', 'missing_log', 140, 'Bật quy tắc không có giờ vào.'),
            'no_in_policy' => $this->definition('late', 'string', 'missing_log', 150, 'Cách tính khi thiếu giờ vào.'),
            'no_in_minutes' => $this->definition(60, 'integer', 'missing_log', 160, 'Số phút tính khi thiếu giờ vào.'),
            'no_out_enabled' => $this->definition(true, 'boolean', 'missing_log', 170, 'Bật quy tắc không có giờ ra.'),
            'no_out_policy' => $this->definition('early', 'string', 'missing_log', 180, 'Cách tính khi thiếu giờ ra.'),
            'no_out_minutes' => $this->definition(60, 'integer', 'missing_log', 190, 'Số phút tính khi thiếu giờ ra.'),
            'late_absent_enabled' => $this->definition(false, 'boolean', 'absence', 200, 'Bật ngưỡng trễ quá mức thành vắng.'),
            'late_absent_minutes' => $this->definition(100, 'integer', 'absence', 210, 'Ngưỡng trễ quá mức thành vắng.'),
            'early_absent_enabled' => $this->definition(false, 'boolean', 'absence', 220, 'Bật ngưỡng về sớm quá mức thành vắng.'),
            'early_absent_minutes' => $this->definition(100, 'integer', 'absence', 230, 'Ngưỡng về sớm quá mức thành vắng.'),
            'leave_interval_as_ot' => $this->definition(true, 'boolean', 'overtime', 240, 'Tính khoảng ra ngoài là tăng ca.'),
            'leave_min_ot_minutes' => $this->definition(60, 'integer', 'overtime', 250, 'Ngưỡng tối thiểu để tính tăng ca khi ra ngoài.'),
            'leave_ot_interval_minutes' => $this->definition(60, 'integer', 'overtime', 260, 'Khoảng phút tính tăng ca khi ra ngoài.'),
            'before_in_interval_as_ot' => $this->definition(false, 'boolean', 'overtime', 270, 'Tính khoảng chấm vào trước giờ là tăng ca.'),
            'before_in_ot_interval_minutes' => $this->definition(60, 'integer', 'overtime', 280, 'Khoảng phút tính tăng ca trước giờ vào.'),
            'limit_before_in_enabled' => $this->definition(false, 'boolean', 'overtime', 290, 'Bật giới hạn tăng ca trước giờ vào.'),
            'max_before_in_minutes' => $this->definition(60, 'integer', 'overtime', 300, 'Tối đa phút tăng ca trước giờ vào.'),
            'limit_after_out_enabled' => $this->definition(false, 'boolean', 'overtime', 310, 'Bật giới hạn tăng ca sau giờ ra.'),
            'max_after_out_minutes' => $this->definition(60, 'integer', 'overtime', 320, 'Tối đa phút tăng ca sau giờ ra.'),
            'limit_total_overtime_enabled' => $this->definition(false, 'boolean', 'overtime', 330, 'Bật giới hạn tổng tăng ca.'),
            'max_total_overtime_minutes' => $this->definition(120, 'integer', 'overtime', 340, 'Tối đa tổng phút tăng ca.'),
            'stat_min_unit' => $this->definition('0.50', 'decimal', 'statistics', 350, 'Đơn vị thống kê tối thiểu.'),
            'stat_unit' => $this->definition('workday', 'string', 'statistics', 360, 'Đơn vị thống kê công.'),
            'stat_report_symbol' => $this->definition('G', 'string', 'statistics', 370, 'Ký hiệu báo cáo mặc định.'),
            'rounding_policy' => $this->definition('nearest', 'string', 'statistics', 380, 'Cách làm tròn khi thống kê.'),
            'accumulate_by_times' => $this->definition(false, 'boolean', 'statistics', 390, 'Cộng dồn theo số lần phát sinh.'),
            'round_at_accumulation' => $this->definition(true, 'boolean', 'statistics', 400, 'Làm tròn khi cộng dồn.'),
            'group_by_time_periods' => $this->definition(false, 'boolean', 'statistics', 410, 'Nhóm thống kê theo khoảng thời gian.'),
            'weekend_count_as_ot' => $this->definition(false, 'boolean', 'weekend', 420, 'Tính ngày cuối tuần là tăng ca.'),
            'weekend_symbol' => $this->definition('W', 'string', 'weekend', 430, 'Ký hiệu cuối tuần trên báo cáo.'),
            'weekend_color' => $this->definition('#ff0000', 'string', 'weekend', 440, 'Màu hiển thị cuối tuần trên báo cáo.'),
        ];
    }

    /**
     * Build one attendance rule definition used for defaults and storage metadata.
     */
    private function definition(mixed $value, string $type, string $group, int $sort, string $description): array
    {
        return [
            'value' => $value,
            'type' => $type,
            'group' => $group,
            'sort' => $sort,
            'description' => $description,
        ];
    }
}
