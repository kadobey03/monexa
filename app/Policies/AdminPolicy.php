<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any admins.
     */
    public function viewAny(Admin $admin): bool
    {
        // Super admin can view all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have view permission
        if (!$admin->hasPermission('admin_view')) {
            return false;
        }

        // Management roles can view their scope
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can view the admin.
     */
    public function view(Admin $admin, Admin $targetAdmin): bool
    {
        // Can view self
        if ($admin->id === $targetAdmin->id) {
            return true;
        }

        // Super admin can view all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have view permission
        if (!$admin->hasPermission('admin_view')) {
            return false;
        }

        // Check hierarchy and scope
        return $this->canAccessAdminByHierarchy($admin, $targetAdmin);
    }

    /**
     * Determine whether the admin can create admins.
     */
    public function create(Admin $admin): bool
    {
        // Super admin can create
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have create permission
        if (!$admin->hasPermission('admin_create')) {
            return false;
        }

        // Must be in management role
        if (!$admin->isManager()) {
            return false;
        }

        // Check group creation limits
        return $this->checkGroupCreationLimits($admin);
    }

    /**
     * Determine whether the admin can update the admin.
     */
    public function update(Admin $admin, Admin $targetAdmin): bool
    {
        // Can update self (limited fields)
        if ($admin->id === $targetAdmin->id) {
            return $admin->hasPermission('admin_update_self');
        }

        // Super admin can update all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have update permission
        if (!$admin->hasPermission('admin_update')) {
            return false;
        }

        // Check if can manage target admin
        if (!$admin->canManageAdmin($targetAdmin)) {
            return false;
        }

        // Additional checks for critical updates
        return $this->validateUpdatePermissions($admin, $targetAdmin);
    }

    /**
     * Determine whether the admin can delete the admin.
     */
    public function delete(Admin $admin, Admin $targetAdmin): bool
    {
        // Cannot delete self
        if ($admin->id === $targetAdmin->id) {
            return false;
        }

        // Super admin can delete (with restrictions)
        if ($admin->isSuperAdmin()) {
            return !$targetAdmin->isSuperAdmin() || $this->canDeleteSuperAdmin($admin, $targetAdmin);
        }

        // Must have delete permission
        if (!$admin->hasPermission('admin_delete')) {
            return false;
        }

        // Check if can manage target admin
        if (!$admin->canManageAdmin($targetAdmin)) {
            return false;
        }

        // Additional safety checks
        return $this->validateDeletePermissions($admin, $targetAdmin);
    }

    /**
     * Determine whether the admin can restore the admin.
     */
    public function restore(Admin $admin, Admin $targetAdmin): bool
    {
        // Super admin can restore
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have restore permission
        if (!$admin->hasPermission('admin_restore')) {
            return false;
        }

        // Check if can manage target admin
        if (!$admin->canManageAdmin($targetAdmin)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the admin can permanently delete the admin.
     */
    public function forceDelete(Admin $admin, Admin $targetAdmin): bool
    {
        // Only super admin can force delete
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot force delete another super admin without special permission
        if ($targetAdmin->isSuperAdmin()) {
            return $admin->hasPermission('admin_force_delete_super');
        }

        return true;
    }

    /**
     * Determine whether the admin can assign roles to the admin.
     */
    public function assignRole(Admin $admin, Admin $targetAdmin): bool
    {
        // Cannot assign role to self
        if ($admin->id === $targetAdmin->id) {
            return false;
        }

        // Super admin can assign roles
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have role assignment permission
        if (!$admin->hasPermission('admin_assign_role')) {
            return false;
        }

        // Check if can manage target admin
        if (!$admin->canManageAdmin($targetAdmin)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the admin can bulk update admins.
     */
    public function bulkUpdate(Admin $admin): bool
    {
        // Super admin can bulk update
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk update permission
        if (!$admin->hasPermission('admin_bulk_update')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can export admin data.
     */
    public function export(Admin $admin): bool
    {
        // Super admin can export
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have export permission
        if (!$admin->hasPermission('admin_export')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can import admin data.
     */
    public function import(Admin $admin): bool
    {
        // Only super admin and head of office can import
        if ($admin->isSuperAdmin()) {
            return true;
        }

        if ($admin->role && $admin->role->name === 'head_of_office') {
            return $admin->hasPermission('admin_import');
        }

        return false;
    }

    /**
     * Check if admin can access target admin by hierarchy.
     */
    protected function canAccessAdminByHierarchy(Admin $admin, Admin $targetAdmin): bool
    {
        $cacheKey = "admin_hierarchy_access_{$admin->id}_{$targetAdmin->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdmin) {
            // Check if target is subordinate
            if ($admin->isSubordinate($targetAdmin)) {
                return true;
            }

            // Check same group access
            if ($admin->admin_group_id && $admin->admin_group_id === $targetAdmin->admin_group_id) {
                return $admin->hasPermission('admin_view_group');
            }

            // Check same department access
            if ($admin->department && $admin->department === $targetAdmin->department) {
                return $admin->hasPermission('admin_view_department');
            }

            return false;
        });
    }

    /**
     * Check group creation limits.
     */
    protected function checkGroupCreationLimits(Admin $admin): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Get admin's group limits
        $groupId = $admin->admin_group_id;
        
        if (!$groupId) {
            return false;
        }

        $cacheKey = "group_creation_limit_{$groupId}";

        return Cache::remember($cacheKey, 3600, function () use ($groupId, $admin) {
            $currentCount = Admin::where('admin_group_id', $groupId)->count();
            $maxAdmins = $admin->adminGroup?->getSetting('max_admins', 50);

            return $currentCount < $maxAdmins;
        });
    }

    /**
     * Validate update permissions for specific fields.
     */
    protected function validateUpdatePermissions(Admin $admin, Admin $targetAdmin): bool
    {
        // Check if target has higher hierarchy level (more senior)
        if ($targetAdmin->role && $admin->role) {
            if ($targetAdmin->role->hierarchy_level < $admin->role->hierarchy_level) {
                return false; // Cannot update more senior admin
            }
        }

        // Additional checks for sensitive fields
        $request = request();
        
        if ($request && $this->hasSensitiveUpdates($request)) {
            return $admin->hasPermission('admin_update_sensitive');
        }

        return true;
    }

    /**
     * Validate delete permissions.
     */
    protected function validateDeletePermissions(Admin $admin, Admin $targetAdmin): bool
    {
        // Cannot delete admin with subordinates unless has special permission
        if ($targetAdmin->subordinates()->exists()) {
            if (!$admin->hasPermission('admin_delete_with_subordinates')) {
                return false;
            }
        }

        // Cannot delete admin with active leads unless has special permission
        if ($targetAdmin->activeLeads()->exists()) {
            if (!$admin->hasPermission('admin_delete_with_leads')) {
                return false;
            }
        }

        // Check if target has higher hierarchy level
        if ($targetAdmin->role && $admin->role) {
            return $targetAdmin->role->hierarchy_level > $admin->role->hierarchy_level;
        }

        return true;
    }

    /**
     * Check if super admin can be deleted.
     */
    protected function canDeleteSuperAdmin(Admin $admin, Admin $targetSuperAdmin): bool
    {
        // Must have special permission to delete super admin
        if (!$admin->hasPermission('admin_delete_super')) {
            return false;
        }

        // Cannot be the last super admin
        $superAdminCount = Admin::whereHas('role', function ($query) {
            $query->where('name', 'super_admin');
        })->where('status', 'Active')->count();

        return $superAdminCount > 1;
    }

    /**
     * Check if request contains sensitive field updates.
     */
    protected function hasSensitiveUpdates($request): bool
    {
        $sensitiveFields = [
            'role_id',
            'admin_group_id',
            'supervisor_id',
            'status',
            'hierarchy_level',
            'subordinate_ids',
            'max_leads_per_day',
        ];

        foreach ($sensitiveFields as $field) {
            if ($request->has($field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if admin can manage group boundaries.
     */
    public function manageGroupBoundary(Admin $admin, Admin $targetAdmin): bool
    {
        // Super admin can manage all boundaries
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have group management permission
        if (!$admin->hasPermission('admin_manage_group_boundary')) {
            return false;
        }

        // Must be in same group or admin's group must be parent group
        if ($admin->admin_group_id === $targetAdmin->admin_group_id) {
            return true;
        }

        // Check parent-child group relationship
        if ($admin->adminGroup && $targetAdmin->adminGroup) {
            return $admin->adminGroup->isParentOf($targetAdmin->adminGroup);
        }

        return false;
    }

    /**
     * Determine if admin can switch roles.
     */
    public function switchRole(Admin $admin, Admin $targetAdmin): bool
    {
        // Only super admin can switch roles
        if (!$admin->isSuperAdmin()) {
            return false;
        }

        // Cannot switch to self
        if ($admin->id === $targetAdmin->id) {
            return false;
        }

        // Must have role switching permission
        return $admin->hasPermission('admin_switch_role');
    }
}