<div class="container-fluid py-4" wire:poll.5s>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Trạm nhận dữ liệu PUSH</h5>
                            <p class="text-sm mb-0">Theo dõi máy chấm công gọi server, nhận log thô và phản hồi lệnh PUSH.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-devices') }}" class="btn btn-outline-secondary mb-0">Thiết bị</a>
                            <a href="{{ route('attendance-raw-logs') }}" class="btn bg-gradient-dark mb-0 ms-2">Log thô</a>
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
                                <div class="full-background" style="background-image: url('{{ asset('assets') }}/img/curved-images/curved11.jpg')"></div>
                                <div class="card-body text-center p-3">
                                    <h4 class="text-white mb-0">{{ $receivedTodayCount }}</h4>
                                    <p class="text-white text-sm opacity-8 mb-0">Log PUSH nhận hôm nay</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Thiết bị đang gọi server</p>
                                    <h6 class="mb-0">{{ $onlineCount }}</h6>
                                    <p class="text-sm mb-0">Có heartbeat/PUSH trong 15 phút gần đây</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <p class="text-sm text-secondary mb-1">Lệnh đang chờ máy lấy</p>
                                    <h6 class="mb-0">{{ $pendingCommandCount }}</h6>
                                    <p class="text-sm mb-0">Sẽ gửi qua /iclock/getrequest</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 col-xl-4">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Cấu hình endpoint</h6>
                                    <p class="text-sm mb-0">Dùng khi khai báo ADMS/PUSH trên máy ZKTeco.</p>
                                </div>
                                <div class="card-body p-3">
                                    <label class="form-label">Server URL</label>
                                    <input type="text" class="form-control" value="{{ url('/') }}" readonly>

                                    <label class="form-label mt-3">Khởi tạo / nhận log</label>
                                    <input type="text" class="form-control" value="{{ $cdataEndpoint }}" readonly>

                                    <label class="form-label mt-3">Máy hỏi lệnh</label>
                                    <input type="text" class="form-control" value="{{ $getRequestEndpoint }}" readonly>

                                    <label class="form-label mt-3">Máy trả kết quả lệnh</label>
                                    <input type="text" class="form-control" value="{{ $deviceCmdEndpoint }}" readonly>

                                    <div class="alert alert-info text-white mt-4 mb-0" role="alert">
                                        Máy sẽ gọi GET /iclock/cdata?SN=...&options=all để lấy cấu hình, sau đó POST log vào /iclock/cdata?table=ATTLOG.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 mt-4 mt-xl-0">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                        <div>
                                            <h6 class="mb-1">Thiết bị đang khai báo</h6>
                                            <p class="text-sm mb-0">Online nghĩa là máy vừa gọi một endpoint /iclock/*.</p>
                                        </div>
                                        <div>
                                            <select class="form-control" wire:model.live="deviceFilter">
                                                <option value="">Tất cả thiết bị</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }}</option>
                                                @endforeach
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
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hôm nay</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lệnh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($deviceRows as $device)
                                                    @php
                                                        $isRecentlyConnected = $device->last_connected_at?->greaterThanOrEqualTo($recentlyConnectedAfter) ?? false;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="avatar avatar-sm bg-gradient-dark me-3">
                                                                    <i class="material-icons-round text-white text-sm">sensors</i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 text-sm">{{ $device->name }}</h6>
                                                                    <p class="text-xs text-secondary mb-0">{{ $device->code }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($isRecentlyConnected)
                                                                <span class="badge bg-gradient-success">Online</span>
                                                            @elseif ($device->last_connected_at)
                                                                <span class="badge bg-gradient-warning">Offline</span>
                                                            @else
                                                                <span class="badge bg-gradient-secondary">Chưa có heartbeat</span>
                                                            @endif
                                                            <p class="text-xs text-secondary mb-0 mt-1">{{ $device->last_connected_at?->diffForHumans() ?? 'Chưa gọi server' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $device->received_today_count }} log</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $device->pending_commands_count }} lệnh chờ</p>
                                                        </td>
                                                        <td class="text-center">
                                                            @can('attendance.devices.manage')
                                                                <button type="button" class="btn btn-link text-secondary mb-0 p-0" wire:click="queueLogSync({{ $device->id }})" title="Yêu cầu máy gửi log" aria-label="Yêu cầu máy gửi log {{ $device->name }}">
                                                                    <i class="material-icons">sync</i>
                                                                </button>
                                                            @else
                                                                <span class="text-xs text-secondary">Chỉ xem</span>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có thiết bị nào.</p>
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

                    <div class="row mt-4">
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Log PUSH vừa nhận</h6>
                                    <p class="text-sm mb-0">Sắp xếp theo thời điểm server nhận dữ liệu.</p>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhận lúc</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Chấm công</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Người dùng máy</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recentLogs as $rawLog)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->created_at->format('d/m/Y H:i:s') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->device?->code ?? 'Không rõ SN' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->punch_time->format('d/m/Y H:i:s') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->punch_type }} / {{ $rawLog->verify_type ?: 'unknown' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $rawLog->device_user_code }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->employee?->full_name ?? 'Chưa map nhân viên' }}</p>
                                                        </td>
                                                        <td>
                                                            @if ($rawLog->processing_status === 'pending')
                                                                <span class="badge bg-gradient-warning">Chờ xử lý</span>
                                                            @elseif ($rawLog->processing_status === 'processed')
                                                                <span class="badge bg-gradient-success">Đã xử lý</span>
                                                            @elseif ($rawLog->processing_status === 'ignored')
                                                                <span class="badge bg-gradient-secondary">Bỏ qua</span>
                                                            @else
                                                                <span class="badge bg-gradient-danger">Lỗi</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa nhận log PUSH nào theo bộ lọc này.</p>
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
                                    <h6 class="mb-1">Lệnh PUSH gần đây</h6>
                                    <p class="text-sm mb-0">Theo dõi lệnh server đã xếp cho máy.</p>
                                </div>
                                <div class="card-body p-3">
                                    @forelse ($recentCommands as $command)
                                        <div class="border-bottom py-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $command->command }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ $command->device?->code ?? 'Không rõ SN' }} / {{ $command->command_key }}</p>
                                                </div>
                                                @if ($command->status === 'pending')
                                                    <span class="badge bg-gradient-warning">Chờ</span>
                                                @elseif ($command->status === 'sent')
                                                    <span class="badge bg-gradient-info">Đã gửi</span>
                                                @elseif ($command->status === 'acknowledged')
                                                    <span class="badge bg-gradient-success">OK</span>
                                                @else
                                                    <span class="badge bg-gradient-danger">Lỗi</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-secondary mb-0 mt-1">
                                                {{ $command->responded_at?->diffForHumans() ?? $command->sent_at?->diffForHumans() ?? $command->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-secondary mb-0">Chưa có lệnh PUSH nào.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
