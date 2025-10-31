# Monexa Fintech Platform - Third-Party Integration Guide

## İçindekiler
- [Genel Bakış](#genel-bakış)
- [Payment Gateway Integrations](#payment-gateway-integrations)
- [Cryptocurrency APIs](#cryptocurrency-apis)
- [Email & SMS Services](#email--sms-services)
- [Social Login Providers](#social-login-providers)
- [Cloud Storage Services](#cloud-storage-services)
- [Monitoring & Analytics](#monitoring--analytics)
- [Security & Compliance](#security--compliance)
- [Webhook Management](#webhook-management)
- [Rate Limiting & Error Handling](#rate-limiting--error-handling)

## Genel Bakış

Monexa platform'u, modern fintech operasyonları için çeşitli third-party servislerle entegre çalışır. Bu integrations'lar güvenli, scalable ve maintainable şekilde tasarlanmıştır.

### Integration Architecture
```
┌─────────────────────────────────────────────────────────────────┐
│                      Monexa Core Application                    │
├─────────────────────────────────────────────────────────────────┤
│                      Service Layer                              │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐ │
│  │  Payment APIs   │  │  Crypto APIs    │  │  Email/SMS      │ │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
                               │
┌─────────────────────────────────────────────────────────────────┐
│                    External Services                            │
│ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌────────┐ │
│ │  Stripe  │ │ Binance  │ │   AWS    │ │ SendGrid │ │ Twilio │ │
│ └──────────┘ └──────────┘ └──────────┘ └──────────┘ └────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

### Service Categories
- **Payment Processing**: Stripe, Paystack, Cryptocurrency APIs
- **Data Providers**: Binance, CoinGecko, Financial data feeds
- **Communication**: SendGrid, Twilio, Push notifications
- **Infrastructure**: AWS S3, Redis Cloud, CDN services
- **Monitoring**: Sentry, DataDog, New Relic

## Payment Gateway Integrations

### Stripe Integration

#### Configuration
```php
// config/stripe.php
return [
    'public_key' => env('STRIPE_PUBLIC_KEY'),
    'secret_key' => env('STRIPE_SECRET_KEY'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'currency' => env('STRIPE_CURRENCY', 'USD'),
    'api_version' => '2023-10-16',
];
```

#### Environment Variables
```bash
# .env
STRIPE_PUBLIC_KEY=pk_live_...  # Production
STRIPE_SECRET_KEY=sk_live_...  # Production
STRIPE_WEBHOOK_SECRET=whsec_...

# For testing
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
```

#### Service Implementation
```php
// app/Services/StripeService.php
<?php

namespace App\Services;

use Stripe\StripeClient;
use App\Services\Results\PaymentResult;

class StripeService
{
    private StripeClient $stripe;
    
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }
    
    public function createPaymentIntent(float $amount, string $currency = 'USD'): PaymentResult
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amount * 100, // Convert to cents
                'currency' => strtolower($currency),
                'metadata' => [
                    'platform' => 'monexa',
                    'user_id' => auth()->id(),
                ],
            ]);
            
            return new PaymentResult(true, $paymentIntent, 'Payment intent created successfully');
            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe API Error', [
                'error' => $e->getMessage(),
                'amount' => $amount,
                'currency' => $currency
            ]);
            
            return new PaymentResult(false, null, 'Payment processing failed');
        }
    }
    
    public function handleWebhook(string $payload, string $signature): bool
    {
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                config('stripe.webhook_secret')
            );
            
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handlePaymentSuccess($event->data->object);
                    break;
                    
                case 'payment_intent.payment_failed':
                    $this->handlePaymentFailure($event->data->object);
                    break;
                    
                default:
                    Log::info('Unhandled Stripe event', ['type' => $event->type]);
            }
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Stripe webhook error', ['error' => $e->getMessage()]);
            return false;
        }
    }
    
    private function handlePaymentSuccess($paymentIntent): void
    {
        $userId = $paymentIntent->metadata->user_id ?? null;
        
        if ($userId) {
            // Update user balance
            $user = User::find($userId);
            $amount = $paymentIntent->amount / 100; // Convert from cents
            
            DB::transaction(function () use ($user, $amount, $paymentIntent) {
                $user->increment('account_bal', $amount);
                
                // Create deposit record
                Deposit::create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'payment_mode' => 'stripe',
                    'status' => 'approved',
                    'txn_id' => $paymentIntent->id,
                ]);
                
                // Send notification
                app(NotificationService::class)->notifyDeposit(
                    $user, 
                    $amount, 
                    $paymentIntent->currency,
                    $paymentIntent->id
                );
            });
        }
    }
}
```

#### Webhook Controller
```php
// app/Http/Controllers/StripeWebhookController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;

