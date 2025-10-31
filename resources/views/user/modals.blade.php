<!-- Modern Trading Subscription Modal -->
<div id="submitmt4modal"
     x-data="{ open: false }"
     x-show="open"
     @keydown.escape.window="open = false"
     @open-modal.window="open = true"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         @click="open = false"></div>
    
    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700">
                <div class="flex items-center justify-between">
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
                        🎯 Trading Hesabı Aboneliği
                    </h4>
                    <button
                        @click="open = false"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <form method="post" action="{{ route('savemt4details') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Duration & Amount Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📅 Abonelik Süresi
                            </label>
                            <select
                                onchange="calcAmount(this)"
                                name="duration"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                id="duratn"
                            >
                                <option value="default">Süre Seçin</option>
                                <option>Aylık</option>
                                <option>Çeyreklik</option>
                                <option>Yıllık</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                💰 Ödenecek Tutar
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                                type="text"
                                id="amount"
                                disabled
                            >
                        </div>
                    </div>
                    
                    <!-- Account Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🔐 Giriş Bilgisi*
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                type="text"
                                name="userid"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🔒 Hesap Şifresi*
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                type="password"
                                name="pswrd"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                👤 Hesap Adı*
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                type="text"
                                name="name"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📊 Hesap Tipi
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                placeholder="Örn. Standard"
                                type="text"
                                name="acntype"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                💵 Para Birimi*
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                placeholder="Örn. USD"
                                type="text"
                                name="currency"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ⚡ Kaldıraç*
                            </label>
                            <input
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                                placeholder="Örn. 1:500"
                                type="text"
                                name="leverage"
                                required
                            >
                        </div>
                    </div>
                    
                    <!-- Server Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🌐 Sunucu*
                        </label>
                        <input
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                            placeholder="Örn. HantecGlobal-live"
                            type="text"
                            name="server"
                            required
                        >
                    </div>
                    
                    <!-- Info Text -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            💡 Tutar hesabınızın bakiyesinden düşülecektir
                        </p>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <input id="amountpay" type="hidden" name="amount">
                        <button
                            type="button"
                            @click="open = false"
                            class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors font-medium"
                        >
                            İptal
                        </button>
                        <button
                            type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            🚀 Aboneliği Başlat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Enhanced Subscription Calculator -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Fee configuration from backend
    const feeConfig = {
        currency: '{{ auth()->user()->currency ?? "$" }}',
        monthly: '{{ $settings->monthlyfee ?? 0 }}',
        quarterly: '{{ $settings->quarterlyfee ?? 0 }}',
        yearly: '{{ $settings->yearlyfee ?? 0 }}'
    };

    // Enhanced calculator function
    window.calcAmount = function(selectElement) {
        const amountField = document.getElementById('amount');
        const amountPayField = document.getElementById('amountpay');
        
        if (!amountField || !amountPayField) return;
        
        let fee = 0;
        let duration = '';
        
        switch(selectElement.value) {
            case 'Çeyreklik':
                fee = feeConfig.quarterly;
                duration = 'Çeyreklik Plan';
                break;
            case 'Yıllık':
                fee = feeConfig.yearly;
                duration = 'Yıllık Plan';
                break;
            case 'Aylık':
                fee = feeConfig.monthly;
                duration = 'Aylık Plan';
                break;
            default:
                amountField.value = '';
                amountPayField.value = '';
                removeCalculationDisplay();
                return;
        }
        
        // Update display and hidden field
        amountField.value = `${feeConfig.currency}${fee}`;
        amountPayField.value = fee;
        
        // Show calculation feedback
        showCalculationFeedback(duration, fee);
    };

    function showCalculationFeedback(duration, fee) {
        // Remove existing display
        removeCalculationDisplay();
        
        // Create new calculation display
        const calcDisplay = document.createElement('div');
        calcDisplay.id = 'calc-display';
        calcDisplay.className = 'mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-lg transition-all duration-300';
        
        calcDisplay.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-green-800 dark:text-green-200 font-medium">
                        ✅ ${duration} seçildi
                    </p>
                    <p class="text-green-700 dark:text-green-300 text-sm">
                        💰 Tutar: ${feeConfig.currency}${fee}
                    </p>
                </div>
            </div>
        `;
        
        // Insert after amount field
        const amountField = document.getElementById('amount');
        amountField.parentNode.parentNode.appendChild(calcDisplay);
        
        // Add entrance animation
        requestAnimationFrame(() => {
            calcDisplay.classList.add('animate-pulse');
            setTimeout(() => calcDisplay.classList.remove('animate-pulse'), 600);
        });
    }

    function removeCalculationDisplay() {
        const existing = document.getElementById('calc-display');
        if (existing) {
            existing.remove();
        }
    }

    // Form validation enhancement
    const form = document.querySelector('#submitmt4modal form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const duration = document.getElementById('duratn').value;
            if (duration === 'default') {
                e.preventDefault();
                showValidationError('Lütfen bir abonelik süresi seçin');
                return;
            }
        });
    }

    function showValidationError(message) {
        // Remove existing errors
        const existingErrors = document.querySelectorAll('.validation-error');
        existingErrors.forEach(error => error.remove());
        
        // Create error display
        const errorDiv = document.createElement('div');
        errorDiv.className = 'validation-error mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
        errorDiv.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 dark:text-red-200 font-medium">${message}</span>
            </div>
        `;
        
        form.appendChild(errorDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => errorDiv.remove(), 5000);
    }
});
</script>
@endpush
