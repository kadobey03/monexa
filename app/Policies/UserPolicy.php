<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any users/leads.
     */
    public function viewAny(Admin $admin): bool
    {
        // Super admin can view all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have view permission
        return $admin->hasPermission('user_view') || $admin->hasPermission('lead_view');
    }

    /**
     * Determine whether the admin can view the user/lead.
     */
    public function view(Admin $admin, User $user): bool
    {
        // Super admin can view all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have view permission
        if (!$admin->hasPermission('user_view') && !$admin->hasPermission('lead_view')) {
            return false;
        }

        // Check if admin can manage this user
        return $admin->canManageUser($user);
    }

    /**
     * Determine whether the admin can create users/leads.
     */
    public function create(Admin $admin): bool
    {
        // Super admin can create
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have create permission
        if (!$admin->hasPermission('user_create') && !$admin->hasPermission('lead_create')) {
            return false;
        }

        // Check creation limits
        return $this->checkCreationLimits($admin);
    }

    /**
     * Determine whether the admin can update the user/lead.
     */
    public function update(Admin $admin, User $user): bool
    {
        // Super admin can update all
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have update permission
        if (!$admin->hasPermission('user_update') && !$admin->hasPermission('lead_update')) {
            return false;
        }

        // Check if admin can manage this user
        return $admin->canManageUser($user);
    }

    /**
     * Determine whether the admin can delete the user/lead.
     */
    public function delete(Admin $admin, User $user): bool
    {
        // Super admin can delete
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have delete permission
        if (!$admin->hasPermission('user_delete') && !$admin->hasPermission('lead_delete')) {
            return false;
        }

        // Check if admin can manage this user
        if (!$admin->canManageUser($user)) {
            return false;
        }

        // Additional safety checks
        return $this->validateDeletePermissions($admin, $user);
    }

    /**
     * Determine whether the admin can restore the user/lead.
     */
    public function restore(Admin $admin, User $user): bool
    {
        // Super admin can restore
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have restore permission
        if (!$admin->hasPermission('user_restore')) {
            return false;
        }

        // Check if admin can manage this user
        return $admin->canManageUser($user);
    }

    /**
     * Determine whether the admin can permanently delete the user/lead.
     */
    public function forceDelete(Admin $admin, User $user): bool
    {
        // Only super admin and head of office can force delete
        if ($admin->isSuperAdmin()) {
            return true;
        }

        if ($admin->role && $admin->role->name === 'head_of_office') {
            return $admin->hasPermission('user_force_delete');
        }

        return false;
    }

    /**
     * Determine whether the admin can assign leads.
     */
    public function assignLead(Admin $admin, User $user = null): bool
    {
        // Super admin can assign
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have assignment permission
        if (!$admin->hasPermission('lead_assign')) {
            return false;
        }

        // Check assignment capacity if specific user provided
        if ($user && $user->assign_to) {
            $assignedAdmin = Admin::find($user->assign_to);
            
            if ($assignedAdmin && !$assignedAdmin->isAvailableForAssignment()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the admin can bulk assign leads.
     */
    public function bulkAssignLeads(Admin $admin): bool
    {
        // Super admin can bulk assign
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk assignment permission
        if (!$admin->hasPermission('lead_bulk_assign')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can reassign leads.
     */
    public function reassignLead(Admin $admin, User $user): bool
    {
        // Super admin can reassign
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have reassignment permission
        if (!$admin->hasPermission('lead_reassign')) {
            return false;
        }

        // Check if admin can manage current assigned admin
        if ($user->assign_to) {
            $currentAssignedAdmin = Admin::find($user->assign_to);
            
            if ($currentAssignedAdmin && !$admin->canManageAdmin($currentAssignedAdmin)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the admin can update lead status.
     */
    public function updateLeadStatus(Admin $admin, User $user): bool
    {
        // Super admin can update status
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have status update permission
        if (!$admin->hasPermission('lead_update_status')) {
            return false;
        }

        // Check if admin can manage this user
        if (!$admin->canManageUser($user)) {
            return false;
        }

        // Additional checks for specific status changes
        return $this->validateStatusUpdatePermissions($admin, $user);
    }

    /**
     * Determine whether the admin can convert lead to customer.
     */
    public function convertToCustomer(Admin $admin, User $user): bool
    {
        // Super admin can convert
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have conversion permission
        if (!$admin->hasPermission('lead_convert')) {
            return false;
        }

        // Lead must be assigned to admin or admin's subordinate
        if (!$admin->canManageUser($user)) {
            return false;
        }

        // Lead must not already be a customer
        return !$user->cstatus || $user->cstatus !== 'Customer';
    }

    /**
     * Determine whether the admin can export user/lead data.
     */
    public function export(Admin $admin): bool
    {
        // Super admin can export
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have export permission
        if (!$admin->hasPermission('user_export') && !$admin->hasPermission('lead_export')) {
            return false;
        }

        // Must be in management role for full export
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can import user/lead data.
     */
    public function import(Admin $admin): bool
    {
        // Only super admin and specific roles can import
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $allowedRoles = ['head_of_office', 'sales_head'];
        
        if ($admin->role && in_array($admin->role->name, $allowedRoles)) {
            return $admin->hasPermission('user_import') || $admin->hasPermission('lead_import');
        }

        return false;
    }

    /**
     * Determine whether the admin can send notifications to users/leads.
     */
    public function sendNotification(Admin $admin, User $user = null): bool
    {
        // Super admin can send notifications
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have notification permission
        if (!$admin->hasPermission('user_send_notification')) {
            return false;
        }

        // If specific user, check management permission
        if ($user && !$admin->canManageUser($user)) {
            return false;
        }

        // Check notification limits
        return $this->checkNotificationLimits($admin);
    }

    /**
     * Determine whether the admin can bulk send notifications.
     */
    public function bulkSendNotification(Admin $admin): bool
    {
        // Super admin can bulk send
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have bulk notification permission
        if (!$admin->hasPermission('user_bulk_notification')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can view lead assignment history.
     */
    public function viewAssignmentHistory(Admin $admin, User $user): bool
    {
        // Super admin can view all history
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have history view permission
        if (!$admin->hasPermission('lead_view_history')) {
            return false;
        }

        // Must be able to manage the user or have broader permissions
        return $admin->canManageUser($user) || $admin->hasPermission('lead_view_all_history');
    }

    /**
     * Determine whether the admin can manage lead categories.
     */
    public function manageLeadCategories(Admin $admin): bool
    {
        // Super admin can manage categories
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have category management permission
        if (!$admin->hasPermission('lead_manage_categories')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can access financial information.
     */
    public function viewFinancialInfo(Admin $admin, User $user): bool
    {
        // Super admin can view financial info
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have financial view permission
        if (!$admin->hasPermission('user_view_financial')) {
            return false;
        }

        // Must be able to manage the user
        if (!$admin->canManageUser($user)) {
            return false;
        }

        // Additional role-based restrictions
        $allowedRoles = ['head_of_office', 'sales_head', 'retention_head'];
        
        return $admin->role && in_array($admin->role->name, $allowedRoles);
    }

    /**
     * Check creation limits for admin.
     */
    protected function checkCreationLimits(Admin $admin): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $cacheKey = "user_creation_limit_{$admin->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin) {
            $dailyLimit = $admin->getSetting('daily_user_creation_limit', 50);
            
            $todayCount = User::where('created_by_admin_id', $admin->id)
                              ->whereDate('created_at', today())
                              ->count();

            return $todayCount < $dailyLimit;
        });
    }

    /**
     * Validate delete permissions with safety checks.
     */
    protected function validateDeletePermissions(Admin $admin, User $user): bool
    {
        // Cannot delete converted customers without special permission
        if ($user->cstatus === 'Customer') {
            return $admin->hasPermission('user_delete_customer');
        }

        // Cannot delete users with financial transactions without special permission
        if ($user->deposits()->exists() || $user->withdrawals()->exists()) {
            return $admin->hasPermission('user_delete_with_transactions');
        }

        return true;
    }

    /**
     * Validate status update permissions.
     */
    protected function validateStatusUpdatePermissions(Admin $admin, User $user): bool
    {
        $request = request();
        
        if (!$request) {
            return true;
        }

        $newStatus = $request->get('cstatus') ?? $request->get('status');
        
        if (!$newStatus) {
            return true;
        }

        // Converting to customer requires special permission
        if ($newStatus === 'Customer' && $user->cstatus !== 'Customer') {
            return $admin->hasPermission('lead_convert');
        }

        // Changing from customer status requires special permission
        if ($user->cstatus === 'Customer' && $newStatus !== 'Customer') {
            return $admin->hasPermission('customer_update_status');
        }

        return true;
    }

    /**
     * Check notification limits.
     */
    protected function checkNotificationLimits(Admin $admin): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $cacheKey = "notification_limit_{$admin->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin) {
            $hourlyLimit = $admin->getSetting('hourly_notification_limit', 20);
            
            $hourCount = $admin->auditLogs()
                             ->where('action', 'send_notification')
                             ->where('created_at', '>=', now()->subHour())
                             ->count();

            return $hourCount < $hourlyLimit;
        });
    }

    /**
     * Determine whether the admin can view user analytics.
     */
    public function viewAnalytics(Admin $admin): bool
    {
        // Super admin can view analytics
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have analytics permission
        if (!$admin->hasPermission('user_view_analytics')) {
            return false;
        }

        // Must be in management role
        return $admin->isManager();
    }

    /**
     * Determine whether the admin can manage lead sources.
     */
    public function manageLeadSources(Admin $admin): bool
    {
        // Super admin can manage sources
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Must have source management permission
        if (!$admin->hasPermission('lead_manage_sources')) {
            return false;
        }

        // Must be in specific management roles
        $allowedRoles = ['head_of_office', 'sales_head'];
        
        return $admin->role && in_array($admin->role->name, $allowedRoles);
    }
}