
<div>
    <x-layout.card
        title="Crypto Payment"
        subtitle="Complete your deposit using cryptocurrency">

        <!-- Payment Summary -->
        <div class="bg-surface-hover rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-text-secondary">Amount to Pay</p>
                    <p class="text-2xl font-bold text-text-primary">
                        <x-financial.amount-display :amount="$amount" :currency="$currency" />
                    </p>
                </div>

                @if($payment_mode)
                    <div class="text-right">
                        <p class="text-sm font-medium text-text-secondary">Payment Method</p>
                        <p class="text-lg font-semibold text-text-primary">{{ $payment_mode->name }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Instructions -->
        <x-ui.alert type="info" class="mb-6">
            <x-slot name="title">Payment Instructions</x-slot>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li>You will be redirected to Binance Pay to complete your payment</li>
                <li>Ensure you have sufficient funds in your Binance account</li>
                <li>Payment will be processed automatically once confirmed</li>
                <li>Your account balance will be updated after successful payment</li>
            </ul>
        </x-ui.alert>

        <!-- Payment Button -->
        <div class="flex justify-center">
            <x-ui.button
                type="button"
                variant="primary"
                size="lg"
                wire:click="payViaBinance"
                :loading="$processing"
                :disabled="$processing"
                class="w-full sm:w-auto">
                <x-slot name="prefix">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </x-slot>
                Pay with Binance
            </x-ui.button>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 p-4 bg-warning-50 border border-warning-200 rounded-lg">
            <div class="flex items-start">
                <x-ui.icon name="exclamation-triangle" class="w-5 h-5 text-warning-600 mt-0.5 mr-3 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-medium text-warning-800">Security Notice</h4>
                    <p class="mt-1 text-sm text-warning-700">
                        Only proceed if you have a verified Binance account. Payments are processed securely through Binance's official payment gateway.
                    </p>
                </div>
            </div>
        </div>
    </x-layout.card>

    <!-- Flash Messages -->
    @if (session()->has('error'))
        <x-ui.toast type="error" :message="session('error')" />
    @endif
</div>
