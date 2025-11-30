@extends('layouts.admin', ['title' => __('admin.deposits.customer_investments')])

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 min-h-screen">
            <!-- Header Section -->
    <div class="bg-white dark:bg-admin-800 border-b border-admin-200 dark:border-admin-700 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('admin.deposits.manage_customer_investments') }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.deposits.view_approve_manage_description') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                                {{ $deposits->count() }} {{ __('admin.deposits.total_records') }}
                            </div>
                            <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.deposits.refresh') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Statistics Cards -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Amount -->
                    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-admin-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">{{ __('admin.deposits.total_amount') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $settings->currency }}{{ number_format($deposits->sum('amount')) }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-green-50">
                            <div class="flex items-center text-green-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.deposits.all_investments') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Processed -->
                    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-admin-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">{{ __('admin.deposits.processed') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $deposits->where('status', 'Processed')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-blue-50">
                            <div class="flex items-center text-blue-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.deposits.approved_transactions') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pending -->
                    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-admin-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-yellow-100 text-sm font-medium">{{ __('admin.deposits.pending') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $deposits->where('status', '!=', 'Processed')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-yellow-50">
                            <div class="flex items-center text-yellow-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('admin.deposits.waiting_approval') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Users -->
                    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-admin-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-100 text-sm font-medium">{{ __('admin.deposits.active_users') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $deposits->pluck('duser_id')->unique()->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-purple-50">
                            <div class="flex items-center text-purple-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                {{ __('admin.deposits.unique_users') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
                <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-admin-900 dark:to-admin-800 px-6 py-4 border-b border-admin-200 dark:border-admin-700">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 lg:mb-0">{{ __('admin.deposits.investment_list') }}</h2>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="{{ __('admin.deposits.search_placeholder') }}"
                                           class="w-full sm:w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="relative">
                                    <select id="filterSelect" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="all">{{ __('admin.deposits.all') }}</option>
                                        <option value="Processed">{{ __('admin.deposits.processed') }}</option>
                                        <option value="pending">{{ __('admin.deposits.pending') }}</option>
                                        <option value="investment">{{ __('admin.deposits.investment_payment') }}</option>
                                        <option value="signal">{{ __('admin.deposits.signal_payment') }}</option>
                                    </select>
                                    <svg class="absolute right-2 top-2.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="depositsTable" class="min-w-full divide-y divide-admin-200 dark:divide-admin-700">
                            <thead class="bg-gray-50 dark:bg-admin-900">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.customer') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.email') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.amount') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.payment_method') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.investment_type') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.date') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('admin.deposits.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700">
                                @forelse ($deposits as $deposit)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Customer -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if(isset($deposit->duser->name) && $deposit->duser->name != null)
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-white">{{ substr($deposit->duser->name, 0, 1) }}</span>
                                                        </div>
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ isset($deposit->duser->name) && $deposit->duser->name != null ? $deposit->duser->name : __('admin.deposits.user_deleted') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Email -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ isset($deposit->duser->email) && $deposit->duser->email != null ? $deposit->duser->email : __('admin.deposits.user_deleted') }}
                                            </div>
                                        </td>
                                        
                                        <!-- Amount -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                {{ $settings->currency }}{{ number_format($deposit->amount) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Payment Method -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                </svg>
                                                {{ $deposit->payment_mode }}
                                            </span>
                                        </td>
                                        
                                        <!-- Investment Type -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($deposit->signals == Null)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.investment_payment') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.signal_payment') }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($deposit->status == 'Processed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.processed') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $deposit->status }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm text-gray-900 dark:text-white">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <div>
                                                    <div>{{ $deposit->created_at->format('d M Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ $deposit->created_at->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('viewdepositimage', $deposit->id) }}" 
                                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.view') }}
                                                </a>
                                                @if ($deposit->status != 'Processed')
                                                    <a href="{{ url('admin/dashboard/pdeposit') }}/{{ $deposit->id }}"
                                                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 bg-green-100 hover:bg-green-200 rounded-lg transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ __('admin.deposits.approve') }}
                                                    </a>
                                                @endif
                                                <a href="{{ url('admin/dashboard/deldeposit') }}/{{ $deposit->id }}"
                                                   onclick="return confirm('{{ __('admin.deposits.delete_confirmation') }}')"
                                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-lg transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.delete') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('admin.deposits.no_investment_records') }}</h3>
                                                <p class="text-gray-500 mb-6">{{ __('admin.deposits.records_will_appear') }}</p>
                                                <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.deposits.refresh_page') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($deposits->hasPages())
                        <div class="bg-white dark:bg-admin-800 px-6 py-4 border-t border-admin-200 dark:border-admin-700">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    <span>{{ __('admin.deposits.showing') }}:</span>
                                    <span class="font-medium">{{ $deposits->firstItem() ?? 0 }}</span>
                                    <span>-</span>
                                    <span class="font-medium">{{ $deposits->lastItem() ?? 0 }}</span>
                                    <span>{{ __('admin.deposits.total') }}:</span>
                                    <span class="font-medium">{{ $deposits->total() ?? 0 }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-700">{{ __('admin.deposits.per_page') }}:</label>
                                    <select onchange="changePerPage(this.value)" class="border border-gray-300 rounded-lg px-2 py-1 text-sm">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                {{ $deposits->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>

<!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#depositsTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) { // Skip empty state row
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
        
        // Filter functionality
        document.getElementById('filterSelect').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('#depositsTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) { // Skip empty state row
                    let showRow = true;
                    
                    switch(filterValue) {
                        case 'Processed':
                            const statusText = row.cells[5].textContent.trim();
                            showRow = statusText.includes('{{ __('admin.deposits.processed') }}');
                            break;
                        case 'pending':
                            const statusTextPending = row.cells[5].textContent.trim();
                            showRow = !statusTextPending.includes('{{ __('admin.deposits.processed') }}');
                            break;
                        case 'investment':
                            const investmentText = row.cells[4].textContent.trim();
                            showRow = investmentText.includes('{{ __('admin.deposits.investment_payment') }}');
                            break;
                        case 'signal':
                            const signalText = row.cells[4].textContent.trim();
                            showRow = signalText.includes('{{ __('admin.deposits.signal_payment') }}');
                            break;
                        case 'all':
                        default:
                            showRow = true;
                            break;
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                }
            });
        });
        
        // Change per page functionality
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }
    </script>
@endsection