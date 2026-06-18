<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;

class NewEmployee extends Component
{
    public function render()
    {
        $departments = [
            'Nhân sự',
            'Kinh doanh',
            'Kế toán',
            'CSKH',
            'Kho vận',
            'IT',
        ];

        $positions = [
            'Nhân viên',
            'Trưởng nhóm',
            'Quản lý',
            'Thực tập sinh',
            'Cộng tác viên',
        ];

        $onboardingTasks = [
            'Tạo tài khoản email công ty',
            'Gán phòng ban và chức danh',
            'Đăng ký ca làm việc',
            'Cấp mã chấm công / QR',
            'Thiết lập quyền truy cập',
            'Bổ sung hồ sơ lao động',
        ];

        $recentActivities = [
            ['label' => 'Nhập hồ sơ', 'time' => '2 phút trước', 'detail' => 'Tạo form nhân viên mới và đính kèm ảnh đại diện.'],
            ['label' => 'Phân công ca', 'time' => '5 phút trước', 'detail' => 'Gán ca sáng và điểm chấm công mặc định.'],
            ['label' => 'Tạo tài khoản', 'time' => '12 phút trước', 'detail' => 'Sẵn sàng gửi email kích hoạt hệ thống.'],
            ['label' => 'Phân quyền', 'time' => '16 phút trước', 'detail' => 'Chọn nhóm quyền theo phòng ban.'],
        ];

        $quickActions = [
            ['title' => 'Nhập hàng loạt', 'text' => 'Import nhiều nhân viên bằng file Excel hoặc CSV.'],
            ['title' => 'Đăng ký thiết bị', 'text' => 'Ghép nhân viên với máy chấm công, QR hoặc RFID.'],
            ['title' => 'Thiết lập duyệt', 'text' => 'Quy định người duyệt công, nghỉ phép và OT.'],
        ];

        return view('livewire.pages.employees.new-employee', compact(
            'departments',
            'positions',
            'onboardingTasks',
            'recentActivities',
            'quickActions'
        ));
    }
}
