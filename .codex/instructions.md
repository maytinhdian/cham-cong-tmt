# Project Instructions

## Goal

Build TMT Time Attendance as a Laravel 11 + Livewire 3 HR and attendance management system.

The project is moving toward a modular backend under `Modules/` while keeping the existing Laravel app and Material Dashboard UI working.

## Current Priorities

1. Read `.codex/logs/progress-log.md` before continuing HR or attendance work.
2. Keep the UI consistent with the existing Material Dashboard template.
3. Organize backend code by business modules.
4. Start backend work from database, models, and core CRUD before complex attendance calculations.
5. Keep business logic out of Blade views.
6. Prefer small, reversible changes.

## Technology Stack

- PHP 8.1+
- Laravel 11
- Livewire 3
- Bootstrap / Material Dashboard 2 Pro style
- Composer PSR-4 autoloading
- Simple DataTables where the template already uses it
- Dropzone where bulk upload UX is needed

## Module Namespace

The root `Modules/` folder should be autoloaded with:

```json
"Modules\\": "Modules/"
```

Example namespace:

```php
namespace Modules\Attendance\Engines;
```

Run this after changing Composer autoload:

```bash
composer dump-autoload
```

## Module Creation Guide

When adding a new business module, create it under `Modules/<ModuleName>` and keep the module focused on one business area.

Recommended folders:

```text
Modules/<ModuleName>/
├── Actions/
├── DTOs/
├── Models/
├── Services/
└── Engines/
```

Use only the folders that are needed for the module. For example, report modules usually need `DTOs`, `Services`, `Actions`, and optional `Exports`, but do not need `Engines` unless they perform reusable calculations.

Module responsibilities:

- `Models`: Eloquent models for tables owned by the module.
- `DTOs`: typed data passed between Livewire pages, actions, services, and engines.
- `Services`: application/business operations and reusable query logic.
- `Actions`: single user- or workflow-triggered operations.
- `Engines`: calculation or rule-processing logic that should stay independent from UI and persistence.
- `Exports`: spreadsheet/PDF export classes when the module produces downloadable files.

Keep UI classes in `app/Http/Livewire/Pages/...` and Blade files in `resources/views/livewire/pages/...`. The module should provide the business logic, while Livewire pages should stay thin.

Before creating a module, update `.codex/architecture.md` if the module introduces a new business responsibility. After creating or moving many module classes, run:

```bash
composer dump-autoload
```

## New Page Authorization Guide

When adding a new authenticated business page, define its permission before or during implementation.

Checklist:

1. Add the permission name to `Modules/Core/Authorization/PermissionRegistry.php`.
2. Use the module/action naming convention:

```text
<module>.<feature>.<action>
```

Examples:

```text
reports.missing_logs.view
reports.missing_logs.export
attendance.timesheet.close
employees.manage
```

3. Add the permission to the default role matrix in `PermissionRegistry::rolePermissions()`.
4. Run:

```bash
php artisan db:seed --class=AuthorizationSeeder
```

5. Protect the route with `can:<permission>`:

```php
Route::get('pages/reports/missing-logs', MissingLogs::class)
    ->middleware('can:reports.missing_logs.view')
    ->name('reports-missing-logs');
```

6. Protect sensitive Livewire actions with `$this->authorize(...)`, especially actions that create, update, delete, process, export, approve, close, unlock, or sync data:

```php
$this->authorize('reports.missing_logs.export');
```

7. Add Core activity logging for sensitive actions when the result affects attendance data, payroll review, devices, reports, settings, or authorization.

Page-level permission controls who can open the screen. Action-level authorization controls what the user can do after the screen is open.
