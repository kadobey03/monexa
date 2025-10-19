<?php
$admin = Auth::guard('admin')->user();
$dashboard_style = $admin->dashboard_style ?? 'dark';

if ($dashboard_style === 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-blue-600">{{ $user->name }}</h1>
                                <p class="text-gray-600 mt-1">Kullanıcı Detay Yönetimi</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('manageusers') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Geri
                            </a>
                            
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    İşlemler
                                    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg z-50">
                                    <div class="py-1">
                                        <a href="{{ route('loginactivity', $user->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                            Giriş Aktivitesi
                                        </a>
                                        
                                        @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                                            <a href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}" class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                Yasağı Kaldır / Etkinleştir
                                            </a>
                                        @else
                                            <a href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.367zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path></svg>
                                                Yasakla / Devre Dışı Bırak
                                            </a>
                                        @endif
                                        
                                        @if (!$user->email_verified_at)
                                            <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}" class="flex items-center px-4 py-2 text-sm text-blue-700 hover:bg-blue-50">
                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                                E-postayı Doğrula
                                            </a>
                                        @endif
                                        
                                        <button data-modal-target="topupModal" data-modal-toggle="topupModal" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h10zM4 8a1 1 0 011-1h1a1 1 0 010 2H5a1 1 0 01-1-1zm5 1a1 1 0 100 2h1a1 1 0 100-2H9z"></path></svg>
                                            Kredi/Debit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Main User Details Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <!-- Financial Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Account Balance -->
                    <div class="group relative bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 text-center">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white/90 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 7a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V7zM6 5a2 2 0 012-2h4a2 2 0 012 2v1H6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white/80 text-sm font-semibold uppercase tracking-wider mb-2">Hesap Bakiyesi</h3>
                            <p class="text-white text-2xl font-bold">{{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}</p>
                        </div>
                    </div>
                    
                    <!-- Profit -->
                    <div class="group relative bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 text-center">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white/90 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-white/80 text-sm font-semibold uppercase tracking-wider mb-2">Kâr</h3>
                            <p class="text-white text-2xl font-bold">{{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }}</p>
                        </div>
                    </div>
                    
                    <!-- Bonus -->
                    <div class="group relative bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10 text-center">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white/90 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path><path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white/80 text-sm font-semibold uppercase tracking-wider mb-2">Bonus</h3>
                            <p class="text-white text-2xl font-bold">{{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- User Transactions Section -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                        <div class="flex items-center text-white">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <h2 class="text-xl font-bold">Müşteri İşlemleri</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($user->trade != null)
                            <a href="{{ route('user.plans', $user->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                İşlemleri Görüntüle
                            </a>
                        @else
                            <div class="text-center py-12">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm-8.207-.293a1 1 0 011.414 0l.707.707a1 1 0 11-1.414 1.414l-.707-.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-gray-500 text-lg font-medium">Henüz İşlem Yok</h3>
                                <p class="text-gray-400 text-sm mt-1">Bu kullanıcı henüz hiç işlem yapmamış</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Account Status Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- KYC Status -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                        <div class="mb-4">
                            @if ($user->account_verify == 'Verified')
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-gray-600 font-medium mb-2">KYC Durumu</h3>
                        @if ($user->account_verify == 'Verified')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Doğrulanmış
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Doğrulanmamış
                            </span>
                        @endif
                    </div>
                    
                    <!-- Trade Mode -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                        <div class="mb-4">
                            @if ($user->tradetype == 'Loss' || $user->tradetype == null)
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0L4 12.414V14a1 1 0 01-2 0V10a1 1 0 011-1h4a1 1 0 110 2H5.414l5.293 5.293a1 1 0 001.414 0l5.586-5.586a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-gray-600 font-medium mb-2">İşlem Modu</h3>
                        @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0L4 12.414V14a1 1 0 01-2 0V10a1 1 0 011-1h4a1 1 0 110 2H5.414l5.293 5.293a1 1 0 001.414 0l5.586-5.586a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Loss
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Profit
                            </span>
                        @endif
                    </div>
                    
                    <!-- Account Status -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                        <div class="mb-4">
                            @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.367zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @elseif ($user->status == 'active')
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-gray-600 font-medium mb-2">Hesap Durumu</h3>
                        @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.367zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ ucfirst($user->status) }}
                            </span>
                        @elseif ($user->status == 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Beklemede
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- User Information Section -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
                        <div class="flex items-center text-white">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                            <h2 class="text-xl font-bold">KULLANICI BİLGİLERİ</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border-l-4 border-blue-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">Ad Soyad</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-xl border-l-4 border-green-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">E-posta Adresi</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-xl border-l-4 border-purple-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">Cep Telefonu</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $user->phone ?? 'Belirtilmemiş' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-orange-50 to-red-50 p-4 rounded-xl border-l-4 border-orange-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">Doğum Tarihi</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $user->dob ?? 'Belirtilmemiş' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-xl border-l-4 border-teal-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">Uyruk</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ $user->country ?? 'Belirtilmemiş' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-4 rounded-xl border-l-4 border-gray-500">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-600">Kayıt Tarihi</p>
                                        <p class="text-lg font-bold text-gray-900 truncate">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('admin.Users.users_actions')
@endsection