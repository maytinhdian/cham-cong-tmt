# Architecture Decisions

## 2026-07-02

Decision:

Use the existing `EmployeeAccountService` for optional login account provisioning inside the new employee wizard.

Reason:

The employee list page already centralizes username, role, password hashing, employee-account linking, and activity logging in this service. Reusing it keeps account creation behavior consistent across quick edit and initial employee creation.

Result:

The wizard account step only exposes provisioning controls to users with `authorization.manage`. Employee profile creation remains available without account provisioning, while enabled account creation uses the employee code as username and writes the linked `users` record through the shared service.

## 2026-07-02

Decision:

Expose ZKTeco PUSH reception through a separate authenticated operator page, while keeping physical device traffic on the public `/iclock/*` endpoints.

Reason:

The device protocol requires plain text public endpoints that physical devices call directly. The HR operator workflow needs a readable monitor for endpoint configuration, heartbeat status, raw log arrival, and queued command status without changing the machine-facing protocol URLs.

Result:

`/pages/attendance/push-receiver` is protected by `attendance.raw_logs.view` and shows real receiver data. Device commands can be queued from this page only by users with `attendance.devices.manage`.

## 2026-07-02

Decision:

Keep the current ZKTeco attendance initialization flow as `SN` lookup or auto-create plus immediate option response, instead of adding mandatory device registration now.

Reason:

The attached protocol note describes registered and unregistered initialization paths, but the current real-device attendance integration and existing tests use the simpler attendance PUSH subset. Adding a stricter registration handshake before a target device requires it could block older attendance devices from receiving `GET OPTION FROM`.

Result:

The API reference now documents the registration variant as a protocol possibility, while TMT continues to return options from `/iclock/cdata?SN=...&options=all` and stores the device serial number in `attendance_devices.code`.

## 2026-07-02

Decision:

Attendance device online status should be based on recent ZKTeco PUSH/ADMS contact with the Laravel server, not on whether an IP address is present or whether the server can open a direct device socket.

Reason:

The supported production integration is device-initiated PUSH. A configured device proves connectivity by calling `/iclock/cdata`, `/iclock/getrequest`, `/iclock/ping`, or `/iclock/devicecmd`; direct `4370` access is useful for local hardware diagnostics but does not prove the ADMS/PUSH path is working.

Result:

The device page treats a machine as online only when `last_connected_at` is within the last 15 minutes. Stale or missing heartbeat/PUSH activity is shown as offline or not yet checked, and failed checks no longer refresh `last_connected_at`.

## 2026-07-01

Decision:

Operational device management should use the ZKTeco PUSH command queue instead of direct `4370` socket calls.

Reason:

The physical device should be managed consistently through the documented ADMS/PUSH flow: the device polls `/iclock/getrequest`, receives server commands, and posts command results to `/iclock/devicecmd`. Direct `4370` access is useful for emergency testing, but it bypasses the production integration contract.

Result:

`AttendanceDeviceCommandService` now supports generic queued PUSH commands with payloads and includes a dedicated `queueDeleteAllUsers()` helper for `DATA DELETE USERINFO`. Destructive commands should not be left pending unless the device is configured to poll the Laravel server.

## 2026-07-01

Decision:

Real ZKTeco device records should use the physical device serial number as `attendance_devices.code` when integrating with PUSH endpoints.

Reason:

The PUSH protocol identifies the device with the `SN` query parameter, and the existing import service matches that serial number to `attendance_devices.code`. Using the serial as the code prevents duplicate device records when the physical machine starts polling `/iclock/*`.

Result:

The real device at `192.168.1.92` is registered as serial `0068143300011` on port `4370`. Direct ZK protocol testing can read users/logs, while the production-facing import path remains the existing `/iclock/cdata` PUSH flow.

## 2026-06-30

Decision:

Role permission selection should use the project's standard switch control for individual on/off permission choices.

Reason:

Permissions are binary assignments, and the existing global `form-switch` styling already defines the approved Material Dashboard on/off visual language.

Result:

The role create/edit permission matrix now renders each permission as a bordered row with a right-aligned switch while preserving the existing Livewire permission array.

