<?php

namespace App\Repositories;

use App\Contracts\Repositories\WithdrawalRepositoryInterface;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Models\User_plans;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalStatus;
use App\Traits\Coinpayment;
use App\Traits\NotificationTrait;

class WithdrawalRepository implements WithdrawalRepositoryInterface
{
    use Coinpayment, NotificationTrait;

    /**
     * Create new withdrawal
     */
    public function create(array $withdrawalData): Withdrawal
    {
        return Withdrawal::create($withdrawalData);
    }

    /**
     * Find pending withdrawals
     */
    public function findPendingWithdrawals(): Collection
    {
        return Withdrawal::where('status', 'Pending')
                        ->with('duser')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    /**
     * Find withdrawal by ID
     */
    public function findById(int $withdrawalId): ?Withdrawal
    {
        return Withdrawal::with('duser')->find($withdrawalId);
    }

    /**
     * Update withdrawal status
     */
    public function updateStatus(int $withdrawalId, string $status): bool
    {
        try {
            $withdrawal = Withdrawal::find($withdrawalId);
            if (!$withdrawal) {
                return false;
            }

            $withdrawal->status = $status;
            return $withdrawal->save();
        } catch (\Exception $e) {
            Log::error('Failed to update withdrawal status', [
                'withdrawal_id' => $withdrawalId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get user withdrawal history
     */
    public function getUserWithdrawalHistory(int $userId): Collection
    {
        return Withdrawal::where('user', $userId)
                        ->with('duser')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    /**
     * Process withdrawal with transaction
     */
    public function processWithdrawal(array $withdrawalData): Withdrawal
    {
        return DB::transaction(function () use ($withdrawalData) {
            $user = User::find($withdrawalData['user']);
            $settings = Settings::where('id', '1')->first();
            $method = Wdmethod::where('name', $withdrawalData['payment_mode'])->first();

            // Validate withdrawal
            $this->validateWithdrawal($user, $withdrawalData['amount'], $method, $settings);

            // Process wallet addresses for crypto
            $this->processWalletAddresses($user, $withdrawalData);

            // Calculate charges
            $charges = $this->calculateCharges($method, $withdrawalData['amount']);
            $toDeduct = $withdrawalData['amount'] + $charges;

            // Deduct from balance if required
            if ($settings->deduction_option == "userRequest") {
                User::where('id', $user->id)->update([
                    'account_bal' => $user->account_bal - $toDeduct,
                    'withdrawotp' => NULL,
                ]);
            }

            // Create withdrawal record
            $withdrawalData['to_deduct'] = $toDeduct;
            $withdrawalData['status'] = 'Pending';
            $withdrawal = $this->create($withdrawalData);

            // Process auto withdrawal for crypto
            if ($settings->withdrawal_option == "auto" &&
                in_array($withdrawalData['payment_mode'], ['Bitcoin', 'Litecoin', 'Ethereum', 'USDT'])) {
                return $this->processCryptoWithdrawal($withdrawal, $user, $toDeduct);
            }

            // Send notifications
            $this->sendWithdrawalNotifications($withdrawal, $user, $settings);

            Log::info('Withdrawal processed successfully', [
                'withdrawal_id' => $withdrawal->id,
                'user_id' => $user->id,
                'amount' => $withdrawal->amount,
                'payment_mode' => $withdrawal->payment_mode
            ]);

            return $withdrawal;
        });
    }

    /**
     * Get withdrawals by status
     */
    public function getWithdrawalsByStatus(string $status): Collection
    {
        return Withdrawal::where('status', $status)
                        ->with('duser')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    /**
     * Get total withdrawal amount for user
     */
    public function getTotalWithdrawalAmount(int $userId): float
    {
        return Withdrawal::where('user', $userId)
                        ->where('status', 'Processed')
                        ->sum('amount');
    }

    /**
     * Get withdrawals within date range
     */
    public function getWithdrawalsByDateRange(int $userId, string $startDate, string $endDate): Collection
    {
        return Withdrawal::where('user', $userId)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    /**
     * Check if user can withdraw amount
     */
    public function canWithdraw(int $userId, float $amount): bool
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        $settings = Settings::where('id', '1')->first();
        if ($settings->enable_kyc == "yes" && $user->account_verify != "Verified") {
            return false;
        }

        return $user->account_bal >= $amount;
    }

    /**
     * Validate withdrawal request
     */
    private function validateWithdrawal(User $user, float $amount, Wdmethod $method, Settings $settings): void
    {
        if ($settings->enable_kyc == "yes" && $user->account_verify != "Verified") {
            throw new \Exception('KYC verification required for withdrawals');
        }

        if ($user->account_bal < $amount) {
            throw new \Exception('Insufficient balance');
        }

        if ($amount < $method->minimum) {
            throw new \Exception("Minimum withdrawal amount is {$settings->currency}{$method->minimum}");
        }
    }

    /**
     * Process wallet addresses for crypto withdrawals
     */
    private function processWalletAddresses(User $user, array &$withdrawalData): void
    {
        if ($withdrawalData['payment_mode'] == 'Bitcoin') {
            User::where('id', $user->id)->update(['btc_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Ethereum') {
            User::where('id', $user->id)->update(['eth_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Litecoin') {
            User::where('id', $user->id)->update(['ltc_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'USDT') {
            User::where('id', $user->id)->update(['usdt_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Bank Transfer') {
            User::where('id', $user->id)->update([
                'bank_name' => $withdrawalData['bank_name'] ?? '',
                'account_name' => $withdrawalData['account_name'] ?? '',
                'swift_code' => $withdrawalData['swift_code'] ?? '',
                'account_number' => $withdrawalData['account_number'] ?? '',
            ]);
        }
    }

    /**
     * Calculate withdrawal charges
     */
    private function calculateCharges(Wdmethod $method, float $amount): float
    {
        if ($method->charges_type == 'percentage') {
            return $amount * $method->charges_amount / 100;
        } else {
            return $method->charges_amount;
        }
    }

    /**
     * Process crypto withdrawal
     */
    private function processCryptoWithdrawal(Withdrawal $withdrawal, User $user, float $toDeduct): Withdrawal
    {
        $coin = $this->getCoinType($withdrawal->payment_mode);
        $wallet = $this->getWalletAddress($user, $withdrawal->payment_mode);

        return $this->cpwithdraw($withdrawal->amount, $coin, $wallet, $user->id, $toDeduct);
    }

    /**
     * Get coin type for crypto withdrawal
     */
    private function getCoinType(string $paymentMode): string
    {
        $coinMap = [
            'Bitcoin' => 'BTC',
            'Ethereum' => 'ETH',
            'Litecoin' => 'LTC',
            'USDT' => 'USDT.TRC20'
        ];

        return $coinMap[$paymentMode] ?? $paymentMode;
    }

    /**
     * Get wallet address for crypto withdrawal
     */
    private function getWalletAddress(User $user, string $paymentMode): string
    {
        $addressMap = [
            'Bitcoin' => $user->btc_address,
            'Ethereum' => $user->eth_address,
            'Litecoin' => $user->ltc_address,
            'USDT' => $user->usdt_address
        ];

        return $addressMap[$paymentMode] ?? '';
    }

    /**
     * Send withdrawal notifications
     */
    private function sendWithdrawalNotifications(Withdrawal $withdrawal, User $user, Settings $settings): void
    {
        // Send to admin
        try {
            Mail::to($settings->contact_email)->send(new WithdrawalStatus($withdrawal, $user, 'Withdrawal Request', true));
        } catch (\Exception $e) {
            Log::error('Failed to send withdrawal notification to admin', [
                'withdrawal_id' => $withdrawal->id,
                'user_email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }

        // Send to user
        try {
            Mail::to($user->email)->send(new WithdrawalStatus($withdrawal, $user, 'Successful Withdrawal Request'));
        } catch (\Exception $e) {
            Log::error('Failed to send withdrawal confirmation to user', [
                'withdrawal_id' => $withdrawal->id,
                'user_email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }

        // Send notification to user and admin
        $this->sendWithdrawalNotification($withdrawal->amount, $settings->currency, $withdrawal->id);
    }
}