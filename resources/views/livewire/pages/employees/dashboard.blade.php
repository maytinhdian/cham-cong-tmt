<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-6 col-12 d-flex ms-auto">
            <a href="{{ route('new-user') }}" class="btn btn-icon btn-outline-secondary ms-auto">
                Thêm nhân viên
            </a>
            <div class="dropleft ms-3">
                <button class="btn bg-gradient-dark dropdown-toggle" type="button" id="dropdownEmployeeRange"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Tháng này
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownEmployeeRange">
                    <li><a class="dropdown-item" href="javascript:;">Hôm nay</a></li>
                    <li><a class="dropdown-item" href="javascript:;">7 ngày qua</a></li>
                    <li><a class="dropdown-item" href="javascript:;">30 ngày qua</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card mb-4">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md mt-n4 position-absolute">
                        <i class="ni ni-badge text-white opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Tổng nhân viên</p>
                        <h5 class="mb-0">248</h5>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+12% </span>so với tháng trước</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card mb-4">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md mt-n4 position-absolute">
                        <i class="ni ni-user-run text-white opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Đang làm việc</p>
                        <h5 class="mb-0">221</h5>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+4% </span>đã kích hoạt công</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card mb-4">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md mt-n4 position-absolute">
                        <i class="ni ni-single-copy-04 text-white opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Nhân viên mới</p>
                        <h5 class="mb-0">18</h5>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+7 </span>trong 30 ngày</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card mb-4">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-md mt-n4 position-absolute">
                        <i class="ni ni-time-alarm text-white opacity-10"></i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Chờ xử lý</p>
                        <h5 class="mb-0">09</h5>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">3 </span>đơn nghỉ chờ duyệt</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Nhân sự theo tháng</h6>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-md badge-dot me-4">
                            <i class="bg-primary"></i>
                            <span class="text-dark text-xs">Tuyển mới</span>
                        </span>
                        <span class="badge badge-md badge-dot me-4">
                            <i class="bg-dark"></i>
                            <span class="text-dark text-xs">Nghỉ việc</span>
                        </span>
                        <span class="badge badge-md badge-dot me-4">
                            <i class="bg-info"></i>
                            <span class="text-dark text-xs">Còn hiệu lực</span>
                        </span>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line-employee" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 mt-4 mt-lg-0">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Phân bổ phòng ban</h6>
                        <button type="button"
                            class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Phân bổ nhân sự theo phòng ban">
                            <i class="material-icons text-sm">priority_high</i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-5 col-12 text-center">
                            <div class="chart mt-5">
                                <canvas id="chart-doughnut-departments" class="chart-canvas" height="200"></canvas>
                            </div>
                            <a class="btn btn-sm bg-gradient-secondary mt-4" href="javascript:;">Xem chi tiết</a>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <span class="avatar avatar-sm me-2 bg-gradient-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle">HC</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Hành chính</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> 25% </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <span class="avatar avatar-sm me-2 bg-gradient-success text-white d-inline-flex align-items-center justify-content-center rounded-circle">KT</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Kế toán</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> 18% </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <span class="avatar avatar-sm me-2 bg-gradient-warning text-white d-inline-flex align-items-center justify-content-center rounded-circle">KD</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Kinh doanh</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> 31% </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <span class="avatar avatar-sm me-2 bg-gradient-info text-white d-inline-flex align-items-center justify-content-center rounded-circle">IT</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Công nghệ</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> 26% </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <span class="avatar avatar-sm me-2 bg-gradient-danger text-white d-inline-flex align-items-center justify-content-center rounded-circle">SX</span>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Sản xuất</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> 14% </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5 mb-md-0">
        <div class="col-sm-6">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Hành động nhanh</h6>
                        <button type="button"
                            class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Các thao tác HR thường dùng">
                            <i class="material-icons text-sm">priority_high</i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <a class="btn btn-success btn-simple mb-0 p-0" href="{{ route('new-user') }}">
                                        <i class="ni ni-badge fa-lg"></i>
                                    </a>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">Thêm nhân viên</span>
                                    <span class="ms-auto text-sm font-weight-normal">Mới</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-gradient-dark w-100" role="progressbar"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <a class="btn btn-primary btn-simple mb-0 p-0" href="javascript:;">
                                        <i class="ni ni-building fa-lg"></i>
                                    </a>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">Gán phòng ban</span>
                                    <span class="ms-auto text-sm font-weight-normal">12</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-gradient-dark w-80" role="progressbar"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <a class="btn btn-warning btn-simple mb-0 p-0" href="javascript:;">
                                        <i class="ni ni-calendar-grid-58 fa-lg"></i>
                                    </a>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">Phân ca làm</span>
                                    <span class="ms-auto text-sm font-weight-normal">08</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-gradient-dark w-60" role="progressbar"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <a class="btn btn-info btn-simple mb-0 p-0" href="javascript:;">
                                        <i class="ni ni-time-alarm fa-lg"></i>
                                    </a>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">Kiểm tra chấm công</span>
                                    <span class="ms-auto text-sm font-weight-normal">03</span>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-gradient-dark w-40" role="progressbar"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card h-100 mt-4 mt-md-0">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Danh sách gần đây</h6>
                        <button type="button"
                            class="btn btn-icon-only btn-rounded btn-outline-success mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Cập nhật gần nhất">
                            <i class="material-icons text-sm">done</i>
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cập nhật</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">1. Nguyễn Minh Quân</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Kinh doanh</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Đã kích hoạt</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">5 phút trước</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">2. Trần Thu Hằng</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Kế toán</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Chờ cấp tài khoản</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">12 phút trước</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">3. Lê Quốc Bảo</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Công nghệ</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Đang onboarding</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">25 phút trước</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">4. Phạm Ngọc Anh</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Hành chính</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">Đã gán ca</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">1 giờ trước</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
        <script>
            var ctx1 = document.getElementById("chart-line-employee").getContext("2d");
            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
            gradientStroke1.addColorStop(1, 'rgba(52,71,103,0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(52,71,103,0.0)');
            gradientStroke1.addColorStop(0, 'rgba(52,71,103,0)');

            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8"],
                    datasets: [{
                        label: "Nhân sự",
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                        borderColor: "#344767",
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: [182, 188, 196, 205, 214, 221, 232, 248],
                        maxBarThickness: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false
                            },
                            ticks: {
                                suggestedMin: 150,
                                suggestedMax: 280,
                                beginAtZero: false,
                                padding: 15,
                                color: '#9ca2b7'
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false
                            },
                            ticks: {
                                display: true,
                                color: '#9ca2b7',
                                padding: 20
                            }
                        }
                    }
                }
            });

            var ctx2 = document.getElementById("chart-doughnut-departments").getContext("2d");
            new Chart(ctx2, {
                type: "doughnut",
                data: {
                    labels: ["Hành chính", "Kế toán", "Kinh doanh", "Công nghệ", "Sản xuất"],
                    datasets: [{
                        label: "Phòng ban",
                        weight: 9,
                        cutout: 70,
                        tension: 0.9,
                        pointRadius: 2,
                        borderWidth: 2,
                        backgroundColor: ["#344767", "#82d616", "#fb8c00", "#17c1e8", "#ea0606"],
                        data: [25, 18, 31, 26, 14]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        </script>
    @endpush
</div>
