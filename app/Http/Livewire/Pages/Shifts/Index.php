<?php

namespace App\Http\Livewire\Pages\Shifts;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $shifts = [
            [
                'name' => 'Ca sáng',
                'time' => '08:00 - 17:00',
                'type' => 'Toàn thời gian',
                'headcount' => 86,
                'status' => 'Đang áp dụng',
                'color' => 'success',
            ],
            [
                'name' => 'Ca chiều',
                'time' => '13:00 - 22:00',
                'type' => 'Toàn thời gian',
                'headcount' => 24,
                'status' => 'Đang áp dụng',
                'color' => 'primary',
            ],
            [
                'name' => 'Ca đêm',
                'time' => '22:00 - 06:00',
                'type' => 'Luân phiên',
                'headcount' => 7,
                'status' => 'Ít nhân sự',
                'color' => 'warning',
            ],
            [
                'name' => 'Ca linh hoạt',
                'time' => 'Theo đăng ký',
                'type' => 'Hybrid / Remote',
                'headcount' => 11,
                'status' => 'Đang áp dụng',
                'color' => 'dark',
            ],
        ];

        $rules = [
            'Tự động tính đi muộn sau 15 phút',
            'Cho phép check-in qua QR, mobile hoặc máy chấm công',
            'Áp dụng OT sau 17:30 nếu có phê duyệt',
            'Có thể khóa ca theo ngày lễ / cuối tuần',
        ];

        $recentActivities = [
            ['title' => 'Cập nhật ca sáng', 'time' => '3 phút trước', 'detail' => 'Tăng 2 nhân sự từ phòng Kinh doanh sang ca sáng.'],
            ['title' => 'Tạo ca đêm', 'time' => '20 phút trước', 'detail' => 'Khởi tạo ca đêm cho bộ phận Kho vận.'],
            ['title' => 'Đổi quy tắc OT', 'time' => '45 phút trước', 'detail' => 'Điều chỉnh OT từ 30 phút xuống 15 phút.'],
            ['title' => 'Khóa ca cuối tuần', 'time' => '1 giờ trước', 'detail' => 'Tạm ẩn ca linh hoạt cho kỳ nghỉ lễ.'],
        ];

        $stats = [
            ['label' => 'Tổng ca', 'value' => '04', 'icon' => 'schedule', 'color' => 'primary'],
            ['label' => 'Đang áp dụng', 'value' => '03', 'icon' => 'check_circle', 'color' => 'success'],
            ['label' => 'Luân phiên', 'value' => '01', 'icon' => 'cached', 'color' => 'warning'],
            ['label' => 'Nhân sự được gán', 'value' => '128', 'icon' => 'groups', 'color' => 'dark'],
        ];

        return view('livewire.pages.shifts.index', compact(
            'shifts',
            'rules',
            'recentActivities',
            'stats'
        ));
    }
}
