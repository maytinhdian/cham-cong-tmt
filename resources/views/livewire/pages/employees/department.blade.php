<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Quản lý phòng ban</h5>
                            <p class="text-sm mb-0">
                                Tạo phòng ban, gán nhân viên vào phòng ban và xem ngay danh sách nhân sự theo từng nhóm.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">Thêm phòng ban</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card card-background card-background-mask-primary h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved14.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">08</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Phòng ban đang hoạt động</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Phòng ban lớn nhất</p>
                                    <h6 class="mb-0">Kinh doanh</h6>
                                    <p class="text-sm mb-0">24 nhân sự</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Cần rà soát</p>
                                    <h6 class="mb-0">02 phòng ban</h6>
                                    <p class="text-sm mb-0">Thiếu quản lý phụ trách</p>
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
                                            <h6 class="mb-1">Danh sách phòng ban</h6>
                                            <p class="text-sm mb-0">Chọn một phòng ban để xem và gán nhân viên.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0">Tạo phòng ban</button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quản lý</th>
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
                                                                <div class="avatar avatar-sm bg-gradient-primary">
                                                                    <i class="ni ni-building text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Kinh doanh</h6>
                                                                <p class="text-xs text-secondary mb-0">Đang được chọn</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">PB-001</p></td>
                                                    <td><p class="text-sm mb-0">Nguyễn Văn A</p></td>
                                                    <td><p class="text-sm mb-0">24</p></td>
                                                    <td><span class="badge bg-gradient-success">Đang hoạt động</span></td>
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
                                                                    <i class="ni ni-single-copy-04 text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Kế toán</h6>
                                                                <p class="text-xs text-secondary mb-0">2 nhân viên chưa phân nhóm</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">PB-002</p></td>
                                                    <td><p class="text-sm mb-0">Trần Thị B</p></td>
                                                    <td><p class="text-sm mb-0">10</p></td>
                                                    <td><span class="badge bg-gradient-success">Đang hoạt động</span></td>
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
                                                                    <i class="ni ni-app text-white text-xs opacity-10"></i>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">Công nghệ</h6>
                                                                <p class="text-xs text-secondary mb-0">Đang mở rộng</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="text-sm mb-0">PB-003</p></td>
                                                    <td><p class="text-sm mb-0">Lê Văn C</p></td>
                                                    <td><p class="text-sm mb-0">18</p></td>
                                                    <td><span class="badge bg-gradient-warning">Cần cập nhật</span></td>
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
                                    <h6 class="mb-1">Gán nhân viên vào phòng ban</h6>
                                    <p class="text-sm mb-0">Chọn phòng ban và gán nhanh nhân viên từ danh sách có sẵn.</p>
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
                                        <textarea class="form-control" rows="3" placeholder="Ví dụ: gán theo đợt onboarding"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-outline-secondary mb-0">Xóa chọn</button>
                                        <button class="btn bg-gradient-primary mb-0">Gán nhân viên</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Nhân viên thuộc phòng ban</h6>
                                            <p class="text-sm mb-0">Danh sách của phòng ban đang chọn: Kinh doanh.</p>
                                        </div>
                                        <span class="badge bg-gradient-success">24 nhân sự</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 bg-gray-100">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-1.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Nguyễn Minh Quân</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-001 - Trưởng nhóm</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-success">Đang làm việc</span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-2.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Phạm Đức Huy</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-014 - Chuyên viên</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-info">Ca chiều</span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets') }}/img/team-3.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            <div>
                                                <h6 class="mb-0 text-sm">Lê Thu Trang</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-020 - Nhân viên mới</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-gradient-warning">Đang thử việc</span>
                                    </div>

                                    <a href="javascript:;" class="btn btn-outline-primary w-100 mb-0">
                                        Xem đầy đủ danh sách nhân viên của phòng ban này
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
