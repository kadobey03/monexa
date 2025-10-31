<?php

namespace App\Services\Results;

class ReturnResult
{
    public function __construct(
        public readonly bool $success,
        public readonly float $totalReturns,
        public readonly int $daysActive,
        public readonly ?string $errorMessage = null
    ) {}
}