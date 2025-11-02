<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class AdminGroup extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'department',
        'group_leader_id',
        'parent_group_id',
        'settings',
        'is_active',
        'max_members',
        'target_amount',
        'region',
        'time_zone',
        'working_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'working_hours' => 'array',
        'max_members' => 'integer',
        'target_amount' => 'decimal:2',
    ];

    /**
     * Get the parent group.
     */
    public function parentGroup(): BelongsTo
    {
        return $this->belongsTo(AdminGroup::class, 'parent_group_id');
    }

    /**
     * Get the child groups.
     */
    public function childGroups(): HasMany
    {
        return $this->hasMany(AdminGroup::class, 'parent_group_id');
    }

    /**
     * Get all subordinate groups recursively.
     */
    public function subordinateGroups(): HasMany
    {
        return $this->hasMany(AdminGroup::class, 'parent_group_id')->with('subordinateGroups');
    }

    /**
     * Get the group leader.
     */
    public function groupLeader(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'group_leader_id');
    }

    /**
     * Get the admins in this group.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'admin_group_id');
    }

    /**
     * Get active admins in this group.
     */
    public function activeAdmins(): HasMany
    {
        return $this->hasMany(Admin::class, 'admin_group_id')->where('status', 'Active');
    }

    /**
     * Get available admins in this group.
     */
    public function availableAdmins(): HasMany
    {
        return $this->hasMany(Admin::class, 'admin_group_id')
                    ->where('is_available', true)
                    ->where('status', 'Active');
    }

    /**
     * Scope a query to only include active groups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by department.
     */
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to filter by region.
     */
    public function scopeByRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope a query to get groups with available capacity.
     */
    public function scopeWithCapacity($query)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM admins WHERE admin_group_id = admin_groups.id) < COALESCE(max_members, 999999)');
    }

    /**
     * Get the current member count.
     */
    public function getMemberCount(): int
    {
        return $this->admins()->count();
    }

    /**
     * Get the current active member count.
     */
    public function getActiveMemberCount(): int
    {
        return $this->activeAdmins()->count();
    }

    /**
     * Get available member count.
     */
    public function getAvailableMemberCount(): int
    {
        return $this->availableAdmins()->count();
    }

    /**
     * Check if group has capacity for new members.
     */
    public function hasCapacity(): bool
    {
        if (!$this->max_members) {
            return true;
        }
        
        return $this->getMemberCount() < $this->max_members;
    }

    /**
     * Get remaining capacity.
     */
    public function getRemainingCapacity(): ?int
    {
        if (!$this->max_members) {
            return null;
        }
        
        return max(0, $this->max_members - $this->getMemberCount());
    }

    /**
     * Get normalized timezone for Carbon compatibility.
     */
    private function getNormalizedTimezone(): string
    {
        $timezone = $this->time_zone ?? 'UTC';
        
        // Convert UTC offset format to timezone name
        $offsetMap = [
            'UTC+3' => 'Europe/Istanbul',
            'UTC+2' => 'Europe/Berlin',
            'UTC+1' => 'Europe/London',
            'UTC+0' => 'UTC',
            'UTC-5' => 'America/New_York',
            'UTC-8' => 'America/Los_Angeles'
        ];
        
        return $offsetMap[$timezone] ?? 'UTC';
    }

    /**
     * Check if group is currently in working hours.
     */
    public function isInWorkingHours(?Carbon $time = null): bool
    {
        try {
            $normalizedTimezone = $this->getNormalizedTimezone();
            $time = $time ?? Carbon::now($normalizedTimezone);
            $workingHours = $this->working_hours;

            if (!$workingHours || !isset($workingHours['start'], $workingHours['end'], $workingHours['days'])) {
                return true; // Default to always available
            }

            // Check if current day is a working day
            $currentDay = strtolower($time->format('l'));
            if (!in_array($currentDay, $workingHours['days'])) {
                return false;
            }

            // Check if current time is within working hours
            $startTime = Carbon::createFromTimeString($workingHours['start'], $normalizedTimezone);
            $endTime = Carbon::createFromTimeString($workingHours['end'], $normalizedTimezone);

            return $time->between($startTime, $endTime);
        } catch (\Exception $e) {
            // If timezone issues occur, default to available
            \Log::warning('AdminGroup timezone error: ' . $e->getMessage());
            return true;
        }
    }

    /**
     * Get the next working time for this group.
     */
    public function getNextWorkingTime(): ?Carbon
    {
        $workingHours = $this->working_hours;

        if (!$workingHours || !isset($workingHours['start'], $workingHours['days'])) {
            return null;
        }

        try {
            $normalizedTimezone = $this->getNormalizedTimezone();
            $now = Carbon::now($normalizedTimezone);
            
            // Try the next 7 days
            for ($i = 0; $i < 7; $i++) {
                $checkDate = $now->copy()->addDays($i);
                $dayName = strtolower($checkDate->format('l'));
                
                if (in_array($dayName, $workingHours['days'])) {
                    $workStart = $checkDate->copy()->setTimeFromTimeString($workingHours['start']);
                    
                    if ($i === 0 && $workStart > $now) {
                        return $workStart; // Today but later
                    } elseif ($i > 0) {
                        return $workStart; // Future day
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('AdminGroup timezone error in getNextWorkingTime: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get group performance metrics.
     */
    public function getPerformanceMetrics(Carbon $startDate = null, Carbon $endDate = null): array
    {
        $startDate = $startDate ?? Carbon::now()->subMonth();
        $endDate = $endDate ?? Carbon::now();

        $admins = $this->admins;
        
        return [
            'total_members' => $admins->count(),
            'active_members' => $admins->where('status', 'Active')->count(),
            'total_leads_assigned' => $admins->sum('leads_assigned_count'),
            'total_leads_converted' => $admins->sum('leads_converted_count'),
            'average_performance' => $admins->avg('current_performance'),
            'target_achievement' => $this->target_amount ? 
                ($admins->sum('current_performance') / $this->target_amount * 100) : 0,
        ];
    }

    /**
     * Get the best performing admin in the group.
     */
    public function getBestPerformer(): ?Admin
    {
        return $this->admins()
                    ->where('status', 'Active')
                    ->orderByDesc('current_performance')
                    ->first();
    }

    /**
     * Get admins with lowest workload for assignment.
     */
    public function getAdminsForAssignment(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return $this->availableAdmins()
                    ->orderBy('leads_assigned_count')
                    ->orderByDesc('current_performance')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Assign admin to this group.
     */
    public function assignAdmin(Admin $admin): bool
    {
        if (!$this->hasCapacity()) {
            return false;
        }

        $admin->admin_group_id = $this->id;
        return $admin->save();
    }

    /**
     * Remove admin from this group.
     */
    public function removeAdmin(Admin $admin): bool
    {
        if ($admin->admin_group_id !== $this->id) {
            return false;
        }

        $admin->admin_group_id = null;
        return $admin->save();
    }

    /**
     * Update group settings.
     */
    public function updateSettings(array $newSettings): bool
    {
        $currentSettings = $this->settings ?? [];
        $this->settings = array_merge($currentSettings, $newSettings);
        
        return $this->save();
    }

    /**
     * Get a specific setting value.
     */
    public function getSetting(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    /**
     * Set working hours for the group.
     */
    public function setWorkingHours(string $start, string $end, array $days): bool
    {
        $this->working_hours = [
            'start' => $start,
            'end' => $end,
            'days' => $days,
        ];
        
        return $this->save();
    }

    /**
     * Check if this group can be managed by a specific role.
     */
    public function canBeManagedBy(Role $role): bool
    {
        // Super admin can manage all groups
        if ($role->isSuperAdmin()) {
            return true;
        }

        // Check department-based access
        $roleDepartment = $role->getSetting('department');
        if ($roleDepartment && $roleDepartment !== $this->department) {
            return false;
        }

        return $role->isManagementRole();
    }

    /**
     * Get display name for the group.
     */
    public function getDisplayName(): string
    {
        return $this->display_name ?: ucwords(str_replace('_', ' ', $this->name));
    }

    /**
     * Get full hierarchy path.
     */
    public function getHierarchyPath(): string
    {
        $path = [$this->getDisplayName()];
        
        $parent = $this->parentGroup;
        while ($parent) {
            array_unshift($path, $parent->getDisplayName());
            $parent = $parent->parentGroup;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }
}