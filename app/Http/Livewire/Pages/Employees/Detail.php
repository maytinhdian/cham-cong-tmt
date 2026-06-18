<?php

namespace App\Http\Livewire\Pages\Employees;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\User\Models\Employee;

class Detail extends Component
{
    public Employee $employee;

    /**
     * Load the selected employee profile with organization context for review.
     */
    public function mount(Employee $employee): void
    {
        $this->employee = $employee->load(['account', 'department', 'position']);
    }

    /**
     * Show employee identity, work assignment, upcoming schedule, and recent attendance.
     */
    public function render()
    {
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();

        return view('livewire.pages.employees.detail', [
            'employee' => $this->employee,
            'avatarUrl' => $this->employeeAvatarUrl(),
            'genderLabel' => $this->genderLabel(),
            'workStatus' => $this->workStatus(),
            'upcomingSchedules' => $this->employee
                ->schedules()
                ->with('shift')
                ->whereDate('work_date', '>=', now()->toDateString())
                ->orderBy('work_date')
                ->limit(5)
                ->get(),
            'recentAttendanceResults' => $this->employee
                ->dailyAttendanceResults()
                ->with('shift')
                ->orderByDesc('work_date')
                ->limit(5)
                ->get(),
            'attendanceSummary' => [
                'scheduled_days' => $this->employee
                    ->schedules()
                    ->whereBetween('work_date', [$monthStart, $monthEnd])
                    ->count(),
                'processed_days' => $this->employee
                    ->dailyAttendanceResults()
                    ->whereBetween('work_date', [$monthStart, $monthEnd])
                    ->count(),
                'late_minutes' => $this->employee
                    ->dailyAttendanceResults()
                    ->whereBetween('work_date', [$monthStart, $monthEnd])
                    ->sum('late_minutes'),
                'overtime_minutes' => $this->employee
                    ->dailyAttendanceResults()
                    ->whereBetween('work_date', [$monthStart, $monthEnd])
                    ->sum('overtime_minutes'),
            ],
        ]);
    }

    /**
     * Resolve a usable employee avatar while keeping the detail page stable.
     */
    private function employeeAvatarUrl(): ?string
    {
        if ($this->employee->avatar && Storage::disk('public')->exists($this->employee->avatar)) {
            return Storage::url($this->employee->avatar);
        }

        if ($this->employee->account?->picture && Storage::disk('public')->exists($this->employee->account->picture)) {
            return Storage::url($this->employee->account->picture);
        }

        return null;
    }

    /**
     * Translate the stored gender code into concise Vietnamese profile text.
     */
    private function genderLabel(): string
    {
        return match ($this->employee->gender) {
            'male' => 'Nam',
            'female' => 'Nữ',
            'other' => 'Khác',
            default => 'Chưa cập nhật',
        };
    }

    /**
     * Translate the stored work status into label and badge styling for HR review.
     */
    private function workStatus(): array
    {
        return match ($this->employee->work_status) {
            'active' => ['label' => 'Đang làm việc', 'badge' => 'bg-gradient-success'],
            'probation' => ['label' => 'Thử việc', 'badge' => 'bg-gradient-info'],
            default => ['label' => 'Tạm ngưng', 'badge' => 'bg-gradient-secondary'],
        };
    }
}
