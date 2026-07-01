<div class="container-fluid py-4 shift-definition-page">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Khai báo ca làm việc</h6>
                            <p class="text-sm text-secondary mb-0">
                                Quản lý ca làm việc, khung giờ chấm công và quy tắc tính công theo từng ca.
                            </p>
                        </div>
                        <button type="button"
                            wire:click="resetForm"
                            class="btn bg-gradient-dark mb-0 d-flex align-items-center gap-2"
                            title="Thêm ca làm việc">
                            <i class="material-icons text-sm">add</i>
                            <span>Thêm ca</span>
                        </button>
                    </div>
                </div>

                <div class="card-body p-3">
                    @if (session('success'))
                        <div class="alert alert-success text-white text-sm" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white text-sm" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ca làm việc</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ ca</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chấm vào</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chấm ra</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công chuẩn</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody wire:key="shift-table-{{ $tableRefreshKey }}">
                                        @forelse ($shifts as $shift)
                                            <tr wire:key="shift-row-{{ $shift->id }}-{{ $shift->status }}-{{ $tableRefreshKey }}">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <span class="avatar avatar-sm border-radius-lg me-3"
                                                                style="background-color: {{ $shift->display_color ?: '#2563EB' }};">
                                                                <i class="material-icons text-white text-sm">
                                                                    {{ (int) substr($shift->start_time, 0, 2) >= 18 || (int) substr($shift->end_time, 0, 2) <= 7 ? 'bedtime' : 'business_center' }}
                                                                </i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs">{{ $shift->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $shift->code }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ substr($shift->start_time, 0, 5) }} - {{ substr($shift->end_time, 0, 5) }}
                                                        @if (substr($shift->end_time, 0, 5) <= substr($shift->start_time, 0, 5))
                                                            <span class="badge badge-sm bg-gradient-info ms-1">Qua đêm</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        Trễ {{ $shift->max_late_minutes }} phút, sớm {{ $shift->max_early_leave_minutes }} phút
                                                    </p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        Nghỉ giữa ca:
                                                        @if ($shift->break_start_time && $shift->break_end_time)
                                                            {{ substr($shift->break_start_time, 0, 5) }} - {{ substr($shift->break_end_time, 0, 5) }}
                                                        @else
                                                            Chưa khai báo
                                                        @endif
                                                        @if ($shift->break_as_overtime_enabled)
                                                            <span class="badge badge-sm bg-gradient-warning ms-1">Nghỉ tính OT</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        OT:
                                                        @if ($shift->overtime_before_shift_enabled)
                                                            Tr&#432;&#7899;c ca t&#7915; {{ $shift->overtime_before_shift_min_minutes }} ph&#250;t,
                                                        @else
                                                            Kh&#244;ng tr&#432;&#7899;c ca,
                                                        @endif
                                                        @if ($shift->overtime_after_shift_enabled)
                                                            sau ca t&#7915; {{ $shift->overtime_after_shift_min_minutes }} ph&#250;t
                                                        @else
                                                            kh&#244;ng sau ca
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">
                                                        {{ $shift->clock_in_from ? substr($shift->clock_in_from, 0, 5) : '--:--' }}
                                                        -
                                                        {{ $shift->clock_in_to ? substr($shift->clock_in_to, 0, 5) : '--:--' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">
                                                        {{ $shift->clock_out_from ? substr($shift->clock_out_from, 0, 5) : '--:--' }}
                                                        -
                                                        {{ $shift->clock_out_to ? substr($shift->clock_out_to, 0, 5) : '--:--' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-dot me-4">
                                                        <i class="{{ $shift->status === 'active' ? 'bg-success' : 'bg-secondary' }}"></i>
                                                        <span class="text-dark text-xs">
                                                            {{ rtrim(rtrim(number_format((float) $shift->workday_value, 2), '0'), '.') }} công /
                                                            {{ $shift->standard_work_minutes }} phút
                                                        </span>
                                                    </span>
                                                </td>
                                                <td class="align-middle" wire:key="shift-status-{{ $shift->id }}-{{ $shift->status }}-{{ $tableRefreshKey }}">
                                                    @if ($shift->status === 'active')
                                                        <span class="badge badge-sm bg-gradient-success">Đang dùng</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-secondary">Tạm ngưng</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button type="button"
                                                        wire:click="editShift({{ $shift->id }})"
                                                        class="btn btn-link text-info mb-0 p-0 me-3"
                                                        title="Chi tiết ca"
                                                        aria-label="Chi tiết ca {{ $shift->name }}">
                                                        <i class="material-icons text-sm">visibility</i>
                                                    </button>
                                                    <button type="button"
                                                        wire:click="editShift({{ $shift->id }})"
                                                        class="btn btn-link text-secondary mb-0 p-0 me-3"
                                                        title="Sửa ca"
                                                        aria-label="Sửa ca {{ $shift->name }}">
                                                        <i class="material-icons text-sm">edit</i>
                                                    </button>
                                                    <button type="button"
                                                        wire:click="deleteShift({{ $shift->id }})"
                                                        wire:confirm="Xóa ca làm việc này?"
                                                        class="btn btn-link text-danger mb-0 p-0"
                                                        title="Xóa ca"
                                                        aria-label="Xóa ca {{ $shift->name }}">
                                                        <i class="material-icons text-sm">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-secondary text-sm py-4">
                                                    Chưa có ca làm việc. Bấm thêm ca để khai báo ca đầu tiên.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <h6 class="mb-0">Thông tin ca</h6>
                                        @if ($editingShiftId)
                                            <span class="badge badge-sm bg-gradient-info">Đang sửa</span>
                                        @endif
                                    </div>
                                </div>

                                <form wire:submit.prevent="saveShift" wire:key="shift-form-{{ $editingShiftId ?? 'new' }}">
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Thông tin ca</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="shiftName">Tên ca <span class="text-danger">*</span></label>
                                                    <input id="shiftName" type="text" class="form-control" wire:model.defer="name">
                                                    @error('name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="shiftCode">Mã ca <span class="text-danger">*</span></label>
                                                    <input id="shiftCode" type="text" class="form-control text-uppercase" wire:model.defer="code">
                                                    @error('code') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="startTime">Giờ vào <span class="text-danger">*</span></label>
                                                            <input id="startTime" type="text" class="form-control js-shift-time-picker" wire:model.live="startTime" placeholder="HH:mm" autocomplete="off" data-time-required="true">
                                                            @error('startTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="endTime">Giờ ra <span class="text-danger">*</span></label>
                                                            <input id="endTime" type="text" class="form-control js-shift-time-picker" wire:model.live="endTime" placeholder="HH:mm" autocomplete="off" data-time-required="true">
                                                            @error('endTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-secondary mt-n2 mb-3">Chọn giờ theo định dạng 24h, ví dụ 08:00 hoặc 22:30.</p>

                                                @if ($isOvernightShift)
                                                    <div class="alert alert-info text-white text-xs py-2 px-3 mb-0" role="alert">
                                                        Ca này qua ngày: giờ ra được tính vào ngày hôm sau.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Nghỉ giữa ca</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="breakStartTime">Nghỉ giữa ca từ</label>
                                                            <input id="breakStartTime" type="text" class="form-control js-shift-time-picker" wire:model.defer="breakStartTime" placeholder="--:--" autocomplete="off">
                                                            @error('breakStartTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="breakEndTime">Nghỉ giữa ca đến</label>
                                                            <input id="breakEndTime" type="text" class="form-control js-shift-time-picker" wire:model.defer="breakEndTime" placeholder="--:--" autocomplete="off">
                                                            @error('breakEndTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="breakMinutes">Số phút nghỉ giữa ca</label>
                                                            <input id="breakMinutes" type="number" class="form-control" wire:model.defer="breakMinutes">
                                                            @error('breakMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check form-switch ps-0 d-flex align-items-center mb-0">
                                                    <input class="form-check-input ms-0 me-2" type="checkbox" id="breakAsOvertimeEnabled" wire:model.live="breakAsOvertimeEnabled">
                                                    <label class="form-check-label text-body text-sm" for="breakAsOvertimeEnabled">
                                                        Tính nghỉ giữa ca là tăng ca
                                                    </label>
                                                </div>
                                                @error('breakAsOvertimeEnabled') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Quy tắc xác định công</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="clockInFrom">Chấm vào từ</label>
                                                            <input id="clockInFrom" type="text" class="form-control js-shift-time-picker" wire:model.defer="clockInFrom" placeholder="--:--" autocomplete="off">
                                                            @error('clockInFrom') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="clockInTo">Chấm vào đến</label>
                                                            <input id="clockInTo" type="text" class="form-control js-shift-time-picker" wire:model.defer="clockInTo" placeholder="--:--" autocomplete="off">
                                                            @error('clockInTo') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="clockOutFrom">Chấm ra từ</label>
                                                            <input id="clockOutFrom" type="text" class="form-control js-shift-time-picker" wire:model.defer="clockOutFrom" placeholder="--:--" autocomplete="off">
                                                            @error('clockOutFrom') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="clockOutTo">Chấm ra đến</label>
                                                            <input id="clockOutTo" type="text" class="form-control js-shift-time-picker" wire:model.defer="clockOutTo" placeholder="--:--" autocomplete="off">
                                                            @error('clockOutTo') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="maxLateMinutes">Trễ tối đa</label>
                                                            <input id="maxLateMinutes" type="number" class="form-control" wire:model.defer="maxLateMinutes">
                                                            @error('maxLateMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="maxEarlyLeaveMinutes">Sớm tối đa</label>
                                                            <input id="maxEarlyLeaveMinutes" type="number" class="form-control" wire:model.defer="maxEarlyLeaveMinutes">
                                                            @error('maxEarlyLeaveMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-0">
                                                            <label class="form-label" for="workdayValue">Số công</label>
                                                            <input id="workdayValue" type="number" class="form-control" wire:model.defer="workdayValue" step="0.1">
                                                            @error('workdayValue') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-0">
                                                            <label class="form-label" for="standardWorkMinutes">Phút chuẩn</label>
                                                            <input id="standardWorkMinutes" type="number" class="form-control" wire:model.defer="standardWorkMinutes">
                                                            @error('standardWorkMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Yêu cầu chấm công</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="form-check form-switch ps-0 d-flex align-items-center mb-2">
                                                    <input class="form-check-input ms-0 me-2" type="radio" id="attendanceRequirementBoth" name="attendanceRequirement" value="both" wire:model.live="attendanceRequirement">
                                                    <label class="form-check-label text-body text-sm" for="attendanceRequirementBoth">
                                                        Bắt buộc đủ vào và ra
                                                    </label>
                                                </div>
                                                <div class="form-check form-switch ps-0 d-flex align-items-center mb-2">
                                                    <input class="form-check-input ms-0 me-2" type="radio" id="attendanceRequirementOne" name="attendanceRequirement" value="one" wire:model.live="attendanceRequirement">
                                                    <label class="form-check-label text-body text-sm" for="attendanceRequirementOne">
                                                        Chỉ cần một lần chấm
                                                    </label>
                                                </div>
                                                <div class="form-check form-switch ps-0 d-flex align-items-center mb-0">
                                                    <input class="form-check-input ms-0 me-2" type="radio" id="attendanceRequirementNone" name="attendanceRequirement" value="none" wire:model.live="attendanceRequirement">
                                                    <label class="form-check-label text-body text-sm" for="attendanceRequirementNone">
                                                        Không yêu cầu chấm công
                                                    </label>
                                                </div>
                                            </div>
                                            @error('attendanceRequirement') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Quy t&#7855;c t&#259;ng ca</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-2">
                                                    <div class="form-check form-switch ps-0 d-flex align-items-center mb-0">
                                                        <input class="form-check-input ms-0 me-2" type="checkbox" id="overtimeBeforeShiftEnabled" wire:model.live="overtimeBeforeShiftEnabled">
                                                        <label class="form-check-label text-body text-sm" for="overtimeBeforeShiftEnabled">
                                                            T&#237;nh t&#259;ng ca tr&#432;&#7899;c gi&#7901; l&#224;m vi&#7879;c
                                                        </label>
                                                    </div>

                                                    @if ($overtimeBeforeShiftEnabled)
                                                        <div class="d-flex align-items-center gap-2" style="max-width: 140px;">
                                                            <input id="overtimeBeforeShiftMinMinutes" type="number" class="form-control form-control-sm" wire:model.defer="overtimeBeforeShiftMinMinutes" min="0">
                                                            <label class="form-label text-sm mb-0" for="overtimeBeforeShiftMinMinutes">Ph&#250;t</label>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                                    <div class="form-check form-switch ps-0 d-flex align-items-center mb-0">
                                                        <input class="form-check-input ms-0 me-2" type="checkbox" id="overtimeAfterShiftEnabled" wire:model.live="overtimeAfterShiftEnabled">
                                                        <label class="form-check-label text-body text-sm" for="overtimeAfterShiftEnabled">
                                                            T&#237;nh t&#259;ng ca sau gi&#7901; l&#224;m vi&#7879;c
                                                        </label>
                                                    </div>

                                                    @if ($overtimeAfterShiftEnabled)
                                                        <div class="d-flex align-items-center gap-2" style="max-width: 140px;">
                                                            <input id="overtimeAfterShiftMinMinutes" type="number" class="form-control form-control-sm" wire:model.defer="overtimeAfterShiftMinMinutes" min="0">
                                                            <label class="form-label text-sm mb-0" for="overtimeAfterShiftMinMinutes">Ph&#250;t</label>
                                                        </div>
                                                    @endif
                                                </div>

                                                <p class="text-xs text-secondary mb-0 mt-2">V&#237; d&#7909; nh&#7853;p 30: &#7903; l&#7841;i d&#432;&#7899;i 30 ph&#250;t kh&#244;ng t&#237;nh OT; t&#7915; 30 ph&#250;t tr&#7903; l&#234;n m&#7899;i t&#237;nh.</p>
                                            </div>
                                            @error('overtimeBeforeShiftEnabled') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            @error('overtimeBeforeShiftMinMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            @error('overtimeAfterShiftEnabled') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            @error('overtimeAfterShiftMinMinutes') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block mb-2">Hiển thị và trạng thái</label>
                                            <div class="border rounded-3 p-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="displayColor">Màu hiển thị</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <input id="displayColorPicker"
                                                            type="color"
                                                            class="form-control p-1"
                                                            style="width: 48px; height: 40px;"
                                                            wire:model.live="displayColor">
                                                        <input id="displayColor" type="text" class="form-control" wire:model.live.debounce.300ms="displayColor">
                                                    </div>
                                                    @error('displayColor') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="description">Mô tả</label>
                                                    <textarea id="description" class="form-control" rows="3" wire:model.defer="description"></textarea>
                                                    @error('description') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label" for="status">Trạng thái</label>
                                                    <select id="status" class="form-control" wire:model.live="status">
                                                        <option value="active">Đang dùng</option>
                                                        <option value="inactive">Tạm ngưng</option>
                                                    </select>
                                                    @error('status') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="button" wire:click="resetForm" class="btn btn-outline-secondary shift-form-action-btn mb-0">Hủy</button>
                                            <button type="submit" class="btn bg-gradient-dark shift-form-action-btn mb-0">
                                                {{ $editingShiftId ? 'Cập nhật' : 'Lưu ca' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script>
        (function () {
            function syncLivewireValue(input) {
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }

            function initShiftTimePickers() {
                if (typeof flatpickr === 'undefined') {
                    return;
                }

                document.querySelectorAll('.js-shift-time-picker').forEach(function (input) {
                    if (input._flatpickr) {
                        return;
                    }

                    flatpickr(input, {
                        allowInput: false,
                        clickOpens: true,
                        dateFormat: 'H:i',
                        disableMobile: true,
                        enableTime: true,
                        minuteIncrement: 5,
                        noCalendar: true,
                        time_24hr: true,
                        onChange: function (selectedDates, dateString) {
                            input.value = dateString;
                            syncLivewireValue(input);
                        },
                        onClose: function () {
                            syncLivewireValue(input);
                        },
                        onReady: function (selectedDates, dateString, instance) {
                            if (input.dataset.timeRequired === 'true') {
                                return;
                            }

                            var clearButton = document.createElement('button');
                            clearButton.type = 'button';
                            clearButton.className = 'btn btn-link text-secondary text-xs mb-0 px-2 py-1';
                            clearButton.textContent = 'Xóa giờ';
                            clearButton.addEventListener('click', function () {
                                instance.clear();
                                input.value = '';
                                syncLivewireValue(input);
                                instance.close();
                            });

                            instance.calendarContainer.appendChild(clearButton);
                        }
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', initShiftTimePickers);
            document.addEventListener('livewire:init', function () {
                initShiftTimePickers();

                if (window.Livewire && typeof window.Livewire.hook === 'function') {
                    window.Livewire.hook('morph.updated', initShiftTimePickers);
                    window.Livewire.hook('morph.added', initShiftTimePickers);
                }
            });
        })();
    </script>
@endpush
