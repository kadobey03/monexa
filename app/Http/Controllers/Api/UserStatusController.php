<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserStatusController extends Controller
{
    /**
     * Get users status endpoint
     * GET /api/users/status
     */
    public function getUsersStatus(Request $request): JsonResponse
    {
        // Simple header authentication check (same as import endpoint)
        if ($request->header('Authorization') !== 'Bearer 41|8ezkQw7SGjTfnnLjGSDfXmTNtcy5psTLbFv1s6wMf85f472c') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }

        try {
            $query = User::query();

            // Optional filters
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }

            if ($request->has('cstatus')) {
                $query->where('cstatus', $request->get('cstatus'));
            }

            if ($request->has('lead_status')) {
                $query->where('lead_status', $request->get('lead_status'));
            }

            if ($request->has('email')) {
                $query->where('email', 'like', '%' . $request->get('email') . '%');
            }

            if ($request->has('created_after')) {
                $query->where('created_at', '>=', $request->get('created_after'));
            }

            if ($request->has('created_before')) {
                $query->where('created_at', '<=', $request->get('created_before'));
            }

            // Pagination
            $perPage = $request->get('per_page', 50);
            $perPage = min($perPage, 500); // Max 500 records per page

            $users = $query->select([
                'id',
                'name', 
                'email',
                'phone',
                'country',
                'status',
                'cstatus',
                'lead_status',
                'lead_score',
                'last_contact_date',
                'next_follow_up_date',
                'assign_to',
                'created_at',
                'updated_at'
            ])
            ->with(['assignedAdmin:id,firstname,lastname'])
            ->paginate($perPage);

            // Transform data for better readability
            $transformedUsers = $users->getCollection()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'country' => $user->country,
                    'status' => $user->status,
                    'customer_status' => $user->cstatus,
                    'lead_status' => $user->lead_status,
                    'lead_status_display' => $user->getLeadStatusNameAttribute(),
                    'lead_score' => $user->lead_score,
                    'assigned_to' => $user->assignedAdmin ? 
                        $user->assignedAdmin->firstname . ' ' . $user->assignedAdmin->lastname : null,
                    'last_contact_date' => $user->last_contact_date,
                    'next_follow_up_date' => $user->next_follow_up_date,
                    'days_since_last_contact' => $user->getDaysSinceLastContact(),
                    'needs_follow_up' => $user->needsFollowUp(),
                    'is_hot_lead' => $user->isHotLead(),
                    'engagement_level' => $user->getEngagementLevel(),
                    'created_at' => $user->created_at->toISOString(),
                    'updated_at' => $user->updated_at->toISOString()
                ];
            });

            // Get summary statistics
            $totalUsers = User::count();
            $statusCounts = User::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');
            
            $leadStatusCounts = User::selectRaw('cstatus, count(*) as count')
                ->whereNotNull('cstatus')
                ->groupBy('cstatus')
                ->pluck('count', 'cstatus');

            return response()->json([
                'success' => true,
                'message' => 'Users status retrieved successfully',
                'data' => $transformedUsers,
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                    'has_more' => $users->hasMorePages()
                ],
                'statistics' => [
                    'total_users' => $totalUsers,
                    'status_breakdown' => $statusCounts,
                    'lead_status_breakdown' => $leadStatusCounts,
                    'query_filters' => $request->only([
                        'status', 'cstatus', 'lead_status', 
                        'email', 'created_after', 'created_before'
                    ])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific user status by ID or email
     * GET /api/users/status/{identifier}
     */
    public function getUserStatus(Request $request, $identifier): JsonResponse
    {
        // Simple header authentication check
        if ($request->header('Authorization') !== 'Bearer 41|8ezkQw7SGjTfnnLjGSDfXmTNtcy5psTLbFv1s6wMf85f472c') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }

        try {
            // Try to find user by ID first, then by email
            $user = null;
            if (is_numeric($identifier)) {
                $user = User::find($identifier);
            } else {
                $user = User::where('email', $identifier)->first();
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'country' => $user->country,
                'status' => $user->status,
                'customer_status' => $user->cstatus,
                'lead_status' => $user->lead_status,
                'lead_status_display' => $user->getLeadStatusNameAttribute(),
                'lead_score' => $user->lead_score,
                'estimated_value' => $user->estimated_value,
                'assigned_to' => $user->assignedAdmin ? 
                    $user->assignedAdmin->firstname . ' ' . $user->assignedAdmin->lastname : null,
                'last_contact_date' => $user->last_contact_date,
                'next_follow_up_date' => $user->next_follow_up_date,
                'days_since_last_contact' => $user->getDaysSinceLastContact(),
                'days_until_follow_up' => $user->getDaysUntilFollowUp(),
                'needs_follow_up' => $user->needsFollowUp(),
                'is_hot_lead' => $user->isHotLead(),
                'engagement_level' => $user->getEngagementLevel(),
                'lead_source' => $user->lead_source,
                'lead_tags' => $user->lead_tags,
                'contact_history_count' => count($user->contact_history ?? []),
                'account_balance' => $user->account_bal,
                'demo_balance' => $user->demo_balance,
                'created_at' => $user->created_at->toISOString(),
                'updated_at' => $user->updated_at->toISOString(),
                'additional_info' => json_decode($user->notify ?? '{}', true)
            ];

            return response()->json([
                'success' => true,
                'message' => 'User status retrieved successfully',
                'data' => $userData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get status statistics
     * GET /api/users/status/statistics
     */
    public function getStatusStatistics(Request $request): JsonResponse
    {
        // Simple header authentication check
        if ($request->header('Authorization') !== 'Bearer 41|8ezkQw7SGjTfnnLjGSDfXmTNtcy5psTLbFv1s6wMf85f472c') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }

        try {
            $totalUsers = User::count();
            
            // Status breakdown
            $statusCounts = User::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            // Customer status breakdown  
            $customerStatusCounts = User::selectRaw('cstatus, count(*) as count')
                ->whereNotNull('cstatus')
                ->groupBy('cstatus')
                ->pluck('count', 'cstatus');

            // Lead status breakdown
            $leadStatusCounts = User::selectRaw('lead_status, count(*) as count')
                ->whereNotNull('lead_status')
                ->groupBy('lead_status')
                ->pluck('count', 'lead_status');

            // Country breakdown
            $countryBreakdown = User::selectRaw('country, count(*) as count')
                ->whereNotNull('country')
                ->groupBy('country')
                ->orderByDesc('count')
                ->take(10)
                ->pluck('count', 'country');

            // Recent registrations (last 30 days)
            $recentUsers = User::where('created_at', '>=', now()->subDays(30))->count();

            // Hot leads count
            $hotLeads = User::where('lead_score', '>=', 70)->count();

            // Users needing follow up
            $needsFollowUp = User::where('next_follow_up_date', '<=', now())->count();

            return response()->json([
                'success' => true,
                'message' => 'Status statistics retrieved successfully',
                'data' => [
                    'overview' => [
                        'total_users' => $totalUsers,
                        'recent_registrations_30d' => $recentUsers,
                        'hot_leads' => $hotLeads,
                        'needs_follow_up' => $needsFollowUp
                    ],
                    'status_breakdown' => $statusCounts,
                    'customer_status_breakdown' => $customerStatusCounts,
                    'lead_status_breakdown' => $leadStatusCounts,
                    'top_countries' => $countryBreakdown,
                    'generated_at' => now()->toISOString()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve status statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}