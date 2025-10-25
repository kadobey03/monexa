<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
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
        'hierarchy_level',
        'parent_role_id',
        'is_active',
        'settings',
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
        'settings' => 'array',
        'hierarchy_level' => 'integer',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($role) {
            // Auto-calculate hierarchy level if parent is set
            if ($role->parent_role_id && !$role->hierarchy_level) {
                $parentRole = static::find($role->parent_role_id);
                $role->hierarchy_level = $parentRole ? $parentRole->hierarchy_level + 1 : 0;
            }
        });
    }

    /**
     * Get the parent role.
     */
    public function parentRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'parent_role_id');
    }

    /**
     * Get the child roles.
     */
    public function childRoles(): HasMany
    {
        return $this->hasMany(Role::class, 'parent_role_id');
    }

    /**
     * Get all subordinate roles recursively.
     */
    public function subordinateRoles(): HasMany
    {
        return $this->hasMany(Role::class, 'parent_role_id')->with('subordinateRoles');
    }

    /**
     * Get the permissions for this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
                    ->withPivot('is_granted', 'constraints', 'granted_at', 'granted_by', 'expires_at', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get the admins with this role.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    /**
     * Scope a query to only include active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by department.
     */
    public function scopeForDepartment($query, string $department)
    {
        return $query->where('settings->department', $department);
    }

    /**
     * Scope a query to filter by hierarchy level.
     */
    public function scopeByHierarchyLevel($query, int $level)
    {
        return $query->where('hierarchy_level', $level);
    }

    /**
     * Scope a query to get roles at or below certain hierarchy level.
     */
    public function scopeAtOrBelowLevel($query, int $level)
    {
        return $query->where('hierarchy_level', '>=', $level);
    }

    /**
     * Get all subordinate roles (recursively).
     */
    public function getSubordinateRoles(): array
    {
        $subordinates = [];
        
        foreach ($this->childRoles as $childRole) {
            $subordinates[] = $childRole->id;
            $subordinates = array_merge($subordinates, $childRole->getSubordinateRoles());
        }
        
        return array_unique($subordinates);
    }

    /**
     * Check if this role can manage another role.
     */
    public function canManage(Role $role): bool
    {
        // Can manage if this role's hierarchy level is lower (closer to 0)
        return $this->hierarchy_level < $role->hierarchy_level;
    }

    /**
     * Check if this role can manage a specific admin.
     */
    public function canManageAdmin(Admin $admin): bool
    {
        if (!$admin->role) {
            return true; // Can manage admins without roles
        }
        
        return $this->canManage($admin->role);
    }

    /**
     * Get the hierarchy level of this role.
     */
    public function getHierarchyLevel(): int
    {
        return $this->hierarchy_level;
    }

    /**
     * Check if this role has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()
                   ->where('name', $permissionName)
                   ->wherePivot('is_granted', true)
                   ->where(function ($query) {
                       $query->whereNull('role_permissions.expires_at')
                             ->orWhere('role_permissions.expires_at', '>', now());
                   })
                   ->exists();
    }

    /**
     * Check if this role has any of the specified permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        return $this->permissions()
                   ->whereIn('name', $permissions)
                   ->wherePivot('is_granted', true)
                   ->where(function ($query) {
                       $query->whereNull('role_permissions.expires_at')
                             ->orWhere('role_permissions.expires_at', '>', now());
                   })
                   ->exists();
    }

    /**
     * Check if this role has all of the specified permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        $grantedPermissions = $this->permissions()
                                  ->whereIn('name', $permissions)
                                  ->wherePivot('is_granted', true)
                                  ->where(function ($query) {
                                      $query->whereNull('role_permissions.expires_at')
                                            ->orWhere('role_permissions.expires_at', '>', now());
                                  })
                                  ->pluck('name')
                                  ->toArray();

        return count(array_diff($permissions, $grantedPermissions)) === 0;
    }

    /**
     * Grant a permission to this role.
     */
    public function grantPermission(string $permissionName, Admin $grantedBy = null, array $constraints = null): bool
    {
        $permission = Permission::where('name', $permissionName)->first();
        
        if (!$permission) {
            return false;
        }

        $this->permissions()->syncWithoutDetaching([
            $permission->id => [
                'is_granted' => true,
                'constraints' => $constraints,
                'granted_at' => now(),
                'granted_by' => $grantedBy?->id,
            ]
        ]);

        return true;
    }

    /**
     * Revoke a permission from this role.
     */
    public function revokePermission(string $permissionName): bool
    {
        $permission = Permission::where('name', $permissionName)->first();
        
        if (!$permission) {
            return false;
        }

        $this->permissions()->updateExistingPivot($permission->id, [
            'is_granted' => false,
        ]);

        return true;
    }

    /**
     * Get all permissions including inherited from parent roles.
     */
    public function getAllPermissions(): array
    {
        $permissions = $this->permissions()
                           ->wherePivot('is_granted', true)
                           ->where(function ($query) {
                               $query->whereNull('role_permissions.expires_at')
                                     ->orWhere('role_permissions.expires_at', '>', now());
                           })
                           ->pluck('name')
                           ->toArray();

        // Add parent role permissions
        if ($this->parentRole) {
            $permissions = array_merge($permissions, $this->parentRole->getAllPermissions());
        }

        return array_unique($permissions);
    }

    /**
     * Check if this is a super admin role.
     */
    public function isSuperAdmin(): bool
    {
        return $this->name === 'super_admin' || $this->hierarchy_level === 0;
    }

    /**
     * Check if this is a management role.
     */
    public function isManagementRole(): bool
    {
        return in_array($this->name, [
            'super_admin',
            'head_of_office',
            'sales_head',
            'retention_head',
            'team_leader',
            'retention_team_leader'
        ]);
    }

    /**
     * Get the department this role belongs to.
     */
    public function getDepartment(): ?string
    {
        return $this->settings['department'] ?? null;
    }

    /**
     * Get a specific setting value.
     */
    public function getSetting(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    /**
     * Get display name for the role.
     */
    public function getDisplayName(): string
    {
        return $this->display_name ?: ucwords(str_replace('_', ' ', $this->name));
    }

    /**
     * Check if this role has permission to a specific permission (model instance).
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            return $this->hasPermission($permission);
        }
        
        if ($permission instanceof Permission) {
            return $this->permissions()
                       ->where('permission_id', $permission->id)
                       ->wherePivot('is_granted', true)
                       ->where(function ($query) {
                           $query->whereNull('role_permissions.expires_at')
                                 ->orWhere('role_permissions.expires_at', '>', now());
                       })
                       ->exists();
        }
        
        return false;
    }

    /**
     * Check if this role has inherited permission from parent roles.
     */
    public function hasInheritedPermission($permission): bool
    {
        if (!$this->parentRole) {
            return false;
        }
        
        return $this->parentRole->hasPermissionTo($permission);
    }

    /**
     * Check if this role has dependent permission (complex permission logic).
     */
    public function hasDependentPermission($permission): bool
    {
        // This is for permissions that depend on other permissions
        // For example, 'user_delete' might depend on having 'user_view' and 'user_update'
        
        if (!($permission instanceof Permission)) {
            return false;
        }
        
        // Check if this permission has dependencies defined in constraints
        $dependencies = $permission->getConstraint('dependencies', []);
        
        if (empty($dependencies)) {
            return false;
        }
        
        // Check if all dependencies are met
        foreach ($dependencies as $dependency) {
            if (!$this->hasPermission($dependency)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get role color class based on hierarchy level and type.
     */
    public function getColorClass(): string
    {
        $colorMap = [
            'super_admin' => 'red',
            'head_of_office' => 'purple',
            'sales_head' => 'blue',
            'retention_head' => 'indigo',
            'team_leader' => 'green',
            'retention_team_leader' => 'teal',
            'sales_agent' => 'orange',
            'retention_agent' => 'amber',
        ];

        if (isset($colorMap[$this->name])) {
            return $colorMap[$this->name];
        }
        
        // Fallback based on hierarchy level
        $levelColors = [
            0 => 'red',     // Super admin
            1 => 'purple',  // Head of office
            2 => 'blue',    // Department heads
            3 => 'green',   // Team leaders
            4 => 'orange',  // Agents
        ];
        
        return $levelColors[$this->hierarchy_level] ?? 'gray';
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }
}