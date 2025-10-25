<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
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

        // Role kontrolü
        if (!$this->hasRequiredRole($admin, $roles)) {
            return $this->forbidden($request, 'Insufficient role permissions');
        }

        // Role switching validation
        if ($request->has('switch_role')) {
            if (!$this->canSwitchRole($admin, $request->get('switch_role'))) {
                return $this->forbidden($request, 'Role switching not allowed');
            }
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
     * Check if admin has required roles.
     */
    protected function hasRequiredRole($admin, array $roles): bool
    {
        if (empty($roles)) {
            return true;
        }

        // Super admin her şeyi yapabilir
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $adminRole = $this->getAdminRoleWithCache($admin);

        if (!$adminRole) {
            return false;
        }

        // Role format: role1,role2|role3 (OR ve AND operatörleri)
        foreach ($roles as $roleExpression) {
            if ($this->evaluateRoleExpression($adminRole, $roleExpression)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Evaluate role expression with OR and AND operators.
     */
    protected function evaluateRoleExpression($adminRole, string $roleExpression): bool
    {
        // OR operatörü (|) ile ayrılmış roller
        $orGroups = explode('|', $roleExpression);

        foreach ($orGroups as $orGroup) {
            // AND operatörü (,) ile ayrılmış roller
            $andRoles = array_map('trim', explode(',', $orGroup));
            
            if ($this->hasAllRoles($adminRole, $andRoles)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if admin has all specified roles (including hierarchy).
     */
    protected function hasAllRoles($adminRole, array $requiredRoles): bool
    {
        foreach ($requiredRoles as $requiredRole) {
            if (!$this->hasRoleOrHierarchy($adminRole, $requiredRole)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if admin has role or can access due to hierarchy.
     */
    protected function hasRoleOrHierarchy($adminRole, string $requiredRole): bool
    {
        // Exact role match
        if ($adminRole->name === $requiredRole) {
            return true;
        }

        // Hierarchy check - üst roller alt rollerin işlevlerini yapabilir
        return $this->canManageRoleByHierarchy($adminRole, $requiredRole);
    }

    /**
     * Check if admin role can manage required role by hierarchy.
     */
    protected function canManageRoleByHierarchy($adminRole, string $requiredRole): bool
    {
        $cacheKey = "role_hierarchy_{$adminRole->id}_{$requiredRole}";

        return Cache::remember($cacheKey, 300, function () use ($adminRole, $requiredRole) {
            $targetRole = \App\Models\Role::where('name', $requiredRole)->first();
            
            if (!$targetRole) {
                return false;
            }

            return $adminRole->canManage($targetRole);
        });
    }

    /**
     * Get admin role with caching.
     */
    protected function getAdminRoleWithCache($admin)
    {
        $cacheKey = "admin_role_{$admin->id}";

        return Cache::remember($cacheKey, 300, function () use ($admin) {
            return $admin->role;
        });
    }

    /**
     * Check if admin can switch to specified role.
     */
    protected function canSwitchRole($admin, string $targetRoleName): bool
    {
        // Super admin can switch to any role
        if ($admin->isSuperAdmin()) {
            return true;
        }

        $adminRole = $admin->role;
        $targetRole = \App\Models\Role::where('name', $targetRoleName)->first();

        if (!$adminRole || !$targetRole) {
            return false;
        }

        // Can only switch to same level or lower hierarchy roles
        return $adminRole->hierarchy_level <= $targetRole->hierarchy_level;
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
            $admin->logActivity('security_violation', [
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