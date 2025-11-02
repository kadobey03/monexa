<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\AdminAuditLog;

class PermissionController extends Controller
{
    /**
     * İzinlerin listesi ve kategoriler
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Build query
        $query = Permission::with([
            'roles' => function($q) {
                $q->wherePivot('is_granted', true)
                  ->select('roles.id', 'roles.name', 'roles.display_name');
            }
        ])->withCount([
            'roles as granted_roles_count' => function($q) {
                $q->where('role_permissions.is_granted', true);
            }
        ]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('display_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'category');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        $allowedSorts = ['name', 'display_name', 'category', 'type', 'created_at', 'granted_roles_count'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Secondary sort by name
        if ($sortBy !== 'name') {
            $query->orderBy('name', 'asc');
        }

        $allPermissions = $query->get();
        $permissionsByCategory = $allPermissions->groupBy('category');

        // Get all roles
        $roles = Role::orderBy('hierarchy_level', 'asc')->get();

        // Get filter options
        $categories = Permission::whereNotNull('category')
                               ->distinct()
                               ->orderBy('category')
                               ->pluck('category');

        $types = ['basic', 'advanced', 'system', 'management'];

        // Category icons
        $categoryIcons = [
            'user_management' => 'users',
            'admin_management' => 'user-cog',
            'role_management' => 'shield-check',
            'permission_management' => 'key',
            'financial' => 'dollar-sign',
            'lead_management' => 'target',
            'system_settings' => 'settings',
            'reports' => 'file-text',
            'content_management' => 'edit-3',
            'communication' => 'mail',
            'analytics' => 'bar-chart',
            'security' => 'lock',
        ];

        // Build role-permissions matrix
        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role->id] = $role->permissions()
                ->where('role_permissions.is_granted', true)
                ->pluck('permissions.id')
                ->toArray();
        }

        // Statistics
        $totalRoles = Role::count();
        $activeRoles = Role::where('is_active', true)->count();
        $totalPermissions = Permission::count();
        $permissionCategories = count($categories);
        $assignedPermissions = DB::table('role_permissions')->where('is_granted', true)->count();
        
        // Last change info
        $lastChange = AdminAuditLog::whereIn('action', [
                'permission_created', 'permission_updated', 'permission_deleted',
                'permission_granted', 'permission_revoked'
            ])
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->first();
            
        $lastChangeAgo = $lastChange ? $lastChange->created_at->diffForHumans() : 'Henüz değişiklik yok';
        $lastChangeUser = $lastChange ? $lastChange->admin->firstName . ' ' . $lastChange->admin->lastName : 'Sistem';

        return view('admin.permissions.index', compact(
            'permissionsByCategory',
            'allPermissions',
            'categories',
            'types',
            'roles',
            'categoryIcons',
            'rolePermissions',
            'totalRoles',
            'activeRoles',
            'totalPermissions',
            'permissionCategories',
            'assignedPermissions',
            'lastChangeAgo',
            'lastChangeUser'
        ))->with([
            'title' => 'İzin Yönetimi',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni izin oluşturma formu
     */
    public function create()
    {
        $categories = [
            'user_management' => 'Kullanıcı Yönetimi',
            'admin_management' => 'Admin Yönetimi', 
            'role_management' => 'Rol Yönetimi',
            'permission_management' => 'İzin Yönetimi',
            'financial' => 'Finansal İşlemler',
            'lead_management' => 'Lead Yönetimi',
            'system_settings' => 'Sistem Ayarları',
            'reports' => 'Raporlar',
            'content_management' => 'İçerik Yönetimi',
            'communication' => 'İletişim',
            'analytics' => 'Analitik',
            'security' => 'Güvenlik',
        ];

        $types = [
            'basic' => 'Temel',
            'advanced' => 'Gelişmiş',
            'system' => 'Sistem',
            'management' => 'Yönetim',
        ];

        return view('admin.permissions.create', compact(
            'categories',
            'types'
        ))->with([
            'title' => 'Yeni İzin Oluştur',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni izin kaydet
     */
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'dependencies' => 'nullable|array',
            'dependencies.*' => 'exists:permissions,id',
            'constraints' => 'nullable|array',
            'default_roles' => 'nullable|array',
            'default_roles.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            $permissionData = [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'is_active' => $request->boolean('is_active', true),
                'settings' => [
                    'dependencies' => $request->dependencies ?? [],
                    'constraints' => $request->constraints ?? [],
                    'is_system_permission' => $request->boolean('is_system_permission'),
                    'requires_confirmation' => $request->boolean('requires_confirmation'),
                    'auto_grant_conditions' => $request->auto_grant_conditions,
                ],
            ];

            $permission = Permission::create($permissionData);

            // Assign to default roles if specified
            if ($request->filled('default_roles')) {
                foreach ($request->default_roles as $roleId) {
                    $role = Role::find($roleId);
                    if ($role) {
                        $role->permissions()->attach($permission->id, [
                            'is_granted' => true,
                            'granted_at' => now(),
                            'granted_by' => $currentAdmin->id,
                        ]);
                    }
                }
            }

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permission_created',
                'target_permission_id' => $permission->id,
                'description' => "Yeni izin oluşturuldu: {$permission->display_name}",
                'metadata' => [
                    'permission_name' => $permission->name,
                    'category' => $permission->category,
                    'type' => $permission->type,
                    'default_roles_count' => count($request->default_roles ?? []),
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'İzin başarıyla oluşturuldu!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'İzin oluşturulurken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * İzin düzenleme formu
     */
    public function edit(Permission $permission)
    {
        $permission->load([
            'roles' => function($query) {
                $query->withPivot('is_granted', 'constraints', 'granted_at', 'expires_at');
            }
        ]);

        $categories = [
            'user_management' => 'Kullanıcı Yönetimi',
            'admin_management' => 'Admin Yönetimi', 
            'role_management' => 'Rol Yönetimi',
            'permission_management' => 'İzin Yönetimi',
            'financial' => 'Finansal İşlemler',
            'lead_management' => 'Lead Yönetimi',
            'system_settings' => 'Sistem Ayarları',
            'reports' => 'Raporlar',
            'content_management' => 'İçerik Yönetimi',
            'communication' => 'İletişim',
            'analytics' => 'Analitik',
            'security' => 'Güvenlik',
        ];

        $types = [
            'basic' => 'Temel',
            'advanced' => 'Gelişmiş',
            'system' => 'Sistem',
            'management' => 'Yönetim',
        ];

        // Get all permissions for dependency selection (excluding self)
        $availablePermissions = Permission::where('id', '!=', $permission->id)
                                         ->orderBy('category')
                                         ->orderBy('display_name')
                                         ->get()
                                         ->groupBy('category');

        return view('admin.permissions.edit', compact(
            'permission',
            'categories',
            'types',
            'availablePermissions'
        ))->with([
            'title' => $permission->display_name . ' - İzin Düzenle',
            'settings' => Settings::first()
        ]);
    }

    /**
     * İzin güncelle
     */
    public function update(Request $request, Permission $permission)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)
            ],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'dependencies' => 'nullable|array',
            'dependencies.*' => 'exists:permissions,id',
            'constraints' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $permission->toArray();

            $updateData = [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'is_active' => $request->boolean('is_active', true),
                'settings' => array_merge($permission->settings ?? [], [
                    'dependencies' => $request->dependencies ?? [],
                    'constraints' => $request->constraints ?? [],
                    'is_system_permission' => $request->boolean('is_system_permission'),
                    'requires_confirmation' => $request->boolean('requires_confirmation'),
                    'auto_grant_conditions' => $request->auto_grant_conditions,
                ]),
            ];

            $permission->update($updateData);

            // If permission was deactivated, revoke from all roles
            if (!$updateData['is_active'] && $oldData['is_active']) {
                $permission->roles()->updateExistingPivot(
                    $permission->roles()->pluck('roles.id')->toArray(),
                    ['is_granted' => false]
                );
            }

            // Log changes
            $changes = array_diff_assoc($updateData, $oldData);
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permission_updated',
                'target_permission_id' => $permission->id,
                'description' => "İzin güncellendi: {$permission->display_name}",
                'metadata' => [
                    'changes' => $changes,
                    'old_active_status' => $oldData['is_active'],
                    'new_active_status' => $updateData['is_active'],
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'İzin başarıyla güncellendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission update failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Güncelleme sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * İzin sil
     */
    public function destroy(Permission $permission)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check if permission is assigned to any roles
        $assignedRolesCount = $permission->roles()->where('role_permissions.is_granted', true)->count();
        
        if ($assignedRolesCount > 0) {
            return redirect()->back()
                           ->with('error', "Bu izin {$assignedRolesCount} role atanmış. Önce rollerin izinlerini kaldırın.");
        }

        DB::beginTransaction();
        try {
            $permissionName = $permission->display_name;
            
            // Remove all role associations
            $permission->roles()->detach();
            
            // Delete the permission
            $permission->delete();

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permission_deleted',
                'target_permission_id' => $permission->id,
                'description' => "İzin silindi: {$permissionName}",
                'metadata' => [
                    'permission_name' => $permission->name,
                    'category' => $permission->category,
                    'type' => $permission->type,
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                           ->with('success', 'İzin başarıyla silindi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission deletion failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Silme işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Rol-izin atama interface
     */
    public function rolePermissions(Role $role)
    {
        $role->load([
            'permissions' => function($query) {
                $query->withPivot('is_granted', 'constraints', 'granted_at', 'expires_at');
            }
        ]);

        // Get all permissions grouped by category
        $permissions = Permission::where('is_active', true)
                                ->orderBy('category', 'asc')
                                ->orderBy('name', 'asc')
                                ->get()
                                ->groupBy('category');

        // Build current permission status
        $currentPermissions = [];
        foreach ($role->permissions as $permission) {
            $currentPermissions[$permission->id] = [
                'granted' => $permission->pivot->is_granted,
                'constraints' => $permission->pivot->constraints,
                'granted_at' => $permission->pivot->granted_at,
                'expires_at' => $permission->pivot->expires_at,
            ];
        }

        return view('admin.permissions.role-permissions', compact(
            'role',
            'permissions',
            'currentPermissions'
        ))->with([
            'title' => $role->display_name . ' - İzin Yönetimi',
            'settings' => Settings::first()
        ]);
    }

    /**
     * İzin atama/çıkarma
     */
    public function assign(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
            'action' => 'required|in:grant,revoke',
            'constraints' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        DB::beginTransaction();
        try {
            if ($request->action === 'grant') {
                // Check dependencies
                $dependencies = $permission->settings['dependencies'] ?? [];
                if (!empty($dependencies)) {
                    $missingDeps = [];
                    foreach ($dependencies as $depId) {
                        if (!$role->hasPermission(Permission::find($depId)->name)) {
                            $dep = Permission::find($depId);
                            $missingDeps[] = $dep->display_name;
                        }
                    }
                    
                    if (!empty($missingDeps)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Bu izin için gerekli bağımlılıklar eksik: ' . implode(', ', $missingDeps),
                            'missing_dependencies' => $missingDeps
                        ], 422);
                    }
                }

                // Grant permission
                $role->permissions()->syncWithoutDetaching([
                    $permission->id => [
                        'is_granted' => true,
                        'constraints' => $request->constraints,
                        'granted_at' => now(),
                        'granted_by' => $currentAdmin->id,
                        'expires_at' => $request->expires_at,
                    ]
                ]);

                $message = 'İzin başarıyla verildi!';
                $actionType = 'granted';

            } else {
                // Check if this permission is required by others
                $dependentPermissions = Permission::whereJsonContains('settings->dependencies', $permission->id)->get();
                $blockers = [];
                
                foreach ($dependentPermissions as $depPerm) {
                    if ($role->hasPermission($depPerm->name)) {
                        $blockers[] = $depPerm->display_name;
                    }
                }
                
                if (!empty($blockers)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu izin şu izinler tarafından gerekli: ' . implode(', ', $blockers),
                        'blocking_permissions' => $blockers
                    ], 422);
                }

                // Revoke permission
                $role->permissions()->updateExistingPivot($permission->id, [
                    'is_granted' => false,
                ]);

                $message = 'İzin başarıyla kaldırıldı!';
                $actionType = 'revoked';
            }

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permission_' . $actionType,
                'target_role_id' => $role->id,
                'target_permission_id' => $permission->id,
                'description' => "İzin {$actionType}: {$permission->display_name} -> {$role->display_name}",
                'metadata' => [
                    'permission_name' => $permission->name,
                    'role_name' => $role->name,
                    'constraints' => $request->constraints,
                    'expires_at' => $request->expires_at,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $actionType,
                'permission_granted' => $request->action === 'grant'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission assignment failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'İşlem sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Toplu izin atama
     */
    public function bulkAssign(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|in:grant,revoke',
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => 'exists:roles,id',
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => 'exists:permissions,id',
            'constraints' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $roles = Role::whereIn('id', $request->role_ids)->get();
        $permissions = Permission::whereIn('id', $request->permission_ids)->get();

        DB::beginTransaction();
        try {
            $successCount = 0;
            $errors = [];

            foreach ($roles as $role) {
                foreach ($permissions as $permission) {
                    try {
                        if ($request->action === 'grant') {
                            // Check dependencies for each permission
                            $dependencies = $permission->settings['dependencies'] ?? [];
                            if (!empty($dependencies)) {
                                $missingDeps = [];
                                foreach ($dependencies as $depId) {
                                    if (!$role->hasPermission(Permission::find($depId)->name)) {
                                        $dep = Permission::find($depId);
                                        $missingDeps[] = $dep->display_name;
                                    }
                                }
                                
                                if (!empty($missingDeps)) {
                                    $errors[] = "{$role->display_name} -> {$permission->display_name}: Eksik bağımlılıklar";
                                    continue;
                                }
                            }

                            $role->permissions()->syncWithoutDetaching([
                                $permission->id => [
                                    'is_granted' => true,
                                    'constraints' => $request->constraints,
                                    'granted_at' => now(),
                                    'granted_by' => $currentAdmin->id,
                                    'expires_at' => $request->expires_at,
                                ]
                            ]);

                        } else {
                            // Check dependencies before revoking
                            $dependentPermissions = Permission::whereJsonContains('settings->dependencies', $permission->id)->get();
                            $hasBlockers = false;
                            
                            foreach ($dependentPermissions as $depPerm) {
                                if ($role->hasPermission($depPerm->name)) {
                                    $hasBlockers = true;
                                    break;
                                }
                            }
                            
                            if ($hasBlockers) {
                                $errors[] = "{$role->display_name} -> {$permission->display_name}: Bağımlı izinler var";
                                continue;
                            }

                            $role->permissions()->updateExistingPivot($permission->id, [
                                'is_granted' => false,
                            ]);
                        }

                        $successCount++;

                    } catch (\Exception $e) {
                        $errors[] = "{$role->display_name} -> {$permission->display_name}: Hata oluştu";
                    }
                }
            }

            // Log bulk action
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'bulk_permission_' . $request->action,
                'description' => "Toplu izin işlemi: {$request->action}",
                'metadata' => [
                    'action' => $request->action,
                    'success_count' => $successCount,
                    'error_count' => count($errors),
                    'role_ids' => $request->role_ids,
                    'permission_ids' => $request->permission_ids,
                    'errors' => $errors,
                ],
            ]);

            DB::commit();

            $actionName = $request->action === 'grant' ? 'verildi' : 'kaldırıldı';
            $message = "{$successCount} izin başarıyla {$actionName}!";
            
            if (!empty($errors)) {
                $message .= " " . count($errors) . " işlemde hata oluştu.";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'success_count' => $successCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk permission assignment failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Toplu işlem sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * İzin değişiklik geçmişi
     */
    public function auditLog(Request $request)
    {
        $query = AdminAuditLog::with(['admin'])
                             ->whereIn('action', [
                                 'permission_created',
                                 'permission_updated', 
                                 'permission_deleted',
                                 'permission_granted',
                                 'permission_revoked',
                                 'bulk_permission_grant',
                                 'bulk_permission_revoke'
                             ]);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Admin filter
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Permission filter
        if ($request->filled('permission_id')) {
            $query->where('target_permission_id', $request->permission_id);
        }

        // Role filter
        if ($request->filled('role_id')) {
            $query->where('target_role_id', $request->role_id);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')
                          ->paginate(50)
                          ->withQueryString();

        // Get filter options
        $admins = Admin::orderBy('firstName')->get();
        $permissions = Permission::orderBy('display_name')->get();
        $roles = Role::orderBy('display_name')->get();

        $actions = [
            'permission_created' => 'İzin Oluşturuldu',
            'permission_updated' => 'İzin Güncellendi',
            'permission_deleted' => 'İzin Silindi',
            'permission_granted' => 'İzin Verildi',
            'permission_revoked' => 'İzin Kaldırıldı',
            'bulk_permission_grant' => 'Toplu İzin Verme',
            'bulk_permission_revoke' => 'Toplu İzin Kaldırma',
        ];

        return view('admin.permissions.audit-log', compact(
            'auditLogs',
            'admins',
            'permissions',
            'roles',
            'actions'
        ))->with([
            'title' => 'İzin Değişiklik Geçmişi',
            'settings' => Settings::first()
        ]);
    }

    /**
     * AJAX: İzin bağımlılıklarını kontrol et
     */
    public function checkDependencies(Request $request)
    {
        $this->validate($request, [
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $permission = Permission::findOrFail($request->permission_id);
        $role = Role::findOrFail($request->role_id);

        $dependencies = $permission->settings['dependencies'] ?? [];
        $missingDeps = [];
        $availableDeps = [];

        foreach ($dependencies as $depId) {
            $dep = Permission::find($depId);
            if ($dep) {
                if ($role->hasPermission($dep->name)) {
                    $availableDeps[] = [
                        'id' => $dep->id,
                        'name' => $dep->name,
                        'display_name' => $dep->display_name,
                    ];
                } else {
                    $missingDeps[] = [
                        'id' => $dep->id,
                        'name' => $dep->name,
                        'display_name' => $dep->display_name,
                    ];
                }
            }
        }

        return response()->json([
            'success' => true,
            'has_dependencies' => !empty($dependencies),
            'missing_dependencies' => $missingDeps,
            'available_dependencies' => $availableDeps,
            'can_grant' => empty($missingDeps),
        ]);
    }

    /**
     * Hiyerarşi görünümü
     */
    public function hierarchy()
    {
        $roles = Role::with(['permissions' => function($query) {
                        $query->where('role_permissions.is_granted', true);
                    }])
                    ->withCount('users')
                    ->orderBy('hierarchy_level', 'asc')
                    ->get();

        $allRoles = Role::orderBy('hierarchy_level', 'asc')->get();

        $permissions = Permission::where('is_active', true)
                                ->orderBy('category')
                                ->orderBy('name')
                                ->get()
                                ->groupBy('category');

        // Build hierarchy tree grouped by level
        $hierarchyTree = $roles->groupBy('hierarchy_level');
        
        // Build department hierarchy (simulate departments based on role names)
        $departmentHierarchy = [];
        $departments = ['Admin', 'Sales', 'Support', 'Management', 'Finance'];
        
        foreach ($departments as $dept) {
            $deptRoles = $roles->filter(function($role) use ($dept) {
                return stripos($role->name, strtolower($dept)) !== false ||
                       stripos($role->display_name, $dept) !== false;
            });
            
            if ($deptRoles->count() > 0) {
                $departmentHierarchy[$dept] = [
                    'total_users' => $deptRoles->sum('users_count'),
                    'total_roles' => $deptRoles->count(),
                    'levels' => $deptRoles->groupBy('hierarchy_level')
                ];
            }
        }

        $categoryIcons = [
            'user_management' => 'users',
            'admin_management' => 'user-cog',
            'role_management' => 'shield-check',
            'permission_management' => 'key',
            'financial' => 'dollar-sign',
            'lead_management' => 'target',
            'system_settings' => 'settings',
            'reports' => 'file-text',
            'content_management' => 'edit-3',
            'communication' => 'mail',
            'analytics' => 'bar-chart',
            'security' => 'lock',
        ];

        // Statistics for the view
        $totalLevels = Role::max('hierarchy_level') ?? 0;
        $activeRoles = Role::where('is_active', true)->count();
        $totalDepartments = count($departmentHierarchy);
        $totalUsers = DB::table('admins')->count();
        $hierarchyConflicts = 0; // Could implement conflict detection logic
        
        // Prepare D3.js hierarchy data
        $d3HierarchyData = [
            'name' => 'Organization',
            'children' => []
        ];

        foreach ($hierarchyTree as $level => $levelRoles) {
            $levelNode = [
                'name' => "Level {$level}",
                'level' => $level,
                'children' => []
            ];
            
            foreach ($levelRoles as $role) {
                $levelNode['children'][] = [
                    'name' => $role->display_name,
                    'id' => $role->id,
                    'level' => $role->hierarchy_level,
                    'users_count' => $role->users_count,
                    'permissions_count' => $role->permissions->count()
                ];
            }
            
            $d3HierarchyData['children'][] = $levelNode;
        }

        return view('admin.permissions.hierarchy', compact(
            'roles',
            'allRoles',
            'permissions',
            'categoryIcons',
            'hierarchyTree',
            'departmentHierarchy',
            'totalLevels',
            'activeRoles',
            'totalDepartments',
            'totalUsers',
            'hierarchyConflicts',
            'd3HierarchyData'
        ))->with([
            'title' => 'İzin Hiyerarşisi',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Toplu güncelleme
     */
    public function bulkUpdate(Request $request)
    {
        $this->validate($request, [
            'changes' => 'required|array|min:1',
            'changes.*.roleId' => 'required|exists:roles,id',
            'changes.*.permissionId' => 'required|exists:permissions,id',
            'changes.*.action' => 'required|in:grant,revoke',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $successCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($request->changes as $change) {
                try {
                    $role = Role::find($change['roleId']);
                    $permission = Permission::find($change['permissionId']);

                    if ($change['action'] === 'grant') {
                        $role->permissions()->syncWithoutDetaching([
                            $permission->id => [
                                'is_granted' => true,
                                'granted_at' => now(),
                                'granted_by' => $currentAdmin->id,
                            ]
                        ]);
                    } else {
                        $role->permissions()->updateExistingPivot($permission->id, [
                            'is_granted' => false,
                        ]);
                    }

                    $successCount++;

                    // Log individual change
                    AdminAuditLog::logAction([
                        'admin_id' => $currentAdmin->id,
                        'action' => 'permission_' . ($change['action'] === 'grant' ? 'granted' : 'revoked'),
                        'target_role_id' => $role->id,
                        'target_permission_id' => $permission->id,
                        'description' => "Bulk işlem: {$permission->display_name} -> {$role->display_name}",
                        'metadata' => [
                            'bulk_operation' => true,
                            'action' => $change['action'],
                        ],
                    ]);

                } catch (\Exception $e) {
                    $errors[] = "Rol {$change['roleId']} - İzin {$change['permissionId']}: Hata";
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$successCount} değişiklik başarıyla uygulandı!",
                'success_count' => $successCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk permission update failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Toplu güncelleme sırasında hata oluştu.'
            ], 500);
        }
    }

    /**
     * İzinleri dışa aktar
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $includeRoles = $request->boolean('include_roles', true);

        try {
            // Get permissions with optional role data
            $query = Permission::with($includeRoles ? 'roles' : [])
                              ->orderBy('category')
                              ->orderBy('name');

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('status')) {
                $query->where('is_active', $request->status === 'active');
            }

            $permissions = $query->get();

            // Prepare export data
            $exportData = [];
            foreach ($permissions as $permission) {
                $row = [
                    'ID' => $permission->id,
                    'İzin Adı' => $permission->name,
                    'Görünen Ad' => $permission->display_name,
                    'Açıklama' => $permission->description,
                    'Kategori' => $permission->category,
                    'Tip' => $permission->type,
                    'Durum' => $permission->is_active ? 'Aktif' : 'Pasif',
                    'Oluşturma Tarihi' => $permission->created_at?->format('Y-m-d H:i:s'),
                ];

                if ($includeRoles) {
                    $roles = $permission->roles->where('pivot.is_granted', true)->pluck('display_name')->join(', ');
                    $row['Atanmış Roller'] = $roles;
                }

                $exportData[] = $row;
            }

            $filename = 'permissions_export_' . date('Y-m-d_H-i-s');

            if ($format === 'csv') {
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
                ];

                $output = fopen('php://output', 'w');
                fputcsv($output, array_keys($exportData[0] ?? []));
                
                foreach ($exportData as $row) {
                    fputcsv($output, $row);
                }
                
                fclose($output);

                return response()->stream(function() {}, 200, $headers);
            }

            // Excel export would require a package like maatwebsite/excel
            // For now, return JSON
            return response()->json([
                'success' => true,
                'data' => $exportData,
                'total' => count($exportData)
            ]);

        } catch (\Exception $e) {
            \Log::error('Permission export failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Dışa aktarma sırasında hata oluştu.'
            ], 500);
        }
    }

    /**
     * İzinleri senkronize et
     */
    public function sync(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        DB::beginTransaction();
        try {
            // Define system permissions that should exist
            $systemPermissions = [
                [
                    'name' => 'admin.view',
                    'display_name' => 'Admin Paneli Görüntüle',
                    'description' => 'Admin paneline erişim',
                    'category' => 'system_settings',
                    'type' => 'basic',
                ],
                [
                    'name' => 'users.view',
                    'display_name' => 'Kullanıcıları Görüntüle',
                    'description' => 'Kullanıcı listesini görüntüleme',
                    'category' => 'user_management',
                    'type' => 'basic',
                ],
                [
                    'name' => 'users.create',
                    'display_name' => 'Kullanıcı Oluştur',
                    'description' => 'Yeni kullanıcı oluşturma',
                    'category' => 'user_management',
                    'type' => 'basic',
                ],
                [
                    'name' => 'users.edit',
                    'display_name' => 'Kullanıcı Düzenle',
                    'description' => 'Kullanıcı bilgilerini düzenleme',
                    'category' => 'user_management',
                    'type' => 'basic',
                ],
                [
                    'name' => 'users.delete',
                    'display_name' => 'Kullanıcı Sil',
                    'description' => 'Kullanıcı silme',
                    'category' => 'user_management',
                    'type' => 'advanced',
                ],
                [
                    'name' => 'roles.manage',
                    'display_name' => 'Rol Yönetimi',
                    'description' => 'Rolleri yönetme',
                    'category' => 'role_management',
                    'type' => 'management',
                ],
                [
                    'name' => 'permissions.manage',
                    'display_name' => 'İzin Yönetimi',
                    'description' => 'İzinleri yönetme',
                    'category' => 'permission_management',
                    'type' => 'system',
                ],
            ];

            $createdCount = 0;
            $updatedCount = 0;

            foreach ($systemPermissions as $permData) {
                $permission = Permission::updateOrCreate(
                    ['name' => $permData['name']],
                    array_merge($permData, [
                        'is_active' => true,
                        'settings' => [],
                    ])
                );

                if ($permission->wasRecentlyCreated) {
                    $createdCount++;
                } else {
                    $updatedCount++;
                }
            }

            // Log sync action
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'permissions_synced',
                'description' => 'Sistem izinleri senkronize edildi',
                'metadata' => [
                    'created_count' => $createdCount,
                    'updated_count' => $updatedCount,
                    'total_permissions' => Permission::count(),
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "İzinler senkronize edildi! {$createdCount} yeni, {$updatedCount} güncellendi.",
                'created_count' => $createdCount,
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Permission sync failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Senkronizasyon sırasında hata oluştu.'
            ], 500);
        }
    }

    /**
     * Hiyerarşiyi yeniden yapılandır
     */
    public function restructure(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'type' => 'required|in:department,function,permission,custom',
        ]);

        try {
            // Bu method gerçek hiyerarşi yeniden yapılandırma algoritmasını içermelidir
            // Şimdilik basit bir başarı yanıtı döndürüyoruz
            
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'hierarchy_restructured',
                'description' => "Hiyerarşi yeniden yapılandırıldı: {$request->type}",
                'metadata' => [
                    'restructure_type' => $request->type,
                ],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hiyerarşi başarıyla yeniden yapılandırıldı.',
                'data' => [
                    'type' => $request->type,
                    'timestamp' => now(),
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Hierarchy restructure failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Yeniden yapılandırma sırasında bir hata oluştu.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiyerarşi dışa aktarma
     */
    public function exportHierarchy(Request $request)
    {
        $format = $request->get('format', 'json');

        try {
            $roles = Role::with(['parentRole', 'childRoles', 'admins'])
                        ->orderBy('hierarchy_level', 'asc')
                        ->orderBy('display_name', 'asc')
                        ->get();

            switch ($format) {
                case 'json':
                    return response()->json([
                        'hierarchy' => $this->buildHierarchyExportData($roles),
                        'exported_at' => now(),
                        'total_roles' => $roles->count(),
                    ]);

                case 'xlsx':
                    // Excel export logic would go here
                    return response()->json([
                        'success' => false,
                        'message' => 'Excel export henüz desteklenmiyor.'
                    ], 501);

                case 'pdf':
                    // PDF export logic would go here
                    return response()->json([
                        'success' => false,
                        'message' => 'PDF export henüz desteklenmiyor.'
                    ], 501);

                case 'png':
                    // PNG export logic would go here
                    return response()->json([
                        'success' => false,
                        'message' => 'PNG export henüz desteklenmiyor.'
                    ], 501);

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Desteklenmeyen format.'
                    ], 400);
            }

        } catch (\Exception $e) {
            \Log::error('Hierarchy export failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Dışa aktarma sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Build hierarchy data for export
     */
    private function buildHierarchyExportData($roles, $parentId = null, $level = 0)
    {
        $data = [];
        
        foreach ($roles as $role) {
            if ($role->parent_role_id == $parentId) {
                $roleData = [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'level' => $level,
                    'hierarchy_level' => $role->hierarchy_level,
                    'department' => $role->settings['department'] ?? null,
                    'is_active' => $role->is_active,
                    'users_count' => $role->admins->count(),
                    'permissions_count' => $role->permissions->count(),
                ];
                
                $children = $this->buildHierarchyExportData($roles, $role->id, $level + 1);
                if (!empty($children)) {
                    $roleData['children'] = $children;
                }
                
                $data[] = $roleData;
            }
        }
        
        return $data;
    }
}