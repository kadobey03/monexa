# Code Mode Rules

## File Editing
- Can edit all file types
- Code writing and editing focused
- Implementation and bug fixes

## Laravel Code Standards
- **Controllers**: Single responsibility, resource methods
- **Models**: Eloquent relationships, proper accessors/mutators
- **Middleware**: Authentication chains, KYC checks
- **Services**: Business logic encapsulation
- **Livewire**: Real-time components, wire:model usage

## Security Implementation
- **Input Validation**: Always use Laravel validation rules
- **SQL Injection**: Use Eloquent ORM, avoid raw queries
- **CRON Endpoints**: CRON_KEY verification required
- **Financial Operations**: Database transactions mandatory
- **Logging**: Log sensitive operations for audit

## Financial Code Patterns
- **Balance Updates**: Verify funds before operations
- **Precision**: Use bcmath for financial calculations
- **Transactions**: Wrap in DB::transaction()
- **Lead Management**: Proper status tracking and history

## Livewire Specific
- **Real-time Updates**: Use wire:model for form binding
- **Performance**: Lazy loading, debounce for search
- **Validation**: Client-side + server-side validation
- **Events**: Emit events for cross-component communication

## Testing Requirements
- **Feature Tests**: For API endpoints and user flows
- **Unit Tests**: For business logic and calculations
- **Integration Tests**: For payment and external APIs
- **Security Tests**: For authentication and authorization
- **Container Testing**: Run tests inside container with `docker-compose exec app-monexa php artisan test`