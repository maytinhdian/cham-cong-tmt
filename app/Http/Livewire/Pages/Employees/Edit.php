<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;

class Edit extends Component
{
    public string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $employee = [
            'code' => $this->id,
            'name' => 'Nguyễn Văn A',
            'department' => 'Kinh doanh',
            'title' => 'Nhân viên kinh doanh',
            'manager' => 'Trần Văn Minh',
            'shift' => 'Ca sáng 08:00 - 17:00',
            'email' => 'a.nguyen@company.com',
            'phone' => '0901 234 567',
            'birthday' => '1994-08-12',
            'gender' => 'Nam',
            'status' => 'Đang làm việc',
            'color' => 'success',
            'join_date' => '2024-02-05',
            'workplace' => 'Hà Nội',
            'device' => 'QR / Mobile',
        ];

        $tabs = [
            'Thông tin cá nhân',
            'Công việc',
            'Chấm công',
            'Quyền truy cập',
            'Lịch sử',
        ];

        $attendanceConfig = [
            ['label' => 'Phương thức chấm công', 'value' => 'QR + Mobile'],
            ['label' => 'Ca mặc định', 'value' => 'Ca sáng'],
            ['label' => 'Dung sai đi muộn', 'value' => '15 phút'],
            ['label' => 'Bắt buộc GPS', 'value' => 'Không'],
            ['label' => 'Tự động tính OT', 'value' => 'Có'],
        ];

        $permissionConfig = [
            'Xem bảng công cá nhân',
            'Gửi đơn nghỉ phép',
            'Đăng ký OT',
            'Đề nghị đổi ca',
            'Cập nhật thông tin cá nhân',
        ];

        $timeline = [
            ['title' => 'Cập nhật phòng ban', 'time' => '5 phút trước', 'detail' => 'Chuyển sang phòng Kinh doanh, quản lý là Trần Văn Minh.'],
            ['title' => 'Gán ca làm', 'time' => '20 phút trước', 'detail' => 'Thiết lập ca sáng là ca mặc định.'],
            ['title' => 'Bổ sung thiết bị', 'time' => '35 phút trước', 'detail' => 'Gán chấm công QR và Mobile cho nhân viên.'],
            ['title' => 'Phân quyền', 'time' => '1 giờ trước', 'detail' => 'Cho phép gửi đơn nghỉ phép và OT.'],
        ];

        $activitySummary = [
            ['label' => 'Lần chấm công tháng này', 'value' => '21'],
            ['label' => 'Đi muộn', 'value' => '2'],
            ['label' => 'OT', 'value' => '4.5 giờ'],
            ['label' => 'Đơn chờ duyệt', 'value' => '1'],
        ];

        return view('livewire.pages.employees.edit', compact(
            'employee',
            'tabs',
            'attendanceConfig',
            'permissionConfig',
            'timeline',
            'activitySummary'
        ));
    }
}
