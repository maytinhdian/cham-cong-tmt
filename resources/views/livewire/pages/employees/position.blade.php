<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Quản lý chức vụ</h5>
                            <p class="text-sm mb-0">
                                Theo dõi danh mục chức vụ, lọc theo phòng ban và gán nhanh chức vụ cho nhân viên.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-2">
                                <i class="material-icons-round text-sm me-1">add</i>
                                Thêm chức vụ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card card-background card-background-mask-dark h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved11.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $positions->count() }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Chức vụ đang quản lý</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ cấp quản lý</p>
                                    <h6 class="mb-0">{{ $managementPositionCount }}</h6>
                                    <p class="text-sm mb-0">Executive, Manager, Lead</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Chức vụ phổ biến</p>
                                    <h6 class="mb-0">{{ $popularPosition?->name ?? 'Chưa có dữ liệu' }}</h6>
                                    <p class="text-sm mb-0">{{ $popularPosition?->employees_count ?? 0 }} nhân viên đang giữ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Lọc theo phòng ban</h6>
                                            <p class="text-sm mb-xl-0">Chọn phòng ban trước khi gán chức vụ cho nhân viên.</p>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            @forelse ($departments as $department)
                                                <button
                                                    type="button"
                                                    wire:click="selectDepartment({{ $department->id }})"
                                                    class="btn btn-sm {{ $selectedDepartment?->id === $department->id ? 'bg-gradient-primary text-white' : 'btn-outline-secondary' }} mb-0"
                                                >
                                                    {{ $department->name }}
                                                </button>
                                            @empty
                                                <span class="text-sm text-secondary">Chưa có phòng ban.</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-7">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Danh sách chức vụ</h6>
                                            <p class="text-sm mb-0">Chọn chức vụ để xem và gán nhân viên trong phòng ban.</p>
                                        </div>
                                        <button class="btn btn-sm bg-gradient-dark mb-0" type="button">
                                            <i class="material-icons-round text-sm me-1">add</i>
                                            Tạo chức vụ
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Chức vụ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cấp độ</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nhân sự</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($positions as $position)
                                                    <tr @class(['bg-gray-100' => $selectedPosition?->id === $position->id])>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="me-3">
                                                                    <div class="avatar avatar-sm bg-gradient-dark">
                                                                        <i class="material-icons-round text-white text-sm opacity-10">badge</i>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $position->name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $position->code }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><p class="text-sm mb-0">{{ $position->level ?: 'Chưa phân cấp' }}</p></td>
                                                        <td><p class="text-sm mb-0">{{ $position->employees_count }} nhân viên</p></td>
                                                        <td>
                                                            @if ($position->status === 'active')
                                                                <span class="badge bg-gradient-success">Đang dùng</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Tạm ngưng</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button
                                                                class="btn btn-link text-info mb-0 p-0 me-3"
                                                                type="button"
                                                                wire:click="selectPosition({{ $position->id }})"
                                                                title="Chọn chức vụ"
                                                                aria-label="Chọn chức vụ {{ $position->name }}"
                                                            >
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                            <a href="javascript:;" class="btn btn-link text-secondary mb-0 p-0" title="Sửa chức vụ" aria-label="Sửa chức vụ {{ $position->name }}">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có chức vụ nào.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-5 mt-4 mt-xl-0">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Gán chức vụ cho nhân viên</h6>
                                    <p class="text-sm mb-0">
                                        {{ $selectedPosition?->name ?? 'Chưa chọn chức vụ' }}
                                        @if ($selectedDepartment)
                                            trong phòng ban {{ $selectedDepartment->name }}
                                        @endif
                                    </p>
                                </div>
                                <div class="card-body pt-3">
                                    @forelse ($availableEmployees as $employee)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-info me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $employee->employee_code }}
                                                        - {{ $employee->position?->name ?? 'Chưa có chức vụ' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-sm bg-gradient-primary mb-0"
                                                type="button"
                                                wire:click="assignPosition({{ $employee->id }})"
                                                @disabled(! $selectedPosition)
                                            >
                                                Gán
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không còn nhân viên phù hợp để gán chức vụ này.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">Nhân viên đang giữ chức vụ</h6>
                                            <p class="text-sm mb-0">
                                                {{ $selectedPosition?->name ?? 'Chưa chọn chức vụ' }}
                                                @if ($selectedDepartment)
                                                    - {{ $selectedDepartment->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <span class="badge bg-gradient-success">{{ $positionEmployees->count() }} nhân sự</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    @forelse ($positionEmployees as $employee)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 mb-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                    <span class="text-white text-xs font-weight-bold">{{ mb_substr($employee->full_name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $employee->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $employee->department?->name ?? 'Chưa có phòng ban' }} - {{ $employee->employee_code }}
                                                    </p>
                                                </div>
                                            </div>
                                            <button
                                                class="btn btn-outline-secondary btn-sm mb-0"
                                                type="button"
                                                wire:click="removePosition({{ $employee->id }})"
                                            >
                                                Gỡ
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Chưa có nhân viên nào giữ chức vụ này trong phòng ban đang chọn.</p>
                                        </div>
                                    @endforelse

                                    <a href="{{ route('employee-list') }}" class="btn btn-outline-primary w-100 mb-0 mt-3">
                                        Xem danh sách nhân viên đầy đủ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
