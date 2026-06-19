# Architecture Decisions

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
