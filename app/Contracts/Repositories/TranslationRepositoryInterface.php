<?php

namespace App\Contracts\Repositories;

use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TranslationRepositoryInterface
{
    /**
     * Get all active languages.
     *
     * @return Collection
     */
    public function getActiveLanguages(): Collection;

    /**
     * Get default language.
     *
     * @return Language|null
     */
    public function getDefaultLanguage(): ?Language;

    /**
     * Get language by code.
     *
     * @param string $code
     * @return Language|null
     */
    public function getLanguageByCode(string $code): ?Language;

    /**
     * Get all phrases with filters.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPhrases(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Get phrase by key.
     *
     * @param string $key
     * @param string|null $group
     * @return Phrase|null
     */
    public function getPhraseByKey(string $key, ?string $group = null): ?Phrase;

    /**
     * Get translation for phrase and language.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string|null $group
     * @return PhraseTranslation|null
     */
    public function getTranslation(string $phraseKey, string $languageCode, ?string $group = null): ?PhraseTranslation;

    /**
     * Get all translations for a language.
     *
     * @param string $languageCode
     * @param string|null $group
     * @return Collection
     */
    public function getTranslationsByLanguage(string $languageCode, ?string $group = null): Collection;

    /**
     * Get translations for multiple languages.
     *
     * @param array $languageCodes
     * @param string|null $group
     * @return Collection
     */
    public function getTranslationsForLanguages(array $languageCodes, ?string $group = null): Collection;

    /**
     * Create or update phrase.
     *
     * @param array $data
     * @return Phrase
     */
    public function createOrUpdatePhrase(array $data): Phrase;

    /**
     * Create or update translation.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param array $data
     * @return PhraseTranslation
     */
    public function createOrUpdateTranslation(string $phraseKey, string $languageCode, array $data): PhraseTranslation;

    /**
     * Create or update multiple translations.
     *
     * @param array $translations
     * @return bool
     */
    public function createOrUpdateTranslations(array $translations): bool;

    /**
     * Delete phrase.
     *
     * @param string $phraseKey
     * @param string|null $group
     * @return bool
     */
    public function deletePhrase(string $phraseKey, ?string $group = null): bool;

    /**
     * Delete translation.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @return bool
     */
    public function deleteTranslation(string $phraseKey, string $languageCode): bool;

    /**
     * Get phrases by group.
     *
     * @param string $group
     * @param string|null $languageCode
     * @return Collection
     */
    public function getPhrasesByGroup(string $group, ?string $languageCode = null): Collection;

    /**
     * Get all phrase groups.
     *
     * @return Collection
     */
    public function getPhraseGroups(): Collection;

    /**
     * Search phrases and translations.
     *
     * @param string $search
     * @param string|null $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchTranslations(string $search, ?string $languageCode = null, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get untranslated phrases for language.
     *
     * @param string $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUntranslatedPhrases(string $languageCode, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get translation completion stats.
     *
     * @param string|null $languageCode
     * @return array
     */
    public function getTranslationStats(?string $languageCode = null): array;

    /**
     * Get phrases needing review.
     *
     * @param string|null $languageCode
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPhrasesNeedingReview(?string $languageCode = null, int $perPage = 15): LengthAwarePaginator;

    /**
     * Mark translation as reviewed.
     *
     * @param string $phraseKey
     * @param string $languageCode
     * @param string $reviewer
     * @return bool
     */
    public function markTranslationAsReviewed(string $phraseKey, string $languageCode, string $reviewer): bool;

    /**
     * Mark translations as needing update.
     *
     * @param array $translationIds
     * @return bool
     */
    public function markTranslationsNeedUpdate(array $translationIds): bool;

    /**
     * Get popular phrases (most used).
     *
     * @param int $limit
     * @return Collection
     */
    public function getPopularPhrases(int $limit = 10): Collection;

    /**
     * Get recently used phrases.
     *
     * @param int $days
     * @param int $limit
     * @return Collection
     */
    public function getRecentlyUsedPhrases(int $days = 30, int $limit = 10): Collection;

    /**
     * Increment phrase usage.
     *
     * @param string $phraseKey
     * @param string|null $group
     * @return bool
     */
    public function incrementPhraseUsage(string $phraseKey, ?string $group = null): bool;

    /**
     * Get language statistics.
     *
     * @return Collection
     */
    public function getLanguageStats(): Collection;

    /**
     * Bulk import translations from array.
     *
     * @param string $languageCode
     * @param array $translations
     * @param string $group
     * @return array
     */
    public function bulkImportTranslations(string $languageCode, array $translations, string $group = 'general'): array;

    /**
     * Export translations for language.
     *
     * @param string $languageCode
     * @param string|null $group
     * @param string $format
     * @return array
     */
    public function exportTranslations(string $languageCode, ?string $group = null, string $format = 'array'): array;
}