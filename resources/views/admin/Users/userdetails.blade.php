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
                <x-heroicon name="arrow-left" class="h-4 w-4 mr-2" />
                Geri
            </a>
            
            <!-- Actions Dropdown -->
            <div class="relative" id="actionsDropdown">
                <button onclick="toggleActionsDropdown()"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    İşlemler
                    <x-heroicon name="chevron-down" class="ml-2 h-4 w-4" />
                </button>
                
                <div id="actionsDropdownContent" style="display: none;"
                     class="absolute right-0 mt-2 w-64 bg-white dark:bg-admin-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-admin-600 opacity-0 transform scale-95 transition-all duration-100">
                    <div class="py-1">
                        <a href="{{ route('loginactivity', $user->id) }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="clock" class="w-4 h-4 mr-3" />
                            Giriş Aktivitesi
                        </a>
                        
                        @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                            <a href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                <x-heroicon name="lock-open" class="w-4 h-4 mr-3" />
                                Yasağı Kaldır / Etkinleştir
                            </a>
                        @else
                            <a href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-heroicon name="ban" class="w-4 h-4 mr-3" />
                                Yasakla / Devre Dışı Bırak
                            </a>
                        @endif
                        
                        @if (!$user->email_verified_at)
                            <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-blue-700 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <x-heroicon name="mail-check" class="w-4 h-4 mr-3" />
                                E-postayı Doğrula
                            </a>
                        @endif
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openTopupModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="credit-card" class="w-4 h-4 mr-3" />
                            Kredi/Debit
                        </button>
                        
                        <button onclick="openEditModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="user-pen" class="w-4 h-4 mr-3" />
                            Kullanıcı Düzenle
                        </button>
                        
                        <button onclick="openTradingModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="arrow-trending-up" class="w-4 h-4 mr-3" />
                            Manuel İşlem Yap
                        </button>
                        
                        <button onclick="openSignalModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="radio" class="w-4 h-4 mr-3" />
                            Sinyal Oluştur
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openEmailModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="envelope" class="w-4 h-4 mr-3" />
                            E-posta Gönder
                        </button>
                        
                        <button onclick="openNotifyModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="bell" class="w-4 h-4 mr-3" />
                            Bildirim Gönder
                        </button>
                        
                        <button onclick="openTaxModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="calculator" class="w-4 h-4 mr-3" />
                            Kullanıcı Vergisi
                        </button>
                        
                        <button onclick="openWithdrawalCodeModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="key" class="w-4 h-4 mr-3" />
                            Para Çekme Kodu
                        </button>
                        
                        <button onclick="openTradesModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="hash" class="w-4 h-4 mr-3" />
                            İşlem Sayısı Belirle
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openSwitchUserModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="user-switch" class="w-4 h-4 mr-3" />
                            Kullanıcı Hesabına Geç
                        </button>
                        
                        <button onclick="openResetPasswordModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-orange-700 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20">
                            <x-heroicon name="key-round" class="w-4 h-4 mr-3" />
                            Şifreyi Sıfırla
                        </button>
                        
                        <a href="{{ url('admin/dashboard/clearacct') }}/{{ $user->id }}"
                           onclick="return confirm('{{ $user->name }} kullanıcısının hesabını temizlemek istediğinizden emin misiniz?')"
                           class="flex items-center px-4 py-2 text-sm text-yellow-700 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                            <x-heroicon name="eraser" class="w-4 h-4 mr-3" />
                            Hesabı Temizle
                        </a>
                        
                        <button onclick="openDeleteModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <x-heroicon name="user-minus" class="w-4 h-4 mr-3" />
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
                        <x-heroicon name="wallet" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
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
                        <x-heroicon name="arrow-trending-up" class="h-6 w-6 text-green-600 dark:text-green-400" />
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
                        <x-heroicon name="gift" class="h-6 w-6 text-purple-600 dark:text-purple-400" />
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
                <x-heroicon name="activity" class="h-5 w-5 mr-2" />
                Müşteri İşlemleri
            </h2>
        </div>
        <div class="p-6">
            @if ($user->trade != null)
                <a href="{{ route('user.plans', $user->id) }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <x-heroicon name="eye" class="w-5 h-5 mr-2" />
                    İşlemleri Görüntüle
                </a>
            @else
                <div class="text-center py-12">
                    <x-heroicon name="clipboard-x" class="mx-auto h-12 w-12 text-gray-400 mb-4" />
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
                        <x-heroicon name="shield-check" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="shield-x" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">KYC Durumu</h3>
            @if ($user->account_verify == 'Verified')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="check" class="w-3 h-3 mr-1" />
                    Doğrulanmış
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="x-mark" class="w-3 h-3 mr-1" />
                    Doğrulanmamış
                </span>
            @endif
        </div>
        
        <!-- Trade Mode -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if ($user->tradetype == 'Loss' || $user->tradetype == null)
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="arrow-trending-down" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="arrow-trending-up" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">İşlem Modu</h3>
            @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="arrow-trending-down" class="w-3 h-3 mr-1" />
                    Loss
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="arrow-trending-up" class="w-3 h-3 mr-1" />
                    Profit
                </span>
            @endif
        </div>
        
        <!-- Account Status -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-minus" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @elseif ($user->status == 'active')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-check" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-question" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">Hesap Durumu</h3>
            @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="x-circle" class="w-3 h-3 mr-1" />
                    {{ ucfirst($user->status) }}
                </span>
            @elseif ($user->status == 'active')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                    Aktif
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                    <x-heroicon name="question-mark-circle" class="w-3 h-3 mr-1" />
                    Beklemede
                </span>
            @endif
        </div>
    </div>
    
    <!-- User Information Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="user" class="h-5 w-5 mr-2" />
                Kullanıcı Bilgileri
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="user" class="w-6 h-6 text-white" />
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
                                <x-heroicon name="envelope" class="w-6 h-6 text-white" />
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
                                <x-heroicon name="phone" class="w-6 h-6 text-white" />
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
                                <x-heroicon name="calendar-days" class="w-6 h-6 text-white" />
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
                                <x-heroicon name="flag" class="w-6 h-6 text-white" />
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
                                <x-heroicon name="clock" class="w-6 h-6 text-white" />
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
// Vanilla JavaScript Modal Sistemi
let currentOpenModal = null;
let actionsDropdownOpen = false;

