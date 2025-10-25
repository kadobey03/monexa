<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class HierarchyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $scope
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $scope = 'subordinates'): Response
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

        // Hiyerarşi kontrolü
        if (!$this->validateHierarchyAccess($admin, $request, $scope)) {
            return $this->forbidden($request, 'Hierarchical access denied');
        }

        // Request'e hierarchy context ekle
        $this->addHierarchyContext($request, $admin, $scope);

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
     * Validate hierarchy access based on scope.
     */
    protected function validateHierarchyAccess($admin, Request $request, string $scope): bool
    {
        // Super admin her şeyi yapabilir
        if ($admin->isSuperAdmin()) {
            return true;
        }

        switch ($scope) {
            case 'subordinates':
                return $this->validateSubordinateAccess($admin, $request);
                
            case 'same_level':
                return $this->validateSameLevelAccess($admin, $request);
                
            case 'group_boundary':
                return $this->validateGroupBoundaryAccess($admin, $request);
                
            case 'department_boundary':
                return $this->validateDepartmentBoundaryAccess($admin, $request);
                
            case 'supervisor':
                return $this->validateSupervisorAccess($admin, $request);
                
            case 'parent_child':
                return $this->validateParentChildAccess($admin, $request);
                
            default:
                return false;
        }
    }

    /**
     * Validate subordinate access - admin can only access subordinates.
     */
    protected function validateSubordinateAccess($admin, Request $request): bool
    {
        $targetAdminId = $this->getTargetAdminIdFromRequest($request);
        
        if (!$targetAdminId) {
            return true; // No specific target, allow (will be filtered in query)
        }

        // Self access is allowed
        if ($targetAdminId == $admin->id) {
            return true;
        }

        $cacheKey = "subordinate_access_{$admin->id}_{$targetAdminId}";
        
        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdminId) {
            $targetAdmin = \App\Models\Admin::find($targetAdminId);
            
            if (!$targetAdmin) {
                return false;
            }

            return $admin->isSubordinate($targetAdmin);
        });
    }

    /**
     * Validate same level access - admin can access same hierarchy level admins.
     */
    protected function validateSameLevelAccess($admin, Request $request): bool
    {
        $targetAdminId = $this->getTargetAdminIdFromRequest($request);
        
        if (!$targetAdminId) {
            return true;
        }

        if ($targetAdminId == $admin->id) {
            return true;
        }

        $cacheKey = "same_level_access_{$admin->id}_{$targetAdminId}";
        
        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdminId) {
            $targetAdmin = \App\Models\Admin::find($targetAdminId);
            
            if (!$targetAdmin || !$targetAdmin->role || !$admin->role) {
                return false;
            }

            return $admin->role->hierarchy_level === $targetAdmin->role->hierarchy_level;
        });
    }

    /**
     * Validate group boundary access - admin can only access same group members.
     */
    protected function validateGroupBoundaryAccess($admin, Request $request): bool
    {
        if (!$admin->admin_group_id) {
            return false;
        }

        $targetAdminId = $this->getTargetAdminIdFromRequest($request);
        
        if (!$targetAdminId) {
            return true;
        }

        if ($targetAdminId == $admin->id) {
            return true;
        }

        $cacheKey = "group_boundary_access_{$admin->id}_{$targetAdminId}";
        
        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdminId) {
            $targetAdmin = \App\Models\Admin::find($targetAdminId);
            
            if (!$targetAdmin) {
                return false;
            }

            return $targetAdmin->admin_group_id === $admin->admin_group_id;
        });
    }

    /**
     * Validate department boundary access - admin can only access same department members.
     */
    protected function validateDepartmentBoundaryAccess($admin, Request $request): bool
    {
        if (!$admin->department) {
            return false;
        }

        $targetAdminId = $this->getTargetAdminIdFromRequest($request);
        
        if (!$targetAdminId) {
            return true;
        }

        if ($targetAdminId == $admin->id) {
            return true;
        }

        $cacheKey = "department_boundary_access_{$admin->id}_{$targetAdminId}";
        
        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdminId) {
            $targetAdmin = \App\Models\Admin::find($targetAdminId);
            
            if (!$targetAdmin) {
                return false;
            }

            return $targetAdmin->department === $admin->department;
        });
    }

    /**
     * Validate supervisor access - admin must be a supervisor.
     */
    protected function validateSupervisorAccess($admin, Request $request): bool
    {
        // Admin must have subordinates to be considered a supervisor
        $hasSubordinates = Cache::remember("admin_subordinates_{$admin->id}", 300, function () use ($admin) {
            return $admin->subordinates()->exists();
        });

        if (!$hasSubordinates) {
            return false;
        }

        // Additional role-based validation
        return $admin->role && $admin->role->isManagementRole();
    }

    /**
     * Validate parent-child relationship access.
     */
    protected function validateParentChildAccess($admin, Request $request): bool
    {
        $targetAdminId = $this->getTargetAdminIdFromRequest($request);
        
        if (!$targetAdminId) {
            return true;
        }

        if ($targetAdminId == $admin->id) {
            return true;
        }

        $cacheKey = "parent_child_access_{$admin->id}_{$targetAdminId}";
        
        return Cache::remember($cacheKey, 300, function () use ($admin, $targetAdminId) {
            $targetAdmin = \App\Models\Admin::find($targetAdminId);
            
            if (!$targetAdmin) {
                return false;
            }

            // Check if admin is direct supervisor or if target is direct subordinate
            return $targetAdmin->supervisor_id === $admin->id || 
                   $admin->supervisor_id === $targetAdminId;
        });
    }

    /**
     * Add hierarchy context to request for query filtering.
     */
    protected function addHierarchyContext(Request $request, $admin, string $scope): void
    {
        $context = [
            'admin_id' => $admin->id,
            'scope' => $scope,
        ];

        switch ($scope) {
            case 'subordinates':
                $context['allowed_admin_ids'] = array_merge(
                    [$admin->id], 
                    $admin->getAllSubordinates()
                );
                break;

            case 'same_level':
                if ($admin->role) {
                    $context['hierarchy_level'] = $admin->role->hierarchy_level;
                }
                break;

            case 'group_boundary':
                $context['admin_group_id'] = $admin->admin_group_id;
                break;

            case 'department_boundary':
                $context['department'] = $admin->department;
                break;

            case 'parent_child':
                $context['allowed_admin_ids'] = $this->getParentChildIds($admin);
                break;
        }

        $request->attributes->set('hierarchy_context', $context);
    }

    /**
     * Get parent-child relationship IDs.
     */
    protected function getParentChildIds($admin): array
    {
        $ids = [$admin->id];

        // Add supervisor
        if ($admin->supervisor_id) {
            $ids[] = $admin->supervisor_id;
        }

        // Add direct subordinates
        $subordinateIds = $admin->subordinates()->pluck('id')->toArray();
        $ids = array_merge($ids, $subordinateIds);

        return array_unique($ids);
    }

    /**
     * Extract target admin ID from request.
     */
    protected function getTargetAdminIdFromRequest(Request $request): ?int
    {
        // Try to get ID from route parameters
        $routeParameters = $request->route()?->parameters() ?? [];
        
        // Check for admin ID in route parameters
        if (isset($routeParameters['admin']) && is_numeric($routeParameters['admin'])) {
            return (int) $routeParameters['admin'];
        }

        if (isset($routeParameters['id']) && is_numeric($routeParameters['id'])) {
            // Make sure we're on an admin route
            if ($request->is('admin/admins/*')) {
                return (int) $routeParameters['id'];
            }
        }

        // Check for admin ID in query parameters
        if ($request->has('admin_id') && is_numeric($request->get('admin_id'))) {
            return (int) $request->get('admin_id');
        }

        // For user/lead management, get the assigned admin
        if ($request->is('admin/users/*') || $request->is('admin/leads/*')) {
            $userId = $routeParameters['user'] ?? $routeParameters['id'] ?? null;
            
            if ($userId && is_numeric($userId)) {
                $user = \App\Models\User::find($userId);
                return $user?->assign_to;
            }
        }

        return null;
    }

    /**
     * Check if request is for bulk operations.
     */
    protected function isBulkOperation(Request $request): bool
    {
        return $request->has('bulk_action') || 
               $request->has('selected_items') ||
               $request->is('*/bulk/*') ||
               str_contains($request->path(), '/bulk/');
    }

    /**
     * Validate bulk operation hierarchy access.
     */
    protected function validateBulkOperationAccess($admin, Request $request, string $scope): bool
    {
        $selectedItems = $request->get('selected_items', []);
        
        if (empty($selectedItems)) {
            return true;
        }

        // Check access for each selected item
        foreach ($selectedItems as $itemId) {
            $tempRequest = clone $request;
            $tempRequest->route()?->setParameter('id', $itemId);
            
            if (!$this->validateHierarchyAccess($admin, $tempRequest, $scope)) {
                return false;
            }
        }

        return true;
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
            $admin->logActivity('hierarchy_violation', [
                'message' => $message,
                'route' => $request->route()?->getName(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'target_admin_id' => $this->getTargetAdminIdFromRequest($request),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }
}