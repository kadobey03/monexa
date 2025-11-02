<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permissions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Admin guard kontrolü
        if (!Auth::guard('admin')->check()) {
            return $this->unauthorized($request, 'Admin authentication required');
        }

        $admin = Auth::guard('admin')->user();

        // Admin aktif mi kontrol et
        if (!$this->isAdminActive($admin)) {
            Auth::guard('admin')->logout();
            return $this->unauthorized($request, 'Admin account is inactive');
        }

        // Permission kontrolü
        if (!$this->hasRequiredPermissions($admin, $permissions, $request)) {
            return $this->forbidden($request, 'Insufficient permissions');
        }

        // Admin activity güncelle
        $admin->updateLastActivity();

        return $next($request);
    }

    /**
     * Check if admin is active.
     */
    protected function isAdminActive($admin): bool
    {
        return $admin->status === 'Active' && !$admin->deleted_at;
    }

    /**
     * Check if admin has required permissions.
     */
    protected function hasRequiredPermissions($admin, array $permissions, Request $request): bool
    {
        if (empty($permissions)) {
            return true;
        }

        // Super admin her şeyi yapabilir
        if ($admin->isSuperAdmin()) {
            return true;
        }

        foreach ($permissions as $permissionExpression) {
            if ($this->evaluatePermissionExpression($admin, $permissionExpression, $request)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Evaluate permission expression with scopes and conditions.
     */
    protected function evaluatePermissionExpression($admin, string $permissionExpression, Request $request): bool
    {
        // Permission format: resource.action:scope@condition
        // Examples: user.view, user.update:own, user.delete:subordinates@group_boundary
        
        $parts = explode('@', $permissionExpression);
        $permissionWithScope = $parts[0];
        $condition = $parts[1] ?? null;

        $scopeParts = explode(':', $permissionWithScope);
        $permissionName = $scopeParts[0];
        $scope = $scopeParts[1] ?? 'all';

        // Base permission kontrolü
        if (!$this->hasBasePermission($admin, $permissionName)) {
            return false;
        }

        // Scope kontrolü
        if (!$this->validatePermissionScope($admin, $permissionName, $scope, $request)) {
            return false;
        }

        // Condition kontrolü
        if ($condition && !$this->validatePermissionCondition($admin, $condition, $request)) {
            return false;
        }

        return true;
    }

    /**
     * Check if admin has base permission.
     */
    protected function hasBasePermission($admin, string $permissionName): bool
    {
        $cacheKey = "admin_permission_{$admin->id}_{$permissionName}";

        return Cache::remember($cacheKey, 300, function () use ($admin, $permissionName) {
            return $admin->hasPermission($permissionName);
        });
    }

    /**
     * Validate permission scope.
     */
    protected function validatePermissionScope($admin, string $permissionName, string $scope, Request $request): bool
    {
        switch ($scope) {
            case 'own':
                return $this->validateOwnScope($admin, $request);
                
            case 'subordinates':
                return $this->validateSubordinatesScope($admin, $request);
                
            case 'group':
                return $this->validateGroupScope($admin, $request);
                
            case 'department':
                return $this->validateDepartmentScope($admin, $request);
                
            case 'all':
                return $this->validateAllScope($admin, $permissionName);
                
            default:
                return false;
        }
    }

    /**
     * Validate own scope - admin can only access own resources.
     */
    protected function validateOwnScope($admin, Request $request): bool
    {
        $resourceId = $this->getResourceIdFromRequest($request);
        
        if (!$resourceId) {
            return true; // No specific resource, allow
        }

        // For admin resources
        if ($request->is('admin/admins/*')) {
            return $resourceId == $admin->id;
        }

        // For user/lead resources
        if ($request->is('admin/users/*') || $request->is('admin/leads/*')) {
            $user = \App\Models\User::find($resourceId);
            return $user && $user->assign_to == $admin->id;
        }

        return true;
    }

    /**
     * Validate subordinates scope - admin can access subordinates' resources.
     */
    protected function validateSubordinatesScope($admin, Request $request): bool
    {
        $resourceId = $this->getResourceIdFromRequest($request);
        
        if (!$resourceId) {
            return true;
        }

        // For admin resources
        if ($request->is('admin/admins/*')) {
            $targetAdmin = \App\Models\Admin::find($resourceId);
            return $targetAdmin && $admin->isSubordinate($targetAdmin);
        }

        // For user/lead resources
        if ($request->is('admin/users/*') || $request->is('admin/leads/*')) {
            $user = \App\Models\User::find($resourceId);
            if (!$user || !$user->assign_to) {
                return false;
            }

            // Can access if user is assigned to admin or admin's subordinates
            $subordinateIds = $admin->getAllSubordinates();
            return $user->assign_to == $admin->id || in_array($user->assign_to, $subordinateIds);
        }

        return true;
    }

    /**
     * Validate group scope - admin can access same group resources.
     */
    protected function validateGroupScope($admin, Request $request): bool
    {
        if (!$admin->admin_group_id) {
            return false;
        }

        $resourceId = $this->getResourceIdFromRequest($request);
        
        if (!$resourceId) {
            return true;
        }

        // For admin resources
        if ($request->is('admin/admins/*')) {
            $targetAdmin = \App\Models\Admin::find($resourceId);
            return $targetAdmin && $targetAdmin->admin_group_id == $admin->admin_group_id;
        }

        return true;
    }

    /**
     * Validate department scope - admin can access same department resources.
     */
    protected function validateDepartmentScope($admin, Request $request): bool
    {
        if (!$admin->department) {
            return false;
        }

        $resourceId = $this->getResourceIdFromRequest($request);
        
        if (!$resourceId) {
            return true;
        }

        // For admin resources
        if ($request->is('admin/admins/*')) {
            $targetAdmin = \App\Models\Admin::find($resourceId);
            return $targetAdmin && $targetAdmin->department == $admin->department;
        }

        return true;
    }

    /**
     * Validate all scope - admin can access all resources (requires high-level permission).
     */
    protected function validateAllScope($admin, string $permissionName): bool
    {
        // Only certain roles can have 'all' scope permissions
        $allowedRoles = ['super_admin', 'head_of_office'];
        
        if (!$admin->role || !in_array($admin->role->name, $allowedRoles)) {
            return false;
        }

        return true;
    }

    /**
     * Validate permission conditions.
     */
    protected function validatePermissionCondition($admin, string $condition, Request $request): bool
    {
        switch ($condition) {
            case 'group_boundary':
                return $this->validateGroupBoundary($admin, $request);
                
            case 'hierarchy_limit':
                return $this->validateHierarchyLimit($admin, $request);
                
            case 'time_restriction':
                return $this->validateTimeRestriction($admin, $request);
                
            case 'ip_restriction':
                return $this->validateIpRestriction($admin, $request);
                
            default:
                return true;
        }
    }

    /**
     * Validate group boundary condition.
     */
    protected function validateGroupBoundary($admin, Request $request): bool
    {
        if (!$admin->admin_group_id) {
            return false;
        }

        $adminGroup = $admin->adminGroup;
        
        if (!$adminGroup || !$adminGroup->isInWorkingHours()) {
            return false;
        }

        return true;
    }

    /**
     * Validate hierarchy limit condition.
     */
    protected function validateHierarchyLimit($admin, Request $request): bool
    {
        $resourceId = $this->getResourceIdFromRequest($request);
        
        if ($request->is('admin/admins/*') && $resourceId) {
            $targetAdmin = \App\Models\Admin::find($resourceId);
            
            if (!$targetAdmin || !$targetAdmin->role) {
                return true;
            }

            return $admin->canManageAdmin($targetAdmin);
        }

        return true;
    }

    /**
     * Validate time restriction condition.
     */
    protected function validateTimeRestriction($admin, Request $request): bool
    {
        // Check working hours
        $workSchedule = $admin->work_schedule;
        
        if (!$workSchedule) {
            return true; // No restriction
        }

        $currentHour = now($admin->time_zone ?? 'UTC')->hour;
        $currentDay = now($admin->time_zone ?? 'UTC')->dayOfWeek;

        $daySchedule = $workSchedule[strtolower(now()->format('l'))] ?? null;
        
        if (!$daySchedule) {
            return false; // No work on this day
        }

        return $currentHour >= $daySchedule['start'] && $currentHour <= $daySchedule['end'];
    }

    /**
     * Validate IP restriction condition.
     */
    protected function validateIpRestriction($admin, Request $request): bool
    {
        $allowedIps = $admin->getSetting('allowed_ips', []);
        
        if (empty($allowedIps)) {
            return true; // No IP restriction
        }

        $clientIp = $request->ip();
        
        foreach ($allowedIps as $allowedIp) {
            if ($this->ipMatch($clientIp, $allowedIp)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if client IP matches allowed IP pattern.
     */
    protected function ipMatch(string $clientIp, string $allowedIp): bool
    {
        if ($clientIp === $allowedIp) {
            return true;
        }

        // CIDR notation support
        if (strpos($allowedIp, '/') !== false) {
            list($subnet, $mask) = explode('/', $allowedIp);
            return (ip2long($clientIp) & ~((1 << (32 - $mask)) - 1)) === ip2long($subnet);
        }

        return false;
    }

    /**
     * Extract resource ID from request.
     */
    protected function getResourceIdFromRequest(Request $request): ?int
    {
        // Try to get ID from route parameters
        $routeParameters = $request->route()?->parameters() ?? [];
        
        // Common parameter names for resource IDs
        $idParams = ['id', 'admin', 'user', 'lead', 'role', 'permission'];
        
        foreach ($idParams as $param) {
            if (isset($routeParameters[$param]) && is_numeric($routeParameters[$param])) {
                return (int) $routeParameters[$param];
            }
        }

        return null;
    }

    /**
     * Handle unauthorized access.
     */
    protected function unauthorized(Request $request, string $message): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => $message,
                'error' => 'Unauthorized',
                'code' => 401
            ], 401);
        }

        return redirect()->guest(route('admin.login'))
            ->with('error', $message);
    }

    /**
     * Handle forbidden access.
     */
    protected function forbidden(Request $request, string $message): Response
    {
        // Log security event
        $this->logSecurityEvent($request, $message);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => $message,
                'error' => 'Forbidden',
                'code' => 403
            ], 403);
        }

        return redirect()->back()
            ->with('error', $message);
    }

    /**
     * Log security events.
     */
    protected function logSecurityEvent(Request $request, string $message): void
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && class_exists(\App\Models\AdminAuditLog::class)) {
            $admin->logActivity('permission_violation', [
                'message' => $message,
                'route' => $request->route()?->getName(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }
}