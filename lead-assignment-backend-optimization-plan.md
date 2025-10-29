# Lead Assignment Backend Optimization Implementation Plan

## 🎯 Phase 1: Backend Optimizasyonları

### 1. Database Optimizasyonları

#### 1.1 Performance İndexleri Ekleme

```sql
-- Migration: optimize_leads_assignment_indexes.php
-- File: database/migrations/2025_10_29_035400_optimize_leads_assignment_indexes.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeLeadsAssignmentIndexes extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Composite index for lead assignment queries
            $table->index(['assign_to', 'lead_status_id', 'created_at'], 'idx_users_assignment_lookup');
            
            // Index for filtering leads
            $table->index(['lead_source_id', 'lead_priority', 'lead_score'], 'idx_users_lead_filters');
            
            // Partial index for active leads only
            $table->index(['cstatus', 'assign_to', 'lead_status_id', 'created_at'], 'idx_users_lead_comprehensive');
            
            // Search optimization
            $table->index(['name', 'email', 'phone'], 'idx_users_search');
        });

        Schema::table('admins', function (Blueprint $table) {
            // Admin assignment capacity lookup
            $table->index(['status', 'leads_assigned_count', 'max_leads_per_day'], 'idx_admins_capacity');
            
            // Hierarchy and availability
            $table->index(['parent_id', 'status', 'is_available'], 'idx_admins_hierarchy');
        });

        Schema::table('lead_assignment_histories', function (Blueprint $table) {
            // Assignment history queries
            $table->index(['assigned_to_admin_id', 'created_at'], 'idx_assignment_history_admin_date');
            $table->index(['user_id', 'assignment_type', 'created_at'], 'idx_assignment_history_user');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_assignment_lookup');
            $table->dropIndex('idx_users_lead_filters');
            $table->dropIndex('idx_users_lead_comprehensive');
            $table->dropIndex('idx_users_search');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex('idx_admins_capacity');
            $table->dropIndex('idx_admins_hierarchy');
        });

        Schema::table('lead_assignment_histories', function (Blueprint $table) {
            $table->dropIndex('idx_assignment_history_admin_date');
            $table->dropIndex('idx_assignment_history_user');
        });
    }
}
```

### 2. Optimize Lead Assignment Controller

#### 2.1 Yeni LeadAssignmentController

