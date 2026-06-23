# Known Issues

## Shift Matching

Problem:

Resolved for the current default first-day overnight policy. Next-day checkout logs from an overnight shift are now kept with the original shift date and excluded from the next day's own pairing.

Impact:

None for this behavior. The alternate saved `two_day_shift_policy = second_day` value is now supported.

Priority:

None

## 2026-06-22 ZKTeco PUSH Migration

Problem:

The new `attendance_device_commands` migration could not be applied to the local development database because MySQL on `127.0.0.1:3306` refused the connection.

Impact:

Code and tests are ready, but the local MySQL database will not have the command queue table until MySQL is started and `php artisan migrate --force` is rerun.

Priority:

High before testing with a real device

## 2026-06-23 ZKTeco Protocol Documentation

Problem:

No new unresolved problem was found while documenting the ZKTeco PUSH PDF.

Impact:

The documentation covers the important attendance-log API subset. Advanced protocol areas such as biometric templates, attendance photos, remote enrollment, firmware/file transfer, and encrypted communication remain later implementation scope.

Priority:

None

## 2026-06-23 ZKTeco BIODATA Sync

Problem:

Cross-device biometric template synchronization is supported by the protocol in principle, but it has not been implemented or tested with real hardware.

Impact:

The app can import attendance logs now, but cannot yet pull biometric templates from one ZKTeco device and push them to other devices.

Pending Work:

When a real device is available, test `POST /iclock/cdata?table=BIODATA`, `DATA QUERY BIODATA`, `DATA UPDATE BIODATA`, `DATA DELETE BIODATA`, and `CLEAR BIODATA`. Then add database storage for biometric templates and command queue support for selected target devices.

Priority:

Deferred until real-device testing

## 2026-06-23 ZKTeco Non-Hardware Review

Problem:

Resolved in this pass. Queued command IDs previously used a long `uniqid` value that included a dot, while the protocol expects compact command IDs of up to 16 alphanumeric characters.

Impact:

The simulated PUSH flow now uses a safer command ID and a getrequest command string closer to the documented format.

Priority:

None

## 2026-06-23 Tabulator Demo

Problem:

No unresolved product issue was introduced. The demo intentionally uses CDN assets and sample client-side data only.

Impact:

The demo is useful for evaluating table interactions, but it is not yet a production replacement for existing Livewire tables and does not save edits.

Priority:

None

## 2026-06-22 Attendance Test Data

Problem:

Resolved in this pass. MySQL was auto-updating `raw_attendance_logs.punch_time` when the processing status changed.

Impact:

Seeded raw logs now retain their original June 2026 punch timestamps after daily processing.

Priority:

None

## Attendance Rule Consumption

Problem:

The attendance engine now consumes the core calculation rules and the per-shift before/after overtime policy, but some saved global settings remain UI/report-oriented or are not fully wired yet.

Impact:

Rules for company display, reporting symbols, rounding/statistical aggregation, out-state policy, OT-state policy, and leave-interval-as-OT still need dedicated report, raw punch classification, or engine handling. Global before/after overtime caps and alternate two-day shift policy are now wired into attendance processing.

Priority:

Medium

## 2026-06-21 Shift Overtime UI

Problem:

No new unresolved problem was found while updating the per-shift overtime switch UI.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Shift Punch Requirement UI

Problem:

No new unresolved problem was found while grouping the punch requirement switch options.

Impact:

None for this change.

Priority:

None

## 2026-06-21 UI Color Rules

Problem:

No new unresolved problem was found while aligning `.codex/ui-rules.md` with the Material Dashboard colors documentation.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Switch Color Standard

Problem:

No new unresolved problem was found while applying the global switch color standard.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Icon Rules

Problem:

No new unresolved problem was found while aligning icon guidance with the Material Dashboard icons documentation.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Break Time As Overtime

Problem:

No new unresolved problem was found while adding the per-shift break-as-overtime rule.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Work Schedule Shift Color

Problem:

No new unresolved problem was found while rendering saved shift colors in the work schedule page.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Bulk Schedule Assignment

Problem:

No new unresolved problem was found while adding department, multi-employee, and date-range assignment.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Schedule Shift Reference

Problem:

No new unresolved problem was found while adding the collapsible shift reference list.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Schedule Collapse Layout

Problem:

No new unresolved problem was found while moving secondary schedule sections into collapsed accordions.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Schedule Two Column Layout

Problem:

No new unresolved problem was found while changing the schedule page to visible two-column quick assignment and shift reference panels.

Impact:

None for this change.

Priority:

None

## 2026-06-21 Declared Schedule Row Limit

Problem:

No new unresolved problem was found while limiting the default declared schedule list to 10 rows with a collapse for the remaining rows.

Impact:

None for this change.

Priority:

None

## 2026-06-22 Monthly Schedule Matrix

Problem:

No new unresolved problem was found while changing the main work schedule grid to a monthly calendar-style matrix.

Impact:

None for this change.

Priority:

None

## 2026-06-22 Monthly Schedule Filters

Problem:

No new unresolved problem was found while adding department and month navigation filters to the monthly schedule grid.

Impact:

None for this change.

Priority:

None

## 2026-06-22 Monthly Weekend Highlight

Problem:

Resolved in this pass. Weekend headers and body cells now receive stronger visible highlighting using the configured weekend color with fallback CSS values.

Impact:

None for this change.

Priority:

None

## 2026-06-22 Declared Schedule Expansion

Problem:

Resolved in this pass. The expanded declared schedule rows now render in the same table, and the action button changes from `Xem thêm ... dòng` to `Thu gọn` after expansion.

Impact:

None for this change.

Priority:

None

## 2026-06-22 PHPUnit Database Isolation

Problem:

Resolved in this pass. PHPUnit was using the local MySQL database because the SQLite testing database settings were commented out.

Impact:

The default login users were removed during a feature test run that used `RefreshDatabase`; they have been restored.

Priority:

None

## 2026-06-22 Monthly Timesheet Aggregation

Problem:

No new unresolved problem was found while adding monthly timesheet aggregation.

Impact:

Timesheet closing and locking are still separate roadmap work.

Priority:

None