## 2026-07-01

Decision:

Role management tables should use a Livewire-compatible pagination view that mirrors the bundled DataTables visual classes.

Reason:

The DataTables demo UI is the desired visual reference, but role management already depends on Livewire server-side pagination, authorization, and sorting. Reusing the template classes avoids replacing the data flow with client-side JavaScript.

Result:

The role list now renders DataTables-style top controls and pagination while keeping the existing Livewire query and actions.

## 2026-07-01

Decision:

Business table action columns should use icon-only controls for both standard actions and domain-specific actions.

Reason:

The UI now uses compact action clusters throughout HR and attendance screens. Domain actions such as sync, apply, ignore, check connection, and adjust should stay visually aligned with the view/edit/delete cluster while keeping their distinct meaning through icon, color, title, and aria-label.

Result:

Attendance and employee setup tables now use Material Icons for their row actions while preserving the existing Livewire methods and routes.

## 2026-06-19

Decision:

Attendance Engine will be separated from Attendance Services.

Reason:

Business rules may change frequently.

Result:

Modules/Attendance/Engine created.

## 2026-06-19

Decision:

Shift break and shift rule data are stored in dedicated tables while the legacy columns on `shifts` remain in place.

Reason:

The current shift form and attendance engine already depend on the legacy shift fields, so the new tables need to coexist without breaking existing flows.

Result:

Added `shift_breaks` and `shift_rules` tables, plus models and seed data under `Modules/Shift`.

## 2026-06-19

Decision:

Raw attendance logs are now filtered and paired before daily result calculation.

Reason:

The first engine pass should stop relying on raw first/last log selection so later processing can grow around a stable pairing step.

Result:

Added `LogFilter`, `LogPairing`, and `LogPairingResult` under `Modules/Attendance`.

## 2026-06-19

Decision:

Weekend and holiday handling should be resolved before daily status calculation, and special-day rows should appear explicitly in the daily timesheet UI.

Reason:

The attendance engine needs calendar awareness so it can avoid marking non-working days as normal absences and can keep the UI filters honest.

Result:

Added `AttendanceDayResolver`, `AttendanceDayContext`, and `weekend` / `holiday` display states in the attendance pages.

## 2026-06-19

Decision:

Approved leave should be evaluated per employee before holiday/weekend checks and should suppress normal late/early/absence penalties for that day.

Reason:

Leave is employee-specific, while weekends and holidays are calendar-wide; the attendance engine needs that priority order to avoid false exceptions.

Result:

Added `approved_leaves` and wired `leave` status handling into the attendance engine and timesheet views.

## 2026-06-19

Decision:

Daily attendance results should store both raw worked minutes and derived attendance value, with break minutes deducted from work time using shift break rules.

Reason:

Payroll review needs the raw time span, the net worked span, and the payable attendance figure side by side so manual corrections and automated processing follow the same rule set.

Result:

Added break deduction and attendance-value calculation to the attendance engine, daily timesheet adjustment service, and daily/process log UI.

## 2026-06-20

Decision:

Global attendance settings are stored in a dedicated `attendance_rules` key-value table, separate from per-shift `shift_rules`.

Reason:

The attendance settings screen controls company-wide defaults such as workday minutes, late/early thresholds, missing-log behavior, overtime limits, statistics display, and weekend display. These values should not be tied to one shift definition.

Result:

Added `attendance_rules` plus `Modules/Attendance` model, DTO, service, and save action; the Livewire settings screen now persists and reloads those values.

## 2026-06-20

Decision:

Attendance processing reads saved global rules through a typed `AttendanceRuleContext` instead of reading raw key-value rows directly inside calculators.

Reason:

The engine needs stable typed values while the settings table remains flexible for UI and report settings. Keeping the key-value conversion in `AttendanceRuleService` prevents calculators from depending on database storage details.

Result:

`AttendanceEngine`, `LateCalculator`, `OvertimeCalculator`, `AttendanceCalculator`, and manual daily adjustment now use saved rule values for core calculation behavior.

## 2026-06-20

