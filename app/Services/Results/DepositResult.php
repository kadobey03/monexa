<?php

namespace App\Services\Results;

class DepositResult extends ServiceResult
{
    public function __construct(
        public readonly ?\App\Models\Deposit $deposit = null,
        public readonly ?CommissionResult $commission = null,
        bool $success = true,
        string $message = '',
        ?string $errorMessage = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($success, $errorMessage ?? $message, $deposit, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful deposit result
     */
    public static function successDeposit(\App\Models\Deposit $deposit, ?CommissionResult $commission = null, string $message = ''): self
    {
        return new self($deposit, $commission, true, $message);
    }

    /**
     * Create failed deposit result
     */
    public static function failureDeposit(string $errorMessage, array $errors = [], ?string $errorCode = null): self
    {
        return new self(null, null, false, '', $errorMessage, $errors, $errorCode);
    }
}