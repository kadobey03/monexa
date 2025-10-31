# Modular Partial Sistem Mimarisi

## 1. Architecture Overview

### 1.1 Design Principles
- **Modular Design**: Her component bağımsız ve tekrar kullanılabilir
- **Single Responsibility**: Her component tek bir sorumluluğa sahip
- **Composition over Inheritance**: Blade components ile slots/props kullanımı
- **Configuration-Driven**: Tailwind-based styling system

### 1.2 Component Hierarchy Structure
```
Core Architecture Layers:
├── Foundation Layer (Base Components) - Tier 1
├── Business Layer (Domain-Specific) - Tier 2
├── Presentation Layer (UI Compositions) - Tier 3
└── Application Layer (Page Templates) - Tier 4
```

### 1.3 Integration Patterns
- **Composition over Inheritance**: Blade components with slots/props
- **Dependency Injection**: Service-based data binding
- **Event-Driven**: Livewire component communication
- **Configuration-Driven**: Tailwind-based styling system

### 1.4 Performance Considerations
- **Lazy Loading**: On-demand component loading
- **Caching Strategy**: Component template caching
- **Asset Optimization**: CSS/JS bundling per component type
- **Memory Management**: Efficient Livewire state handling

## 2. Component Classification System

### 2.1 Foundation Components (Tier 1)
**UI Primitives - Atomic Level**

#### Forms Components
```
components/ui/forms/
├── input.blade.php                 # Text, email, password variants
├── select.blade.php                # Single, multi-select dropdowns
├── checkbox.blade.php              # Boolean, checkbox groups
├── radio.blade.php                 # Single, radio groups
├── textarea.blade.php              # Basic, rich-text areas
├── file-upload.blade.php           # Single, multiple, drag-drop
├── date-picker.blade.php           # Date/time selection
├── range-slider.blade.php          # Numeric range inputs
└── form-group.blade.php            # Form field wrapper
```

#### Button Components
```
components/ui/buttons/
├── primary.blade.php               # Call-to-action buttons
├── secondary.blade.php             # Alternative actions
├── danger.blade.php                # Destructive actions
├── ghost.blade.php                 # Subtle actions
├── icon.blade.php                  # Icon-only buttons
├── loading.blade.php               # Loading state buttons
└── floating-action.blade.php       # FAB buttons
```

#### Feedback Components
```
components/ui/feedback/
├── alert.blade.php                 # Success, warning, error, info
├── toast.blade.php                 # Temporary notifications
├── badge.blade.php                 # Status indicators
├── spinner.blade.php               # Loading states
├── progress-bar.blade.php          # Progress indicators
├── skeleton.blade.php              # Content placeholders
└── empty-state.blade.php           # No data states
```

#### Layout Components
```
components/ui/layout/
├── container.blade.php             # Responsive containers
├── grid.blade.php                  # Layout grids
├── stack.blade.php                 # Vertical/horizontal stacks
├── divider.blade.php               # Section separators
├── card.blade.php                  # Content cards
├── modal.blade.php                 # Modal dialogs
└── drawer.blade.php                # Slide-out panels
```

### 2.2 Business Components (Tier 2)
**Domain-Specific - Molecular Level**

#### Trading Components
```
components/business/trading/
├── price-ticker.blade.php          # Live price display
├── trade-form.blade.php            # Buy/sell forms
├── chart-widget.blade.php          # TradingView integration
├── position-card.blade.php         # Trade position display
├── market-summary.blade.php        # Market overview
├── asset-selector.blade.php        # Trading instrument picker
├── risk-meter.blade.php            # Risk assessment display
└── trade-history-item.blade.php    # Individual trade record
```

#### Finance Components
```
components/business/finance/
├── balance-card.blade.php          # Account balance display
├── transaction-row.blade.php       # Transaction list item
├── deposit-form.blade.php          # Deposit workflows
├── withdrawal-form.blade.php       # Withdrawal workflows
├── currency-converter.blade.php    # Conversion utility
├── payment-method.blade.php        # Payment option display
├── fee-breakdown.blade.php         # Cost analysis
└── account-summary.blade.php       # Financial overview
```

