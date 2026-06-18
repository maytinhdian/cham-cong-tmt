<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class WorkSchedule extends Component
{
    public function render()
    {
        $summaryCards = [
            ['label' => 'Ca đang áp dụng', 'value' => '04', 'icon' => 'schedule', 'color' => 'primary'],
            ['label' => 'Ngày nghỉ lễ', 'value' => '11', 'icon' => 'event_busy', 'color' => 'warning'],
            ['label' => 'Ngày làm bù', 'value' => '03', 'icon' => 'event_available', 'color' => 'success'],
            ['label' => 'Nhân sự theo lịch', 'value' => '128', 'icon' => 'groups', 'color' => 'dark'],
        ];

        $weeklyRoster = [
            ['day' => 'Thứ 2', 'shift' => 'Ca sáng', 'time' => '08:00 - 17:00', 'team' => 'Kinh doanh / Kế toán'],
            ['day' => 'Thứ 3', 'shift' => 'Ca sáng', 'time' => '08:00 - 17:00', 'team' => 'Kinh doanh / CSKH'],
            ['day' => 'Thứ 4', 'shift' => 'Ca chiều', 'time' => '13:00 - 22:00', 'team' => 'CSKH / Kho vận'],
            ['day' => 'Thứ 5', 'shift' => 'Ca sáng', 'time' => '08:00 - 17:00', 'team' => 'Toàn công ty'],
            ['day' => 'Thứ 6', 'shift' => 'Ca linh hoạt', 'time' => 'Theo đăng ký', 'team' => 'IT / Hybrid'],
            ['day' => 'Thứ 7', 'shift' => 'Ca trực', 'time' => '09:00 - 15:00', 'team' => 'Hỗ trợ / trực lễ'],
            ['day' => 'Chủ nhật', 'shift' => 'Nghỉ / trực', 'time' => 'Tùy tuần', 'team' => 'Luân phiên'],
        ];

        $holidays = [
            ['date' => '01/01', 'name' => 'Tết Dương lịch', 'type' => 'Nghỉ lễ', 'applies' => 'Toàn công ty', 'color' => 'warning'],
            ['date' => '30/04', 'name' => 'Ngày Giải phóng', 'type' => 'Nghỉ lễ', 'applies' => 'Toàn công ty', 'color' => 'warning'],
            ['date' => '01/05', 'name' => 'Quốc tế Lao động', 'type' => 'Nghỉ lễ', 'applies' => 'Toàn công ty', 'color' => 'warning'],
            ['date' => '02/09', 'name' => 'Quốc khánh', 'type' => 'Nghỉ lễ', 'applies' => 'Toàn công ty', 'color' => 'warning'],
            ['date' => 'T7 tuần cuối', 'name' => 'Làm bù', 'type' => 'Ngày làm bù', 'applies' => 'Khối vận hành', 'color' => 'success'],
        ];

        $specialDays = [
            ['date' => '12/02', 'name' => 'Triển khai hệ thống', 'rule' => 'Cho phép làm bù sau 17:00'],
            ['date' => '15/03', 'name' => 'Nghỉ nội bộ', 'rule' => 'Không tính công toàn công ty'],
            ['date' => '20/06', 'name' => 'Đào tạo nhân sự', 'rule' => 'Ca rút ngắn 1/2 ngày'],
            ['date' => '24/12', 'name' => 'Hoạt động team', 'rule' => 'Chuyển sang lịch sự kiện'],
        ];

        $rules = [
            'Tạo lịch theo tháng hoặc theo quý',
            'Gán lịch riêng cho từng phòng ban',
            'Tự động chuyển ngày nghỉ lễ sang làm bù khi cần',
            'Cho phép khóa lịch sau khi chốt công',
            'Đồng bộ với bảng công và OT',
        ];

        $recentChanges = [
            ['title' => 'Cập nhật lịch Tết', 'time' => '5 phút trước', 'detail' => 'Đã thêm 5 ngày nghỉ lễ và 2 ngày làm bù.'],
            ['title' => 'Đổi ca trực tuần', 'time' => '18 phút trước', 'detail' => 'Khối vận hành chuyển sang ca trực thứ 7.'],
            ['title' => 'Chốt lịch quý', 'time' => '40 phút trước', 'detail' => 'Đã khóa lịch từ tháng 4 đến tháng 6.'],
            ['title' => 'Thêm ngày đào tạo', 'time' => '1 giờ trước', 'detail' => 'Áp dụng lịch rút ngắn cho toàn bộ nhân sự.'],
        ];

        $departmentAssignments = [
            ['name' => 'Kinh doanh', 'schedule' => 'Ca sáng', 'holiday' => 'Nghỉ lễ toàn công ty'],
            ['name' => 'CSKH', 'schedule' => 'Ca chiều', 'holiday' => 'Trực luân phiên ngày lễ'],
            ['name' => 'Kho vận', 'schedule' => 'Ca đêm / ca trực', 'holiday' => 'Làm bù cuối tuần'],
            ['name' => 'IT', 'schedule' => 'Linh hoạt / hybrid', 'holiday' => 'Theo lịch dự án'],
        ];

        return view('livewire.pages.work-schedule', compact(
            'summaryCards',
            'weeklyRoster',
            'holidays',
            'specialDays',
            'rules',
            'recentChanges',
            'departmentAssignments'
        ));
    }
}
