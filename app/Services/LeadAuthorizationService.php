<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LeadAuthorizationService
{
    protected $cachePrefix = 'lead_auth_';
    protected $cacheExpiry = 300; // 5 minutes

    /**
     * Get leads query based on admin's authorization level.
     */
    public function getAuthorizedLeadsQuery(Admin $admin): Builder
    {
        // DÜZELTME: Daha gevşek lead criteria - cstatus Customer olmayanları lead say
        $query = User::query()
            ->where(function($q) {
                // Sadece Customer olmayanları al - diğer tüm kullanıcılar lead
                $q->where('cstatus', '!=', 'Customer')
                  ->orWhereNull('cstatus');
            });

        // Super admin ve head of office tüm leads'i görebilir
        if ($admin->isSuperAdmin() || $admin->role?->name === 'head_of_office') {
            Log::info('Full lead access granted', [
                'admin_id' => $admin->id,
                'admin_role' => $admin->role?->name,
                'total_leads' => $query->count()
            ]);
            return $query;
        }

        // Diğer roller için role-based filtering uygula
        $roleBasedQuery = $this->applyRoleBasedFiltering($query, $admin);
        
        Log::info('Lead authorization applied', [
            'admin_id' => $admin->id,
            'admin_role' => $admin->role?->name,
            'query_count' => $roleBasedQuery->count()
        ]);

        return $roleBasedQuery;
    }

    /**
     * Apply role-based filtering to leads query.
     */
    protected function applyRoleBasedFiltering(Builder $query, Admin $admin): Builder
    {
        $roleName = $admin->role?->name;

        switch ($roleName) {
            case 'head_of_office':
                // Head of office sees all leads in their office
                return $this->getOfficeLeads($query, $admin);

            case 'sales_head':
            case 'retention_head':
                // Department heads see all leads in their department
                return $this->getDepartmentLeads($query, $admin);

            case 'team_leader':
            case 'retention_team_leader':
                // Team leaders see their own leads + their team members' leads
                return $this->getTeamLeads($query, $admin);

            case 'sales_agent':
            case 'retention_agent':
            default:
                // Sales agents see only their own leads
                return $this->getOwnLeads($query, $admin);
        }
    }

    /**
     * Get all leads for office level access.
     */
    protected function getOfficeLeads(Builder $query, Admin $admin): Builder
    {
        // Head of office can see all leads
        // No additional filtering needed
        return $query;
    }

    /**
     * Get leads for department level access.
     */
    protected function getDepartmentLeads(Builder $query, Admin $admin): Builder
    {
        $departmentAdminIds = $this->getDepartmentAdminIds($admin);
        
        return $query->where(function($q) use ($departmentAdminIds) {
            $q->whereIn('assign_to', $departmentAdminIds)
              ->orWhereNull('assign_to'); // Include unassigned leads
        });
    }

    /**
     * Get leads for team level access.
     */
    protected function getTeamLeads(Builder $query, Admin $admin): Builder
    {
        $teamAdminIds = $this->getTeamAdminIds($admin);
        
        return $query->where(function($q) use ($teamAdminIds) {
            $q->whereIn('assign_to', $teamAdminIds)
              ->orWhereNull('assign_to'); // Include unassigned leads for assignment
        });
    }

    /**
     * Get leads for individual level access.
     */
    protected function getOwnLeads(Builder $query, Admin $admin): Builder
    {
        return $query->where('assign_to', $admin->id);
    }

    /**
     * Get all admin IDs in the same department.
     */
    protected function getDepartmentAdminIds(Admin $admin): array
    {
        $cacheKey = $this->cachePrefix . 'dept_' . $admin->id;
        
        return Cache::remember($cacheKey, $this->cacheExpiry, function() use ($admin) {
            $adminIds = collect([$admin->id]);
            
            // Get all subordinates
            $subordinates = $admin->getAllSubordinates();
            $adminIds = $adminIds->merge($subordinates);
            
            // Get admins from same department under same supervisor
            if ($admin->supervisor_id) {
                $siblings = Admin::where('supervisor_id', $admin->supervisor_id)
                    ->where('department', $admin->department)
                    ->pluck('id');
                $adminIds = $adminIds->merge($siblings);
                
                // Get subordinates of siblings too
                foreach ($siblings as $siblingId) {
                    $sibling = Admin::find($siblingId);
                    if ($sibling) {
                        $adminIds = $adminIds->merge($sibling->getAllSubordinates());
                    }
                }
            }
            
            return $adminIds->unique()->values()->toArray();
        });
    }

    /**
     * Get admin IDs in the team.
     */
    protected function getTeamAdminIds(Admin $admin): array
    {
        $cacheKey = $this->cachePrefix . 'team_' . $admin->id;
        
        return Cache::remember($cacheKey, $this->cacheExpiry, function() use ($admin) {
            $adminIds = collect([$admin->id]);
            
            // Add direct subordinates
            $subordinates = $admin->getAllSubordinates();
            $adminIds = $adminIds->merge($subordinates);
            
            return $adminIds->unique()->values()->toArray();
        });
    }

    /**
     * Check if admin can view a specific lead.
     */
    public function canViewLead(Admin $admin, User $lead): bool
    {
        if ($admin->isSuperAdmin()) {
            return true;
        }

        // Use authorized query to check if lead would be included
        $authorizedQuery = $this->getAuthorizedLeadsQuery($admin);
        
        return $authorizedQuery->where('id', $lead->id)->exists();
    }

    /**
     * Check if admin can edit a specific lead.
     */
    public function canEditLead(Admin $admin, User $lead): bool
    {
        // Same permissions as viewing for now, but could be more restrictive
        return $this->canViewLead($admin, $lead);
    }

    /**
     * Check if admin can assign a specific lead.
     */
    public function canAssignLead(Admin $admin, User $lead): bool
    {
        $roleName = $admin->role?->name;

        switch ($roleName) {
            case 'sales_agent':
            case 'retention_agent':
                // Agents cannot reassign leads
                return false;

            case 'team_leader':
            case 'retention_team_leader':
                // Team leaders can assign leads within their team
                return $this->canViewLead($admin, $lead);

            case 'sales_head':
            case 'retention_head':
            case 'head_of_office':
                // Management can assign leads they can view
                return $this->canViewLead($admin, $lead);

            default:
                return $admin->isSuperAdmin();
        }
    }

    /**
     * Check if admin can delete a specific lead.
     */
    public function canDeleteLead(Admin $admin, User $lead): bool
    {
        $roleName = $admin->role?->name;

        switch ($roleName) {
            case 'sales_agent':
            case 'retention_agent':
            case 'team_leader':
            case 'retention_team_leader':
                // Lower level roles cannot delete leads
                return false;

            case 'sales_head':
            case 'retention_head':
                // Heads can delete leads in their department
                return $this->canViewLead($admin, $lead);

            case 'head_of_office':
                // Head of office can delete any lead
                return true;

            default:
                return $admin->isSuperAdmin();
        }
    }

    /**
     * Get available admins for lead assignment.
     */
    public function getAvailableAdminsForAssignment(Admin $currentAdmin): array
    {
        $cacheKey = $this->cachePrefix . 'assignable_' . $currentAdmin->id;
        
        return Cache::remember($cacheKey, $this->cacheExpiry, function() use ($currentAdmin) {
            if ($currentAdmin->isSuperAdmin()) {
                // Super admin can assign to anyone
                return Admin::active()
                    ->with('role')
                    ->orderBy('firstName')
                    ->get()
                    ->map(function($admin) {
                        return [
                            'id' => $admin->id,
                            'name' => $admin->getFullName(),
                            'role' => $admin->role?->display_name ?? 'No Role',
                            'department' => $admin->department,
                            'capacity' => $admin->getAssignmentCapacity(),
                        ];
                    })
                    ->toArray();
            }

            $roleName = $currentAdmin->role?->name;
            $query = Admin::active()->with('role');

            switch ($roleName) {
                case 'head_of_office':
                    // Can assign to anyone in office
                    break;

                case 'sales_head':
                case 'retention_head':
                    // Can assign within department
                    $departmentAdminIds = $this->getDepartmentAdminIds($currentAdmin);
                    $query->whereIn('id', $departmentAdminIds);
                    break;

                case 'team_leader':
                case 'retention_team_leader':
                    // Can assign within team
                    $teamAdminIds = $this->getTeamAdminIds($currentAdmin);
                    $query->whereIn('id', $teamAdminIds);
                    break;

                default:
                    // Agents can't assign
                    return [];
            }

            return $query->orderBy('firstName')
                ->get()
                ->map(function($admin) {
                    return [
                        'id' => $admin->id,
                        'name' => $admin->getFullName(),
                        'role' => $admin->role?->display_name ?? 'No Role',
                        'department' => $admin->department,
                        'capacity' => $admin->getAssignmentCapacity(),
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Clear authorization cache for admin.
     */
    public function clearCache(Admin $admin): void
    {
        $keys = [
            $this->cachePrefix . 'dept_' . $admin->id,
            $this->cachePrefix . 'team_' . $admin->id,
            $this->cachePrefix . 'assignable_' . $admin->id,
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Log::info('Lead authorization cache cleared', ['admin_id' => $admin->id]);
    }

    /**
     * Get lead statistics visible to admin.
     */
    public function getLeadStatistics(Admin $admin): array
    {
        $query = $this->getAuthorizedLeadsQuery($admin);
        $totalLeads = $query->count();
        
        Log::info('🪲 STATS QUERY DEBUG', [
            'admin_id' => $admin->id,
            'admin_role' => $admin->role?->name,
            'admin_type' => $admin->type,
            'total_leads_found' => $totalLeads
        ]);

        return [
            'total_leads' => $totalLeads,
            'unassigned_leads' => (clone $query)->whereNull('assign_to')->count(),
            'assigned_leads' => (clone $query)->whereNotNull('assign_to')->count(),
            'high_priority_leads' => (clone $query)->where('lead_priority', 'high')->count(),
            'recent_leads' => (clone $query)->where('created_at', '>=', now()->subDays(7))->count(),
            'needs_follow_up' => (clone $query)->where('next_follow_up_date', '<=', now())->count(),
            'hot_leads' => (clone $query)->where('lead_score', '>=', 70)->count(),
        ];
    }

    /**
     * Apply additional filters to authorized query.
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('lead_notes', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if (!empty($filters['status'])) {
            if (is_array($filters['status'])) {
                $query->whereIn('lead_status_id', $filters['status']);
            } else {
                $query->where('lead_status_id', $filters['status']);
            }
        }

        // Assigned admin filter
        if (!empty($filters['assigned_admin'])) {
            if (is_array($filters['assigned_admin'])) {
                $query->whereIn('assign_to', $filters['assigned_admin']);
            } else {
                $query->where('assign_to', $filters['assigned_admin']);
            }
        }

        // Country filter
        if (!empty($filters['country'])) {
            if (is_array($filters['country'])) {
                $query->whereIn('country', $filters['country']);
            } else {
                $query->where('country', $filters['country']);
            }
        }

        // Lead source filter
        if (!empty($filters['lead_source'])) {
            if (is_array($filters['lead_source'])) {
                $query->whereIn('lead_source', $filters['lead_source']);
            } else {
                $query->where('lead_source', $filters['lead_source']);
            }
        }

        // Lead score range filter
        if (!empty($filters['score_min'])) {
            $query->where('lead_score', '>=', $filters['score_min']);
        }
        if (!empty($filters['score_max'])) {
            $query->where('lead_score', '<=', $filters['score_max']);
        }

        // Date range filter
        if (!empty($filters['date_range'])) {
            $dateRange = $filters['date_range'];
            if (isset($dateRange['start']) && isset($dateRange['end'])) {
                $query->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
            }
        }

        // Last contact filter
        if (!empty($filters['last_contact'])) {
            switch ($filters['last_contact']) {
                case 'today':
                    $query->whereDate('last_contact_date', today());
                    break;
                case 'yesterday':
                    $query->whereDate('last_contact_date', yesterday());
                    break;
                case 'last_7_days':
                    $query->where('last_contact_date', '>=', now()->subDays(7));
                    break;
                case 'last_30_days':
                    $query->where('last_contact_date', '>=', now()->subDays(30));
                    break;
                case 'never':
                    $query->whereNull('last_contact_date');
                    break;
            }
        }

        // Phone validation filter
        if (!empty($filters['has_valid_phone'])) {
            $query->whereNotNull('phone')
                  ->where('phone', '!=', '');
        }

        // Email validation filter
        if (!empty($filters['has_valid_email'])) {
            $query->whereNotNull('email')
                  ->where('email', '!=', '')
                  ->where('email', 'LIKE', '%@%');
        }

        // Notes filter
        if (!empty($filters['has_notes'])) {
            $query->whereNotNull('lead_notes')
                  ->where('lead_notes', '!=', '');
        }

        return $query;
    }
}