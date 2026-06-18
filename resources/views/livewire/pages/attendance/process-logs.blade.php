<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Xử lý log chấm công</h5>
                            <p class="text-sm mb-0">
                                Chuyển log thô từ thiết bị thành kết quả chấm công ngày theo lịch làm việc và ca đã khai báo.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-raw-logs') }}" class="btn btn-outline-secondary mb-0">Log thô</a>
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
                                    <h4 class="text-white mb-0">{{ $pendingRawLogCount }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Log thô chờ xử lý</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Kết quả ngày công</p>
                                    <h6 class="mb-0">{{ $processedResultCount }}</h6>
                                    <p class="text-sm mb-0">Dữ liệu đã tính theo nhân viên/ngày</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Dòng cần kiểm tra</p>
                                    <h6 class="mb-0">{{ $exceptionCount }}</h6>
                                    <p class="text-sm mb-0">Thiếu log, đi trễ hoặc về sớm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-4">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Chạy xử lý</h6>
                                    <p class="text-sm mb-0">Chọn khoảng ngày để engine tạo/cập nhật kết quả chấm công ngày.</p>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="processLogs">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Từ ngày</label>
                                                <input type="date" class="form-control" wire:model="dateFrom">
                                                @error('dateFrom') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Đến ngày</label>
                                                <input type="date" class="form-control" wire:model="dateTo">
                                                @error('dateTo') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Nhân viên</label>
                                            <select class="form-control" wire:model="employeeId">
                                                <option value="">Tất cả nhân viên</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->employee_code }} - {{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('employeeId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0 mt-4">
                                            Xử lý log
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Kết quả chấm công ngày</h6>
                                            <p class="text-sm mb-0">Hiển thị tối đa 300 dòng mới nhất theo bộ lọc.</p>
                                        </div>
                                        <div class="mt-3 mt-lg-0">
                                            <select class="form-control" wire:model.live="statusFilter">
                                                <option value="">Tất cả trạng thái</option>
                                                <option value="complete">Hợp lệ</option>
                                                <option value="exception">Cần kiểm tra</option>
                                                <option value="absent">Vắng</option>
                                                <option value="no_schedule">Chưa có lịch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vào/Ra</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lỗi</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($results as $result)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->work_date->format('d/m/Y') }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $result->employee?->full_name }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->employee?->employee_code }} - {{ $result->employee?->department?->name ?? 'Chưa có phòng ban' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->shift?->name ?? 'Chưa có ca' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->shift?->code ?? '-' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">
                                                                {{ $result->clock_in_at?->format('H:i') ?? '--:--' }}
                                                                -
                                                                {{ $result->clock_out_at?->format('H:i') ?? '--:--' }}
                                                            </p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->work_minutes }} phút</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">OT: {{ $result->overtime_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">Thiếu log: {{ $result->missing_log_count }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">Trễ: {{ $result->late_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">Về sớm: {{ $result->early_leave_minutes }} phút</p>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($result->status === 'complete')
                                                                <span class="badge bg-gradient-success">Hợp lệ</span>
                                                            @elseif ($result->status === 'exception')
                                                                <span class="badge bg-gradient-warning">Cần kiểm tra</span>
                                                            @elseif ($result->status === 'absent')
                                                                <span class="badge bg-gradient-danger">Vắng</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Chưa có lịch</span>
                                                            @endif
                                                            @if ($result->note)
                                                                <p class="text-xs text-secondary mb-0 mt-1">{{ $result->note }}</p>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có kết quả chấm công ngày trong bộ lọc này.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
