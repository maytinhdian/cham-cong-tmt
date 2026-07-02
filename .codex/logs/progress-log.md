# Progress Log

This file is the working memory for the HR and time attendance build. Read it before changing HR, attendance, schedule, device, payroll, or report features.

## 2026-07-03 Device Command Tester

- Added `/pages/attendance/device-command-tester` as an authenticated operator page for testing ZKTeco PUSH commands against configured attendance devices.
- The page lets authorized users queue `DATA QUERY ATTLOG` by start/end time, queue `LOG`, queue `CHECK`, or send a controlled custom PUSH command/payload.
- Expanded the tester with documented presets for `RELOAD OPTIONS`, `SET OPTION`, `DATA QUERY BIODATA`, `DATA DELETE USERINFO`, `DATA DELETE BIODATA`, and `CLEAR BIODATA`.
- Added a visible list of destructive/delete-capable commands on the tester page and require the operator to type `XOA` before queueing those commands.
- Added multi-select cleanup for recent test commands so operators can delete selected pending commands or old command-history rows from the tester.
- Scoped the recent-command row checkboxes to a native CSS checkmark so they no longer depend on the remote Font Awesome font used by the Material Dashboard checkbox style.
- Added live polling panels for selected-device pending commands, today's received PUSH logs, recent queued commands, and recent imported raw logs.
- Added `AttendanceDeviceCommandService::queueAttendanceLogQuery()` and `queueCheckSync()` helpers so range sync and CHECK commands stay in the shared PUSH command queue.
- Added command service helpers for reload options, set option, BIODATA query, user deletion, BIODATA deletion, and BIODATA clearing.
- Added the page to the `Thiết bị chấm công` sidebar group as `Test liên kết`.
- Added feature coverage for dispatching a queued `DATA QUERY ATTLOG StartTime=...\tEndTime=...` command and destructive delete commands through `/iclock/getrequest`.
- Verified PHP syntax, Blade compilation, route registration, and the ZKTeco PUSH feature tests.

## 2026-07-02 Employee Create Account Wizard

- Wired the `/pages/users/new-user` wizard account step into the existing `EmployeeAccountService`.
- Added an authorization-aware option to create a login account while creating a new employee profile.
- Users with `authorization.manage` can enable account creation, choose a role, and enter the initial password.
- Account provisioning uses the employee code as username and links the created `users` row back to `employees.user_id`.
- Added a numeric `Mã chấm công` field to the new employee wizard and quick form.
- When a new employee has a `Mã chấm công`, the app creates `attendance_device_user_maps` rows for every attendance device and applies those mappings to existing unmapped raw logs.
- Kept the login provisioning step focused on role and initial password only; the switch now reveals those fields client-side so the wizard stays on the account step instead of resetting to step one.
- Kept users without `authorization.manage` able to create the employee profile without account provisioning.
- Updated the new employee wizard layout, full-width forms, icon-only wizard navigation, and scoped CSS for wizard panel height.
- Verified PHP syntax and Blade compilation.

## 2026-07-02 Position Department Tag Filter

- Restyled the `/pages/employees/positions` department filter as tag-like chips inspired by Creative Tim's tags plugin.
- Kept the existing single-department Livewire filtering behavior unchanged.
- Added employee counts to each department chip.
- Added scoped CSS in `public/assets/css/tmt-ui.css` for the position department tag filter.
- Verified PHP syntax, Blade compilation, route registration, and the existing ZKTeco PUSH feature test file.

## 2026-07-02 Position Create/Edit/Delete Form

- Added a real create/edit position form to `/pages/employees/positions`.
- Wired the existing Org position DTO, action, and service into the Livewire position management page.
- Added validation for position code, name, level, sort order, status, and description.
- Added action-level `employees.manage` authorization for position save/edit/delete and employee assignment changes.
- Added Core activity logging for position create, update, and delete actions.
- Added a guarded delete action to the position table; positions with assigned employees cannot be deleted.
- Updated the position table edit button to load records into the form.
- Added required PHPDoc blocks to touched Org position DTO/action/service methods.
- Verified PHP syntax, Blade compilation, route registration, and the existing ZKTeco PUSH feature test file.