Decision:

Shift definition time fields use the bundled Flatpickr plugin in time-only, 24-hour mode.

Reason:

The shift form needs a clickable time picker that avoids browser AM/PM controls and avoids long manual dropdown lists while still saving `HH:mm` values for Livewire validation and shift services.

Result:

The shift definition page initializes Flatpickr for shift, break, and punch-window time fields with five-minute increments and Livewire value syncing.

## 2026-06-20

Decision:

Overtime-before-shift permission and the after-shift overtime threshold are configured per shift.

Reason:

Different shifts can have different overtime policies. Day shifts, night shifts, and special production shifts should not all inherit the same before/after overtime behavior from a global setting.

Result:

The `shifts` table stores `overtime_before_shift_enabled` and `overtime_after_shift_min_minutes`; shift definition UI saves both values, and attendance processing uses them when calculating daily overtime minutes.

## 2026-06-21

Decision:

Per-shift overtime before and after work should both be controlled by explicit switch state and minute threshold fields.

Reason:

The shift definition form needs a consistent UI: enabling a switch reveals the relevant minute input, and disabling a switch should stop that overtime direction from being calculated.

Result:

Added `overtime_before_shift_min_minutes` and `overtime_after_shift_enabled` to `shifts`; the shift form now shows compact `Phút` inputs only when each overtime switch is on, and `OvertimeCalculator` respects both switch states.

## 2026-06-21

Decision:

The shift punch requirement control should be shown as one grouped set of switch-style radio options.

Reason:

The three punch requirement modes are mutually exclusive business choices, so the UI should make the grouping visible while preventing multiple selections.

Result:

The shift definition form now uses three grouped radio inputs styled with the existing switch classes and bound to the existing `attendanceRequirement` value.

## 2026-06-21

Decision:

The project UI color contract should follow the Material Dashboard foundation colors documentation.

Reason:

The bundled template already defines semantic utility classes and documented colors, so custom color values should not compete with the template palette.

Result:

`.codex/ui-rules.md` now points to `public/documentation/foundation/colors.html`, lists the documented semantic colors and gray scale, and allows only template `bg-gradient-*` gradients.

## 2026-06-21

Decision:

Switch controls should use the documented Primary and Secondary colors for on/off states.

Reason:

Switches appear across attendance configuration screens and should not depend on per-page custom styling. A global override keeps current and future switch controls visually consistent.

Result:

`public/assets/css/tmt-ui.css` now colors `.form-switch .form-check-input` off state with Secondary `#7b809a`, checked state with Primary `#e91e63`, and focus state with a subtle Primary ring. `.codex/ui-rules.md` documents the standard for both checkbox switches and mutually exclusive radio switches.

## 2026-06-21

Decision:

Icon usage should follow the Material Dashboard foundation icons documentation.

Reason:

The template examples use Google Material Design icons by default and provide Font Awesome as an optional expanded set. Keeping that priority prevents mixed icon styles in the same UI.

Result:

`.codex/ui-rules.md` now prefers Material Icons / Material Icons Round, allows Font Awesome as a fallback, limits Nucleo to existing template/sidebar areas, and discourages Bootstrap Glyphicons for new UI.

## 2026-06-21

Decision:

Counting middle-break time as overtime should be a per-shift rule, not a global default.

Reason:

The rule is unusual and should not change historical or ordinary shift calculations unless HR explicitly enables it for a specific shift.

Result:

Added `break_as_overtime_enabled` to `shifts`; the shift definition form exposes the switch in the middle-break section, and overtime calculation adds deducted break minutes to OT only when the matched shift enables the rule.

## 2026-06-21

Decision:

Work schedule badges should render the assigned shift's saved display color.

Reason:

Shift color is part of the shift definition and should help users recognize the same shift consistently when assigning or reviewing employee schedules.

Result:

The work schedule grid and declared schedule list now use `shifts.display_color` for assigned shift badges, while unassigned schedule rows keep the secondary template fallback.

## 2026-06-21

Decision:

Bulk work schedule assignment should remain stored as one row per employee per work date.

Reason:

