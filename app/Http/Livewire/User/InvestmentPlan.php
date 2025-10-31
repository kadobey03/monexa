<?php

namespace App\Http\Livewire\User;

use App\Services\PlanService;
use App\Services\NotificationService;
use App\Models\Plans;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class InvestmentPlan extends Component
{
    public ?Plans $planSelected = null;

    #[Validate('required|numeric|min:0')]
    public $amountToInvest = 0;

    #[Validate('required|in:Account Balance')]
    public $paymentMethod = 'Account Balance';

    public $processing = false;
    public $feedback = '';
    public $currency = 'USD';

    public function __construct(
        private PlanService $planService,
        private NotificationService $notificationService
    ) {}

    public function mount()
    {
        $this->paymentMethod = 'Account Balance';

        // Get currency from settings
        $settings = Settings::where('id', '1')->first();
        $this->currency = $settings->currency ?? 'USD';

        // Select first available plan
        $firstPlan = Plans::orderByDesc('id')->first();
        if ($firstPlan) {
            $this->planSelected = $firstPlan;
        }
    }

    public function selectPlan($id)
    {
        $this->planSelected = Plans::find($id);
        $this->validateForm();
    }

    public function updatedAmountToInvest()
    {
        $this->validateOnly('amountToInvest');
        $this->validateForm();
    }

    public function selectAmount($value)
    {
        $this->amountToInvest = intval($value);
        $this->validateForm();
    }

    public function changePaymentMethod($method)
    {
        $this->paymentMethod = $method;
        $this->validateForm();
    }

    private function validateForm()
    {
        // Basic validation - we can invest if we have plan, amount > 0, and payment method
        $this->validateOnly('amountToInvest');
        $this->validateOnly('paymentMethod');
    }

    public function getCanInvestProperty()
    {
        return $this->planSelected &&
               $this->amountToInvest > 0 &&
               $this->paymentMethod &&
               !$this->processing;
    }


    public function joinPlan()
    {
        $this->validate();

        if (!$this->canInvest) {
            session()->flash('error', 'Please complete all required fields');
            return;
        }

        $this->processing = true;
        $this->feedback = 'Processing your investment...';

        try {
            // Check plan eligibility via service
            $eligibility = $this->planService->validatePlanEligibility(
                $this->planSelected,
                $this->amountToInvest,
                auth()->user()
            );

            if (!$eligibility->eligible) {
                session()->flash('error', $eligibility->message);
                return;
            }

            // Invest in plan via service
            $result = $this->planService->investInPlan(
                $this->planSelected,
                $this->amountToInvest,
                auth()->user(),
                $this->paymentMethod
            );

            if ($result->success) {
                // Reset form
                $this->reset(['amountToInvest']);

                // Emit events for real-time updates
                $this->emit('plan-invested', $result->userPlan);
                $this->emit('balance-updated');
                $this->emit('notification-count-updated');

                session()->flash('success', 'Investment plan activated successfully!');
            } else {
                session()->flash('error', $result->message ?? 'Failed to activate investment plan');
            }
        } catch (\Exception $e) {
            Log::error('Plan investment failed in Livewire component', [
                'user_id' => auth()->id(),
                'plan_id' => $this->planSelected?->id,
                'amount' => $this->amountToInvest,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred. Please try again.');
        } finally {
            $this->processing = false;
            $this->feedback = '';
        }
    }
    public function render()
    {
        return view('livewire.user.investment-plan', [
            'plans' => Plans::orderByDesc('id')->get(),
            'settings' => Settings::where('id', '1')->first(),
            'user' => auth()->user(),
        ]);
    }
}