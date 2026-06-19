<?php

namespace App\Http\Livewire\Pages\Attendance;

use Livewire\Component;

class Settings extends Component
{
    /**
     * Render attendance rule settings grouped by the legacy rule dialog tabs.
     */
    public function render()
    {
        return view('livewire.pages.attendance.settings', [
            'weekdays' => [
                'sunday' => 'Chủ nhật',
                'monday' => 'Thứ hai',
                'tuesday' => 'Thứ ba',
                'wednesday' => 'Thứ tư',
                'thursday' => 'Thứ năm',
                'friday' => 'Thứ sáu',
                'saturday' => 'Thứ bảy',
            ],
            'statisticItems' => [
                'BLeave',
                'Normal',
                'Late',
                'Early',
                'Aff',
                'Absent',
                'OT',
                'Rest',
                'N/In',
                'N/Out',
                'ROT',
                'BOUT',
                'OUT',
                'FOT',
            ],
        ]);
    }
}
