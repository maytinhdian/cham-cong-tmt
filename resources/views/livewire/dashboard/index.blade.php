<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Tổng quan chấm công</h5>
            <p class="text-sm mb-0">
                Theo dõi nhanh toàn bộ tình hình nhân sự, ca làm, đơn chờ duyệt, thiết bị chấm công và xu hướng công trong tuần.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-success"></i>
                    <span class="text-dark">Hôm nay: {{ now()->format('d/m/Y') }}</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Kỳ công: 01 - 30/06/2026</span>
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
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Biến động công trong tuần</h6>
                        <p class="text-sm mb-0">So sánh số lượng đúng giờ và đi muộn theo từng ngày</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem chi tiết</button>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="attendance-trend-chart" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Cơ cấu trạng thái</h6>
                    <p class="text-sm mb-0">Tỷ lệ tổng hợp của toàn bộ nhân sự trong ngày</p>
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
                                    <div>
                                        <h6 class="mb-0 text-sm">{{ $status['label'] }}</h6>
                                        <p class="mb-0 text-xs text-secondary">{{ $status['value'] }} người</p>
                                    </div>
                                </div>
                                <span class="text-sm font-weight-bold">{{ $status['percent'] }}</span>
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
                        <h6 class="mb-0">Bảng chấm công hôm nay</h6>
                        <p class="text-sm mb-0">Danh sách vào - ra gần nhất, có thể nối dữ liệu máy hoặc import thủ công</p>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm mb-0">Xuất Excel</button>
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
                                @foreach ($todayLogs as $log)
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
                                            <span class="badge badge-sm {{ str_contains($log['status'], 'muộn') ? 'bg-warning' : (str_contains($log['status'], 'Vắng') ? 'bg-danger' : 'bg-success') }}">
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

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ca làm hôm nay</h6>
                    <p class="text-sm mb-0">Số lượng nhân sự theo từng ca</p>
                </div>
                <div class="card-body">
                    @foreach ($todayShifts as $shift)
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

                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Có thể gắn trực tiếp với lịch làm việc, ngày nghỉ lễ và ca qua đêm ở các màn hình cấu hình phía sau.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Đơn chờ duyệt</h6>
                    <p class="text-sm mb-0">Nghỉ phép, OT và đổi ca</p>
                </div>
                <div class="card-body">
                    @foreach ($pendingRequests as $request)
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
                    <h6 class="mb-0">Thiết bị chấm công</h6>
                    <p class="text-sm mb-0">Trạng thái đồng bộ của các máy đang hoạt động</p>
                </div>
                <div class="card-body">
                    @foreach ($deviceStatus as $device)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="me-3">
                                    <h6 class="mb-1 text-sm">{{ $device['name'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $device['location'] }}</p>
                                </div>
                                <span class="badge {{ $device['status'] === 'Online' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $device['status'] }}
                                </span>
                            </div>
                            <p class="text-xs text-secondary mb-0 mt-2">Đồng bộ: {{ $device['sync'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Tổng hợp phòng ban</h6>
                    <p class="text-sm mb-0">Tỷ lệ hiện diện và đi muộn theo bộ phận</p>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NV</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đi muộn</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentOverview as $dept)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $dept['name'] }}</h6>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $dept['headcount'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $dept['late'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $dept['rate'] }}</span>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Điểm cần chú ý hôm nay</h6>
                        <p class="text-sm mb-0">Các trạng thái cần nhân sự xử lý sớm trong ca hiện tại</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                            <div class="border-radius-lg bg-gradient-success p-3 h-100">
                                <p class="text-white text-xs opacity-8 mb-1">Tỷ lệ đúng giờ</p>
                                <h3 class="text-white mb-0">82%</h3>
                                <p class="text-white text-sm opacity-8 mb-0">Mục tiêu: trên 85%</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                            <div class="border-radius-lg bg-gradient-warning p-3 h-100">
                                <p class="text-white text-xs opacity-8 mb-1">Đi muộn</p>
                                <h3 class="text-white mb-0">21 người</h3>
                                <p class="text-white text-sm opacity-8 mb-0">Cần đối soát ngay sau giờ vào ca</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                            <div class="border-radius-lg bg-gradient-primary p-3 h-100">
                                <p class="text-white text-xs opacity-8 mb-1">Đơn chờ duyệt</p>
                                <h3 class="text-white mb-0">14 đơn</h3>
                                <p class="text-white text-sm opacity-8 mb-0">Có 3 đơn vừa phát sinh sáng nay</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="border-radius-lg bg-gradient-dark p-3 h-100">
                                <p class="text-white text-xs opacity-8 mb-1">Thiết bị cảnh báo</p>
                                <h3 class="text-white mb-0">1 máy</h3>
                                <p class="text-white text-sm opacity-8 mb-0">Máy kho vận cần kiểm tra lại tín hiệu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        const trendCanvas = document.getElementById('attendance-trend-chart');
        if (trendCanvas) {
            new Chart(trendCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [{
                        label: 'Đúng giờ',
                        tension: 0.35,
                        borderWidth: 3,
                        borderColor: '#2dce89',
                        backgroundColor: 'rgba(45, 206, 137, .12)',
                        fill: true,
                        data: @json($attendanceSeries),
                        pointRadius: 4,
                        pointBackgroundColor: '#2dce89',
                    }, {
                        label: 'Đi muộn',
                        tension: 0.35,
                        borderWidth: 3,
                        borderColor: '#fb6340',
                        backgroundColor: 'rgba(251, 99, 64, .12)',
                        fill: true,
                        data: @json($lateSeries),
                        pointRadius: 4,
                        pointBackgroundColor: '#fb6340',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                usePointStyle: true,
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
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
    </script>
@endpush