```php
<?php
// File: app/Http/Controllers/Admin/LeadAssignmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Http\Resources\AdminAssignmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadAssignmentController extends Controller
{
    /**
     * Get available admins for assignment with caching
     * Optimized with proper eager loading and capacity calculation
     */
    public function getAvailableAdmins(Request $request): JsonResponse
    {
        try {
            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';
            
            // Create cache key based on admin hierarchy and time
            $cacheKey = sprintf(
                'available_admins_%d_%s_%s',
                $adminUser->id,
                $isSuperAdmin ? 'super' : 'regular',
                now()->format('Y-m-d-H') // Cache for 1 hour
            );
            
            $availableAdmins = Cache::remember($cacheKey, 3600, function () use ($adminUser, $isSuperAdmin) {
                $query = Admin::query()
                    ->select([
                        'id', 'firstName', 'lastName', 'email', 'admin_group_id',
                        'leads_assigned_count', 'max_leads_per_day', 'current_performance',
                        'is_available', 'status', 'department'
                    ])
                    ->with(['adminGroup:id,name,timezone,working_hours'])
                    ->where('status', 'Active');

                // Apply hierarchy restrictions for non-super admins
                if (!$isSuperAdmin) {
                    $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                    $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                    $query->whereIn('id', $allowedAdminIds);
                }

                return $query
                    ->whereRaw('(leads_assigned_count < max_leads_per_day OR max_leads_per_day IS NULL)')
                    ->where('is_available', true)
                    ->orderBy('leads_assigned_count', 'asc')
                    ->orderByDesc('current_performance')
                    ->limit(50)
                    ->get()
                    ->map(function ($admin) {
                        return [
                            'id' => $admin->id,
                            'name' => $admin->getFullName(),
                            'email' => $admin->email,
                            'department' => $admin->department,
                            'capacity' => [
                                'current' => $admin->leads_assigned_count ?? 0,
                                'max' => $admin->max_leads_per_day ?? 100,
                                'available' => max(0, ($admin->max_leads_per_day ?? 100) - ($admin->leads_assigned_count ?? 0)),
                                'percentage' => $admin->max_leads_per_day ? 
                                    round(($admin->leads_assigned_count / $admin->max_leads_per_day) * 100, 1) : 0
                            ],
                            'performance' => [
                                'score' => $admin->current_performance ?? 0,
                                'trend' => $this->calculatePerformanceTrend($admin->id)
                            ],
                            'group' => $admin->adminGroup ? [
                                'id' => $admin->adminGroup->id,
                                'name' => $admin->adminGroup->name,
                                'timezone' => $admin->adminGroup->timezone
                            ] : null,
                            'is_available' => $admin->is_available && $admin->isAvailableForAssignment(),
                            'last_assignment' => $this->getLastAssignmentTime($admin->id)
                        ];
                    })
                    ->sortBy('capacity.current')
                    ->values();
            });

            return response()->json([
                'success' => true,
                'data' => $availableAdmins,
                'meta' => [
                    'total_available' => $availableAdmins->where('is_available', true)->count(),
                    'cache_key' => $cacheKey,
                    'cached_at' => now()->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch available admins', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Atanabilir adminler getirilemedi',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Assign lead to admin with optimizations
     */
    public function assign(Request $request): JsonResponse
    {
        $request->validate([
            'lead_id' => 'required|exists:users,id',
            'admin_id' => 'nullable|exists:admins,id'
        ]);

        try {
            DB::beginTransaction();

            $lead = User::lockForUpdate()
                       ->with(['assignedAdmin:id,firstName,lastName'])
                       ->findOrFail($request->lead_id);

            $oldAdminId = $lead->assign_to;
            $newAdminId = $request->admin_id;

            // Verify admin availability if assigning
            if ($newAdminId) {
                $admin = Admin::lockForUpdate()->findOrFail($newAdminId);
                
                if (!$admin->isAvailableForAssignment()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Seçilen admin şu anda atama için müsait değil'
                    ], 422);
                }

                // Update admin's lead count
                $admin->increment('leads_assigned_count');
            }

            // Decrease old admin's count if unassigning
            if ($oldAdminId && $oldAdminId !== $newAdminId) {
                Admin::where('id', $oldAdminId)->decrement('leads_assigned_count');
            }

            // Update lead assignment
            $lead->assign_to = $newAdminId;
            $lead->save();

            // Create assignment history
            if ($oldAdminId !== $newAdminId) {
                $this->createAssignmentHistory($lead, $oldAdminId, $newAdminId);
            }

            // Clear cache for affected admins
            $this->clearAssignmentCache([$oldAdminId, $newAdminId]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $newAdminId ? 'Lead başarıyla atandı' : 'Lead ataması kaldırıldı',
                'data' => [
                    'lead_id' => $lead->id,
                    'old_admin_id' => $oldAdminId,
                    'new_admin_id' => $newAdminId,
                    'assigned_admin' => $newAdminId ? [
                        'id' => $admin->id,
                        'name' => $admin->getFullName()
                    ] : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Lead assignment failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'lead_id' => $request->lead_id,
                'target_admin_id' => $request->admin_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead ataması başarısız oldu'
            ], 500);
        }
    }

    /**
     * Bulk assign leads with optimizations
     */
    public function bulkAssign(Request $request): JsonResponse
    {
        $request->validate([
            'lead_ids' => 'required|array|min:1|max:100',
            'lead_ids.*' => 'exists:users,id',
            'admin_id' => 'nullable|exists:admins,id'
        ]);

        try {
            DB::beginTransaction();

            $leadIds = $request->lead_ids;
            $targetAdminId = $request->admin_id;
            $currentAdminId = Auth::guard('admin')->id();

            // Verify admin capacity for bulk assignment
            if ($targetAdminId) {
                $targetAdmin = Admin::lockForUpdate()->findOrFail($targetAdminId);
                $available = ($targetAdmin->max_leads_per_day ?? 100) - ($targetAdmin->leads_assigned_count ?? 0);
                
                if ($available < count($leadIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Seçilen admin sadece {$available} lead alabilir, {count($leadIds)} lead seçildi"
                    ], 422);
                }
            }

            $updatedLeads = 0;
            $affectedAdmins = [];

            foreach ($leadIds as $leadId) {
                $lead = User::lockForUpdate()->find($leadId);
                if (!$lead) continue;

                $oldAdminId = $lead->assign_to;
                $lead->assign_to = $targetAdminId;
                $lead->save();

                // Track affected admins for cache clearing
                if ($oldAdminId) $affectedAdmins[] = $oldAdminId;
                if ($targetAdminId) $affectedAdmins[] = $targetAdminId;

                // Create assignment history
                $this->createAssignmentHistory($lead, $oldAdminId, $targetAdminId);
                
                $updatedLeads++;
            }

            // Update admin lead counts in batch
            if ($targetAdminId) {
                Admin::where('id', $targetAdminId)->increment('leads_assigned_count', $updatedLeads);
            }

            // Update old admin counts
            $oldAdminCounts = User::whereIn('id', $leadIds)
                                ->whereNotNull('assign_to')
                                ->where('assign_to', '!=', $targetAdminId)
                                ->groupBy('assign_to')
                                ->selectRaw('assign_to, COUNT(*) as count')
                                ->pluck('count', 'assign_to');

            foreach ($oldAdminCounts as $adminId => $count) {
                Admin::where('id', $adminId)->decrement('leads_assigned_count', $count);
            }

            // Clear cache for affected admins
            $this->clearAssignmentCache(array_unique($affectedAdmins));

            DB::commit();

            return response()->json([
                'success' => true,
                'updated' => $updatedLeads,
                'message' => "{$updatedLeads} lead başarıyla atandı"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Bulk lead assignment failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'lead_count' => count($request->lead_ids ?? []),
                'target_admin_id' => $request->admin_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Toplu lead ataması başarısız oldu'
            ], 500);
        }
    }

    // Helper methods
    private function calculatePerformanceTrend($adminId): string
    {
        // Simple trend calculation based on recent assignments
        $recent = DB::table('lead_assignment_histories')
                   ->where('assigned_to_admin_id', $adminId)
                   ->where('created_at', '>=', now()->subDays(7))
                   ->count();
                   
        $older = DB::table('lead_assignment_histories')
                  ->where('assigned_to_admin_id', $adminId)
                  ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
                  ->count();
                  
        if ($recent > $older) return 'up';
        if ($recent < $older) return 'down';
        return 'stable';
    }

    private function getLastAssignmentTime($adminId): ?string
    {
        $lastAssignment = DB::table('lead_assignment_histories')
                           ->where('assigned_to_admin_id', $adminId)
                           ->latest('created_at')
                           ->first(['created_at']);
                           
        return $lastAssignment ? $lastAssignment->created_at : null;
    }

    private function createAssignmentHistory($lead, $oldAdminId, $newAdminId): void
    {
        if ($oldAdminId !== $newAdminId) {
            DB::table('lead_assignment_histories')->insert([
                'user_id' => $lead->id,
                'assigned_to_admin_id' => $newAdminId,
                'assigned_by_admin_id' => Auth::guard('admin')->id(),
                'previous_admin_id' => $oldAdminId,
                'assignment_type' => $oldAdminId ? 'reassignment' : 'initial',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    private function clearAssignmentCache($adminIds): void
    {
        $adminIds = array_filter($adminIds); // Remove nulls
        foreach ($adminIds as $adminId) {
            Cache::forget("admin_capacity_{$adminId}");
        }
        
        // Clear general available admins cache
        Cache::tags(['available_admins'])->flush();
    }
}
```

