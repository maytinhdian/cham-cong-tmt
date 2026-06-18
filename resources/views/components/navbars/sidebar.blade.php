<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
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
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    @php
                        $userPicture = auth()->user()->picture;
                        $defaultAvatar = asset('assets/img/default-avatar.png');
                        $avatarUrl = $userPicture && \Illuminate\Support\Facades\Storage::disk('public')->exists($userPicture)
                            ? \Illuminate\Support\Facades\Storage::url($userPicture)
                            : $defaultAvatar;
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="avatar" class="avatar"
                        onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
                    <span class="nav-link-text ms-2 ps-1">{{ auth()->user()->name }}</span>
                </a>
                <div class="collapse" id="ProfileNav" style="">
                    <ul class="nav ">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('overview') }}">
                                <span class="sidenav-mini-icon"> MP </span>
                                <span class="sidenav-normal  ms-3  ps-1"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="{{ route('settings') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Settings </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <livewire:auth.logout />
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0">
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#dashboardsExamples"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'dashboard')=== false ? '' : 'active' }} "
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <i class="ni ni-shop opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Dashboards</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'dashboard')=== false ? '' : 'show' }} "
                    id="dashboardsExamples">
                    <ul class="nav ">
                        <li class="nav-item {{ Route::currentRouteName() == 'analytics' ? 'active' : '' }}  ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'analytics' ? 'active' : '' }} "
                                href="{{ route('analytics') }}">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Analytics </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'discover' ? 'active' : '' }} ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'discover' ? 'active' : '' }}"
                                href="{{ route('discover') }}">
                                <span class="sidenav-mini-icon"> B </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Báº£ng tin </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'sales' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'sales' ? 'active' : '' }} "
                                href="{{ route('sales') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Sales </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'automotive' ? 'active' : '' }}  ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'automotive' ? 'active' : '' }} "
                                href="{{ route('automotive') }}">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Automotive </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'smart-home' ? 'active' : '' }}  ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'smart-home' ? 'active' : '' }} "
                                href="{{ route('smart-home') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Smart Home </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#LaravelExamples"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'laravel-examples')=== false ? '' : 'active' }} "
                    aria-controls="LaravelExamples" role="button" aria-expanded="false">
                    <i class="ni ni-laptop opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Laravel Examples</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'laravel-examples')=== false ? '' : 'show' }} "
                    id="LaravelExamples">
                    <ul class="nav ">
                        <li class="nav-item {{ Route::currentRouteName() == 'user-profile' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'user-profile' ? 'active' : '' }}  "
                                href="{{ route('user-profile') }}">
                                <span class="sidenav-mini-icon"> UP </span>
                                <span class="sidenav-normal  ms-2  ps-1"> User Profile <b class="caret"></b></span>
                            </a>
                        </li>
                        @can('manage-users', App\Models\User::class)
                        <li
                            class="nav-item {{ strpos(Request::route()->uri(), 'user-management')=== false ? '' : 'active' }}">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'user-management')=== false ? '' : 'active' }}  "
                                href="{{ route('user-management') }}">
                                <span class="sidenav-mini-icon"> UM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> User Management <b class="caret"></b></span>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ strpos(Request::route()->uri(), 'role-management')=== false ? '' : 'active' }} ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'role-management')=== false ? '' : 'active' }} "
                                href="{{ route('role-management') }}">
                                <span class="sidenav-mini-icon"> RM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Role Management <b class="caret"></b></span>
                            </a>
                        </li>
                        @endcan
                        @can('manage-items', App\Models\User::class)
                        <li class="nav-item {{ strpos(Request::route()->uri(), 'category')=== false ? '' : 'active' }}">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'category')=== false ? '' : 'active' }}  "
                                href="{{ route('category-management') }}">
                                <span class="sidenav-mini-icon"> CM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Category Management <b
                                        class="caret"></b></span>
                            </a>
                        </li>
                        <li class="nav-item {{ strpos(Request::route()->uri(), 'tag')=== false ? '' : 'active' }}">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'tag')=== false ? '' : 'active' }} "
                                href="{{ route('tag-management') }}">
                                <span class="sidenav-mini-icon"> TM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Tag Management <b class="caret"></b></span>
                            </a>
                        </li>
                        @endcan
                        @can('manage-items', App\Models\User::class)
                        <li class="nav-item {{ strpos(Request::route()->uri(), 'item')=== false ? '' : 'active' }}">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'item')=== false ? '' : 'active' }}"
                                href="{{ route('item-management') }}">
                                <span class="sidenav-mini-icon"> IM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Item Management <b class="caret"></b></span>
                            </a>
                        </li>
                        @else
                        <li class="nav-item {{ strpos(Request::route()->uri(), 'item')=== false ? '' : 'active' }}">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'item')=== false ? '' : 'active' }}  "
                                href="{{ route('item-management') }}">
                                <span class="sidenav-mini-icon"> IM </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Items <b class="caret"></b></span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#attendanceExamples"
                    class="nav-link text-white {{ in_array(Route::currentRouteName(), ['attendance-settings', 'attendance-schedules', 'attendance-shift-definition', 'attendance-weekend-definition', 'attendance-symbol-statistics']) ? 'active' : '' }}"
                    aria-controls="attendanceExamples" role="button" aria-expanded="false">
                    <i class="ni ni-settings-gear-65 opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Cài đặt chấm công</span>
                </a>
                <div class="collapse {{ in_array(Route::currentRouteName(), ['attendance-settings', 'attendance-schedules', 'attendance-shift-definition', 'attendance-weekend-definition', 'attendance-symbol-statistics']) ? 'show' : '' }}"
                    id="attendanceExamples">
                    <ul class="nav">
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
                        <li class="nav-item {{ Route::currentRouteName() == 'attendance-schedules' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-schedules' ? 'active' : '' }}"
                                href="{{ route('attendance-schedules') }}">
                                <span class="sidenav-mini-icon"> LV </span>
                                <span class="sidenav-normal ms-2 ps-1"> Lịch làm việc </span>
                            </a>
                        </li>
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
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#deviceExamples"
                    class="nav-link text-white {{ in_array(Route::currentRouteName(), ['attendance-devices']) ? 'active' : '' }}"
                    aria-controls="deviceExamples" role="button" aria-expanded="false">
                    <i class="ni ni-tablet-button opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Thiết bị chấm công</span>
                </a>
                <div class="collapse {{ in_array(Route::currentRouteName(), ['attendance-devices']) ? 'show' : '' }}"
                    id="deviceExamples">
                    <ul class="nav">
                        <li class="nav-item {{ Route::currentRouteName() == 'attendance-devices' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-devices' ? 'active' : '' }}"
                                href="{{ route('attendance-devices') }}">
                                <span class="sidenav-mini-icon"> TB </span>
                                <span class="sidenav-normal ms-2 ps-1"> Quản lý thiết bị </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'attendance-reports' ? 'active' : '' }}"
                    href="{{ route('attendance-reports') }}">
                    <i class="ni ni-chart-bar-32 opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Báo biểu</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#employeeExamples"
                    class="nav-link text-white {{ in_array(Route::currentRouteName(), ['employee-list', 'new-user', 'employee-dashboard', 'employee-bulk-create', 'employee-department', 'employee-company-chart', 'employee-position']) ? 'active' : '' }}"
                    aria-controls="employeeExamples" role="button" aria-expanded="false">
                    <i class="ni ni-badge opacity-10"></i>
                    <span class="nav-link-text ms-2 ps-1">Quản lý nhân viên</span>
                </a>
                <div class="collapse {{ in_array(Route::currentRouteName(), ['employee-list', 'new-user', 'employee-dashboard', 'employee-bulk-create', 'employee-department', 'employee-company-chart', 'employee-position']) ? 'show' : '' }}"
                    id="employeeExamples">
                    <ul class="nav">
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
                                <span class="sidenav-mini-icon"><i class="fas fa-file-excel text-success"></i></span>
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
                        <li class="nav-item {{ Route::currentRouteName() == 'employee-company-chart' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-company-chart' ? 'active' : '' }}"
                                href="{{ route('employee-company-chart') }}">
                                <span class="sidenav-mini-icon"> SC </span>
                                <span class="sidenav-normal ms-2 ps-1"> Sơ đồ công ty </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'employee-position' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'employee-position' ? 'active' : '' }}"
                                href="{{ route('employee-position') }}">
                                <span class="sidenav-mini-icon"> CV </span>
                                <span class="sidenav-normal ms-2 ps-1"> Chức vụ </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">PAGES</h6>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pagesExamples"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'pages') === false ? '' : 'active' }}  "
                    aria-controls="pagesExamples" role="button" aria-expanded="false">
                    <i class="ni ni-image me-2"></i>
                    <span class="nav-link-text ms-2 ps-1">Pages</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'pages') === false ? '' : 'show' }} "
                    id="pagesExamples">
                    <ul class="nav ">
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'profile') === false ? '' : 'active' }}  "
                                data-bs-toggle="collapse" aria-expanded="false" href="#profileExample">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Profile <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'profile') === false ? '' : 'show' }}  "
                                id="profileExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'overview' ? 'active' : '' }} "
                                            href="{{ route('overview') }}">
                                            <span class="sidenav-mini-icon"> P </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Profile Overview </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'projects' ? 'active' : '' }}"
                                            href="{{ route('projects') }}">
                                            <span class="sidenav-mini-icon"> A </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> All Projects </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'users') === false ? '' : 'active' }}   "
                                data-bs-toggle="collapse" aria-expanded="false" href="#usersExample">
                                <span class="sidenav-mini-icon"> U </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Users <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'users') === false ? '' : 'show' }} "
                                id="usersExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'reports' ? 'active' : '' }} "
                                            href="{{ route('reports') }}">
                                            <span class="sidenav-mini-icon"> R </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Reports </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'new-user' ? 'active' : '' }}"
                                            href="{{ route('new-user') }}">
                                            <span class="sidenav-mini-icon"> N </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> New User </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'account') === false ? '' : 'active' }}   "
                                data-bs-toggle="collapse" aria-expanded="false" href="#accountExample">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Account <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'account') === false ? '' : 'show' }}  "
                                id="accountExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'settings' ? 'active' : '' }} "
                                            href="{{ route('settings') }}">
                                            <span class="sidenav-mini-icon"> S </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Settings </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'billing' ? 'active' : '' }} "
                                            href="{{ route('billing') }}">
                                            <span class="sidenav-mini-icon"> B </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Billing </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'invoice' ? 'active' : '' }} "
                                            href="{{ route('invoice') }}">
                                            <span class="sidenav-mini-icon"> I </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Invoice </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'security' ? 'active' : '' }}"
                                            href="{{ route('security') }}">
                                            <span class="sidenav-mini-icon"> S </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Security </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'projects') === false ? '' : 'active' }}  "
                                data-bs-toggle="collapse" aria-expanded="false" href="#projectsExample">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Projects <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'projects') === false ? '' : 'show' }}   "
                                id="projectsExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'general' ? 'active' : '' }} "
                                            href="{{ route('general') }}">
                                            <span class="sidenav-mini-icon"> G </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> General </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'timeline' ? 'active' : '' }}"
                                            href="{{ route('timeline') }}">
                                            <span class="sidenav-mini-icon"> T </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Timeline </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'new-project' ? 'active' : '' }}"
                                            href="{{ route('new-project') }}">
                                            <span class="sidenav-mini-icon"> N </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> New Project </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'vr')=== false ? '' : 'active' }} "
                                data-bs-toggle="collapse" aria-expanded="false" href="#vrExamples">
                                <span class="sidenav-mini-icon"> V </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Virtual Reality <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'vr')=== false ? '' : 'show' }} "
                                id="vrExamples">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'vr-default' ? 'active' : '' }}"
                                            href="{{ route('vr-default') }}">
                                            <span class="sidenav-mini-icon"> V </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> VR Default </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'vr-info' ? 'active' : '' }}"
                                            href="{{ route('vr-info') }}">
                                            <span class="sidenav-mini-icon"> V </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> VR Info </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'pricing-page' ? 'active' : '' }}">
                            <a class="nav-link text-white  {{ Route::currentRouteName() == 'pricing-page' ? 'active' : '' }}"
                                href="{{ route('pricing-page') }}">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Pricing Page </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'rtl' ? 'active' : '' }}">
                            <a class="nav-link text-white  {{ Route::currentRouteName() == 'rtl' ? 'active' : '' }} "
                                href="{{ route('rtl') }}">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1"> RTL </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'widgets' ? 'active' : '' }}">
                            <a class="nav-link text-white  {{ Route::currentRouteName() == 'widgets' ? 'active' : '' }} "
                                href="{{ route('widgets') }}">
                                <span class="sidenav-mini-icon"> W </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Widgets </span>
                            </a>
                        </li>
                        <li class="nav-item  {{ Route::currentRouteName() == 'charts' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'charts' ? 'active' : '' }}"
                                href="{{ route('charts') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Charts </span>
                            </a>
                        </li>
                        <li class="nav-item  {{ Route::currentRouteName() == 'sweet-alerts' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'sweet-alerts' ? 'active' : '' }}"
                                href="{{ route('sweet-alerts') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Sweet Alerts </span>
                            </a>
                        </li>
                        <li class="nav-item  {{ Route::currentRouteName() == 'notifications' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'notifications' ? 'active' : '' }}"
                                href="{{ route('notifications') }}">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Notifications </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#applicationsExamples"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'applications') === false ? '' : 'active' }}"
                    aria-controls="applicationsExamples" role="button" aria-expanded="false">
                    <i class="ni ni-app me-2"></i>
                    <span class="nav-link-text ms-2 ps-1">Applications</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'applications') === false ? '' : 'show' }}"
                    id="applicationsExamples">
                    <ul class="nav ">
                        <li class="nav-item {{ Route::currentRouteName() == 'crm' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'crm' ? 'active' : '' }}"
                                href="{{ route('crm') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> CRM </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'kanban' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'kanban' ? 'active' : '' }}"
                                href="{{ route('kanban') }}">
                                <span class="sidenav-mini-icon"> K </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Kanban </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'wizard' ? 'active' : '' }} ">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'wizard' ? 'active' : '' }} "
                                href="{{ route('wizard') }}">
                                <span class="sidenav-mini-icon"> W </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Wizard </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'datatables' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'datatables' ? 'active' : '' }}"
                                href="{{ route('datatables') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal  ms-2  ps-1"> DataTables </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'calendar' ? 'active' : '' }}"
                                href="{{ route('calendar') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Calendar </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'stats' ? 'active' : '' }}">
                            <a class="nav-link text-white {{ Route::currentRouteName() == 'stats' ? 'active' : '' }} "
                                href="{{ route('stats') }}">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Stats </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#ecommerceExamples"
                    class="nav-link text-white {{ strpos(Request::route()->uri(), 'ecommerce')=== false ? '' : 'active' }} "
                    aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                    <i
                        class="ni ni-cart me-2"></i>
                    <span class="nav-link-text ms-2 ps-1">Ecommerce</span>
                </a>
                <div class="collapse {{ strpos(Request::route()->uri(), 'ecommerce')=== false ? '' : 'show' }}"
                    id="ecommerceExamples">
                    <ul class="nav ">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'products')=== false ? '' : 'active' }}"
                                data-bs-toggle="collapse" aria-expanded="false" href="#productsExample">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Products <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'products')=== false ? '' : 'show' }}"
                                id="productsExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'new-product' ? 'active' : '' }}"
                                            href="{{ route('new-product') }}">
                                            <span class="sidenav-mini-icon"> N </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> New Product </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'edit-product' ? 'active' : '' }}"
                                            href="{{ route('edit-product') }}">
                                            <span class="sidenav-mini-icon"> E </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Edit Product </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'product-page' ? 'active' : '' }} "
                                            href="{{ route('product-page') }}">
                                            <span class="sidenav-mini-icon"> P </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Product Page </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'products-list' ? 'active' : '' }} "
                                            href="{{ route('products-list') }}">
                                            <span class="sidenav-mini-icon"> P </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Products List </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ strpos(Request::route()->uri(), 'orders')===false ? '' : 'active' }}"
                                data-bs-toggle="collapse" aria-expanded="false" href="#ordersExample">
                                <span class="sidenav-mini-icon"> O </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Orders <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{ strpos(Request::route()->uri(), 'orders')===false ? '' : 'show' }}"
                                id="ordersExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'order-list' ? 'active' : '' }} "
                                            href="{{ route('order-list') }}">
                                            <span class="sidenav-mini-icon"> O </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Order List </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ Route::currentRouteName() == 'order-details' ? 'active' : '' }}"
                                            href="{{ route('order-details') }}">
                                            <span class="sidenav-mini-icon"> O </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Order Details </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'referral' ? 'active' : '' }}">
                            <a class="nav-link text-white  {{ Route::currentRouteName() == 'referral' ? 'active' : '' }}"
                                href="{{ route('referral') }}">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Referral </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#authExamples" class="nav-link text-white "
                    aria-controls="authExamples" role="button" aria-expanded="false">
                    <i
                        class="ni ni-single-copy-04 me-2"></i>
                    <span class="nav-link-text ms-2 ps-1">Authentication</span>
                </a>
                <div class="collapse " id="authExamples">
                    <ul class="nav ">
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="{{ route('cover-sign-in') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Sign In </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " data-bs-toggle="collapse" aria-expanded="false"
                                href="#signupExample">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Sign Up <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="signupExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{ route('basic-sign-up') }}">
                                            <span class="sidenav-mini-icon"> B </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Basic </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{ route('cover-sign-up') }}">
                                            <span class="sidenav-mini-icon"> C </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Cover </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{ route('illustration-sign-up') }}">
                                            <span class="sidenav-mini-icon"> I </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Illustration </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="{{ route('cover-reset') }}">
                                <span class="sidenav-mini-icon"> R </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Reset Password </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="{{ route('cover-lock') }}">
                                <span class="sidenav-mini-icon"> L </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Lock </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="{{ route('cover-verification') }}">
                                <span class="sidenav-mini-icon"> 2 </span>
                                <span class="sidenav-normal  ms-2  ps-1"> 2-Step Verification </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " data-bs-toggle="collapse" aria-expanded="false"
                                href="#errorExample">
                                <span class="sidenav-mini-icon"> E </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Error <b class="caret"></b></span>
                            </a>
                            <div class="collapse " id="errorExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{ route('error404') }}">
                                            <span class="sidenav-mini-icon"> E </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Error 404 </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white " href="{{ route('error500') }}">
                                            <span class="sidenav-mini-icon"> E </span>
                                            <span class="sidenav-normal  ms-2  ps-1"> Error 500 </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <hr class="horizontal light" />
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">DOCS</h6>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#componentsExamples" class="nav-link text-white "
                    aria-controls="componentsExamples" role="button" aria-expanded="false">
                    <i
                        class="ni ni-settings me-2"></i>
                    <span class="nav-link-text ms-2 ps-1">Components</span>
                </a>
                <div class="collapse " id="componentsExamples">
                    <ul class="nav ">
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/alerts.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> A </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Alerts </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/badge.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> B </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Badge </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/buttons.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> B </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Buttons </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/cards.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Card </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/carousel.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Carousel </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/collapse.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Collapse </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/dropdowns.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Dropdowns </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/forms.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> F </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Forms </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/modal.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> M </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Modal </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/navs.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Navs </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/navbar.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> N </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Navbar </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/pagination.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Pagination </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/popovers.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Popovers </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/progress.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> P </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Progress </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/spinners.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> S </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Spinners </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/tables.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> T </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Tables </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="../../documentation/components/tooltips.html"
                                target="_blank">
                                <span class="sidenav-mini-icon"> T </span>
                                <span class="sidenav-normal  ms-2  ps-1"> Tooltips </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>

