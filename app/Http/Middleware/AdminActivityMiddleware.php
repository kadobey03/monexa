<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AdminActivityMiddleware
{
    /**
     * Sensitive operations that require detailed logging.
     */
    protected $sensitiveOperations = [
        'DELETE',
        'admin/admins/*/delete',
        'admin/users/*/delete',
        'admin/roles/*/delete',
        'admin/permissions/*',
        'admin/bulk/*',
        'admin/export/*',
        'admin/import/*',
        'admin/settings/*',
        'admin/system/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Admin guard kontrolü
        if (!Auth::guard('admin')->check()) {
            return $next($request);
        }

        $admin = Auth::guard('admin')->user();

        // Pre-request logging
        $this->logPreRequest($admin, $request);

        // Session tracking
        $this->trackSession($admin, $request);

        // Rate limiting check
        if (!$this->checkRateLimit($admin, $request)) {
            return $this->rateLimitExceeded($request);
        }

        // Execute request
        $response = $next($request);

        // Post-request logging
        $endTime = microtime(true);
        $this->logPostRequest($admin, $request, $response, $endTime - $startTime);

        // Performance metrics collection
        $this->collectPerformanceMetrics($admin, $request, $response, $endTime - $startTime);

        // Update admin activity
        $admin->updateLastActivity();

        return $response;
    }

    /**
     * Log pre-request information.
     */
    protected function logPreRequest($admin, Request $request): void
    {
        $routeName = $request->route()?->getName();
        $isSensitive = $this->isSensitiveOperation($request);

        // Real-time activity logging
        $activityData = [
            'admin_id' => $admin->id,
            'admin_name' => $admin->getFullName(),
            'admin_email' => $admin->email,
            'action' => $this->getActionName($request),
            'route' => $routeName,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_sensitive' => $isSensitive,
            'started_at' => now(),
            'request_data' => $this->getFilteredRequestData($request, $isSensitive),
        ];

        // Store in cache for real-time tracking
        $cacheKey = "admin_activity_{$admin->id}_" . time();
        Cache::put($cacheKey, $activityData, 300); // 5 minutes

        // Log sensitive operations immediately
        if ($isSensitive) {
            $this->logSensitiveOperation($admin, $request, $activityData);
        }
    }

    /**
     * Log post-request information.
     */
    protected function logPostRequest($admin, Request $request, Response $response, float $executionTime): void
    {
        $activityData = [
            'admin_id' => $admin->id,
            'action' => $this->getActionName($request),
            'route' => $request->route()?->getName(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'response_status' => $response->getStatusCode(),
            'execution_time' => $executionTime,
            'memory_usage' => memory_get_peak_usage(true),
            'completed_at' => now(),
            'is_sensitive' => $this->isSensitiveOperation($request),
        ];

        // Add response data for specific operations
        if ($this->shouldLogResponseData($request, $response)) {
            $activityData['response_data'] = $this->getFilteredResponseData($response);
        }

        // Log to AdminAuditLog if available
        if (class_exists(\App\Models\AdminAuditLog::class)) {
            \App\Models\AdminAuditLog::logAction($activityData);
        }

        // Update activity counters
        $this->updateActivityCounters($admin, $request);
    }

    /**
     * Track session information.
     */
    protected function trackSession($admin, Request $request): void
    {
        $sessionId = session()->getId();
        $cacheKey = "admin_session_{$admin->id}";

        $sessionData = Cache::get($cacheKey, []);
        $currentTime = now();

        // Update session tracking data
        $sessionData['session_id'] = $sessionId;
        $sessionData['last_activity'] = $currentTime;
        $sessionData['ip_address'] = $request->ip();
        $sessionData['user_agent'] = $request->userAgent();

        // Initialize session if new
        if (!isset($sessionData['session_started'])) {
            $sessionData['session_started'] = $currentTime;
            $sessionData['request_count'] = 0;
        }

        $sessionData['request_count']++;

        // Check for suspicious activity
        $this->detectSuspiciousActivity($admin, $request, $sessionData);

        // Store updated session data
        Cache::put($cacheKey, $sessionData, 1440); // 24 hours
    }

    /**
     * Check rate limiting.
     */
    protected function checkRateLimit($admin, Request $request): bool
    {
        $key = "rate_limit_{$admin->id}";
        $maxRequests = $this->getMaxRequestsPerMinute($admin, $request);
        
        $requests = Cache::get($key, []);
        $currentTime = time();
        
        // Clean old requests (older than 1 minute)
        $requests = array_filter($requests, function($timestamp) use ($currentTime) {
            return $currentTime - $timestamp < 60;
        });
        
        // Check if limit exceeded
        if (count($requests) >= $maxRequests) {
            $this->logRateLimitViolation($admin, $request);
            return false;
        }
        
        // Add current request
        $requests[] = $currentTime;
        Cache::put($key, $requests, 60);
        
        return true;
    }

    /**
     * Get maximum requests per minute for admin.
     */
    protected function getMaxRequestsPerMinute($admin, Request $request): int
    {
        // Different limits for different operations
        if ($this->isSensitiveOperation($request)) {
            return 10; // Sensitive operations
        }

        if ($request->is('api/*')) {
            return 60; // API requests
        }

        if ($admin->isSuperAdmin()) {
            return 120; // Super admin
        }

        return 100; // Regular admin
    }

    /**
     * Collect performance metrics.
     */
    protected function collectPerformanceMetrics($admin, Request $request, Response $response, float $executionTime): void
    {
        $metricsKey = "performance_metrics_{$admin->id}";
        $metrics = Cache::get($metricsKey, [
            'total_requests' => 0,
            'total_execution_time' => 0,
            'slow_requests' => 0,
            'error_requests' => 0,
            'avg_execution_time' => 0,
        ]);

        $metrics['total_requests']++;
        $metrics['total_execution_time'] += $executionTime;

        // Slow request threshold (2 seconds)
        if ($executionTime > 2.0) {
            $metrics['slow_requests']++;
            $this->logSlowRequest($admin, $request, $executionTime);
        }

        // Error request
        if ($response->getStatusCode() >= 400) {
            $metrics['error_requests']++;
        }

        $metrics['avg_execution_time'] = $metrics['total_execution_time'] / $metrics['total_requests'];

        Cache::put($metricsKey, $metrics, 1440); // 24 hours
    }

    /**
     * Detect suspicious activity.
     */
    protected function detectSuspiciousActivity($admin, Request $request, array $sessionData): void
    {
        $alerts = [];

        // High request frequency
        if ($sessionData['request_count'] > 1000 && 
            now()->diffInMinutes($sessionData['session_started']) < 60) {
            $alerts[] = 'high_request_frequency';
        }

        // IP address change
        if (isset($sessionData['previous_ip']) && 
            $sessionData['previous_ip'] !== $request->ip()) {
            $alerts[] = 'ip_address_change';
        }

        // User agent change
        if (isset($sessionData['previous_user_agent']) && 
            $sessionData['previous_user_agent'] !== $request->userAgent()) {
            $alerts[] = 'user_agent_change';
        }

        // Multiple sensitive operations
        $sensitiveCount = Cache::get("sensitive_ops_{$admin->id}", 0);
        if ($sensitiveCount > 20) {
            $alerts[] = 'excessive_sensitive_operations';
        }

        // Log alerts
        foreach ($alerts as $alert) {
            $this->logSecurityAlert($admin, $request, $alert, $sessionData);
        }

        // Store previous values for next comparison
        $sessionData['previous_ip'] = $request->ip();
        $sessionData['previous_user_agent'] = $request->userAgent();
    }

    /**
     * Check if operation is sensitive.
     */
    protected function isSensitiveOperation(Request $request): bool
    {
        $method = $request->method();
        $path = $request->path();

        // Check method
        if (in_array($method, ['DELETE', 'PUT', 'PATCH'])) {
            return true;
        }

        // Check path patterns
        foreach ($this->sensitiveOperations as $pattern) {
            if ($method === $pattern) {
                return true;
            }

            if (str_contains($path, $pattern) || 
                fnmatch($pattern, $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get action name from request.
     */
    protected function getActionName(Request $request): string
    {
        $routeName = $request->route()?->getName();
        
        if ($routeName) {
            return $routeName;
        }

        // Fallback to method + path
        return strtolower($request->method()) . '_' . 
               str_replace(['/', '-'], '_', trim($request->path(), '/'));
    }

    /**
     * Get filtered request data.
     */
    protected function getFilteredRequestData(Request $request, bool $isSensitive = false): array
    {
        $data = $request->all();

        // Remove sensitive fields
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            'new_password',
            'token',
            'csrf_token',
            '_token',
        ];

        foreach ($sensitiveFields as $field) {
            unset($data[$field]);
        }

        // Limit data size for non-sensitive operations
        if (!$isSensitive && count($data) > 50) {
            $data = array_slice($data, 0, 50);
            $data['_truncated'] = true;
        }

        return $data;
    }

    /**
     * Check if response data should be logged.
     */
    protected function shouldLogResponseData(Request $request, Response $response): bool
    {
        // Only log for sensitive operations with successful responses
        return $this->isSensitiveOperation($request) && 
               $response->getStatusCode() < 400;
    }

    /**
     * Get filtered response data.
     */
    protected function getFilteredResponseData(Response $response): array
    {
        $content = $response->getContent();
        
        if (!$content) {
            return [];
        }

        $data = json_decode($content, true);
        
        if (!is_array($data)) {
            return ['raw_content_type' => $response->headers->get('Content-Type')];
        }

        // Limit response data size
        if (count($data) > 100) {
            $data = array_slice($data, 0, 100);
            $data['_truncated'] = true;
        }

        return $data;
    }

    /**
     * Update activity counters.
     */
    protected function updateActivityCounters($admin, Request $request): void
    {
        $date = now()->format('Y-m-d');
        $hour = now()->hour;

        // Daily counter
        $dailyKey = "admin_activity_daily_{$admin->id}_{$date}";
        Cache::increment($dailyKey);
        Cache::expire($dailyKey, 86400); // 24 hours

        // Hourly counter
        $hourlyKey = "admin_activity_hourly_{$admin->id}_{$date}_{$hour}";
        Cache::increment($hourlyKey);
        Cache::expire($hourlyKey, 3600); // 1 hour

        // Sensitive operations counter
        if ($this->isSensitiveOperation($request)) {
            $sensitiveKey = "sensitive_ops_{$admin->id}";
            Cache::increment($sensitiveKey);
            Cache::expire($sensitiveKey, 3600); // 1 hour
        }
    }

    /**
     * Log sensitive operation.
     */
    protected function logSensitiveOperation($admin, Request $request, array $activityData): void
    {
        Log::warning('Sensitive operation detected', [
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'action' => $activityData['action'],
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'timestamp' => now(),
        ]);
    }

    /**
     * Log rate limit violation.
     */
    protected function logRateLimitViolation($admin, Request $request): void
    {
        Log::warning('Rate limit exceeded', [
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
            'timestamp' => now(),
        ]);

        if (class_exists(\App\Models\AdminAuditLog::class)) {
            $admin->logActivity('rate_limit_violation', [
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
        }
    }

    /**
     * Log slow request.
     */
    protected function logSlowRequest($admin, Request $request, float $executionTime): void
    {
        Log::info('Slow request detected', [
            'admin_id' => $admin->id,
            'execution_time' => $executionTime,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
    }

    /**
     * Log security alert.
     */
    protected function logSecurityAlert($admin, Request $request, string $alertType, array $sessionData): void
    {
        Log::alert('Security alert', [
            'alert_type' => $alertType,
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
            'ip_address' => $request->ip(),
            'session_data' => $sessionData,
            'timestamp' => now(),
        ]);

        if (class_exists(\App\Models\AdminAuditLog::class)) {
            $admin->logActivity('security_alert', [
                'alert_type' => $alertType,
                'ip_address' => $request->ip(),
                'session_data' => $sessionData,
            ]);
        }
    }

    /**
     * Handle rate limit exceeded.
     */
    protected function rateLimitExceeded(Request $request): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
                'error' => 'Rate Limit Exceeded',
                'code' => 429
            ], 429);
        }

        return redirect()->back()
            ->with('error', 'Too many requests. Please slow down.');
    }
}