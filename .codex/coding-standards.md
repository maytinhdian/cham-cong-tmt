# Coding Standards

## PHP

- Follow PSR-4 namespaces.
- Keep class names aligned with file names.
- Keep module classes under `Modules/<ModuleName>/...`.
- Keep Laravel app classes under `app/`.
- Prefer typed properties and return types where practical.
- Avoid putting business logic in Blade files.
- Every new or edited function/method must have a short PHPDoc block that explains its purpose in business terms.
- Keep PHPDoc concise: describe why the method exists, important side effects, and returned result when useful.
- Do not add noisy comments that merely repeat the method name or each line of code.

Example:

```php
/**
 * Assign or replace an employee's planned shift for one work date.
 */
public function assign(EmployeeScheduleData $data): EmployeeSchedule
{
}
```

## Laravel

- Use migrations for database structure.
- Use Eloquent models for persisted entities.
- Use service classes for application use cases.
- Use engine classes for calculation logic.
- Use DTO classes when data crosses service or engine boundaries.
- Keep controllers and Livewire components thin.

## Module Class Examples

```php
namespace Modules\Attendance\Services;

class AttendanceLogService
{
}
```

```php
namespace Modules\Attendance\DTOs;

readonly class AttendanceLogData
{
}
```

## Verification

After PHP changes, run relevant checks:

```bash
php -l path/to/file.php
php artisan view:cache
composer dump-autoload
```

Use `composer dump-autoload` after changing `composer.json` autoload rules or adding many new PSR-4 classes.