## 2026-07-02 Department Delete Guard

- Added a delete action to the department management table.
- Department deletion is allowed only when the department has no employees.
- The delete action is also blocked when the department has child departments, preventing orphaned organization rows.
- Added user-facing error messages when deletion is blocked.
- Added Core activity logging for successful department deletion.
- Verified PHP syntax, Blade compilation, and the existing ZKTeco PUSH feature test file.

## 2026-07-02 Department Create/Edit Form

- Added a real create/edit department form to `/pages/employees/departments`.
- Wired the existing Org module DTO, action, and service into the Livewire department management page.
- Added validation for department code, name, parent department, contact fields, sort order, status, and description.
- Added action-level `employees.manage` authorization for department save/edit and employee assignment changes.
- Added Core activity logging for department create and update actions.
- Updated the department table edit button to load records into the form.
- Added required PHPDoc blocks to touched Org department DTO/action/service methods.
- Verified PHP syntax, Blade compilation, and the existing ZKTeco PUSH feature test file.

## 2026-07-02 Raw Attendance Log Cleanup

- Cleared all existing rows from `raw_attendance_logs` after the user requested deleting old logs.
- Deleted 123 raw attendance log rows.
- Kept attendance devices, device-user mappings, queued device commands, processed attendance data, and system activity logs unchanged.

## 2026-07-02 Raw Log Auto Refresh

- Added Livewire polling to the PUSH receiver page so new device logs appear without manually refreshing the browser.
- Added the same polling behavior to the raw attendance log page.
- Both pages now refresh their Livewire data every 5 seconds while open.
- Verified Blade compilation and existing ZKTeco PUSH protocol tests.

## 2026-07-02 PUSH Receiver Page

- Added a separate Livewire page at `/pages/attendance/push-receiver` for monitoring ZKTeco PUSH data reception.
- The page shows ADMS/PUSH endpoint URLs, online devices based on recent `/iclock/*` calls, today's received `zkteco_push` raw logs, pending commands, recent logs, and recent command statuses.
- Added a device-level `LOG` queue action on the receiver page for users with `attendance.devices.manage`.
- Protected the page with the existing `attendance.raw_logs.view` permission.
- Added the page to the `Thiết bị chấm công` sidebar group as `Nhận dữ liệu PUSH`.
- Documented the operator page in `.codex/docs/devices/zkteco-push-api-reference.md`.

## 2026-07-02 PUSH Device Connection Check

- Reviewed the attendance device connection flow after the real ZKTeco test.
- Confirmed the physical device at `192.168.1.92` currently has TCP port `80` and ZK protocol port `4370` open, while port `8081` is closed.
- Kept production device operations aligned with the existing ZKTeco PUSH/ADMS flow instead of direct socket checks.
- Updated the device page connection check so a device is considered online only when it has called the Laravel server through `/iclock/*` in the last 15 minutes.
- Updated online/offline counts, status filtering, and row badges to use recent `last_connected_at` heartbeat/PUSH activity.
- Stopped failed connection checks from overwriting `last_connected_at` with the current time.
- Updated device page guidance to explain that ZKTeco PUSH devices should use serial `SN` as the device code and must point ADMS/PUSH to the Laravel server.
- Verified PHP syntax, Blade compilation, and the existing ZKTeco PUSH feature tests.

## 2026-07-02 ZKTeco Initialization Documentation

- Read the attached notes about `Initialize Information Interaction` for ZKTeco PUSH.
- Confirmed the key point that the device initiates the first connection with `GET /iclock/cdata?SN=...&options=all&pushver=...`.
- Added a registration-flow note to `.codex/docs/devices/zkteco-push-api-reference.md`.
- Clarified in `.codex/docs/devices/zkteco-push-summary.md` that TMT currently follows the attendance PUSH subset by auto-creating unknown serial numbers and returning options immediately.

## 2026-07-01 Real ZKTeco Device Test

