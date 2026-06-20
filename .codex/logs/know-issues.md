# Known Issues

## Shift Matching

Problem:

Night shift matching not finalized.

Impact:

Attendance calculation may be incorrect.

Priority:

High

## Attendance Rule Consumption

Problem:

The attendance engine now consumes the core calculation rules and the per-shift before/after overtime policy, but some saved global settings remain UI/report-oriented or are not fully wired yet.

Impact:

Rules for company display, reporting symbols, rounding/statistical aggregation, out-state policy, OT-state policy, two-day shift policy, leave-interval-as-OT, and global before/after overtime caps still need dedicated report or engine handling.

Priority:

Medium
