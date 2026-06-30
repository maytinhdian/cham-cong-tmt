<?php

namespace Modules\Core\Authorization;

class PermissionRegistry
{
    /**
     * List every supported business permission with module grouping metadata.
     */
    public static function permissions(): array
    {
        return [
            'employees.view' => ['module' => 'employees', 'label' => 'Xem nhân sự'],
            'employees.manage' => ['module' => 'employees', 'label' => 'Quản lý nhân sự'],
            'attendance.settings.manage' => ['module' => 'attendance', 'label' => 'Quản lý cài đặt chấm công'],
            'attendance.schedules.manage' => ['module' => 'attendance', 'label' => 'Quản lý lịch làm việc'],
            'attendance.devices.manage' => ['module' => 'attendance', 'label' => 'Quản lý thiết bị chấm công'],
            'attendance.raw_logs.view' => ['module' => 'attendance', 'label' => 'Xem log chấm công'],
            'attendance.raw_logs.manage' => ['module' => 'attendance', 'label' => 'Quản lý log chấm công'],
            'attendance.processing.run' => ['module' => 'attendance', 'label' => 'Xử lý log chấm công'],
            'attendance.timesheet.view' => ['module' => 'attendance', 'label' => 'Xem bảng công'],
            'attendance.timesheet.view_all' => ['module' => 'attendance', 'label' => 'Xem bảng công tất cả nhân viên'],
            'attendance.timesheet.adjust' => ['module' => 'attendance', 'label' => 'Điều chỉnh bảng công'],
            'attendance.timesheet.generate' => ['module' => 'attendance', 'label' => 'Tổng hợp bảng công tháng'],
            'attendance.timesheet.close' => ['module' => 'attendance', 'label' => 'Chốt bảng công'],
            'reports.view' => ['module' => 'reports', 'label' => 'Xem báo cáo'],
            'reports.export' => ['module' => 'reports', 'label' => 'Xuất báo cáo'],
            'authorization.manage' => ['module' => 'authorization', 'label' => 'Quản lý người dùng và phân quyền'],
        ];
    }

    /**
     * Provide the complete permission name list used when registering Gates.
     */
    public static function names(): array
    {
        return array_keys(self::permissions());
    }

    /**
     * Map business roles to their default permission set for seed data.
     */
    public static function rolePermissions(): array
    {
        return [
            'Admin' => self::names(),
            'Super Admin' => self::names(),
            'HR Manager' => array_values(array_diff(self::names(), ['authorization.manage'])),
            'HR Staff' => [
                'employees.view',
                'employees.manage',
                'attendance.settings.manage',
                'attendance.schedules.manage',
                'attendance.devices.manage',
                'attendance.raw_logs.view',
                'attendance.raw_logs.manage',
                'attendance.processing.run',
                'attendance.timesheet.view',
                'attendance.timesheet.view_all',
                'attendance.timesheet.adjust',
                'attendance.timesheet.generate',
                'reports.view',
                'reports.export',
            ],
            'Department Manager' => [
                'employees.view',
                'attendance.schedules.manage',
                'attendance.raw_logs.view',
                'attendance.timesheet.view',
                'reports.view',
            ],
            'Employee' => [
                'attendance.timesheet.view',
            ],
            'Creator' => [
                'employees.view',
                'attendance.raw_logs.view',
                'attendance.timesheet.view',
                'reports.view',
            ],
            'Member' => [
                'attendance.timesheet.view',
            ],
        ];
    }
}
