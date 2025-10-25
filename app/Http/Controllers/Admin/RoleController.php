<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\AdminAuditLog;

class RoleController extends Controller
{
    /**
     * Rollerin listesi ve hiyerarşik görünümü
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Build query
        $query = Role::with([
            'parentRole',
            'childRoles',
            'permissions' => function($q) {
                $q->where('role_permissions.is_granted', true)
                  ->where(function($query) {
                      $query->whereNull('role_permissions.expires_at')
                            ->orWhere('role_permissions.expires_at', '>', now());
                  });
            },
            'admins' => function($q) {
                $q->select('id', 'firstName', 'lastName', 'role_id', 'status');
            }
        ])->withCount([
            'admins',
            'permissions as active_permissions_count' => function($q) {
                $q->where('role_permissions.is_granted', true)
                  ->where(function($query) {
                      $query->whereNull('role_permissions.expires_at')
                            ->orWhere('role_permissions.expires_at', '>', now());
                  });
            }
        ]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('display_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Hierarchy level filter
        if ($request->filled('level')) {
            $query->where('hierarchy_level', $request->level);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('settings->department', $request->department);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'hierarchy_level');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        $allowedSorts = ['name', 'display_name', 'hierarchy_level', 'created_at', 'admins_count'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // If not sorted by hierarchy, add secondary sort
        if ($sortBy !== 'hierarchy_level') {
            $query->orderBy('hierarchy_level', 'asc');
        }

        $roles = $query->get();

        // Organize roles by hierarchy for tree view
        $roleTree = $this->buildRoleTree($roles);

        // Get filter options
        $departments = Role::whereNotNull('settings->department')
                          ->get()
                          ->pluck('settings.department')
                          ->filter()
                          ->unique()
                          ->sort()
                          ->values();

        $hierarchyLevels = Role::distinct()
                              ->orderBy('hierarchy_level')
                              ->pluck('hierarchy_level')
                              ->filter(function($level) { return $level !== null; });

        // Statistics
        $stats = [
            'total_roles' => Role::count(),
            'active_roles' => Role::where('is_active', true)->count(),
            'inactive_roles' => Role::where('is_active', false)->count(),
            'admin_roles' => Role::has('admins')->count(),
        ];

        return view('admin.roles.index', compact(
            'roles',
            'roleTree',
            'departments',
            'hierarchyLevels',
            'stats'
        ))->with([
            'title' => 'Roller ve Yetkiler',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni rol oluşturma formu
     */
    public function create()
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Get all permissions grouped by category
        $permissions = Permission::orderBy('category', 'asc')
                                ->orderBy('name', 'asc')
                                ->get()
                                ->groupBy('category');

        // Get potential parent roles
        $parentRoles = Role::active()
                          ->orderBy('hierarchy_level', 'asc')
                          ->orderBy('display_name', 'asc')
                          ->get();

        $departments = [
            'sales' => 'Satış',
            'retention' => 'Retention',
            'support' => 'Destek',
            'finance' => 'Finans',
            'marketing' => 'Pazarlama',
            'compliance' => 'Uyumluluk',
            'it' => 'IT',
            'management' => 'Yönetim',
        ];