// Modal açma fonksiyonu
function openModal(modalId) {
    console.log('🔍 MODAL DEBUG - Opening attempt:', modalId); // Enhanced debug log
    
    // DOM element kontrolü
    const modal = document.getElementById(modalId);
    console.log('🔍 MODAL DEBUG - Element search result:', {
        modalId: modalId,
        elementFound: modal ? 'YES' : 'NO',
        elementType: modal ? modal.tagName : 'N/A',
        elementClasses: modal ? modal.className : 'N/A'
    });
    
    closeAllModals(); // Önce tüm modalleri kapat
    
    if (modal) {
        console.log('🔍 MODAL DEBUG - Before opening:', {
            modalId: modalId,
            currentDisplay: modal.style.display,
            visibility: modal.style.visibility,
            zIndex: modal.style.zIndex
        });
        
        // Modal'ı görünür yap
        modal.style.display = 'block';
        modal.style.visibility = 'visible';
        modal.style.zIndex = '9999';
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        
        // Body scroll'unu engelle
        document.body.style.overflow = 'hidden';
        currentOpenModal = modalId;
        
        // Modal içeriğine fade-in animasyonu
        const modalContent = modal.querySelector('.inline-block');
        if (modalContent) {
            modalContent.classList.add('animate-fadeIn');
            modalContent.style.transform = 'scale(1)';
        }
        
        // Forced reflow to ensure styles apply
        modal.offsetHeight;
        
        console.log('🔍 MODAL DEBUG - After opening:', {
            modalId: modalId,
            currentDisplay: modal.style.display,
            visibility: modal.style.visibility,
            zIndex: modal.style.zIndex,
            opacity: modal.classList.contains('opacity-100')
        });
    } else {
        console.error('🚨 MODAL DEBUG - Element NOT FOUND:', modalId);
        console.log('🔍 MODAL DEBUG - Available modals check:');
        
        // Tüm modal'ları kontrol et
        const allModals = [
            'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
            'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
            'tradesModal', 'signalModal', 'switchUserModal'
        ];
        
        allModals.forEach(id => {
            const element = document.getElementById(id);
            console.log(`🔍 ${id}:`, element ? 'EXISTS' : 'MISSING');
        });
    }
}

// Modal kapatma fonksiyonu
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        const modalContent = modal.querySelector('.inline-block');
        if (modalContent) {
            modalContent.style.transform = 'scale(0.95)';
        }
        
        setTimeout(() => {
            modal.style.display = 'none';
            modal.style.visibility = 'hidden';
            document.body.style.overflow = 'auto'; // Scroll'u geri aç
            currentOpenModal = null;
        }, 300);
    }
}

