<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Thiết bị chấm công</h5>
            <p class="text-sm mb-0">
                Quản lý máy vân tay, QR, RFID, GPS mobile và nhật ký đồng bộ dữ liệu chấm công.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Đồng bộ realtime</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Quản lý theo chi nhánh</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4" id="overview">
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
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Danh sách thiết bị</h6>
                        <p class="text-sm mb-0">Theo dõi trạng thái và vị trí đặt máy</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Thêm thiết bị</button>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thiết bị</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vị trí</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đồng bộ gần nhất</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $device)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $device['name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $device['code'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-sm">{{ $device['type'] }}</span></td>
                                        <td><span class="text-sm">{{ $device['location'] }}</span></td>
                                        <td><span class="badge bg-{{ $device['color'] }}">{{ $device['status'] }}</span></td>
                                        <td><span class="text-sm text-secondary">{{ $device['last_sync'] }}</span></td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-link text-success px-2 mb-0">
                                                <i class="material-icons text-sm me-1">settings</i>Cấu hình
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thiết lập nhanh</h6>
                    <p class="text-sm mb-0">Các quy định áp dụng cho toàn bộ thiết bị</p>
                </div>
                <div class="card-body">
                    @foreach ($configurations as $config)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ $config }}</label>
                        </div>
                    @endforeach
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu cấu hình</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Khôi phục mặc định</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Phân loại thiết bị</h6>
                    <p class="text-sm mb-0">Nhìn nhanh số lượng theo loại máy</p>
                </div>
                <div class="card-body">
                    @foreach ($deviceTypes as $type)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-{{ $type['color'] }} shadow-{{ $type['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">devices</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $type['label'] }}</h6>
                            </div>
                            <span class="badge bg-light text-dark">{{ $type['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Phân bổ theo phòng ban</h6>
                    <p class="text-sm mb-0">Thiết bị nào phục vụ nhóm nào</p>
                </div>
                <div class="card-body">
                    @foreach ($deployment as $item)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $item['team'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $item['device'] }}</p>
                                </div>
                                <span class="text-xs text-secondary">{{ $item['scope'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7" id="sync">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Nhật ký đồng bộ</h6>
                    <p class="text-sm mb-0">Các hoạt động đẩy dữ liệu từ thiết bị về hệ thống</p>
                </div>
                <div class="card-body">
                    @foreach ($syncLogs as $log)
                        <div class="d-flex {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">sync</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $log['title'] }}</h6>
                                <p class="text-xs text-secondary mb-1">{{ $log['time'] }}</p>
                                <p class="text-sm mb-0">{{ $log['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4" id="maintenance">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Bảo trì & giám sát</h6>
                    <p class="text-sm mb-0">Các việc cần làm định kỳ cho thiết bị</p>
                </div>
                <div class="card-body">
                    @foreach ($maintenance as $item)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $item['title'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $item['hint'] }}</p>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Đồng bộ ngay</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xem cảnh báo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
