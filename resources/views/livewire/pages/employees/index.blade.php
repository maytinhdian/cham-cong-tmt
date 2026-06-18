<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Danh sách nhân viên</h6>
                            <p class="text-sm mb-0 text-muted">Quan ly danh sach nhan vien, trang thai, phong ban va ca lam</p>
                        </div>
                        <div class="d-flex gap-2 mt-3 mt-md-0">
                            <a href="{{ route('employee-dashboard') }}" class="btn btn-outline-secondary mb-0">Dashboard</a>
                            <a href="{{ route('new-user') }}" class="btn bg-gradient-dark mb-0">Thêm nhân viên</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca làm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="{{ asset('assets') }}/img/team-1.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Nguyen Minh Quan</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-001</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><p class="text-sm mb-0">Kinh doanh</p></td>
                                    <td><p class="text-sm mb-0">Hành chính</p></td>
                                    <td><span class="badge bg-gradient-success">Đang làm việc</span></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Sửa</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="{{ asset('assets') }}/img/team-2.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Tran Thu Hang</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-002</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><p class="text-sm mb-0">Kế toán</p></td>
                                    <td><p class="text-sm mb-0">Ca sáng</p></td>
                                    <td><span class="badge bg-gradient-warning">Chờ cấp tài khoản</span></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Sửa</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="{{ asset('assets') }}/img/team-3.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Le Quoc Bao</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-003</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><p class="text-sm mb-0">Công nghệ</p></td>
                                    <td><p class="text-sm mb-0">Ca chiều</p></td>
                                    <td><span class="badge bg-gradient-info">Đang onboarding</span></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Sửa</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="{{ asset('assets') }}/img/team-4.jpg" class="avatar avatar-sm me-3" alt="employee">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Pham Ngoc Anh</h6>
                                                <p class="text-xs text-secondary mb-0">EMP-004</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><p class="text-sm mb-0">Hành chính</p></td>
                                    <td><p class="text-sm mb-0">Ca đêm</p></td>
                                    <td><span class="badge bg-gradient-success">Đã gán ca</span></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Sửa</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Bộ lọc nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Kinh doanh</option>
                            <option>Kế toán</option>
                            <option>Công nghệ</option>
                            <option>Hành chính</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-control">
                            <option>Tất cả</option>
                            <option>Đang làm việc</option>
                            <option>Chờ cấp tài khoản</option>
                            <option>Đang onboarding</option>
                        </select>
                    </div>
                    <div class="form-group mt-3 mb-0">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" placeholder="Tên, mã nhân viên">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Thao tác nhanh</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="d-grid gap-2">
                        <a href="{{ route('new-user') }}" class="btn bg-gradient-dark mb-0">Thêm nhân viên</a>
                        <a href="{{ route('employee-dashboard') }}" class="btn btn-outline-secondary mb-0">Về dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
