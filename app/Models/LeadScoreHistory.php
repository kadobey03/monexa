<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadScoreHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'old_score',
        'new_score',
        'score_change',
        'score_breakdown',
        'change_reason',
        'change_description',
        'demographic_score',
        'engagement_score',
        'contact_score',
        'value_score',
        'referral_score',
        'trigger_event',
        'trigger_data',
    ];

    protected $casts = [
        'score_breakdown' => 'array',
        'trigger_data' => 'array',
    ];

    /**
     * Get the user that owns the score history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that triggered the score change.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Calculate score change automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->score_change = $model->new_score - $model->old_score;
        });
    }

    /**
     * Get change direction (up/down/same).
     */
    public function getChangeDirection(): string
    {
        if ($this->score_change > 0) {
            return 'up';
        } elseif ($this->score_change < 0) {
            return 'down';
        }
        return 'same';
    }

    /**
     * Get change direction icon.
     */
    public function getChangeIcon(): string
    {
        return match($this->getChangeDirection()) {
            'up' => 'fas fa-arrow-up',
            'down' => 'fas fa-arrow-down',
            default => 'fas fa-minus',
        };
    }

    /**
     * Get change direction color.
     */
    public function getChangeColorClass(): string
    {
        return match($this->getChangeDirection()) {
            'up' => 'text-green-600',
            'down' => 'text-red-600',
            default => 'text-gray-600',
        };
    }

    /**
     * Get formatted change description.
     */
    public function getFormattedChange(): string
    {
        $direction = $this->getChangeDirection();
        $absChange = abs($this->score_change);

        return match($direction) {
            'up' => "+{$absChange} puan artış",
            'down' => "-{$absChange} puan düşüş",
            default => "Değişiklik yok",
        };
    }
}