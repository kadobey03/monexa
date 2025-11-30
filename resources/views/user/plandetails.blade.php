@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 md:py-8" x-data="{ showCancelModal: false }">
    <div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4 py-2 sm:py-3 md:py-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 md:mb-8 gap-4">
            <div class="flex items-center gap-3 md:gap-4">
                <a href="{{ route('myplans', 'All') }}" class="p-2 md:p-2 bg-gray-900 dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 border border-gray-700 dark:border-gray-600">
                    <x-heroicon name="arrow-left" class="w-5 h-5 md:w-6 md:h-6 text-gray-300 dark:text-gray-300" />
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ __('user.plan_details.page_title') }}</h1>
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mt-1">{{ __('user.plan_details.page_subtitle') }}</p>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Plan Overview Card -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 mb-6 md:mb-8">
            <div class="p-4 md:p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="w-full lg:w-auto">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-3">
                            <h2 class="text-xl md:text-2xl font-bold text-white dark:text-white">{{ $plan->uplan->name }}</h2>
                            @if ($plan->active == 'yes')
                                <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-medium rounded-full">{{ __('user.plan_details.active') }}</span>
                            @elseif($plan->active == 'expired')
                                <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-full">{{ __('user.plan_details.expired') }}</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400 text-sm font-medium rounded-full">{{ __('user.plan_details.inactive') }}</span>
                            @endif
                        </div>
                        <p class="text-sm md:text-base text-gray-300 dark:text-gray-400">
                            {{ $plan->uplan->increment_type == 'Fixed' ? Auth::user()->currency : '' }}{{ $plan->uplan->increment_amount }}{{ $plan->uplan->increment_type == 'Percentage' ? '%' : '' }}
                            {{ $plan->uplan->increment_interval }} for {{ $plan->uplan->expiration }}
                        </p>
                    </div>

                    @if ($settings->should_cancel_plan && $plan->active == 'yes')
                        <button
                            @click="showCancelModal = true"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-200 text-sm">
                            <x-heroicon name="x-mark" class="w-4 h-4" />
                            <span>Cancel Plan</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Financial Overview -->
            <div class="border-t border-gray-700 dark:border-gray-600">
                <div class="p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-white dark:text-white mb-4">{{ __('user.plan_details.financial_overview') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                        <!-- Invested Amount -->
                        <div class="bg-gray-800 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-700 dark:border-gray-600">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="briefcase" class="w-5 h-5 md:w-6 md:h-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.invested_amount') }}</p>
                                    <p class="text-xl md:text-2xl font-bold text-white dark:text-white break-words">
                                        {{ Auth::user()->currency }}{{ number_format($plan->amount, 2, '.', ',') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Profit Earned -->
                        <div class="bg-gray-800 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-700 dark:border-gray-600">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="arrow-trending-up" class="w-5 h-5 md:w-6 md:h-6 text-green-600 dark:text-green-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.profit_earned') }}</p>
                                    <p class="text-xl md:text-2xl font-bold text-green-400 dark:text-green-400 break-words">
                                        {{ Auth::user()->currency }}{{ number_format($plan->profit_earned, 2, '.', ',') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Return -->
                        <div class="bg-gray-800 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-700 dark:border-gray-600">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="wallet" class="w-5 h-5 md:w-6 md:h-6 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.total_return') }}</p>
                                    <p class="text-xl md:text-2xl font-bold text-purple-400 dark:text-purple-400 break-words">
                                        @if ($settings->return_capital)
                                            {{ Auth::user()->currency }}{{ number_format($plan->amount + $plan->profit_earned, 2, '.', ',') }}
                                        @else
                                            {{ Auth::user()->currency }}{{ number_format($plan->profit_earned, 2, '.', ',') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Timeline & Details -->
            <div class="border-t border-gray-700 dark:border-gray-600">
                <div class="p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-white dark:text-white mb-4">{{ __('user.plan_details.plan_details') }}</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        <!-- Timeline -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="calendar-days" class="w-4 h-4 md:w-5 md:h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.duration') }}</p>
                                    <p class="font-medium text-white dark:text-white break-words">{{ $plan->uplan->expiration }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="calendar-plus" class="w-4 h-4 md:w-5 md:h-5 text-green-600 dark:text-green-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.start_date') }}</p>
                                    <p class="font-medium text-white dark:text-white text-sm md:text-base break-words">{{ $plan->created_at->addHour()->toDayDateTimeString() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="calendar-check" class="w-4 h-4 md:w-5 md:h-5 text-red-600 dark:text-red-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.end_date') }}</p>
                                    <p class="font-medium text-white dark:text-white text-sm md:text-base break-words">{{ \Carbon\Carbon::parse($plan->expire_date)->addHour()->toDayDateTimeString() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Details -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="bar-chart-2" class="w-4 h-4 md:w-5 md:h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.roi_interval') }}</p>
                                    <p class="font-medium text-white dark:text-white break-words">{{ $plan->uplan->increment_interval }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="arrow-trending-up" class="w-4 h-4 md:w-5 md:h-5 text-green-600 dark:text-green-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.minimum_return') }}</p>
                                    <p class="font-medium text-white dark:text-white break-words">{{ $plan->uplan->minr }}%</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex-shrink-0">
                                    <x-heroicon name="arrow-trending-up" class="w-4 h-4 md:w-5 md:h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.plan_details.maximum_return') }}</p>
                                    <p class="font-medium text-white dark:text-white break-words">{{ $plan->uplan->maxr }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions History -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600">
            <div class="p-4 md:p-6">
                <div class="flex items-center gap-3 mb-4 md:mb-6">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex-shrink-0">
                        <x-heroicon name="list-bullet" class="w-4 h-4 md:w-5 md:h-5 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-white dark:text-white">{{ __('user.plan_details.transaction_history') }}</h3>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-700 dark:border-gray-600">
                    <!-- Mobile Card View -->
                    <div class="block md:hidden">
                        @forelse($transactions as $history)
                            <div class="bg-gray-800 dark:bg-gray-700 p-4 border-b border-gray-700 dark:border-gray-600 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="p-1.5 bg-green-100 dark:bg-green-900/30 rounded-full">
                                            <x-heroicon name="arrow-trending-up" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                        </div>
                                        <div>
                                            <p class="font-medium text-white dark:text-white text-sm">{{ __('user.plan_details.profit') }}</p>
                                            <p class="text-xs text-gray-300 dark:text-gray-400">{{ $history->created_at->addHour()->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                    <span class="font-medium text-green-400 dark:text-green-400 text-sm">
                                        {{ Auth::user()->currency }}{{ number_format($history->amount, 2, '.', ',') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-400 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <div class="p-3 bg-gray-700 dark:bg-gray-600 rounded-full mb-3">
                                        <x-heroicon name="information-circle" class="w-6 h-6 text-gray-400 dark:text-gray-500" />
                                    </div>
                                    <p class="text-sm">{{ __('user.plan_details.no_transactions') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-800 dark:bg-gray-700/50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-400 uppercase tracking-wider">{{ __('user.plan_details.type') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-400 uppercase tracking-wider">{{ __('user.plan_details.date') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-400 uppercase tracking-wider">{{ __('user.plan_details.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-900 dark:bg-gray-800 divide-y divide-gray-700 dark:divide-gray-600">
                                @forelse($transactions as $history)
                                    <tr class="hover:bg-gray-800 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-1.5 bg-green-100 dark:bg-green-900/30 rounded-full mr-3">
                                                    <x-heroicon name="arrow-trending-up" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                                </div>
                                                <span class="font-medium text-white dark:text-white">{{ __('user.plan_details.profit') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300 dark:text-gray-300">
                                            {{ $history->created_at->addHour()->toDayDateTimeString() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-medium text-green-400 dark:text-green-400">
                                                {{ Auth::user()->currency }}{{ number_format($history->amount, 2, '.', ',') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-gray-400 dark:text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <div class="p-3 bg-gray-700 dark:bg-gray-600 rounded-full mb-3">
                                                    <x-heroicon name="information-circle" class="w-6 h-6 text-gray-400 dark:text-gray-500" />
                                                </div>
                                                <p>{{ __('user.plan_details.no_transactions') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modern Pagination -->
                @if ($transactions->hasPages())
                    <div class="mt-6 px-4 py-3 bg-gray-800 dark:bg-gray-700/50 rounded-xl border border-gray-700 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Pagination Info -->
                            <div class="flex items-center gap-2 text-sm text-gray-300 dark:text-gray-400">
                                <span>{{ __('user.common.showing') }}</span>
                                <span class="font-medium text-white dark:text-white">{{ $transactions->firstItem() }}</span>
                                <span>{{ __('user.common.to') }}</span>
                                <span class="font-medium text-white dark:text-white">{{ $transactions->lastItem() }}</span>
                                <span>{{ __('user.common.of') }}</span>
                                <span class="font-medium text-white dark:text-white">{{ $transactions->total() }}</span>
                                <span>{{ __('user.common.results') }}</span>
                            </div>

                            <!-- Pagination Links -->
                            <div class="flex items-center gap-1">
                                <!-- Previous Button -->
                                @if ($transactions->onFirstPage())
                                    <div class="px-3 py-2 text-gray-500 dark:text-gray-600 cursor-not-allowed">
                                        <x-heroicon name="chevron-left" class="w-4 h-4" />
                                    </div>
                                @else
                                    <a href="{{ $transactions->previousPageUrl() }}"
                                       class="px-3 py-2 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 flex items-center gap-1">
                                        <x-heroicon name="chevron-left" class="w-4 h-4" />
                                        <span class="hidden sm:inline">{{ __('user.common.previous') }}</span>
                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                <div class="flex items-center gap-1 mx-2">
                                    @php
                                        $start = max(1, $transactions->currentPage() - 2);
                                        $end = min($transactions->lastPage(), $transactions->currentPage() + 2);
                                    @endphp

                                    @if ($start > 1)
                                        <a href="{{ $transactions->url(1) }}"
                                           class="px-3 py-2 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 text-sm">
                                            1
                                        </a>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-500 dark:text-gray-600">...</span>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $transactions->currentPage())
                                            <div class="px-3 py-2 bg-blue-600 text-white rounded-lg shadow-md font-medium text-sm">
                                                {{ $page }}
                                            </div>
                                        @else
                                            <a href="{{ $transactions->url($page) }}"
                                               class="px-3 py-2 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 text-sm">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if ($end < $transactions->lastPage())
                                        @if ($end < $transactions->lastPage() - 1)
                                            <span class="px-2 text-gray-500 dark:text-gray-600">...</span>
                                        @endif
                                        <a href="{{ $transactions->url($transactions->lastPage()) }}"
                                           class="px-3 py-2 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 text-sm">
                                            {{ $transactions->lastPage() }}
                                        </a>
                                    @endif
                                </div>

                                <!-- Next Button -->
                                @if ($transactions->hasMorePages())
                                    <a href="{{ $transactions->nextPageUrl() }}"
                                       class="px-3 py-2 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-white hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg transition-all duration-200 flex items-center gap-1">
                                        <span class="hidden sm:inline">{{ __('user.common.next') }}</span>
                                        <x-heroicon name="chevron-right" class="w-4 h-4" />
                                    </a>
                                @else
                                    <div class="px-3 py-2 text-gray-500 dark:text-gray-600 cursor-not-allowed">
                                        <x-heroicon name="chevron-right" class="w-4 h-4" />
                                    </div>
                                @endif
                            </div>

                            <!-- Mobile Quick Jump (Optional) -->
                            <div class="sm:hidden w-full">
                                <select onchange="window.location.href = this.value"
                                        class="w-full px-3 py-2 bg-gray-700 dark:bg-gray-600 border border-gray-600 dark:border-gray-500 rounded-lg text-white dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @for ($page = 1; $page <= $transactions->lastPage(); $page++)
                                        <option value="{{ $transactions->url($page) }}"
                                                {{ $page == $transactions->currentPage() ? 'selected' : '' }}>
                                            {{ __('user.common.page_of', ['page' => $page, 'total' => $transactions->lastPage()]) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cancel Plan Modal -->
        <div
            x-show="showCancelModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showCancelModal = false"></div>

                <div
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-xl transform transition-all max-w-md w-full mx-4 p-6 z-10 border border-gray-700 dark:border-gray-600">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                            <x-heroicon name="exclamation-triangle" class="h-8 w-8 text-red-600 dark:text-red-400" />
                        </div>
                        <h3 class="text-xl font-semibold text-white dark:text-white mb-2">{{ __('user.plan_details.cancel_investment_plan') }}</h3>
                        <p class="mb-6 text-gray-300 dark:text-gray-400 text-sm md:text-base">{{ __('user.plan_details.cancel_confirmation', ['plan' => $plan->uplan->name]) }}</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4">
                            <button @click="showCancelModal = false" class="w-full sm:w-auto px-4 py-2 bg-gray-700 dark:bg-gray-700 text-gray-300 dark:text-gray-300 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-600 focus:outline-none transition-colors text-sm font-medium">
                                {{ __('user.common.cancel') }}
                            </button>
                            <a href="{{ route('cancelplan', $plan->id) }}" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none transition-colors text-sm font-medium text-center">
                                {{ __('user.plan_details.confirm_cancellation') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Calculate and display progress if needed
            const startDate = new Date('{{ $plan->created_at }}');
            const endDate = new Date('{{ $plan->expire_date }}');
            const currentDate = new Date();

            if (currentDate >= startDate && currentDate <= endDate) {
                const totalDuration = endDate - startDate;
                const elapsedTime = currentDate - startDate;
                const progressPercent = Math.min(100, Math.round((elapsedTime / totalDuration) * 100));

                // If you want to show a progress bar
                if (document.getElementById('plan-progress')) {
                    document.getElementById('plan-progress').style.width = `${progressPercent}%`;
                }
            }
        });
    </script>
@endsection
