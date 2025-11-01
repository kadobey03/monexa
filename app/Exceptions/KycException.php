<?php

namespace App\Exceptions;

use Exception;

class KycException extends Exception
{
    protected $kycStatus;
    protected $requiredSteps;

    public function __construct(
        string $message = 'KYC verification required',
        string $kycStatus = 'pending',
        array $requiredSteps = [],
        int $code = 403,
        ?Exception $previous = null
    ) {
        $this->kycStatus = $kycStatus;
        $this->requiredSteps = $requiredSteps;

        parent::__construct($message, $code, $previous);
    }

    public function getKycStatus(): string
    {
        return $this->kycStatus;
    }

    public function getRequiredSteps(): array
    {
        return $this->requiredSteps;
    }

    public static function verificationRequired(): self
    {
        return new static(
            'KYC doğrulaması gerekli',
            'pending',
            ['identity_verification', 'document_upload']
        );
    }

    public static function documentExpired(): self
    {
        return new static(
            'Dokümanların süresi dolmuş',
            'expired',
            ['document_reupload']
        );
    }

    public static function verificationFailed(string $reason): self
    {
        return new static(
            'KYC doğrulaması başarısız: ' . $reason,
            'failed',
            ['reapply']
        );
    }
}