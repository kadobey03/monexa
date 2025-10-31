# Monexa Fintech Platform - Component Library Documentation

## İçindekiler
- [Genel Bakış](#genel-bakış)
- [Design System](#design-system)
- [UI Components](#ui-components)
- [Form Components](#form-components)
- [Financial Components](#financial-components)
- [Layout Components](#layout-components)
- [Admin Components](#admin-components)
- [Accessibility Features](#accessibility-features)
- [Best Practices](#best-practices)

## Genel Bakış

Monexa platform'u, tutarlı kullanıcı deneyimi ve hızlı geliştirme için kapsamlı bir Blade component library'si kullanır. Tüm components'ler Tailwind CSS ve Livewire 3 ile uyumlu olarak tasarlanmıştır.

### Component Architecture
- **Reusable**: Tüm projede tekrar kullanılabilir
- **Consistent**: Tutarlı design patterns
- **Accessible**: WCAG 2.1 AA uyumlu
- **Responsive**: Mobile-first approach
- **Modular**: İhtiyaç duyulan özellikleri içerir

### Component Locations
```
resources/views/components/
├── ui/                 # Basic UI elements
├── forms/              # Form input components
├── financial/          # Finance-specific components
├── layout/             # Layout structure components
└── admin/              # Admin panel components
```

## Design System

### Color Palette
```css
/* Primary Colors */
--primary-50: #eff6ff;
--primary-100: #dbeafe;
--primary-500: #3b82f6;
--primary-600: #2563eb;
--primary-900: #1e3a8a;

/* Success Colors */
--success-50: #ecfdf5;
--success-100: #d1fae5;
--success-500: #10b981;
--success-600: #059669;
--success-900: #064e3b;

/* Warning Colors */
--warning-50: #fffbeb;
--warning-100: #fef3c7;
--warning-500: #f59e0b;
--warning-600: #d97706;
--warning-900: #78350f;

/* Error Colors */
--error-50: #fef2f2;
--error-100: #fee2e2;
--error-500: #ef4444;
--error-600: #dc2626;
--error-900: #7f1d1d;
```

### Typography Scale
```css
--text-xs: 0.75rem;      /* 12px */
--text-sm: 0.875rem;     /* 14px */
--text-base: 1rem;       /* 16px */
--text-lg: 1.125rem;     /* 18px */
--text-xl: 1.25rem;      /* 20px */
--text-2xl: 1.5rem;      /* 24px */
--text-3xl: 1.875rem;    /* 30px */
```

### Spacing System
```css
--spacing-1: 0.25rem;    /* 4px */
--spacing-2: 0.5rem;     /* 8px */
--spacing-4: 1rem;       /* 16px */
--spacing-6: 1.5rem;     /* 24px */
--spacing-8: 2rem;       /* 32px */
--spacing-12: 3rem;      /* 48px */
```

## UI Components

### Button Component
**Lokasyon**: [`resources/views/components/ui/button.blade.php`](resources/views/components/ui/button.blade.php)

**Kullanım:**
```html
<!-- Basic Button -->
<x-ui.button>Click Me</x-ui.button>

<!-- Primary Button -->
<x-ui.button variant="primary" size="lg">
    Primary Action
</x-ui.button>

<!-- Secondary Button -->
<x-ui.button variant="secondary" size="md">
    Secondary Action
</x-ui.button>

<!-- Outline Button -->
<x-ui.button variant="outline" size="sm">
    Outline Button
</x-ui.button>

<!-- Disabled Button -->
<x-ui.button disabled="true">
    Disabled Button
</x-ui.button>

<!-- Loading Button -->
<x-ui.button loading="true">
    <x-ui.spinner class="mr-2" />
    Processing...
</x-ui.button>

<!-- Button with Icon -->
<x-ui.button variant="primary">
    <x-ui.icon name="plus" class="mr-2" />
    Add New
</x-ui.button>
```

**Props:**
- `variant`: `primary`, `secondary`, `outline`, `danger` (default: `primary`)
- `size`: `sm`, `md`, `lg` (default: `md`)
- `disabled`: `true`, `false` (default: `false`)
- `loading`: `true`, `false` (default: `false`)
- `type`: `button`, `submit`, `reset` (default: `button`)

### Modal Component
**Lokasyon**: [`resources/views/components/ui/modal.blade.php`](resources/views/components/ui/modal.blade.php)

**Kullanım:**
```html
<!-- Basic Modal -->
<x-ui.modal wire:model="showModal" title="Confirm Transaction">
    <x-slot name="content">
        <p>Are you sure you want to proceed with this transaction?</p>
    </x-slot>
    
    <x-slot name="footer">
        <x-ui.button variant="secondary" wire:click="$set('showModal', false)">
            Cancel
        </x-ui.button>
        <x-ui.button variant="primary" wire:click="confirmTransaction">
            Confirm
        </x-ui.button>
    </x-slot>
</x-ui.modal>

<!-- Large Modal with Custom Width -->
<x-ui.modal wire:model="showDetailsModal" title="Transaction Details" size="lg">
    <div class="space-y-4">
        <!-- Modal content -->
    </div>
</x-ui.modal>
```

**Props:**
- `title`: Modal başlığı (required)
- `size`: `sm`, `md`, `lg`, `xl` (default: `md`)
- `closable`: `true`, `false` (default: `true`)
- `wire:model`: Livewire property for show/hide state

### Alert Component
**Lokasyon**: [`resources/views/components/ui/alert.blade.php`](resources/views/components/ui/alert.blade.php)

**Kullanım:**
```html
<!-- Success Alert -->
<x-ui.alert type="success" title="Transaction Successful">
    Your deposit of $500.00 has been processed successfully.
</x-ui.alert>

<!-- Error Alert -->
<x-ui.alert type="error" title="Validation Error" dismissible="true">
    Please check the form fields and try again.
</x-ui.alert>

<!-- Warning Alert -->
<x-ui.alert type="warning" title="KYC Required">
    <p>Your account requires KYC verification to continue.</p>
    <x-ui.button variant="outline" size="sm" class="mt-2">
        Complete KYC
    </x-ui.button>
</x-ui.alert>

<!-- Info Alert -->
<x-ui.alert type="info" title="System Maintenance">
    Scheduled maintenance will occur on Sunday at 2:00 AM UTC.
</x-ui.alert>
```

**Props:**
- `type`: `success`, `error`, `warning`, `info` (default: `info`)
- `title`: Alert başlığı (optional)
- `dismissible`: `true`, `false` (default: `false`)

### Toast Notification
**Lokasyon**: [`resources/views/components/ui/toast.blade.php`](resources/views/components/ui/toast.blade.php)

**Kullanım:**
```html
<!-- Success Toast -->
<x-ui.toast type="success" message="Transaction completed successfully" />

<!-- Error Toast -->
<x-ui.toast type="error" message="An error occurred while processing your request" />

<!-- Toast with Action -->
<x-ui.toast type="info" message="New investment opportunity available">
    <x-slot name="action">
        <x-ui.button variant="outline" size="sm">
            View Details
        </x-ui.button>
    </x-slot>
</x-ui.toast>
```

### Dropdown Component
**Lokasyon**: [`resources/views/components/ui/dropdown.blade.php`](resources/views/components/ui/dropdown.blade.php)

**Kullanım:**
```html
<!-- Basic Dropdown -->
<x-ui.dropdown>
    <x-slot name="trigger">
        <x-ui.button variant="secondary">
            Options
            <x-ui.icon name="chevron-down" class="ml-2" />
        </x-ui.button>
    </x-slot>
    
    <x-slot name="content">
        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
            Edit Profile
        </a>
        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
            Account Settings
        </a>
        <hr class="my-1">
        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
            Sign Out
        </a>
    </x-slot>
</x-ui.dropdown>
```

### Icon Component
**Lokasyon**: [`resources/views/components/ui/icon.blade.php`](resources/views/components/ui/icon.blade.php)

**Kullanım:**
```html
<!-- Basic Icons -->
<x-ui.icon name="user" />
<x-ui.icon name="home" class="w-5 h-5" />
<x-ui.icon name="settings" class="text-blue-500" />

<!-- Icons with Custom Size -->
<x-ui.icon name="chart-bar" size="lg" />
<x-ui.icon name="bell" size="sm" />

<!-- Available Icons -->
<!-- user, home, settings, chart-bar, bell, plus, minus, check, 
     cross, arrow-up, arrow-down, chevron-left, chevron-right -->
```

## Form Components

### Financial Input Component
**Lokasyon**: [`resources/views/components/forms/financial-input.blade.php`](resources/views/components/forms/financial-input.blade.php)

**Kullanım:**
```html
<!-- Basic Financial Input -->
<x-forms.financial-input
    wire:model="amount"
    name="amount"
    label="Investment Amount"
    currency="USD"
    required />

<!-- Financial Input with Min/Max -->
<x-forms.financial-input
    wire:model="depositAmount"
    name="deposit_amount"
    label="Deposit Amount"
    currency="USD"
    :min="50"
    :max="10000"
    placeholder="Enter amount between $50 - $10,000"
    help-text="Minimum deposit amount is $50" />

<!-- Multiple Currency Support -->
<x-forms.financial-input
    wire:model="withdrawalAmount"
    name="withdrawal_amount"
    label="Withdrawal Amount"
    :currency="$user->currency"
    :balance="$user->account_bal"
    show-balance="true" />
```

**Props:**
- `name`: Input name (required)
- `label`: Field label (required)
- `currency`: Currency code (`USD`, `EUR`, `GBP`) (default: `USD`)
- `min`: Minimum amount (optional)
- `max`: Maximum amount (optional)
- `balance`: User's available balance (optional)
- `show-balance`: Show balance below input (default: `false`)
- `placeholder`: Placeholder text (optional)
- `help-text`: Help text below input (optional)
- `required`: Required field (default: `false`)

### KYC Upload Component
**Lokasyon**: [`resources/views/components/forms/kyc-upload.blade.php`](resources/views/components/forms/kyc-upload.blade.php)

**Kullanım:**
```html
<!-- Identity Document Upload -->
<x-forms.kyc-upload
    wire:model="identityFront"
    type="identity_front"
    label="Identity Document (Front)"
    accept="image/*,.pdf"
    max-size="5MB"
    required />

<!-- Multiple File Upload -->
<x-forms.kyc-upload
    wire:model="addressProof"
    type="address_proof"
    label="Address Proof Documents"
    accept="image/*,.pdf"
    multiple="true"
    max-files="3"
    help-text="Upload utility bills, bank statements, or official documents" />

<!-- Drag & Drop Upload -->
<x-forms.kyc-upload
    wire:model="selfie"
    type="selfie"
    label="Selfie with ID"
    accept="image/*"
    drag-drop="true"
    preview="true" />
```

**Props:**
- `type`: Upload type (`identity_front`, `identity_back`, `address_proof`, `selfie`)
- `label`: Field label (required)
- `accept`: File types accepted (default: `image/*,.pdf`)
- `max-size`: Maximum file size (default: `5MB`)
- `max-files`: Maximum number of files (default: `1`)
- `multiple`: Allow multiple files (default: `false`)
- `drag-drop`: Enable drag & drop (default: `true`)
- `preview`: Show image preview (default: `true`)
- `required`: Required field (default: `false`)

### Input Component
**Lokasyon**: [`resources/views/components/forms/input.blade.php`](resources/views/components/forms/input.blade.php)

**Kullanım:**
```html
<!-- Text Input -->
<x-forms.input
    wire:model="name"
    name="name"
    label="Full Name"
    placeholder="Enter your full name"
    required />

<!-- Email Input -->
<x-forms.input
    wire:model="email"
    type="email"
    name="email"
    label="Email Address"
    autocomplete="email"
    required />

<!-- Password Input -->
<x-forms.input
    wire:model="password"
    type="password"
    name="password"
    label="Password"
    show-toggle="true"
    required />

<!-- Phone Input with Country Code -->
<x-forms.input
    wire:model="phone"
    type="tel"
    name="phone"
    label="Phone Number"
    prefix="+1"
    placeholder="123 456 7890" />
```

### Select Component
**Lokasyon**: [`resources/views/components/forms/select.blade.php`](resources/views/components/forms/select.blade.php)

**Kullanım:**
```html
<!-- Basic Select -->
<x-forms.select
    wire:model="country"
    name="country"
    label="Country"
    :options="$countries"
    placeholder="Select your country"
    required />

<!-- Multi-Select -->
<x-forms.select
    wire:model="interests"
    name="interests"
    label="Investment Interests"
    :options="$investmentTypes"
    multiple="true"
    searchable="true" />

<!-- Select with Custom Option Format -->
<x-forms.select
    wire:model="planId"
    name="plan_id"
    label="Investment Plan">
    
    <option value="">Choose a plan...</option>
    @foreach($plans as $plan)
        <option value="{{ $plan->id }}">
            {{ $plan->name }} ({{ $plan->min_price }} - {{ $plan->max_price }})
        </option>
    @endforeach
</x-forms.select>
```

## Financial Components

### Amount Display Component
**Lokasyon**: [`resources/views/components/financial/amount-display.blade.php`](resources/views/components/financial/amount-display.blade.php)

**Kullanım:**
```html
<!-- Basic Amount Display -->
<x-financial.amount-display 
    :amount="1250.50"
    currency="USD" />

<!-- Amount with Symbol -->
<x-financial.amount-display 
    :amount="user()->account_bal"
    currency="USD"
    show-symbol="true"
    size="lg" />

<!-- Colored Amount (Profit/Loss) -->
<x-financial.amount-display 
    :amount="profit"
    currency="USD"
    :colored="true"
    show-change="true" />

<!-- Amount with Prefix/Suffix -->
<x-financial.amount-display 
    :amount="monthlyReturn"
    currency="USD"
    prefix="+"
    suffix="/month"
    class="text-green-600" />
```

**Props:**
- `amount`: Numeric amount (required)
- `currency`: Currency code (default: `USD`)
- `show-symbol`: Show currency symbol (default: `false`)
- `size`: `sm`, `md`, `lg`, `xl` (default: `md`)
- `colored`: Auto-color based on positive/negative (default: `false`)
- `show-change`: Show +/- prefix (default: `false`)
- `prefix`: Custom prefix text (optional)
- `suffix`: Custom suffix text (optional)

### Balance Card Component
**Lokasyon**: [`resources/views/components/financial/balance-card.blade.php`](resources/views/components/financial/balance-card.blade.php)

**Kullanım:**
```html
<!-- Basic Balance Card -->
<x-financial.balance-card
    :balance="auth()->user()->account_bal"
    currency="USD"
    label="Available Balance" />

<!-- Balance Card with Actions -->
<x-financial.balance-card
    :balance="user()->demo_balance"
    currency="USD"
    label="Demo Balance"
    icon="chart-line"
    show-actions="true">
    
    <x-slot name="actions">
        <x-ui.button variant="primary" size="sm">
            Start Trading
        </x-ui.button>
        <x-ui.button variant="outline" size="sm">
            Reset Demo
        </x-ui.button>
    </x-slot>
</x-financial.balance-card>

<!-- Balance Card with Trend -->
<x-financial.balance-card
    :balance="totalProfit"
    currency="USD"
    label="Total Profit"
    :trend="12.5"
    trend-period="This Month"
    variant="success" />
```

**Props:**
- `balance`: Balance amount (required)
- `currency`: Currency code (default: `USD`)
- `label`: Card label (required)
- `icon`: Icon name (optional)
- `variant`: `default`, `success`, `warning`, `danger` (default: `default`)
- `trend`: Percentage change (optional)
- `trend-period`: Trend time period (optional)
- `show-actions`: Show action slot (default: `false`)

### Transaction Status Component
**Lokasyon**: [`resources/views/components/financial/transaction-status.blade.php`](resources/views/components/financial/transaction-status.blade.php)

**Kullanım:**
```html
<!-- Basic Status Badge -->
<x-financial.transaction-status 
    status="completed"
    show-icon="true" />

<!-- Status with Custom Text -->
<x-financial.transaction-status 
    status="pending"
    text="Processing Payment"
    show-icon="true" />

<!-- Detailed Status -->
<x-financial.transaction-status 
    status="approved"
    show-icon="true"
    show-timestamp="true"
    :timestamp="$deposit->approved_at" />

<!-- All Available Statuses -->
<div class="space-y-2">
    <x-financial.transaction-status status="pending" />
    <x-financial.transaction-status status="approved" />
    <x-financial.transaction-status status="completed" />
    <x-financial.transaction-status status="declined" />
    <x-financial.transaction-status status="cancelled" />
    <x-financial.transaction-status status="processing" />
</div>
```

**Props:**
- `status`: Transaction status (required)
- `text`: Custom status text (optional)
- `show-icon`: Show status icon (default: `true`)
- `show-timestamp`: Show timestamp (default: `false`)
- `timestamp`: Timestamp value (optional)
- `size`: `sm`, `md`, `lg` (default: `md`)

## Layout Components

### Dashboard Layout
**Lokasyon**: [`resources/views/components/layout/dashboard-layout.blade.php`](resources/views/components/layout/dashboard-layout.blade.php)

**Kullanım:**
```html
<x-layout.dashboard-layout>
    <x-slot name="sidebar">
        <nav class="space-y-2">
            <a href="/dashboard" class="flex items-center px-3 py-2 rounded-md">
                <x-ui.icon name="home" class="mr-3" />
                Dashboard
            </a>
            <a href="/investments" class="flex items-center px-3 py-2 rounded-md">
                <x-ui.icon name="chart-bar" class="mr-3" />
                Investments
            </a>
        </nav>
    </x-slot>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <x-ui.button variant="primary">
                New Investment
            </x-ui.button>
        </div>
    </x-slot>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Dashboard content -->
    </div>
</x-layout.dashboard-layout>
```

### Card Component
**Lokasyon**: [`resources/views/components/layout/card.blade.php`](resources/views/components/layout/card.blade.php)

**Kullanım:**
```html
<!-- Basic Card -->
<x-layout.card title="Transaction History">
    <div class="space-y-4">
        <!-- Card content -->
    </div>
</x-layout.card>

<!-- Card with Subtitle and Actions -->
<x-layout.card 
    title="Investment Portfolio" 
    subtitle="Your active investments and returns">
    
    <x-slot name="actions">
        <x-ui.button variant="outline" size="sm">
            View All
        </x-ui.button>
    </x-slot>
    
    <div class="space-y-4">
        <!-- Portfolio content -->
    </div>
</x-layout.card>

<!-- Loading Card -->
<x-layout.card title="Account Balance" loading="true">
    <x-ui.spinner class="mx-auto" />
</x-layout.card>
```

## Admin Components

### Data Table Component
**Lokasyon**: [`resources/views/components/admin/data-table.blade.php`](resources/views/components/admin/data-table.blade.php)

**Kullanım:**
```html
<x-admin.data-table
    :headers="['Name', 'Email', 'Status', 'Actions']"
    :data="$users"
    searchable="true"
    sortable="true">
    
    <x-slot name="row" slot-scope="{ user }">
        <td class="px-4 py-2">{{ $user->name }}</td>
        <td class="px-4 py-2">{{ $user->email }}</td>
        <td class="px-4 py-2">
            <x-financial.transaction-status :status="$user->status" />
        </td>
        <td class="px-4 py-2">
            <x-ui.dropdown>
                <x-slot name="trigger">
                    <x-ui.button variant="outline" size="sm">
                        Actions
                    </x-ui.button>
                </x-slot>
                <x-slot name="content">
                    <a href="#" class="block px-4 py-2">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600">Delete</a>
                </x-slot>
            </x-ui.dropdown>
        </td>
    </x-slot>
</x-admin.data-table>
```

## Accessibility Features

### WCAG 2.1 AA Compliance
- **Keyboard Navigation**: Tab, Shift+Tab, Enter, Space, Arrow keys
- **Screen Reader Support**: Proper ARIA labels ve descriptions
- **Color Contrast**: 4.5:1 ratio for normal text, 3:1 for large text
- **Focus Management**: Visible focus indicators ve trap management

### Keyboard Shortcuts
```html
<!-- Modal -->
<x-ui.modal wire:model="showModal">
    <!-- Escape key closes modal -->
    <!-- Tab cycles through focusable elements -->
    <!-- Enter/Space activates buttons -->
</x-ui.modal>

<!-- Dropdown -->
<x-ui.dropdown>
    <!-- Arrow keys navigate options -->
    <!-- Enter selects option -->
    <!-- Escape closes dropdown -->
</x-ui.dropdown>
```

### Screen Reader Support
```html
<!-- Semantic HTML -->
<x-ui.button role="button" aria-label="Close modal">
    <x-ui.icon name="cross" aria-hidden="true" />
</x-ui.button>

<!-- Status Announcements -->
<x-ui.toast type="success" role="status" aria-live="polite">
    Transaction completed successfully
</x-ui.toast>

<!-- Form Labels -->
<x-forms.input
    name="amount"
    label="Investment Amount"
    aria-describedby="amount-help" />
<div id="amount-help" class="text-sm text-gray-600">
    Minimum amount is $50
</div>
```

## Best Practices

### Component Usage Guidelines

#### 1. Consistent Naming
```html
<!-- ✅ Good: Descriptive, consistent naming -->
<x-financial.amount-display :amount="$balance" />
<x-forms.financial-input name="deposit_amount" />

<!-- ❌ Bad: Generic, inconsistent naming -->
<x-money-display :value="$balance" />
<x-input-financial name="depositAmount" />
```

#### 2. Prop Validation
```html
<!-- ✅ Good: Type-safe props -->
<x-financial.amount-display 
    :amount="(float) $user->balance"
    currency="USD" />

<!-- ❌ Bad: Unvalidated props -->
<x-financial.amount-display 
    amount="{{ $user->balance }}"
    currency="{{ $currency ?? 'USD' }}" />
```

#### 3. Accessibility First
```html
<!-- ✅ Good: Accessible component usage -->
<x-ui.button
    wire:click="processPayment"
    aria-label="Process payment of ${{ $amount }}"
    :disabled="$processing">
    
    @if($processing)
        <x-ui.spinner class="mr-2" aria-hidden="true" />
        Processing...
    @else
        Process Payment
    @endif
</x-ui.button>

<!-- ❌ Bad: Missing accessibility -->
<x-ui.button wire:click="processPayment">
    Process
</x-ui.button>
```

#### 4. Responsive Design
```html
<!-- ✅ Good: Mobile-first responsive -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-financial.balance-card :balance="$balance" />
    <x-financial.balance-card :balance="$profit" />
    <x-financial.balance-card :balance="$total" />
</div>

<!-- ❌ Bad: Fixed layout -->
<div class="flex space-x-4">
    <x-financial.balance-card :balance="$balance" />
    <x-financial.balance-card :balance="$profit" />
</div>
```

#### 5. Error Handling
```html
<!-- ✅ Good: Comprehensive error handling -->
<x-forms.financial-input
    wire:model="amount"
    name="amount"
    label="Investment Amount"
    :error="$errors->first('amount')"
    required />

@error('amount')
    <x-ui.alert type="error" :message="$message" />
@enderror

<!-- ❌ Bad: No error handling -->
<x-forms.financial-input
    wire:model="amount"
    name="amount"
    label="Investment Amount" />
```

### Performance Optimization

#### 1. Lazy Loading
```html
<!-- ✅ Good: Lazy load heavy components -->
<div x-data="{ show: false }" x-intersect="show = true">
    <template x-if="show">
        <x-admin.data-table :data="$largeDataset" />
    </template>
</div>

<!-- ✅ Good: Conditional rendering -->
@if($showChart)
    <x-financial.trading-chart :data="$chartData" />
@endif
```

#### 2. Caching
```html
<!-- ✅ Good: Cache expensive components -->
@cache('user-balance-' . auth()->id(), now()->addMinutes(5))
    <x-financial.balance-card :balance="$user->calculateBalance()" />
@endcache
```

### Testing Components

#### Unit Testing
```php
// tests/Feature/ComponentTest.php
public function test_financial_amount_display_renders_correctly()
{
    $view = $this->blade('<x-financial.amount-display :amount="1250.50" currency="USD" />');
    
    $view->assertSee('$1,250.50');
    $view->assertSee('USD');
}

public function test_button_component_handles_loading_state()
{
    $view = $this->blade('<x-ui.button loading="true">Save</x-ui.button>');
    
    $view->assertSee('Save');
    $view->assertSeeHtml('<svg'); // Spinner icon
}
```

---

**Son Güncelleme**: 31 Ekim 2025  
**Component Library Versiyon**: 2.0  
**Storybook**: [Component Showcase](./storybook/index.html)