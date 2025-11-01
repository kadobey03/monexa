<?php

namespace App\Exceptions;

use Exception;

class FinancialException extends Exception
{
    protected $code;
    protected $context;
    protected $details;

    public function __construct(
        string $message = 'Financial operation failed',
        int $code = 422,
        array $context = [],
        array $details = [],
        ?Exception $previous = null
    ) {
        $this->code = $code;
        $this->context = $context;
        $this->details = $details;

        parent::__construct($message, $code, $previous);
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public static function insufficientBalance(float $balance, float $required): self
    {
        return new static(
            'Yetersiz bakiye',
            422,
            ['current_balance' => $balance, 'required_amount' => $required],
            [
                'tr' => 'Yetersiz bakiye. Mevcut: {balance}, Gerekli: {required}',
                'en' => 'Insufficient balance. Current: {balance}, Required: {required}'
            ]
        );
    }

    public static function invalidAmount(float $amount, string $reason): self
    {
        return new static(
            'Geçersiz miktar',
            422,
            ['amount' => $amount, 'reason' => $reason],
            [
                'tr' => 'Geçersiz miktar: {reason}',
                'en' => 'Invalid amount: {reason}'
            ]
        );
    }

    public static function transactionFailed(string $operation, string $reason): self
    {
        return new static(
            'İşlem başarısız',
            500,
            ['operation' => $operation],
            [
                'tr' => 'İşlem başarısız oldu: {reason}',
                'en' => 'Transaction failed: {reason}'
            ]
        );
    }

    public static function limitExceeded(string $operation, float $limit): self
    {
        return new static(
            'Limit aşıldı',
            429,
            ['operation' => $operation, 'limit' => $limit],
            [
                'tr' => '{operation} işlemi limit aşıldı: {limit}',
                'en' => '{operation} operation limit exceeded: {limit}'
            ]
        );
    }
}