<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Thêm nhân viên mới</h5>
            <p class="text-sm mb-0">
                Nhập hồ sơ nhân sự và các thiết lập liên quan đến chấm công, ca làm, quyền truy cập, onboarding.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Mã tạm: EMP-2026-018</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Trạng thái: Nháp</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Hồ sơ nhân viên</h6>
                            <p class="text-sm mb-0">Thông tin cơ bản để tạo hồ sơ làm việc</p>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0">Lưu nháp</button>
                    </div>
                </div>

                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-5">
                                <div class="card bg-gray-100 shadow-none">
                                    <div class="card-body text-center p-3">
                                        <div class="avatar avatar-xxl position-relative mx-auto">
                                            <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar"
                                                class="w-100 rounded-circle shadow-sm">
                                            <label for="employee-photo"
                                                class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                                <i class="fa fa-pen" aria-hidden="true"></i>
                                            </label>
                                            <input id="employee-photo" type="file" class="d-none">
                                        </div>
                                        <h6 class="mt-3 mb-0">Ảnh đại diện</h6>
                                        <p class="text-xs text-secondary mb-0">Chọn ảnh rõ mặt, nền sáng</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-9 col-lg-8 col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Mã nhân viên</label>
                                        <input type="text" class="form-control border border-2 p-2" placeholder="VD: NV-0001">
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-3">
                                        <label class="form-label">Họ và tên</label>
                                        <input type="text" class="form-control border border-2 p-2" placeholder="Nhập họ tên">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Email công ty</label>
                                        <input type="email" class="form-control border border-2 p-2" placeholder="name@company.com">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control border border-2 p-2" placeholder="SĐT liên hệ">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Ngày sinh</label>
                                        <input type="date" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Giới tính</label>
                                        <select class="form-select border border-2 p-2">
                                            <option>Nam</option>
                                            <option>Nữ</option>
                                            <option>Khác</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Phòng ban</label>
                                <select class="form-select border border-2 p-2">
                                    @foreach ($departments as $department)
                                        <option>{{ $department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-md-0 mt-3">
                                <label class="form-label">Chức danh</label>
                                <select class="form-select border border-2 p-2">
                                    @foreach ($positions as $position)
                                        <option>{{ $position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-md-0 mt-3">
                                <label class="form-label">Ngày vào làm</label>
                                <input type="date" class="form-control border border-2 p-2">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-label">Quản lý trực tiếp</label>
                                <input type="text" class="form-control border border-2 p-2" placeholder="Tên quản lý">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-label">Loại hợp đồng</label>
                                <select class="form-select border border-2 p-2">
                                    <option>Chính thức</option>
                                    <option>Thử việc</option>
                                    <option>Cộng tác viên</option>
                                    <option>Thời vụ</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label class="form-label">Địa điểm làm việc</label>
                                <select class="form-select border border-2 p-2">
                                    <option>Hà Nội</option>
                                    <option>TP. Hồ Chí Minh</option>
                                    <option>Đà Nẵng</option>
                                    <option>Hybrid / Remote</option>
                                </select>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">Thiết lập chấm công</h6>
                                <p class="text-sm mb-3">Các cấu hình sẽ ảnh hưởng đến bảng công và cách ghi nhận hoạt động.</p>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <label class="form-label">Ca mặc định</label>
                                        <select class="form-select border border-2 p-2">
                                            <option>Ca sáng 08:00 - 17:00</option>
                                            <option>Ca chiều 13:00 - 22:00</option>
                                            <option>Ca linh hoạt</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <label class="form-label">Thiết bị chấm công</label>
                                        <select class="form-select border border-2 p-2">
                                            <option>QR / Mobile</option>
                                            <option>Máy vân tay</option>
                                            <option>Thẻ từ RFID</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border shadow-none mb-3">
                                    <div class="card-body p-3">
                                        <label class="form-label">Dung sai đi muộn</label>
                                        <input type="text" class="form-control border border-2 p-2" value="15 phút">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="allow-ot" checked>
                                    <label class="form-check-label" for="allow-ot">Cho phép đăng ký tăng ca</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto-attendance" checked>
                                    <label class="form-check-label" for="auto-attendance">Tự động gắn vào bảng công</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="require-approval">
                                    <label class="form-check-label" for="require-approval">Bắt buộc duyệt đơn nghỉ phép</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enable-holiday">
                                    <label class="form-check-label" for="enable-holiday">Áp dụng lịch nghỉ lễ công ty</label>
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-1">Thông tin bổ sung</h6>
                                <p class="text-sm mb-3">Dùng cho hành chính - nhân sự khi hoàn thiện hồ sơ.</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa chỉ thường trú</label>
                                <input type="text" class="form-control border border-2 p-2" placeholder="Số nhà, đường, phường...">
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3">
                                <label class="form-label">Người liên hệ khẩn cấp</label>
                                <input type="text" class="form-control border border-2 p-2" placeholder="Tên + quan hệ + SĐT">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">Ghi chú nội bộ</label>
                                <textarea class="form-control border border-2 p-2" rows="4"
                                    placeholder="Ghi các yêu cầu đặc biệt, thời gian làm việc, thiết bị cần cấp..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Các hoạt động liên quan sau khi tạo</h6>
                    <p class="text-sm mb-0">Checklist cho onboarding nhân viên mới</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($onboardingTasks as $task)
                            <div class="col-md-6 col-lg-4 mt-3">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body p-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" checked>
                                            <label class="form-check-label font-weight-bold text-dark">
                                                {{ $task }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Xem trước hồ sơ</h6>
                    <p class="text-sm mb-0">Cách thẻ nhân viên sẽ hiển thị</p>
                </div>
                <div class="card-body">
                    <div class="bg-gradient-dark border-radius-xl p-3 position-relative overflow-hidden">
                        <span class="mask bg-gradient-dark opacity-8"></span>
                        <div class="position-relative z-index-2 text-white">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets') }}/img/default-avatar.png" class="avatar avatar-xl me-3"
                                    alt="avatar">
                                <div>
                                    <p class="text-white text-sm opacity-8 mb-1">EMP-2026-018</p>
                                    <h5 class="text-white mb-0">Nguyễn Văn A</h5>
                                    <p class="text-white text-sm opacity-8 mb-0">Phòng Kinh doanh</p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-6">
                                    <p class="text-white text-xs opacity-8 mb-1">Ca làm</p>
                                    <h6 class="text-white mb-0">08:00 - 17:00</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-white text-xs opacity-8 mb-1">Thiết bị</p>
                                    <h6 class="text-white mb-0">QR / Mobile</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @foreach ($recentActivities as $activity)
                            <div class="d-flex {{ !$loop->last ? 'mb-3' : '' }}">
                                <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                    <i class="material-icons opacity-10">history</i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h6 class="mb-0 text-sm">{{ $activity['label'] }}</h6>
                                    <p class="text-xs text-secondary mb-1">{{ $activity['time'] }}</p>
                                    <p class="text-sm mb-0">{{ $activity['detail'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thao tác nhanh</h6>
                    <p class="text-sm mb-0">Những việc thường làm sau khi nhập nhân sự</p>
                </div>
                <div class="card-body">
                    @foreach ($quickActions as $action)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $action['title'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $action['text'] }}</p>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Tạo nhân viên</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Gửi email mời vào hệ thống</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