- Tested the real attendance device at `192.168.1.92`.
- Confirmed network reachability and open ports:
  - HTTP web UI on port `80`, redirecting to `/csl/login`.
  - ZK device protocol on port `4370`.
  - Previously saved port `8081` did not respond.
- Connected through the ZK protocol and read device information:
  - Serial: `0068143300011`.
  - Device name/model: `210 PLUS`.
  - Platform: `ZMM220_TFT`.
  - Firmware: `Ver 6.60 May 14 2018`.
  - Device clock reported `2024-05-03 13:18:21`.
- Updated the existing `Bảo Vệ` attendance device record to use code/serial `0068143300011`, IP `192.168.1.92`, and port `4370`.
- Read 280 device users and 110 attendance logs from the device.
- Imported the 110 logs through the existing local PUSH endpoint `/iclock/cdata?SN=0068143300011&table=ATTLOG`, so the normal parser/import service handled persistence.
- Verified the imported raw logs are stored as `zkteco_push`, pending processing, with timestamps from `2024-05-02 11:35:48` through `2024-05-03 08:04:30`.
- Queued a `LOG` command for the device. It remains pending until the physical device polls `/iclock/getrequest` through PUSH/ADMS.
- Reconnected to the same device and confirmed the device clock was corrected to `2026-07-01`.
- Deleted all users from the physical device through the ZK protocol on port `4370` after the user explicitly requested deletion without backup.
- Verified the device user count is now `0`.
- Verified attendance logs were not cleared; the device still reports `111` attendance log rows after the user deletion.
- Realigned the implementation direction back to PUSH-only device operations after user feedback.
- Updated `AttendanceDeviceCommandService` so queued commands can include arbitrary PUSH command text and payload instead of only returning bare commands such as `LOG`.
- Added a `queueDeleteAllUsers()` service method for the PUSH command `DATA DELETE USERINFO`, to be dispatched only through `/iclock/getrequest` when the device polls the Laravel server.

## 2026-06-30 Role Permission Switch Controls

- Updated the shared role permission matrix partial so each permission is selected with a Material Dashboard `form-switch` on/off control.
- Kept the existing Livewire `selectedPermissions` binding and module-level select/clear actions unchanged.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 Role List DataTable Pagination Style

- Read the `/applications/datatables` demo implementation and reused its `dataTable-wrapper`, `dataTable-top`, `dataTable-selector`, `dataTable-input`, `dataTable-bottom`, and `dataTable-pagination` class structure.
- Added a reusable Livewire pagination view at `resources/views/components/datatable-pagination.blade.php`.
- Updated the role list page to keep server-side Livewire search/sort/pagination while matching the Material Dashboard DataTables pagination UI.
- Documented the DataTables-style pagination standard in `.codex/ui-rules.md` for future table screens.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 Shift Definition Action Icons

- Updated the shift definition table action column to use icon-only Material Icons controls.
- Added a `visibility` detail action before the edit and delete actions.
- Kept the existing shift selection/edit Livewire flow and added hover/accessibility labels for the action buttons.
- Documented the standard view/edit/delete icon-only action cluster in `.codex/ui-rules.md`.
- Matched the footer `Hủy` and save/update buttons to the same minimum width for a steadier form layout.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 Weekend Definition Switch Controls

- Replaced the weekend weekday checkbox controls with Material Dashboard `form-check form-switch` controls.
- Replaced the holiday paid checkbox with a `form-switch` control.
- Kept the existing Livewire models for `weekendDays` and `isPaid`.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 User Management Action Icons

- Updated the user management table action column to follow the standard detail/edit/delete icon-only cluster.
- Added a temporary detail action using `visibility` that links to the existing edit user route until a dedicated detail route exists.
- Added hover and accessibility labels for the action buttons.
- Updated `.codex/ui-rules.md` so standard detail/edit/delete action icons use the default Material Icons size instead of `text-sm`.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 Employee List Action Icons

- Updated the employee list action column to follow the standard detail/edit/delete icon-only cluster.
- Kept the real employee detail route for the `visibility` action and existing Livewire edit/delete actions.
- Added hover and accessibility labels for the employee action buttons.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-07-01 Business Table Action Icon Sweep

