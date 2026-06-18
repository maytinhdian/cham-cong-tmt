<?php

namespace App\Http\Livewire\Pages\Requests;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $stats = [
            ['label' => 'Đơn chờ duyệt', 'value' => '12', 'icon' => 'hourglass_empty', 'color' => 'warning'],
            ['label' => 'Nghỉ phép', 'value' => '07', 'icon' => 'event_busy', 'color' => 'primary'],
            ['label' => 'OT', 'value' => '04', 'icon' => 'schedule_send', 'color' => 'success'],
            ['label' => 'Công tác', 'value' => '03', 'icon' => 'work', 'color' => 'dark'],
        ];

        $requestTypes = [
            ['name' => 'Nghỉ phép năm', 'hint' => 'Trừ vào phép năm còn lại'],
            ['name' => 'Nghỉ ốm', 'hint' => 'Cần giấy xác nhận nếu vượt ngưỡng'],
            ['name' => 'Làm thêm giờ', 'hint' => 'Tính OT theo hệ số cấu hình'],
            ['name' => 'Công tác', 'hint' => 'Ghi nhận di chuyển công tác'],
            ['name' => 'Đổi ca', 'hint' => 'Thay đổi lịch làm trong ngày'],
        ];

        $pendingRequests = [
            [
                'employee' => 'Nguyễn Văn A',
                'code' => 'EMP-0001',
                'type' => 'Nghỉ phép năm',
                'from' => '20/06/2026',
                'to' => '21/06/2026',
                'status' => 'Chờ duyệt',
                'color' => 'warning',
                'reason' => 'Có việc gia đình đột xuất',
            ],
            [
                'employee' => 'Trần Thị B',
                'code' => 'EMP-0002',
                'type' => 'Làm thêm giờ',
                'from' => '18:00 - 21:00',
                'to' => '18:00 - 21:00',
                'status' => 'Chờ duyệt',
                'color' => 'primary',
                'reason' => 'Chốt số cuối tháng',
            ],
            [
                'employee' => 'Lê Minh C',
                'code' => 'EMP-0003',
                'type' => 'Công tác',
                'from' => '22/06/2026',
                'to' => '24/06/2026',
                'status' => 'Đang duyệt',
                'color' => 'dark',
                'reason' => 'Thăm khách hàng chi nhánh miền Trung',
            ],
        ];

        $history = [
            ['title' => 'Đã duyệt nghỉ phép', 'time' => '5 phút trước', 'detail' => 'Huỳnh Yến E được duyệt nghỉ 1 ngày.'],
            ['title' => 'Từ chối OT', 'time' => '20 phút trước', 'detail' => 'Lý do: chưa đủ thời gian OT tối thiểu.'],
            ['title' => 'Chuyển trạng thái', 'time' => '35 phút trước', 'detail' => 'Đơn công tác của Lê Minh C đang chờ duyệt cấp 2.'],
            ['title' => 'Gửi nhắc nhở', 'time' => '1 giờ trước', 'detail' => 'Nhắc quản lý duyệt đơn nghỉ cho tuần này.'],
        ];

        $approvalMatrix = [
            ['type' => 'Nghỉ phép', 'level' => 'Trưởng phòng', 'rule' => 'Duyệt trước 1 ngày làm việc'],
            ['type' => 'OT', 'level' => 'Quản lý trực tiếp', 'rule' => 'Duyệt trước khi hết ca'],
            ['type' => 'Công tác', 'level' => 'HR + Quản lý', 'rule' => 'Duyệt theo cấp 2'],
            ['type' => 'Đổi ca', 'level' => 'Trưởng nhóm', 'rule' => 'Duyệt trong ngày'],
        ];

        $policyNotes = [
            'Cho phép đính kèm file minh chứng',
            'Tự động gửi email khi chuyển trạng thái',
            'Có thể chỉnh ngưỡng duyệt theo phòng ban',
            'Tự động cập nhật bảng công sau khi duyệt',
            'Lưu lịch sử ai duyệt, lúc nào, lý do gì',
        ];

        $workflow = [
            ['step' => '1', 'title' => 'Tạo đơn', 'detail' => 'Nhân viên tạo yêu cầu từ app hoặc web.'],
            ['step' => '2', 'title' => 'Kiểm tra', 'detail' => 'Hệ thống kiểm tra trùng lịch, tồn phép và quy tắc OT.'],
            ['step' => '3', 'title' => 'Duyệt', 'detail' => 'Quản lý xác nhận hoặc từ chối.'],
            ['step' => '4', 'title' => 'Cập nhật công', 'detail' => 'Bảng công tự động phản ánh thay đổi.'],
        ];

        return view('livewire.pages.requests.index', compact(
            'stats',
            'requestTypes',
            'pendingRequests',
            'history',
            'approvalMatrix',
            'policyNotes',
            'workflow'
        ));
    }
}