The existing `employee_schedules` unique key on `employee_id` and `work_date` already prevents duplicate daily schedules. Keeping that storage shape lets HR assign a department or many employees over a date range without introducing a separate batch table or changing attendance processing.

Result:

The schedule page now resolves the selected department or employee list, expands the selected date range, and calls the existing assignment action for each employee/date combination.

## 2026-06-21

Decision:

The work schedule page should expose basic shift information through a collapsed reference list.

Reason:

Users need to compare shift codes, times, colors, and break minutes while assigning schedules, but showing the full shift list permanently would make the scheduling screen harder to scan.

Result:

Added a `Danh sách ca làm việc` accordion under the quick assignment panel, using the existing shift data already loaded for the assignment select.

## 2026-06-21

Decision:

The work schedule grid should remain the primary visible area, while secondary actions and detail tables should be collapsed by default.

Reason:

The schedule page combines assignment, reference, calendar review, and detailed row management. Keeping everything expanded makes the page hard to scan for daily use.

Result:

`Phân ca nhanh`, `Danh sách ca làm việc`, and `Danh sách lịch đã khai báo` are now accordion sections, while the filters and calendar grid remain visible.

## 2026-06-21

Decision:

The work schedule page should show quick assignment and shift references side by side, while placing filters directly above the declared schedule list.

Reason:

Users need quick assignment controls and basic shift information visible at the same time. The department/date filters are more understandable when they sit next to the detailed results they filter.

Result:

The schedule page now uses two visible top columns for `Phân ca nhanh` and `Danh sách ca làm việc`, keeps the day grid visible below, and moves the filter controls into the `Danh sách lịch đã khai báo` card.

## 2026-06-21

Decision:

The declared schedule list should show only the first 10 filtered rows by default.

Reason:

The detailed list can become long after filtering by department and date range. Showing the first 10 rows keeps the page compact while still allowing users to expand the remaining rows when needed.

Result:

Rows after the first 10 are rendered inside a Bootstrap collapse controlled by a `Xem thêm` button.

## 2026-06-22

Decision:

The main work schedule grid should use a full monthly matrix with calendar-style day cells.

Reason:

HR needs a month-level overview where employees remain easy to scan vertically, while shift assignments read like calendar events across the days of the month.

Result:

The schedule page now loads a selected month, renders every day as a column with weekday and date labels, keeps the existing employee identity column, and displays shift codes as wider bottom-aligned bars inside each day cell.

## 2026-06-22

Decision:

The monthly schedule matrix should expose department and month navigation controls directly in the grid header.

Reason:

Users need to filter the visual month matrix by department and move between adjacent months without leaving the schedule overview.

Result:

The monthly grid header now includes a department filter, previous and next month buttons, a month picker, and a `Hôm nay` shortcut that returns the grid to the current month.

## 2026-06-22

Decision:

Weekend highlighting in the monthly schedule matrix should be driven by existing weekend settings and attendance rule color data.

Reason:

The schedule grid needs to distinguish weekend cells now, while still allowing the future weekend-definition UI to choose which weekdays and color should be used without changing the grid markup again.

Result:

The monthly schedule grid marks cells whose ISO weekday is configured as weekend and sets the highlight through a CSS variable sourced from the saved `weekend_color` attendance rule.

## 2026-06-22

Decision:

Weekend highlighting in the monthly schedule matrix should mark both headers and body cells, with visible fallback CSS values.

Reason:

Only tinting the table cell was too subtle and could be hidden by table/template styling. HR needs weekend columns to be identifiable without relying on a faint background alone.

Result:

Weekend headers now get their own weekend class and top border, weekend day numbers use the configured weekend color, and weekend body cells paint the inner cell area with the configured background.

## 2026-06-22

Decision:

Declared schedule expansion should be controlled by Livewire state and rendered inside the same table.

Reason:

Using a Bootstrap collapse with a second table made the expanded rows visually unstable and prevented the button label from reflecting the open state.

Result:

The declared schedule list now uses one table for compact and expanded states, and the button toggles between showing the remaining row count and `Thu gọn`.

## 2026-06-22

