<div class="max-w-lg mx-auto">
    @if ($hasSubscribe)
        <!-- Success State -->
        <div class="text-center space-y-6">
            <div class="flex justify-center">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        🔗 Davet Linkiniz
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                            wire:model='inviteLink'
                            readonly
                        >
                        <button
                            @click="navigator.clipboard.writeText($event.target.previousElementSibling.value)"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-blue-600 hover:text-blue-700 transition-colors"
                            title="Kopyala"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                    <p class="text-sm text-amber-800 dark:text-amber-200">
                        ⚠️ <strong>Önemli:</strong> Davet linkinizi kopyalayıp kullanın. Bu linki sadece bir kez kullanabilir ve sayfa yenilendiğinde bir daha erişilemez.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Subscription Form -->
        <form wire:submit.prevent='subscribe' class="space-y-6">
            <!-- Duration Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    ⏰ Abonelik Süresi
                </label>
                <select
                    wire:model='duration'
                    wire:change='calculate'
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors"
                >
                    <option value="Choose">Süre Seçin</option>
                    <option value="Monthly">Aylık</option>
                    <option value="Quarterly">Çeyreklik</option>
                    <option value="Yearly">Yıllık</option>
                </select>
            </div>

            <!-- Amount Display -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    💰 Tutar ({{ $settings->currency }})
                </label>
                <input
                    type="number"
                    wire:model='amount'
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                    readonly
                >
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    💡 Tutar hesabınızın bakiyesinden düşülecektir.
                </p>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    🚀 Aboneliği Başlat
                </button>
            </div>
        </form>
    @endif
</div>
