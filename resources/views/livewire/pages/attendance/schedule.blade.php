<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Lịch làm việc nhân viên</h5>
                            <p class="text-sm mb-0">Phân ca theo phòng ban, nhiều nhân viên và khoảng thời gian để chuẩn bị dữ liệu chấm công.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-shift-definition') }}" class="btn btn-outline-secondary mb-0">Khai báo ca</a>
                            <a href="{{ route('employee-list') }}" class="btn bg-gradient-dark mb-0 ms-2">Danh sách nhân viên</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Phân ca nhanh</h6>
                                    <p class="text-sm mb-0">Chọn phòng ban hoặc nhiều nhân viên, sau đó áp dụng cho một khoảng ngày.</p>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="assignSchedule">
                                        <div class="form-group">
                                            <label class="form-label">Phòng ban áp dụng</label>
                                            <select class="form-control" wire:model.live="assignDepartmentId">
                                                <option value="">Không chọn phòng ban</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <p class="text-xs text-secondary mb-0 mt-1">Nếu chọn phòng ban, lịch sẽ áp dụng cho toàn bộ nhân viên trong phòng ban đó.</p>
                                            @error('assignDepartmentId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        @if ($assignDepartmentId)
                                            <div class="alert alert-info text-white text-sm mt-3 mb-0" role="alert">
                                                Sẽ áp dụng cho {{ $assignmentEmployees->count() }} nhân viên thuộc phòng ban đã chọn.
                                            </div>
                                        @else
                                            <div class="form-group mt-3">
                                                <label class="form-label">Nhân viên</label>
                                                <select class="form-control" multiple size="8" wire:model="employeeIds">
                                                    @foreach ($assignmentEmployees as $employee)
                                                        <option value="{{ $employee->id }}">
                                                            {{ $employee->employee_code }} - {{ $employee->full_name }}{{ $employee->department ? ' - '.$employee->department->name : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="text-xs text-secondary mb-0 mt-1">Giữ Ctrl để chọn nhiều nhân viên cùng lúc.</p>
                                                @error('employeeIds') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                @error('employeeIds.*') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Từ ngày</label>
                                                <input type="date" class="form-control" wire:model="assignDateFrom">
                                                @error('assignDateFrom') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Đến ngày</label>
                                                <input type="date" class="form-control" wire:model="assignDateTo">
                                                @error('assignDateTo') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ca làm</label>
                                            <select class="form-control" wire:model="shiftId">
                                                <option value="">Không gán ca</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}">
                                                        {{ $shift->name }} ({{ substr($shift->start_time, 0, 5) }} - {{ substr($shift->end_time, 0, 5) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('shiftId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Loại lịch</label>
                                                <select class="form-control" wire:model="scheduleType">
                                                    <option value="work">Đi làm</option>
                                                    <option value="off">Nghỉ</option>
                                                    <option value="holiday">Nghỉ lễ</option>
                                                    <option value="training">Đào tạo</option>
                                                </select>
                                                @error('scheduleType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái</label>
                                                <select class="form-control" wire:model="status">
                                                    <option value="planned">Dự kiến</option>
                                                    <option value="approved">Đã duyệt</option>
                                                    <option value="locked">Đã khóa</option>
                                                </select>
                                                @error('status') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" rows="3" wire:model="note" placeholder="Ví dụ: phân ca theo kế hoạch tuần"></textarea>
                                            @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button class="btn bg-gradient-dark w-100 mt-4 mb-0" type="submit">Lưu lịch làm việc</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Danh sách ca làm việc</h6>
                                    <p class="text-sm mb-0">Thông tin ca cơ bản để đối chiếu khi phân lịch.</p>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        @forelse ($shifts as $shift)
                                            <div class="col-md-6 mb-3">
                                                <div class="border rounded-3 p-3 h-100">
                                                    <div class="d-flex align-items-start">
                                                        <span
                                                            class="badge text-white me-2 mt-1"
                                                            style="background-color: {{ $shift->display_color ?: '#2563EB' }};"
                                                        >
                                                            {{ $shift->code }}
                                                        </span>
                                                        <div class="flex-grow-1">
                                                            <p class="text-sm font-weight-bold mb-0">{{ $shift->name }}</p>
                                                            <p class="text-xs text-secondary mb-0">
                                                                {{ substr($shift->start_time, 0, 5) }} - {{ substr($shift->end_time, 0, 5) }}
                                                            </p>
                                                            @if ($shift->break_minutes)
                                                                <p class="text-xs text-secondary mb-0">Nghỉ giữa ca: {{ $shift->break_minutes }} phút</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-sm text-secondary mb-0">Chưa có ca làm việc để tham khảo.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card card-calendar">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">
                                        <div>
                                            <h6 class="mb-1">Bảng lịch theo tháng</h6>
                                            <p class="text-sm mb-0">Xem nhanh lịch đã gán theo nhân viên và từng ngày trong tháng.</p>
                                        </div>
                                        <div class="schedule-month-filters mt-3 mt-lg-0">
                                            <div class="schedule-month-department-filter">
                                                <label class="form-label text-xs text-uppercase text-secondary mb-1">Phòng ban</label>
                                                <select class="form-control" wire:model.live="departmentFilter">
                                                    <option value="">Tất cả</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="schedule-month-control">
                                                <label class="form-label text-xs text-uppercase text-secondary mb-1">Tháng</label>
                                                <div class="schedule-month-nav">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm mb-0"
                                                        type="button"
                                                        wire:click="previousScheduleMonth"
                                                        title="Lùi 1 tháng"
                                                    >
                                                        <i class="material-icons-round text-sm">chevron_left</i>
                                                    </button>
                                                    <input type="month" class="form-control" wire:model.live="scheduleMonth">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm mb-0"
                                                        type="button"
                                                        wire:click="nextScheduleMonth"
                                                        title="Tiến 1 tháng"
                                                    >
                                                        <i class="material-icons-round text-sm">chevron_right</i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="schedule-month-today">
                                                <label class="form-label text-xs text-uppercase text-secondary mb-1">&nbsp;</label>
                                                <button
                                                    class="btn bg-gradient-primary btn-sm mb-0 w-100"
                                                    type="button"
                                                    wire:click="goToCurrentScheduleMonth"
                                                >
                                                    Hôm nay
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="schedule-month-scroll" style="--schedule-weekend-color: {{ $weekendHighlightColor }}; --schedule-weekend-bg: {{ $weekendHighlightBackground }};">
                                        <table class="table align-items-center mb-0 schedule-month-table">
                                            <thead>
                                                <tr>
                                                    <th class="schedule-month-employee-col text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        <div class="schedule-month-employee-header">
                                                            <span class="schedule-month-employee-title">Nhân viên</span>
                                                            <button
                                                                class="btn btn-link text-secondary schedule-month-sort-btn mb-0 p-0"
                                                                type="button"
                                                                wire:click="toggleEmployeeSort"
                                                                title="{{ $employeeSortDirection === 'asc' ? 'Sắp xếp Z-A' : 'Sắp xếp A-Z' }}"
                                                                aria-label="{{ $employeeSortDirection === 'asc' ? 'Sắp xếp Z-A' : 'Sắp xếp A-Z' }}"
                                                            >
                                                                <span class="schedule-month-alpha-sort" aria-hidden="true">
                                                                    <span>{{ $employeeSortDirection === 'asc' ? 'A' : 'Z' }}</span>
                                                                    <i class="material-icons-round">arrow_downward</i>
                                                                    <span>{{ $employeeSortDirection === 'asc' ? 'Z' : 'A' }}</span>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </th>
                                                    @foreach ($scheduleDays as $day)
                                                        @php
                                                            $isWeekendHeader = in_array($day->dayOfWeekIso, $weekendWeekdays, true);
                                                        @endphp
                                                        <th class="schedule-month-day-col {{ $isWeekendHeader ? 'schedule-month-day-col--weekend' : '' }} text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            <span class="schedule-month-weekday">
                                                                {{ ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'][$day->dayOfWeek] }}
                                                            </span>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($employees as $employee)
                                                    <tr>
                                                        <td class="schedule-month-employee-col">
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $employee->department?->name ?? 'Chưa gán phòng ban' }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @foreach ($scheduleDays as $day)
                                                            @php
                                                                $schedule = $monthlyScheduleByEmployeeDate[$employee->id][$day->toDateString()] ?? null;
                                                                $isWeekendDay = in_array($day->dayOfWeekIso, $weekendWeekdays, true);
                                                                $shiftTitle = $schedule?->shift
                                                                    ? $schedule->shift->name.' - '.substr($schedule->shift->start_time, 0, 5).' đến '.substr($schedule->shift->end_time, 0, 5)
                                                                    : strtoupper((string) $schedule?->schedule_type);
                                                            @endphp
                                                            <td class="schedule-month-cell {{ $isWeekendDay ? 'schedule-month-cell--weekend' : '' }}">
                                                                <div class="schedule-month-cell-inner">
                                                                    <span class="schedule-month-cell-date">{{ $day->format('j') }}</span>
                                                                    @if ($schedule)
                                                                        @if ($schedule->shift)
                                                                            <span
                                                                                class="schedule-month-shift badge text-white"
                                                                                style="background-color: {{ $schedule->shift->display_color ?: '#2563EB' }};"
                                                                                title="{{ $shiftTitle }}"
                                                                            >
                                                                                {{ $schedule->shift->code }}
                                                                            </span>
                                                                        @else
                                                                            <span class="schedule-month-shift badge bg-gradient-secondary" title="{{ $shiftTitle }}">
                                                                                {{ strtoupper($schedule->schedule_type) }}
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ count($scheduleDays) + 1 }}" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Không có nhân viên phù hợp.</p>
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

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Danh sách lịch đã khai báo</h6>
                                    <p class="text-sm mb-0">Lọc và xem chi tiết các dòng lịch trong khoảng ngày cần kiểm tra.</p>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Phòng ban</label>
                                            <select class="form-control" wire:model.live="departmentFilter">
                                                <option value="">Tất cả</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <label class="form-label">Từ ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateFrom">
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <label class="form-label">Đến ngày</label>
                                            <input type="date" class="form-control" wire:model.live="dateTo">
                                        </div>
                                    </div>

                                    @php
                                        $remainingSchedulesCount = max($schedules->count() - 10, 0);
                                        $visibleSchedules = $showAllDeclaredSchedules ? $schedules : $schedules->take(10);
                                    @endphp

                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($visibleSchedules as $schedule)
                                                    <tr>
                                                        <td><p class="text-sm mb-0">{{ $schedule->work_date->format('d/m/Y') }}</p></td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $schedule->employee->full_name }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $schedule->employee->employee_code }} - {{ $schedule->employee->department?->name ?? 'Chưa gán' }}</p>
                                                        </td>
                                                        <td>
                                                            @if ($schedule->shift)
                                                                <span
                                                                    class="badge text-white"
                                                                    style="background-color: {{ $schedule->shift->display_color ?: '#2563EB' }};"
                                                                >
                                                                    {{ $schedule->shift->name }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Không gán ca</span>
                                                            @endif
                                                        </td>
                                                        <td><span class="badge bg-gradient-info">{{ $schedule->schedule_type }}</span></td>
                                                        <td><span class="badge bg-gradient-secondary">{{ $schedule->status }}</span></td>
                                                        <td class="text-center">
                                                            <button
                                                                class="btn btn-link text-danger text-xs font-weight-bold mb-0 p-0"
                                                                type="button"
                                                                wire:click="deleteSchedule({{ $schedule->id }})"
                                                                wire:confirm="Xóa dòng lịch này?"
                                                            >
                                                                Xóa
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có lịch làm việc trong khoảng ngày này.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($remainingSchedulesCount > 0)
                                        <button
                                            class="btn btn-outline-secondary btn-sm mt-3 mb-0"
                                            type="button"
                                            wire:click="toggleDeclaredSchedules"
                                        >
                                            {{ $showAllDeclaredSchedules ? 'Thu gọn' : 'Xem thêm '.$remainingSchedulesCount.' dòng' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
