# Çok Dilli Destek Sistemi - API Dokümantasyonu

Bu dokümantasyon, Monexa Finance platformu çok dilli destek sistemi için geliştirici API'sini kapsamaktadır.

## 📋 İçindekiler

- [Service Layer API](#service-layer-api)
- [Repository Layer API](#repository-layer-api)
- [Cache Service API](#cache-service-api)
- [Laravel Helper Functions](#laravel-helper-functions)
- [HTTP API Endpoints](#http-api-endpoints)
- [Events & Listeners](#events--listeners)
- [Middleware Integration](#middleware-integration)

---

## 🎯 Service Layer API

### TranslationService

#### `translate(string $key, string $locale = null, array $replace = []): string`

Verilen anahtar için çeviri döndürür.

```php
use App\Services\TranslationService;

$service = app(TranslationService::class);

// Basit çeviri
$translation = $service->translate('auth.login', 'tr');
// Returns: "Giriş Yap"

// Parametreli çeviri
$translation = $service->translate('welcome.user', 'tr', ['name' => 'Ahmet']);
// Returns: "Hoş geldin, Ahmet!"

// Varsayılan locale kullanımı
$translation = $service->translate('auth.password');
// Current locale'e göre çeviri döner
```

#### `translateWithFallback(string $key, string $locale, string $fallbackLocale = 'tr'): string`

Fallback desteği ile çeviri döndürür.

```php
// Rusça çeviri yoksa Türkçe'ye fall back eder
$translation = $service->translateWithFallback('new.feature', 'ru', 'tr');
```

#### `getAllTranslations(string $locale): array`

Belirtilen dil için tüm çevirileri döndürür.

```php
$allTranslations = $service->getAllTranslations('tr');
/*
Returns:
[
    'auth' => [
        'login' => 'Giriş Yap',
        'password' => 'Şifre',
        'email' => 'E-posta'
    ],
    'admin' => [
        'dashboard' => 'Kontrol Paneli',
        'users' => 'Kullanıcılar'
    ]
]
*/
```

#### `getGroupTranslations(string $group, string $locale): array`

Belirtilen grup için çevirileri döndürür.

```php
$authTranslations = $service->getGroupTranslations('auth', 'tr');
/*
Returns:
[
    'login' => 'Giriş Yap',
    'password' => 'Şifre',
    'email' => 'E-posta',
    'register' => 'Kayıt Ol'
]
*/
```

#### `createPhrase(array $data): Phrase`

Yeni phrase ve çevirileri oluşturur.

```php
$phrase = $service->createPhrase([
    'key' => 'custom.welcome',
    'group' => 'custom',
    'description' => 'Welcome message for new users',
    'translations' => [
        'tr' => 'Hoş geldiniz',
        'ru' => 'Добро пожаловать'
    ]
]);
```

#### `updatePhrase(int $phraseId, array $data): bool`

Mevcut phrase'i günceller.

```php
$updated = $service->updatePhrase(123, [
    'description' => 'Updated description',
    'translations' => [
        'tr' => 'Güncellenmiş çeviri',
        'ru' => 'Обновленный перевод'
    ]
]);
```

#### `deletePhrase(int $phraseId): bool`

Phrase ve ilişkili çevirileri siler.

```php
$deleted = $service->deletePhrase(123);
```

#### `searchPhrases(string $query, array $groups = null): Collection`

Phrase'lerde arama yapar.

```php
// Tüm gruplarda ara
$results = $service->searchPhrases('login');

// Belirli gruplarda ara
$results = $service->searchPhrases('user', ['auth', 'admin']);
```

#### `getCompletionStats(): array`

Diller için completion istatistiklerini döndürür.

```php
$stats = $service->getCompletionStats();
/*
Returns:
[
    'tr' => ['completed' => 150, 'total' => 150, 'percentage' => 100.0],
    'ru' => ['completed' => 120, 'total' => 150, 'percentage' => 80.0]
]
*/
```

#### `warmCache(string $locale = null): void`

Cache'i ısıtır (pre-load).

```php
// Belirli dil için
$service->warmCache('tr');

// Tüm aktif diller için
$service->warmCache();
```

#### `clearCache(string $locale = null): void`

Cache'i temizler.

```php
// Belirli dil için
$service->clearCache('tr');

// Tüm diller için
$service->clearCache();
```

---

## 🗄️ Repository Layer API

### TranslationRepositoryInterface

#### `findPhraseByKey(string $key): ?Phrase`

Anahtar ile phrase bulur.

```php
use App\Contracts\Repositories\TranslationRepositoryInterface;

$repository = app(TranslationRepositoryInterface::class);
$phrase = $repository->findPhraseByKey('auth.login');
```

#### `getTranslationsForPhrase(int $phraseId, string $locale = null): Collection`

Phrase için çevirileri getirir.

```php
$translations = $repository->getTranslationsForPhrase(123, 'tr');
```

#### `getGroupPhrases(string $group, string $locale): array`

Grup bazında phrase'leri getirir.

```php
$phrases = $repository->getGroupPhrases('auth', 'tr');
```

#### `createPhraseWithTranslations(array $phraseData, array $translations): Phrase`

Transaction içinde phrase ve çevirileri oluşturur.

```php
$phrase = $repository->createPhraseWithTranslations(
    [
        'key' => 'new.phrase',
        'group' => 'custom',
        'description' => 'New phrase description'
    ],
    [
        'tr' => 'Türkçe çeviri',
        'ru' => 'Русский перевод'
    ]
);
```

#### `bulkUpdateTranslations(array $updates): int`

Toplu çeviri güncellemesi.

```php
$updatedCount = $repository->bulkUpdateTranslations([
    ['phrase_id' => 1, 'language_id' => 1, 'translation' => 'Yeni çeviri 1'],
    ['phrase_id' => 2, 'language_id' => 1, 'translation' => 'Yeni çeviri 2']
]);
```

#### `getPhraseStats(): array`

Phrase istatistiklerini döndürür.

```php
$stats = $repository->getPhraseStats();
/*
Returns:
[
    'total_phrases' => 150,
    'total_translations' => 280,
    'completion_by_language' => [
        'tr' => 100.0,
        'ru' => 86.7
    ]
]
*/
```

#### `searchPhrasesWithTranslations(string $query, array $filters = []): Collection`

Çeviriler dahil phrase arama.

```php
$results = $repository->searchPhrasesWithTranslations('welcome', [
    'groups' => ['auth', 'admin'],
    'languages' => ['tr', 'ru'],
    'reviewed_only' => true
]);
```

---

## ⚡ Cache Service API

### CacheService

#### `remember(string $key, callable $callback, int $ttl = null): mixed`

Cache remember pattern implementasyonu.

```php
use App\Services\CacheService;

$cache = app(CacheService::class);

$translations = $cache->remember(
    "translations:tr:auth",
    function() use ($repository) {
        return $repository->getGroupPhrases('auth', 'tr');
    },
    3600
);
```

#### `tags(array $tags): CacheService`

Cache tag'leri ayarlar.

```php
$result = $cache->tags(['translations', 'tr'])
    ->remember('auth_phrases', $callback, 3600);
```

#### `invalidatePattern(string $pattern): int`

Pattern ile cache invalidation.

```php
// 'translations:tr:*' pattern'ine uyan tüm key'leri sil
$deletedCount = $cache->invalidatePattern('translations:tr:*');
```

#### `getMetrics(): array`

Cache performans metrikleri.

```php
$metrics = $cache->getMetrics();
/*
Returns:
[
    'hit_rate' => 0.875,
    'total_hits' => 1750,
    'total_misses' => 250,
    'memory_usage' => 12.5, // MB
    'avg_response_time' => 2.3 // ms
]
*/
```

#### `warmPattern(string $pattern, callable $warmer): int`

Pattern ile cache warming.

```php
$warmedCount = $cache->warmPattern('translations:*', function($key) {
    // Cache warming logic
    return $this->loadTranslationData($key);
});
```

---

## 🔧 Laravel Helper Functions

### Global Helper Functions

#### `__($key, $replace = [], $locale = null)`

Laravel'in standart translation helper'ı, database-driven olarak çalışır.

```php
// Basit kullanım
echo __('auth.login'); // "Giriş Yap"

// Parametreli kullanım
echo __('welcome.user', ['name' => $user->name]); // "Hoş geldin, Ahmet!"

// Belirli locale için
echo __('auth.login', [], 'ru'); // "Войти"
```

#### `trans($key, $replace = [], $locale = null)`

`__()` helper'ının alias'ı.

```php
echo trans('auth.password'); // "Şifre"
```

#### `trans_choice($key, $number, $replace = [], $locale = null)`

Pluralization desteği ile çeviri.

```php
echo trans_choice('messages.comments', 0); // "Yorum yok"
echo trans_choice('messages.comments', 1); // "1 yorum"  
echo trans_choice('messages.comments', 5); // "5 yorum"
```

### Custom Helper Functions

#### `translate_key($key, $locale = null, $fallback = true)`

Custom translation helper with advanced options.

```php
// Fallback ile
$translation = translate_key('new.feature', 'ru', true);

// Fallback olmadan (null dönebilir)
$translation = translate_key('new.feature', 'ru', false);
```

#### `get_available_locales()`

Aktif dilleri listeler.

```php
$locales = get_available_locales();
// Returns: ['tr', 'ru', 'en']
```

#### `current_locale()`

Aktif locale'i döndürür.

```php
$currentLocale = current_locale(); // 'tr'
```

---

## 🌐 HTTP API Endpoints

### REST API Routes

#### `GET /api/v1/translations/{locale}`

Belirtilen dil için tüm çevirileri getirir.

```bash
curl -X GET "https://app.monexa.com/api/v1/translations/tr" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "auth": {
      "login": "Giriş Yap",
      "password": "Şifre"
    },
    "admin": {
      "dashboard": "Kontrol Paneli"
    }
  },
  "meta": {
    "locale": "tr",
    "total_phrases": 150,
    "last_updated": "2024-01-15T10:30:00Z"
  }
}
```

#### `GET /api/v1/translations/{locale}/{group}`

Belirtilen grup için çevirileri getirir.

```bash
curl -X GET "https://app.monexa.com/api/v1/translations/tr/auth" \
  -H "Authorization: Bearer {token}"
```

#### `POST /api/v1/translations`

Yeni çeviri ekler (Admin yetkisi gerekli).

```bash
curl -X POST "https://app.monexa.com/api/v1/translations" \
  -H "Authorization: Bearer {admin-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "key": "custom.message",
    "group": "custom",
    "description": "Custom message",
    "translations": {
      "tr": "Özel mesaj",
      "ru": "Пользовательское сообщение"
    }
  }'
```

#### `PUT /api/v1/translations/{id}`

Çeviri günceller (Admin yetkisi gerekli).

```bash
curl -X PUT "https://app.monexa.com/api/v1/translations/123" \
  -H "Authorization: Bearer {admin-token}" \
  -H "Content-Type: application/json" \
  -d '{
    "translations": {
      "tr": "Güncellenmiş mesaj",
      "ru": "Обновленное сообщение"
    }
  }'
```

#### `DELETE /api/v1/translations/{id}`

Çeviri siler (Admin yetkisi gerekli).

```bash
curl -X DELETE "https://app.monexa.com/api/v1/translations/123" \
  -H "Authorization: Bearer {admin-token}"
```

### Admin Panel AJAX Endpoints

#### `POST /admin/phrases/bulk-update`

Toplu güncelleme.

```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.post('/admin/phrases/bulk-update', {
    updates: [
        {id: 1, translation: 'Yeni çeviri 1'},
        {id: 2, translation: 'Yeni çeviri 2'}
    ]
}, function(response) {
    if (response.success) {
        // Success handling
    }
});
```

#### `POST /admin/phrases/export`

Çeviri dışa aktarma.

```javascript
$.post('/admin/phrases/export', {
    format: 'json', // json, csv, excel
    locale: 'tr',
    groups: ['auth', 'admin']
}, function(response) {
    // Download handling
    window.open(response.download_url);
});
```

---

## 🎭 Events & Listeners

### Custom Events

#### `TranslationUpdated`

Çeviri güncellendiğinde tetiklenir.

```php
use App\Events\TranslationUpdated;

// Event firing
event(new TranslationUpdated($phrase, $language, $oldTranslation, $newTranslation));

// Event listener
class ClearTranslationCache
{
    public function handle(TranslationUpdated $event)
    {
        // Cache temizleme logic'i
        Cache::tags(['translations', $event->language->code])
            ->flush();
    }
}
```

#### `LanguageActivated`

Yeni dil aktifleştirildiğinde tetiklenir.

```php
use App\Events\LanguageActivated;

event(new LanguageActivated($language));
```

#### `PhraseCreated`

Yeni phrase oluşturulduğunda tetiklenir.

```php
use App\Events\PhraseCreated;

event(new PhraseCreated($phrase));
```

### Event Listeners Registration

```php
// EventServiceProvider.php
protected $listen = [
    TranslationUpdated::class => [
        ClearTranslationCache::class,
        UpdateCompletionStats::class,
        LogTranslationChange::class,
    ],
    LanguageActivated::class => [
        WarmCacheForLanguage::class,
        NotifyAdminUsers::class,
    ],
    PhraseCreated::class => [
        CreateMissingTranslations::class,
        UpdateUsageStats::class,
    ],
];
```

---

## 🛡️ Middleware Integration

### SetLocale Middleware

Automatic locale detection ve setting.

```php
use App\Http\Middleware\SetLocale;

// routes/web.php
Route::middleware(['web', 'setlocale'])->group(function () {
    // Routes that need translation
});

// Manual locale setting
app()->setLocale('ru');
```

### TranslationAuth Middleware

Translation yönetimi için yetkilendirme.

```php
use App\Http\Middleware\TranslationAuth;

// routes/admin.php
Route::middleware(['admin', 'translation.auth'])->group(function () {
    Route::resource('phrases', PhrasesController::class);
});
```

---

## 🔍 Advanced Usage Patterns

### Service Container Integration

```php
// Service provider registration
$this->app->singleton(TranslationServiceInterface::class, function ($app) {
    return new TranslationService(
        $app[TranslationRepositoryInterface::class],
        $app[CacheService::class],
        $app['config']['app.locale']
    );
});

// Facade usage
use App\Facades\Translation;

Translation::translate('auth.login', 'tr');
Translation::warmCache();
Translation::getCompletionStats();
```

### Custom Translation Loaders

```php
use App\Services\Translation\DatabaseTranslationLoader;

class CustomTranslationLoader extends DatabaseTranslationLoader
{
    public function load($locale, $group, $namespace = null)
    {
        // Custom loading logic
        $translations = parent::load($locale, $group, $namespace);
        
        // Apply business rules
        return $this->applyBusinessRules($translations, $locale);
    }
}
```

### Performance Monitoring Integration

```php
use App\Services\PerformanceMonitoringService;

class TranslationPerformanceMiddleware
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        
        $response = $next($request);
        
        $duration = microtime(true) - $start;
        
        app(PerformanceMonitoringService::class)
            ->recordTranslationRequest($request->path(), $duration);
        
        return $response;
    }
}
```

---

## 📊 Error Handling

### Exception Types

```php
use App\Exceptions\TranslationException;
use App\Exceptions\TranslationNotFoundException;
use App\Exceptions\InvalidLocaleException;

try {
    $translation = $service->translate('nonexistent.key', 'invalid_locale');
} catch (TranslationNotFoundException $e) {
    // Handle missing translation
    Log::warning('Translation not found', ['key' => $e->getKey()]);
    return $e->getKey(); // Fallback to key
} catch (InvalidLocaleException $e) {
    // Handle invalid locale
    app()->setLocale(config('app.fallback_locale'));
    return $service->translate('nonexistent.key');
} catch (TranslationException $e) {
    // Handle general translation errors
    Log::error('Translation error', ['message' => $e->getMessage()]);
    return 'Error loading translation';
}
```

### Logging and Monitoring

```php
// config/logging.php
'channels' => [
    'translation' => [
        'driver' => 'daily',
        'path' => storage_path('logs/translation.log'),
        'level' => 'info',
        'days' => 14,
    ],
],

// Usage
Log::channel('translation')->info('Translation cache warmed', [
    'locale' => $locale,
    'phrases_count' => $count,
    'duration' => $duration
]);
```

---

Bu API dokümantasyonu, sistemin tüm programmatik arayüzlerini kapsamaktadır. Herhangi bir sorunla karşılaştığınızda veya ek özellik gereksinimi duyduğunuzda, bu dokümantasyonu referans alarak geliştiriniz.