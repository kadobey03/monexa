<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Role;
use App\Models\AdminGroup;
use App\Models\Settings;
use App\Models\AdminAuditLog;

class AdminManagerController extends Controller
{
    /**
     * Admin yöneticilerini listele (hiyerarşik filtreleme ile)
     */
    public function index(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Base query
        $query = Admin::with(['role', 'supervisor', 'subordinates', 'adminGroup'])
                     ->withCount(['subordinates', 'assignedUsers']);

        // Hierarchy-based filtering
        if (!$currentAdmin->isSuperAdmin()) {
            // Only show admins this user can manage
            $manageableIds = array_merge(
                [$currentAdmin->id],
                $currentAdmin->getAllSubordinates()
            );
            $query->whereIn('id', $manageableIds);
        }

        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('firstName', 'LIKE', "%{$search}%")
                  ->orWhere('lastName', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('employee_id', 'LIKE', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Availability filter
        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('is_available', true);
            } elseif ($request->availability === 'unavailable') {
                $query->where('is_available', false);
            }
        }

        // Performance filter
        if ($request->filled('performance_range')) {
            switch ($request->performance_range) {
                case 'high':
                    $query->where('current_performance', '>=', 80);
                    break;
                case 'medium':
                    $query->whereBetween('current_performance', [50, 79]);
                    break;
                case 'low':
                    $query->where('current_performance', '<', 50);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'firstName');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        $allowedSorts = ['firstName', 'lastName', 'email', 'created_at', 'hierarchy_level', 'current_performance', 'leads_assigned_count'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $admins = $query->paginate(20)->withQueryString();

        // Get filter options
        $roles = Role::active()->orderBy('display_name')->get();
        $departments = Admin::whereNotNull('department')
                           ->distinct()
                           ->pluck('department')
                           ->sort()
                           ->values();

        // Statistics
        $stats = [
            'total_admins' => Admin::count(),
            'active_admins' => Admin::where('status', Admin::STATUS_ACTIVE)->count(),
            'available_admins' => Admin::where('is_available', true)->count(),
            'high_performers' => Admin::where('current_performance', '>=', 80)->count(),
        ];

        return view('admin.managers.index', compact(
            'admins',
            'roles',
            'departments',
            'stats',
            'currentAdmin'
        ))->with([
            'title' => 'Yöneticiler',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni yönetici ekleme formu
     */
    public function create()
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        // Get manageable roles based on hierarchy
        $roles = Role::active()->orderBy('hierarchy_level', 'asc')->get();
        if (!$currentAdmin->isSuperAdmin()) {
            $roles = $roles->filter(function($role) use ($currentAdmin) {
                return !$currentAdmin->role || $currentAdmin->role->canManage($role);
            });
        }

        // Get potential supervisors
        $supervisors = Admin::active()
                          ->whereHas('role', function($q) {
                              $q->where('is_active', true);
                          })
                          ->where('id', '!=', $currentAdmin->id)
                          ->orderBy('firstName')
                          ->get();

        // Get admin groups
        $adminGroups = AdminGroup::where('is_active', true)->orderBy('name')->get();

        $departments = [
            'sales' => 'Satış',
            'retention' => 'Retention',
            'support' => 'Destek',
            'finance' => 'Finans',
            'marketing' => 'Pazarlama',
            'compliance' => 'Uyumluluk',
            'it' => 'IT',
        ];

        return view('admin.managers.create', compact(
            'roles',
            'supervisors',
            'adminGroups',
            'departments'
        ))->with([
            'title' => 'Yeni Yönetici Ekle',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yeni yönetici kaydet
     */
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();

        $this->validate($request, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:50|unique:admins,employee_id',
            'role_id' => [
                'required',
                'exists:roles,id',
                function ($attribute, $value, $fail) use ($currentAdmin) {
                    if (!$currentAdmin->isSuperAdmin()) {
                        $role = Role::find($value);
                        if ($role && (!$currentAdmin->role || !$currentAdmin->role->canManage($role))) {
                            $fail('Bu rolü atama yetkiniz yok.');
                        }
                    }
                },
            ],
            'supervisor_id' => 'nullable|exists:admins,id',
            'admin_group_id' => 'nullable|exists:admin_groups,id',
            'department' => 'required|string',
            'position' => 'nullable|string|max:255',
            'monthly_target' => 'nullable|numeric|min:0',
            'max_leads_per_day' => 'nullable|integer|min:1|max:500',
            'time_zone' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'work_schedule' => 'nullable|array',
            'lead_assignment_rules' => 'nullable|array',
            'preferred_lead_sources' => 'nullable|array',
            'lead_categories' => 'nullable|array',
            'social_links' => 'nullable|array',
            'emergency_contact' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $adminData = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'employee_id' => $request->employee_id,
                'role_id' => $request->role_id,
                'supervisor_id' => $request->supervisor_id,
                'admin_group_id' => $request->admin_group_id,
                'department' => $request->department,
                'position' => $request->position,
                'hired_at' => now(),
                'monthly_target' => $request->monthly_target,
                'max_leads_per_day' => $request->max_leads_per_day ?? 50,
                'time_zone' => $request->time_zone ?? 'Europe/Istanbul',
                'bio' => $request->bio,
                'work_schedule' => $request->work_schedule,
                'lead_assignment_rules' => $request->lead_assignment_rules,
                'preferred_lead_sources' => $request->preferred_lead_sources,
                'lead_categories' => $request->lead_categories,
                'social_links' => $request->social_links,
                'emergency_contact' => $request->emergency_contact,
                'status' => Admin::STATUS_ACTIVE,
                'is_available' => true,
                'dashboard_style' => 'light',
                'notification_preferences' => [
                    'email_notifications' => true,
                    'lead_assignments' => true,
                    'performance_alerts' => true,
                    'system_updates' => true,
                ],
            ];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $adminData['avatar'] = $avatarPath;
            }

            // Set hierarchy level based on supervisor
            if ($request->supervisor_id) {
                $supervisor = Admin::find($request->supervisor_id);
                $adminData['hierarchy_level'] = $supervisor->hierarchy_level + 1;
            } else {
                $role = Role::find($request->role_id);
                $adminData['hierarchy_level'] = $role->hierarchy_level;
            }

            $admin = Admin::create($adminData);

            // Update supervisor's subordinate_ids
            if ($request->supervisor_id) {
                $supervisor = Admin::find($request->supervisor_id);
                $subordinateIds = $supervisor->subordinate_ids ?? [];
                $subordinateIds[] = $admin->id;
                $supervisor->update(['subordinate_ids' => array_unique($subordinateIds)]);
            }

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'admin_created',
                'target_admin_id' => $admin->id,
                'description' => "Yeni yönetici oluşturuldu: {$admin->getFullName()}",
                'metadata' => [
                    'role' => $admin->role?->display_name,
                    'department' => $admin->department,
                    'supervisor' => $admin->supervisor?->getFullName(),
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.managers.index')
                           ->with('success', 'Yönetici başarıyla oluşturuldu!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Yönetici oluşturulurken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Yönetici detayları görüntüle
     */
    public function show(Admin $manager)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($manager) && $currentAdmin->id !== $manager->id) {
            abort(403, 'Bu yöneticinin detaylarını görme yetkiniz yok.');
        }

        $manager->load([
            'role',
            'supervisor',
            'subordinates.role',
            'adminGroup',
            'assignedUsers' => function($query) {
                $query->select('id', 'name', 'email', 'assign_to', 'created_at', 'cstatus')
                      ->orderBy('created_at', 'desc')
                      ->take(10);
            },
            'auditLogs' => function($query) {
                $query->orderBy('created_at', 'desc')
                      ->take(20);
            }
        ]);

        // Get performance metrics
        $performanceData = $manager->getPerformanceMetrics();
        
        // Get activity timeline
        $recentActivity = AdminAuditLog::where('admin_id', $manager->id)
                                     ->orWhere('target_admin_id', $manager->id)
                                     ->with('admin')
                                     ->orderBy('created_at', 'desc')
                                     ->take(15)
                                     ->get();

        return view('admin.managers.show', compact(
            'manager',
            'performanceData',
            'recentActivity'
        ))->with([
            'title' => $manager->getFullName() . ' - Yönetici Detayları',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yönetici düzenleme formu
     */
    public function edit(Admin $manager)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($manager)) {
            abort(403, 'Bu yöneticiyi düzenleme yetkiniz yok.');
        }

        // Get manageable roles based on hierarchy
        $roles = Role::active()->orderBy('hierarchy_level', 'asc')->get();
        if (!$currentAdmin->isSuperAdmin()) {
            $roles = $roles->filter(function($role) use ($currentAdmin) {
                return !$currentAdmin->role || $currentAdmin->role->canManage($role);
            });
        }

        // Get potential supervisors (excluding self and subordinates)
        $excludeIds = array_merge([$manager->id], $manager->getAllSubordinates());
        $supervisors = Admin::active()
                          ->whereNotIn('id', $excludeIds)
                          ->orderBy('firstName')
                          ->get();

        // Get admin groups
        $adminGroups = AdminGroup::where('is_active', true)->orderBy('name')->get();

        $departments = [
            'sales' => 'Satış',
            'retention' => 'Retention',
            'support' => 'Destek',
            'finance' => 'Finans',
            'marketing' => 'Pazarlama',
            'compliance' => 'Uyumluluk',
            'it' => 'IT',
        ];

        return view('admin.managers.edit', compact(
            'manager',
            'roles',
            'supervisors',
            'adminGroups',
            'departments'
        ))->with([
            'title' => $manager->getFullName() . ' - Düzenle',
            'settings' => Settings::first()
        ]);
    }

    /**
     * Yönetici güncelle
     */
    public function update(Request $request, Admin $manager)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($manager)) {
            abort(403, 'Bu yöneticiyi düzenleme yetkiniz yok.');
        }

        $this->validate($request, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($manager->id)
            ],
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'employee_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('admins')->ignore($manager->id)
            ],
            'role_id' => [
                'required',
                'exists:roles,id',
                function ($attribute, $value, $fail) use ($currentAdmin) {
                    if (!$currentAdmin->isSuperAdmin()) {
                        $role = Role::find($value);
                        if ($role && (!$currentAdmin->role || !$currentAdmin->role->canManage($role))) {
                            $fail('Bu rolü atama yetkiniz yok.');
                        }
                    }
                },
            ],
            'supervisor_id' => [
                'nullable',
                'exists:admins,id',
                function ($attribute, $value, $fail) use ($manager) {
                    if ($value && ($value == $manager->id || in_array($value, $manager->getAllSubordinates()))) {
                        $fail('Hiyerarşi döngüsü oluşturulamaz.');
                    }
                },
            ],
            'admin_group_id' => 'nullable|exists:admin_groups,id',
            'department' => 'required|string',
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:' . implode(',', [Admin::STATUS_ACTIVE, Admin::STATUS_INACTIVE, Admin::STATUS_SUSPENDED]),
            'monthly_target' => 'nullable|numeric|min:0',
            'current_performance' => 'nullable|numeric|min:0|max:100',
            'max_leads_per_day' => 'nullable|integer|min:1|max:500',
            'is_available' => 'boolean',
            'time_zone' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $manager->toArray();

            $updateData = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'employee_id' => $request->employee_id,
                'role_id' => $request->role_id,
                'admin_group_id' => $request->admin_group_id,
                'department' => $request->department,
                'position' => $request->position,
                'status' => $request->status,
                'monthly_target' => $request->monthly_target,
                'current_performance' => $request->current_performance,
                'max_leads_per_day' => $request->max_leads_per_day,
                'is_available' => $request->boolean('is_available'),
                'time_zone' => $request->time_zone,
                'bio' => $request->bio,
            ];

            // Handle password update
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($manager->avatar) {
                    Storage::disk('public')->delete($manager->avatar);
                }
                $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            // Handle supervisor change
            if ($request->supervisor_id != $manager->supervisor_id) {
                // Remove from old supervisor's subordinate list
                if ($manager->supervisor_id) {
                    $oldSupervisor = Admin::find($manager->supervisor_id);
                    if ($oldSupervisor) {
                        $subordinateIds = array_diff($oldSupervisor->subordinate_ids ?? [], [$manager->id]);
                        $oldSupervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                    }
                }

                // Add to new supervisor's subordinate list
                if ($request->supervisor_id) {
                    $newSupervisor = Admin::find($request->supervisor_id);
                    $subordinateIds = $newSupervisor->subordinate_ids ?? [];
                    $subordinateIds[] = $manager->id;
                    $newSupervisor->update(['subordinate_ids' => array_unique($subordinateIds)]);
                    
                    // Update hierarchy level
                    $updateData['hierarchy_level'] = $newSupervisor->hierarchy_level + 1;
                } else {
                    // Set hierarchy level based on role
                    $role = Role::find($request->role_id);
                    $updateData['hierarchy_level'] = $role->hierarchy_level;
                }

                $updateData['supervisor_id'] = $request->supervisor_id;
            }

            $manager->update($updateData);

            // Log changes
            $changes = array_diff_assoc($updateData, $oldData);
            if (!empty($changes)) {
                AdminAuditLog::logAction([
                    'admin_id' => $currentAdmin->id,
                    'action' => 'admin_updated',
                    'target_admin_id' => $manager->id,
                    'description' => "Yönetici güncellendi: {$manager->getFullName()}",
                    'metadata' => [
                        'changes' => $changes,
                        'changed_fields' => array_keys($changes),
                    ],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.managers.show', $manager)
                           ->with('success', 'Yönetici bilgileri başarıyla güncellendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin update failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Güncelleme sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Yönetici sil
     */
    public function destroy(Admin $manager)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($manager)) {
            abort(403, 'Bu yöneticiyi silme yetkiniz yok.');
        }

        // Prevent self-deletion
        if ($currentAdmin->id === $manager->id) {
            return redirect()->back()->with('error', 'Kendi hesabınızı silemezsiniz!');
        }

        DB::beginTransaction();
        try {
            // Handle subordinates - reassign to manager's supervisor
            if ($manager->subordinates()->count() > 0) {
                $newSupervisorId = $manager->supervisor_id;
                
                foreach ($manager->subordinates as $subordinate) {
                    $subordinate->update(['supervisor_id' => $newSupervisorId]);
                    
                    // Update new supervisor's subordinate list
                    if ($newSupervisorId) {
                        $newSupervisor = Admin::find($newSupervisorId);
                        $subordinateIds = $newSupervisor->subordinate_ids ?? [];
                        $subordinateIds[] = $subordinate->id;
                        $newSupervisor->update(['subordinate_ids' => array_unique($subordinateIds)]);
                    }
                }
            }

            // Remove from supervisor's subordinate list
            if ($manager->supervisor_id) {
                $supervisor = Admin::find($manager->supervisor_id);
                if ($supervisor) {
                    $subordinateIds = array_diff($supervisor->subordinate_ids ?? [], [$manager->id]);
                    $supervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                }
            }

            // Handle assigned users - reassign to supervisor or unassign
            if ($manager->assignedUsers()->count() > 0) {
                $reassignToId = $manager->supervisor_id;
                $manager->assignedUsers()->update(['assign_to' => $reassignToId]);
            }

            // Delete avatar
            if ($manager->avatar) {
                Storage::disk('public')->delete($manager->avatar);
            }

            $managerName = $manager->getFullName();
            
            // Soft delete the manager
            $manager->delete();

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'admin_deleted',
                'target_admin_id' => $manager->id,
                'description' => "Yönetici silindi: {$managerName}",
                'metadata' => [
                    'deleted_admin' => [
                        'name' => $managerName,
                        'email' => $manager->email,
                        'role' => $manager->role?->display_name,
                        'department' => $manager->department,
                    ],
                ],
            ]);

            DB::commit();

            return redirect()->route('admin.managers.index')
                           ->with('success', 'Yönetici başarıyla silindi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin deletion failed: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Silme işlemi sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Toplu işlemler
     */
    public function bulkAction(Request $request)
    {
        $this->validate($request, [
            'action' => 'required|in:activate,deactivate,change_role,change_department,change_supervisor,delete',
            'admin_ids' => 'required|array|min:1',
            'admin_ids.*' => 'exists:admins,id',
            'role_id' => 'nullable|exists:roles,id',
            'department' => 'nullable|string',
            'supervisor_id' => 'nullable|exists:admins,id',
        ]);

        $currentAdmin = Auth::guard('admin')->user();
        $adminIds = $request->admin_ids;

        // Remove current admin from bulk operations
        $adminIds = array_diff($adminIds, [$currentAdmin->id]);
        
        if (empty($adminIds)) {
            return redirect()->back()->with('error', 'Geçerli yönetici seçilmedi.');
        }

        // Check permissions for each admin
        $admins = Admin::whereIn('id', $adminIds)->get();
        foreach ($admins as $admin) {
            if (!$currentAdmin->canManageAdmin($admin)) {
                return redirect()->back()->with('error', 'Seçilen yöneticilerden bazılarını yönetme yetkiniz yok.');
            }
        }

        DB::beginTransaction();
        try {
            $successCount = 0;
            $action = $request->action;

            foreach ($admins as $admin) {
                switch ($action) {
                    case 'activate':
                        $admin->update(['status' => Admin::STATUS_ACTIVE, 'is_available' => true]);
                        $successCount++;
                        break;

                    case 'deactivate':
                        $admin->update(['status' => Admin::STATUS_INACTIVE, 'is_available' => false]);
                        $successCount++;
                        break;

                    case 'change_role':
                        if ($request->role_id) {
                            $role = Role::find($request->role_id);
                            if (!$currentAdmin->isSuperAdmin() && $currentAdmin->role && !$currentAdmin->role->canManage($role)) {
                                continue 2; // Skip this admin
                            }
                            $admin->update(['role_id' => $request->role_id]);
                            $successCount++;
                        }
                        break;

                    case 'change_department':
                        if ($request->department) {
                            $admin->update(['department' => $request->department]);
                            $successCount++;
                        }
                        break;

                    case 'change_supervisor':
                        // Validate hierarchy
                        if (!$request->supervisor_id || 
                            ($request->supervisor_id != $admin->id && 
                             !in_array($request->supervisor_id, $admin->getAllSubordinates()))) {
                            
                            // Remove from old supervisor
                            if ($admin->supervisor_id) {
                                $oldSupervisor = Admin::find($admin->supervisor_id);
                                if ($oldSupervisor) {
                                    $subordinateIds = array_diff($oldSupervisor->subordinate_ids ?? [], [$admin->id]);
                                    $oldSupervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                                }
                            }

                            // Add to new supervisor
                            if ($request->supervisor_id) {
                                $newSupervisor = Admin::find($request->supervisor_id);
                                $subordinateIds = $newSupervisor->subordinate_ids ?? [];
                                $subordinateIds[] = $admin->id;
                                $newSupervisor->update(['subordinate_ids' => array_unique($subordinateIds)]);
                            }

                            $admin->update(['supervisor_id' => $request->supervisor_id]);
                            $successCount++;
                        }
                        break;

                    case 'delete':
                        // Handle subordinates and assigned users
                        foreach ($admin->subordinates as $subordinate) {
                            $subordinate->update(['supervisor_id' => $admin->supervisor_id]);
                        }
                        
                        $admin->assignedUsers()->update(['assign_to' => $admin->supervisor_id]);
                        
                        // Delete avatar
                        if ($admin->avatar) {
                            Storage::disk('public')->delete($admin->avatar);
                        }
                        
                        $admin->delete();
                        $successCount++;
                        break;
                }
            }

            // Log bulk action
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'bulk_admin_action',
                'description' => "Toplu işlem gerçekleştirildi: {$action}",
                'metadata' => [
                    'action' => $action,
                    'affected_count' => $successCount,
                    'admin_ids' => $adminIds,
                ],
            ]);

            DB::commit();

            $actionNames = [
                'activate' => 'aktifleştirildi',
                'deactivate' => 'devre dışı bırakıldı',
                'change_role' => 'rolü değiştirildi',
                'change_department' => 'departmanı değiştirildi',
                'change_supervisor' => 'süpervizörü değiştirildi',
                'delete' => 'silindi',
            ];

            $actionName = $actionNames[$action] ?? 'güncellendi';

            return redirect()->back()->with('success', "{$successCount} yönetici {$actionName}!");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Bulk admin action failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Toplu işlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }
}