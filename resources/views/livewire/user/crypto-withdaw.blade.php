<div>
    <x-layout.card
        title="Crypto Withdrawal"
        subtitle="Withdraw funds to your Binance account">

        <x-slot name="header">
            <x-financial.balance-card
                :balance="$user->account_bal"
                :currency="$currency"
                label="Current Balance" />
        </x-slot>

        <!-- Warning Alert -->
        <x-ui.alert type="warning" :dismissable="true">
            <x-slot name="title">Binance Account Required</x-slot>
            Our automatic USDT payment is powered by Binance. To receive your funds, ensure you have a Binance account
            registered with the same email address as your platform account.
            <a href="https://www.binance.com/en" target="_blank" class="btn-link font-semibold">Create an account</a>
            if you don't have one.
            <strong class="block mt-2">
                NOTE: Do not proceed if you don't have a Binance account or use a different email address to avoid losing your funds.
            </strong>
        </x-ui.alert>

        <form wire:submit.prevent="withdraw">
            <div class="space-y-6">
                <x-forms.financial-input
                    wire:model="amount"
                    name="amount"
                    label="Withdrawal Amount"
                    :currency="$currency"
                    :min="0.01"
                    :error="$errors->first('amount')"
                    placeholder="Enter amount to withdraw"
                    required />

                @if ($user->sendotpemail == 'Yes')
                    <div class="space-y-3">
                        <x-forms.input
                            wire:model="otpCode"
                            name="otpCode"
                            label="Enter OTP"
                            :error="$errors->first('otpCode')"
                            placeholder="Enter OTP code"
                            required>
                            <x-slot name="hint">
                                <span class="text-sm text-text-secondary">
                                    OTP will be sent to your email when requested
                                </span>
                            </x-slot>
                        </x-forms.input>

                        <x-ui.button
                            type="button"
                            variant="outline"
                            size="sm"
                            wire:click="requestOtp"
                            :loading="$processing"
                            wire:target="requestOtp"
                            class="w-full sm:w-auto">
                            <x-slot name="prefix">
                                <x-ui.icon name="envelope" class="w-4 h-4" />
                            </x-slot>
                            Request OTP
                        </x-ui.button>
                    </div>
                @endif

                <div class="flex justify-end space-x-4">
                    <x-ui.button
                        type="button"
                        variant="secondary"
                        wire:click="$reset">
                        Reset
                    </x-ui.button>

                    <x-ui.button
                        type="submit"
                        variant="primary"
                        :loading="$processing"
                        :disabled="$processing">
                        Complete Withdrawal
                    </x-ui.button>
                </div>
            </div>
        </form>
    </x-layout.card>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <x-ui.toast type="success" :message="session('success')" />
    @endif

    @if (session()->has('error'))
        <x-ui.toast type="error" :message="session('error')" />
    @endif
</div>
