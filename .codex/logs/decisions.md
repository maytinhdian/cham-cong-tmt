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
