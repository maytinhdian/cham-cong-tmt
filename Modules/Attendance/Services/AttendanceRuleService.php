<?php

namespace Modules\Attendance\Services;

use Illuminate\Support\Collection;
use Modules\Attendance\DTOs\AttendanceRuleContext;
use Modules\Attendance\DTOs\AttendanceRuleData;
use Modules\Attendance\Models\AttendanceRule;

class AttendanceRuleService
{
    /**
     * Return saved attendance rules keyed by their business setting key.
     */
    public function keyed(): Collection
    {
        return AttendanceRule::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('rule_key');
    }

    /**
     * Merge saved rule values over the defaults used by the settings page.
     */
    public function valuesWithDefaults(array $defaults): array
    {
        $savedRules = $this->keyed();

        foreach ($defaults as $key => $default) {
            if (! $savedRules->has($key)) {
                continue;
            }

            $defaults[$key]['value'] = $this->castValue(
                $savedRules->get($key)->rule_value,
                $defaults[$key]['type']
            );
        }

        return $defaults;
    }

    /**
     * Return the default metadata used by settings UI and attendance processing.
     */
    public function definitions(): array
    {
        return [
            'company_name' => $this->definition('OUR COMPANY', 'string', 'basic', 10, 'Tên đơn vị hiển thị trên báo cáo.'),
            'company_short_name' => $this->definition('OUR COMPANY', 'string', 'basic', 20, 'Tên viết tắt của đơn vị.'),
            'week_starts_on' => $this->definition('monday', 'string', 'period', 30, 'Ngày bắt đầu tuần công.'),
            'month_starts_day' => $this->definition(1, 'integer', 'period', 40, 'Ngày bắt đầu tháng công.'),
            'max_shift_minutes' => $this->definition(1200, 'integer', 'matching', 50, 'Giới hạn dài nhất khi nhận diện ca.'),
            'min_overtime_minutes' => $this->definition(120, 'integer', 'matching', 60, 'Ngưỡng ngắn nhất vượt ca.'),
            'min_shift_gap_minutes' => $this->definition(5, 'integer', 'matching', 70, 'Khoảng lệch ca tối thiểu.'),
            'two_day_shift_policy' => $this->definition('second_day', 'string', 'matching', 80, 'Cách ghi nhận ca kéo dài qua hai ngày.'),
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
     * Build typed calculation settings for attendance processing.
     */
    public function context(): AttendanceRuleContext
    {
        $rules = collect($this->valuesWithDefaults($this->definitions()))
            ->mapWithKeys(fn (array $definition, string $key) => [$key => $definition['value']])
            ->all();

        return AttendanceRuleContext::fromValues($rules);
    }

    /**
     * Persist the complete set of global attendance calculation settings.
     */
    public function sync(array $rules, array $definitions): void
    {
        foreach ($rules as $key => $value) {
            if (! isset($definitions[$key])) {
                continue;
            }

            $definition = $definitions[$key];

            AttendanceRule::query()->updateOrCreate(
                ['rule_key' => $key],
                (new AttendanceRuleData(
                    ruleKey: $key,
                    ruleValue: $this->stringValue($value, $definition['type']),
                    ruleType: $definition['type'],
                    groupKey: $definition['group'],
                    sortOrder: $definition['sort'],
                    description: $definition['description'],
                ))->toArray()
            );
        }
    }

    /**
     * Cast a stored string value into the expected Livewire property type.
     */
    private function castValue(?string $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'decimal' => (string) $value,
            default => $value,
        };
    }

    /**
     * Normalize typed form values into strings for key-value storage.
     */
    private function stringValue(mixed $value, string $type): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };
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