#### KYC Components
```
components/business/kyc/
├── verification-status.blade.php   # KYC status display
├── document-upload.blade.php       # KYC document forms
├── identity-form.blade.php         # Identity verification
├── verification-progress.blade.php # Step indicator
├── document-preview.blade.php      # Document review
├── rejection-notice.blade.php      # KYC rejection info
└── compliance-badge.blade.php      # Compliance indicators
```

#### CRM Components
```
components/business/crm/
├── lead-card.blade.php             # Lead information display
├── contact-form.blade.php          # Lead contact forms
├── activity-timeline.blade.php     # Lead activity
├── assignment-widget.blade.php     # Lead assignment
├── lead-status-badge.blade.php     # Status indicators
├── follow-up-scheduler.blade.php   # Task scheduling
└── conversion-tracker.blade.php    # Lead conversion metrics
```

### 2.3 Layout Components (Tier 3)
**Structural - Organism Level**

#### Core Layouts
```
components/layouts/core/
├── app.blade.php                   # Main application layout
├── admin.blade.php                 # Admin panel layout
├── guest.blade.php                 # Public pages layout
├── modal-layout.blade.php          # Modal wrapper layout
├── print-layout.blade.php          # Print-friendly layout
└── email-layout.blade.php          # Email template layout
```

#### Navigation Components
```
components/layouts/navigation/
├── header.blade.php                # Site header
├── sidebar.blade.php               # Navigation sidebar
├── breadcrumb.blade.php            # Page breadcrumbs
├── mobile-nav.blade.php            # Mobile navigation
├── footer.blade.php                # Site footer
├── user-menu.blade.php             # User dropdown menu
└── admin-menu.blade.php            # Admin navigation menu
```

#### Dashboard Layouts
```
components/layouts/dashboard/
├── dashboard-header.blade.php      # Dashboard top section
├── widget-grid.blade.php           # Dashboard widget container
├── quick-actions.blade.php         # Dashboard shortcuts
├── recent-activity.blade.php       # Activity feed
├── stats-overview.blade.php        # Key metrics display
└── notification-panel.blade.php    # Notification center
```

### 2.4 Utility Components (Tier 4)
**Cross-cutting - Service Level**

#### Data Components
```
components/utilities/data/
├── data-table.blade.php            # Sortable, filterable tables
├── pagination.blade.php            # Page navigation
├── search-filter.blade.php         # Search/filter controls
├── export-controls.blade.php       # Data export options
├── bulk-actions.blade.php          # Mass operations
├── column-chooser.blade.php        # Table customization
└── data-summary.blade.php          # Summary statistics
```

#### Media Components
```
components/utilities/media/
├── image.blade.php                 # Responsive images
├── avatar.blade.php                # User avatars
├── gallery.blade.php               # Image galleries
├── video.blade.php                 # Video players
├── file-preview.blade.php          # File previews
└── media-uploader.blade.php        # Multi-media upload
```

#### Admin Components
```
components/utilities/admin/
├── admin-stats.blade.php           # Admin dashboard metrics
├── permission-gate.blade.php       # Role-based access
├── audit-log.blade.php             # Admin activity logging
├── system-health.blade.php         # System status monitoring
├── backup-controls.blade.php       # Backup management
└── maintenance-mode.blade.php      # Maintenance controls
```

## 3. Directory Structure Design

