<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Cài đặt chấm công</h5>
                            <p class="text-sm mb-0">
                                Thiết lập quy tắc tính công, khung giờ làm việc, ca làm và các điều kiện chấm công.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-company-chart') }}" class="btn btn-outline-secondary mb-0">Sơ đồ công ty</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">Lưu cấu hình</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Quy tắc tính công</p>
                                    <h6 class="mb-0">05</h6>
                                    <p class="text-sm mb-0">Đang kích hoạt</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Ca chuẩn</p>
                                    <h6 class="mb-0">03</h6>
                                    <p class="text-sm mb-0">Ca sáng, chiều, đêm</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chính sách phạt</p>
                                    <h6 class="mb-0">02 mức</h6>
                                    <p class="text-sm mb-0">Đi muộn, về sớm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Thiết lập quy tắc tính công</h6>
                                    <p class="text-sm mb-0">Cấu hình theo nhu cầu vận hành của doanh nghiệp.</p>
                                </div>
                                <div class="card-body">
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
                                            <label class="form-label">Phút đi muộn cho phép</label>
                                            <input type="number" class="form-control" value="15">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Phút về sớm cho phép</label>
                                            <input type="number" class="form-control" value="15">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Tự động làm tròn công</label>
                                            <select class="form-control">
                                                <option>Có</option>
                                                <option>Không</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Khoảng làm tròn</label>
                                            <select class="form-control">
                                                <option>5 phút</option>
                                                <option>10 phút</option>
                                                <option>15 phút</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label class="form-label">Ghi chú chính sách</label>
                                            <textarea class="form-control" rows="4" placeholder="Ví dụ: áp dụng riêng cho khối văn phòng"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Quy tắc áp dụng</h6>
                                    <p class="text-sm mb-0">Những thành phần ảnh hưởng trực tiếp tới công lương.</p>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <strong>Ca làm</strong>
                                            <p class="text-sm mb-0">Định nghĩa giờ vào, giờ ra, nghỉ giữa ca.</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Lịch nghỉ</strong>
                                            <p class="text-sm mb-0">Ngày lễ, nghỉ bù và ngày nghỉ theo phòng ban.</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Thiết bị</strong>
                                            <p class="text-sm mb-0">Nguồn dữ liệu chấm công từ máy hoặc app.</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <strong>Phòng ban</strong>
                                            <p class="text-sm mb-0">Có thể áp dụng quy tắc riêng theo nhóm nhân sự.</p>
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
