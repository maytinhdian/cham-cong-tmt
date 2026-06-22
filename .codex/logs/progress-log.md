# Progress Log

This file is the working memory for the HR and time attendance build. Read it before changing HR, attendance, schedule, device, payroll, or report features.

## Correct Business Flow

The agreed flow should stay in this order unless the user explicitly changes it:

1. Data foundation
   Departments, positions, employees, shifts.
2. Scheduling
   Weekend rules, holidays, employee shift assignment, weekly/monthly work calendar.
3. Attendance devices
   Device list, connection data, device status, employee sync, raw log sync.
4. Attendance processing
   Match raw logs to shifts, detect late/early/missing logs, calculate OT, leave, holidays, weekends.
5. Timesheet
   Daily timesheet, monthly timesheet, manual adjustments, closing/locking timesheets.
6. Reports
   Late/early reports, missing log reports, OT reports, monthly attendance summaries.

## Timesheet Detailed Flow

After attendance processing has produced `daily_attendance_results`, continue in this order:

1. Daily timesheet review
   Show processed daily attendance by employee/date, including clock-in, clock-out, work minutes, late minutes, early-leave minutes, overtime minutes, missing logs, and status.
2. Timesheet adjustment
   Allow authorized users to correct daily attendance results, record adjustment reason, and preserve audit history of old/new values.
3. Monthly timesheet
   Aggregate daily results by employee/month, department, and status for payroll-ready review.
4. Timesheet closing
   Lock approved monthly timesheets by period/department so later changes require unlock or adjustment workflow.

## Flow Correction

On 2026-06-19, we noticed the work drifted too quickly into scheduling/holiday backend before finishing device logs and attendance processing.

The existing scheduling and holiday work is still useful foundation, but do not keep expanding it blindly. Before the next major feature, realign with the flow above.

Recommended next feature after this note:

- Attendance devices and raw attendance logs.

## Completed Implementation Log

- Created `.codex` project guidance files and root `AGENTS.md`.
- Added modular backend direction with PSR-4 namespace `Modules\\`.
- Scaffolded modules: `User`, `Org`, `Shift`, `Schedule`, and partial `Attendance`.
- Created real tables/models/seeders for departments, positions, employees, and shifts.
- Connected real employee list data.
- Connected real department management data.
- Connected real position management data.
- Connected new employee form to real `employees` table.
- Added employee list filters, quick edit, and soft delete.
- Added employee detail page.
- Added employee schedule foundation:
  - `employee_schedules` table.
  - `Modules/Schedule` model, DTO, service, and action.
  - Work schedule page under attendance settings.
- Added weekend and holiday foundation:
  - `weekend_settings` table.
  - `holiday_calendars` table.
  - Weekend/holiday models, DTO, service, and actions.
  - Upgraded weekend definition page to real data.
- Added attendance device foundation:
  - `attendance_devices` table normalization.
  - `Modules/Device` model, DTO, service, and create/update actions.
  - Real device management page with create, edit, soft delete, simulated connection check, and simulated sync timestamp.
- Added raw attendance log foundation:
  - `raw_attendance_logs` table.
  - `Modules/Attendance` raw log model, DTO, service, and save action.
  - Real raw log page with manual entry, date/device/employee/status filters, ignore, and delete.
- Added shift break and shift rule foundation:
  - `shift_breaks` table.
  - `shift_rules` table.
  - `Modules/Shift` break and rule models, DTOs, services, and seeded records.
- Added attendance engine log filtering and pairing:
  - `Modules/Attendance/Engines/LogFilter`.
  - `Modules/Attendance/Engines/LogPairing`.
  - `Modules/Attendance/DTOs/LogPairingResult`.
- Added attendance day context handling:
  - `Modules/Attendance/DTOs/AttendanceDayContext`.
  - `Modules/Attendance/Services/AttendanceDayResolver`.
  - Weekend and holiday statuses in attendance processing and daily timesheet UI.
- Added leave handling foundation:
  - `approved_leaves` table.
  - `Modules/Leave` approved leave model, DTO, service, and save action.
  - Employee-specific leave day detection in attendance processing.
  - `leave` status in attendance processing and timesheet screens.