// Tüm modalleri kapatma
function closeAllModals() {
    const modals = [
        'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
        'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
        'tradesModal', 'signalModal', 'switchUserModal'
    ];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal && modal.style.display !== 'none') {
            closeModal(modalId);
        }
    });
}

// Actions dropdown toggle
function toggleActionsDropdown() {
    const dropdown = document.getElementById('actionsDropdownContent');
    if (!dropdown) return;
    
    actionsDropdownOpen = !actionsDropdownOpen;
    
    if (actionsDropdownOpen) {
        dropdown.style.display = 'block';
        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
        }, 10);
    } else {
        dropdown.classList.remove('opacity-100', 'scale-100');
        dropdown.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            dropdown.style.display = 'none';
        }, 100);
    }
}

// Dropdown'u kapat
function closeActionsDropdown() {
    if (actionsDropdownOpen) {
        const dropdown = document.getElementById('actionsDropdownContent');
        if (dropdown) {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                dropdown.style.display = 'none';
                actionsDropdownOpen = false;
            }, 100);
        }
    }
}

// Modal açma fonksiyonları
window.openTopupModal = function() { openModal('topupModal'); };
window.openEditModal = function() { openModal('editModal'); };
window.openTradingModal = function() { openModal('tradingModal'); };
window.openSignalModal = function() { openModal('signalModal'); };
window.openEmailModal = function() { openModal('emailModal'); };
window.openNotifyModal = function() { openModal('notifyModal'); };
window.openTaxModal = function() { openModal('taxModal'); };
window.openWithdrawalCodeModal = function() {
    console.log('openWithdrawalCodeModal called'); // Debug log
    openModal('withdrawalCodeModal');
};
window.openTradesModal = function() { openModal('tradesModal'); };
window.openSwitchUserModal = function() { openModal('switchUserModal'); };
window.openResetPasswordModal = function() {
    console.log('openResetPasswordModal called'); // Debug log
    openModal('resetPasswordModal');
};
window.openDeleteModal = function() { openModal('deleteModal'); };

// Event listener'lar
document.addEventListener('DOMContentLoaded', function() {
    // ESC tuşu ile modal kapatma
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && currentOpenModal) {
            closeModal(currentOpenModal);
        }
    });
    
    // Dış tıklama ile dropdown kapatma
    document.addEventListener('click', function(e) {
        const actionsDropdown = document.getElementById('actionsDropdown');
        if (actionsDropdownOpen && actionsDropdown && !actionsDropdown.contains(e.target)) {
            closeActionsDropdown();
        }
    });
});

// Debug fonksiyonu
window.debugModals = function() {
    console.log('Modal System Debug:');
    console.log('Current open modal:', currentOpenModal);
    console.log('Actions dropdown open:', actionsDropdownOpen);
    
    const modals = [
        'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
        'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
        'tradesModal', 'signalModal', 'switchUserModal'
    ];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        console.log(`${modalId}:`, modal ? 'exists' : 'missing', modal?.style.display || 'none');
    });
};

// Problem olan modallar için özel debug fonksiyonu
window.debugProblemModals = function() {
    console.log('=== Problem Modal Debug ===');
    
    console.log('Button elements check:');
    const withdrawalBtn = document.querySelector('[onclick*="openWithdrawalCodeModal"]');
    const resetBtn = document.querySelector('[onclick*="openResetPasswordModal"]');
    console.log('Withdrawal button found:', withdrawalBtn ? 'YES' : 'NO');
    console.log('Reset password button found:', resetBtn ? 'YES' : 'NO');
    
    console.log('Modal elements check:');
    const withdrawalModal = document.getElementById('withdrawalCodeModal');
    const resetModal = document.getElementById('resetPasswordModal');
    console.log('withdrawalCodeModal element:', withdrawalModal ? 'EXISTS' : 'MISSING');
    console.log('resetPasswordModal element:', resetModal ? 'EXISTS' : 'MISSING');
    
    if (withdrawalModal) {
        console.log('withdrawalCodeModal display:', withdrawalModal.style.display);
        console.log('withdrawalCodeModal classes:', withdrawalModal.className);
    }
    
    if (resetModal) {
        console.log('resetPasswordModal display:', resetModal.style.display);
        console.log('resetPasswordModal classes:', resetModal.className);
    }
    
    console.log('Functions check:');
    console.log('openWithdrawalCodeModal exists:', typeof window.openWithdrawalCodeModal);
    console.log('openResetPasswordModal exists:', typeof window.openResetPasswordModal);
    console.log('openModal exists:', typeof window.openModal);
};
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>

@include('admin.Users.users_actions')
@endsection