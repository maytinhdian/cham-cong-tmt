<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Thiết bị chấm công</h5>
                            <p class="text-sm mb-0">
                                Quản lý máy chấm công, trạng thái kết nối và chuẩn bị dữ liệu cho bước đồng bộ log thô.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-settings') }}" class="btn btn-outline-secondary mb-0">Cài đặt chấm công</a>
                            <button type="button" class="btn bg-gradient-dark mb-0 ms-2" wire:click="resetForm">
                                <i class="material-icons-round text-sm me-1">add</i>
                                Thêm thiết bị
                            </button>
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
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved8.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $devices->count() }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Thiết bị đã khai báo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Đang online</p>
                                    <h6 class="mb-0">{{ $onlineCount }}</h6>
                                    <p class="text-sm mb-0">Dựa trên lần máy gọi server qua PUSH</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Offline / cần kiểm tra</p>
                                    <h6 class="mb-0">{{ $offlineCount }}</h6>
                                    <p class="text-sm mb-0">
                                        @if ($latestSyncedDevice)
                                            Đồng bộ gần nhất: {{ $latestSyncedDevice->last_synced_at->diffForHumans() }}
                                        @else
                                            Chưa có lần đồng bộ
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                        <div>
                                            <h6 class="mb-1">Danh sách thiết bị</h6>
                                            <p class="text-sm mb-0">Theo dõi lần máy gọi server, xếp lệnh PUSH và nhận log thô.</p>
                                        </div>
                                        <div>
                                            <select class="form-control" wire:model.live="statusFilter">
                                                <option value="">Tất cả trạng thái</option>
                                                <option value="online">Online</option>
                                                <option value="offline">Offline</option>
                                                <option value="unknown">Chưa kiểm tra</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thiết bị</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kết nối</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vị trí</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đồng bộ</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($devices as $device)
                                                    @php
                                                        $isRecentlyConnected = $device->last_connected_at?->greaterThanOrEqualTo($recentlyConnectedAfter) ?? false;
                                                    @endphp
                                                    <tr @class(['bg-gray-100' => (int) $editingDeviceId === $device->id])>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                                    <i class="material-icons-round text-white text-sm">fingerprint</i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-sm">{{ $device->name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $device->code }} - {{ strtoupper($device->device_type) }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $device->ip_address ?: 'Chưa có IP' }}:{{ $device->port }}</p>
                                                            @if ($isRecentlyConnected)
                                                                <span class="badge bg-gradient-success">Online</span>
                                                            @elseif (! $device->last_connected_at)
                                                                <span class="badge bg-gradient-secondary">Chưa kiểm tra</span>
                                                            @else
                                                                <span class="badge bg-gradient-warning">Offline</span>
                                                            @endif
                                                            <p class="text-xs text-secondary mb-0 mt-1">
                                                                {{ $device->last_connected_at ? 'Gọi server: ' . $device->last_connected_at->diffForHumans() : 'Chưa có heartbeat/PUSH' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $device->location ?: 'Chưa khai báo' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $device->last_synced_at?->diffForHumans() ?? 'Chưa đồng bộ' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $device->sync_status }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-link text-info me-3 mb-0 p-0" wire:click="checkConnection({{ $device->id }})" title="Kiểm tra kết nối" aria-label="Kiểm tra kết nối {{ $device->name }}">
                                                                <i class="material-icons">sensors</i>
                                                            </button>
                                                            <button type="button" class="btn btn-link text-secondary me-3 mb-0 p-0" wire:click="syncDevice({{ $device->id }})" title="Đồng bộ thiết bị" aria-label="Đồng bộ thiết bị {{ $device->name }}">
                                                                <i class="material-icons">sync</i>
                                                            </button>
                                                            <button type="button" class="btn btn-link text-secondary me-3 mb-0 p-0" wire:click="editDevice({{ $device->id }})" title="Sửa thiết bị" aria-label="Sửa thiết bị {{ $device->name }}">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                            <button
                                                                type="button"
                                                                class="btn btn-link text-danger mb-0 p-0"
                                                                wire:click="deleteDevice({{ $device->id }})"
                                                                wire:confirm="Xóa thiết bị này khỏi danh sách?"
                                                                title="Xóa thiết bị"
                                                                aria-label="Xóa thiết bị {{ $device->name }}"
                                                            >
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có thiết bị chấm công nào.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $editingDeviceId ? 'Sửa thiết bị' : 'Thêm thiết bị' }}</h6>
                                            <p class="text-sm mb-0">Khai báo thông tin kết nối máy chấm công.</p>
                                        </div>
                                        @if ($editingDeviceId)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="resetForm">Hủy</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="saveDevice">
                                        <div class="form-group">
                                            <label class="form-label">Tên thiết bị <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" wire:model="name" placeholder="Máy cửa chính">
                                            @error('name') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Mã thiết bị <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="code" placeholder="DEV-001">
                                                @error('code') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Loại máy</label>
                                                <select class="form-control" wire:model="deviceType">
                                                    <option value="zkteco">ZKTeco</option>
                                                    <option value="ronald_jack">Ronald Jack</option>
                                                    <option value="hikvision">Hikvision</option>
                                                    <option value="other">Khác</option>
                                                </select>
                                                @error('deviceType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-8">
                                                <label class="form-label">IP thiết bị</label>
                                                <input type="text" class="form-control" wire:model="ipAddress" placeholder="192.168.1.201">
                                                @error('ipAddress') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Port</label>
                                                <input type="number" class="form-control" wire:model="port">
                                                @error('port') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Vị trí lắp đặt</label>
                                            <input type="text" class="form-control" wire:model="location" placeholder="Cổng chính, xưởng A...">
                                            @error('location') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái kết nối</label>
                                                <select class="form-control" wire:model="connectionStatus">
                                                    <option value="unknown">Chưa kiểm tra</option>
                                                    <option value="online">Online</option>
                                                    <option value="offline">Offline</option>
                                                </select>
                                                @error('connectionStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Trạng thái đồng bộ</label>
                                                <select class="form-control" wire:model="syncStatus">
                                                    <option value="idle">Chờ đồng bộ</option>
                                                    <option value="syncing">Đang đồng bộ</option>
                                                    <option value="synced">Đã đồng bộ</option>
                                                    <option value="failed">Lỗi</option>
                                                </select>
                                                @error('syncStatus') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Ghi chú</label>
                                            <textarea class="form-control" rows="3" wire:model="note" placeholder="Thông tin tài khoản kết nối, khu vực phụ trách..."></textarea>
                                            @error('note') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="alert alert-info text-white mt-4" role="alert">
                                            Với ZKTeco PUSH, mã thiết bị nên là serial SN. Máy cần cấu hình ADMS/PUSH trỏ về server để gọi /iclock/cdata và /iclock/getrequest.
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0">
                                            {{ $editingDeviceId ? 'Cập nhật thiết bị' : 'Lưu thiết bị' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
