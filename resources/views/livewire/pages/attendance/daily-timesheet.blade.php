<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Bảng công ngày</h5>
                            <p class="text-sm mb-0">
                                Kiểm tra kết quả chấm công đã xử lý theo từng nhân viên và từng ngày làm việc.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-process-logs') }}" class="btn btn-outline-secondary mb-0">Xử lý log</a>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-2" wire:click="resetFilters">Làm mới lọc</button>
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
                        <div class="col-lg-3 mt-4">
                            <div class="card card-background card-background-mask-dark h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved14.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $summary['total'] }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Dòng ngày công</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Hợp lệ</p>
                                    <h6 class="mb-0">{{ $summary['complete'] }}</h6>
                                    <p class="text-sm mb-0">{{ $summary['adjusted'] }} dòng đã chỉnh</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Cần kiểm tra</p>
                                    <h6 class="mb-0">{{ $summary['exception'] }}</h6>
                                    <p class="text-sm mb-0">{{ $summary['missing_logs'] }} log còn thiếu</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nghỉ phép</p>
                                    <h6 class="mb-0">{{ $summary['leave'] }}</h6>
                                    <p class="text-sm mb-0">Ngày nghỉ đã được duyệt</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Cuối tuần</p>
                                    <h6 class="mb-0">{{ $summary['weekend'] }}</h6>
                                    <p class="text-sm mb-0">Ngày nghỉ theo cấu hình hệ thống</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nghỉ lễ</p>
                                    <h6 class="mb-0">{{ $summary['holiday'] }}</h6>
                                    <p class="text-sm mb-0">Ngày nghỉ theo lịch công ty</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Tổng giờ công</p>
                                    <h6 class="mb-0">{{ number_format($summary['work_minutes'] / 60, 1) }} giờ</h6>
                                    <p class="text-sm mb-0">OT {{ $summary['overtime_minutes'] }} phút</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($adjustingResult)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header pb-0 p-3">
                                        <div class="d-flex flex-column flex-lg-row justify-content-between">
                                            <div>
                                                <h6 class="mb-1">Điều chỉnh công ngày</h6>
                                                <p class="text-sm mb-0">
                                                    {{ $adjustingResult->employee?->employee_code }} - {{ $adjustingResult->employee?->full_name }}
                                                    |
                                                    {{ $adjustingResult->work_date->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary mb-0 mt-3 mt-lg-0" wire:click="cancelAdjustment">
                                                Hủy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <form wire:submit.prevent="saveAdjustment">
                                            <div class="row">
                                                <div class="col-md-3 mt-3">
                                                    <label class="form-label">Giờ vào mới</label>
                                                    <input type="datetime-local" class="form-control" wire:model="adjustClockInAt">
                                                    @error('adjustClockInAt') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="col-md-3 mt-3">
                                                    <label class="form-label">Giờ ra mới</label>
                                                    <input type="datetime-local" class="form-control" wire:model="adjustClockOutAt">
                                                    @error('adjustClockOutAt') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="form-label">Lý do điều chỉnh <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="adjustReason" placeholder="Ví dụ: nhân viên quên chấm ra, đã xác nhận với quản lý">
                                                    @error('adjustReason') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-label">Ghi chú hiển thị trên bảng công</label>
                                                    <textarea class="form-control" rows="2" wire:model="adjustNote" placeholder="Ghi chú nội bộ nếu cần"></textarea>
                                                    @error('adjustNote') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="button" class="btn btn-outline-secondary mb-0 me-2" wire:click="cancelAdjustment">Hủy</button>
                                                <button type="submit" class="btn bg-gradient-dark mb-0">Lưu điều chỉnh</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Bộ lọc bảng công</h6>
                                    <div class="row">
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Từ ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateFrom">
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Đến ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateTo">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Phòng ban</label>
                                            <select class="form-control" wire:model.live="departmentId">
                                                <option value="">Tất cả phòng ban</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Nhân viên</label>
                                            <select class="form-control" wire:model.live="employeeId">
                                                <option value="">Tất cả nhân viên</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->employee_code }} - {{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Trạng thái</label>
                                            <select class="form-control" wire:model.live="statusFilter">
                                                <option value="">Tất cả</option>
                                                <option value="complete">Hợp lệ</option>
                                                <option value="adjusted">Đã điều chỉnh</option>
                                                <option value="exception">Cần kiểm tra</option>
                                                <option value="absent">Vắng</option>
                                                <option value="leave">Nghỉ phép</option>
                                                <option value="weekend">Cuối tuần</option>
                                                <option value="holiday">Nghỉ lễ</option>
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
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca làm</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ vào/ra</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trễ/sớm</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">OT</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($results as $result)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $result->work_date->format('d/m/Y') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->work_date->translatedFormat('l') }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $result->employee?->full_name ?? 'Không rõ nhân viên' }}</p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $result->employee?->employee_code ?? '-' }}
                                                                -
                                                                {{ $result->employee?->department?->name ?? 'Chưa có phòng ban' }}
                                                            </p>
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
                                                            <p class="text-xs text-secondary mb-0">Thiếu log: {{ $result->missing_log_count }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->work_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">{{ number_format($result->work_minutes / 60, 1) }} giờ</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">Trễ {{ $result->late_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">Sớm {{ $result->early_leave_minutes }} phút</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->overtime_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">{{ number_format($result->overtime_minutes / 60, 1) }} giờ</p>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($result->status === 'complete')
                                                                <span class="badge bg-gradient-success">Hợp lệ</span>
                                                            @elseif ($result->status === 'adjusted')
                                                                <span class="badge bg-gradient-info">Đã điều chỉnh</span>
                                                            @elseif ($result->status === 'exception')
                                                                <span class="badge bg-gradient-warning">Cần kiểm tra</span>
                                                            @elseif ($result->status === 'absent')
                                                                <span class="badge bg-gradient-danger">Vắng</span>
                                                            @elseif ($result->status === 'leave')
                                                                <span class="badge bg-gradient-info">Nghỉ phép</span>
                                                            @elseif ($result->status === 'weekend')
                                                                <span class="badge bg-gradient-info">Cuối tuần</span>
                                                            @elseif ($result->status === 'holiday')
                                                                <span class="badge bg-gradient-primary">Nghỉ lễ</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Chưa có lịch</span>
                                                            @endif
                                                            @if ($result->note)
                                                                <p class="text-xs text-secondary mb-0 mt-1">{{ $result->note }}</p>
                                                            @endif
                                                            @if ($result->adjustments_count > 0)
                                                                <p class="text-xs text-secondary mb-0 mt-1">{{ $result->adjustments_count }} lần chỉnh</p>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button
                                                                type="button"
                                                                class="btn btn-link text-dark font-weight-bold text-xs mb-0 p-0"
                                                                wire:click="openAdjustment({{ $result->id }})"
                                                            >
                                                                Điều chỉnh
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">
                                                                Chưa có dữ liệu bảng công ngày trong bộ lọc này. Hãy chạy xử lý log trước nếu đã có log chấm công.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-xs text-secondary mt-3 mb-0">Trang này hiển thị tối đa 500 dòng bảng công ngày theo bộ lọc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
