<?php

namespace App\Services\Results;

class ChargeResult
{
    public function __construct(
        public readonly float $totalCharges,
        public readonly string $chargeType,
        public readonly float $chargeAmount
    ) {}
}