- Applied icon-only action buttons across remaining business tables:
  - Attendance devices: connection check, sync, edit, delete.
  - Device user mappings: apply, edit, delete.
  - Raw attendance logs: ignore and delete.
  - Work schedules: delete.
  - Daily timesheet: adjustment.
  - Holiday calendar: delete.
  - Department and position setup: select/detail and edit placeholder actions.
  - Role list: detail/edit/delete.
- Kept existing Livewire methods and routes unchanged; detail placeholders continue to point at existing edit/detail flows where no dedicated detail route exists.
- Verified Blade compilation with `php artisan view:cache`.

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
- Strengthened monthly schedule weekend highlighting:
  - Weekend day headers now receive the same weekend classification as body cells.
  - Weekend columns now use a visible top border, stronger date label color, and a fallback weekend color/background when saved CSS variables are missing.
  - Weekend body cells now paint the inner cell area as well as the table cell so template table styles cannot visually hide the highlight.
- Stabilized the declared schedule list expansion:
  - The list now expands within the same table instead of rendering a second table below the first 10 rows.
  - The expansion button now toggles between `Xem thêm ... dòng` and `Thu gọn`.
  - Changing the declared schedule filters collapses the list back to the compact view.
- Finalized default overnight shift matching behavior:
  - Attendance processing now detects the previous day's overnight schedule when processing the next calendar date.
  - Next-day checkout punches that belong to the previous overnight shift are excluded from the next day's own pairing.
  - Added a feature test covering a 22:00-06:00 shift so the 06:00 checkout stays on the original work date.
- Wired additional attendance overtime rule consumption:
  - `AttendanceRuleContext` now carries the saved global before-shift and after-shift overtime cap settings.
  - `OvertimeCalculator` applies `limit_before_in_enabled` / `max_before_in_minutes` and `limit_after_out_enabled` / `max_after_out_minutes` before total overtime limits.
  - Added unit coverage for before-shift and after-shift global overtime caps.
- Fixed test database isolation:
  - `phpunit.xml` now runs tests against SQLite in-memory instead of the local MySQL database.
  - Restored the default login roles/users after the earlier feature test reset the local MySQL data.
  - Verified the ca-dem feature test no longer deletes local users after it runs.
- Added `two_day_shift_policy = second_day` support:
  - Attendance processing can now write an overnight shift result to the second calendar day when the saved rule is set to `second_day`.
  - Processing either the shift start date or the second date updates the same second-day daily result.
  - Daily result persistence now uses `whereDate()` before save so date matching is stable across MySQL and SQLite.
- Added monthly timesheet aggregation foundation:
  - Created `monthly_timesheets` table and `MonthlyTimesheet` model.
  - Added monthly aggregation service/action that summarizes `daily_attendance_results` by employee and month.
  - Added `Bảng công tháng` Livewire page, route, and sidebar entry with filters and a `Tổng hợp tháng` action.
  - Added feature coverage for monthly aggregation from daily attendance rows.

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

## 2026-06-22 Attendance Test Data Seeder

- Added `TestAttendanceDataSeeder` for six reusable employees, `TEST-001` to `TEST-006`.
- Seeded June 2026 office, 12-hour day, and 12-hour night-shift scenarios with complete, late, early, missing-log, absent, and overnight cases.
- The seeder clears its own generated schedules, raw logs, daily results, and monthly rows before rebuilding so it can be rerun safely.
- `two_day_shift_policy` now defaults to `second_day`, and the seeder persists that rule before processing overnight logs.
- Added migrations to make `raw_attendance_logs.punch_time` stable as `DATETIME`, preventing status updates from changing the original punch time.
- Verified the local database now has 6 test employees, 108 schedules, 210 raw logs, 126 daily results, and 6 June 2026 monthly timesheet rows.

## Current Test Data Notes

- Reusable attendance test data exists for `TEST-001` to `TEST-006`.
- Test raw logs cover `2026-06-01 07:00:00` through `2026-06-21 07:00:00`.
- Attendance rule `two_day_shift_policy` is currently set to `second_day`.

