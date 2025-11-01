<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_id',
        'user_id',
        'exception_class',
        'error_type',
        'error_message',
        'error_code',
        'status_code',
        'request_id',
        'url',
        'method',
        'user_agent',
        'ip_address',
        'context',
        'stack_trace',
        'handled',
        'resolved_at',
        'metadata',
    ];

    protected $casts = [
        'context' => 'array',
        'metadata' => 'array',
        'handled' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    /**
     * Error categories
     */
    public const ERROR_CATEGORIES = [
        'financial' => 'Finansal',
        'authentication' => 'Kimlik Doğrulama',
        'authorization' => 'Yetkilendirme',
        'validation' => 'Doğrulama',
        'network' => 'Ağ',
        'server' => 'Sunucu',
        'rate_limit' => 'Rate Limiting',
        'kyc' => 'KYC',
        'general' => 'Genel',
    ];

    /**
     * Severity levels
     */
    public const SEVERITY_LEVELS = [
        'low' => 'Düşük',
        'medium' => 'Orta',
        'high' => 'Yüksek',
        'critical' => 'Kritik',
    ];

    /**
     * Get the user that owns the error log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for financial errors
     */
    public function scopeFinancial($query)
    {
        return $query->where('error_type', 'financial');
    }

    /**
     * Scope for unhandled errors
     */
    public function scopeUnhandled($query)
    {
        return $query->where('handled', false);
    }

    /**
     * Scope for critical errors
     */
    public function scopeCritical($query)
    {
        return $query->where('metadata->severity', 'critical');
    }

    /**
     * Scope for recent errors
     */
    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    /**
     * Mark error as handled
     */
    public function markAsHandled(): void
    {
        $this->update([
            'handled' => true,
            'resolved_at' => now(),
        ]);
    }

    /**
     * Get severity level
     */
    public function getSeverityAttribute(): string
    {
        return $this->metadata['severity'] ?? 'medium';
    }

    /**
     * Get formatted error category
     */
    public function getCategoryNameAttribute(): string
    {
        return self::ERROR_CATEGORIES[$this->error_type] ?? $this->error_type;
    }

    /**
     * Get formatted severity name
     */
    public function getSeverityNameAttribute(): string
    {
        return self::SEVERITY_LEVELS[$this->severity] ?? 'Orta';
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($errorLog) {
            if (!$errorLog->error_id) {
                $errorLog->error_id = 'err_' . uniqid();
            }
        });
    }
}