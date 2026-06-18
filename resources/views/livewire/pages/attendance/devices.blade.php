<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Thiết bị chấm công</h5>
                            <p class="text-sm mb-0">
                                Quản lý máy chấm công, trạng thái kết nối và dữ liệu đồng bộ từ thiết bị.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">Cài đặt chấm công</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">Thêm thiết bị</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Thiết bị đang hoạt động</p>
                                    <h6 class="mb-0">12</h6>
                                    <p class="text-sm mb-0">Kết nối ổn định</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Thiết bị offline</p>
                                    <h6 class="mb-0">02</h6>
                                    <p class="text-sm mb-0">Cần kiểm tra</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Lần đồng bộ gần nhất</p>
                                    <h6 class="mb-0">10 phút trước</h6>
                                    <p class="text-sm mb-0">Từ máy cửa chính</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thiết bị</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vị trí</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đồng bộ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><h6 class="mb-0 text-sm">Máy cửa chính</h6></td>
                                    <td><p class="text-sm mb-0">DEV-001</p></td>
                                    <td><p class="text-sm mb-0">Tầng 1</p></td>
                                    <td><span class="badge bg-gradient-success">Online</span></td>
                                    <td><p class="text-sm mb-0">10 phút trước</p></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Cấu hình</a></td>
                                </tr>
                                <tr>
                                    <td><h6 class="mb-0 text-sm">Máy xưởng sản xuất</h6></td>
                                    <td><p class="text-sm mb-0">DEV-002</p></td>
                                    <td><p class="text-sm mb-0">Khu A</p></td>
                                    <td><span class="badge bg-gradient-warning">Offline</span></td>
                                    <td><p class="text-sm mb-0">2 giờ trước</p></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Cấu hình</a></td>
                                </tr>
                                <tr>
                                    <td><h6 class="mb-0 text-sm">Máy văn phòng</h6></td>
                                    <td><p class="text-sm mb-0">DEV-003</p></td>
                                    <td><p class="text-sm mb-0">Tầng 3</p></td>
                                    <td><span class="badge bg-gradient-success">Online</span></td>
                                    <td><p class="text-sm mb-0">5 phút trước</p></td>
                                    <td><a href="javascript:;" class="text-dark font-weight-bold text-xs">Cấu hình</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
