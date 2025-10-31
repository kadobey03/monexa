<?php

namespace App\Services\Results;

class KycResult
{
    public function __construct(
        public readonly bool $isVerified,
        public readonly string $message,
        public readonly ?string $errorDetails = null
    ) {}
}