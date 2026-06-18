<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Khai báo ngày cuối tuần</h6>
                            <p class="text-sm mb-0">
                                Thiết lập các ngày được xem là cuối tuần để phục vụ tính công, tăng ca và báo biểu.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">Quy tắc tính công</a>
                            <a href="{{ route('attendance-shift-definition') }}" class="btn bg-gradient-dark mb-0">Lưu cấu hình</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Ngày cuối tuần đang áp dụng</p>
                                    <h6 class="mb-0">Thứ 7, Chủ nhật</h6>
                                    <p class="text-sm mb-0">Mặc định</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Quy tắc linh hoạt</p>
                                    <h6 class="mb-0">02 nhóm</h6>
                                    <p class="text-sm mb-0">Theo phòng ban / ca làm</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Mẫu mở rộng</p>
                                    <h6 class="mb-0">Sẵn sàng</h6>
                                    <p class="text-sm mb-0">Cho lịch nghỉ bù và lễ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Thiết lập ngày cuối tuần</h6>
                                    <p class="text-sm mb-0">Chọn các ngày được tính là cuối tuần trong hệ thống.</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Ngày cuối tuần thứ nhất</label>
                                            <select class="form-control">
                                                <option selected>Thứ 7</option>
                                                <option>Chủ nhật</option>
                                                <option>Thứ 6</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <label class="form-label">Ngày cuối tuần thứ hai</label>
                                            <select class="form-control">
                                                <option selected>Chủ nhật</option>
                                                <option>Thứ 7</option>
                                                <option>Thứ 6</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label class="form-label">Áp dụng đặc biệt</label>
                                            <textarea class="form-control" rows="4" placeholder="Ví dụ: phòng sản xuất làm việc 6 ngày/tuần, văn phòng nghỉ thứ 7 và Chủ nhật"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Ghi chú</h6>
                                    <p class="text-sm mb-0">Những thành phần ảnh hưởng đến quy tắc cuối tuần.</p>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <strong>Tính công</strong>
                                            <p class="text-sm mb-0">Xác định ngày nào là công thường hay cuối tuần.</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Tăng ca</strong>
                                            <p class="text-sm mb-0">Áp dụng hệ số OT khác nhau vào ngày cuối tuần.</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Báo biểu</strong>
                                            <p class="text-sm mb-0">Lọc dữ liệu theo ngày nghỉ chuẩn trong tháng.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
