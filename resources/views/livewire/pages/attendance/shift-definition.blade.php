<style>
    .shift-definition-page .shift-shell {
        background: #f8f9fa;
    }

    .shift-definition-page .shift-card {
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 10px 30px rgba(18, 38, 63, 0.08);
    }

    .shift-definition-page .shift-table-wrap {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .shift-definition-page .shift-table {
        margin-bottom: 0;
        min-width: 980px;
    }

    .shift-definition-page .shift-table thead th {
        background: #f6f7fb;
        color: #344767;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        padding: 0.7rem 0.75rem;
        border-bottom: 1px solid #dee2e6;
    }

    .shift-definition-page .shift-table tbody td {
        font-size: 13px;
        white-space: nowrap;
        padding: 0.65rem 0.75rem;
        vertical-align: middle;
    }

    .shift-definition-page .shift-table tbody tr.is-active {
        background: #dceafe;
    }

    .shift-definition-page .form-control,
    .shift-definition-page .form-select {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        background-color: #fff !important;
        box-shadow: none !important;
    }

    .shift-definition-page .form-control:focus,
    .shift-definition-page .form-select:focus {
        border-color: #5e72e4 !important;
        box-shadow: 0 0 0 0.15rem rgba(94, 114, 228, 0.15) !important;
    }

    .shift-definition-page .mini-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.35rem;
    }

    .shift-definition-page .field-group {
        margin-bottom: 0.95rem;
    }

    .shift-definition-page .form-check-input:checked {
        background-color: #5e72e4;
        border-color: #5e72e4;
    }

    .shift-definition-page .color-chip {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        background: #3b82f6;
    }
</style>

<div class="container-fluid py-4 shift-definition-page">
    <div class="row">
        <div class="col-12">
            <div class="card shift-card">
                <div class="card-header p-3 pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Shift Timetable Maintenance</h6>
                            <p class="text-sm mb-0">
                                Quản lý ca làm việc, khung giờ chấm công và quy tắc tính công.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">
                                Cài đặt tính công
                            </a>
                            <button type="button" class="btn bg-gradient-dark mb-0">
                                Post
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-3 pt-0 shift-shell">
                    <hr class="horizontal dark mt-0 mb-3">

                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="shift-table-wrap">
                                <div class="table-responsive">
                                    <table class="table align-items-center shift-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 160px;">Tên ca</th>
                                                <th style="width: 110px;">Mã ca</th>
                                                <th style="width: 100px;">Giờ vào ca</th>
                                                <th style="width: 100px;">Giờ ra ca</th>
                                                <th style="width: 140px;">Cho phép chấm vào từ</th>
                                                <th style="width: 140px;">Cho phép chấm vào đến</th>
                                                <th style="width: 140px;">Cho phép chấm ra từ</th>
                                                <th style="width: 140px;">Cho phép chấm ra đến</th>
                                                <th style="width: 120px;">Màu hiển thị</th>
                                                <th style="width: 110px;">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="is-active">
                                                <td>Ca ngày 12 tiếng</td>
                                                <td>DAY_12H</td>
                                                <td>07:00</td>
                                                <td>19:00</td>
                                                <td>06:30</td>
                                                <td>07:30</td>
                                                <td>18:30</td>
                                                <td>19:30</td>
                                                <td>
                                                    <span class="badge bg-primary">#3b82f6</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Đang dùng</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ca đêm 12 tiếng</td>
                                                <td>NIGHT_12H</td>
                                                <td>19:00</td>
                                                <td>07:00</td>
                                                <td>18:30</td>
                                                <td>19:30</td>
                                                <td>06:30</td>
                                                <td>07:30</td>
                                                <td>
                                                    <span class="badge bg-dark">#111827</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">Tạm ngưng</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ca hành chính</td>
                                                <td>HC</td>
                                                <td>08:00</td>
                                                <td>17:30</td>
                                                <td>07:45</td>
                                                <td>08:15</td>
                                                <td>17:15</td>
                                                <td>18:00</td>
                                                <td>
                                                    <span class="badge bg-info">#0ea5e9</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Đang dùng</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border shadow-none h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <h6 class="mb-0">Thông tin ca</h6>
                                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                                            <button type="button" class="btn btn-sm btn-outline-primary mb-0">Add</button>
                                            <button type="button" class="btn btn-sm btn-outline-success mb-0">Post</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger mb-0">Delete</button>
                                        </div>
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

                                    <button type="button" class="btn bg-gradient-dark w-100 mb-0 mt-4">Lưu ca làm việc</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
