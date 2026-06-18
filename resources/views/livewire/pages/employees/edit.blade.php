<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Chi tiết / sửa nhân viên</h5>
            <p class="text-sm mb-0">
                Quản lý toàn bộ hồ sơ, phòng ban, ca làm, quyền truy cập và lịch sử hoạt động của nhân viên.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-{{ $employee['color'] }}"></i>
                    <span class="text-dark">{{ $employee['code'] }}</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">{{ $employee['status'] }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xxl position-relative mx-auto">
                        <img src="{{ asset('assets') }}/img/default-avatar.png" alt="avatar" class="w-100 rounded-circle shadow-sm">
                        <label for="edit-photo"
                            class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen" aria-hidden="true"></i>
                        </label>
                        <input id="edit-photo" type="file" class="d-none">
                    </div>
                    <h5 class="mt-3 mb-1">{{ $employee['name'] }}</h5>
                    <p class="text-sm mb-1">{{ $employee['title'] }}</p>
                    <span class="badge bg-{{ $employee['color'] }}">{{ $employee['department'] }}</span>

                    <div class="row mt-4">
                        @foreach ($activitySummary as $summary)
                            <div class="col-6 mb-3">
                                <div class="card bg-gray-100 shadow-none mb-0">
                                    <div class="card-body p-3">
                                        <p class="text-xs text-secondary mb-1">{{ $summary['label'] }}</p>
                                        <h6 class="mb-0">{{ $summary['value'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu thay đổi</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Khôi phục</button>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Các tab hồ sơ</h6>
                </div>
                <div class="card-body">
                    @foreach ($tabs as $tab)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-0 text-sm">{{ $tab }}</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thông tin hồ sơ</h6>
                    <p class="text-sm mb-0">Chỉnh sửa dữ liệu cá nhân và công việc</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Mã nhân viên</label>
                            <input type="text" class="form-control border border-2 p-2" value="{{ $employee['code'] }}">
                        </div>
                        <div class="col-md-6 mt-md-0 mt-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control border border-2 p-2" value="{{ $employee['name'] }}">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control border border-2 p-2" value="{{ $employee['email'] }}">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control border border-2 p-2" value="{{ $employee['phone'] }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control border border-2 p-2" value="{{ $employee['birthday'] }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Giới tính</label>
                            <select class="form-select border border-2 p-2">
                                <option {{ $employee['gender'] === 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option {{ $employee['gender'] === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option {{ $employee['gender'] === 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Ngày vào làm</label>
                            <input type="date" class="form-control border border-2 p-2" value="{{ $employee['join_date'] }}">
                        </div>
                    </div>

                    <hr class="horizontal dark my-4">

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Phòng ban</label>
                            <select class="form-select border border-2 p-2">
                                <option selected>{{ $employee['department'] }}</option>
                                <option>Nhân sự</option>
                                <option>Kinh doanh</option>
                                <option>Kế toán</option>
                                <option>CSKH</option>
                                <option>Kho vận</option>
                                <option>IT</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-md-0 mt-3">
                            <label class="form-label">Chức danh</label>
                            <input type="text" class="form-control border border-2 p-2" value="{{ $employee['title'] }}">
                        </div>
                        <div class="col-md-4 mt-md-0 mt-3">
                            <label class="form-label">Quản lý trực tiếp</label>
                            <input type="text" class="form-control border border-2 p-2" value="{{ $employee['manager'] }}">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Ca làm</label>
                            <select class="form-select border border-2 p-2">
                                <option selected>{{ $employee['shift'] }}</option>
                                <option>Ca chiều 13:00 - 22:00</option>
                                <option>Ca đêm 22:00 - 06:00</option>
                                <option>Ca linh hoạt</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Địa điểm làm việc</label>
                            <select class="form-select border border-2 p-2">
                                <option selected>{{ $employee['workplace'] }}</option>
                                <option>TP. Hồ Chí Minh</option>
                                <option>Đà Nẵng</option>
                                <option>Hybrid / Remote</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Thiết bị chấm công</label>
                            <select class="form-select border border-2 p-2">
                                <option selected>{{ $employee['device'] }}</option>
                                <option>Máy vân tay</option>
                                <option>Thẻ RFID</option>
                                <option>GPS / Mobile</option>
                            </select>
                        </div>
                    </div>

                    <hr class="horizontal dark my-4">

                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-1">Thiết lập chấm công cá nhân</h6>
                            <p class="text-sm mb-3">Ghi đè cho trường hợp đặc biệt của nhân viên này.</p>
                        </div>
                        <div class="col-md-6">
                            @foreach ($attendanceConfig as $config)
                                <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-sm">{{ $config['label'] }}</h6>
                                        <span class="badge bg-light text-dark">{{ $config['value'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="gps-check" checked>
                                <label class="form-check-label" for="gps-check">Bắt buộc GPS khi chấm công</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allow-manual" checked>
                                <label class="form-check-label" for="allow-manual">Cho phép chỉnh công thủ công</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allow-ot" checked>
                                <label class="form-check-label" for="allow-ot">Cho phép đăng ký OT</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allow-leave" checked>
                                <label class="form-check-label" for="allow-leave">Cho phép gửi đơn nghỉ phép</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="lock-record">
                                <label class="form-check-label" for="lock-record">Khóa dữ liệu công theo tháng</label>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark my-4">

                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-2">Quyền truy cập</h6>
                        </div>
                        @foreach ($permissionConfig as $permission)
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">{{ $permission }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Lịch sử hoạt động</h6>
                        <p class="text-sm mb-0">Các cập nhật gần nhất trên hồ sơ nhân viên</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem log đầy đủ</button>
                </div>
                <div class="card-body">
                    @foreach ($timeline as $item)
                        <div class="d-flex {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">history</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1 text-sm">{{ $item['title'] }}</h6>
                                <p class="text-xs text-secondary mb-1">{{ $item['time'] }}</p>
                                <p class="text-sm mb-0">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
