<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AttendanceClosing extends Component
{
    public $summaryCards = [];

    public $periodInfo = [];

    public $closingStages = [];

    public $employees = [];

    public $departmentSummary = [];

    public $closingHistory = [];

    public $checklist = [];

    public $alerts = [];

    public function mount()
    {
        $this->summaryCards = [
            ['label' => 'Kỳ công hiện tại', 'value' => '01 - 30/06/2026', 'icon' => 'event', 'color' => 'primary'],
            ['label' => 'Đã chốt tạm', 'value' => '186', 'icon' => 'lock_clock', 'color' => 'success'],
            ['label' => 'Đã chốt chính thức', 'value' => '102', 'icon' => 'lock', 'color' => 'dark'],
            ['label' => 'Cần rà soát', 'value' => '9', 'icon' => 'report_problem', 'color' => 'warning'],
        ];

        $this->periodInfo = [
            ['label' => 'Ngày mở kỳ', 'value' => '01/06/2026'],
            ['label' => 'Ngày chốt dự kiến', 'value' => '30/06/2026'],
            ['label' => 'Trạng thái kỳ', 'value' => 'Đang xử lý'],
            ['label' => 'Người phụ trách', 'value' => 'HR Admin'],
        ];

        $this->closingStages = [
            ['step' => '1', 'title' => 'Tổng hợp dữ liệu', 'detail' => 'Nạp log từ máy, app, QR và các chỉnh sửa thủ công.'],
            ['step' => '2', 'title' => 'Đối soát sai lệch', 'detail' => 'Kiểm tra giờ vào ra, OT, nghỉ phép, thiếu check-out.'],
            ['step' => '3', 'title' => 'Chốt tạm', 'detail' => 'Khóa tạm để quản lý rà soát trước khi chốt chính thức.'],
            ['step' => '4', 'title' => 'Chốt chính thức', 'detail' => 'Dữ liệu được khóa để chuyển sang tính lương.'],
        ];

        $this->employees = [
            ['code' => 'EMP-0001', 'name' => 'Nguyễn Văn A', 'dept' => 'Kinh doanh', 'shift' => 'Ca sáng', 'workdays' => '26.0', 'late' => '1', 'ot' => '4.5', 'leave' => '0.5', 'status' => 'Đã chốt tạm', 'color' => 'success'],
            ['code' => 'EMP-0002', 'name' => 'Trần Thị B', 'dept' => 'Kế toán', 'shift' => 'Ca sáng', 'workdays' => '25.5', 'late' => '2', 'ot' => '1.0', 'leave' => '1.0', 'status' => 'Cần rà soát', 'color' => 'warning'],
            ['code' => 'EMP-0003', 'name' => 'Lê Minh C', 'dept' => 'CSKH', 'shift' => 'Ca chiều', 'workdays' => '24.0', 'late' => '3', 'ot' => '5.0', 'leave' => '0', 'status' => 'Đã chốt chính thức', 'color' => 'dark'],
            ['code' => 'EMP-0004', 'name' => 'Phạm Quốc D', 'dept' => 'IT', 'shift' => 'Linh hoạt', 'workdays' => '26.0', 'late' => '0', 'ot' => '2.0', 'leave' => '0', 'status' => 'Đã chốt tạm', 'color' => 'success'],
            ['code' => 'EMP-0005', 'name' => 'Huỳnh Yến E', 'dept' => 'Nhân sự', 'shift' => 'Ca sáng', 'workdays' => '23.5', 'late' => '4', 'ot' => '0', 'leave' => '2.0', 'status' => 'Cần rà soát', 'color' => 'warning'],
            ['code' => 'EMP-0006', 'name' => 'Hoàng Minh F', 'dept' => 'Kho vận', 'shift' => 'Ca đêm', 'workdays' => '27.0', 'late' => '0', 'ot' => '6.0', 'leave' => '0', 'status' => 'Đã chốt chính thức', 'color' => 'dark'],
        ];

        $this->departmentSummary = [
            ['name' => 'Kinh doanh', 'employees' => 34, 'locked' => 29, 'issues' => 2],
            ['name' => 'Kế toán', 'employees' => 12, 'locked' => 9, 'issues' => 1],
            ['name' => 'CSKH', 'employees' => 26, 'locked' => 21, 'issues' => 3],
            ['name' => 'IT', 'employees' => 18, 'locked' => 18, 'issues' => 0],
            ['name' => 'Kho vận', 'employees' => 16, 'locked' => 14, 'issues' => 1],
        ];

        $this->closingHistory = [
            ['title' => 'Chốt tạm tháng 05', 'time' => '5 phút trước', 'detail' => 'Đã khóa tạm 96% nhân viên, còn 9 trường hợp cần rà soát.'],
            ['title' => 'Mở khóa 3 nhân viên', 'time' => '22 phút trước', 'detail' => 'Cho phép sửa lại log thiếu check-out sau khi đối soát.'],
            ['title' => 'Xuất bảng công', 'time' => '40 phút trước', 'detail' => 'Đã xuất file tổng hợp công tháng 6 cho kế toán.'],
            ['title' => 'Chốt chính thức ca đêm', 'time' => '1 giờ trước', 'detail' => 'Khối kho vận được chuyển sang trạng thái khóa chính thức.'],
        ];

        $this->checklist = [
            'Đã đối soát log máy chấm công',
            'Đã kiểm tra đơn nghỉ phép / OT',
            'Đã rà soát nhân viên thiếu check-out',
            'Đã xác nhận các chỉnh sửa thủ công',
            'Đã xuất file bàn giao sang kế toán',
        ];

        $this->alerts = [
            'Có 2 nhân viên chưa nộp xác nhận công tác',
            '3 bản ghi thiếu check-out cần HR mở khóa',
            '1 thiết bị kho vận gửi log trễ 18 phút',
        ];
    }

    public function render()
    {
        return view('livewire.pages.attendance-closing');
    }
}
