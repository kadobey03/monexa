@extends('layouts.dasht')
@section('title', 'Demo Ticaret Gösterge Paneli')
@section('content')

<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Demo Trading Dashboard
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Practice trading with virtual money - Risk Free!
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="{{ route('demo.trade') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors text-sm sm:text-base">
                    <i data-lucide="plus" class="w-4 h-4 sm:w-5 sm:h-5"></i> Start Demo Trade
                </a>
                <a href="{{ route('demo.history') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition-colors text-sm sm:text-base">
                    <i data-lucide="history" class="w-4 h-4 sm:w-5 sm:h-5"></i> View History
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Alerts -->
      <x-danger-alert />
    <x-success-alert />

    <!-- Demo Balance Card -->
    <div class="mb-6 sm:mb-8 mt-2">
        <div class="bg-gradient-to-br from-gray-900 via-black to-gray-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 shadow-2xl ring-1 ring-gray-700/50 relative overflow-hidden">
            <!-- Elegant Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 via-transparent to-blue-500/20"></div>
                <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)]"></div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-2 right-2 sm:top-4 sm:right-4 w-20 h-20 sm:w-32 sm:h-32 bg-gradient-to-br from-emerald-500/10 to-blue-500/10 rounded-full blur-2xl sm:blur-3xl"></div>
            <div class="absolute -bottom-4 -left-4 sm:-bottom-8 sm:-left-8 w-24 h-24 sm:w-40 sm:h-40 bg-gradient-to-tr from-purple-500/10 to-pink-500/10 rounded-full blur-2xl sm:blur-3xl"></div>

            <div class="relative">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 sm:gap-6">
                    <div class="text-center lg:text-left">
                        <!-- Status Indicator -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 sm:gap-3 mb-3 sm:mb-4">
                            <div class="relative">
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-emerald-400 animate-pulse"></div>
                                <div class="absolute inset-0 w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-emerald-400 animate-ping opacity-20"></div>
                            </div>
                            <span class="text-gray-300 text-xs sm:text-sm font-semibold tracking-wide uppercase">Demo Mode Active</span>
                            <div class="px-2 py-0.5 sm:px-3 sm:py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-full">
                                <span class="text-emerald-400 text-xs font-bold">RISK FREE</span>
                            </div>
                        </div>

                        <!-- Balance Display -->
                        <div class="mb-3">
                            <div class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-white mb-1 tracking-tight break-all">
                                <span class="bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                                    ${{ number_format(auth()->user()->demo_balance, 2) }}
                                </span>
                            </div>
                            <p class="text-gray-400 text-sm sm:text-base lg:text-lg font-medium">Virtual Trading Balance</p>
                        </div>

                        <!-- Additional Info -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 sm:gap-4 text-xs sm:text-sm text-gray-500">
                            <div class="flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3 h-3 sm:w-4 sm:h-4 text-emerald-500"></i>
                                <span class="hidden sm:inline">Protected Environment</span>
                                <span class="sm:hidden">Protected</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="trending-up" class="w-3 h-3 sm:w-4 sm:h-4 text-blue-500"></i>
                                <span class="hidden sm:inline">Real Market Data</span>
                                <span class="sm:hidden">Real Data</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full lg:w-auto">
                        <a href="{{ route('trade.index') }}"
                           class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:px-6 sm:py-3 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white rounded-lg sm:rounded-xl font-medium sm:font-semibold transition-all duration-200 shadow-lg hover:shadow-emerald-500/25 transform hover:-translate-y-0.5 text-sm sm:text-base">
                            <i data-lucide="trending-up" class="w-4 h-4 sm:w-5 sm:h-5 group-hover:scale-110 transition-transform"></i>
                            <span class="hidden sm:inline">Switch to Live Trading</span>
                            <span class="sm:hidden">Live Trading</span>
                        </a>

                        <form action="{{ route('demo.reset') }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Are you sure you want to reset your demo account? This will close all active trades and reset your balance to $100,000.')">
                            @csrf
                            <button type="submit"
                                    class="group inline-flex items-center justify-center gap-2 px-4 py-2.5 sm:px-6 sm:py-3 bg-gray-800/80 hover:bg-gray-700/80 backdrop-blur-sm text-gray-300 hover:text-white rounded-lg sm:rounded-xl font-medium sm:font-semibold transition-all duration-200 border border-gray-700/50 hover:border-gray-600/50 shadow-lg w-full sm:w-auto text-sm sm:text-base">
                                <i data-lucide="refresh-cw" class="w-4 h-4 sm:w-5 sm:h-5 group-hover:rotate-180 transition-transform duration-300"></i>
                                <span class="hidden sm:inline">Reset Account</span>
                                <span class="sm:hidden">Reset</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bottom Stats Bar -->
                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-700/50">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 text-center sm:text-left">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-blue-400 flex-shrink-0"></div>
                            <span class="text-gray-400 text-xs sm:text-sm">Unlimited Practice Trades</span>
                        </div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-400 flex-shrink-0"></div>
                            <span class="text-gray-400 text-xs sm:text-sm">No Financial Risk</span>
                        </div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-purple-400 flex-shrink-0"></div>
                            <span class="text-gray-400 text-xs sm:text-sm">Real-time Market Prices</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalTrades }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Trades</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="trending-up" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $winRate }}%</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Win Rate</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <i data-lucide="target" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold {{ $totalProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        ${{ number_format($totalProfit, 2) }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total P&L</p>
                </div>
                <div class="p-3 bg-{{ $totalProfit >= 0 ? 'green' : 'red' }}-100 dark:bg-{{ $totalProfit >= 0 ? 'green' : 'red' }}-900/30 rounded-lg">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-{{ $totalProfit >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $totalProfit >= 0 ? 'green' : 'red' }}-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $activeTrades->count() }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active Trades</p>
                </div>
                <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                    <i data-lucide="activity" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('demo.trade') }}" class="flex items-center justify-center gap-3 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>Start Demo Trade</span>
                </a>

                <a href="{{ route('demo.history') }}" class="flex items-center justify-center gap-3 px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span>View History</span>
                </a>

                <a href="{{ route('trade.index') }}" class="flex items-center justify-center gap-3 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                    <span>Live Trading</span>
                </a>

                <form action="{{ route('demo.reset') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reset your demo account? This will close all active trades and reset your balance to $100,000.')">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                        <span>Reset Account</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Trades -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Demo Trades</h3>
                @if($activeTrades->count() > 0)
                    <span class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                        {{ $activeTrades->count() }} Active
                    </span>
                @endif
            </div>
        </div>

       
    </div>
</div>

<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection

