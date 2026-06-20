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

The attendance settings screen now persists global rules, but the processing engines do not yet consume every saved rule.

Impact:

Saved settings are available in `attendance_rules`, but some calculation behavior may still follow existing hard-coded or shift-level logic until the engine is wired to these global rules.

Priority:

Medium
