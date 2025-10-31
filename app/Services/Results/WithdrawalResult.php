<?php

namespace App\Services\Results;

class WithdrawalResult extends ServiceResult
{
    public function __construct(
        public readonly ?\App\Models\Withdrawal $withdrawal = null,
        public readonly ?ChargeResult $charges = null,
        bool $success = true,
        string $message = '',
        ?string $errorMessage = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($success, $errorMessage ?? $message, $withdrawal, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful withdrawal result
     */
    public static function successWithdrawal(\App\Models\Withdrawal $withdrawal, ?ChargeResult $charges = null, string $message = ''): self
    {
        return new self($withdrawal, $charges, true, $message);
    }

    /**
     * Create failed withdrawal result
     */
    public static function failureWithdrawal(string $errorMessage, array $errors = [], ?string $errorCode = null): self
    {
        return new self(null, null, false, '', $errorMessage, $errors, $errorCode);
    }
}