<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Throwable;

class ErrorLogger
{
    public function logError(
        Throwable $exception,
        string $level = 'error',
        array $context = []
    ): void {
        $logData = [
            'timestamp' => now()->toISOString(),
            'level' => $level,
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'request_id' => $this->getRequestId(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
            'user' => $this->getCurrentUser(),
            'session_id' => session()->getId(),
            'route' => request()->route()?->getName(),
            'controller' => request()->route()?->getActionName(),
            'context' => $context,
            'query_params' => request()->query(),
            'request_params' => request()->except(['password', 'password_confirmation']),
            'headers' => $this->sanitizeHeaders(),
        ];

        // Log financial errors separately
        if ($exception instanceof \App\Exceptions\FinancialException) {
            $this->logFinancialError($exception, $logData);
            return;
        }

        // Log API errors separately
        if ($exception instanceof \App\Exceptions\ApiException) {
            $this->logApiError($exception, $logData);
            return;
        }

        // Log general errors
        Log::channel('stack')->log($level, $exception->getMessage(), $logData);

        // Send alerts for critical errors
        if (in_array($level, ['critical', 'emergency'])) {
            $this->sendCriticalErrorAlert($exception, $logData);
        }
    }

    public function logFinancialError(\App\Exceptions\FinancialException $exception, array $logData): void
    {
        $logData['financial_details'] = [
            'context' => $exception->getContext(),
            'details' => $exception->getDetails(),
            'category' => $this->getFinancialCategory($exception),
        ];

        Log::channel('financial_errors')->error($exception->getMessage(), $logData);

        // Alert for financial errors
        if ($exception->getCode() >= 500) {
            $this->sendFinancialAlert($exception, $logData);
        }
    }

    public function logApiError(\App\Exceptions\ApiException $exception, array $logData): void
    {
        $logData['api_details'] = [
            'status_code' => $exception->getStatusCode(),
            'errors' => $exception->getErrors(),
            'category' => $this->getApiCategory($exception),
        ];

        Log::channel('api_errors')->error($exception->getMessage(), $logData);

        // Alert for critical API errors
        if (in_array($exception->getStatusCode(), [500, 502, 503, 504])) {
            $this->sendCriticalErrorAlert($exception, $logData);
        }
    }

    public function logKycError(\App\Exceptions\KycException $exception, array $logData): void
    {
        $logData['kyc_details'] = [
            'status' => $exception->getKycStatus(),
            'required_steps' => $exception->getRequiredSteps(),
        ];

        Log::channel('kyc_errors')->warning($exception->getMessage(), $logData);
    }

    private function getCurrentUser(): ?array
    {
        if (Auth::check()) {
            $user = Auth::user();
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role ?? 'user',
                'is_admin' => $user->is_admin ?? false,
            ];
        }

        return null;
    }

    private function getRequestId(): string
    {
        return request()->header('X-Request-ID') ?? uniqid('req_', true);
    }

    private function sanitizeHeaders(): array
    {
        $headers = request()->headers->all();
        $sensitive = ['authorization', 'cookie', 'x-api-key', 'x-auth-token'];

        foreach ($sensitive as $key) {
            if (isset($headers[$key])) {
                $headers[$key] = '[REDACTED]';
            }
        }

        return $headers;
    }

    private function getFinancialCategory(\App\Exceptions\FinancialException $exception): string
    {
        $message = $exception->getMessage();

        if (str_contains($message, 'Yetersiz bakiye')) {
            return 'insufficient_balance';
        }

        if (str_contains($message, 'Geçersiz')) {
            return 'invalid_amount';
        }

        if (str_contains($message, 'başarısız')) {
            return 'transaction_failed';
        }

        if (str_contains($message, 'Limit')) {
            return 'limit_exceeded';
        }

        return 'financial_operation';
    }

    private function getApiCategory(\App\Exceptions\ApiException $exception): string
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

    private function sendCriticalErrorAlert(Throwable $exception, array $logData): void
    {
        // Here you can implement email notifications, Slack alerts, etc.
        Log::channel('alerts')->critical('Critical error occurred', [
            'exception' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'user' => $logData['user'],
            'url' => $logData['url'],
        ]);
    }

    private function sendFinancialAlert(\App\Exceptions\FinancialException $exception, array $logData): void
    {
        // Financial error specific alerts
        Log::channel('financial_alerts')->critical('Financial error occurred', [
            'exception' => $exception->getMessage(),
            'context' => $exception->getContext(),
            'user' => $logData['user'],
        ]);
    }

    public function logSecurityEvent(string $event, array $data = []): void
    {
        Log::channel('security')->warning($event, [
            'timestamp' => now()->toISOString(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user' => $this->getCurrentUser(),
            'url' => request()->fullUrl(),
            'data' => $data,
        ]);
    }

    public function logAuditEvent(string $action, array $data = []): void
    {
        Log::channel('audit')->info($action, [
            'timestamp' => now()->toISOString(),
            'user' => $this->getCurrentUser(),
            'action' => $action,
            'data' => $data,
        ]);
    }
}