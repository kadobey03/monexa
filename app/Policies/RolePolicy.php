<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any roles.
     */
    public function viewAny(Admin $admin): bool
    {
        // Super admin can view all roles
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have role view permission
        if (!$admin->hasPermission('role_view')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can view the role.
     */
    public function view(Admin $admin, Role $role): bool
    {
        // Super admin can view all roles
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have role view permission
        if (!$admin->hasPermission('role_view')) {
            return false;
        }

        // Can view own role
        if ($admin->role_id === $role->id) {
            return true;
        }

        // Check if can manage this role by hierarchy
        return $this->canManageRoleByHierarchy($admin, $role);
    }

    /**
     * Determine whether the admin can create roles.
     */
    public function create(Admin $admin): bool
    {
        // Super admin can create roles
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have role creation permission
        if (!$admin->hasPermission('role_create')) {
            return false;
        }

        // Must be in specific management roles
        $allowedRoles = ['head_of_office'];
        
        if (!$admin->role || !in_array($admin->role->name, $allowedRoles)) {
            return false;
        }

        // Check creation limits
        return $this->checkRoleCreationLimits($admin);
    }

    /**
     * Determine whether the admin can update the role.
     */
    public function update(Admin $admin, Role $role): bool
    {
        // Super admin can update all roles
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Cannot update super admin role
        if ($role->isSuperAdmin()) {
            return false;
        }

        // Must have role update permission
        if (!$admin->hasPermission('role_update')) {
            return false;
        }

        // Check if can manage this role by hierarchy
        if (!$this->canManageRoleByHierarchy($admin, $role)) {
            return false;
        }

        // Additional checks for sensitive updates
        return $this->validateRoleUpdatePermissions($admin, $role);
    }

    /**
     * Determine whether the admin can delete the role.
     */
    public function delete(Admin $admin, Role $role): bool
    {
        // Super admin can delete (with restrictions)
        if ($admin->isSuperAdmin()) {
            return !$role->isSuperAdmin() && !$this->isProtectedRole($role);
        }

        // Cannot delete super admin role or protected roles
        if ($role->isSuperAdmin() || $this->isProtectedRole($role)) {
            return false;
        }

        // Must have role delete permission
        if (!$admin->hasPermission('role_delete')) {
            return false;
        }

        // Check if can manage this role by hierarchy
        if (!$this->canManageRoleByHierarchy($admin, $role)) {
            return false;
        }

        // Additional safety checks
        return $this->validateRoleDeletePermissions($admin, $role);
    }

    /**
     * Determine whether the admin can restore the role.
     */
    public function restore(Admin $admin, Role $role): bool
    {
        // Super admin can restore
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have role restore permission
        if (!$admin->hasPermission('role_restore')) {
            return false;
        }

        // Check if can manage this role by hierarchy
        return $this->canManageRoleByHierarchy($admin, $role);
    }

    /**
     * Determine whether the admin can permanently delete the role.
     */
    public function forceDelete(Admin $admin, Role $role): bool
    {
        // Only super admin can force delete
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot force delete super admin role or protected roles
        if ($role->isSuperAdmin() || $this->isProtectedRole($role)) {
            return false;
        }

        // Must have special force delete permission
        return $admin->hasPermission('role_force_delete');
    }

    /**
     * Determine whether the admin can assign permissions to roles.
     */
    public function assignPermissions(Admin $admin, Role $role): bool
    {
        // Super admin can assign permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Cannot assign permissions to super admin role
        if ($role->isSuperAdmin()) {
            return false;
        }

        // Must have permission assignment permission
        if (!$admin->hasPermission('role_assign_permissions')) {
            return false;
        }

        // Check if can manage this role by hierarchy
        if (!$this->canManageRoleByHierarchy($admin, $role)) {
            return false;
        }

        // Additional checks for permission assignment
        return $this->validatePermissionAssignmentPermissions($admin, $role);
    }

    /**
     * Determine whether the admin can modify role hierarchy.
     */
    public function modifyHierarchy(Admin $admin, Role $role): bool
    {
        // Only super admin can modify hierarchy
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot modify super admin role hierarchy
        if ($role->isSuperAdmin()) {
            return false;
        }

        // Must have hierarchy modification permission
        return $admin->hasPermission('role_modify_hierarchy');
    }

    /**
     * Determine whether the admin can bulk update roles.
     */
    public function bulkUpdate(Admin $admin): bool
    {
        // Super admin can bulk update
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk update permission
        if (!$admin->hasPermission('role_bulk_update')) {
            return false;
        }

        // Must be head of office
        return $admin->role && $admin->role->name === 'head_of_office';
    }

    /**
     * Determine whether the admin can duplicate roles.
     */
    public function duplicate(Admin $admin, Role $role): bool
    {
        // Super admin can duplicate roles
        if ($admin->isSuperAdmin()) {
            return !$role->isSuperAdmin(); // Cannot duplicate super admin role
        }

        // Must have role creation permission
        if (!$admin->hasPermission('role_create')) {
            return false;
        }

        // Check if can view the source role
        if (!$this->view($admin, $role)) {
            return false;
        }

        // Check creation limits
        return $this->checkRoleCreationLimits($admin);
    }

    /**
     * Determine whether the admin can export role data.
     */
    public function export(Admin $admin): bool
    {
        // Super admin can export
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have export permission
        if (!$admin->hasPermission('role_export')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Check if admin can manage role by hierarchy.
     */
    protected function canManageRoleByHierarchy(Admin $admin, Role $role): bool
    {
        if (!$admin->role) {
            return false;
        }

        $cacheKey = "role_hierarchy_management_{$admin->role->id}_{$role->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin, $role) {
            // Admin's role must have lower hierarchy level (more senior) to manage
            return $admin->role->hierarchy_level < $role->hierarchy_level;
        });
    }

    /**
     * Check role creation limits.
     */
    protected function checkRoleCreationLimits(Admin $admin): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $cacheKey = "role_creation_limit_{$admin->id}";

        return Cache::remember($cacheKey, 3600, function () use ($admin) {
            // Get roles created by admin's group/department
            $groupId = $admin->admin_group_id;
            $department = $admin->department;

            if (!$groupId && !$department) {
                return false;
            }

            $currentCount = Role::where(function ($query) use ($groupId, $department) {
                if ($groupId) {
                    $query->where('settings->admin_group_id', $groupId);
                }
                if ($department) {
                    $query->orWhere('settings->department', $department);
                }
            })->count();

            $maxRoles = $admin->getSetting('max_roles_per_group', 20);

            return $currentCount < $maxRoles;
        });
    }

    /**
     * Validate role update permissions.
     */
    protected function validateRoleUpdatePermissions(Admin $admin, Role $role): bool
    {
        $request = request();

        if (!$request) {
            return true;
        }

        // Check for sensitive field updates
        $sensitiveFields = [
            'hierarchy_level',
            'parent_role_id',
            'is_active',
        ];

        foreach ($sensitiveFields as $field) {
            if ($request->has($field)) {
                if (!$admin->hasPermission('role_update_sensitive')) {
                    return false;
                }
            }
        }

        // Check hierarchy level changes
        if ($request->has('hierarchy_level')) {
            $newLevel = (int) $request->get('hierarchy_level');
            
            // Cannot set hierarchy level equal or higher than admin's role
            if ($admin->role && $newLevel <= $admin->role->hierarchy_level) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate role delete permissions.
     */
    protected function validateRoleDeletePermissions(Admin $admin, Role $role): bool
    {
        // Cannot delete role if it has active admins assigned
        if ($role->admins()->where('status', 'Active')->exists()) {
            return $admin->hasPermission('role_delete_with_admins');
        }

        // Cannot delete role if it has child roles
        if ($role->childRoles()->exists()) {
            return $admin->hasPermission('role_delete_with_children');
        }

        return true;
    }

    /**
     * Validate permission assignment permissions.
     */
    protected function validatePermissionAssignmentPermissions(Admin $admin, Role $role): bool
    {
        $request = request();

        if (!$request || !$request->has('permissions')) {
            return true;
        }

        $requestedPermissions = $request->get('permissions', []);

        // Admin can only assign permissions they have
        $adminPermissions = $admin->role?->getAllPermissions() ?? [];

        foreach ($requestedPermissions as $permissionName) {
            if (!in_array($permissionName, $adminPermissions)) {
                return false;
            }

            // Cannot assign critical permissions without special permission
            $permission = \App\Models\Permission::where('name', $permissionName)->first();
            
            if ($permission && $permission->isCritical()) {
                if (!$admin->hasPermission('role_assign_critical_permissions')) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check if role is protected from deletion.
     */
    protected function isProtectedRole(Role $role): bool
    {
        $protectedRoles = [
            'super_admin',
            'head_of_office',
            'default_admin',
            'default_user',
        ];

        return in_array($role->name, $protectedRoles);
    }

    /**
     * Determine whether the admin can manage role settings.
     */
    public function manageSettings(Admin $admin, Role $role): bool
    {
        // Super admin can manage all role settings
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Cannot manage super admin role settings
        if ($role->isSuperAdmin()) {
            return false;
        }

        // Must have settings management permission
        if (!$admin->hasPermission('role_manage_settings')) {
            return false;
        }

        // Check if can manage this role by hierarchy
        return $this->canManageRoleByHierarchy($admin, $role);
    }

    /**
     * Determine whether the admin can view role permissions.
     */
    public function viewPermissions(Admin $admin, Role $role): bool
    {
        // Super admin can view all permissions
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have permission view capability
        if (!$admin->hasPermission('role_view_permissions')) {
            return false;
        }

        // Can view own role permissions
        if ($admin->role_id === $role->id) {
            return true;
        }

        // Check if can manage this role by hierarchy
        return $this->canManageRoleByHierarchy($admin, $role);
    }

    /**
     * Determine whether the admin can clone role structure.
     */
    public function cloneStructure(Admin $admin): bool
    {
        // Only super admin can clone role structures
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Must have special cloning permission
        return $admin->hasPermission('role_clone_structure');
    }
}