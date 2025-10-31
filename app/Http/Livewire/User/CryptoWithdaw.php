<?php

namespace App\Http\Livewire\User;

use App\Services\FinancialService;
use App\Services\UserService;
use App\Services\NotificationService;
use App\Models\Settings;
use App\Traits\BinanceApi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class CryptoWithdaw extends Component
{
    use BinanceApi;

    #[Validate('required|numeric|min:0.01')]
    public $amount;

    #[Validate('required|string|max:6')]
    public $otpCode;

    public $payment_mode = 'USDT';
    public $processing = false;
    public $otpRequested = false;
    public $currency = 'USD';

    public function __construct(
        private FinancialService $financialService,
        private UserService $userService,
        private NotificationService $notificationService
    ) {}

    public function mount()
    {
        $settings = Settings::where('id', '1')->first();
        $this->currency = $settings->currency ?? 'USD';
    }

    public function requestOtp()
    {
        $this->processing = true;

        try {
            // Generate and update OTP via UserService
            $otpCode = $this->userService->generateWithdrawalOtp(auth()->user());
            $this->otpRequested = true;

            session()->flash('success', 'OTP has been sent to your email');
        } catch (\Exception $e) {
            Log::error('OTP generation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Failed to send OTP. Please try again.');
        } finally {
            $this->processing = false;
        }
    }

    public function withdraw()
    {
        $this->validate();

        $this->processing = true;

        try {
            // Check OTP if required
            if (auth()->user()->sendotpemail == "Yes" && !$this->userService->verifyWithdrawalOtp(auth()->user(), $this->otpCode)) {
                session()->flash('error', 'OTP is incorrect, please recheck the code');
                return;
            }

            // Process withdrawal via FinancialService
            $result = $this->financialService->processWithdrawal([
                'amount' => $this->amount,
                'payment_mode' => $this->payment_mode,
                'paydetails' => auth()->user()->email, // Binance email
            ], auth()->user());

            if ($result->success) {
                // Binance payout logic using trait
                $http_response = $this->payout($this->amount, $this->generateRandomString(10), auth()->user()->email);
                $data = json_decode($http_response);

                if ($data->status == "FAIL") {
                    session()->flash('error', 'Something went wrong, please contact our support team if problem persists');
                    Log::error('Binance payout failed', [
                        'user_id' => auth()->id(),
                        'response' => $http_response
                    ]);
                } else {
                    // Create Binance transaction record
                    $this->createBinanceRecord($data->data->requestId);

                    // Emit events for real-time updates
                    $this->emit('withdrawal-processed', $result->withdrawal);
                    $this->emit('balance-updated');
                    $this->emit('notification-count-updated');

                    $this->reset(['amount', 'otpCode']);
                    session()->flash('success', 'Withdrawal request submitted successfully');
                }
            } else {
                session()->flash('error', $result->errorMessage ?? 'Failed to process withdrawal');
            }
        } catch (\Exception $e) {
            Log::error('Withdrawal processing failed in Livewire component', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred processing your withdrawal');
        } finally {
            $this->processing = false;
        }
    }


    /**
     * Generate random string
     */
    private function generateRandomString(int $n): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * Create Binance transaction record
     */
    private function createBinanceRecord(string $requestId): void
    {
        \App\Models\BncTransaction::create([
            'user_id' => auth()->id(),
            'prepay_id' => $requestId,
            'type' => 'Withdrawal',
            'status' => 'Pending'
        ]);
    }

    public function render()
    {
        return view('livewire.user.crypto-withdaw', [
            'settings' => Settings::where('id', '1')->first(),
            'user' => auth()->user()
        ]);
    }
}