class StripeWebhookController extends Controller
{
    public function handle(Request $request, StripeService $stripeService)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        
        if ($stripeService->handleWebhook($payload, $signature)) {
            return response('Webhook handled', 200);
        }
        
        return response('Webhook error', 400);
    }
}
```

### Paystack Integration

#### Configuration & Usage
```php
// config/paystack.php
return [
    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'currency' => env('PAYSTACK_CURRENCY', 'NGN'),
    'base_url' => 'https://api.paystack.co',
];

// app/Services/PaystackService.php
class PaystackService
{
    public function initializeTransaction(float $amount, User $user): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('paystack.secret_key'),
            'Content-Type' => 'application/json',
        ])->post(config('paystack.base_url') . '/transaction/initialize', [
            'email' => $user->email,
            'amount' => $amount * 100, // Convert to kobo
            'currency' => config('paystack.currency'),
            'callback_url' => route('paystack.callback'),
            'metadata' => [
                'user_id' => $user->id,
                'platform' => 'monexa'
            ]
        ]);
        
        if ($response->successful()) {
            return $response->json()['data'];
        }
        
        throw new PaymentException('Failed to initialize Paystack transaction');
    }
}
```

## Cryptocurrency APIs

### Binance API Integration

#### Configuration
```php
// config/binance.php
return [
    'api_key' => env('BINANCE_API_KEY'),
    'secret_key' => env('BINANCE_SECRET_KEY'),
    'base_url' => env('BINANCE_BASE_URL', 'https://api.binance.com'),
    'testnet_url' => 'https://testnet.binance.vision',
    'use_testnet' => env('BINANCE_USE_TESTNET', false),
];
```

#### Service Implementation
```php
// app/Services/CryptoService.php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CryptoService
{
    private string $baseUrl;
    
    public function __construct()
    {
        $this->baseUrl = config('binance.use_testnet') 
            ? config('binance.testnet_url') 
            : config('binance.base_url');
    }
    
    public function getCurrentPrice(string $symbol): float
    {
        $cacheKey = "crypto_price_{$symbol}";
        
        return Cache::remember($cacheKey, 60, function () use ($symbol) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . '/api/v3/ticker/price', [
                    'symbol' => $symbol
                ]);
                
                if ($response->successful()) {
                    return (float) $response->json()['price'];
                }
                
                throw new \Exception('Failed to fetch price from Binance');
                
            } catch (\Exception $e) {
                Log::error('Binance API Error', [
                    'symbol' => $symbol,
                    'error' => $e->getMessage()
                ]);
                
                // Return cached fallback price if available
                return Cache::get("crypto_price_fallback_{$symbol}", 0.0);
            }
        });
    }
    
    public function getPriceHistory(string $symbol, string $interval = '1h', int $limit = 24): array
    {
        try {
            $response = Http::timeout(30)->get($this->baseUrl . '/api/v3/klines', [
                'symbol' => $symbol,
                'interval' => $interval,
                'limit' => $limit
            ]);
            
            if ($response->successful()) {
                return collect($response->json())->map(function ($kline) {
                    return [
                        'timestamp' => $kline[0],
                        'open' => (float) $kline[1],
                        'high' => (float) $kline[2],
                        'low' => (float) $kline[3],
                        'close' => (float) $kline[4],
                        'volume' => (float) $kline[5],
                    ];
                })->toArray();
            }
            
            return [];
            
        } catch (\Exception $e) {
            Log::error('Binance History API Error', [
                'symbol' => $symbol,
                'error' => $e->getMessage()
            ]);
            
            return [];
        }
    }
    
    public function getMultiplePrices(array $symbols): array
    {
        try {
            $symbolsString = implode('","', $symbols);
            $response = Http::timeout(15)->get($this->baseUrl . '/api/v3/ticker/price');
            
            if ($response->successful()) {
                $allPrices = collect($response->json());
                
                return $allPrices
                    ->whereIn('symbol', $symbols)
                    ->pluck('price', 'symbol')
                    ->map(fn($price) => (float) $price)
                    ->toArray();
            }
            
            return [];
            
        } catch (\Exception $e) {
            Log::error('Binance Multiple Prices API Error', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
```

#### Scheduled Price Updates
```php
// app/Console/Commands/UpdateCryptoPrices.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CryptoService;
use App\Models\MarketPrice;

class UpdateCryptoPrices extends Command
{
    protected $signature = 'crypto:update-prices';
    protected $description = 'Update cryptocurrency prices from Binance API';
    
    public function handle(CryptoService $cryptoService): void
    {
        $symbols = ['BTCUSDT', 'ETHUSDT', 'LTCUSDT', 'ADAUSDT', 'DOTUSDT'];
        
        $this->info('Fetching cryptocurrency prices...');
        
        $prices = $cryptoService->getMultiplePrices($symbols);
        
        foreach ($prices as $symbol => $price) {
            MarketPrice::updateOrCreate(
                ['symbol' => $symbol],
                [
                    'price' => $price,
                    'updated_at' => now()
                ]
            );
            
            $this->line("Updated {$symbol}: ${$price}");
        }
        
        $this->info('Price update completed!');
    }
}

// app/Console/Kernel.php - Schedule the command
protected function schedule(Schedule $schedule): void
{
    $schedule->command('crypto:update-prices')
             ->everyFiveMinutes()
             ->withoutOverlapping();
}
```

### CoinGecko API Integration
```php
// app/Services/CoinGeckoService.php
class CoinGeckoService
{
    private string $baseUrl = 'https://api.coingecko.com/api/v3';
    
    public function getMarketData(array $coinIds): array
    {
        $coinsList = implode(',', $coinIds);
        
        try {
            $response = Http::timeout(20)->get($this->baseUrl . '/simple/price', [
                'ids' => $coinsList,
                'vs_currencies' => 'usd',
                'include_market_cap' => true,
                'include_24hr_change' => true,
            ]);
            
            return $response->successful() ? $response->json() : [];
            
        } catch (\Exception $e) {
            Log::error('CoinGecko API Error', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
```

## Email & SMS Services

### SendGrid Integration

#### Configuration
```php
// config/mail.php
'mailers' => [
    'sendgrid' => [
        'transport' => 'sendgrid',
        'key' => env('SENDGRID_API_KEY'),
    ],
],

// .env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=SG.your_api_key
MAIL_FROM_ADDRESS="noreply@monexa.app"
MAIL_FROM_NAME="Monexa Platform"
```

#### Email Templates
```php
// app/Mail/DepositConfirmation.php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Deposit;
use App\Models\User;

class DepositConfirmation extends Mailable
{
    public function __construct(
        public User $user,
        public Deposit $deposit
    ) {}
    
    public function build(): self
    {
        return $this->subject('Deposit Confirmation - Monexa')
                   ->view('emails.deposit-confirmation')
                   ->with([
                       'user' => $this->user,
                       'deposit' => $this->deposit,
                       'dashboard_url' => route('user.dashboard')
                   ]);
    }
}

// Usage in service
Mail::to($user->email)->send(new DepositConfirmation($user, $deposit));
```

#### Bulk Email Service
```php
// app/Services/EmailService.php
class EmailService
{
    public function sendBulkNotification(array $userIds, string $subject, string $template, array $data = []): void
    {
        $users = User::whereIn('id', $userIds)->get();
        
        foreach ($users->chunk(100) as $chunk) {
            dispatch(new SendBulkEmailJob($chunk, $subject, $template, $data));
        }
    }
}

// app/Jobs/SendBulkEmailJob.php
class SendBulkEmailJob implements ShouldQueue
{
    public function handle(): void
    {
        foreach ($this->users as $user) {
            Mail::to($user->email)->send(
                new BulkNotificationMail($user, $this->subject, $this->template, $this->data)
            );
        }
    }
}
```

### Twilio SMS Integration

#### Configuration & Service
```php
// config/twilio.php
return [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_TOKEN'),
    'from' => env('TWILIO_FROM'),
];

// app/Services/SmsService.php
use Twilio\Rest\Client;

class SmsService
{
    private Client $twilio;
    
    public function __construct()
    {
        $this->twilio = new Client(
            config('twilio.sid'),
            config('twilio.token')
        );
    }
    
    public function sendVerificationCode(string $phoneNumber, string $code): bool
    {
        try {
            $this->twilio->messages->create($phoneNumber, [
                'from' => config('twilio.from'),
                'body' => "Your Monexa verification code is: {$code}. Valid for 5 minutes."
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('SMS send failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}
```

## Social Login Providers

### Google OAuth Integration

#### Configuration
```php
// config/services.php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],

// .env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=https://monexa.app/auth/google/callback
```

#### Social Login Controller
```php
// app/Http/Controllers/SocialLoginController.php
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->redirect();
    }
    
    public function handleGoogleCallback(UserService $userService)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'email_verified_at' => now(),
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar ?? $user->avatar,
                ]);
            }
            
            Auth::login($user, true);
            
            return redirect()->route('user.dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google OAuth Error', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'OAuth authentication failed');
        }
    }
}
```

### Facebook & Twitter Integration
```php
// config/services.php
'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => env('FACEBOOK_REDIRECT_URL'),
],

'twitter' => [
    'client_id' => env('TWITTER_CLIENT_ID'),
    'client_secret' => env('TWITTER_CLIENT_SECRET'),
    'redirect' => env('TWITTER_REDIRECT_URL'),
],
```

## Cloud Storage Services

### AWS S3 Integration

#### Configuration
```php
// config/filesystems.php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],

// .env
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=monexa-storage
```

#### File Upload Service
```php
// app/Services/FileStorageService.php
class FileStorageService
{
    public function uploadKycDocument(UploadedFile $file, User $user, string $type): string
    {
        $filename = $this->generateSecureFilename($file, $user, $type);
        $path = "kyc/{$user->id}/{$filename}";
        
        $uploaded = Storage::disk('s3')->put($path, $file->getContent(), [
            'visibility' => 'private',
            'metadata' => [
                'user_id' => $user->id,
                'document_type' => $type,
                'uploaded_at' => now()->toISOString(),
            ]
        ]);
        
        if ($uploaded) {
            // Log upload for audit trail
            Log::info('KYC document uploaded', [
                'user_id' => $user->id,
                'type' => $type,
                'path' => $path
            ]);
            
            return Storage::disk('s3')->url($path);
        }
        
        throw new FileUploadException('Failed to upload document to S3');
    }
    
    public function generateTemporaryUrl(string $path, int $expirationMinutes = 60): string
    {
        return Storage::disk('s3')->temporaryUrl(
            $path,
            now()->addMinutes($expirationMinutes)
        );
    }
    
    private function generateSecureFilename(UploadedFile $file, User $user, string $type): string
    {
        $extension = $file->getClientOriginalExtension();
        $hash = hash('sha256', $file->getContent() . $user->id . time());
        
        return "{$type}_{$hash}.{$extension}";
    }
}
```

## Monitoring & Analytics

### Sentry Error Tracking

#### Configuration
```php
// config/sentry.php
return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'environment' => env('APP_ENV', 'production'),
    'release' => env('SENTRY_RELEASE'),
    'sample_rate' => env('SENTRY_SAMPLE_RATE', 1.0),
];

// .env
SENTRY_LARAVEL_DSN=https://your-dsn@sentry.io/project-id
SENTRY_SAMPLE_RATE=0.1  # 10% sampling in production
```

#### Custom Error Context
```php
// app/Exceptions/Handler.php
public function register(): void
{
    $this->reportable(function (Throwable $e) {
        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }
    });
}

// Usage in services
try {
    // Risky operation
    $result = $this->processPayment($data);
} catch (PaymentException $e) {
    Sentry\captureException($e, [
        'extra' => [
            'user_id' => auth()->id(),
            'payment_data' => $data,
            'timestamp' => now()->toISOString(),
        ]
    ]);
    
    throw $e;
}
```

### Google Analytics Integration
```php
// app/Services/AnalyticsService.php
class AnalyticsService
{
    public function trackUserRegistration(User $user): void
    {
        // GA4 Measurement Protocol
        Http::post('https://www.google-analytics.com/mp/collect', [
            'measurement_id' => config('analytics.ga4_measurement_id'),
            'api_secret' => config('analytics.ga4_api_secret'),
            'client_id' => $user->id,
            'events' => [
                [
                    'name' => 'sign_up',
                    'parameters' => [
                        'method' => 'email',
                        'user_id' => $user->id,
                        'timestamp_micros' => now()->getTimestampMs() * 1000,
                    ]
                ]
            ]
        ]);
    }
    
    public function trackDeposit(User $user, float $amount, string $currency): void
    {
        // Track deposit event
        Http::post('https://www.google-analytics.com/mp/collect', [
            'measurement_id' => config('analytics.ga4_measurement_id'),
            'api_secret' => config('analytics.ga4_api_secret'),
            'client_id' => $user->id,
            'events' => [
                [
                    'name' => 'purchase',
                    'parameters' => [
                        'transaction_id' => Str::uuid(),
                        'value' => $amount,
                        'currency' => $currency,
                        'user_id' => $user->id,
                    ]
                ]
            ]
        ]);
    }
}
```

## Security & Compliance

### reCAPTCHA Integration
```php
// config/recaptcha.php
return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    'version' => env('RECAPTCHA_VERSION', 'v3'),
];

// app/Http/Requests/RegisterRequest.php
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'recaptcha_token' => ['required', new RecaptchaRule],
        ];
    }
}

