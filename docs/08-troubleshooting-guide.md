# Monexa Fintech Platform - Troubleshooting Guide

## İçindekiler
- [Genel Troubleshooting](#genel-troubleshooting)
- [Application Issues](#application-issues)
- [Database Issues](#database-issues)
- [Authentication & Session Issues](#authentication--session-issues)
- [API Integration Issues](#api-integration-issues)
- [Component & Frontend Issues](#component--frontend-issues)
- [Performance Issues](#performance-issues)
- [Queue & Background Jobs](#queue--background-jobs)
- [File Upload Issues](#file-upload-issues)
- [Email & Notification Issues](#email--notification-issues)
- [Development Environment Issues](#development-environment-issues)

## Genel Troubleshooting

### Diagnostic Commands
```bash
# Application health check
php artisan about
php artisan config:show
php artisan route:list

# Database connection test
php artisan tinker
>>> DB::connection()->getPdo();

# Cache status check
php artisan cache:table
redis-cli ping

# Queue status check
php artisan queue:work --once
php artisan horizon:status

# Log monitoring
tail -f storage/logs/laravel.log
journalctl -f -u nginx -u php8.3-fpm
```

### Log Locations
```bash
# Application logs
storage/logs/laravel.log
storage/logs/laravel-{date}.log

# System logs
/var/log/nginx/error.log
/var/log/nginx/access.log
/var/log/php8.3-fpm.log

# Database logs
/var/log/mysql/error.log
/var/log/mysql/slow.log

# Queue logs
storage/logs/horizon.log
```

## Application Issues

### 1. Repository Dependency Injection Errors

**Problem**: `Target [App\Contracts\Repositories\UserRepositoryInterface] is not instantiable`

**Symptoms**:
- Białe ekran (WSOD) on application load
- Error logs showing interface binding issues
- Service container resolution failures

**Diagnosis**:
```bash
# Check service provider registration
php artisan config:show app.providers

# Verify interface bindings
php artisan tinker
>>> app()->bound('App\Contracts\Repositories\UserRepositoryInterface');
```

**Solutions**:
```bash
# 1. Clear config cache
php artisan config:clear

# 2. Check RepositoryServiceProvider registration
# File: config/app.php
# Ensure App\Providers\RepositoryServiceProvider::class is listed

# 3. Verify interface bindings
# File: app/Providers/RepositoryServiceProvider.php
public function register(): void
{
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    // Add missing bindings
}

# 4. Re-cache configuration
php artisan config:cache
```

### 2. Service Layer Transaction Issues

**Problem**: Financial operations not rolling back on failure

**Symptoms**:
- Partial data updates in database
- Inconsistent financial balances
- Exception logs without proper rollbacks

**Diagnosis**:
```bash
# Enable query logging
php artisan tinker
>>> DB::enableQueryLog();
>>> // Perform problematic operation
>>> dd(DB::getQueryLog());

# Check for transaction usage
grep -r "DB::transaction" app/Services/
```

**Solutions**:
```php
// ✅ Correct: Wrap operations in transactions
public function processDeposit(array $data, User $user): DepositResult
{
    return DB::transaction(function () use ($data, $user) {
        $deposit = $this->depositRepository->create($data);
        $this->updateUserBalance($user, $deposit->amount);
        $this->calculateCommissions($user, $deposit->amount);
        
        return new DepositResult($deposit, true, 'Success');
    });
}

// ❌ Wrong: No transaction wrapper
public function processDeposit(array $data, User $user): DepositResult
{
    $deposit = $this->depositRepository->create($data);
    $this->updateUserBalance($user, $deposit->amount); // May fail here
    $this->calculateCommissions($user, $deposit->amount); // Leaving inconsistent state
}
```

### 3. Livewire Component Errors

**Problem**: Livewire components not updating or throwing errors

**Symptoms**:
- Component data not refreshing
- Wire:model not working
- JavaScript console errors

**Diagnosis**:
```bash
# Clear Livewire cache
php artisan livewire:clear-cache

# Check Livewire assets
php artisan livewire:publish --assets

# Verify component registration
php artisan livewire:list
```

**Solutions**:
```bash
# 1. Republish Livewire assets
php artisan livewire:publish --force

# 2. Clear all caches
php artisan optimize:clear

# 3. Check component class properties are public
# ✅ Correct:
class InvestmentPlan extends Component
{
    public $amount; // Public property
    public $planId; // Public property
}

# ❌ Wrong:
class InvestmentPlan extends Component
{
    private $amount; // Private - won't work with wire:model
}

# 4. Verify Alpine.js compatibility
npm run dev # Rebuild assets
```

## Database Issues

### 1. Migration Constraint Failures

**Problem**: Foreign key constraint failures during migration

**Symptoms**:
- Migration rollback failures
- Error: "Cannot add foreign key constraint"
- Database inconsistency errors

**Diagnosis**:
```bash
# Check migration status
php artisan migrate:status

# Identify constraint issues
php artisan tinker
>>> Schema::getColumnListing('users');
>>> DB::select("SHOW CREATE TABLE users");
```

**Solutions**:
```bash
# 1. Check migration order
ls -la database/migrations/

# 2. Ensure referenced tables exist first
# Migration naming: 2025_01_01_000001_create_users_table.php (users first)
# Migration naming: 2025_01_01_000002_create_deposits_table.php (deposits second)

# 3. Use proper foreign key syntax
Schema::table('deposits', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    // Instead of: $table->foreign('user_id')->references('id')->on('users');
});

# 4. Disable foreign key checks temporarily (last resort)
php artisan migrate --force
```

### 2. Query Performance Issues

**Problem**: Slow API responses and database queries

**Symptoms**:
- API timeouts
- High database CPU usage
- Slow page load times

**Diagnosis**:
```bash
# Enable MySQL slow query log
sudo mysql -e "SET GLOBAL slow_query_log = 'ON';"
sudo mysql -e "SET GLOBAL long_query_time = 1;" # Queries > 1 second

# Monitor slow queries
sudo tail -f /var/log/mysql/slow.log

# Laravel query debugging
php artisan tinker
>>> DB::enableQueryLog();
>>> User::with('deposits')->get(); // Example query
>>> collect(DB::getQueryLog())->each(fn($q) => dump($q['query']));
```

**Solutions**:
```php
// ✅ Correct: Eager loading to prevent N+1
$users = User::with(['deposits', 'withdrawals', 'plans'])->get();

// ❌ Wrong: Lazy loading causes N+1 problem
$users = User::all();
foreach ($users as $user) {
    echo $user->deposits->count(); // N+1 query problem
}

// Add indexes for commonly queried fields
Schema::table('users', function (Blueprint $table) {
    $table->index(['lead_status', 'assign_to']);
    $table->index(['email', 'status']);
    $table->index('next_follow_up_date');
});

// Use query scopes for complex queries
class User extends Model 
{
    public function scopeActiveLeads($query) 
    {
        return $query->where('lead_status', '!=', 'converted')
                    ->whereNotNull('assign_to');
    }
}

// Usage: User::activeLeads()->get();
```

### 3. Connection Pool Exhaustion

**Problem**: Database connection errors under load

**Symptoms**:
- "Too many connections" errors
- Connection timeouts
- Application hanging

**Solutions**:
```php
// config/database.php - Optimize connection pooling
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'options' => [
        PDO::ATTR_PERSISTENT => false, // Disable persistent connections in high-load
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 30,
    ],
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 10,
        'connect_timeout' => 10.0,
        'wait_timeout' => 3.0,
        'heartbeat' => -1,
        'max_idle_time' => 60.0,
    ],
],

// Monitor connections
-- MySQL: SHOW PROCESSLIST;
-- Check max connections: SHOW VARIABLES LIKE 'max_connections';
```

## Authentication & Session Issues

### 1. Sanctum Token Authentication Failures

**Problem**: API authentication not working with Sanctum tokens

**Symptoms**:
- 401 Unauthorized responses
- Token validation failures
- Session-based auth working but API tokens failing

**Diagnosis**:
```bash
# Check Sanctum configuration
php artisan config:show sanctum

# Verify middleware setup
php artisan route:list --path=api

# Test token generation
php artisan tinker
>>> $user = User::first();
>>> $token = $user->createToken('test')->plainTextToken;
>>> echo $token;
```

**Solutions**:
```bash
# 1. Verify Sanctum configuration
# config/sanctum.php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),

# 2. Check API routes middleware
# routes/api.php
Route::middleware(['auth:sanctum'])->group(function () {
    // Protected routes
});

# 3. Verify token usage in requests
# Headers:
# Authorization: Bearer 1|your-token-here
# Accept: application/json
# Content-Type: application/json

# 4. Clear config cache
php artisan config:clear
php artisan optimize
```

### 2. Session Configuration Issues

**Problem**: Users getting logged out frequently or sessions not persisting

**Symptoms**:
- Frequent login prompts
- Session data not persisting
- CSRF token mismatches

**Solutions**:
```bash
# 1. Check session configuration
# config/session.php
'lifetime' => env('SESSION_LIFETIME', 120), // minutes
'expire_on_close' => false,
'encrypt' => env('SESSION_ENCRYPT', false),
'files' => storage_path('framework/sessions'),
'connection' => env('SESSION_CONNECTION', null),
'table' => 'sessions',
'store' => env('SESSION_STORE', null),
'lottery' => [2, 100],
'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),
'path' => '/',
'domain' => env('SESSION_DOMAIN', null),
'secure' => env('SESSION_SECURE_COOKIE'), // true for HTTPS
'http_only' => true,
'same_site' => 'lax',

# 2. Fix permissions
sudo chmod -R 775 storage/framework/sessions
sudo chown -R www-data:www-data storage/framework/sessions

# 3. For Redis sessions
REDIS_CLIENT=predis # or phpredis
SESSION_DRIVER=redis
SESSION_CONNECTION=default
```

### 3. KYC Middleware Issues

**Problem**: KYC verification middleware blocking legitimate users

**Symptoms**:
- Verified users getting KYC required errors
- Middleware not recognizing KYC status
- Incorrect redirects

**Solutions**:
```php
// app/Http/Middleware/EnsureKycIsCompleted.php
public function handle(Request $request, Closure $next)
{
    $user = auth()->user();
    
    // Skip check for specific routes
    if ($request->routeIs(['kyc.upload', 'kyc.status', 'user.profile'])) {
        return $next($request);
    }
    
    // Check KYC status properly
    if (!$user || $user->kyc_status !== 'approved') {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'KYC verification required',
                'error_code' => 'KYC_REQUIRED'
            ], 403);
        }
        
        return redirect()->route('kyc.form')->with('error', 'KYC verification required');
    }
    
    return $next($request);
}

// Clear route cache
php artisan route:clear
php artisan optimize
```

## API Integration Issues

### 1. Binance API Rate Limiting

**Problem**: Binance API calls failing with rate limit errors

**Symptoms**:
- 429 Too Many Requests errors
- API responses failing intermittently
- Price data not updating

**Solutions**:
```php
// app/Services/CryptoService.php with rate limiting
class CryptoService
{
    private const RATE_LIMIT_KEY = 'binance_api_calls';
    private const MAX_CALLS_PER_MINUTE = 1200; // Binance limit
    
    public function getCurrentPrice(string $symbol): float
    {
        if (!$this->checkRateLimit()) {
            // Return cached price if rate limited
            return Cache::get("crypto_price_fallback_{$symbol}", 0.0);
        }
        
        return $this->fetchFromBinance($symbol);
    }
    
    private function checkRateLimit(): bool
    {
        $key = self::RATE_LIMIT_KEY . ':' . now()->format('Y-m-d:H:i');
        $current = Cache::get($key, 0);
        
        if ($current >= self::MAX_CALLS_PER_MINUTE) {
            Log::warning('Binance API rate limit approached', ['current' => $current]);
            return false;
        }
        
        Cache::put($key, $current + 1, 60); // 1 minute TTL
        return true;
    }
}

// Implement exponential backoff
private function fetchWithBackoff(string $url, int $maxRetries = 3): array
{
    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $response = Http::timeout(10)->get($url);
            
            if ($response->status() === 429) {
                $waitTime = pow(2, $i); // Exponential backoff: 1s, 2s, 4s
                sleep($waitTime);
                continue;
            }
            
            return $response->json();
            
        } catch (\Exception $e) {
            if ($i === $maxRetries - 1) {
                throw $e;
            }
        }
    }
}
```

### 2. Stripe Webhook Signature Verification Failures

**Problem**: Stripe webhooks failing signature verification

**Symptoms**:
- Webhook events not processed
- 400 Bad Request responses from webhook endpoint
- Payment status not updating

**Solutions**:
```php
// app/Http/Controllers/StripeWebhookController.php
public function handle(Request $request)
{
    $payload = $request->getContent();
    $signature = $request->header('Stripe-Signature');
    
    try {
        // Verify webhook signature
        $event = \Stripe\Webhook::constructEvent(
            $payload,
            $signature,
            config('stripe.webhook_secret')
        );
        
        Log::info('Stripe webhook received', ['type' => $event->type]);
        
        // Process event
        return $this->processWebhookEvent($event);
        
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        Log::error('Stripe webhook signature verification failed', [
            'error' => $e->getMessage(),
            'payload_excerpt' => substr($payload, 0, 100)
        ]);
        
        return response('Invalid signature', 400);
    }
}

// Ensure webhook endpoint is excluded from CSRF protection
// app/Http/Middleware/VerifyCsrfToken.php
protected $except = [
    'webhooks/stripe',
    'webhooks/paystack',
    'webhooks/*',
];
```

## Component & Frontend Issues

### 1. Component Not Rendering

**Problem**: Custom Blade components showing as plain HTML

**Symptoms**:
- Component tags rendered literally
- No component functionality
- Missing styles/scripts

**Solutions**:
```bash
# 1. Clear view cache
php artisan view:clear

# 2. Check component registration
# app/View/Components/Financial/AmountDisplay.php
<?php
namespace App\View\Components\Financial;

use Illuminate\View\Component;

class AmountDisplay extends Component
{
    public function __construct(
        public float $amount,
        public string $currency = 'USD'
    ) {}
    
    public function render()
    {
        return view('components.financial.amount-display');
    }
}

# 3. Register component in service provider (if needed)
# app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Blade;

public function boot()
{
    Blade::component('financial.amount-display', AmountDisplay::class);
}

# 4. Check component view file exists
# resources/views/components/financial/amount-display.blade.php
```

### 2. Tailwind CSS Not Loading

**Problem**: Styles not applied, classes not working

**Symptoms**:
- Unstyled appearance
- Tailwind classes not taking effect
- Build process issues

**Solutions**:
```bash
# 1. Rebuild assets
npm run dev

# 2. Check Tailwind config
# tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php', // Include PHP files for dynamic classes
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

# 3. Force rebuild and clear browser cache
npm run build
php artisan optimize:clear

# 4. Check if CSS is being loaded
# View source and verify CSS link exists
# <link rel="stylesheet" href="/build/assets/app-[hash].css">
```

## Performance Issues

### 1. Slow Page Load Times

**Problem**: Application pages loading slowly

**Symptoms**:
- High Time to First Byte (TTFB)
- Slow database queries
- Memory exhaustion

**Diagnosis**:
```bash
# Profile application
composer require --dev barryvdh/laravel-debugbar
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

# Check memory usage
php artisan tinker
>>> memory_get_usage(true);

# Monitor slow queries
sudo tail -f /var/log/mysql/slow.log

# Check OPcache status
php -r "print_r(opcache_get_status());"
```

**Solutions**:
```php
// 1. Implement query optimization
// ✅ Good: Eager loading
$users = User::with(['deposits:id,user_id,amount,status', 'plans:id,user_id,plan_id,status'])
             ->select(['id', 'name', 'email', 'account_bal'])
             ->limit(50)
             ->get();

// ❌ Bad: N+1 queries
$users = User::all();
foreach ($users as $user) {
    echo $user->deposits->count(); // Each iteration hits DB
}

// 2. Implement caching
class UserService 
{
    public function getUserDashboardData(User $user): array
    {
        return Cache::remember(
            "user_dashboard_{$user->id}",
            300, // 5 minutes
            fn() => $this->calculateDashboardData($user)
        );
    }
}

// 3. Optimize OPcache for production
// /etc/php/8.3/fpm/conf.d/10-opcache.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=10000
opcache.revalidate_freq=0
opcache.validate_timestamps=0 // Disable in production
opcache.save_comments=0
opcache.fast_shutdown=1
```

### 2. Memory Limit Exhaustion

**Problem**: PHP memory limit reached during operations

**Solutions**:
```bash
# 1. Increase memory limit temporarily
php -d memory_limit=512M artisan command:run

# 2. Use chunking for large datasets
User::chunk(100, function ($users) {
    foreach ($users as $user) {
        $this->processUser($user);
    }
});

# 3. Use lazy collections for memory efficiency
User::lazy()->each(function ($user) {
    $this->processUser($user);
});

# 4. Clean up variables in loops
foreach ($largeDataset as $item) {
    $result = $this->processItem($item);
    // Process result
    unset($result, $item); // Free memory
}
```

## Queue & Background Jobs

### 1. Queue Workers Not Processing Jobs

**Problem**: Jobs stuck in queue, not being processed

**Symptoms**:
- Failed jobs table filling up
- Background tasks not executing
- Email/notification delays

**Diagnosis**:
```bash
# Check queue status
php artisan queue:work --once
php artisan horizon:status

# List failed jobs
php artisan queue:failed

# Monitor queue in real-time
php artisan queue:monitor redis:default --max=100
```

**Solutions**:
```bash
# 1. Restart queue workers
php artisan queue:restart

# 2. Process failed jobs
php artisan queue:retry all

# 3. Check supervisor configuration
# /etc/supervisor/conf.d/monexa-worker.conf
[program:monexa-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/monexa/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=3
redirect_stderr=true
stdout_logfile=/var/www/monexa/storage/logs/worker.log

# 4. Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl restart monexa-worker:*
```

### 2. Job Timeout Issues

**Problem**: Long-running jobs timing out

**Solutions**:
```php
// app/Jobs/ProcessLargeDataset.php
class ProcessLargeDataset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 300; // 5 minutes
    public $tries = 3;
    public $maxExceptions = 2;
    
    public function handle()
    {
        // Set time limit
        set_time_limit(300);
        
        // Process in chunks
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($this->shouldStop()) {
                    break;
                }
                
                $this->processUser($user);
            }
        });
    }
    
    private function shouldStop(): bool
    {
        // Check if we're approaching timeout
        return (microtime(true) - LARAVEL_START) > ($this->timeout - 30);
    }
}
```

## File Upload Issues

### 1. Large File Upload Failures

**Problem**: File uploads failing for large files (KYC documents, etc.)

**Symptoms**:
- Upload timeouts
- 413 Request Entity Too Large errors
- Blank responses

**Solutions**:
```bash
# 1. PHP configuration
# /etc/php/8.3/fpm/php.ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M

# 2. Nginx configuration
# /etc/nginx/sites-available/monexa
client_max_body_size 10M;
client_body_timeout 300s;
client_header_timeout 300s;

# 3. Laravel validation
// app/Http/Requests/KycUploadRequest.php
public function rules(): array
{
    return [
        'identity_front' => [
            'required',
            'file',
            'mimes:jpeg,png,pdf',
            'max:5120' // 5MB in kilobytes
        ],
    ];
}

# 4. Restart services
sudo systemctl restart php8.3-fpm nginx
```

### 2. File Storage Permission Issues

**Problem**: Uploaded files not accessible or storage errors

**Solutions**:
```bash
# 1. Fix storage permissions
sudo chmod -R 775 storage
sudo chown -R www-data:www-data storage
sudo chmod -R 775 bootstrap/cache
sudo chown -R www-data:www-data bootstrap/cache

# 2. Create symbolic link for public storage
php artisan storage:link

# 3. Check S3 configuration (if using cloud storage)
# .env
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=monexa-storage
AWS_USE_PATH_STYLE_ENDPOINT=false

# 4. Test S3 connectivity
php artisan tinker
>>> Storage::disk('s3')->put('test.txt', 'Hello World');
>>> Storage::disk('s3')->get('test.txt');
```

## Email & Notification Issues

### 1. Emails Not Being Sent

**Problem**: Email notifications not reaching users

**Symptoms**:
- No emails in user inboxes
- Mail queue filling up
- SMTP connection errors

**Diagnosis**:
```bash
# Check mail configuration
php artisan config:show mail

# Test email sending
php artisan tinker
>>> Mail::raw('Test email', function ($message) {
>>>     $message->to('test@example.com')->subject('Test');
>>> });

# Check mail logs
tail -f storage/logs/laravel.log | grep -i mail
```

**Solutions**:
```bash
# 1. Verify SMTP configuration
# .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@monexa.app"
MAIL_FROM_NAME="Monexa Platform"

# 2. Test SMTP connection
php artisan tinker
>>> use Illuminate\Support\Facades\Mail;
>>> Mail::raw('Test', fn($msg) => $msg->to('test@example.com')->subject('Test'));

# 3. Check queue for email jobs
php artisan queue:work --queue=emails

# 4. For development, use log driver
MAIL_MAILER=log
```

### 2. Notification System Issues

**Problem**: In-app notifications not working properly

**Solutions**:
```php
// app/Services/NotificationService.php - Fix notification creation
public function createUserNotification($userId, $title, $message, $type = 'info'): void
{
    try {
        DB::transaction(function () use ($userId, $title, $message, $type) {
            Notification::create([
                'user_id' => $userId,
                'admin_id' => null,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'read' => false,
                'created_at' => now(),
            ]);
            
            // Broadcast to user if using websockets
            broadcast(new NotificationCreated($userId, $title, $message, $type));
        });
        
    } catch (\Exception $e) {
        Log::error('Failed to create notification', [
            'user_id' => $userId,
            'title' => $title,
            'error' => $e->getMessage()
        ]);
    }
}

// Clear notification cache after creation
Cache::forget("user_notifications_{$userId}");
Cache::forget("unread_count_{$userId}");
```

## Development Environment Issues

### 1. Vite Build Errors

**Problem**: Asset compilation failing with Vite

**Solutions**:
```bash
# 1. Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# 2. Check Vite configuration
# vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
    },
});

# 3. Update package.json scripts
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  }
}

# 4. Force rebuild
npm run build
```

### 2. Docker/Sail Issues

**Problem**: Laravel Sail containers not working properly

**Solutions**:
```bash
# 1. Rebuild containers
./vendor/bin/sail down
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d

# 2. Check service status
./vendor/bin/sail ps

# 3. View service logs
./vendor/bin/sail logs mysql
./vendor/bin/sail logs redis

# 4. Reset everything (nuclear option)
./vendor/bin/sail down --volumes --remove-orphans
docker system prune -a
./vendor/bin/sail up -d

# 5. Database connection issues in Sail
# .env
DB_HOST=mysql # Use service name, not localhost
REDIS_HOST=redis # Use service name, not 127.0.0.1
```

---

**Son Güncelleme**: 31 Ekim 2025  
**Versiyon**: 3.0  
**Support Contact**: [technical-support@monexa.app](mailto:technical-support@monexa.app)  
**Emergency Hotline**: +1-XXX-XXX-XXXX