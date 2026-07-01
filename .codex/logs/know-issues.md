# Known Issues

## 2026-06-30 Role Permission Switch Controls

Problem:

No new unresolved implementation problem was found while changing individual role permissions to switch controls.

Impact:

The browser verification plugin could not be used in this environment, but Blade compilation passed and the change is limited to the shared permission matrix markup.

Priority:

None

## 2026-07-01 Role List DataTable Pagination Style

Problem:

No new unresolved implementation problem was found while adapting the role list pagination to the DataTables visual style.

Impact:

The change is currently scoped to role management. Other Livewire lists still use their existing Bootstrap pagination until they are explicitly migrated.

Priority:

None

## 2026-07-01 Business Table Action Icon Sweep

Problem:

No new unresolved implementation problem was found while applying icon-only action buttons across the remaining business tables.

Impact:

Some detail/edit controls intentionally keep existing placeholder or edit-route behavior where the application does not yet have a dedicated detail route.

Priority:

None

## Shift Matching

Problem:

Resolved for the current default first-day overnight policy. Next-day checkout logs from an overnight shift are now kept with the original shift date and excluded from the next day's own pairing.

Impact:

None for this behavior. The alternate saved `two_day_shift_policy = second_day` value is now supported.

Priority:

None

## 2026-06-22 ZKTeco PUSH Migration

Problem:

Resolved on 2026-06-25. The local MySQL database accepted the pending migrations, including `attendance_device_commands`.

Impact:

The command queue table now exists in the local database.

Priority:

None

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

## 2026-06-27 Attendance Settings Tab Highlight

Problem:

No new unresolved problem was found while applying the raised active-tab treatment to the attendance settings page.

Impact:

The change is scoped to the attendance settings tabs and does not change other nav-pills groups.

Priority:

None

## 2026-06-27 Attendance Settings Tab Motion

Problem:

Resolved in this pass. The attendance settings tabs could feel jumpy because the active link had its own transform while the Material Dashboard moving indicator was also being repositioned.

Impact:

The fix is scoped to `.attendance-settings-tabs` and does not change other `nav-pills` groups.

Priority:

None

## 2026-06-27 ZKTeco PUSH Version Diff

Problem:

No new implementation problem was introduced while reviewing the two PUSH protocol PDFs. The review confirmed that the 2024 Security PUSH document is broader than the current attendance-log integration.

Impact:

Future support for 2024-style devices may require registry/session handling, `rtlog`, `tabledata`, `querydata`, and access-control event parsing. The current `ATTLOG` path remains the primary supported scope.

Priority:

Future compatibility work when real hardware requires the 2024 flow

## 2026-06-30 Authorization Test Follow-up

Problem:

`php artisan test` currently has one failing template test: `Tests\Feature\ExampleTest` expects `GET /` to return HTTP 200, while the application root route redirects unauthenticated users to `sign-in` and authenticated users to the dashboard, producing HTTP 302.

Impact:

The authorization changes passed syntax checks and the domain feature/unit tests passed. The remaining failure is the default sample test expectation for the root redirect behavior.

Pending Work:

Update or replace `Tests\Feature\ExampleTest` so it asserts the intended redirect behavior for `/`.

Priority:

Low

## 2026-06-30 Role Permission Matrix UI

Problem:

No new unresolved problem was found while reworking the role create/edit UI.

Impact:

Role assignment is now clearer, but it still uses the existing template user-management screens for assigning users to roles.

Priority:

None

## 2026-06-30 Employee Login Account Provisioning

Problem:

No new unresolved implementation problem was found while adding employee-code login account provisioning.

Impact:

Employees can now be linked to login accounts from the employee screen, but password delivery is still an operational process handled by the higher-level user outside the system.

Priority:

None

## 2026-06-30 Employee Self-Service Profile

Problem:

No new unresolved implementation problem was found while updating the self-service profile page.

Impact:

The page supports basic profile and password changes. More advanced self-service fields such as emergency contacts, bank data, documents, or approval workflows remain outside the current scope.

Priority:

None

## 2026-06-30 Permission-Aware Sidebar

Problem:

No new unresolved implementation problem was found while making the sidebar permission-aware.

Impact:

The sidebar is now much cleaner for normal employees. Future pages still need to follow the New Page Authorization Guide so their menu items are wrapped with the matching permission.

Priority:

None

## 2026-06-30 Self-Scoped Timesheet Views

Problem:

No new unresolved implementation problem was found while scoping daily/monthly timesheet views by the logged-in employee.

Impact:

Employee accounts must be linked to an `employees` row through `employees.user_id`; otherwise they will see empty timesheet pages unless they have `attendance.timesheet.view_all`.

Priority:

None

## 2026-06-30 Sidebar Demo Reference Section

Problem:

The demo links are now grouped in an Admin/Super Admin-only sidebar section, but many legacy template/demo routes still only require `auth` at the route level.

Impact:

Normal users should not see the demo menu, but a logged-in user who knows a direct legacy URL may still be able to open some demo/template pages until those routes receive explicit middleware or are removed.

Priority:

Medium

## 2026-06-30 Sidebar Report Header

Problem:

No new unresolved implementation problem was found while adding the report sidebar header.

Impact:

The section currently contains only the existing attendance report link. More report links can be added under the same header during Phase 7.

Priority:

None
