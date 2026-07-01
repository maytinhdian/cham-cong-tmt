<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Log chấm công thô</h5>
                            <p class="text-sm mb-0">
                                Lưu và kiểm tra dữ liệu chấm công gốc trước khi xử lý thành bảng công.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-devices') }}" class="btn btn-outline-secondary mb-0">Thiết bị</a>
                            <a href="{{ route('attendance-schedules') }}" class="btn bg-gradient-dark mb-0 ms-2">Lịch làm việc</a>
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
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved14.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $totalCount }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Tổng log thô</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Log hôm nay</p>
                                    <h6 class="mb-0">{{ $todayCount }}</h6>
                                    <p class="text-sm mb-0">Theo thời gian chấm công</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chờ xử lý</p>
                                    <h6 class="mb-0">{{ $pendingCount }}</h6>
                                    <p class="text-sm mb-0">Sẽ dùng cho bước tính công</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-4">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Nhập log thủ công</h6>
                                    <p class="text-sm mb-0">Dùng để test hoặc bổ sung log trước khi có đồng bộ máy thật.</p>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="saveRawLog">
                                        <div class="form-group">
                                            <label class="form-label">Thiết bị</label>
                                            <select class="form-control" wire:model="attendanceDeviceId">
                                                <option value="">Không chọn thiết bị</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }} - {{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('attendanceDeviceId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Nhân viên</label>
                                            <select class="form-control" wire:model="employeeId">
                                                <option value="">Chưa map nhân viên</option>
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
                                                <label class="form-label">Thời gian <span class="text-danger">*</span></label>
                                                <input type="datetime-local" class="form-control" wire:model="punchTime">
                                                @error('punchTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Loại log</label>
                                                <select class="form-control" wire:model="punchType">
                                                    <option value="unknown">Chưa xác định</option>
                                                    <option value="in">Vào</option>
                                                    <option value="out">Ra</option>
                                                    <option value="break_in">Vào nghỉ</option>
                                                    <option value="break_out">Ra nghỉ</option>
                                                </select>
                                                @error('punchType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Xác thực</label>
                                                <input type="text" class="form-control" wire:model="verifyType" placeholder="finger, face, card">
                                                @error('verifyType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Nguồn</label>
                                                <select class="form-control" wire:model="source">
                                                    <option value="manual">Nhập tay</option>
                                                    <option value="device">Thiết bị</option>
                                                    <option value="import">Import file</option>
                                                    <option value="api">API</option>
                                                </select>
                                                @error('source') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" wire:model="processingStatus">
                                                    <option value="pending">Chờ xử lý</option>
                                                    <option value="processed">Đã xử lý</option>
                                                    <option value="ignored">Bỏ qua</option>
                                                    <option value="error">Lỗi</option>
                                                </select>
                                                @error('processingStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" rows="3" wire:model="note" placeholder="Ví dụ: log nhập tay để test"></textarea>
                                            @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0 mt-4">Lưu log thô</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Bộ lọc log</h6>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Từ ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateFrom">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Đến ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateTo">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Thiết bị</label>
                                            <select class="form-control" wire:model.live="deviceFilter">
                                                <option value="">Tất cả</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Trạng thái</label>
                                            <select class="form-control" wire:model.live="statusFilter">
                                                <option value="">Tất cả</option>
                                                <option value="pending">Chờ xử lý</option>
                                                <option value="processed">Đã xử lý</option>
                                                <option value="ignored">Bỏ qua</option>
                                                <option value="error">Lỗi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Nhân viên</label>
                                            <select class="form-control" wire:model.live="employeeFilter">
                                                <option value="">Tất cả</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->employee_code }} - {{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thiết bị</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Log</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($rawLogs as $rawLog)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->punch_time->format('d/m/Y H:i') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->source }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $rawLog->employee?->full_name ?? 'Chưa map' }}</p>
                                                            <p class="text-xs text-secondary mb-0">Mã máy: {{ $rawLog->device_user_code }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->device?->name ?? 'Không rõ thiết bị' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->device?->code ?? '-' }}</p>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-gradient-info">{{ $rawLog->punch_type }}</span>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->verify_type ?: 'Không rõ xác thực' }}</p>
                                                        </td>
                                                        <td>
                                                            @if ($rawLog->processing_status === 'pending')
                                                                <span class="badge bg-gradient-warning">Chờ xử lý</span>
                                                            @elseif ($rawLog->processing_status === 'processed')
                                                                <span class="badge bg-gradient-success">Đã xử lý</span>
                                                            @elseif ($rawLog->processing_status === 'ignored')
                                                                <span class="badge bg-gradient-secondary">Bỏ qua</span>
                                                            @else
                                                                <span class="badge bg-gradient-danger">Lỗi</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-link text-secondary me-3 mb-0 p-0" wire:click="ignoreRawLog({{ $rawLog->id }})" title="Bỏ qua log" aria-label="Bỏ qua log {{ $rawLog->id }}">
                                                                <i class="material-icons">block</i>
                                                            </button>
                                                            <button
                                                                type="button"
                                                                class="btn btn-link text-danger mb-0 p-0"
                                                                wire:click="deleteRawLog({{ $rawLog->id }})"
                                                                wire:confirm="Xóa log thô này?"
                                                                title="Xóa log"
                                                                aria-label="Xóa log {{ $rawLog->id }}"
                                                            >
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có log chấm công thô trong bộ lọc này.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-xs text-secondary mt-3 mb-0">Trang này chỉ hiển thị tối đa 300 log mới nhất theo bộ lọc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
