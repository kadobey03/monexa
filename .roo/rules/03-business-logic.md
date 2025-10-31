# Business Logic & Security

## Financial Operations
- **Transactions**: Use database transactions for deposits/withdrawals
- **Balance Updates**: Always verify sufficient funds before operations
- **Currency**: Default currency from Settings model
- **Validation**: Financial amounts must be numeric, positive
- **Audit Trail**: Log all financial operations

## Lead Management System
- **User Model**: Contains lead_status, lead_score, assign_to fields
- **Assignment History**: Track admin assignments with LeadAssignmentHistory
- **Status Updates**: Use proper Turkish translations for lead statuses
- **Follow-ups**: Track next_follow_up_date and last_contact_date

## Security Patterns
- **CRON Protection**: All cron endpoints require CRON_KEY verification
- **KYC Middleware**: complete.kyc middleware for sensitive operations
- **2FA Support**: Optional via Fortify TwoFactorAuthenticatable
- **Email Verification**: Required for account activation
- **Input Sanitization**: Always validate and sanitize user inputs

## API Integrations
- **External APIs**: Use Http facade with proper error handling
- **Rate Limiting**: Apply throttling for external API calls
- **Fallback Data**: Provide default values when APIs fail
- **Logging**: Log API failures for monitoring

## Business Rules
- **Plans**: Investment plans have min/max limits, duration, profit rates
- **Referrals**: Commission system via ref_by field
- **Demo Mode**: Users can have demo_balance for testing
- **Multi-currency**: Support different currencies per user