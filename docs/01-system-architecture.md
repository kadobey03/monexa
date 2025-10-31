# Monexa Fintech Platform - System Architecture Documentation

## İçindekiler
- [Sistem Genel Bakış](#sistem-genel-bakış)
- [3-Tier Architecture](#3-tier-architecture)
- [Katman Sorumlulukları](#katman-sorumlulukları)
- [Teknoloji Stack'i](#teknoloji-stacki)
- [Güvenlik Mimarisi](#güvenlik-mimarisi)
- [İş Kuralları](#iş-kuralları)
- [Entegrasyon Noktaları](#entegrasyon-noktaları)

## Sistem Genel Bakış

**Monexa**, Laravel 12 tabanlı modern bir fintech trading platformudur. Platform, kullanıcıların yatırım planlarına katılmasına, kripto para işlemleri yapmasına, copy trading özelliklerini kullanmasına ve kapsamlı bir lead management sistemi aracılığıyla yönetilmesine olanak tanır.

### Temel Özellikler
- **Kullanıcı Yönetimi**: KYC doğrulaması, 2FA desteği
- **Finansal İşlemler**: Yatırım, çekim, komisyon hesaplamaları
- **Yatırım Planları**: Çoklu kategori destekli yatırım planları
- **Lead Management**: CRM benzeri lead takip ve yönetim sistemi
- **Copy Trading**: Uzman trader'ları takip etme sistemi
- **Crypto Trading**: Gerçek zamanlı crypto işlem desteği
- **Multi-language**: Türkçe odaklı, İngilizce destek
- **Real-time UI**: Livewire 3 tabanlı gerçek zamanlı arayüz

## 3-Tier Architecture

Platform, modern yazılım geliştirme prensiplerine uygun olarak **3-Tier Architecture** pattern'ini kullanır:

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                       │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Controllers   │  │  API Resources  │  │  Livewire   │ │
│  │                 │  │                 │  │ Components  │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                               │
┌─────────────────────────────────────────────────────────────┐
│                     BUSINESS LAYER                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │    Services     │  │    Observers    │  │    Events   │ │
│  │                 │  │                 │  │             │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                               │
┌─────────────────────────────────────────────────────────────┐
│                      DATA LAYER                             │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │  Repositories   │  │   Eloquent      │  │   Database  │ │
│  │                 │  │    Models       │  │             │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

## Katman Sorumlulukları

### Repository Layer (Data Access)
**Lokasyon**: [`app/Repositories/`](app/Repositories/) & [`app/Contracts/Repositories/`](app/Contracts/Repositories/)

**Sorumluluklar**:
- Tüm database işlemleri
- Query optimizasyonu
- Data integrity kontrolü
- Transaction yönetimi

**Temel Repository'ler**:
- [`UserRepository`](app/Repositories/UserRepository.php:15-160) - Kullanıcı data işlemleri
- [`DepositRepository`](app/Repositories/DepositRepository.php:18-289) - Yatırım data işlemleri  
- [`WithdrawalRepository`](app/Repositories/WithdrawalRepository.php:20-311) - Çekim data işlemleri
- [`PlanRepository`](app/Repositories/PlanRepository.php:14-180) - Plan data işlemleri

**Örnek Implementation**:
```php
// app/Repositories/DepositRepository.php
class DepositRepository implements DepositRepositoryInterface
{
    public function create(array $depositData): Deposit
    {
        return DB::transaction(function () use ($depositData) {
            return Deposit::create($depositData);
        });
    }
    
    public function findPendingDeposits(): Collection
    {
        return Deposit::where('status', 'pending')
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
```

### Service Layer (Business Logic)
**Lokasyon**: [`app/Services/`](app/Services/) & [`app/Services/Results/`](app/Services/Results/)

**Sorumluluklar**:
- İş kurallarının uygulanması
- Cross-cutting concerns
- Transaction boundary'leri
- Result object'leri ile response yönetimi

**Temel Service'ler**:
- [`FinancialService`](app/Services/FinancialService.php:22-344) - Finansal işlem business logic
- [`UserService`](app/Services/UserService.php:13-147) - Kullanıcı business logic
- [`PlanService`](app/Services/PlanService.php:18-210) - Plan yatırım business logic
- [`LeadScoringService`](app/Services/LeadScoringService.php:10-418) - Lead skorlama algoritması
- [`NotificationService`](app/Services/NotificationService.php:11-586) - Bildirim yönetimi

**Örnek Implementation**:
```php
// app/Services/FinancialService.php
class FinancialService
{
    public function processDeposit(array $depositData, User $user): DepositResult
    {
        return DB::transaction(function () use ($depositData, $user) {
            $this->validateDeposit($user, $depositData);
            
            $deposit = $this->depositRepository->create($depositData);
            $this->updateUserBalanceForDeposit($user, $deposit->amount);
            $this->calculateReferralCommission($deposit->amount, $user);
            
            return new DepositResult($deposit, true, 'Deposit processed successfully');
        });
    }
}
```

### Controller Layer (HTTP Handling)
**Lokasyon**: [`app/Http/Controllers/`](app/Http/Controllers/) & [`app/Http/Controllers/Api/`](app/Http/Controllers/Api/)

**Sorumluluklar**:
- HTTP request/response handling
- Request validation (FormRequest sınıfları ile)
- Service delegation
- Resource transformation

**Temel Controller'lar**:
- [`UserApiController`](routes/api.php:37-42) - Kullanıcı profil API endpoints
- [`FinancialApiController`](routes/api.php:45-57) - Finansal işlem endpoints
- [`PlanApiController`](routes/api.php:60-62) - Plan yatırım endpoints

**Örnek Implementation**:
```php
// app/Http/Controllers/Api/DepositApiController.php
class DepositApiController extends Controller
{
    public function store(DepositRequest $request): JsonResponse
    {
        $result = $this->financialService->processDeposit(
            $request->validated(), 
            auth()->user()
        );
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => new DepositResource($result->deposit)
        ], $result->success ? 201 : 400);
    }
}
```

## Teknoloji Stack'i

### Backend Framework
- **Laravel 12**: Modern PHP framework with PHP 8.3+ support
- **Sanctum**: Token-based API authentication
- **Livewire 3**: Reactive components for real-time UI
- **Jetstream**: Authentication scaffolding with 2FA support

### Database & Storage
- **MySQL 8.0+**: Primary database with optimized schema
- **Redis**: Caching ve session storage
- **Migration System**: 85+ migrations consolidated into single schema

### Third-Party Integrations
- **Stripe**: Payment gateway integration
- **Binance API**: Crypto price feeds
- **Sanctum**: API token management
- **Socialite**: Social login capabilities

### Development & Testing
- **PHPUnit**: Unit ve integration testing
- **Pint**: Code style enforcement
- **Vite**: Asset compilation and bundling

## Güvenlik Mimarisi

### Authentication & Authorization
```php
// Katmanlı güvenlik yaklaşımı
Route::middleware(['auth:sanctum', 'verified', 'kyc.complete'])->group(function () {
    // Finansal işlemler için KYC zorunlu
    Route::post('/financial/withdrawals', [WithdrawalApiController::class, 'store']);
});
```

**Güvenlik Katmanları**:
1. **Authentication**: Sanctum token-based auth
2. **Email Verification**: [`verified`](app/Http/Middleware/) middleware
3. **KYC Verification**: [`kyc.complete`](app/Http/Middleware/EnsureKycIsCompleted.php) middleware
4. **2FA Support**: Fortify TwoFactorAuthenticatable
5. **CRON Protection**: [`CRON_KEY`](.env.example:69-71) verification for automated tasks

### Input Validation & Sanitization
```php
// FormRequest sınıfları ile validation
class DepositRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:10', 'max:50000'],
            'payment_method' => ['required', 'in:crypto,bank,card'],
            'currency' => ['required', 'in:USD,EUR,GBP']
        ];
    }
}
```

## İş Kuralları

### Finansal İşlemler
- **Minimum Yatırım**: Plan bazlı minimum limitler
- **Commission Calculation**: Multi-level referral sistemi
- **Balance Verification**: Çekim öncesi balance kontrolü
- **Transaction Audit**: Tüm finansal işlemler log'lanır

### Lead Management
- **Lead Scoring**: Otomatik lead skorlama algoritması
- **Assignment Rules**: Hierarchy tabanlı atama kuralları
- **Follow-up Tracking**: Otomatik takip sistemi

### KYC & Compliance
- **Document Verification**: Multi-stage KYC süreci
- **Risk Assessment**: Otomatik risk değerlendirmesi
- **Compliance Monitoring**: Regulatory compliance tracking

## Entegrasyon Noktaları

### External APIs
```php
// Binance API entegrasyonu
class CryptoService
{
    public function getBinancePrice(string $symbol): float
    {
        $response = Http::get(config('binance.base_url') . '/api/v3/ticker/price', [
            'symbol' => $symbol
        ]);
        
        return (float) $response->json()['price'];
    }
}
```

### Webhook Endpoints
- **Stripe Webhooks**: Payment status updates
- **Crypto Webhooks**: Transaction confirmations
- **System Notifications**: Real-time event processing

### Queue System
```php
// Asenkron işlemler için queue kullanımı
dispatch(new ProcessDepositJob($deposit));
dispatch(new SendWelcomeEmailJob($user));
dispatch(new UpdateLeadScoreJob($lead));
```

## Performance Optimizasyonları

### Database Optimizations
- **Indexing Strategy**: Composite indexes for query optimization
- **Query Optimization**: Eager loading and query scopes
- **Connection Pooling**: Redis-based caching layer

### Caching Strategy
- **Config Caching**: [`php artisan config:cache`](config/)
- **Route Caching**: [`php artisan route:cache`](routes/)
- **View Caching**: [`php artisan view:cache`](resources/views/)
- **Application Caching**: Redis-based data caching

### Asset Optimization
- **Vite Bundling**: Modern asset compilation
- **CSS/JS Minification**: Production optimizations
- **Image Optimization**: Automated image processing

---

**Son Güncelleme**: 31 Ekim 2025  
**Versiyon**: 3.0 (Post-Refactoring)  
**Architecture Review**: Q4 2025