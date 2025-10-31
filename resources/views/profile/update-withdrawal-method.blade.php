<div class="max-w-4xl mx-auto">
    <form id="updatewithdrawalinfo" method="post" action="javascript:void(0)" x-data="withdrawalForm()" x-init="init()">
        @csrf
        @method('PUT')

        <!-- Bank Transfer Section -->
        @if ($methods[3]->status == 'enabled')
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                        🏦
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Banka Transfer Bilgileri</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🏛️ Banka Adı
                        </label>
                        <input
                            type="text"
                            name="bank_name"
                            value="{{ Auth::user()->bank_name }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                            placeholder="Banka adını girin"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            👤 Hesap Sahibi
                        </label>
                        <input
                            type="text"
                            name="account_name"
                            value="{{ Auth::user()->account_name }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                            placeholder="Hesap sahibinin adı"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🔢 Hesap Numarası
                        </label>
                        <input
                            type="text"
                            name="account_no"
                            value="{{ Auth::user()->account_number }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                            placeholder="Hesap numarası"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🔗 Swift Kodu
                        </label>
                        <input
                            type="text"
                            name="swiftcode"
                            value="{{ Auth::user()->swift_code }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                            placeholder="SWIFT kodu"
                        >
                    </div>
                </div>
            </div>
        @endif

        <!-- Cryptocurrency Section -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-3">
                    ₿
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kripto Para Cüzdan Adresleri</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($methods[0]->status == 'enabled')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ₿ Bitcoin (BTC)
                        </label>
                        <input
                            type="text"
                            name="btc_address"
                            value="{{ Auth::user()->btc_address }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors font-mono text-sm"
                            placeholder="Bitcoin cüzdan adresi"
                        >
                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            💡 Bitcoin adresinizi girin, bu adres para çekme işlemlerinde kullanılacak
                        </p>
                    </div>
                @endif
                
                @if ($methods[1]->status == 'enabled')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ♦ Ethereum (ETH)
                        </label>
                        <input
                            type="text"
                            name="eth_address"
                            value="{{ Auth::user()->eth_address }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors font-mono text-sm"
                            placeholder="Ethereum cüzdan adresi"
                        >
                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            💡 Ethereum adresinizi girin, bu adres para çekme işlemlerinde kullanılacak
                        </p>
                    </div>
                @endif
                
                @if ($methods[2]->status == 'enabled')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ł Litecoin (LTC)
                        </label>
                        <input
                            type="text"
                            name="ltc_address"
                            value="{{ Auth::user()->ltc_address }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors font-mono text-sm"
                            placeholder="Litecoin cüzdan adresi"
                        >
                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            💡 Litecoin adresinizi girin, bu adres para çekme işlemlerinde kullanılacak
                        </p>
                    </div>
                @endif
                
                @if ($methods[4]->status == 'enabled')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            💵 USDT (TRC20)
                        </label>
                        <input
                            type="text"
                            name="usdt_address"
                            value="{{ Auth::user()->usdt_address }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors font-mono text-sm"
                            placeholder="USDT.TRC20 cüzdan adresi"
                        >
                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                            💡 USDT.TRC20 cüzdan adresinizi girin, bu adres para çekme işlemlerinde kullanılacak
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">🔒 Güvenlik Bildirimi</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                        Cüzdan adreslerinizi doğru girdiğinizden emin olun. Yanlış adreslere gönderilen fonlar geri alınamaz.
                    </p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button
                type="submit"
                x-ref="submitButton"
                class="px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2"
                :disabled="loading"
            >
                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="loading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-text="loading ? 'Kaydediliyor...' : 'Kaydet'"></span>
            </button>
        </div>
    </form>
</div>

<!-- Modern Alpine.js Logic -->
<script>
function withdrawalForm() {
    return {
        loading: false,
        
        init() {
            document.getElementById('updatewithdrawalinfo').addEventListener('submit', this.handleSubmit.bind(this));
        },
        
        async handleSubmit(e) {
            e.preventDefault();
            this.loading = true;
            
            try {
                const formData = new FormData(document.getElementById('updatewithdrawalinfo'));
                
                const response = await fetch('{{ route('updateacount') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                });
                
                const data = await response.json();
                
                if (data.status === 200) {
                    this.showNotification('success', data.success);
                } else {
                    this.showNotification('error', data.message || 'Bir hata oluştu');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('error', 'Sunucuya bağlanırken bir hata oluştu');
            } finally {
                this.loading = false;
            }
        },
        
        showNotification(type, message) {
            // Remove existing notifications
            const existing = document.querySelectorAll('.notification-toast');
            existing.forEach(n => n.remove());
            
            // Create notification
            const notification = document.createElement('div');
            notification.className = `notification-toast fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
                type === 'success'
                    ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200'
                    : 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        ${type === 'success'
                            ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                            : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                        }
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-current hover:opacity-70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    }
}
</script>



</script>
