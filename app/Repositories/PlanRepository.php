<?php

namespace App\Repositories;

use App\Contracts\Repositories\PlanRepositoryInterface;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanRepository implements PlanRepositoryInterface
{
    /**
     * Get active plans
     */
    public function getActivePlans(): Collection
    {
        return Plans::where('active', 'yes')
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Find user active plans
     */
    public function findUserActivePlans(int $userId): Collection
    {
        return User_plans::where('user', $userId)
                        ->where('active', 'yes')
                        ->with('dplan')
                        ->orderBy('activated_at', 'desc')
                        ->get();
    }

    /**
     * Create user plan
     */
    public function createUserPlan(array $planData): User_plans
    {
        return User_plans::create($planData);
    }

    /**
     * Find plan by ID
     */
    public function findById(int $planId): ?Plans
    {
        return Plans::find($planId);
    }

    /**
     * Get plans by category
     */
    public function getPlansByCategory(int $categoryId): Collection
    {
        return Plans::where('category_id', $categoryId)
                   ->where('active', 'yes')
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Get plan with details
     */
    public function getPlanWithDetails(int $planId): ?Plans
    {
        return Plans::with('category')->find($planId);
    }

    /**
     * Check if user can invest in plan
     */
    public function canUserInvestInPlan(int $userId, int $planId, float $amount): bool
    {
        $plan = $this->findById($planId);
        if (!$plan) {
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        // Check minimum and maximum investment amounts
        if ($amount < $plan->min_price || $amount > $plan->max_price) {
            return false;
        }

        // Check if user has sufficient balance
        return $user->account_bal >= $amount;
    }

    /**
     * Get user plan statistics
     */
    public function getUserPlanStatistics(int $userId): array
    {
        $activePlans = $this->findUserActivePlans($userId);
        $totalInvested = $activePlans->sum('amount');
        $totalProfit = $activePlans->sum('profit_earned');

        return [
            'active_plans_count' => $activePlans->count(),
            'total_invested' => $totalInvested,
            'total_profit_earned' => $totalProfit,
            'total_portfolio_value' => $totalInvested + $totalProfit
        ];
    }

    /**
     * Update plan status
     */
    public function updatePlanStatus(int $userPlanId, string $status): bool
    {
        try {
            $userPlan = User_plans::find($userPlanId);
            if (!$userPlan) {
                return false;
            }

            $userPlan->active = $status;
            return $userPlan->save();
        } catch (\Exception $e) {
            Log::error('Failed to update plan status', [
                'user_plan_id' => $userPlanId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get expired plans
     */
    public function getExpiredPlans(): Collection
    {
        return User_plans::where('active', 'yes')
                        ->where('expire_date', '<', now())
                        ->with(['user', 'dplan'])
                        ->get();
    }

    /**
     * Process plan expiration
     */
    public function processExpiredPlans(): int
    {
        return DB::transaction(function () {
            $expiredPlans = $this->getExpiredPlans();
            $processedCount = 0;

            foreach ($expiredPlans as $userPlan) {
                try {
                    // Mark plan as inactive
                    $userPlan->active = 'no';
                    $userPlan->save();

                    // Return capital to user balance
                    if ($userPlan->user) {
                        $userPlan->user->account_bal += $userPlan->amount;
                        $userPlan->user->save();
                    }

                    $processedCount++;
                } catch (\Exception $e) {
                    Log::error('Failed to process expired plan', [
                        'user_plan_id' => $userPlan->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return $processedCount;
        });
    }
}