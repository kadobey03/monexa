<?php

namespace App\Services\Results;

class CompletionResult
{
    public function __construct(
        public readonly bool $success,
        public readonly float $finalReturns,
        public readonly ?string $errorMessage = null
    ) {}
}