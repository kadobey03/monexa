<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Services\ErrorResponseFormatter;
use App\Services\ErrorLogger;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $errorFormatter;
    protected $errorLogger;

    public function __construct(ErrorResponseFormatter $errorFormatter, ErrorLogger $errorLogger)
    {
        $this->errorFormatter = $errorFormatter;
        $this->errorLogger = $errorLogger;
        parent::__construct();
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Log all errors
            $this->errorLogger->logError($e);
        });

        // Report critical errors
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                $this->errorLogger->logError($e, 'critical');
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Log the error before rendering
        $this->errorLogger->logError($exception);

        // Handle API requests with JSON responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderApiError($request, $exception);
        }

        // Handle web requests with custom error pages
        if ($request->wantsJson()) {
            return $this->renderApiError($request, $exception);
        }

        // Handle web requests
        $response = parent::render($request, $exception);
        
        // Add settings to error views to prevent undefined variable errors
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 600) {
            try {
                $settings = Settings::where('id', 1)->first();
                if ($settings) {
                    // For custom error pages, include settings
                    if (view()->exists('errors.' . $response->getStatusCode())) {
                        return response()->view('errors.' . $response->getStatusCode(), [
                            'settings' => $settings
                        ], $response->getStatusCode());
                    }
                }
            } catch (\Exception $e) {
                // Fallback - don't break error handling
            }
        }
        
        return $response;
    }

    /**
     * Render API errors as JSON responses
     */
    protected function renderApiError(Request $request, Throwable $exception)
    {
        $locale = $request->header('Accept-Language', 'tr');
        
        return $this->errorFormatter->createJsonResponse($exception, $locale);
    }

    /**
     * Report an exception.
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            // Enhanced logging for different exception types
            if ($exception instanceof \App\Exceptions\FinancialException) {
                $this->errorLogger->logFinancialError($exception, []);
            } elseif ($exception instanceof \App\Exceptions\KycException) {
                $this->errorLogger->logKycError($exception, []);
            } elseif ($exception instanceof \App\Exceptions\ApiException) {
                $this->errorLogger->logApiError($exception, []);
            } else {
                $this->errorLogger->logError($exception);
            }
        }

        parent::report($exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     */
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
                'error_code' => 'UNAUTHENTICATED',
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Convert an authorization exception into an unauthorized response.
     */
    protected function unauthorized($request, \Illuminate\Auth\Access\AuthorizationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient permissions',
                'error_code' => 'INSUFFICIENT_PERMISSIONS',
            ], 403);
        }

        return response()->view('errors.403', [], 403);
    }

    /**
     * Convert a validation exception into a JSON response.
     */
    protected function invalidJson($request, \Illuminate\Validation\ValidationException $exception)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'error_code' => 'VALIDATION_FAILED',
            'errors' => $exception->errors(),
        ], 422);
    }
}