# UI Rules

# UI_RULES.md

# User Interface Standards

## Design Philosophy

Phần mềm chấm công là ứng dụng nghiệp vụ.

Ưu tiên:

* Đơn giản
* Rõ ràng
* Dễ đọc
* Dễ nhập liệu
* Tối ưu cho nhân sự và kế toán

Không sử dụng quá nhiều màu sắc.

---

# Color Palette

## Primary

Màu thương hiệu.

```css
#2563EB
```

Sử dụng cho:

* Menu đang chọn
* Nút chính
* Link
* Tab đang active

---

## Success

```css
#16A34A
```

Sử dụng cho:

* Đúng giờ
* Hoàn thành
* Đã duyệt
* Hoạt động

---

## Warning

```css
#F59E0B
```

Sử dụng cho:

* Đi trễ
* Chờ duyệt
* Sắp hết hạn

---

## Danger

```css
#DC2626
```

Sử dụng cho:

* Nghỉ không phép
* Lỗi
* Xóa dữ liệu
* Khóa tài khoản

---

## Info

```css
#0891B2
```

Sử dụng cho:

* Thông báo
* Ghi chú
* Hướng dẫn

---

# Neutral Colors

## Background

```css
#F8FAFC
```

## Card

```css
#FFFFFF
```

## Border

```css
#E5E7EB
```

## Text Primary

```css
#111827
```

## Text Secondary

```css
#6B7280
```

---

# Attendance Status Colors

## Đúng giờ

Green

```css
#16A34A
```

---

## Đi trễ

Orange

```css
#F59E0B
```

---

## Về sớm

Yellow

```css
#EAB308
```

---

## Thiếu công

Red

```css
#DC2626
```

---

## Nghỉ phép

Blue

```css
#2563EB
```

---

## Nghỉ lễ

Purple

```css
#7C3AED
```

---

# Buttons

## Primary Button

Background

```css
#2563EB
```

Text

```css
#FFFFFF
```

---

## Secondary Button

Background

```css
#FFFFFF
```

Border

```css
#D1D5DB
```

---

## Danger Button

Background

```css
#DC2626
```

Text

```css
#FFFFFF
```

---

# Tables

## Header

```css
#F3F4F6
```

## Row Hover

```css
#F9FAFB
```

## Alternate Row

```css
#FCFCFC
```

---

# Dashboard Cards

## Nhân viên

Blue

```css
#2563EB
```

## Chấm công

Green

```css
#16A34A
```

## Tăng ca

Orange

```css
#F59E0B
```

## Nghỉ phép

Purple

```css
#7C3AED
```

---

## Forbidden

Không sử dụng:

* Màu neon
* Gradient
* Shadow đậm
* Nhiều hơn 6 màu chính trên cùng màn hình

Ưu tiên giao diện giống:

* ERPNext
* Odoo
* HRM phổ thông
* Dashboard quản trị doanh nghiệp

## Visual System

Use the existing Material Dashboard 2 Pro / Bootstrap visual language.

## Design Tokens

Use these values as the default UI contract unless an existing template component already defines a stronger local style.

### Colors

* Primary action: `bg-gradient-dark` for main save/create buttons.
* Secondary action: `btn-outline-secondary` or `bg-gradient-light`.
* Positive state: `bg-gradient-success`.
* Informational state: `bg-gradient-info`.
* Warning state: `bg-gradient-warning`.
* Error/destructive state: `text-danger`, `bg-gradient-danger`, or `btn-outline-danger`.
* Neutral text: `text-secondary`, `text-muted`, `text-dark`.
* Page background: prefer `bg-gray-100` or `bg-gray-200` only when the surrounding layout already uses it.
* Do not introduce random brand colors per page. Reuse template gradients first.

### Border Radius

