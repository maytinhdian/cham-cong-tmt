<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class Attendance extends Component
{
    public function render()
    {
        $summaryCards = [
            [
                'label' => 'Đã chấm công hôm nay',
                'value' => '126',
                'change' => '+8%',
                'icon' => 'how_to_reg',
                'color' => 'success',
            ],
            [
                'label' => 'Đang đi làm',
                'value' => '94',
                'change' => '78%',
                'icon' => 'badge',
                'color' => 'primary',
            ],
            [
                'label' => 'Đi muộn',
                'value' => '12',
                'change' => 'so với hôm qua',
                'icon' => 'schedule',
                'color' => 'warning',
            ],
            [
                'label' => 'Nghỉ phép / vắng',
                'value' => '7',
                'change' => '2 đang chờ duyệt',
                'icon' => 'event_busy',
                'color' => 'dark',
            ],
        ];

        $recentLogs = [
            ['name' => 'Nguyễn Văn A', 'dept' => 'Kinh doanh', 'in' => '08:02', 'out' => '17:29', 'status' => 'Đúng giờ'],
            ['name' => 'Trần Thị B', 'dept' => 'Kế toán', 'in' => '08:18', 'out' => '17:34', 'status' => 'Đi muộn 18p'],
            ['name' => 'Lê Minh C', 'dept' => 'Kho vận', 'in' => '07:56', 'out' => '17:12', 'status' => 'Đúng giờ'],
            ['name' => 'Phạm Quốc D', 'dept' => 'IT', 'in' => '08:31', 'out' => '17:41', 'status' => 'Đi muộn 31p'],
            ['name' => 'Huỳnh Yến E', 'dept' => 'CSKH', 'in' => '08:04', 'out' => '17:25', 'status' => 'Đúng giờ'],
        ];

        $shiftCards = [
            ['title' => 'Ca sáng', 'time' => '08:00 - 17:00', 'members' => '86 nhân sự', 'color' => 'success'],
            ['title' => 'Ca chiều', 'time' => '13:00 - 22:00', 'members' => '24 nhân sự', 'color' => 'primary'],
            ['title' => 'Ca linh hoạt', 'time' => 'Theo đăng ký', 'members' => '16 nhân sự', 'color' => 'warning'],
        ];

        $requests = [
            ['name' => 'Nghỉ phép năm', 'person' => 'Nguyễn Thị H', 'time' => '09:20', 'status' => 'Chờ duyệt'],
            ['name' => 'Đi công tác', 'person' => 'Phạm Văn K', 'time' => '10:05', 'status' => 'Đã duyệt'],
            ['name' => 'Làm bù cuối tuần', 'person' => 'Lê Thị M', 'time' => '11:40', 'status' => 'Chờ duyệt'],
        ];

        return view('livewire.pages.attendance', compact(
            'summaryCards',
            'recentLogs',
            'shiftCards',
            'requests'
        ));
    }
}
