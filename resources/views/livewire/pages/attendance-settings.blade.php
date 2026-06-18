<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Thiết lập tính công</h5>
            <p class="text-sm mb-0">
                Tinh chỉnh chi tiết toàn bộ quy tắc chấm công, OT, nghỉ phép, phê duyệt và ngoại lệ theo phòng ban.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Áp dụng toàn công ty</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-success"></i>
                    <span class="text-dark">Có thể ghi đè theo phòng ban</span>
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
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Thiết lập chung</h6>
                    <p class="text-sm mb-0">Thông số nền của hệ thống công</p>
                </div>
                <div class="card-body">
                    @foreach ($generalSettings as $setting)
                        <div class="border-radius-lg bg-gray-100 p-3 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="me-3">
                                    <h6 class="mb-1 text-sm">{{ $setting['label'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $setting['hint'] }}</p>
                                </div>
                                <span class="badge bg-light text-dark">{{ $setting['value'] }}</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="auto-round" checked>
                        <label class="form-check-label" for="auto-round">Tự động làm tròn thời gian công</label>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="multi-source" checked>
                        <label class="form-check-label" for="multi-source">Cho phép nhiều nguồn chấm công</label>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="manual-adjust">
                        <label class="form-check-label" for="manual-adjust">Cho phép chỉnh công thủ công</label>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="lock-when-missing" checked>
                        <label class="form-check-label" for="lock-when-missing">Khóa công khi thiếu check-out</label>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu cấu hình</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Khôi phục mặc định</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy tắc check-in / check-out</h6>
                    <p class="text-sm mb-0">Kiểm soát vào ca, ra ca và dữ liệu vi phạm</p>
                </div>
                <div class="card-body">
                    @foreach ($attendanceRules as $rule)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">fact_check</i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 text-sm">{{ $rule['title'] }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $rule['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Có thể áp dụng riêng cho từng phòng ban hoặc từng nhóm nhân sự đặc thù.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Quy tắc OT & nghỉ phép</h6>
                    <p class="text-sm mb-0">Công thức cộng trừ công và cách phê duyệt</p>
                </div>
                <div class="card-body">
                    <h6 class="text-sm mb-2">Quy tắc OT</h6>
                    @foreach ($overtimeRules as $rule)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : 'mb-4' }}">
                            <h6 class="mb-1 text-sm">{{ $rule['title'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $rule['detail'] }}</p>
                        </div>
                    @endforeach

                    <h6 class="text-sm mb-2 mt-4">Quy tắc nghỉ phép</h6>
                    @foreach ($leaveRules as $rule)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $rule['title'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $rule['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ghi đè theo phòng ban</h6>
                    <p class="text-sm mb-0">Thiết lập riêng cho từng bộ phận nếu cần</p>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quy tắc chấm công</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">OT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Duyệt nghỉ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentOverrides as $dept)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $dept['name'] }}</h6>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $dept['rule'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $dept['overtime'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-sm">{{ $dept['leave'] }}</span>
                                        </td>
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
                    <h6 class="mb-0">Cấp phê duyệt</h6>
                    <p class="text-sm mb-0">Ai được phép duyệt những loại yêu cầu nào</p>
                </div>
                <div class="card-body">
                    @foreach ($approvalLevels as $level)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $level['level'] }} - {{ $level['label'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $level['scope'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <h6 class="text-sm mb-2 mt-4">Checklist chính sách</h6>
                    @foreach ($policyChecklist as $policy)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ $policy }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Lịch sử thay đổi</h6>
                        <p class="text-sm mb-0">Các thao tác gần đây trên thiết lập tính công</p>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem log đầy đủ</button>
                </div>
                <div class="card-body">
                    @foreach ($history as $item)
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
            </div>
        </div>

        <div class="col-lg-4 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Ma trận quyết định</h6>
                    <p class="text-sm mb-0">Kết quả hệ thống sẽ xử lý khi gặp từng trường hợp</p>
                </div>
                <div class="card-body">
                    @foreach ($decisionMatrix as $row)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <h6 class="mb-1 text-sm">{{ $row['case'] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $row['result'] }}</p>
                        </div>
                    @endforeach
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-success mb-0">Lưu & áp dụng</button>
                        <button type="button" class="btn btn-outline-dark mb-0">Xem trước báo cáo công</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
