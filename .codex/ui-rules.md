
# User Interface Standards

## Design Philosophy

Phần mềm chấm công là ứng dụng nghiệp vụ.

Ưu tiên:

* Đơn giản
* Rõ ràng
* Dễ đọc
* Dễ nhập liệu
* Tối ưu cho nhân sự và kế toán

Không sử dụng quá nhiều màu sắc

## Color Palette

Use the Material Dashboard foundation colors from:

```text
public/documentation/foundation/colors.html
```

### Template Semantic Colors

These are the default colors for Bootstrap/Material Dashboard utility classes and should be preferred over custom hex values:

* Primary: `#e91e63`
  * Use with `text-primary`, `bg-primary`, `bg-gradient-primary`, `badge bg-gradient-primary`, `shadow-primary`.
  * Best for important template accents, selected states, and standout positive actions.
* Secondary: `#7b809a`
  * Use with `text-secondary`, `bg-secondary`, `bg-gradient-secondary`.
  * Best for muted labels, helper text, inactive states, and secondary badges.
* Info: `#03a9f4`
  * Use with `text-info`, `bg-info`, `bg-gradient-info`.
  * Best for notices, informational badges, and non-critical guidance.
* Success: `#4caf50`
  * Use with `text-success`, `bg-success`, `bg-gradient-success`.
  * Best for active, completed, connected, approved, or valid states.
* Danger: `#f44335`
  * Use with `text-danger`, `bg-danger`, `bg-gradient-danger`.
  * Best for errors, destructive actions, failed checks, or blocked states.
* Warning: `#fb8c00`
  * Use with `text-warning`, `bg-warning`, `bg-gradient-warning`.
  * Best for pending, attention-needed, warning, or review states.

### Template Neutral Colors

Use the documented gray scale for backgrounds, borders, dividers, muted text, and table structure:

* Gray 100: `#f8f9fa`
* Gray 200: `#e9ecef`
* Gray 300: `#dee2e6`
* Gray 400: `#ced4da`
* Gray 500: `#adb5bd`
* Gray 600: `#6c757d`
* Gray 700: `#495057`
* Gray 800: `#343a40`
* Gray 900: `#212529`

### Project Usage Mapping

* Page background: prefer `#f8f9fa` / `bg-gray-100` where available.
* Card background: `#ffffff` via `card` defaults.
* Border/divider: prefer `#dee2e6` or Bootstrap border utilities.
* Input border: prefer `#ced4da` or the existing project-wide form override.
* Primary body text: prefer `#212529` or template text defaults.
* Secondary/helper text: prefer `text-secondary` / `#7b809a` before custom gray values.
* Dark navigation and dark buttons may continue to use Material Dashboard `#344767` through `bg-gradient-dark`, `text-dark`, or template defaults.
* Do not introduce new brand colors unless a feature has a clear business reason and no documented semantic color fits.

## Forbidden

Không sử dụng:

* Màu neon
* Custom gradient outside the Material Dashboard `bg-gradient-*` utilities
* Shadow đậm
* Nhiều hơn 6 màu chính trên cùng màn hình

## Visual System

Use the existing Material Dashboard 2 Pro / Bootstrap visual language.

## Design Tokens

Use these values as the default UI contract unless an existing template component already defines a stronger local style.

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

### Switch Controls

* Use `form-check form-switch` for on/off controls.
* Switches use the global `public/assets/css/tmt-ui.css` override:
  * Off state: Secondary `#7b809a`.
  * On state: Primary `#e91e63`.
  * Focus ring: Primary with low opacity.
* Do not add inline colors or one-off classes for switch on/off states.
* For mutually exclusive switch-like choices, use radio inputs styled with `form-check form-switch`, the same `name`, and distinct `value` attributes.

### Tables

* Use compact Material Dashboard tables.
* Header cells should use `text-uppercase text-secondary text-xxs font-weight-bolder opacity-7`.
* Row avatar initials should use `avatar avatar-sm bg-gradient-*`.
* Status values should use badges, not raw colored text.
* Last column is usually actions; keep actions centered when there are multiple buttons.

### Icons

Use the Material Dashboard icon guidance from:

```text
public/documentation/foundation/icons.html
```

* Prefer Google Material Design icons for app UI, because the dashboard examples use them by default.
* Use the consistent `<i>` element pattern shown in the docs:
  * Material Icons: `<i class="material-icons">face</i>`.
  * Material Icons Round: `<i class="material-icons-round">add</i>` when the surrounding template already uses the round set.
* Use Material icons for form actions, table actions, navigation actions, status hints, and compact command buttons.
* Use Font Awesome only when a needed icon is not available in Material Icons or the page already uses Font Awesome in that component area.
  * Font Awesome markup should follow the documented pattern, for example `<i class="fas fa-heart"></i>`.
  * Do not add a new Font Awesome stylesheet or script unless the layout does not already load it.
* Use Nucleo icons only where the existing Material Dashboard sidebar/template section already uses Nucleo classes such as `ni ni-*`.
* Avoid Bootstrap Glyphicons for new UI unless maintaining legacy markup that already uses them.
* Do not mix unrelated icon styles in the same component area. A toolbar, menu, table action group, or status row should use one icon family.
* Icon-only controls need a `title`, tooltip, or accessible label. Prefer icon + short text for primary actions.

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

* Use the palette above as the default color contract.
* Use `card`, `table-responsive`, and `table align-items-center mb-0` for standard content blocks.
* Use `badge`, `badge-sm`, `badge-dot`, and `bg-gradient-*` for status and emphasis.
* Use `nav nav-pills nav-fill p-1` for grouped settings.
* Use `form-check form-switch` for on/off settings and rely on the global switch colors.
* Use Material icons where the template already uses them.

## Table Reference

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
