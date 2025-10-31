<div>
    <x-layout.card
        title="New Deposit"
        subtitle="Add funds to your account">

        <x-slot name="header">
            <x-financial.balance-card
                :balance="auth()->user()->account_bal"
                :currency="$currency"
                label="Current Balance" />
        </x-slot>

        <form wire:submit.prevent="saveDeposit">
            <div class="space-y-6">
                <x-forms.financial-input
                    wire:model="amount"
                    name="amount"
                    label="Deposit Amount"
                    :currency="$currency"
                    :min="10"
                    :error="$errors->first('amount')"
                    required />

                <x-forms.select
                    wire:model="paymentMethod"
                    name="paymentMethod"
                    label="Payment Method"
                    :options="$paymentMethods"
                    :error="$errors->first('paymentMethod')"
                    required />

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
                        :loading="$processing">
                        Process Deposit
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
