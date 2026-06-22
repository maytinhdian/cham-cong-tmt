# Known Issues

## Shift Matching

Problem:

Resolved for the current default first-day overnight policy. Next-day checkout logs from an overnight shift are now kept with the original shift date and excluded from the next day's own pairing.

Impact:

None for this default behavior. Supporting the alternate saved `two_day_shift_policy` value is still tracked under Attendance Rule Consumption.

Priority:

None

## Attendance Rule Consumption

Problem:

The attendance engine now consumes the core calculation rules and the per-shift before/after overtime policy, but some saved global settings remain UI/report-oriented or are not fully wired yet.

Impact:

Rules for company display, reporting symbols, rounding/statistical aggregation, out-state policy, OT-state policy, two-day shift policy, leave-interval-as-OT, and global before/after overtime caps still need dedicated report or engine handling.

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
