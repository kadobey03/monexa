<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Exceptions\FinancialException;
use App\Exceptions\ApiException;
use App\Exceptions\KycException;
use Exception;
use Throwable;

class ErrorResponseFormatter
{
    private const SUPPORTED_LANGUAGES = ['tr', 'en'];

    public function formatError(
        Throwable $exception,
        ?string $locale = null,
        bool $debug = false
    ): array {
        $locale = $this->getSupportedLocale($locale);
        
        $response = [
            'success' => false,
            'timestamp' => now()->toISOString(),
            'locale' => $locale,
            'request_id' => $this->getRequestId(),
        ];

        // Add debug information if enabled
        if ($debug) {
            $response['debug'] = [
                'exception_class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        }

        // Handle specific exception types
        if ($exception instanceof FinancialException) {
            return $this->formatFinancialException($exception, $response, $locale);
        }

        if ($exception instanceof ApiException) {
            return $this->formatApiException($exception, $response);
        }

        if ($exception instanceof KycException) {
            return $this->formatKycException($exception, $response, $locale);
        }

        // Default exception handling
        return $this->formatGenericException($exception, $response);
    }

    private function formatFinancialException(FinancialException $exception, array $response, string $locale): array
    {
        $response['error'] = [
            'type' => 'financial',
            'code' => 'FINANCIAL_ERROR',
            'message' => $this->translateMessage($exception->getMessage(), $locale),
            'details' => $exception->getDetails(),
            'context' => $exception->getContext(),
            'category' => $this->getFinancialCategory($exception),
            'recovery_suggestions' => $this->getFinancialRecoverySuggestions($exception),
        ];

        $response['status_code'] = $exception->getCode();

        return $response;
    }

    private function formatApiException(ApiException $exception, array $response): array
    {
        $response['error'] = [
            'type' => 'api',
            'code' => 'API_ERROR',
            'message' => $exception->getMessage(),
            'errors' => $exception->getErrors(),
            'category' => $this->getApiCategory($exception),
        ];

        $response['status_code'] = $exception->getStatusCode();

        return $response;
    }

    private function formatKycException(KycException $exception, array $response, string $locale): array
    {
        $response['error'] = [
            'type' => 'kyc',
            'code' => 'KYC_ERROR',
            'message' => $this->translateMessage($exception->getMessage(), $locale),
            'status' => $exception->getKycStatus(),
            'required_steps' => $exception->getRequiredSteps(),
            'recovery_suggestions' => $this->getKycRecoverySuggestions($exception, $locale),
        ];

        $response['status_code'] = $exception->getCode();

        return $response;
    }

    private function formatGenericException(Throwable $exception, array $response): array
    {
        $response['error'] = [
            'type' => 'generic',
            'code' => 'GENERIC_ERROR',
            'message' => config('app.debug') ? $exception->getMessage() : 'An unexpected error occurred',
            'category' => 'system',
        ];

        $response['status_code'] = $exception->getCode() ?: 500;

        return $response;
    }

    private function getSupportedLocale(?string $locale): string
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }

        return in_array($locale, self::SUPPORTED_LANGUAGES) ? $locale : 'tr';
    }

    private function translateMessage(string $message, string $locale): string
    {
        $translations = [
            'Yetersiz bakiye' => [
                'tr' => 'Yetersiz bakiye',
                'en' => 'Insufficient balance'
            ],
            'Geçersiz miktar' => [
                'tr' => 'Geçersiz miktar',
                'en' => 'Invalid amount'
            ],
            'İşlem başarısız' => [
                'tr' => 'İşlem başarısız',
                'en' => 'Transaction failed'
            ],
            'Limit aşıldı' => [
                'tr' => 'Limit aşıldı',
                'en' => 'Limit exceeded'
            ],
            'KYC doğrulaması gerekli' => [
                'tr' => 'KYC doğrulaması gerekli',
                'en' => 'KYC verification required'
            ],
        ];

        return $translations[$message][$locale] ?? $message;
    }

    private function getFinancialCategory(FinancialException $exception): string
    {
        if (str_contains($exception->getMessage(), 'Yetersiz bakiye')) {
            return 'balance_insufficient';
        }

        if (str_contains($exception->getMessage(), 'Geçersiz')) {
            return 'invalid_input';
        }

        if (str_contains($exception->getMessage(), 'başarısız')) {
            return 'transaction_failed';
        }

        return 'financial_operation';
    }

    private function getFinancialRecoverySuggestions(FinancialException $exception): array
    {
        if (str_contains($exception->getMessage(), 'Yetersiz bakiye')) {
            return [
                'tr' => ['Hesabınıza para yükleyin', 'Daha düşük bir miktar deneyin'],
                'en' => ['Add funds to your account', 'Try a lower amount']
            ];
        }

        return [
            'tr' => ['Tekrar deneyin'],
            'en' => ['Try again']
        ];
    }

    private function getApiCategory(ApiException $exception): string
    {
        $code = $exception->getStatusCode();

        return match ($code) {
            401 => 'authentication',
            403 => 'authorization',
            404 => 'not_found',
            422 => 'validation',
            429 => 'rate_limit',
            500, 502, 503, 504 => 'server_error',
            default => 'general'
        };
    }

    private function getKycRecoverySuggestions(KycException $exception, string $locale): array
    {
        $suggestions = [
            'tr' => ['KYC doğrulamasını tamamlayın', 'Gerekli belgeleri yükleyin'],
            'en' => ['Complete KYC verification', 'Upload required documents']
        ];

        if ($exception->getKycStatus() === 'expired') {
            $suggestions = [
                'tr' => ['Belgelerinizi yenileyin', 'Yeni KYC doğrulaması başlatın'],
                'en' => ['Renew your documents', 'Start new KYC verification']
            ];
        }

        return $suggestions;
    }

    private function getRequestId(): string
    {
        return request()->header('X-Request-ID') ?? uniqid('req_', true);
    }

    public function createJsonResponse(Throwable $exception, ?string $locale = null): JsonResponse
    {
        $formattedError = $this->formatError($exception, $locale, config('app.debug'));

        return response()->json($formattedError, $formattedError['status_code']);
    }
}