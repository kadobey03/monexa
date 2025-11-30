<?php

namespace App\Services;

use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TranslationService
{
    /**
     * Translation repository instance.
     */
    protected TranslationRepositoryInterface $translationRepository;

    /**
     * Cache service instance.
     */
    protected CacheService $cacheService;

    /**
     * Performance monitoring service instance.
     */
    protected PerformanceMonitoringService $performanceService;

    /**
     * Default locale.
     */
    protected string $defaultLocale;

    /**
     * Current locale.
     */
    protected string $currentLocale;

    /**
     * Cache duration in minutes.
     */
    const CACHE_DURATION = 60;

    /**
     * Constructor.
     *
     * @param TranslationRepositoryInterface $translationRepository
     * @param CacheService $cacheService
     */
    public function __construct(
        TranslationRepositoryInterface $translationRepository,
        CacheService $cacheService,
        PerformanceMonitoringService $performanceService
    ) {
        $this->translationRepository = $translationRepository;
        $this->cacheService = $cacheService;
        $this->performanceService = $performanceService;
        $this->defaultLocale = config('app.locale', 'tr');
        $this->currentLocale = App::getLocale();
    }

    /**
     * Get translation for a given key.
     *
     * @param string $key
     * @param array $parameters
     * @param string|null $locale
     * @return string
     */
    public function get(string $key, array $parameters = [], ?string $locale = null): string
    {
        $startTime = microtime(true);
        $locale = $locale ?: $this->currentLocale;
        
        // Parse key to extract group and actual key
        $parsedKey = $this->parseTranslationKey($key);
        
        try {
            // Increment usage statistics (async)
            $this->incrementUsageAsync($parsedKey['key'], $parsedKey['group']);
            
            // Get translation from cache or database
            $translation = $this->getTranslationFromCacheOrDb(
                $parsedKey['key'],
                $locale,
                $parsedKey['group']
            );
            
            $executionTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
            $cached = $this->wasCached($parsedKey['key'], $locale, $parsedKey['group']);
            
            // Record performance metrics
            $this->performanceService->recordTranslationLookup(
                $key,
                $locale,
                $executionTime,
                $cached
            );
            
            if ($translation && $translation->translation) {
                return $this->processTranslationParameters($translation->translation, $parameters);
            }
            
            // Fallback to default language if current locale is not default
            if ($locale !== $this->defaultLocale) {
                $fallbackStartTime = microtime(true);
                $defaultTranslation = $this->getTranslationFromCacheOrDb(
                    $parsedKey['key'],
                    $this->defaultLocale,
                    $parsedKey['group']
                );
                
                $fallbackExecutionTime = (microtime(true) - $fallbackStartTime) * 1000;
                $fallbackCached = $this->wasCached($parsedKey['key'], $this->defaultLocale, $parsedKey['group']);
                
                // Record fallback performance metrics
                $this->performanceService->recordTranslationLookup(
                    $key,
                    $this->defaultLocale,
                    $fallbackExecutionTime,
                    $fallbackCached
                );
                
                if ($defaultTranslation && $defaultTranslation->translation) {
                    return $this->processTranslationParameters($defaultTranslation->translation, $parameters);
                }
            }
            
            // Return the original key if no translation found
            return $key;
            
        } catch (\Exception $e) {
            Log::error('Translation service error', [
                'key' => $key,
                'locale' => $locale,
                'error' => $e->getMessage()
            ]);
            
            return $key;
        }
    }

    /**
     * Get plural translation.
     *
     * @param string $key
     * @param int $count
     * @param array $parameters
     * @param string|null $locale
     * @return string
     */
    public function getPlural(string $key, int $count, array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?: $this->currentLocale;
        $parsedKey = $this->parseTranslationKey($key);
        
        try {
            $translation = $this->getTranslationFromCacheOrDb(
                $parsedKey['key'], 
                $locale, 
                $parsedKey['group']
            );
            
            if ($translation) {
                $text = $count === 1 && $translation->translation 
                    ? $translation->translation 
                    : ($translation->plural_translation ?: $translation->translation);
                
                if ($text) {
                    $parameters['count'] = $count;
                    return $this->processTranslationParameters($text, $parameters);
                }
            }
            
            return $this->get($key, array_merge($parameters, ['count' => $count]), $locale);
            
        } catch (\Exception $e) {
            Log::error('Plural translation service error', [
                'key' => $key,
                'count' => $count,
                'locale' => $locale,
                'error' => $e->getMessage()
            ]);
            
            return $this->get($key, array_merge($parameters, ['count' => $count]), $locale);
        }
    }

    /**
     * Set current locale.
     *
     * @param string $locale
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->currentLocale = $locale;
        App::setLocale($locale);
    }

    /**
     * Get current locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->currentLocale;
    }

    /**
     * Get available languages.
     *
     * @return Collection
     */
    public function getAvailableLanguages(): Collection
    {
        $cacheKey = 'available_languages';
        
        if ($this->cacheService->has($cacheKey)) {
            $this->performanceService->recordCacheHit($cacheKey, 'language_list');
        } else {
            $this->performanceService->recordCacheMiss($cacheKey, 'language_list');
        }
        
        return $this->cacheService->remember($cacheKey, function () {
            return $this->translationRepository->getActiveLanguages();
        }, self::CACHE_DURATION);
    }

    /**
     * Get default language.
     *
     * @return Language|null
     */
    public function getDefaultLanguage(): ?Language
    {
        return $this->cacheService->remember('default_language', function () {
            return $this->translationRepository->getDefaultLanguage();
        }, self::CACHE_DURATION);
    }

    /**
     * Create or update phrase.
     *
     * @param array $data
     * @return Phrase
     */
    public function createPhrase(array $data): Phrase
    {
        $phrase = $this->translationRepository->createOrUpdatePhrase($data);
        
        // Clear related caches
        $this->clearPhraseCache($phrase->key, $phrase->group);
        
        return $phrase;
    }

    /**
     * Create or update translation.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param array $data
     * @return PhraseTranslation
     */
    public function createTranslation(string $phraseKey, string $languageCode, array $data): PhraseTranslation
    {
        $translation = $this->translationRepository->createOrUpdateTranslation($phraseKey, $languageCode, $data);
        
        // Clear related caches
        $this->clearTranslationCache($phraseKey, $languageCode, $data['group'] ?? 'general');
        
        return $translation;
    }

    /**
     * Bulk import translations.
     *
     * @param string $languageCode
     * @param array $translations
     * @param string $group
     * @return array
     */
    public function bulkImportTranslations(string $languageCode, array $translations, string $group = 'general'): array
    {
        $result = $this->translationRepository->bulkImportTranslations($languageCode, $translations, $group);
        
        // Clear all caches for the language and group
        $keysCleared = $this->cacheService->forgetPattern("translation.{$languageCode}.*");
        $keysCleared += $this->cacheService->forgetPattern("translation.by_language.{$languageCode}*");
        
        // Record cache invalidation
        $this->performanceService->recordCacheInvalidation(
            "translation.{$languageCode}.*",
            $keysCleared
        );
        
        return $result;
    }

    /**
     * Export translations for language.
     *
     * @param string $languageCode
     * @param string|null $group
     * @param string $format
     * @return array
     */
    public function exportTranslations(string $languageCode, ?string $group = null, string $format = 'array'): array
    {
        return $this->translationRepository->exportTranslations($languageCode, $group, $format);
    }

    /**
     * Search translations.
     *
     * @param string $search
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchTranslations(string $search, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->translationRepository->searchTranslations(
            $search,
            $filters['language_code'] ?? null,
            $perPage
        );
    }

    /**
     * Get translation statistics.
     *
     * @param string|null $languageCode
     * @return array
     */
    public function getTranslationStats(?string $languageCode = null): array
    {
        $cacheKey = $languageCode ? "translation_stats.{$languageCode}" : 'translation_stats.global';
        
        return $this->cacheService->remember($cacheKey, function () use ($languageCode) {
            return $this->translationRepository->getTranslationStats($languageCode);
        }, self::CACHE_DURATION);
    }

    /**
     * Get language statistics.
     *
     * @return Collection
     */
    public function getLanguageStats(): Collection
    {
        return $this->cacheService->remember('language_stats', function () {
            return $this->translationRepository->getLanguageStats();
        }, self::CACHE_DURATION);
    }

    /**
     * Get untranslated phrases for language.
     *
     * @param string $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUntranslatedPhrases(string $languageCode, int $perPage = 15): LengthAwarePaginator
    {
        return $this->translationRepository->getUntranslatedPhrases($languageCode, $perPage);
    }

    /**
     * Get phrases needing review.
     *
     * @param string|null $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPhrasesNeedingReview(?string $languageCode = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->translationRepository->getPhrasesNeedingReview($languageCode, $perPage);
    }

    /**
     * Mark translation as reviewed.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string $reviewer
     * @return bool
     */
    public function markTranslationAsReviewed(string $phraseKey, string $languageCode, string $reviewer): bool
    {
        $result = $this->translationRepository->markTranslationAsReviewed($phraseKey, $languageCode, $reviewer);
        
        if ($result) {
            $this->clearTranslationCache($phraseKey, $languageCode);
        }
        
        return $result;
    }

    /**
     * Get popular phrases.
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopularPhrases(int $limit = 10): Collection
    {
        return $this->cacheService->remember("popular_phrases.{$limit}", function () use ($limit) {
            return $this->translationRepository->getPopularPhrases($limit);
        }, self::CACHE_DURATION);
    }

    /**
     * Get recently used phrases.
     *
     * @param int $days
     * @param int $limit
     * @return Collection
     */
    public function getRecentlyUsedPhrases(int $days = 30, int $limit = 10): Collection
    {
        return $this->cacheService->remember("recent_phrases.{$days}.{$limit}", function () use ($days, $limit) {
            return $this->translationRepository->getRecentlyUsedPhrases($days, $limit);
        }, self::CACHE_DURATION);
    }

    /**
     * Warm up cache for specific language.
     *
     * @param string $languageCode
     * @param string|null $group
     * @return int
     */
    public function warmUpCache(string $languageCode, ?string $group = null): int
    {
        $translations = $this->translationRepository->getTranslationsByLanguage($languageCode, $group);
        $count = 0;
        
        foreach ($translations as $translation) {
            $cacheKey = $this->buildTranslationCacheKey(
                $translation->phrase->key,
                $languageCode,
                $translation->phrase->group
            );
            
            $this->cacheService->put($cacheKey, $translation, self::CACHE_DURATION);
            $count++;
        }
        
        return $count;
    }

    /**
     * Clear all translation caches.
     *
     * @return bool
     */
    public function clearAllCaches(): bool
    {
        return $this->cacheService->flush();
    }

    /**
     * Clear cache for specific language.
     *
     * @param string $languageCode
     * @return bool
     */
    public function clearLanguageCache(string $languageCode): bool
    {
        $patterns = [
            "translation.{$languageCode}.*",
            "translation.by_language.{$languageCode}*",
            "translation_stats.{$languageCode}",
        ];
        
        $totalKeysCleared = 0;
        
        foreach ($patterns as $pattern) {
            $keysCleared = $this->cacheService->forgetPattern($pattern);
            $totalKeysCleared += $keysCleared;
            
            // Record each cache invalidation
            $this->performanceService->recordCacheInvalidation($pattern, $keysCleared);
        }
        
        return true;
    }

    /**
     * Parse translation key to extract group and key.
     *
     * @param string $key
     * @return array
     */
    private function parseTranslationKey(string $key): array
    {
        if (str_contains($key, '.')) {
            $parts = explode('.', $key, 2);
            return [
                'group' => $parts[0],
                'key' => $parts[1]
            ];
        }
        
        return [
            'group' => 'general',
            'key' => $key
        ];
    }

    /**
     * Get translation from cache or database.
     *
     * @param string $key
     * @param string $locale
     * @param string $group
     * @return PhraseTranslation|null
     */
    private function getTranslationFromCacheOrDb(string $key, string $locale, string $group = 'general'): ?PhraseTranslation
    {
        $cacheKey = $this->buildTranslationCacheKey($key, $locale, $group);
        
        if ($this->cacheService->has($cacheKey)) {
            $this->performanceService->recordCacheHit($cacheKey, 'phrase_lookup');
        } else {
            $this->performanceService->recordCacheMiss($cacheKey, 'phrase_lookup');
        }
        
        return $this->cacheService->remember($cacheKey, function () use ($key, $locale, $group) {
            $startTime = microtime(true);
            $result = $this->translationRepository->getTranslation($key, $locale, $group);
            $executionTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
            
            // Record database query performance
            $this->performanceService->recordQuery(
                "Translation lookup: {$key} in {$locale}",
                $executionTime,
                ['key' => $key, 'locale' => $locale, 'group' => $group]
            );
            
            return $result;
        }, self::CACHE_DURATION);
    }

    /**
     * Process translation parameters.
     *
     * @param string $translation
     * @param array $parameters
     * @return string
     */
    private function processTranslationParameters(string $translation, array $parameters): string
    {
        if (empty($parameters)) {
            return $translation;
        }
        
        foreach ($parameters as $key => $value) {
            $translation = str_replace([
                ":{$key}",
                "{{$key}}",
                "%{$key}%"
            ], $value, $translation);
        }
        
        return $translation;
    }

    /**
     * Build translation cache key.
     *
     * @param string $key
     * @param string $locale
     * @param string $group
     * @return string
     */
    private function buildTranslationCacheKey(string $key, string $locale, string $group = 'general'): string
    {
        return "translation.{$locale}.{$key}" . ($group !== 'general' ? ".{$group}" : '');
    }

    /**
     * Clear phrase cache.
     *
     * @param string $phraseKey
     * @param string $group
     * @return void
     */
    private function clearPhraseCache(string $phraseKey, string $group = 'general'): void
    {
        $patterns = [
            "translation.*.{$phraseKey}" . ($group !== 'general' ? ".{$group}" : ''),
            'translation_stats.*',
            'language_stats',
            'popular_phrases.*',
            'recent_phrases.*'
        ];
        
        foreach ($patterns as $pattern) {
            $keysCleared = $this->cacheService->forgetPattern($pattern);
            $this->performanceService->recordCacheInvalidation($pattern, $keysCleared);
        }
    }

    /**
     * Clear translation cache.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string $group
     * @return void
     */
    private function clearTranslationCache(string $phraseKey, string $languageCode, string $group = 'general'): void
    {
        $cacheKey = $this->buildTranslationCacheKey($phraseKey, $languageCode, $group);
        $this->cacheService->forget($cacheKey);
        
        // Record single cache key invalidation
        $this->performanceService->recordCacheInvalidation($cacheKey, 1);
        
        $patterns = [
            "translation.by_language.{$languageCode}*",
            "translation_stats.{$languageCode}",
            'translation_stats.global',
            'language_stats'
        ];
        
        foreach ($patterns as $pattern) {
            $keysCleared = $this->cacheService->forgetPattern($pattern);
            $this->performanceService->recordCacheInvalidation($pattern, $keysCleared);
        }
    }

    /**
     * Increment phrase usage asynchronously.
     *
     * @param string $phraseKey
     * @param string $group
     * @return void
     */
    private function incrementUsageAsync(string $phraseKey, string $group = 'general'): void
    {
        // In a real application, this could be dispatched to a queue
        // For now, we'll do it synchronously but wrapped in try-catch
        try {
            $this->translationRepository->incrementPhraseUsage($phraseKey, $group);
        } catch (\Exception $e) {
            // Log error but don't fail the translation request
            Log::warning('Failed to increment phrase usage', [
                'phrase_key' => $phraseKey,
                'group' => $group,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if translation was cached.
     *
     * @param string $key
     * @param string $locale
     * @param string $group
     * @return bool
     */
    private function wasCached(string $key, string $locale, string $group = 'general'): bool
    {
        $cacheKey = $this->buildTranslationCacheKey($key, $locale, $group);
        return $this->cacheService->has($cacheKey);
    }

    /**
     * Get performance monitoring service.
     *
     * @return PerformanceMonitoringService
     */
    public function getPerformanceService(): PerformanceMonitoringService
    {
        return $this->performanceService;
    }

    /**
     * Get translations by group for specific language.
     *
     * Bu metod DatabaseTranslationLoader tarafından kullanılır.
     * Laravel translation system entegrasyonu için kritik.
     *
     * @param string $group
     * @param string $languageCode
     * @return array
     */
    public function getGroupTranslations(string $group, string $languageCode): array
    {
        try {
            $cacheKey = "translation.by_language.{$languageCode}.{$group}";
            
            if ($this->cacheService->has($cacheKey)) {
                $this->performanceService->recordCacheHit($cacheKey, 'group_translations');
            } else {
                $this->performanceService->recordCacheMiss($cacheKey, 'group_translations');
            }
            
            return $this->cacheService->remember($cacheKey, function () use ($group, $languageCode) {
                $startTime = microtime(true);
                
                // Repository'den grup çevirilerini al
                $translations = $this->translationRepository->getTranslationsByLanguage($languageCode, $group);
                
                // Array formatına dönüştür (Laravel translation system uyumlu)
                $result = [];
                foreach ($translations as $translation) {
                    if ($translation->phrase && $translation->translation) {
                        // Nested key desteği: 'auth.login' -> ['auth' => ['login' => 'translation']]
                        $this->setNestedArrayValue($result, $translation->phrase->key, $translation->translation);
                    }
                }
                
                $executionTime = (microtime(true) - $startTime) * 1000;
                
                // Performance monitoring
                $this->performanceService->recordQuery(
                    "Group translations lookup: {$group} in {$languageCode}",
                    $executionTime,
                    ['group' => $group, 'language_code' => $languageCode, 'count' => count($result)]
                );
                
                return $result;
            }, self::CACHE_DURATION);
        } catch (\Exception $e) {
            Log::error('Group translations service error', [
                'group' => $group,
                'language_code' => $languageCode,
                'error' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Set nested array value using dot notation.
     *
     * 'auth.login' key'ini ['auth' => ['login' => 'value']] formatına çevirir.
     *
     * @param array &$array
     * @param string $key
     * @param mixed $value
     * @return void
     */
    private function setNestedArrayValue(array &$array, string $key, $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;
        
        foreach ($keys as $k) {
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
        
        $current = $value;
    }
}