Decision:

Overnight shift results should remain attached to the shift's starting work date under the current default rule policy.

Reason:

The saved default for two-day shifts is `first_day`, and processing the next calendar date should not reuse the checkout punch from the previous night's shift as a separate day result.

Result:

Attendance processing now removes punches that fall inside the previous day's overnight shift window before pairing the current day, and a feature test locks the 22:00-06:00 scenario.

## 2026-06-22

Decision:

Global before-shift and after-shift overtime caps should be applied after per-shift overtime eligibility but before total overtime limits.

Reason:

Per-shift switches decide whether a shift allows overtime in each direction, while company-wide rules can still cap how many minutes are payable before or after the shift.

Result:

`AttendanceRuleContext` now exposes the directional overtime caps, and `OvertimeCalculator` limits before-shift and after-shift overtime separately before applying the minimum and total overtime rules.

## 2026-06-22

Decision:

Automated tests must use SQLite in-memory instead of the local MySQL development database.

Reason:

Feature tests that use `RefreshDatabase` can reset the configured database. With the SQLite test settings commented out, the night-shift feature test reset local MySQL data, including default login users.

Result:

`phpunit.xml` now sets `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` for test runs, and the default roles/users were restored in the local MySQL database.

## 2026-06-22

Decision:

The `second_day` overnight shift policy should store the processed daily result on the calendar date where the shift ends.

Reason:

Some payroll policies group overnight work by checkout date instead of shift start date. The engine needs to support both policies without creating duplicate daily rows.

Result:

`AttendanceRuleContext` now carries `two_day_shift_policy`; `AttendanceEngine` separates the log-processing date from the result date and uses `whereDate()` persistence so processing the first or second date updates the same second-day result.

## 2026-06-22

Decision:

Monthly timesheets should be stored as one generated row per employee and payroll month.

Reason:

Payroll review needs stable month-level totals that can be regenerated from daily attendance results before the later closing/locking workflow is introduced.

Result:

Added `monthly_timesheets`, `MonthlyTimesheetService`, `GenerateMonthlyTimesheetAction`, and the `Bảng công tháng` page. The page can generate draft monthly summaries from processed daily results and review totals by month, department, employee, and status.
## 2026-06-22

Decision:

The default overnight shift policy should be `second_day`.

Reason:

The selected payroll policy groups overnight work on the checkout calendar date, and seeded test data should match the behavior users review in daily and monthly timesheets.

Result:

`AttendanceRuleService` now defaults `two_day_shift_policy` to `second_day`; the night-shift feature test still covers `first_day` explicitly, and `TestAttendanceDataSeeder` persists the `second_day` rule before processing its sample logs.

## 2026-06-22

Decision:

Raw attendance punch times must be stored as stable `DATETIME` values.

Reason:

The existing MySQL `TIMESTAMP` column had `ON UPDATE CURRENT_TIMESTAMP`, so marking a raw log as processed changed the original punch time to the current time.

Result:

Added migrations that convert `raw_attendance_logs.punch_time` to `DATETIME NOT NULL`, preserving original device punch times when processing status is updated.

## 2026-06-22

Decision:

ZKTeco attendance devices should be integrated through the PUSH protocol endpoints rather than a direct socket poller.

Reason:

The referenced `Attendance PUSH Communication Protocol 20200801.pdf` defines the device as an HTTP client that initializes with `/iclock/cdata`, polls `/iclock/getrequest`, uploads ATTLOG records to `/iclock/cdata?table=ATTLOG`, and acknowledges commands through `/iclock/devicecmd`.

Result:

Added a small PUSH adapter under `Modules/Device` with parser, import service, command queue service, public `/iclock/*` routes, CSRF exclusion for device callbacks, and feature tests. Device `SN` maps to `attendance_devices.code`; queued sync uses the protocol `LOG` command.

## 2026-06-23

Decision:

ZKTeco protocol notes will be kept as Markdown beside the source PDF under `.codex/docs/devices`.

Reason:

The original protocol PDF is long and covers many biometric, file, firmware, and remote-enrollment features that are not part of the current attendance-log integration. A concise summary and API reference make the implemented `/iclock/*` subset easier to audit and extend.

