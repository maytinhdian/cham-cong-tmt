<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Báo biểu chấm công</h5>
                            <p class="text-sm mb-0">
                                Tổng hợp các biểu mẫu báo cáo công, đi muộn, về sớm, ca làm và dữ liệu theo phòng ban.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">Cài đặt chấm công</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">Xuất báo biểu</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Tổng ngày công</p>
                                    <h6 class="mb-0">1,248</h6>
                                    <p class="text-sm mb-0">Trong tháng hiện tại</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Đi muộn</p>
                                    <h6 class="mb-0">36 lượt</h6>
                                    <p class="text-sm mb-0">Cần theo dõi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Về sớm</p>
                                    <h6 class="mb-0">12 lượt</h6>
                                    <p class="text-sm mb-0">Phát sinh trong tuần</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Thiếu công</p>
                                    <h6 class="mb-0">08 nhân sự</h6>
                                    <p class="text-sm mb-0">Cần duyệt lại</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Biểu mẫu báo cáo</h6>
                                            <p class="text-sm mb-0">Chọn báo biểu để xem nhanh dữ liệu tổng hợp.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0">Tạo mẫu mới</button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Biểu mẫu</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kỳ báo cáo</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><h6 class="mb-0 text-sm">Bảng công tổng hợp</h6></td>
                                                    <td><p class="text-sm mb-0">Công</p></td>
                                                    <td><p class="text-sm mb-0">Tháng 06/2026</p></td>
                                                    <td><span class="badge bg-gradient-success">Sẵn sàng</span></td>
                                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem</a></td>
                                                </tr>
                                                <tr>
                                                    <td><h6 class="mb-0 text-sm">Báo cáo đi muộn</h6></td>
                                                    <td><p class="text-sm mb-0">Kỷ luật</p></td>
                                                    <td><p class="text-sm mb-0">Tuần này</p></td>
                                                    <td><span class="badge bg-gradient-warning">Cần duyệt</span></td>
                                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem</a></td>
                                                </tr>
                                                <tr>
                                                    <td><h6 class="mb-0 text-sm">Báo cáo phòng ban</h6></td>
                                                    <td><p class="text-sm mb-0">Theo đơn vị</p></td>
                                                    <td><p class="text-sm mb-0">Tháng 06/2026</p></td>
                                                    <td><span class="badge bg-gradient-success">Sẵn sàng</span></td>
                                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Xem</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Bộ lọc báo biểu</h6>
                                    <p class="text-sm mb-0">Lọc nhanh theo nhu cầu kiểm tra.</p>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Phòng ban</label>
                                        <select class="form-control">
                                            <option>Tất cả</option>
                                            <option>Kinh doanh</option>
                                            <option>Kế toán</option>
                                            <option>Công nghệ</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Loại báo cáo</label>
                                        <select class="form-control">
                                            <option>Bảng công</option>
                                            <option>Đi muộn</option>
                                            <option>Về sớm</option>
                                            <option>Thiếu công</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Kỳ báo cáo</label>
                                        <select class="form-control">
                                            <option>Tháng hiện tại</option>
                                            <option>Tháng trước</option>
                                            <option>Theo tuần</option>
                                        </select>
                                    </div>
                                    <div class="d-grid mt-4">
                                        <button class="btn bg-gradient-primary mb-0">Áp dụng</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Xuất dữ liệu</h6>
                                    <p class="text-sm mb-0">Các định dạng phổ biến để chia sẻ.</p>
                                </div>
                                <div class="card-body">
                                    <a href="javascript:;" class="btn btn-outline-success w-100 mb-2">Xuất Excel</a>
                                    <a href="javascript:;" class="btn btn-outline-danger w-100 mb-2">Xuất PDF</a>
                                    <a href="javascript:;" class="btn btn-outline-dark w-100 mb-0">In báo biểu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
