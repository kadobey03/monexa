<?php

namespace App\Contracts\Repositories;

use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Collection;

interface WithdrawalRepositoryInterface
{
    /**
     * Create new withdrawal
     */
    public function create(array $withdrawalData): Withdrawal;

    /**
     * Find pending withdrawals
     */
    public function findPendingWithdrawals(): Collection;

    /**
     * Find withdrawal by ID
     */
    public function findById(int $withdrawalId): ?Withdrawal;

    /**
     * Update withdrawal status
     */
    public function updateStatus(int $withdrawalId, string $status): bool;

    /**
     * Get user withdrawal history
     */
    public function getUserWithdrawalHistory(int $userId): Collection;

    /**
     * Process withdrawal with transaction
     */
    public function processWithdrawal(array $withdrawalData): Withdrawal;

    /**
     * Get withdrawals by status
     */
    public function getWithdrawalsByStatus(string $status): Collection;

    /**
     * Get total withdrawal amount for user
     */
    public function getTotalWithdrawalAmount(int $userId): float;

    /**
     * Get withdrawals within date range
     */
    public function getWithdrawalsByDateRange(int $userId, string $startDate, string $endDate): Collection;

    /**
     * Check if user can withdraw amount
     */
    public function canWithdraw(int $userId, float $amount): bool;
}