<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        // Core Framework Providers
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        
        // Application Providers
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
        App\Providers\NotificationServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
        App\Providers\ServiceServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware
        $middleware->use([
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        // Web middleware group
        $middleware->web([
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Laravel\Jetstream\Http\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\BlockIpAddressMiddleware::class,
            \App\Http\Middleware\CheckBannedUser::class,
        ]);

        // API middleware group
        $middleware->api([
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Route middleware aliases
        $middleware->alias([
            '2fa' => \App\Http\Middleware\TwoFactorVerify::class,
            'admin' => \App\Http\Middleware\EnsureIsAdmin::class,
            'isadmin' => \App\Http\Middleware\EnsureIsAdmin::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'adminguest' => \App\Http\Middleware\RedirectIfAdminIsLoggedIn::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'complete.kyc' => \App\Http\Middleware\EnsureKycIsCompleted::class,
            'check.banned' => \App\Http\Middleware\CheckBannedUser::class,
             
            // Hiyerarşik Rol Sistemi Middleware'leri
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'hierarchy' => \App\Http\Middleware\HierarchyMiddleware::class,
            'admin.activity' => \App\Http\Middleware\AdminActivityMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Sentry reporting - tüm environment'larda aktif
        $exceptions->reportable(function (Throwable $e) {
            try {
                // Validation exception'ları için Sentry'ye gönderme (spam olmasın)
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return false;
                }
                
                // Sentry'ye exception gönder
                if (app()->bound('sentry')) {
                    \Sentry\captureException($e);
                }
                
                // Ek logging (validation hariç)
                if (!($e instanceof \Illuminate\Validation\ValidationException)) {
                    error_log('Application Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                }
            } catch (\Exception $logException) {
                // Silently fail if logging doesn't work
            }
        });

        // Local environment'ta Laravel'in native debug page'ini kullan
        // Ama Sentry reporting'i de çalışsın
        if (app()->environment('local') && config('app.debug')) {
            // Sadece reporting yapıp render'i Laravel'a bırak
            return;
        }
        
        // Production/staging environment'lar için custom handling
        $exceptions->render(function (Throwable $e, $request) {
            try {
                // Validation Exception için özel handling
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    // API requests için JSON response
                    if ($request->expectsJson() || $request->is('api/*')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $e->errors()
                        ], 422);
                    }
                    
                    // Web requests için - Laravel'in default validation handling'ini kullan
                    return redirect()->back()
                        ->withErrors($e->errors())
                        ->withInput($request->except(['password', 'password_confirmation']));
                }

                // Authentication Exception için özel handling
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    if ($request->expectsJson() || $request->is('api/*')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Unauthenticated'
                        ], 401);
                    }
                    
                    return redirect()->route('login');
                }
                
                // API requests için JSON response
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Server Error',
                        'message' => 'An error occurred while processing your request.'
                    ], 500);
                }
                
                // Web requests için custom error page
                return response()->view('errors.500', [
                    'message' => 'Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.'
                ], 500);
                
            } catch (\Exception $handlerException) {
                // Fallback response
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Server Error'
                    ], 500);
                }
                return response('Server Error', 500, ['Content-Type' => 'text/plain']);
            }
        });
    })->create();