<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Danh sách chấm công</h5>
            <p class="text-sm mb-0">
                Bảng tra cứu chi tiết log vào ra, lọc theo ngày, phòng ban, trạng thái và nguồn chấm công.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-success"></i>
                    <span class="text-dark">Ngày: {{ now()->format('d/m/Y') }}</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Tổng log: 248</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($summaryCards as $card)
            <div class="col-xl-2 col-md-4 col-sm-6 mt-md-0 mt-4">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="icon icon-lg icon-shape bg-gradient-{{ $card['color'] }} shadow-{{ $card['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">{{ $card['icon'] }}</i>
                            </div>
                            <span class="badge badge-sm bg-light text-dark">Live</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm mb-1 text-capitalize">{{ $card['label'] }}</p>
                            <h4 class="mb-1">{{ $card['value'] }}</h4>
                            <p class="mb-0 text-sm text-secondary">{{ $card['change'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">Bộ lọc nhanh</h6>
                        <p class="text-sm mb-0">Chọn ngày, phòng ban, trạng thái hoặc nguồn dữ liệu</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-dark btn-sm mb-0" type="button">Xuất Excel</button>
                        <button class="btn btn-outline-primary btn-sm mb-0" type="button">In bảng công</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($filters as $filter)
                            <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                <label class="form-label text-xs text-secondary mb-1">{{ $filter['label'] }}</label>
                                <div class="form-control bg-white">{{ $filter['value'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Log chấm công theo danh sách</h6>
                        <p class="text-sm mb-0">Gần như bảng dữ liệu vận hành hằng ngày cho HR và quản lý</p>
                    </div>
                    <span class="badge bg-light text-dark">8 bản ghi</span>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ca</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ vào</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ ra</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">OT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nguồn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendanceRecords as $record)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $record['name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $record['dept'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $record['shift'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $record['in'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $record['out'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $record['ot'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ str_contains($record['status'], 'muộn') ? 'bg-warning' : (str_contains($record['status'], 'Vắng') ? 'bg-danger' : (str_contains($record['status'], 'Chưa') ? 'bg-secondary' : 'bg-success')) }}">
                                                {{ $record['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $record['source'] }}</span>
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
                    <h6 class="mb-0">Cơ cấu trạng thái</h6>
                    <p class="text-sm mb-0">Tổng hợp nhanh theo tình trạng log</p>
                </div>
                <div class="card-body">
                    <div class="chart text-center">
                        <canvas id="attendance-status-chart" class="chart-canvas" height="220"></canvas>
                    </div>

                    <div class="mt-4">
                        @foreach ($statusBreakdown as $status)
                            <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $status['color'] }} me-3">&nbsp;</span>
                                    <h6 class="mb-0 text-sm">{{ $status['label'] }}</h6>
                                </div>
                                <span class="text-sm font-weight-bold">{{ $status['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Số lượng theo phòng ban</h6>
                    <p class="text-sm mb-0">Phòng ban nào đang có nhiều bản ghi nhất trong ngày</p>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="attendance-department-chart" class="chart-canvas" height="280"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Lý do đi muộn phổ biến</h6>
                    <p class="text-sm mb-0">Để HR theo dõi nhóm nguyên nhân lặp lại</p>
                </div>
                <div class="card-body">
                    @foreach ($lateReasons as $reason)
                        <div class="d-flex justify-content-between align-items-center border-radius-lg bg-gray-100 p-3 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div>
                                <h6 class="mb-0 text-sm">{{ $reason['reason'] }}</h6>
                                <p class="mb-0 text-xs text-secondary">Số lần ghi nhận trong tháng</p>
                            </div>
                            <span class="badge bg-light text-dark">{{ $reason['count'] }}</span>
                        </div>
                    @endforeach

                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Có thể nối khối này với báo cáo đi muộn / về sớm theo tháng.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Hoạt động gần đây</h6>
                        <p class="text-sm mb-0">Nhật ký thao tác trên dữ liệu chấm công</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem log hệ thống</button>
                </div>
                <div class="card-body">
                    @foreach ($recentActivity as $activity)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="me-3">
                                    <h6 class="mb-1 text-sm">{{ $activity['title'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $activity['detail'] }}</p>
                                </div>
                                <span class="text-xs text-secondary">{{ $activity['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Hành động nhanh</h6>
                    <p class="text-sm mb-0">Dành cho HR khi xử lý bảng công</p>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn bg-gradient-success mb-0">
                            Duyệt công tạm
                        </button>
                        <button type="button" class="btn bg-gradient-primary mb-0">
                            Nhập file chấm công
                        </button>
                        <button type="button" class="btn bg-gradient-warning mb-0">
                            Sửa log thủ công
                        </button>
                        <button type="button" class="btn btn-outline-dark mb-0">
                            Đối soát với thiết bị
                        </button>
                    </div>

                    <div class="alert alert-light text-dark mt-4 mb-0 border">
                        Màn này là nền thao tác thật: sau này ta có thể gắn API, phân quyền, và workflow duyệt trực tiếp.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        const statusCanvas = document.getElementById('attendance-status-chart');
        if (statusCanvas) {
            new Chart(statusCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusValues),
                        backgroundColor: ['#2dce89', '#fb6340', '#f5365c', '#11cdef'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            });
        }

        const departmentCanvas = document.getElementById('attendance-department-chart');
        if (departmentCanvas) {
            new Chart(departmentCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($departmentLabels),
                    datasets: [{
                        label: 'Bản ghi',
                        data: @json($departmentValues),
                        borderRadius: 8,
                        backgroundColor: ['#344767', '#2dce89', '#11cdef', '#f5365c', '#fb6340', '#5e72e4'],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0,0,0,.06)',
                            },
                            ticks: {
                                color: '#67748e',
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#67748e',
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