### 3.1 Organized File Structure
```
resources/views/
├── components/                     # Reusable Blade components
│   ├── ui/                        # Foundation UI components (Tier 1)
│   │   ├── forms/                 # Form elements
│   │   ├── buttons/               # Button variants
│   │   ├── feedback/              # User feedback
│   │   └── layout/                # Layout primitives
│   ├── business/                  # Business domain components (Tier 2)
│   │   ├── trading/               # Trading-specific
│   │   ├── finance/               # Financial operations
│   │   ├── kyc/                   # Know Your Customer
│   │   └── crm/                   # Customer relationship
│   ├── layouts/                   # Layout components (Tier 3)
│   │   ├── core/                  # Base layouts
│   │   ├── navigation/            # Navigation elements
│   │   └── dashboard/             # Dashboard layouts
│   └── utilities/                 # Utility components (Tier 4)
│       ├── data/                  # Data manipulation
│       ├── media/                 # Media handling
│       └── admin/                 # Admin utilities
├── partials/                      # Legacy partials (migration path)
│   ├── _deprecated/               # Components being phased out
│   └── _migration/                # Components in transition
├── pages/                         # Full page compositions
│   ├── auth/                      # Authentication pages
│   ├── dashboard/                 # Dashboard pages
│   ├── admin/                     # Admin panel pages
│   └── public/                    # Public facing pages
├── layouts/                       # Base layout templates
├── emails/                        # Email templates
└── errors/                        # Error page templates
```

### 3.2 Naming Conventions

#### Component Naming Pattern
```
{category}-{purpose}-{variant}.blade.php

Examples:
- ui-button-primary.blade.php
- business-trading-form.blade.php
- layout-dashboard-header.blade.php
- utility-data-table.blade.php
```

#### Directory Naming
- **kebab-case** for directories
- **Singular nouns** for component categories
- **Plural nouns** for collections (forms/, buttons/)

#### Component Props Naming
```php
// Consistent prop naming across components
$attributes = [
    'size' => 'sm|md|lg|xl',           // Size variants
    'variant' => 'primary|secondary',   // Style variants
    'state' => 'default|loading|error', // Component states
    'disabled' => true|false,           // Boolean props
];
```

### 3.3 Component Relationships

#### Dependency Flow
```
Page Templates → Layout Components → Business Components → UI Components

Example Dependency Chain:
dashboard/index.blade.php 
  ├─ layouts/dashboard-header.blade.php
  │   ├─ business/balance-card.blade.php
  │   │   ├─ ui/card.blade.php
  │   │   └─ ui/alert.blade.php
  │   └─ ui/button-primary.blade.php
  ├─ business/trading/chart-widget.blade.php
  │   ├─ ui/spinner.blade.php
  │   └─ ui/error-boundary.blade.php
  └─ layouts/dashboard/widget-grid.blade.php
      └─ utilities/data/pagination.blade.php
```

#### Import Strategy
```php
// Component composition example
// resources/views/pages/dashboard/index.blade.php
@extends('layouts.core.app')

@section('content')
    <x-layouts.dashboard.dashboard-header 
        :user="$user" 
        :balance="$balance" />
    
    <x-layouts.dashboard.widget-grid>
        <x-business.finance.balance-card 
            :balance="$balance"
            :currency="$currency" />
        
        <x-business.trading.chart-widget 
            :symbol="$activeSymbol" />
    </x-layouts.dashboard.widget-grid>
@endsection
```

## 4. Implementation Standards

### 4.1 Blade Component Conventions

#### Component Structure Template
```php
{{-- resources/views/components/ui/button/primary.blade.php --}}
@props([
    'size' => 'md',          // sm, md, lg, xl
    'variant' => 'solid',    // solid, outline, ghost
    'disabled' => false,     // boolean
    'loading' => false,      // boolean
    'href' => null,          // link behavior
    'type' => 'button',      // button type
])

@php
$classes = [
    'inline-flex items-center justify-center font-medium transition-colors',
    'focus:outline-none focus:ring-2 focus:ring-offset-2',
    
    // Size variants
    'text-sm px-4 py-2' => $size === 'sm',
    'text-base px-6 py-3' => $size === 'md',
    'text-lg px-8 py-4' => $size === 'lg',
    
    // Style variants
    'bg-blue-600 text-white hover:bg-blue-700' => $variant === 'solid',
    'border border-blue-600 text-blue-600 hover:bg-blue-50' => $variant === 'outline',
    
    // States
    'opacity-50 cursor-not-allowed' => $disabled,
    'cursor-wait' => $loading,
];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => collect($classes)->filter()->keys()->implode(' ')]) }}>
        @if($loading)
            <x-ui.feedback.spinner class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </a>
@else
    <button 
        type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => collect($classes)->filter()->keys()->implode(' ')]) }}>
        @if($loading)
            <x-ui.feedback.spinner class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </button>
@endif
```

