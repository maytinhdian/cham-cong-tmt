<?php

namespace App\Http\Livewire\Pages\Departments;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $departments = [
            [
                'name' => 'Nhân sự',
                'manager' => 'Nguyễn Thị Hạnh',
                'headcount' => 8,
                'status' => 'Đang hoạt động',
                'color' => 'success',
            ],
            [
                'name' => 'Kinh doanh',
                'manager' => 'Trần Văn Minh',
                'headcount' => 14,
                'status' => 'Đang hoạt động',
                'color' => 'primary',
            ],
            [
                'name' => 'Kế toán',
                'manager' => 'Phạm Thu Hà',
                'headcount' => 6,
                'status' => 'Đang hoạt động',
                'color' => 'warning',
            ],
            [
                'name' => 'CSKH',
                'manager' => 'Lê Hoài Nam',
                'headcount' => 11,
                'status' => 'Cần bổ sung',
                'color' => 'dark',
            ],
        ];

        $activityLogs = [
            ['action' => 'Tạo mới phòng ban IT', 'time' => '2 phút trước', 'detail' => 'Thêm trưởng phòng và phân quyền truy cập.'],
            ['action' => 'Cập nhật CSKH', 'time' => '12 phút trước', 'detail' => 'Tăng định biên từ 9 lên 11 nhân sự.'],
            ['action' => 'Đổi người phụ trách', 'time' => '30 phút trước', 'detail' => 'Kế toán chuyển sang người duyệt mới.'],
            ['action' => 'Khóa phòng ban cũ', 'time' => '1 giờ trước', 'detail' => 'Ẩn phòng ban thử nghiệm khỏi danh sách.'],
        ];

        $quickStats = [
            ['label' => 'Phòng ban', 'value' => '04', 'icon' => 'apartment', 'color' => 'primary'],
            ['label' => 'Đang hoạt động', 'value' => '03', 'icon' => 'check_circle', 'color' => 'success'],
            ['label' => 'Cần bổ sung trưởng bộ phận', 'value' => '01', 'icon' => 'person_search', 'color' => 'warning'],
            ['label' => 'Tổng nhân sự', 'value' => '39', 'icon' => 'groups', 'color' => 'dark'],
        ];

        $assignmentNotes = [
            'Gán phòng ban mặc định khi tạo nhân viên mới',
            'Đồng bộ phòng ban với ca làm và bảng công',
            'Thiết lập trưởng bộ phận duyệt nghỉ phép / OT',
            'Cho phép ẩn phòng ban không còn sử dụng',
        ];

        return view('livewire.pages.departments.index', compact(
            'departments',
            'activityLogs',
            'quickStats',
            'assignmentNotes'
        ));
    }
}
