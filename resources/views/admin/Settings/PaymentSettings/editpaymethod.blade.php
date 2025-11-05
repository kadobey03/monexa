@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-admin-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ödeme Yöntemi Güncelle</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $method->name }} ödeme yöntemi ayarlarını düzenleyin</p>
                </div>
                <a href="{{ route('paymentview') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </a>
            </div>
        </div>

        <!-- Alerts -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-600 overflow-hidden">
            <!-- Special USDT Warning -->
            @if ($method->name == 'USDT')
                <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-400 p-6">
                    <div class="flex">
                        <svg class="w-6 h-6 text-amber-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-2">USDT Ödeme Yöntemi Hakkında Önemli Bilgi</h3>
                            <p class="text-sm text-amber-700 dark:text-amber-300">
                                Kullanıcılarınızın USDT ile para çekebilmeleri için, Binance merchant kullanıyor ve otomatik para çekme ayarlıyorsanız, 
                                IP adreslerini whitelist'e almanız gerekir. Bunun için "Kullanıcı Yönetimi"nden giriş aktivitelerini kontrol edin, 
                                IP adreslerini toplayın ve Binance merchant dashboard'ınızda whitelist'e ekleyin.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <div class="p-8">
                <form method="POST" action="{{ route('updatemethod') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $method->id }}">

                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Temel Bilgiler</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Payment Method Name -->
                            <div class="lg:col-span-2 space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Ödeme Yöntemi Adı
                                    </span>
                                </label>
                                @if ($method->defaultpay == 'yes')
                                    <input type="text" name="name" value="{{ $method->name }}" readonly
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-gray-100 dark:bg-admin-600 dark:text-gray-300 rounded-xl cursor-not-allowed font-medium" 
                                           placeholder="Ödeme yöntemi adı">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bu varsayılan ödeme yöntemidir, adı değiştirilemez</p>
                                @else
                                    <input type="text" name="name" value="{{ $method->name }}" required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                           placeholder="Ödeme yöntemi adı">
                                @endif
                                
                                @if ($method->name == 'Credit Card')
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mt-3">
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            <strong>Önemli:</strong> Ödeme tercihleri sekmesinden bir kredi kartı sağlayıcısı seçtiğinizden emin olun. 
                                            Bu yöntem zaten Paystack ve Stripe'ı kullandığından, bunları ayrı olarak eklemeyin.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Method Type -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Ödeme Türü
                                    </span>
                                </label>
                                <select name="methodtype" id="methodtype" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="{{ $method->methodtype }}">{{ $method->methodtype == 'currency' ? 'Para Birimi' : 'Kripto Para' }}</option>
                                    <option value="currency">Para Birimi</option>
                                    <option value="crypto">Kripto Para</option>
                                </select>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Geleneksel para birimi veya kripto para seçin</p>
                            </div>

                            <!-- Image URL -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Logo URL'si
                                    </span>
                                </label>
                                <input type="url" name="url" value="{{ $method->img_url }}" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                       placeholder="https://example.com/logo.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ödeme yöntemi logosu için URL (isteğe bağlı)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Amount & Charges Section -->
                    <div class="border-t border-gray-200 dark:border-admin-600 pt-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Limitler ve Komisyonlar</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Minimum Amount -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                        Minimum Miktar
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="minimum" value="{{ $method->minimum }}" required min="0" step="0.01"
                                           class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                           placeholder="10.00">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $settings->currency }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sadece para çekme işlemleri için geçerlidir</p>
                            </div>

                            <!-- Maximum Amount -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        Maximum Miktar
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="maximum" value="{{ $method->maximum }}" required min="0" step="0.01"
                                           class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                           placeholder="1000.00">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $settings->currency }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sadece para çekme işlemleri için geçerlidir</p>
                            </div>

                            <!-- Charges -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Komisyon Miktarı
                                    </span>
                                </label>
                                <input type="number" name="charges" value="{{ $method->charges_amount }}" required min="0" step="0.01"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                       placeholder="5.00">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Sadece para çekme işlemleri için geçerlidir</p>
                            </div>

                            <!-- Charges Type -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        Komisyon Türü
                                    </span>
                                </label>
                                <select name="chargetype" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="{{ $method->charges_type }}">
                                        {{ $method->charges_type == 'percentage' ? 'Yüzde (%)' : 'Sabit ('.$settings->currency.')' }}
                                    </option>
                                    <option value="percentage">Yüzde (%)</option>
                                    <option value="fixed">Sabit ({{ $settings->currency }})</option>
                                </select>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Komisyon hesaplama türü</p>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Fields -->
                    <div class="border-t border-gray-200 dark:border-admin-600 pt-8 currency-fields">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Banka Bilgileri</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Banka Adı
                                    </span>
                                </label>
                                <input type="text" name="bank" value="{{ $method->bankname }}" class="currency-input"
                                       placeholder="Örnek: Ziraat Bankası"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        Hesap Sahibi
                                    </span>
                                </label>
                                <input type="text" name="account_name" value="{{ $method->account_name }}" class="currency-input"
                                       placeholder="Örnek: Ahmet Yılmaz"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v2a1 1 0 01-1 1h-1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8H3a1 1 0 01-1-1V5a1 1 0 011-1h4z"></path>
                                        </svg>
                                        Hesap Numarası
                                    </span>
                                </label>
                                <input type="text" name="account_number" value="{{ $method->account_number }}" class="currency-input"
                                       placeholder="Örnek: 1234567890123456"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 font-mono">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        SWIFT/Diğer Kod
                                    </span>
                                </label>
                                <input type="text" name="swift" value="{{ $method->swift_code }}" class="currency-input"
                                       placeholder="Örnek: TCZBTR2AXXX"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 font-mono">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Uluslararası transferler için gerekli</p>
                            </div>
                        </div>
                    </div>

                    <!-- Crypto Fields -->
                    <div class="border-t border-gray-200 dark:border-admin-600 pt-8 crypto-fields hidden">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kripto Para Bilgileri</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Cüzdan Adresi
                                    </span>
                                </label>
                                <input type="text" name="walletaddress" value="{{ $method->wallet_address }}" class="crypto-input"
                                       placeholder="Kripto cüzdan adresinizi girin"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        QR Kod (Barcode)
                                    </span>
                                </label>
                                <input type="file" name="barcode" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/50 dark:file:text-blue-300">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Cüzdan adresi için QR kod resmi (isteğe bağlı)</p>
                            </div>

                            <div class="lg:col-span-2 space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Ağ Türü (Network)
                                    </span>
                                </label>
                                <input type="text" name="wallettype" value="{{ $method->network }}" class="crypto-input"
                                       placeholder="Örnek: TRC20, ERC20, BSC"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                                
                                @if ($method->name == 'USDT' or $method->name == 'BUSD')
                                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mt-3">
                                        <p class="text-sm text-amber-700 dark:text-amber-300">
                                            <strong>Önemli Network Bilgisi:</strong><br>
                                            USDT ödemeleri için ağ türünün her zaman TRC20, BUSD ödemeleri için ERC20 olması gerekir 
                                            (otomatik ödeme ve coinpayment kullanıyorsanız). Manuel ödeme kullanıyorsanız istediğiniz ağı seçebilirsiniz.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="border-t border-gray-200 dark:border-admin-600 pt-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Genel Ayarlar</h3>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Durum
                                    </span>
                                </label>
                                <select name="status" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="{{ $method->status }}">{{ $method->status == 'enabled' ? 'Aktif' : 'Pasif' }}</option>
                                    <option value="enabled">Aktif</option>
                                    <option value="disabled">Pasif</option>
                                </select>
                            </div>

                            <!-- Type For -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                        Kullanım Alanı
                                    </span>
                                </label>
                                <select name="typefor" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="{{ $method->type }}">
                                        @if($method->type == 'withdrawal') Para Çekme
                                        @elseif($method->type == 'deposit') Para Yatırma  
                                        @else Her İkisi @endif
                                    </option>
                                    <option value="withdrawal">Para Çekme</option>
                                    <option value="deposit">Para Yatırma</option>
                                    <option value="both">Her İkisi</option>
                                </select>
                            </div>

                            <!-- Optional Note -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        İsteğe Bağlı Not
                                    </span>
                                </label>
                                <input type="text" name="note" value="{{ $method->duration }}" 
                                       placeholder="Örnek: İşlem 24 saate kadar sürebilir"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Kullanıcılara gösterilecek bilgi notu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="border-t border-gray-200 dark:border-admin-600 pt-8 flex justify-center">
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Değişiklikleri Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodTypeSelect = document.getElementById('methodtype');
        const currencyFields = document.querySelector('.currency-fields');
        const cryptoFields = document.querySelector('.crypto-fields');
        const currencyInputs = document.querySelectorAll('.currency-input');
        const cryptoInputs = document.querySelectorAll('.crypto-input');

        // Initialize field visibility and requirements based on current method type
        function initializeFields() {
            const currentType = methodTypeSelect.value;
            toggleFields(currentType);
        }

        // Toggle field visibility and requirements
        function toggleFields(type) {
            if (type === 'currency') {
                // Show currency fields, hide crypto fields
                currencyFields.classList.remove('hidden');
                cryptoFields.classList.add('hidden');
                
                // Set currency inputs as required
                currencyInputs.forEach((input, index) => {
                    if (index < 3) { // First 3 inputs are required for currency
                        input.setAttribute('required', '');
                        input.classList.remove('border-gray-300', 'dark:border-admin-600');
                        input.classList.add('border-gray-300', 'dark:border-admin-600');
                    }
                });

                // Remove crypto inputs requirements
                cryptoInputs.forEach(input => {
                    input.removeAttribute('required');
                });
                
            } else if (type === 'crypto') {
                // Hide currency fields, show crypto fields
                currencyFields.classList.add('hidden');
                cryptoFields.classList.remove('hidden');
                
                // Set crypto inputs as required (except file upload)
                cryptoInputs.forEach((input, index) => {
                    if (input.type !== 'file') { // Don't require file upload
                        input.setAttribute('required', '');
                    }
                });

                // Remove currency inputs requirements
                currencyInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        }

        // Event listener for method type change
        methodTypeSelect.addEventListener('change', function() {
            toggleFields(this.value);
        });

        // Initialize on page load
        initializeFields();

        // Form validation enhancement
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function(e) {
            // Add loading state to submit button
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Kaydediliyor...
            `;
        });

        // Input validation for numbers
        const numberInputs = document.querySelectorAll('input[type="number"]');
        numberInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });

        // Auto-format account number and similar fields
        const formatInputs = document.querySelectorAll('input[name="account_number"], input[name="walletaddress"]');
        formatInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Remove spaces for cleaner input
                this.value = this.value.replace(/\s/g, '');
            });
        });
    });
</script>
@endsection