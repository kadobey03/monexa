<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AdminAuditLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'admin_name',
        'admin_email',
        'action',
        'entity_type',
        'entity_id',
        'entity_name',
        'method',
        'url',
        'route',
        'request_data',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'session_id',
        'headers',
        'category',
        'severity',
        'status',
        'description',
        'reason',
        'affected_entities',
        'affected_count',
        'is_bulk_operation',
        'operation_id',
        'execution_time_ms',
        'memory_usage_mb',
        'performance_metrics',
        'is_sensitive',
        'requires_approval',
        'approved_by',
        'approved_at',
        'compliance_status',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'tags',
        'metadata',
        'reference_id',
        'notes',
        'occurred_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'session_id',
        'headers',
        'request_data', // May contain sensitive data
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_data' => 'array',
        'old_values' => 'array',
        'new_values' => 'array',
        'headers' => 'array',
        'affected_entities' => 'array',
        'performance_metrics' => 'array',
        'tags' => 'array',
        'metadata' => 'array',
        'is_bulk_operation' => 'boolean',
        'is_sensitive' => 'boolean',
        'requires_approval' => 'boolean',
        'affected_count' => 'integer',
        'execution_time_ms' => 'integer',
        'memory_usage_mb' => 'integer',
        'occurred_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Audit log severity levels.
     */
    public const SEVERITY_INFO = 'info';
    public const SEVERITY_WARNING = 'warning';
    public const SEVERITY_ERROR = 'error';
    public const SEVERITY_CRITICAL = 'critical';

    /**
     * Audit log statuses.
     */
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';
    public const STATUS_PARTIAL = 'partial';

    /**
     * Compliance statuses.
     */
    public const COMPLIANCE_COMPLIANT = 'compliant';
    public const COMPLIANCE_NON_COMPLIANT = 'non_compliant';
    public const COMPLIANCE_PENDING = 'pending';

    /**
     * Categories for audit logs.
     */
    public const CATEGORIES = [
        'authentication' => 'Authentication',
        'authorization' => 'Authorization',
        'user_management' => 'User Management',
        'admin_management' => 'Admin Management',
        'lead_management' => 'Lead Management',
        'role_management' => 'Role Management',
        'system_configuration' => 'System Configuration',
        'data_export' => 'Data Export',
        'data_import' => 'Data Import',
        'financial_operations' => 'Financial Operations',
        'security_events' => 'Security Events',
        'performance_issues' => 'Performance Issues',
    ];

    /**
     * Get the admin who performed the action.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the admin who approved the action.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * Scope a query to filter by admin.
     */
    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    /**
     * Scope a query to filter by action.
     */
    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to filter by entity type.
     */
    public function scopeByEntityType($query, string $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by severity.
     */
    public function scopeBySeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('occurred_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by IP address.
     */
    public function scopeByIpAddress($query, string $ipAddress)
    {
        return $query->where('ip_address', $ipAddress);
    }

    /**
     * Scope a query to get sensitive operations.
     */
    public function scopeSensitive($query)
    {
        return $query->where('is_sensitive', true);
    }

    /**
     * Scope a query to get bulk operations.
     */
    public function scopeBulkOperations($query)
    {
        return $query->where('is_bulk_operation', true);
    }

    /**
     * Scope a query to get failed operations.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope a query to get critical operations.
     */
    public function scopeCritical($query)
    {
        return $query->where('severity', self::SEVERITY_CRITICAL);
    }

    /**
     * Scope a query to get recent logs.
     */
    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('occurred_at', '>=', Carbon::now()->subHours($hours));
    }

    /**
     * Create an audit log entry.
     */
    public static function logAction(array $data): self
    {
        // Set default values
        $data = array_merge([
            'occurred_at' => now(),
            'severity' => self::SEVERITY_INFO,
            'status' => self::STATUS_SUCCESS,
            'category' => 'general',
        ], $data);

        // Auto-detect sensitive operations
        if (!isset($data['is_sensitive'])) {
            $data['is_sensitive'] = static::isSensitiveOperation($data);
        }

        // Auto-detect if approval is required
        if (!isset($data['requires_approval'])) {
            $data['requires_approval'] = static::requiresApproval($data);
        }

        return static::create($data);
    }

    /**
     * Log admin login.
     */
    public static function logLogin(Admin $admin, array $requestData = []): self
    {
        return static::logAction([
            'admin_id' => $admin->id,
            'admin_name' => $admin->firstName . ' ' . $admin->lastName,
            'admin_email' => $admin->email,
            'action' => 'login',
            'entity_type' => 'admin',
            'entity_id' => $admin->id,
            'category' => 'authentication',
            'description' => 'Admin logged in',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
            'request_data' => $requestData,
        ]);
    }

    /**
     * Log admin logout.
     */
    public static function logLogout(Admin $admin): self
    {
        return static::logAction([
            'admin_id' => $admin->id,
            'admin_name' => $admin->firstName . ' ' . $admin->lastName,
            'admin_email' => $admin->email,
            'action' => 'logout',
            'entity_type' => 'admin',
            'entity_id' => $admin->id,
            'category' => 'authentication',
            'description' => 'Admin logged out',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Log entity creation.
     */
    public static function logCreation(Admin $admin, Model $entity, array $data = []): self
    {
        return static::logAction([
            'admin_id' => $admin->id,
            'admin_name' => $admin->firstName . ' ' . $admin->lastName,
            'admin_email' => $admin->email,
            'action' => 'create',
            'entity_type' => class_basename($entity),
            'entity_id' => $entity->id,
            'entity_name' => static::getEntityName($entity),
            'category' => static::getCategoryForEntity($entity),
            'description' => 'Created ' . class_basename($entity),
            'new_values' => $entity->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
            'metadata' => $data,
        ]);
    }

    /**
     * Log entity update.
     */
    public static function logUpdate(Admin $admin, Model $entity, array $oldValues, array $newValues): self
    {
        return static::logAction([
            'admin_id' => $admin->id,
            'admin_name' => $admin->firstName . ' ' . $admin->lastName,
            'admin_email' => $admin->email,
            'action' => 'update',
            'entity_type' => class_basename($entity),
            'entity_id' => $entity->id,
            'entity_name' => static::getEntityName($entity),
            'category' => static::getCategoryForEntity($entity),
            'description' => 'Updated ' . class_basename($entity),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Log entity deletion.
     */
    public static function logDeletion(Admin $admin, Model $entity): self
    {
        return static::logAction([
            'admin_id' => $admin->id,
            'admin_name' => $admin->firstName . ' ' . $admin->lastName,
            'admin_email' => $admin->email,
            'action' => 'delete',
            'entity_type' => class_basename($entity),
            'entity_id' => $entity->id,
            'entity_name' => static::getEntityName($entity),
            'category' => static::getCategoryForEntity($entity),
            'description' => 'Deleted ' . class_basename($entity),
            'old_values' => $entity->toArray(),
            'severity' => self::SEVERITY_WARNING,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Check if operation is sensitive.
     */
    protected static function isSensitiveOperation(array $data): bool
    {
        $sensitiveActions = ['delete', 'bulk_assign', 'export', 'system_settings'];
        $sensitiveCategories = ['security_events', 'financial_operations', 'system_configuration'];
        
        return in_array($data['action'] ?? '', $sensitiveActions) ||
               in_array($data['category'] ?? '', $sensitiveCategories) ||
               str_contains($data['description'] ?? '', 'password');
    }

    /**
     * Check if operation requires approval.
     */
    protected static function requiresApproval(array $data): bool
    {
        $approvalRequiredActions = ['delete', 'bulk_assign', 'system_settings'];
        
        return in_array($data['action'] ?? '', $approvalRequiredActions) ||
               ($data['severity'] ?? '') === self::SEVERITY_CRITICAL;
    }

    /**
     * Get entity name for logging.
     */
    protected static function getEntityName(Model $entity): ?string
    {
        if (method_exists($entity, 'getDisplayName')) {
            return $entity->getDisplayName();
        }

        $nameFields = ['name', 'title', 'display_name', 'firstName', 'email'];
        
        foreach ($nameFields as $field) {
            if (isset($entity->$field)) {
                return $entity->$field;
            }
        }

        return null;
    }

    /**
     * Get category for entity.
     */
    protected static function getCategoryForEntity(Model $entity): string
    {
        $entityClass = class_basename($entity);
        
        $categoryMap = [
            'User' => 'user_management',
            'Admin' => 'admin_management',
            'Role' => 'role_management',
            'Permission' => 'role_management',
            'AdminGroup' => 'admin_management',
            'AdminSetting' => 'system_configuration',
        ];

        return $categoryMap[$entityClass] ?? 'general';
    }

    /**
     * Get performance impact level.
     */
    public function getPerformanceImpact(): string
    {
        if (!$this->execution_time_ms) {
            return 'unknown';
        }

        if ($this->execution_time_ms < 1000) {
            return 'low';
        } elseif ($this->execution_time_ms < 5000) {
            return 'medium';
        } else {
            return 'high';
        }
    }

    /**
     * Get the display name for category.
     */
    public function getCategoryDisplayName(): string
    {
        return static::CATEGORIES[$this->category] ?? ucwords(str_replace('_', ' ', $this->category));
    }

    /**
     * Check if this log entry is suspicious.
     */
    public function isSuspicious(): bool
    {
        return $this->severity === self::SEVERITY_CRITICAL ||
               $this->status === self::STATUS_FAILED ||
               $this->execution_time_ms > 10000 ||
               str_contains($this->description, 'failed') ||
               str_contains($this->description, 'error');
    }

    /**
     * Get formatted description.
     */
    public function getFormattedDescription(): string
    {
        if ($this->description) {
            return $this->description;
        }

        return sprintf(
            '%s %s %s',
            $this->admin_name ?: 'System',
            $this->action,
            $this->entity_name ?: $this->entity_type
        );
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getFormattedDescription();
    }
}