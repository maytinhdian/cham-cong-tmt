<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
                        <form wire:submit="update" enctype="multipart/form-data">
                            <div class="avatar avatar-xl position-relative preview">
                                @if($picture)
                                    <img src="{{ $picture->temporaryUrl() }}" class="w-100 rounded-circle shadow-sm" alt="Profile Photo">
                                @elseif ($user->picture)
                                    <img src="/storage/{{ $user->picture }}" alt="avatar" class="w-100 rounded-circle shadow-sm">
                                @else
                                    <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar" class="w-100 rounded-circle shadow-sm">
                                @endif
                                <label for="file-input" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2" title="Đổi ảnh">
                                    <i class="material-icons text-sm">edit</i>
                                </label>
                                <input wire:model.live="picture" type="file" id="file-input" class="d-none">
                            </div>
                        </form>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-gradient-dark">{{ $user->username ?? $user->email }}</span>
                                <span class="badge bg-gradient-info">{{ $user->role?->name ?? 'Chưa gán vai trò' }}</span>
                                @if ($employee)
                                    <span class="badge bg-gradient-secondary">{{ $employee->employee_code }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @error('picture')
                        <p class="text-danger text-xs mt-3 mb-0">{{ $message }}</p>
                    @enderror

                    @if (session('status'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">{{ session('status') }}</div>
                    @endif
                    @if (session('demo'))
                        <div class="alert alert-danger text-white mt-3 mb-0" role="alert">{{ session('demo') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Thông tin cá nhân</h6>
                    <p class="text-sm text-secondary mb-0">Cập nhật thông tin liên hệ cơ bản của tài khoản.</p>
                </div>
                <div class="card-body">
                    <form wire:submit="update">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Họ và tên</label>
                                <input wire:model.blur="user.name" type="text" class="form-control">
                                @error('user.name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Email</label>
                                <input wire:model.blur="user.email" type="email" class="form-control">
                                @error('user.email') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input wire:model.blur="user.phone" type="text" class="form-control">
                                @error('user.phone') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Địa chỉ</label>
                                <input wire:model.blur="user.location" type="text" class="form-control">
                                @error('user.location') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" value="{{ $user->username ?? $user->email }}" disabled>
                            </div>
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Vai trò</label>
                                <input type="text" class="form-control" value="{{ $user->role?->name ?? 'Chưa gán' }}" disabled>
                            </div>
                        </div>

                        @if ($employee)
                            <div class="border rounded-3 p-3 mt-4">
                                <h6 class="text-sm mb-2">Thông tin nhân viên</h6>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <p class="text-xs text-secondary mb-1">Mã nhân viên</p>
                                        <p class="text-sm mb-0">{{ $employee->employee_code }}</p>
                                    </div>
                                    <div class="col-12 col-md-4 mt-3 mt-md-0">
                                        <p class="text-xs text-secondary mb-1">Phòng ban</p>
                                        <p class="text-sm mb-0">{{ $employee->department?->name ?? 'Chưa gán' }}</p>
                                    </div>
                                    <div class="col-12 col-md-4 mt-3 mt-md-0">
                                        <p class="text-xs text-secondary mb-1">Chức vụ</p>
                                        <p class="text-sm mb-0">{{ $employee->position?->name ?? 'Chưa gán' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn bg-gradient-dark mt-4 mb-0">Lưu thông tin</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5 mt-4 mt-lg-0">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Đổi mật khẩu</h6>
                    <p class="text-sm text-secondary mb-0">Nhập mật khẩu hiện tại trước khi đổi sang mật khẩu mới.</p>
                    @if (session('error'))
                        <div class="alert alert-danger text-white mt-3 mb-0" role="alert">{{ session('error') }}</div>
                    @elseif (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">{{ session('success') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit="passwordUpdate">
                        <div class="form-group">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input wire:model.blur="old_password" type="password" class="form-control" autocomplete="current-password">
                            @error('old_password') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input wire:model.blur="new_password" type="password" class="form-control" autocomplete="new-password">
                            @error('new_password') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input wire:model.live="confirmationPassword" type="password" class="form-control" autocomplete="new-password">
                        </div>
                        <button class="btn bg-gradient-dark mt-4 mb-0">Cập nhật mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
