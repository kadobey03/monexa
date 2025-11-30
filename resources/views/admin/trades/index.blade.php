@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between bg-gradient-to-r from-violet-600 via-purple-700 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <x-heroicon name="chart-bar-square" class="w-8 h-8 text-white" />
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-1">{{ __('admin.trading.management') }}</h1>
                <p class="text-violet-100 text-lg">{{ __('admin.trading.monitor_and_manage') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="hidden md:flex items-center space-x-2 text-white/80">
                <x-heroicon name="home" class="w-4 h-4" />
                <span>{{ __('admin.navigation.dashboard') }}</span>
                <x-heroicon name="chevron-right" class="w-4 h-4" />
                <span>{{ __('admin.navigation.management') }}</span>
                <x-heroicon name="chevron-right" class="w-4 h-4" />
                <span class="text-white font-semibold">{{ __('admin.trading.trades') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<x-success-alert />
<x-danger-alert />

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">{{ __('admin.trading.total_trades') }}</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['total'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 dark:text-admin-500 mt-1">{{ __('admin.trading.all_trades') }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                <x-heroicon name="chart-bar" class="w-7 h-7 text-white" />
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">{{ __('admin.trading.active_trades') }}</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['active'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 dark:text-admin-500 mt-1">{{ __('admin.trading.ongoing') }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                <x-heroicon name="clock" class="w-7 h-7 text-white" />
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">{{ __('admin.trading.completed') }}</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['expired'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 dark:text-admin-500 mt-1">{{ __('admin.trading.finished_trades') }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                <x-heroicon name="check-circle" class="w-7 h-7 text-white" />
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">{{ __('admin.trading.total_volume') }}</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">${{ number_format($stats['total_volume'] ?? 0, 2) }}</h3>
                <p class="text-xs text-admin-400 dark:text-admin-500 mt-1">{{ __('admin.trading.usd_value') }}</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center shadow-lg">
                <x-heroicon name="currency-dollar" class="w-7 h-7 text-white" />
            </div>
        </div>
    </div>
</div>

<!-- Filters Panel -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 mb-8">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-heroicon name="funnel" class="w-5 h-5 text-white" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.filters_and_search') }}</h2>
                    <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.filter_and_search_trades') }}</p>
                </div>
            </div>
            <button id="toggleFilters" class="flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                <x-heroicon name="adjustments-horizontal" class="w-4 h-4 mr-2" />
                <span id="toggleFiltersText">{{ __('admin.trading.show_filters') }}</span>
            </button>
        </div>
    </div>
    
    <div id="filtersPanel" class="hidden">
        <div class="p-6 bg-admin-50 dark:bg-admin-900/50">
            <form method="GET" action="{{ route('admin.trades.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                            <x-heroicon name="magnifying-glass" class="w-4 h-4 mr-1" />
                            {{ __('admin.trading.search_user') }}
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                               placeholder="{{ __('admin.trading.name_or_email') }}">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                            <x-heroicon name="flag" class="w-4 h-4 mr-1" />
                            {{ __('admin.trading.status') }}
                        </label>
                        <select name="status" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors">
                            <option value="">{{ __('common.all') }}</option>
                            <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>{{ __('admin.trading.active') }}</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('admin.trading.completed') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                            <x-heroicon name="arrows-up-down" class="w-4 h-4 mr-1" />
                            {{ __('admin.trading.trade_type') }}
                        </label>
                        <select name="type" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors">
                            <option value="">{{ __('common.all') }}</option>
                            <option value="Buy" {{ request('type') == 'Buy' ? 'selected' : '' }}>{{ __('admin.trading.buy') }}</option>
                            <option value="Sell" {{ request('type') == 'Sell' ? 'selected' : '' }}>{{ __('admin.trading.sell') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                            <x-heroicon name="squares-2x2" class="w-4 h-4 mr-1" />
                            {{ __('admin.trading.asset') }}
                        </label>
                        <input type="text" name="asset" value="{{ request('asset') }}"
                               class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                               placeholder="{{ __('admin.trading.asset_name_example') }}">
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                            <x-heroicon name="magnifying-glass" class="w-4 h-4 mr-2" />
                            {{ __('common.filter') }}
                        </button>
                        <a href="{{ route('admin.trades.index') }}" class="px-4 py-3 bg-admin-500 hover:bg-admin-600 text-white rounded-xl transition-all duration-200 shadow-lg">
                            <x-heroicon name="x-mark" class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Trades Table -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-heroicon name="table-cells" class="w-5 h-5 text-white" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.user_trades') }}</h2>
                    <p class="text-admin-500 dark:text-admin-400 text-sm">{{ $trades->total() }} {{ __('admin.trading.total_records_found') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="testRoutes()" class="flex items-center px-4 py-2 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                    <x-heroicon name="wrench-screwdriver" class="w-4 h-4 mr-2" />
                    {{ __('admin.trading.test_routes') }}
                </button>
                
                <div class="relative">
                    <button id="exportDropdown" class="flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                        <x-heroicon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                        {{ __('admin.trading.export') }}
                        <x-heroicon name="chevron-down" class="w-4 h-4 ml-2" />
                    </button>
                    <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-xl border border-admin-200 dark:border-admin-700 z-50">
                        <a href="{{ route('admin.trades.export', ['format' => 'csv'] + request()->all()) }}"
                           class="flex items-center px-4 py-3 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700 rounded-t-xl transition-colors">
                            <x-heroicon name="document-text" class="w-4 h-4 mr-3 text-admin-400" />
                            {{ __('admin.trading.csv_format') }}
                        </a>
                        <a href="{{ route('admin.trades.export', ['format' => 'excel'] + request()->all()) }}"
                           class="flex items-center px-4 py-3 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700 rounded-b-xl transition-colors">
                            <x-heroicon name="document-chart-bar" class="w-4 h-4 mr-3 text-admin-400" />
                            {{ __('admin.trading.excel_format') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-admin-50 dark:bg-admin-900/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="hashtag" class="w-3 h-3" />
                            <span>ID</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="user" class="w-3 h-3" />
                            <span>{{ __('admin.users.user') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="squares-2x2" class="w-3 h-3" />
                            <span>{{ __('admin.trading.asset') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="arrows-up-down" class="w-3 h-3" />
                            <span>{{ __('admin.trading.type') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="currency-dollar" class="w-3 h-3" />
                            <span>{{ __('admin.trading.amount') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="scale" class="w-3 h-3" />
                            <span>{{ __('admin.trading.leverage') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="chart-pie" class="w-3 h-3" />
                            <span>{{ __('admin.trading.profit_loss') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="flag" class="w-3 h-3" />
                            <span>{{ __('admin.trading.status') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="calendar" class="w-3 h-3" />
                            <span>{{ __('admin.trading.created') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="clock" class="w-3 h-3" />
                            <span>{{ __('admin.trading.expiry') }}</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-admin-600 dark:text-admin-400 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <x-heroicon name="cog-6-tooth" class="w-3 h-3" />
                            <span>{{ __('admin.users.actions') }}</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700">
                @forelse($trades as $trade)
                    <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-admin-100 dark:bg-admin-700 text-admin-800 dark:text-admin-200">
                                #{{ $trade->id }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <x-heroicon name="user" class="h-5 w-5 text-white" />
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-admin-900 dark:text-admin-100">
                                        {{ $trade->user_name ?? __('admin.trading.user_not_found') }}
                                    </div>
                                    <div class="text-sm text-admin-500 dark:text-admin-400">
                                        {{ $trade->user_email ?? __('admin.trading.not_specified') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                {{ $trade->assets ?? 'N/A' }}
                            </span>
                            @if($trade->symbol)
                                <div class="text-xs text-admin-500 dark:text-admin-400 mt-1">{{ $trade->symbol }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trade->type)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium {{ $trade->type == 'Buy' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    @if($trade->type == 'Buy')
                                        <x-heroicon name="arrow-trending-up" class="w-3 h-3 mr-1" />
                                    @else
                                        <x-heroicon name="arrow-trending-down" class="w-3 h-3 mr-1" />
                                    @endif
                                    {{ $trade->type }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-admin-100 dark:bg-admin-700 text-admin-800 dark:text-admin-200">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-admin-900 dark:text-admin-100">
                                ${{ number_format($trade->amount, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200">
                                1:{{ $trade->leverage ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trade->profit_earned)
                                @if($trade->profit_earned > 0)
                                    <div class="flex items-center text-green-600 dark:text-green-400 font-medium">
                                        <x-heroicon name="arrow-trending-up" class="w-4 h-4 mr-1" />
                                        +${{ number_format($trade->profit_earned, 2) }}
                                    </div>
                                @else
                                    <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                        <x-heroicon name="arrow-trending-down" class="w-4 h-4 mr-1" />
                                        ${{ number_format($trade->profit_earned, 2) }}
                                    </div>
                                @endif
                            @else
                                <span class="text-admin-400 dark:text-admin-500">$0.00</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trade->active == 'yes')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                    {{ __('admin.trading.active') }}
                                </span>
                            @elseif($trade->active == 'expired')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                                    {{ __('admin.trading.completed') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-admin-100 dark:bg-admin-700 text-admin-800 dark:text-admin-200">
                                    {{ ucfirst($trade->active ?? 'N/A') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-admin-900 dark:text-admin-100">
                            <div class="font-medium">{{ $trade->created_at->format('d.m.Y') }}</div>
                            <div class="text-xs text-admin-500 dark:text-admin-400">{{ $trade->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-admin-900 dark:text-admin-100">
                            @if($trade->expire_date)
                                <div class="font-medium">{{ \Carbon\Carbon::parse($trade->expire_date)->format('d.m.Y') }}</div>
                                <div class="text-xs text-admin-500 dark:text-admin-400">{{ \Carbon\Carbon::parse($trade->expire_date)->format('H:i') }}</div>
                            @else
                                <span class="text-admin-400 dark:text-admin-500">{{ __('admin.trading.not_specified') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-admin-500 dark:text-admin-400">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.trades.edit', $trade->id) }}" 
                                   class="p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/50 rounded-lg transition-all duration-200" 
                                   title="{{ __('admin.trading.edit_trade') }}">
                                    <x-heroicon name="pencil-square" class="w-4 h-4" />
                                </a>
                                <button onclick="showAddProfitForm({{ $trade->id }})" 
                                        class="p-2 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/50 rounded-lg transition-all duration-200" 
                                        title="{{ __('admin.trading.add_profit_loss') }}">
                                    <x-heroicon name="plus-circle" class="w-4 h-4" />
                                </button>
                                <button onclick="deleteTrade({{ $trade->id }})" 
                                        class="p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/50 rounded-lg transition-all duration-200" 
                                        title="{{ __('admin.trading.delete_trade') }}">
                                    <x-heroicon name="trash" class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-admin-100 dark:bg-admin-700 rounded-2xl flex items-center justify-center mb-4">
                                    <x-heroicon name="chart-bar" class="w-8 h-8 text-admin-400 dark:text-admin-500" />
                                </div>
                                <h3 class="text-lg font-semibold text-admin-900 dark:text-admin-100 mb-2">
                                    {{ __('admin.trading.no_trades_yet') }}
                                </h3>
                                <p class="text-admin-500 dark:text-admin-400 mb-4">
                                    {{ __('admin.trading.check_filters_or_try_different_search') }}
                                </p>
                                <a href="{{ route('admin.trades.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg">
                                    <x-heroicon name="arrow-path" class="w-4 h-4 mr-2" />
                                    {{ __('admin.trading.clear_filters') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($trades->hasPages())
        <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
            {{ $trades->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Add Profit Modal -->
<div id="addProfitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-admin-800 rounded-2xl max-w-md w-full shadow-2xl border border-admin-200 dark:border-admin-700">
            <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <x-heroicon name="plus-circle" class="w-5 h-5 text-white" />
                        </div>
                        <h3 class="text-xl font-semibold text-admin-900 dark:text-admin-100">
                            {{ __('admin.trading.add_profit_loss') }}
                        </h3>
                    </div>
                    <button onclick="closeModal('addProfitModal')" class="p-2 text-admin-400 hover:text-admin-600 dark:text-admin-500 dark:hover:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                        <x-heroicon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>
            </div>
            
            <form id="addProfitForm" method="POST" action="" class="space-y-6">
                @csrf
                <div class="p-6">
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start space-x-3">
                            <x-heroicon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <p class="font-medium mb-1">Bilgilendirme:</p>
                                <p>{{ __('admin.trading.profit_loss_info') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                                <x-heroicon name="currency-dollar" class="w-4 h-4 mr-1" />
                                {{ __('admin.trading.profit_loss_amount') }}
                            </label>
                            <input type="number" 
                                   id="profit_amount" 
                                   name="profit_amount" 
                                   step="0.01" 
                                   required
                                   class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                                   placeholder="{{ __('admin.trading.enter_amount_to_add') }}">
                            <p class="text-xs text-admin-500 dark:text-admin-400 mt-2">
                                {{ __('admin.trading.positive_for_profit_negative_for_loss') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                                <x-heroicon name="document-text" class="w-4 h-4 mr-1" />
                                {{ __('admin.trading.note_optional') }}
                            </label>
                            <textarea id="profit_note" 
                                      name="note" 
                                      rows="3"
                                      class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors resize-none"
                                      placeholder="{{ __('admin.trading.add_note_about_adjustment') }}"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50 rounded-b-2xl">
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeModal('addProfitModal')" 
                                class="px-4 py-2 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl transition-colors font-medium">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit" 
                                class="flex items-center px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                            <x-heroicon name="plus-circle" class="w-4 h-4 mr-2" />
                            {{ __('admin.trading.add_profit_loss') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Management
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    // Close modal on backdrop click
    document.getElementById('addProfitModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal('addProfitModal');
        }
    });

    // Add Profit Form Handler
    window.showAddProfitForm = function(tradeId) {
        const form = document.getElementById('addProfitForm');
        const profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
        form.setAttribute('action', profitUrl);
        
        // Clear form fields
        document.getElementById('profit_amount').value = '';
        document.getElementById('profit_note').value = '';
        
        // Show modal with animation
        const modal = document.getElementById('addProfitModal');
        modal.classList.remove('hidden');
        
        // Focus on amount input
        setTimeout(() => {
            document.getElementById('profit_amount').focus();
        }, 100);
    };

    // Delete Trade Handler
    window.deleteTrade = function(tradeId) {
        const deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
        
        // Create custom confirmation modal
        const confirmModal = document.createElement('div');
        confirmModal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
        confirmModal.innerHTML = `
            <div class="bg-white dark:bg-admin-800 rounded-2xl max-w-md w-full shadow-2xl border border-admin-200 dark:border-admin-700">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.delete_trade') }}</h3>
                            <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.this_action_irreversible') }}</p>
                        </div>
                    </div>
                    <p class="text-admin-600 dark:text-admin-300 mb-6">
                        {{ __('admin.trading.confirm_delete_trade_message') }}
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl transition-colors font-medium">
                            {{ __('common.cancel') }}
                        </button>
                        <button onclick="confirmDelete('${deleteUrl}', this)" class="flex items-center px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('admin.trading.yes_delete') }}
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(confirmModal);
    };

    // Confirm Delete Function
    window.confirmDelete = function(deleteUrl, button) {
        // Show loading state
        button.disabled = true;
        button.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            {{ __('admin.trading.deleting') }}...
        `;
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    };

    // Route Testing Function
    window.testRoutes = function() {
        console.log('🔍 Route testi başlatılıyor...');
        const baseUrl = '{{ url('/') }}';
        const routes = [
            { url: baseUrl + '/admin/trades', name: 'İşlemler Ana Sayfa' },
            { url: baseUrl + '/admin/trades/1', name: 'İşlem Detay' },
            { url: baseUrl + '/admin/trades/1/edit', name: 'İşlem Düzenleme' }
        ];

        // Show loading notification
        showNotification('info', '{{ __("admin.trading.starting_route_tests") }}...');

        routes.forEach((route, index) => {
            fetch(route.url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                const status = response.status;
                const statusText = response.statusText;
                
                if (status === 200) {
                    console.log(`✅ ${route.name}: ${status} ${statusText}`);
                } else if (status === 404) {
                    console.log(`❌ ${route.name}: ${status} ${statusText} - Route bulunamadı`);
                } else if (status >= 500) {
                    console.log(`🚨 ${route.name}: ${status} ${statusText} - Server hatası`);
                } else {
                    console.log(`⚠️ ${route.name}: ${status} ${statusText}`);
                }
                
                // Show final result after last test
                if (index === routes.length - 1) {
                    showNotification('success', '{{ __("admin.trading.route_tests_completed") }}');
                }
            })
            .catch(error => {
                console.log(`💥 ${route.name}: Network hatası - ${error.message}`);
                if (index === routes.length - 1) {
                    showNotification('warning', '{{ __("admin.trading.route_tests_completed_with_errors") }}');
                }
            });
        });
    };

    // Filter Panel Toggle
    const toggleFilters = document.getElementById('toggleFilters');
    const filtersPanel = document.getElementById('filtersPanel');
    const toggleFiltersText = document.getElementById('toggleFiltersText');
    
    if (toggleFilters && filtersPanel && toggleFiltersText) {
        toggleFilters.addEventListener('click', function() {
            const isHidden = filtersPanel.classList.contains('hidden');
            
            if (isHidden) {
                filtersPanel.classList.remove('hidden');
                toggleFiltersText.textContent = '{{ __("admin.trading.hide_filters") }}';
                // Save filter state
                localStorage.setItem('tradesFiltersOpen', 'true');
            } else {
                filtersPanel.classList.add('hidden');
                toggleFiltersText.textContent = '{{ __("admin.trading.show_filters") }}';
                localStorage.setItem('tradesFiltersOpen', 'false');
            }
        });
        
        // Restore filter state
        const filtersOpen = localStorage.getItem('tradesFiltersOpen');
        if (filtersOpen === 'true') {
            filtersPanel.classList.remove('hidden');
            toggleFiltersText.textContent = '{{ __("admin.trading.hide_filters") }}';
        }
    }

    // Export Dropdown Toggle
    const exportDropdown = document.getElementById('exportDropdown');
    const exportMenu = document.getElementById('exportMenu');
    
    if (exportDropdown && exportMenu) {
        exportDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            exportMenu.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            exportMenu.classList.add('hidden');
        });
        
        // Prevent closing when clicking inside menu
        exportMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Notification System
    window.showNotification = function(type, message) {
        const notification = document.createElement('div');
        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };
        const colors = {
            success: 'from-green-500 to-emerald-500',
            error: 'from-red-500 to-red-600',
            warning: 'from-yellow-500 to-orange-500',
            info: 'from-blue-500 to-cyan-500'
        };
        
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg text-white bg-gradient-to-r ${colors[type]} transform translate-x-full transition-transform duration-300`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <span class="text-xl">${icons[type]}</span>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    };

    // Auto-dismiss alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            if (alert) {
                alert.style.display = 'none';
            }
        });
    }, 5000);

    console.log('🚀 Admin Trades sayfası başarıyla yüklendi!');
});
</script>
@endpush