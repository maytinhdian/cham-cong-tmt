<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Mapping người dùng trên máy</h5>
                            <p class="text-sm mb-0">
                                Liên kết mã người dùng trên thiết bị chấm công với hồ sơ nhân viên trong hệ thống.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-devices') }}" class="btn btn-outline-secondary mb-0">Thiết bị</a>
                            <a href="{{ route('attendance-raw-logs') }}" class="btn bg-gradient-dark mb-0 ms-2">Log chấm công</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card card-background card-background-mask-dark h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved11.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $mappings->count() }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Mapping đang hiển thị</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Thiết bị khả dụng</p>
                                    <h6 class="mb-0">{{ $devices->count() }}</h6>
                                    <p class="text-sm mb-0">Dùng để phân biệt mã người dùng trên từng máy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nhân viên khả dụng</p>
                                    <h6 class="mb-0">{{ $employees->count() }}</h6>
                                    <p class="text-sm mb-0">Có thể map với mã trên máy</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-4">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $editingMappingId ? 'Sửa mapping' : 'Thêm mapping' }}</h6>
                                            <p class="text-sm mb-0">Một thiết bị và một mã máy chỉ nên map tới một nhân viên.</p>
                                        </div>
                                        @if ($editingMappingId)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="resetForm">Hủy</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="saveMapping">
                                        <div class="form-group">
                                            <label class="form-label">Thiết bị <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model="attendanceDeviceId">
                                                <option value="">Chọn thiết bị</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }} - {{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('attendanceDeviceId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Nhân viên <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model="employeeId">
                                                <option value="">Chọn nhân viên</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->employee_code }} - {{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('employeeId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Mã trên máy <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="deviceUserCode" placeholder="001">
                                                @error('deviceUserCode') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Tên trên máy</label>
                                                <input type="text" class="form-control" wire:model="deviceUserName" placeholder="Nguyen Van A">
                                                @error('deviceUserName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Trạng thái</label>
                                            <select class="form-control" wire:model="status">
                                                <option value="active">Đang dùng</option>
                                                <option value="inactive">Tạm ngưng</option>
                                            </select>
                                            @error('status') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" rows="3" wire:model="note" placeholder="Ví dụ: mã này lấy từ máy cửa chính"></textarea>
                                            @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0 mt-4">
                                            {{ $editingMappingId ? 'Cập nhật mapping' : 'Lưu mapping' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Thiết bị</label>
                                            <select class="form-control" wire:model.live="deviceFilter">
                                                <option value="">Tất cả thiết bị</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }} - {{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Trạng thái</label>
                                            <select class="form-control" wire:model.live="statusFilter">
                                                <option value="">Tất cả</option>
                                                <option value="active">Đang dùng</option>
                                                <option value="inactive">Tạm ngưng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thiết bị</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã máy</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($mappings as $mapping)
                                                    <tr @class(['bg-gray-100' => (int) $editingMappingId === $mapping->id])>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $mapping->device->name }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $mapping->device->code }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $mapping->device_user_code }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $mapping->device_user_name ?: 'Chưa có tên trên máy' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $mapping->employee->full_name }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $mapping->employee->employee_code }} - {{ $mapping->employee->department?->name ?? 'Chưa gán phòng ban' }}</p>
                                                        </td>
                                                        <td>
                                                            @if ($mapping->status === 'active')
                                                                <span class="badge bg-gradient-success">Đang dùng</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Tạm ngưng</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-link text-dark font-weight-bold text-xs me-2 mb-0 p-0" wire:click="applyMapping({{ $mapping->id }})">
                                                                Áp dụng
                                                            </button>
                                                            <button type="button" class="btn btn-link text-secondary font-weight-bold text-xs me-2 mb-0 p-0" wire:click="editMapping({{ $mapping->id }})">
                                                                Sửa
                                                            </button>
                                                            <button
                                                                type="button"
                                                                class="btn btn-link text-danger font-weight-bold text-xs mb-0 p-0"
                                                                wire:click="deleteMapping({{ $mapping->id }})"
                                                                wire:confirm="Xóa mapping này?"
                                                            >
                                                                Xóa
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có mapping người dùng trên máy.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-xs text-secondary mt-3 mb-0">Nút Áp dụng chỉ cập nhật các log thô chưa có nhân viên.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