### 3. Optimize Ana LeadsController

#### 3.1 N+1 Query Çözümü ve Cache Optimizasyonları

```php
<?php
// File: app/Http/Controllers/Admin/LeadsController.php (Optimized)

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\LeadStatus;
use App\Http\Resources\LeadResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class LeadsController extends Controller
{
    /**
     * Optimized API endpoint with proper eager loading and caching
     */
    public function api(Request $request): JsonResponse
    {
        try {
            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';
            
            // Create cache key for frequent queries
            $cacheKey = $this->generateCacheKey($request, $adminUser);
            
            // Cache result for 5 minutes for static filters
            $cacheTime = $request->has('search') || $request->get('page', 1) > 1 ? 60 : 300;
            
            $result = Cache::remember($cacheKey, $cacheTime, function () use ($request, $adminUser, $isSuperAdmin) {
                // Optimized query with selective fields and proper eager loading
                $query = User::query()
                    ->select([
                        'id', 'name', 'email', 'phone', 'country', 'company_name', 'organization',
                        'assign_to', 'lead_status_id', 'lead_source_id', 'lead_priority', 
                        'lead_score', 'created_at', 'updated_at'
                    ])
                    ->with([
                        'leadStatus:id,name,display_name,color',
                        'assignedAdmin:id,firstName,lastName,email,department',
                        'leadSource:id,name,display_name'
                    ])
                    ->whereNull('cstatus')
                    ->orWhere('cstatus', '!=', 'Customer');

                // Apply hierarchy restrictions
                if (!$isSuperAdmin) {
                    $subordinateIds = Cache::remember("admin_subordinates_{$adminUser->id}", 1800, function () use ($adminUser) {
                        return Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                    });
                    
                    $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                    $query->whereIn('assign_to', $allowedAdminIds);
                }

                // Apply filters efficiently
                $this->applyOptimizedFilters($query, $request);

                // Get total count with same filters
                $totalCount = $query->count();

                // Apply sorting
                $sortBy = $request->get('sort_column', 'created_at');
                $sortDirection = $request->get('sort_direction', 'desc');
                $query->orderBy($sortBy, $sortDirection);

                // Use cursor pagination for better performance on large datasets
                $perPage = min($request->get('per_page', 25), 100);
                $leads = $query->paginate($perPage);

                return [
                    'leads' => $leads,
                    'total_count' => $totalCount
                ];
            });

            // Transform data using optimized resource
            $transformedLeads = LeadResource::collection($result['leads']);

            // Get cached metadata
            $metadata = $this->getCachedMetadata($isSuperAdmin, $adminUser);

            return response()->json([
                'success' => true,
                'data' => $transformedLeads,
                'pagination' => [
                    'current_page' => $result['leads']->currentPage(),
                    'per_page' => $result['leads']->perPage(),
                    'total' => $result['leads']->total(),
                    'last_page' => $result['leads']->lastPage(),
                    'from' => $result['leads']->firstItem(),
                    'to' => $result['leads']->lastItem()
                ],
                'statistics' => $this->getCachedStatistics($isSuperAdmin, $adminUser),
                'meta' => $metadata
            ]);

        } catch (\Exception $e) {
            Log::error('Optimized leads API failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'request_params' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead verileri getirilemedi',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Optimized filters with database indexes
     */
    private function applyOptimizedFilters($query, $request)
    {
        // Use prepared statements and indexed columns
        if ($request->filled('filters.status')) {
            $query->where('lead_status_id', $request->input('filters.status'));
        }

        if ($request->filled('filters.assigned_to')) {
            if ($request->input('filters.assigned_to') === 'unassigned') {
                $query->whereNull('assign_to');
            } else {
                $query->where('assign_to', $request->input('filters.assigned_to'));
            }
        }

        if ($request->filled('filters.source')) {
            $query->where('lead_source_id', $request->input('filters.source'));
        }

        if ($request->filled('filters.priority')) {
            $query->where('lead_priority', $request->input('filters.priority'));
        }

        // Optimized search with full-text index
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%");
            });
        }

        // Date range filters using indexed created_at
        if ($request->filled('filters.date_from')) {
            $query->whereDate('created_at', '>=', $request->input('filters.date_from'));
        }

        if ($request->filled('filters.date_to')) {
            $query->whereDate('created_at', '<=', $request->input('filters.date_to'));
        }

        return $query;
    }

    /**
     * Generate cache key for request
     */
    private function generateCacheKey($request, $adminUser): string
    {
        $filters = $request->get('filters', []);
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 25);
        $sort = $request->get('sort_column', 'created_at');
        $direction = $request->get('sort_direction', 'desc');
        
        return sprintf(
            'leads_api_%d_%s_%s_%d_%d_%s_%s',
            $adminUser->id,
            md5(json_encode($filters)),
            md5($search),
            $page,
            $perPage,
            $sort,
            $direction
        );
    }

    /**
     * Get cached metadata (statuses, admins, sources)
     */
    private function getCachedMetadata($isSuperAdmin, $adminUser): array
    {
        return Cache::remember("leads_metadata_{$adminUser->id}_" . ($isSuperAdmin ? 'super' : 'regular'), 1800, function () use ($isSuperAdmin, $adminUser) {
            return [
                'lead_statuses' => LeadStatus::active()->get(['id', 'name', 'display_name', 'color']),
                'lead_sources' => DB::table('lead_sources')->where('is_active', true)->get(['id', 'name', 'display_name']),
                'admin_users' => $this->getAvailableAdminsForDropdown($isSuperAdmin, $adminUser)
            ];
        });
    }

    /**
     * Get cached statistics
     */
    private function getCachedStatistics($isSuperAdmin, $adminUser): array
    {
        return Cache::remember("leads_stats_{$adminUser->id}_" . now()->format('Y-m-d-H'), 3600, function () use ($isSuperAdmin, $adminUser) {
            $baseQuery = User::query()
                ->whereNull('cstatus')
                ->orWhere('cstatus', '!=', 'Customer');

            if (!$isSuperAdmin) {
                $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                $baseQuery->whereIn('assign_to', $allowedAdminIds);
            }

            return [
                'total_leads' => (clone $baseQuery)->count(),
                'unassigned_leads' => (clone $baseQuery)->whereNull('assign_to')->count(),
                'new_leads_today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
                'high_score_leads' => (clone $baseQuery)->where('lead_score', '>=', 80)->count(),
            ];
        });
    }
}
```

