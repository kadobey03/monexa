<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monexa Component Library - Showcase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ mix('resources/css/design-system/index.scss') }}">
</head>
<body class="bg-background p-8">
    <div class="max-w-7xl mx-auto space-y-12">

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-text-primary mb-4">
                Monexa Component Library
            </h1>
            <p class="text-lg text-text-secondary">
                Comprehensive UI components for fintech applications
            </p>
        </div>

        <!-- Design System Colors -->
        <x-layout.card title="Design System - Colors">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $colors = [
                        'primary-500' => '--primary-500',
                        'success-500' => '--success-500',
                        'warning-500' => '--warning-500',
                        'error-500' => '--error-500',
                        'info-500' => '--info-500',
                        'neutral-500' => '--neutral-500'
                    ];
                @endphp

                @foreach($colors as $name => $var)
                    <div class="text-center">
                        <div
                            class="w-16 h-16 rounded-lg mx-auto border-2 border-border"
                            style="background-color: var({{ $var }})"
                        ></div>
                        <p class="mt-2 text-sm font-medium text-text-primary">{{ $name }}</p>
                        <p class="text-xs text-text-secondary">{{ $var }}</p>
                    </div>
                @endforeach
            </div>
        </x-layout.card>

        <!-- Typography Scale -->
        <x-layout.card title="Typography Scale">
            <div class="space-y-4">
                @php
                    $textSizes = [
                        'text-xs' => 'Extra Small (12px)',
                        'text-sm' => 'Small (14px)',
                        'text-base' => 'Base (16px)',
                        'text-lg' => 'Large (18px)',
                        'text-xl' => 'Extra Large (20px)',
                        'text-2xl' => '2X Large (24px)',
                        'text-3xl' => '3X Large (30px)'
                    ];
                @endphp

                @foreach($textSizes as $class => $label)
                    <div>
                        <p class="{{ $class }} font-medium text-text-primary">
                            {{ $label }}
                        </p>
                        <p class="{{ $class }} text-text-secondary">
                            The quick brown fox jumps over the lazy dog.
                        </p>
                    </div>
                @endforeach
            </div>
        </x-layout.card>

        <!-- Buttons -->
        <x-layout.card title="Buttons">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Variants</h3>
                    <div class="flex flex-wrap gap-4">
                        <x-ui.button variant="primary">Primary</x-ui.button>
                        <x-ui.button variant="secondary">Secondary</x-ui.button>
                        <x-ui.button variant="outline">Outline</x-ui.button>
                        <x-ui.button variant="ghost">Ghost</x-ui.button>
                        <x-ui.button variant="success">Success</x-ui.button>
                        <x-ui.button variant="warning">Warning</x-ui.button>
                        <x-ui.button variant="error">Error</x-ui.button>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Sizes</h3>
                    <div class="flex flex-wrap items-center gap-4">
                        <x-ui.button size="xs">Extra Small</x-ui.button>
                        <x-ui.button size="sm">Small</x-ui.button>
                        <x-ui.button size="default">Default</x-ui.button>
                        <x-ui.button size="lg">Large</x-ui.button>
                        <x-ui.button size="xl">Extra Large</x-ui.button>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">With Icons</h3>
                    <div class="flex flex-wrap gap-4">
                        <x-ui.button icon="plus">Add Item</x-ui.button>
                        <x-ui.button icon="arrow-right" icon-position="right">Continue</x-ui.button>
                        <x-ui.button variant="outline" icon="cog" icon-position="right">Settings</x-ui.button>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Loading States</h3>
                    <div class="flex flex-wrap gap-4">
                        <x-ui.button :loading="true">Loading...</x-ui.button>
                        <x-ui.button variant="outline" :loading="true" loading>Processing</x-ui.button>
                    </div>
                </div>
            </div>
        </x-layout.card>

        <!-- Financial Components -->
        <x-layout.card title="Financial Components">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Amount Display</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-financial.amount-display :amount="1234.56" currency="USD" />
                        <x-financial.amount-display :amount="789.12" currency="EUR" size="lg" />
                        <x-financial.amount-display :amount="-456.78" currency="TRY" color="error" />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Transaction Status</h3>
                    <div class="flex flex-wrap gap-4">
                        <x-financial.transaction-status status="completed" />
                        <x-financial.transaction-status status="pending" />
                        <x-financial.transaction-status status="processing" />
                        <x-financial.transaction-status status="failed" />
                        <x-financial.transaction-status status="cancelled" />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Balance Cards</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-financial.balance-card :balance="15420.75" currency="USD" label="USD Balance" trend="up" />
                        <x-financial.balance-card :balance="2500.00" currency="EUR" label="EUR Balance" />
                        <x-financial.balance-card :balance="890.50" currency="TRY" label="TRY Balance" trend="down" />
                    </div>
                </div>
            </div>
        </x-layout.card>

        <!-- Form Components -->
        <x-layout.card title="Form Components">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Financial Input</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-forms.financial-input
                            name="amount_usd"
                            label="Amount (USD)"
                            currency="USD"
                            placeholder="Enter amount"
                        />

                        <x-forms.financial-input
                            name="amount_eur"
                            label="Amount (EUR)"
                            currency="EUR"
                            placeholder="Enter amount"
                            :error="'Amount must be greater than 10'"
                        />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">KYC Upload</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-forms.kyc-upload
                            type="identity"
                            :required="true"
                        />

                        <x-forms.kyc-upload
                            type="address"
                            :required="true"
                        />
                    </div>
                </div>
            </div>
        </x-layout.card>

        <!-- Data Display -->
        <x-layout.card title="Data Display Components">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Statistics Cards</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <x-data.stat-card value="125430" label="Total Balance" icon="currency-dollar" color="success" trend="up" />
                        <x-data.stat-card value="15" label="Active Plans" icon="chart-bar" color="primary" />
                        <x-data.stat-card value="89" label="Transactions" icon="arrows-right-left" color="info" />
                        <x-data.stat-card value="2.5" label="Avg. Return %" icon="trending-up" color="warning" trend="down" />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Transaction Table</h3>
                    <x-data.transaction-table
                        :transactions="[
                            (object)['id' => 1, 'type' => 'deposit', 'amount' => 5000.00, 'currency' => 'USD', 'status' => 'completed', 'created_at' => now()],
                            (object)['id' => 2, 'type' => 'withdrawal', 'amount' => 1250.00, 'currency' => 'USD', 'status' => 'pending', 'created_at' => now()->subHours(2)],
                            (object)['id' => 3, 'type' => 'deposit', 'amount' => 750.50, 'currency' => 'EUR', 'status' => 'failed', 'created_at' => now()->subHours(4)],
                        ]"
                    />
                </div>
            </div>
        </x-layout.card>

        <!-- Interactive Components -->
        <x-layout.card title="Interactive Components">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Tabs</h3>
                    <x-ui.tabs :tabs="[
                        'tab1' => ['label' => 'Overview', 'icon' => 'home', 'content' => '<div class=\"p-4 bg-surface rounded\">Tab 1 content with overview information.</div>'],
                        'tab2' => ['label' => 'Analytics', 'icon' => 'chart-bar', 'content' => '<div class=\"p-4 bg-surface rounded\">Tab 2 content with analytics and charts.</div>'],
                        'tab3' => ['label' => 'Settings', 'icon' => 'cog', 'content' => '<div class=\"p-4 bg-surface rounded\">Tab 3 content with configuration options.</div>']
                    ]" />
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Accordion</h3>
                    <x-ui.accordion :items="[
                        ['title' => 'What is Monexa?', 'content' => '<p class=\"text-text-secondary\">Monexa is a comprehensive fintech platform for investment and trading.</p>'],
                        ['title' => 'How do I get started?', 'content' => '<p class=\"text-text-secondary\">Sign up for an account and complete KYC verification to start trading.</p>'],
                        ['title' => 'What are the fees?', 'content' => '<p class=\"text-text-secondary\">We offer competitive fees starting from 0.1% per transaction.</p>']
                    ]" />
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Modal & Dropdowns</h3>
                    <div class="flex gap-4">
                        <x-ui.dropdown trigger="<x-ui.button variant='outline'>Dropdown Menu</x-ui.button>">
                            <a href="#" class="block px-4 py-2 text-sm text-text-primary hover:bg-surface-hover">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-text-primary hover:bg-surface-hover">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-text-primary hover:bg-surface-hover">Logout</a>
                        </x-ui.dropdown>

                        <x-ui.button x-on:click="$dispatch('open-modal', { id: 'demo-modal' })">
                            Open Modal
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </x-layout.card>

        <!-- Demo Modal -->
        <x-ui.modal id="demo-modal" title="Demo Modal" description="This is a demonstration of the modal component.">
            <div class="space-y-4">
                <p class="text-text-secondary">
                    This modal demonstrates the accessibility features and responsive design of our component library.
                </p>

                <div class="bg-surface p-4 rounded">
                    <h4 class="font-medium text-text-primary mb-2">Features:</h4>
                    <ul class="list-disc list-inside text-sm text-text-secondary space-y-1">
                        <li>WCAG 2.1 AA compliant</li>
                        <li>Responsive design</li>
                        <li>Keyboard navigation support</li>
                        <li>Screen reader compatible</li>
                    </ul>
                </div>
            </div>

            <x-slot name="footer">
                <x-ui.button variant="outline" x-on:click="$dispatch('close-modal', { id: 'demo-modal' })">
                    Cancel
                </x-ui.button>
                <x-ui.button variant="primary" x-on:click="$dispatch('close-modal', { id: 'demo-modal' })">
                    Confirm
                </x-ui.button>
            </x-slot>
        </x-ui.modal>

        <!-- Utility Components -->
        <x-layout.card title="Utility Components">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Icons</h3>
                    <div class="grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12 gap-4">
                        <div class="text-center">
                            <x-ui.icon name="home" class="w-8 h-8 mx-auto text-primary-500" />
                            <p class="mt-2 text-xs text-text-secondary">home</p>
                        </div>
                        <div class="text-center">
                            <x-ui.icon name="user" class="w-8 h-8 mx-auto text-primary-500" />
                            <p class="mt-2 text-xs text-text-secondary">user</p>
                        </div>
                        <div class="text-center">
                            <x-ui.icon name="cog" class="w-8 h-8 mx-auto text-primary-500" />
                            <p class="mt-2 text-xs text-text-secondary">cog</p>
                        </div>
                        <div class="text-center">
                            <x-ui.icon name="check" class="w-8 h-8 mx-auto text-success-500" />
                            <p class="mt-2 text-xs text-text-secondary">check</p>
                        </div>
                        <div class="text-center">
                            <x-ui.icon name="x-mark" class="w-8 h-8 mx-auto text-error-500" />
                            <p class="mt-2 text-xs text-text-secondary">x-mark</p>
                        </div>
                        <div class="text-center">
                            <x-ui.icon name="chevron-down" class="w-8 h-8 mx-auto text-text-secondary" />
                            <p class="mt-2 text-xs text-text-secondary">chevron-down</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Spinners</h3>
                    <div class="flex items-center gap-8">
                        <div class="text-center">
                            <x-ui.spinner size="sm" />
                            <p class="mt-2 text-sm text-text-secondary">Small</p>
                        </div>
                        <div class="text-center">
                            <x-ui.spinner size="default" />
                            <p class="mt-2 text-sm text-text-secondary">Default</p>
                        </div>
                        <div class="text-center">
                            <x-ui.spinner size="lg" />
                            <p class="mt-2 text-sm text-text-secondary">Large</p>
                        </div>
                        <div class="text-center">
                            <x-ui.spinner size="xl" color="white" class="bg-primary-500 p-2 rounded" />
                            <p class="mt-2 text-sm text-text-secondary">White</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-text-primary mb-4">Toast Notifications</h3>
                    <div class="space-y-2">
                        <x-ui.toast message="This is a success message!" type="success" />
                        <x-ui.toast message="This is a warning message!" type="warning" />
                        <x-ui.toast message="This is an error message!" type="error" />
                        <x-ui.toast message="This is an info message!" type="info" />
                    </div>
                </div>
            </div>
        </x-layout.card>

    </div>

    @livewireScripts
</body>
</html>