<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepositRepositoryInterface;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DepositStatus;
use App\Traits\NotificationTrait;

class DepositRepository implements DepositRepositoryInterface
{
    use NotificationTrait;

    /**
     * Create new deposit
     */
    public function create(array $depositData): Deposit
    {
        return Deposit::create($depositData);
    }

    /**
     * Find pending deposits
     */
    public function findPendingDeposits(): Collection
    {
        return Deposit::where('status', 'Pending')
                     ->with('duser')
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    /**
     * Find deposit by ID
     */
    public function findById(int $depositId): ?Deposit
    {
        return Deposit::with('duser')->find($depositId);
    }

    /**
     * Update deposit status
     */
    public function updateStatus(int $depositId, string $status): bool
    {
        try {
            $deposit = Deposit::find($depositId);
            if (!$deposit) {
                return false;
            }

            $deposit->status = $status;
            return $deposit->save();
        } catch (\Exception $e) {
            Log::error('Failed to update deposit status', [
                'deposit_id' => $depositId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get user deposit history
     */
    public function getUserDepositHistory(int $userId): Collection
    {
        return Deposit::where('user', $userId)
                     ->with('duser')
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    /**
     * Process deposit with transaction
     */
    public function processDeposit(array $depositData): Deposit
    {
        return DB::transaction(function () use ($depositData) {
            // Create deposit
            $deposit = $this->create($depositData);

            // Get user and settings
            $user = User::find($deposit->user);
            $settings = Settings::where('id', '1')->first();

            // Process referral bonuses and balance updates
            $this->processReferralCommission($user, $deposit->amount, $settings);

            // Add deposit bonus if applicable
            if ($settings->deposit_bonus != NULL && $settings->deposit_bonus > 0) {
                $bonus = $deposit->amount * $settings->deposit_bonus / 100;
                $this->addDepositBonus($user, $bonus, $deposit->amount, $settings->currency);
            }

            // Update user balance
            $bonus = $bonus ?? 0;
            User::where('id', $user->id)->update([
                'account_bal' => $user->account_bal + $deposit->amount + $bonus,
                'bonus' => $user->bonus + $bonus,
                'cstatus' => 'Customer',
            ]);

            // Send notifications
            $this->sendDepositNotifications($deposit, $user, $settings);

            Log::info('Deposit processed successfully', [
                'deposit_id' => $deposit->id,
                'user_id' => $user->id,
                'amount' => $deposit->amount,
                'bonus' => $bonus
            ]);

            return $deposit;
        });
    }

    /**
     * Get deposits by status
     */
    public function getDepositsByStatus(string $status): Collection
    {
        return Deposit::where('status', $status)
                     ->with('duser')
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    /**
     * Get total deposit amount for user
     */
    public function getTotalDepositAmount(int $userId): float
    {
        return Deposit::where('user', $userId)
                     ->where('status', 'Processed')
                     ->sum('amount');
    }

    /**
     * Get deposits within date range
     */
    public function getDepositsByDateRange(int $userId, string $startDate, string $endDate): Collection
    {
        return Deposit::where('user', $userId)
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->orderBy('created_at', 'desc')
                     ->get();
    }

    /**
     * Process referral commission
     */
    private function processReferralCommission(User $user, float $amount, Settings $settings): void
    {
        if (!empty($user->ref_by)) {
            $agent = User::where('id', $user->ref_by)->first();
            $earnings = $settings->referral_commission * $amount / 100;

            User::where('id', $user->ref_by)->update([
                'account_bal' => $agent->account_bal + $earnings,
                'ref_bonus' => $agent->ref_bonus + $earnings,
            ]);

            Tp_Transaction::create([
                'user' => $user->ref_by,
                'plan' => "Credit",
                'amount' => $earnings,
                'type' => "Ref_bonus",
            ]);

            // Process ancestors (getAncestors logic extracted)
            $this->processAncestors($amount, $user->id);
        }
    }

    /**
     * Process ancestors for referral commission
     */
    private function processAncestors(float $depositAmount, int $parentId): void
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
        User::where('id', $entry->id)->update([
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
     * Add deposit bonus
     */
    private function addDepositBonus(User $user, float $bonus, float $depositAmount, string $currency): void
    {
        Tp_Transaction::create([
            'user' => $user->id,
            'plan' => "Deposit Bonus for $currency $depositAmount deposited",
            'amount' => $bonus,
            'type' => "Bonus",
        ]);
    }

    /**
     * Send deposit notifications
     */
    private function sendDepositNotifications(Deposit $deposit, User $user, Settings $settings): void
    {
        // Send to admin
        try {
            Mail::to($settings->contact_email)->send(new DepositStatus($deposit, $user, 'Successful Deposit', true));
        } catch (\Exception $e) {
            Log::error('Failed to send deposit notification to admin', [
                'deposit_id' => $deposit->id,
                'user_email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }

        // Send to user
        try {
            Mail::to($user->email)->send(new DepositStatus($deposit, $user, 'Successful Deposit', false));
        } catch (\Exception $e) {
            Log::error('Failed to send deposit confirmation to user', [
                'deposit_id' => $deposit->id,
                'user_email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }

        // Send notification to user and admin
        $this->sendDepositNotification($deposit->amount, $settings->currency, $deposit->id);
    }
}