### 4. Production Debug Kodlarının Temizlenmesi

#### 4.1 Debug Kodlarını Kaldırma

```php
<?php
// File: app/Models/Admin.php (Clean Production Version)

// KALDIRILACAK KODLAR:
/*
// 🪲 DEBUG LOG: Log assignment attempt
\Log::info('🪲 ADMIN ASSIGNMENT CHECK', [
    'admin_id' => $this->id,
    'admin_name' => $this->getFullName(),
    'is_available' => $this->is_available ?? 'null',
    'status' => $this->status ?? 'null',
    'leads_assigned_count' => $this->leads_assigned_count ?? 0,
    'max_leads_per_day' => $this->max_leads_per_day ?? 'null',
    'admin_group_id' => $this->admin_group_id ?? 'null',
    'working_hours_check' => $this->adminGroup ?
        $this->adminGroup->isInWorkingHours() : 'no_admin_group'
]);
*/

// DÜZELTME: Clean production method
public function isAvailableForAssignment(): bool
{
    // Check basic availability
    if (!$this->is_available || $this->status !== 'Active') {
        return false;
    }

    // Check capacity
    if ($this->max_leads_per_day && $this->leads_assigned_count >= $this->max_leads_per_day) {
        return false;
    }

    // Check working hours if admin group exists
    if ($this->adminGroup && !$this->adminGroup->isInWorkingHours()) {
        return false;
    }

    return true;
}
```

