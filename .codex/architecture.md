# Architecture

## Backend Direction

The backend should be organized by business modules under `Modules/`.

Current module list:

- `Modules/User`
- `Modules/Core`
- `Modules/Org`
- `Modules/Shift`
- `Modules/Schedule`
- `Modules/Device`
- `Modules/Attendance`
- `Modules/Leave`
- `Modules/Overtime`
- `Modules/Payroll`
- `Modules/Report`
- `Modules/Notification`

## Module Responsibilities

- `Modules/User`: employee profile, user account mapping
- `Modules/Core`: reusable audit logging, shared events, subscribers, contracts, enums, and helpers
- `Modules/Org`: departments, positions, organization chart
- `Modules/Shift`: shift definitions and shift assignments
- `Modules/Schedule`: working calendars, holidays, weekend rules
- `Modules/Device`: attendance devices and sync configuration
- `Modules/Attendance`: raw logs, matching, attendance calculation
- `Modules/Leave`: leave requests and approved leave
- `Modules/Overtime`: overtime registration and approval
- `Modules/Payroll`: locked timesheets and payroll-ready data
- `Modules/Report`: attendance and payroll reports
- `Modules/Notification`: reminders and system notifications

## Attendance Engine

Use `Modules/Attendance/Engines` for attendance calculation:

- `ShiftMatcher`: match logs to the best shift
- `WorkHourCalculator`: calculate work minutes
- `LateCalculator`: calculate late arrival and early leave
- `OvertimeCalculator`: calculate overtime
- `AttendanceEngine`: orchestrate the calculation flow

## Recommended Database Order

Create core tables before complex business logic:

- `departments`
- `positions`
- `employees`
- `shifts`
- `attendance_devices`
- `attendance_logs`
- `attendance_rules`
- `timesheets`
- `timesheet_details`
- `leaves`
- `overtimes`
- `holidays`

## Processing Flow

1. Receive logs from devices or manual input.
2. Store raw logs in `attendance_logs`.
3. Match logs to employees.
4. Match logs to shifts.
5. Calculate work minutes.
6. Calculate late arrival and early leave.
7. Calculate overtime.
8. Generate daily timesheet rows.
