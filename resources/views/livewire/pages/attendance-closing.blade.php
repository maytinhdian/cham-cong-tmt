<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Chốt công</h5>
            <p class="text-sm mb-0">
                Khóa dữ liệu chấm công theo kỳ để chuyển sang tính lương và đối soát chính thức.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-success"></i>
                    <span class="text-dark">Đang mở kỳ tháng 6</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-warning"></i>
                    <span class="text-dark">Còn 9 trường hợp cần rà soát</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($summaryCards as $card)
            <div class="col-xl-3 col-md-6 mt-md-0 mt-4">
                <div class="card h-100">
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
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thông tin kỳ công</h6>
                    <p class="text-sm mb-0">Mốc thời gian và trạng thái hiện tại</p>
                </div>
                <div class="card-body">
                    @foreach ($periodInfo as $item)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $item['label'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $item['value'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Chốt tạm</button>
                        <button type="button" class="btn bg-gradient-dark mb-0">Chốt chính thức</button>
                        <button type="button" class="btn btn-outline-warning mb-0">Mở khóa</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">Danh sách nhân viên chờ chốt</h6>
                        <p class="text-sm mb-0">Dùng để rà soát trước khi khóa dữ liệu sang bảng lương</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xuất Excel</button>
                        <button type="button" class="btn btn-outline-dark btn-sm mb-0">Lọc theo phòng ban</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table table-flush align-items-center mb-0" id="datatable-attendance-closing">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ca</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Công</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Đi muộn</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">OT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nghỉ phép</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center px-2 py-1">
                                                <div class="avatar avatar-sm me-3 rounded-circle bg-gradient-{{ $employee['color'] }} d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-xs font-weight-bold">{{ strtoupper(substr($employee['name'], 0, 1)) }}</span>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $employee['name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $employee['code'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-sm">{{ $employee['dept'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">{{ $employee['shift'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-sm font-weight-bold">{{ $employee['workdays'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-sm text-secondary">{{ $employee['late'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-sm text-secondary">{{ $employee['ot'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-sm text-secondary">{{ $employee['leave'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-{{ $employee['color'] }}">{{ $employee['status'] }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:;" class="btn btn-link text-success px-2 mb-0">
                                                <i class="material-icons text-sm me-1">lock</i>Chốt
                                            </a>
                                            <a href="javascript:;" class="btn btn-link text-warning px-2 mb-0">
                                                <i class="material-icons text-sm me-1">lock_open</i>Mở
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
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy trình chốt công</h6>
                    <p class="text-sm mb-0">Các bước cần hoàn tất trước khi khóa dữ liệu</p>
                </div>
                <div class="card-body">
                    @foreach ($closingStages as $stage)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <span class="text-white font-weight-bold">{{ $stage['step'] }}</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 text-sm">{{ $stage['title'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $stage['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Cảnh báo cần xử lý</h6>
                    <p class="text-sm mb-0">Những điểm cần sửa trước khi chốt</p>
                </div>
                <div class="card-body">
                    @foreach ($alerts as $alert)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $alert }}</h6>
                        </div>
                    @endforeach

                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Chốt công chỉ nên thực hiện sau khi không còn lỗi dữ liệu lớn và các đơn nghỉ phép / OT đã được duyệt.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Tổng hợp theo phòng ban</h6>
                    <p class="text-sm mb-0">Tỷ lệ nhân viên đã chốt và số trường hợp cần mở khóa</p>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đã chốt</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cần rà soát</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentSummary as $department)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $department['name'] }}</h6>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $department['employees'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $department['locked'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $department['issues'] > 0 ? 'bg-warning' : 'bg-success' }}">{{ $department['issues'] }}</span>
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
                    <h6 class="mb-0">Lịch sử chốt công</h6>
                    <p class="text-sm mb-0">Ai chốt, lúc nào và đã làm gì</p>
                </div>
                <div class="card-body">
                    @foreach ($closingHistory as $item)
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

                    <div class="card bg-gradient-dark mt-4 mb-0">
                        <div class="card-body p-3">
                            <p class="text-white text-xs opacity-8 mb-1">Bước tiếp theo</p>
                            <h6 class="text-white mb-0">Chốt kỳ này và bàn giao sang bảng lương</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.simpleDatatables) {
                new simpleDatatables.DataTable('#datatable-attendance-closing', {
                    searchable: true,
                    fixedHeight: true,
                    perPage: 10
                });
            }
        });
    </script>
@endpush
