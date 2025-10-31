<?php

namespace App\Services\Results;

class CompletionResult extends ServiceResult
{
    public function __construct(
        public readonly float $finalReturns,
        bool $success = true,
        string $message = '',
        ?string $errorMessage = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($success, $errorMessage ?? $message, $finalReturns, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful completion result
     */
    public static function successCompletion(float $finalReturns, string $message = ''): self
    {
        return new self($finalReturns, true, $message);
    }

    /**
     * Create failed completion result
     */
    public static function failureCompletion(string $errorMessage, array $errors = [], ?string $errorCode = null): self
    {
        return new self(0.0, false, '', $errorMessage, $errors, $errorCode);
    }
}