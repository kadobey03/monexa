<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag_icon',
        'is_active',
        'is_default',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the phrase translations for the language.
     *
     * @return HasMany
     */
    public function phraseTranslations(): HasMany
    {
        return $this->hasMany(PhraseTranslation::class);
    }

    /**
     * Get the phrases through translations for the language.
     *
     * @return HasManyThrough
     */
    public function phrases(): HasManyThrough
    {
        return $this->hasManyThrough(Phrase::class, PhraseTranslation::class);
    }

    /**
     * Scope a query to only include active languages.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include the default language.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope a query to order languages by sort order.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the display name with flag icon.
     *
     * @return Attribute
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->flag_icon ? "{$this->flag_icon} {$this->name}" : $this->name,
        );
    }

    /**
     * Get the language direction (LTR/RTL).
     *
     * @return Attribute
     */
    protected function direction(): Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->code, ['ar', 'he', 'fa', 'ur']) ? 'rtl' : 'ltr',
        );
    }

    /**
     * Check if this is the default language.
     *
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->is_default;
    }

    /**
     * Check if this language is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Set this language as default.
     *
     * @return bool
     */
    public function setAsDefault(): bool
    {
        // First, remove default from all other languages
        static::where('is_default', true)->update(['is_default' => false]);
        
        // Set this language as default
        return $this->update(['is_default' => true]);
    }

    /**
     * Get the translation completion percentage for this language.
     *
     * @return float
     */
    public function getCompletionPercentage(): float
    {
        $totalPhrases = Phrase::active()->count();
        
        if ($totalPhrases === 0) {
            return 0.0;
        }

        $translatedPhrases = $this->phraseTranslations()
            ->whereHas('phrase', fn($query) => $query->active())
            ->whereNotNull('translation')
            ->where('translation', '!=', '')
            ->count();

        return round(($translatedPhrases / $totalPhrases) * 100, 2);
    }

    /**
     * Get untranslated phrases count for this language.
     *
     * @return int
     */
    public function getUntranslatedPhrasesCount(): int
    {
        $activePhraseIds = Phrase::active()->pluck('id');
        $translatedPhraseIds = $this->phraseTranslations()
            ->whereNotNull('translation')
            ->where('translation', '!=', '')
            ->pluck('phrase_id');

        return $activePhraseIds->diff($translatedPhraseIds)->count();
    }
}