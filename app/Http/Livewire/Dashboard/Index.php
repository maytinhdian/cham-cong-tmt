<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public $summaryCards = [];

    public $trendLabels = [];

    public $attendanceSeries = [];

    public $lateSeries = [];

    public $statusBreakdown = [];

    public $statusLabels = [];

    public $statusValues = [];

    public $todayLogs = [];

    public $todayShifts = [];

    public $pendingRequests = [];

    public $deviceStatus = [];

    public $departmentOverview = [];

    public function mount()
    {
        $this->summaryCards = [
            ['label' => 'Tổng nhân viên', 'value' => '248', 'change' => '+12 so với tháng trước', 'icon' => 'groups', 'color' => 'primary'],
            ['label' => 'Đúng giờ', 'value' => '187', 'change' => '+8% so với hôm qua', 'icon' => 'check_circle', 'color' => 'success'],
            ['label' => 'Đi muộn', 'value' => '21', 'change' => '-4 ca so với hôm qua', 'icon' => 'schedule', 'color' => 'warning'],
            ['label' => 'Vắng mặt', 'value' => '6', 'change' => '-2 người so với tuần trước', 'icon' => 'cancel', 'color' => 'danger'],
            ['label' => 'Tăng ca', 'value' => '19', 'change' => '+5 người đang OT', 'icon' => 'nightlight', 'color' => 'info'],
            ['label' => 'Đơn chờ duyệt', 'value' => '14', 'change' => '3 đơn mới sáng nay', 'icon' => 'assignment_turned_in', 'color' => 'dark'],
        ];

        $this->trendLabels = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
        $this->attendanceSeries = [184, 190, 188, 192, 196, 201, 176];
        $this->lateSeries = [12, 10, 14, 9, 8, 11, 5];

        $this->statusBreakdown = [
            ['label' => 'Đúng giờ', 'value' => '187', 'percent' => '76%', 'color' => 'success'],
            ['label' => 'Đi muộn', 'value' => '21', 'percent' => '9%', 'color' => 'warning'],
            ['label' => 'Vắng mặt', 'value' => '6', 'percent' => '3%', 'color' => 'danger'],
            ['label' => 'Tăng ca', 'value' => '19', 'percent' => '8%', 'color' => 'info'],
        ];
        $this->statusLabels = array_column($this->statusBreakdown, 'label');
        $this->statusValues = array_map(static fn ($item) => (int) $item['value'], $this->statusBreakdown);

        $this->todayLogs = [
            ['name' => 'Nguyễn Văn A', 'dept' => 'Kinh doanh', 'in' => '08:01', 'out' => '17:32', 'status' => 'Đúng giờ'],
            ['name' => 'Trần Thị B', 'dept' => 'Kế toán', 'in' => '08:12', 'out' => '17:28', 'status' => 'Đi muộn 12p'],
            ['name' => 'Lê Văn C', 'dept' => 'Sản xuất', 'in' => '07:54', 'out' => '17:40', 'status' => 'Tăng ca'],
            ['name' => 'Phạm Thu D', 'dept' => 'Hành chính', 'in' => '08:00', 'out' => '--', 'status' => 'Chưa check-out'],
            ['name' => 'Hoàng Minh E', 'dept' => 'Kho vận', 'in' => '--', 'out' => '--', 'status' => 'Vắng mặt'],
        ];

        $this->todayShifts = [
            ['title' => 'Ca sáng', 'time' => '08:00 - 12:00', 'members' => '98 người', 'color' => 'success'],
            ['title' => 'Ca chiều', 'time' => '13:00 - 17:30', 'members' => '104 người', 'color' => 'primary'],
            ['title' => 'Ca đêm', 'time' => '22:00 - 06:00', 'members' => '12 người', 'color' => 'dark'],
        ];

        $this->pendingRequests = [
            ['name' => 'Nghỉ phép năm', 'person' => 'Nguyễn Văn A', 'time' => '08:10', 'status' => 'Chờ duyệt'],
            ['name' => 'OT cuối ngày', 'person' => 'Trần Thị B', 'time' => '08:42', 'status' => 'Chờ duyệt'],
            ['name' => 'Đổi ca', 'person' => 'Lê Văn C', 'time' => '09:05', 'status' => 'Đã duyệt'],
        ];

        $this->deviceStatus = [
            ['name' => 'Máy cổng chính', 'location' => 'Tầng 1', 'status' => 'Online', 'sync' => '2 phút trước'],
            ['name' => 'Máy xưởng A', 'location' => 'Khu sản xuất', 'status' => 'Online', 'sync' => '5 phút trước'],
            ['name' => 'Máy kho vận', 'location' => 'Kho trung tâm', 'status' => 'Cảnh báo', 'sync' => '18 phút trước'],
        ];

        $this->departmentOverview = [
            ['name' => 'Kinh doanh', 'headcount' => '48', 'late' => '6', 'rate' => '93%'],
            ['name' => 'Sản xuất', 'headcount' => '96', 'late' => '8', 'rate' => '90%'],
            ['name' => 'Hành chính', 'headcount' => '27', 'late' => '1', 'rate' => '98%'],
            ['name' => 'Kho vận', 'headcount' => '31', 'late' => '4', 'rate' => '92%'],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
