@extends('layouts.admin', ['title' => 'Kullanıcı Detayları - ' . $user->name])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kullanıcı detay bilgileri ve hesap yönetimi</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('manageusers') }}"
               class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-admin-700 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-600">
                <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                Geri
            </a>
            
            <!-- Actions Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    İşlemler
                    <i data-lucide="chevron-down" class="ml-2 h-4 w-4"></i>
                </button>
                
                <div x-show="open" @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-64 bg-white dark:bg-admin-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-admin-600">
                    <div class="py-1">
                        <a href="{{ route('loginactivity', $user->id) }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="clock" class="w-4 h-4 mr-3"></i>
                            Giriş Aktivitesi
                        </a>
                        
                        @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                            <a href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                <i data-lucide="unlock" class="w-4 h-4 mr-3"></i>
                                Yasağı Kaldır / Etkinleştir
                            </a>
                        @else
                            <a href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i data-lucide="ban" class="w-4 h-4 mr-3"></i>
                                Yasakla / Devre Dışı Bırak
                            </a>
                        @endif
                        
                        @if (!$user->email_verified_at)
                            <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-blue-700 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <i data-lucide="mail-check" class="w-4 h-4 mr-3"></i>
                                E-postayı Doğrula
                            </a>
                        @endif
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openTopupModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="credit-card" class="w-4 h-4 mr-3"></i>
                            Kredi/Debit
                        </button>
                        
                        <button onclick="openEditModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="user-pen" class="w-4 h-4 mr-3"></i>
                            Kullanıcı Düzenle
                        </button>
                        
                        <button onclick="openTradingModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-3"></i>
                            Manuel İşlem Yap
                        </button>
                        
                        <button onclick="openSignalModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="radio" class="w-4 h-4 mr-3"></i>
                            Sinyal Oluştur
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openEmailModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="mail" class="w-4 h-4 mr-3"></i>
                            E-posta Gönder
                        </button>
                        
                        <button onclick="openNotifyModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="bell" class="w-4 h-4 mr-3"></i>
                            Bildirim Gönder
                        </button>
                        
                        <button onclick="openTaxModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="calculator" class="w-4 h-4 mr-3"></i>
                            Kullanıcı Vergisi
                        </button>
                        
                        <button onclick="openWithdrawalCodeModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="key" class="w-4 h-4 mr-3"></i>
                            Para Çekme Kodu
                        </button>
                        
                        <button onclick="openTradesModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="hash" class="w-4 h-4 mr-3"></i>
                            İşlem Sayısı Belirle
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openSwitchUserModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <i data-lucide="user-switch" class="w-4 h-4 mr-3"></i>
                            Kullanıcı Hesabına Geç
                        </button>
                        
                        <button onclick="openResetPasswordModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-orange-700 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20">
                            <i data-lucide="key-round" class="w-4 h-4 mr-3"></i>
                            Şifreyi Sıfırla
                        </button>
                        
                        <a href="{{ url('admin/dashboard/clearacct') }}/{{ $user->id }}"
                           onclick="return confirm('{{ $user->name }} kullanıcısının hesabını temizlemek istediğinizden emin misiniz?')"
                           class="flex items-center px-4 py-2 text-sm text-yellow-700 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                            <i data-lucide="eraser" class="w-4 h-4 mr-3"></i>
                            Hesabı Temizle
                        </a>
                        
                        <button onclick="openDeleteModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i data-lucide="user-x" class="w-4 h-4 mr-3"></i>
                            Hesabı Sil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />
            
    <!-- Financial Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Account Balance -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="wallet" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hesap Bakiyesi</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Profit -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="trending-up" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kâr</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Bonus -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="gift" class="h-6 w-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Bonus</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Transactions Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="activity" class="h-5 w-5 mr-2"></i>
                Müşteri İşlemleri
            </h2>
        </div>
        <div class="p-6">
            @if ($user->trade != null)
                <a href="{{ route('user.plans', $user->id) }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
                    İşlemleri Görüntüle
                </a>
            @else
                <div class="text-center py-12">
                    <i data-lucide="clipboard-x" class="mx-auto h-12 w-12 text-gray-400 mb-4"></i>
                    <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">Henüz İşlem Yok</h3>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Bu kullanıcı henüz hiç işlem yapmamış</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Account Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- KYC Status -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if ($user->account_verify == 'Verified')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="shield-check" class="h-8 w-8 text-green-600 dark:text-green-400"></i>
                    </div>
                @else
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="shield-x" class="h-8 w-8 text-red-600 dark:text-red-400"></i>
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">KYC Durumu</h3>
            @if ($user->account_verify == 'Verified')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                    Doğrulanmış
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                    Doğrulanmamış
                </span>
            @endif
        </div>
        
        <!-- Trade Mode -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if ($user->tradetype == 'Loss' || $user->tradetype == null)
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="trending-down" class="h-8 w-8 text-red-600 dark:text-red-400"></i>
                    </div>
                @else
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="trending-up" class="h-8 w-8 text-green-600 dark:text-green-400"></i>
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">İşlem Modu</h3>
            @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
                    Loss
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                    Profit
                </span>
            @endif
        </div>
        
        <!-- Account Status -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="user-x" class="h-8 w-8 text-red-600 dark:text-red-400"></i>
                    </div>
                @elseif ($user->status == 'active')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="user-check" class="h-8 w-8 text-green-600 dark:text-green-400"></i>
                    </div>
                @else
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="user-question" class="h-8 w-8 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">Hesap Durumu</h3>
            @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                    {{ ucfirst($user->status) }}
                </span>
            @elseif ($user->status == 'active')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                    Aktif
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                    <i data-lucide="help-circle" class="w-3 h-3 mr-1"></i>
                    Beklemede
                </span>
            @endif
        </div>
    </div>
    
    <!-- User Information Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="user" class="h-5 w-5 mr-2"></i>
                Kullanıcı Bilgileri
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="user" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Ad Soyad</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="mail" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">E-posta Adresi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="phone" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Cep Telefonu</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->phone ?? 'Belirtilmemiş' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg border border-orange-200 dark:border-orange-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="calendar" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Doğum Tarihi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->dob ?? 'Belirtilmemiş' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-teal-50 dark:bg-teal-900/20 p-4 rounded-lg border border-teal-200 dark:border-teal-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="flag" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Uyruk</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->country ?? 'Belirtilmemiş' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-900/20 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="clock" class="w-6 h-6 text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Kayıt Tarihi</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Basit event dispatch fonksiyonları
window.openTopupModal = function() {
    window.dispatchEvent(new CustomEvent('open-topup-modal'));
};

