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
