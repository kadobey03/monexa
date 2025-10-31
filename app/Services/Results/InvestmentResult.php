<?php

namespace App\Services\Results;

class InvestmentResult extends ServiceResult
{
    public function __construct(
        public readonly ?\App\Models\User_plans $userPlan = null,
        bool $success = true,
        string $message = '',
        ?string $errorMessage = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        parent::__construct($success, $errorMessage ?? $message, $userPlan, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful investment result
     */
    public static function successInvestment(\App\Models\User_plans $userPlan, string $message = ''): self
    {
        return new self($userPlan, true, $message);
    }

    /**
     * Create failed investment result
     */
    public static function failureInvestment(string $errorMessage, array $errors = [], ?string $errorCode = null): self
    {
        return new self(null, false, '', $errorMessage, $errors, $errorCode);
    }
}