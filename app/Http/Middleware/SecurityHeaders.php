<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SecurityHeaders
{
    /**
     * Güvenlik header'larını tüm HTTP yanıtlarına uygula
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // HSTS (HTTP Strict Transport Security) - HTTPS zorlaması
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Content Security Policy (CSP) - XSS koruması
        $csp = $this->generateCSP();
        $response->headers->set('Content-Security-Policy', $csp);

        // X-Frame-Options - Clickjacking koruması
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // X-Content-Type-Options - MIME type sniffing koruması
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-XSS-Protection - Eski tarayıcılar için XSS koruması
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy - Referrer bilgisi kontrolü
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy - Tarayıcı özelliklerini kısıtlama
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=(), usb=()');

        // Feature-Policy - (deprecated, Permissions-Policy ile değiştirildi)
        $response->headers->set('Feature-Policy', 'geolocation none; microphone none; camera none');

        // Cross-Origin Resource Policy
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // Cross-Origin-Embedder-Policy
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');

        // Cross-Origin-Opener-Policy
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // Finansal servisler için özel header'lar
        if ($this->isFinancialEndpoint($request)) {
            $response->headers->set('X-Financial-Endpoint', 'true');
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        // API endpoint'leri için özel header'lar
        if ($request->is('api/*')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('X-API-Version', 'v1');
        }

        // Admin paneli için özel koruma
        if ($request->is('admin/*')) {
            $response->headers->set('X-Admin-Endpoint', 'true');
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
        }

        return $response;
    }

    /**
     * Content Security Policy (CSP) direktiflerini oluştur
     */
    private function generateCSP(): string
    {
        $directives = [
            // Ana kaynak kısıtlamaları
            'default-src' => ["'self'"],
            
            // Script kaynakları - nonce ile dinamik yükleme
            'script-src' => [
                "'self'",
                "'unsafe-inline'", // Livewire için gerekli
                "'unsafe-eval'",   // Bazı JavaScript framework'leri için
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
                'https://fonts.googleapis.com',
                'blob:'
            ],
            
            // Stil kaynakları
            'style-src' => [
                "'self'",
                "'unsafe-inline'", // Inline CSS için
                'https://fonts.googleapis.com',
                'https://cdnjs.cloudflare.com'
            ],
            
            // Font kaynakları
            'font-src' => [
                "'self'",
                'https://fonts.gstatic.com',
                'data:'
            ],
            
            // Görsel kaynakları
            'img-src' => [
                "'self'",
                'data:',
                'blob:',
                'https:'
            ],
            
            // Video/Audio kaynakları
            'media-src' => [
                "'self'",
                'blob:'
            ],
            
            // Frame embedding
            'frame-src' => [
                "'self'",
                'https://js.stripe.com', // Stripe için
                'https://checkout.stripe.com',
                'https://hooks.stripe.com',
                'https://js.paystack.co', // Paystack için
                'https://api.paystack.co'
            ],
            
            // Connection kaynakları (fetch, XMLHttpRequest, WebSocket)
            'connect-src' => [
                "'self'",
                'https://api.stripe.com',
                'https://checkout.stripe.com',
                'https://api.paystack.co',
                'https://hooks.stripe.com',
                'https://api.coinbase.com', // Crypto API'ler için
                'https://api.coingecko.com',
                'wss:', // WebSocket bağlantıları için
                'ws:'
            ],
            
            // Object kaynakları (Flash vb.)
            'object-src' => ["'none'"],
            
            // Base URI
            'base-uri' => ["'self'"],
            
            // Form action
            'form-action' => ["'self'"],
            
            // Frame ancestors (iframe gömme)
            'frame-ancestors' => ["'none'"],
            
            // Worker kaynakları
            'worker-src' => ["'self'", 'blob:'],
            
            // Manifest
            'manifest-src' => ["'self'"],
            
            // Prefetch
            'prefetch-src' => ["'self'"]
        ];

        // Direktifleri string'e çevir
        $cspString = '';
        foreach ($directives as $directive => $sources) {
            $cspString .= $directive . ' ' . implode(' ', $sources) . '; ';
        }

        return rtrim($cspString, '; ');
    }

    /**
     * İsteğin finansal endpoint olup olmadığını kontrol et
     */
    private function isFinancialEndpoint(Request $request): bool
    {
        $financialEndpoints = [
            'api/deposits',
            'api/withdrawals', 
            'api/investments',
            'api/transfers',
            'api/payments',
            'api/kyc',
            'admin/deposits',
            'admin/withdrawals',
            'admin/investments'
        ];

        foreach ($financialEndpoints as $endpoint) {
            if ($request->is($endpoint . '*')) {
                return true;
            }
        }

        return false;
    }
}