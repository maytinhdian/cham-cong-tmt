<?php

namespace App\Http\Livewire\Pages\Permissions;

use Livewire\Component;

class Index extends Component
{
    public $summaryCards = [];

    public $roles = [];

    public $modules = [];

    public $activityLog = [];

    public $policyRules = [];

    public function mount()
    {
        $this->summaryCards = [
            ['label' => 'Vai trò', 'value' => '4', 'icon' => 'admin_panel_settings', 'color' => 'primary'],
            ['label' => 'Module được kiểm soát', 'value' => '8', 'icon' => 'grid_view', 'color' => 'success'],
            ['label' => 'Quyền đặc biệt', 'value' => '12', 'icon' => 'verified_user', 'color' => 'warning'],
            ['label' => 'Lần cập nhật gần nhất', 'value' => '5 phút trước', 'icon' => 'history', 'color' => 'dark'],
        ];

        $this->roles = [
            ['name' => 'Admin', 'users' => 1, 'scope' => 'Toàn quyền hệ thống', 'color' => 'dark'],
            ['name' => 'HR', 'users' => 3, 'scope' => 'Nhân sự, chấm công, báo cáo', 'color' => 'primary'],
            ['name' => 'Manager', 'users' => 6, 'scope' => 'Phòng ban, phê duyệt, theo dõi', 'color' => 'success'],
            ['name' => 'Employee', 'users' => 238, 'scope' => 'Tự xem công và gửi yêu cầu', 'color' => 'warning'],
        ];

        $this->modules = [
            ['module' => 'Hệ thống nhân sự', 'description' => 'Phòng ban, nhân viên, ca làm', 'admin' => true, 'hr' => true, 'manager' => false, 'employee' => false],
            ['module' => 'Chấm công', 'description' => 'Check-in, check-out, log công', 'admin' => true, 'hr' => true, 'manager' => true, 'employee' => true],
            ['module' => 'Thiết lập tính công', 'description' => 'Quy tắc, làm tròn, OT, ngày lễ', 'admin' => true, 'hr' => true, 'manager' => false, 'employee' => false],
            ['module' => 'Duyệt đơn', 'description' => 'Nghỉ phép, OT, đổi ca, công tác', 'admin' => true, 'hr' => true, 'manager' => true, 'employee' => true],
            ['module' => 'Báo cáo công', 'description' => 'Tổng hợp, đối soát, export', 'admin' => true, 'hr' => true, 'manager' => true, 'employee' => false],
            ['module' => 'Thiết bị chấm công', 'description' => 'Máy, đồng bộ, nhật ký lỗi', 'admin' => true, 'hr' => true, 'manager' => false, 'employee' => false],
            ['module' => 'Lịch làm việc', 'description' => 'Lịch ca, nghỉ lễ, làm bù', 'admin' => true, 'hr' => true, 'manager' => true, 'employee' => false],
            ['module' => 'Cấu hình người dùng', 'description' => 'Phân nhóm, reset, tài khoản', 'admin' => true, 'hr' => false, 'manager' => false, 'employee' => false],
        ];

        $this->activityLog = [
            ['title' => 'Cập nhật quyền HR', 'time' => '5 phút trước', 'detail' => 'Bật quyền duyệt đơn và xem báo cáo cho nhóm HR.'],
            ['title' => 'Giới hạn Manager', 'time' => '18 phút trước', 'detail' => 'Manager chỉ còn xem báo cáo và duyệt đơn thuộc phòng ban.'],
            ['title' => 'Khóa quyền thiết bị', 'time' => '40 phút trước', 'detail' => 'Chỉ Admin và HR được can thiệp cấu hình thiết bị.'],
            ['title' => 'Đồng bộ role', 'time' => '1 giờ trước', 'detail' => 'Đã cập nhật 238 tài khoản theo role mới.'],
        ];

        $this->policyRules = [
            'Admin luôn có toàn quyền cấu hình',
            'HR được phép thao tác chấm công và duyệt đơn',
            'Manager chỉ thấy dữ liệu thuộc phòng ban của mình',
            'Employee chỉ xem được công cá nhân và gửi yêu cầu',
            'Mọi thay đổi đều lưu log lịch sử',
        ];
    }

    public function render()
    {
        return view('livewire.pages.permissions.index');
    }
}