window.openEditModal = function() {
    window.dispatchEvent(new CustomEvent('open-edit-modal'));
};

window.openTradingModal = function() {
    window.dispatchEvent(new CustomEvent('open-trading-modal'));
};

window.openSignalModal = function() {
    window.dispatchEvent(new CustomEvent('open-signal-modal'));
};

window.openEmailModal = function() {
    window.dispatchEvent(new CustomEvent('open-email-modal'));
};

window.openNotifyModal = function() {
    window.dispatchEvent(new CustomEvent('open-notify-modal'));
};

window.openTaxModal = function() {
    window.dispatchEvent(new CustomEvent('open-tax-modal'));
};

window.openWithdrawalCodeModal = function() {
    window.dispatchEvent(new CustomEvent('open-withdrawal-code-modal'));
};

window.openTradesModal = function() {
    window.dispatchEvent(new CustomEvent('open-trades-modal'));
};

window.openSwitchUserModal = function() {
    window.dispatchEvent(new CustomEvent('open-switch-user-modal'));
};

window.openResetPasswordModal = function() {
    window.dispatchEvent(new CustomEvent('open-reset-password-modal'));
};

window.openDeleteModal = function() {
    window.dispatchEvent(new CustomEvent('open-delete-modal'));
};

// Debug için console.log ekleyelim
window.debugModals = function() {
    console.log('Modal elements:');
    console.log('Topup modal:', document.querySelector('#topupModal'));
    console.log('Edit modal:', document.querySelector('#editModal'));
    console.log('Trading modal:', document.querySelector('#tradingModal'));
    console.log('Signal modal:', document.querySelector('#signalModal'));
    console.log('Email modal:', document.querySelector('#emailModal'));
    console.log('Notify modal:', document.querySelector('#notifyModal'));
    console.log('Tax modal:', document.querySelector('#taxModal'));
    console.log('Withdrawal code modal:', document.querySelector('#withdrawalCodeModal'));
    console.log('Trades modal:', document.querySelector('#tradesModal'));
    console.log('Switch user modal:', document.querySelector('#switchUserModal'));
    console.log('Reset password modal:', document.querySelector('#resetPasswordModal'));
    console.log('Delete modal:', document.querySelector('#deleteModal'));
};
</script>

@include('admin.Users.users_actions')
@endsection