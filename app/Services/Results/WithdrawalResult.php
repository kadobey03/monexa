<?php

namespace App\Services\Results;

class WithdrawalResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?\App\Models\Withdrawal $withdrawal = null,
        public readonly ?string $errorMessage = null,
        public readonly ?ChargeResult $charges = null
    ) {}
}