## 2026-06-22 ZKTeco PUSH Device Integration

- Read `Attendance PUSH Communication Protocol 20200801.pdf` and implemented the attendance-log path for ZKTeco PUSH devices.
- Added public `/iclock/cdata`, `/iclock/getrequest`, `/iclock/ping`, and `/iclock/devicecmd` endpoints.
- Initialization responds with `GET OPTION FROM`, `TransFlag=TransData AttLog`, timezone 7, and realtime ATTLOG upload enabled.
- `POST /iclock/cdata?table=ATTLOG` now parses pushed attendance lines and stores them in `raw_attendance_logs` with source `zkteco_push`.
- Device `SN` is matched to `attendance_devices.code`, and unknown serial numbers auto-create a ZKTeco device record.
- Active `attendance_device_user_maps` are applied during import so raw logs link to employees when mapped.
- Added `attendance_device_commands` to queue PUSH commands.
- The device page `Đồng bộ` action now queues a `LOG` command; the next `/iclock/getrequest` returns `C:<id>:LOG` so the device uploads new logs.
- `/iclock/devicecmd` records command acknowledgements.
- Added feature coverage for initialization, ATTLOG import, and queued LOG command dispatch.

## 2026-06-23 ZKTeco Device Documentation

- Read `.codex/docs/devices/zkteco-sdk.pdf`, the ZKTeco Attendance PUSH Communication Protocol document.
- Added `.codex/docs/devices/zkteco-push-summary.md` with the integration flow, attendance-log format, command priorities, and project scope notes.
- Added `.codex/docs/devices/zkteco-push-api-reference.md` with the important `/iclock/*` endpoints, request/response formats, ATTLOG body format, command formats, and return codes.
- Confirmed the documented API subset matches the existing Laravel routes for initialization, ATTLOG upload, command polling, heartbeat, and command acknowledgement.
- Recorded that the protocol supports server-mediated `BIODATA` synchronization between devices, but implementation is postponed until a real ZKTeco device is available for firmware/model testing.
- Reviewed the non-hardware ZKTeco flow and tightened queued command formatting so `/iclock/getrequest` returns protocol-style `C: <id>: LOG` with compact alphanumeric command IDs.

## 2026-06-23 Tabulator Demo

- Added a client-side Tabulator demo page under `pages/attendance/tabulator-demo`.
- The demo shows attendance-log-like sample data with add row, delete selected rows, clear, reset, search, copy JSON, CSV download, inline editing, row selection, header filters, and status badges.
- Added the demo route and sidebar entry under `Thiết bị chấm công`.

## 2026-06-25 Local Database Schema Sync

- Checked the local database with `php artisan migrate:status`.
- Found eight pending attendance/device/timesheet migrations on the local MySQL database.
- Ran `php artisan migrate` to add the missing schema pieces:
  - break and attendance value fields on `daily_attendance_results`.
  - `attendance_rules`.
  - overtime policy fields on `shifts`.
  - `monthly_timesheets`.
  - stable `DATETIME` handling for `raw_attendance_logs.punch_time`.
  - `attendance_device_commands`.
- Rechecked migration status and confirmed all migrations are now applied.

## 2026-06-27 Attendance Settings Tab Highlight

- Applied the Material Dashboard floating active-tab treatment to `pages/attendance/settings`.
- Added a scoped `attendance-settings-tabs` wrapper so the attendance rule tabs show a white raised active state like the profile overview tabs.
- Kept the styling in `public/assets/css/tmt-ui.css` so the fallback works even when the template moving-tab script has not initialized yet.
- Verified Blade compilation with `php artisan view:cache`.

## 2026-06-27 Attendance Settings Tab Motion

- Smoothed the `pages/attendance/settings` tab transition by removing the vertical active-link transform that made tabs feel jumpy.
- Added scoped moving-tab transition tuning in `public/assets/css/tmt-ui.css` using transform/width/height animation with `will-change`.
- Added `public/assets/js/tmt-ui.js` and loaded it after Material Dashboard so the attendance settings tabs resync their moving indicator on click, `shown.bs.tab`, Livewire navigation, and resize.
- Delayed the custom tab sync until after the template moving-tab initializer runs to avoid duplicate indicators.
- Verified Blade compilation with `php artisan view:cache`.
- Matched the Material Dashboard sample more closely by keeping the attendance settings nav in `flex-row` mode and using the template-like `0.5s ease` moving-tab transition.

