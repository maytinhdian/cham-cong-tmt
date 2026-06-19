# Attendance System Roadmap

## Naming Alignment

- `AttendanceLog` in the original draft maps to `RawAttendanceLog` in the current code.
- `AttendanceCalculator` work is currently split across `AttendanceEngine`, `WorkHourCalculator`, `LateCalculator`, and `OvertimeCalculator`.

## Phase 1 - Foundation

### Core Data
- [x] Department model, migration, seeder, service, and CRUD UI
- [x] Position model, migration, seeder, service, and CRUD UI
- [x] Employee model, migration, seeder, service, and CRUD UI

### Shift Data
- [x] Shift model, migration, seeder, DTO, service, and CRUD UI
- [x] Shift break model, migration, service, and seeded records
- [x] Shift rule model, migration, service, and seeded records

### Attendance Base
- [x] Raw attendance log model
- [x] Raw attendance log migration
- [x] Raw attendance log service
- [ ] Raw attendance log repository

## Phase 2 - Scheduling

- [x] Weekend rules
- [x] Holiday calendar
- [x] Employee shift assignment
- [ ] Weekly/monthly work calendar

## Phase 3 - Attendance Devices

- [x] Attendance device model and table
- [x] Device connection metadata
- [x] Device user mapping
- [x] Raw attendance log sync foundation
- [x] Manual raw log entry
- [ ] Real device sync
- [ ] Employee sync from devices

## Phase 4 - Attendance Processing

- [x] Attendance engine foundation
- [x] ShiftMatcher
- [x] Raw log processing action and service
- [x] LogFilter
- [x] LogPairing
- [x] Missing log detection
- [x] Weekend and holiday rule handling
- [x] Leave rule handling

## Phase 5 - Calculation

- [x] WorkHourCalculator
- [x] LateCalculator
- [x] OvertimeCalculator
- [x] BreakCalculator
- [x] AttendanceCalculator

## Phase 6 - Timesheet

- [x] Daily attendance result model
- [x] Daily timesheet review
- [x] Daily timesheet adjustment
- [ ] Monthly timesheet aggregation
- [ ] Timesheet closing and locking

## Phase 7 - Reports

- [ ] Late/early reports
- [ ] Missing log reports
- [ ] OT reports
- [ ] Monthly attendance summaries
- [ ] Excel export
- [ ] PDF export
