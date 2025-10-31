<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Services\Results\KycResult;
use App\Services\Results\VerificationResult;
use App\Exceptions\Business\KycException;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Update lead status for user
     */
    public function updateLeadStatus(User $user, string $status): bool
    {
        try {
            $result = $this->userRepository->updateLeadStatus($user->id, $status);

            if ($result) {
                Log::info('Lead status updated', [
                    'user_id' => $user->id,
                    'status' => $status
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to update lead status', [
                'user_id' => $user->id,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Validate KYC for user
     */
    public function validateKyc(User $user): KycResult
    {
        try {
            if ($user->account_verify === 'Verified') {
                return new KycResult(true, 'KYC already verified', null);
            }

            if (empty($user->account_verify) || $user->account_verify === 'Pending') {
                return new KycResult(false, 'KYC verification pending', null);
            }

            return new KycResult(false, 'KYC verification required', null);
        } catch (\Exception $e) {
            Log::error('KYC validation error', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return new KycResult(false, 'KYC validation failed', $e->getMessage());
        }
    }

    /**
     * Calculate lead score
     */
    public function calculateLeadScore(User $user): float
    {
        $score = 0;

        // Base score from registration
        $score += 10;

        // Bonus for email verification
        if ($user->email_verified_at) {
            $score += 20;
        }

        // Bonus for deposits
        $totalDeposits = $this->userRepository->getTotalDepositAmount($user->id);
        if ($totalDeposits > 0) {
            $score += min($totalDeposits / 100, 30); // Max 30 points for deposits
        }

        // Bonus for active plans
        $activePlans = $this->userRepository->getUserDepositHistory($user->id)->count();
        $score += min($activePlans * 5, 20); // Max 20 points for activity

        return round($score, 2);
    }

    /**
     * Process user verification
     */
    public function processUserVerification(User $user, array $documents): VerificationResult
    {
        try {
            // Validate documents
            $validationResult = $this->validateVerificationDocuments($documents);

            if (!$validationResult['valid']) {
                return new VerificationResult(false, $validationResult['message'], null);
            }

            // Update user verification status
            $user->account_verify = 'Verified';
            $user->save();

            Log::info('User verification completed', [
                'user_id' => $user->id
            ]);

            return new VerificationResult(true, 'Verification completed successfully', null);
        } catch (\Exception $e) {
            Log::error('User verification failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return new VerificationResult(false, 'Verification failed', $e->getMessage());
        }
    }

    /**
     * Validate verification documents
     */
    private function validateVerificationDocuments(array $documents): array
    {
        // Basic validation - can be extended
        if (empty($documents)) {
            return ['valid' => false, 'message' => 'No documents provided'];
        }

        // Check for required document types
        $requiredTypes = ['id_card', 'proof_of_address'];
        foreach ($requiredTypes as $type) {
            if (!isset($documents[$type])) {
                return ['valid' => false, 'message' => "Missing required document: {$type}"];
            }
        }

        return ['valid' => true, 'message' => 'Documents validated'];
    }
}