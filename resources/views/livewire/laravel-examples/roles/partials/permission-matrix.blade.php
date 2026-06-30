<div class="border rounded-3 p-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h6 class="mb-0">Ma trận quyền</h6>
            <p class="text-sm text-secondary mb-0">Chọn quyền theo từng nhóm nghiệp vụ.</p>
        </div>
        <span class="badge bg-gradient-info">{{ count($selectedPermissions) }} quyền đã chọn</span>
    </div>

    @error('selectedPermissions')
        <p class="text-danger text-xs mt-1 mb-2">{{ $message }}</p>
    @enderror

    @foreach ($permissionGroups as $group)
        <div class="border rounded-3 p-3 mb-3">
            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                <div>
                    <h6 class="text-sm mb-0">{{ $group['label'] }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ $group['permissions']->count() }} quyền</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-0" wire:click="clearModule('{{ $group['module'] }}')">
                        Bỏ chọn
                    </button>
                    <button type="button" class="btn bg-gradient-dark btn-sm mb-0" wire:click="selectModule('{{ $group['module'] }}')">
                        Chọn nhóm
                    </button>
                </div>
            </div>

            <div class="row">
                @foreach ($group['permissions'] as $permission)
                    <div class="col-12 col-md-6 mb-2" wire:key="permission-{{ $permission->id }}">
                        <div class="border rounded-3 px-3 py-2 h-100 d-flex align-items-center justify-content-between gap-3">
                            <label class="form-check-label text-sm mb-0" for="permission-{{ $permission->id }}">
                                {{ $permission->label ?: $permission->name }}
                                <span class="d-block text-xs text-secondary">{{ $permission->name }}</span>
                            </label>
                            <div class="form-check form-switch mb-0 ps-0">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="permission-{{ $permission->id }}"
                                    value="{{ $permission->id }}"
                                    wire:model.live="selectedPermissions"
                                    aria-label="{{ $permission->label ?: $permission->name }}"
                                >
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
