<div class="container-fluid py-4" wire:poll.5s>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Test liên kết máy chấm công</h5>
                            <p class="text-sm mb-0">Xếp lệnh PUSH để máy tải log mới, tải theo khoảng thời gian, hoặc kiểm tra phản hồi lệnh.</p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('attendance-push-receiver') }}" class="btn btn-outline-secondary mb-0">Trạm PUSH</a>
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
                        <div class="col-12 col-xl-4 mt-4">
                            <div class="card h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Lệnh test</h6>
                                    <p class="text-sm mb-0">Lệnh được gửi khi máy gọi endpoint lấy lệnh.</p>
                                </div>
                                <div class="card-body p-3">
                                    <form wire:submit.prevent="queueCommand">
                                        <div class="form-group">
                                            <label class="form-label">Thiết bị <span class="text-danger">*</span></label>
                                            <select class="form-control" wire:model.live="attendanceDeviceId">
                                                <option value="">Chọn thiết bị</option>
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->code }} - {{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('attendanceDeviceId') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label class="form-label">Chức năng test</label>
                                            <select class="form-control" wire:model.live="commandType">
                                                <option value="range_attlog">Tải log theo khoảng thời gian</option>
                                                <option value="log">Tải log mới ngay</option>
                                                <option value="check">Kiểm tra / nạp lại theo stamp</option>
                                                <option value="reload_options">Nạp lại cấu hình thiết bị</option>
                                                <option value="set_option">Cập nhật một option</option>
                                                <option value="query_biodata">Truy vấn BIODATA</option>
                                                <option value="delete_user">Xóa một người dùng</option>
                                                <option value="delete_all_users">Xóa toàn bộ người dùng</option>
                                                <option value="delete_biodata_pin">Xóa BIODATA theo PIN</option>
                                                <option value="delete_biodata_type">Xóa BIODATA theo PIN + loại</option>
                                                <option value="delete_biodata_no">Xóa BIODATA theo PIN + loại + số mẫu</option>
                                                <option value="clear_biodata">Xóa toàn bộ BIODATA</option>
                                                <option value="custom">Lệnh tùy chỉnh</option>
                                            </select>
                                            @error('commandType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                        </div>

                                        @if ($commandType === 'range_attlog')
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <label class="form-label">Từ thời điểm <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" class="form-control" wire:model="startTime">
                                                    @error('startTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-label">Đến thời điểm <span class="text-danger">*</span></label>
                                                    <input type="datetime-local" class="form-control" wire:model="endTime">
                                                    @error('endTime') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                        @endif

                                        @if ($commandType === 'set_option')
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <label class="form-label">Option <span class="text-danger">*</span></label>
                                                    <select class="form-control" wire:model="optionKey">
                                                        <option value="ATTLOGStamp">ATTLOGStamp</option>
                                                        <option value="OPERLOGStamp">OPERLOGStamp</option>
                                                        <option value="ATTPHOTOStamp">ATTPHOTOStamp</option>
                                                        <option value="TransInterval">TransInterval</option>
                                                        <option value="TransTimes">TransTimes</option>
                                                        <option value="Realtime">Realtime</option>
                                                        <option value="Delay">Delay</option>
                                                    </select>
                                                    @error('optionKey') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="optionValue" placeholder="0">
                                                    @error('optionValue') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array($commandType, ['query_biodata', 'delete_user', 'delete_biodata_pin', 'delete_biodata_type', 'delete_biodata_no'], true))
                                            <div class="form-group mt-3">
                                                <label class="form-label">PIN người dùng trên máy @if ($commandType !== 'query_biodata') <span class="text-danger">*</span> @endif</label>
                                                <input type="text" class="form-control" wire:model="deviceUserPin" placeholder="1452">
                                                @error('deviceUserPin') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        @if (in_array($commandType, ['query_biodata', 'delete_biodata_type', 'delete_biodata_no'], true))
                                            <div class="form-group mt-3">
                                                <label class="form-label">Loại BIODATA <span class="text-danger">*</span></label>
                                                <select class="form-control" wire:model="biodataType">
                                                    <option value="1">1 - Vân tay</option>
                                                    <option value="2">2 - Khuôn mặt</option>
                                                    <option value="6">6 - Lòng bàn tay</option>
                                                    <option value="7">7 - Tĩnh mạch ngón tay</option>
                                                    <option value="8">8 - Bàn tay</option>
                                                    <option value="9">9 - Visible light face</option>
                                                </select>
                                                @error('biodataType') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        @if ($commandType === 'delete_biodata_no' || $commandType === 'query_biodata')
                                            <div class="form-group mt-3">
                                                <label class="form-label">Số mẫu BIODATA</label>
                                                <input type="text" class="form-control" wire:model="biodataNo" placeholder="1">
                                                @error('biodataNo') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        @if ($commandType === 'custom')
                                            <div class="form-group mt-3">
                                                <label class="form-label">Command <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="customCommand" placeholder="DATA QUERY ATTLOG">
                                                @error('customCommand') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="form-label">Payload</label>
                                                <textarea class="form-control" rows="3" wire:model="customPayload" placeholder="StartTime=2026-07-01 00:00:00&#9;EndTime=2026-07-31 23:59:59"></textarea>
                                                @error('customPayload') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        @if ($isDestructiveCommand)
                                            <div class="alert alert-danger text-white mt-4" role="alert">
                                                Lệnh đang chọn có thể xóa dữ liệu trên máy chấm công thật. Nhập XOA để xác nhận trước khi xếp lệnh.
                                            </div>
                                            <div class="form-group mt-3">
                                                <label class="form-label">Xác nhận lệnh xóa <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="deleteConfirmation" placeholder="XOA">
                                                @error('deleteConfirmation') <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p> @enderror
                                            </div>
                                        @endif

                                        <div class="alert alert-info text-white mt-4" role="alert">
                                            Máy phải đang cấu hình ADMS/PUSH về server. Trang này chỉ xếp lệnh; máy tự lấy lệnh tại {{ $getRequestEndpoint }}.
                                        </div>

                                        <button type="submit" class="btn bg-gradient-dark w-100 mb-0">
                                            <i class="material-icons-round text-sm me-1">send</i>
                                            Xếp lệnh test
                                        </button>
                                    </form>

                                    <div class="border-top mt-4 pt-3">
                                        <h6 class="text-sm mb-2">Danh sách lệnh xóa có thể test</h6>
                                        <p class="text-xs text-secondary mb-1">DATA DELETE USERINFO PIN=...</p>
                                        <p class="text-xs text-secondary mb-1">DATA DELETE USERINFO</p>
                                        <p class="text-xs text-secondary mb-1">DATA DELETE BIODATA Pin=...</p>
                                        <p class="text-xs text-secondary mb-1">DATA DELETE BIODATA Pin=...	Type=...</p>
                                        <p class="text-xs text-secondary mb-1">DATA DELETE BIODATA Pin=...	Type=...	No=...</p>
                                        <p class="text-xs text-secondary mb-0">CLEAR BIODATA</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body p-3">
                                            <p class="text-sm text-secondary mb-1">Thiết bị</p>
                                            <h6 class="mb-0">{{ $devices->count() }}</h6>
                                            <p class="text-sm mb-0">Đã khai báo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <div class="card h-100">
                                        <div class="card-body p-3">
                                            <p class="text-sm text-secondary mb-1">Lệnh đang chờ</p>
                                            <h6 class="mb-0">{{ $selectedDevice?->pending_commands_count ?? 0 }}</h6>
                                            <p class="text-sm mb-0">{{ $selectedDevice?->code ?? 'Chưa chọn thiết bị' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <div class="card h-100">
                                        <div class="card-body p-3">
                                            <p class="text-sm text-secondary mb-1">Log nhận hôm nay</p>
                                            <h6 class="mb-0">{{ $selectedDevice?->received_today_count ?? 0 }}</h6>
                                            <p class="text-sm mb-0">Qua {{ $uploadEndpoint }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header pb-0 p-3">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                        <div>
                                            <h6 class="mb-1">Lệnh gần đây</h6>
                                            <p class="text-sm mb-0">Theo dõi lệnh đã xếp, đã gửi và phản hồi từ máy.</p>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger btn-sm mb-0"
                                            wire:click="deleteSelectedCommands"
                                            wire:confirm="Xóa các lệnh test đã chọn khỏi danh sách?"
                                            @disabled(empty($selectedCommandIds))
                                        >
                                            <i class="material-icons-round text-sm me-1">delete</i>
                                            Xóa lệnh chọn
                                        </button>
                                    </div>
                                    @error('selectedCommandIds') <p class="text-danger text-xs mt-2 mb-0">{{ $message }}</p> @enderror
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Chọn</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lệnh</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thiết bị</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thời điểm</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recentCommands as $command)
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="form-check tmt-command-checkbox mb-0">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    value="{{ $command->id }}"
                                                                    wire:model.live="selectedCommandIds"
                                                                    aria-label="Chọn lệnh {{ $command->command_key }}"
                                                                >
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $command->command }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $command->payload ?: 'Không có payload' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $command->device?->code ?? 'Không rõ SN' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $command->command_key }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $command->created_at->format('d/m/Y H:i:s') }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $command->responded_at?->diffForHumans() ?? $command->sent_at?->diffForHumans() ?? 'Chưa gửi' }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($command->status === 'pending')
                                                                <span class="badge bg-gradient-warning">Chờ máy lấy</span>
                                                            @elseif ($command->status === 'sent')
                                                                <span class="badge bg-gradient-info">Đã gửi</span>
                                                            @elseif ($command->status === 'acknowledged')
                                                                <span class="badge bg-gradient-success">OK</span>
                                                            @else
                                                                <span class="badge bg-gradient-danger">Lỗi</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">Chưa có lệnh test nào.</p>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-1">Log vừa nhận từ thiết bị đang chọn</h6>
                                    <p class="text-sm mb-0">Dùng để kiểm tra sau khi máy phản hồi lệnh tải dữ liệu.</p>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giờ chấm</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Người dùng máy</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thiết bị</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Xử lý</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recentLogs as $rawLog)
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->punch_time->format('d/m/Y H:i:s') }}</p>
                                                            <p class="text-xs text-secondary mb-0">Nhận: {{ $rawLog->created_at->format('d/m/Y H:i:s') }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm font-weight-bold mb-0">{{ $rawLog->device_user_code }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->employee?->full_name ?? 'Chưa map nhân viên' }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm mb-0">{{ $rawLog->device?->code ?? 'Không rõ SN' }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $rawLog->punch_type }} / {{ $rawLog->verify_type ?: 'unknown' }}</p>
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
                                                            <p class="text-sm text-secondary mb-0">Chưa có log theo thiết bị đang chọn.</p>
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
