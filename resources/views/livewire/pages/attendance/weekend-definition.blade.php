<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h6 class="mb-1">Khai báo ngày cuối tuần và nghỉ lễ</h6>
                            <p class="text-sm mb-0">
                                Thiết lập ngày nghỉ chuẩn, nghỉ lễ và nghỉ bù để phục vụ lịch làm việc, tính công và báo biểu.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">Quy tắc tính công</a>
                            <a href="{{ route('attendance-schedules') }}" class="btn bg-gradient-dark mb-0">Lịch làm việc</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-white mt-3 mb-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <div class="card card-background card-background-mask-dark h-100">
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved9.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ count($weekendDays) }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Ngày cuối tuần mỗi tuần</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Ngày nghỉ/lễ đã khai báo</p>
                                    <h6 class="mb-0">{{ $holidays->count() }}</h6>
                                    <p class="text-sm mb-0">Áp dụng cho lịch và tính công</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Nghỉ có hưởng công</p>
                                    <h6 class="mb-0">{{ $holidays->where('is_paid', true)->count() }}</h6>
                                    <p class="text-sm mb-0">Theo cấu hình ngày nghỉ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-5">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Thiết lập ngày cuối tuần</h6>
                                    <p class="text-sm mb-0">Chọn các ngày được tính là cuối tuần trong hệ thống.</p>
                                </div>
                                <div class="card-body">
                                    <form wire:submit.prevent="saveWeekendSettings">
                                        <div class="row">
                                            @foreach ([1 => 'Thứ 2', 2 => 'Thứ 3', 3 => 'Thứ 4', 4 => 'Thứ 5', 5 => 'Thứ 6', 6 => 'Thứ 7', 7 => 'Chủ nhật'] as $weekday => $label)
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-check form-switch">
                                                        <input
                                                            id="weekday-{{ $weekday }}"
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            role="switch"
                                                            value="{{ $weekday }}"
                                                            wire:model="weekendDays"
                                                        >
                                                        <label class="form-check-label" for="weekday-{{ $weekday }}">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('weekendDays') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        <button type="submit" class="btn bg-gradient-dark mb-0 mt-3">Lưu ngày cuối tuần</button>
                                    </form>

                                    <hr class="horizontal dark my-4">
                                    <h6 class="mb-2">Cấu hình hiện tại</h6>
                                    @forelse ($weekendSettings as $setting)
                                        <div class="d-flex align-items-center justify-content-between border-radius-lg p-2 {{ $loop->first ? 'bg-gray-100' : '' }}">
                                            <span class="text-sm">{{ $setting->label }}</span>
                                            @if ($setting->is_weekend)
                                                <span class="badge bg-gradient-success">Cuối tuần</span>
                                            @else
                                                <span class="badge bg-gradient-secondary">Ngày thường</span>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-sm text-secondary mb-0">Chưa có cấu hình cuối tuần.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-7 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Thêm ngày nghỉ/lễ</h6>
                                    <p class="text-sm mb-0">Khai báo nghỉ lễ, nghỉ bù hoặc ngày công ty nghỉ riêng.</p>
                                </div>
                                <div class="card-body">
                                    <form wire:submit.prevent="saveHoliday">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Ngày</label>
                                                <input type="date" class="form-control" wire:model="holidayDate">
                                                @error('holidayDate') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <label class="form-label">Tên ngày nghỉ</label>
                                                <input type="text" class="form-control" wire:model="holidayName" placeholder="Ví dụ: Tết Dương lịch">
                                                @error('holidayName') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Loại</label>
                                                <select class="form-control" wire:model="holidayType">
                                                    <option value="holiday">Nghỉ lễ</option>
                                                    <option value="compensatory">Nghỉ bù</option>
                                                    <option value="company_off">Công ty nghỉ</option>
                                                    <option value="special_workday">Ngày làm bù</option>
                                                </select>
                                                @error('holidayType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-md-4 mt-3 mt-md-0">
                                                <label class="form-label">Số công quy đổi</label>
                                                <input type="number" step="0.25" min="0" max="2" class="form-control" wire:model="workdayValue">
                                                @error('workdayValue') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-md-4 mt-3 mt-md-0">
                                                <label class="form-label d-block">Hưởng công</label>
                                                <div class="form-check form-switch weekend-paid-switch">
                                                    <input id="holiday-paid" class="form-check-input" type="checkbox" role="switch" wire:model="isPaid">
                                                    <label class="form-check-label" for="holiday-paid">Có tính công</label>
                                                </div>
                                                @error('isPaid') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" rows="3" wire:model="note" placeholder="Ví dụ: áp dụng toàn công ty"></textarea>
                                            @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark mb-0 mt-3">Lưu ngày nghỉ/lễ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6 class="mb-1">Danh sách ngày nghỉ/lễ</h6>
                                    <p class="text-sm mb-0">Các ngày này sẽ được dùng khi sinh lịch và tính công.</p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loại</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Công</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ghi chú</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($holidays as $holiday)
                                                    <tr>
                                                        <td><p class="text-sm mb-0">{{ $holiday->date->format('d/m/Y') }}</p></td>
                                                        <td><p class="text-sm font-weight-bold mb-0">{{ $holiday->name }}</p></td>
                                                        <td><span class="badge bg-gradient-info">{{ $holiday->type }}</span></td>
                                                        <td>
                                                            @if ($holiday->is_paid)
                                                                <span class="badge bg-gradient-success">{{ $holiday->workday_value }} công</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Không hưởng công</span>
                                                            @endif
                                                        </td>
                                                        <td><p class="text-sm mb-0">{{ $holiday->note ?: '-' }}</p></td>
                                                        <td class="text-center">
                                                            <button
                                                                type="button"
                                                                class="btn btn-link text-danger text-xs font-weight-bold mb-0 p-0"
                                                                wire:click="deleteHoliday({{ $holiday->id }})"
                                                                wire:confirm="Xóa ngày nghỉ/lễ này?"
                                                            >
                                                                Xóa
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa khai báo ngày nghỉ/lễ nào.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