Result:

Added `zkteco-push-summary.md` and `zkteco-push-api-reference.md`, focused on initialization, ATTLOG upload, getrequest commands, devicecmd replies, heartbeat, and the small command subset needed by this project.

## 2026-06-23

Decision:

BIODATA synchronization will remain documented future scope until tested against a real ZKTeco device.

Reason:

The protocol provides `BIODATA` upload, query, update, delete, and clear commands, which are enough for server-mediated cross-device biometric sync. Actual template compatibility depends on device model, firmware, biometric type, algorithm version, format, and payload behavior, so implementation should wait for real hardware verification.

Result:

Added BIODATA notes to the ZKTeco summary and API reference. The current product scope remains attendance-log import first.

## 2026-06-23

Decision:

ZKTeco queued command IDs should be compact alphanumeric values and getrequest responses should follow the documented `C: <id>: <command>` shape.

Reason:

The protocol describes command IDs as server-generated values with a maximum length of 16 characters and examples include spaces around the `C:` command fields. Keeping the generated IDs simple improves compatibility before hardware testing.

Result:

`AttendanceDeviceCommandService` now generates 12-character uppercase alphanumeric command keys and returns `C: <command_key>: LOG` for queued sync commands.

## 2026-06-23

Decision:

The first Tabulator trial will be a client-side demo page loaded from CDN instead of a bundled production dependency.

Reason:

The user wants to try the table experience before committing it to core attendance screens. Loading Tabulator only on the demo page keeps the current Bootstrap/Livewire tables untouched while still proving add/delete/edit/filter/download interactions.

Result:

Added `Attendance\TabulatorDemo`, the `attendance-tabulator-demo` route, and a sidebar entry. The page uses sample attendance-log data and does not persist changes to the database.

## 2026-06-25

Decision:

Local database repair should use the existing project migrations instead of creating duplicate compatibility tables such as generic `timesheets`, `leaves`, or `holidays`.

Reason:

The current codebase already stores those concepts in the established project tables: `daily_attendance_results`, `monthly_timesheets`, `approved_leaves`, and `holiday_calendars`. Creating parallel tables would split business data and confuse later services.

Result:

Ran the pending migrations through `php artisan migrate`, bringing the local database in line with the current Laravel schema.

## 2026-06-27

Decision:

Attendance settings tabs should have a scoped raised active state that matches the Material Dashboard profile overview tabs.

Reason:

The settings page already uses `nav-pills`, but its active tab can appear flat when the template moving-tab script is not visibly applied during Livewire rendering. A scoped fallback keeps this specific business settings screen consistent without changing every nav-pills group.

Result:

Added an `attendance-settings-tabs` wrapper on the settings page and matching CSS in `tmt-ui.css` for the active tab background, light shadow, and subtle lift.

## 2026-06-27

Decision:

Attendance settings tab motion should be handled by a small scoped helper loaded after the Material Dashboard script.

Reason:

The template initializes `moving-tab` asynchronously and binds movement through hover/click behavior. On the attendance settings screen, that can feel delayed or jumpy, especially when the active link itself also animates.

Result:

Added `public/assets/js/tmt-ui.js` to resync only `.attendance-settings-tabs` indicators after the template initializes, and tuned `tmt-ui.css` so the moving indicator animates smoothly while the tab text remains stable.

Follow-up:

The attendance settings nav keeps the template `flex-row` class and uses the same slower `0.5s ease` movement rhythm as the Material Dashboard sample tabs.

## 2026-06-27

Decision:

Keep the ZKTeco PUSH 2020 and 2024 protocol comparison as a separate documentation note instead of merging it into the existing attendance-focused API reference.

Reason:

The 2024 PDF is a broader Security PUSH document, not a direct replacement for the current Attendance PUSH integration. Keeping a separate version-diff note preserves the current `ATTLOG` implementation guidance while documenting future compatibility work for registry/session, `rtlog`, `tabledata`, `querydata`, and access-control features.

Result:

