@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', 'Demo Ticaret Geçmişi')
@section('content')

<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Demo Trading History
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Review your past demo trades and track your performance
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <div class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs sm:text-sm lg:text-base">
                    <x-heroicon name="wallet" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5" />
                    <span class="hidden sm:inline">Balance:</span> ${{ number_format(auth()->user()->demo_balance, 2) }}
                </div>
                <a href="{{ route('demo.trade') }}" class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors text-xs sm:text-sm lg:text-base">
                    <x-heroicon name="plus" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5" />
                    <span class="hidden sm:inline">New</span> Trade
                </a>
                <a href="{{ route('demo.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition-colors text-xs sm:text-sm lg:text-base">
                    <x-heroicon name="arrow-left" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5" /> Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Alerts -->
    <div class="space-y-4 mb-6">
        <x-danger-alert />
        <x-success-alert />
    </div>

    @if($trades->count() > 0)
    <!-- Statistics Summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
        @php
            $totalTrades = $trades->total();
            $activeTrades = $trades->where('active', 'yes')->count();
            $winTrades = $trades->where('result_type', 'WIN')->count();
            $winRate = $totalTrades > 0 ? round(($winTrades / $totalTrades) * 100, 1) : 0;
            $totalPnL = $trades->sum(function($trade) {
                return $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
            });
        @endphp

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalTrades }}</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Total Trades</p>
                </div>
                <div class="p-2 sm:p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <x-heroicon name="arrow-trending-up" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white">{{ $winRate }}%</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Win Rate</p>
                </div>
                <div class="p-2 sm:p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <x-heroicon name="view-finder" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-green-600 dark:text-green-400" />
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg lg:text-2xl xl:text-3xl font-bold {{ $totalPnL >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        ${{ number_format($totalPnL, 2) }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Total P&L</p>
                </div>
                <div class="p-2 sm:p-3 bg-{{ $totalPnL >= 0 ? 'green' : 'red' }}-100 dark:bg-{{ $totalPnL >= 0 ? 'green' : 'red' }}-900/30 rounded-lg">
                    <x-heroicon name="currency-dollar" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-{{ $totalPnL >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $totalPnL >= 0 ? 'green' : 'red' }}-400" />
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white">{{ $activeTrades }}</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Active Trades</p>
                </div>
                <div class="p-2 sm:p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                    <x-heroicon name="activity" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-orange-600 dark:text-orange-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm mb-6">
        <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Filters</h3>
                <button type="button" id="toggleFilters" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                    <span id="filterToggleText">Show Filters</span>
                    <x-heroicon name="chevron-down" class="w-3 h-3 sm:w-4 sm:h-4 inline-block ml-1 transition-transform" id="filterToggleIcon" />
                </button>
            </div>
        </div>

        <div id="filterSection" class="hidden p-3 sm:p-4 lg:p-6">
            <form method="GET" action="{{ route('demo.history') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trade Type</label>
                        <select name="type" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                            <option value="Buy" {{ request('type') === 'Buy' ? 'selected' : '' }}>Buy</option>
                            <option value="Sell" {{ request('type') === 'Sell' ? 'selected' : '' }}>Sell</option>
                        </select>
                    </div>

                    <!-- Result Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Result</label>
                        <select name="result" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Results</option>
                            <option value="WIN" {{ request('result') === 'WIN' ? 'selected' : '' }}>Win</option>
                            <option value="LOSE" {{ request('result') === 'LOSE' ? 'selected' : '' }}>Loss</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Per Page</label>
                        <select name="per_page" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <!-- Asset Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asset</label>
                        <input type="text" name="asset" value="{{ request('asset') }}"
                               placeholder="e.g., BTC, ETH, EUR/USD"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-4">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        <x-heroicon name="magnifying-glass" class="w-3 h-3 sm:w-4 sm:h-4" />
                        Apply Filters
                    </button>
                    <a href="{{ route('demo.history') }}" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        <x-heroicon name="x-mark" class="w-3 h-3 sm:w-4 sm:h-4" />
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Trading History Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Trading History</h2>
                @if($trades->count() > 0)
                    <span class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1 text-xs sm:text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full">
                        {{ $trades->total() }} {{ $trades->total() === 1 ? 'Trade' : 'Trades' }}
                    </span>
                @endif
            </div>
        </div>

        @if($trades->count() > 0)
        <!-- Mobile Card Layout (hidden on lg+) -->
        <div class="block lg:hidden space-y-4 p-4">
            @foreach($trades as $trade)
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <!-- Asset and Type Row -->
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trade->assets }}</h4>
                        @if($trade->symbol && $trade->symbol !== $trade->assets)
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $trade->symbol }}</p>
                        @endif
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $trade->type === 'Buy' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                        {{ $trade->type }}
                    </span>
                </div>

                <!-- Amount and P&L Row -->
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Amount</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($trade->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">P&L</p>
                        @php
                            $pnl = $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
                            $pnlClass = $pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                            $returnPercentage = $trade->amount > 0 ? ($pnl / $trade->amount) * 100 : 0;
                        @endphp
                        <div class="text-sm font-semibold {{ $pnlClass }}">
                            {{ $pnl >= 0 ? '+' : '' }}${{ number_format($pnl, 2) }}
                        </div>
                        <div class="text-xs {{ $pnlClass }}">
                            ({{ $returnPercentage >= 0 ? '+' : '' }}{{ number_format($returnPercentage, 2) }}%)
                        </div>
                    </div>
                </div>

                <!-- Status and Actions Row -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($trade->active === 'yes')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Active
                            </span>
                        @else
                            @php
                                $resultClass = match($trade->result_type) {
                                    'WIN' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'LOSE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                };
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $resultClass }}">
                                {{ $trade->result_type ?? 'Closed' }}
                            </span>
                        @endif
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $trade->created_at->format('M d, Y H:i') }}
                        </span>
                    </div>
                    @if($trade->active === 'yes')
                        <form action="{{ route('demo.close', $trade->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg transition-colors"
                                    onclick="return confirm('Are you sure you want to close this trade?')">
                                <x-heroicon name="x-mark" class="w-3 h-3 mr-1" />
                                Close
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table Layout (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Leverage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Entry</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">P&L</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($trades as $trade)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $trade->assets }}
                            </div>
                            @if($trade->symbol && $trade->symbol !== $trade->assets)
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $trade->symbol }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $trade->type === 'Buy' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                {{ $trade->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($trade->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $trade->leverage }}x
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($trade->entry_price)
                                ${{ number_format($trade->entry_price, 4) }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($trade->current_price)
                                ${{ number_format($trade->current_price, 4) }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $pnl = $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
                                $pnlClass = $pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                                $returnPercentage = $trade->amount > 0 ? ($pnl / $trade->amount) * 100 : 0;
                            @endphp
                            <div class="text-sm font-semibold {{ $pnlClass }}">
                                {{ $pnl >= 0 ? '+' : '' }}${{ number_format($pnl, 2) }}
                            </div>
                            <div class="text-xs {{ $pnlClass }}">
                                ({{ $returnPercentage >= 0 ? '+' : '' }}{{ number_format($returnPercentage, 2) }}%)
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trade->active === 'yes')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Active
                                </span>
                            @else
                                @php
                                    $resultClass = match($trade->result_type) {
                                        'WIN' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'LOSE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $resultClass }}">
                                    {{ $trade->result_type ?? 'Closed' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div>{{ $trade->created_at->format('M d, Y') }}</div>
                            <div class="text-xs">{{ $trade->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trade->active === 'yes')
                                <form action="{{ route('demo.close', $trade->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg transition-colors"
                                            onclick="return confirm('Are you sure you want to close this trade?')">
                                        <x-heroicon name="x-mark" class="w-3 h-3 mr-1" />
                                        Close
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 dark:text-gray-600 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        <!-- Enhanced Pagination - Always show when there are trades -->
        @if($trades->count() > 0)
        <div class="p-3 sm:p-4 lg:p-6 border-t border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-4">
                <!-- Pagination Info -->
                <div class="text-center sm:text-left">
                    <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                        @if($trades->hasPages())
                            Showing {{ $trades->firstItem() ?? 0 }} to {{ $trades->lastItem() ?? 0 }}
                            of {{ number_format($trades->total()) }} {{ $trades->total() === 1 ? 'trade' : 'trades' }}
                        @else
                            Showing {{ $trades->count() }} {{ $trades->count() === 1 ? 'trade' : 'trades' }}
                        @endif
                    </div>
                    @if($trades->hasPages() && $trades->total() > $trades->perPage())
                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            {{ $trades->perPage() }} trades per page
                        </div>
                    @endif
                </div>

                <!-- Pagination Links -->
                @if($trades->hasPages())
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Previous/Next for Mobile -->
                    <div class="flex items-center gap-2 sm:hidden w-full">
                        @if($trades->onFirstPage())
                            <span class="flex-1 px-3 py-2 text-xs bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg text-center">
                                Previous
                            </span>
                        @else
                            <a href="{{ $trades->previousPageUrl() }}" class="flex-1 px-3 py-2 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center transition-colors">
                                Previous
                            </a>
                        @endif

                        <span class="px-3 py-2 text-xs bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg">
                            Page {{ $trades->currentPage() }} of {{ $trades->lastPage() }}
                        </span>

                        @if($trades->hasMorePages())
                            <a href="{{ $trades->nextPageUrl() }}" class="flex-1 px-3 py-2 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center transition-colors">
                                Next
                            </a>
                        @else
                            <span class="flex-1 px-3 py-2 text-xs bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg text-center">
                                Next
                            </span>
                        @endif
                    </div>

                    <!-- Full Pagination for Desktop -->
                    <div class="hidden sm:flex items-center justify-center w-full">
                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            <!-- Previous Button -->
                            @if($trades->onFirstPage())
                                <span class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $trades->previousPageUrl() }}" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Previous
                                </a>
                            @endif

                            <!-- Page Numbers -->
                            @foreach($trades->getUrlRange(max(1, $trades->currentPage() - 2), min($trades->lastPage(), $trades->currentPage() + 2)) as $page => $url)
                                @if($page == $trades->currentPage())
                                    <span class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            <!-- Show ellipsis if there are more pages -->
                            @if($trades->currentPage() < $trades->lastPage() - 3)
                                <span class="px-2 py-2 text-sm text-gray-500 dark:text-gray-400">...</span>
                                <a href="{{ $trades->url($trades->lastPage()) }}" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    {{ $trades->lastPage() }}
                                </a>
                            @endif

                            <!-- Next Button -->
                            @if($trades->hasMorePages())
                                <a href="{{ $trades->nextPageUrl() }}" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Next
                                </a>
                            @else
                                <span class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg">
                                    Next
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
                @endif

                <!-- Quick Page Jump (Desktop only) -->
                @if($trades->hasPages() && $trades->lastPage() > 5)
                <div class="hidden lg:flex items-center justify-center gap-4">
                    <form method="GET" action="{{ route('demo.history') }}" class="flex items-center gap-2">
                        <!-- Preserve current filters -->
                        @foreach(request()->except(['page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <label class="text-xs text-gray-500 dark:text-gray-400">Go to page:</label>
                        <input type="number" name="page" min="1" max="{{ $trades->lastPage() }}"
                               value="{{ $trades->currentPage() }}"
                               class="w-16 px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        <button type="submit" class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors">
                            Go
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endif

        @else
        <div class="p-6 sm:p-8 lg:p-12 text-center">
            <div class="mx-auto w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <x-heroicon name="bar-chart-3" class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400 dark:text-gray-500" />
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Trading History</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">You haven't placed any demo trades yet. Start trading to build your history and track your performance!</p>
            <a href="{{ route('demo.trade') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-6 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-sm sm:text-base">
                <x-heroicon name="plus" class="w-3 h-3 sm:w-4 sm:h-4" />
                Place Your First Trade
            </a>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Filter toggle functionality
        const toggleFilters = document.getElementById('toggleFilters');
        const filterSection = document.getElementById('filterSection');
        const filterToggleText = document.getElementById('filterToggleText');
        const filterToggleIcon = document.getElementById('filterToggleIcon');

        // Check if filters have values and show them initially
        const hasActiveFilters = {{ json_encode(
            request()->hasAny(['status', 'type', 'result', 'asset', 'date_from', 'date_to', 'per_page']) &&
            (request('per_page') != 20 || request()->hasAny(['status', 'type', 'result', 'asset', 'date_from', 'date_to']))
        ) }};

        if (hasActiveFilters) {
            filterSection.classList.remove('hidden');
            filterToggleText.textContent = 'Hide Filters';
            filterToggleIcon.style.transform = 'rotate(180deg)';
        }

        if (toggleFilters) {
            toggleFilters.addEventListener('click', function() {
                const isHidden = filterSection.classList.contains('hidden');

                if (isHidden) {
                    filterSection.classList.remove('hidden');
                    filterToggleText.textContent = 'Hide Filters';
                    filterToggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    filterSection.classList.add('hidden');
                    filterToggleText.textContent = 'Show Filters';
                    filterToggleIcon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Auto-submit form when per_page changes (for better UX)
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endsection
