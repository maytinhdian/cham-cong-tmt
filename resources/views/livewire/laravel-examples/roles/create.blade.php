<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">Tạo vai trò</h5>
                            <p class="text-sm text-secondary mb-0">Khai báo vai trò và chọn quyền nghiệp vụ được phép sử dụng.</p>
                        </div>
                        <a class="btn btn-outline-secondary mb-0" href="{{ route('role-management') }}">
                            Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit="store">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="border rounded-3 p-3 h-100">
                                    <h6 class="mb-3">Thông tin vai trò</h6>
                                    <div class="mb-3">
                                        <label class="form-label" for="role-name">Tên vai trò <span class="text-danger">*</span></label>
                                        <input wire:model.blur="name" type="text" class="form-control" id="role-name" placeholder="Ví dụ: HR Staff">
                                        @error('name')
                                            <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label" for="role-description">Mô tả <span class="text-danger">*</span></label>
                                        <textarea wire:model.blur="description" class="form-control" id="role-description" rows="5" placeholder="Mô tả phạm vi sử dụng vai trò"></textarea>
                                        @error('description')
                                            <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                                @include('livewire.laravel-examples.roles.partials.permission-matrix')
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a class="btn btn-outline-secondary mb-0" href="{{ route('role-management') }}">Hủy</a>
                            <button type="submit" class="btn bg-gradient-dark mb-0">Tạo vai trò</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
