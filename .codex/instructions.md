# Project Instructions

## Goal

Build TMT Time Attendance as a Laravel 11 + Livewire 3 HR and attendance management system.

The project is moving toward a modular backend under `Modules/` while keeping the existing Laravel app and Material Dashboard UI working.

## Current Priorities

1. Keep the UI consistent with the existing Material Dashboard template.
2. Organize backend code by business modules.
3. Start backend work from database, models, and core CRUD before complex attendance calculations.
4. Keep business logic out of Blade views.
5. Prefer small, reversible changes.

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

