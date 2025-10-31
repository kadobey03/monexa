<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'payment_mode',
        'paydetails',
        'to_deduct',
        'charges',
        'user',
        'txn_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'charges' => 'decimal:2',
        'to_deduct' => 'decimal:2',
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
     * Business logic scopes
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIn('status', ['processed', 'approved', 'paid']);
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

    public function scopeWithCharges(Builder $query): Builder
    {
        return $query->where('charges', '>', 0);
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
        return in_array($this->status, ['processed', 'approved', 'paid']);
    }

    public function getNetAmount(): float
    {
        return $this->amount - ($this->charges ?? 0) - ($this->to_deduct ?? 0);
    }

    public function getTotalDeductions(): float
    {
        return ($this->charges ?? 0) + ($this->to_deduct ?? 0);
    }

    public function getFormattedAmount(): string
    {
        return number_format($this->amount, 2) . ' ' . ($this->user?->currency ?? 'USD');
    }

    public function getProcessingFee(): float
    {
        return $this->charges ?? 0;
    }

    /**
     * Legacy relationship (kept for backward compatibility)
     */
    public function duser(){
    	return $this->user();
    }
}
