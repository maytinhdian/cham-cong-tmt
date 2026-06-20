<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Quy tắc tính công</h6>
                            <p class="text-sm text-secondary mb-0">
                                Thiết lập quy tắc chuyển log chấm công thành công chuẩn, trạng thái và ký hiệu báo cáo.
                            </p>
                        </div>
                        <button type="submit" form="attendance-rules-form" class="btn bg-gradient-dark mb-0">
                            Cập nhật quy tắc
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="card-body p-3">
                    <form id="attendance-rules-form" wire:submit.prevent="saveRules">
                        <div class="nav-wrapper position-relative end-0 mb-4">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#basic-settings" role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative">settings</i>
                                        <span class="ms-1">Cơ bản</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#calculation-settings" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">calculate</i>
                                        <span class="ms-1">Tính công</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#statistic-items" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">format_list_bulleted</i>
                                        <span class="ms-1">Ký hiệu thống kê</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#weekend-set" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">weekend</i>
                                        <span class="ms-1">Cuối tuần</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="basic-settings" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Thông tin đơn vị</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên đơn vị</label>
                                                    <input type="text" class="form-control" wire:model="rules.company_name">
                                                    @error('rules.company_name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label">Tên viết tắt</label>
                                                    <input type="text" class="form-control" wire:model="rules.company_short_name">
                                                    @error('rules.company_short_name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4 mt-lg-0">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Kỳ công</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tuần bắt đầu từ</label>
                                                        <select class="form-control" wire:model="rules.week_starts_on">
                                                            <option value="monday">Thứ hai</option>
                                                            <option value="sunday">Chủ nhật</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-3 mt-md-0">
                                                        <label class="form-label">Tháng bắt đầu ngày</label>
                                                        <input type="number" class="form-control" wire:model="rules.month_starts_day" min="1" max="31">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Giới hạn nhận diện ca</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Dài nhất dưới</label>
                                                        <input type="number" class="form-control" wire:model="rules.max_shift_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                    <div class="col-md-4 mt-3 mt-md-0">
                                                        <label class="form-label">Ngắn nhất vượt</label>
                                                        <input type="number" class="form-control" wire:model="rules.min_overtime_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                    <div class="col-md-4 mt-3 mt-md-0">
                                                        <label class="form-label">Lệch ca tối thiểu</label>
                                                        <input type="number" class="form-control" wire:model="rules.min_shift_gap_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Ca kéo dài hai ngày</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="twoDayShift" id="firstDayShift" value="first_day" wire:model="rules.two_day_shift_policy">
                                                    <label class="form-check-label" for="firstDayShift">Tính vào ngày đầu ca</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="radio" name="twoDayShift" id="secondDayShift" value="second_day" wire:model="rules.two_day_shift_policy">
                                                    <label class="form-check-label" for="secondDayShift">Tính vào ngày sau ca</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Trạng thái ra ngoài</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="outState" id="outIgnore" value="ignore" wire:model="rules.out_state_policy">
                                                    <label class="form-check-label" for="outIgnore">Bỏ qua trạng thái</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="outState" id="outAsOut" value="out" wire:model="rules.out_state_policy">
                                                    <label class="form-check-label" for="outAsOut">Tính là ra ngoài</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="outState" id="outBusiness" value="business" wire:model="rules.out_state_policy">
                                                    <label class="form-check-label" for="outBusiness">Tính là công tác ngoài</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="radio" name="outState" id="outAudit" value="audit" wire:model="rules.out_state_policy">
                                                    <label class="form-check-label" for="outAudit">Đưa vào kiểm tra</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Trạng thái OT</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="otState" id="otIgnore" value="ignore" wire:model="rules.ot_state_policy">
                                                    <label class="form-check-label" for="otIgnore">Bỏ qua trạng thái</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="otState" id="otAsDirect" value="direct" wire:model="rules.ot_state_policy">
                                                    <label class="form-check-label" for="otAsDirect">Tính OT trực tiếp</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="radio" name="otState" id="otAudit" value="audit" wire:model="rules.ot_state_policy">
                                                    <label class="form-check-label" for="otAudit">Đưa vào kiểm tra</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="calculation-settings" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Công chuẩn</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <label class="form-label">Một ngày công</label>
                                                <input type="number" class="form-control" wire:model="rules.standard_work_minutes">
                                                <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 mt-4 mt-lg-0">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Ngưỡng trễ / sớm</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Chấm vào quá</label>
                                                        <input type="number" class="form-control" wire:model="rules.late_threshold_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút thì tính đi trễ</p>
                                                    </div>
                                                    <div class="col-md-6 mt-3 mt-md-0">
                                                        <label class="form-label">Chấm ra sớm quá</label>
                                                        <input type="number" class="form-control" wire:model="rules.early_threshold_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút thì tính về sớm</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Thiếu chấm công</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="noInEnabled" wire:model="rules.no_in_enabled">
                                                    <label class="form-check-label" for="noInEnabled">Không có giờ vào</label>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-7">
                                                        <label class="form-label">Tính là</label>
                                                        <select class="form-control" wire:model="rules.no_in_policy">
                                                            <option value="late">Đi trễ</option>
                                                            <option value="absent">Vắng</option>
                                                            <option value="missing_log">Thiếu log</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mt-3 mt-md-0">
                                                        <label class="form-label">Số phút</label>
                                                        <input type="number" class="form-control" wire:model="rules.no_in_minutes">
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="noOutEnabled" wire:model="rules.no_out_enabled">
                                                    <label class="form-check-label" for="noOutEnabled">Không có giờ ra</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <label class="form-label">Tính là</label>
                                                        <select class="form-control" wire:model="rules.no_out_policy">
                                                            <option value="early">Về sớm</option>
                                                            <option value="absent">Vắng</option>
                                                            <option value="missing_log">Thiếu log</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 mt-3 mt-md-0">
                                                        <label class="form-label">Số phút</label>
                                                        <input type="number" class="form-control" wire:model="rules.no_out_minutes">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mt-4">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Ngưỡng tính vắng</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="lateAbsent" wire:model="rules.late_absent_enabled">
                                                    <label class="form-check-label" for="lateAbsent">Trễ vượt quá thì tính vắng</label>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Ngưỡng trễ</label>
                                                    <input type="number" class="form-control" wire:model="rules.late_absent_minutes">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="earlyAbsent" wire:model="rules.early_absent_enabled">
                                                    <label class="form-check-label" for="earlyAbsent">Về sớm vượt quá thì tính vắng</label>
                                                </div>
                                                <div>
                                                    <label class="form-label">Ngưỡng về sớm</label>
                                                    <input type="number" class="form-control" wire:model="rules.early_absent_minutes">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="card">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Quy tắc tính tăng ca</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h6 class="text-sm mb-3">Ra ngoài trong ca</h6>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="leaveAsOt" wire:model="rules.leave_interval_as_ot">
                                                            <label class="form-check-label" for="leaveAsOt">Khoảng ra ngoài tính là OT</label>
                                                        </div>
                                                        <label class="form-label">Tối thiểu tính OT</label>
                                                        <input type="number" class="form-control" wire:model="rules.leave_min_ot_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                        <label class="form-label">Khoảng này tính OT</label>
                                                        <input type="number" class="form-control" wire:model="rules.leave_ot_interval_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                    <div class="col-lg-4 mt-4 mt-lg-0">
                                                        <h6 class="text-sm mb-3">Trước giờ vào</h6>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="checkInIntervalOt" wire:model="rules.before_in_interval_as_ot">
                                                            <label class="form-check-label" for="checkInIntervalOt">Khoảng chấm vào tính là OT</label>
                                                        </div>
                                                        <label class="form-label">Khoảng này tính OT</label>
                                                        <input type="number" class="form-control" wire:model="rules.before_in_ot_interval_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="longestBeforeIn" wire:model="rules.limit_before_in_enabled">
                                                            <label class="form-check-label" for="longestBeforeIn">Giới hạn OT trước giờ vào</label>
                                                        </div>
                                                        <label class="form-label">Tối đa trước giờ vào</label>
                                                        <input type="number" class="form-control" wire:model="rules.max_before_in_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                    <div class="col-lg-4 mt-4 mt-lg-0">
                                                        <h6 class="text-sm mb-3">Sau giờ ra</h6>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="longestAfterOut" wire:model="rules.limit_after_out_enabled">
                                                            <label class="form-check-label" for="longestAfterOut">Giới hạn OT sau giờ ra</label>
                                                        </div>
                                                        <label class="form-label">Tối đa sau giờ ra</label>
                                                        <input type="number" class="form-control" wire:model="rules.max_after_out_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="checkbox" id="longestOvertime" wire:model="rules.limit_total_overtime_enabled">
                                                            <label class="form-check-label" for="longestOvertime">Giới hạn OT tổng</label>
                                                        </div>
                                                        <label class="form-label">Tối đa OT</label>
                                                        <input type="number" class="form-control" wire:model="rules.max_total_overtime_minutes">
                                                        <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="statistic-items" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Danh sách trạng thái</label>
                                        <select class="form-control" size="14">
                                            @foreach ($statisticItems as $item)
                                                <option @selected($loop->first)>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-8 mt-4 mt-lg-0">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Quy tắc thống kê</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Đơn vị tối thiểu</label>
                                                        <input type="number" class="form-control" wire:model="rules.stat_min_unit" step="0.01">
                                                    </div>
                                                    <div class="col-md-4 mt-3 mt-md-0">
                                                        <label class="form-label">Đơn vị</label>
                                                        <select class="form-control" wire:model="rules.stat_unit">
                                                            <option value="workday">Ngày công</option>
                                                            <option value="hour">Giờ</option>
                                                            <option value="minute">Phút</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mt-3 mt-md-0">
                                                        <label class="form-label">Ký hiệu báo cáo</label>
                                                        <input type="text" class="form-control" wire:model="rules.stat_report_symbol">
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <h6 class="text-sm mb-3">Kiểm soát làm tròn</h6>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="roundControl" id="roundDown" value="down" wire:model="rules.rounding_policy">
                                                            <label class="form-check-label" for="roundDown">Làm tròn xuống</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="roundControl" id="roundOff" value="nearest" wire:model="rules.rounding_policy">
                                                            <label class="form-check-label" for="roundOff">Làm tròn gần nhất</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="radio" name="roundControl" id="roundUp" value="up" wire:model="rules.rounding_policy">
                                                            <label class="form-check-label" for="roundUp">Làm tròn lên</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-4 mt-md-0">
                                                        <h6 class="text-sm mb-3">Tùy chọn cộng dồn</h6>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" id="accByTimes" wire:model="rules.accumulate_by_times">
                                                            <label class="form-check-label" for="accByTimes">Cộng theo số lần</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" id="roundAtAcc" wire:model="rules.round_at_accumulation">
                                                            <label class="form-check-label" for="roundAtAcc">Làm tròn khi cộng dồn</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" id="groupByTimePeriods" wire:model="rules.group_by_time_periods">
                                                            <label class="form-check-label" for="groupByTimePeriods">Nhóm theo khoảng thời gian</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="weekend-set" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="mb-3">Chọn ngày cuối tuần</h6>
                                        <div class="row">
                                            @foreach ($weekdays as $key => $label)
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="weekend-{{ $key }}" value="{{ $key }}" wire:model="weekendDays">
                                                        <label class="form-check-label" for="weekend-{{ $key }}">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('weekendDays') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="col-lg-6 mt-4 mt-lg-0">
                                        <div class="card h-100">
                                            <div class="card-header pb-0 p-3">
                                                <h6 class="mb-0">Hiển thị cuối tuần</h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="weekendCountAsOt" wire:model="rules.weekend_count_as_ot">
                                                    <label class="form-check-label" for="weekendCountAsOt">Cuối tuần tính là OT</label>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="weekendSymbol">Ký hiệu cuối tuần trong báo cáo</label>
                                                    <input id="weekendSymbol" type="text" class="form-control" wire:model="rules.weekend_symbol">
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label" for="weekendColor">Màu cuối tuần trong báo cáo</label>
                                                    <input id="weekendColor" type="color" class="form-control p-1" style="width: 64px; height: 42px;" wire:model="rules.weekend_color">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="reset" class="btn btn-outline-secondary mb-0">Hủy</button>
                            <button type="submit" class="btn bg-gradient-dark mb-0">Cập nhật quy tắc</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
