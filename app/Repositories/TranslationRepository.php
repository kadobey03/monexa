<?php

namespace App\Repositories;

use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TranslationRepository implements TranslationRepositoryInterface
{
    /**
     * Cache duration in minutes.
     */
    const CACHE_DURATION = 60;

    /**
     * Get all active languages.
     *
     * @return Collection
     */
    public function getActiveLanguages(): Collection
    {
        return Cache::remember('translation.languages.active', self::CACHE_DURATION, function () {
            return Language::active()->ordered()->get();
        });
    }

    /**
     * Get default language.
     *
     * @return Language|null
     */
    public function getDefaultLanguage(): ?Language
    {
        return Cache::remember('translation.language.default', self::CACHE_DURATION, function () {
            return Language::default()->first();
        });
    }

    /**
     * Get language by code.
     *
     * @param string $code
     * @return Language|null
     */
    public function getLanguageByCode(string $code): ?Language
    {
        return Cache::remember("translation.language.{$code}", self::CACHE_DURATION, function () use ($code) {
            return Language::where('code', $code)->first();
        });
    }

    /**
     * Get all phrases with filters.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPhrases(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Phrase::query();

        // Apply filters
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['group'])) {
            $query->group($filters['group']);
        }

        if (!empty($filters['context'])) {
            $query->context($filters['context']);
        }

        if (isset($filters['is_active'])) {
            if ($filters['is_active']) {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        // Load relationships
        $query->with(['phraseTranslations.language']);

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'key';
        $sortDirection = $filters['sort_direction'] ?? 'asc';
        
        switch ($sortBy) {
            case 'usage_count':
                $query->popular($sortDirection);
                break;
            case 'last_used_at':
                $query->orderBy('last_used_at', $sortDirection);
                break;
            default:
                $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get phrase by key.
     *
     * @param string $key
     * @param string|null $group
     * @return Phrase|null
     */
    public function getPhraseByKey(string $key, ?string $group = null): ?Phrase
    {
        $cacheKey = "translation.phrase.{$key}" . ($group ? ".{$group}" : '');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($key, $group) {
            $query = Phrase::where('key', $key);
            
            if ($group) {
                $query->where('group', $group);
            }
            
            return $query->with(['phraseTranslations.language'])->first();
        });
    }

    /**
     * Get translation for phrase and language.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string|null $group
     * @return PhraseTranslation|null
     */
    public function getTranslation(string $phraseKey, string $languageCode, ?string $group = null): ?PhraseTranslation
    {
        $cacheKey = "translation.{$languageCode}.{$phraseKey}" . ($group ? ".{$group}" : '');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($phraseKey, $languageCode, $group) {
            return PhraseTranslation::whereHas('phrase', function ($query) use ($phraseKey, $group) {
                $query->where('key', $phraseKey);
                if ($group) {
                    $query->where('group', $group);
                }
            })
            ->whereHas('language', function ($query) use ($languageCode) {
                $query->where('code', $languageCode);
            })
            ->with(['phrase', 'language'])
            ->first();
        });
    }

    /**
     * Get all translations for a language.
     *
     * @param string $languageCode
     * @param string|null $group
     * @return Collection
     */
    public function getTranslationsByLanguage(string $languageCode, ?string $group = null): Collection
    {
        $cacheKey = "translation.by_language.{$languageCode}" . ($group ? ".{$group}" : '');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($languageCode, $group) {
            $query = PhraseTranslation::whereHas('language', function ($q) use ($languageCode) {
                $q->where('code', $languageCode);
            })
            ->whereHas('phrase', function ($q) use ($group) {
                $q->active();
                if ($group) {
                    $q->where('group', $group);
                }
            })
            ->with(['phrase', 'language']);

            return $query->get();
        });
    }

    /**
     * Get translations for multiple languages.
     *
     * @param array $languageCodes
     * @param string|null $group
     * @return Collection
     */
    public function getTranslationsForLanguages(array $languageCodes, ?string $group = null): Collection
    {
        $query = PhraseTranslation::whereHas('language', function ($q) use ($languageCodes) {
            $q->whereIn('code', $languageCodes);
        })
        ->whereHas('phrase', function ($q) use ($group) {
            $q->active();
            if ($group) {
                $q->where('group', $group);
            }
        })
        ->with(['phrase', 'language']);

        return $query->get();
    }

    /**
     * Create or update phrase.
     *
     * @param array $data
     * @return Phrase
     */
    public function createOrUpdatePhrase(array $data): Phrase
    {
        $phrase = Phrase::updateOrCreate(
            [
                'key' => $data['key'],
                'group' => $data['group'] ?? 'general'
            ],
            $data
        );

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
    public function createOrUpdateTranslation(string $phraseKey, string $languageCode, array $data): PhraseTranslation
    {
        // Get or create phrase
        $phrase = $this->getPhraseByKey($phraseKey, $data['group'] ?? null);
        if (!$phrase) {
            $phrase = $this->createOrUpdatePhrase([
                'key' => $phraseKey,
                'group' => $data['group'] ?? 'general',
                'is_active' => true
            ]);
        }

        // Get language
        $language = $this->getLanguageByCode($languageCode);
        if (!$language) {
            throw new \InvalidArgumentException("Language with code '{$languageCode}' not found");
        }

        // Create or update translation
        $translation = PhraseTranslation::updateOrCreate(
            [
                'phrase_id' => $phrase->id,
                'language_id' => $language->id
            ],
            array_merge($data, [
                'needs_update' => false,
                'is_reviewed' => $data['is_reviewed'] ?? false
            ])
        );

        // Clear related caches
        $this->clearTranslationCache($phraseKey, $languageCode, $phrase->group);

        return $translation;
    }

    /**
     * Create or update multiple translations.
     *
     * @param array $translations
     * @return bool
     */
    public function createOrUpdateTranslations(array $translations): bool
    {
        try {
            DB::beginTransaction();

            foreach ($translations as $translation) {
                $this->createOrUpdateTranslation(
                    $translation['phrase_key'],
                    $translation['language_code'],
                    $translation['data']
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete phrase.
     *
     * @param string $phraseKey
     * @param string|null $group
     * @return bool
     */
    public function deletePhrase(string $phraseKey, ?string $group = null): bool
    {
        $phrase = $this->getPhraseByKey($phraseKey, $group);
        
        if (!$phrase) {
            return false;
        }

        $result = $phrase->delete();

        if ($result) {
            $this->clearPhraseCache($phraseKey, $group);
        }

        return $result;
    }

    /**
     * Delete translation.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @return bool
     */
    public function deleteTranslation(string $phraseKey, string $languageCode): bool
    {
        $translation = $this->getTranslation($phraseKey, $languageCode);
        
        if (!$translation) {
            return false;
        }

        $result = $translation->delete();

        if ($result) {
            $this->clearTranslationCache($phraseKey, $languageCode, $translation->phrase->group);
        }

        return $result;
    }

    /**
     * Get phrases by group.
     *
     * @param string $group
     * @param string|null $languageCode
     * @return Collection
     */
    public function getPhrasesByGroup(string $group, ?string $languageCode = null): Collection
    {
        $query = Phrase::group($group)->active();

        if ($languageCode) {
            $query->with(['phraseTranslations' => function ($q) use ($languageCode) {
                $q->whereHas('language', function ($lang) use ($languageCode) {
                    $lang->where('code', $languageCode);
                });
            }]);
        } else {
            $query->with(['phraseTranslations.language']);
        }

        return $query->get();
    }

    /**
     * Get all phrase groups.
     *
     * @return Collection
     */
    public function getPhraseGroups(): Collection
    {
        return Cache::remember('translation.phrase_groups', self::CACHE_DURATION, function () {
            return Phrase::getGroupedPhrases();
        });
    }

    /**
     * Search phrases and translations.
     *
     * @param string $search
     * @param string|null $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchTranslations(string $search, ?string $languageCode = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Phrase::search($search)->active();

        if ($languageCode) {
            $query->with(['phraseTranslations' => function ($q) use ($languageCode, $search) {
                $q->whereHas('language', function ($lang) use ($languageCode) {
                    $lang->where('code', $languageCode);
                })->search($search);
            }]);
        } else {
            $query->with(['phraseTranslations.language']);
        }

        return $query->paginate($perPage);
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
        $language = $this->getLanguageByCode($languageCode);
        
        if (!$language) {
            throw new \InvalidArgumentException("Language with code '{$languageCode}' not found");
        }

        return Phrase::active()
            ->whereDoesntHave('phraseTranslations', function ($query) use ($language) {
                $query->where('language_id', $language->id)
                      ->whereNotNull('translation')
                      ->where('translation', '!=', '');
            })
            ->paginate($perPage);
    }

    /**
     * Get translation completion stats.
     *
     * @param string|null $languageCode
     * @return array
     */
    public function getTranslationStats(?string $languageCode = null): array
    {
        if ($languageCode) {
            return $this->getSpecificLanguageStats($languageCode);
        }

        return Cache::remember('translation.stats.global', self::CACHE_DURATION, function () {
            $totalPhrases = Phrase::active()->count();
            $totalLanguages = Language::active()->count();
            $totalTranslations = PhraseTranslation::translated()->count();

            $completionRate = $totalLanguages > 0 && $totalPhrases > 0 
                ? round(($totalTranslations / ($totalPhrases * $totalLanguages)) * 100, 2)
                : 0;

            return [
                'total_phrases' => $totalPhrases,
                'total_languages' => $totalLanguages,
                'total_translations' => $totalTranslations,
                'completion_rate' => $completionRate,
                'reviewed_translations' => PhraseTranslation::reviewed()->count(),
                'needs_update' => PhraseTranslation::needsUpdate()->count(),
            ];
        });
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
        $query = PhraseTranslation::unreviewed()
            ->with(['phrase', 'language']);

        if ($languageCode) {
            $query->byLanguage($languageCode);
        }

        return $query->paginate($perPage);
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
        $translation = $this->getTranslation($phraseKey, $languageCode);
        
        if (!$translation) {
            return false;
        }

        $result = $translation->markAsReviewed($reviewer);

        if ($result) {
            $this->clearTranslationCache($phraseKey, $languageCode, $translation->phrase->group);
        }

        return $result;
    }

    /**
     * Mark translations as needing update.
     *
     * @param array $translationIds
     * @return bool
     */
    public function markTranslationsNeedUpdate(array $translationIds): bool
    {
        $result = PhraseTranslation::whereIn('id', $translationIds)
            ->update([
                'needs_update' => true,
                'is_reviewed' => false
            ]);

        // Clear caches for affected translations
        $this->clearTranslationCaches();

        return $result > 0;
    }

    /**
     * Get popular phrases (most used).
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopularPhrases(int $limit = 10): Collection
    {
        return Cache::remember("translation.popular_phrases.{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return Phrase::active()
                ->popular()
                ->limit($limit)
                ->get();
        });
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
        return Cache::remember("translation.recent_phrases.{$days}.{$limit}", self::CACHE_DURATION, function () use ($days, $limit) {
            return Phrase::active()
                ->recentlyUsed($days)
                ->orderBy('last_used_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Increment phrase usage.
     *
     * @param string $phraseKey
     * @param string|null $group
     * @return bool
     */
    public function incrementPhraseUsage(string $phraseKey, ?string $group = null): bool
    {
        $phrase = $this->getPhraseByKey($phraseKey, $group);
        
        if (!$phrase) {
            return false;
        }

        $phrase->incrementUsage();
        
        // Clear related caches
        $this->clearPhraseCache($phraseKey, $group);
        Cache::forget('translation.popular_phrases.10');
        Cache::forget('translation.recent_phrases.30.10');

        return true;
    }

    /**
     * Get language statistics.
     *
     * @return Collection
     */
    public function getLanguageStats(): Collection
    {
        return Cache::remember('translation.language_stats', self::CACHE_DURATION, function () {
            return Language::active()
                ->get()
                ->map(function ($language) {
                    return [
                        'id' => $language->id,
                        'code' => $language->code,
                        'name' => $language->name,
                        'completion_percentage' => $language->getCompletionPercentage(),
                        'untranslated_count' => $language->getUntranslatedPhrasesCount(),
                        'is_default' => $language->is_default
                    ];
                });
        });
    }

    /**
     * Bulk import translations from array.
     *
     * @param string $languageCode
     * @param array $translations
     * @param string $group
     * @return array
     */
    public function bulkImportTranslations(string $languageCode, array $translations, string $group = 'general'): array
    {
        $imported = 0;
        $updated = 0;
        $errors = [];

        try {
            DB::beginTransaction();

            foreach ($translations as $key => $value) {
                try {
                    $existingTranslation = $this->getTranslation($key, $languageCode, $group);
                    
                    $data = [
                        'translation' => $value,
                        'group' => $group
                    ];

                    $this->createOrUpdateTranslation($key, $languageCode, $data);

                    if ($existingTranslation) {
                        $updated++;
                    } else {
                        $imported++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Key '{$key}': " . $e->getMessage();
                }
            }

            DB::commit();

            // Clear caches
            $this->clearTranslationCaches();

            return [
                'imported' => $imported,
                'updated' => $updated,
                'errors' => $errors
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
        $translations = $this->getTranslationsByLanguage($languageCode, $group);
        
        $result = [];

        foreach ($translations as $translation) {
            if ($format === 'flat') {
                $key = $translation->phrase->group !== 'general' 
                    ? $translation->phrase->group . '.' . $translation->phrase->key
                    : $translation->phrase->key;
                $result[$key] = $translation->translation;
            } else {
                // Nested array format
                if ($translation->phrase->group !== 'general') {
                    $result[$translation->phrase->group][$translation->phrase->key] = $translation->translation;
                } else {
                    $result[$translation->phrase->key] = $translation->translation;
                }
            }
        }

        return $result;
    }

    /**
     * Get language statistics for specific language.
     *
     * @param string $languageCode
     * @return array
     */
    private function getSpecificLanguageStats(string $languageCode): array
    {
        return Cache::remember("translation.stats.{$languageCode}", self::CACHE_DURATION, function () use ($languageCode) {
            $language = $this->getLanguageByCode($languageCode);
            
            if (!$language) {
                throw new \InvalidArgumentException("Language with code '{$languageCode}' not found");
            }

            $totalPhrases = Phrase::active()->count();
            $translatedPhrases = PhraseTranslation::byLanguage($languageCode)
                ->translated()
                ->whereHas('phrase', fn($q) => $q->active())
                ->count();

            return [
                'language' => $language->toArray(),
                'total_phrases' => $totalPhrases,
                'translated_phrases' => $translatedPhrases,
                'untranslated_phrases' => $totalPhrases - $translatedPhrases,
                'completion_percentage' => $language->getCompletionPercentage(),
                'reviewed_translations' => PhraseTranslation::byLanguage($languageCode)->reviewed()->count(),
                'needs_update' => PhraseTranslation::byLanguage($languageCode)->needsUpdate()->count(),
            ];
        });
    }

    /**
     * Clear phrase-related caches.
     *
     * @param string $phraseKey
     * @param string|null $group
     * @return void
     */
    private function clearPhraseCache(string $phraseKey, ?string $group = null): void
    {
        $cacheKey = "translation.phrase.{$phraseKey}" . ($group ? ".{$group}" : '');
        Cache::forget($cacheKey);
        Cache::forget('translation.phrase_groups');
        Cache::forget('translation.stats.global');
    }

    /**
     * Clear translation-related caches.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string|null $group
     * @return void
     */
    private function clearTranslationCache(string $phraseKey, string $languageCode, ?string $group = null): void
    {
        $cacheKey = "translation.{$languageCode}.{$phraseKey}" . ($group ? ".{$group}" : '');
        Cache::forget($cacheKey);
        Cache::forget("translation.by_language.{$languageCode}" . ($group ? ".{$group}" : ''));
        Cache::forget("translation.stats.{$languageCode}");
        Cache::forget('translation.stats.global');
        Cache::forget('translation.language_stats');
    }

    /**
     * Clear all translation caches.
     *
     * @return void
     */
    private function clearTranslationCaches(): void
    {
        Cache::flush(); // In production, implement more selective cache clearing
    }
}