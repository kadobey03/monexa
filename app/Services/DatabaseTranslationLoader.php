<?php

namespace App\Services;

use Illuminate\Contracts\Translation\Loader;
use App\Services\TranslationService;

/**
 * Database Translation Loader
 *
 * Laravel'in Translation LoaderInterface'ini implement eden database-driven loader.
 * Bu sınıf Laravel'in __() ve trans() fonksiyonlarının database'den çeviri yüklemesini sağlar.
 */
class DatabaseTranslationLoader implements Loader
{
    /**
     * Translation Service instance
     *
     * @var TranslationService
     */
    protected TranslationService $translationService;

    /**
     * Loaded translation cache
     *
     * @var array
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
     * Laravel tarafından çağrılan ana metod.
     * Belirtilen locale için tüm çevirileri yükler.
     *
     * @param string $locale
     * @param string $group
     * @param string|null $namespace
     * @return array
     */
    public function load($locale, $group, $namespace = null)
    {
        // Namespace desteği şimdilik yok, null olmayan namespace'leri atla
        if ($namespace !== null && $namespace !== '*') {
            return [];
        }

        // Cache key oluştur
        $key = "{$locale}.{$group}." . ($namespace ?? '*');

        // Cache'den kontrol et
        if (isset($this->loaded[$key])) {
            return $this->loaded[$key];
        }

        try {
            // Session'dan gerçek locale'i al (AppServiceProvider fix sonrası)
            $sessionLocale = \Illuminate\Support\Facades\Session::get('locale');
            if ($sessionLocale && in_array($sessionLocale, ['tr', 'ru', 'en'])) {
                $locale = $sessionLocale; // Session'daki locale'i kullan
            }
            
            // Language ID mapping: tr=1, ru=2, en=3
            $languageId = $locale === 'tr' ? 1 : ($locale === 'ru' ? 2 : 3);
            
            // Database'den grup ile başlayan tüm key'leri yükle
            // Not: Laravel'in group parametresi ile Phrase.group field'ı farklı olabilir
            // Key pattern'e göre arama yap, group field'ını yoksay
            $phrases = \App\Models\Phrase::with(['translations' => function($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->where('key', 'LIKE', $group . '.%')->get();
            
            // Laravel'in beklediği nested array formatına çevir
            $result = [];
            foreach ($phrases as $phrase) {
                if ($phrase->translations->isNotEmpty()) {
                    $translation = $phrase->translations->first()->translation;
                    
                    // Key'den grup prefix'ini kaldır (örn: admin.dashboard.welcome -> dashboard.welcome)
                    $keyWithoutGroup = substr($phrase->key, strlen($group) + 1);
                    
                    // Nested array formatına çevir
                    $this->setNestedArrayValue($result, $keyWithoutGroup, $translation);
                }
            }
            
            // Cache'e kaydet
            $this->loaded[$key] = $result;
            
            return $result;
        } catch (\Exception $e) {
            // Hata durumunda boş array döndür ve loglama yap
            logger()->warning("Database translation loading failed: {$e->getMessage()}", [
                'locale' => $locale,
                'group' => $group,
                'namespace' => $namespace,
                'exception' => $e
            ]);

            // Cache'e boş değer kaydet (tekrar tekrar denemesin)
            $this->loaded[$key] = [];
            
            return [];
        }
    }

    /**
     * Add a new namespace to the loader.
     *
     * Laravel'in namespace desteği için gerekli metod.
     * Şimdilik basit implementasyon.
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        // Namespace desteği şimdilik implement edilmemiş
        // TODO: Gelecekte namespace desteği eklenebilir
    }

    /**
     * Add a new JSON path to the loader.
     *
     * Laravel'in JSON translation desteği için gerekli metod.
     * Database-driven sistemde JSON path'lere ihtiyaç yok.
     *
     * @param string $path
     * @return void
     */
    public function addJsonPath($path)
    {
        // JSON path desteği database-driven sistemde gerekli değil
    }

    /**
     * Get all namespaces.
     *
     * Laravel'in namespace listesi için gerekli metod.
     *
     * @return array
     */
    public function namespaces()
    {
        // Şimdilik namespace desteği yok
        return [];
    }

    /**
     * Cache'i temizle
     *
     * Translation güncellendiğinde cache'i temizlemek için kullanılır.
     *
     * @param string|null $locale
     * @param string|null $group
     * @return void
     */
    public function flushCache(?string $locale = null, ?string $group = null): void
    {
        if ($locale === null && $group === null) {
            // Tüm cache'i temizle
            $this->loaded = [];
        } else {
            // Belirli locale/group için cache temizle
            $pattern = ($locale ?? '*') . '.' . ($group ?? '*') . '.*';
            
            foreach (array_keys($this->loaded) as $key) {
                if (fnmatch($pattern, $key)) {
                    unset($this->loaded[$key]);
                }
            }
        }
    }

    /**
     * Tüm aktif dillerin çevirilerini pre-load et
     *
     * Performance optimizasyonu için tüm çevirileri önceden yükler.
     *
     * @param array $locales
     * @param array $groups
     * @return int Yüklenen çeviri sayısı
     */
    public function preloadTranslations(array $locales = [], array $groups = []): int
    {
        $loadedCount = 0;

        try {
            // Varsayılan değerler
            if (empty($locales)) {
                $locales = ['tr', 'ru', 'en']; // Desteklenen diller
            }

            if (empty($groups)) {
                $groups = ['auth', 'validation', 'passwords', 'common', 'navigation', 'dashboard'];
            }

            // Her locale ve group kombinasyonu için çevirileri yükle
            foreach ($locales as $locale) {
                foreach ($groups as $group) {
                    $translations = $this->load($locale, $group);
                    $loadedCount += count($translations);
                }
            }

            return $loadedCount;
        } catch (\Exception $e) {
            logger()->warning("Translation preloading failed: {$e->getMessage()}", [
                'locales' => $locales,
                'groups' => $groups,
                'exception' => $e
            ]);

            return $loadedCount;
        }
    }

    /**
     * Debug bilgisi için yüklenen çevirileri göster
     *
     * @return array
     */
    public function getLoadedTranslations(): array
    {
        return $this->loaded;
    }

    /**
     * Cache durumunu kontrol et
     *
     * @return array
     */
    public function getCacheStats(): array
    {
        return [
            'total_cached_groups' => count($this->loaded),
            'memory_usage_bytes' => strlen(serialize($this->loaded)),
            'cached_keys' => array_keys($this->loaded),
        ];
    }

    /**
     * Set nested array value using dot notation
     *
     * @param array &$array
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function setNestedArrayValue(array &$array, string $key, $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;

        // Son key hariç tüm key'ler için nested array yaratma
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $k = $keys[$i];
            
            // CRITICAL FIX: Eğer key zaten string bir değere sahipse ve nested path geliyorsa,
            // bu bir çakışma durumudur. Örnek: deposits.status = "Durum" varken
            // deposits.status.processed geliyor. Bu durumda string değeri koruyoruz.
            if (!isset($current[$k])) {
                $current[$k] = [];
            } elseif (!is_array($current[$k])) {
                // String değer var, ama nested path geliyor - bu çakışma durumu
                // String değeri koruyoruz ve nested path'i atlıyoruz
                return; // Çakışma durumunda işlemi durdur
            }
            $current = &$current[$k];
        }

        // Son key'e değeri ata
        $lastKey = end($keys);
        $current[$lastKey] = $value;
    }
}