# Coding Standards

## General

- Follow PSR-12.
- Use strict typing where possible.
- One class per file.
- One responsibility per class.

## Methods

Prefer:

createEmployee()
updateEmployee()
calculateOvertime()

Avoid:

create()
update()
calculate()

unless context is obvious.

## Controllers

Controllers must:

- Validate request
- Call Action or Service
- Return Response

Controllers must not:

- Contain business logic
- Contain SQL queries

## Documentation Standards

### Class Documentation

All public classes must contain PHPDoc.

Example:

/**

- Responsible for matching attendance logs
- to the most appropriate work shift.
 */
class ShiftMatcher
{
}

---

### Method Documentation

All public methods must contain PHPDoc.

Example:

/**

- Match logs to a shift.
-
- @param Employee $employee
- @param Collection $logs
-
- @return Shift|null
 */
public function match(
    Employee $employee,
    Collection $logs
): ?Shift
{
}

---

### Complex Logic

Complex business rules must be documented.

Example:

// Night shift may span across two calendar days.
// Logs between 18:00 and 09:00 belong to this shift.

---

### Engine Rules

Attendance Engine classes require:

- Class PHPDoc
- Public method PHPDoc
- Business rule comments where logic is not obvious

Examples:

LogPairing
ShiftMatcher
BreakCalculator
AttendanceCalculator
OTCalculator
