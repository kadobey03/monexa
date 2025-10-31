<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monexa Dashboard - Component Library Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ mix('resources/css/design-system/index.scss') }}">
</head>
<body class="bg-background">
    <x-layout.dashboard-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-text-primary">
                    {{ __('Financial Dashboard') }}
                </h1>
                <div class="flex items-center space-x-4">
                    <x-ui.button variant="outline" icon="cog">
                        {{ __('Settings') }}
                    </x-ui.button>
                    <x-ui.button variant="primary" icon="plus">
                        {{ __('New Transaction') }}
                    </x-ui.button>
                </div>
            </div>
        </x-slot>

        <x-slot name="sidebar">
            <!-- Navigation items would be injected here -->
        </x-slot>

        <div class="space-y-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-data.stat-card
                    value="125430.50"
                    label="{{ __('Total Balance') }}"
                    icon="currency-dollar"
                    color="success"
                    trend="up"
                />

                <x-data.stat-card
                    value="15"
                    label="{{ __('Active Plans') }}"
                    icon="chart-bar"
                    color="primary"
                />

                <x-data.stat-card
                    value="89"
                    label="{{ __('Total Transactions') }}"
                    icon="arrows-right-left"
                    color="info"
                />

                <x-data.stat-card
                    value="2.5"
                    label="{{ __('Avg. Return') }}"
                    icon="trending-up"
                    color="warning"
                    trend="down"
                />
            </div>

            <!-- Balance Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <x-financial.balance-card
                    :balance="15420.75"
                    currency="USD"
                    label="{{ __('USD Balance') }}"
                    trend="up"
                    :clickable="true"
                />

                <x-financial.balance-card
                    :balance="890.50"
                    currency="EUR"
                    label="{{ __('EUR Balance') }}"
                    :clickable="true"
                />

                <x-financial.balance-card
                    :balance="2500.00"
                    currency="TRY"
                    label="{{ __('TRY Balance') }}"
                    trend="down"
                    :clickable="true"
                />
            </div>

            <!-- Transaction Table -->
            <x-layout.card title="{{ __('Recent Transactions') }}">
                <x-data.transaction-table
                    :transactions="[
                        (object)['id' => 1, 'type' => 'deposit', 'amount' => 5000.00, 'currency' => 'USD', 'status' => 'completed', 'created_at' => now()],
                        (object)['id' => 2, 'type' => 'withdrawal', 'amount' => 1250.00, 'currency' => 'USD', 'status' => 'pending', 'created_at' => now()->subHours(2)],
                        (object)['id' => 3, 'type' => 'deposit', 'amount' => 750.50, 'currency' => 'EUR', 'status' => 'completed', 'created_at' => now()->subHours(4)],
                    ]"
                    :columns="[
                        'date' => ['label' => __('Date'), 'sortable' => true],
                        'type' => ['label' => __('Type'), 'sortable' => true],
                        'amount' => ['label' => __('Amount'), 'sortable' => true],
                        'status' => ['label' => __('Status'), 'sortable' => false],
                        'actions' => ['label' => __('Actions'), 'sortable' => false]
                    ]"
                />
            </x-layout.card>

            <!-- Forms Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Deposit Form -->
                <x-layout.card title="{{ __('Quick Deposit') }}">
                    <form class="space-y-6">
                        <x-forms.financial-input
                            name="deposit_amount"
                            label="{{ __('Deposit Amount') }}"
                            currency="USD"
                            :min="10"
                            :max="50000"
                            required="true"
                        />

                        <div class="flex space-x-3">
                            <x-ui.button variant="primary" type="submit" class="flex-1">
                                {{ __('Deposit Funds') }}
                            </x-ui.button>
                            <x-ui.button variant="outline" type="button">
                                {{ __('Cancel') }}
                            </x-ui.button>
                        </div>
                    </form>
                </x-layout.card>

                <!-- KYC Upload -->
                <x-layout.card title="{{ __('Complete Your Profile') }}">
                    <div class="space-y-4">
                        <x-forms.kyc-upload
                            type="identity"
                            :required="true"
                            :multiple="false"
                        />

                        <x-ui.button variant="outline" class="w-full">
                            {{ __('Upload Identity Document') }}
                        </x-ui.button>
                    </div>
                </x-layout.card>
            </div>

            <!-- Interactive Components Demo -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Tabs -->
                <x-layout.card title="{{ __('Account Overview') }}">
                    <x-ui.tabs :tabs="[
                        'overview' => ['label' => __('Overview'), 'icon' => 'home', 'content' => '<p>Account overview content...</p>'],
                        'transactions' => ['label' => __('Transactions'), 'icon' => 'arrows-right-left', 'content' => '<p>Transaction history...</p>'],
                        'settings' => ['label' => __('Settings'), 'icon' => 'cog', 'content' => '<p>Account settings...</p>']
                    ]" />
                </x-layout.card>

                <!-- Accordion -->
                <x-layout.card title="{{ __('FAQs') }}">
                    <x-ui.accordion :items="[
                        ['title' => __('How do I deposit funds?'), 'content' => '<p>You can deposit funds using bank transfer, credit card, or cryptocurrency...</p>'],
                        ['title' => __('What are the fees?'), 'content' => '<p>Deposit fees vary by method. Trading fees are 0.1% per transaction...</p>'],
                        ['title' => __('How do I withdraw?'), 'content' => '<p>Withdrawals are processed within 24 hours for approved accounts...</p>']
                    ]" />
                </x-layout.card>
            </div>

            <!-- Toast Notifications (Demo) -->
            <div class="fixed bottom-4 right-4 z-50 space-y-2">
                <x-ui.toast message="{{ __('Deposit successful! Funds added to your account.')}}" type="success" />
                <x-ui.toast message="{{ __('Please complete your KYC verification to unlock all features.')}}" type="warning" />
            </div>
        </div>
    </x-layout.dashboard-layout>

    @livewireScripts
</body>
</html>