### 4.2 Props/Slots Standards

#### Standard Props Interface
```php
// Every component should support these base props
@props([
    'id' => null,           // HTML id attribute
    'class' => '',          // Additional CSS classes
    'size' => 'md',         // Component size
    'variant' => 'default', // Style variant
    'disabled' => false,    // Disabled state
    'loading' => false,     // Loading state
    'data' => [],          // Data attributes
])
```

#### Named Slots Convention
```php
{{-- Component with named slots --}}
<x-ui.layout.card>
    <x-slot:header>
        <h3>Card Title</h3>
    </x-slot:header>
    
    <x-slot:actions>
        <x-ui.button.primary>Action</x-ui.button.primary>
    </x-slot:actions>
    
    {{-- Default slot --}}
    <p>Card content goes here</p>
</x-ui.layout.card>
```

### 4.3 Data Flow Patterns

#### Parent-Child Communication
```php
{{-- Parent component passing data --}}
<x-business.trading.trade-form 
    :instruments="$instruments"
    :balance="$userBalance"
    wire:model="selectedInstrument"
    @trade-submitted="handleTradeSubmit" />

{{-- Child component receiving data --}}
@props([
    'instruments' => collect(),
    'balance' => 0,
    'selectedInstrument' => null,
])

<form wire:submit.prevent="submitTrade">
    <x-ui.forms.select 
        :options="$instruments"
        wire:model="selectedInstrument" />
    
    <x-ui.forms.input 
        type="number"
        :max="$balance"
        wire:model="amount" />
        
    <x-ui.button.primary type="submit">
        Submit Trade
    </x-ui.button.primary>
</form>
```

#### Event Handling Patterns
```php
{{-- Component emitting events --}}
@script
<script>
    $wire.on('trade-completed', (data) => {
        // Handle successful trade
        showNotification('Trade completed successfully', 'success');
        refreshBalance();
    });
    
    $wire.on('trade-failed', (error) => {
        // Handle trade failure
        showNotification(error.message, 'error');
    });
</script>
@endscript
```

## 5. Integration Architecture Framework

### 5.1 Livewire Component Integration

#### Component Class Structure
```php
<?php
// app/Livewire/Business/Trading/TradeForm.php

namespace App\Livewire\Business\Trading;

use Livewire\Component;
use App\Services\Trading\TradeService;
use App\Models\TradingInstrument;

class TradeForm extends Component
{
    // Props
    public $instruments;
    public $userBalance;
    
    // State
    public $selectedInstrument;
    public $amount;
    public $orderType = 'buy';
    
    // Validation
    protected $rules = [
        'selectedInstrument' => 'required|exists:trading_instruments,id',
        'amount' => 'required|numeric|min:1',
        'orderType' => 'required|in:buy,sell',
    ];
    
    // Lifecycle
    public function mount($instruments, $userBalance)
    {
        $this->instruments = $instruments;
        $this->userBalance = $userBalance;
    }
    
    // Actions
    public function submitTrade(TradeService $tradeService)
    {
        $this->validate();
        
        try {
            $result = $tradeService->executeTrade([
                'instrument_id' => $this->selectedInstrument,
                'amount' => $this->amount,
                'order_type' => $this->orderType,
            ]);
            
            $this->dispatch('trade-completed', $result);
            $this->reset(['amount']);
            
        } catch (\Exception $e) {
            $this->dispatch('trade-failed', ['message' => $e->getMessage()]);
        }
    }
    
    public function render()
    {
        return view('components.business.trading.trade-form');
    }
}
```

### 5.2 Tailwind CSS Integration

