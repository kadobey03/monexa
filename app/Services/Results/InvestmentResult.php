<?php

namespace App\Services\Results;

class InvestmentResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?\App\Models\User_plans $userPlan = null,
        public readonly ?string $errorMessage = null
    ) {}
}