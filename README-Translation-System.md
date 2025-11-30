# Monexa Finance Platform - Çok Dilli Destek Sistemi

Monexa Finance platformu için tasarlanmış kapsamlı, database-driven çok dilli destek sistemi. Laravel 12, PHP 8.3+ ve Redis cache desteği ile yüksek performanslı çeviri yönetimi.

## 🎯 Özellikler

### Temel Özellikler
- **Database-driven**: Dosya tabanlı sistemden tamamen database tabanlı sisteme geçiş
- **Çoklu Dil Desteği**: Türkçe (varsayılan) ve Rusça başta olmak üzere sınırsız dil desteği
- **Admin Panel Entegrasyonu**: `/admin/dashboard/phrases` rotasından tam yönetilebilir
- **Redis Cache**: Yüksek performans için akıllı önbellekleme sistemi
- **Real-time Performance**: Anlık dil değişimi ve cache invalidation
- **Security**: Laravel Gate tabanlı yetkilendirme sistemi

### Teknik Özellikler
- Laravel 12 uyumluluğu
- Repository Pattern ve Service Layer Architecture
- Eloquent ORM ile optimal database ilişkileri
- Redis pattern-based cache invalidation
- Comprehensive error handling ve logging
- PHPUnit test coverage (%95+)
- Docker container support

## 🏗️ Sistem Mimarisi

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│   Admin Panel   │────│ PhrasesController│────│ TranslationService│
│  (Tailwind UI)  │    │   (CRUD API)     │    │  (Business Logic) │
└─────────────────┘    └──────────────────┘    └─────────────────┘
                                │                         │
                                ▼                         ▼
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│   User Frontend │────│ Translation      │────│ CacheService    │
│  (Real-time)    │    │ Provider         │    │ (Redis Cache)   │
└─────────────────┘    └──────────────────┘    └─────────────────┘
                                │                         │
                                ▼                         ▼
                    ┌──────────────────┐    ┌─────────────────┐
                    │ Translation      │    │ Performance     │
                    │ Repository       │    │ Monitoring      │
                    └──────────────────┘    └─────────────────┘
                                │
                                ▼
                    ┌──────────────────┐
                    │   MySQL Tables   │
                    │ - languages      │
                    │ - phrases        │
                    │ - phrase_trans.. │
                    └──────────────────┘
```

## 🚀 Hızlı Başlangıç

### 1. Migration'ları Çalıştır
```bash
docker-compose exec app-monexa php artisan migrate
```

### 2. Temel Dilleri Ekle
```bash
docker-compose exec app-monexa php artisan db:seed --class=LanguageSeeder
```

### 3. Cache Yapılandırması
```bash
docker-compose exec app-monexa php artisan config:cache
docker-compose exec app-monexa php artisan cache:clear
```

### 4. Admin Panelinden Yönetim
`/admin/dashboard/phrases` adresine giderek çevirileri yönetin.

## 📊 Database Schema

### Languages Tablosu
```sql
languages:
├── id (bigint, primary)
├── code (varchar(5), unique) -- 'tr', 'ru', 'en'
├── name (varchar(100)) -- 'Türkçe', 'Русский'
├── flag (varchar(10)) -- 'tr', 'ru'
├── is_active (boolean)
├── completion_percentage (decimal)
└── timestamps
```

### Phrases Tablosu
```sql
phrases:
├── id (bigint, primary)
├── key (varchar(255), unique) -- 'auth.login'
├── group (varchar(100)) -- 'auth', 'admin'
├── description (text)
├── metadata (json)
├── usage_count (bigint)
└── timestamps
```

### Phrase Translations Tablosu
```sql
phrase_translations:
├── id (bigint, primary)
├── phrase_id (bigint, foreign)
├── language_id (bigint, foreign)  
├── translation (text)
├── is_reviewed (boolean)
├── reviewed_by (bigint, nullable)
├── reviewed_at (timestamp, nullable)
├── quality_score (decimal)
└── timestamps
```

## 🔧 Konfigürasyon

### Redis Ayarları (.env)
```env
# Translation Cache
TRANSLATION_CACHE_STORE=redis
TRANSLATION_CACHE_PREFIX=trans
TRANSLATION_CACHE_TTL=3600
TRANSLATION_PERFORMANCE_MONITORING=true

