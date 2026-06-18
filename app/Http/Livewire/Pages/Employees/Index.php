<?php

namespace App\Http\Livewire\Pages\Employees;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $departments = [
            'Tất cả phòng ban',
            'Nhân sự',
            'Kinh doanh',
            'Kế toán',
            'CSKH',
            'Kho vận',
            'IT',
        ];

        $employees = [
            [
                'code' => 'EMP-0001',
                'name' => 'Nguyễn Văn A',
                'department' => 'Kinh doanh',
                'title' => 'Nhân viên kinh doanh',
                'shift' => 'Ca sáng',
                'status' => 'Đang làm việc',
                'color' => 'success',
                'email' => 'a.nguyen@company.com',
            ],
            [
                'code' => 'EMP-0002',
                'name' => 'Trần Thị B',
                'department' => 'Kế toán',
                'title' => 'Kế toán tổng hợp',
                'shift' => 'Ca sáng',
                'status' => 'Đang làm việc',
                'color' => 'primary',
                'email' => 'b.tran@company.com',
            ],
            [
                'code' => 'EMP-0003',
                'name' => 'Lê Minh C',
                'department' => 'CSKH',
                'title' => 'Trưởng nhóm CSKH',
                'shift' => 'Ca chiều',
                'status' => 'Chờ duyệt',
                'color' => 'warning',
                'email' => 'c.le@company.com',
            ],
            [
                'code' => 'EMP-0004',
                'name' => 'Phạm Quốc D',
                'department' => 'IT',
                'title' => 'Lập trình viên',
                'shift' => 'Linh hoạt',
                'status' => 'Đang làm việc',
                'color' => 'dark',
                'email' => 'd.pham@company.com',
            ],
            [
                'code' => 'EMP-0005',
                'name' => 'Huỳnh Yến E',
                'department' => 'Nhân sự',
                'title' => 'Chuyên viên C&B',
                'shift' => 'Ca sáng',
                'status' => 'Nghỉ phép',
                'color' => 'info',
                'email' => 'e.huynh@company.com',
            ],
        ];

        $stats = [
            ['label' => 'Tổng nhân viên', 'value' => '128', 'icon' => 'groups', 'color' => 'primary'],
            ['label' => 'Đang làm việc', 'value' => '119', 'icon' => 'how_to_reg', 'color' => 'success'],
            ['label' => 'Chờ bổ sung hồ sơ', 'value' => '6', 'icon' => 'assignment_late', 'color' => 'warning'],
            ['label' => 'Nghỉ phép hôm nay', 'value' => '3', 'icon' => 'event_busy', 'color' => 'dark'],
        ];

        $quickActions = [
            'Tạo hồ sơ nhân viên mới',
            'Gán phòng ban và chức danh',
            'Cấp mã chấm công / QR',
            'Đồng bộ ca làm mặc định',
            'Thiết lập quyền truy cập',
        ];

        $departmentSummary = [
            ['name' => 'Kinh doanh', 'count' => 34, 'lead' => 'Trần Văn Minh'],
            ['name' => 'Kế toán', 'count' => 12, 'lead' => 'Phạm Thu Hà'],
            ['name' => 'CSKH', 'count' => 26, 'lead' => 'Lê Hoài Nam'],
            ['name' => 'IT', 'count' => 18, 'lead' => 'Nguyễn Quốc Huy'],
        ];

        $recentEvents = [
            ['title' => 'Nhân viên mới được thêm', 'time' => '5 phút trước', 'detail' => 'Đã tạo hồ sơ EMP-00129 cho phòng Kinh doanh.'],
            ['title' => 'Đổi phòng ban', 'time' => '18 phút trước', 'detail' => 'Chuyển 2 nhân viên từ CSKH sang Kinh doanh.'],
            ['title' => 'Cập nhật chức danh', 'time' => '35 phút trước', 'detail' => 'Thay đổi chức danh của 1 nhân viên IT.'],
            ['title' => 'Bổ sung ảnh đại diện', 'time' => '1 giờ trước', 'detail' => 'Hoàn thiện hồ sơ cho 3 nhân viên mới.'],
        ];

        return view('livewire.pages.employees.index', compact(
            'departments',
            'employees',
            'stats',
            'quickActions',
            'departmentSummary',
            'recentEvents'
        ));
    }
}
