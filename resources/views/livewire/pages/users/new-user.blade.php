<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Thêm nhân viên</h5>
                            <p class="text-sm mb-0">
                                Chọn cách nhập phù hợp: đi theo wizard đầy đủ hoặc chỉ nhập các thông tin bắt buộc.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <a href="{{ route('employee-list') }}" class="btn btn-outline-secondary mb-0">Danh sách nhân viên</a>
                            <a href="{{ route('employee-bulk-create') }}" class="btn bg-gradient-dark mb-0 ms-2">Thêm hàng loạt</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <button type="button" class="btn w-100 text-start border border-2 p-4 mb-0 option-card js-mode-btn active" data-mode="wizard">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg bg-gradient-primary me-3">
                                            <i class="ni ni-app text-white opacity-10"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Dùng wizard đầy đủ</h6>
                                            <p class="text-sm mb-0">Nhập chi tiết, có nhiều bước, phù hợp khi tạo nhân viên mới hoàn chỉnh.</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-gradient-primary">Khuyến nghị</span>
                                </div>
                            </button>
                        </div>
                        <div class="col-12 col-lg-6">
                            <button type="button" class="btn w-100 text-start border border-2 p-4 mb-0 option-card js-mode-btn" data-mode="quick">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg bg-gradient-dark me-3">
                                            <i class="ni ni-single-02 text-white opacity-10"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Chỉ thêm thông tin bắt buộc</h6>
                                            <p class="text-sm mb-0">Nhanh gọn, chỉ cần dữ liệu tối thiểu để tạo hồ sơ nhân viên.</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-gradient-secondary">Nhanh</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="wizardMode">
                <div class="multisteps-form mb-9">
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <div class="card">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                        <div class="multisteps-form__progress">
                                            <button class="multisteps-form__progress-btn js-active" type="button" title="Basic Info">
                                                <span>1. Thông tin</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Job Info">
                                                <span>2. Công việc</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Account Info">
                                                <span>3. Tài khoản</span>
                                            </button>
                                            <button class="multisteps-form__progress-btn" type="button" title="Note">
                                                <span>4. Ghi chú</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="multisteps-form__form">
                                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Thông tin cá nhân</h5>
                                            <p class="mb-0 text-sm">Nhập các thông tin cơ bản của nhân viên.</p>
                                            <div class="multisteps-form__content">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Họ và tên</label>
                                                            <input class="multisteps-form__input form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Mã nhân viên</label>
                                                            <input class="multisteps-form__input form-control" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Số điện thoại</label>
                                                            <input class="multisteps-form__input form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Email</label>
                                                            <input class="multisteps-form__input form-control" type="email" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Tiếp theo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Thông tin công việc</h5>
                                            <p class="mb-0 text-sm">Chọn phòng ban, chức vụ và ca làm cho nhân viên.</p>
                                            <div class="multisteps-form__content">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label mb-1">Phòng ban</label>
                                                        <select class="form-control">
                                                            <option>Kinh doanh</option>
                                                            <option>Kế toán</option>
                                                            <option>Công nghệ</option>
                                                            <option>Hành chính</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <label class="form-label mb-1">Chức vụ</label>
                                                        <select class="form-control">
                                                            <option>Nhân viên</option>
                                                            <option>Trưởng phòng</option>
                                                            <option>Phó phòng</option>
                                                            <option>Thực tập sinh</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <label class="form-label mb-1">Ca làm</label>
                                                        <select class="form-control">
                                                            <option>Hành chính</option>
                                                            <option>Ca sáng</option>
                                                            <option>Ca chiều</option>
                                                            <option>Ca đêm</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Ngày vào làm</label>
                                                            <input class="multisteps-form__input form-control" type="date" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Quay lại</button>
                                                    <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Tiếp theo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Tài khoản hệ thống</h5>
                                            <p class="mb-0 text-sm">Tạo tài khoản đăng nhập nếu nhân viên cần sử dụng hệ thống.</p>
                                            <div class="multisteps-form__content">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Tên đăng nhập</label>
                                                            <input class="multisteps-form__input form-control" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                        <div class="input-group input-group-dynamic">
                                                            <label class="form-label">Mật khẩu</label>
                                                            <input class="multisteps-form__input form-control" type="password" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <label class="form-label mb-1">Quyền truy cập</label>
                                                        <select class="form-control">
                                                            <option>Nhân viên</option>
                                                            <option>Quản lý</option>
                                                            <option>Nhân sự</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Quay lại</button>
                                                    <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Tiếp theo</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="multisteps-form__panel border-radius-xl bg-white h-100" data-animation="FadeIn">
                                            <h5 class="font-weight-bolder mb-0">Ghi chú và xác nhận</h5>
                                            <p class="mb-0 text-sm">Thêm ghi chú cuối cùng trước khi lưu nhân viên.</p>
                                            <div class="multisteps-form__content mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group input-group-dynamic">
                                                            <textarea class="multisteps-form__textarea form-control" rows="5" placeholder="Ghi chú, người tạo, lý do tạo..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="button-row d-flex mt-4">
                                                    <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Quay lại</button>
                                                    <button class="btn bg-gradient-dark ms-auto mb-0" type="button" title="Send">Lưu nhân viên</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="quickMode" class="d-none">
                <div class="row">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5 class="mb-1">Thêm thông tin bắt buộc</h5>
                                <p class="text-sm mb-0">Dùng khi cần tạo hồ sơ nhanh, chỉ nhập những thông tin cần thiết.</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Họ và tên</label>
                                            <input class="form-control" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Mã nhân viên</label>
                                            <input class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Số điện thoại</label>
                                            <input class="form-control" type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label mb-1">Phòng ban</label>
                                        <select class="form-control">
                                            <option>Kinh doanh</option>
                                            <option>Kế toán</option>
                                            <option>Công nghệ</option>
                                            <option>Hành chính</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <label class="form-label mb-1">Chức vụ</label>
                                        <select class="form-control">
                                            <option>Nhân viên</option>
                                            <option>Trưởng phòng</option>
                                            <option>Phó phòng</option>
                                            <option>Thực tập sinh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Ngày vào làm</label>
                                            <input class="form-control" type="date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary mb-0 js-mode-btn" data-mode="wizard">Quay lại wizard</button>
                                    <button type="button" class="btn bg-gradient-dark mb-0">Lưu nhân viên</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
<script>
    if (document.getElementById('choices-state')) {
        var element = document.getElementById('choices-state');
        const example = new Choices(element, {
            searchEnabled: false
        });
    }

    const modeButtons = document.querySelectorAll('.js-mode-btn');
    const wizardMode = document.getElementById('wizardMode');
    const quickMode = document.getElementById('quickMode');
    const optionCards = document.querySelectorAll('.option-card');

    function setMode(mode) {
        if (mode === 'quick') {
            wizardMode.classList.add('d-none');
            quickMode.classList.remove('d-none');
        } else {
            quickMode.classList.add('d-none');
            wizardMode.classList.remove('d-none');
        }

        optionCards.forEach((card) => {
            const active = card.dataset.mode === mode;
            card.classList.toggle('border-primary', active);
            card.classList.toggle('shadow-lg', active);
        });
    }

    modeButtons.forEach((button) => {
        button.addEventListener('click', () => setMode(button.dataset.mode));
    });

    setMode('wizard');
</script>
@endpush
