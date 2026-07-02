<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Quản lý phòng ban</h5>
                            <p class="text-sm mb-0">Tạo phòng ban, theo dõi cơ cấu và gán nhanh nhân viên vào phòng ban đang chọn.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-2" wire:click="resetDepartmentForm">
                                <i class="material-icons-round text-sm me-1">add</i>
                                Thêm phòng ban
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white mt-3 mb-0" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card card-background card-background-mask-primary h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved14.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $departments->count() }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Phòng ban đang quản lý</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nhân sự đã gán phòng ban</p>
                                    <h6 class="mb-0">{{ $departments->sum('employees_count') }} nhân viên</h6>
                                    <p class="text-sm mb-0">Dựa trên dữ liệu nhân viên hiện tại</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Phòng ban đang chọn</p>
                                    <h6 class="mb-0">{{ $selectedDepartment?->name ?? 'Chưa có phòng ban' }}</h6>
                                    <p class="text-sm mb-0">{{ $selectedDepartment?->code ?? 'Tạo phòng ban để bắt đầu gán nhân sự' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Danh sách phòng ban</h6>
                                            <p class="text-sm mb-0">Chọn một phòng ban để xem, sửa và gán nhân viên.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0" type="button" wire:click="resetDepartmentForm">
                                            <i class="material-icons-round text-sm me-1">add</i>
                                            Tạo phòng ban
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quản lý</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân sự</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($departments as $department)
                                                    <tr @class(['bg-gray-100' => $selectedDepartment?->id === $department->id])>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="avatar avatar-sm bg-gradient-primary me-3">
                                                                    <i class="material-icons-round text-white text-sm opacity-10">apartment</i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-sm">{{ $department->name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $department->code }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $department->manager_name ?: 'Chưa gán' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $department->email ?: 'Chưa có email' }}</p>
                                                        </td>
                                                        <td><p class="text-sm mb-0">{{ $department->employees_count }} nhân viên</p></td>
                                                        <td>
                                                            @if ($department->status === 'active')
                                                                <span class="badge bg-gradient-success">Đang hoạt động</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Tạm ngưng</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button
                                                                class="btn btn-link text-info mb-0 p-0 me-3"
                                                                type="button"
                                                                wire:click="selectDepartment({{ $department->id }})"
                                                                title="Chọn phòng ban"
                                                                aria-label="Chọn phòng ban {{ $department->name }}"
                                                            >
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                            <button
                                                                class="btn btn-link text-secondary mb-0 p-0"
                                                                type="button"
                                                                wire:click="editDepartment({{ $department->id }})"
                                                                title="Sửa phòng ban"
                                                                aria-label="Sửa phòng ban {{ $department->name }}"
                                                            >
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                            <button
                                                                class="btn btn-link text-danger mb-0 p-0 ms-3"
                                                                type="button"
                                                                wire:click="deleteDepartment({{ $department->id }})"
                                                                wire:confirm="Xóa phòng ban này?"
                                                                title="{{ $department->employees_count > 0 ? 'Chỉ xóa được phòng ban chưa có nhân viên' : 'Xóa phòng ban' }}"
                                                                aria-label="Xóa phòng ban {{ $department->name }}"
                                                                @disabled($department->employees_count > 0)
                                                            >
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có phòng ban nào.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $editingDepartmentId ? 'Sửa phòng ban' : 'Tạo phòng ban' }}</h6>
                                            <p class="text-sm mb-0">Khai báo thông tin phòng ban dùng cho nhân sự và báo cáo.</p>
                                        </div>
                                        @if ($editingDepartmentId)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="resetDepartmentForm">Hủy</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <form wire:submit.prevent="saveDepartment">
                                        <div class="row">
                                            <div class="col-5">
                                                <label class="form-label">Mã <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="code" placeholder="HCNS">
                                                @error('code') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-7">
                                                <label class="form-label">Tên phòng ban <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="name" placeholder="Hành chính nhân sự">
                                                @error('name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Phòng ban cha</label>
                                            <select class="form-control" wire:model="parentId">
                                                <option value="">Không có</option>
                                                @foreach ($departments as $department)
                                                    @if ($editingDepartmentId !== $department->id)
                                                        <option value="{{ $department->id }}">{{ $department->code }} - {{ $department->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('parentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-7">
                                                <label class="form-label">Quản lý</label>
                                                <input type="text" class="form-control" wire:model="managerName" placeholder="Người phụ trách">
                                                @error('managerName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label">Thứ tự</label>
                                                <input type="number" class="form-control" wire:model="sortOrder" min="0">
                                                @error('sortOrder') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Điện thoại</label>
                                                <input type="text" class="form-control" wire:model="phone" placeholder="090...">
                                                @error('phone') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" wire:model="email" placeholder="hr@company.vn">
                                                @error('email') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" wire:model="status">
                                                    <option value="active">Đang hoạt động</option>
                                                    <option value="inactive">Tạm ngưng</option>
                                                </select>
                                                @error('status') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Mô tả</label>
                                            <textarea class="form-control" rows="3" wire:model="description" placeholder="Ghi chú phạm vi, vai trò, khu vực phụ trách..."></textarea>
                                            @error('description') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0 mt-4">
                                            {{ $editingDepartmentId ? 'Cập nhật phòng ban' : 'Lưu phòng ban' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-6">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Gán nhân viên vào phòng ban</h6>
                                    <p class="text-sm mb-0">
                                        Phòng ban đang chọn:
                                        <span class="font-weight-bold">{{ $selectedDepartment?->name ?? 'Chưa chọn' }}</span>
                                    </p>
                                </div>
                                <div class="card-body pt-3">
                                    @forelse ($availableEmployees as $employee)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-info me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $employee->employee_code }}
                                                        @if ($employee->department)
                                                            - {{ $employee->department->name }}
                                                        @else
                                                            - Chưa có phòng ban
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-sm bg-gradient-primary mb-0"
                                                type="button"
                                                wire:click="assignEmployee({{ $employee->id }})"
                                                @disabled(! $selectedDepartment)
                                            >
                                                Gán
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không còn nhân viên ngoài phòng ban này.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-6 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Nhân viên thuộc phòng ban</h6>
                                            <p class="text-sm mb-0">{{ $selectedDepartment?->name ?? 'Chọn phòng ban để xem danh sách' }}</p>
                                        </div>
                                        <span class="badge bg-gradient-success">{{ $departmentEmployees->count() }} nhân sự</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    @forelse ($departmentEmployees as $employee)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $employee->employee_code }} - {{ $employee->position?->name ?? 'Chưa có chức vụ' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-outline-secondary btn-sm mb-0"
                                                type="button"
                                                wire:click="removeEmployee({{ $employee->id }})"
                                            >
                                                Gỡ
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Phòng ban này chưa có nhân viên.</p>
                                        </div>
                                    @endforelse

                                    <a href="{{ route('employee-list') }}" class="btn btn-outline-primary w-100 mb-0 mt-3">
                                        Xem danh sách nhân viên đầy đủ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
