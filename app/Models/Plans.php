<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'increment_amount',
        'increment_interval',
        'increment_type',
        'increment_percentage',
        'total_return',
        'total_duration',
        'min_investment',
        'max_investment',
        'status',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'increment_amount' => 'decimal:2',
        'increment_percentage' => 'decimal:2',
        'total_return' => 'decimal:2',
        'total_duration' => 'integer',
        'min_investment' => 'decimal:2',
        'max_investment' => 'decimal:2',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Enhanced relationships
     */
    public function userPlans(): HasMany
    {
        return $this->hasMany(User_plans::class, 'plan');
    }

    public function activeInvestments(): HasMany
    {
        return $this->userPlans()->where('status', 'active');
    }

    public function completedInvestments(): HasMany
    {
        return $this->userPlans()->where('status', 'completed');
    }

    /**
     * Business logic scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByPriceRange(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByDuration(Builder $query, int $days): Builder
    {
        return $query->where('total_duration', $days);
    }

    public function scopeHighReturn(Builder $query, float $minReturn = 100): Builder
    {
        return $query->where('total_return', '>=', $minReturn);
    }

    /**
     * Business logic methods
     */
    public function getReturnPercentage(): float
    {
        if ($this->price <= 0) {
            return 0;
        }

        return ($this->total_return / $this->price) * 100;
    }

    public function getMonthlyReturn(): float
    {
        if ($this->total_duration <= 0) {
            return 0;
        }

        return $this->total_return / $this->total_duration;
    }

    public function getDailyIncrementAmount(): float
    {
        if ($this->increment_interval !== 'daily' || $this->increment_amount <= 0) {
            return 0;
        }

        return $this->increment_amount;
    }

    public function isValidInvestment(float $amount): bool
    {
        if ($this->min_investment && $amount < $this->min_investment) {
            return false;
        }

        if ($this->max_investment && $amount > $this->max_investment) {
            return false;
        }

        return true;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2) . ' USD';
    }

    public function getFormattedReturn(): string
    {
        return number_format($this->total_return, 2) . ' USD (' . number_format($this->getReturnPercentage(), 1) . '%)';
    }

    /**
     * Accessor for calculated fields
     */
    public function getReturnPercentageAttribute(): float
    {
        return $this->getReturnPercentage();
    }

    public function getMonthlyReturnAttribute(): float
    {
        return $this->getMonthlyReturn();
    }
}
