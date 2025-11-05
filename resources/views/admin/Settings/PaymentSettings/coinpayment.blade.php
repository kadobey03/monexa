<div class="space-y-8">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Coinpayment Ayarları</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Coinpayment API entegrasyonunu yapılandırın</p>
    </div>

    <!-- Main Form -->
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl shadow-xl border border-yellow-200 dark:border-yellow-800 overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/20 rounded-lg mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Coinpayment API Yapılandırması</h3>
                    <p class="text-yellow-100 mt-1">Kripto para ödemelerini otomatikleştirmek için gerekli bilgileri girin</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-8">
            <form action="javascript:void(0)" method="POST" id="coinpayform" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- API Keys Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">API Anahtarları</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Public Key
                                </span>
                            </label>
                            <input type="text" name="cp_p_key" value="{{ $cpd->cp_p_key }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="Coinpayment Public Key'inizi girin">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Coinpayment hesabınızdan alacağınız public key</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Private Key
                                </span>
                            </label>
                            <input type="password" name="cp_pv_key" value="{{ $cpd->cp_pv_key }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="Coinpayment Private Key'inizi girin">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Güvenlik nedeniyle gizlenmiş. Coinpayment hesabınızdan alacağınız private key</p>
                        </div>
                    </div>
                </div>

                <!-- Merchant Settings -->
                <div class="border-t border-gray-200 dark:border-admin-600 pt-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Merchant Bilgileri</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Merchant ID
                                </span>
                            </label>
                            <input type="text" name="cp_m_id" value="{{ $cpd->cp_m_id }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                                   placeholder="Merchant ID'nizi girin">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Coinpayment hesabınızda bulunan benzersiz merchant kimliği</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    Debug E-posta
                                </span>
                            </label>
                            <input type="email" name="cp_debug_email" value="{{ $cpd->cp_debug_email }}" required 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400" 
                                   placeholder="debug@example.com">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Coinpayment hata bildirimleri bu adrese gönderilir</p>
                        </div>
                    </div>
                </div>

                <!-- IPN Settings -->
                <div class="border-t border-gray-200 dark:border-admin-600 pt-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">IPN Güvenlik Ayarları</h4>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                IPN Secret Key
                            </span>
                        </label>
                        <input type="password" name="cp_ipn_secret" value="{{ $cpd->cp_ipn_secret }}" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 placeholder-gray-400 font-mono text-sm" 
                               placeholder="IPN Secret Key'inizi girin">
                        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 mt-3">
                            <div class="flex">
                                <svg class="w-5 h-5 text-purple-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-purple-700 dark:text-purple-300">
                                        <strong>IPN Secret Key Nedir?</strong><br>
                                        Instant Payment Notification (IPN) gizli anahtarı, ödeme bildirimlerinin güvenliğini sağlar. 
                                        Bu anahtar, Coinpayment'tan gelen bildirimlerin gerçek olduğunu doğrular ve güvenliğinizi artırır.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6">
                    <div class="flex">
                        <svg class="w-6 h-6 text-amber-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-2">Önemli Bilgiler</h4>
                            <ul class="text-xs text-amber-700 dark:text-amber-300 space-y-1">
                                <li>• Bu bilgileri Coinpayment hesabınızın API ayarlar bölümünden alabilirsiniz</li>
                                <li>• API anahtarlarınızı asla üçüncü şahıslarla paylaşmayın</li>
                                <li>• Testnet ve mainnet için farklı API anahtarları kullanmanız gerekebilir</li>
                                <li>• IPN URL'inizi Coinpayment hesabınızda doğru şekilde yapılandırın</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-admin-600">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="coinpayButtonText">Ayarları Kaydet</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Form submission with loading state
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('coinpayform');
        const saveButton = form.querySelector('button[type="submit"]');
        const saveButtonText = document.getElementById('coinpayButtonText');
        
        if (form && saveButton) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                saveButton.disabled = true;
                saveButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                `;
                
                // The form handler is already defined in the parent component
                // This will be handled by the existing event listener
                const coinpayform = document.getElementById('coinpayform');
                if (coinpayform) {
                    const event = new Event('submit');
                    coinpayform.dispatchEvent(event);
                }
            });
        }
        
        // Add show/hide toggle for password fields
        const passwordFields = document.querySelectorAll('input[type="password"]');
        passwordFields.forEach(field => {
            const container = field.parentNode;
            const toggleButton = document.createElement('button');
            toggleButton.type = 'button';
            toggleButton.className = 'absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors';
            toggleButton.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            `;
            
            // Make the container relative
            container.style.position = 'relative';
            field.style.paddingRight = '3rem';
            
            toggleButton.addEventListener('click', function() {
                if (field.type === 'password') {
                    field.type = 'text';
                    toggleButton.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    `;
                } else {
                    field.type = 'password';
                    toggleButton.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    `;
                }
            });
            
            container.appendChild(toggleButton);
        });
    });
</script>