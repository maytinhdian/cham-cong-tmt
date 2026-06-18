<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AttendanceList extends Component
{
    public $summaryCards = [];

    public $filters = [];

    public $attendanceRecords = [];

    public $statusBreakdown = [];

    public $statusLabels = [];

    public $statusValues = [];

    public $departmentLabels = [];

    public $departmentValues = [];

    public $lateReasons = [];

    public $recentActivity = [];

    public function mount()
    {
        $this->summaryCards = [
            ['label' => 'Tổng log hôm nay', 'value' => '248', 'change' => '+18 so với hôm qua', 'icon' => 'description', 'color' => 'primary'],
            ['label' => 'Đúng giờ', 'value' => '187', 'change' => '76% tổng số', 'icon' => 'check_circle', 'color' => 'success'],
            ['label' => 'Đi muộn', 'value' => '21', 'change' => '9% tổng số', 'icon' => 'schedule', 'color' => 'warning'],
            ['label' => 'Vắng mặt', 'value' => '6', 'change' => '3% tổng số', 'icon' => 'cancel', 'color' => 'danger'],
            ['label' => 'Tăng ca', 'value' => '19', 'change' => '8% tổng số', 'icon' => 'nightlight', 'color' => 'info'],
        ];

        $this->filters = [
            ['label' => 'Ngày', 'value' => now()->format('d/m/Y')],
            ['label' => 'Phòng ban', 'value' => 'Tất cả phòng ban'],
            ['label' => 'Trạng thái', 'value' => 'Tất cả trạng thái'],
            ['label' => 'Nguồn', 'value' => 'QR + Máy chấm công'],
        ];

        $this->attendanceRecords = [
            ['name' => 'Nguyễn Văn A', 'dept' => 'Kinh doanh', 'shift' => 'Ca sáng', 'in' => '08:01', 'out' => '17:32', 'ot' => '00:30', 'status' => 'Đúng giờ', 'source' => 'QR'],
            ['name' => 'Trần Thị B', 'dept' => 'Kế toán', 'shift' => 'Ca sáng', 'in' => '08:12', 'out' => '17:28', 'ot' => '00:00', 'status' => 'Đi muộn 12p', 'source' => 'Máy'],
            ['name' => 'Lê Văn C', 'dept' => 'Sản xuất', 'shift' => 'Ca chiều', 'in' => '13:02', 'out' => '22:10', 'ot' => '00:45', 'status' => 'Tăng ca', 'source' => 'Mobile'],
            ['name' => 'Phạm Thu D', 'dept' => 'Hành chính', 'shift' => 'Ca sáng', 'in' => '08:00', 'out' => '--', 'ot' => '--', 'status' => 'Chưa check-out', 'source' => 'QR'],
            ['name' => 'Hoàng Minh E', 'dept' => 'Kho vận', 'shift' => 'Ca đêm', 'in' => '--', 'out' => '--', 'ot' => '--', 'status' => 'Vắng mặt', 'source' => 'Máy'],
            ['name' => 'Đỗ Ngọc F', 'dept' => 'CSKH', 'shift' => 'Ca sáng', 'in' => '08:06', 'out' => '17:18', 'ot' => '00:00', 'status' => 'Đúng giờ', 'source' => 'QR'],
            ['name' => 'Lý Gia G', 'dept' => 'IT', 'shift' => 'Hybrid', 'in' => '09:03', 'out' => '18:15', 'ot' => '01:15', 'status' => 'Tăng ca', 'source' => 'Mobile'],
            ['name' => 'Võ Thị H', 'dept' => 'Kinh doanh', 'shift' => 'Ca chiều', 'in' => '13:18', 'out' => '22:00', 'ot' => '00:00', 'status' => 'Đi muộn 18p', 'source' => 'Máy'],
        ];

        $this->statusBreakdown = [
            ['label' => 'Đúng giờ', 'value' => '187', 'color' => 'success'],
            ['label' => 'Đi muộn', 'value' => '21', 'color' => 'warning'],
            ['label' => 'Vắng mặt', 'value' => '6', 'color' => 'danger'],
            ['label' => 'Tăng ca', 'value' => '19', 'color' => 'info'],
        ];
        $this->statusLabels = array_column($this->statusBreakdown, 'label');
        $this->statusValues = array_map(static fn ($item) => (int) $item['value'], $this->statusBreakdown);

        $this->departmentLabels = ['Kinh doanh', 'Kế toán', 'Sản xuất', 'Hành chính', 'Kho vận', 'CSKH'];
        $this->departmentValues = [48, 26, 92, 27, 31, 24];

        $this->lateReasons = [
            ['reason' => 'Kẹt xe / đường xa', 'count' => 9],
            ['reason' => 'Quên check-in', 'count' => 4],
            ['reason' => 'Đi công tác', 'count' => 3],
            ['reason' => 'Lỗi thiết bị', 'count' => 2],
            ['reason' => 'Lý do cá nhân', 'count' => 3],
        ];

        $this->recentActivity = [
            ['title' => 'Import file chấm công', 'time' => '5 phút trước', 'detail' => 'Đã nhập 1.240 bản ghi từ máy cổng chính.'],
            ['title' => 'Sửa log thủ công', 'time' => '18 phút trước', 'detail' => 'Điều chỉnh giờ vào cho 3 nhân viên phòng Kinh doanh.'],
            ['title' => 'Đồng bộ thiết bị', 'time' => '35 phút trước', 'detail' => 'Máy kho vận đã đồng bộ lại sau khi mất kết nối.'],
            ['title' => 'Chốt công tạm', 'time' => '1 giờ trước', 'detail' => 'Chốt dữ liệu đến 12:00 để tính OT bán ca.'],
        ];
    }

    public function render()
    {
        return view('livewire.pages.attendance-list');
    }
}