// app/Rules/RecaptchaRule.php
class RecaptchaRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);
        
        $result = $response->json();
        
        return $result['success'] && $result['score'] >= 0.5;
    }
    
    public function message(): string
    {
        return 'reCAPTCHA verification failed.';
    }
}
```

## Webhook Management

### Centralized Webhook Handler
```php
// app/Http/Controllers/WebhookController.php
class WebhookController extends Controller
{
    private array $webhookServices = [
        'stripe' => StripeService::class,
        'paystack' => PaystackService::class,
        'binance' => BinanceService::class,
    ];
    
    public function handle(string $provider, Request $request)
    {
        if (!isset($this->webhookServices[$provider])) {
            return response('Provider not found', 404);
        }
        
        $serviceClass = $this->webhookServices[$provider];
        $service = app($serviceClass);
        
        // Verify webhook signature
        if (!$this->verifyWebhookSignature($provider, $request)) {
            Log::warning('Invalid webhook signature', ['provider' => $provider]);
            return response('Invalid signature', 401);
        }
        
        // Process webhook
        $result = $service->handleWebhook(
            $request->getContent(),
            $request->headers->all()
        );
        
        return $result ? response('OK', 200) : response('Error', 500);
    }
    
    private function verifyWebhookSignature(string $provider, Request $request): bool
    {
        switch ($provider) {
            case 'stripe':
                return $this->verifyStripeSignature($request);
            case 'paystack':
                return $this->verifyPaystackSignature($request);
            default:
                return true;
        }
    }
}
```

## Rate Limiting & Error Handling

### API Rate Limiting Service
```php
// app/Services/RateLimitService.php
class RateLimitService
{
    public function checkApiLimit(string $service, string $identifier): bool
    {
        $key = "api_limit:{$service}:{$identifier}";
        $limit = config("services.{$service}.rate_limit", 1000);
        $window = config("services.{$service}.rate_window", 3600);
        
        $current = Cache::get($key, 0);
        
        if ($current >= $limit) {
            return false;
        }
        
        Cache::put($key, $current + 1, $window);
        return true;
    }
    
