<style>
    .attendance-rules-page .form-control,
    .attendance-rules-page .form-select {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
        box-shadow: none !important;
    }

    .attendance-rules-page .form-control:focus,
    .attendance-rules-page .form-select:focus {
        border-color: #5e72e4 !important;
        box-shadow: 0 0 0 0.15rem rgba(94, 114, 228, 0.15) !important;
    }

    .attendance-rules-page .rule-summary {
        border-left: 1px solid #e9ecef;
    }

    @media (max-width: 1199.98px) {
        .attendance-rules-page .rule-summary {
            border-left: 0;
            border-top: 1px solid #e9ecef;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }
    }
</style>

<div class="container-fluid py-4 attendance-rules-page">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-3 pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Quy tắc tính công</h6>
                            <p class="text-sm mb-0">
                                Thiết lập cách hệ thống chuyển dữ liệu chấm công thành công chuẩn, công thiếu và công tăng ca.
                            </p>
                        </div>
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab"
                                        href="#standard-work" role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative">schedule</i>
                                        <span class="ms-1">Công chuẩn</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                        href="#late-early" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">timer</i>
                                        <span class="ms-1">Trễ / sớm</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                        href="#overtime" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">more_time</i>
                                        <span class="ms-1">Tăng ca</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                        href="#leave-rule" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">event_available</i>
                                        <span class="ms-1">Nghỉ phép</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab"
                                        href="#lock-rule" role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">lock</i>
                                        <span class="ms-1">Khóa công</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3 pt-0">
                    <hr class="horizontal dark mt-0 mb-4">

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="standard-work" role="tabpanel">
                                    <h6 class="mb-1">Cấu hình công chuẩn</h6>
                                    <p class="text-sm text-secondary mb-4">Dùng làm nền để tính đủ công, thiếu công và quy đổi phút làm việc.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Giờ bắt đầu công chuẩn</label>
                                            <input type="time" class="form-control" value="08:00">
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Giờ kết thúc công chuẩn</label>
                                            <input type="time" class="form-control" value="17:30">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Số phút công chuẩn</label>
                                            <input type="number" class="form-control" value="480">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Số công quy đổi</label>
                                            <input type="number" class="form-control" value="1" step="0.1">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Kiểu tính công</label>
                                            <select class="form-select">
                                                <option>Theo phút làm việc thực tế</option>
                                                <option>Theo đủ ca = 1 công</option>
                                                <option>Theo tỷ lệ phút chuẩn</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Khoảng làm tròn</label>
                                            <select class="form-select">
                                                <option>Không làm tròn</option>
                                                <option>5 phút</option>
                                                <option>10 phút</option>
                                                <option>15 phút</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox" id="roundWorkMinutes" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="roundWorkMinutes">
                                                    Tự động làm tròn phút công khi tổng hợp bảng công
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="late-early" role="tabpanel">
                                    <h6 class="mb-1">Đi trễ / Về sớm</h6>
                                    <p class="text-sm text-secondary mb-4">Cấu hình ngưỡng cảnh báo và cách ghi nhận trễ sớm trong bảng công.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Phút đi trễ cho phép</label>
                                            <input type="number" class="form-control" value="5">
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Phút về sớm cho phép</label>
                                            <input type="number" class="form-control" value="5">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Ngưỡng cảnh báo đi trễ</label>
                                            <input type="number" class="form-control" value="15">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Ngưỡng cảnh báo về sớm</label>
                                            <input type="number" class="form-control" value="15">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Cách trừ công</label>
                                            <select class="form-select">
                                                <option>Trừ theo số phút thực tế</option>
                                                <option>Trừ theo mức cố định</option>
                                                <option>Chỉ ghi nhận cảnh báo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Mức trừ cố định</label>
                                            <select class="form-select">
                                                <option>0.25 công</option>
                                                <option>0.5 công</option>
                                                <option>1 công</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="overtime" role="tabpanel">
                                    <h6 class="mb-1">Tăng ca</h6>
                                    <p class="text-sm text-secondary mb-4">Xác định điều kiện tính OT sau ca, cuối tuần và ngày lễ.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">OT tối thiểu sau ca (phút)</label>
                                            <input type="number" class="form-control" value="30">
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Làm tròn OT</label>
                                            <select class="form-select">
                                                <option>15 phút</option>
                                                <option>30 phút</option>
                                                <option>Không làm tròn</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hệ số ngày thường</label>
                                            <input type="number" class="form-control" value="1.5" step="0.1">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hệ số cuối tuần</label>
                                            <input type="number" class="form-control" value="2" step="0.1">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hệ số ngày lễ</label>
                                            <input type="number" class="form-control" value="3" step="0.1">
                                        </div>
                                    </div>
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox" id="requireOtApproval" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="requireOtApproval">
                                                    Chỉ tính OT khi có đăng ký hoặc duyệt tăng ca
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="leave-rule" role="tabpanel">
                                    <h6 class="mb-1">Nghỉ phép</h6>
                                    <p class="text-sm text-secondary mb-4">Quy định cách nghỉ phép được quy đổi vào bảng công.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Nghỉ phép cả ngày quy đổi</label>
                                            <input type="number" class="form-control" value="1" step="0.1">
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Nghỉ phép nửa ngày quy đổi</label>
                                            <input type="number" class="form-control" value="0.5" step="0.1">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Ngưỡng nửa ngày (phút)</label>
                                            <input type="number" class="form-control" value="240">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Loại phép mặc định</label>
                                            <select class="form-select">
                                                <option>Phép năm</option>
                                                <option>Nghỉ không lương</option>
                                                <option>Nghỉ bù</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox" id="approvedLeaveOnly" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="approvedLeaveOnly">
                                                    Chỉ đưa nghỉ phép đã duyệt vào bảng công
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-pane fade" id="lock-rule" role="tabpanel">
                                    <h6 class="mb-1">Khóa công</h6>
                                    <p class="text-sm text-secondary mb-4">Kiểm soát thời điểm chốt công và quyền điều chỉnh sau khi khóa.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Tự động khóa sau (ngày)</label>
                                            <input type="number" class="form-control" value="3">
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Ngày chốt công trong tháng</label>
                                            <input type="number" class="form-control" value="25">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Người được mở khóa</label>
                                            <select class="form-select">
                                                <option>Quản trị hệ thống</option>
                                                <option>Trưởng phòng nhân sự</option>
                                                <option>Quản lý phòng ban</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Thời hạn mở khóa tạm</label>
                                            <select class="form-select">
                                                <option>2 giờ</option>
                                                <option>1 ngày</option>
                                                <option>3 ngày</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="list-group mt-4">
                                        <li class="list-group-item border-0 px-0">
                                            <div class="form-check form-switch ps-0">
                                                <input class="form-check-input ms-auto" type="checkbox" id="notifyBeforeLock" checked>
                                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="notifyBeforeLock">
                                                    Gửi cảnh báo trước khi khóa bảng công
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 rule-summary ps-xl-4">
                            <h6 class="mb-3">Tóm tắt áp dụng</h6>
                            <ul class="list-group">
                                <li class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-dot me-3"><i class="bg-success"></i></span>
                                        <div>
                                            <h6 class="text-sm mb-0">Công chuẩn</h6>
                                            <p class="text-xs text-secondary mb-0">480 phút được quy đổi thành 1 công.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-dot me-3"><i class="bg-warning"></i></span>
                                        <div>
                                            <h6 class="text-sm mb-0">Trễ / sớm</h6>
                                            <p class="text-xs text-secondary mb-0">Có ngưỡng cho phép trước khi ghi nhận vi phạm.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-dot me-3"><i class="bg-info"></i></span>
                                        <div>
                                            <h6 class="text-sm mb-0">Tăng ca</h6>
                                            <p class="text-xs text-secondary mb-0">Tính theo hệ số ngày thường, cuối tuần và ngày lễ.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-dot me-3"><i class="bg-dark"></i></span>
                                        <div>
                                            <h6 class="text-sm mb-0">Khóa công</h6>
                                            <p class="text-xs text-secondary mb-0">Giảm rủi ro chỉnh sửa bảng công sau kỳ chốt.</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
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
