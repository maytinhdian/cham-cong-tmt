<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Bảng công tháng</h5>
                            <p class="text-sm mb-0">Tổng hợp bảng công ngày thành dữ liệu tháng để kiểm tra trước khi chốt công.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-daily-timesheet') }}" class="btn btn-outline-secondary mb-0">Bảng công ngày</a>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-2" wire:click="generateMonthlyTimesheet">
                                Tổng hợp tháng
                            </button>
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
                                    <p class="text-white text-sm opacity-8 mb-0">Dòng bảng công tháng</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Tổng công tính</p>
                                    <h6 class="mb-0">{{ number_format($summary['attendance_value'], 2) }}</h6>
                                    <p class="text-sm mb-0">Theo bảng công ngày</p>
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
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Cần kiểm tra</p>
                                    <h6 class="mb-0">{{ $summary['exception_days'] }} ngày</h6>
                                    <p class="text-sm mb-0">{{ $summary['missing_logs'] }} log thiếu, {{ $summary['absent_days'] }} ngày vắng</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Bộ lọc bảng công tháng</h6>
                                            <p class="text-sm mb-0">Chọn tháng rồi bấm tổng hợp để cập nhật dữ liệu từ bảng công ngày.</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-0 mt-3 mt-lg-0" wire:click="resetFilters">
                                            Làm mới lọc
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Tháng</label>
                                            <input type="month" class="form-control" wire:model.live="periodMonth">
                                            @error('periodMonth') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Phòng ban</label>
                                            <select class="form-control" wire:model.live="departmentId">
                                                <option value="">Tất cả phòng ban</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('departmentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-md-4 mt-3">
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
                                                <option value="draft">Nháp</option>
                                                <option value="reviewed">Đã kiểm tra</option>
                                                <option value="locked">Đã khóa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tháng</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ngày công</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công / giờ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trễ / sớm</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">OT</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ngoại lệ</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($results as $result)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $result->period_month->format('m/Y') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->generated_at?->format('d/m/Y H:i') ?? 'Chưa tổng hợp' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $result->employee?->full_name ?? 'Không rõ nhân viên' }}</p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ $result->employee?->employee_code ?? '-' }}
                                                                -
                                                                {{ $result->department?->name ?? $result->employee?->department?->name ?? 'Chưa có phòng ban' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->total_days }} dòng</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->work_days }} hợp lệ, {{ $result->adjusted_days }} đã chỉnh</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ number_format((float) $result->attendance_value, 2) }} công</p>
                                                            <p class="text-xs text-secondary mb-0">{{ number_format($result->work_minutes / 60, 1) }} giờ làm</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">Trễ {{ $result->late_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">Sớm {{ $result->early_leave_minutes }} phút</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->overtime_minutes }} phút</p>
                                                            <p class="text-xs text-secondary mb-0">{{ number_format($result->overtime_minutes / 60, 1) }} giờ</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $result->exception_days }} cần kiểm tra</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $result->absent_days }} vắng, {{ $result->missing_log_count }} log thiếu</p>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($result->status === 'locked')
                                                                <span class="badge bg-gradient-danger">Đã khóa</span>
                                                            @elseif ($result->status === 'reviewed')
                                                                <span class="badge bg-gradient-success">Đã kiểm tra</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Nháp</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có bảng công tháng. Hãy xử lý log, kiểm tra bảng công ngày, rồi bấm tổng hợp tháng.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-xs text-secondary mt-3 mb-0">Trang này hiển thị tối đa 500 dòng bảng công tháng theo bộ lọc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
