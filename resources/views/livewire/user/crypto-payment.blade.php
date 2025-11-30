
<div>
    <x-layout.card
        :title="__('user.financial.crypto.payment_title')"
        :subtitle="__('user.financial.crypto.payment_subtitle')">

        <!-- Payment Summary -->
        <div class="bg-surface-hover rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-text-secondary">{{ __('user.financial.crypto.amount_to_pay') }}</p>
                    <p class="text-2xl font-bold text-text-primary">
                        <x-financial.amount-display :amount="$amount" :currency="$currency" />
                    </p>
                </div>

                @if($payment_mode)
                    <div class="text-right">
                        <p class="text-sm font-medium text-text-secondary">{{ __('user.financial.payment.method') }}</p>
                        <p class="text-lg font-semibold text-text-primary">{{ $payment_mode->name }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Instructions -->
        <x-ui.alert type="info" class="mb-6">
            <x-slot name="title">{{ __('user.financial.crypto.payment_instructions') }}</x-slot>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li>{{ __('user.financial.crypto.instruction_1') }}</li>
                <li>{{ __('user.financial.crypto.instruction_2') }}</li>
                <li>{{ __('user.financial.crypto.instruction_3') }}</li>
                <li>{{ __('user.financial.crypto.instruction_4') }}</li>
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
                {{ __('user.financial.crypto.pay_with_binance') }}
            </x-ui.button>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 p-4 bg-warning-50 border border-warning-200 rounded-lg">
            <div class="flex items-start">
                <x-ui.icon name="exclamation-triangle" class="w-5 h-5 text-warning-600 mt-0.5 mr-3 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-medium text-warning-800">{{ __('common.security.notice_title') }}</h4>
                    <p class="mt-1 text-sm text-warning-700">
                        {{ __('user.financial.crypto.security_notice') }}
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
