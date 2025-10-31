<?php

namespace App\Services\Results;

class CommissionResult
{
    public function __construct(
        public readonly float $totalCommission,
        public readonly float $level1Commission,
        public readonly array $commissionDetails
    ) {}
}