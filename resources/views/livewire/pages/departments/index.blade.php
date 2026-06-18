<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Quản lý phòng ban</h5>
            <p class="text-sm mb-0">
                Tạo mới, chỉnh sửa và phân công trưởng bộ phận cho cấu trúc nhân sự nội bộ.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Màn hình cấu hình tổ chức</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Đồng bộ với chấm công</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($quickStats as $stat)
            <div class="col-xl-3 col-md-6 mt-md-0 mt-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-{{ $stat['color'] }} shadow-{{ $stat['color'] }} text-center border-radius-md">
                                <i class="material-icons opacity-10">{{ $stat['icon'] }}</i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-1 text-capitalize">{{ $stat['label'] }}</p>
                                <h4 class="mb-0">{{ $stat['value'] }}</h4>
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
                    <h6 class="mb-0">Tạo phòng ban</h6>
                    <p class="text-sm mb-0">Nhập thông tin phòng ban mới</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tên phòng ban</label>
                            <input type="text" class="form-control border border-2 p-2" placeholder="VD: Hành chính - Nhân sự">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mã phòng ban</label>
                            <input type="text" class="form-control border border-2 p-2" placeholder="VD: HCNS">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trưởng phòng</label>
                            <input type="text" class="form-control border border-2 p-2" placeholder="Chọn hoặc nhập tên">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Loại phòng ban</label>
                            <select class="form-select border border-2 p-2">
                                <option>Hành chính</option>
                                <option>Kinh doanh</option>
                                <option>Sản xuất</option>
                                <option>Hỗ trợ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số lượng định biên</label>
                            <input type="number" class="form-control border border-2 p-2" value="10">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea class="form-control border border-2 p-2" rows="4" placeholder="Mô tả chức năng, phạm vi trách nhiệm..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="dept-active" checked>
                            <label class="form-check-label" for="dept-active">Phòng ban đang hoạt động</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn bg-gradient-success mb-0">Lưu phòng ban</button>
                            <button type="button" class="btn btn-outline-dark mb-0">Lưu nháp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Danh sách phòng ban</h6>
                        <p class="text-sm mb-0">Xem nhanh trưởng bộ phận, định biên và trạng thái</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xuất Excel</button>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trưởng bộ phận</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân sự</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $department['name'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">Mã phòng ban nội bộ</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $department['manager'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm font-weight-bold">{{ $department['headcount'] }} người</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $department['color'] }}">{{ $department['status'] }}</span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-link text-dark px-2 mb-0">
                                                <i class="material-icons text-sm me-1">edit</i>Sửa
                                            </a>
                                            <a href="javascript:;" class="btn btn-link text-danger px-2 mb-0">
                                                <i class="material-icons text-sm me-1">delete</i>Xóa
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
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Phân công & quy tắc</h6>
                    <p class="text-sm mb-0">Thiết lập chung cho nhân viên trong phòng ban</p>
                </div>
                <div class="card-body">
                    @foreach ($assignmentNotes as $note)
                        <div class="d-flex align-items-center {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">fact_check</i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-sm">{{ $note }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Lịch sử thay đổi</h6>
                    <p class="text-sm mb-0">Các thao tác gần đây trên cấu trúc phòng ban</p>
                </div>
                <div class="card-body">
                    @foreach ($activityLogs as $activity)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $activity['action'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $activity['detail'] }}</p>
                                </div>
                                <span class="text-xs text-secondary">{{ $activity['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
