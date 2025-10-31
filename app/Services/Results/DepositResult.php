<?php

namespace App\Services\Results;

class DepositResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?\App\Models\Deposit $deposit = null,
        public readonly ?string $errorMessage = null,
        public readonly ?CommissionResult $commission = null
    ) {}
}