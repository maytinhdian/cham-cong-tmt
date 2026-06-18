<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Báo cáo công</h5>
            <p class="text-sm mb-0">
                Menu báo cáo lớn để theo dõi đi muộn, vắng mặt, OT và xuất báo cáo theo nhiều kiểu khác nhau.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Tổng quan theo tháng</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Có thể xuất Excel / PDF</span>
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
        <div class="col-lg-8" id="late">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Xu hướng công theo tháng</h6>
                        <p class="text-sm mb-0">Đi muộn, vắng mặt và OT trên cùng một biểu đồ dữ liệu</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Chọn kỳ báo cáo</button>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tháng</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đi muộn</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vắng mặt</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">OT (giờ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthlyTrend as $item)
                                    <tr>
                                        <td><span class="text-sm font-weight-bold">{{ $item['month'] }}</span></td>
                                        <td><span class="text-sm">{{ $item['late'] }}</span></td>
                                        <td><span class="text-sm">{{ $item['absent'] }}</span></td>
                                        <td><span class="text-sm">{{ $item['ot'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4" id="export">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Xuất báo cáo</h6>
                    <p class="text-sm mb-0">Mẫu file thường dùng trong thực tế</p>
                </div>
                <div class="card-body">
                    @foreach ($exportTemplates as $template)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-0 text-sm">{{ $template }}</h6>
                        </div>
                    @endforeach
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Xuất Excel</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xuất PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4" id="absence">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Đi muộn / về sớm</h6>
                    <p class="text-sm mb-0">Top nhân sự cần theo dõi</p>
                </div>
                <div class="card-body">
                    @foreach ($lateEmployees as $employee)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $employee['name'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $employee['department'] }}</p>
                                </div>
                                <span class="badge bg-warning text-dark">{{ $employee['late'] }}</span>
                            </div>
                            <p class="text-xs text-secondary mb-0 mt-2">Số lần: {{ $employee['count'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4" id="overtime">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Vắng mặt / nghỉ phép</h6>
                    <p class="text-sm mb-0">Thống kê theo loại đơn</p>
                </div>
                <div class="card-body">
                    @foreach ($absenceSummary as $item)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-{{ $item['color'] }} shadow-{{ $item['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">event_busy</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $item['name'] }}</h6>
                            </div>
                            <span class="badge bg-light text-dark">{{ $item['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy tắc báo cáo</h6>
                    <p class="text-sm mb-0">Các tiêu chí sẽ được dùng trong xuất file</p>
                </div>
                <div class="card-body">
                    @foreach ($rules as $rule)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ $rule }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Báo cáo gần đây</h6>
                    <p class="text-sm mb-0">Lịch sử tạo báo cáo và xuất file</p>
                </div>
                <div class="card-body">
                    @foreach ($recentReports as $item)
                        <div class="d-flex {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">history</i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-0 text-sm">{{ $item['title'] }}</h6>
                                <p class="text-xs text-secondary mb-1">{{ $item['time'] }}</p>
                                <p class="text-sm mb-0">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Bộ lọc nhanh</h6>
                    <p class="text-sm mb-0">Dành cho HR và kế toán</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kỳ báo cáo</label>
                        <select class="form-select border border-2 p-2">
                            <option>Tháng này</option>
                            <option>Tháng trước</option>
                            <option>Quý này</option>
                            <option>Năm nay</option>
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
                        <label class="form-label">Kiểu xuất</label>
                        <select class="form-select border border-2 p-2">
                            <option>Excel</option>
                            <option>PDF</option>
                            <option>CSV</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Tạo báo cáo</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xem trước</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
