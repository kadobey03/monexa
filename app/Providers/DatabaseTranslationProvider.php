<?php

namespace App\Providers;

use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\Translation\Loader;
use App\Services\TranslationService;

/**
 * Database Translation Provider
 * 
 * Bu provider, Laravel'in yerleşik translation sistemini database-driven
 * yaklaşımla extend eder. Translator sınıfına database destekli translation
 * özelliklerini entegre eder.
 * 
 * Özellikler:
 * - Database-driven translation loading
 * - Cache entegrasyonu
 * - Fallback dil desteği
 * - Real-time translation updates
 * - Performance optimizasyonları
 */
class DatabaseTranslationProvider extends TranslationServiceProvider
{
    /**
     * Translation Service instance
     */
    protected TranslationService $translationService;

    /**
     * Default locale
     */
    protected string $locale;

    /**
     * Fallback locale
     */
    protected string $fallbackLocale;

    /**
     * Constructor
     *
     * @param TranslationService $translationService
     * @param string $locale
     * @param string $fallbackLocale
     */
    public function __construct(TranslationService $translationService, string $locale, string $fallbackLocale)
    {
        $this->translationService = $translationService;
        $this->locale = $locale;
        $this->fallbackLocale = $fallbackLocale;
    }

    /**
     * Register the translation line loader.
     *
     * Bu method, Laravel'in translation loader'ını database-driven
     * yaklaşımla değiştirir.
     */
    protected function registerLoader(): void
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new DatabaseTranslationLoader($this->translationService);
        });
    }

    /**
     * Register the translator instance.
     *
     * Translator'ı database loader ile birlikte register eder.
     */
    protected function registerTranslator(): void
    {
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];

            // Create translator with the database loader
            $trans = new DatabaseTranslator($loader, $this->locale, $this->translationService);

            // Set fallback locale
            $trans->setFallback($this->fallbackLocale);

            return $trans;
        });
    }
}

/**
 * Database Translation Loader
 * 
 * Laravel'in translation loader interface'ini implement eder
 * ancak dosya sistemi yerine database'den translation'ları yükler.
 */
class DatabaseTranslationLoader implements Loader
{
    /**
     * Translation Service instance
     */
    protected TranslationService $translationService;

    /**
     * Loaded translations cache
     */
    protected array $loaded = [];

    /**
     * Constructor
     *
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string|null $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null): array
    {
        // Namespace desteği eklenebilir, şimdilik null
        if ($namespace && $namespace !== '*') {
            return [];
        }

        $key = "{$locale}.{$group}";
        
        // Cache'den kontrol et
        if (isset($this->loaded[$key])) {
            return $this->loaded[$key];
        }

        try {
            // Database'den translation'ları yükle
            $translations = $this->translationService->getTranslationsByGroup($group, $locale);
            
            // Array formatına çevir
            $result = [];
            foreach ($translations as $translation) {
                // Nested key desteği (örn: auth.failed)
                $this->setNestedValue($result, $translation->phrase_key, $translation->translation);
            }

            // Cache'e kaydet
            $this->loaded[$key] = $result;

            return $result;
        } catch (\Exception $e) {
            // Hata durumunda boş array döndür ve log'la
            logger()->warning("Translation loading failed for {$locale}.{$group}: " . $e->getMessage());
            
            // Cache'e boş array kaydet (sürekli denenmesini engeller)
            $this->loaded[$key] = [];
            
            return [];
        }
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint): void
    {
        // Database-driven yaklaşımda namespace hint'e gerek yok
        // Gelecekte namespace desteği eklenebilir
    }

    /**
     * Add a new JSON path to the loader.
     *
     * @param string $path
     * @return void
     */
    public function addJsonPath($path): void
    {
        // Database-driven yaklaşımda JSON path'e gerek yok
        // Bu method interface'den dolayı implement ediliyor
    }

