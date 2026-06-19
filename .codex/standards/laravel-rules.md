# Laravel Rules

## Validation

Always use FormRequest.

Never validate in Controller.

## Database

Use Eloquent models.

Use Repository only for:

- Complex queries
- Reusable query logic

## Business Logic

Business logic belongs in:

- Actions
- Services
- Attendance Engine

Never in:

- Controllers
- Livewire Components
- Blade Views

## Dependency Injection

Always prefer constructor injection.