## 2026-06-27 ZKTeco PUSH Version Diff

- Read the two new protocol PDFs:
  - `.codex/docs/devices/ZkTecoPUSH-Communication-Protocol-20200325.pdf`
  - `.codex/docs/devices/ZKTecoPUSH-Communication-Protocol-20240112.pdf`
- Extracted PDF text with `pypdf` for local review.
- Added `.codex/docs/devices/zkteco-push-version-diff.md` summarizing differences between the 2020 Attendance PUSH document and the 2024 Security PUSH document.
- Noted that the current TMT implementation follows the 2020 attendance-log subset, while the 2024 document adds a broader security/access-control flow with registry/session handling, `rtlog`, `tabledata`, `querydata`, channel controller, Wiegand 2.0, video intercom, and expanded event codes.
- Linked the version-diff note from `.codex/docs/devices/zkteco-push-summary.md`.

## 2026-06-30 Authorization & Roles Foundation

- Added Phase 6.5 to `.codex/roadmap.md` for authorization and roles before Reports.
- Added a module creation guide to `.codex/instructions.md`.
- Created `permissions` and `permission_role` tables for module/action permissions.
- Added `Modules/Core/Models/Permission` and `Modules/Core/Authorization/PermissionRegistry`.
- Added `AuthorizationSeeder` to seed default permissions and role-permission assignments.
- Expanded `RolesSeeder` with business roles: `Super Admin`, `HR Manager`, `HR Staff`, `Department Manager`, and `Employee`, while preserving template roles `Admin`, `Creator`, and `Member`.
- Updated `User` and `Role` models with permission relationships and permission-check helpers.
- Registered permission Gates in `AuthServiceProvider`; existing `Admin` and `Super Admin` roles bypass detailed permission checks.
- Protected HR, attendance, device, timesheet, report, and authorization routes with `can:*` middleware.
- Added Livewire action-level authorization checks to sensitive attendance/device/settings/schedule actions.
- Added Core activity logging for manual raw-log changes, raw-log processing, monthly timesheet generation, and attendance device operations.
- Ran `php artisan migrate --force`; this applied the new permission migration and also applied the previously pending `attendance_device_commands` migration.
- Ran `php artisan db:seed --class=AuthorizationSeeder --force`.
- Verified changed PHP files with `php -l`, rebuilt optimized autoload, and ran `php artisan view:cache`.

## 2026-06-30 Role Permission Matrix UI

- Reworked the role create page from a basic name/description form into a business permission matrix.
- Reworked the role edit page so Admin can assign permissions by grouped modules.
- Added grouped permission controls with module-level `Chọn nhóm` and `Bỏ chọn` actions.
- Added selected-permission count feedback on the role form.
- Updated the role list to show permission count and assigned-user count per role.
- Fixed role management authorization references to use the current `App\Models\User` class.
- Added action-level authorization checks to role create, edit, and delete actions.
- Verified the edited role PHP files with `php -l`.
- Verified Blade compilation with `php artisan view:cache`.
- Added a New Page Authorization Guide to `.codex/instructions.md` so future pages define permissions, route middleware, action authorization, and audit logging consistently.

## 2026-06-30 Employee Login Account Provisioning

- Added `users.username` so employees can log in with their employee code while existing email login still works.
- Updated the login form and Livewire login action to accept either email or employee code.
- Added `EmployeeAccountService` to create or update a Laravel user account linked to `employees.user_id`.
- Employee accounts use the employee code as `username` and default to the existing `Member` role unless a higher role is selected by an authorized user.
- Added a `Tài khoản đăng nhập` panel to the employee quick-edit form for authorized users with `authorization.manage`.
- The employee list now shows whether each employee already has a linked login account, plus username and role when available.
- Account provisioning writes a Core activity log entry with the linked user, username, and role.
- Ran the new username migration with `php artisan migrate --force`.
- Verified edited PHP files with `php -l`, rebuilt optimized autoload, compiled Blade views, and reran `MonthlyTimesheetServiceTest`.

