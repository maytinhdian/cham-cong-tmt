<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Quản lý chức vụ</h5>
                            <p class="text-sm mb-0">
                                Tạo chức vụ, gán chức vụ cho nhân viên theo từng phòng ban và theo dõi người đang giữ chức vụ đó.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">Thêm chức vụ</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ cấp quản lý</p>
                                    <h6 class="mb-0">04</h6>
                                    <p class="text-sm mb-0">Có quyền phê duyệt</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ phổ biến</p>
                                    <h6 class="mb-0">Nhân viên</h6>
                                    <p class="text-sm mb-0">Được gán nhiều nhất</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Cần duyệt lại</p>
                                    <h6 class="mb-0">03 chức vụ</h6>
                                    <p class="text-sm mb-0">Chưa có mô tả đầy đủ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-7">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Danh sách chức vụ</h6>
                                            <p class="text-sm mb-0">Chọn một chức vụ để gán cho nhân viên theo phòng ban.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0">Tạo chức vụ</button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Chức vụ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cấp độ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân sự</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-gray-100">
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="me-3">
                                                                <div class="avatar avatar-sm bg-gradient-dark">
                                                                    <i class="ni ni-badge text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Giám đốc</h6>
                                                                <p class="text-xs text-secondary mb-0">Đang được chọn</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">CV-001</p></td>
                                                    <td><p class="text-sm mb-0">Cấp 1</p></td>
                                                    <td><p class="text-sm mb-0">2</p></td>
                                                    <td><span class="badge bg-gradient-success">Đang dùng</span></td>
                                                    <td>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs me-3">Gán nhân viên</a>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem nhân viên</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="me-3">
                                                                <div class="avatar avatar-sm bg-gradient-info">
                                                                    <i class="ni ni-satisfied text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Trưởng phòng</h6>
                                                                <p class="text-xs text-secondary mb-0">Theo phòng ban</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">CV-002</p></td>
                                                    <td><p class="text-sm mb-0">Cấp 2</p></td>
                                                    <td><p class="text-sm mb-0">8</p></td>
                                                    <td><span class="badge bg-gradient-success">Đang dùng</span></td>
                                                    <td>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs me-3">Gán nhân viên</a>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem nhân viên</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="me-3">
                                                                <div class="avatar avatar-sm bg-gradient-warning">
                                                                    <i class="ni ni-single-02 text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Nhân viên</h6>
                                                                <p class="text-xs text-secondary mb-0">Phổ biến nhất</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">CV-003</p></td>
                                                    <td><p class="text-sm mb-0">Cấp 3</p></td>
                                                    <td><p class="text-sm mb-0">54</p></td>
                                                    <td><span class="badge bg-gradient-success">Đang dùng</span></td>
                                                    <td>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs me-3">Gán nhân viên</a>
                                                        <a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem nhân viên</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-5 mt-4 mt-xl-0">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Gán chức vụ cho nhân viên</h6>
                                    <p class="text-sm mb-0">Chọn phòng ban trước, sau đó gán chức vụ tương ứng cho nhân viên.</p>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Phòng ban</label>
                                        <select class="form-control">
                                            <option>Kinh doanh</option>
                                            <option>Kế toán</option>
                                            <option>Công nghệ</option>
                                            <option>Hành chính</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Chức vụ</label>
                                        <select class="form-control">
                                            <option>Giám đốc</option>
                                            <option>Trưởng phòng</option>
                                            <option>Nhân viên</option>
                                            <option>Thực tập sinh</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Chọn nhân viên</label>
                                        <select class="form-control" multiple>
                                            <option>Nguyễn Minh Quân</option>
                                            <option>Trần Thu Hằng</option>
                                            <option>Lê Quốc Bảo</option>
                                            <option>Phạm Thị Mai</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Ghi chú</label>
                                        <textarea class="form-control" rows="3" placeholder="Ví dụ: gán chức vụ theo đợt điều chuyển"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-outline-secondary mb-0">Xóa chọn</button>
                                        <button class="btn bg-gradient-primary mb-0">Gán chức vụ</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Nhân viên đang giữ chức vụ</h6>
                                            <p class="text-sm mb-0">Danh sách của chức vụ đang chọn: Giám đốc.</p>
                                        </div>
                                        <span class="badge bg-gradient-success">2 nhân sự</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 bg-gray-100">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-1.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Nguyễn Minh Quân</h6>
                                                <p class="text-xs text-secondary mb-0">Kinh doanh - EMP-001</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-success">Quản lý chính</span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-2.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Trần Quốc Hưng</h6>
                                                <p class="text-xs text-secondary mb-0">Công nghệ - EMP-014</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-info">Phụ trách</span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-3.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Lê Thu Trang</h6>
                                                <p class="text-xs text-secondary mb-0">Kế toán - EMP-020</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-warning">Thay thế</span>
                                    </div>

                                    <a href="javascript:;" class="btn btn-outline-primary w-100 mb-0">
                                        Xem đầy đủ danh sách nhân viên theo chức vụ này
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
