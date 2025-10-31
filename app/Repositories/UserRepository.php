<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Tp_Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find user with lead information
     */
    public function findWithLeadInfo(int $userId): ?User
    {
        return User::with([
            'leadStatus',
            'leadSource',
            'assignedAdmin',
            'leadAssignmentHistory',
            'leadNotes',
            'leadCommunications'
        ])->find($userId);
    }

    /**
     * Update lead status for user
     */
    public function updateLeadStatus(int $userId, string $status): bool
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return false;
            }

            $user->lead_status = $status;
            $user->last_contact_date = now();
            return $user->save();
        } catch (\Exception $e) {
            Log::error('Failed to update lead status', [
                'user_id' => $userId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get users with pending KYC
     */
    public function getUsersWithPendingKyc(): Collection
    {
        return User::where(function($query) {
            $query->whereNull('account_verify')
                  ->orWhere('account_verify', '!=', 'Verified');
        })->get();
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
     * Get user by ID
     */
    public function findById(int $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * Update user balance
     */
    public function updateBalance(int $userId, float $amount, string $type = 'add'): bool
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return false;
            }

            DB::beginTransaction();

            if ($type === 'add') {
                $user->account_bal += $amount;
            } elseif ($type === 'subtract') {
                if ($user->account_bal < $amount) {
                    throw new \Exception('Insufficient balance');
                }
                $user->account_bal -= $amount;
            } else {
                throw new \Exception('Invalid balance update type');
            }

            $user->save();
            DB::commit();

            Log::info('User balance updated', [
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $type,
                'new_balance' => $user->account_bal
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user balance', [
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get user referral earnings
     */
    public function getReferralEarnings(int $userId): float
    {
        return Tp_Transaction::where('user', $userId)
                            ->where('type', 'Ref_bonus')
                            ->sum('amount');
    }
}