    /**
     * Get an array of all the registered namespaces.
     *
     * @return array
     */
    public function namespaces(): array
    {
        // Şimdilik namespace desteği yok
        return [];
    }

    /**
     * Set nested array value using dot notation
     *
     * @param array &$array
     * @param string $key
     * @param mixed $value
     */
    protected function setNestedValue(array &$array, string $key, $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $k) {
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }

        // Son key'de değeri ata
        $lastKey = array_pop($keys);
        if ($lastKey) {
            $current[$lastKey] = $value;
        } else {
            // Tek seviye key (nokta yok)
            $array[$key] = $value;
        }
    }

    /**
     * Clear the loaded translations cache
     */
    public function clearCache(): void
    {
        $this->loaded = [];
    }

    /**
     * Get loaded translations for debugging
     */
    public function getLoaded(): array
    {
        return $this->loaded;
    }
}

/**
 * Database Translator
 * 
 * Laravel'in Translator sınıfını extend eder ve database-driven
 * özelliklerle zenginleştirir.
 */
class DatabaseTranslator extends Translator
{
    /**
     * Translation Service instance
     */
    protected TranslationService $translationService;

    /**
     * Constructor
     *
     * @param Loader $loader
     * @param string $locale
     * @param TranslationService $translationService
     */
    public function __construct(Loader $loader, string $locale, TranslationService $translationService)
    {
        parent::__construct($loader, $locale);
        $this->translationService = $translationService;
    }

    /**
     * Get the translation for the given key with database fallback.
     *
     * Bu method, parent'teki get methodunu override eder ve
     * database-specific özellikler ekler.
     *
     * @param string $key
     * @param array $replace
     * @param string|null $locale
     * @param bool $fallback
     * @return string|array
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        // Önce parent'in methodunu dene
        $result = parent::get($key, $replace, $locale, $fallback);

        // Eğer translation bulunamadı ve fallback aktifse
        if ($result === $key && $fallback) {
            try {
                // Database'den direkt olarak bul
                $translation = $this->translationService->getTranslation($key, $locale ?: $this->locale);
                
                if ($translation) {
                    // Usage count'u artır (async)
                    $this->incrementUsageAsync($key);
                    
                    // Replace parameters
                    return $this->makeReplacements($translation, $replace);
                }
            } catch (\Exception $e) {
                // Hata durumunda log'la ve key'i döndür
                logger()->debug("Direct translation lookup failed for key {$key}: " . $e->getMessage());
            }
        }

        // Translation bulunduysa usage count'u artır
        if ($result !== $key) {
            $this->incrementUsageAsync($key);
        }

        return $result;
    }

    /**
     * Increment usage count asynchronously
     *
     * @param string $key
     */
    protected function incrementUsageAsync(string $key): void
    {
        // Queue'ya job ekleyerek async olarak usage count'u artır
        try {
            dispatch(function () use ($key) {
                $this->translationService->incrementUsageCount($key);
            })->onQueue('low');
        } catch (\Exception $e) {
            // Queue hatası durumunda sync olarak yap
            try {
                $this->translationService->incrementUsageCount($key);
            } catch (\Exception $syncError) {
                // Her iki durumda da hata varsa log'la ama işlemi durdurma
                logger()->debug("Usage count increment failed for key {$key}");
            }
        }
    }

    /**
     * Clear translator cache
     */
    public function clearCache(): void
    {
        // Loader cache'ini temizle
        if ($this->loader instanceof DatabaseTranslationLoader) {
            $this->loader->clearCache();
        }

        // Translation service cache'ini de temizle
        $this->translationService->clearCache();
    }

    /**
     * Get translation statistics
     */
    public function getStatistics(): array
    {
        return [
            'loaded_groups' => $this->loader instanceof DatabaseTranslationLoader 
                ? count($this->loader->getLoaded())
                : 0,
            'cache_stats' => $this->translationService->getCacheStatistics(),
        ];
    }
}