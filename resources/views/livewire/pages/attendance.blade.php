<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Chấm công</h5>
            <p class="text-sm mb-0">
                Màn hình tổng quan chấm công nội bộ: xem trạng thái hôm nay, chấm vào / chấm ra, ca làm việc và danh sách log gần nhất.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-success"></i>
                    <span class="text-dark">Hôm nay: 18/06/2026</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Chi nhánh: TMT Office</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($summaryCards as $card)
            <div class="col-xl-3 col-md-6 mt-md-0 mt-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-{{ $card['color'] }} shadow-{{ $card['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">{{ $card['icon'] }}</i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-1 text-capitalize">{{ $card['label'] }}</p>
                                <h4 class="mb-0">{{ $card['value'] }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-3">
                        <p class="mb-0 text-sm">
                            <span class="text-{{ $card['color'] }} text-sm font-weight-bolder">{{ $card['change'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Bảng chấm công nhanh</h6>
                    <p class="text-sm mb-0">Thao tác mẫu cho nhân viên đang đăng nhập</p>
                </div>
                <div class="card-body">
                    <div class="border-radius-xl p-3 bg-gradient-dark position-relative overflow-hidden">
                        <span class="mask bg-gradient-dark opacity-8"></span>
                        <div class="position-relative z-index-2 text-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-white text-sm opacity-8 mb-1">Nhân viên</p>
                                    <h5 class="text-white mb-1">Nguyễn Văn A</h5>
                                    <p class="text-white text-sm opacity-8 mb-0">Phòng Kinh doanh</p>
                                </div>
                                <div class="text-end">
                                    <p class="text-white text-sm opacity-8 mb-1">Trạng thái</p>
                                    <span class="badge bg-success">Đang trong ca</span>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="card bg-white shadow-none mb-0">
                                        <div class="card-body p-3">
                                            <p class="text-xs text-secondary mb-1">Giờ vào</p>
                                            <h5 class="mb-0 text-dark">08:01</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-white shadow-none mb-0">
                                        <div class="card-body p-3">
                                            <p class="text-xs text-secondary mb-1">Giờ ra dự kiến</p>
                                            <h5 class="mb-0 text-dark">17:30</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button class="btn bg-gradient-success mb-0" type="button">
                                    <i class="material-icons text-sm me-2">login</i>Chấm vào
                                </button>
                                <button class="btn bg-gradient-primary mb-0" type="button">
                                    <i class="material-icons text-sm me-2">logout</i>Chấm ra
                                </button>
                            </div>

                            <div class="mt-4 d-flex justify-content-between text-sm opacity-8">
                                <span>Ca hiện tại: 08:00 - 17:00</span>
                                <span>Hệ số: 1.0x</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light text-dark mt-4 mb-0 border">
                        <strong>Gợi ý:</strong> Có thể thay 2 nút này bằng chấm công QR, GPS hoặc máy chấm công sau.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Log chấm công hôm nay</h6>
                        <p class="text-sm mb-0">Danh sách lượt vào ra gần nhất trong ngày</p>
                    </div>
                    <button class="btn btn-outline-primary btn-sm mb-0" type="button">Xuất Excel</button>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ vào</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ ra</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentLogs as $log)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $log['name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $log['dept'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $log['in'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $log['out'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ str_contains($log['status'], 'Đi muộn') ? 'bg-warning' : 'bg-success' }}">
                                                {{ $log['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ca làm việc</h6>
                    <p class="text-sm mb-0">Phân bổ nhân sự theo ca</p>
                </div>
                <div class="card-body">
                    @foreach ($shiftCards as $shift)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-{{ $shift['color'] }} shadow-{{ $shift['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">schedule</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $shift['title'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $shift['time'] }}</p>
                            </div>
                            <span class="badge badge-sm bg-light text-dark">{{ $shift['members'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Đơn chờ duyệt</h6>
                    <p class="text-sm mb-0">Nghỉ phép, công tác, làm bù</p>
                </div>
                <div class="card-body">
                    @foreach ($requests as $request)
                        <div class="d-flex align-items-center border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">assignment</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $request['name'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $request['person'] }} - {{ $request['time'] }}</p>
                            </div>
                            <span class="badge {{ $request['status'] === 'Đã duyệt' ? 'bg-success' : 'bg-warning' }}">
                                {{ $request['status'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Tóm tắt hôm nay</h6>
                    <p class="text-sm mb-0">Bức tranh nhanh của bộ phận</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="card bg-gradient-success shadow-success mb-0">
                                <div class="card-body p-3">
                                    <p class="text-white text-xs opacity-8 mb-1">Đúng giờ</p>
                                    <h4 class="text-white mb-0">82%</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-gradient-warning shadow-warning mb-0">
                                <div class="card-body p-3">
                                    <p class="text-white text-xs opacity-8 mb-1">Đi muộn</p>
                                    <h4 class="text-white mb-0">12%</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-gradient-primary shadow-primary mb-0">
                                <div class="card-body p-3">
                                    <p class="text-white text-xs opacity-8 mb-1">Tăng ca</p>
                                    <h4 class="text-white mb-0">19 người</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-gradient-dark shadow-dark mb-0">
                                <div class="card-body p-3">
                                    <p class="text-white text-xs opacity-8 mb-1">Vắng mặt</p>
                                    <h4 class="text-white mb-0">7 người</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Giao diện này là nền ban đầu để sau đó gắn dữ liệu thật, ca làm, máy chấm công, và quy trình duyệt.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
