<div>
    <x-layout.card
        title="{{ __('user.investment.investment_plans') }}"
        subtitle="{{ __('user.investment.choose_invest_subtitle') }}">

        <x-slot name="header">
            <x-financial.balance-card
                :balance="$user->account_bal"
                :currency="$currency"
                label="{{ __('user.financial.available_balance') }}" />
        </x-slot>
                        <div class="mt-5">
                            <div class="">
                                <p>{{ __('user.investment.choose_quick_amount') }}</p>
                            </div>
                            <div class="flex-wrap mb-1 d-flex justify-content-start align-items-center">
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('100')">{{ $settings->currency }}100</button>
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('250')">{{ $settings->currency }}250</button>
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('500')">{{ $settings->currency }}500</button>
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('1000')">{{ $settings->currency }}1,000</button>
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('1500')">{{ $settings->currency }}1,500</button>
                                <button class="mb-2 border-black rounded-none btn btn-light"
                                    wire:click="selectAmount('2000')">{{ $settings->currency }}2,000</button>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="">
                                <p>{{ __('user.investment.or_enter_amount') }}</p>
                                <div>
                                    <input type="number" required wire:model='amountToInvest'
                                        wire:keyup="checkIfAmountIsEmpty" name="" id=""
                                        class="form-control d-block w-100" placeholder="{{ __('user.investment.amount_placeholder') }}"
                                        min="{{ $planSelected ? $planSelected->min_price : '0' }}"
                                        max="{{ $planSelected ? $planSelected->max_price : '10000000000' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <p>{{ __('user.investment.choose_payment_method') }}</p>
                        </div>
                        <div class="select-menu2">
                            <ul class="options2 d-block">
                                <li class="mb-3 option2 {{ $paymentMethod == 'Account Balance' ? 'bg-light border border-primary' : '' }}"
                                    id="acnt" wire:click="chanegePaymentMethod('Account Balance')">
                                    <i class="fas fa-wallet"></i>
                                    <span class="option-text2 d-block mr-2">{{ __('user.financial.account_balance') }} </span> <br>
                                    <span class="small">
                                        {{ $settings->currency }}{{ number_format(Auth::user()->account_bal) }}
                                    </span>
                                </li>
                                {{-- <li class="mb-3 shadow option2 {{ $paymentMethod == 'BTC Wallet' ? 'bg-light border border-primary' : '' }}"
                                    id="btcbal" wire:click="chanegePaymentMethod('BTC Wallet')">
                                    <i class="fab fa-bitcoin"></i>
                                    <span class="option-text2">BTC Wallet</span>
                                    <span class="small">
                                        <strong> Balance: </strong> 0.00038828 BTC
                                    </span>
                                </li> --}}
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>{{ __('user.investment.investment_details') }}</p>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.plan_name') }}</p>
                                <span class="text-primary small">{{ $planSelected ? $planSelected->name : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.plan_price') }}</p>
                                <span
                                    class="text-primary small">{{ $settings->currency }}{{ $planSelected ? $planSelected->price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.duration') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $planSelected->expiration : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.profit') }}</p>
                                <span class="text-primary small">
                                    @if ($planSelected)
                                        @if ($planSelected->increment_type == 'Fixed')
                                            {{ $settings->currency }}{{ $planSelected->increment_amount }}
                                            {{ $planSelected->increment_interval }}
                                        @else
                                            {{ $planSelected->increment_amount }}%
                                            {{ $planSelected->increment_interval }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.min_deposit') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $settings->currency . $planSelected->min_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.max_deposit') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $settings->currency . $planSelected->max_price : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.min_return') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $planSelected->minr . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.max_return') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $planSelected->maxr . '%' : '-' }}</span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <p class="mb-0 small">{{ __('user.investment.bonus') }}</p>
                                <span
                                    class="text-primary small">{{ $planSelected ? $settings->currency . $planSelected->gift : '-' }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="justify-content-between d-md-flex">
                            <span class="small d-block d-md-inline">{{ __('user.investment.payment_method') }}:</span>
                            <span class="small text-primary">{{ $paymentMethod ? $paymentMethod : '-' }}</span>
                        </div>
                        <hr>
                        <div class="justify-content-between d-md-flex">
                            <span class="d-block d-md-inline font-weight-bold">{{ __('user.investment.amount_to_invest') }}:</span>
                            <span
                                class="text-primary font-weight-bold">{{ $settings->currency }}{{ $amountToInvest ? number_format($amountToInvest) : '0' }}</span>
                        </div>
                        <div class="mt-3 text-center">
                            <form action="" wire:submit.prevent="joinPlan">
                                <button class="px-3 btn btn-primary" {{ $disabled }}>
                                    {{ __('user.investment.confirm_invest') }}
                                </button>
                            </form>
                            <span class="mt-2 small text-primary" wire:loading wire:target="joinPlan">
                                {{ $feedback }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="py-4 card">
                    <div class="text-center card-body">
                        <p>{{ __('user.investment.no_plans_available') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<script>
// Investment Plan Component State
let investmentPlanState = {
    planSelectorOpen: false
};

// Toggle plan selector dropdown
function togglePlanSelector() {
    investmentPlanState.planSelectorOpen = !investmentPlanState.planSelectorOpen;
    const selectMenu = document.getElementById('planSelectMenu');
    
    if (selectMenu) {
        if (investmentPlanState.planSelectorOpen) {
            selectMenu.classList.add('active');
        } else {
            selectMenu.classList.remove('active');
        }
    }
}

// Close plan selector dropdown
function closePlanSelector() {
    investmentPlanState.planSelectorOpen = false;
    const selectMenu = document.getElementById('planSelectMenu');
    
    if (selectMenu) {
        selectMenu.classList.remove('active');
    }
}

// Initialize investment plan component
document.addEventListener('DOMContentLoaded', function() {
    // Add click outside listener for plan selector
    document.addEventListener('click', function(event) {
        const selectMenu = document.getElementById('planSelectMenu');
        if (selectMenu && investmentPlanState.planSelectorOpen && !selectMenu.contains(event.target)) {
            closePlanSelector();
        }
    });
    
    console.log("{{ __('user.investment.component_initialized') }}");
});
</script>
