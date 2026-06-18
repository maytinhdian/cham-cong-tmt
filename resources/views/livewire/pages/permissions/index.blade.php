<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-1">Phân quyền</h5>
            <p class="text-sm mb-0">
                Quản lý quyền theo vai trò để kiểm soát đúng ai được xem, sửa, duyệt và xuất dữ liệu.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-lg-0 mt-3">
            <div class="d-inline-flex gap-2 flex-wrap justify-content-lg-end">
                <span class="badge badge-lg badge-dot me-2">
                    <i class="bg-success"></i>
                    <span class="text-dark">Đang áp dụng role-based access</span>
                </span>
                <span class="badge badge-lg badge-dot">
                    <i class="bg-primary"></i>
                    <span class="text-dark">Cập nhật theo log hệ thống</span>
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
                    <h6 class="mb-0">Vai trò hiện có</h6>
                    <p class="text-sm mb-0">Nhóm quyền đang dùng trong hệ thống</p>
                </div>
                <div class="card-body">
                    @foreach ($roles as $role)
                        <div class="border-radius-lg p-3 bg-gray-100 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-sm">{{ $role['name'] }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $role['scope'] }}</p>
                                </div>
                                <span class="badge bg-{{ $role['color'] }}">{{ $role['users'] }} user</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn bg-gradient-dark mb-0">Tạo role mới</button>
                        <button type="button" class="btn btn-outline-primary mb-0">Sao chép role</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">Ma trận quyền theo module</h6>
                        <p class="text-sm mb-0">Thiết lập ai được xem, chỉnh sửa, duyệt hay xuất dữ liệu</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-dark btn-sm mb-0">Xuất cấu hình</button>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-0">Lưu thay đổi</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Module</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mô tả</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Admin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">HR</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Manager</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Employee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $module['module'] }}</h6>
                                        </td>
                                        <td>
                                            <span class="text-sm text-secondary">{{ $module['description'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $module['admin'] ? 'bg-success' : 'bg-light text-dark' }}">
                                                {{ $module['admin'] ? 'Có' : 'Không' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $module['hr'] ? 'bg-success' : 'bg-light text-dark' }}">
                                                {{ $module['hr'] ? 'Có' : 'Không' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $module['manager'] ? 'bg-success' : 'bg-light text-dark' }}">
                                                {{ $module['manager'] ? 'Có' : 'Không' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $module['employee'] ? 'bg-success' : 'bg-light text-dark' }}">
                                                {{ $module['employee'] ? 'Có' : 'Không' }}
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
    </div>

    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Nguyên tắc áp dụng</h6>
                    <p class="text-sm mb-0">Các rule nền tảng khi triển khai quyền</p>
                </div>
                <div class="card-body">
                    @foreach ($policyRules as $rule)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="icon icon-shape icon-md bg-gradient-primary shadow-primary text-center border-radius-md">
                                <i class="material-icons opacity-10">fact_check</i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1 text-sm">{{ $rule }}</h6>
                                <p class="text-xs text-secondary mb-0">Có thể thay đổi theo chính sách vận hành và vai trò quản trị.</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5 mt-lg-0 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Hoạt động gần đây</h6>
                    <p class="text-sm mb-0">Ghi nhận thay đổi quyền và role</p>
                </div>
                <div class="card-body">
                    @foreach ($activityLog as $item)
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

                    <div class="alert alert-secondary text-dark mt-4 mb-0">
                        Menu này là điểm quản trị riêng cho phân quyền, tách khỏi phần `Laravel Examples` để dùng nhanh hơn.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
