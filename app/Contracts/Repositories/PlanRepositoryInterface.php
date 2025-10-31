<?php

namespace App\Contracts\Repositories;

use App\Models\UserPlan;
use App\Models\Plans;
use Illuminate\Database\Eloquent\Collection;

interface PlanRepositoryInterface
{
    /**
     * Get active plans
     */
    public function getActivePlans(): Collection;

    /**
     * Find user active plans
     */
    public function findUserActivePlans(int $userId): Collection;

    /**
     * Create user plan
     */
    public function createUserPlan(array $planData): User_plans;

    /**
     * Find plan by ID
     */
    public function findById(int $planId): ?Plans;

    /**
     * Get plans by category
     */
    public function getPlansByCategory(int $categoryId): Collection;

    /**
     * Get plan with details
     */
    public function getPlanWithDetails(int $planId): ?Plans;

    /**
     * Check if user can invest in plan
     */
    public function canUserInvestInPlan(int $userId, int $planId, float $amount): bool;

    /**
     * Get user plan statistics
     */
    public function getUserPlanStatistics(int $userId): array;

    /**
     * Update plan status
     */
    public function updatePlanStatus(int $userPlanId, string $status): bool;
}