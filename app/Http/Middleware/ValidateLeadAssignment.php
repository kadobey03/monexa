<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ValidateLeadAssignment
{
    /**
     * Handle an incoming request for lead assignment operations
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required.',
                'error_code' => 'AUTH_REQUIRED'
            ], 401);
        }

        $admin = Auth::guard('admin')->user();
        
        // Check if admin has assignment permissions
        if (!$this->hasAssignmentPermission($admin)) {
            Log::warning('Lead assignment permission denied', [
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'route' => $request->route()->getName(),
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to assign leads.',
                'error_code' => 'PERMISSION_DENIED'
            ], 403);
        }

        // Validate lead exists for single assignments
        if ($request->route('leadId')) {
            $leadId = $request->route('leadId');
            $lead = User::find($leadId);
            
            if (!$lead) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead not found.',
                    'error_code' => 'LEAD_NOT_FOUND'
                ], 404);
            }
            
            // Attach lead to request for controller use
            $request->attributes->add(['lead' => $lead]);
        }

        // Validate admin ID for assignments
        if ($request->has('admin_id')) {
            $adminId = $request->input('admin_id');
            
            if ($adminId) {
                $targetAdmin = Admin::find($adminId);
                
                if (!$targetAdmin) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Target admin not found.',
                        'error_code' => 'ADMIN_NOT_FOUND'
                    ], 404);
                }
                
                if (!$targetAdmin->isAvailableForAssignment()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected admin is not available for new assignments.',
                        'error_code' => 'ADMIN_NOT_AVAILABLE'
                    ], 422);
                }
                
                // Attach target admin to request
                $request->attributes->add(['target_admin' => $targetAdmin]);
            }
        }

        // Validate bulk assignment data
        if ($request->has('lead_ids') && is_array($request->input('lead_ids'))) {
            $leadIds = $request->input('lead_ids');
            
            if (count($leadIds) > 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bulk assignment limited to 100 leads at a time.',
                    'error_code' => 'BULK_LIMIT_EXCEEDED'
                ], 422);
            }
            
            $leads = User::whereIn('id', $leadIds)->get();
            
            if ($leads->count() !== count($leadIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some leads were not found.',
                    'error_code' => 'INVALID_LEAD_IDS'
                ], 422);
            }
            
            $request->attributes->add(['leads' => $leads]);
        }

        return $next($request);
    }

    /**
     * Check if admin has permission to assign leads
     */
    private function hasAssignmentPermission(Admin $admin): bool
    {
        // Check if admin is active
        if ($admin->status !== 'active') {
            return false;
        }

        // Check role-based permissions
        if ($admin->hasRole(['super_admin', 'admin', 'lead_manager'])) {
            return true;
        }

        // Check specific permission
        if ($admin->hasPermissionTo('assign_leads')) {
            return true;
        }

        // Default: no permission
        return false;
    }
}