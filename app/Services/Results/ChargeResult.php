<?php

namespace App\Services\Results;

/**
 * Charge calculation result - not a service result but a data object
 * This doesn't extend ServiceResult as it's a pure data object for charge calculations
 */
class ChargeResult
{
    public function __construct(
        public readonly float $totalCharges,
        public readonly string $chargeType,
        public readonly float $chargeAmount
    ) {}

    /**
     * Get charge details as array
     */
    public function toArray(): array
    {
        return [
            'total_charges' => $this->totalCharges,
            'charge_type' => $this->chargeType,
            'charge_amount' => $this->chargeAmount,
        ];
    }

    /**
     * Get total charges
     */
    public function getTotalCharges(): float
    {
        return $this->totalCharges;
    }

    /**
     * Get charge type
     */
    public function getChargeType(): string
    {
        return $this->chargeType;
    }

    /**
     * Get charge amount
     */
    public function getChargeAmount(): float
    {
        return $this->chargeAmount;
    }
}