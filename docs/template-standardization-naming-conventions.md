# Template Standardizasyonu - Naming Convention Dokümantasyonu

> **Monexa Finans Platform** - Comprehensive Template Naming Standards  
> **Versiyon:** 1.0.0  
> **Tarih:** 31 Ekim 2024  
> **Hedef:** Consistent, scalable ve maintainable template structure

---

## İçindekiler

1. [Genel Prensipler](#genel-prensipler)
2. [File & Directory Structure Standards](#file--directory-structure-standards)
3. [Component Naming Framework](#component-naming-framework)
4. [Code-Level Naming Standards](#code-level-naming-standards)
5. [Integration Naming Standards](#integration-naming-standards)
6. [Domain-Specific Standards](#domain-specific-standards)
7. [Migration & Implementation Guidelines](#migration--implementation-guidelines)
8. [Quality Assurance Checkpoints](#quality-assurance-checkpoints)

---

## Genel Prensipler

### Core Philosophy
- **Consistency First**: Tüm dosya ve bileşenler için tutarlı naming
- **Scalability**: Büyük takımlar ve uzun vadeli bakım için uygun
- **Domain Clarity**: Fintech terminolojisine uygun, business-oriented naming
- **Developer Experience**: Kolay navigation ve quick identification
- **Modern Standards**: Laravel 11, Livewire 3, ve modern frontend best practices

### Naming Philosophy Matrix

```
┌──────────────────┬─────────────────┬─────────────────┬─────────────────┐
│ Context          │ Pattern         │ Example         │ Rationale       │
├──────────────────┼─────────────────┼─────────────────┼─────────────────┤
│ Files & Dirs     │ kebab-case      │ user-dashboard  │ URL-friendly    │
│ Components       │ kebab-case      │ balance-card    │ HTML standard   │
│ Classes/Methods  │ PascalCase      │ UserController  │ PSR standards   │
│ Variables        │ camelCase       │ accountBalance  │ JS/PHP standard │
│ Database         │ snake_case      │ user_id         │ SQL standard    │
│ Routes           │ kebab-case      │ account-profile │ RESTful         │
└──────────────────┴─────────────────┴─────────────────┴─────────────────┘
```

---

## 1. File & Directory Structure Standards

### 1.1 Blade View File Naming

#### **Standardization Rules**
```bash
# ✅ Correct Pattern
resources/views/user/
├── account-settings.blade.php    # kebab-case for multi-word
├── dashboard.blade.php           # single word lowercase
├── deposit-history.blade.php     # descriptive, kebab-case
└── trading-dashboard.blade.php   # domain-specific, clear

# ❌ Current Inconsistencies (Migrate These)
├── mplans.blade.php             → investment-plans.blade.php
├── mcopytradings.blade.php      → copy-trading-list.blade.php
├── subtrade.blade.php           → subscription-trading.blade.php
├── thistory.blade.php           → trading-history.blade.php
```

#### **Directory Organization Pattern**
```
resources/views/
├── auth/                        # Authentication views
│   ├── login.blade.php
│   ├── register.blade.php
│   └── forgot-password.blade.php
├── user/                        # User-facing views
│   ├── dashboard.blade.php
│   ├── profile/                 # Grouped functionality
│   │   ├── index.blade.php
│   │   ├── edit-profile.blade.php
│   │   └── security-settings.blade.php
│   ├── trading/                 # Business domain grouping
│   │   ├── dashboard.blade.php
│   │   ├── trade-execution.blade.php
│   │   └── trading-history.blade.php
│   └── financial/               # Financial operations
│       ├── deposit-form.blade.php
│       ├── withdrawal-form.blade.php
│       └── transaction-history.blade.php
├── admin/                       # Admin panel views
│   ├── dashboard.blade.php
│   ├── users/                   # Resource-based grouping
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   └── edit.blade.php
│   └── leads/                   # CRM functionality
│       ├── index.blade.php
│       ├── lead-detail.blade.php
│       └── assignment-history.blade.php
└── components/                  # Reusable components
    ├── ui/                      # Generic UI components
    ├── forms/                   # Form-specific components
    ├── financial/               # Finance-specific components
    └── admin/                   # Admin-specific components
```

### 1.2 Livewire Component Naming

#### **Component Structure Standard**
```bash
# Livewire Component Naming Pattern: {Domain}.{Feature}.{Action}
app/Http/Livewire/
├── User/
│   ├── CryptoPayment.php          # PascalCase class names
│   ├── InvestmentPlan.php         # Descriptive, clear purpose
│   ├── NotificationCenter.php     # Feature-focused
│   └── TradingDashboard.php       # Domain-specific
├── Admin/
│   ├── UserManagement.php
│   ├── TradingPayments.php
│   └── LeadAssignment.php
```

#### **View Files for Livewire**
```bash
resources/views/livewire/
├── user/
│   ├── crypto-payment.blade.php      # kebab-case for views
│   ├── investment-plan.blade.php     # matches component name
│   ├── notification-center.blade.php # consistent pattern
│   └── trading-dashboard.blade.php   # descriptive
├── admin/
│   ├── user-management.blade.php
│   ├── trading-payments.blade.php
│   └── lead-assignment.blade.php
```

### 1.3 Extension & File Type Conventions

```bash
# Template Files
*.blade.php      # Blade templates
*.vue           # Vue.js components (future migration)
*.jsx           # React components (if implemented)

# Style Files  
*.scss          # Sass files
*.css           # Compiled or utility CSS

# Script Files
*.js            # JavaScript
*.ts            # TypeScript (for future migrations)

# Config Files
*.config.js     # Configuration files (tailwind.config.js)
*.json          # JSON configurations
*.yaml          # YAML configurations
```

---

## 2. Component Naming Framework

### 2.1 Component Architecture Layers

#### **Layer 1: Foundation/UI Components**
```bash
components/ui/
├── alert.blade.php              # Generic alerts
├── button.blade.php             # Base button component
├── modal.blade.php              # Base modal wrapper
├── input.blade.php              # Form input base
├── dropdown.blade.php           # Dropdown component
├── tabs.blade.php               # Tab navigation
├── accordion.blade.php          # Accordion component
└── spinner.blade.php            # Loading indicators
```

#### **Layer 2: Forms & Input Components**
```bash
components/forms/
├── financial-input.blade.php    # Money/currency inputs
├── kyc-upload.blade.php         # Document upload component
├── select.blade.php             # Enhanced select component
├── date-picker.blade.php        # Date selection
├── currency-selector.blade.php  # Multi-currency support
└── validation-input.blade.php   # Input with validation UI
```

#### **Layer 3: Business Domain Components**
```bash
components/financial/
├── balance-card.blade.php       # Account balance display
├── transaction-status.blade.php # Status indicators
├── amount-display.blade.php     # Formatted amount display
├── profit-indicator.blade.php   # Profit/loss indicators
├── currency-converter.blade.php # Currency conversion
└── investment-summary.blade.php # Investment overview

components/trading/
├── trade-execution-form.blade.php
├── market-overview.blade.php
├── signal-indicator.blade.php
├── copy-trading-card.blade.php
└── trading-chart-wrapper.blade.php

components/admin/
├── lead-assignment-panel.blade.php
├── user-status-toggle.blade.php
├── kyc-verification-panel.blade.php
└── admin-action-buttons.blade.php
```

#### **Layer 4: Layout & Structure Components**
```bash
components/layout/
├── dashboard-layout.blade.php   # Main dashboard wrapper
├── card.blade.php               # Generic card container
├── sidebar-navigation.blade.php # Navigation component
├── header-actions.blade.php     # Header action buttons
├── breadcrumb.blade.php         # Navigation breadcrumb
└── footer.blade.php             # Footer component

components/data/
├── stat-card.blade.php          # Statistics display
├── transaction-table.blade.php  # Data table component
├── pagination-controls.blade.php
└── data-export-buttons.blade.php
```

### 2.2 Component Props & Slots Naming

#### **Props Naming Convention**
```php
// ✅ Correct: camelCase for props
@props([
    'accountBalance' => 0,
    'currencyCode' => 'USD',
    'showCurrencySymbol' => true,
    'isLoading' => false,
    'displayFormat' => 'standard'
])

// ❌ Avoid: snake_case or kebab-case in props
@props([
    'account_balance' => 0,      // ❌ snake_case
    'currency-code' => 'USD',    // ❌ kebab-case
])
```

#### **Slots Naming Convention**
```blade
{{-- ✅ Correct: kebab-case for slot names --}}
<x-financial.balance-card>
    <x-slot:header-actions>
        <button>Export</button>
    </x-slot>
    
    <x-slot:footer-content>
        <small>Last updated: {{ now() }}</small>
    </x-slot>
</x-financial.balance-card>
```

---

## 3. Code-Level Naming Standards

### 3.1 CSS Class Naming (Tailwind-Compatible)

#### **BEM-Inspired + Tailwind Integration**
```css
/* Component-specific classes */
.balance-card { }
.balance-card__amount { }
.balance-card__currency { }
.balance-card--highlighted { }

/* Utility class patterns */
.btn-primary { }
.btn-secondary { }
.btn--loading { }
.text-financial-positive { }    /* Green for profits */
.text-financial-negative { }    /* Red for losses */
.bg-trading-signal { }          /* Signal-specific background */
```

#### **Fintech-Specific Utility Classes**
```css
/* Financial Status Classes */
.status-pending { @apply bg-yellow-100 text-yellow-800; }
.status-approved { @apply bg-green-100 text-green-800; }
.status-rejected { @apply bg-red-100 text-red-800; }
.status-under-review { @apply bg-blue-100 text-blue-800; }

/* Trading Status Classes */
.trade-profit { @apply text-green-600 font-semibold; }
.trade-loss { @apply text-red-600 font-semibold; }
.trade-pending { @apply text-yellow-600 font-semibold; }

/* User Verification Levels */
.kyc-verified { @apply border-green-500 bg-green-50; }
.kyc-pending { @apply border-yellow-500 bg-yellow-50; }
.kyc-rejected { @apply border-red-500 bg-red-50; }
```

### 3.2 JavaScript Variable Naming

#### **Camelcase Convention**
```javascript
// ✅ Correct: camelCase for variables and functions
const accountBalance = 1000;
const userTradingHistory = [];
const isKycVerified = true;

function calculateProfitLoss(initialAmount, currentAmount) {
    return currentAmount - initialAmount;
}

function formatCurrencyAmount(amount, currencyCode) {
    return new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: currencyCode
    }).format(amount);
}

// Vue/Alpine.js data properties
Alpine.data('tradingDashboard', () => ({
    selectedAsset: 'BTCUSD',
    tradeAmount: 0,
    leverageRatio: 100,
    isExecutingTrade: false,
    
    executeTradeOrder() {
        this.isExecutingTrade = true;
        // Trade execution logic
    }
}));
```

### 3.3 Blade Directive & Helper Naming

```blade
{{-- ✅ Correct: Descriptive helper function names --}}
{{ formatCurrency($amount, $user->currency) }}
{{ calculateProfitPercentage($initial, $current) }}
{{ getKycStatusBadge($user->kyc_status) }}
{{ displayTradingSignalStrength($signal_value) }}

{{-- Custom Blade Directives --}}
@currencyInput($value, $currency)
@tradingChart($symbol, $timeframe)
@kycStatusIndicator($status)
@profitLossIndicator($amount, $percentage)
```

---

## 4. Integration Naming Standards

### 4.1 Route Naming Consistency

#### **RESTful Route Patterns**
```php
// User Routes - Feature-based grouping
Route::prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    // Trading Operations
    Route::prefix('trading')->name('trading.')->group(function () {
        Route::get('/', 'TradingController@index')->name('index');
        Route::get('/history', 'TradingController@history')->name('history');
        Route::post('/execute', 'TradingController@execute')->name('execute');
    });
    
    // Financial Operations
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/deposits', 'DepositController@index')->name('deposits.index');
        Route::post('/deposits', 'DepositController@store')->name('deposits.store');
        Route::get('/withdrawals', 'WithdrawalController@index')->name('withdrawals.index');
        Route::post('/withdrawals', 'WithdrawalController@store')->name('withdrawals.store');
    });
    
    // Profile & Settings
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'ProfileController@show')->name('show');
        Route::put('/update', 'ProfileController@update')->name('update');
        Route::get('/security', 'ProfileController@security')->name('security');
        Route::get('/kyc-verification', 'ProfileController@kyc')->name('kyc');
    });
});

// Admin Routes - Resource-based grouping
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    
    // User Management
    Route::resource('users', 'Admin\UserController')->names('users');
    Route::resource('leads', 'Admin\LeadController')->names('leads');
    
    // Financial Management  
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/deposits', 'Admin\DepositController@index')->name('deposits.index');
        Route::put('/deposits/{deposit}/approve', 'Admin\DepositController@approve')->name('deposits.approve');
        Route::get('/withdrawals', 'Admin\WithdrawalController@index')->name('withdrawals.index');
        Route::put('/withdrawals/{withdrawal}/process', 'Admin\WithdrawalController@process')->name('withdrawals.process');
    });
});
```

### 4.2 Controller Method Naming

```php
// ✅ RESTful Controller Methods
class UserTradingController extends Controller 
{
    public function index()              // GET /user/trading
    public function create()             // GET /user/trading/create  
    public function store(Request $request) // POST /user/trading
    public function show($id)            // GET /user/trading/{id}
    public function edit($id)            // GET /user/trading/{id}/edit
    public function update(Request $request, $id) // PUT /user/trading/{id}
    public function destroy($id)         // DELETE /user/trading/{id}
    
    // Custom business logic methods
    public function executeTrade(Request $request)
    public function calculateProfitLoss($tradeId) 
    public function getTradingHistory(Request $request)
    public function exportTradingData(Request $request)
}

// ✅ Admin Controller Methods  
class Admin\LeadController extends Controller
{
    // Standard CRUD
    public function index()
    public function show(Lead $lead)
    public function update(Request $request, Lead $lead)
    
    // Business-specific methods
    public function assignToAdmin(Request $request, Lead $lead)
    public function updateStatus(Request $request, Lead $lead)
    public function bulkAssign(Request $request)
    public function getAssignmentHistory(Lead $lead)
}
```

### 4.3 API Endpoint Naming

```php
// API Routes - Version-based + RESTful
Route::prefix('api/v1')->name('api.v1.')->group(function () {
    
    // Authentication
    Route::post('/auth/login', 'Api\AuthController@login')->name('auth.login');
    Route::post('/auth/logout', 'Api\AuthController@logout')->name('auth.logout');
    Route::post('/auth/refresh', 'Api\AuthController@refresh')->name('auth.refresh');
    
    // User Data
    Route::apiResource('users', 'Api\UserController')->names('users');
    
    // Financial Operations
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/account-balance', 'Api\FinancialController@getBalance')->name('balance');
        Route::get('/transaction-history', 'Api\FinancialController@getTransactions')->name('transactions');
        Route::post('/deposit-request', 'Api\FinancialController@createDeposit')->name('deposit');
        Route::post('/withdrawal-request', 'Api\FinancialController@createWithdrawal')->name('withdrawal');
    });
    
    // Trading Operations
    Route::prefix('trading')->name('trading.')->group(function () {
        Route::get('/active-trades', 'Api\TradingController@getActiveTrades')->name('active');
        Route::post('/execute-trade', 'Api\TradingController@executeTrade')->name('execute');
        Route::get('/trading-signals', 'Api\TradingController@getSignals')->name('signals');
        Route::get('/market-data/{symbol}', 'Api\TradingController@getMarketData')->name('market-data');
    });
});
```

---

## 5. Domain-Specific Standards

### 5.1 Fintech Terminology Standardization

#### **Financial Terms Dictionary**
```php
// ✅ Standardized Financial Terms
$standardTerms = [
    // Account & Balance
    'account_balance'     => 'Hesap Bakiyesi',
    'available_balance'   => 'Kullanılabilir Bakiye',
    'total_invested'      => 'Toplam Yatırım',
    'total_profit'        => 'Toplam Kar',
    'total_loss'          => 'Toplam Zarar',
    
    // Transaction Types
    'deposit'             => 'Para Yatırma',
    'withdrawal'          => 'Para Çekme', 
    'investment'          => 'Yatırım',
    'profit_distribution' => 'Kar Paylaşımı',
    'commission'          => 'Komisyon',
    'bonus'               => 'Bonus',
    
    // Trading Terms
    'buy_order'           => 'Alış Emri',
    'sell_order'          => 'Satış Emri',
    'leverage'            => 'Kaldıraç',
    'margin'              => 'Marj',
    'spread'              => 'Spread',
    'signal_strength'     => 'Sinyal Gücü',
    'copy_trading'        => 'Kopya Ticaret',
    
    // User Status
    'kyc_verified'        => 'KYC Doğrulandı',
    'kyc_pending'         => 'KYC Beklemede',
    'account_active'      => 'Hesap Aktif',
    'account_suspended'   => 'Hesap Askıya Alındı',
    
    // Investment Plans
    'investment_plan'     => 'Yatırım Planı',
    'plan_duration'       => 'Plan Süresi', 
    'expected_return'     => 'Beklenen Getiri',
    'minimum_investment'  => 'Minimum Yatırım',
    'maximum_investment'  => 'Maksimum Yatırım',
];
```

#### **Business Process Naming**
```php
// ✅ Clear Business Process Names
class Services
{
    // KYC & Verification
    public function processKycVerification($userId, $documents)
    public function approveKycDocuments($kycId)
    public function rejectKycApplication($kycId, $reason)
    
    // Trading Operations
    public function executeBuyOrder($userId, $symbol, $amount)
    public function executeSellOrder($userId, $symbol, $amount)
    public function calculateTradingProfitLoss($tradeId)
    public function processCopyTradingSignal($signalId, $followers)
    
    // Financial Operations
    public function processDepositRequest($userId, $amount, $method)
    public function approveWithdrawalRequest($withdrawalId)
    public function calculateInvestmentReturns($planId, $userId)
    public function distributeProfitShares($planId)
    
    // Lead Management
    public function assignLeadToAdmin($leadId, $adminId)
    public function updateLeadStatus($leadId, $status)
    public function trackLeadConversion($leadId)
    public function generateLeadReport($dateRange)
}
```

### 5.2 User Role & Permission Naming

```php
// ✅ Role-based Naming Convention
$roles = [
    'super_admin'    => 'Super Admin',
    'admin'          => 'Admin',
    'manager'        => 'Manager', 
    'lead_admin'     => 'Lead Admin',
    'finance_admin'  => 'Finance Admin',
    'support_agent'  => 'Support Agent',
    'user'           => 'Regular User',
    'verified_user'  => 'Verified User',
    'premium_user'   => 'Premium User',
];

$permissions = [
    // User Management
    'users.view'         => 'View Users',
    'users.create'       => 'Create Users', 
    'users.edit'         => 'Edit Users',
    'users.delete'       => 'Delete Users',
    'users.kyc_approve'  => 'Approve KYC',
    
    // Financial Operations
    'deposits.view'      => 'View Deposits',
    'deposits.approve'   => 'Approve Deposits',
    'withdrawals.view'   => 'View Withdrawals',
    'withdrawals.process' => 'Process Withdrawals',
    
    // Trading Management
    'trades.view'        => 'View Trades',
    'trades.manage'      => 'Manage Trades',
    'signals.create'     => 'Create Trading Signals',
    'signals.publish'    => 'Publish Trading Signals',
    
    // Lead Management
    'leads.view'         => 'View Leads',
    'leads.assign'       => 'Assign Leads',
    'leads.update'       => 'Update Lead Status',
    'leads.convert'      => 'Convert Leads',
];
```

### 5.3 Database Table & Column Naming

```sql
-- ✅ Consistent Database Naming (snake_case)
-- Users & Authentication
users
├── id
├── name
├── email
├── email_verified_at
├── kyc_status
├── kyc_verified_at
├── account_balance
├── total_invested
├── total_profit
├── referral_code
├── referred_by_id
├── created_at
└── updated_at

-- Financial Transactions
deposits
├── id
├── user_id
├── amount
├── currency_code
├── payment_method
├── transaction_reference
├── status
├── approved_by_admin_id
├── approved_at
├── created_at
└── updated_at

withdrawals
├── id  
├── user_id
├── amount
├── currency_code
├── withdrawal_method
├── bank_account_details
├── status
├── processed_by_admin_id
├── processed_at
├── created_at
└── updated_at

-- Trading Operations
trades
├── id
├── user_id
├── symbol
├── trade_type (buy/sell)
├── amount
├── leverage_ratio
├── entry_price
├── exit_price
├── profit_loss
├── status
├── executed_at
├── closed_at
├── created_at
└── updated_at

-- Investment Plans
investment_plans
├── id
├── name
├── description
├── minimum_amount
├── maximum_amount
├── duration_days
├── expected_return_percentage
├── risk_level
├── is_active
├── created_at
└── updated_at

-- Lead Management (CRM)
leads
├── id
├── name
├── email
├── phone
├── lead_source
├── lead_status
├── lead_score
├── assigned_to_admin_id
├── last_contact_date
├── next_follow_up_date
├── conversion_date
├── notes
├── created_at
└── updated_at

lead_assignment_history
├── id
├── lead_id
├── previous_admin_id
├── new_admin_id
├── assigned_by_admin_id
├── assignment_reason
├── assigned_at
└── created_at
```

---

## 6. Migration & Implementation Guidelines

### 6.1 Existing Code Update Procedures

#### **Phase 1: Critical Path Updates (Week 1-2)**
```bash
# High Priority - User-Facing Views
resources/views/user/
├── mplans.blade.php           → investment-plans.blade.php
├── mcopytradings.blade.php    → copy-trading-list.blade.php  
├── subtrade.blade.php         → subscription-trading.blade.php
├── thistory.blade.php         → trading-history.blade.php
├── withdrawals.blade.php      → withdrawal-history.blade.php

# Update corresponding routes
Route::get('/investment-plans', 'UserController@investmentPlans')->name('user.investment-plans');
Route::get('/copy-trading-list', 'UserController@copyTradingList')->name('user.copy-trading-list');
```

#### **Phase 2: Component Standardization (Week 3-4)**
```bash
# Livewire Component Migrations
app/Http/Livewire/User/
├── CryptoPayment.php          → ✅ Already correct
├── CryptoWithdraw.php         → CryptoWithdrawal.php (fix typo)
├── InvestmentPlan.php         → ✅ Already correct
├── NotificationsCount.php     → ✅ Already correct
├── SubscribeToSignal.php      → SignalSubscription.php
└── SystemCourses.php          → CourseManagement.php

# Create missing components following new standard
components/financial/
├── balance-card.blade.php
├── transaction-status.blade.php
└── amount-display.blade.php
```

#### **Phase 3: Route & Controller Cleanup (Week 5-6)**
```php
// Standardize inconsistent route names
// Before
Route::get('/mplans', 'UserController@mplans')->name('mplans');
Route::get('/myplans', 'UserController@myplans')->name('myplans');
Route::get('/mcopytradings', 'UserController@mcopytradings')->name('mcopytradings');

// After - Consistent RESTful naming
Route::prefix('investment')->name('investment.')->group(function () {
    Route::get('/plans', 'InvestmentController@index')->name('plans.index');
    Route::get('/my-plans', 'InvestmentController@userPlans')->name('plans.user');
});

Route::prefix('trading')->name('trading.')->group(function () {
    Route::get('/copy-trading', 'TradingController@copyTrading')->name('copy-trading.index');
});
```

### 6.2 New Code Creation Standards

#### **Component Creation Template**
```bash
# When creating new components, follow this structure:
php artisan make:livewire User/TradingDashboard
# Creates: app/Http/Livewire/User/TradingDashboard.php
# Creates: resources/views/livewire/user/trading-dashboard.blade.php

php artisan make:component Financial/BalanceCard
# Creates: app/View/Components/Financial/BalanceCard.php  
# Creates: resources/views/components/financial/balance-card.blade.php
```

#### **New View Creation Checklist**
```bash
✅ File name uses kebab-case
✅ Descriptive and clear purpose
✅ Grouped in appropriate subdirectory
✅ Follows business domain structure
✅ Uses standard component naming
✅ Includes proper @extends or component structure
✅ Has descriptive @section('title') 
```

### 6.3 Code Review Checklist

#### **Pre-Merge Checklist**
```
File Naming:
□ All new files follow kebab-case convention
□ Directory structure matches business domains
□ Component names are descriptive and clear
□ No abbreviations or unclear acronyms

Code Standards:
□ Classes use PascalCase
□ Methods use camelCase  
□ Variables use camelCase
□ CSS classes follow BEM-inspired convention
□ Database fields use snake_case

Routes & Controllers:
□ Routes follow RESTful conventions
□ Route names are descriptive and grouped
□ Controller methods have clear purposes
□ Proper route-controller-view alignment

Components:
□ Props use camelCase
□ Slots use kebab-case
□ Component organization follows layer structure
□ Reusable components are properly abstracted
```

---

## 7. Quality Assurance Checkpoints

### 7.1 Automated Checks

#### **Laravel Pint Configuration (.pint.json)**
```json
{
    "preset": "laravel",
    "rules": {
        "class_attributes_separation": true,
        "method_argument_space": {
            "on_multiline": "ensure_fully_multiline"
        },
        "no_unused_imports": true,
        "ordered_imports": {
            "sort_algorithm": "alpha"
        }
    }
}
```

#### **Custom Validation Rules**
```bash
# Create custom artisan commands for validation
php artisan make:command ValidateNamingConventions
php artisan validate:naming-conventions --check-views
php artisan validate:naming-conventions --check-components  
php artisan validate:naming-conventions --check-routes
```

### 7.2 Manual Review Process

#### **Code Review Template**
```markdown
## Naming Convention Review

### File Structure ✓/❌
- [ ] Files follow kebab-case convention
- [ ] Directory structure is logical and business-aligned
- [ ] Component placement follows layer architecture

### Component Standards ✓/❌  
- [ ] Component names are descriptive
- [ ] Props follow camelCase convention
- [ ] Slots follow kebab-case convention
- [ ] Components are properly categorized

### Route & Controller Standards ✓/❌
- [ ] Routes follow RESTful conventions
- [ ] Controller methods are appropriately named
- [ ] Route-Controller-View alignment is correct

### Domain Standards ✓/❌
- [ ] Fintech terminology is consistent
- [ ] Business processes are clearly named
- [ ] Database fields follow snake_case

### Additional Notes:
[Reviewer comments and suggestions]
```

### 7.3 Documentation Maintenance

#### **Living Documentation Process**
```bash
# Update documentation with each major change
docs/
├── template-standardization-naming-conventions.md  # This document
├── component-library.md                           # Component usage guide  
├── route-reference.md                            # Route documentation
├── fintech-terminology.md                        # Business term dictionary
└── migration-log.md                              # Change tracking
```

#### **Automated Documentation Generation**
```php
// Consider implementing automated docs generation
php artisan docs:generate-routes     // Generate route documentation
php artisan docs:generate-components // Generate component library
php artisan docs:validate-standards  // Check compliance
```

---

## 8. Implementation Roadmap

### 8.1 Timeline & Priorities

#### **Week 1-2: Foundation (Critical)**
- [ ] Rename high-traffic user views (mplans → investment-plans)
- [ ] Update corresponding routes and controllers
- [ ] Create missing financial components
- [ ] Document current inconsistencies

#### **Week 3-4: Component System (High)**  
- [ ] Standardize Livewire components
- [ ] Implement component layer architecture
- [ ] Create reusable UI component library
- [ ] Update admin panel components

#### **Week 5-6: Integration (Medium)**
- [ ] Standardize API endpoints
- [ ] Clean up route naming inconsistencies  
- [ ] Update JavaScript variable naming
- [ ] Implement CSS class standards

#### **Week 7-8: Quality Assurance (Medium)**
- [ ] Automated validation tools
- [ ] Code review process implementation
- [ ] Documentation updates
- [ ] Team training and onboarding

### 8.2 Success Metrics

```bash
# Before Implementation
❌ Mixed naming patterns: 67% inconsistency
❌ 43 files with unclear naming
❌ 12 different naming patterns across codebase
❌ Average 15 minutes to locate specific components

# After Implementation (Target)
✅ Consistent naming patterns: 95%+ compliance
✅ All files follow established conventions
✅ Single, unified naming system
✅ Average 3 minutes to locate components
✅ New developer onboarding time reduced by 50%
```

---

## Sonuç ve Faydalar

### Immediate Benefits
1. **Developer Productivity**: Kolay navigation ve component location
2. **Code Maintainability**: Tutarlı structure ile kolay maintenance
3. **Team Collaboration**: Clear conventions ile better teamwork
4. **Onboarding Speed**: New developers için faster learning curve

### Long-term Benefits
1. **Scalability**: Large codebase için sustainable growth
2. **Code Quality**: Consistent patterns ile better code quality
3. **Business Alignment**: Domain-specific naming ile better business understanding
4. **Future-Proofing**: Modern standards ile easier technology migrations

### Implementation Success Factors
- **Team Commitment**: Tüm team members'ın standards'a commitment'ı
- **Gradual Migration**: Step-by-step approach ile minimal disruption
- **Documentation**: Living documentation ile sürekli güncel tutma
- **Automation**: Automated tools ile consistency enforcement

---

**Bu dokümantasyon, Monexa Finans Platform'un template standardizasyonu için comprehensive guide'dır. Tüm development process'lerinde referans alınmalı ve sürekli güncellenmeli.**

**Version Control**: Bu dokümantasyon her major update'de versiyonlanmalı ve değişiklikler migration-log.md'de track edilmeli.