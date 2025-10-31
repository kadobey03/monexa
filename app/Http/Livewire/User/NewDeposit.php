<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Services\FinancialService;
use App\Services\NotificationService;
use App\Models\Settings;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class NewDeposit extends Component
{
    #[Validate('required|numeric|min:10')]
    public $amount;

    #[Validate('required|in:crypto,bank_transfer,paypal')]
    public $paymentMethod = 'crypto';

    public $processing = false;
    public $currency = 'USD';

    public function __construct(
        private FinancialService $financialService,
        private NotificationService $notificationService
    ) {}

    public function mount()
    {
        // Get currency from settings
        $settings = Settings::where('id', '1')->first();
        $this->currency = $settings->currency ?? 'USD';
    }

    public function saveDeposit()
    {
        $this->validate();

        $this->processing = true;

        try {
            $result = $this->financialService->processDeposit([
                'amount' => $this->amount,
                'payment_method' => $this->paymentMethod,
            ], auth()->user());

            if ($result->success) {
                // Reset form
                $this->reset(['amount', 'paymentMethod']);

                // Emit events for real-time updates
                $this->emit('deposit-processed', $result->deposit);
                $this->emit('balance-updated');
                $this->emit('notification-count-updated');

                session()->flash('success', 'Deposit processed successfully');
            } else {
                session()->flash('error', $result->errorMessage ?? 'Failed to process deposit');
            }
        } catch (\Exception $e) {
            Log::error('Deposit processing failed in Livewire component', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred processing your deposit');
        } finally {
            $this->processing = false;
        }
    }

    public function getPaymentMethodsProperty()
    {
        return [
            'crypto' => 'Cryptocurrency',
            'bank_transfer' => 'Bank Transfer',
            'paypal' => 'PayPal'
        ];
    }

    public function render()
    {
        return view('livewire.user.new-deposit', [
            'paymentMethods' => $this->paymentMethods
        ]);
    }
}
