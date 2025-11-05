@extends('layouts.admin', ['title' => 'Tavsiye/Bonus Ayarları'])

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-admin-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tavsiye/Bonus Ayarları</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Referral komisyonları ve kullanıcı bonuslarını yapılandırın</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-blue-700 dark:text-blue-300 font-medium">Finans Sistemi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Referral Commission Settings -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-600 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-white/20 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Referral Komisyon Ayarları</h3>
                            <p class="text-green-100 mt-1">6 seviyeli komisyon sistemi yapılandırması</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8">
                    <form method="POST" id="referralForm" class="space-y-6">
                        <input type="hidden" name="id" value="1">
                        @csrf
                        
                        <!-- Commission Levels -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Komisyon Seviyeleri</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Level 1 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">1</div>
                                            1. Seviye Komisyon (Direkt Referral)
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission" value="{{ $settings->referral_commission }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Doğrudan davet edilen kullanıcılardan</p>
                                </div>

                                <!-- Level 2 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-blue-400 to-blue-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">2</div>
                                            2. Seviye Komisyon
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission1" value="{{ $settings->referral_commission1 }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">2. seviye alt referrallardan</p>
                                </div>

                                <!-- Level 3 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-purple-400 to-purple-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">3</div>
                                            3. Seviye Komisyon
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission2" value="{{ $settings->referral_commission2 }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">3. seviye alt referrallardan</p>
                                </div>

                                <!-- Level 4 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-orange-400 to-orange-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">4</div>
                                            4. Seviye Komisyon
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission3" value="{{ $settings->referral_commission3 }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">4. seviye alt referrallardan</p>
                                </div>

                                <!-- Level 5 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-red-400 to-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">5</div>
                                            5. Seviye Komisyon
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission4" value="{{ $settings->referral_commission4 }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">5. seviye alt referrallardan</p>
                                </div>

                                <!-- Level 6 -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <div class="w-6 h-6 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white text-xs font-bold rounded-full flex items-center justify-center mr-2">6</div>
                                            6. Seviye Komisyon
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="ref_commission5" value="{{ $settings->referral_commission5 }}" 
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">6. seviye alt referrallardan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Information Box -->
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-green-800 dark:text-green-200 mb-1">Referral Komisyon Sistemi</h4>
                                    <p class="text-xs text-green-700 dark:text-green-300">
                                        Her kullanıcı kendi referral ağından gelen yatırımlardan belirtilen yüzde oranında komisyon alır. 
                                        Komisyonlar otomatik olarak hesaplanır ve kullanıcı bakiyesine eklenir.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-center pt-4">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="referralButtonText">Komisyon Ayarlarını Kaydet</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bonus Settings -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-600 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-white/20 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Kullanıcı Bonus Ayarları</h3>
                            <p class="text-blue-100 mt-1">Kayıt ve yatırım bonusları yapılandırması</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8">
                    <form method="POST" id="bonusForm" class="space-y-8">
                        <input type="hidden" name="id" value="1">
                        @csrf
                        
                        <!-- Bonus Types -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Bonus Türleri</h4>
                            </div>

                            <!-- Registration Bonus -->
                            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800 p-6">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-emerald-500 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Kayıt Bonusu</h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Yeni kayıt olan kullanıcılara verilen hoş geldin bonusu</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            Bonus Miktarı ({{ $settings->currency }})
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="signup_bonus" value="{{ $settings->signup_bonus }}" 
                                                   step="0.01" min="0"
                                                   class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                                   placeholder="0.00">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $settings->currency }}</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            0 girerseniz kayıt bonusu verilmez. Bu miktar yeni kayıt olan her kullanıcının hesabına otomatik eklenir.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deposit Bonus -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-blue-500 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Yatırım Bonusu</h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Her yatırım için verilen yüzde bonus</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            Bonus Yüzdesi (%)
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="deposit_bonus" value="{{ $settings->deposit_bonus }}" 
                                                   step="0.01" min="0" max="100"
                                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" 
                                                   placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Sistem kullanıcı yatırım miktarının belirttiğiniz yüzdesi kadar bonusu hesaplayarak bakiyesine ekler (her yatırım için).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bonus Calculation Example -->
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-amber-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-1">Bonus Hesaplama Örneği</h4>
                                    <p class="text-xs text-amber-700 dark:text-amber-300">
                                        Yatırım bonusu %10 ise, kullanıcı $1000 yatırım yaptığında $100 bonus alacaktır.
                                        Kayıt bonusu $50 ise, her yeni kullanıcı kayıt olduktan sonra hesabında $50 bulacaktır.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-center pt-4">
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="bonusButtonText">Bonus Ayarlarını Kaydet</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="mt-8 bg-gray-100 dark:bg-admin-800/50 rounded-xl p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-2 bg-gray-200 dark:bg-gray-700 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sistem Bilgileri</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center justify-between p-3 bg-white dark:bg-admin-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Para Birimi</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $settings->currency }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white dark:bg-admin-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Referral Sistemi</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                        6 Seviye Aktif
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white dark:bg-admin-700 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">Bonus Sistemi</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                        Otomatik Hesaplama
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referral Form submission handler
        const referralForm = document.getElementById('referralForm');
        if (referralForm) {
            referralForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button[type="submit"]');
                const buttonText = document.getElementById('referralButtonText');
                const originalText = buttonText.innerHTML;
                
                button.disabled = true;
                buttonText.innerHTML = 'Kaydediliyor...';
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Kaydediliyor...</span>
                `;
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('updaterefbonus') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 200) {
                        // Success notification
                        showNotification(result.success || 'Referral komisyon ayarları başarıyla güncellendi!', 'success');
                    } else {
                        throw new Error(result.message || 'İşlem başarısız oldu');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Bir hata oluştu: ' + error.message, 'error');
                } finally {
                    button.disabled = false;
                    buttonText.innerHTML = originalText;
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>${originalText}</span>
                    `;
                }
            });
        }

        // Bonus Form submission handler
        const bonusForm = document.getElementById('bonusForm');
        if (bonusForm) {
            bonusForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button[type="submit"]');
                const buttonText = document.getElementById('bonusButtonText');
                const originalText = buttonText.innerHTML;
                
                button.disabled = true;
                buttonText.innerHTML = 'Kaydediliyor...';
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Kaydediliyor...</span>
                `;
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('otherbonus') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 200) {
                        // Success notification
                        showNotification(result.success || 'Bonus ayarları başarıyla güncellendi!', 'success');
                    } else {
                        throw new Error(result.message || 'İşlem başarısız oldu');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Bir hata oluştu: ' + error.message, 'error');
                } finally {
                    button.disabled = false;
                    buttonText.innerHTML = originalText;
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>${originalText}</span>
                    `;
                }
            });
        }

        // Input validation
        const numberInputs = document.querySelectorAll('input[type="number"]');
        numberInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
                if (this.hasAttribute('max') && parseFloat(this.value) > parseFloat(this.getAttribute('max'))) {
                    this.value = this.getAttribute('max');
                }
            });

            // Add visual feedback on focus
            input.addEventListener('focus', function() {
                this.closest('.space-y-2')?.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-20', 'rounded-lg');
            });

            input.addEventListener('blur', function() {
                this.closest('.space-y-2')?.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-20', 'rounded-lg');
            });
        });

        // Notification function
        function showNotification(message, type = 'success') {
            // If toastr is available, use it
            if (typeof toastr !== 'undefined') {
                if (type === 'success') {
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            } else {
                // Fallback to alert
                alert(message);
            }
        }

        // Real-time bonus calculation preview
        const depositBonusInput = document.querySelector('input[name="deposit_bonus"]');
        if (depositBonusInput) {
            let timeoutId;
            depositBonusInput.addEventListener('input', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    updateBonusExample(parseFloat(this.value) || 0);
                }, 500);
            });
        }

        function updateBonusExample(bonusPercentage) {
            const exampleBox = document.querySelector('.bg-amber-50');
            if (exampleBox && bonusPercentage > 0) {
                const exampleText = exampleBox.querySelector('p');
                const exampleAmount = (1000 * bonusPercentage / 100).toFixed(2);
                const currency = '{{ $settings->currency }}';
                
                exampleText.innerHTML = `
                    Yatırım bonusu %${bonusPercentage} ise, kullanıcı ${currency}1000 yatırım yaptığında ${currency}${exampleAmount} bonus alacaktır.
                    Kayıt bonusu miktarı ne olarak ayarlandıysa, her yeni kullanıcı kayıt olduktan sonra hesabında o miktarı bulacaktır.
                `;
            }
        }
    });
</script>
@endsection