<div class="space-y-8">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transfer Ayarları</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Kullanıcı transferi özelliklerini yapılandırın</p>
    </div>

    <!-- Main Form -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl shadow-xl border border-green-200 dark:border-green-800 overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
            <div class="flex items-center">
                <div class="p-2 bg-white/20 rounded-lg mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Kullanıcı Transfer Sistemi</h3>
                    <p class="text-green-100 mt-1">Kullanıcılar arası para transferi özelliklerini yönetin</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-8">
            <form action="javascript:void(0)" method="POST" id="trasfer" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Transfer Status Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Transfer Durumu</h4>
                    </div>
                    
                    <div class="bg-white dark:bg-admin-800 p-6 rounded-xl border border-gray-200 dark:border-admin-600 shadow-sm">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Kullanıcı Transferi Özelliği
                        </label>
                        
                        <div class="flex items-center space-x-4">
                            <!-- On Option -->
                            <label class="relative flex items-center cursor-pointer group">
                                <input type="radio" name="usertransfer" value="1" 
                                       class="sr-only peer" 
                                       {{ $moresettings->use_transfer ? 'checked' : '' }}>
                                <div class="flex items-center px-6 py-3 bg-gray-100 dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white transition-all duration-200 group-hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2 text-gray-500 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700 dark:text-gray-300 peer-checked:text-white">Açık</span>
                                </div>
                            </label>
                            
                            <!-- Off Option -->
                            <label class="relative flex items-center cursor-pointer group">
                                <input type="radio" name="usertransfer" value="0" 
                                       class="sr-only peer" 
                                       {{ $moresettings->use_transfer ? '' : 'checked' }}>
                                <div class="flex items-center px-6 py-3 bg-gray-100 dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white transition-all duration-200 group-hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2 text-gray-500 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="font-medium text-gray-700 dark:text-gray-300 peer-checked:text-white">Kapalı</span>
                                </div>
                            </label>
                        </div>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                            Bu özelliği kullanmak istiyorsanız açık, kullanmak istemiyorsanız kapalı olarak seçin.
                        </p>
                    </div>
                </div>

                <!-- Transfer Settings Section -->
                <div class="border-t border-gray-200 dark:border-admin-600 pt-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Transfer Limitleri ve Komisyonlar</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Minimum Transfer Amount -->
                        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl border border-gray-200 dark:border-admin-600 shadow-sm">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Minimum Transfer Miktarı
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" name="min_transfer" value="{{ $moresettings->min_transfer }}" 
                                       min="0" step="0.01"
                                       class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                       placeholder="100.00">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $settings->currency }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Kullanıcıların yapabileceği minimum transfer miktarı
                            </p>
                        </div>
                        
                        <!-- Transfer Charges -->
                        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl border border-gray-200 dark:border-admin-600 shadow-sm">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Komisyon Oranı (%)
                                </span>
                            </label>
                            <div class="relative">
                                <input type="number" name="charges" value="{{ $moresettings->transfer_charges }}" 
                                       min="0" max="100" step="0.01"
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" 
                                       placeholder="2.50">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">%</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Komisyon almak istemiyorsanız 0 girin
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                    <div class="flex">
                        <svg class="w-6 h-6 text-blue-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">Transfer Özelliği Hakkında</h4>
                            <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                <li>• Kullanıcılar birbirlerine para transferi yapabilir</li>
                                <li>• Minimum miktar belirleyerek küçük transferleri engelleyebilirsiniz</li>
                                <li>• Komisyon oranı her transfer için uygulanır</li>
                                <li>• Tüm transfer işlemleri güvenlik kontrollerinden geçer</li>
                                <li>• Transfer geçmişi ve detayları admin panelinde görüntülenebilir</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-admin-600">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="transferButtonText">Ayarları Kaydet</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Form submission with loading state
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('trasfer');
        const saveButton = form.querySelector('button[type="submit"]');
        const saveButtonText = document.getElementById('transferButtonText');
        
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
                const trasfer = document.getElementById('trasfer');
                if (trasfer) {
                    const event = new Event('submit');
                    trasfer.dispatchEvent(event);
                }
            });
        }
        
        // Add visual feedback for radio button changes
        const radioButtons = document.querySelectorAll('input[name="usertransfer"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                // Reset all buttons
                radioButtons.forEach(r => {
                    const label = r.closest('label');
                    const div = label.querySelector('div');
                    if (r.value === '1') {
                        div.classList.remove('peer-checked:bg-green-500', 'peer-checked:border-green-500');
                        div.classList.add('bg-gray-100', 'dark:bg-admin-700', 'border-gray-300', 'dark:border-admin-600');
                    } else {
                        div.classList.remove('peer-checked:bg-red-500', 'peer-checked:border-red-500');
                        div.classList.add('bg-gray-100', 'dark:bg-admin-700', 'border-gray-300', 'dark:border-admin-600');
                    }
                });
                
                // Apply checked styles to selected button
                const selectedLabel = this.closest('label');
                const selectedDiv = selectedLabel.querySelector('div');
                if (this.value === '1') {
                    selectedDiv.classList.remove('bg-gray-100', 'dark:bg-admin-700', 'border-gray-300', 'dark:border-admin-600');
                    selectedDiv.classList.add('bg-green-500', 'border-green-500', 'text-white');
                } else {
                    selectedDiv.classList.remove('bg-gray-100', 'dark:bg-admin-700', 'border-gray-300', 'dark:border-admin-600');
                    selectedDiv.classList.add('bg-red-500', 'border-red-500', 'text-white');
                }
            });
        });
        
        // Initialize the correct styles on page load
        const checkedRadio = document.querySelector('input[name="usertransfer"]:checked');
        if (checkedRadio) {
            checkedRadio.dispatchEvent(new Event('change'));
        }
    });
</script>