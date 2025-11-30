<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\TranslationServiceProvider as LaravelTranslationServiceProvider;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Repositories\TranslationRepository;
use App\Services\TranslationService;
use App\Services\CacheService;
use App\Services\PerformanceMonitoringService;
use App\Services\DatabaseTranslationLoader;
use App\Providers\DatabaseTranslationProvider;

/**
 * Database Translation Service Provider
 * 
 * Bu ServiceProvider, database-driven çeviri sisteminin tüm bileşenlerini
 * Laravel'in dependency injection container'ına kaydeder ve sistemi yapılandırır.
 * 
 * Özellikler:
 * - Repository pattern binding
 * - Service sınıfları kaydı
 * - Custom Translation Provider entegrasyonu
 * - Cache konfigürasyonu
 * - Performance optimizasyonları
 */
class DatabaseTranslationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Bu method, servisleri container'a kaydetmek için kullanılır.
     * Lazy loading ve singleton pattern kullanarak performansı optimize eder.
     */
    public function register(): void
    {
        // Repository Interface Binding
        $this->app->bind(TranslationRepositoryInterface::class, TranslationRepository::class);

        // PerformanceMonitoringService - Singleton olarak kaydet
        $this->app->singleton(PerformanceMonitoringService::class, function ($app) {
            return new PerformanceMonitoringService();
        });

        // Cache Service - Singleton olarak kaydet
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService(
                $app['config']['cache.default'] ?? 'redis',  // string store name
                'translation',                                // string prefix
                60                                           // int default TTL
            );
        });

        // Translation Service - Repository ve Cache bağımlılıkları ile
        $this->app->singleton(TranslationService::class, function ($app) {
            return new TranslationService(
                $app[TranslationRepositoryInterface::class],
                $app[CacheService::class],
                $app[PerformanceMonitoringService::class]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * Bu method, uygulama bootstrap edilirken çağrılır.
     * Translation driver'ını configure eder ve cache stratejilerini başlatır.
     */
    public function boot(): void
    {
        // Laravel Translation Manager entegrasyonu - Düzeltilmiş yaklaşım
        $this->replaceTranslationLoader();
        
        // Production'da translation cache warming et (sadece production'da)
        // $this->warmTranslationCache();
    }

    /**
     * Translation Manager'a Database Driver'ını Extend Et
     *
     * Laravel'in Translation Manager'ına özel database driver'ımızı ekler.
     * Bu sayede config/app.php'de 'database' driver'ı kullanılabilir.
     */
    protected function extendTranslationManager(): void
    {
        $this->app['translator']->extend('database', function ($app, $config) {
            return new DatabaseTranslationProvider(
                $app[TranslationService::class],
                $app['config']['app.locale'],
                $app['config']['app.fallback_locale']
            );
        });
    }

    /**
     * Translation Driver Konfigürasyonu
     *
     * Uygulama başlatılırken translation driver'ını database olarak ayarlar.
     * Config cache'i varsa bunu günceller.
     */
    protected function configureTranslationDriver(): void
    {
        // Runtime'da driver'ı değiştir
        $this->app['config']->set('translation.driver', 'database');
        
        // Translation Manager'ı yeniden başlat
        $this->app->forgetInstance('translator');
        $this->app->extend('translator', function ($translator, $app) {
            return $app['translation.loader']->createTranslator($app['config']['app.locale']);
        });
    }

    /**
     * Translation Cache'ini Warming Et
     *
     * Uygulama başlatıldığında frequently used translation'ları cache'e yükler.
     * Bu sayede ilk isteklerde performans artışı sağlanır.
     */
    protected function warmTranslationCache(): void
    {
        // Production ortamında ve cache aktifse warming yap
        if ($this->app->environment('production') && $this->app['config']['cache.default'] !== 'array') {
            $this->app->booted(function () {
                try {
                    $translationService = $this->app[TranslationService::class];
                    $cacheService = $this->app[CacheService::class];

                    // Aktif dilleri cache'e yükle
                    $activeLanguages = $translationService->getActiveLanguages();
                    foreach ($activeLanguages as $language) {
                        // Core sistem çevirilerini warming et
                        $this->warmCoreTranslations($translationService, $language->code);
                    }

                    // Cache statistics'i initialize et
                    $cacheService->initializeStatistics();
                } catch (\Exception $e) {
                    // Warming hatası critical değil, log'la ve devam et
                    logger()->warning('Translation cache warming failed: ' . $e->getMessage());
                }
            });
        }
    }

    /**
     * Core Translation'ları Warming Et
     *
     * Sistem açılışında en sık kullanılan çevirileri cache'e yükler.
     * 
     * @param TranslationService $service
     * @param string $locale
     */
    protected function warmCoreTranslations(TranslationService $service, string $locale): void
    {
        // Core grupları warming et
        $coreGroups = [
            'auth',         // Giriş/çıkış mesajları
            'validation',   // Form validation mesajları
            'pagination',   // Sayfalama
            'passwords',    // Şifre sıfırlama
            'common',       // Genel kullanım
            'navigation',   // Menü öğeleri
            'dashboard',    // Dashboard metinleri
        ];

        foreach ($coreGroups as $group) {
            try {
                $service->getTranslationsByGroup($group, $locale);
            } catch (\Exception $e) {
                // Grup bulunamadıysa devam et
                continue;
            }
        }
    }

    /**
     * Artisan Komutlarını Kaydet
     *
     * Translation yönetimi için özel Artisan komutlarını kaydetder.
     */
    /**
     * Laravel Translation Loader'ını Database-Driven Loader ile Değiştir
     *
     * Bu method, Laravel'in standart FileLoader'ını database-driven yaklaşımla değiştirir.
     */
    protected function replaceTranslationLoader(): void
    {
        // Laravel'in translator'ı singleton olarak yeniden tanımla
        $this->app->singleton('translator', function ($app) {
            $loader = new DatabaseTranslationLoader(
                $app[TranslationService::class]
            );
            
            $trans = new \Illuminate\Translation\Translator($loader, $app['config']['app.locale']);
            $trans->setFallback($app['config']['app.fallback_locale']);
            
            return $trans;
        });
    }

    protected function registerCommands(): void
    {
        // Geçici olarak disable - komutlar henüz implement edilmemiş
        // TODO: Translation management komutları implement et
    }

    /**
     * Provides listesi
     *
     * Bu ServiceProvider'ın sağladığı servislerin listesi.
     * Laravel'in service discovery için kullanır.
     * 
     * @return array<string>
     */
    public function provides(): array
    {
        return [
            TranslationRepositoryInterface::class,
            TranslationRepository::class,
            TranslationService::class,
            CacheService::class,
        ];
    }
}