#### Component-Specific Styling
```css
/* resources/css/components/ui/buttons.css */
@layer components {
    .btn-base {
        @apply inline-flex items-center justify-center font-medium transition-colors;
        @apply focus:outline-none focus:ring-2 focus:ring-offset-2;
        @apply disabled:opacity-50 disabled:cursor-not-allowed;
    }
    
    .btn-sm {
        @apply text-sm px-4 py-2 rounded-md;
    }
    
    .btn-md {
        @apply text-base px-6 py-3 rounded-lg;
    }
    
    .btn-lg {
        @apply text-lg px-8 py-4 rounded-xl;
    }
    
    .btn-primary {
        @apply btn-base bg-blue-600 text-white hover:bg-blue-700;
        @apply focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600;
    }
}
```

#### Theme Configuration
```js
// tailwind.config.js - Component variants
module.exports = {
    theme: {
        extend: {
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                },
                success: {
                    50: '#ecfdf5',
                    500: '#10b981',
                    600: '#059669',
                },
                // Fintech-specific colors
                trading: {
                    buy: '#10b981',
                    sell: '#ef4444',
                    neutral: '#6b7280',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
```

### 5.3 JavaScript Integration Patterns

#### Component JavaScript Organization
```js
// resources/js/components/business/trading/chart-widget.js
class ChartWidget {
    constructor(element, options = {}) {
        this.element = element;
        this.options = {
            symbol: 'BTCUSD',
            interval: '1m',
            theme: 'dark',
            ...options
        };
        
        this.init();
    }
    
    init() {
        this.createChart();
        this.bindEvents();
    }
    
    createChart() {
        // TradingView widget initialization
        new TradingView.widget({
            container_id: this.element.id,
            symbol: this.options.symbol,
            interval: this.options.interval,
            theme: this.options.theme,
        });
    }
    
    bindEvents() {
        // Component-specific event handling
        this.element.addEventListener('symbol-changed', (e) => {
            this.updateSymbol(e.detail.symbol);
        });
    }
    
    updateSymbol(symbol) {
        this.options.symbol = symbol;
        this.createChart();
    }
}

// Auto-initialize components
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-chart-widget]').forEach(element => {
        new ChartWidget(element, JSON.parse(element.dataset.chartOptions || '{}'));
    });
});
```

## 6. Scalability & Maintenance Framework

### 6.1 Growth Strategy

#### Horizontal Scaling
```
Component Expansion Path:
├── Add new business domains
│   ├── components/business/portfolio/
│   ├── components/business/analytics/
│   └── components/business/social/
├── Extend UI component variants
│   ├── components/ui/forms/advanced/
│   ├── components/ui/charts/
│   └── components/ui/animations/
└── Create specialized utilities
    ├── components/utilities/reporting/
    ├── components/utilities/integrations/
    └── components/utilities/mobile/
```

#### Vertical Scaling
```
Component Complexity Levels:
├── Simple (Single purpose, no state)
├── Complex (Multiple variants, internal state)
├── Compound (Multiple sub-components)
└── Smart (Connected to services, business logic)
```

### 6.2 Versioning Approach

#### Component Versioning Strategy
```php
// Version tracking in component
<?php
// app/View/Components/UI/Button/Primary.php

namespace App\View\Components\UI\Button;

use Illuminate\View\Component;

class Primary extends Component
{
    public const VERSION = '2.1.0';
    public const CHANGELOG = [
        '2.1.0' => 'Added loading state support',
        '2.0.0' => 'Breaking: Changed prop naming convention',
        '1.0.0' => 'Initial release',
    ];
    
    // Component implementation...
}
```

#### Migration Strategy
```php
// Component migration helper
// app/Services/ComponentMigration/MigrationService.php

class ComponentMigrationService
{
    public function migrateComponent($oldComponent, $newComponent)
    {
        // Automated migration logic
        $this->copyProps($oldComponent, $newComponent);
        $this->updateReferences($oldComponent, $newComponent);
        $this->validateMigration($newComponent);
    }
    
    public function generateMigrationReport()
    {
        return [
            'deprecated' => $this->getDeprecatedComponents(),
            'new' => $this->getNewComponents(),
            'breaking_changes' => $this->getBreakingChanges(),
        ];
    }
}
```

### 6.3 Documentation Requirements

