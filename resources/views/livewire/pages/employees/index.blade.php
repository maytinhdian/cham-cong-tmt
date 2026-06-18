<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Danh sách nhân viên</h5>
            <p class="text-sm mb-0">
                Quản lý nhân sự theo phòng ban, theo dõi trạng thái làm việc, ca làm và các hoạt động gần đây.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Liên kết phòng ban</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Dùng cho chấm công</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($stats as $stat)
            <div class="col-xl-3 col-md-6 mt-md-0 mt-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-{{ $stat['color'] }} shadow-{{ $stat['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">{{ $stat['icon'] }}</i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-1 text-capitalize">{{ $stat['label'] }}</p>
                                <h4 class="mb-0">{{ $stat['value'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Nhân viên theo phòng ban</h6>
                        <p class="text-sm mb-0">Tìm kiếm, lọc và thao tác nhanh trên hồ sơ nhân sự</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xuất Excel</button>
                        <a href="{{ route('employee-new') }}" class="btn bg-gradient-dark btn-sm mb-0">+ Thêm nhân viên</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Phòng ban</label>
                            <select class="form-select border border-2 p-2">
                                @foreach ($departments as $department)
                                    <option>{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 mt-md-0 mt-3">
                            <label class="form-label">Tìm nhân viên</label>
                            <input type="text" class="form-control border border-2 p-2" placeholder="Tên, mã NV, email...">
                        </div>
                        <div class="col-md-3 mt-md-0 mt-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select border border-2 p-2">
                                <option>Tất cả</option>
                                <option>Đang làm việc</option>
                                <option>Nghỉ phép</option>
                                <option>Chờ duyệt</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chức danh</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca làm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="avatar avatar-sm me-3 rounded-circle bg-gradient-{{ $employee['color'] }} d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-xs font-weight-bold">{{ strtoupper(substr($employee['name'], 0, 1)) }}</span>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $employee['name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $employee['code'] }} - {{ $employee['email'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $employee['department'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $employee['title'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $employee['shift'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $employee['color'] }}">{{ $employee['status'] }}</span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-link text-dark px-2 mb-0">
                                                <i class="material-icons text-sm me-1">visibility</i>Xem
                                            </a>
                                            <a href="{{ route('employee-edit', ['id' => $employee['code']]) }}" class="btn btn-link text-success px-2 mb-0">
                                                <i class="material-icons text-sm me-1">edit</i>Sửa
                                            </a>
                                            <a href="javascript:;" class="btn btn-link text-warning px-2 mb-0">
                                                <i class="material-icons text-sm me-1">badge</i>Phòng ban
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Hoạt động gần đây</h6>
                    <p class="text-sm mb-0">Các thay đổi nhân sự và phòng ban mới nhất</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($recentEvents as $event)
                            <div class="col-md-6 mt-3">
                                <div class="border-radius-lg p-3 bg-gray-100 h-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 text-sm">{{ $event['title'] }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $event['detail'] }}</p>
                                        </div>
                                        <span class="text-xs text-secondary">{{ $event['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Tổng quan phòng ban</h6>
                    <p class="text-sm mb-0">Phân bổ nhân viên theo bộ phận</p>
                </div>
                <div class="card-body">
                    @foreach ($departmentSummary as $department)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">apartment</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $department['name'] }}</h6>
                                <p class="text-xs text-secondary mb-0">Trưởng bộ phận: {{ $department['lead'] }}</p>
                            </div>
                            <span class="badge bg-light text-dark">{{ $department['count'] }} người</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thao tác nhanh</h6>
                    <p class="text-sm mb-0">Các hành động thường dùng</p>
                </div>
                <div class="card-body">
                    @foreach ($quickActions as $action)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $action }}</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
