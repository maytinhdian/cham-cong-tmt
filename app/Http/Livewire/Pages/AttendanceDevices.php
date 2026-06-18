<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AttendanceDevices extends Component
{
    public function render()
    {
        $summaryCards = [
            ['label' => 'Thiết bị online', 'value' => '08', 'icon' => 'devices', 'color' => 'success'],
            ['label' => 'Thiết bị offline', 'value' => '02', 'icon' => 'portable_wifi_off', 'color' => 'warning'],
            ['label' => 'Lần đồng bộ hôm nay', 'value' => '126', 'icon' => 'sync', 'color' => 'primary'],
            ['label' => 'Cảnh báo', 'value' => '03', 'icon' => 'report_problem', 'color' => 'dark'],
        ];

        $devices = [
            [
                'name' => 'Máy vân tay tầng 1',
                'code' => 'DEV-001',
                'type' => 'Fingerprint',
                'location' => 'Sảnh chính - Hà Nội',
                'status' => 'Online',
                'color' => 'success',
                'last_sync' => '2 phút trước',
            ],
            [
                'name' => 'Máy QR phòng CSKH',
                'code' => 'DEV-002',
                'type' => 'QR / Mobile',
                'location' => 'Tầng 3 - CSKH',
                'status' => 'Online',
                'color' => 'primary',
                'last_sync' => '5 phút trước',
            ],
            [
                'name' => 'Thiết bị RFID kho',
                'code' => 'DEV-003',
                'type' => 'RFID',
                'location' => 'Kho vận',
                'status' => 'Offline',
                'color' => 'warning',
                'last_sync' => '2 giờ trước',
            ],
            [
                'name' => 'Mobile GPS - IT',
                'code' => 'DEV-004',
                'type' => 'Mobile / GPS',
                'location' => 'Hybrid',
                'status' => 'Online',
                'color' => 'dark',
                'last_sync' => '10 phút trước',
            ],
        ];

        $syncLogs = [
            ['title' => 'Đồng bộ dữ liệu ca sáng', 'time' => '3 phút trước', 'detail' => 'Đã đẩy 48 lượt check-in từ máy vân tay.'],
            ['title' => 'Lỗi kết nối RFID', 'time' => '20 phút trước', 'detail' => 'Thiết bị DEV-003 mất kết nối tạm thời.'],
            ['title' => 'Đồng bộ OCR / QR', 'time' => '40 phút trước', 'detail' => 'Tất cả bản ghi đã được cập nhật vào bảng công.'],
            ['title' => 'Cập nhật firmware', 'time' => '1 giờ trước', 'detail' => 'Máy DEV-001 đã nâng cấp firmware phiên bản mới.'],
        ];

        $configurations = [
            'Bắt buộc đồng bộ dữ liệu sau mỗi 5 phút',
            'Tự động cảnh báo khi thiết bị offline quá 15 phút',
            'Cho phép nhận diện khuôn mặt ở thiết bị hỗ trợ',
            'Khóa chấm công ngoài vùng GPS với nhóm hybrid',
            'Gán thiết bị theo phòng ban / chi nhánh',
        ];

        $deployment = [
            ['team' => 'Kinh doanh', 'device' => 'QR / Mobile', 'scope' => 'Tầng 2 - Hà Nội'],
            ['team' => 'CSKH', 'device' => 'QR + Máy vân tay', 'scope' => 'Tầng 3 - Hà Nội'],
            ['team' => 'Kho vận', 'device' => 'RFID + Camera', 'scope' => 'Kho trung tâm'],
            ['team' => 'IT', 'device' => 'Mobile GPS', 'scope' => 'Hybrid / Remote'],
        ];

        $maintenance = [
            ['title' => 'Kiểm tra pin / nguồn', 'hint' => 'Theo lịch hàng tuần'],
            ['title' => 'Đồng bộ firmware', 'hint' => 'Theo lịch hàng tháng'],
            ['title' => 'Kiểm tra kết nối mạng', 'hint' => 'Theo dõi realtime'],
            ['title' => 'Xác nhận log chấm công', 'hint' => 'Đối chiếu cuối ngày'],
        ];

        $deviceTypes = [
            ['label' => 'Fingerprint', 'count' => 3, 'color' => 'primary'],
            ['label' => 'QR / Mobile', 'count' => 4, 'color' => 'success'],
            ['label' => 'RFID', 'count' => 2, 'color' => 'warning'],
            ['label' => 'Mobile GPS', 'count' => 1, 'color' => 'dark'],
        ];

        return view('livewire.pages.attendance-devices', compact(
            'summaryCards',
            'devices',
            'syncLogs',
            'configurations',
            'deployment',
            'maintenance',
            'deviceTypes'
        ));
    }
}
