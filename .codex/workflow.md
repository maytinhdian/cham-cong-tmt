# Workflow

## Recommended Backend Work Order

1. Create migrations and models for core tables.
2. Build CRUD for foundation data.
3. Add service layer.
4. Add DTOs for engine/service boundaries.
5. Implement attendance calculation engines.
6. Add jobs for sync and timesheet generation.
7. Add controllers or Livewire actions last.
8. Connect real data to the existing UI pages.

## First Backend Milestone

Start with:

- `departments`
- `positions`
- `employees`
- `shifts`

Then connect real data to:

- Employee list
- Add employee
- Department management
- Position management
- Shift definition

## Attendance Calculation Milestone

After foundation CRUD is stable:

1. Store raw attendance logs.
2. Match employee.
3. Match shift.
4. Calculate work minutes.
5. Calculate late / early leave.
6. Calculate overtime.
7. Generate daily timesheet detail.
8. Lock monthly timesheet.

## Before Finishing A Change

Run only the checks that fit the change:

- `php -l` for changed PHP files
- `php artisan view:cache` for Blade changes
- `composer dump-autoload` for autoload or namespace changes