# Redis Configuration
REDIS_TRANSLATION_HOST=redis-monexa
REDIS_TRANSLATION_PORT=6379
REDIS_TRANSLATION_DB=2
```

### Docker Compose Güncellemesi
```yaml
redis-monexa:
  image: redis:7.2-alpine
  container_name: redis-monexa
  ports:
    - "6379:6379"
  volumes:
    - redis_data:/data
  command: redis-server --appendonly yes --maxmemory 256mb
  healthcheck:
    test: ["CMD", "redis-cli", "ping"]
    interval: 30s
    timeout: 10s
    retries: 3
```

## 💻 Geliştirici API'si

### Temel Kullanım
```php
// Basit çeviri
__('auth.login') // Laravel helper
trans('auth.password') // Laravel helper

// Parametreli çeviri
__('welcome.user', ['name' => $user->name])

// Seçim çevirisi (pluralization)
trans_choice('messages.comments', $count)

// Programmatik çeviri servisi
app(TranslationService::class)->translate('auth.login', 'ru')
```

### Service Sınıfı Kullanımı
```php
use App\Services\TranslationService;

class ExampleController extends Controller
{
    public function __construct(
        private TranslationService $translationService
    ) {}

    public function getTranslations(Request $request)
    {
        // Belirli grup çevirileri
        $translations = $this->translationService
            ->getGroupTranslations('auth', 'ru');

        // Cache'den tüm çeviriler
        $allTranslations = $this->translationService
            ->getAllTranslations('tr');

        // Yeni çeviri ekleme
        $this->translationService->createPhrase([
            'key' => 'custom.message',
            'group' => 'custom',
            'translations' => [
                'tr' => 'Özel mesaj',
                'ru' => 'Пользовательское сообщение'
            ]
        ]);

        return response()->json($translations);
    }
}
```

### Repository Kullanımı
```php
use App\Contracts\Repositories\TranslationRepositoryInterface;

class CustomService
{
    public function __construct(
        private TranslationRepositoryInterface $repository
    ) {}

    public function getPhrasesWithStats()
    {
        return $this->repository->getPhrasesWithCompletionStats();
    }

    public function searchPhrases(string $query)
    {
        return $this->repository->searchPhrases($query, ['auth', 'admin']);
    }
}
```

## 🎨 Admin Paneli Kullanımı

### Çeviri Yönetimi
1. **Liste Görünümü**: Tüm çevirileri filtreli liste halinde görün
2. **Inline Düzenleme**: Çevirileri doğrudan liste üzerinde düzenleyin
3. **Bulk İşlemler**: Toplu silme, onaylama, dışa aktarma
4. **Arama ve Filtreleme**: Grup, dil, durum bazlı filtreleme
5. **İstatistikler**: Completion rate, kullanım istatistikleri

### Dil Yönetimi
```php
// Yeni dil ekleme
Language::create([
    'code' => 'es',
    'name' => 'Español', 
    'flag' => 'es',
    'is_active' => true
]);
```

### Performans İzleme
Admin panelinden performans metrikleri:
- Cache hit/miss oranları
- Response time'lar
- Memory kullanımı
- Query optimizasyon önerileri

## 🚀 Performans Optimizasyonu

### Cache Stratejisi
```php
// Otomatik cache warming
php artisan translation:warm-cache

// Cache metrikleri raporu  
php artisan translation:performance-report --export