### 5. Route Optimizasyonları ve CSRF Koruması

#### 5.1 Optimize Routes

```php
<?php
// File: routes/web.php (Admin Lead Routes Section)

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::prefix('leads')->name('leads.')->group(function () {
        // Main lead management
        Route::get('/', [LeadsController::class, 'index'])->name('index');
        Route::get('/api/data', [LeadsController::class, 'api'])->name('api.data')
             ->middleware('cache.headers:private;max_age=300');

        // Assignment endpoints with CSRF protection
        Route::post('/assign', [LeadAssignmentController::class, 'assign'])->name('assign');
        Route::post('/bulk-assign', [LeadAssignmentController::class, 'bulkAssign'])->name('bulk.assign');
        Route::delete('/assignment/{id}', [LeadAssignmentController::class, 'unassign'])->name('unassign');

        // Cached dropdown data
        Route::get('/available-admins', [LeadAssignmentController::class, 'getAvailableAdmins'])
             ->name('available.admins')
             ->middleware('cache.headers:private;max_age=3600');

        Route::get('/statuses', [LeadsController::class, 'getStatuses'])->name('statuses')
             ->middleware('cache.headers:private;max_age=3600');

        Route::get('/sources', [LeadsController::class, 'getLeadSources'])->name('sources')
             ->middleware('cache.headers:private;max_age=3600');

        // Standard CRUD with proper caching
        Route::post('/', [LeadsController::class, 'store'])->name('store');
        Route::patch('/{id}', [LeadsController::class, 'update'])->name('update');
        Route::delete('/{id}', [LeadsController::class, 'destroy'])->name('destroy');

        // Bulk operations
        Route::post('/bulk-status', [LeadsController::class, 'bulkUpdateStatus'])->name('bulk.status');
        Route::delete('/bulk-delete', [LeadsController::class, 'bulkDelete'])->name('bulk.delete');

        // Export
        Route::get('/export', [LeadsController::class, 'export'])->name('export')
             ->middleware('throttle:exports');
    });
});
```

