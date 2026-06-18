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
