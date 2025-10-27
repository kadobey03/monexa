<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadExportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'filename',
        'file_path',
        'format',
        'status',
        'record_count',
        'filters_applied',
        'columns_exported',
        'export_settings',
        'file_size_kb',
        'started_at',
        'completed_at',
        'expires_at',
        'failure_reason',
    ];

    protected $casts = [
        'filters_applied' => 'array',
        'columns_exported' => 'array',
        'export_settings' => 'array',
        'file_size_kb' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'record_count' => 'integer',
    ];

    /**
     * Export statuses.
     */
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';

    /**
     * Export formats.
     */
    public const FORMAT_XLSX = 'xlsx';
    public const FORMAT_CSV = 'csv';
    public const FORMAT_PDF = 'pdf';

    /**
     * Get the admin that initiated the export.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope for processing exports.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    /**
     * Scope for completed exports.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for failed exports.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope for expired exports.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED)
                    ->orWhere('expires_at', '<', now());
    }

    /**
     * Scope for available downloads.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_COMPLETED)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for recent exports.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if export is in progress.
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if export completed successfully.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if export failed.
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if export is expired.
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED || 
               ($this->expires_at && $this->expires_at->isPast());
    }

    /**
     * Check if export is available for download.
     */
    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_COMPLETED && 
               !$this->isExpired() && 
               file_exists($this->file_path);
    }

    /**
     * Get export duration in seconds.
     */
    public function getDurationInSeconds(): ?int
    {
        if (!$this->started_at || !$this->completed_at) {
            return null;
        }

        return $this->completed_at->diffInSeconds($this->started_at);
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDuration(): string
    {
        $duration = $this->getDurationInSeconds();
        
        if (!$duration) {
            return 'N/A';
        }

        $minutes = floor($duration / 60);
        $seconds = $duration % 60;

        if ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $seconds);
        }

        return sprintf('%ds', $seconds);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSize(): string
    {
        if (!$this->file_size_kb) {
            return 'N/A';
        }

        if ($this->file_size_kb < 1024) {
            return round($this->file_size_kb, 2) . ' KB';
        }

        $mb = $this->file_size_kb / 1024;
        if ($mb < 1024) {
            return round($mb, 2) . ' MB';
        }

        $gb = $mb / 1024;
        return round($gb, 2) . ' GB';
    }

    /**
     * Get format display name.
     */
    public function getFormatDisplayName(): string
    {
        $formatNames = [
            self::FORMAT_XLSX => 'Excel (XLSX)',
            self::FORMAT_CSV => 'CSV',
            self::FORMAT_PDF => 'PDF',
        ];

        return $formatNames[$this->format] ?? strtoupper($this->format);
    }

    /**
     * Mark export as completed.
     */
    public function markAsCompleted(string $filePath, float $fileSizeKb): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'file_path' => $filePath,
            'file_size_kb' => $fileSizeKb,
            'completed_at' => now(),
            'expires_at' => now()->addHours(24), // Files expire after 24 hours
        ]);
    }

    /**
     * Mark export as failed.
     */
    public function markAsFailed(string $reason): bool
    {
        return $this->update([
            'status' => self::STATUS_FAILED,
            'completed_at' => now(),
            'failure_reason' => $reason,
        ]);
    }

    /**
     * Mark export as expired.
     */
    public function markAsExpired(): bool
    {
        return $this->update([
            'status' => self::STATUS_EXPIRED,
        ]);
    }

    /**
     * Get download URL.
     */
    public function getDownloadUrl(): ?string
    {
        if (!$this->isAvailable()) {
            return null;
        }

        return route('admin.leads.export.download', $this->id);
    }

    /**
     * Get export summary.
     */
    public function getSummary(): array
    {
        return [
            'filename' => $this->filename,
            'format' => $this->getFormatDisplayName(),
            'status' => $this->status,
            'record_count' => $this->record_count,
            'file_size' => $this->getFormattedFileSize(),
            'duration' => $this->getFormattedDuration(),
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
            'expires_at' => $this->expires_at,
            'download_url' => $this->getDownloadUrl(),
            'admin_name' => $this->admin?->getFullName(),
            'is_available' => $this->isAvailable(),
        ];
    }

    /**
     * Get recent export statistics for admin.
     */
    public static function getAdminStats(int $adminId, int $days = 30): array
    {
        $exports = static::where('admin_id', $adminId)
                        ->where('created_at', '>=', now()->subDays($days))
                        ->get();

        return [
            'total_exports' => $exports->count(),
            'successful_exports' => $exports->where('status', self::STATUS_COMPLETED)->count(),
            'failed_exports' => $exports->where('status', self::STATUS_FAILED)->count(),
            'total_records_exported' => $exports->sum('record_count'),
            'total_file_size_mb' => round($exports->sum('file_size_kb') / 1024, 2),
            'most_used_format' => $exports->groupBy('format')->sortByDesc(function($group) {
                return $group->count();
            })->keys()->first(),
        ];
    }

    /**
     * Clean up expired export files.
     */
    public static function cleanupExpiredFiles(): int
    {
        $expiredExports = static::where('expires_at', '<', now())
                               ->where('status', '!=', self::STATUS_EXPIRED)
                               ->get();

        $cleanedCount = 0;

        foreach ($expiredExports as $export) {
            if ($export->file_path && file_exists($export->file_path)) {
                unlink($export->file_path);
            }
            
            $export->markAsExpired();
            $cleanedCount++;
        }

        return $cleanedCount;
    }
}