# Laravel & PHP Coding Standards

## Code Structure & Architecture
- **PSR-4 autoloading**: Namespace `App\` mapped to `app/`
- **Controllers**: ResourceController pattern, single responsibility, resource methods
- **Models**: Eloquent relationships, proper accessors/mutators, scopes
- **Services**: Business logic in `App\Services\`, encapsulation pattern
- **Repositories**: Data access patterns where used
- **Middleware**: Authentication chains, KYC checks

## Naming Conventions
- **Classes**: PascalCase (`UserController`, `InvestmentPlan`)
- **Methods**: camelCase (`joinPlan`, `updateProfile`)
- **Variables**: camelCase (`planSelected`, `amountToInvest`)
- **Routes**: kebab-case (`account-settings`, `trading-history`)
- **Database**: snake_case (`lead_status`, `next_follow_up_date`)

## Laravel Features & Implementation
- **Livewire 3**: Real-time UI with [`wire:model`](app/Http/Livewire) binding, lazy loading, debounce for search
- **Jetstream**: Authentication scaffolding
- **Sanctum**: API authentication
- **Fortify**: Two-factor authentication
- **Mail**: Email notifications with queues
- **Observers**: Model event handling
- **Validation**: Request validation rules, client-side + server-side

## Frontend & Styling Standards
- **CSS Framework**: MANDATORY use Tailwind CSS only
- **No Native CSS**: Avoid writing custom CSS files
- **No Bootstrap**: Do not use Bootstrap or other CSS frameworks
- **Utility-First**: Use Tailwind utility classes for all styling

## Security Implementation
- **Input Validation**: Always use Laravel validation rules
- **SQL Injection**: Use Eloquent ORM, avoid raw queries
- **CRON Endpoints**: [`CRON_KEY`](app/Http/Middleware) verification required
- **KYC Middleware**: [`complete.kyc`](app/Http/Middleware/EnsureKycIsCompleted.php) middleware for sensitive operations
- **2FA Support**: Optional via Fortify TwoFactorAuthenticatable
- **Email Verification**: Required for account activation
- **Input Sanitization**: Always validate and sanitize user inputs
- **Logging**: Log sensitive operations for audit

## Financial Code Patterns
- **Balance Updates**: Verify funds before operations
- **Precision**: Use [`bcmath`](app/Services/FinancialService.php) for financial calculations
- **Transactions**: Wrap in [`DB::transaction()`](app/Services) for deposits/withdrawals
- **Lead Management**: Proper status tracking and history
- **Audit Trail**: Log all financial operations

## Testing Requirements
- **Feature Tests**: API endpoints and user flows
- **Unit Tests**: Business logic and calculations
- **Integration Tests**: Payment and external APIs
- **Security Tests**: Authentication and authorization
- **Container Testing**: `docker-compose exec app-monexa php artisan test`

## Docker Development Standards
- **MANDATORY**: All Laravel artisan commands MUST be executed inside Docker container
- **Command Pattern**: `docker-compose exec app-monexa php artisan [command]`
- **Container Service**: Use `app-monexa` as main PHP-FPM container
- **Never Use**: Direct `php artisan` commands on host system

## Best Practices
- Use Eloquent relationships over raw SQL
- Implement proper error handling with try-catch
- Use database transactions for critical operations
- Apply middleware for route protection
- Utilize Laravel's localization features (tr locale)
- Emit events for cross-component communication in Livewire