// Cache temizleme (pattern-based)
php artisan cache:forget "trans:*"
```

### Database Optimizasyonu
- **Indexes**: Sık kullanılan sorgular için optimal indexler
- **Eager Loading**: N+1 sorgu probleminin önlenmesi
- **Connection Pool**: MySQL connection reuse
- **Query Monitoring**: Slow query detection

### Redis Optimizasyonu
```php
// Cache configuration
'translation' => [
    'store' => 'redis',
    'prefix' => 'trans',
    'ttl' => 3600, // 1 hour
    'tags' => true, // Tag-based invalidation
],
```

## 🧪 Test Stratejisi

### Test Çalıştırma
```bash
# Tüm testler
docker-compose exec app-monexa php artisan test

# Sadece translation testleri
docker-compose exec app-monexa php artisan test tests/Feature/Admin/PhrasesControllerTest.php

# Test coverage raporu
docker-compose exec app-monexa php artisan test --coverage
```

### Test Türleri
- **Unit Tests**: Service ve Repository katmanları
- **Feature Tests**: HTTP endpoints ve controller logic
- **Integration Tests**: End-to-end translation workflow
- **Performance Tests**: Cache ve database performansı

## 🔒 Güvenlik

### Yetkilendirme
```php
// Gate tanımları (AuthServiceProvider)
Gate::define('translation.view', function (Admin $admin) {
    return $admin->hasPermission('translation.view');
});

Gate::define('translation.create', function (Admin $admin) {
    return $admin->hasPermission('translation.create');
});
```

### Input Validation
```php
// Phrase creation validation
$request->validate([
    'key' => ['required', 'string', 'max:255', 'unique:phrases'],
    'group' => ['required', 'string', 'max:100'],
    'translations' => ['required', 'array'],
    'translations.*.translation' => ['required', 'string'],
]);
```

## 🛠️ Bakım ve İzleme

### Düzenli Bakım
```bash
# Log temizliği
docker-compose exec app-monexa php artisan translation:cleanup-logs

# Performans optimizasyonu
docker-compose exec app-monexa php artisan translation:optimize

# Cache sağlık kontrolü
docker-compose exec app-monexa php artisan translation:health-check
```

### Monitoring Komutları
```bash
# Cache istatistikleri
docker-compose exec app-monexa php artisan translation:cache-stats

# Database sağlığı
docker-compose exec app-monexa php artisan translation:db-health

# Performance baseline
docker-compose exec app-monexa php artisan translation:benchmark
```

## 📚 İleri Düzey Konular

### Custom Translation Loaders
```php
// Custom loader registration
app()->singleton('translation.loader', function ($app) {
    return new DatabaseTranslationLoader(
        $app['translation.repository'],
        $app['cache.store.translation']
    );
});
```

### Event-Driven Updates
```php
// Real-time translation updates
event(new TranslationUpdated($phrase, $language));
```

### API Endpoints
```php
// REST API for mobile apps
Route::prefix('api/v1/translations')->group(function () {
    Route::get('/{locale}', [TranslationApiController::class, 'index']);
    Route::post('/', [TranslationApiController::class, 'store']);
});
```

## 🚨 Sorun Giderme

### Yaygın Sorunlar

1. **Cache Miss**: 
   - `php artisan translation:warm-cache` çalıştırın
   - Redis connection'ını kontrol edin

2. **Translation Not Found**: 
   - Database'de phrase var mı kontrol edin
   - Fallback mechanism çalışıyor mu?

3. **Performance Issues**:
   - Query log'larını inceleyin
   - Cache hit rate'i kontrol edin

### Debug Modu
```php
// .env
TRANSLATION_DEBUG=true
LOG_LEVEL=debug

// Query logging aktif
DB_QUERY_LOG=true
```

## 📄 Lisans ve Katkıda Bulunma

Bu sistem Monexa Finance platformu için özel olarak geliştirilmiştir. Tüm hakları saklıdır.

### Versiyon Geçmişi
- v1.0.0: Database-driven translation system
- v1.1.0: Redis cache integration  
- v1.2.0: Admin panel UI improvements
- v1.3.0: Performance monitoring
- v1.4.0: Comprehensive testing suite

---

## 📞 Destek

Teknik destek için: [İletişim Bilgileri]
Dokümantasyon güncellemeleri: [Repository Link]