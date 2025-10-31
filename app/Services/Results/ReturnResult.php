<?php

namespace App\Services\Results;

class ReturnResult extends ServiceResult
{
    public function __construct(
        public readonly float $totalReturns,
        public readonly int $daysActive,
        bool $success = true,
        string $message = '',
        ?string $errorMessage = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        $data = [
            'total_returns' => $totalReturns,
            'days_active' => $daysActive,
        ];

        parent::__construct($success, $errorMessage ?? $message, $data, $errors, $errorCode, $metadata);
    }

    /**
     * Create successful return result
     */
    public static function successReturn(float $totalReturns, int $daysActive, string $message = ''): self
    {
        return new self($totalReturns, $daysActive, true, $message);
    }

    /**
     * Create failed return result
     */
    public static function failureReturn(string $errorMessage, array $errors = [], ?string $errorCode = null): self
    {
        return new self(0.0, 0, false, '', $errorMessage, $errors, $errorCode);
    }

    /**
     * Get total returns
     */
    public function getTotalReturns(): float
    {
        return $this->totalReturns;
    }

    /**
     * Get days active
     */
    public function getDaysActive(): int
    {
        return $this->daysActive;
    }
}