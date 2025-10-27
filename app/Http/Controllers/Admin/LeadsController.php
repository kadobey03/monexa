<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\LeadActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\LeadAssignmentHistory;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class LeadsController extends Controller
{
    /**
     * Display leads dashboard
     */
    public function index(Request $request)
    {
        Log::info('🪲 DEBUG: LeadsController@index called', [
            'admin_id' => Auth::guard('admin')->id(),
            'request_uri' => $request->getUri(),
            'request_method' => $request->getMethod(),
            'user_agent' => $request->userAgent(),
            'session_id' => session()->getId()
        ]);

        return view('admin.leads', [
            'title' => 'Lead Yönetimi'
        ]);
    }

    /**
     * API endpoint for dynamic table - Get leads data with advanced filtering
     * GET /admin/leads/api
     */
    public function api(Request $request): JsonResponse
    {
        try {
            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';
            
            // Base query for leads (users who are not customers yet)
            $query = User::with(['leadStatus', 'assignedAdmin', 'leadSource'])
                        ->where(function($q) {
                            $q->whereNull('cstatus')
                              ->orWhere('cstatus', '!=', 'Customer');
                        });

            // Admin level filtering
            if (!$isSuperAdmin) {
                $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                
                $query->whereIn('assign_to', $allowedAdminIds);
            }

            // Apply filters
            $this->applyFilters($query, $request);

            // Get total count before pagination
            $totalCount = $query->count();

            // Apply sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            $query->orderBy($sortBy, $sortDirection);

            // Apply pagination
            $perPage = min($request->get('per_page', 25), 100);
            $page = $request->get('page', 1);
            $leads = $query->paginate($perPage);

            // Transform leads data
            $transformedLeads = $leads->map(function($lead) {
                return [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'country' => $lead->country,
                    'status' => $lead->leadStatus ? [
                        'id' => $lead->leadStatus->id,
                        'name' => $lead->leadStatus->name,
                        'display_name' => $lead->leadStatus->display_name,
                        'color' => $lead->leadStatus->color
                    ] : null,
                    'priority' => $lead->lead_priority,
                    'lead_score' => $lead->lead_score ?? 0,
                    'conversion_probability' => $lead->conversion_probability ?? 0,
                    'assigned_to' => $lead->assignedAdmin ? [
                        'id' => $lead->assignedAdmin->id,
                        'name' => $lead->assignedAdmin->firstName . ' ' . $lead->assignedAdmin->lastName,
                        'email' => $lead->assignedAdmin->email
                    ] : null,
                    'source' => $lead->leadSource ? [
                        'id' => $lead->leadSource->id,
                        'name' => $lead->leadSource->name
                    ] : ($lead->lead_source ? ['name' => $lead->lead_source] : null),
                    'tags' => $lead->lead_tags ? json_decode($lead->lead_tags, true) : [],
                    'notes' => $lead->lead_notes,
                    'created_at' => $lead->created_at->toISOString(),
                    'updated_at' => $lead->updated_at->toISOString(),
                    'last_contact_date' => $lead->last_contact_date?->toISOString(),
                    'next_follow_up_date' => $lead->next_follow_up_date?->toISOString(),
                    'estimated_value' => $lead->estimated_value,
                    'is_verified' => $lead->phone_verified || $lead->email_verified,
                    'is_premium' => $lead->account_type === 'premium'
                ];
            });

            // Get statistics
            $stats = $this->getLeadsStatistics($isSuperAdmin, $adminUser);

            // Get filter options
            $leadStatuses = LeadStatus::active()->get(['id', 'name', 'display_name', 'color']);
            $leadSources = LeadSource::active()->get(['id', 'name']);
            $admins = $isSuperAdmin ? 
                Admin::where('status', 'Active')->orderBy('firstName')->get(['id', 'firstName', 'lastName', 'email']) : 
                Admin::where(function($q) use ($adminUser) {
                    $q->where('id', $adminUser->id)
                      ->orWhere('parent_id', $adminUser->id);
                })->where('status', 'Active')->orderBy('firstName')->get(['id', 'firstName', 'lastName', 'email']);

            return response()->json([
                'success' => true,
                'data' => $transformedLeads,
                'pagination' => [
                    'current_page' => $leads->currentPage(),
                    'per_page' => $leads->perPage(),
                    'total' => $leads->total(),
                    'last_page' => $leads->lastPage(),
                    'from' => $leads->firstItem(),
                    'to' => $leads->lastItem()
                ],
                'filtered_count' => $totalCount,
                'total_count' => User::where(function($q) {
                    $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                })->count(),
                'lead_sources' => $leadSources,
                'lead_statuses' => $leadStatuses,
                'admin_users' => $admins->map(function($admin) {
                    return [
                        'id' => $admin->id,
                        'name' => $admin->firstName . ' ' . $admin->lastName,
                        'email' => $admin->email
                    ];
                }),
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch leads API data', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch leads data.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Store a new lead
     * POST /admin/leads
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',
                'status' => 'nullable|exists:lead_statuses,id',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'lead_source_id' => 'nullable|exists:lead_sources,id',
                'assigned_to' => 'nullable|exists:admins,id',
                'lead_score' => 'nullable|integer|min:0|max:100',
                'conversion_probability' => 'nullable|integer|min:0|max:100',
                'estimated_value' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
                'is_verified' => 'nullable|boolean',
                'is_premium' => 'nullable|boolean'
            ]);

            $adminUser = Auth::guard('admin')->user();

            DB::beginTransaction();

            $leadData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'lead_status_id' => $request->status ?? 1,
                'lead_priority' => $request->priority ?? 'medium',
                'lead_source_id' => $request->lead_source_id,
                'assign_to' => $request->assigned_to,
                'lead_score' => $request->lead_score ?? 0,
                'conversion_probability' => $request->conversion_probability ?? 0,
                'estimated_value' => $request->estimated_value,
                'lead_notes' => $request->notes,
                'lead_tags' => $request->tags ? json_encode($request->tags) : null,
                'account_type' => $request->is_premium ? 'premium' : 'lead',
                'phone_verified' => $request->is_verified ?? false,
                'email_verified' => $request->is_verified ?? false,
                'created_by_admin_id' => $adminUser->id
            ];

            $lead = User::create($leadData);

            // Add initial activity
            if ($lead->id) {
                LeadActivity::create([
                    'user_id' => $lead->id,
                    'admin_id' => $adminUser->id,
                    'type' => 'created',
                    'description' => 'Lead oluşturuldu',
                    'metadata' => json_encode([
                        'created_by' => $adminUser->firstName . ' ' . $adminUser->lastName,
                        'initial_status' => $leadData['lead_status_id']
                    ])
                ]);
            }

            DB::commit();

            Log::info('Lead created via API', [
                'admin_id' => $adminUser->id,
                'lead_id' => $lead->id,
                'lead_name' => $lead->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead başarıyla oluşturuldu',
                'data' => $lead->load(['leadStatus', 'assignedAdmin', 'leadSource'])
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create lead', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead oluşturulamadı'
            ], 500);
        }
    }

    /**
     * Update an existing lead
     * PUT /admin/leads/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',
                'status' => 'nullable|exists:lead_statuses,id',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'lead_source_id' => 'nullable|exists:lead_sources,id',
                'assigned_to' => 'nullable|exists:admins,id',
                'lead_score' => 'nullable|integer|min:0|max:100',
                'conversion_probability' => 'nullable|integer|min:0|max:100',
                'estimated_value' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
                'is_verified' => 'nullable|boolean',
                'is_premium' => 'nullable|boolean'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';

            $lead = User::where('id', $id)
                       ->where(function($q) {
                           $q->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                       })->firstOrFail();

            // Check permissions
            if (!$isSuperAdmin) {
                $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                
                if ($lead->assign_to && !in_array($lead->assign_to, $allowedAdminIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu lead\'i düzenleme yetkiniz yok'
                    ], 403);
                }
            }

            DB::beginTransaction();

            $oldData = $lead->toArray();
            $changes = [];

            $updateData = [];
            if ($request->has('name')) $updateData['name'] = $request->name;
            if ($request->has('email')) $updateData['email'] = $request->email;
            if ($request->has('phone')) $updateData['phone'] = $request->phone;
            if ($request->has('country')) $updateData['country'] = $request->country;
            if ($request->has('status')) $updateData['lead_status_id'] = $request->status;
            if ($request->has('priority')) $updateData['lead_priority'] = $request->priority;
            if ($request->has('lead_source_id')) $updateData['lead_source_id'] = $request->lead_source_id;
            if ($request->has('assigned_to')) $updateData['assign_to'] = $request->assigned_to;
            if ($request->has('lead_score')) $updateData['lead_score'] = $request->lead_score;
            if ($request->has('conversion_probability')) $updateData['conversion_probability'] = $request->conversion_probability;
            if ($request->has('estimated_value')) $updateData['estimated_value'] = $request->estimated_value;
            if ($request->has('notes')) $updateData['lead_notes'] = $request->notes;
            if ($request->has('tags')) $updateData['lead_tags'] = json_encode($request->tags);
            if ($request->has('is_premium')) $updateData['account_type'] = $request->is_premium ? 'premium' : 'lead';
            if ($request->has('is_verified')) {
                $updateData['phone_verified'] = $request->is_verified;
                $updateData['email_verified'] = $request->is_verified;
            }

            $lead->update($updateData);

            // Track changes for activity log
            foreach ($updateData as $key => $newValue) {
                if ($oldData[$key] != $newValue) {
                    $changes[$key] = ['from' => $oldData[$key], 'to' => $newValue];
                }
            }

            // Add activity if there are changes
            if (!empty($changes)) {
                LeadActivity::create([
                    'user_id' => $lead->id,
                    'admin_id' => $adminUser->id,
                    'type' => 'updated',
                    'description' => 'Lead bilgileri güncellendi',
                    'metadata' => json_encode([
                        'changes' => $changes,
                        'updated_by' => $adminUser->firstName . ' ' . $adminUser->lastName
                    ])
                ]);
            }

            DB::commit();

            Log::info('Lead updated via API', [
                'admin_id' => $adminUser->id,
                'lead_id' => $lead->id,
                'changes' => array_keys($changes)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead başarıyla güncellendi',
                'data' => $lead->fresh(['leadStatus', 'assignedAdmin', 'leadSource'])
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update lead', [
                'admin_id' => Auth::guard('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead güncellenemedi'
            ], 500);
        }
    }

    /**
     * Delete a lead
     * DELETE /admin/leads/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';

            $lead = User::where('id', $id)
                       ->where(function($q) {
                           $q->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                       })->firstOrFail();

            // Check permissions
            if (!$isSuperAdmin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead silme yetkiniz yok'
                ], 403);
            }

            DB::beginTransaction();

            // Add deletion activity before deleting
            LeadActivity::create([
                'user_id' => $lead->id,
                'admin_id' => $adminUser->id,
                'type' => 'deleted',
                'description' => 'Lead silindi',
                'metadata' => json_encode([
                    'deleted_by' => $adminUser->firstName . ' ' . $adminUser->lastName,
                    'deleted_lead_name' => $lead->name
                ])
            ]);

            $leadName = $lead->name;
            $lead->delete();

            DB::commit();

            Log::info('Lead deleted via API', [
                'admin_id' => $adminUser->id,
                'lead_id' => $id,
                'lead_name' => $leadName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead başarıyla silindi'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete lead', [
                'admin_id' => Auth::guard('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead silinemedi'
            ], 500);
        }
    }

    /**
     * Bulk update status
     * POST /admin/leads/bulk-update-status
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'lead_ids' => 'required|array|min:1',
                'lead_ids.*' => 'exists:users,id',
                'status' => 'required|exists:lead_statuses,id'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $updated = 0;

            DB::beginTransaction();

            foreach ($request->lead_ids as $leadId) {
                $lead = User::where('id', $leadId)
                           ->where(function($q) {
                               $q->whereNull('cstatus')
                                 ->orWhere('cstatus', '!=', 'Customer');
                           })->first();

                if ($lead) {
                    $oldStatus = $lead->lead_status_id;
                    $lead->update(['lead_status_id' => $request->status]);

                    // Add activity
                    LeadActivity::create([
                        'user_id' => $lead->id,
                        'admin_id' => $adminUser->id,
                        'type' => 'status_updated',
                        'description' => 'Durum toplu güncelleme ile değiştirildi',
                        'metadata' => json_encode([
                            'old_status' => $oldStatus,
                            'new_status' => $request->status,
                            'updated_by' => $adminUser->firstName . ' ' . $adminUser->lastName
                        ])
                    ]);

                    $updated++;
                }
            }

            DB::commit();

            Log::info('Bulk status update completed', [
                'admin_id' => $adminUser->id,
                'updated_count' => $updated,
                'total_requested' => count($request->lead_ids)
            ]);

            return response()->json([
                'success' => true,
                'updated' => $updated,
                'message' => "{$updated} lead'in durumu güncellendi"
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk status update failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Toplu durum güncellemesi başarısız'
            ], 500);
        }
    }

    /**
     * Bulk assign leads
     * POST /admin/leads/bulk-assign
     */
    public function bulkAssign(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'lead_ids' => 'required|array|min:1',
                'lead_ids.*' => 'exists:users,id',
                'admin_id' => 'nullable|exists:admins,id'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';
            $assigned = 0;

            // Check assignment permission
            if ($request->admin_id && !$isSuperAdmin) {
                $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                
                if (!in_array($request->admin_id, $allowedAdminIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu admin\'e atama yapma yetkiniz yok'
                    ], 403);
                }
            }

            DB::beginTransaction();

            foreach ($request->lead_ids as $leadId) {
                $lead = User::where('id', $leadId)
                           ->where(function($q) {
                               $q->whereNull('cstatus')
                                 ->orWhere('cstatus', '!=', 'Customer');
                           })->first();

                if ($lead) {
                    $oldAdminId = $lead->assign_to;
                    $lead->update(['assign_to' => $request->admin_id]);

                    // Add activity
                    $assignedAdminName = $request->admin_id ? 
                        Admin::find($request->admin_id)->firstName . ' ' . Admin::find($request->admin_id)->lastName : 
                        'Atanmamış';

                    LeadActivity::create([
                        'user_id' => $lead->id,
                        'admin_id' => $adminUser->id,
                        'type' => 'assigned',
                        'description' => 'Lead atama toplu işlem ile değiştirildi',
                        'metadata' => json_encode([
                            'old_admin_id' => $oldAdminId,
                            'new_admin_id' => $request->admin_id,
                            'new_admin_name' => $assignedAdminName,
                            'assigned_by' => $adminUser->firstName . ' ' . $adminUser->lastName
                        ])
                    ]);

                    $assigned++;
                }
            }

            DB::commit();

            Log::info('Bulk assignment completed', [
                'admin_id' => $adminUser->id,
                'assigned_count' => $assigned,
                'target_admin_id' => $request->admin_id
            ]);

            return response()->json([
                'success' => true,
                'assigned' => $assigned,
                'message' => "{$assigned} lead atandı"
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk assignment failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Toplu atama başarısız'
            ], 500);
        }
    }

    /**
     * Bulk add tags
     * POST /admin/leads/bulk-add-tags
     */
    public function bulkAddTags(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'lead_ids' => 'required|array|min:1',
                'lead_ids.*' => 'exists:users,id',
                'tags' => 'required|array|min:1',
                'tags.*' => 'string|max:50'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $updated = 0;

            DB::beginTransaction();

            foreach ($request->lead_ids as $leadId) {
                $lead = User::where('id', $leadId)
                           ->where(function($q) {
                               $q->whereNull('cstatus')
                                 ->orWhere('cstatus', '!=', 'Customer');
                           })->first();

                if ($lead) {
                    $existingTags = $lead->lead_tags ? json_decode($lead->lead_tags, true) : [];
                    $newTags = array_unique(array_merge($existingTags, $request->tags));
                    
                    $lead->update(['lead_tags' => json_encode($newTags)]);

                    // Add activity
                    LeadActivity::create([
                        'user_id' => $lead->id,
                        'admin_id' => $adminUser->id,
                        'type' => 'tags_added',
                        'description' => 'Etiketler toplu işlem ile eklendi',
                        'metadata' => json_encode([
                            'added_tags' => $request->tags,
                            'added_by' => $adminUser->firstName . ' ' . $adminUser->lastName
                        ])
                    ]);

                    $updated++;
                }
            }

            DB::commit();

            Log::info('Bulk tag addition completed', [
                'admin_id' => $adminUser->id,
                'updated_count' => $updated,
                'added_tags' => $request->tags
            ]);

            return response()->json([
                'success' => true,
                'updated' => $updated,
                'message' => "{$updated} lead'e etiket eklendi"
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk tag addition failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Toplu etiket ekleme başarısız'
            ], 500);
        }
    }

    /**
     * Bulk delete leads
     * DELETE /admin/leads/bulk-delete
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'lead_ids' => 'required|array|min:1',
                'lead_ids.*' => 'exists:users,id'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';

            if (!$isSuperAdmin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Toplu silme işlemi için süper admin yetkisi gerekli'
                ], 403);
            }

            $deleted = 0;

            DB::beginTransaction();

            foreach ($request->lead_ids as $leadId) {
                $lead = User::where('id', $leadId)
                           ->where(function($q) {
                               $q->whereNull('cstatus')
                                 ->orWhere('cstatus', '!=', 'Customer');
                           })->first();

                if ($lead) {
                    // Add deletion activity before deleting
                    LeadActivity::create([
                        'user_id' => $lead->id,
                        'admin_id' => $adminUser->id,
                        'type' => 'deleted',
                        'description' => 'Lead toplu silme ile silindi',
                        'metadata' => json_encode([
                            'deleted_by' => $adminUser->firstName . ' ' . $adminUser->lastName,
                            'deleted_lead_name' => $lead->name
                        ])
                    ]);

                    $lead->delete();
                    $deleted++;
                }
            }

            DB::commit();

            Log::info('Bulk deletion completed', [
                'admin_id' => $adminUser->id,
                'deleted_count' => $deleted
            ]);

            return response()->json([
                'success' => true,
                'deleted' => $deleted,
                'message' => "{$deleted} lead silindi"
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk deletion failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Toplu silme başarısız'
            ], 500);
        }
    }

    /**
     * Add activity to lead
     * POST /admin/leads/{id}/activities
     */
    public function addActivity(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'type' => 'required|in:call,email,meeting,note,sms,whatsapp',
                'description' => 'required|string|max:1000'
            ]);

            $adminUser = Auth::guard('admin')->user();
            $lead = User::findOrFail($id);

            $activity = LeadActivity::create([
                'user_id' => $lead->id,
                'admin_id' => $adminUser->id,
                'type' => $request->type,
                'description' => $request->description,
                'metadata' => json_encode([
                    'added_by' => $adminUser->firstName . ' ' . $adminUser->lastName,
                    'admin_name' => $adminUser->firstName . ' ' . $adminUser->lastName
                ])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Aktivite eklendi',
                'data' => [
                    'id' => $activity->id,
                    'type' => $activity->type,
                    'description' => $activity->description,
                    'created_at' => $activity->created_at->toISOString(),
                    'admin_name' => $adminUser->firstName . ' ' . $adminUser->lastName
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Failed to add activity', [
                'admin_id' => Auth::guard('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Aktivite eklenemedi'
            ], 500);
        }
    }

    /**
     * Export leads
     * GET /admin/leads/export
     */
    public function export(Request $request)
    {
        try {
            $adminUser = Auth::guard('admin')->user();
            $isSuperAdmin = $adminUser->type === 'Super Admin';

            if (!$isSuperAdmin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Export işlemi için süper admin yetkisi gerekli'
                ], 403);
            }

            // Build query with same filters as API
            $query = User::with(['leadStatus', 'assignedAdmin', 'leadSource'])
                        ->where(function($q) {
                            $q->whereNull('cstatus')
                              ->orWhere('cstatus', '!=', 'Customer');
                        });

            // Apply filters if provided
            $this->applyFilters($query, $request);

            // If specific lead IDs provided
            if ($request->has('lead_ids')) {
                $leadIds = explode(',', $request->lead_ids);
                $query->whereIn('id', $leadIds);
            }

            $format = $request->get('format', 'excel');
            $filename = 'leads-' . date('Y-m-d-H-i-s') . '.' . ($format === 'excel' ? 'xlsx' : 'csv');

            return Excel::download(new LeadsExport($query), $filename);

        } catch (\Exception $e) {
            Log::error('Lead export failed', [
                'admin_id' => Auth::guard('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Export işlemi başarısız'
            ], 500);
        }
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, $request)
    {
        if ($request->has('status') && $request->status !== '') {
            $query->where('lead_status_id', $request->status);
        }

        if ($request->has('source') && $request->source !== '') {
            $query->where('lead_source_id', $request->source);
        }

        if ($request->has('assigned_to') && $request->assigned_to !== '') {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assign_to');
            } else {
                $query->where('assign_to', $request->assigned_to);
            }
        }

        if ($request->has('priority') && $request->priority !== '') {
            $query->where('lead_priority', $request->priority);
        }

        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('min_score') && $request->min_score !== '') {
            $query->where('lead_score', '>=', $request->min_score);
        }

        if ($request->has('max_score') && $request->max_score !== '') {
            $query->where('lead_score', '<=', $request->max_score);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('lead_notes', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('tags') && is_array($request->tags) && !empty($request->tags)) {
            $query->where(function($q) use ($request) {
                foreach ($request->tags as $tag) {
                    $q->orWhere('lead_tags', 'LIKE', "%\"$tag\"%");
                }
            });
        }

        if ($request->has('has_phone') && $request->has_phone !== '') {
            if ($request->has_phone === 'true') {
                $query->whereNotNull('phone')->where('phone', '!=', '');
            } else {
                $query->where(function($q) {
                    $q->whereNull('phone')->orWhere('phone', '');
                });
            }
        }

        if ($request->has('has_email') && $request->has_email !== '') {
            if ($request->has_email === 'true') {
                $query->whereNotNull('email')->where('email', '!=', '');
            } else {
                $query->where(function($q) {
                    $q->whereNull('email')->orWhere('email', '');
                });
            }
        }

        if ($request->has('is_verified') && $request->is_verified !== '') {
            if ($request->is_verified === 'true') {
                $query->where(function($q) {
                    $q->where('phone_verified', true)
                      ->orWhere('email_verified', true);
                });
            } else {
                $query->where('phone_verified', false)
                      ->where('email_verified', false);
            }
        }

        if ($request->has('is_premium') && $request->is_premium !== '') {
            if ($request->is_premium === 'true') {
                $query->where('account_type', 'premium');
            } else {
                $query->where('account_type', '!=', 'premium');
            }
        }

        return $query;
    }

    /**
     * Get leads statistics
     */
    private function getLeadsStatistics($isSuperAdmin, $adminUser)
    {
        $baseQuery = User::where(function($q) {
            $q->whereNull('cstatus')
              ->orWhere('cstatus', '!=', 'Customer');
        });

        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            $baseQuery->whereIn('assign_to', $allowedAdminIds);
        }

        return [
            'total_leads' => (clone $baseQuery)->count(),
            'unassigned_leads' => (clone $baseQuery)->whereNull('assign_to')->count(),
            'new_leads_today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
            'new_leads_this_week' => (clone $baseQuery)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'high_score_leads' => (clone $baseQuery)->where('lead_score', '>=', 80)->count(),
            'follow_ups_today' => (clone $baseQuery)->whereDate('next_follow_up_date', today())->count(),
            'overdue_follow_ups' => (clone $baseQuery)->where('next_follow_up_date', '<', now())->count(),
        ];
    }

    // ... (keep existing methods that are still relevant: show, myLeads, etc.)
    
    /**
     * Show lead details
     */
    public function show($id)
    {
        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';
        
        $query = User::with(['leadStatus', 'assignedAdmin'])
                    ->where('id', $id)
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Admin level access control
        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            
            $query->where(function($q) use ($allowedAdminIds) {
                $q->whereIn('assign_to', $allowedAdminIds)
                  ->orWhereNull('assign_to');
            });
        }

        $lead = $query->firstOrFail();

        // Get lead activities
        $activities = LeadActivity::where('user_id', $lead->id)
                                ->with('admin:id,firstName,lastName')
                                ->orderBy('created_at', 'desc')
                                ->limit(20)
                                ->get();

        $leadStatuses = LeadStatus::active()->get();
        $admins = $isSuperAdmin ? Admin::orderBy('firstName')->get() : 
                 Admin::where('id', $adminUser->id)
                      ->orWhere('parent_id', $adminUser->id)
                      ->orderBy('firstName')->get();

        return response()->json([
            'success' => true,
            'data' => array_merge($lead->toArray(), [
                'activities' => $activities->map(function($activity) {
                    return [
                        'id' => $activity->id,
                        'type' => $activity->type,
                        'description' => $activity->description,
                        'created_at' => $activity->created_at->toISOString(),
                        'admin_name' => $activity->admin ? 
                            $activity->admin->firstName . ' ' . $activity->admin->lastName : 
                            'System'
                    ];
                })
            ]),
            'meta' => [
                'lead_statuses' => $leadStatuses,
                'admin_users' => $admins->map(function($admin) {
                    return [
                        'id' => $admin->id,
                        'name' => $admin->firstName . ' ' . $admin->lastName,
                        'email' => $admin->email
                    ];
                })
            ]
        ]);
    }
}