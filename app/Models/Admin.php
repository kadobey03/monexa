<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    /**
     * The guard associated with the model.
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'phone',
        'dashboard_style',
        'status',
        'type',
        'role_id',
        'admin_group_id',
        'supervisor_id',
        'subordinate_ids',
        'hired_at',
        'employee_id',
        'department',
        'position',
        'hierarchy_level',
        'monthly_target',
        'current_performance',
        'leads_assigned_count',
        'leads_converted_count',
        'work_schedule',
        'time_zone',
        'is_available',
        'last_activity',
        'lead_assignment_rules',
        'max_leads_per_day',
        'preferred_lead_sources',
        'lead_categories',
        'notification_preferences',
        'dashboard_settings',
        'language',
        'last_login_at',
        'last_login_ip',
        'two_factor_enabled',
        'login_history',
        'bio',
        'avatar',
        'social_links',
        'emergency_contact',
        // 2FA Security fields
        'enable_2fa',
        'token_2fa',
        'token_2fa_expiry',
        'pass_2fa',
        'failed_login_attempts',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'login_history',
        'emergency_contact',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'hired_at' => 'date',
        'monthly_target' => 'decimal:2',
        'current_performance' => 'decimal:2',
        'hierarchy_level' => 'integer',
        'leads_assigned_count' => 'integer',
        'leads_converted_count' => 'integer',
        'max_leads_per_day' => 'integer',
        'is_available' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'last_activity' => 'datetime',
        'last_login_at' => 'datetime',
        'subordinate_ids' => 'array',
        'work_schedule' => 'array',
        'lead_assignment_rules' => 'array',
        'preferred_lead_sources' => 'array',
        'lead_categories' => 'array',
        'notification_preferences' => 'array',
        'dashboard_settings' => 'array',
        'login_history' => 'array',
        'social_links' => 'array',
        'emergency_contact' => 'array',
        // 2FA Security casts
        'token_2fa_expiry' => 'datetime',
        'failed_login_attempts' => 'integer',
        'locked_until' => 'datetime',
    ];

    /**
     * Available admin statuses.
     */
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_INACTIVE = 'Inactive';
    public const STATUS_SUSPENDED = 'Suspended';

    /**
     * Available admin types.
     */
    public const TYPE_ADMIN = 'admin';
    public const TYPE_MANAGER = 'manager';
    public const TYPE_SUPERVISOR = 'supervisor';

    /**
     * Get the role that belongs to the admin.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the admin group that belongs to the admin.
     */
    public function adminGroup(): BelongsTo
    {
        return $this->belongsTo(AdminGroup::class, 'admin_group_id');
    }

    /**
     * Get the supervisor of this admin.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'supervisor_id');
    }

    /**
     * Get the subordinates of this admin.
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(Admin::class, 'supervisor_id');
    }

    /**
     * Enhanced lead management relationships
     */
    public function allAssignedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'assign_to');
    }

    public function currentLeads(): HasMany
    {
        return $this->assignedUsers()->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
    }

    public function convertedCustomers(): HasMany
    {
        return $this->assignedUsers()->where('cstatus', 'Customer');
    }

    public function hotLeads(): HasMany
    {
        return $this->assignedUsers()
                    ->whereNull('cstatus')
                    ->where('lead_score', '>=', 70);
    }

    public function leadsNeedingFollowUp(): HasMany
    {
        return $this->assignedUsers()
                    ->whereNull('cstatus')
                    ->where('next_follow_up_date', '<=', now());
    }

    /**
     * Get the users assigned to this admin.
     */
    public function assignedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'assign_to');
    }

    /**
     * Get the active leads assigned to this admin.
     */
    public function activeLeads(): HasMany
    {
        return $this->hasMany(User::class, 'assign_to')->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
    }

    /**
     * Get the audit logs for this admin.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AdminAuditLog::class, 'admin_id');
    }

    /**
     * Get the lead assignment history for this admin.
     */
    public function leadAssignmentHistory(): HasMany
    {
        return $this->hasMany(LeadAssignmentHistory::class, 'assigned_to_admin_id');
    }

    /**
     * Scope a query to only include active admins.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include available admins.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to filter by department.
     */
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to filter by role.
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }

    /**
     * Scope a query to filter by admin group.
     */
    public function scopeByGroup($query, $groupId)
    {
        return $query->where('admin_group_id', $groupId);
    }

    /**
     * Scope a query to get admins with capacity for new leads.
     */
    public function scopeWithCapacity($query)
    {
        return $query->whereRaw('leads_assigned_count < COALESCE(max_leads_per_day, 999999)');
    }

    /**
     * Enhanced scope for lead management
     */
    public function scopeAvailableForLeads(Builder $query): Builder
    {
        return $query->active()
                    ->available()
                    ->withCapacity()
                    ->orderBy('leads_assigned_count', 'asc');
    }

    public function scopeByPerformance(Builder $query, float $minPerformance = 0): Builder
    {
        return $query->where('current_performance', '>=', $minPerformance);
    }

    public function scopeByLeadCount(Builder $query, int $minLeads = 0, int $maxLeads = null): Builder
    {
        $query->where('leads_assigned_count', '>=', $minLeads);

        if ($maxLeads !== null) {
            $query->where('leads_assigned_count', '<=', $maxLeads);
        }

        return $query;
    }

    public function scopeByConversionRate(Builder $query, float $minRate = 0): Builder
    {
        return $query->whereRaw('(leads_converted_count / GREATEST(leads_assigned_count, 1)) * 100 >= ?', [$minRate]);
    }

    /**
     * Check if admin has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($permissionName);
    }

    /**
     * Check if admin has any of the specified permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasAnyPermission($permissions);
    }

    /**
     * Check if admin has all of the specified permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasAllPermissions($permissions);
    }

    /**
     * Check if admin can manage another admin.
     */
    public function canManageAdmin(Admin $admin): bool
    {
        // Can't manage self
        if ($this->id === $admin->id) {
            return false;
        }

        // Super admin can manage everyone
        if ($this->role && $this->role->isSuperAdmin()) {
            return true;
        }

        // Check if admin is a subordinate
        if ($this->isSubordinate($admin)) {
            return true;
        }

        // Check role hierarchy
        if ($this->role && $admin->role) {
            return $this->role->canManage($admin->role);
        }

        return false;
    }

    /**
     * Check if admin can manage a specific user/lead.
     */
    public function canManageUser(User $user): bool
    {
        // Can manage if user is assigned to this admin
        if ($user->assign_to === $this->id) {
            return true;
        }

        // Can manage if user is assigned to a subordinate
        $subordinateIds = $this->getSubordinateIds();
        if ($user->assign_to && in_array($user->assign_to, $subordinateIds)) {
            return true;
        }

        // Check permissions
        return $this->hasPermission('user_view') &&
               ($this->hasPermission('user_update') || $this->hasPermission('lead_update'));
    }

    /**
     * Get all subordinate admin IDs.
     */
    public function getSubordinateIds(): array
    {
        if ($this->subordinate_ids) {
            return $this->subordinate_ids;
        }

        // Fallback: get from relationship
        return $this->subordinates->pluck('id')->toArray();
    }

    /**
     * Get all subordinates recursively.
     */
    public function getAllSubordinates(): array
    {
        $subordinates = [];
        
        foreach ($this->subordinates as $subordinate) {
            $subordinates[] = $subordinate->id;
            $subordinates = array_merge($subordinates, $subordinate->getAllSubordinates());
        }
        
        return array_unique($subordinates);
    }

    /**
     * Check if another admin is a subordinate of this admin.
     */
    public function isSubordinate(Admin $admin): bool
    {
        return in_array($admin->id, $this->getAllSubordinates());
    }

    /**
     * Check if this admin is available for lead assignment.
     * Enhanced with proper validation and logging.
     */
    public function isAvailableForAssignment(): bool
    {
        // Basic status check
        if ($this->status !== self::STATUS_ACTIVE) {
            \Log::debug('Admin assignment check failed: inactive status', [
                'admin_id' => $this->id,
                'admin_name' => $this->getFullName(),
                'status' => $this->status
            ]);
            return false;
        }

        // Availability check
        if (!$this->is_available) {
            \Log::debug('Admin assignment check failed: not available', [
                'admin_id' => $this->id,
                'admin_name' => $this->getFullName(),
                'is_available' => $this->is_available
            ]);
            return false;
        }

        // Capacity check - allow override for super admins and managers
        if ($this->max_leads_per_day && !$this->isManager()) {
            $currentCount = $this->leads_assigned_count ?? 0;
            if ($currentCount >= $this->max_leads_per_day) {
                \Log::debug('Admin assignment check failed: at capacity', [
                    'admin_id' => $this->id,
                    'admin_name' => $this->getFullName(),
                    'current_leads' => $currentCount,
                    'max_leads' => $this->max_leads_per_day
                ]);
                return false;
            }
        }

        // Working hours check (optional - can be disabled via config)
        if (config('lead_assignment.check_working_hours', false) && $this->adminGroup) {
            if (!$this->adminGroup->isInWorkingHours()) {
                \Log::debug('Admin assignment check failed: outside working hours', [
                    'admin_id' => $this->id,
                    'admin_name' => $this->getFullName(),
                    'admin_group_id' => $this->admin_group_id
                ]);
                return false;
            }
        }

        \Log::debug('Admin assignment check passed', [
            'admin_id' => $this->id,
            'admin_name' => $this->getFullName(),
            'current_leads' => $this->leads_assigned_count ?? 0,
            'max_leads' => $this->max_leads_per_day ?? 'unlimited'
        ]);

        return true;
    }

    /**
     * Get current lead assignment capacity.
     */
    public function getAssignmentCapacity(): array
    {
        $maxLeads = $this->max_leads_per_day ?: 50; // Default capacity
        $currentLeads = $this->leads_assigned_count;
        
        return [
            'max_capacity' => $maxLeads,
            'current_assigned' => $currentLeads,
            'remaining_capacity' => max(0, $maxLeads - $currentLeads),
            'capacity_percentage' => ($currentLeads / $maxLeads) * 100,
        ];
    }

    /**
     * Assign a user to this admin with enhanced safety.
     */
    public function assignUser(User $user, Admin $assignedBy = null, string $reason = null): bool
    {
        if (!$this->isAvailableForAssignment()) {
            \Log::warning('User assignment failed: Admin not available', [
                'admin_id' => $this->id,
                'user_id' => $user->id,
                'assigned_by' => $assignedBy?->id
            ]);
            return false;
        }

        try {
            \DB::beginTransaction();

            $previousAdminId = $user->assign_to;

            // Skip if already assigned to this admin
            if ($previousAdminId == $this->id) {
                \DB::rollBack();
                return true;
            }

            // End current assignment if exists
            if ($previousAdminId) {
                $currentAssignment = LeadAssignmentHistory::where('user_id', $user->id)
                                                         ->where('assignment_outcome', LeadAssignmentHistory::OUTCOME_ACTIVE)
                                                         ->whereNull('assignment_ended_at')
                                                         ->first();
                
                if ($currentAssignment) {
                    $currentAssignment->endAssignment(LeadAssignmentHistory::OUTCOME_REASSIGNED);
                }

                // Safely decrement previous admin's count
                Admin::where('id', $previousAdminId)
                     ->where('leads_assigned_count', '>', 0)
                     ->decrement('leads_assigned_count');
            }

            $user->assign_to = $this->id;
            $user->save();

            // Create comprehensive assignment history record
            LeadAssignmentHistory::createAssignment([
                'user_id' => $user->id,
                'assigned_from_admin_id' => $previousAdminId,
                'assigned_to_admin_id' => $this->id,
                'assigned_by_admin_id' => $assignedBy?->id,
                'assignment_type' => $previousAdminId ? LeadAssignmentHistory::TYPE_REASSIGNMENT : LeadAssignmentHistory::TYPE_INITIAL,
                'assignment_method' => LeadAssignmentHistory::METHOD_MANUAL,
                'assignment_outcome' => LeadAssignmentHistory::OUTCOME_ACTIVE,
                'reason' => $reason,
                'priority' => $user->lead_priority ?? 'normal',
                'lead_status_at_assignment' => $user->lead_status ?? 'new',
                'lead_score_at_assignment' => $user->lead_score,
                'estimated_value_at_assignment' => $user->estimated_value,
                'lead_tags_at_assignment' => $user->lead_tags,
                'admin_lead_count_before' => $this->leads_assigned_count,
                'admin_lead_count_after' => $this->leads_assigned_count + 1,
                'admin_performance_score' => $this->current_performance,
                'admin_availability_status' => $this->is_available ? 'available' : 'busy',
                'lead_timezone' => $user->getTimezone(),
                'lead_region' => $user->getRegion(),
                'admin_timezone' => $this->time_zone ?? 'UTC',
                'lead_source' => $user->lead_source,
                'department' => $this->department,
                'admin_group_id' => $this->admin_group_id,
                'assignment_started_at' => now(),
            ]);

            // Safely increment counter
            $this->increment('leads_assigned_count');

            \DB::commit();

            \Log::info('User assigned to admin successfully', [
                'admin_id' => $this->id,
                'user_id' => $user->id,
                'previous_admin_id' => $previousAdminId,
                'assigned_by' => $assignedBy?->id,
                'reason' => $reason
            ]);

            return true;

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('User assignment to admin failed', [
                'admin_id' => $this->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Update performance metrics.
     */
    public function updatePerformance(float $performance, bool $isConversion = false): bool
    {
        $this->current_performance = $performance;
        
        if ($isConversion) {
            $this->increment('leads_converted_count');
        }
        
        return $this->save();
    }

    /**
     * Get performance metrics.
     */
    public function getPerformanceMetrics(Carbon $startDate = null, Carbon $endDate = null): array
    {
        $startDate = $startDate ?? Carbon::now()->subMonth();
        $endDate = $endDate ?? Carbon::now();

        // Safely get assignment stats - handle case where table doesn't exist
        $assignmentStats = [];
        try {
            if (class_exists(LeadAssignmentHistory::class)) {
                $assignmentStats = LeadAssignmentHistory::getAdminStats($this->id, $startDate, $endDate);
            }
        } catch (\Exception $e) {
            // If table doesn't exist or other DB error, use default stats
            $assignmentStats = [
                'total_assignments' => $this->leads_assigned_count ?? 0,
                'total_conversions' => $this->leads_converted_count ?? 0,
                'conversion_rate' => 0,
                'avg_assignment_duration' => 0,
                'peak_assignment_day' => null,
                'recent_activity' => []
            ];
        }
        
        return array_merge($assignmentStats, [
            'current_performance' => $this->current_performance ?? 0,
            'target_achievement' => $this->monthly_target ?
                (($this->current_performance ?? 0) / $this->monthly_target * 100) : 0,
            'efficiency_rating' => $this->calculateEfficiencyRating(),
        ]);
    }

    /**
     * Calculate efficiency rating based on various factors.
     */
    public function calculateEfficiencyRating(): float
    {
        $rating = 0;

        // Conversion rate (0-40 points)
        if ($this->leads_assigned_count > 0) {
            $conversionRate = ($this->leads_converted_count / $this->leads_assigned_count) * 100;
            $rating += min(40, $conversionRate);
        }

        // Target achievement (0-30 points)
        if ($this->monthly_target > 0) {
            $targetAchievement = ($this->current_performance / $this->monthly_target) * 100;
            $rating += min(30, $targetAchievement * 0.3);
        }

        // Activity level (0-20 points)
        if ($this->last_activity) {
            $daysSinceActivity = Carbon::now()->diffInDays($this->last_activity);
            $activityScore = max(0, 20 - ($daysSinceActivity * 2));
            $rating += $activityScore;
        }

        // Workload management (0-10 points)
        $capacity = $this->getAssignmentCapacity();
        if ($capacity['capacity_percentage'] <= 80) {
            $rating += 10; // Good workload management
        } elseif ($capacity['capacity_percentage'] <= 100) {
            $rating += 5; // At capacity but manageable
        }

        return min(100, $rating);
    }

    /**
     * Enhanced business logic for lead management
     */
    public function getLeadStats(): array
    {
        $assignedUsers = $this->allAssignedUsers;

        return [
            'total_assigned' => $assignedUsers->count(),
            'active_leads' => $this->currentLeads()->count(),
            'converted_customers' => $this->convertedCustomers()->count(),
            'hot_leads' => $this->hotLeads()->count(),
            'needs_follow_up' => $this->leadsNeedingFollowUp()->count(),
            'conversion_rate' => $this->getConversionRate(),
            'capacity_used' => $this->getAssignmentCapacity()['capacity_percentage'],
        ];
    }

    public function canTakeMoreLeads(): bool
    {
        return $this->isAvailableForAssignment();
    }

    public function getWorkloadStatus(): string
    {
        $capacity = $this->getAssignmentCapacity();

        if ($capacity['capacity_percentage'] >= 90) {
            return 'overloaded';
        } elseif ($capacity['capacity_percentage'] >= 70) {
            return 'busy';
        } elseif ($capacity['capacity_percentage'] >= 40) {
            return 'moderate';
        } else {
            return 'light';
        }
    }

    public function getPerformanceTier(): string
    {
        $performance = $this->current_performance ?? 0;
        $conversionRate = $this->getConversionRate();

        if ($performance >= 10000 && $conversionRate >= 30) {
            return 'elite';
        } elseif ($performance >= 5000 && $conversionRate >= 20) {
            return 'high';
        } elseif ($performance >= 2000 && $conversionRate >= 10) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Get the admin's full name.
     */
    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    /**
     * Get display name for the admin.
     */
    public function getDisplayName(): string
    {
        return $this->getFullName();
    }

    /**
     * Check if admin is a super admin.
     * Bu method role relationship'i kullanarak consistent bir yaklaşım sağlar.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->isSuperAdmin();
    }

    /**
     * Check if admin is in management role.
     */
    public function isManager(): bool
    {
        return $this->role && $this->role->isManagementRole();
    }

    /**
     * Check if admin is head of office.
     * Lead authorization için özel method.
     */
    public function isHeadOfOffice(): bool
    {
        return $this->role && $this->role->name === 'head_of_office';
    }

    /**
     * Check if admin is sales representative (agent level).
     * Bu role'ler sadece kendi assign_to=admin_id olan lead'leri görebilir.
     */
    public function isSalesRepresentative(): bool
    {
        return $this->role && in_array($this->role->name, [
            'sale',            // ✅ FIXED: DB'deki gerçek role name
            'sales_agent',
            'retention_agent'
        ]);
    }

    /**
     * Get standardized role name.
     * Consistent role detection için kullanılır.
     */
    public function getRoleName(): ?string
    {
        return $this->role?->name;
    }

    /**
     * Check if admin has bypass privileges for lead filtering.
     * Super admin ve head of office tüm lead'leri görebilir.
     */
    public function hasBypassPrivileges(): bool
    {
        return $this->isSuperAdmin() || $this->isHeadOfOffice();
    }

    /**
     * Check if admin can be a supervisor.
     * This method determines if an admin can supervise other admins.
     */
    public function canBeSupervisor(): bool
    {
        // Basic supervisor qualification requirements:
        // 1. Must be active
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }
        
        // 2. Must have a role assigned
        if (!$this->role) {
            return false;
        }
        
        // 3. Must have a management role
        if (!$this->isManager()) {
            return false;
        }
        
        // 4. Optional: Check if admin is available for supervisory duties
        // (This can be enabled if needed for business logic)
        // if (!$this->is_available) {
        //     return false;
        // }
        
        return true;
    }

    /**
     * Update last activity timestamp.
     */
    public function updateLastActivity(): bool
    {
        $this->last_activity = now();
        return $this->save();
    }

    /**
     * Update availability status.
     */
    public function setAvailability(bool $isAvailable): bool
    {
        $this->is_available = $isAvailable;
        return $this->save();
    }

    /**
     * Get notification preferences for a specific type.
     */
    public function getNotificationPreference(string $type, bool $default = true): bool
    {
        $preferences = $this->notification_preferences ?? [];
        return $preferences[$type] ?? $default;
    }

    /**
     * Set notification preference for a specific type.
     */
    public function setNotificationPreference(string $type, bool $enabled): bool
    {
        $preferences = $this->notification_preferences ?? [];
        $preferences[$type] = $enabled;
        $this->notification_preferences = $preferences;
        
        return $this->save();
    }

    /**
     * Get dashboard setting.
     */
    public function getDashboardSetting(string $key, $default = null)
    {
        $settings = $this->dashboard_settings ?? [];
        return data_get($settings, $key, $default);
    }

    /**
     * Set dashboard setting.
     */
    public function setDashboardSetting(string $key, $value): bool
    {
        $settings = $this->dashboard_settings ?? [];
        data_set($settings, $key, $value);
        $this->dashboard_settings = $settings;
        
        return $this->save();
    }

    /**
     * Log admin activity.
     */
    public function logActivity(string $action, array $data = []): void
    {
        if (class_exists(AdminAuditLog::class)) {
            AdminAuditLog::logAction(array_merge([
                'admin_id' => $this->id,
                'admin_name' => $this->getFullName(),
                'admin_email' => $this->email,
                'action' => $action,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ], $data));
        }
        
        $this->updateLastActivity();
    }

    /**
     * Get profile image URL.
     */
    public function getProfileImage(): string
    {
        if (!empty($this->avatar)) {
            // If avatar is a full URL, return as-is
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            
            // If it's a relative path, prepend asset URL
            return asset('storage/' . ltrim($this->avatar, '/'));
        }
        
        // Generate default profile image based on initials
        $initials = $this->getInitials();
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) .
               "&color=7F9CF5&background=EBF4FF&size=200";
    }

    /**
     * Get admin initials.
     */
    public function getInitials(): string
    {
        $firstName = strtoupper(substr($this->firstName ?? '', 0, 1));
        $lastName = strtoupper(substr($this->lastName ?? '', 0, 1));
        
        return $firstName . $lastName;
    }

    /**
     * Get profile image for small avatar display.
     */
    public function getProfileImageSmall(): string
    {
        if (!empty($this->avatar)) {
            return $this->getProfileImage();
        }
        
        $initials = $this->getInitials();
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) .
               "&color=7F9CF5&background=EBF4FF&size=64";
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }
}
