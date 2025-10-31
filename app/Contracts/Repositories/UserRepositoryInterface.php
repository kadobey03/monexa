<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user with lead information
     */
    public function findWithLeadInfo(int $userId): ?User;

    /**
     * Update lead status for user
     */
    public function updateLeadStatus(int $userId, string $status): bool;

    /**
     * Get users with pending KYC
     */
    public function getUsersWithPendingKyc(): Collection;

    /**
     * Get user deposit history
     */
    public function getUserDepositHistory(int $userId): Collection;

    /**
     * Get user withdrawal history
     */
    public function getUserWithdrawalHistory(int $userId): Collection;

    /**
     * Get user by ID
     */
    public function findById(int $userId): ?User;

    /**
     * Update user balance
     */
    public function updateBalance(int $userId, float $amount, string $type = 'add'): bool;

    /**
     * Get user referral earnings
     */
    public function getReferralEarnings(int $userId): float;
}