- Added detailed attendance value calculation:
  - `BreakCalculator` to deduct configured shift breaks from gross work minutes.
  - `AttendanceCalculator` to convert work minutes into payable attendance value.
  - Shared attendance-value and break-minute storage on daily attendance results.
  - Daily timesheet review and log processing screens now show break minutes and attendance value.
- Added device user mapping foundation:
  - `attendance_device_user_maps` table.
  - `Modules/Device` mapping model, DTO, service, and save action.
  - Real mapping page with create, edit, delete, filters, and apply-to-raw-logs action.
- Added reusable Core module foundation:
  - `activity_logs` table.
  - `Modules/Core` DTO, model, event, service, and subscriber for shared activity/audit logging.
  - Registered Core activity subscriber in Laravel's event provider.
- Added daily timesheet review foundation:
  - Daily timesheet service based on `daily_attendance_results`.
  - Daily timesheet Livewire page with date, department, employee, and status filters.
  - New sidebar menu `Bảng công` with `Bảng công ngày`.
- Added daily timesheet adjustment foundation:
  - `daily_timesheet_adjustments` table for manual correction history.
  - Adjustment DTO, model, service, and action under `Modules/Attendance`.
  - Daily timesheet UI can open an adjustment form for one row, update clock-in/out, require a reason, and write Core `activity_logs`.
- Added persistent attendance rule settings:
  - `attendance_rules` table for global calculation/settings key-value rules.
  - `Modules/Attendance` rule model, DTO, service, and save action.
  - Attendance settings page now loads saved values, validates inputs, saves rule changes, and syncs selected weekend days.
- Fixed shift status refresh on the shift definition table:
  - Added a table refresh key so Livewire rebuilds the table after status-changing actions.
  - Keyed shift rows and status cells by `shift_id`, `status`, and refresh key.
  - Kept the table as badge-only for status display.
  - Status changes are handled from the edit form and reflected back into the table.
- Changed shift punch requirement configuration:
  - Replaced separate required-in/required-out switches with one business mode selector.
  - Modes are `Bắt buộc đủ vào và ra`, `Chỉ cần một lần chấm`, and `Không yêu cầu chấm công`.
  - Attendance processing treats the one-punch mode as valid when either clock-in or clock-out exists.
- Added overnight shift guidance:
  - Shift definition form now shows a note when `Giờ ra` is less than or equal to `Giờ vào`.
  - Shift table marks overnight shifts with a `Qua đêm` badge.
- Renamed shift break labels from lunch-specific wording to `Nghỉ giữa ca` so the form fits both day and night shifts.
- Changed shift time inputs to bundled Flatpickr time pickers using 24-hour `HH:mm` values in five-minute intervals so users can choose times from a UI control without AM/PM browser rendering.
- Added per-shift overtime policy settings:
  - Shift definitions now store whether overtime before the shift is allowed.
  - Shift definitions now store how many minutes after shift end must pass before after-shift overtime is counted.
  - Attendance overtime calculation now includes enabled before-shift overtime and applies the per-shift after-shift threshold.
  - Shift log filtering now keeps early punches when before-shift overtime is enabled.
- Updated the shift definition overtime UI:
  - Overtime before shift and overtime after shift now use matching switch rows.
  - Each switch reveals a compact minute input labeled `Phút` only when enabled.
  - Shift records now store a before-shift overtime minute threshold and an explicit after-shift overtime enabled flag.
  - Attendance overtime calculation respects the new before/after switch states and minute thresholds.
- Updated the shift punch requirement UI:
  - Replaced the dropdown with a grouped switch-style radio set.
  - The three modes remain mutually exclusive: full in/out, one punch, or no punch requirement.
- Refined the shift overtime UI by grouping the before/after overtime switches inside a titled bordered section.
- Grouped the shift name, code, main in/out times, and middle-break fields into titled bordered sections in the shift form.
- Grouped punch windows, late/early thresholds, workday value, and standard minutes into a `Quy tắc xác định công` section.
- Grouped display color, description, and status into a `Hiển thị và trạng thái` section.
- Updated `.codex/ui-rules.md` so the project color contract follows the Material Dashboard foundation colors page.
- Added global switch color overrides:
  - Switch off state uses Material Dashboard Secondary `#7b809a`.
  - Switch on and focus states use Material Dashboard Primary `#e91e63`.
  - `.codex/ui-rules.md` now documents this as the required switch control standard.
