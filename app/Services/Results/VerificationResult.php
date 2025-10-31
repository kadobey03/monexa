<?php

namespace App\Services\Results;

class VerificationResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly ?string $errorDetails = null
    ) {}
}