<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AttendanceReport extends Component
{
    public function render()
    {
        $summaryCards = [
            ['label' => 'Tổng công hợp lệ', 'value' => '2,486', 'icon' => 'fact_check', 'color' => 'success'],
            ['label' => 'Đi muộn', 'value' => '126', 'icon' => 'schedule', 'color' => 'warning'],
            ['label' => 'Vắng mặt', 'value' => '18', 'icon' => 'event_busy', 'color' => 'dark'],
            ['label' => 'OT đã duyệt', 'value' => '214 giờ', 'icon' => 'schedule_send', 'color' => 'primary'],
        ];

        $monthlyTrend = [
            ['month' => 'T1', 'late' => 22, 'absent' => 4, 'ot' => 30],
            ['month' => 'T2', 'late' => 18, 'absent' => 3, 'ot' => 36],
            ['month' => 'T3', 'late' => 25, 'absent' => 6, 'ot' => 40],
            ['month' => 'T4', 'late' => 19, 'absent' => 5, 'ot' => 42],
            ['month' => 'T5', 'late' => 15, 'absent' => 2, 'ot' => 33],
            ['month' => 'T6', 'late' => 27, 'absent' => 3, 'ot' => 48],
        ];

        $lateEmployees = [
            ['name' => 'Trần Thị B', 'department' => 'Kế toán', 'late' => '18 phút', 'count' => 4],
            ['name' => 'Phạm Quốc D', 'department' => 'IT', 'late' => '31 phút', 'count' => 6],
            ['name' => 'Lê Minh C', 'department' => 'CSKH', 'late' => '12 phút', 'count' => 3],
            ['name' => 'Huỳnh Yến E', 'department' => 'Nhân sự', 'late' => '09 phút', 'count' => 2],
        ];

        $absenceSummary = [
            ['name' => 'Nghỉ phép', 'count' => 7, 'color' => 'primary'],
            ['name' => 'Nghỉ không phép', 'count' => 3, 'color' => 'danger'],
            ['name' => 'Đi công tác', 'count' => 5, 'color' => 'warning'],
            ['name' => 'Nghỉ ốm', 'count' => 2, 'color' => 'dark'],
        ];

        $exportTemplates = [
            'Báo cáo công ngày',
            'Báo cáo công tháng',
            'Báo cáo đi muộn / về sớm',
            'Báo cáo OT',
            'Báo cáo vắng mặt',
        ];

        $rules = [
            'Tổng hợp theo ngày, tuần hoặc tháng',
            'Lọc theo phòng ban, chức danh, ca làm',
            'Xuất file Excel/PDF để nộp kế toán',
            'Cho phép đối chiếu công thực tế và công chuẩn',
            'Hiển thị các trường hợp cần xử lý thủ công',
        ];

        $recentReports = [
            ['title' => 'Báo cáo tháng 6', 'time' => '5 phút trước', 'detail' => 'Đã tổng hợp 128 nhân sự, 214 giờ OT.'],
            ['title' => 'Đi muộn tuần này', 'time' => '20 phút trước', 'detail' => 'Tăng 3% so với tuần trước.'],
            ['title' => 'Vắng mặt', 'time' => '45 phút trước', 'detail' => 'Có 3 trường hợp chưa nộp đơn.'],
            ['title' => 'Xuất file', 'time' => '1 giờ trước', 'detail' => 'Đã tạo file báo cáo công tháng 06.'],
        ];

        return view('livewire.pages.attendance-report', compact(
            'summaryCards',
            'monthlyTrend',
            'lateEmployees',
            'absenceSummary',
            'exportTemplates',
            'rules',
            'recentReports'
        ));
    }
}
