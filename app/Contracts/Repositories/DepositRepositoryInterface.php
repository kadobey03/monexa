<?php

namespace App\Contracts\Repositories;

use App\Models\Deposit;
use Illuminate\Database\Eloquent\Collection;

interface DepositRepositoryInterface
{
    /**
     * Create new deposit
     */
    public function create(array $depositData): Deposit;

    /**
     * Find pending deposits
     */
    public function findPendingDeposits(): Collection;

    /**
     * Find deposit by ID
     */
    public function findById(int $depositId): ?Deposit;

    /**
     * Update deposit status
     */
    public function updateStatus(int $depositId, string $status): bool;

    /**
     * Get user deposit history
     */
    public function getUserDepositHistory(int $userId): Collection;

    /**
     * Process deposit with transaction
     */
    public function processDeposit(array $depositData): Deposit;

    /**
     * Get deposits by status
     */
    public function getDepositsByStatus(string $status): Collection;

    /**
     * Get total deposit amount for user
     */
    public function getTotalDepositAmount(int $userId): float;

    /**
     * Get deposits within date range
     */
    public function getDepositsByDateRange(int $userId, string $startDate, string $endDate): Collection;
}