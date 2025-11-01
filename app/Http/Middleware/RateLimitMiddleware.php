<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class RateLimitMiddleware
{
    /**
     * Finansal servisler için gelişmiş rate limiting middleware'i
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $tier Rate limiting seviyesi (financial, api, login, form, etc.)
     * @param  int $maxAttempts Maksimum deneme sayısı
     * @param  int $decayMinutes Dakika başına düşüş
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $tier = 'default', $maxAttempts = null, $decayMinutes = null)
    {
        // Endpoint ve tier için rate limit konfigürasyonu
        $limits = $this->getRateLimits();
        
        if (!isset($limits[$tier])) {
            $tier = 'default';
        }

        $config = $limits[$tier];
        
        // Parametre override'ları
        $maxAttempts = $maxAttempts ?? $config['max_attempts'];
        $decayMinutes = $decayMinutes ?? $config['decay_minutes'];
        $key = $this->generateKey($request, $tier, $config['key_prefix']);

        // Rate limit kontrolü
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            // Güvenlik logları
            $this->logSecurityEvent($request, $tier, 'rate_limit_exceeded', [
                'key' => $key,
                'attempts' => RateLimiter::attempts($key),
                'max_attempts' => $maxAttempts,
                'remaining_seconds' => $seconds
            ]);

            return response()->json([
                'error' => [
                    'code' => 'RATE_LIMIT_EXCEEDED',
                    'message' => 'Çok fazla istek gönderildiniz. Lütfen daha sonra tekrar deneyin.',
                    'retry_after' => $seconds,
                    'limit' => $maxAttempts
                ]
            ], 429, [
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset' => now()->addSeconds($seconds)->timestamp,
                'Retry-After' => $seconds
            ]);
        }

        // Rate limit hit kaydı
        RateLimiter::hit($key, $decayMinutes * 60);

        $response = $next($request);

        // Rate limit bilgilerini header'lara ekle
        $remaining = $maxAttempts - RateLimiter::attempts($key);
        $resetTime = now()->addMinutes($decayMinutes)->timestamp;

        $response->headers->add([
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => max(0, $remaining),
            'X-RateLimit-Reset' => $resetTime,
            'X-RateLimit-Tier' => $tier
        ]);

        return $response;
    }

    /**
     * Rate limit konfigürasyonları
     */
    private function getRateLimits(): array
    {
        return [
            // Finansal işlemler - En kısıtlı
            'financial' => [
                'max_attempts' => 3,
                'decay_minutes' => 15, // 15 dakikada 3 işlem
                'key_prefix' => 'financial_',
                'description' => 'Para yatırma/çekme, yatırım işlemleri'
            ],
            
            // Login denemeleri
            'login' => [
                'max_attempts' => 5,
                'decay_minutes' => 15,
                'key_prefix' => 'login_',
                'description' => 'Kullanıcı giriş denemeleri'
            ],
            
            // API çağrıları
            'api' => [
                'max_attempts' => 60,
                'decay_minutes' => 1, // Dakikada 60 istek
                'key_prefix' => 'api_',
                'description' => 'Genel API endpointleri'
            ],
            
            // Form gönderimi
            'form' => [
                'max_attempts' => 10,
                'decay_minutes' => 5,
                'key_prefix' => 'form_',
                'description' => 'Form gönderimleri'
            ],
            
            // Dosya yükleme
            'upload' => [
                'max_attempts' => 5,
                'decay_minutes' => 10,
                'key_prefix' => 'upload_',
                'description' => 'Dosya yükleme işlemleri'
            ],
            
            // KYC başvuruları
            'kyc' => [
                'max_attempts' => 3,
                'decay_minutes' => 60, // Saatte 3 deneme
                'key_prefix' => 'kyc_',
                'description' => 'KYC başvuru işlemleri'
            ],
            
            // Admin paneli
            'admin' => [
                'max_attempts' => 100,
                'decay_minutes' => 1,
                'key_prefix' => 'admin_',
                'description' => 'Admin panel işlemleri'
            ],
            
            // Webhook'lar (Stripe, Paystack)
            'webhook' => [
                'max_attempts' => 1000,
                'decay_minutes' => 1,
                'key_prefix' => 'webhook_',
                'description' => 'Payment webhook işlemleri'
            ],
            
            // Genel default
            'default' => [
                'max_attempts' => 30,
                'decay_minutes' => 1,
                'key_prefix' => 'default_',
                'description' => 'Genel web sayfaları'
            ],
            
            // CRON endpoint'leri
            'cron' => [
                'max_attempts' => 10,
                'decay_minutes' => 60,
                'key_prefix' => 'cron_',
                'description' => 'CRON job endpointleri'
            ]
        ];
    }

    /**
     * Rate limit key oluştur
     */
    private function generateKey(Request $request, string $tier, string $prefix): string
    {
        $key = $prefix;
        
        // Authenticated kullanıcılar için user ID kullan
        if (auth()->check()) {
            $key .= 'user_' . auth()->id();
        } 
        // API key ile gelen istekler için
        elseif ($request->header('X-API-Key')) {
            $key .= 'api_' . hash('sha256', $request->header('X-API-Key'));
        }
        // Anonymous kullanıcılar için IP ve User-Agent
        else {
            $ip = $request->ip() ?? 'unknown';
            $userAgent = hash('sha256', $request->userAgent() ?? 'unknown');
            $key .= "ip_{$ip}_ua_{$userAgent}";
        }

        // Endpoint'e özgü key
        $route = $request->path();
        $key .= '_' . Str::slug($route);

        return Str::lower($key);
    }

    /**
     * Güvenlik olayını logla
     */
    private function logSecurityEvent(Request $request, string $tier, string $event, array $context = []): void
    {
        $logData = [
            'event' => $event,
            'tier' => $tier,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => auth()->id(),
            'timestamp' => now(),
            'context' => $context
        ];

        // Security log dosyasına yaz
        \Log::channel('security')->warning('Rate Limit Event', $logData);

        // Yüksek önem dereceli olaylar için ayrı log
        if (in_array($tier, ['financial', 'login', 'kyc'])) {
            \Log::channel('security_critical')->alert('High Priority Rate Limit Event', $logData);
        }
    }

    /**
     * Rate limit reset metodu (Admin paneli için)
     */
    public static function resetRateLimit(string $key): bool
    {
        try {
            RateLimiter::clear($key);
            return true;
        } catch (\Exception $e) {
            \Log::error('Rate limit reset failed', ['key' => $key, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Rate limit durumunu kontrol et
     */
    public static function checkRateLimit(string $key, int $maxAttempts): array
    {
        $attempts = RateLimiter::attempts($key);
        $remaining = max(0, $maxAttempts - $attempts);
        $available = RateLimiter::availableIn($key);

        return [
            'attempts' => $attempts,
            'remaining' => $remaining,
            'limit' => $maxAttempts,
            'available_in' => $available,
            'is_limited' => $attempts >= $maxAttempts
        ];
    }
}