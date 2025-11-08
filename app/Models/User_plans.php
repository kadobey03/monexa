<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class User_plans extends Model
{
    use HasFactory;

    protected $table = 'user_plans';

    protected $fillable = [
        'plan',
        'amount',
        'activate',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'assets',
        'type',
        'leverage',
        'profit_earned',
        'active',
        'symbol',
        'user',
        'user_name',
        'user_email',
        'start_date',
        'end_date',
        'expected_return',
        'status'
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
        'expire_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount' => 'decimal:2',
        'expected_return' => 'decimal:2',
        'profit_earned' => 'decimal:2',
        'active' => 'boolean',
    ];

    /**
     * Enhanced relationships
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * Legacy relationships (kept for backward compatibility)
     */
    public function dplan(){
        return $this->plan();
    }

    public function getUserNameAttribute(){
        // Önce cache alanını kontrol et (database'den gelen değer)
        if (!empty($this->attributes['user_name'])) {
            return $this->attributes['user_name'];
        }

        // Cache boşsa, ilişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->name;
        }

        return 'Kullanıcı Bulunamadı';
    }

    public function getUserEmailAttribute(){
        // Önce cache alanını kontrol et (database'den gelen değer)
        if (!empty($this->attributes['user_email'])) {
            return $this->attributes['user_email'];
        }

        // Cache boşsa, ilişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->email;
        }

        return 'Belirtilmemiş';
    }

    public function getUserStatusAttribute(){
        // İlişki yüklenmiş ve geçerli mi kontrol et
        if ($this->relationLoaded('user') && $this->user && is_object($this->user)) {
            return $this->user->status ?? 'Bilinmiyor';
        }

        return 'Bilinmiyor';
    }

    /**
     * Geçersiz user ID'leri otomatik düzelt ve user_name/user_email'i güncelle
     */
    public static function fixInvalidUserIds()
    {
        $allUserIdsInTrades = self::whereNotNull('user')->where('user', '!=', 0)->pluck('user')->unique();
        $existingUserIds = User::pluck('id')->toArray();
        $missingUserIds = $allUserIdsInTrades->diff($existingUserIds)->values();

        if ($missingUserIds->isNotEmpty()) {
            foreach ($missingUserIds as $invalidId) {
                $tradeCount = self::where('user', $invalidId)->count();

                if ($tradeCount > 0) {
                    // Geçersiz user ID'yi null yap
                    self::where('user', $invalidId)->update(['user' => null]);
                    \Illuminate\Support\Facades\Log::info("Geçersiz user ID {$invalidId} düzeltildi. {$tradeCount} kayıt etkilendi.");
                }
            }

            return $missingUserIds->sum(function($id) {
                return self::where('user', $id)->count();
            });
        }

        return 0;
    }

    /**
     * Business logic scopes
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeByPlan(Builder $query, int $planId): Builder
    {
        return $query->where('plan', $planId);
    }

    public function scopeByDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeHighValue(Builder $query, float $threshold = 1000): Builder
    {
        return $query->where('amount', '>=', $threshold);
    }

    public function scopeProfitable(Builder $query, float $minProfit = 100): Builder
    {
        return $query->where('profit_earned', '>=', $minProfit);
    }

    /**
     * Business logic methods
     */
    public function isActive(): bool
    {
        return $this->active && $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function getTotalReturn(): float
    {
        return $this->profit_earned + $this->amount;
    }

    public function getCurrentValue(): float
    {
        return $this->amount + $this->profit_earned;
    }

    public function getProgressPercentage(): float
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }

        $totalDays = $this->start_date->diffInDays($this->end_date);
        $elapsedDays = $this->start_date->diffInDays(now());

        if ($totalDays <= 0) {
            return 100;
        }

        return min(100, ($elapsedDays / $totalDays) * 100);
    }

    public function getFormattedAmount(): string
    {
        return number_format($this->amount, 2) . ' ' . ($this->user?->currency ?? 'USD');
    }

    public function getFormattedProfit(): string
    {
        return number_format($this->profit_earned, 2) . ' ' . ($this->user?->currency ?? 'USD');
    }

    /**
     * User ilişkisi yüklenemediğinde user_name ve user_email alanlarını güncelle
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Eğer user ilişkisi yüklenmiş ve null ise, user_name ve user_email alanlarını temizle
            if ($model->relationLoaded('user') && is_null($model->user)) {
                $model->user = null;
                $model->user_name = null;
                $model->user_email = null;
            }
        });

        static::retrieved(function ($model) {
            // Eğer user ilişkisi yüklenmiş ve geçersiz ise, otomatik düzelt
            if ($model->relationLoaded('user') && $model->user === null && !is_null($model->getOriginal('user'))) {
                // Geçersiz user ID'yi tespit ettik, düzeltelim
                $model->user = null;
                $model->user_name = null;
                $model->user_email = null;
                $model->save();
            }
        });
    }

}
