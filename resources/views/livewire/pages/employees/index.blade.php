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

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tài khoản</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr @class(['bg-gray-100' => (int) $editingEmployeeId === $employee->id])>
                                        <td>
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
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
                                            @elseif ($employee->work_status === 'probation')
                                                <span class="badge badge-sm bg-gradient-info">Thử việc</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Tạm ngưng</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($employee->account)
                                                <span class="badge badge-sm bg-gradient-success">Đã cấp</span>
                                                <p class="text-xs text-secondary mb-0">{{ $employee->account->username ?? $employee->account->email }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $employee->account->role?->name ?? 'N/A' }}</p>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Chưa cấp</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <a
                                                href="{{ route('employee-detail', $employee) }}"
                                                class="btn btn-link text-info mb-0 p-0 me-3"
                                                title="Chi tiết nhân viên"
                                                aria-label="Chi tiết nhân viên {{ $employee->full_name }}"
                                            >
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-link text-secondary mb-0 p-0 me-3"
                                                wire:click="editEmployee({{ $employee->id }})"
                                                title="Sửa nhân viên"
                                                aria-label="Sửa nhân viên {{ $employee->full_name }}"
                                            >
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-link text-danger mb-0 p-0"
                                                wire:click="deleteEmployee({{ $employee->id }})"
                                                wire:confirm="Xóa mềm nhân viên này khỏi danh sách?"
                                                title="Xóa nhân viên"
                                                aria-label="Xóa nhân viên {{ $employee->full_name }}"
                                            >
                                                <i class="material-icons">close</i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Chưa có nhân viên nào phù hợp.</p>
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
                        <select class="form-control" wire:model.live="departmentFilter">
                            <option value="">Tất cả</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-control" wire:model.live="statusFilter">
                            <option value="">Tất cả</option>
                            <option value="active">Đang làm việc</option>
                            <option value="probation">Thử việc</option>
                            <option value="inactive">Tạm ngưng</option>
                        </select>
                    </div>
                    <div class="form-group mt-3 mb-0">
                        <label class="form-label">Tìm kiếm</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Tên, mã, email, số điện thoại"
                            wire:model.live.debounce.400ms="search"
                        >
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">{{ $editingEmployeeId ? 'Sửa nhân viên' : 'Chưa chọn nhân viên' }}</h6>
                            <p class="text-sm mb-0">Chọn `Sửa` ở bảng để cập nhật nhanh hồ sơ.</p>
                        </div>
                        @if ($editingEmployeeId)
                            <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="cancelEdit">Hủy</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if ($editingEmployeeId)
                        <form wire:submit.prevent="updateEmployee">
                            <div class="form-group">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" wire:model="fullName">
                                @error('fullName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Mã nhân viên</label>
                                <input type="text" class="form-control" wire:model="employeeCode">
                                @error('employeeCode') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model="email">
                                    @error('email') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-12 col-md-6 mt-3 mt-md-0">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" wire:model="phone">
                                    @error('phone') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Giới tính</label>
                                    <select class="form-control" wire:model="gender">
                                        <option value="">Chưa chọn</option>
                                        <option value="male">Nam</option>
                                        <option value="female">Nữ</option>
                                        <option value="other">Khác</option>
                                    </select>
                                    @error('gender') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-12 col-md-6 mt-3 mt-md-0">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" wire:model="dateOfBirth">
                                    @error('dateOfBirth') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Phòng ban</label>
                                    <select class="form-control" wire:model="departmentId">
                                        <option value="">Chưa gán</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('departmentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-12 col-md-6 mt-3 mt-md-0">
                                    <label class="form-label">Chức vụ</label>
                                    <select class="form-control" wire:model="positionId">
                                        <option value="">Chưa gán</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('positionId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Ngày vào làm</label>
                                    <input type="date" class="form-control" wire:model="hireDate">
                                    @error('hireDate') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-12 col-md-6 mt-3 mt-md-0">
                                    <label class="form-label">Trạng thái</label>
                                    <select class="form-control" wire:model="workStatus">
                                        <option value="active">Đang làm việc</option>
                                        <option value="probation">Thử việc</option>
                                        <option value="inactive">Tạm ngưng</option>
                                    </select>
                                    @error('workStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Ghi chú</label>
                                <textarea class="form-control" rows="3" wire:model="note"></textarea>
                                @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                            @can('authorization.manage')
                                <div class="border rounded-3 p-3 mt-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h6 class="mb-0">Tài khoản đăng nhập</h6>
                                            <p class="text-sm text-secondary mb-0">Nhân viên đăng nhập bằng mã nhân viên và mật khẩu được cấp.</p>
                                        </div>
                                        @php
                                            $selectedEmployee = $employees->firstWhere('id', $editingEmployeeId);
                                        @endphp
                                        @if ($selectedEmployee?->account)
                                            <span class="badge badge-sm bg-gradient-success">Đã cấp</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">Chưa cấp</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Tên đăng nhập</label>
                                            <input type="text" class="form-control" value="{{ $employeeCode }}" disabled>
                                        </div>
                                        <div class="col-12 col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Vai trò</label>
                                            <select class="form-control" wire:model="accountRoleId">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('accountRoleId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Mật khẩu cấp mới</label>
                                        <input type="password" class="form-control" wire:model="accountPassword" autocomplete="new-password">
                                        @error('accountPassword') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                    </div>
                                    <button type="button" class="btn bg-gradient-primary btn-sm mb-0 mt-3" wire:click="provisionEmployeeAccount">
                                        Cấp/cập nhật tài khoản
                                    </button>
                                </div>
                            @endcan
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary mb-0" wire:click="cancelEdit">Hủy</button>
                                <button type="submit" class="btn bg-gradient-dark mb-0">Cập nhật</button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <div class="avatar avatar-lg bg-gradient-secondary mx-auto mb-3">
                                <i class="material-icons-round text-white">edit</i>
                            </div>
                            <p class="text-sm text-secondary mb-0">Chưa có nhân viên nào được chọn để chỉnh sửa.</p>
                        </div>
                    @endif
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
