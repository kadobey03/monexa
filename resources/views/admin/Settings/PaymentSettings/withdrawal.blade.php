<div class="space-y-8">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ödeme Tercihleri</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Yatırım ve çekim işlemlerinin genel ayarlarını yapılandırın</p>
    </div>

    <form action="javascript:void(0)" method="POST" id="paypreform" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Deposit & Withdrawal Options -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">İşlem Türü Ayarları</h3>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Yatırım Seçeneği</label>
                    <select name="deposit_option" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="{{ $settings->deposit_option }}">{{ $settings->deposit_option }} (Mevcut)</option>
                        <option value="manual">Manuel</option>
                        <option value="auto">Otomatik</option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Yatırım işlemlerinin onay sürecini belirler</p>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Çekim Seçeneği</label>
                    <select name="withdrawal_option" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="{{ $settings->withdrawal_option }}">{{ $settings->withdrawal_option }} (Mevcut)</option>
                        <option value="manual">Manuel</option>
                        <option value="auto">Otomatik</option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Çekim işlemlerinin onay sürecini belirler</p>
                </div>
            </div>
        </div>

        <!-- Financial Limits -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Finansal Limitler</h3>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Minimum Yatırım Tutarı ({{ $settings->currency }})</label>
                <input type="text" name="minamt" value="{{ $moresettings->minamt }}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" placeholder="Minimum yatırım tutarı">
                <p class="text-xs text-gray-500 dark:text-gray-400">Kullanıcıların yapabileceği minimum yatırım miktarını belirler</p>
            </div>
        </div>

        <!-- Payment Providers -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ödeme Sağlayıcıları</h3>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">USDT Otomatik Ödeme Sağlayıcısı</label>
                    <select name="merchat" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        <option value="{{ $settings->auto_merchant_option }}">{{ $settings->auto_merchant_option }} (Mevcut)</option>
                        <option value="Coinpayment">Coinpayment</option>
                        <option value="Binance">Binance</option>
                    </select>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mt-2">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-yellow-700 dark:text-yellow-300">
                                    <strong>Önemli:</strong> Seçtiğiniz USDT sağlayıcısı için API anahtarlarınızı doğru girdiğinizden emin olun. 
                                    Gateway/Coinpayment sekmesinden kontrol edin. <br>
                                    <span class="font-semibold">NOT: Binance kullanmak için web sitesi para biriminizin USD olması gerekir.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Kredi Kartı Ödeme Sağlayıcısı</label>
                    <select name="credit_card_provider" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                        <option value="{{ $settings->credit_card_provider }}">{{ $settings->credit_card_provider }} (Mevcut)</option>
                        <option value="Paystack">Paystack</option>
                        <option value="Flutterwave">Flutterwave</option>
                        <option value="Stripe">Stripe</option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Kullanıcılar kredi/banka kartı ile yatırım yapmak istediklerinde kullanılacak sağlayıcı. 
                        Seçtiğiniz seçenek için doğru API anahtarlarını girdiğinizden emin olun.
                    </p>
                </div>
            </div>
        </div>

        <!-- Withdrawal Settings -->
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-orange-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Çekim İşlemleri</h3>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Çekim Kesintisi Zamanı</label>
                <select name="deduction_option" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    <option value="{{ $settings->deduction_option }}">
                        {{ $settings->deduction_option == 'userRequest' ? 'Kullanıcı talebinde kes' : 'Admin onayında kes' }} (Mevcut)
                    </option>
                    <option value="userRequest">Kullanıcı talebinde kes</option>
                    <option value="AdminApprove">Admin onayında kes</option>
                </select>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mt-2">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            Kullanıcı hesabından paranın ne zaman kesileceğini belirler. Kullanıcı çekim talebinde bulunduğu anda mı, 
                            yoksa admin onayladığı zaman mı kesileceğini seçin.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span id="saveButtonText">Ayarları Kaydet</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Form submission with loading state
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paypreform');
        const saveButton = form.querySelector('button[type="submit"]');
        const saveButtonText = document.getElementById('saveButtonText');
        
        if (form && saveButton) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                saveButton.disabled = true;
                saveButtonText.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                `;
                
                // The form handler is already defined in the parent component
                // This will be handled by the existing event listener
                const paypreform = document.getElementById('paypreform');
                if (paypreform) {
                    const event = new Event('submit');
                    paypreform.dispatchEvent(event);
                }
            });
        }
    });
</script>