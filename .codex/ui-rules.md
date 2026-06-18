# UI Rules

## Visual System

Use the existing Material Dashboard 2 Pro / Bootstrap visual language.

Prefer:

- `card`
- `table-responsive`
- `table align-items-center mb-0`
- `text-uppercase text-secondary text-xxs font-weight-bolder opacity-7` for table headers
- `badge`, `badge-sm`, `badge-dot`, `bg-gradient-*`
- `nav nav-pills nav-fill p-1` for grouped settings
- `form-check form-switch` for on/off settings
- Material icons where the template already uses them

## Tables

Follow the table style from:

```text
public/documentation/components/tables.html
```

Table pattern:

```html
<div class="table-responsive">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Column</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
```

Avoid desktop-style thick borders unless the target page explicitly requires a legacy device-style layout.

## Attendance UI Decisions

`Cài đặt chấm công` is a large sidebar menu.

Its submenu items include:

- `Quy tắc tính công`
- `Khai báo ca làm việc`
- `Khai báo ngày cuối tuần`
- `Kí hiệu thống kê`

`Quy tắc tính công` should use nav-pills style groups:

- `Công chuẩn`
- `Trễ / sớm`
- `Tăng ca`
- `Nghỉ phép`
- `Khóa công`

`Khai báo ca làm việc` should use a table on the left and an edit form on the right.

