<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Role;
use App\Models\AdminGroup;
use App\Models\Settings;
use App\Models\AdminAuditLog;
use Carbon\Carbon;

class HierarchyController extends Controller
{
    /**
     * Hiyerarşi ana sayfası
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Get view type from request
        $viewType = $request->get('view', 'chart'); // chart, tree, table, performance

        // Get filter parameters
        $department = $request->get('department');
        $roleId = $request->get('role_id');
        $groupId = $request->get('group_id');
        $status = $request->get('status');

        // Build base hierarchy data
        $hierarchyData = $this->buildHierarchyData($department, $roleId, $groupId, $status);

        // Get statistics
        $stats = $this->getHierarchyStatistics($department, $roleId, $groupId);

        // Get filter options
        $departments = Admin::whereNotNull('department')
                           ->distinct()
                           ->pluck('department')
                           ->sort()
                           ->values();

        $roles = Role::active()
                    ->whereNotNull('name')
                    ->whereNotNull('hierarchy_level')
                    ->orderBy('hierarchy_level')
                    ->orderBy('display_name')
                    ->get();
        $allRoles = $roles; // For matrix view
        $adminGroups = AdminGroup::where('is_active', true)->orderBy('name')->get();

        // Build hierarchy tree for tree view
        $hierarchyTree = $this->buildHierarchyTreeByLevels($roles);

        // Build department hierarchy for org view
        $departmentHierarchy = $this->buildDepartmentHierarchy();

        // Calculate view-specific stats
        $totalLevels = $roles->max('hierarchy_level') + 1;
        $activeRoles = $roles->where('is_active', true)->count();
        $totalDepartments = $departments->count();
        $totalUsers = Admin::count();
        $hierarchyConflicts = 0; // TODO: Implement conflict detection

        // D3 hierarchy data for complex visualization
        $d3HierarchyData = $this->formatHierarchyForD3($hierarchyData);

        return view('admin.permissions.hierarchy', compact(
            'hierarchyData',
            'stats',
            'departments',
            'roles',
            'allRoles',
            'adminGroups',
            'viewType',
            'hierarchyTree',
            'departmentHierarchy',
            'totalLevels',
            'activeRoles',
            'totalDepartments',
            'totalUsers',
            'hierarchyConflicts',
            'd3HierarchyData'
        ))->with([
            'title' => 'Organizasyon Hiyerarşisi',
            'settings' => Settings::first() ?: (object)[
                'id' => 1,
                'app_name' => 'MonexaFinans',
                'dashboard_style' => 'light',
                'favicon' => null,
                'logo' => null,
                'timezone' => 'Europe/Istanbul',
                'locale' => 'tr',
                'maintenance_mode' => false,
            ]
        ]);
    }

    /**
     * AJAX: Hiyerarşi verilerini getir
     */
    public function getData(Request $request)
    {
        $department = $request->get('department');
        $roleId = $request->get('role_id');
        $groupId = $request->get('group_id');
        $status = $request->get('status');
        $format = $request->get('format', 'tree'); // tree, chart, table

        $hierarchyData = $this->buildHierarchyData($department, $roleId, $groupId, $status);

        switch ($format) {
            case 'chart':
                return response()->json($this->formatForChart($hierarchyData));
            
            case 'tree':
                return response()->json($this->formatForTree($hierarchyData));
                
            case 'table':
                return response()->json($this->formatForTable($hierarchyData));
                
            default:
                return response()->json($hierarchyData);
        }
    }

