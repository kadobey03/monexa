@extends('layouts.admin', ['title' => __('admin.demo.management')])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.demo.management') }}</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('admin.demo.management_description') }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                <x-heroicon name="plus" class="h-4 w-4 mr-2" />
                {{ __('admin.demo.new_account') }}
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center">
                        <x-heroicon name="users" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.demo.active_accounts') }}</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">0</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center">
                        <x-heroicon name="arrow-trending-up" class="w-6 h-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.demo.total_trades') }}</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">0</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center">
                        <x-heroicon name="currency-dollar" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.demo.demo_balance') }}</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">$0</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-xl flex items-center justify-center">
                        <x-heroicon name="activity" class="w-6 h-6 text-orange-600 dark:text-orange-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.demo.active_trades') }}</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">0</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Trading Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('admin.demo.accounts') }}</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="{{ __('admin.demo.search_accounts') }}"
                               class="admin-input w-64 pl-10 pr-4 py-2 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="magnifying-glass" class="w-4 h-4 text-gray-400" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-admin-200 dark:divide-admin-700">
                <thead class="bg-admin-50 dark:bg-admin-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.user') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.demo_balance') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.open_trades') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.last_activity') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.demo.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700">
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-center">
                                <x-heroicon name="inbox" class="w-12 h-12 text-admin-400 mx-auto mb-4" />
                                <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100 mb-2">{{ __('admin.demo.no_accounts_yet') }}</h3>
                                <p class="text-admin-500 dark:text-admin-400 mb-6">{{ __('admin.demo.accounts_will_display') }}</p>
                                <button class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <x-heroicon name="plus" class="h-4 w-4 mr-2" />
                                    {{ __('admin.demo.create_first_account') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Demo trading specific JavaScript can be added here
        console.log('Demo Trading Management page loaded');
    });
</script>
@endpush
@endsection