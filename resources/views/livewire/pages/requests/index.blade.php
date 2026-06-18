<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Duyệt đơn nghỉ phép / OT</h5>
            <p class="text-sm mb-0">
                Quản lý toàn bộ yêu cầu trước khi cập nhật vào bảng công và báo cáo.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-warning"></i>
                    <span class="text-dark">Chờ duyệt: 12</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Đã liên kết bảng công</span>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($stats as $stat)
            <div class="col-xl-3 col-md-6 mt-md-0 mt-4">
                <div class="card h-100">
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
                    <h6 class="mb-0">Tạo yêu cầu mới</h6>
                    <p class="text-sm mb-0">Gửi đơn nghỉ phép, OT hoặc công tác</p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nhân viên</label>
                        <input type="text" class="form-control border border-2 p-2" placeholder="Chọn hoặc nhập tên nhân viên">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại yêu cầu</label>
                        <select class="form-select border border-2 p-2">
                            @foreach ($requestTypes as $type)
                                <option>{{ $type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Từ ngày / giờ</label>
                            <input type="datetime-local" class="form-control border border-2 p-2">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Đến ngày / giờ</label>
                            <input type="datetime-local" class="form-control border border-2 p-2">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Lý do</label>
                        <textarea class="form-control border border-2 p-2" rows="4" placeholder="Nhập lý do, bối cảnh, mục đích..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Người duyệt</label>
                        <select class="form-select border border-2 p-2">
                            <option>Trưởng phòng</option>
                            <option>Quản lý trực tiếp</option>
                            <option>HR / Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đính kèm</label>
                        <input type="file" class="form-control border border-2 p-2">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="auto-check" checked>
                        <label class="form-check-label" for="auto-check">Tự động kiểm tra trùng lịch và tồn phép</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn bg-gradient-success mb-0">Gửi yêu cầu</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Lưu nháp</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">Danh sách yêu cầu chờ duyệt</h6>
                        <p class="text-sm mb-0">Theo dõi trạng thái và đưa ra quyết định nhanh</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xuất Excel</button>
                        <button type="button" class="btn bg-gradient-dark btn-sm mb-0">Lọc theo trạng thái</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhân viên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thời gian</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lý do</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvalQueue as $request)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $request['employee'] }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $request['code'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $request['department'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $request['type'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $request['from'] }} - {{ $request['to'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $request['reason'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $request['color'] }}">{{ $request['status'] }}</span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-link text-success px-2 mb-0">
                                                <i class="material-icons text-sm me-1">check_circle</i>Duyệt
                                            </a>
                                            <a href="javascript:;" class="btn btn-link text-danger px-2 mb-0">
                                                <i class="material-icons text-sm me-1">cancel</i>Từ chối
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
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Chi tiết đơn đang chọn</h6>
                    <p class="text-sm mb-0">Xem nhanh dữ liệu trước khi ra quyết định</p>
                </div>
                <div class="card-body">
                    <div class="border-radius-lg bg-gradient-dark p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-white text-sm opacity-8 mb-1">Nhân viên</p>
                                <h5 class="text-white mb-1">{{ $selectedRequest['employee'] }}</h5>
                                <p class="text-white text-sm opacity-8 mb-0">{{ $selectedRequest['code'] }} - {{ $selectedRequest['department'] }}</p>
                            </div>
                            <span class="badge bg-light text-dark">{{ $selectedRequest['status'] }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="card bg-gray-100 shadow-none mb-0">
                                <div class="card-body p-3">
                                    <p class="text-xs text-secondary mb-1">Loại yêu cầu</p>
                                    <h6 class="mb-0">{{ $selectedRequest['type'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-gray-100 shadow-none mb-0">
                                <div class="card-body p-3">
                                    <p class="text-xs text-secondary mb-1">Thời lượng</p>
                                    <h6 class="mb-0">{{ $selectedRequest['duration'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-gray-100 shadow-none mb-0">
                                <div class="card-body p-3">
                                    <p class="text-xs text-secondary mb-1">Người duyệt</p>
                                    <h6 class="mb-0">{{ $selectedRequest['approver'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-gray-100 shadow-none mb-0">
                                <div class="card-body p-3">
                                    <p class="text-xs text-secondary mb-1">Gửi lúc</p>
                                    <h6 class="mb-0">{{ $selectedRequest['submittedAt'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light text-dark border">
                        <strong>Lý do:</strong> {{ $selectedRequest['reason'] }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Khu vực đối soát</h6>
                    <p class="text-sm mb-0">Chốt nhanh trước khi cập nhật vào bảng công</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($pendingByType as $item)
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <div class="card mb-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-lg icon-shape bg-gradient-{{ $item['color'] }} shadow-{{ $item['color'] }} text-center border-radius-md">
                                                <i class="material-icons opacity-10">{{ $item['icon'] }}</i>
                                            </div>
                                            <div class="ms-3">
                                                <p class="text-sm mb-1 text-capitalize">{{ $item['label'] }}</p>
                                                <h5 class="mb-0">{{ $item['value'] }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="alert alert-secondary text-dark mt-2 mb-0">
                        Tự động khóa đơn khi trùng lịch đã duyệt, đồng thời cập nhật phần công và OT liên quan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy trình duyệt</h6>
                    <p class="text-sm mb-0">Luồng xử lý trước khi công được cập nhật</p>
                </div>
                <div class="card-body">
                    @foreach ($workflow as $step)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <span class="text-white font-weight-bold">{{ $step['step'] }}</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 text-sm">{{ $step['title'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $step['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Bảng phê duyệt</h6>
                    <p class="text-sm mb-0">Ai xử lý từng loại đơn</p>
                </div>
                <div class="card-body">
                    @foreach ($approvalMatrix as $rule)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $rule['type'] }}</h6>
                            <p class="text-xs text-secondary mb-1">{{ $rule['level'] }}</p>
                            <p class="text-xs mb-0">{{ $rule['rule'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-3 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy định hệ thống</h6>
                    <p class="text-sm mb-0">Những chính sách nên bật</p>
                </div>
                <div class="card-body">
                    @foreach ($policyNotes as $note)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ $note }}</label>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu thiết lập</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xem báo cáo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Lịch sử xử lý</h6>
                    <p class="text-sm mb-0">Ghi nhận các yêu cầu vừa được duyệt hoặc từ chối</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($history as $item)
                            <div class="col-md-6 mt-3">
                                <div class="border-radius-lg p-3 bg-gray-100 h-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <h6 class="mb-1 text-sm">{{ $item['title'] }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $item['detail'] }}</p>
                                        </div>
                                        <span class="text-xs text-secondary">{{ $item['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
