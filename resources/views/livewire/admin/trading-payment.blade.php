<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-admin-900 dark:text-admin-100">Fund your wallet</h1>
        <a href="{{ route('tsettings') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg transition-colors bg-blue-600 hover:bg-blue-700 text-white">
            <i class="fa fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>

    <x-danger-alert />
    <x-success-alert />
    
    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 p-6">
        @if (!$toPay)
            <div class="max-w-2xl mx-auto">
                <form wire:submit.prevent='setToPay' class="space-y-4">
                    <div>
                        <label for="" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Enter Amount ($)</label>
                        <input type="number" wire:model.defer='amount' class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            required>
                    </div>
                    
                    <div>
                        <label for="" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Payment Method</label>
                        <div class="flex justify-center items-center">
                            <div style="cursor:pointer;"
                                class="flex flex-col items-center justify-center p-3 m-2 bg-admin-50 dark:bg-admin-700 rounded-lg text-center shadow-sm border-2 border-primary-200 dark:border-primary-700 hover:border-primary-400 dark:hover:border-primary-500 transition-colors">
                                <img src="{{ asset('dash/tether-usdt-logo.png') }}"
                                    alt="" class="w-6 h-6 mb-1">
                                <h5 class="text-sm font-medium text-admin-700 dark:text-admin-300">Tether(USDT)</h5>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                            Continue to Payment
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        @if ($toPay)
            <div class="max-w-2xl mx-auto">
                <div class="text-right mb-4">
                    <button type="button" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 text-sm rounded-lg transition-colors"
                        wire:click='unSetToPay'>back</button>
                </div>
                
                <form action="" wire:submit.prevent='completePayment' class="space-y-4">
                    <div class="p-4 bg-admin-50 dark:bg-admin-700 rounded-lg border border-admin-200 dark:border-admin-600">
                        <p class="text-admin-700 dark:text-admin-300 mb-2">
                            Please send ${{ $amount }} of {{ $method }} to the wallet address below
                        </p>
                        <h2 class="text-lg font-bold text-admin-900 dark:text-admin-100 break-all">{{ $walletAddress }}</h2>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                            Complete Payment
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
