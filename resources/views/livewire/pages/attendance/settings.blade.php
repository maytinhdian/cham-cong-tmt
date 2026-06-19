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
                        <button type="button" class="btn bg-gradient-dark mb-0">
                            Cập nhật quy tắc
                        </button>
                    </div>
                </div>

                <div class="card-body p-3">
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
                                                <input type="text" class="form-control" value="OUR COMPANY">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label">Tên viết tắt</label>
                                                <input type="text" class="form-control" value="OUR COMPANY">
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
                                                    <select class="form-control">
                                                        <option selected>Thứ hai</option>
                                                        <option>Chủ nhật</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-3 mt-md-0">
                                                    <label class="form-label">Tháng bắt đầu ngày</label>
                                                    <input type="number" class="form-control" value="1" min="1" max="31">
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
                                                    <input type="number" class="form-control" value="1200">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                                <div class="col-md-4 mt-3 mt-md-0">
                                                    <label class="form-label">Ngắn nhất vượt</label>
                                                    <input type="number" class="form-control" value="120">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                                <div class="col-md-4 mt-3 mt-md-0">
                                                    <label class="form-label">Lệch ca tối thiểu</label>
                                                    <input type="number" class="form-control" value="5">
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
                                                <input class="form-check-input" type="radio" name="twoDayShift" id="firstDayShift" checked>
                                                <label class="form-check-label" for="firstDayShift">Tính vào ngày đầu ca</label>
                                            </div>
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="radio" name="twoDayShift" id="secondDayShift">
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
                                                <input class="form-check-input" type="radio" name="outState" id="outIgnore">
                                                <label class="form-check-label" for="outIgnore">Bỏ qua trạng thái</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="outState" id="outAsOut">
                                                <label class="form-check-label" for="outAsOut">Tính là ra ngoài</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="outState" id="outBusiness">
                                                <label class="form-check-label" for="outBusiness">Tính là công tác ngoài</label>
                                            </div>
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="radio" name="outState" id="outAudit" checked>
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
                                                <input class="form-check-input" type="radio" name="otState" id="otIgnore">
                                                <label class="form-check-label" for="otIgnore">Bỏ qua trạng thái</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="otState" id="otAsDirect">
                                                <label class="form-check-label" for="otAsDirect">Tính OT trực tiếp</label>
                                            </div>
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="radio" name="otState" id="otAudit" checked>
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
                                            <input type="number" class="form-control" value="420">
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
                                                    <input type="number" class="form-control" value="10">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút thì tính đi trễ</p>
                                                </div>
                                                <div class="col-md-6 mt-3 mt-md-0">
                                                    <label class="form-label">Chấm ra sớm quá</label>
                                                    <input type="number" class="form-control" value="5">
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
                                                <input class="form-check-input" type="checkbox" id="noInEnabled" checked>
                                                <label class="form-check-label" for="noInEnabled">Không có giờ vào</label>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-7">
                                                    <label class="form-label">Tính là</label>
                                                    <select class="form-control">
                                                        <option selected>Đi trễ</option>
                                                        <option>Vắng</option>
                                                        <option>Thiếu log</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5 mt-3 mt-md-0">
                                                    <label class="form-label">Số phút</label>
                                                    <input type="number" class="form-control" value="60">
                                                </div>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="noOutEnabled" checked>
                                                <label class="form-check-label" for="noOutEnabled">Không có giờ ra</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label class="form-label">Tính là</label>
                                                    <select class="form-control">
                                                        <option selected>Về sớm</option>
                                                        <option>Vắng</option>
                                                        <option>Thiếu log</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5 mt-3 mt-md-0">
                                                    <label class="form-label">Số phút</label>
                                                    <input type="number" class="form-control" value="60">
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
                                                <input class="form-check-input" type="checkbox" id="lateAbsent">
                                                <label class="form-check-label" for="lateAbsent">Trễ vượt quá thì tính vắng</label>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Ngưỡng trễ</label>
                                                <input type="number" class="form-control" value="100">
                                                <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="earlyAbsent">
                                                <label class="form-check-label" for="earlyAbsent">Về sớm vượt quá thì tính vắng</label>
                                            </div>
                                            <div>
                                                <label class="form-label">Ngưỡng về sớm</label>
                                                <input type="number" class="form-control" value="100">
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
                                                        <input class="form-check-input" type="checkbox" id="leaveAsOt" checked>
                                                        <label class="form-check-label" for="leaveAsOt">Khoảng ra ngoài tính là OT</label>
                                                    </div>
                                                    <label class="form-label">Tối thiểu tính OT</label>
                                                    <input type="number" class="form-control" value="60">
                                                    <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                    <label class="form-label">Khoảng này tính OT</label>
                                                    <input type="number" class="form-control" value="60">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                                <div class="col-lg-4 mt-4 mt-lg-0">
                                                    <h6 class="text-sm mb-3">Trước giờ vào</h6>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="checkInIntervalOt">
                                                        <label class="form-check-label" for="checkInIntervalOt">Khoảng chấm vào tính là OT</label>
                                                    </div>
                                                    <label class="form-label">Khoảng này tính OT</label>
                                                    <input type="number" class="form-control" value="60">
                                                    <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="longestBeforeIn">
                                                        <label class="form-check-label" for="longestBeforeIn">Giới hạn OT trước giờ vào</label>
                                                    </div>
                                                    <label class="form-label">Tối đa trước giờ vào</label>
                                                    <input type="number" class="form-control" value="60">
                                                    <p class="text-xs text-secondary mt-1 mb-0">phút</p>
                                                </div>
                                                <div class="col-lg-4 mt-4 mt-lg-0">
                                                    <h6 class="text-sm mb-3">Sau giờ ra</h6>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="longestAfterOut">
                                                        <label class="form-check-label" for="longestAfterOut">Giới hạn OT sau giờ ra</label>
                                                    </div>
                                                    <label class="form-label">Tối đa sau giờ ra</label>
                                                    <input type="number" class="form-control" value="60">
                                                    <p class="text-xs text-secondary mt-1 mb-3">phút</p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="longestOvertime">
                                                        <label class="form-check-label" for="longestOvertime">Giới hạn OT tổng</label>
                                                    </div>
                                                    <label class="form-label">Tối đa OT</label>
                                                    <input type="number" class="form-control" value="120">
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
                                                    <input type="number" class="form-control" value="0.50" step="0.01">
                                                </div>
                                                <div class="col-md-4 mt-3 mt-md-0">
                                                    <label class="form-label">Đơn vị</label>
                                                    <select class="form-control">
                                                        <option selected>Ngày công</option>
                                                        <option>Giờ</option>
                                                        <option>Phút</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-3 mt-md-0">
                                                    <label class="form-label">Ký hiệu báo cáo</label>
                                                    <input type="text" class="form-control" value="G">
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <h6 class="text-sm mb-3">Kiểm soát làm tròn</h6>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="roundControl" id="roundDown">
                                                        <label class="form-check-label" for="roundDown">Làm tròn xuống</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="radio" name="roundControl" id="roundOff" checked>
                                                        <label class="form-check-label" for="roundOff">Làm tròn gần nhất</label>
                                                    </div>
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="radio" name="roundControl" id="roundUp">
                                                        <label class="form-check-label" for="roundUp">Làm tròn lên</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-4 mt-md-0">
                                                    <h6 class="text-sm mb-3">Tùy chọn cộng dồn</h6>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="accByTimes">
                                                        <label class="form-check-label" for="accByTimes">Cộng theo số lần</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="roundAtAcc" checked>
                                                        <label class="form-check-label" for="roundAtAcc">Làm tròn khi cộng dồn</label>
                                                    </div>
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" id="groupByTimePeriods">
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
                                                    <input class="form-check-input" type="checkbox" id="weekend-{{ $key }}" @checked(in_array($key, ['saturday', 'sunday'], true))>
                                                    <label class="form-check-label" for="weekend-{{ $key }}">{{ $label }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-4 mt-lg-0">
                                    <div class="card h-100">
                                        <div class="card-header pb-0 p-3">
                                            <h6 class="mb-0">Hiển thị cuối tuần</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="weekendCountAsOt">
                                                <label class="form-check-label" for="weekendCountAsOt">Cuối tuần tính là OT</label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="weekendSymbol">Ký hiệu cuối tuần trong báo cáo</label>
                                                <input id="weekendSymbol" type="text" class="form-control" value="W">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label" for="weekendColor">Màu cuối tuần trong báo cáo</label>
                                                <input id="weekendColor" type="color" class="form-control p-1" style="width: 64px; height: 42px;" value="#ff0000">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary mb-0">Hủy</button>
                        <button type="button" class="btn bg-gradient-dark mb-0">Cập nhật quy tắc</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
