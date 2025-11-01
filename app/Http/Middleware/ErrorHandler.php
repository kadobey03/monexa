<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\FinancialException;
use App\Exceptions\ApiException;
use App\Exceptions\KycException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Services\ErrorResponseFormatter;
use App\Services\ErrorLogger;

class ErrorHandler
{
    public function __construct(
        private ErrorResponseFormatter $errorFormatter,
        private ErrorLogger $errorLogger
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $response = $next($request);
            
            // Check for HTTP error status codes
            if ($response->getStatusCode() >= 400) {
                if ($response->getStatusCode() === 404) {
                    throw new NotFoundHttpException('Resource not found');
                }
                
                if ($response->getStatusCode() === 403) {
                    throw new AccessDeniedHttpException('Access denied');
                }
            }
            
            return $response;
        } catch (FinancialException $e) {
            return $this->handleCustomException($e, $request);
        } catch (ApiException $e) {
            return $this->handleCustomException($e, $request);
        } catch (KycException $e) {
            return $this->handleCustomException($e, $request);
        } catch (NotFoundHttpException $e) {
            return $this->handleNotFound($request);
        } catch (AccessDeniedHttpException $e) {
            return $this->handleAccessDenied($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->handleValidationError($e, $request);
        } catch (\Exception $e) {
            return $this->handleGenericError($e, $request);
        }
    }

    /**
     * Handle custom exceptions
     */
    protected function handleCustomException($exception, Request $request)
    {
        // Log the exception
        $this->errorLogger->logError($exception);

        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->errorFormatter->createJsonResponse($exception, $request->getLocale());
        }

        // For web requests, you might want to redirect or show custom error pages
        if ($exception instanceof FinancialException) {
            return redirect()->back()
                ->withErrors(['financial_error' => $exception->getMessage()])
                ->withInput();
        }

        if ($exception instanceof KycException) {
            return redirect()->route('user.verify')
                ->withErrors(['kyc_error' => $exception->getMessage()]);
        }

        // Default handling
        if ($exception instanceof \Throwable) {
            throw $exception;
        }
    }

    /**
     * Handle 404 errors
     */
    protected function handleNotFound(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'error_code' => 'RESOURCE_NOT_FOUND',
            ], 404);
        }

        return response()->view('errors.404', [], 404);
    }

    /**
     * Handle access denied errors
     */
    protected function handleAccessDenied(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
                'error_code' => 'ACCESS_DENIED',
            ], 403);
        }

        return response()->view('errors.403', [], 403);
    }

    /**
     * Handle validation errors
     */
    protected function handleValidationError(\Illuminate\Validation\ValidationException $e, Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'error_code' => 'VALIDATION_FAILED',
                'errors' => $e->errors(),
            ], 422);
        }

        throw $e;
    }

    /**
     * Handle generic errors
     */
    protected function handleGenericError(\Exception $e, Request $request)
    {
        // Log the error
        $this->errorLogger->logError($e);

        if ($request->expectsJson() || $request->is('api/*')) {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            
            return response()->json([
                'success' => false,
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred',
                'error_code' => 'INTERNAL_ERROR',
            ], $statusCode);
        }

        throw $e;
    }
}