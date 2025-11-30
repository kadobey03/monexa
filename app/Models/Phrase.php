<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Phrase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'group',
        'description',
        'parameters',
        'is_active',
        'context',
        'last_used_at',
        'usage_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'parameters' => 'json',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
        'last_used_at' => 'datetime'
    ];

    /**
     * Get the phrase translations for the phrase.
     *
     * @return HasMany
     */
    public function phraseTranslations(): HasMany
    {
        return $this->hasMany(PhraseTranslation::class);
    }

    /**
     * Get the languages through translations for the phrase.
     *
     * @return HasManyThrough
     */
    public function languages(): HasManyThrough
    {
        return $this->hasManyThrough(Language::class, PhraseTranslation::class);
    }

    /**
     * Alias for phraseTranslations relationship.
     * Used by controllers that expect 'translations' relationship.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->phraseTranslations();
    }

    /**
     * Scope a query to only include active phrases.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by context.
     *
     * @param Builder $query
     * @param string $context
     * @return Builder
     */
    public function scopeContext(Builder $query, string $context): Builder
    {
        return $query->where('context', $context)->orWhere('context', 'all');
    }

    /**
     * Scope a query to filter by group.
     *
     * @param Builder $query
     * @param string $group
     * @return Builder
     */
    public function scopeGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    /**
     * Scope a query to search phrases by key or description.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('key', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('group', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to order by usage count.
     *
     * @param Builder $query
     * @param string $direction
     * @return Builder
     */
    public function scopePopular(Builder $query, string $direction = 'desc'): Builder
    {
        return $query->orderBy('usage_count', $direction);
    }

    /**
     * Scope a query to get recently used phrases.
     *
     * @param Builder $query
     * @param int $days
     * @return Builder
     */
    public function scopeRecentlyUsed(Builder $query, int $days = 30): Builder
    {
        return $query->where('last_used_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Get the display key with group prefix.
     *
     * @return Attribute
     */
    protected function fullKey(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->group !== 'general' ? "{$this->group}.{$this->key}" : $this->key,
        );
    }

    /**
     * Get the parameter names from the parameters JSON.
     *
     * @return Attribute
     */
    protected function parameterNames(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->parameters ? array_keys($this->parameters) : [],
        );
    }

    /**
     * Check if this phrase is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Increment usage statistics.
     *
     * @return void
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => Carbon::now()]);
    }

    /**
     * Get translation for specific language.
     *
     * @param string|Language $language
     * @return PhraseTranslation|null
     */
    public function getTranslation($language): ?PhraseTranslation
    {
        $languageId = $language instanceof Language ? $language->id : 
                     (is_numeric($language) ? $language : 
                      Language::where('code', $language)->value('id'));

        if (!$languageId) {
            return null;
        }

        return $this->phraseTranslations()
                   ->where('language_id', $languageId)
                   ->first();
    }

    /**
     * Get translation text for specific language.
     *
     * @param string|Language $language
     * @param array $parameters
     * @return string|null
     */
    public function getTranslationText($language, array $parameters = []): ?string
    {
        $translation = $this->getTranslation($language);
        
        if (!$translation || !$translation->translation) {
            return null;
        }

        $text = $translation->translation;

        // Replace parameters if provided
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $text = str_replace(":{$key}", $value, $text);
            }
        }

        return $text;
    }

    /**
     * Check if phrase has translation for specific language.
     *
     * @param string|Language $language
     * @return bool
     */
    public function hasTranslation($language): bool
    {
        $translation = $this->getTranslation($language);
        
        return $translation && !empty($translation->translation);
    }

    /**
     * Get completion percentage across all active languages.
     *
     * @return float
     */
    public function getCompletionPercentage(): float
    {
        $activeLanguagesCount = Language::active()->count();
        
        if ($activeLanguagesCount === 0) {
            return 0.0;
        }

        $translationsCount = $this->phraseTranslations()
                                 ->whereHas('language', fn($query) => $query->active())
                                 ->whereNotNull('translation')
                                 ->where('translation', '!=', '')
                                 ->count();

        return round(($translationsCount / $activeLanguagesCount) * 100, 2);
    }

    /**
     * Get missing translations for this phrase.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMissingTranslations()
    {
        $translatedLanguageIds = $this->phraseTranslations()
                                     ->whereNotNull('translation')
                                     ->where('translation', '!=', '')
                                     ->pluck('language_id');

        return Language::active()
                      ->whereNotIn('id', $translatedLanguageIds)
                      ->get();
    }

    /**
     * Create or update translation for specific language.
     *
     * @param string|Language $language
     * @param string $translation
     * @param string|null $pluralTranslation
     * @param array $metadata
     * @return PhraseTranslation
     */
    public function setTranslation($language, string $translation, ?string $pluralTranslation = null, array $metadata = []): PhraseTranslation
    {
        $languageId = $language instanceof Language ? $language->id : 
                     (is_numeric($language) ? $language : 
                      Language::where('code', $language)->value('id'));

        if (!$languageId) {
            throw new \InvalidArgumentException('Invalid language provided');
        }

        return $this->phraseTranslations()->updateOrCreate(
            ['language_id' => $languageId],
            [
                'translation' => $translation,
                'plural_translation' => $pluralTranslation,
                'metadata' => $metadata ?: null,
                'needs_update' => false
            ]
        );
    }

    /**
     * Get grouped phrases for admin interface.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getGroupedPhrases()
    {
        return static::select('group', \DB::raw('COUNT(*) as count'))
                     ->groupBy('group')
                     ->orderBy('group')
                     ->get();
    }

    /**
     * Get usage statistics.
     *
     * @return array
     */
    public function getUsageStats(): array
    {
        return [
            'usage_count' => $this->usage_count,
            'last_used_at' => $this->last_used_at?->format('Y-m-d H:i:s'),
            'days_since_last_use' => $this->last_used_at ? 
                                   $this->last_used_at->diffInDays(Carbon::now()) : null,
        ];
    }
}