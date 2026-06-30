<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    @php
        $currentUser = auth()->user();
        $showTemplateMenus = $currentUser?->isSuperRole() ?? false;
        $showAttendanceSettings = $currentUser?->can('attendance.settings.manage') || $currentUser?->can('attendance.schedules.manage');
        $showDeviceMenus = $currentUser?->can('attendance.devices.manage') || $currentUser?->can('attendance.raw_logs.view') || $currentUser?->can('attendance.processing.run');
        $showTimesheetMenus = $currentUser?->can('attendance.timesheet.view');
        $showReportMenus = $currentUser?->can('reports.view');
        $showEmployeeMenus = $currentUser?->can('employees.view') || $currentUser?->can('employees.manage');
        $attendanceSettingRoutes = ['attendance-settings', 'attendance-schedules', 'attendance-shift-definition', 'attendance-weekend-definition', 'attendance-symbol-statistics'];
        $deviceRoutes = ['attendance-devices', 'attendance-device-user-mappings', 'attendance-raw-logs', 'attendance-process-logs', 'attendance-tabulator-demo'];
        $timesheetRoutes = ['attendance-daily-timesheet', 'attendance-monthly-timesheet'];
        $employeeRoutes = ['employee-list', 'new-user', 'employee-dashboard', 'employee-bulk-create', 'employee-department', 'employee-company-chart', 'employee-position'];
    @endphp

    <div class="sidenav-header">
        <i class="ni ni-fat-remove p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 p-4 d-flex align-items-center text-wrap" href="{{ route('analytics') }}">
            <span class="icon icon-sm icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-watch-time text-white opacity-10"></i>
            </span>
            <span class="ms-2 font-weight-bold text-white">TMT Time Attendance</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    @php
                        $userPicture = $currentUser->picture;
                        $defaultAvatar = asset('assets/img/default-avatar.png');
                        $avatarUrl = $userPicture && \Illuminate\Support\Facades\Storage::disk('public')->exists($userPicture)
                            ? \Illuminate\Support\Facades\Storage::url($userPicture)
                            : $defaultAvatar;
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="avatar" class="avatar"
                        onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
                    <span class="nav-link-text ms-2 ps-1">{{ $currentUser->name }}</span>
                </a>
                <div class="collapse" id="ProfileNav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'user-profile' ? 'active' : '' }}"
                                href="{{ route('user-profile') }}">
                                <span class="sidenav-mini-icon"> HS </span>
                                <span class="sidenav-normal ms-3 ps-1"> Hồ sơ cá nhân </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <livewire:auth.logout />
                        </li>
                    </ul>
                </div>
            </li>

            <hr class="horizontal light mt-0">

            @if ($showAttendanceSettings)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#attendanceExamples"
                        class="nav-link text-white {{ in_array(Route::currentRouteName(), $attendanceSettingRoutes, true) ? 'active' : '' }}"
                        aria-controls="attendanceExamples" role="button" aria-expanded="false">
                        <i class="ni ni-settings-gear-65 opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Cài đặt chấm công</span>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $attendanceSettingRoutes, true) ? 'show' : '' }}"
                        id="attendanceExamples">
                        <ul class="nav">
                            @can('attendance.settings.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-settings' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-settings' ? 'active' : '' }}"
                                        href="{{ route('attendance-settings') }}">
                                        <span class="sidenav-mini-icon"> CT </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Quy tắc tính công </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-shift-definition' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-shift-definition' ? 'active' : '' }}"
                                        href="{{ route('attendance-shift-definition') }}">
                                        <span class="sidenav-mini-icon"> KC </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Khai báo ca làm việc </span>
                                    </a>
                                </li>
                            @endcan
                            @can('attendance.schedules.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-schedules' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-schedules' ? 'active' : '' }}"
                                        href="{{ route('attendance-schedules') }}">
                                        <span class="sidenav-mini-icon"> LV </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Lịch làm việc </span>
                                    </a>
                                </li>
                            @endcan
                            @can('attendance.settings.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-weekend-definition' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-weekend-definition' ? 'active' : '' }}"
                                        href="{{ route('attendance-weekend-definition') }}">
                                        <span class="sidenav-mini-icon"> CN </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Khai báo ngày cuối tuần </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-symbol-statistics' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-symbol-statistics' ? 'active' : '' }}"
                                        href="{{ route('attendance-symbol-statistics') }}">
                                        <span class="sidenav-mini-icon"> KS </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Kí hiệu thống kê </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            @if ($showDeviceMenus)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#deviceExamples"
                        class="nav-link text-white {{ in_array(Route::currentRouteName(), $deviceRoutes, true) ? 'active' : '' }}"
                        aria-controls="deviceExamples" role="button" aria-expanded="false">
                        <i class="ni ni-tablet-button opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Thiết bị chấm công</span>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $deviceRoutes, true) ? 'show' : '' }}"
                        id="deviceExamples">
                        <ul class="nav">
                            @can('attendance.devices.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-devices' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-devices' ? 'active' : '' }}"
                                        href="{{ route('attendance-devices') }}">
                                        <span class="sidenav-mini-icon"> TB </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Quản lý thiết bị </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-device-user-mappings' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-device-user-mappings' ? 'active' : '' }}"
                                        href="{{ route('attendance-device-user-mappings') }}">
                                        <span class="sidenav-mini-icon"> MP </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Mapping nhân viên </span>
                                    </a>
                                </li>
                            @endcan
                            @can('attendance.raw_logs.view')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-raw-logs' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-raw-logs' ? 'active' : '' }}"
                                        href="{{ route('attendance-raw-logs') }}">
                                        <span class="sidenav-mini-icon"> LG </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Log chấm công </span>
                                    </a>
                                </li>
                            @endcan
                            @can('attendance.processing.run')
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-process-logs' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-process-logs' ? 'active' : '' }}"
                                        href="{{ route('attendance-process-logs') }}">
                                        <span class="sidenav-mini-icon"> XL </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Xử lý log </span>
                                    </a>
                                </li>
                            @endcan
                            @if ($showTemplateMenus)
                                <li class="nav-item {{ Route::currentRouteName() == 'attendance-tabulator-demo' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-tabulator-demo' ? 'active' : '' }}"
                                        href="{{ route('attendance-tabulator-demo') }}">
                                        <span class="sidenav-mini-icon"> TB </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Demo Tabulator </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if ($showTimesheetMenus)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#timesheetExamples"
                        class="nav-link text-white {{ in_array(Route::currentRouteName(), $timesheetRoutes, true) ? 'active' : '' }}"
                        aria-controls="timesheetExamples" role="button" aria-expanded="false">
                        <i class="ni ni-calendar-grid-58 opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Bảng công</span>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $timesheetRoutes, true) ? 'show' : '' }}"
                        id="timesheetExamples">
                        <ul class="nav">
                            <li class="nav-item {{ Route::currentRouteName() == 'attendance-daily-timesheet' ? 'active' : '' }}">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-daily-timesheet' ? 'active' : '' }}"
                                    href="{{ route('attendance-daily-timesheet') }}">
                                    <span class="sidenav-mini-icon"> NG </span>
                                    <span class="sidenav-normal ms-2 ps-1"> Bảng công ngày </span>
                                </a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'attendance-monthly-timesheet' ? 'active' : '' }}">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-monthly-timesheet' ? 'active' : '' }}"
                                    href="{{ route('attendance-monthly-timesheet') }}">
                                    <span class="sidenav-mini-icon"> TH </span>
                                    <span class="sidenav-normal ms-2 ps-1"> Bảng công tháng </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if ($showReportMenus)
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-reports' ? 'active' : '' }}"
                        href="{{ route('attendance-reports') }}">
                        <i class="ni ni-chart-bar-32 opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Báo biểu</span>
                    </a>
                </li>
            @endif

            @if ($showEmployeeMenus)
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#employeeExamples"
                        class="nav-link text-white {{ in_array(Route::currentRouteName(), $employeeRoutes, true) ? 'active' : '' }}"
                        aria-controls="employeeExamples" role="button" aria-expanded="false">
                        <i class="ni ni-badge opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Quản lý nhân viên</span>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $employeeRoutes, true) ? 'show' : '' }}"
                        id="employeeExamples">
                        <ul class="nav">
                            @can('employees.view')
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-dashboard' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-dashboard' ? 'active' : '' }}"
                                        href="{{ route('employee-dashboard') }}">
                                        <span class="sidenav-mini-icon"> DB </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Dashboard </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-list' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-list' ? 'active' : '' }}"
                                        href="{{ route('employee-list') }}">
                                        <span class="sidenav-mini-icon"> DS </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Danh sách nhân viên </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-company-chart' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-company-chart' ? 'active' : '' }}"
                                        href="{{ route('employee-company-chart') }}">
                                        <span class="sidenav-mini-icon"> SC </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Sơ đồ công ty </span>
                                    </a>
                                </li>
                            @endcan
                            @can('employees.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'new-user' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'new-user' ? 'active' : '' }}"
                                        href="{{ route('new-user') }}">
                                        <span class="sidenav-mini-icon"> + </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Thêm nhân viên </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-bulk-create' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-bulk-create' ? 'active' : '' }}"
                                        href="{{ route('employee-bulk-create') }}">
                                        <span class="sidenav-mini-icon"> XL </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Thêm nhân viên hàng loạt </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-department' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-department' ? 'active' : '' }}"
                                        href="{{ route('employee-department') }}">
                                        <span class="sidenav-mini-icon"> PB </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Phòng ban </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'employee-position' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-position' ? 'active' : '' }}"
                                        href="{{ route('employee-position') }}">
                                        <span class="sidenav-mini-icon"> CV </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Chức vụ </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            @if ($showTemplateMenus)
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder text-white">Quản trị hệ thống</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::currentRouteName() == 'analytics' ? 'active' : '' }}"
                        href="{{ route('analytics') }}">
                        <i class="ni ni-shop opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#adminExamples"
                        class="nav-link text-white {{ str_contains(Route::currentRouteName() ?? '', 'role') || str_contains(Route::currentRouteName() ?? '', 'user-management') ? 'active' : '' }}"
                        aria-controls="adminExamples" role="button" aria-expanded="false">
                        <i class="ni ni-single-02 opacity-10"></i>
                        <span class="nav-link-text ms-2 ps-1">Người dùng & quyền</span>
                    </a>
                    <div class="collapse {{ str_contains(Route::currentRouteName() ?? '', 'role') || str_contains(Route::currentRouteName() ?? '', 'user-management') ? 'show' : '' }}"
                        id="adminExamples">
                        <ul class="nav">
                            @can('authorization.manage')
                                <li class="nav-item {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                                        href="{{ route('user-management') }}">
                                        <span class="sidenav-mini-icon"> US </span>
                                        <span class="sidenav-normal ms-2 ps-1"> User Management </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Route::currentRouteName() == 'role-management' ? 'active' : '' }}">
                                    <a class="nav-link text-white {{ Route::currentRouteName() == 'role-management' ? 'active' : '' }}"
                                        href="{{ route('role-management') }}">
                                        <span class="sidenav-mini-icon"> RQ </span>
                                        <span class="sidenav-normal ms-2 ps-1"> Vai trò & quyền </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</aside>
