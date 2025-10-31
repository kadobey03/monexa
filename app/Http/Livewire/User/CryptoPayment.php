<?php

namespace App\Http\Livewire\User;

use App\Models\BncTransaction;
use App\Models\Wdmethod;
use App\Models\Settings;
use App\Traits\BinanceApi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class CryptoPayment extends Component
{
    use BinanceApi;

    public $amount;
    public $paymentMode;
    public $processing = false;

    public function mount()
    {
        $this->amount = session('amount');
        $this->paymentMode = session('payment_mode');
    }

    public function payViaBinance()
    {
        $this->processing = true;

        try {
            // Validate session data
            if (!$this->amount || !$this->paymentMode) {
                session()->flash('error', 'Payment session expired. Please try again.');
                return;
            }

            // Create Binance order
            $successUrl = env('APP_URL') . "/dashboard/binance/success";
            $errorUrl = env('APP_URL') . "/dashboard/binance/error";
            $transactionID = $this->generateTransactionId(10);

            $response = json_decode($this->createOrder($this->amount, $transactionID, $successUrl, $errorUrl));

            if (!$response || !isset($response->data)) {
                Log::error('Binance order creation failed', [
                    'user_id' => auth()->id(),
                    'amount' => $this->amount,
                    'response' => $response
                ]);
                session()->flash('error', 'Failed to create payment order. Please try again.');
                return;
            }

            $data = $response->data;

            // Create Binance transaction record
            $this->createBinanceRecord($data->prepayId, $transactionID);

            // Clear session data
            session()->forget(['amount', 'payment_mode']);

            // Redirect to Binance checkout
            return redirect()->away($data->checkoutUrl);

        } catch (\Exception $e) {
            Log::error('Binance payment initiation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'An error occurred. Please try again.');
        } finally {
            $this->processing = false;
        }
    }

    /**
     * Generate transaction ID
     */
    private function generateTransactionId(int $length): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $transactionId = '';

        for ($i = 0; $i < $length; $i++) {
            $transactionId .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $transactionId;
    }

    /**
     * Create Binance transaction record
     */
    private function createBinanceRecord(string $prepayId, string $transactionId): void
    {
        BncTransaction::create([
            'user_id' => auth()->id(),
            'prepay_id' => $prepayId,
            'transaction_id' => $transactionId,
            'type' => 'Deposit',
            'status' => 'Pending',
            'amount' => $this->amount
        ]);
    }

    public function render()
    {
        $method = Wdmethod::where('name', $this->paymentMode)->first();
        $settings = Settings::where('id', '1')->first();

        return view('livewire.user.crypto-payment', [
            'title' => 'Deposit via crypto',
            'amount' => $this->amount,
            'payment_mode' => $method,
            'currency' => $settings->currency ?? 'USD'
        ]);
    }
}