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
@extends('layouts.master', ['layoutType' => 'admin', 'title' => 'Admin Paneli'])
@section('content')
    <!-- Admin Layout Container -->
    <div class="min-h-screen bg-gray-50">
        @include('admin.topmenu')
        @include('admin.sidebar')
        
        <!-- Main Content -->
        <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300 pt-16 lg:pt-20">
            <!-- Hero Header Section -->
            <div class="relative min-h-[300px] bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 overflow-hidden mt-0 lg:mt-0">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;grain&quot; width=&quot;100&quot; height=&quot;100&quot; patternUnits=&quot;userSpaceOnUse&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;1&quot; fill=&quot;%23ffffff&quot; opacity=&quot;0.02&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23grain)&quot;/></svg>');"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1 mb-8 lg:mb-0">
                        <!-- Welcome Badge -->
                        <div class="inline-flex items-center px-4 py-2 mb-6 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium animate-fade-in-up">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                            Yönetim Paneli
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4 animate-fade-in-left">
                            <svg class="w-10 h-10 lg:w-12 lg:h-12 mr-3 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Kontrol Paneli
                        </h1>
                        
                        <!-- Greeting -->
                        <h2 class="text-xl lg:text-2xl text-white/90 mb-4 animate-fade-in-left animation-delay-200">
                            Hoş geldiniz, {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}!
                        </h2>
                        
                        <!-- Date Time -->
                        <div class="flex items-center text-white/80 text-lg animate-fade-in-left animation-delay-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ date('l, F j, Y') }}
                            <span class="mx-3">•</span>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span id="current-time" class="font-medium"></span>
                        </div>
                    </div>
                    
                    @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-3 lg:space-y-4">
                            <a href="{{ route('mdeposits') }}" class="group inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Yatırımlar
                            </a>
                            <a href="{{ route('mwithdrawals') }}" class="group inline-flex items-center justify-center px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Çekimler
                            </a>
                            <a href="{{ route('manageusers') }}" class="group inline-flex items-center justify-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                Kullanıcılar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div class="px-4 sm:px-6 lg:px-8">
            <x-danger-alert />
            <x-success-alert />
        </div>
        
        <!-- Main Dashboard Content -->
        <div class="px-4 py-8 sm:px-6 lg:px-8 -mt-20 relative z-20">
            <!-- Financial Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Deposits -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-emerald-500 animate-fade-in-up">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 7a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V7zM6 5a2 2 0 012-2h4a2 2 0 012 2v1H6V5z"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-emerald-100 rounded-full">
                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Toplam Yatırımlar</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">
                            @foreach ($total_deposited as $deposited)
                                @if (!empty($deposited->count))
                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                @else
                                    {{ $settings->currency }}0.00
                                @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Tüm zamanlar toplamı
                        </p>
                    </div>
                </div>
                
                <!-- Pending Deposits -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-amber-500 animate-fade-in-up animation-delay-100">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-amber-100 rounded-full">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Bekleyen Yatırımlar</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">
                            @foreach ($pending_deposited as $deposited)
                                @if (!empty($deposited->count))
                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                @else
                                    {{ $settings->currency }}0.00
                                @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Onay bekliyor
                        </p>
                    </div>
                </div>
                
                <!-- Total Withdrawals -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-rose-500 animate-fade-in-up animation-delay-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h10zM4 8a1 1 0 011-1h1a1 1 0 010 2H5a1 1 0 01-1-1zm5 1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-rose-100 rounded-full">
                                <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Toplam Çekimler</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">
                            @foreach ($total_withdrawn as $deposited)
                                @if (!empty($deposited->count))
                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                @else
                                    {{ $settings->currency }}0.00
                                @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Tüm zamanlar toplamı
                        </p>
                    </div>
                </div>
                
                <!-- Pending Withdrawals -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-blue-500 animate-fade-in-up animation-delay-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-blue-100 rounded-full">
                                <svg class="w-4 h-4 text-blue-600 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Bekleyen Çekimler</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">
                            @foreach ($pending_withdrawn as $deposited)
                                @if (!empty($deposited->count))
                                    {{ $settings->currency }}{{ number_format($deposited->count) }}
                                @else
                                    {{ $settings->currency }}0.00
                                @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            İşleniyor
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- User Statistics Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-purple-500 animate-fade-in-up animation-delay-400">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-purple-100 rounded-full">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Toplam Kullanıcılar</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($user_count) }}</p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Toplam kayıtlı
                        </p>
                    </div>
                </div>
                
                <!-- Active Users -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-emerald-500 animate-fade-in-up animation-delay-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-emerald-100 rounded-full">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Aktif Kullanıcılar</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">{{ $activeusers }}</p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                            </svg>
                            Şu anda çevrimiçi
                        </p>
                    </div>
                </div>
                
                <!-- Blocked Users -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-rose-500 animate-fade-in-up animation-delay-600">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-rose-100 rounded-full">
                                <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Engellenen Kullanıcılar</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">{{ $blockeusers }}</p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Askıya alınmış hesaplar
                        </p>
                    </div>
                </div>
                
                <!-- Investment Plans -->
                <div class="group relative bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-l-4 border-amber-500 animate-fade-in-up animation-delay-700">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent rounded-2xl opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                            </div>
                            <div class="p-1 bg-amber-100 rounded-full">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Yatırım Planları</h3>
                        <p class="text-2xl font-bold text-gray-900 mb-2">{{ $plans }}</p>
                        <p class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Mevcut planlar
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Analytics Chart Section -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden animate-fade-in-up animation-delay-800">
                <!-- Chart Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200/50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                </svg>
                                Sistem Analitiği
                            </h2>
                            <p class="text-gray-600 text-sm">Finansal genel bakış ve işlem analitiği</p>
                        </div>
                        
                        <!-- Period Selector -->
                        <div class="inline-flex rounded-lg bg-gray-100 p-1" role="group">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-transparent rounded-md hover:bg-white hover:text-gray-900 transition-all duration-200">
                                Bugün
                            </button>
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-transparent rounded-md hover:bg-white hover:text-gray-900 transition-all duration-200">
                                Bu Hafta
                            </button>
                            <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm transition-all duration-200">
                                Bu Ay
                            </button>
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-transparent rounded-md hover:bg-white hover:text-gray-900 transition-all duration-200">
                                Bu Yıl
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Content -->
                <div class="p-6">
                    <div class="relative">
                        <canvas id="myChart" class="w-full h-96"></canvas>
                    </div>
                    
                    <!-- Chart Summary -->
                    <div class="mt-8 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-gray-900">{{ $settings->currency }}{{ number_format($chart_pdepsoit) }}</span>
                                <span class="text-xs text-gray-600 uppercase tracking-wider">Toplam Yatırımlar</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-gray-900">{{ $settings->currency }}{{ number_format($chart_pwithdraw) }}</span>
                                <span class="text-xs text-gray-600 uppercase tracking-wider">Toplam Çekimler</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-gray-900">{{ $settings->currency }}{{ number_format($chart_pendepsoit) }}</span>
                                <span class="text-xs text-gray-600 uppercase tracking-wider">Bekleyen Yatırımlar</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-gray-900">{{ $settings->currency }}{{ number_format($chart_trans) }}</span>
                                <span class="text-xs text-gray-600 uppercase tracking-wider">İşlemler</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin Layout Container -->
    </div>

    <!-- Enhanced Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time clock with enhanced formatting
            function updateTime() {
                const now = new Date();
                const timeOptions = {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                const timeString = now.toLocaleTimeString('tr-TR', timeOptions);
                const timeElement = document.getElementById('current-time');
                
                if (timeElement) {
                    timeElement.textContent = timeString;
                    // Add subtle color animation based on seconds
                    const hue = (now.getSeconds() * 6) % 360;
                    timeElement.style.color = `hsl(${hue}, 60%, 60%)`;
                }
            }
            
            updateTime();
            setInterval(updateTime, 1000);
            
            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded. Please check the CDN link.');
                return;
            }

            // Chart setup with modern styling
            const ctx = document.getElementById('myChart')?.getContext('2d');
            if (ctx) {
                // Ensure Chart.js is loaded before creating chart
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded yet, retrying...');
                    setTimeout(() => {
                        if (typeof Chart !== 'undefined') {
                            createChart();
                        } else {
                            console.error('Chart.js failed to load after retry');
                        }
                    }, 100);
                    return;
                }

                createChart();
            }

            function createChart() {
                const chartData = [
                    "{{ $chart_pdepsoit }}",
                    "{{ $chart_pendepsoit }}",
                    "{{ $chart_pwithdraw }}",
                    "{{ $chart_pendwithdraw }}",
                    "{{ $chart_trans }}"
                ];
                
                // Create gradient backgrounds
                const createGradient = (ctx, color1, color2) => {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, color1);
                    gradient.addColorStop(1, color2);
                    return gradient;
                };
                
                const gradients = [
                    createGradient(ctx, 'rgba(16, 185, 129, 0.8)', 'rgba(16, 185, 129, 0.2)'),
                    createGradient(ctx, 'rgba(245, 158, 11, 0.8)', 'rgba(245, 158, 11, 0.2)'),
                    createGradient(ctx, 'rgba(239, 68, 68, 0.8)', 'rgba(239, 68, 68, 0.2)'),
                    createGradient(ctx, 'rgba(59, 130, 246, 0.8)', 'rgba(59, 130, 246, 0.2)'),
                    createGradient(ctx, 'rgba(139, 92, 246, 0.8)', 'rgba(139, 92, 246, 0.2)')
                ];
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Toplam Yatırımlar', 'Bekleyen Yatırımlar', 'Toplam Çekimler', 'Bekleyen Çekimler', 'Toplam İşlemler'],
                        datasets: [{
                            label: `Tutar ({{ $settings->currency }})`,
                            data: chartData,
                            backgroundColor: gradients,
                            borderColor: [
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)',
                                'rgb(59, 130, 246)',
                                'rgb(139, 92, 246)'
                            ],
                            borderWidth: 2,
                            borderRadius: 12,
                            borderSkipped: false,
                            hoverBorderRadius: 16,
                            hoverBorderWidth: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255, 255, 255, 0.2)',
                                borderWidth: 1,
                                cornerRadius: 12,
                                displayColors: true,
                                padding: 12,
                                titleFont: { size: 14, weight: '600' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: function(context) {
                                        const value = new Intl.NumberFormat('tr-TR').format(context.parsed.y);
                                        return `Tutar: {{ $settings->currency }}${value}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false,
                                    lineWidth: 1
                                },
                                ticks: {
                                    font: { size: 12, family: "'Inter', sans-serif" },
                                    color: '#6b7280',
                                    padding: 10,
                                    callback: function(value) {
                                        if (value >= 1000000) {
                                            return '{{ $settings->currency }}' + (value / 1000000).toFixed(1) + 'M';
                                        } else if (value >= 1000) {
                                            return '{{ $settings->currency }}' + (value / 1000).toFixed(1) + 'K';
                                        }
                                        return '{{ $settings->currency }}' + new Intl.NumberFormat('tr-TR').format(value);
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { size: 12, weight: '600', family: "'Inter', sans-serif" },
                                    color: '#374151',
                                    padding: 15
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        interaction: { intersect: false, mode: 'index' },
                        elements: { bar: { hoverBorderRadius: 16 } }
                    }
                });
            }
        });
        });
    </script>
    
    <style>
        /* Modern Tailwind Extensions */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Animation Classes */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out;
        }
        
        .animation-delay-100 { animation-delay: 100ms; }
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-300 { animation-delay: 300ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-500 { animation-delay: 500ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .animation-delay-700 { animation-delay: 700ms; }
        .animation-delay-800 { animation-delay: 800ms; }
        
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
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Glass morphism effect */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
        
        /* Responsive Design Enhancements */
        @media (max-width: 640px) {
            .text-4xl { font-size: 2rem; }
            .text-5xl { font-size: 2.5rem; }
            
            /* Stack financial cards vertically on mobile */
            .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
            
            /* Adjust padding for mobile */
            .px-4 { padding-left: 1rem; padding-right: 1rem; }
            .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        }
        
        @media (min-width: 640px) {
            .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
        
        /* Hover effects for cards */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
        
        .group:hover .group-hover\:animate-bounce {
            animation: bounce 1s infinite;
        }
        
        .group:hover .group-hover\:animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .bg-white\/95 {
                background-color: rgba(31, 41, 55, 0.95);
            }
            
            .text-gray-900 {
                color: rgb(243, 244, 246);
            }
            
            .text-gray-600 {
                color: rgb(156, 163, 175);
            }
            
            .border-gray-200\/50 {
                border-color: rgba(75, 85, 99, 0.5);
            }
        }
    </style>
@endsection