Added `.codex/docs/devices/zkteco-push-version-diff.md` and linked it from the ZKTeco PUSH summary.

## 2026-06-30

Decision:

Authorization will use the existing `roles` table and app `User` model, extended with first-party `permissions` and `permission_role` tables instead of adding an external permission package.

Reason:

The project already has template role management and user-role assignment screens. Extending that foundation keeps the change small, avoids package migration work, and lets business permissions be expressed with module/action names before Reports and timesheet locking are implemented.

Result:

Added `PermissionRegistry`, `Permission` model, permission seed data, Gate registration, route `can:*` middleware, and action-level checks for sensitive attendance workflows. Existing `Admin` and new `Super Admin` roles bypass detailed checks for backward compatibility.

## 2026-06-30

Decision:

Role creation and editing should expose permissions as a grouped business matrix instead of a plain role form.

Reason:

Admins need to understand role scope quickly before Reports and timesheet locking are added. Grouping permissions by module makes role setup safer than typing a role name and assigning permissions elsewhere.

Result:

The role create/edit screens now show grouped permission checkboxes, module-level select/clear actions, and selected-permission counts. The role list now shows permission and user counts for faster review.

## 2026-06-30

Decision:

Employee login accounts should be provisioned from the employee management screen and should use the employee code as the login username.

Reason:

HR already manages the official employee code in `employees`. Using that code as `users.username` lets employees log in with their familiar personnel code while preserving existing email login for template/admin accounts. Keeping account provisioning inside employee management also keeps `employees.user_id` as the single link between HR profile and login account.

Result:

Added a `username` column to `users`, updated login to accept email or employee code, added `EmployeeAccountService`, and added a restricted account provisioning panel on the employee list quick-edit form. The default minimum role is `Member`.

## 2026-06-30

Decision:

Employee-linked users should be able to access `/laravel-examples/user-profile` as a self-service page without requiring HR or authorization-management permissions.

Reason:

After a higher-level user provisions an account from employee management, the employee needs a safe place to update basic contact information and change their own password. This keeps normal profile maintenance out of the admin-only user management screens.

Result:

The profile page now allows authenticated users to update their own basic account fields and password. It also displays linked employee context and mirrors simple contact fields to the linked employee record.

## 2026-06-30

Decision:

Sidebar navigation should be permission-aware and should not expose pages the current user cannot use.

Reason:

Route middleware already protects access, but showing unavailable menu items creates confusion for employee and department-manager users. Keeping the menu aligned with permissions makes the app feel intentionally scoped after account provisioning.

Result:

The sidebar now always shows the user's profile/logout controls, shows business groups only when the related permission is granted, and limits template/admin navigation to Admin/Super Admin users.

## 2026-06-30

Decision:

Timesheet page access should distinguish between opening a timesheet page and viewing every employee's timesheet.

Reason:

Employees need access to their own daily/monthly timesheet, but the same page must not expose other employees' attendance data. A separate `attendance.timesheet.view_all` permission keeps self-service access simple while preserving HR-wide review capability.

Result:

Users with only `attendance.timesheet.view` are scoped to the employee profile linked to their login account. Users with `attendance.timesheet.view_all` can use department/employee filters and review all rows.

## 2026-06-30

Decision:

Legacy template/demo links should be grouped under a dedicated `Demo` sidebar section below system administration.

Reason:

The links are still useful as UI references while building new screens, but they should not be mixed into real HR, device, or timesheet workflows. Keeping them at the bottom makes the production navigation clearer while preserving quick access for Admin/Super Admin review.

Result:

The sidebar now shows `Demo` after `Người dùng & quyền` for Admin/Super Admin users, with grouped sample links and the attendance Tabulator demo moved out of the device menu.

## 2026-06-30

Decision:

Report navigation should have its own sidebar header instead of being a standalone item mixed into surrounding business menus.

Reason:

Reports are becoming their own Phase 7 module, so the sidebar should reserve a clear section for current and future report pages without mixing them into timesheet or employee management navigation.

Result:

Users with `reports.view` now see a `Báo Biểu` header with the existing attendance report link under it.
