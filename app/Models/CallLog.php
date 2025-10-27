<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'admin_id',
        'phone_number',
        'call_type',
        'status',
        'duration',
        'notes',
        'call_started_at',
        'call_ended_at',
        'external_call_id',
        'call_metadata',
    ];

    protected $casts = [
        'call_started_at' => 'datetime',
        'call_ended_at' => 'datetime',
        'call_metadata' => 'array',
        'duration' => 'integer',
    ];

    /**
     * Call types.
     */
    public const TYPE_DIRECT = 'direct';
    public const TYPE_WEBRTC = 'webrtc';
    public const TYPE_WHATSAPP = 'whatsapp';
    public const TYPE_SYSTEM = 'system';

    /**
     * Call statuses.
     */
    public const STATUS_ATTEMPTED = 'attempted';
    public const STATUS_ANSWERED = 'answered';
    public const STATUS_BUSY = 'busy';
    public const STATUS_NO_ANSWER = 'no_answer';
    public const STATUS_FAILED = 'failed';
    public const STATUS_SENT = 'sent'; // For WhatsApp messages

    /**
     * Get the lead (user) that belongs to this call log.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    /**
     * Get the admin that made the call.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope for successful calls.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_ANSWERED);
    }

    /**
     * Scope for failed calls.
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', [
            self::STATUS_BUSY,
            self::STATUS_NO_ANSWER,
            self::STATUS_FAILED
        ]);
    }

    /**
     * Scope for calls by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('call_type', $type);
    }

    /**
     * Scope for calls within date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('call_started_at', [$startDate, $endDate]);
    }

    /**
     * Get call duration in human readable format.
     */
    public function getFormattedDuration(): string
    {
        if (!$this->duration) {
            return 'N/A';
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        if ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $seconds);
        }

        return sprintf('%ds', $seconds);
    }

    /**
     * Get call status display name.
     */
    public function getStatusDisplayName(): string
    {
        $statusNames = [
            self::STATUS_ATTEMPTED => 'Arama Yapıldı',
            self::STATUS_ANSWERED => 'Cevaplandı',
            self::STATUS_BUSY => 'Meşgul',
            self::STATUS_NO_ANSWER => 'Cevap Yok',
            self::STATUS_FAILED => 'Başarısız',
            self::STATUS_SENT => 'Gönderildi',
        ];

        return $statusNames[$this->status] ?? 'Bilinmiyor';
    }

    /**
     * Get call type display name.
     */
    public function getTypeDisplayName(): string
    {
        $typeNames = [
            self::TYPE_DIRECT => 'Doğrudan Arama',
            self::TYPE_WEBRTC => 'Web Araması',
            self::TYPE_WHATSAPP => 'WhatsApp',
            self::TYPE_SYSTEM => 'Sistem Araması',
        ];

        return $typeNames[$this->call_type] ?? 'Bilinmiyor';
    }

    /**
     * Check if call was successful.
     */
    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_ANSWERED;
    }

    /**
     * Check if call failed.
     */
    public function isFailed(): bool
    {
        return in_array($this->status, [
            self::STATUS_BUSY,
            self::STATUS_NO_ANSWER,
            self::STATUS_FAILED
        ]);
    }

    /**
     * Create a call log entry.
     */
    public static function createCall(array $data): self
    {
        $callLog = static::create($data);

        // Update lead's contact count and last contact date
        if ($callLog->lead) {
            $callLog->lead->increment('contact_count');
            $callLog->lead->update(['last_contact_date' => $callLog->call_started_at]);
            
            // Add to contact history
            $callLog->lead->addContactHistory(
                $data['call_type'] ?? 'call',
                $callLog->getStatusDisplayName() . 
                ($callLog->duration ? " ({$callLog->getFormattedDuration()})" : '') .
                ($data['notes'] ? " - {$data['notes']}" : ''),
                $callLog->admin_id
            );
        }

        return $callLog;
    }

    /**
     * Get call statistics for an admin.
     */
    public static function getAdminStats(int $adminId, $startDate = null, $endDate = null): array
    {
        $query = static::where('admin_id', $adminId);

        if ($startDate && $endDate) {
            $query->whereBetween('call_started_at', [$startDate, $endDate]);
        }

        $totalCalls = $query->count();
        $successfulCalls = $query->where('status', self::STATUS_ANSWERED)->count();
        $avgDuration = $query->where('status', self::STATUS_ANSWERED)->avg('duration');

        return [
            'total_calls' => $totalCalls,
            'successful_calls' => $successfulCalls,
            'failed_calls' => $totalCalls - $successfulCalls,
            'success_rate' => $totalCalls > 0 ? ($successfulCalls / $totalCalls) * 100 : 0,
            'average_duration' => $avgDuration ? round($avgDuration, 2) : 0,
            'total_talk_time' => $query->where('status', self::STATUS_ANSWERED)->sum('duration'),
        ];
    }

    /**
     * Get call statistics for a lead.
     */
    public static function getLeadStats(int $leadId): array
    {
        $query = static::where('lead_id', $leadId);

        $totalCalls = $query->count();
        $successfulCalls = $query->where('status', self::STATUS_ANSWERED)->count();
        $lastCall = $query->latest('call_started_at')->first();

        return [
            'total_calls' => $totalCalls,
            'successful_calls' => $successfulCalls,
            'last_call_date' => $lastCall?->call_started_at,
            'last_call_status' => $lastCall?->getStatusDisplayName(),
            'total_talk_time' => $query->where('status', self::STATUS_ANSWERED)->sum('duration'),
        ];
    }
}