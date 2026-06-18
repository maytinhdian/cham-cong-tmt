<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Kí hiệu thống kê</h6>
                            <p class="text-sm mb-0">
                                Bảng giải thích các ký hiệu dùng chung trong chấm công, báo cáo và tổng hợp dữ liệu.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('attendance-reports') }}" class="btn btn-outline-secondary mb-0">Báo biểu</a>
                            <a href="{{ route('attendance-settings') }}" class="btn bg-gradient-dark mb-0">Quy tắc tính công</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-success mt-1">HC</span>
                                    <div>
                                        <h6 class="mb-1">Có mặt</h6>
                                        <p class="text-sm mb-0">Nhân viên đủ log vào và ra theo ca.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-warning mt-1">TR</span>
                                    <div>
                                        <h6 class="mb-1">Đi trễ</h6>
                                        <p class="text-sm mb-0">Log vào sau giờ cho phép của ca làm việc.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-info mt-1">VS</span>
                                    <div>
                                        <h6 class="mb-1">Về sớm</h6>
                                        <p class="text-sm mb-0">Log ra trước thời điểm kết thúc ca.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-dark mt-1">OT</span>
                                    <div>
                                        <h6 class="mb-1">Tăng ca</h6>
                                        <p class="text-sm mb-0">Thời gian làm thêm ngoài khung giờ chuẩn.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-secondary mt-1">NP</span>
                                    <div>
                                        <h6 class="mb-1">Nghỉ phép</h6>
                                        <p class="text-sm mb-0">Ngày nghỉ đã được duyệt trong kỳ công.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-danger mt-1">LG</span>
                                    <div>
                                        <h6 class="mb-1">Thiếu log</h6>
                                        <p class="text-sm mb-0">Thiếu một hoặc nhiều lần chấm vào/ra.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-6 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-primary mt-1">KC</span>
                                    <div>
                                        <h6 class="mb-1">Khóa công</h6>
                                        <p class="text-sm mb-0">Kỳ công đã chốt, không cho phép chỉnh sửa tự do.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3 d-flex align-items-start gap-3">
                                    <span class="badge bg-gradient-success mt-1">CN</span>
                                    <div>
                                        <h6 class="mb-1">Cuối tuần</h6>
                                        <p class="text-sm mb-0">Ngày được cấu hình là cuối tuần để tính hệ số riêng.</p>
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
