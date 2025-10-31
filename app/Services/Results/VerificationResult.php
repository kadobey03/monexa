<?php

namespace App\Services\Results;

class VerificationResult extends ServiceResult
{
    public function __construct(
        bool $success = true,
        string $message = '',
        ?string $errorDetails = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($success, $errorDetails ?? $message, null, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful verification result
     */
    public static function successVerification(string $message = ''): self
    {
        return new self(true, $message);
    }

    /**
     * Create failed verification result
     */
    public static function failureVerification(string $errorDetails, array $errors = [], ?string $errorCode = null): self
    {
        return new self(false, '', $errorDetails, $errors, $errorCode);
    }
}