<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class PhraseTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phrase_id',
        'language_id',
        'translation',
        'plural_translation',
        'metadata',
        'is_reviewed',
        'needs_update',
        'reviewer',
        'reviewed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'json',
        'is_reviewed' => 'boolean',
        'needs_update' => 'boolean',
        'reviewed_at' => 'datetime'
    ];

    /**
     * Get the phrase that owns the translation.
     *
     * @return BelongsTo
     */
    public function phrase(): BelongsTo
    {
        return $this->belongsTo(Phrase::class);
    }

    /**
     * Get the language that owns the translation.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Scope a query to only include reviewed translations.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeReviewed(Builder $query): Builder
    {
        return $query->where('is_reviewed', true);
    }

    /**
     * Scope a query to only include unreviewed translations.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnreviewed(Builder $query): Builder
    {
        return $query->where('is_reviewed', false);
    }

    /**
     * Scope a query to only include translations that need update.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNeedsUpdate(Builder $query): Builder
    {
        return $query->where('needs_update', true);
    }

    /**
     * Scope a query to filter by language.
     *
     * @param Builder $query
     * @param string|int|Language $language
     * @return Builder
     */
    public function scopeByLanguage(Builder $query, $language): Builder
    {
        if ($language instanceof Language) {
            return $query->where('language_id', $language->id);
        }
        
        if (is_numeric($language)) {
            return $query->where('language_id', $language);
        }
        
        return $query->whereHas('language', function ($q) use ($language) {
            $q->where('code', $language);
        });
    }

    /**
     * Scope a query to filter by phrase.
     *
     * @param Builder $query
     * @param string|int|Phrase $phrase
     * @return Builder
     */
    public function scopeByPhrase(Builder $query, $phrase): Builder
    {
        if ($phrase instanceof Phrase) {
            return $query->where('phrase_id', $phrase->id);
        }
        
        if (is_numeric($phrase)) {
            return $query->where('phrase_id', $phrase);
        }
        
        return $query->whereHas('phrase', function ($q) use ($phrase) {
            $q->where('key', $phrase);
        });
    }

    /**
     * Scope a query to include only translations with content.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeTranslated(Builder $query): Builder
    {
        return $query->whereNotNull('translation')
                    ->where('translation', '!=', '');
    }

    /**
     * Scope a query to include only empty translations.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUntranslated(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('translation')
              ->orWhere('translation', '');
        });
    }

    /**
     * Scope a query to search translations by content.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('translation', 'like', "%{$search}%")
              ->orWhere('plural_translation', 'like', "%{$search}%");
        });
    }

    /**
     * Get the translation text with fallback.
     *
     * @return Attribute
     */
    protected function text(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->translation ?: $this->phrase->key ?? '',
        );
    }

    /**
     * Get the plural text with fallback.
     *
     * @return Attribute
     */
    protected function pluralText(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->plural_translation ?: $this->translation ?: $this->phrase->key ?? '',
        );
    }

    /**
     * Get translation status badge color.
     *
     * @return Attribute
     */
    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->needs_update) return 'red';
                if (!$this->is_reviewed) return 'yellow';
                if (empty($this->translation)) return 'gray';
                return 'green';
            }
        );
    }

    /**
     * Get translation status text.
     *
     * @return Attribute
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->translation)) return 'Çevrilmedi';
                if ($this->needs_update) return 'Güncelleme Gerekiyor';
                if (!$this->is_reviewed) return 'İnceleme Bekliyor';
                return 'Onaylandı';
            }
        );
    }

    /**
     * Check if the translation is reviewed.
     *
     * @return bool
     */
    public function isReviewed(): bool
    {
        return $this->is_reviewed;
    }

    /**
     * Check if the translation needs update.
     *
     * @return bool
     */
    public function needsUpdate(): bool
    {
        return $this->needs_update;
    }

    /**
     * Check if the translation has content.
     *
     * @return bool
     */
    public function hasTranslation(): bool
    {
        return !empty($this->translation);
    }

    /**
     * Check if the translation has plural form.
     *
     * @return bool
     */
    public function hasPluralTranslation(): bool
    {
        return !empty($this->plural_translation);
    }

    /**
     * Mark the translation as reviewed.
     *
     * @param string $reviewer
     * @return bool
     */
    public function markAsReviewed(string $reviewer): bool
    {
        return $this->update([
            'is_reviewed' => true,
            'needs_update' => false,
            'reviewer' => $reviewer,
            'reviewed_at' => Carbon::now()
        ]);
    }

    /**
     * Mark the translation as needing update.
     *
     * @return bool
     */
    public function markNeedsUpdate(): bool
    {
        return $this->update([
            'needs_update' => true,
            'is_reviewed' => false
        ]);
    }

    /**
     * Clear review status.
     *
     * @return bool
     */
    public function clearReview(): bool
    {
        return $this->update([
            'is_reviewed' => false,
            'reviewer' => null,
            'reviewed_at' => null
        ]);
    }

    /**
     * Get the translation with parameters replaced.
     *
     * @param array $parameters
     * @param bool $plural
     * @return string
     */
    public function getProcessedTranslation(array $parameters = [], bool $plural = false): string
    {
        $text = $plural && $this->plural_translation ? 
               $this->plural_translation : 
               $this->translation;

        if (empty($text)) {
            return $this->phrase->key ?? '';
        }

        // Replace parameters
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $text = str_replace([
                    ":{$key}",
                    "{{$key}}",
                    "%{$key}%"
                ], $value, $text);
            }
        }

        return $text;
    }

    /**
     * Get metadata value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMetadata(string $key, $default = null)
    {
        return data_get($this->metadata, $key, $default);
    }

    /**
     * Set metadata value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setMetadata(string $key, $value): bool
    {
        $metadata = $this->metadata ?: [];
        data_set($metadata, $key, $value);
        
        return $this->update(['metadata' => $metadata]);
    }

    /**
     * Get translation quality score based on various factors.
     *
     * @return int
     */
    public function getQualityScore(): int
    {
        $score = 0;

        // Has translation
        if ($this->hasTranslation()) {
            $score += 40;
        }

        // Is reviewed
        if ($this->isReviewed()) {
            $score += 30;
        }

        // Has plural form (if original phrase has parameters suggesting plural)
        $phraseParams = $this->phrase->parameters ?? [];
        if (isset($phraseParams['count']) && $this->hasPluralTranslation()) {
            $score += 20;
        }

        // Doesn't need update
        if (!$this->needsUpdate()) {
            $score += 10;
        }

        return min($score, 100);
    }

    /**
     * Get review information.
     *
     * @return array
     */
    public function getReviewInfo(): array
    {
        return [
            'is_reviewed' => $this->is_reviewed,
            'reviewer' => $this->reviewer,
            'reviewed_at' => $this->reviewed_at?->format('Y-m-d H:i:s'),
            'needs_update' => $this->needs_update,
            'quality_score' => $this->getQualityScore()
        ];
    }
}