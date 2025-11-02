<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'category',
        'resource',
        'action',
        'is_active',
        'priority',
        'constraints',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
        'constraints' => 'array',
    ];

    /**
     * Available permission categories.
     */
    public const CATEGORIES = [
        'user' => 'User Management',
        'admin' => 'Admin Management',
        'role' => 'Role Management',
        'lead' => 'Lead Management',
        'group' => 'Group Management',
        'system' => 'System Management',
        'permission' => 'Permission Management',
        'notification' => 'Notification Management',
        'finance' => 'Financial Management',
        'report' => 'Report Management',
    ];

    /**
     * Available permission actions.
     */
    public const ACTIONS = [
        'view' => 'View',
        'create' => 'Create',
        'update' => 'Update',
        'delete' => 'Delete',
        'assign' => 'Assign',
        'bulk_assign' => 'Bulk Assign',
        'export' => 'Export',
        'import' => 'Import',
        'approve' => 'Approve',
        'send' => 'Send',
        'manage_members' => 'Manage Members',
        'settings' => 'Settings',
        'backup' => 'Backup',
        'maintenance' => 'Maintenance',
        'view_subordinates' => 'View Subordinates',
        'update_subordinates' => 'Update Subordinates',
        'delete_subordinates' => 'Delete Subordinates',
        'view_all' => 'View All',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
                    ->withPivot('is_granted', 'constraints', 'granted_at', 'granted_by', 'expires_at', 'notes')
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by resource.
     */
    public function scopeByResource($query, string $resource)
    {
        return $query->where('resource', $resource);
    }

    /**
     * Scope a query to filter by action.
     */
    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to order by priority.
     */
    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority')->orderBy('name');
    }

    /**
     * Scope a query to get permissions for specific categories.
     */
    public function scopeForCategories($query, array $categories)
    {
        return $query->whereIn('category', $categories);
    }

    /**
     * Scope a query to get management permissions.
     */
    public function scopeManagement($query)
    {
        return $query->whereIn('action', ['create', 'update', 'delete', 'assign', 'manage_members']);
    }

    /**
     * Scope a query to get view-only permissions.
     */
    public function scopeViewOnly($query)
    {
        return $query->where('action', 'view');
    }

    /**
     * Check if this permission is critical (affects system security).
     */
    public function isCritical(): bool
    {
        $criticalPermissions = [
            'system_settings',
            'system_backup',
            'system_maintenance',
            'role_create',
            'role_delete',
            'admin_create',
            'admin_delete_subordinates',
            'permission_assign',
        ];

        return in_array($this->name, $criticalPermissions);
    }

    /**
     * Check if this permission requires approval.
     */
    public function requiresApproval(): bool
    {
        return $this->isCritical() || 
               in_array($this->action, ['delete', 'bulk_assign']) ||
               $this->category === 'system';
    }

    /**
     * Get permission display name.
     */
    public function getDisplayName(): string
    {
        return $this->display_name ?: ucwords(str_replace('_', ' ', $this->name));
    }

    /**
     * Get permission category display name.
     */
    public function getCategoryDisplayName(): string
    {
        return static::CATEGORIES[$this->category] ?? ucwords($this->category);
    }

    /**
     * Get permission action display name.
     */
    public function getActionDisplayName(): string
    {
        return static::ACTIONS[$this->action] ?? ucwords(str_replace('_', ' ', $this->action));
    }

    /**
     * Get permission description or generate one.
     */
    public function getDescription(): string
    {
        if ($this->description) {
            return $this->description;
        }

        return sprintf(
            '%s %s',
            $this->getActionDisplayName(),
            str_replace('_', ' ', $this->resource)
        );
    }

    /**
     * Check if permission has constraints.
     */
    public function hasConstraints(): bool
    {
        return !empty($this->constraints);
    }

    /**
     * Get a specific constraint value.
     */
    public function getConstraint(string $key, $default = null)
    {
        return data_get($this->constraints, $key, $default);
    }

    /**
     * Check if permission is granted to a specific role.
     */
    public function isGrantedToRole(Role $role): bool
    {
        return $this->roles()
                   ->where('role_id', $role->id)
                   ->wherePivot('is_granted', true)
                   ->where(function ($query) {
                       $query->whereNull('role_permissions.expires_at')
                             ->orWhere('role_permissions.expires_at', '>', now());
                   })
                   ->exists();
    }

    /**
     * Get all permissions grouped by category.
     */
    public static function getGroupedByCategory(): array
    {
        return static::active()
                    ->orderByPriority()
                    ->get()
                    ->groupBy('category')
                    ->map(function ($permissions, $category) {
                        return [
                            'category' => $category,
                            'display_name' => static::CATEGORIES[$category] ?? ucwords($category),
                            'permissions' => $permissions,
                        ];
                    })
                    ->values()
                    ->toArray();
    }

    /**
     * Get permissions by role.
     */
    public static function getByRole(Role $role): \Illuminate\Database\Eloquent\Collection
    {
        return static::whereHas('roles', function ($query) use ($role) {
                        $query->where('role_id', $role->id)
                              ->wherePivot('is_granted', true)
                              ->where(function ($subQuery) {
                                  $subQuery->whereNull('role_permissions.expires_at')
                                          ->orWhere('role_permissions.expires_at', '>', now());
                              });
                    })
                    ->active()
                    ->orderByPriority()
                    ->get();
    }

    /**
     * Get permissions for specific resource and action.
     */
    public static function findByResourceAndAction(string $resource, string $action): ?self
    {
        return static::where('resource', $resource)
                    ->where('action', $action)
                    ->active()
                    ->first();
    }

    /**
     * Create a permission name from resource and action.
     */
    public static function createPermissionName(string $resource, string $action): string
    {
        return strtolower($resource) . '_' . strtolower($action);
    }

    /**
     * Check if a permission name exists.
     */
    public static function exists(string $permissionName): bool
    {
        return static::where('name', $permissionName)->exists();
    }

    /**
     * Get high-priority permissions.
     */
    public static function getHighPriority(int $threshold = 50): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()
                    ->where('priority', '>=', $threshold)
                    ->orderByPriority()
                    ->get();
    }

    /**
     * Get permissions that can be assigned by a specific role.
     */
    public static function getAssignableBy(Role $role): \Illuminate\Database\Eloquent\Collection
    {
        if ($role->isSuperAdmin()) {
            return static::active()->orderByPriority()->get();
        }

        // Role can only assign permissions it has and non-critical permissions
        $rolePermissions = static::getByRole($role)->pluck('name')->toArray();
        
        return static::active()
                    ->where(function ($query) use ($rolePermissions) {
                        $query->whereIn('name', $rolePermissions)
                              ->where('priority', '<', 90); // Non-critical threshold
                    })
                    ->orderByPriority()
                    ->get();
    }

    /**
     * Get permission color class based on category.
     */
    public function getColorClass(): string
    {
        $colorMap = [
            'user' => 'blue',
            'admin' => 'purple',
            'role' => 'indigo',
            'lead' => 'green',
            'group' => 'orange',
            'system' => 'red',
            'permission' => 'purple',
            'notification' => 'yellow',
            'finance' => 'emerald',
            'report' => 'gray',
        ];

        return $colorMap[$this->category] ?? 'gray';
    }

    /**
     * Get permission icon based on category and action.
     */
    public function getIcon(): string
    {
        $iconMap = [
            'user' => [
                'view' => 'users',
                'create' => 'user-plus',
                'update' => 'user-check',
                'delete' => 'user-x',
                'default' => 'users'
            ],
            'admin' => [
                'view' => 'shield',
                'create' => 'shield-plus',
                'update' => 'shield-check',
                'delete' => 'shield-x',
                'default' => 'shield'
            ],
            'role' => [
                'view' => 'key',
                'create' => 'key-square',
                'update' => 'edit-2',
                'delete' => 'trash-2',
                'assign' => 'user-plus-2',
                'default' => 'key'
            ],
            'lead' => [
                'view' => 'user-search',
                'create' => 'user-plus',
                'update' => 'user-check',
                'delete' => 'user-minus',
                'default' => 'user-search'
            ],
            'group' => [
                'view' => 'users-2',
                'create' => 'plus-circle',
                'update' => 'edit',
                'delete' => 'minus-circle',
                'manage_members' => 'settings',
                'default' => 'users-2'
            ],
            'system' => [
                'settings' => 'settings',
                'backup' => 'download',
                'maintenance' => 'tool',
                'default' => 'server'
            ],
            'permission' => [
                'view' => 'eye',
                'assign' => 'link',
                'bulk_assign' => 'layers',
                'default' => 'lock'
            ],
            'notification' => [
                'view' => 'bell',
                'send' => 'send',
                'default' => 'bell'
            ],
            'finance' => [
                'view' => 'dollar-sign',
                'create' => 'plus',
                'update' => 'edit-3',
                'approve' => 'check-circle',
                'default' => 'credit-card'
            ],
            'report' => [
                'view' => 'bar-chart',
                'export' => 'download',
                'default' => 'file-text'
            ],
        ];

        $categoryIcons = $iconMap[$this->category] ?? $iconMap['system'];
        return $categoryIcons[$this->action] ?? $categoryIcons['default'];
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }
}