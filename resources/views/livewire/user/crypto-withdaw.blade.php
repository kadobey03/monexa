<div>
    <x-layout.card
        :title="__('user.financial.withdrawal.crypto_title')"
        :subtitle="__('user.financial.withdrawal.crypto_subtitle')">

        <x-slot name="header">
            <x-financial.balance-card
                :balance="$user->account_bal"
                :currency="$currency"
                :label="__('user.financial.balance.current')" />
        </x-slot>

        <!-- Warning Alert -->
        <x-ui.alert type="warning" :dismissable="true">
            <x-slot name="title">{{ __('user.financial.withdrawal.binance_required') }}</x-slot>
            {{ __('user.financial.withdrawal.binance_description') }}
            <a href="https://www.binance.com/en" target="_blank" class="btn-link font-semibold">{{ __('user.financial.withdrawal.create_account') }}</a>
            {{ __('user.financial.withdrawal.create_account_suffix') }}
            <strong class="block mt-2">
                {{ __('user.financial.withdrawal.warning_note') }}
            </strong>
        </x-ui.alert>

        <form wire:submit.prevent="withdraw">
            <div class="space-y-6">
                <x-forms.financial-input
                    wire:model="amount"
                    name="amount"
                    :label="__('user.financial.amount.withdrawal')"
                    :currency="$currency"
                    :min="0.01"
                    :error="$errors->first('amount')"
                    :placeholder="__('user.financial.amount.withdrawal_placeholder')"
                    required />

                @if ($user->sendotpemail == 'Yes')
                    <div class="space-y-3">
                        <x-forms.input
                            wire:model="otpCode"
                            name="otpCode"
                            :label="__('user.security.otp.enter_label')"
                            :error="$errors->first('otpCode')"
                            :placeholder="__('user.security.otp.enter_placeholder')"
                            required>
                            <x-slot name="hint">
                                <span class="text-sm text-text-secondary">
                                    {{ __('user.security.otp.email_hint') }}
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
                            {{ __('user.security.otp.request_button') }}
                        </x-ui.button>
                    </div>
                @endif

                <div class="flex justify-end space-x-4">
                    <x-ui.button
                        type="button"
                        variant="secondary"
                        wire:click="$reset">
                        {{ __('common.buttons.reset') }}
                    </x-ui.button>

                    <x-ui.button
                        type="submit"
                        variant="primary"
                        :loading="$processing"
                        :disabled="$processing">
                        {{ __('user.financial.withdrawal.complete_button') }}
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