* Cards: use template `card` defaults; when explicit radius is needed use `border-radius-lg` or `border-radius-xl`.
* Buttons: keep default Material Dashboard button radius.
* Badges: use template `badge` / `badge-sm`; do not make custom pill shapes unless matching existing badge styles.
* Form inputs: use Bootstrap/Material Dashboard default `form-control` with the project-wide light border `1px solid #D1D5DB` and `6px` border radius.
* Legacy device-style layouts are allowed only when the user explicitly asks for that look.

### Shadows

* Main cards: rely on `card` default shadow.
* Highlighted floating cards or hero stat cards: use `shadow`, `shadow-dark`, `shadow-primary`, or existing template shadow utilities.
* Avoid stacking multiple shadows on the same element.
* Do not use harsh custom box-shadow values unless matching a referenced template page.

### Spacing

* Page wrapper: `container-fluid py-4`.
* Main card header: `card-header pb-0` or `card-header pb-0 p-3`.
* Main card body: `card-body`, `card-body p-3`, or `card-body pt-0`.
* Grid spacing: prefer Bootstrap rows/columns with `mt-3`, `mt-4`, `mb-0`, `gap-2`, `gap-3`.
* Avoid one-off inline spacing unless necessary for an existing template pattern.

### Buttons

* Primary create/save/update: `btn bg-gradient-dark mb-0`.
* Important positive action: `btn bg-gradient-primary mb-0` only when it must stand out from regular save.
* Cancel/back: `btn btn-outline-secondary mb-0` or `btn bg-gradient-light mb-0`.
* Destructive inline action: `btn btn-link text-danger font-weight-bold text-xs mb-0 p-0`.
* Table inline actions: use text/link-style buttons to keep table compact.
* Icon-only add buttons should use Material icons, usually `add`, inside the existing button class.

### Forms

* Labels: `form-label`.
* Inputs: `form-control`.
* Selects: `form-control` unless the template page already uses Choices.js.
* All text inputs, selects, and textareas should keep a light border `1px solid #D1D5DB` and subtle `6px` radius through the global `public/assets/css/tmt-ui.css` override.
* Validation text: `text-danger text-xs mt-1 mb-0`.
* Required marker: `<span class="text-danger">*</span>`.
* Keep forms in cards and group fields with rows/columns.

### Tables

* Use compact Material Dashboard tables.
* Header cells should use `text-uppercase text-secondary text-xxs font-weight-bolder opacity-7`.
* Row avatar initials should use `avatar avatar-sm bg-gradient-*`.
* Status values should use badges, not raw colored text.
* Last column is usually actions; keep actions centered when there are multiple buttons.

### Icons

* Prefer Material icons with `material-icons` or `material-icons-round`.
* Use Nucleo icons only where the existing sidebar/template section already uses them.
* Do not mix unrelated icon styles in the same component area.

### Vietnamese UI Text

* Keep labels short and clear.
* Avoid mojibake. Save edited Blade/PHP/Markdown files as UTF-8.
* Prefer consistent terms:
  * `Nhân viên`
  * `Phòng ban`
  * `Chức vụ`
  * `Ca làm`
  * `Lịch làm việc`
  * `Thiết bị chấm công`
  * `Log chấm công`
  * `Bảng công`
  * `Chốt công`

Prefer:

* `card`
* `table-responsive`
* `table align-items-center mb-0`
* `text-uppercase text-secondary text-xxs font-weight-bolder opacity-7` for table headers
* `badge`, `badge-sm`, `badge-dot`, `bg-gradient-*`
* `nav nav-pills nav-fill p-1` for grouped settings
* `form-check form-switch` for on/off settings
* Material icons where the template already uses them

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

* `Quy tắc tính công`
* `Khai báo ca làm việc`
* `Khai báo ngày cuối tuần`
* `Kí hiệu thống kê`

`Quy tắc tính công` should use nav-pills style groups:

* `Công chuẩn`
* `Trễ / sớm`
* `Tăng ca`
* `Nghỉ phép`
* `Khóa công`

`Khai báo ca làm việc` should use a table on the left and an edit form on the right.