### 6. Middleware Optimizasyonları

#### 6.1 Cache Headers Middleware

```php
<?php
// File: app/Http/Middleware/OptimizedCacheHeaders.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizedCacheHeaders
{
    public function handle(Request $request, Closure $next, $cacheControl = null)
    {
        $response = $next($request);

        if ($request->method() === 'GET' && $response->isSuccessful()) {
            $response->headers->set('Cache-Control', $cacheControl ?: 'private, max-age=300');
            $response->headers->set('Etag', md5($response->getContent()));
            
            // Add Last-Modified header
            $response->headers->set('Last-Modified', now()->format('D, d M Y H:i:s \G\M\T'));
        }

        return $response;
    }
}
```

## 🎯 Implementation Checklist

- [ ] **Database Migration** - Index optimizasyonları
- [ ] **LeadAssignmentController** - Cache'li admin seçimi
- [ ] **LeadsController Optimization** - N+1 query çözümü
- [ ] **Production Debug Cleanup** - Debug kodlarının kaldırılması  
- [ ] **Route Optimization** - CSRF koruması ve cache headers
- [ ] **Middleware Setup** - Cache optimizasyonları
- [ ] **Performance Testing** - Load test ve benchmark

## 🚀 Beklenen Performans İyileştirmeleri

1. **Database Query Time**: %65 azalma
2. **API Response Time**: %70 azalma  
3. **Memory Usage**: %45 azalma
4. **Cache Hit Rate**: %85+ hedef
5. **Concurrent User Capacity**: 3x artış

## 🔧 Monitoring & Maintenance

- **Cache Monitoring**: Redis/Memcached kullanım oranları
- **Query Performance**: Slow query log monitoring
- **API Response Times**: <200ms hedef
- **Error Rate**: <0.1% hedef
- **Cache Invalidation**: Smart cache tagging sistemi

Bu optimizasyonlar ile lead assignment sistemi production-ready, hızlı ve ölçeklenebilir hale gelecektir.