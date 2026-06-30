<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h5 class="mb-0">Vai trò & phân quyền</h5>
                    <p class="text-sm text-secondary mb-0">Quản lý vai trò người dùng và số quyền nghiệp vụ đang được gán.</p>
                </div>
                @if (Session::has('status'))
                <div class="alert alert-success alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (Session::has('error'))
                <div class="alert alert-danger alert-dismissible text-white mx-4" role="alert">
                    <span class="text-sm">{{ Session::get('error') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @can('manage-users', App\Models\User::class)
                <div class="col-12 text-end">
                    <a class="btn bg-gradient-dark mb-0 me-4" href="{{ route('new-role') }}"><i
                            class="material-icons text-sm">add</i>&nbsp;&nbsp;Tạo vai trò</a>
                </div>
                @endcan
                <div class="d-flex flex-row justify-content-between mx-4">
                    <div class="d-flex mt-3 align-items-center justify-content-center">
                        <p class="text-secondary pt-2">Hiển thị&nbsp;&nbsp;</p>
                        <select wire:model.live="perPage" class="form-control mb-2" id="entries">
                            <option value="5">5</option>
                            <option selected value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <p class="text-secondary pt-2">&nbsp;&nbsp;dòng</p>
                    </div>
                    <div class="mt-3 ">
                        <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm vai trò...">
                    </div>
                </div>
                <x-table>

                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('id')"
                            :direction="$sortField === 'id' ? $sortDirection : null"> ID
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> Vai trò
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('description')"
                            :direction="$sortField === 'description' ? $sortDirection : null">Mô tả
                        </x-table.heading>
                        <x-table.heading>
                            Quyền
                        </x-table.heading>
                        <x-table.heading>
                            Người dùng
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                            :direction="$sortField === 'created_at' ? $sortDirection : null">
                            Ngày tạo
                        </x-table.heading>
                        @can('manage-users', App\Models\User::class)
                        <x-table.heading>Actions</x-table.heading>
                        @endcan
                    </x-slot>

                    <x-slot name="body">
                        @foreach ($roles as $role)
                        <x-table.row wire:key="row-{{ $role->id }}">
                            <x-table.cell>{{ $role->id }}</x-table.cell>
                            <x-table.cell>
                                <span class="text-sm font-weight-bold">{{ $role->name }}</span>
                            </x-table.cell>
                            <x-table.cell>{{ $role->description }}</x-table.cell>
                            <x-table.cell>
                                <span class="badge badge-sm bg-gradient-info">{{ $role->permissions_count }} quyền</span>
                            </x-table.cell>
                            <x-table.cell>
                                <span class="badge badge-sm bg-gradient-secondary">{{ $role->users_count }} user</span>
                            </x-table.cell>
                            <x-table.cell>{{ $role->created_at?->format('Y-m-d') }}</x-table.cell>
                            <x-table.cell>
                                @can('manage-users', App\Models\User::class)
                                @can('update', $role)
                                <a rel="tooltip" class="btn btn-link text-dark mb-0 p-0 me-3" href="{{ route('edit-role', $role)}}"
                                    data-original-title="" title="Sửa vai trò">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                                @endcan
                                @can('delete', $role)
                                <button type="button" class="btn btn-link text-danger mb-0 p-0" data-original-title="" title="Xóa vai trò"
                                    onclick="confirm('Bạn chắc chắn muốn xóa vai trò này?') || event.stopImmediatePropagation()"
                                    wire:click="destroy({{ $role->id }})">
                                    <i class="material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                                @endcan
                                @endcan
                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                <div id="datatable-bottom">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
@endpush
