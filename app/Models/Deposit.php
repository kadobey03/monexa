<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'payment_mode',
        'proof',
        'txn_id',
        'user',
        'plan',
        'signals',
        'created_at',
        'updated_at',
        'fees'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fees' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Enhanced relationship with User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * Relationship with Plans
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    /**
     * Business logic scopes
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIn('status', ['processed', 'approved']);
    }

    public function scopeByDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeByPaymentMethod(Builder $query, string $method): Builder
    {
        return $query->where('payment_mode', $method);
    }

    public function scopeHighValue(Builder $query, float $threshold = 1000): Builder
    {
        return $query->where('amount', '>=', $threshold);
    }

    /**
     * Business logic methods
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['processed', 'approved']);
    }

    public function getNetAmount(): float
    {
        return $this->amount - ($this->fees ?? 0);
    }

    public function getFormattedAmount(): string
    {
        return number_format($this->amount, 2) . ' ' . ($this->user?->currency ?? 'USD');
    }

    /**
     * Legacy relationships (kept for backward compatibility)
     */
    public function duser(){
    	return $this->user();
    }

    public function dplan(){
    	return $this->plan();
    }
}
