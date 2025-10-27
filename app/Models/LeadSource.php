<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadSource extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_sources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'color',
        'icon',
        'conversion_rate',
        'cost_per_lead',
        'priority_weight'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'conversion_rate' => 'decimal:2',
        'cost_per_lead' => 'decimal:2',
        'priority_weight' => 'integer'
    ];

    /**
     * Get all users (leads) associated with this lead source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'lead_source_id');
    }

    /**
     * Get all activities for leads from this source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function activities()
    {
        return $this->hasManyThrough(LeadActivity::class, User::class, 'lead_source_id', 'user_id');
    }

    /**
     * Scope to get only active lead sources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by priority weight (highest first).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriority($query)
    {
        return $query->orderByDesc('priority_weight');
    }

    /**
     * Get the conversion rate as percentage.
     *
     * @return float
     */
    public function getConversionRatePercentageAttribute(): float
    {
        return $this->conversion_rate * 100;
    }

    /**
     * Get formatted cost per lead.
     *
     * @return string
     */
    public function getFormattedCostPerLeadAttribute(): string
    {
        return '$' . number_format($this->cost_per_lead, 2);
    }

    /**
     * Calculate total leads from this source.
     *
     * @return int
     */
    public function getTotalLeadsAttribute(): int
    {
        return $this->users()->count();
    }

    /**
     * Calculate converted leads from this source.
     *
     * @return int
     */
    public function getConvertedLeadsAttribute(): int
    {
        return $this->users()->whereNotNull('email_verified_at')->count();
    }

    /**
     * Get leads statistics for this source.
     *
     * @return array
     */
    public function getStatsAttribute(): array
    {
        $totalLeads = $this->users()->count();
        $convertedLeads = $this->users()->whereNotNull('email_verified_at')->count();
        $activeLeads = $this->users()->where('status', '!=', 'inactive')->count();

        return [
            'total_leads' => $totalLeads,
            'converted_leads' => $convertedLeads,
            'active_leads' => $activeLeads,
            'conversion_rate' => $totalLeads > 0 ? ($convertedLeads / $totalLeads) * 100 : 0,
            'total_cost' => $totalLeads * $this->cost_per_lead,
            'cost_per_conversion' => $convertedLeads > 0 ? ($totalLeads * $this->cost_per_lead) / $convertedLeads : 0
        ];
    }

    /**
     * Get the CSS class for the lead source color.
     *
     * @return string
     */
    public function getColorClassAttribute(): string
    {
        $colorMap = [
            'blue' => 'bg-blue-100 text-blue-800',
            'green' => 'bg-green-100 text-green-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'red' => 'bg-red-100 text-red-800',
            'purple' => 'bg-purple-100 text-purple-800',
            'indigo' => 'bg-indigo-100 text-indigo-800',
            'pink' => 'bg-pink-100 text-pink-800',
            'gray' => 'bg-gray-100 text-gray-800'
        ];

        return $colorMap[$this->color] ?? $colorMap['gray'];
    }
}