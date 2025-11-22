<?php

namespace App\Services;

use App\Contracts\Repositories\PlanRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\Plans;
use App\Models\User_plans;
use App\Services\Results\InvestmentResult;
use App\Services\Results\ReturnResult;
use App\Services\Results\CompletionResult;
use App\Exceptions\Business\PlanException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlanService
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private UserRepositoryInterface $userRepository,
        private NotificationService $notificationService
    ) {}

    /**
     * Invest in a plan
     */
    public function investInPlan(User $user, Plans $plan, float $amount): InvestmentResult
    {
        try {
            return DB::transaction(function () use ($user, $plan, $amount) {
                // Validate investment eligibility
                $this->validatePlanEligibility($user, $plan, $amount);

                // Check sufficient balance
                if ($user->account_bal < $amount) {
                    throw new PlanException('Insufficient balance for investment');
                }

                // Create user plan
                $userPlanData = [
                    'user' => $user->id,
                    'plan' => $plan->id,
                    'amount' => $amount,
                    'active' => 'yes',
                    'activated_at' => now(),
                    'expire_date' => $this->calculateExpiryDate($plan),
                    'profit_earned' => 0,
                ];

                $userPlan = $this->planRepository->createUserPlan($userPlanData);

                // Deduct from user balance
                $this->userRepository->updateBalance($user->id, $amount, 'subtract');

                // Send notifications
                $this->notificationService->sendPlanInvestmentNotification($userPlan);

                Log::info('Investment in plan completed', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'amount' => $amount
                ]);

                return new InvestmentResult(true, $userPlan, null);
            });
        } catch (PlanException $e) {
            Log::warning('Plan investment failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);
            return new InvestmentResult(false, null, $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Unexpected error during plan investment', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage()
            ]);
            return new InvestmentResult(false, null, 'Investment failed');
        }
    }

    /**
     * Calculate plan returns
     */
    public function calculatePlanReturns(User_plans $userPlan): ReturnResult
    {
        try {
            $plan = $userPlan->dplan;

            if (!$plan) {
                throw new PlanException('Plan not found');
            }

            $returns = 0;
            $daysActive = now()->diffInDays($userPlan->activated_at);

            // Calculate returns based on plan type
            if ($plan->type === 'fixed') {
                $returns = $this->calculateFixedReturns($userPlan, $plan, $daysActive);
            } elseif ($plan->type === 'percentage') {
                $returns = $this->calculatePercentageReturns($userPlan, $plan, $daysActive);
            }

            return new ReturnResult(true, $returns, $daysActive, null);
        } catch (PlanException $e) {
            return new ReturnResult(false, 0, 0, $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error calculating plan returns', [
                'user_plan_id' => $userPlan->id,
                'error' => $e->getMessage()
            ]);
            return new ReturnResult(false, 0, 0, 'Return calculation failed');
        }
    }

    /**
     * Validate plan eligibility
     */
    public function validatePlanEligibility(User $user, Plans $plan): bool
    {
        try {
            // Check if plan is active
            if ($plan->active !== 'yes') {
                throw new PlanException('Plan is not active');
            }

            // Check user status - sadece converted lead'ler (customer'lar) yatırım yapabilir
            if ($user->lead_status !== 'converted') {
                throw new PlanException('User must be a converted customer to invest');
            }

            return true;
        } catch (PlanException $e) {
            return false;
        }
    }

    /**
     * Process plan completion
     */
    public function processPlanCompletion(User_plans $userPlan): CompletionResult
    {
        try {
            return DB::transaction(function () use ($userPlan) {
                // Mark plan as completed
                $userPlan->active = 'no';
                $userPlan->save();

                // Calculate final returns
                $returnResult = $this->calculatePlanReturns($userPlan);

                if ($returnResult->success) {
                    // Add returns to user balance
                    $this->userRepository->updateBalance($userPlan->user, $returnResult->totalReturns, 'add');

                    // Return capital
                    $this->userRepository->updateBalance($userPlan->user, $userPlan->amount, 'add');
                }

                // Send completion notification
                $this->notificationService->sendPlanCompletionNotification($userPlan);

                Log::info('Plan completion processed', [
                    'user_plan_id' => $userPlan->id,
                    'returns' => $returnResult->totalReturns
                ]);

                return new CompletionResult(true, $returnResult->totalReturns, null);
            });
        } catch (\Exception $e) {
            Log::error('Plan completion failed', [
                'user_plan_id' => $userPlan->id,
                'error' => $e->getMessage()
            ]);
            return new CompletionResult(false, 0, 'Completion processing failed');
        }
    }

    /**
     * Calculate fixed returns
     */
    private function calculateFixedReturns(User_plans $userPlan, Plans $plan, int $daysActive): float
    {
        // Simple interest calculation: amount * rate * time
        return $userPlan->amount * ($plan->interest / 100) * ($daysActive / 365);
    }

    /**
     * Calculate percentage returns
     */
    private function calculatePercentageReturns(User_plans $userPlan, Plans $plan, int $daysActive): float
    {
        // Compound interest calculation
        $rate = $plan->interest / 100;
        $periods = $daysActive / 30; // Monthly compounding

        return $userPlan->amount * (pow(1 + $rate, $periods) - 1);
    }

    /**
     * Calculate plan expiry date
     */
    private function calculateExpiryDate(Plans $plan): \Carbon\Carbon
    {
        return now()->addDays($plan->duration ?? 30);
    }
}