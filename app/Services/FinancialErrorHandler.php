<?php

namespace App\Services;

use App\Exceptions\FinancialException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class FinancialErrorHandler
{
    public function __construct(
        private ErrorLogger $errorLogger,
        private ErrorResponseFormatter $errorFormatter
    ) {}

    /**
     * Execute financial operation with comprehensive error handling
     */
    public function executeWithErrorHandling(
        callable $operation,
        User $user,
        string $operationType,
        array $context = []
    ) {
        $transaction = null;
        
        try {
            // Start database transaction
            DB::beginTransaction();
            
            // Log financial operation start
            $this->logFinancialOperationStart($user, $operationType, $context);
            
            // Execute the operation
            $result = $operation();
            
            // Verify balance integrity
            $this->verifyBalanceIntegrity($user);
            
            // Commit transaction
            DB::commit();
            
            // Log successful operation
            $this->logFinancialOperationSuccess($user, $operationType, $result);
            
            return $result;
            
        } catch (FinancialException $e) {
            DB::rollBack();
            $this->handleFinancialException($e, $user, $operationType, $context);
            throw $e;
            
        } catch (\PDOException $e) {
            DB::rollBack();
            $this->handleDatabaseError($e, $user, $operationType, $context);
            throw FinancialException::transactionFailed($operationType, 'Database error occurred');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->handleUnexpectedError($e, $user, $operationType, $context);
            throw FinancialException::transactionFailed($operationType, $e->getMessage());
        }
    }

    /**
     * Check user balance with error handling
     */
    public function verifyBalance(User $user, float $requiredAmount, string $operationType): void
    {
        $balance = $user->balance ?? 0;
        
        if ($balance < $requiredAmount) {
            throw FinancialException::insufficientBalance($balance, $requiredAmount);
        }
        
        // Log balance verification
        Log::channel('financial_audit')->info('Balance verification', [
            'user_id' => $user->id,
            'operation' => $operationType,
            'required_amount' => $requiredAmount,
            'current_balance' => $balance,
            'sufficient' => $balance >= $requiredAmount,
            'timestamp' => now(),
        ]);
    }

    /**
     * Validate transaction amount
     */
    public function validateAmount(float $amount, string $operationType): void
    {
        if ($amount <= 0) {
            throw FinancialException::invalidAmount($amount, 'Amount must be positive');
        }
        
        if ($amount < config('financial.min_transaction_amount', 0.01)) {
            throw FinancialException::invalidAmount(
                $amount, 
                'Amount below minimum threshold'
            );
        }
        
        if ($amount > config('financial.max_transaction_amount', 1000000)) {
            throw FinancialException::invalidAmount(
                $amount,
                'Amount exceeds maximum limit'
            );
        }
        
        // Check daily limits
        $this->checkDailyLimits(auth()->user(), $amount, $operationType);
    }

    /**
     * Handle financial exception with specialized logging
     */
    private function handleFinancialException(
        FinancialException $exception,
        User $user,
        string $operationType,
        array $context
    ): void {
        $logData = [
            'user_id' => $user->id,
            'operation_type' => $operationType,
            'context' => $context,
            'exception_details' => [
                'message' => $exception->getMessage(),
                'context' => $exception->getContext(),
                'details' => $exception->getDetails(),
                'code' => $exception->getCode(),
            ],
            'user_balance' => $user->balance,
            'timestamp' => now(),
        ];
        
        // Log based on exception type
        if (str_contains($exception->getMessage(), 'Yetersiz bakiye')) {
            Log::channel('financial_errors')->warning('Insufficient balance', $logData);
        } elseif (str_contains($exception->getMessage(), 'Limit')) {
            Log::channel('financial_errors')->warning('Transaction limit exceeded', $logData);
        } else {
            Log::channel('financial_errors')->error('Financial operation failed', $logData);
        }
        
        // Send alert for critical financial errors
        if ($exception->getCode() >= 500) {
            $this->sendFinancialAlert($user, $operationType, $exception, $logData);
        }
    }

    /**
     * Handle database errors in financial operations
     */
    private function handleDatabaseError(
        \PDOException $exception,
        User $user,
        string $operationType,
        array $context
    ): void {
        Log::channel('financial_errors')->critical('Database error in financial operation', [
            'user_id' => $user->id,
            'operation_type' => $operationType,
            'context' => $context,
            'error_code' => $exception->getCode(),
            'error_message' => $exception->getMessage(),
            'timestamp' => now(),
        ]);
        
        $this->sendFinancialAlert($user, $operationType, $exception, [
            'error_type' => 'database',
            'error_code' => $exception->getCode(),
        ]);
    }

    /**
     * Handle unexpected errors in financial operations
     */
    private function handleUnexpectedError(
        \Exception $exception,
        User $user,
        string $operationType,
        array $context
    ): void {
        Log::channel('financial_errors')->critical('Unexpected error in financial operation', [
            'user_id' => $user->id,
            'operation_type' => $operationType,
            'context' => $context,
            'exception_class' => get_class($exception),
            'exception_message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'timestamp' => now(),
        ]);
        
        $this->sendFinancialAlert($user, $operationType, $exception, [
            'error_type' => 'unexpected',
            'exception_class' => get_class($exception),
        ]);
    }

    /**
     * Verify balance integrity after transaction
     */
    private function verifyBalanceIntegrity(User $user): void
    {
        $expectedBalance = $user->getOriginal('balance');
        $currentBalance = $user->balance;
        
        if ($expectedBalance !== $currentBalance) {
            Log::channel('financial_errors')->critical('Balance integrity check failed', [
                'user_id' => $user->id,
                'expected_balance' => $expectedBalance,
                'current_balance' => $currentBalance,
                'difference' => $currentBalance - $expectedBalance,
                'timestamp' => now(),
            ]);
            
            // This is a critical error that should trigger immediate investigation
            throw new \Exception('Balance integrity verification failed');
        }
    }

    /**
     * Check daily transaction limits
     */
    private function checkDailyLimits(User $user, float $amount, string $operationType): void
    {
        $today = now()->startOfDay();
        $todayTransactions = \DB::table('transactions')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', $today)
            ->where('type', $operationType)
            ->sum('amount');
            
        $dailyLimit = $this->getDailyLimit($user, $operationType);
        
        if ($todayTransactions + $amount > $dailyLimit) {
            throw FinancialException::limitExceeded($operationType, $dailyLimit);
        }
    }

    /**
     * Get daily transaction limit for user
     */
    private function getDailyLimit(User $user, string $operationType): float
    {
        // This would typically come from user settings or business rules
        return match($operationType) {
            'withdrawal' => config('financial.daily_withdrawal_limit', 10000),
            'transfer' => config('financial.daily_transfer_limit', 50000),
            'investment' => config('financial.daily_investment_limit', 100000),
            default => config('financial.daily_limit', 50000),
        };
    }

    /**
     * Log financial operation start
     */
    private function logFinancialOperationStart(User $user, string $operationType, array $context): void
    {
        Log::channel('financial_audit')->info('Financial operation started', [
            'user_id' => $user->id,
            'operation_type' => $operationType,
            'context' => $context,
            'user_balance' => $user->balance,
            'timestamp' => now(),
        ]);
    }

    /**
     * Log successful financial operation
     */
    private function logFinancialOperationSuccess(User $user, string $operationType, $result): void
    {
        Log::channel('financial_audit')->info('Financial operation completed', [
            'user_id' => $user->id,
            'operation_type' => $operationType,
            'result' => $result,
            'user_balance' => $user->balance,
            'timestamp' => now(),
        ]);
    }

    /**
     * Send financial error alert
     */
    private function sendFinancialAlert(User $user, string $operationType, Throwable $exception, array $additionalData): void
    {
        // This would integrate with your alert system (email, Slack, etc.)
        Log::channel('financial_alerts')->critical('Financial error alert', array_merge([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'operation_type' => $operationType,
            'exception_message' => $exception->getMessage(),
            'alert_type' => 'financial_error',
        ], $additionalData));
    }

    /**
     * Create retry mechanism for financial operations
     */
    public function createRetryableOperation(callable $operation, int $maxAttempts = 3): callable
    {
        return function() use ($operation, $maxAttempts) {
            $attempts = 0;
            $lastException = null;
            
            while ($attempts < $maxAttempts) {
                try {
                    return $operation();
                } catch (\Exception $e) {
                    $lastException = $e;
                    $attempts++;
                    
                    if ($attempts >= $maxAttempts) {
                        throw $lastException;
                    }
                    
                    // Exponential backoff
                    $delay = pow(2, $attempts) * 1000; // milliseconds
                    sleep($delay / 1000);
                }
            }
            
            throw $lastException;
        };
    }
}