## 2026-06-30 Employee Self-Service Profile

- Updated `/laravel-examples/user-profile` into a self-service profile page for any authenticated employee/user account.
- The page now shows username, role, employee code, department, and position when the account is linked to an employee.
- Users can update simple profile fields: name, email, phone, location, and avatar.
- Simple contact changes are mirrored back to the linked employee profile for name, email, and phone.
- Users can change their own password after entering the current password.
- Profile and password changes now write Core activity log entries.
- Added `User::employeeProfile()` to link a login account back to its employee profile.
- Verified edited PHP files with `php -l`, compiled Blade views, and reran `MonthlyTimesheetServiceTest`.

## 2026-06-30 Permission-Aware Sidebar

- Reworked the sidebar so menu groups are shown only when the current user has the related permission.
- The avatar menu always keeps `Hồ sơ cá nhân` available for authenticated users.
- Attendance settings, device, timesheet, report, and employee menus now use the current permission matrix.
- Admin/Super Admin still see the compact system/admin area, including dashboard and user/role management.
- Removed broad template/demo navigation from normal employee-facing sidebar visibility.
- Verified Blade compilation with `php artisan view:cache`.
- Reran `MonthlyTimesheetServiceTest`.

## 2026-06-30 Self-Scoped Timesheet Views

- Added `attendance.timesheet.view_all` permission for users who can review every employee's daily/monthly timesheet.
- Kept `attendance.timesheet.view` as the base permission for opening timesheet pages.
- Daily and monthly timesheet pages now force non-`view_all` users to their linked `employees.user_id` profile.
- If a login account has no linked employee profile and lacks `view_all`, timesheet queries return no rows instead of falling back to all employees.
- Employee/member users no longer see department or employee filters on daily/monthly timesheet pages.
- Employee/member users no longer see daily adjustment actions or monthly generation actions.
- Reran `AuthorizationSeeder` so the new permission is available in the role matrix and default role assignments.
- Verified edited PHP files with `php -l`, compiled Blade views, and reran `MonthlyTimesheetServiceTest`.

## 2026-06-30 Sidebar Demo Reference Section

- Added a dedicated `Demo` section at the bottom of the Admin/Super Admin sidebar, after `Người dùng & quyền`.
- Moved `Demo Tabulator` out of the real attendance-device menu and into the new demo reference section.
- Grouped legacy template links by purpose: attendance demo, Laravel examples, template pages, projects/profile, account, ecommerce, dashboards, applications, and sample authentication pages.
- Kept normal employee-facing menus focused on real business workflows.
- Verified Blade compilation with `php artisan view:cache` and checked the sidebar Blade file with `php -l`.

## 2026-06-30 Sidebar Report Header

- Added a dedicated `Báo Biểu` header in the sidebar when the current user has `reports.view`.
- Kept the existing attendance report link under that header so Phase 7 report pages can be added in the same section later.
- Positioned the report section below `Quản lý nhân viên` and above `Quản trị hệ thống`.
- Verified Blade compilation with `php artisan view:cache` and checked the sidebar Blade file with `php -l`.

## 2026-06-30 Sidebar Dashboard Position

- Moved the system `Dashboard` link up below the horizontal divider after the logged-in user profile area for Admin/Super Admin users.
- Removed the duplicate system dashboard link from the `Quản trị hệ thống` section.
- Removed the active background styling from the top `Dashboard` link so it stays visually neutral in the compact header area.
- Verified Blade compilation with `php artisan view:cache` and checked the sidebar Blade file with `php -l`.

## 2026-06-30 Profile Header Simplification

- Updated the self-service profile header to use a simple name plus secondary description line instead of dark/info role badges.
- The secondary line now shows `position / department` for linked employees, or the user's role when no employee profile is linked.
- Verified Blade compilation with `php artisan view:cache` and checked the profile Blade file with `php -l`.