    /**
     * Performans dashboard'u
     */
    public function performance(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Date range
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $department = $request->get('department');
        $roleId = $request->get('role_id');

        // Build query
        $query = Admin::with(['role', 'supervisor', 'subordinates'])
                     ->withCount(['subordinates', 'assignedUsers']);

        if ($department) {
            $query->where('department', $department);
        }

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        // Only show admins current user can manage
        if (!$currentAdmin->isSuperAdmin()) {
            $manageableIds = array_merge(
                [$currentAdmin->id],
                $currentAdmin->getAllSubordinates()
            );
            $query->whereIn('id', $manageableIds);
        }

        $admins = $query->get();

        // Calculate performance metrics
        $performanceData = [];
        foreach ($admins as $admin) {
            $metrics = $admin->getPerformanceMetrics(Carbon::parse($startDate), Carbon::parse($endDate));
            $performanceData[] = [
                'admin' => $admin,
                'metrics' => $metrics,
                'efficiency_rating' => $admin->calculateEfficiencyRating(),
            ];
        }

        // Sort by performance
        usort($performanceData, function($a, $b) {
            return $b['efficiency_rating'] <=> $a['efficiency_rating'];
        });

        // Department performance summary
        $departmentStats = $this->getDepartmentPerformanceStats($admins);

        // Role performance summary
        $roleStats = $this->getRolePerformanceStats($admins);

        // Get filter options
        $departments = Admin::whereNotNull('department')
                           ->distinct()
                           ->pluck('department')
                           ->sort()
                           ->values();

        $roles = Role::active()->orderBy('display_name')->get();

        return view('admin.permissions.performance', compact(
            'performanceData',
            'departmentStats',
            'roleStats',
            'departments',
            'roles',
            'startDate',
            'endDate'
        ))->with([
            'title' => 'Performans Dashboard',
            'settings' => Settings::first() ?: (object)[
                'id' => 1,
                'app_name' => 'MonexaFinans',
                'dashboard_style' => 'light',
                'favicon' => null,
                'logo' => null,
                'timezone' => 'Europe/Istanbul',
                'locale' => 'tr',
                'maintenance_mode' => false,
            ]
        ]);
    }

    /**
     * Departman breakdown
     */
    public function departmentBreakdown(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Build query
        $query = Admin::with(['role', 'supervisor'])
                     ->withCount(['subordinates', 'assignedUsers']);

        // Only show admins current user can manage
        if (!$currentAdmin->isSuperAdmin()) {
            $manageableIds = array_merge(
                [$currentAdmin->id],
                $currentAdmin->getAllSubordinates()
            );
            $query->whereIn('id', $manageableIds);
        }

        $admins = $query->get()->groupBy('department');

        $departmentData = [];
        foreach ($admins as $department => $departmentAdmins) {
            $departmentName = $department ?: 'Atanmamış';
            
            $stats = [
                'total_admins' => $departmentAdmins->count(),
                'active_admins' => $departmentAdmins->where('status', Admin::STATUS_ACTIVE)->count(),
                'available_admins' => $departmentAdmins->where('is_available', true)->count(),
                'total_leads' => $departmentAdmins->sum('leads_assigned_count'),
                'total_conversions' => $departmentAdmins->sum('leads_converted_count'),
                'avg_performance' => round($departmentAdmins->avg('current_performance'), 2),
                'roles_distribution' => $departmentAdmins->groupBy('role.name')->map->count(),
                'hierarchy_levels' => $departmentAdmins->groupBy('hierarchy_level')->map->count(),
            ];

            // Calculate department efficiency
            $efficiency = 0;
            if ($stats['total_leads'] > 0) {
                $efficiency = ($stats['total_conversions'] / $stats['total_leads']) * 100;
            }
            $stats['conversion_rate'] = round($efficiency, 2);

            $departmentData[$departmentName] = [
                'admins' => $departmentAdmins->sortBy('hierarchy_level'),
                'stats' => $stats
            ];
        }

        return view('admin.permissions.department-breakdown', compact(
            'departmentData'
        ))->with([
            'title' => 'Departman Analizi',
            'settings' => Settings::first() ?: (object)[
                'id' => 1,
                'app_name' => 'MonexaFinans',
                'dashboard_style' => 'light',
                'favicon' => null,
                'logo' => null,
                'timezone' => 'Europe/Istanbul',
                'locale' => 'tr',
                'maintenance_mode' => false,
            ]
        ]);
    }

