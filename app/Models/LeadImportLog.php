<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'filename',
        'file_path',
        'status',
        'total_rows',
        'processed_rows',
        'success_count',
        'error_count',
        'warning_count',
        'errors',
        'warnings',
        'import_settings',
        'progress_percentage',
        'started_at',
        'completed_at',
        'failure_reason',
    ];

    protected $casts = [
        'errors' => 'array',
        'warnings' => 'array',
        'import_settings' => 'array',
        'progress_percentage' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'total_rows' => 'integer',
        'processed_rows' => 'integer',
        'success_count' => 'integer',
        'error_count' => 'integer',
        'warning_count' => 'integer',
    ];

    /**
     * Import statuses.
     */
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the admin that initiated the import.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope for processing imports.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    /**
     * Scope for completed imports.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for failed imports.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope for recent imports.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if import is in progress.
     */
    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    /**
     * Check if import completed successfully.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if import failed.
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Get import progress percentage.
     */
    public function getProgressPercentage(): float
    {
        if ($this->total_rows === 0) {
            return 0;
        }

        return round(($this->processed_rows / $this->total_rows) * 100, 2);
    }

    /**
     * Get import duration in seconds.
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
     * Get success rate percentage.
     */
    public function getSuccessRate(): float
    {
        if ($this->processed_rows === 0) {
            return 0;
        }

        return round(($this->success_count / $this->processed_rows) * 100, 2);
    }

    /**
     * Update import progress.
     */
    public function updateProgress(int $processedRows, int $successCount, int $errorCount, array $errors = [], array $warnings = []): bool
    {
        $this->processed_rows = $processedRows;
        $this->success_count = $successCount;
        $this->error_count = $errorCount;
        $this->warning_count = count($warnings);
        $this->progress_percentage = $this->getProgressPercentage();
        
        if (!empty($errors)) {
            $existingErrors = $this->errors ?: [];
            $this->errors = array_merge($existingErrors, $errors);
        }
        
        if (!empty($warnings)) {
            $existingWarnings = $this->warnings ?: [];
            $this->warnings = array_merge($existingWarnings, $warnings);
        }

        return $this->save();
    }

    /**
     * Mark import as completed.
     */
    public function markAsCompleted(): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);
    }

    /**
     * Mark import as failed.
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
     * Get import summary.
     */
    public function getSummary(): array
    {
        return [
            'filename' => $this->filename,
            'status' => $this->status,
            'total_rows' => $this->total_rows,
            'processed_rows' => $this->processed_rows,
            'success_count' => $this->success_count,
            'error_count' => $this->error_count,
            'warning_count' => $this->warning_count,
            'success_rate' => $this->getSuccessRate(),
            'progress_percentage' => $this->progress_percentage,
            'duration' => $this->getFormattedDuration(),
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
            'admin_name' => $this->admin?->getFullName(),
        ];
    }

    /**
     * Get recent import statistics for admin.
     */
    public static function getAdminStats(int $adminId, int $days = 30): array
    {
        $imports = static::where('admin_id', $adminId)
                        ->where('created_at', '>=', now()->subDays($days))
                        ->get();

        return [
            'total_imports' => $imports->count(),
            'successful_imports' => $imports->where('status', self::STATUS_COMPLETED)->count(),
            'failed_imports' => $imports->where('status', self::STATUS_FAILED)->count(),
            'total_leads_imported' => $imports->sum('success_count'),
            'average_success_rate' => $imports->avg('success_count'),
        ];
    }
}