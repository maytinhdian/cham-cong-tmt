<div class="container-fluid py-4 bg-gray-200 employee-create-page">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-3">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Thêm nhân viên</h5>
                            <p class="text-sm mb-0">
                                Chọn cách nhập phù hợp: đi theo wizard đầy đủ hoặc chỉ nhập các thông tin bắt buộc.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary d-inline-flex align-items-center mb-0">
                                <i class="material-icons-round me-1">list</i>
                                Danh sách nhân viên
                            </a>
                            <a href="{{ route('employee-bulk-create') }}" class="btn bg-gradient-dark d-inline-flex align-items-center mb-0 ms-2">
                                <i class="material-icons-round me-1">upload_file</i>
                                Nhập từ Excel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if (session('success'))
                        <div class="alert alert-success text-white mt-4 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <button
                                type="button"
                                wire:click="$set('formMode', 'wizard')"
                                class="btn w-100 text-start border border-2 p-4 mb-0 option-card {{ $formMode === 'wizard' ? 'is-active shadow' : '' }}"
                            >
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg bg-gradient-dark me-3">
                                            <i class="material-icons-round text-white opacity-10">dynamic_form</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Dùng wizard đầy đủ</h6>
                                            <p class="text-sm mb-0">Nhập chi tiết nhiều bước, phù hợp khi tạo hồ sơ nhân viên hoàn chỉnh.</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-gradient-secondary">Khuyến nghị</span>
                                </div>
                            </button>
                        </div>
                        <div class="col-12 col-lg-6">
                            <button
                                type="button"
                                wire:click="$set('formMode', 'quick')"
                                class="btn w-100 text-start border border-2 p-4 mb-0 option-card {{ $formMode === 'quick' ? 'is-active shadow' : '' }}"
                            >
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg bg-gradient-dark me-3">
                                            <i class="material-icons-round text-white opacity-10">person_add</i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Chỉ thêm thông tin bắt buộc</h6>
                                            <p class="text-sm mb-0">Nhanh gọn, chỉ cần dữ liệu tối thiểu để tạo hồ sơ nhân viên.</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-gradient-secondary">Nhanh</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nhân viên hiện có</p>
                                    <h6 class="mb-0">{{ $employeeCount }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Phòng ban khả dụng</p>
                                    <h6 class="mb-0">{{ $departments->count() }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ khả dụng</p>
                                    <h6 class="mb-0">{{ $positions->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($formMode === 'wizard')
                <div class="multisteps-form mt-5 mb-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header p-0 position-relative mt-n3 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                        <div class="multisteps-form__progress">
                                            <button class="multisteps-form__progress-btn js-active" type="button" title="Basic Info">
                                                <span>1. Thông tin</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Job Info">
                                                <span>2. Công việc</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Account Info">
                                                <span>3. Tài khoản</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Note">
                                                <span>4. Ghi chú</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="multisteps-form__form" wire:submit.prevent="saveEmployee">
                                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Thông tin cá nhân</h5>
                                            <p class="mb-0 text-sm">Nhập thông tin cơ bản của nhân viên.</p>
                                            <div class="multisteps-form__content">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" wire:model="fullName" placeholder="Nguyễn Văn A">
                                                        @error('fullName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" wire:model="employeeCode" placeholder="EMP-005">
                                                        @error('employeeCode') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label">Số điện thoại</label>
                                                        <input class="form-control" type="text" wire:model="phone" placeholder="0900000000">
                                                        @error('phone') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label">Email</label>
                                                        <input class="form-control" type="email" wire:model="email" placeholder="nhanvien@tmt.vn">
                                                        @error('email') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label">Giới tính</label>
                                                        <select class="form-control" wire:model="gender">
                                                            <option value="">Chưa chọn</option>
                                                            <option value="male">Nam</option>
                                                            <option value="female">Nữ</option>
                                                            <option value="other">Khác</option>
                                                        </select>
                                                        @error('gender') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label">Ngày sinh</label>
                                                        <input class="form-control" type="date" wire:model="dateOfBirth">
                                                        @error('dateOfBirth') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn btn-sm bg-gradient-primary ms-auto mb-0 js-btn-next" type="button" title="Tiếp theo" aria-label="Tiếp theo">
                                                        <i class="material-icons-round">arrow_forward</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Thông tin công việc</h5>
                                            <p class="mb-0 text-sm">Chọn phòng ban, chức vụ và ca làm ban đầu cho nhân viên.</p>
                                            <div class="multisteps-form__content">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label mb-1">Phòng ban</label>
                                                        <select class="form-control" wire:model="departmentId">
                                                            <option value="">Chưa gán phòng ban</option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('departmentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label mb-1">Chức vụ</label>
                                                        <select class="form-control" wire:model="positionId">
                                                            <option value="">Chưa gán chức vụ</option>
                                                            @foreach ($positions as $position)
                                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('positionId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label mb-1">Ca làm ban đầu</label>
                                                        <select class="form-control" wire:model="shiftId">
                                                            <option value="">Chưa chọn ca</option>
                                                            @foreach ($shifts as $shift)
                                                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <p class="text-xs text-secondary mt-1 mb-0">Ca làm sẽ được dùng làm ghi chú ban đầu, chưa phải phân ca chính thức.</p>
                                                        @error('shiftId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label">Ngày vào làm</label>
                                                        <input class="form-control" type="date" wire:model="hireDate">
                                                        @error('hireDate') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <label class="form-label mb-1">Trạng thái làm việc</label>
                                                        <select class="form-control" wire:model="workStatus">
                                                            <option value="active">Đang làm việc</option>
                                                            <option value="probation">Thử việc</option>
                                                            <option value="inactive">Tạm ngưng</option>
                                                        </select>
                                                        @error('workStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn btn-sm bg-gradient-primary mb-0 js-btn-prev" type="button" title="Quay lại" aria-label="Quay lại">
                                                        <i class="material-icons-round">arrow_back</i>
                                                    </button>
                                                    <button class="btn btn-sm bg-gradient-primary ms-auto mb-0 js-btn-next" type="button" title="Tiếp theo" aria-label="Tiếp theo">
                                                        <i class="material-icons-round">arrow_forward</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Tài khoản hệ thống</h5>
                                            <p class="mb-0 text-sm">Tùy chọn cấp tài khoản đăng nhập ngay khi tạo hồ sơ nhân viên.</p>
                                            <div class="multisteps-form__content">
                                                @can('authorization.manage')
                                                    <div class="form-check form-switch mt-3">
                                                        <input class="form-check-input" type="checkbox" id="createLoginAccount" wire:model="createLoginAccount">
                                                        <label class="form-check-label" for="createLoginAccount">Tạo tài khoản đăng nhập</label>
                                                    </div>

                                                    @if ($createLoginAccount)
                                                        <div class="row mt-3">
                                                            <div class="col-12 col-sm-6">
                                                                <label class="form-label">Vai trò đăng nhập <span class="text-danger">*</span></label>
                                                                <select class="form-control" wire:model="accountRoleId">
                                                                    <option value="">Chọn vai trò</option>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('accountRoleId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                            </div>
                                                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                                <label class="form-label">Mật khẩu ban đầu <span class="text-danger">*</span></label>
                                                                <input class="form-control" type="password" wire:model="accountPassword" autocomplete="new-password">
                                                                @error('accountPassword') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                            </div>
                                                        </div>
                                                        <p class="text-xs text-secondary mt-2 mb-0">Tên đăng nhập sẽ dùng mã nhân viên. Email tài khoản dùng email nhân viên hoặc email nội bộ tự sinh nếu cần.</p>
                                                    @endif
                                                @else
                                                    <div class="alert alert-info text-white mt-3 mb-0" role="alert">
                                                        Bạn chưa có quyền cấp tài khoản đăng nhập. Hồ sơ nhân viên vẫn có thể được tạo trước.
                                                    </div>
                                                @endcan
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn btn-sm bg-gradient-primary mb-0 js-btn-prev" type="button" title="Quay lại" aria-label="Quay lại">
                                                        <i class="material-icons-round">arrow_back</i>
                                                    </button>
                                                    <button class="btn btn-sm bg-gradient-primary ms-auto mb-0 js-btn-next" type="button" title="Tiếp theo" aria-label="Tiếp theo">
                                                        <i class="material-icons-round">arrow_forward</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Ghi chú và xác nhận</h5>
                                            <p class="mb-0 text-sm">Kiểm tra thông tin cuối cùng trước khi lưu nhân viên.</p>
                                            <div class="multisteps-form__content mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">Ghi chú</label>
                                                        <textarea class="form-control" rows="5" wire:model="note" placeholder="Ghi chú, người tạo, lý do tạo..."></textarea>
                                                        @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn btn-sm bg-gradient-primary mb-0 js-btn-prev" type="button" title="Quay lại" aria-label="Quay lại">
                                                        <i class="material-icons-round">arrow_back</i>
                                                    </button>
                                                    <button class="btn btn-sm bg-gradient-primary ms-auto mb-0" type="submit" title="Lưu nhân viên" aria-label="Lưu nhân viên">
                                                        <i class="material-icons-round">save</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5 class="mb-1">Thêm thông tin bắt buộc</h5>
                                <p class="text-sm mb-0">Dùng khi cần tạo hồ sơ nhanh, chỉ nhập những thông tin cần thiết.</p>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="saveEmployee">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" wire:model="fullName" placeholder="Nguyễn Văn A">
                                            @error('fullName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" wire:model="employeeCode" placeholder="EMP-005">
                                            @error('employeeCode') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" wire:model="email" placeholder="nhanvien@tmt.vn">
                                            @error('email') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label class="form-label">Số điện thoại</label>
                                            <input class="form-control" type="text" wire:model="phone" placeholder="0900000000">
                                            @error('phone') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label mb-1">Phòng ban</label>
                                            <select class="form-control" wire:model="departmentId">
                                                <option value="">Chưa gán phòng ban</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('departmentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label class="form-label mb-1">Chức vụ</label>
                                            <select class="form-control" wire:model="positionId">
                                                <option value="">Chưa gán chức vụ</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('positionId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">Ngày vào làm</label>
                                            <input class="form-control" type="date" wire:model="hireDate">
                                            @error('hireDate') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label class="form-label mb-1">Trạng thái</label>
                                            <select class="form-control" wire:model="workStatus">
                                                <option value="active">Đang làm việc</option>
                                                <option value="probation">Thử việc</option>
                                                <option value="inactive">Tạm ngưng</option>
                                            </select>
                                            @error('workStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-secondary mb-0" wire:click="$set('formMode', 'wizard')">Quay lại wizard</button>
                                        <button type="submit" class="btn bg-gradient-dark mb-0">Lưu nhân viên</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
@endpush
