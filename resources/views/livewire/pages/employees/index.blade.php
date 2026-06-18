<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Danh sách nhân viên</h6>
                            <p class="text-sm mb-0 text-muted">Quản lý nhân viên, phòng ban, chức vụ và trạng thái làm việc.</p>
                        </div>
                        <div class="d-flex gap-2 mt-3 mt-md-0">
                            <a href="{{ route('employee-dashboard') }}" class="btn btn-outline-secondary mb-0">Dashboard</a>
                            <a href="{{ route('new-user') }}" class="btn bg-gradient-dark mb-0">Thêm nhân viên</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chức vụ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ngày vào làm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div>
                                                    <img src="{{ $employee->avatar ? asset('storage/' . $employee->avatar) : asset('assets/img/default-avatar.png') }}"
                                                        class="avatar avatar-sm me-3" alt="employee">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $employee->employee_code }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $employee->department?->name ?? 'Chưa gán' }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $employee->department?->code ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">{{ $employee->position?->name ?? 'Chưa gán' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0">{{ $employee->hire_date?->format('d/m/Y') ?? 'Chưa cập nhật' }}</p>
                                        </td>
                                        <td>
                                            @if ($employee->work_status === 'active')
                                                <span class="badge badge-sm bg-gradient-success">Đang làm việc</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Tạm ngưng</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-3">Sửa</a>
                                            <a href="javascript:;" class="text-danger font-weight-bold text-xs">Xóa</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Chưa có nhân viên nào.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Bộ lọc nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            @foreach ($departments as $department)
                                <option>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Đang làm việc</option>
                            <option>Tạm ngưng</option>
                        </select>
                    </div>
                    <div class="form-group mt-3 mb-0">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" placeholder="Tên, mã nhân viên">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Thao tác nhanh</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="d-grid gap-2">
                        <a href="{{ route('new-user') }}" class="btn bg-gradient-dark mb-0">Thêm nhân viên</a>
                        <a href="{{ route('employee-dashboard') }}" class="btn btn-outline-secondary mb-0">Về dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
