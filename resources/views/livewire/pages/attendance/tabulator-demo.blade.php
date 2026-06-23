<div class="container-fluid py-4">
    <link href="https://unpkg.com/tabulator-tables@6.5.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">

    <style>
        .tmt-tabulator-demo .tabulator {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .tmt-tabulator-demo .tabulator .tabulator-header {
            border-bottom: 1px solid #dee2e6;
        }

        .tmt-tabulator-demo .tabulator-row.tabulator-selected {
            background-color: rgba(233, 30, 99, 0.08);
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card tmt-tabulator-demo">
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Demo Tabulator</h5>
                            <p class="text-sm mb-0">Bảng thử nghiệm thao tác nhanh với log chấm công mẫu.</p>
                        </div>
                        <div class="mt-3 mt-lg-0 d-flex flex-wrap gap-2">
                            <button id="tabulator-add-row" type="button" class="btn bg-gradient-dark btn-sm mb-0">
                                <i class="material-icons-round text-sm me-1">add</i>
                                Thêm dòng
                            </button>
                            <button id="tabulator-delete-row" type="button" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="material-icons-round text-sm me-1">delete</i>
                                Xóa dòng chọn
                            </button>
                            <button id="tabulator-reset" type="button" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="material-icons-round text-sm me-1">restart_alt</i>
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <p class="text-sm text-secondary mb-1">Dòng hiện có</p>
                                <h6 id="tabulator-row-count" class="mb-0">0</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <p class="text-sm text-secondary mb-1">Dòng đang chọn</p>
                                <h6 id="tabulator-selected-count" class="mb-0">0</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <p class="text-sm text-secondary mb-1">Log chờ xử lý</p>
                                <h6 id="tabulator-pending-count" class="mb-0">0</h6>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <p class="text-sm text-secondary mb-1">Dữ liệu cuối</p>
                                <h6 id="tabulator-last-action" class="mb-0">Sẵn sàng</h6>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-2 mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <button id="tabulator-copy" type="button" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="material-icons-round text-sm me-1">content_copy</i>
                                Copy JSON
                            </button>
                            <button id="tabulator-download" type="button" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="material-icons-round text-sm me-1">download</i>
                                Tải CSV
                            </button>
                            <button id="tabulator-clear" type="button" class="btn btn-link text-danger font-weight-bold text-xs mb-0 px-2">
                                Xóa dữ liệu bảng
                            </button>
                        </div>
                        <div class="w-100 w-lg-25">
                            <input id="tabulator-search" type="text" class="form-control form-control-sm" placeholder="Lọc theo nhân viên, mã máy, thiết bị">
                        </div>
                    </div>

                    <div id="tabulator-demo-table"></div>

                    <p class="text-xs text-secondary mt-3 mb-0">
                        Demo này chạy hoàn toàn trên trình duyệt, chưa lưu vào database.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://unpkg.com/tabulator-tables@6.5.0/dist/js/tabulator.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const originalData = [
                    {
                        id: 1,
                        employee_code: "TEST-001",
                        employee_name: "Nguyễn Minh Anh",
                        device_code: "ZK-01",
                        device_user_code: "1001",
                        punch_time: "2026-06-22 07:58:00",
                        punch_type: "in",
                        verify_type: "fingerprint",
                        status: "pending",
                    },
                    {
                        id: 2,
                        employee_code: "TEST-001",
                        employee_name: "Nguyễn Minh Anh",
                        device_code: "ZK-01",
                        device_user_code: "1001",
                        punch_time: "2026-06-22 17:06:00",
                        punch_type: "out",
                        verify_type: "fingerprint",
                        status: "pending",
                    },
                    {
                        id: 3,
                        employee_code: "TEST-002",
                        employee_name: "Trần Quốc Bảo",
                        device_code: "ZK-02",
                        device_user_code: "2002",
                        punch_time: "2026-06-22 08:14:00",
                        punch_type: "in",
                        verify_type: "face",
                        status: "warning",
                    },
                    {
                        id: 4,
                        employee_code: "TEST-003",
                        employee_name: "Lê Thanh Nhã",
                        device_code: "ZK-01",
                        device_user_code: "3003",
                        punch_time: "2026-06-22 22:01:00",
                        punch_type: "in",
                        verify_type: "card",
                        status: "processed",
                    },
                ];

                const statusFormatter = function (cell) {
                    const value = cell.getValue();
                    const labels = {
                        pending: ["Chờ xử lý", "bg-gradient-warning"],
                        processed: ["Đã xử lý", "bg-gradient-success"],
                        warning: ["Cần kiểm tra", "bg-gradient-danger"],
                        ignored: ["Bỏ qua", "bg-gradient-secondary"],
                    };
                    const label = labels[value] || [value, "bg-gradient-secondary"];

                    return `<span class="badge badge-sm ${label[1]}">${label[0]}</span>`;
                };

                const table = new Tabulator("#tabulator-demo-table", {
                    data: originalData,
                    height: "460px",
                    layout: "fitColumns",
                    addRowPos: "bottom",
                    selectableRows: true,
                    reactiveData: false,
                    placeholder: "Chưa có dữ liệu mẫu",
                    columns: [
                        { title: "Mã NV", field: "employee_code", width: 110, editor: "input", headerFilter: "input" },
                        { title: "Nhân viên", field: "employee_name", minWidth: 180, editor: "input", headerFilter: "input" },
                        { title: "Thiết bị", field: "device_code", width: 110, editor: "input", headerFilter: "input" },
                        { title: "Mã máy", field: "device_user_code", width: 110, editor: "input" },
                        { title: "Thời gian", field: "punch_time", width: 170, editor: "input", sorter: "datetime" },
                        {
                            title: "Loại",
                            field: "punch_type",
                            width: 115,
                            editor: "list",
                            editorParams: { values: ["in", "out", "break_in", "break_out", "unknown"] },
                        },
                        {
                            title: "Xác thực",
                            field: "verify_type",
                            width: 130,
                            editor: "list",
                            editorParams: { values: ["fingerprint", "face", "card", "password"] },
                        },
                        {
                            title: "Trạng thái",
                            field: "status",
                            width: 140,
                            formatter: statusFormatter,
                            editor: "list",
                            editorParams: { values: ["pending", "processed", "warning", "ignored"] },
                        },
                    ],
                });

                const setText = function (id, text) {
                    document.getElementById(id).textContent = text;
                };

                const refreshCounters = function (actionText = null) {
                    const rows = table.getData("active");
                    setText("tabulator-row-count", rows.length);
                    setText("tabulator-selected-count", table.getSelectedRows().length);
                    setText("tabulator-pending-count", rows.filter((row) => row.status === "pending").length);

                    if (actionText) {
                        setText("tabulator-last-action", actionText);
                    }
                };

                table.on("tableBuilt", function () {
                    refreshCounters("Đã tải bảng");
                });

                table.on("dataChanged", function () {
                    refreshCounters();
                });

                table.on("rowSelectionChanged", function () {
                    refreshCounters();
                });

                document.getElementById("tabulator-add-row").addEventListener("click", function () {
                    table.addRow({
                        id: Date.now(),
                        employee_code: "TEST-NEW",
                        employee_name: "Nhân viên mới",
                        device_code: "ZK-01",
                        device_user_code: "",
                        punch_time: "2026-06-23 08:00:00",
                        punch_type: "in",
                        verify_type: "fingerprint",
                        status: "pending",
                    }).then(() => refreshCounters("Đã thêm dòng"));
                });

                document.getElementById("tabulator-delete-row").addEventListener("click", function () {
                    const selectedRows = table.getSelectedRows();

                    if (selectedRows.length === 0) {
                        refreshCounters("Chưa chọn dòng");
                        return;
                    }

                    selectedRows.forEach((row) => row.delete());
                    refreshCounters("Đã xóa dòng");
                });

                document.getElementById("tabulator-clear").addEventListener("click", function () {
                    table.clearData();
                    refreshCounters("Đã xóa bảng");
                });

                document.getElementById("tabulator-reset").addEventListener("click", function () {
                    table.setData(originalData);
                    refreshCounters("Đã reset");
                });

                document.getElementById("tabulator-download").addEventListener("click", function () {
                    table.download("csv", "tabulator-attendance-demo.csv");
                    refreshCounters("Đã tải CSV");
                });

                document.getElementById("tabulator-copy").addEventListener("click", function () {
                    navigator.clipboard.writeText(JSON.stringify(table.getData(), null, 2));
                    refreshCounters("Đã copy JSON");
                });

                document.getElementById("tabulator-search").addEventListener("input", function (event) {
                    const keyword = event.target.value.trim().toLowerCase();

                    if (!keyword) {
                        table.clearFilter();
                        refreshCounters("Đã bỏ lọc");
                        return;
                    }

                    table.setFilter(function (row) {
                        return ["employee_code", "employee_name", "device_code", "device_user_code"].some(function (field) {
                            return String(row[field] || "").toLowerCase().includes(keyword);
                        });
                    });
                    refreshCounters("Đang lọc");
                });
            });
        </script>
    @endpush
</div>