    public function getRemainingRequests(string $service, string $identifier): int
    {
        $key = "api_limit:{$service}:{$identifier}";
        $limit = config("services.{$service}.rate_limit", 1000);
        $current = Cache::get($key, 0);
        
        return max(0, $limit - $current);
    }
}

// Usage in services
class CryptoService
{
    public function getCurrentPrice(string $symbol): float
    {
        if (!$this->rateLimitService->checkApiLimit('binance', 'price_fetch')) {
            throw new RateLimitExceededException('Binance API rate limit exceeded');
        }
        
        // Proceed with API call
        return $this->fetchPriceFromApi($symbol);
    }
}
```

### Circuit Breaker Pattern
```php
// app/Services/CircuitBreakerService.php
class CircuitBreakerService
{
    private const STATE_CLOSED = 'closed';
    private const STATE_OPEN = 'open';
    private const STATE_HALF_OPEN = 'half_open';
    
    public function call(string $service, callable $callback)
    {
        $state = $this->getState($service);
        
        switch ($state) {
            case self::STATE_OPEN:
                if ($this->shouldTryReset($service)) {
                    $this->setState($service, self::STATE_HALF_OPEN);
                } else {
                    throw new CircuitOpenException("Circuit breaker open for {$service}");
                }
                break;
                
            case self::STATE_HALF_OPEN:
                try {
                    $result = $callback();
                    $this->onSuccess($service);
                    return $result;
                } catch (\Exception $e) {
                    $this->onFailure($service);
                    throw $e;
                }
                
            case self::STATE_CLOSED:
            default:
                try {
                    $result = $callback();
                    $this->onSuccess($service);
                    return $result;
                } catch (\Exception $e) {
                    $this->onFailure($service);
                    throw $e;
                }
        }
    }
}
```

---

**Son Güncelleme**: 31 Ekim 2025  
**Integration Versiyon**: 2.0  
**Third-Party Services**: 15+ aktif entegrasyon  
**API Documentation**: [External APIs Reference](./external-apis.md)