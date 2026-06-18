<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AttendanceSettings extends Component
{
    public function render()
    {
        $summaryCards = [
            ['label' => 'Thiết lập chung', 'value' => '08', 'icon' => 'tune', 'color' => 'primary'],
            ['label' => 'Quy tắc vào/ra', 'value' => '06', 'icon' => 'fact_check', 'color' => 'success'],
            ['label' => 'Quy tắc OT', 'value' => '05', 'icon' => 'schedule_send', 'color' => 'warning'],
            ['label' => 'Quy tắc ngoại lệ', 'value' => '07', 'icon' => 'rule', 'color' => 'dark'],
        ];

        $generalSettings = [
            ['label' => 'Giờ làm chuẩn', 'value' => '08:00 - 17:00', 'hint' => 'Áp dụng cho ca hành chính mặc định'],
            ['label' => 'Nghỉ trưa', 'value' => '12:00 - 13:00', 'hint' => 'Không tính công và không tính OT'],
            ['label' => 'Dung sai đi muộn', 'value' => '15 phút', 'hint' => 'Vượt quá sẽ tính đi muộn'],
            ['label' => 'Dung sai về sớm', 'value' => '10 phút', 'hint' => 'Vượt quá sẽ trừ công'],
            ['label' => 'Làm tròn công', 'value' => '15 phút', 'hint' => 'Làm tròn theo từng 15 phút'],
            ['label' => 'Khóa công khi thiếu dữ liệu', 'value' => 'Sau 3 lần', 'hint' => 'Áp dụng với quên check-out'],
            ['label' => 'Nguồn chấm công', 'value' => 'QR + Mobile + Máy', 'hint' => 'Cho phép nhiều nguồn ghi nhận'],
            ['label' => 'Phạm vi áp dụng', 'value' => 'Toàn công ty', 'hint' => 'Có thể ghi đè theo phòng ban'],
        ];

        $attendanceRules = [
            [
                'title' => 'Check-in',
                'detail' => 'Cho phép check-in từ 07:30 đến 09:00. Ngoài khung giờ này sẽ cần lý do hoặc phê duyệt.',
            ],
            [
                'title' => 'Check-out',
                'detail' => 'Cho phép check-out thủ công, tự động hoặc đồng bộ từ máy chấm công.',
            ],
            [
                'title' => 'Quên check-out',
                'detail' => 'Nếu quên check-out quá 3 lần trong tháng sẽ khóa công và gửi cảnh báo cho quản lý.',
            ],
            [
                'title' => 'Thiết bị hợp lệ',
                'detail' => 'Máy vân tay, RFID, QR Code, GPS trên mobile và nhập tay bởi quản lý.',
            ],
            [
                'title' => 'Xác thực vị trí',
                'detail' => 'Bật kiểm tra GPS khi chấm công ngoài văn phòng hoặc với nhóm hybrid.',
            ],
            [
                'title' => 'Chấm công nhiều lần',
                'detail' => 'Cho phép check-in/check-out nhiều lượt trong ngày với công thức cộng gộp.',
            ],
        ];

        $overtimeRules = [
            [
                'title' => 'OT ngày thường',
                'detail' => 'Tính từ 17:30, hệ số 150% và làm tròn theo 30 phút.',
            ],
            [
                'title' => 'OT cuối tuần',
                'detail' => 'Hệ số 200% cho thứ bảy, 250% cho chủ nhật nếu được duyệt trước.',
            ],
            [
                'title' => 'OT ngày lễ',
                'detail' => 'Hệ số 300% và phải gắn với lý do công việc hợp lệ.',
            ],
            [
                'title' => 'Ngưỡng tối thiểu',
                'detail' => 'Chỉ tính OT khi vượt quá 30 phút làm thêm.',
            ],
            [
                'title' => 'Tự động đề xuất OT',
                'detail' => 'Hệ thống tự tạo gợi ý OT khi nhân viên ở lại sau giờ làm chuẩn.',
            ],
        ];

        $leaveRules = [
            [
                'title' => 'Nghỉ phép năm',
                'detail' => 'Trừ 1 công nếu nghỉ nguyên ngày, 0.5 công nếu nghỉ nửa ngày.',
            ],
            [
                'title' => 'Nghỉ không phép',
                'detail' => 'Tự động trừ công và gửi cảnh báo cho quản lý trực tiếp.',
            ],
            [
                'title' => 'Nghỉ ốm',
                'detail' => 'Cần giấy tờ xác nhận nếu vượt quá số ngày cho phép.',
            ],
            [
                'title' => 'Nghỉ lễ',
                'detail' => 'Tự động đồng bộ theo lịch nghỉ lễ công ty và lịch quốc gia.',
            ],
        ];

        $departmentOverrides = [
            [
                'name' => 'Kinh doanh',
                'rule' => 'Check-in qua mobile + GPS',
                'overtime' => '150%',
                'leave' => 'Duyệt bởi Trưởng kinh doanh',
            ],
            [
                'name' => 'Kho vận',
                'rule' => 'Máy vân tay + ca đêm',
                'overtime' => '200%',
                'leave' => 'Duyệt bởi Quản lý kho',
            ],
            [
                'name' => 'IT',
                'rule' => 'Hybrid, linh hoạt giờ vào',
                'overtime' => '150%',
                'leave' => 'Duyệt bởi CTO / trưởng nhóm',
            ],
            [
                'name' => 'CSKH',
                'rule' => 'Ca xoay, chấm công theo ca',
                'overtime' => '180%',
                'leave' => 'Duyệt bởi trưởng bộ phận',
            ],
        ];

        $approvalLevels = [
            ['level' => 'Cấp 1', 'label' => 'Trưởng nhóm', 'scope' => 'Duyệt đi muộn, quên check-in/out'],
            ['level' => 'Cấp 2', 'label' => 'Trưởng phòng', 'scope' => 'Duyệt OT, nghỉ phép, đổi ca'],
            ['level' => 'Cấp 3', 'label' => 'HR / Admin', 'scope' => 'Khóa công, chỉnh công, cấu hình hệ thống'],
        ];

        $policyChecklist = [
            'Áp dụng lịch nghỉ lễ theo năm',
            'Bật cảnh báo đi muộn / về sớm qua email',
            'Cho phép quản lý chỉnh công có log',
            'Lưu lịch sử thay đổi từng cấu hình',
            'Chỉ định người duyệt theo phòng ban',
            'Ghi nhận lý do khi chấm công ngoài giờ',
        ];

        $history = [
            ['title' => 'Cập nhật dung sai đi muộn', 'time' => '3 phút trước', 'detail' => 'Tăng từ 10 phút lên 15 phút cho toàn công ty.'],
            ['title' => 'Bật GPS cho nhóm hybrid', 'time' => '20 phút trước', 'detail' => 'Áp dụng cho nhân viên làm việc ngoài văn phòng.'],
            ['title' => 'Đổi hệ số OT cuối tuần', 'time' => '42 phút trước', 'detail' => 'Giữ hệ số 200% cho thứ bảy, chủ nhật.'],
            ['title' => 'Đồng bộ lịch lễ', 'time' => '1 giờ trước', 'detail' => 'Cập nhật thêm ngày nghỉ lễ của năm hiện tại.'],
        ];

        $decisionMatrix = [
            ['case' => 'Đi muộn dưới 15 phút', 'result' => 'Không trừ công, chỉ ghi nhận vi phạm nhẹ'],
            ['case' => 'Quên check-out 1 lần', 'result' => 'Tự động nhắc và cho phép sửa tay'],
            ['case' => 'Quên check-out 3 lần', 'result' => 'Khóa công và gửi quản lý duyệt'],
            ['case' => 'Làm thêm sau 17:30', 'result' => 'Tạo bản ghi OT chờ duyệt'],
        ];

        return view('livewire.pages.attendance-settings', compact(
            'summaryCards',
            'generalSettings',
            'attendanceRules',
            'overtimeRules',
            'leaveRules',
            'departmentOverrides',
            'approvalLevels',
            'policyChecklist',
            'history',
            'decisionMatrix'
        ));
    }
}
