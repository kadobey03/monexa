<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. This configuration is optimized for security
    | requirements of financial services applications.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    | Security Note: Be careful when modifying these settings for production.
    | CORS misconfiguration can lead to security vulnerabilities.
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'webhooks/*', // Stripe/Paystack webhooks
        'payments/*', // Payment endpoints
        'api/v1/*', // Versioned API routes
    ],

    'allowed_methods' => [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'OPTIONS', // Required for CORS preflight
        'PATCH'
    ],

    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:3000'),
        env('APP_URL', 'http://localhost'),
        'https://monexafinans.com',
        'https://www.monexafinans.com',
    ],

    'allowed_origins_patterns' => [
        // Allow subdomains of the main domain
        '/^https:\/\/.*\.monexafinans\.com$/',
        // Allow development patterns
        '/^http:\/\/localhost:\d+$/',
        '/^https:\/\/localhost:\d+$/',
    ],

    'allowed_headers' => [
        'Accept',
        'Accept-Language',
        'Authorization',
        'Cache-Control',
        'Content-Type',
        'Origin',
        'Pragma',
        'Referer',
        'User-Agent',
        'X-Requested-With',
        'X-CSRF-TOKEN',
        'X-API-KEY',
        'X-HTTP-Method-Override',
    ],

    'exposed_headers' => [
        'X-Rate-Limit-Remaining',
        'X-Rate-Limit-Reset',
        'X-API-Version',
        'X-Request-ID',
    ],

    'max_age' => 3600, // 1 hour cache for CORS preflight requests

    'supports_credentials' => true, // Required for authenticated requests

];