<?php

namespace App\Services\Results;

/**
 * Commission calculation result - not a service result but a data object
 * This doesn't extend ServiceResult as it's a pure data object for commission calculations
 */
class CommissionResult
{
    public function __construct(
        public readonly float $totalCommission,
        public readonly float $level1Commission,
        public readonly array $commissionDetails
    ) {}

    /**
     * Get commission details as array
     */
    public function toArray(): array
    {
        return [
            'total_commission' => $this->totalCommission,
            'level1_commission' => $this->level1Commission,
            'commission_details' => $this->commissionDetails,
        ];
    }

    /**
     * Get total commission
     */
    public function getTotalCommission(): float
    {
        return $this->totalCommission;
    }

    /**
     * Get level 1 commission
     */
    public function getLevel1Commission(): float
    {
        return $this->level1Commission;
    }

    /**
     * Get commission details
     */
    public function getCommissionDetails(): array
    {
        return $this->commissionDetails;
    }
}