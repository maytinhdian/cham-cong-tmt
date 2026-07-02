<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Quản lý chức vụ</h5>
                            <p class="text-sm mb-0">Tạo chức vụ, lọc theo phòng ban và gán nhanh chức vụ cho nhân viên.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-2" wire:click="resetPositionForm">
                                <i class="material-icons-round text-sm me-1">add</i>
                                Thêm chức vụ
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
                            <div class="card card-background card-background-mask-dark h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved11.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $positions->count() }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Chức vụ đang quản lý</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ cấp quản lý</p>
                                    <h6 class="mb-0">{{ $managementPositionCount }}</h6>
                                    <p class="text-sm mb-0">Executive, Manager, Lead</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ phổ biến</p>
                                    <h6 class="mb-0">{{ $popularPosition?->name ?? 'Chưa có dữ liệu' }}</h6>
                                    <p class="text-sm mb-0">{{ $popularPosition?->employees_count ?? 0 }} nhân viên đang giữ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 position-department-filter">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex flex-column flex-xl-row align-items-xl-start justify-content-between gap-3">
                                        <div>
                                            <h6 class="mb-1">Lọc theo phòng ban</h6>
                                            <p class="text-sm mb-xl-0">Chọn phòng ban trước khi gán chức vụ cho nhân viên.</p>
                                        </div>
                                        <div class="tmt-tags-filter" role="list" aria-label="Lọc chức vụ theo phòng ban">
                                            @forelse ($departments as $department)
                                                <button
                                                    type="button"
                                                    wire:click="selectDepartment({{ $department->id }})"
                                                    @class([
                                                        'tmt-tag-filter',
                                                        'active' => $selectedDepartment?->id === $department->id,
                                                    ])
                                                    aria-pressed="{{ $selectedDepartment?->id === $department->id ? 'true' : 'false' }}"
                                                >
                                                    <span class="tmt-tag-filter-label">{{ $department->name }}</span>
                                                    <span class="tmt-tag-filter-count">{{ $department->employees_count }}</span>
                                                    @if ($selectedDepartment?->id === $department->id)
                                                        <i class="material-icons-round" aria-hidden="true">check</i>
                                                    @endif
                                                </button>
                                            @empty
                                                <span class="text-sm text-secondary">Chưa có phòng ban.</span>
                                            @endforelse
                                        </div>
                                    </div>
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
                                            <h6 class="mb-1">Danh sách chức vụ</h6>
                                            <p class="text-sm mb-0">Chọn một chức vụ để xem, sửa và gán nhân viên trong phòng ban.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0" type="button" wire:click="resetPositionForm">
                                            <i class="material-icons-round text-sm me-1">add</i>
                                            Tạo chức vụ
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Chức vụ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cấp độ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân sự</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($positions as $position)
                                                    <tr @class(['bg-gray-100' => $selectedPosition?->id === $position->id])>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                                    <i class="material-icons-round text-white text-sm opacity-10">badge</i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-sm">{{ $position->name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $position->code }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><p class="text-sm mb-0">{{ $position->level ?: 'Chưa phân cấp' }}</p></td>
                                                        <td><p class="text-sm mb-0">{{ $position->employees_count }} nhân viên</p></td>
                                                        <td>
                                                            @if ($position->status === 'active')
                                                                <span class="badge bg-gradient-success">Đang dùng</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Tạm ngưng</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button
                                                                class="btn btn-link text-info mb-0 p-0 me-3"
                                                                type="button"
                                                                wire:click="selectPosition({{ $position->id }})"
                                                                title="Chọn chức vụ"
                                                                aria-label="Chọn chức vụ {{ $position->name }}"
                                                            >
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                            <button
                                                                class="btn btn-link text-secondary mb-0 p-0"
                                                                type="button"
                                                                wire:click="editPosition({{ $position->id }})"
                                                                title="Sửa chức vụ"
                                                                aria-label="Sửa chức vụ {{ $position->name }}"
                                                            >
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                            <button
                                                                class="btn btn-link text-danger mb-0 p-0 ms-3"
                                                                type="button"
                                                                wire:click="deletePosition({{ $position->id }})"
                                                                wire:confirm="Xóa chức vụ này?"
                                                                title="{{ $position->employees_count > 0 ? 'Chỉ xóa được chức vụ chưa có nhân viên' : 'Xóa chức vụ' }}"
                                                                aria-label="Xóa chức vụ {{ $position->name }}"
                                                                @disabled($position->employees_count > 0)
                                                            >
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có chức vụ nào.</p>
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
                                            <h6 class="mb-1">{{ $editingPositionId ? 'Sửa chức vụ' : 'Tạo chức vụ' }}</h6>
                                            <p class="text-sm mb-0">Khai báo chức danh dùng cho hồ sơ nhân viên và báo cáo.</p>
                                        </div>
                                        @if ($editingPositionId)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="resetPositionForm">Hủy</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <form wire:submit.prevent="savePosition">
                                        <div class="row">
                                            <div class="col-5">
                                                <label class="form-label">Mã <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="code" placeholder="NVKD">
                                                @error('code') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-7">
                                                <label class="form-label">Tên chức vụ <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="name" placeholder="Nhân viên kinh doanh">
                                                @error('name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-7">
                                                <label class="form-label">Cấp độ</label>
                                                <select class="form-control" wire:model="level">
                                                    <option value="">Chưa phân cấp</option>
                                                    <option value="Executive">Executive</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="Lead">Lead</option>
                                                    <option value="Senior">Senior</option>
                                                    <option value="Staff">Staff</option>
                                                    <option value="Intern">Intern</option>
                                                </select>
                                                @error('level') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label">Thứ tự</label>
                                                <input type="number" class="form-control" wire:model="sortOrder" min="0">
                                                @error('sortOrder') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" wire:model="status">
                                                    <option value="active">Đang dùng</option>
                                                    <option value="inactive">Tạm ngưng</option>
                                                </select>
                                                @error('status') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Mô tả</label>
                                            <textarea class="form-control" rows="3" wire:model="description" placeholder="Vai trò, phạm vi công việc, ghi chú phân cấp..."></textarea>
                                            @error('description') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0 mt-4">
                                            {{ $editingPositionId ? 'Cập nhật chức vụ' : 'Lưu chức vụ' }}
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
                                    <h6 class="mb-1">Gán chức vụ cho nhân viên</h6>
                                    <p class="text-sm mb-0">
                                        {{ $selectedPosition?->name ?? 'Chưa chọn chức vụ' }}
                                        @if ($selectedDepartment)
                                            trong phòng ban {{ $selectedDepartment->name }}
                                        @endif
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
                                                        - {{ $employee->position?->name ?? 'Chưa có chức vụ' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-sm bg-gradient-primary mb-0"
                                                type="button"
                                                wire:click="assignPosition({{ $employee->id }})"
                                                @disabled(! $selectedPosition)
                                            >
                                                Gán
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không còn nhân viên phù hợp để gán chức vụ này.</p>
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
                                            <h6 class="mb-1">Nhân viên đang giữ chức vụ</h6>
                                            <p class="text-sm mb-0">
                                                {{ $selectedPosition?->name ?? 'Chưa chọn chức vụ' }}
                                                @if ($selectedDepartment)
                                                    - {{ $selectedDepartment->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <span class="badge bg-gradient-success">{{ $positionEmployees->count() }} nhân sự</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    @forelse ($positionEmployees as $employee)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $employee->department?->name ?? 'Chưa có phòng ban' }} - {{ $employee->employee_code }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-outline-secondary btn-sm mb-0"
                                                type="button"
                                                wire:click="removePosition({{ $employee->id }})"
                                            >
                                                Gỡ
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Chưa có nhân viên nào giữ chức vụ này trong phòng ban đang chọn.</p>
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
