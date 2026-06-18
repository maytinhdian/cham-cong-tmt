<div class="container-fluid px-2 px-md-4 py-4">
    <div class="page-header min-height-250 border-radius-xl mt-2"
        style="background-image: url('{{ asset('assets') }}/img/office-dark.jpg'); background-position: center;">
        <span class="mask bg-gradient-dark opacity-6"></span>
    </div>

    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 align-items-center">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative bg-gradient-dark">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $employee->full_name }}" class="w-100 rounded-circle shadow-sm">
                    @else
                        <span class="text-white font-weight-bold fs-4">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">{{ $employee->full_name }}</h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        {{ $employee->employee_code }}
                        @if ($employee->department)
                            - {{ $employee->department->name }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-lg-5 col-md-7 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" href="{{ route('employee-list') }}">
                                <i class="material-icons text-lg position-relative">arrow_back</i>
                                <span class="ms-1">Danh sách</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" href="{{ route('attendance-schedules') }}">
                                <i class="material-icons text-lg position-relative">event</i>
                                <span class="ms-1">Lịch làm</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" href="{{ route('attendance-daily-timesheet') }}">
                                <i class="material-icons text-lg position-relative">fact_check</i>
                                <span class="ms-1">Bảng công</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-md-6 col-xl-4 position-relative">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Thông tin cá nhân</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                <strong class="text-dark">Họ tên:</strong> &nbsp; {{ $employee->full_name }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Mã nhân viên:</strong> &nbsp; {{ $employee->employee_code }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Giới tính:</strong> &nbsp; {{ $genderLabel }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Ngày sinh:</strong> &nbsp; {{ $employee->date_of_birth?->format('d/m/Y') ?? 'Chưa cập nhật' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 pb-0 text-sm">
                                <strong class="text-dark">Ngày vào làm:</strong> &nbsp; {{ $employee->hire_date?->format('d/m/Y') ?? 'Chưa cập nhật' }}
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="vertical dark">
            </div>

            <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Công việc</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm bg-gradient-primary me-3">
                                <i class="material-icons-round text-white text-sm">apartment</i>
                            </div>
                            <div>
                                <p class="text-xs text-secondary mb-0">Phòng ban</p>
                                <h6 class="mb-0 text-sm">{{ $employee->department?->name ?? 'Chưa gán' }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm bg-gradient-dark me-3">
                                <i class="material-icons-round text-white text-sm">badge</i>
                            </div>
                            <div>
                                <p class="text-xs text-secondary mb-0">Chức vụ</p>
                                <h6 class="mb-0 text-sm">{{ $employee->position?->name ?? 'Chưa gán' }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm bg-gradient-info me-3">
                                <i class="material-icons-round text-white text-sm">verified_user</i>
                            </div>
                            <div>
                                <p class="text-xs text-secondary mb-0">Trạng thái</p>
                                <span class="badge {{ $workStatus['badge'] }}">{{ $workStatus['label'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="vertical dark">
            </div>

            <div class="col-12 col-xl-4 mt-xl-0 mt-4">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Liên hệ</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                <strong class="text-dark">Email:</strong> &nbsp; {{ $employee->email ?: 'Chưa cập nhật' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Số điện thoại:</strong> &nbsp; {{ $employee->phone ?: 'Chưa cập nhật' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Tài khoản:</strong> &nbsp; {{ $employee->account?->email ?? 'Chưa liên kết' }}
                            </li>
                            <li class="list-group-item border-0 ps-0 pb-0 text-sm">
                                <strong class="text-dark">Ghi chú:</strong> &nbsp; {{ $employee->note ?: 'Không có ghi chú' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">event_available</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Lịch tháng này</p>
                            <h5 class="mb-0">{{ $attendanceSummary['scheduled_days'] }} ngày</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">fact_check</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Đã xử lý công</p>
                            <h5 class="mb-0">{{ $attendanceSummary['processed_days'] }} ngày</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Đi trễ</p>
                            <h5 class="mb-0">{{ $attendanceSummary['late_minutes'] }} phút</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">more_time</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Tăng ca</p>
                            <h5 class="mb-0">{{ $attendanceSummary['overtime_minutes'] }} phút</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Lịch làm việc sắp tới</h6>
                </div>
                <div class="card-body p-3">
                    @forelse ($upcomingSchedules as $schedule)
                        <div class="d-flex justify-content-between align-items-center border-radius-lg p-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                            <div>
                                <h6 class="text-sm mb-0">{{ $schedule->work_date->format('d/m/Y') }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $schedule->note ?: 'Không có ghi chú' }}</p>
                            </div>
                            <span class="badge bg-gradient-primary">{{ $schedule->shift?->code ?? strtoupper($schedule->schedule_type) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-secondary mb-0">Chưa có lịch làm việc sắp tới.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Kết quả chấm công gần đây</h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('attendance-daily-timesheet') }}" class="btn btn-link text-dark px-0 mb-0">
                                Xem bảng công
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ca</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vào / ra</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Công</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentAttendanceResults as $result)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $result->work_date->format('d/m/Y') }}</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-gradient-dark">{{ $result->shift?->code ?? 'Chưa gán' }}</span>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">
                                                {{ $result->clock_in_at?->format('H:i') ?? '--:--' }}
                                                /
                                                {{ $result->clock_out_at?->format('H:i') ?? '--:--' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">{{ $result->work_minutes }} phút</p>
                                            <p class="text-xs text-secondary mb-0">
                                                Trễ {{ $result->late_minutes }}p, sớm {{ $result->early_leave_minutes }}p
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if ($result->status === 'completed')
                                                <span class="badge badge-sm bg-gradient-success">Đủ công</span>
                                            @elseif ($result->status === 'missing_log')
                                                <span class="badge badge-sm bg-gradient-warning">Thiếu log</span>
                                            @elseif ($result->status === 'adjusted')
                                                <span class="badge badge-sm bg-gradient-info">Đã chỉnh</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">{{ strtoupper($result->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary text-sm py-4">
                                            Chưa có kết quả chấm công đã xử lý cho nhân viên này.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
