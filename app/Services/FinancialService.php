<?php

namespace App\Services;

use App\Contracts\Repositories\DepositRepositoryInterface;
use App\Contracts\Repositories\WithdrawalRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Services\Results\DepositResult;
use App\Services\Results\WithdrawalResult;
use App\Services\Results\CommissionResult;
use App\Services\Results\ChargeResult;
use App\Exceptions\Business\FinancialException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Tp_Transaction;

class FinancialService
{
    public function __construct(
        private DepositRepositoryInterface $depositRepository,
        private WithdrawalRepositoryInterface $withdrawalRepository,
        private UserRepositoryInterface $userRepository,
        private NotificationService $notificationService
    ) {}

    /**
     * Process deposit with business logic
     */
    public function processDeposit(array $depositData, User $user): DepositResult
    {
        try {
            return DB::transaction(function () use ($depositData, $user) {
                // Validate user status and business rules
                $this->validateDeposit($user, $depositData);

                // Process deposit via repository
                $deposit = $this->depositRepository->processDeposit($depositData);

                // Process referral commission
                $commission = $this->calculateReferralCommission($depositData['amount'], $user);

                // Update user balance with deposit and bonus
                $this->updateUserBalanceForDeposit($user, $deposit->amount);

                // Send notifications
                $this->notificationService->sendDepositConfirmation($deposit);

                Log::info('Deposit processed successfully', [
                    'deposit_id' => $deposit->id,
                    'user_id' => $user->id,
                    'amount' => $deposit->amount
                ]);

                return new DepositResult(true, $deposit, null, $commission);
            });
        } catch (FinancialException $e) {
            Log::warning('Deposit processing failed', [
                'user_id' => $user->id,
                'amount' => $depositData['amount'],
                'error' => $e->getMessage()
            ]);
            return new DepositResult(false, null, $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Unexpected error during deposit processing', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return new DepositResult(false, null, 'Internal error occurred');
        }
    }

    /**
     * Process withdrawal with business logic
     */
    public function processWithdrawal(array $withdrawalData, User $user): WithdrawalResult
    {
        try {
            return DB::transaction(function () use ($withdrawalData, $user) {
                // Validate withdrawal business rules
                $this->validateWithdrawal($user, $withdrawalData);

                // Calculate charges
                $charges = $this->processCharges($withdrawalData['amount'], $withdrawalData['payment_mode']);

                // Verify sufficient balance
                $totalDeduction = $withdrawalData['amount'] + $charges->totalCharges;
                $this->verifyBalanceSufficiency($user, $totalDeduction);

                // Process withdrawal via repository
                $withdrawalData['to_deduct'] = $totalDeduction;
                $withdrawal = $this->withdrawalRepository->processWithdrawal($withdrawalData);

                // Update user balance and wallet addresses
                $this->updateUserForWithdrawal($user, $totalDeduction, $withdrawalData);

                // Send notifications
                $this->notificationService->sendWithdrawalStatus($withdrawal);

                Log::info('Withdrawal processed successfully', [
                    'withdrawal_id' => $withdrawal->id,
                    'user_id' => $user->id,
                    'amount' => $withdrawal->amount
                ]);

                return new WithdrawalResult(true, $withdrawal, null, $charges);
            });
        } catch (FinancialException $e) {
            Log::warning('Withdrawal processing failed', [
                'user_id' => $user->id,
                'amount' => $withdrawalData['amount'],
                'error' => $e->getMessage()
            ]);
            return new WithdrawalResult(false, null, $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Unexpected error during withdrawal processing', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return new WithdrawalResult(false, null, 'Internal error occurred');
        }
    }

    /**
     * Calculate referral commission
     */
    public function calculateReferralCommission(float $depositAmount, User $user): CommissionResult
    {
        $settings = Settings::where('id', '1')->first();

        if (empty($user->ref_by)) {
            return new CommissionResult(0, 0, []);
        }

        $commission = $settings->referral_commission * $depositAmount / 100;

        // Process ancestors using repository
        $this->processAncestorsCommission($depositAmount, $user->id);

        return new CommissionResult($commission, 0, []);
    }

    /**
     * Process ancestors commission (extracted from DepositController)
     */
    private function processAncestorsCommission(float $depositAmount, int $parentId): void
    {
        $users = User::all();
        $this->getAncestors($users, $depositAmount, $parentId);
    }

    /**
     * Get uplines (extracted from DepositController)
     */
    private function getAncestors(Collection $array, float $depositAmount, int $parent = 0, int $level = 0): void
    {
        $settings = Settings::where('id', '1')->first();
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $depositAmount / 100;
                    $this->creditAncestor($entry, $earnings);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $depositAmount / 100;
                    $this->creditAncestor($entry, $earnings);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $depositAmount / 100;
                    $this->creditAncestor($entry, $earnings);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $depositAmount / 100;
                    $this->creditAncestor($entry, $earnings);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $depositAmount / 100;
                    $this->creditAncestor($entry, $earnings);
                }

                if ($level < 6) {
                    $this->getAncestors($array, $depositAmount, $entry->id, $level + 1);
                }
                break;
            }
        }
    }

    /**
     * Credit ancestor with earnings
     */
    private function creditAncestor(User $entry, float $earnings): void
    {
        $entry->update([
            'account_bal' => $entry->account_bal + $earnings,
            'ref_bonus' => $entry->ref_bonus + $earnings,
        ]);

        Tp_Transaction::create([
            'user' => $entry->id,
            'plan' => "Credit",
            'amount' => $earnings,
            'type' => "Ref_bonus",
        ]);
    }

    /**
     * Verify balance sufficiency
     */
    public function verifyBalanceSufficiency(User $user, float $amount): bool
    {
        if ($user->account_bal < $amount) {
            throw new FinancialException('Insufficient balance for this operation');
        }
        return true;
    }

    /**
     * Process charges for withdrawal
     */
    public function processCharges(float $amount, string $paymentMode): ChargeResult
    {
        $method = Wdmethod::where('name', $paymentMode)->first();

        if (!$method) {
            throw new FinancialException('Invalid payment method');
        }

        if ($method->charges_type == 'percentage') {
            $charges = $amount * $method->charges_amount / 100;
        } else {
            $charges = $method->charges_amount;
        }

        return new ChargeResult($charges, $method->charges_type, $method->charges_amount);
    }

    /**
     * Validate deposit business rules
     */
    private function validateDeposit(User $user, array $depositData): void
    {
        if ($depositData['amount'] <= 0) {
            throw new FinancialException('Invalid deposit amount');
        }

        // Add more validation rules as needed
    }

    /**
     * Validate withdrawal business rules
     */
    private function validateWithdrawal(User $user, array $withdrawalData): void
    {
        $settings = Settings::where('id', '1')->first();

        // KYC validation
        if ($settings->enable_kyc == "yes" && $user->account_verify != "Verified") {
            throw new FinancialException('KYC verification required for withdrawals');
        }

        if ($withdrawalData['amount'] <= 0) {
            throw new FinancialException('Invalid withdrawal amount');
        }

        $method = Wdmethod::where('name', $withdrawalData['payment_mode'])->first();
        if (!$method) {
            throw new FinancialException('Invalid payment method');
        }

        if ($withdrawalData['amount'] < $method->minimum) {
            throw new FinancialException("Minimum withdrawal amount is {$settings->currency}{$method->minimum}");
        }
    }

    /**
     * Update user balance for deposit
     */
    private function updateUserBalanceForDeposit(User $user, float $amount): void
    {
        $settings = Settings::where('id', '1')->first();
        $bonus = 0;

        // Add deposit bonus if applicable
        if ($settings->deposit_bonus != NULL && $settings->deposit_bonus > 0) {
            $bonus = $amount * $settings->deposit_bonus / 100;
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Deposit Bonus for {$settings->currency} $amount deposited",
                'amount' => $bonus,
                'type' => "Bonus",
            ]);
        }

        $user->update([
            'account_bal' => $user->account_bal + $amount + $bonus,
            'bonus' => $user->bonus + $bonus,
            'lead_status' => 'converted', // Deposit sonrası lead converted olur
        ]);
    }

    /**
     * Update user for withdrawal
     */
    private function updateUserForWithdrawal(User $user, float $totalDeduction, array $withdrawalData): void
    {
        $settings = Settings::where('id', '1')->first();

        // Update wallet addresses for crypto
        $this->updateWalletAddresses($user, $withdrawalData);

        // Deduct balance if required
        if ($settings->deduction_option == "userRequest") {
            $user->update([
                'account_bal' => $user->account_bal - $totalDeduction,
                'withdrawotp' => NULL,
            ]);
        }
    }

    /**
     * Update wallet addresses for crypto withdrawals
     */
    private function updateWalletAddresses(User $user, array $withdrawalData): void
    {
        if ($withdrawalData['payment_mode'] == 'Bitcoin') {
            $user->update(['btc_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Ethereum') {
            $user->update(['eth_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Litecoin') {
            $user->update(['ltc_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'USDT') {
            $user->update(['usdt_address' => $withdrawalData['paydetails']]);
        } elseif ($withdrawalData['payment_mode'] == 'Bank Transfer') {
            $user->update([
                'bank_name' => $withdrawalData['bank_name'] ?? '',
                'account_name' => $withdrawalData['account_name'] ?? '',
                'swift_code' => $withdrawalData['swift_code'] ?? '',
                'account_number' => $withdrawalData['account_number'] ?? '',
            ]);
        }
    }
}