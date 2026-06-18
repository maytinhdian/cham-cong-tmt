<style>
    .shift-definition-page .form-control,
    .shift-definition-page .form-select {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
        box-shadow: none !important;
    }

    .shift-definition-page .form-control:focus,
    .shift-definition-page .form-select:focus {
        border-color: #5e72e4 !important;
        box-shadow: 0 0 0 0.15rem rgba(94, 114, 228, 0.15) !important;
    }

    .shift-definition-page .mini-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 0.35rem;
    }

    .shift-definition-page .field-group {
        margin-bottom: 0.95rem;
    }

    .shift-definition-page .color-chip {
        width: 36px;
        height: 36px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #3b82f6;
        flex: 0 0 auto;
    }

    .shift-definition-page .form-check-input:checked {
        background-color: #5e72e4;
        border-color: #5e72e4;
    }
</style>

<div class="container-fluid py-4 shift-definition-page">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-3 pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Khai báo ca làm việc</h6>
                            <p class="text-sm mb-0">
                                Quản lý ca làm việc, khung giờ chấm công và quy tắc tính công theo từng ca.
                            </p>
                        </div>
                        <button type="button"
                            class="btn btn-icon btn-2 btn-primary mb-0 d-flex align-items-center justify-content-center"
                            title="Thêm ca làm việc">
                            <span class="btn-inner--icon">
                                <i class="material-icons">add</i>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="card-body p-3 pt-0">
                    <hr class="horizontal dark mt-0 mb-4">

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ca làm việc</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giờ ca</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chấm vào</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chấm ra</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công chuẩn</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <span class="avatar avatar-sm bg-gradient-primary border-radius-lg me-3">
                                                                <i class="material-icons text-white text-sm">wb_sunny</i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs">Ca ngày 12 tiếng</h6>
                                                            <p class="text-xs text-secondary mb-0">DAY_12H</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">07:00 - 19:00</p>
                                                    <p class="text-xs text-secondary mb-0">Đi trễ 5 phút</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">06:30 - 07:30</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">18:30 - 19:30</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-dot me-4">
                                                        <i class="bg-success"></i>
                                                        <span class="text-dark text-xs">1 công / 480 phút</span>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge badge-sm bg-gradient-success">Đang dùng</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-3">Sửa</a>
                                                    <a href="javascript:;" class="text-danger font-weight-bold text-xs">Xóa</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <span class="avatar avatar-sm bg-gradient-dark border-radius-lg me-3">
                                                                <i class="material-icons text-white text-sm">bedtime</i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs">Ca đêm 12 tiếng</h6>
                                                            <p class="text-xs text-secondary mb-0">NIGHT_12H</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">19:00 - 07:00</p>
                                                    <p class="text-xs text-secondary mb-0">Qua ngày</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">18:30 - 19:30</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">06:30 - 07:30</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-dot me-4">
                                                        <i class="bg-info"></i>
                                                        <span class="text-dark text-xs">1 công / 480 phút</span>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge badge-sm bg-gradient-secondary">Tạm ngưng</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-3">Sửa</a>
                                                    <a href="javascript:;" class="text-danger font-weight-bold text-xs">Xóa</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <span class="avatar avatar-sm bg-gradient-info border-radius-lg me-3">
                                                                <i class="material-icons text-white text-sm">business_center</i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs">Ca hành chính</h6>
                                                            <p class="text-xs text-secondary mb-0">HC</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">08:00 - 17:30</p>
                                                    <p class="text-xs text-secondary mb-0">Về sớm 5 phút</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">07:45 - 08:15</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-normal mb-0">17:15 - 18:00</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-dot me-4">
                                                        <i class="bg-success"></i>
                                                        <span class="text-dark text-xs">1 công / 480 phút</span>
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge badge-sm bg-gradient-success">Đang dùng</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs me-3">Sửa</a>
                                                    <a href="javascript:;" class="text-danger font-weight-bold text-xs">Xóa</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="card border shadow-none h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <h6 class="mb-0">Thông tin ca</h6>
                                        <span class="badge badge-sm bg-gradient-info">Đang chỉnh sửa</span>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="field-group">
                                        <div class="mini-label">Tên ca</div>
                                        <input type="text" class="form-control" value="Ca ngày 12 tiếng">
                                    </div>

                                    <div class="field-group">
                                        <div class="mini-label">Mã ca</div>
                                        <input type="text" class="form-control" value="DAY_12H">
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Giờ vào ca</div>
                                                <input type="time" class="form-control" value="07:00">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Giờ ra ca</div>
                                                <input type="time" class="form-control" value="19:00">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Cho phép chấm vào từ</div>
                                                <input type="time" class="form-control" value="06:30">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Cho phép chấm vào đến</div>
                                                <input type="time" class="form-control" value="07:30">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Cho phép chấm ra từ</div>
                                                <input type="time" class="form-control" value="18:30">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Cho phép chấm ra đến</div>
                                                <input type="time" class="form-control" value="19:30">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Đi trễ tối đa (phút)</div>
                                                <input type="number" class="form-control" value="5">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Về sớm tối đa (phút)</div>
                                                <input type="number" class="form-control" value="5">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Số công quy đổi</div>
                                                <input type="number" class="form-control" value="1" step="0.1">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="field-group">
                                                <div class="mini-label">Số phút công chuẩn</div>
                                                <input type="number" class="form-control" value="480">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check form-switch ps-0 field-group">
                                                <input class="form-check-input ms-auto" type="checkbox" checked>
                                                <label class="form-check-label mini-label">Bắt buộc chấm vào</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check form-switch ps-0 field-group">
                                                <input class="form-check-input ms-auto" type="checkbox" checked>
                                                <label class="form-check-label mini-label">Bắt buộc chấm ra</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="mini-label">Màu hiển thị</div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="color-chip"></div>
                                            <input type="text" class="form-control" value="#3b82f6">
                                        </div>
                                    </div>

                                    <div class="field-group">
                                        <div class="mini-label">Mô tả</div>
                                        <textarea class="form-control" rows="3">Ca ngày 12 tiếng cho bộ phận sản xuất.</textarea>
                                    </div>

                                    <div class="field-group mb-0">
                                        <div class="mini-label">Trạng thái</div>
                                        <select class="form-select">
                                            <option selected>Đang dùng</option>
                                            <option>Tạm ngưng</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="button" class="btn btn-outline-secondary mb-0">Hủy</button>
                                        <button type="button" class="btn bg-gradient-dark mb-0">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