- Updated `.codex/ui-rules.md` icon guidance from the Material Dashboard foundation icons page.
- Added an optional per-shift rule to count deducted middle-break minutes as overtime:
  - Shift definitions now store `break_as_overtime_enabled`.
  - The shift form shows `Tính nghỉ giữa ca là tăng ca` in the middle-break section.
  - Attendance processing and manual daily adjustments add break minutes to OT when the rule is enabled.
- Updated work schedule color display:
  - The schedule grid now renders assigned shifts with the saved `shifts.display_color`.
  - The declared schedule list now shows the shift badge with the same saved shift color.
  - Schedules without an assigned shift keep the template secondary badge fallback.
- Updated quick schedule assignment:
  - The quick assignment form can apply a schedule to an entire department.
  - The same form can assign schedules to multiple selected employees at once when no department is selected.
  - Assignment now supports a start and end date, creating or updating one `employee_schedules` row per employee per day.
  - After assignment, the schedule grid filter follows the assigned date range and selected department when applicable.
- Added a collapsible shift reference list on the work schedule page:
  - The left scheduling panel now has a `Danh sách ca làm việc` accordion.
  - Each shift reference shows code, configured display color, name, work time, and break minutes.
- Reduced visual clutter on the work schedule page:
  - `Phân ca nhanh` now uses a collapsed accordion by default.
  - The schedule grid filters and calendar grid remain visible as the primary working area.
  - `Danh sách lịch đã khai báo` now uses a collapsed accordion by default.
- Reworked the work schedule page layout after UI review:
  - `Phân ca nhanh` and `Danh sách ca làm việc` now display side by side in two columns.
  - The shift reference list is visible by default and no longer uses collapse.
  - The department/date filters moved down to the `Danh sách lịch đã khai báo` section.
  - The declared schedule list is visible by default so filtered results are easier to read.
- Limited the default declared schedule list length:
  - The `Danh sách lịch đã khai báo` table now shows the first 10 rows by default.
  - Additional filtered rows are placed in a Bootstrap collapse opened by a `Xem thêm` button.
- Updated the main work schedule grid to a monthly calendar-style matrix:
  - The grid now shows every day in the selected month instead of a capped day range.
  - The employee column keeps the avatar, employee name, and department style.
  - Each day column shows weekday and day-of-month in the header.
  - Shift codes render as wider bottom-aligned calendar bars using the shift display color and 97% of the actual cell width.
  - Each employee/day cell also shows the day number inside the calendar cell.
  - The monthly grid header now shows full Vietnamese weekday names only.
  - Weekday names use a lighter variant of the Material Dashboard Primary color.
  - The monthly grid filter now includes department selection, previous/next month controls, and a current-month shortcut.
  - The employee column header now includes an A-Z/Z-A sort toggle for the monthly grid.
  - Weekend cells in the monthly grid now receive a visible configurable background based on the saved weekend color rule.

## Documentation Rule For Code Changes

From this point forward:

- Any new function/method must include a short PHPDoc description.
- Any edited function/method should receive a short PHPDoc description if it does not already have one.
- The description should explain the method's business purpose, not restate the code line by line.
- Livewire action methods should describe the user action they perform.
- Service/action methods should describe the business operation they execute.

## UI Consistency Rule

Before creating or changing screens, read `.codex/ui-rules.md`.

Important UI constraints:

- Reuse Material Dashboard 2 Pro / Bootstrap classes.
- Use the documented colors, border radius, shadows, buttons, forms, and tables from `.codex/ui-rules.md`.
- Do not invent a new visual style for each screen.
- Keep Vietnamese UI text UTF-8 and consistent.

## Current Data Notes

- Current employee seed/user data includes `EMP-001` to `EMP-004`.
- A real extra employee `EMP-05: Lê Thanh Nhã` exists and should not be deleted automatically.
- Weekend settings currently default to `Thứ 7, Chủ nhật`.
- Holiday calendar is currently empty after test cleanup.
- Employee schedules table is currently empty after test cleanup.
