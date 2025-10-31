# Monexa Finance Project Context

## Project Overview
- **Platform**: Laravel-based financial trading platform
- **Domain**: Fintech, investment, cryptocurrency, forex trading
- **Technologies**: Laravel 12, PHP 8.3+, Livewire 3, Jetstream, MySQL
- **Language**: Turkish (tr locale), some technical terms in English

## Core Features
- User authentication & KYC verification
- Investment plans & portfolio management
- Crypto trading & copy trading
- Lead management system (CRM)
- Real-time trading data
- Multi-currency support
- Payment integrations (Stripe, Paystack)

## Architecture Patterns
- Repository pattern in some areas
- Service layer for business logic  
- Observer pattern for model events
- Livewire components for real-time UI
- API integrations with external services

## Key Models & Relationships
- User (extends Authenticatable, has lead system)
- Settings (global configuration)
- Plans (investment plans)
- Deposits/Withdrawals (financial transactions)
- Admin (staff management)
- Lead management system

## Security Requirements
- KYC verification required
- 2FA support
- CRON endpoint protection with keys
- Email verification
- Input validation & sanitization