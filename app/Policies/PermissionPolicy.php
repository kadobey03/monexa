<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any permissions.
     */
    public function viewAny(Admin $admin): bool
    {
        // Super admin can view all permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have permission view capability
        if (!$admin->hasPermission('permission_view')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can view the permission.
     */
    public function view(Admin $admin, Permission $permission): bool
    {
        // Super admin can view all permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have permission view capability
        if (!$admin->hasPermission('permission_view')) {
            return false;
        }

        // Can view permissions that admin has
        if ($admin->hasPermission($permission->name)) {
            return true;
        }

        // Can view permissions that are assignable by admin
        return $this->canAssignPermission($admin, $permission);
    }

    /**
     * Determine whether the admin can create permissions.
     */
    public function create(Admin $admin): bool
    {
        // Only super admin can create new permissions
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Must have permission creation capability
        return $admin->hasPermission('permission_create');
    }

    /**
     * Determine whether the admin can update the permission.
     */
    public function update(Admin $admin, Permission $permission): bool
    {
        // Super admin can update permissions
        if ($admin->isSuperAdmin()) {
            return !$this->isSystemProtectedPermission($permission);
        }

        // Cannot update critical permissions
        if ($permission->isCritical()) {
            return false;
        }

        // Must have permission update capability
        if (!$admin->hasPermission('permission_update')) {
            return false;
        }

        // Additional checks for permission updates
        return $this->validatePermissionUpdatePermissions($admin, $permission);
    }

    /**
     * Determine whether the admin can delete the permission.
     */
    public function delete(Admin $admin, Permission $permission): bool
    {
        // Only super admin can delete permissions
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot delete system protected permissions
        if ($this->isSystemProtectedPermission($permission)) {
            return false;
        }

        // Cannot delete permissions currently assigned to roles
        if ($this->isPermissionInUse($permission)) {
            return $admin->hasPermission('permission_delete_in_use');
        }

        // Must have permission delete capability
        return $admin->hasPermission('permission_delete');
    }

    /**
     * Determine whether the admin can restore the permission.
     */
    public function restore(Admin $admin, Permission $permission): bool
    {
        // Only super admin can restore permissions
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Must have permission restore capability
        return $admin->hasPermission('permission_restore');
    }

    /**
     * Determine whether the admin can permanently delete the permission.
     */
    public function forceDelete(Admin $admin, Permission $permission): bool
    {
        // Only super admin can force delete permissions
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot force delete system protected permissions
        if ($this->isSystemProtectedPermission($permission)) {
            return false;
        }

        // Must have special force delete permission
        return $admin->hasPermission('permission_force_delete');
    }

    /**
     * Determine whether the admin can assign permissions to roles.
     */
    public function assign(Admin $admin, Permission $permission = null): bool
    {
        // Super admin can assign permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have permission assignment capability
        if (!$admin->hasPermission('permission_assign')) {
            return false;
        }

        // If specific permission provided, check assignability
        if ($permission && !$this->canAssignPermission($admin, $permission)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the admin can bulk assign permissions.
     */
    public function bulkAssign(Admin $admin): bool
    {
        // Super admin can bulk assign
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk assignment permission
        if (!$admin->hasPermission('permission_bulk_assign')) {
            return false;
        }

        // Must be head of office
        return $admin->role && $admin->role->name === 'head_of_office';
    }

    /**
     * Determine whether the admin can revoke permissions from roles.
     */
    public function revoke(Admin $admin, Permission $permission = null): bool
    {
        // Super admin can revoke permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have permission revocation capability
        if (!$admin->hasPermission('permission_revoke')) {
            return false;
        }

        // If specific permission provided, check revocability
        if ($permission) {
            // Cannot revoke critical permissions without special permission
            if ($permission->isCritical()) {
                return $admin->hasPermission('permission_revoke_critical');
            }

            // Cannot revoke permissions admin doesn't have
            if (!$admin->hasPermission($permission->name)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the admin can bulk revoke permissions.
     */
    public function bulkRevoke(Admin $admin): bool
    {
        // Super admin can bulk revoke
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk revocation permission
        if (!$admin->hasPermission('permission_bulk_revoke')) {
            return false;
        }

        // Must be head of office
        return $admin->role && $admin->role->name === 'head_of_office';
    }

    /**
     * Determine whether the admin can export permission data.
     */
    public function export(Admin $admin): bool
    {
        // Super admin can export
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have export permission
        if (!$admin->hasPermission('permission_export')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can import permission data.
     */
    public function import(Admin $admin): bool
    {
        // Only super admin can import permissions
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Must have import permission
        return $admin->hasPermission('permission_import');
    }

    /**
     * Determine whether the admin can manage permission categories.
     */
    public function manageCategories(Admin $admin): bool
    {
        // Only super admin can manage categories
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Must have category management permission
        return $admin->hasPermission('permission_manage_categories');
    }

    /**
     * Determine whether the admin can view permission usage analytics.
     */
    public function viewAnalytics(Admin $admin): bool
    {
        // Super admin can view analytics
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have analytics permission
        if (!$admin->hasPermission('permission_view_analytics')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can audit permission changes.
     */
    public function audit(Admin $admin): bool
    {
        // Super admin can audit
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have audit permission
        if (!$admin->hasPermission('permission_audit')) {
            return false;
        }

        // Must be in specific roles
        $allowedRoles = ['head_of_office'];
        
        return $admin->role && in_array($admin->role->name, $allowedRoles);
    }

    /**
     * Check if admin can assign specific permission.
     */
    protected function canAssignPermission(Admin $admin, Permission $permission): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $cacheKey = "permission_assignable_{$admin->id}_{$permission->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin, $permission) {
            // Admin can only assign permissions they have
            if (!$admin->hasPermission($permission->name)) {
                return false;
            }

            // Cannot assign critical permissions without special permission
            if ($permission->isCritical()) {
                return $admin->hasPermission('permission_assign_critical');
            }

            // Check permission priority limits
            $adminRole = $admin->role;
            
            if (!$adminRole) {
                return false;
            }

            $maxAssignablePriority = $this->getMaxAssignablePriority($adminRole);
            
            return $permission->priority <= $maxAssignablePriority;
        });
    }

    /**
     * Get maximum assignable permission priority for role.
     */
    protected function getMaxAssignablePriority($role): int
    {
        $priorityLimits = [
            'super_admin' => 100,
            'head_of_office' => 80,
            'sales_head' => 60,
            'retention_head' => 60,
            'team_leader' => 40,
            'retention_team_leader' => 40,
            'sales_agent' => 20,
            'retention_agent' => 20,
        ];

        return $priorityLimits[$role->name] ?? 10;
    }

    /**
     * Check if permission is system protected.
     */
    protected function isSystemProtectedPermission(Permission $permission): bool
    {
        $protectedPermissions = [
            'system_settings',
            'system_backup',
            'system_maintenance',
            'permission_create',
            'permission_delete',
            'permission_force_delete',
            'role_create',
            'role_delete',
            'admin_delete_super',
        ];

        return in_array($permission->name, $protectedPermissions);
    }

    /**
     * Check if permission is currently in use.
     */
    protected function isPermissionInUse(Permission $permission): bool
    {
        $cacheKey = "permission_in_use_{$permission->id}";

        return Cache::remember($cacheKey, 300, function () use ($permission) {
            return $permission->roles()
                            ->wherePivot('is_granted', true)
                            ->exists();
        });
    }

    /**
     * Validate permission update permissions.
     */
    protected function validatePermissionUpdatePermissions(Admin $admin, Permission $permission): bool
    {
        $request = request();

        if (!$request) {
            return true;
        }

        // Check for sensitive field updates
        $sensitiveFields = [
            'category',
            'priority',
            'constraints',
            'is_active',
        ];

        foreach ($sensitiveFields as $field) {
            if ($request->has($field)) {
                if (!$admin->hasPermission('permission_update_sensitive')) {
                    return false;
                }
            }
        }

        // Check priority changes
        if ($request->has('priority')) {
            $newPriority = (int) $request->get('priority');
            $maxPriority = $this->getMaxAssignablePriority($admin->role);
            
            if ($newPriority > $maxPriority) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the admin can duplicate permissions.
     */
    public function duplicate(Admin $admin, Permission $permission): bool
    {
        // Super admin can duplicate permissions
        if ($admin->isSuperAdmin()) {
            return !$this->isSystemProtectedPermission($permission);
        }

        // Must have creation permission
        if (!$admin->hasPermission('permission_create')) {
            return false;
        }

        // Must be able to view the source permission
        return $this->view($admin, $permission);
    }

    /**
     * Determine whether the admin can manage permission constraints.
     */
    public function manageConstraints(Admin $admin, Permission $permission): bool
    {
        // Super admin can manage constraints
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Cannot manage constraints for critical permissions
        if ($permission->isCritical()) {
            return false;
        }

        // Must have constraint management permission
        if (!$admin->hasPermission('permission_manage_constraints')) {
            return false;
        }

        // Must be able to assign the permission
        return $this->canAssignPermission($admin, $permission);
    }

    /**
     * Determine whether the admin can test permission compatibility.
     */
    public function testCompatibility(Admin $admin): bool
    {
        // Super admin can test compatibility
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have testing permission
        if (!$admin->hasPermission('permission_test_compatibility')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can manage permission templates.
     */
    public function manageTemplates(Admin $admin): bool
    {
        // Super admin can manage templates
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have template management permission
        if (!$admin->hasPermission('permission_manage_templates')) {
            return false;
        }

        // Must be head of office
        return $admin->role && $admin->role->name === 'head_of_office';
    }
}