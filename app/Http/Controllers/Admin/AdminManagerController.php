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

        // Get supervisor options based on organizational role structure
        $supervisors = $this->getSupervisorOptions($currentAdmin);

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
            'supervisors',
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
    public function show(Admin $manager = null)
    {
        // Defensive coding: Check if manager exists
        if (!$manager || !$manager->exists) {
            return redirect()->route('admin.managers.index')
                           ->with('error', 'Aradığınız yönetici bulunamadı. Yönetici silinmiş veya mevcut olmayabilir.');
        }

        $currentAdmin = Auth::guard('admin')->user();

        // Additional null check for current admin
        if (!$currentAdmin) {
            return redirect()->route('admin.login')
                           ->with('error', 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.');
        }

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
    public function edit(Admin $manager = null)
    {
        // Defensive coding: Check if manager exists
        if (!$manager || !$manager->exists) {
            return redirect()->route('admin.managers.index')
                           ->with('error', 'Düzenlemek istediğiniz yönetici bulunamadı. Yönetici silinmiş veya mevcut olmayabilir.');
        }

        $currentAdmin = Auth::guard('admin')->user();

        // Additional null check for current admin
        if (!$currentAdmin) {
            return redirect()->route('admin.login')
                           ->with('error', 'Oturum süresi dolmuş. Lütfen tekrar giriş yapın.');
        }

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
     * AJAX için yönetici verilerini döndür
     */
    public function editData(Admin $admin)
    {
        \Log::info('🚀 DEBUG: editData method called');
        \Log::info('🚀 DEBUG: Admin parameter received:', [
            'id' => $admin?->id ?? 'null',
            'exists' => $admin?->exists ?? 'null',
            'firstName' => $admin?->firstName ?? 'null',
        ]);
        
        $currentAdmin = Auth::guard('admin')->user();
        \Log::info('🚀 DEBUG: Current admin:', [
            'id' => $currentAdmin?->id ?? 'null',
            'type' => $currentAdmin?->type ?? 'null',
            'role' => $currentAdmin?->role?->name ?? 'none',
        ]);

        // Check permissions
        if (!$currentAdmin->canManageAdmin($admin)) {
            \Log::warning('🚨 DEBUG: Permission denied for editing admin');
            return response()->json([
                'success' => false,
                'message' => 'Bu yöneticiyi düzenleme yetkiniz yok.'
            ], 403);
        }

        $admin->load(['role', 'supervisor']);
        \Log::info('🚀 DEBUG: Admin loaded with relations:', [
            'admin_id' => $admin->id,
            'role_id' => $admin->role_id,
            'supervisor_id' => $admin->supervisor_id,
            'role_name' => $admin->role?->display_name ?? 'none',
            'supervisor_name' => $admin->supervisor?->getFullName() ?? 'none',
        ]);

        // Get supervisor options based on current admin's organizational hierarchy permissions
        $supervisors = $this->getSupervisorOptions($currentAdmin);
        \Log::info('🚀 DEBUG: Supervisor options loaded:', [
            'count' => $supervisors->count(),
            'supervisor_ids' => $supervisors->pluck('id')->toArray(),
        ]);

        $responseData = [
            'success' => true,
            'manager' => [
                'id' => $admin->id,
                'firstName' => $admin->firstName,
                'lastName' => $admin->lastName,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'role_id' => $admin->role_id,
                'supervisor_id' => $admin->supervisor_id,
                'department' => $admin->department,
                'status' => $admin->status,
            ],
            'supervisors' => $supervisors->map(function($supervisor) {
                return [
                    'id' => $supervisor->id,
                    'name' => $supervisor->getFullName(),
                    'role' => $supervisor->role?->display_name ?? 'Belirsiz',
                    'department' => $supervisor->department,
                ];
            })
        ];
        
        \Log::info('🚀 DEBUG: Response data prepared:', [
            'manager_id' => $responseData['manager']['id'],
            'supervisors_count' => count($responseData['supervisors']),
        ]);
        return response()->json($responseData);
    }

    /**
     * Yönetici güncelle
     */
    public function update(Request $request, Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        \Log::info('🚀 DEBUG: update method called', [
            'admin_id' => $admin?->id ?? 'null',
            'request_data' => $request->all(),
        ]);

        // Check permissions
        if (!$currentAdmin->canManageAdmin($admin)) {
            \Log::warning('🚨 DEBUG: Permission denied for updating admin');
            abort(403, 'Bu yöneticiyi düzenleme yetkiniz yok.');
        }

        $this->validate($request, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id)
            ],
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'employee_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('admins')->ignore($admin->id)
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
                function ($attribute, $value, $fail) use ($admin) {
                    if ($value && ($value == $admin->id || in_array($value, $admin->getAllSubordinates()))) {
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
            $oldData = $admin->toArray();

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
                'current_performance' => $request->current_performance ?? $admin->current_performance ?? 0,
                'max_leads_per_day' => $request->max_leads_per_day,
                'is_available' => $request->boolean('is_available'),
                'time_zone' => $request->time_zone ?? $admin->time_zone ?? 'Europe/Istanbul',
                'bio' => $request->bio,
            ];

            // Handle password update
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($admin->avatar) {
                    Storage::disk('public')->delete($admin->avatar);
                }
                $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            // Handle supervisor change
            if ($request->supervisor_id != $admin->supervisor_id) {
                // Remove from old supervisor's subordinate list
                if ($admin->supervisor_id) {
                    $oldSupervisor = Admin::find($admin->supervisor_id);
                    if ($oldSupervisor) {
                        $subordinateIds = array_diff($oldSupervisor->subordinate_ids ?? [], [$admin->id]);
                        $oldSupervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                    }
                }

                // Add to new supervisor's subordinate list
                if ($request->supervisor_id) {
                    $newSupervisor = Admin::find($request->supervisor_id);
                    $subordinateIds = $newSupervisor->subordinate_ids ?? [];
                    $subordinateIds[] = $admin->id;
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

            $admin->update($updateData);

            // Log changes
            $changes = array_diff_assoc($updateData, $oldData);
            if (!empty($changes)) {
                AdminAuditLog::logAction([
                    'admin_id' => $currentAdmin->id,
                    'action' => 'admin_updated',
                    'description' => "Yönetici güncellendi: {$admin->getFullName()}",
                    'metadata' => [
                        'target_admin_id' => $admin->id,
                        'changes' => $changes,
                        'changed_fields' => array_keys($changes),
                    ],
                ]);
            }

            DB::commit();

            // Check if this is an AJAX request
            if ($request->wantsJson() || $request->ajax()) {
                \Log::info('🚀 DEBUG: Returning JSON response');
                return response()->json([
                    'success' => true,
                    'message' => 'Yönetici bilgileri başarıyla güncellendi!',
                    'manager' => $admin->fresh(['role', 'supervisor'])
                ]);
            }

            return redirect()->route('admin.managers.show', $admin)
                           ->with('success', 'Yönetici bilgileri başarıyla güncellendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin update failed: ' . $e->getMessage());
            
            // Check if this is an AJAX request for error handling
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Güncelleme sırasında bir hata oluştu. Lütfen tekrar deneyin.'
                ], 500);
            }
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Güncelleme sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * AJAX Yönetici güncelle - Workaround
     */
    public function updateAjax(Request $request, Admin $admin)
    {
        \Log::info('🚀 DEBUG: updateAjax method called', [
            'admin_id' => $admin?->id ?? 'null',
            'request_data' => $request->all(),
        ]);

        return $this->update($request, $admin);
    }

    /**
     * Yönetici sil
     */
    public function destroy(Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($admin)) {
            abort(403, 'Bu yöneticiyi silme yetkiniz yok.');
        }

        // Prevent self-deletion
        if ($currentAdmin->id === $admin->id) {
            return redirect()->back()->with('error', 'Kendi hesabınızı silemezsiniz!');
        }

        DB::beginTransaction();
        try {
            // Handle subordinates - reassign to admin's supervisor
            if ($admin->subordinates()->count() > 0) {
                $newSupervisorId = $admin->supervisor_id;
                
                foreach ($admin->subordinates as $subordinate) {
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
            if ($admin->supervisor_id) {
                $supervisor = Admin::find($admin->supervisor_id);
                if ($supervisor) {
                    $subordinateIds = array_diff($supervisor->subordinate_ids ?? [], [$admin->id]);
                    $supervisor->update(['subordinate_ids' => array_values($subordinateIds)]);
                }
            }

            // Handle assigned users - reassign to supervisor or unassign
            if ($admin->assignedUsers()->count() > 0) {
                $reassignToId = $admin->supervisor_id;
                $admin->assignedUsers()->update(['assign_to' => $reassignToId]);
            }

            // Delete avatar
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar);
            }

            $adminName = $admin->getFullName();
            
            // Soft delete the admin
            $admin->delete();

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'admin_deleted',
                'target_admin_id' => $admin->id,
                'description' => "Yönetici silindi: {$adminName}",
                'metadata' => [
                    'deleted_admin' => [
                        'name' => $adminName,
                        'email' => $admin->email,
                        'role' => $admin->role?->display_name,
                        'department' => $admin->department,
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

    /**
     * Get supervisor options based on organizational hierarchy
     */
    protected function getSupervisorOptions(Admin $currentAdmin)
    {
        $supervisors = collect();
        
        if (!$currentAdmin->role) {
            return $supervisors;
        }

        $currentRole = $currentAdmin->role->name;
        $currentHierarchyLevel = $currentAdmin->role->hierarchy_level;

        switch ($currentRole) {
            case 'head_of_office':
                // Head of office can see everyone (for reorganizing purposes)
                $supervisors = Admin::active()
                    ->whereHas('role', function($q) {
                        $q->where('is_active', true);
                    })
                    ->orderBy('firstName')
                    ->get();
                break;

            case 'sales_head':
            case 'retention_head':
                // Heads can only see Head Of Office and their own team
                $supervisors = Admin::active()
                    ->whereHas('role', function($q) {
                        $q->where('is_active', true)
                          ->where(function($q2) {
                              $q2->where('name', 'head_of_office') // Can report to Head Of Office
                                 ->orWhere('hierarchy_level', '>=', 2); // Or see their own level and below
                          });
                    })
                    ->where(function($q) use ($currentAdmin) {
                        $q->where('supervisor_id', $currentAdmin->supervisor_id) // Same branch
                          ->orWhere('id', $currentAdmin->supervisor_id) // Their supervisor (Head Of Office)
                          ->orWhere('supervisor_id', $currentAdmin->id); // Their subordinates
                    })
                    ->orderBy('firstName')
                    ->get();
                break;

            case 'team_leader':
            case 'retention_team_leader':
                // Team leaders can only see their Head and Head Of Office
                $supervisors = Admin::active()
                    ->whereHas('role', function($q) {
                        $q->where('is_active', true)
                          ->whereIn('name', ['head_of_office', 'sales_head', 'retention_head']);
                    })
                    ->where(function($q) use ($currentAdmin) {
                        $q->where('id', $currentAdmin->supervisor_id) // Their Head
                          ->orWhereHas('role', function($q2) {
                              $q2->where('name', 'head_of_office'); // Head Of Office
                          });
                    })
                    ->orderBy('firstName')
                    ->get();
                break;

            case 'sales_agent':
            case 'retention_agent':
                // Sales agents can only see their Team Leader
                $supervisors = Admin::active()
                    ->whereHas('role', function($q) {
                        $q->where('is_active', true)
                          ->whereIn('name', ['team_leader', 'retention_team_leader']);
                    })
                    ->where(function($q) use ($currentAdmin) {
                        $q->where('id', $currentAdmin->supervisor_id) // Their Team Leader
                          ->orWhere('supervisor_id', $currentAdmin->supervisor_id); // Same team
                    })
                    ->orderBy('firstName')
                    ->get();
                break;

            default:
                // For other roles, use basic hierarchy level filtering
                $supervisors = Admin::active()
                    ->whereHas('role', function($q) use ($currentHierarchyLevel) {
                        $q->where('is_active', true)
                          ->where('hierarchy_level', '<', $currentHierarchyLevel);
                    })
                    ->orderBy('firstName')
                    ->get();
                break;
        }

        return $supervisors;
    }

    /**
     * Reset admin password and return it for display (POST method)
     */
    public function resetPasswordPost(Request $request, Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();

        // Check permissions
        if (!$currentAdmin->canManageAdmin($admin)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu yöneticinin şifresini sıfırlama yetkiniz yok.'
            ], 403);
        }

        // Prevent self password reset via this method (security)
        if ($currentAdmin->id === $admin->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bu yöntemle kendi şifrenizi sıfırlayamazsınız.'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Generate secure password
            $newPassword = $this->generateSecurePassword();
            
            // Update admin password
            $admin->update([
                'password' => Hash::make($newPassword),
                'password_changed_at' => now(),
            ]);

            // Log activity
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'action' => 'admin_password_reset',
                'description' => "Yönetici şifresi sıfırlandı: {$admin->getFullName()}",
                'metadata' => [
                    'target_admin_id' => $admin->id,
                    'target_admin_name' => $admin->getFullName(),
                    'target_admin_email' => $admin->email,
                    'reset_method' => 'admin_panel_display',
                    'reset_by' => $currentAdmin->getFullName(),
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'newPassword' => $newPassword,
                'message' => 'Şifre başarıyla sıfırlandı ve aşağıda görüntülendi.',
                'adminName' => $admin->getFullName(),
                'adminEmail' => $admin->email
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin password reset failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Şifre sıfırlama sırasında bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }

    /**
     * Generate a secure password for admin
     */
    private function generateSecurePassword($length = 12)
    {
        // Character sets for secure password generation
        $uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lowercase = 'abcdefghjkmnpqrstuvwxyz';
        $numbers = '23456789';
        $symbols = '!@#$%^&*';

        // Ensure at least one character from each set
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Fill remaining length with random characters from all sets
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password to randomize character positions
        return str_shuffle($password);
    }
}