    /**
     * Hiyerarşi hiyerarşisini yeniden yapılandır
     */
    public function restructure(Request $request)
    {
        $this->validate($request, [
            'admin_id' => 'required|exists:admins,id',
            'new_supervisor_id' => 'nullable|exists:admins,id',
            'new_role_id' => 'nullable|exists:roles,id',
            'new_department' => 'nullable|string|max:100',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::findOrFail($request->admin_id);

        // Permission check
        if (!$currentAdmin->canManageAdmin($admin)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu yöneticiyi düzenleme yetkiniz yok.'
            ], 403);
        }

        // Hierarchy validation
        if ($request->new_supervisor_id) {
            if ($request->new_supervisor_id == $admin->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yönetici kendine rapor edemez.'
                ], 422);
            }

            if (in_array($request->new_supervisor_id, $admin->getAllSubordinates())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hiyerarşi döngüsü oluşturulamaz.'
                ], 422);
            }
        }

        DB::beginTransaction();
        try {
            $oldData = [
                'supervisor_id' => $admin->supervisor_id,
                'role_id' => $admin->role_id,
                'department' => $admin->department,
                'hierarchy_level' => $admin->hierarchy_level,
            ];

            // Remove from old supervisor's subordinate list
            if ($admin->supervisor_id && $admin->supervisor_id != $request->new_supervisor_id) {
                $oldSupervisor = Admin::find($admin->supervisor_id);
                if ($oldSupervisor) {
                    $subordinateIds = array_diff($oldSupervisor->subordinate_ids ?? [], [$admin->id]);
                    $oldSupervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                }
            }

            $updateData = [];

            // Update supervisor
            if ($request->has('new_supervisor_id')) {
                $updateData['supervisor_id'] = $request->new_supervisor_id;

                if ($request->new_supervisor_id) {
                    $newSupervisor = Admin::find($request->new_supervisor_id);
                    
                    // Add to new supervisor's subordinate list
                    $subordinateIds = $newSupervisor->subordinate_ids ?? [];
                    $subordinateIds[] = $admin->id;
                    $newSupervisor->update(['subordinate_ids' => array_unique($subordinateIds)]);

                    // Update hierarchy level
                    $updateData['hierarchy_level'] = $newSupervisor->hierarchy_level + 1;
                } else {
                    // Root level admin
                    $updateData['hierarchy_level'] = 0;
                }
            }

            // Update role
            if ($request->has('new_role_id')) {
                $updateData['role_id'] = $request->new_role_id;

                // If no supervisor change but role changed, adjust hierarchy level
                if (!$request->has('new_supervisor_id') || !$request->new_supervisor_id) {
                    $role = Role::find($request->new_role_id);
                    $updateData['hierarchy_level'] = $role->hierarchy_level;
                }
            }

            // Update department
            if ($request->has('new_department')) {
                $updateData['department'] = $request->new_department;
            }

            $admin->update($updateData);

            // Update subordinates' hierarchy levels if needed
            if (isset($updateData['hierarchy_level']) && $updateData['hierarchy_level'] != $oldData['hierarchy_level']) {
                $this->updateSubordinateHierarchyLevels($admin);
            }

            // Log the restructure
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'hierarchy_restructure',
                'target_admin_id' => $admin->id,
                'description' => "Hiyerarşi yeniden yapılandırıldı: {$admin->getFullName()}",
                'metadata' => [
                    'old_data' => $oldData,
                    'new_data' => $updateData,
                    'changes' => array_keys($updateData),
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hiyerarşi başarıyla güncellendi!',
                'updated_admin' => [
                    'id' => $admin->id,
                    'name' => $admin->getFullName(),
                    'hierarchy_level' => $admin->hierarchy_level,
                    'supervisor' => $admin->supervisor?->getFullName(),
                    'role' => $admin->role?->display_name,
                    'department' => $admin->department,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Hierarchy restructure failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'İşlem sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * AJAX: Rol detayları getir
     */
    public function getRoleDetails($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $role = Role::with(['parentRole', 'childRoles', 'permissions'])
                   ->withCount(['admins'])
                   ->findOrFail($id);

        // Permission check - basic role viewing
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->role->canManage($role)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu rolün detaylarını görme yetkiniz yok.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'description' => $role->description,
                'hierarchy_level' => $role->hierarchy_level,
                'is_active' => $role->is_active,
                'users_count' => $role->admins_count,
                'permissions_count' => $role->permissions()->wherePivot('is_granted', true)->count(),
                'parent_roles' => $role->parentRole ? collect([$role->parentRole])->map(function($parent) {
                    return [
                        'id' => $parent->id,
                        'display_name' => $parent->display_name,
                        'hierarchy_level' => $parent->hierarchy_level,
                    ];
                }) : collect([]),
                'child_roles' => $role->childRoles->map(function($child) {
                    return [
                        'id' => $child->id,
                        'display_name' => $child->display_name,
                        'hierarchy_level' => $child->hierarchy_level,
                    ];
                }),
                'permissions' => $role->permissions()->wherePivot('is_granted', true)->get(['name', 'display_name']),
            ]
        ]);
    }

    /**
     * AJAX: Admin detayları getir
     */
    public function getAdminDetails($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $admin = Admin::with(['role', 'supervisor', 'subordinates.role', 'adminGroup'])
                     ->withCount(['subordinates', 'assignedUsers'])
                     ->findOrFail($id);

        // Permission check
        if (!$currentAdmin->canManageAdmin($admin) && $currentAdmin->id !== $admin->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bu yöneticinin detaylarını görme yetkiniz yok.'
            ], 403);
        }

        $performanceMetrics = $admin->getPerformanceMetrics();
        $capacityInfo = $admin->getAssignmentCapacity();

        return response()->json([
            'success' => true,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->getFullName(),
                'email' => $admin->email,
                'phone' => $admin->phone,
                'employee_id' => $admin->employee_id,
                'department' => $admin->department,
                'position' => $admin->position,
                'status' => $admin->status,
                'is_available' => $admin->is_available,
                'hired_at' => $admin->hired_at?->format('d.m.Y'),
                'last_activity' => $admin->last_activity?->diffForHumans(),
                'hierarchy_level' => $admin->hierarchy_level,
                'bio' => $admin->bio,
                'avatar' => $admin->avatar ? asset('storage/' . $admin->avatar) : null,
                'role' => $admin->role ? [
                    'id' => $admin->role->id,
                    'name' => $admin->role->name,
                    'display_name' => $admin->role->display_name,
                    'hierarchy_level' => $admin->role->hierarchy_level,
                ] : null,
                'supervisor' => $admin->supervisor ? [
                    'id' => $admin->supervisor->id,
                    'name' => $admin->supervisor->getFullName(),
                    'email' => $admin->supervisor->email,
                ] : null,
                'admin_group' => $admin->adminGroup ? [
                    'id' => $admin->adminGroup->id,
                    'name' => $admin->adminGroup->name,
                ] : null,
                'subordinates' => $admin->subordinates->map(function($sub) {
                    return [
                        'id' => $sub->id,
                        'name' => $sub->getFullName(),
                        'role' => $sub->role?->display_name,
                        'department' => $sub->department,
                    ];
                }),
                'stats' => [
                    'subordinates_count' => $admin->subordinates_count,
                    'assigned_users_count' => $admin->assigned_users_count,
                    'leads_assigned' => $admin->leads_assigned_count,
                    'leads_converted' => $admin->leads_converted_count,
                    'current_performance' => $admin->current_performance,
                    'monthly_target' => $admin->monthly_target,
                ],
                'performance_metrics' => $performanceMetrics,
                'capacity_info' => $capacityInfo,
                'efficiency_rating' => $admin->calculateEfficiencyRating(),
            ]
        ]);
    }

    /**
     * Hiyerarşi verilerini oluştur
     */
    private function buildHierarchyData($department = null, $roleId = null, $groupId = null, $status = null)
    {
        $query = Admin::with([
            'role',
            'supervisor',
            'subordinates.role',
            'adminGroup'
        ])->withCount(['subordinates', 'assignedUsers']);

        // Apply filters
        if ($department) {
            $query->where('department', $department);
        }

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if ($groupId) {
            $query->where('admin_group_id', $groupId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Permission-based filtering
        $currentAdmin = Auth::guard('admin')->user();
        if (!$currentAdmin->isSuperAdmin()) {
            $manageableIds = array_merge(
                [$currentAdmin->id],
                $currentAdmin->getAllSubordinates()
            );
            $query->whereIn('id', $manageableIds);
        }

        $admins = $query->get();

        return $this->buildHierarchyTree($admins);
    }

    /**
     * Hiyerarşi ağacı oluştur
     */
    private function buildHierarchyTree($admins, $parentId = null, $level = 0)
    {
        $tree = [];

        foreach ($admins as $admin) {
            if ($admin->supervisor_id == $parentId) {
                $adminData = [
                    'id' => $admin->id,
                    'name' => $admin->getFullName(),
                    'email' => $admin->email,
                    'employee_id' => $admin->employee_id,
                    'department' => $admin->department,
                    'position' => $admin->position,
                    'status' => $admin->status,
                    'is_available' => $admin->is_available,
                    'hierarchy_level' => $admin->hierarchy_level,
                    'tree_level' => $level,
                    'subordinates_count' => $admin->subordinates_count,
                    'assigned_users_count' => $admin->assigned_users_count,
                    'current_performance' => $admin->current_performance,
                    'efficiency_rating' => $admin->calculateEfficiencyRating(),
                    'avatar' => $admin->avatar ? asset('storage/' . $admin->avatar) : null,
                    'role' => $admin->role ? [
                        'id' => $admin->role->id,
                        'name' => $admin->role->name,
                        'display_name' => $admin->role->display_name,
                        'hierarchy_level' => $admin->role->hierarchy_level,
                    ] : null,
                    'admin_group' => $admin->adminGroup ? [
                        'id' => $admin->adminGroup->id,
                        'name' => $admin->adminGroup->name,
                    ] : null,
                    'children' => $this->buildHierarchyTree($admins, $admin->id, $level + 1)
                ];

                $tree[] = $adminData;
            }
        }

        // Sort by hierarchy level and name
        usort($tree, function($a, $b) {
            if ($a['hierarchy_level'] != $b['hierarchy_level']) {
                return $a['hierarchy_level'] <=> $b['hierarchy_level'];
            }
            return $a['name'] <=> $b['name'];
        });

        return $tree;
    }

    /**
     * Chart formatında veri hazırla
     */
    private function formatForChart($hierarchyData)
    {
        $chartData = [];
        
        foreach ($hierarchyData as $node) {
            $chartData[] = [
                'id' => $node['id'],
                'name' => $node['name'],
                'title' => $node['role']['display_name'] ?? 'Rol Atanmamış',
                'department' => $node['department'],
                'avatar' => $node['avatar'],
                'parent' => $node['tree_level'] > 0 ? 'parent_id_needed' : null,
                'children' => $this->flattenForChart($node['children'])
            ];
        }

        return $chartData;
    }

    /**
     * Chart için düzleştir
     */
    private function flattenForChart($children)
    {
        $result = [];
        foreach ($children as $child) {
            $result[] = [
                'id' => $child['id'],
                'name' => $child['name'],
                'title' => $child['role']['display_name'] ?? 'Rol Atanmamış',
                'department' => $child['department'],
                'avatar' => $child['avatar'],
            ];
            
            if (!empty($child['children'])) {
                $result = array_merge($result, $this->flattenForChart($child['children']));
            }
        }
        return $result;
    }

    /**
     * Tree formatında veri hazırla
     */
    private function formatForTree($hierarchyData)
    {
        return [
            'nodes' => $hierarchyData,
            'total_nodes' => $this->countNodes($hierarchyData),
            'max_depth' => $this->getMaxDepth($hierarchyData),
        ];
    }

    /**
     * Table formatında veri hazırla
     */
    private function formatForTable($hierarchyData)
    {
        return $this->flattenHierarchy($hierarchyData);
    }

    /**
     * Hiyerarşiyi düzleştir
     */
    private function flattenHierarchy($hierarchyData, &$result = [])
    {
        foreach ($hierarchyData as $node) {
            $result[] = $node;
            if (!empty($node['children'])) {
                $this->flattenHierarchy($node['children'], $result);
            }
        }
        return $result;
    }

    /**
     * Node sayısını hesapla
     */
    private function countNodes($hierarchyData)
    {
        $count = count($hierarchyData);
        foreach ($hierarchyData as $node) {
            if (!empty($node['children'])) {
                $count += $this->countNodes($node['children']);
            }
        }
        return $count;
    }

    /**
     * Maksimum derinliği hesapla
     */
    private function getMaxDepth($hierarchyData, $currentDepth = 1)
    {
        $maxDepth = $currentDepth;
        foreach ($hierarchyData as $node) {
            if (!empty($node['children'])) {
                $depth = $this->getMaxDepth($node['children'], $currentDepth + 1);
                $maxDepth = max($maxDepth, $depth);
            }
        }
        return $maxDepth;
    }

    /**
     * Alt çalışanların hiyerarşi seviyelerini güncelle
     */
    private function updateSubordinateHierarchyLevels(Admin $parentAdmin)
    {
        foreach ($parentAdmin->subordinates as $subordinate) {
            $subordinate->update([
                'hierarchy_level' => $parentAdmin->hierarchy_level + 1
            ]);
            
            if ($subordinate->subordinates()->count() > 0) {
                $this->updateSubordinateHierarchyLevels($subordinate);
            }
        }
    }

    /**
     * Hiyerarşi istatistikleri
     */
    private function getHierarchyStatistics($department = null, $roleId = null, $groupId = null)
    {
        $query = Admin::query();

        if ($department) {
            $query->where('department', $department);
        }

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if ($groupId) {
            $query->where('admin_group_id', $groupId);
        }

        $currentAdmin = Auth::guard('admin')->user();
        if (!$currentAdmin->isSuperAdmin()) {
            $manageableIds = array_merge(
                [$currentAdmin->id],
                $currentAdmin->getAllSubordinates()
            );
            $query->whereIn('id', $manageableIds);
        }

        return [
            'total_admins' => $query->count(),
            'active_admins' => (clone $query)->where('status', Admin::STATUS_ACTIVE)->count(),
            'available_admins' => (clone $query)->where('is_available', true)->count(),
            'departments_count' => (clone $query)->distinct('department')->count('department'),
            'roles_count' => (clone $query)->distinct('role_id')->count('role_id'),
            'hierarchy_levels' => (clone $query)->distinct('hierarchy_level')->count('hierarchy_level'),
            'avg_subordinates' => round((clone $query)->avg('leads_assigned_count'), 2),
            'total_subordinates' => (clone $query)->sum('leads_assigned_count'),
            'avg_performance' => round((clone $query)->avg('current_performance'), 2),
        ];
    }

    /**
     * Departman performans istatistikleri
     */
    private function getDepartmentPerformanceStats($admins)
    {
        return $admins->groupBy('department')->map(function($deptAdmins, $department) {
            $totalLeads = $deptAdmins->sum('leads_assigned_count');
            $totalConversions = $deptAdmins->sum('leads_converted_count');
            
            return [
                'department' => $department ?: 'Atanmamış',
                'admin_count' => $deptAdmins->count(),
                'total_leads' => $totalLeads,
                'total_conversions' => $totalConversions,
                'conversion_rate' => $totalLeads > 0 ? round(($totalConversions / $totalLeads) * 100, 2) : 0,
                'avg_performance' => round($deptAdmins->avg('current_performance'), 2),
                'avg_efficiency' => round($deptAdmins->avg(function($admin) {
                    return $admin->calculateEfficiencyRating();
                }), 2),
            ];
        });
    }

    /**
     * Rol performans istatistikleri
     */
    private function getRolePerformanceStats($admins)
    {
        return $admins->groupBy('role.name')->map(function($roleAdmins, $roleName) {
            $totalLeads = $roleAdmins->sum('leads_assigned_count');
            $totalConversions = $roleAdmins->sum('leads_converted_count');
            
            return [
                'role' => $roleAdmins->first()->role?->display_name ?: 'Rol Atanmamış',
                'admin_count' => $roleAdmins->count(),
                'total_leads' => $totalLeads,
                'total_conversions' => $totalConversions,
                'conversion_rate' => $totalLeads > 0 ? round(($totalConversions / $totalLeads) * 100, 2) : 0,
                'avg_performance' => round($roleAdmins->avg('current_performance'), 2),
                'avg_efficiency' => round($roleAdmins->avg(function($admin) {
                    return $admin->calculateEfficiencyRating();
                }), 2),
            ];
        });
    }

    /**
     * Build hierarchy tree organized by levels for tree view
     */
    private function buildHierarchyTreeByLevels($roles)
    {
        $tree = [];
        
        // Filter out null roles and group by hierarchy level
        $filteredRoles = $roles->filter(function ($role) {
            return $role !== null && $role instanceof Role;
        });
        
        $rolesByLevel = $filteredRoles->groupBy('hierarchy_level');
        
        foreach ($rolesByLevel as $level => $levelRoles) {
            // Double check - filter out any remaining null values
            $validRoles = $levelRoles->filter(function ($role) {
                return $role !== null && $role instanceof Role;
            });
            
            if ($validRoles->isNotEmpty()) {
                $tree[$level] = $validRoles;
            }
        }

        return $tree;
    }

    /**
     * Build department-based hierarchy for org view
     */
    private function buildDepartmentHierarchy()
    {
        $departments = Admin::with('role')->get()->groupBy('department');
        $hierarchy = [];

        foreach ($departments as $department => $admins) {
            $departmentName = $department ?: 'Atanmamış';
            
            // Group by hierarchy level
            $levels = [];
            $rolesByLevel = $admins->groupBy('role.hierarchy_level');
            
            foreach ($rolesByLevel as $level => $levelAdmins) {
                // Filter out admins with null roles
                $validAdmins = $levelAdmins->filter(function ($admin) {
                    return $admin->role !== null && $admin->role instanceof Role;
                });
                
                if ($validAdmins->isNotEmpty()) {
                    $roles = $validAdmins->pluck('role')->unique('id')->filter();
                    $levels[$level] = $roles;
                }
            }

            $hierarchy[$departmentName] = [
                'total_users' => $admins->count(),
                'total_roles' => $admins->filter(function ($admin) {
                    return $admin->role !== null;
                })->pluck('role.id')->unique()->count(),
                'levels' => $levels
            ];
        }

        return $hierarchy;
    }

    /**
     * Format hierarchy data for D3.js visualization
     */
    private function formatHierarchyForD3($hierarchyData)
    {
        return array_map(function($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'role' => $item['role']['display_name'] ?? '',
                'department' => $item['department'],
                'level' => $item['hierarchy_level'],
                'children' => $this->formatHierarchyForD3($item['children'] ?? [])
            ];
        }, $hierarchyData);
    }
}