#### Component Documentation Template
```php
{{-- 
Component: UI Button Primary
Version: 2.1.0
Author: Development Team
Last Updated: 2024-01-15

Description:
Primary action button with multiple size and state variants.

Usage:
<x-ui.button.primary size="md" :loading="$isLoading">
    Submit Form
</x-ui.button.primary>

Props:
- size: string (sm|md|lg|xl) - Button size variant
- variant: string (solid|outline|ghost) - Visual style
- disabled: bool - Disabled state
- loading: bool - Loading state with spinner
- href: string|null - Convert to link if provided
- type: string (button|submit|reset) - HTML button type

Slots:
- default: Button content

Examples:
@example('components.ui.button.primary.basic')
@example('components.ui.button.primary.loading')
@example('components.ui.button.primary.disabled')

Dependencies:
- x-ui.feedback.spinner (for loading state)

CSS Classes:
- .btn-primary (main styles)
- .btn-{size} (size variants)

JavaScript:
- None required

Changelog:
- v2.1.0: Added loading state support
- v2.0.0: Breaking: Changed prop naming convention  
- v1.0.0: Initial release
--}}
```

#### Auto-generated Documentation
```php
// Command to generate component documentation
// php artisan components:document

class ComponentDocumentationCommand extends Command
{
    public function handle()
    {
        $components = $this->discoverComponents();
        
        foreach ($components as $component) {
            $documentation = $this->generateDocumentation($component);
            $this->saveDocumentation($component, $documentation);
        }
        
        $this->generateComponentCatalog($components);
    }
    
    private function generateDocumentation($component)
    {
        return [
            'name' => $component->getName(),
            'version' => $component->getVersion(),
            'props' => $component->getProps(),
            'slots' => $component->getSlots(),
            'examples' => $component->getExamples(),
            'dependencies' => $component->getDependencies(),
        ];
    }
}
```

### 6.4 Quality Assurance Framework

#### Component Testing Strategy
```php
// tests/Feature/Components/UI/Button/PrimaryTest.php

class PrimaryButtonTest extends TestCase
{
    /** @test */
    public function it_renders_with_default_props()
    {
        $view = $this->blade('<x-ui.button.primary>Click Me</x-ui.button.primary>');
        
        $view->assertSee('Click Me');
        $view->assertSeeInOrder(['btn-primary', 'btn-md']);
    }
    
    /** @test */
    public function it_applies_size_variants()
    {
        $view = $this->blade('<x-ui.button.primary size="lg">Large Button</x-ui.button.primary>');
        
        $view->assertSee('btn-lg');
    }
    
    /** @test */
    public function it_shows_loading_state()
    {
        $view = $this->blade('<x-ui.button.primary :loading="true">Loading</x-ui.button.primary>');
        
        $view->assertSeeText('Loading');
        $view->assertSee('cursor-wait');
    }
}
```

#### Performance Monitoring
```php
// Component performance tracking
// app/Services/ComponentPerformance/PerformanceMonitor.php

class ComponentPerformanceMonitor
{
    public function trackComponentRender($componentName, $renderTime, $memoryUsage)
    {
        $this->metrics->record([
            'component' => $componentName,
            'render_time' => $renderTime,
            'memory_usage' => $memoryUsage,
            'timestamp' => now(),
        ]);
    }
    
    public function generatePerformanceReport()
    {
        return [
            'slowest_components' => $this->getSlowestComponents(),
            'memory_intensive' => $this->getMemoryIntensiveComponents(),
            'recommendations' => $this->getOptimizationRecommendations(),
        ];
    }
}
```

## Sonuç

Bu Modular Partial Sistem Mimarisi, Monexa finans platformunun frontend component yapısını:

1. **Sistematik olarak reorganize eder** - 4 katmanlı hierarchy ile
2. **Reusability'yi maksimize eder** - Standardized props/slots ile
3. **Maintainability'yi artırır** - Clear dependencies ve documentation ile
4. **Scalability sağlar** - Growth strategy ve versioning ile
5. **Performance optimize eder** - Lazy loading ve caching ile

Bu mimari, mevcut 150+ view dosyasını düzenli bir component sistemine dönüştürür ve gelecekteki genişleme ihtiyaçlarını karşılar.