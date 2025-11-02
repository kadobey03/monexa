<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminCacheService
{
    protected string $cachePrefix = 'admin_dropdown_';
    protected int $cacheTtl = 300; // 5 minutes

    /**
     * Get assignable admins with caching.
     */
    public function getAssignableAdmins(Admin $currentAdmin): array
    {
        $cacheKey = $this->getCacheKey('assignable', $currentAdmin->id);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function() use ($currentAdmin) {
            return $this->buildAssignableAdminsList($currentAdmin);
        });
    }

    /**
     * Get all active admins with caching.
     */
    public function getAllActiveAdmins(): array
    {
        $cacheKey = $this->getCacheKey('all_active');
        
        return Cache::remember($cacheKey, $this->cacheTtl, function() {
            return $this->buildAllActiveAdminsList();
        });
    }

    /**
     * Build assignable admins list with optimized queries.
     */
    protected function buildAssignableAdminsList(Admin $currentAdmin): array
    {
        $isSuperAdmin = $currentAdmin->isSuperAdmin() || $currentAdmin->type === 'Super Admin';
        
        if ($isSuperAdmin) {
            // Super admin can assign to anyone
            $admins = Admin::with(['role:id,name,display_name'])
                ->where('status', 'Active')
                ->select([
                    'id', 'firstName', 'lastName', 'email', 'role_id', 
                    'department', 'leads_assigned_count', 'max_leads_per_day',
                    'is_available', 'hierarchy_level', 'position'
                ])
                ->orderBy('firstName')
                ->orderBy('lastName')
                ->get();
        } else {
            // Non-super admin - get subordinates and self
            $allowedAdminIds = $this->getAllowedAdminIds($currentAdmin);
            
            $admins = Admin::with(['role:id,name,display_name'])
                ->whereIn('id', $allowedAdminIds)
                ->where('status', 'Active')
                ->select([
                    'id', 'firstName', 'lastName', 'email', 'role_id', 
                    'department', 'leads_assigned_count', 'max_leads_per_day',
                    'is_available', 'hierarchy_level', 'position'
                ])
                ->orderBy('firstName')
                ->orderBy('lastName')
                ->get();
        }

        return $this->formatAdminsForDropdown($admins);
    }

    /**
     * Build all active admins list with optimized queries.
     */
    protected function buildAllActiveAdminsList(): array
    {
        $admins = Admin::with(['role:id,name,display_name'])
            ->where('status', 'Active')
            ->select([
                'id', 'firstName', 'lastName', 'email', 'role_id', 
                'department', 'leads_assigned_count', 'max_leads_per_day',
                'is_available', 'hierarchy_level', 'position'
            ])
            ->orderBy('firstName')
            ->orderBy('lastName')
            ->get();

        return $this->formatAdminsForDropdown($admins);
    }

    /**
     * Get allowed admin IDs for current admin.
     */
    protected function getAllowedAdminIds(Admin $currentAdmin): array
    {
        $allowedIds = collect([$currentAdmin->id]);
        
        // Add direct subordinates
        $subordinateIds = Admin::where('supervisor_id', $currentAdmin->id)
            ->where('status', 'Active')
            ->pluck('id');
        
        $allowedIds = $allowedIds->merge($subordinateIds);
        
        // Add indirect subordinates (team members under this admin)
        if ($currentAdmin->subordinate_ids) {
            $indirectSubordinates = Admin::whereIn('id', $currentAdmin->subordinate_ids)
                ->where('status', 'Active')
                ->pluck('id');
            
            $allowedIds = $allowedIds->merge($indirectSubordinates);
        }
        
        return $allowedIds->unique()->values()->toArray();
    }

    /**
     * Format admins collection for dropdown.
     */
    protected function formatAdminsForDropdown($admins): array
    {
        return $admins->map(function($admin) {
            $capacity = $this->calculateCapacity($admin);
            
            return [
                'id' => $admin->id,
                'name' => trim($admin->firstName . ' ' . $admin->lastName),
                'email' => $admin->email,
                'role' => [
                    'id' => $admin->role?->id,
                    'name' => $admin->role?->name ?? 'No Role',
                    'display_name' => $admin->role?->display_name ?? 'No Role'
                ],
                'department' => $admin->department,
                'position' => $admin->position,
                'hierarchy_level' => $admin->hierarchy_level,
                'is_available' => (bool) $admin->is_available,
                'capacity' => $capacity,
                'status_indicator' => $this->getStatusIndicator($admin, $capacity),
                'initials' => $this->getInitials($admin->firstName, $admin->lastName),
                'has_capacity' => $capacity['remaining'] > 0
            ];
        })->toArray();
    }

    /**
     * Calculate admin capacity.
     */
    protected function calculateCapacity($admin): array
    {
        $maxLeads = $admin->max_leads_per_day ?: 50;
        $currentLeads = $admin->leads_assigned_count ?: 0;
        $remaining = max(0, $maxLeads - $currentLeads);
        $percentage = $maxLeads > 0 ? round(($currentLeads / $maxLeads) * 100, 1) : 0;
        
        return [
            'max' => $maxLeads,
            'current' => $currentLeads,
            'remaining' => $remaining,
            'percentage' => $percentage,
            'status' => $this->getCapacityStatus($percentage)
        ];
    }

    /**
     * Get capacity status.
     */
    protected function getCapacityStatus(float $percentage): string
    {
        if ($percentage >= 100) {
            return 'full';
        } elseif ($percentage >= 80) {
            return 'high';
        } elseif ($percentage >= 50) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Get status indicator for admin.
     */
    protected function getStatusIndicator($admin, array $capacity): array
    {
        if (!$admin->is_available) {
            return [
                'status' => 'unavailable',
                'color' => 'red',
                'text' => 'Müsait Değil',
                'icon' => 'circle-slash'
            ];
        }
        
        switch ($capacity['status']) {
            case 'full':
                return [
                    'status' => 'full',
                    'color' => 'red',
                    'text' => 'Kapasitesi Dolu',
                    'icon' => 'exclamation-triangle'
                ];
            case 'high':
                return [
                    'status' => 'high',
                    'color' => 'orange',
                    'text' => 'Kapasitesi Yüksek',
                    'icon' => 'exclamation-circle'
                ];
            case 'medium':
                return [
                    'status' => 'medium',
                    'color' => 'yellow',
                    'text' => 'Kapasitesi Orta',
                    'icon' => 'clock'
                ];
            default:
                return [
                    'status' => 'available',
                    'color' => 'green',
                    'text' => 'Müsait',
                    'icon' => 'check-circle'
                ];
        }
    }

    /**
     * Get admin initials.
     */
    protected function getInitials(string $firstName = '', string $lastName = ''): string
    {
        $first = strtoupper(substr($firstName, 0, 1));
        $last = strtoupper(substr($lastName, 0, 1));
        
        return $first . $last;
    }

    /**
     * Clear cache for specific admin.
     */
    public function clearAdminCache(int $adminId): void
    {
        $patterns = [
            $this->getCacheKey('assignable', $adminId),
            $this->getCacheKey('all_active'),
            // Clear subordinates' cache too since hierarchy might have changed
            $this->getCacheKey('assignable', '*')
        ];
        
        foreach ($patterns as $pattern) {
            if (str_contains($pattern, '*')) {
                // For wildcard patterns, we need to flush all related keys
                $this->clearCacheByPattern($pattern);
            } else {
                Cache::forget($pattern);
            }
        }
        
        Log::info('Admin dropdown cache cleared', [
            'admin_id' => $adminId,
            'cache_patterns' => $patterns
        ]);
    }

    /**
     * Clear all admin dropdown cache.
     */
    public function clearAllCache(): void
    {
        $this->clearCacheByPattern($this->cachePrefix . '*');
        
        Log::info('All admin dropdown cache cleared');
    }

    /**
     * Clear cache by pattern (Redis specific).
     */
    protected function clearCacheByPattern(string $pattern): void
    {
        try {
            // Check if we're using Redis
            if (config('cache.default') === 'redis') {
                $redis = Cache::getRedis();
                $keys = $redis->keys($pattern);
                
                if (!empty($keys)) {
                    $redis->del($keys);
                }
            } else {
                // For other cache drivers, we'll need to implement differently
                // For now, just clear the main cache keys
                Cache::forget($this->getCacheKey('all_active'));
            }
        } catch (\Exception $e) {
            Log::warning('Failed to clear cache by pattern', [
                'pattern' => $pattern,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate cache key.
     */
    protected function getCacheKey(string $type, int $adminId = null): string
    {
        $key = $this->cachePrefix . $type;
        
        if ($adminId) {
            $key .= '_' . $adminId;
        }
        
        return $key;
    }

    /**
     * Get cache statistics.
     */
    public function getCacheStats(): array
    {
        return [
            'prefix' => $this->cachePrefix,
            'ttl_seconds' => $this->cacheTtl,
            'ttl_minutes' => $this->cacheTtl / 60,
            'driver' => config('cache.default'),
            'last_cleared' => Cache::get($this->cachePrefix . 'last_cleared'),
        ];
    }
}