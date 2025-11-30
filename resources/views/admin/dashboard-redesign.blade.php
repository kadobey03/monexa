<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bg = 'light';
    $text = 'dark';
    $gradient = 'primary';
} else {
    $bg = 'dark';
    $text = 'light';
    $gradient = 'dark';
}
?>
@extends('layouts.admin', ['title' => 'Dashboard'])
@section('content')
    <!-- Modern Admin Layout Container -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        @include('admin.topmenu')
        @include('admin.sidebar')
        
        <!-- Main Content Area -->
        <main class="admin-main-content flex-1 lg:ml-64 transition-all duration-300 pt-16 lg:pt-20">
            
            <!-- Enhanced Hero Section -->
            <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 py-12 lg:py-16">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-transparent to-black/10"></div>
                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)"/>
                    </svg>
                </div>
                
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-8 lg:space-y-0">
                        
                        <!-- Welcome Content -->
                        <div class="flex-1 space-y-6">
                            <!-- Status Badge -->
                            <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-500/20 border border-emerald-500/30 backdrop-blur-sm">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-3 animate-pulse"></div>
                                <span class="text-emerald-100 text-sm font-medium">{{ __('admin.dashboard.system_active') }}</span>
                            </div>
                            
                            <!-- Main Title -->
                            <div class="space-y-3">
                                <h1 class="text-3xl lg:text-5xl font-bold text-white">
                                    <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                                        {{ __('admin.dashboard.advanced_control_panel') }}
                                    </span>
                                </h1>
                                <p class="text-xl lg:text-2xl text-blue-100 font-light">
                                    {{ __('admin.dashboard.welcome_admin', ['name' => Auth('admin')->User()->firstName . ' ' . Auth('admin')->User()->lastName]) }}
                                </p>
                            </div>
                            
                            <!-- Admin Info -->
                            <div class="flex items-center space-x-6 text-blue-100">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-medium">{{ Auth('admin')->User()->type }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span id="live-time" class="font-mono">{{ date('H:i:s') }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ date('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions Panel -->
                        @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                            <div class="flex-shrink-0">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 lg:w-72">
                                    <a href="{{ route('mdeposits') }}" 
                                       class="group flex items-center justify-between p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-emerald-500 rounded-xl">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-white font-semibold">{{ __('admin.dashboard.investments') }}</span>
                                        </div>
                                        <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('mwithdrawals') }}" 
                                       class="group flex items-center justify-between p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-rose-500 rounded-xl">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-white font-semibold">{{ __('admin.dashboard.withdrawals_short') }}</span>
                                        </div>
                                        <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('manageusers') }}" 
                                       class="group flex items-center justify-between p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 lg:col-span-1 sm:col-span-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-blue-500 rounded-xl">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-white font-semibold">{{ __('admin.dashboard.user_management') }}</span>
                                        </div>
                                        <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Alert Messages -->
            <div class="relative z-20 -mt-8 px-4 sm:px-6 lg:px-8">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Main Dashboard Content -->
            <div class="relative z-10 px-4 py-8 sm:px-6 lg:px-8 -mt-4">
                
                <!-- Enhanced Financial Statistics -->
                <section class="mb-12">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('admin.dashboard.financial_status_summary') }}</h2>
                        <p class="text-gray-600">{{ __('admin.dashboard.system_financial_status_description') }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Deposits Card -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-3xl transform rotate-1 transition-transform group-hover:rotate-2"></div>
                            <div class="relative bg-white rounded-3xl p-6 shadow-xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-emerald-100 rounded-2xl">
                                        <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 7a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V7zM6 5a2 2 0 012-2h4a2 2 0 012 2v1H6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-emerald-600 font-medium">{{ __('admin.dashboard.active') }}</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.total_investments') }}</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-3">
                                    @foreach ($total_deposited as $deposited)
                                        @if (!empty($deposited->count))
                                            {{ $settings->currency }}{{ number_format($deposited->count) }}
                                        @else
                                            {{ $settings->currency }}0.00
                                        @endif
                                    @endforeach
                                </p>
                                
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('admin.dashboard.all_time_total') }}
                                </div>
                            </div>
                        </div>

                        <!-- Pending Deposits Card -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-amber-600 to-amber-700 rounded-3xl transform rotate-1 transition-transform group-hover:rotate-2"></div>
                            <div class="relative bg-white rounded-3xl p-6 shadow-xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-amber-100 rounded-2xl">
                                        <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-amber-500 rounded-full animate-bounce"></div>
                                        <span class="text-xs text-amber-600 font-medium">{{ __('admin.dashboard.pending') }}</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.pending_investments') }}</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-3">
                                    @foreach ($pending_deposited as $deposited)
                                        @if (!empty($deposited->count))
                                            {{ $settings->currency }}{{ number_format($deposited->count) }}
                                        @else
                                            {{ $settings->currency }}0.00
                                        @endif
                                    @endforeach
                                </p>
                                
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('admin.dashboard.awaiting_approval') }}
                                </div>
                            </div>
                        </div>

                        <!-- Total Withdrawals Card -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-rose-600 to-rose-700 rounded-3xl transform rotate-1 transition-transform group-hover:rotate-2"></div>
                            <div class="relative bg-white rounded-3xl p-6 shadow-xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-rose-100 rounded-2xl">
                                        <svg class="w-8 h-8 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h10zM4 8a1 1 0 011-1h1a1 1 0 010 2H5a1 1 0 01-1-1zm5 1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-rose-500 rounded-full"></div>
                                        <span class="text-xs text-rose-600 font-medium">{{ __('admin.dashboard.completed') }}</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.total_withdrawals') }}</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-3">
                                    @foreach ($total_withdrawn as $deposited)
                                        @if (!empty($deposited->count))
                                            {{ $settings->currency }}{{ number_format($deposited->count) }}
                                        @else
                                            {{ $settings->currency }}0.00
                                        @endif
                                    @endforeach
                                </p>
                                
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('admin.dashboard.completed_transactions') }}
                                </div>
                            </div>
                        </div>

                        <!-- Pending Withdrawals Card -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 rounded-3xl transform rotate-1 transition-transform group-hover:rotate-2"></div>
                            <div class="relative bg-white rounded-3xl p-6 shadow-xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-blue-100 rounded-2xl">
                                        <svg class="w-8 h-8 text-blue-600 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                        <span class="text-xs text-blue-600 font-medium">{{ __('admin.dashboard.processing') }}</span>
                                    </div>
                                </div>
                                
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.pending_withdrawals') }}</h3>
                                <p class="text-3xl font-bold text-gray-900 mb-3">
                                    @foreach ($pending_withdrawn as $deposited)
                                        @if (!empty($deposited->count))
                                            {{ $settings->currency }}{{ number_format($deposited->count) }}
                                        @else
                                            {{ $settings->currency }}0.00
                                        @endif
                                    @endforeach
                                </p>
                                
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('admin.dashboard.under_review') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- User Statistics Section -->
                <section class="mb-12">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('admin.dashboard.user_statistics') }}</h2>
                        <p class="text-gray-600">{{ __('admin.dashboard.platform_user_status') }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Users -->
                        <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-purple-100 rounded-2xl">
                                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                                    {{ __('admin.dashboard.total') }}
                                </span>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.total_users') }}</h3>
                            <p class="text-3xl font-bold text-gray-900 mb-3">{{ number_format($user_count) }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.dashboard.all_registered_users') }}</p>
                        </div>

                        <!-- Active Users -->
                        <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-emerald-100 rounded-2xl">
                                    <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-emerald-600 font-medium">{{ __('admin.dashboard.online') }}</span>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.active_users') }}</h3>
                            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $activeusers }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.dashboard.currently_active') }}</p>
                        </div>

                        <!-- Blocked Users -->
                        <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-rose-100 rounded-2xl">
                                    <svg class="w-8 h-8 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-rose-600 bg-rose-100 px-3 py-1 rounded-full">
                                    {{ __('admin.dashboard.blocked') }}
                                </span>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.blocked_users') }}</h3>
                            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $blockeusers }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.dashboard.suspended_accounts') }}</p>
                        </div>

                        <!-- Investment Plans -->
                        <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-amber-100 rounded-2xl">
                                    <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-amber-600 bg-amber-100 px-3 py-1 rounded-full">
                                    {{ __('admin.dashboard.plans') }}
                                </span>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">{{ __('admin.dashboard.investment_plans') }}</h3>
                            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $plans }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.dashboard.available_plans') }}</p>
                        </div>
                    </div>
                </section>

                <!-- Enhanced Analytics Chart -->
                <section class="mb-12">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <!-- Chart Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-100">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="mb-4 lg:mb-0">
                                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                        <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                            </svg>
                                        </div>
                                        {{ __('admin.dashboard.advanced_system_analytics') }}
                                    </h2>
                                    <p class="text-gray-600 mt-2">{{ __('admin.dashboard.comprehensive_financial_analysis') }}</p>
                                </div>
                                
                                <!-- Period Selector -->
                                <div class="inline-flex rounded-2xl bg-white p-1 shadow-sm border border-gray-200" role="group">
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-xl shadow-sm hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        {{ __('admin.dashboard.today') }}
                                    </button>
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        {{ __('admin.dashboard.this_week') }}
                                    </button>
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        {{ __('admin.dashboard.this_month') }}
                                    </button>
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        {{ __('admin.dashboard.this_year') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chart Content -->
                        <div class="p-8">
                            <div class="relative mb-8">
                                <canvas id="modernChart" class="w-full" style="height: 400px;"></canvas>
                            </div>
                            
                            <!-- Enhanced Chart Summary -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                                <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl">
                                    <div class="text-2xl font-bold text-emerald-800">{{ $settings->currency }}{{ number_format($chart_pdepsoit) }}</div>
                                    <div class="text-sm text-emerald-600 font-medium mt-1">{{ __('admin.dashboard.total_investments') }}</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-rose-50 to-rose-100 rounded-2xl">
                                    <div class="text-2xl font-bold text-rose-800">{{ $settings->currency }}{{ number_format($chart_pwithdraw) }}</div>
                                    <div class="text-sm text-rose-600 font-medium mt-1">{{ __('admin.dashboard.total_withdrawals') }}</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl">
                                    <div class="text-2xl font-bold text-amber-800">{{ $settings->currency }}{{ number_format($chart_pendepsoit) }}</div>
                                    <div class="text-sm text-amber-600 font-medium mt-1">{{ __('admin.dashboard.pending_investments') }}</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl">
                                    <div class="text-2xl font-bold text-blue-800">{{ $settings->currency }}{{ number_format($chart_trans) }}</div>
                                    <div class="text-sm text-blue-600 font-medium mt-1">{{ __('admin.dashboard.total_transactions') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <!-- Enhanced Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced live clock
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('tr-TR', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                const timeElement = document.getElementById('live-time');
                if (timeElement) {
                    timeElement.textContent = timeString;
                    // Add subtle pulse animation every second
                    timeElement.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        timeElement.style.transform = 'scale(1)';
                    }, 200);
                }
            }
            
            updateTime();
            setInterval(updateTime, 1000);
            
            // Enhanced Chart Implementation
            const ctx = document.getElementById('modernChart');
            if (ctx) {
                const chartData = [
                    "{{ $chart_pdepsoit }}",
                    "{{ $chart_pendepsoit }}",
                    "{{ $chart_pwithdraw }}",
                    "{{ $chart_pendwithdraw }}",
                    "{{ $chart_trans }}"
                ];
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['{{ __('admin.dashboard.total_investments') }}', '{{ __('admin.dashboard.pending_investments') }}', '{{ __('admin.dashboard.total_withdrawals') }}', '{{ __('admin.dashboard.pending_withdrawals') }}', '{{ __('admin.dashboard.total_transactions') }}'],
                        datasets: [{
                            data: chartData,
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)', 
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderColor: [
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)',
                                'rgb(59, 130, 246)', 
                                'rgb(139, 92, 246)'
                            ],
                            borderWidth: 3,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 13,
                                        family: "'Inter', sans-serif",
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255, 255, 255, 0.2)',
                                borderWidth: 1,
                                cornerRadius: 12,
                                padding: 15,
                                titleFont: { size: 14, weight: '600' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        const value = new Intl.NumberFormat('tr-TR').format(context.parsed);
                                        return `${context.label}: {{ $settings->currency }}${value}`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }
        });
    </script>
    
    <style>
        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Enhanced card hover effects */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
        
        /* Custom scrollbar for the main content */
        .admin-main-content {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }
        
        .admin-main-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .admin-main-content::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .admin-main-content::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }
        
        .admin-main-content::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.7);
        }
    </style>
@endsection