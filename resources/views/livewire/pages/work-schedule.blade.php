<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Lịch làm việc & nghỉ lễ</h5>
            <p class="text-sm mb-0">
                Quản lý lịch làm việc theo tuần/tháng, ngày nghỉ lễ, ngày làm bù và phân công theo phòng ban.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Chốt theo tháng</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Đồng bộ chấm công</span>
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
                        <h6 class="mb-0">Lịch làm việc tuần hiện tại</h6>
                        <p class="text-sm mb-0">Thiết lập lịch mặc định cho cả tuần</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Chọn tuần</button>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Khung giờ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhóm áp dụng</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($weeklyRoster as $row)
                                    <tr>
                                        <td><span class="text-sm font-weight-bold">{{ $row['day'] }}</span></td>
                                        <td><span class="text-sm">{{ $row['shift'] }}</span></td>
                                        <td><span class="text-sm">{{ $row['time'] }}</span></td>
                                        <td><span class="text-sm text-secondary">{{ $row['team'] }}</span></td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-link text-success px-2 mb-0">
                                                <i class="material-icons text-sm me-1">edit</i>Sửa
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
                    <p class="text-sm mb-0">Tác vụ thường dùng khi chỉnh lịch</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Chu kỳ lịch</label>
                        <select class="form-select border border-2 p-2">
                            <option>Theo tuần</option>
                            <option>Theo tháng</option>
                            <option>Theo quý</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phòng ban</label>
                        <select class="form-select border border-2 p-2">
                            <option>Tất cả</option>
                            <option>Kinh doanh</option>
                            <option>Kế toán</option>
                            <option>CSKH</option>
                            <option>IT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kiểu lịch</label>
                        <select class="form-select border border-2 p-2">
                            <option>Ca sáng</option>
                            <option>Ca chiều</option>
                            <option>Ca đêm</option>
                            <option>Linh hoạt</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu lịch</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Khôi phục</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ngày nghỉ lễ & ngày làm bù</h6>
                    <p class="text-sm mb-0">Danh sách ngày đặc biệt trong năm</p>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên ngày</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Áp dụng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($holidays as $holiday)
                                    <tr>
                                        <td><span class="text-sm font-weight-bold">{{ $holiday['date'] }}</span></td>
                                        <td><span class="text-sm">{{ $holiday['name'] }}</span></td>
                                        <td><span class="badge bg-{{ $holiday['color'] }}">{{ $holiday['type'] }}</span></td>
                                        <td><span class="text-sm text-secondary">{{ $holiday['applies'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ngày đặc biệt / sự kiện nội bộ</h6>
                    <p class="text-sm mb-0">Các ngày có quy tắc riêng</p>
                </div>
                <div class="card-body">
                    @foreach ($specialDays as $day)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $day['date'] }} - {{ $day['name'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $day['rule'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Gán lịch theo phòng ban</h6>
                    <p class="text-sm mb-0">Mỗi bộ phận có thể có lịch riêng</p>
                </div>
                <div class="card-body">
                    @foreach ($departmentAssignments as $assignment)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">apartment</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $assignment['name'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $assignment['schedule'] }}</p>
                            </div>
                            <span class="badge bg-light text-dark">{{ $assignment['holiday'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy định lịch</h6>
                    <p class="text-sm mb-0">Điều kiện áp dụng lịch làm việc và nghỉ lễ</p>
                </div>
                <div class="card-body">
                    @foreach ($rules as $rule)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ $rule }}</label>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <h6 class="mb-2 text-sm">Lịch sử thay đổi</h6>
                        @foreach ($recentChanges as $item)
                            <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="me-3">
                                        <h6 class="mb-1 text-sm">{{ $item['title'] }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $item['detail'] }}</p>
                                    </div>
                                    <span class="text-xs text-secondary">{{ $item['time'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu & chốt lịch</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xuất lịch năm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
