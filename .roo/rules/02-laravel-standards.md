# Laravel & PHP Coding Standards

## Code Structure
- **PSR-4 autoloading**: Namespace `App\` mapped to `app/`
- **Controllers**: ResourceController pattern, single responsibility
- **Models**: Eloquent with proper relationships, scopes, mutators
- **Services**: Business logic in `App\Services\`
- **Repositories**: Data access patterns where used

## Naming Conventions
- **Classes**: PascalCase (UserController, InvestmentPlan)
- **Methods**: camelCase (joinPlan, updateProfile)
- **Variables**: camelCase (planSelected, amountToInvest)
- **Routes**: kebab-case (account-settings, trading-history)
- **Database**: snake_case (lead_status, next_follow_up_date)

## Laravel Features Used
- **Livewire 3**: Real-time UI components with wire:model
- **Jetstream**: Authentication scaffolding
- **Sanctum**: API authentication
- **Fortify**: Two-factor authentication
- **Mail**: Email notifications with queues
- **Observers**: Model event handling
- **Validation**: Request validation rules

## Best Practices
- Use Eloquent relationships over raw SQL
- Implement proper error handling with try-catch
- Use database transactions for critical operations
- Apply middleware for route protection
- Utilize Laravel's localization features (tr locale)

## Docker Deployment Standards
- **MANDATORY**: All Laravel artisan commands MUST be executed inside Docker container
- **Command Pattern**: `docker-compose exec app-monexa php artisan [command]`
- **Container Service**: Use `app-monexa` as main PHP-FPM container
- **Never Use**: Direct `php artisan` commands on host system