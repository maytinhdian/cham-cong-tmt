<div class="container-fluid py-4 bg-gray-200">
    <div class="row">
        <div class="col-12">
            <div class="multisteps-form mb-5">
                <div class="row">
                    <div class="col-12 my-5">
                        <div class="card">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <div class="multisteps-form__progress">
                                        <button class="multisteps-form__progress-btn js-active" type="button" title="Guide">
                                            <span>1. Hướng dẫn</span>
                                        </button>
                                        <button class="multisteps-form__progress-btn" type="button" title="Upload">
                                            <span>2. Tải file lên</span>
                                        </button>
                                        <button class="multisteps-form__progress-btn" type="button" title="Review">
                                            <span>3. Kiểm tra & nhập</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <form class="multisteps-form__form">
                                    <div class="multisteps-form__panel pt-3 border-radius-xl bg-white js-active"
                                        data-animation="FadeIn">
                                        <h5 class="font-weight-bolder mb-0">Bước 1: Hướng dẫn chuẩn bị file</h5>
                                        <p class="mb-0 text-sm">
                                            Hãy chuẩn bị đúng cấu trúc cột trước khi tải lên để giảm lỗi khi import.
                                        </p>

                                        <div class="multisteps-form__content">
                                            <div class="row mt-4 text-start">
                                                <div class="col-12 col-md-4">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Mã nhân viên</p>
                                                        <h6 class="mb-0">Không được trùng</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Họ và tên</p>
                                                        <h6 class="mb-0">Bắt buộc có dữ liệu</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Phòng ban</p>
                                                        <h6 class="mb-0">Nên khớp danh mục có sẵn</h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4 text-start">
                                                <div class="col-12 col-lg-6">
                                                    <label class="form-control ms-0">Cột gợi ý trong file</label>
                                                    <ul class="mb-0 ps-3">
                                                        <li>Mã nhân viên</li>
                                                        <li>Họ và tên</li>
                                                        <li>Email</li>
                                                        <li>Phòng ban</li>
                                                        <li>Ca làm</li>
                                                    </ul>
                                                </div>
                                                <div class="col-12 col-lg-6 mt-3 mt-lg-0">
                                                    <label class="form-control ms-0">Lưu ý</label>
                                                    <ul class="mb-0 ps-3">
                                                        <li>Hỗ trợ file `.xlsx`, `.xls`, `.csv`.</li>
                                                        <li>Mỗi dòng tương ứng với một nhân viên.</li>
                                                        <li>Nên dùng file mẫu để chuẩn hóa dữ liệu.</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="button-row d-flex mt-4">
                                                <a href="javascript:;" class="btn btn-outline-dark mb-0">Tải file mẫu</a>
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="multisteps-form__panel pt-3 border-radius-xl bg-white" data-animation="FadeIn">
                                        <h5 class="font-weight-bolder mb-0">Bước 2: Tải file lên</h5>
                                        <p class="mb-0 text-sm">
                                            Kéo thả file Excel/CSV vào khu vực bên dưới để bắt đầu kiểm tra.
                                        </p>

                                        <div class="multisteps-form__content">
                                            <div class="row mt-4 text-start">
                                                <div class="col-12">
                                                    <label class="form-control ms-0">File import</label>
                                                    <div action="javascript:;" class="form-control border dropzone" id="employeeBulkDropzone">
                                                        <div class="fallback">
                                                            <input name="file" type="file" accept=".xlsx,.xls,.csv" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4 text-start">
                                                <div class="col-12 col-md-4">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Định dạng</p>
                                                        <h6 class="mb-0">XLSX, XLS, CSV</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Dung lượng</p>
                                                        <h6 class="mb-0">Tối đa 10 MB</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-3 mt-md-0">
                                                    <div class="border rounded-3 p-3 h-100">
                                                        <p class="text-xs text-uppercase text-secondary font-weight-bold mb-1">Trạng thái</p>
                                                        <h6 class="mb-0">Chưa nhập dữ liệu</h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="button-row d-flex mt-4">
                                                <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">
                                                    Prev
                                                </button>
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="multisteps-form__panel pt-3 border-radius-xl bg-white" data-animation="FadeIn">
                                        <h5 class="font-weight-bolder mb-0">Bước 3: Kiểm tra và nhập dữ liệu</h5>
                                        <p class="mb-0 text-sm">
                                            Xem trước dữ liệu import và xác nhận trước khi ghi vào hệ thống.
                                        </p>

                                        <div class="multisteps-form__content mt-3">
                                            <div class="row text-start">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-flush align-items-center mb-0" id="employee-bulk-table">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Họ và tên</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã NV</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phòng ban</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ca làm</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ghi chú</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-sm font-weight-normal">Nguyễn Minh Quân</td>
                                                                    <td class="text-sm font-weight-normal">EMP-001</td>
                                                                    <td class="text-sm font-weight-normal">Kinh doanh</td>
                                                                    <td class="text-sm font-weight-normal">Hành chính</td>
                                                                    <td class="text-sm font-weight-normal">
                                                                        <span class="badge bg-gradient-success">Hợp lệ</span>
                                                                    </td>
                                                                    <td class="text-sm font-weight-normal">Đủ thông tin</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-sm font-weight-normal">Trần Thu Hằng</td>
                                                                    <td class="text-sm font-weight-normal">EMP-002</td>
                                                                    <td class="text-sm font-weight-normal">Kế toán</td>
                                                                    <td class="text-sm font-weight-normal">Ca sáng</td>
                                                                    <td class="text-sm font-weight-normal">
                                                                        <span class="badge bg-gradient-warning">Thiếu cột</span>
                                                                    </td>
                                                                    <td class="text-sm font-weight-normal">Thiếu email</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-sm font-weight-normal">Lê Quốc Bảo</td>
                                                                    <td class="text-sm font-weight-normal">EMP-003</td>
                                                                    <td class="text-sm font-weight-normal">Công nghệ</td>
                                                                    <td class="text-sm font-weight-normal">Ca chiều</td>
                                                                    <td class="text-sm font-weight-normal">
                                                                        <span class="badge bg-gradient-info">Chờ duyệt</span>
                                                                    </td>
                                                                    <td class="text-sm font-weight-normal">Chưa gán phòng ban</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-sm font-weight-normal">Phạm Thị Mai</td>
                                                                    <td class="text-sm font-weight-normal">EMP-004</td>
                                                                    <td class="text-sm font-weight-normal">Nhân sự</td>
                                                                    <td class="text-sm font-weight-normal">Ca đêm</td>
                                                                    <td class="text-sm font-weight-normal">
                                                                        <span class="badge bg-gradient-success">Hợp lệ</span>
                                                                    </td>
                                                                    <td class="text-sm font-weight-normal">Sẵn sàng import</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="button-row d-flex mt-4 px-3 pb-2">
                                                <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                                                <button class="btn bg-gradient-dark ms-auto mb-0" type="button" title="Send">Import</button>
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
    </div>
</div>

@push('js')
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/dropzone.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/datatables.js"></script>
<script src="{{ asset('assets') }}/js/plugins/multistep-form.js"></script>
<script>
    Dropzone.autoDiscover = false;

    if (document.getElementById('employeeBulkDropzone')) {
        new Dropzone('#employeeBulkDropzone', {
            url: "/file-upload",
            addRemoveLinks: true,
            acceptedFiles: ".xlsx,.xls,.csv",
            maxFilesize: 10
        });
    }

    if (document.getElementById('employee-bulk-table')) {
        new simpleDatatables.DataTable("#employee-bulk-table", {
            searchable: true,
            fixedHeight: false,
            perPage: 5
        });

        window.dispatchEvent(new Event('resize'));
        setTimeout(() => window.dispatchEvent(new Event('resize')), 150);
    }
</script>
@endpush