        return view('admin.roles.create', compact(
            'permissions',
            'parentRoles',
            'departments'
        ))->with([
            'title' => 'Yeni Rol Oluştur',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni rol kaydet
     */
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_role_id' => 'nullable|exists:roles,id',
            'hierarchy_level' => 'nullable|integer|min:0|max:10',
            'department' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'permission_constraints' => 'nullable|array',
            'permission_constraints.*' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Calculate hierarchy level if not provided
            $hierarchyLevel = $request->hierarchy_level;
            if (!$hierarchyLevel && $request->parent_role_id) {
                $parentRole = Role::find($request->parent_role_id);
                $hierarchyLevel = $parentRole ? $parentRole->hierarchy_level + 1 : 0;
            } elseif (!$hierarchyLevel) {
                $hierarchyLevel = 0; // Root level
            }

            $roleData = [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'parent_role_id' => $request->parent_role_id,
                'hierarchy_level' => $hierarchyLevel,
                'is_active' => $request->boolean('is_active', true),
                'settings' => [
                    'department' => $request->department,
                    'can_manage_subordinates' => $request->boolean('can_manage_subordinates'),
                    'can_assign_leads' => $request->boolean('can_assign_leads'),
                    'max_subordinates' => $request->max_subordinates,
                    'auto_assign_leads' => $request->boolean('auto_assign_leads'),
                ],
            ];

            $role = Role::create($roleData);

            // Attach permissions
            if ($request->filled('permissions')) {
                $permissionData = [];
                foreach ($request->permissions as $permissionId) {
                    $constraints = $request->permission_constraints[$permissionId] ?? null;
                    $permissionData[$permissionId] = [
                        'is_granted' => true,
                        'constraints' => $constraints,
                        'granted_at' => now(),
                        'granted_by' => $currentAdmin->id,
                    ];
                }
                $role->permissions()->sync($permissionData);
            }

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'role_created',
                'target_role_id' => $role->id,
                'description' => "Yeni rol oluşturuldu: {$role->display_name}",
                'metadata' => [
                    'role_name' => $role->name,
                    'hierarchy_level' => $role->hierarchy_level,
                    'permissions_count' => count($request->permissions ?? []),
                    'department' => $request->department,
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'Rol başarıyla oluşturuldu!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Role creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Rol oluşturulurken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Rol düzenleme formu
     */
    public function edit(Role $role)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $role->load([
            'permissions' => function($query) {
                $query->withPivot('is_granted', 'constraints', 'granted_at', 'expires_at');
            },
            'parentRole',
            'childRoles'
        ]);

        // Get all permissions grouped by category
        $permissions = Permission::orderBy('category', 'asc')
                                ->orderBy('name', 'asc')
                                ->get()
                                ->groupBy('category');

        // Get potential parent roles (excluding self and descendants)
        $excludeIds = array_merge([$role->id], $role->getSubordinateRoles());
        $parentRoles = Role::active()
                          ->whereNotIn('id', $excludeIds)
                          ->orderBy('hierarchy_level', 'asc')
                          ->orderBy('display_name', 'asc')
                          ->get();

        $departments = [
            'sales' => 'Satış',
            'retention' => 'Retention',
            'support' => 'Destek',
            'finance' => 'Finans',
            'marketing' => 'Pazarlama',
            'compliance' => 'Uyumluluk',
            'it' => 'IT',
            'management' => 'Yönetim',
        ];

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'parentRoles',
            'departments'
        ))->with([
            'title' => $role->display_name . ' - Rol Düzenle',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Rol güncelle
     */
    public function update(Request $request, Role $role)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id)
            ],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'parent_role_id' => [
                'nullable',
                'exists:roles,id',
                function ($attribute, $value, $fail) use ($role) {
                    if ($value && ($value == $role->id || in_array($value, $role->getSubordinateRoles()))) {
                        $fail('Hiyerarşi döngüsü oluşturulamaz.');
                    }
                },
            ],
            'hierarchy_level' => 'nullable|integer|min:0|max:10',
            'department' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'permission_constraints' => 'nullable|array',
            'permission_constraints.*' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $role->toArray();

            // Calculate hierarchy level if parent changed
            $hierarchyLevel = $request->hierarchy_level;
            if ($request->parent_role_id != $role->parent_role_id) {
                if ($request->parent_role_id) {
                    $parentRole = Role::find($request->parent_role_id);
                    $hierarchyLevel = $parentRole ? $parentRole->hierarchy_level + 1 : 0;
                } else {
                    $hierarchyLevel = 0; // Root level
                }
            }

            $updateData = [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'parent_role_id' => $request->parent_role_id,
                'hierarchy_level' => $hierarchyLevel,
                'is_active' => $request->boolean('is_active', true),
                'settings' => array_merge($role->settings ?? [], [
                    'department' => $request->department,
                    'can_manage_subordinates' => $request->boolean('can_manage_subordinates'),
                    'can_assign_leads' => $request->boolean('can_assign_leads'),
                    'max_subordinates' => $request->max_subordinates,
                    'auto_assign_leads' => $request->boolean('auto_assign_leads'),
                ]),
            ];

            $role->update($updateData);

            // Update permissions
            if ($request->has('permissions')) {
                $permissionData = [];
                foreach ($request->permissions ?? [] as $permissionId) {
                    $constraints = $request->permission_constraints[$permissionId] ?? null;
                    $permissionData[$permissionId] = [
                        'is_granted' => true,
                        'constraints' => $constraints,
                        'granted_at' => now(),
                        'granted_by' => $currentAdmin->id,
                    ];
                }
                $role->permissions()->sync($permissionData);
            } else {
                // Remove all permissions if none selected
                $role->permissions()->detach();
            }

            // If hierarchy changed, update child roles
            if ($hierarchyLevel != $oldData['hierarchy_level']) {
                $this->updateChildRoleHierarchy($role);
            }

            // Log changes
            $changes = array_diff_assoc($updateData, $oldData);
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'role_updated',
                'target_role_id' => $role->id,
                'description' => "Rol güncellendi: {$role->display_name}",
                'metadata' => [
                    'changes' => $changes,
                    'permissions_updated' => true,
                    'old_hierarchy_level' => $oldData['hierarchy_level'],
                    'new_hierarchy_level' => $hierarchyLevel,
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'Rol başarıyla güncellendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Role update failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Güncelleme sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Rol detayları göster
     */
    public function show(Role $role, Request $request)
    {
        $role->load([
            'permissions' => function($q) {
                $q->where('role_permissions.is_granted', true)
                  ->where(function($query) {
                      $query->whereNull('role_permissions.expires_at')
                            ->orWhere('role_permissions.expires_at', '>', now());
                  });
            },
            'parentRole',
            'childRoles',
            'admins' => function($q) {
                $q->select('id', 'firstName', 'lastName', 'email', 'status', 'role_id');
            }
        ]);

        // If requesting JSON data (for AJAX calls)
        if ($request->wantsJson() || $request->has('data')) {
            return response()->json([
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
                'description' => $role->description,
                'hierarchy_level' => $role->hierarchy_level,
                'is_active' => $role->is_active,
                'department' => $role->settings['department'] ?? null,
                'users_count' => $role->admins->count(),
                'permissions_count' => $role->permissions->count(),
                'parent_roles' => $role->parentRole ? [
                    [
                        'id' => $role->parentRole->id,
                        'display_name' => $role->parentRole->display_name,
                        'hierarchy_level' => $role->parentRole->hierarchy_level,
                    ]
                ] : [],
                'child_roles' => $role->childRoles->map(function($child) {
                    return [
                        'id' => $child->id,
                        'display_name' => $child->display_name,
                        'hierarchy_level' => $child->hierarchy_level,
                    ];
                })->toArray(),
                'permissions' => $role->permissions->map(function($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'display_name' => $permission->display_name,
                        'category' => $permission->category,
                    ];
                })->toArray(),
                'admins' => $role->admins->map(function($admin) {
                    return [
                        'id' => $admin->id,
                        'name' => $admin->firstName . ' ' . $admin->lastName,
                        'email' => $admin->email,
                        'status' => $admin->status,
                    ];
                })->toArray(),
            ]);
        }

        // Regular view
        $stats = [
            'total_admins' => $role->admins->count(),
            'active_admins' => $role->admins->where('status', 1)->count(),
            'total_permissions' => $role->permissions->count(),
            'subordinate_roles' => $role->childRoles->count(),
        ];

        return view('admin.roles.show', compact('role', 'stats'))
              ->with([
                  'title' => $role->display_name . ' - Rol Detayları',
                  'settings' => Settings::first()
              ]);
    }

    /**
     * Rol sil
     */
    public function destroy(Role $role)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check if role has admins
        if ($role->admins()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Bu role sahip adminler var. Önce adminleri farklı rollere atayın.');
        }

        // Check if role has child roles
        if ($role->childRoles()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Bu rolün alt rolleri var. Önce alt rolleri silin veya farklı üst role atayın.');
        }

        DB::beginTransaction();
        try {
            $roleName = $role->display_name;
            
            // Remove all permission associations
            $role->permissions()->detach();
            
            // Delete the role
            $role->delete();

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'role_deleted',
                'target_role_id' => $role->id,
                'description' => "Rol silindi: {$roleName}",
                'metadata' => [
                    'role_name' => $role->name,
                    'hierarchy_level' => $role->hierarchy_level,
                    'department' => $role->getDepartment(),
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'Rol başarıyla silindi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Role deletion failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Silme işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Rol-izin matrix görüntüle
     */
    public function permissions()
    {
        $roles = Role::with([
            'permissions' => function($q) {
                $q->where('role_permissions.is_granted', true)
                  ->where(function($query) {
                      $query->whereNull('role_permissions.expires_at')
                            ->orWhere('role_permissions.expires_at', '>', now());
                  });
            }
        ])->orderBy('hierarchy_level', 'asc')
          ->orderBy('display_name', 'asc')
          ->get();

        $permissions = Permission::orderBy('category', 'asc')
                                ->orderBy('name', 'asc')
                                ->get()
                                ->groupBy('category');

        // Build permission matrix
        $matrix = [];
        foreach ($roles as $role) {
            foreach ($permissions as $category => $categoryPermissions) {
                foreach ($categoryPermissions as $permission) {
                    $hasPermission = $role->permissions->contains('id', $permission->id);
                    $matrix[$role->id][$permission->id] = $hasPermission;
                }
            }
        }

        return view('admin.permissions.role-permissions', compact(
            'roles',
            'permissions',
            'matrix'
        ))->with([
            'title' => 'Rol-İzin Matrix',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Hiyerarşi görüntüleme
     */
    public function hierarchy()
    {
        $roles = Role::with([
            'parentRole',
            'childRoles.childRoles',
            'admins' => function($q) {
                $q->select('id', 'firstName', 'lastName', 'role_id', 'status');
            }
        ])->orderBy('hierarchy_level', 'asc')
          ->orderBy('display_name', 'asc')
          ->get();

        $hierarchyTree = $this->buildDetailedRoleTree($roles);
        
        // Calculate total hierarchy levels
        $totalLevels = ($roles->max('hierarchy_level') ?? 0) + 1;
        $activeRoles = $roles->where('is_active', true)->count();
        $totalUsers = Admin::count();
        $hierarchyConflicts = 0; // Bu değer gerçek çakışma kontrolü ile hesaplanabilir
        
        // Department-based organization
        $departmentHierarchy = [];
        $departments = $roles->pluck('settings.department')->filter()->unique();
        $totalDepartments = $departments->count();
        
        foreach ($departments as $department) {
            $departmentRoles = $roles->where('settings.department', $department);
            $departmentHierarchy[$department] = [
                'total_users' => $departmentRoles->sum(function($role) {
                    return $role->admins->count();
                }),
                'total_roles' => $departmentRoles->count(),
                'levels' => $departmentRoles->groupBy('hierarchy_level')->sortKeys()
            ];
        }
        
        // All roles for matrix view
        $allRoles = $roles;
        
        // D3 hierarchy data for tree visualization
        $d3HierarchyData = $this->buildD3HierarchyData($roles);
        
        // Calculate statistics
        $stats = [
            'total_roles' => $roles->count(),
            'active_roles' => $activeRoles,
            'inactive_roles' => $roles->where('is_active', false)->count(),
            'total_levels' => $totalLevels,
            'max_depth' => $totalLevels - 1,
        ];

        return view('admin.permissions.hierarchy', compact(
            'roles',
            'hierarchyTree',
            'totalLevels',
            'activeRoles',
            'totalUsers',
            'totalDepartments',
            'hierarchyConflicts',
            'departmentHierarchy',
            'allRoles',
            'd3HierarchyData',
            'stats',
            'departments'
        ))->with([
            'title' => 'Rol Hiyerarşisi',
            'settings' => Settings::first()
        ]);
    }

    /**
     * AJAX: İzin durumunu değiştir
     */
    public function togglePermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
            'granted' => 'required|boolean',
            'constraints' => 'nullable|array',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        DB::beginTransaction();
        try {
            if ($request->granted) {
                // Grant permission
                $role->permissions()->syncWithoutDetaching([
                    $permission->id => [
                        'is_granted' => true,
                        'constraints' => $request->constraints,
                        'granted_at' => now(),
                        'granted_by' => $currentAdmin->id,
                    ]
                ]);
                $action = 'granted';
            } else {
                // Revoke permission
                $role->permissions()->updateExistingPivot($permission->id, [
                    'is_granted' => false,
                ]);
                $action = 'revoked';
            }

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permission_' . $action,
                'target_role_id' => $role->id,
                'description' => "İzin {$action}: {$permission->display_name} -> {$role->display_name}",
                'metadata' => [
                    'permission_name' => $permission->name,
                    'role_name' => $role->name,
                    'constraints' => $request->constraints,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "İzin başarıyla {$action}!",
                'permission_granted' => $request->granted
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission toggle failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'İşlem sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Build role tree for hierarchical display
     */
    private function buildRoleTree($roles, $parentId = null)
    {
        $tree = collect();
        
        foreach ($roles as $role) {
            if ($role->parent_role_id == $parentId) {
                $children = $this->buildRoleTree($roles, $role->id);
                $role->children = $children;
                $tree->push($role);
            }
        }
        
        return $tree;
    }

    /**
     * Build detailed role tree with additional information
     */
    private function buildDetailedRoleTree($roles, $parentId = null, $level = 0)
    {
        $tree = collect();
        
        foreach ($roles as $role) {
            if ($role->parent_role_id == $parentId) {
                $children = $this->buildDetailedRoleTree($roles, $role->id, $level + 1);
                $role->tree_level = $level;
                $role->children = $children;
                $tree->push($role);
            }
        }
        
        return $tree;
    }

    /**
     * Update child role hierarchy levels recursively
     */
    private function updateChildRoleHierarchy(Role $parentRole)
    {
        $childRoles = $parentRole->childRoles;
        
        foreach ($childRoles as $childRole) {
            $newLevel = $parentRole->hierarchy_level + 1;
            $childRole->update(['hierarchy_level' => $newLevel]);
            
            // Recursively update grandchildren
            if ($childRole->childRoles()->count() > 0) {
                $this->updateChildRoleHierarchy($childRole);
            }
        }
    }

    /**
     * Build D3.js hierarchy data for tree visualization
     */
    private function buildD3HierarchyData($roles, $parentId = null)
    {
        $data = [];
        
        foreach ($roles as $role) {
            if ($role->parent_role_id == $parentId) {
                $roleData = [
                    'id' => $role->id,
                    'name' => $role->display_name,
                    'level' => $role->hierarchy_level,
                    'users_count' => $role->admins->count(),
                    'permissions_count' => $role->permissions->count(),
                    'department' => $role->settings['department'] ?? 'Genel',
                    'is_active' => $role->is_active,
                ];
                
                $children = $this->buildD3HierarchyData($roles, $role->id);
                if (!empty($children)) {
                    $roleData['children'] = $children;
                }
                
                $data[] = $roleData;
            }
        }
        
        return $data;
    }
    /**
     * Rol aktif yap
     */
    public function activate(Role $role)
    {
        $currentAdmin = Auth::guard('admin')->user();

        if ($role->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Rol zaten aktif durumda.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $role->update(['is_active' => true]);

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'role_activated',
                'target_role_id' => $role->id,
                'description' => "Rol aktif edildi: {$role->display_name}",
                'metadata' => [
                    'role_name' => $role->name,
                    'hierarchy_level' => $role->hierarchy_level,
                    'department' => $role->settings['department'] ?? null,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rol başarıyla aktif edildi!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Role activation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Aktivasyon sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Rol pasif yap
     */
    public function deactivate(Role $role)
    {
        $currentAdmin = Auth::guard('admin')->user();

        if (!$role->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Rol zaten pasif durumda.'
            ], 400);
        }

        // Check if role has active admins
        $activeAdminCount = $role->admins()->where('status', 1)->count();
        if ($activeAdminCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Bu rolde {$activeAdminCount} aktif admin var. Önce adminleri farklı rollere atayın veya pasif yapın."
            ], 400);
        }

        DB::beginTransaction();
        try {
            $role->update(['is_active' => false]);

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'role_deactivated',
                'target_role_id' => $role->id,
                'description' => "Rol pasif edildi: {$role->display_name}",
                'metadata' => [
                    'role_name' => $role->name,
                    'hierarchy_level' => $role->hierarchy_level,
                    'department' => $role->settings['department'] ?? null,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rol başarıyla pasif edildi!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Role deactivation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Deaktivasyon sırasında bir hata oluştu.'
            ], 500);
        }
    }
}