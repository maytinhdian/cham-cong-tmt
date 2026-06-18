<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-xxl bg-gradient-dark">
                                <span class="text-white font-weight-bold fs-4">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-1">{{ $employee->full_name }}</h4>
                            <p class="text-sm text-secondary mb-1">
                                {{ $employee->employee_code }}
                                @if ($employee->department)
                                    - {{ $employee->department->name }}
                                @endif
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($employee->work_status === 'active')
                                    <span class="badge bg-gradient-success">Đang làm việc</span>
                                @elseif ($employee->work_status === 'probation')
                                    <span class="badge bg-gradient-info">Thử việc</span>
                                @else
                                    <span class="badge bg-gradient-secondary">Tạm ngưng</span>
                                @endif
                                <span class="badge bg-gradient-dark">{{ $employee->position?->name ?? 'Chưa gán chức vụ' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Quay lại danh sách</a>
                            <a href="{{ route('new-user') }}" class="btn bg-gradient-dark mb-0 ms-lg-2 mt-2 mt-lg-0">Thêm nhân viên</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card h-100">
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
                            <strong class="text-dark">Giới tính:</strong> &nbsp;
                            @if ($employee->gender === 'male')
                                Nam
                            @elseif ($employee->gender === 'female')
                                Nữ
                            @elseif ($employee->gender)
                                Khác
                            @else
                                Chưa cập nhật
                            @endif
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
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card h-100">
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
                            <i class="material-icons-round text-white text-sm">event_available</i>
                        </div>
                        <div>
                            <p class="text-xs text-secondary mb-0">Trạng thái</p>
                            <h6 class="mb-0 text-sm">
                                @if ($employee->work_status === 'active')
                                    Đang làm việc
                                @elseif ($employee->work_status === 'probation')
                                    Thử việc
                                @else
                                    Tạm ngưng
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card h-100">
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
                        <li class="list-group-item border-0 ps-0 pb-0 text-sm">
                            <strong class="text-dark">Ghi chú:</strong> &nbsp; {{ $employee->note ?: 'Không có ghi chú' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Chấm công tháng này</p>
                            <h5 class="mb-0">Chưa nối dữ liệu</h5>
                        </div>
                    </div>
                    <p class="text-xs text-secondary mt-3 mb-0">Sẽ lấy từ module Attendance khi có bảng log và bảng công.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">beach_access</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Nghỉ phép</p>
                            <h5 class="mb-0">Chưa nối dữ liệu</h5>
                        </div>
                    </div>
                    <p class="text-xs text-secondary mt-3 mb-0">Sẽ nối với module Leave để xem phép năm, phép đã dùng và đơn nghỉ.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-warning shadow text-center border-radius-md me-3">
                            <i class="material-icons opacity-10">more_time</i>
                        </div>
                        <div>
                            <p class="text-sm mb-0 text-secondary">Tăng ca</p>
                            <h5 class="mb-0">Chưa nối dữ liệu</h5>
                        </div>
                    </div>
                    <p class="text-xs text-secondary mt-3 mb-0">Sẽ nối với module Overtime khi có đăng ký và phê duyệt OT.</p>
                </div>
            </div>
        </div>
    </div>
</div>
