<?php

namespace App\Services\Results;

class KycResult extends ServiceResult
{
    public function __construct(
        public readonly bool $isVerified,
        string $message = '',
        ?string $errorDetails = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($isVerified, $errorDetails ?? $message, null, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful KYC verification result
     */
    public static function successKyc(string $message = ''): self
    {
        return new self(true, $message);
    }

    /**
     * Create failed KYC verification result
     */
    public static function failureKyc(string $errorDetails, array $errors = [], ?string $errorCode = null): self
    {
        return new self(false, '', $errorDetails, $errors, $errorCode);
    }
}