<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignLeadRequest;
use App\Http\Requests\BulkAssignLeadsRequest;
use App\Models\Admin;
use App\Models\User;
use App\Models\LeadAssignmentHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LeadAssignmentController extends Controller
{
    /**
     * Assign single lead to admin
     * PUT /admin/dashboard/leads/api/{leadId}/assignment
     */
    public function assignLead(AssignLeadRequest $request, int $leadId): JsonResponse
    {
        try {
            $validated = $request->getValidatedData();

            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            DB::beginTransaction();

            // Get lead with lock for concurrency safety
            $lead = User::lockForUpdate()
                       ->with(['assignedAdmin:id,firstName,lastName,email'])
                       ->where('id', $leadId)
                       ->where(function($q) {
                           $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                       })
                       ->first();

            if (!$lead) {
                DB::rollBack();
                return $this->errorResponse('Lead bulunamadı veya müşteriye dönüştürülmüş', 'LEAD_NOT_FOUND', 404);
            }

            // Check permission to assign this lead
            if (!$this->canAssignLead($authAdmin, $lead)) {
                DB::rollBack();
                return $this->errorResponse('Bu lead\'i atama yetkiniz yok', 'INSUFFICIENT_PERMISSIONS', 403);
            }

            $previousAdminId = $lead->assign_to;
            $newAdminId = $validated['admin_id'];

            // If unassigning (setting to null)
            if (!$newAdminId) {
                if ($previousAdminId) {
                    // Decrease previous admin's lead count
                    Admin::where('id', $previousAdminId)->decrement('leads_assigned_count');
                    
                    // End current assignment
                    $this->endCurrentAssignment($lead, LeadAssignmentHistory::OUTCOME_REASSIGNED);
                }
                
                $lead->assign_to = null;
                $lead->save();

                DB::commit();
                
                Log::info('Lead unassigned successfully', [
                    'lead_id' => $leadId,
                    'previous_admin_id' => $previousAdminId,
                    'assigned_by_admin_id' => $authAdmin->id
                ]);

                return $this->successResponse([
                    'lead' => $this->formatLeadResponse($lead),
                    'assignment' => null
                ], 'Lead başarıyla atama kaldırıldı');
            }

            // Get target admin with lock for concurrency safety
            $targetAdmin = Admin::lockForUpdate()->find($newAdminId);
            
            if (!$targetAdmin) {
                DB::rollBack();
                return $this->errorResponse('Hedef admin bulunamadı', 'ADMIN_NOT_FOUND', 404);
            }

            if (!$targetAdmin->isAvailableForAssignment()) {
                DB::rollBack();
                return $this->errorResponse('Seçilen admin şu anda atama için müsait değil', 'ADMIN_NOT_AVAILABLE', 422);
            }

            // Check if it's the same admin (no change needed)
            if ($previousAdminId == $newAdminId) {
                DB::rollBack();
                return $this->successResponse([
                    'lead' => $this->formatLeadResponse($lead),
                    'assignment' => $lead->currentAssignment
                ], 'Lead zaten bu admin\'e atanmış');
            }

            // Update admin lead counts
            if ($previousAdminId && $previousAdminId != $newAdminId) {
                Admin::where('id', $previousAdminId)->decrement('leads_assigned_count');
                $this->endCurrentAssignment($lead, LeadAssignmentHistory::OUTCOME_REASSIGNED);
            }
            
            $targetAdmin->increment('leads_assigned_count');

            // Update lead assignment
            $lead->assign_to = $newAdminId;
            $lead->save();

            // Create assignment history
            $assignmentData = [
                'user_id' => $lead->id,
                'assigned_from_admin_id' => $previousAdminId,
                'assigned_to_admin_id' => $newAdminId,
                'assigned_by_admin_id' => $authAdmin->id,
                'assignment_type' => $previousAdminId ? LeadAssignmentHistory::TYPE_REASSIGNMENT : LeadAssignmentHistory::TYPE_INITIAL,
                'assignment_method' => LeadAssignmentHistory::METHOD_MANUAL,
                'assignment_outcome' => LeadAssignmentHistory::OUTCOME_ACTIVE,
                'reason' => $validated['reason'] ?? null,
                'priority' => $validated['priority'],
                'lead_status_at_assignment' => $lead->lead_status ?? 'new',
                'lead_score_at_assignment' => $lead->lead_score,
                'estimated_value_at_assignment' => $lead->estimated_value,
                'lead_tags_at_assignment' => $lead->lead_tags,
                'admin_lead_count_before' => $targetAdmin->leads_assigned_count - 1,
                'admin_lead_count_after' => $targetAdmin->leads_assigned_count,
                'admin_performance_score' => $targetAdmin->current_performance,
                'admin_availability_status' => $targetAdmin->is_available ? 'available' : 'busy',
                'lead_timezone' => $lead->getTimezone(),
                'lead_region' => $lead->getRegion(),
                'admin_timezone' => $targetAdmin->time_zone,
                'lead_source' => $lead->lead_source,
                'department' => $targetAdmin->department,
                'admin_group_id' => $targetAdmin->admin_group_id,
                'assignment_started_at' => now(),
            ];

            $assignment = LeadAssignmentHistory::create($assignmentData);

            // Clear relevant caches
            $this->clearAssignmentCaches($authAdmin->id, $newAdminId, $previousAdminId);

            DB::commit();

            Log::info('Lead assigned successfully', [
                'lead_id' => $leadId,
                'previous_admin_id' => $previousAdminId,
                'new_admin_id' => $newAdminId,
                'assigned_by_admin_id' => $authAdmin->id,
                'assignment_id' => $assignment->id
            ]);

            return $this->successResponse([
                'lead' => $this->formatLeadResponse($lead->fresh(['assignedAdmin'])),
                'assignment' => $assignment
            ], 'Lead başarıyla atandı');

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->errorResponse(
                'Validation hatası', 
                'VALIDATION_ERROR', 
                422, 
                $e->errors()
            );
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Lead assignment failed', [
                'lead_id' => $leadId,
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse(
                'Lead atama işlemi başarısız', 
                'ASSIGNMENT_FAILED', 
                500,
                config('app.debug') ? ['message' => $e->getMessage()] : null
            );
        }
    }

    /**
     * Bulk assign leads to admin
     * POST /admin/dashboard/leads/api/bulk-assign
     */
    public function bulkAssignLeads(BulkAssignLeadsRequest $request): JsonResponse
    {
        try {
            $validated = $request->getValidatedData();
            $leadIds = $request->getUniqueLeadIds();
            
            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            $newAdminId = $validated['admin_id'];
            $bulkAssignmentId = 'bulk_' . now()->format('YmdHis') . '_' . $authAdmin->id;
            
            $results = [
                'successful' => [],
                'failed' => [],
                'skipped' => []
            ];

            DB::beginTransaction();

            // Get all leads with lock
            $leads = User::lockForUpdate()
                        ->with(['assignedAdmin:id,firstName,lastName'])
                        ->whereIn('id', $leadIds)
                        ->where(function($q) {
                            $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                        })
                        ->get();

            if ($leads->isEmpty()) {
                DB::rollBack();
                return $this->errorResponse('Geçerli lead bulunamadı', 'NO_VALID_LEADS', 404);
            }

            // Check permissions for all leads
            foreach ($leads as $lead) {
                if (!$this->canAssignLead($authAdmin, $lead)) {
                    $results['failed'][] = [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'error' => 'Yetki yok'
                    ];
                    continue;
                }
                
                // Check if already assigned to same admin
                if ($lead->assign_to == $newAdminId) {
                    $results['skipped'][] = [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'reason' => 'Zaten aynı admin\'e atanmış'
                    ];
                }
            }

            // Get target admin if assigning (not unassigning)
            $targetAdmin = null;
            if ($newAdminId) {
                $targetAdmin = Admin::lockForUpdate()->find($newAdminId);
                
                if (!$targetAdmin) {
                    DB::rollBack();
                    return $this->errorResponse('Hedef admin bulunamadı', 'ADMIN_NOT_FOUND', 404);
                }

                if (!$targetAdmin->isAvailableForAssignment()) {
                    DB::rollBack();
                    return $this->errorResponse('Seçilen admin şu anda atama için müsait değil', 'ADMIN_NOT_AVAILABLE', 422);
                }
            }

            $processedCount = 0;
            $adminCountUpdates = [];

            // Process each lead
            foreach ($leads as $lead) {
                // Skip if already processed as failed or skipped
                $isAlreadyProcessed = collect($results['failed'])->contains('lead_id', $lead->id) ||
                                     collect($results['skipped'])->contains('lead_id', $lead->id);
                
                if ($isAlreadyProcessed) {
                    continue;
                }

                try {
                    $previousAdminId = $lead->assign_to;

                    // Update admin counters
                    if ($previousAdminId && $previousAdminId != $newAdminId) {
                        $adminCountUpdates[$previousAdminId] = ($adminCountUpdates[$previousAdminId] ?? 0) - 1;
                        $this->endCurrentAssignment($lead, LeadAssignmentHistory::OUTCOME_REASSIGNED);
                    }

                    if ($newAdminId && $previousAdminId != $newAdminId) {
                        $adminCountUpdates[$newAdminId] = ($adminCountUpdates[$newAdminId] ?? 0) + 1;
                    }

                    // Update lead assignment
                    $lead->assign_to = $newAdminId;
                    $lead->save();

                    // Create assignment history
                    $assignmentData = [
                        'user_id' => $lead->id,
                        'assigned_from_admin_id' => $previousAdminId,
                        'assigned_to_admin_id' => $newAdminId,
                        'assigned_by_admin_id' => $authAdmin->id,
                        'assignment_type' => LeadAssignmentHistory::TYPE_BULK_ASSIGNMENT,
                        'assignment_method' => LeadAssignmentHistory::METHOD_MANUAL,
                        'assignment_outcome' => LeadAssignmentHistory::OUTCOME_ACTIVE,
                        'reason' => $validated['reason'] ?? null,
                        'priority' => $validated['priority'],
                        'lead_status_at_assignment' => $lead->lead_status ?? 'new',
                        'lead_score_at_assignment' => $lead->lead_score,
                        'estimated_value_at_assignment' => $lead->estimated_value,
                        'lead_tags_at_assignment' => $lead->lead_tags,
                        'admin_lead_count_before' => $targetAdmin ? $targetAdmin->leads_assigned_count + ($adminCountUpdates[$newAdminId] ?? 0) - 1 : null,
                        'admin_lead_count_after' => $targetAdmin ? $targetAdmin->leads_assigned_count + ($adminCountUpdates[$newAdminId] ?? 0) : null,
                        'admin_performance_score' => $targetAdmin->current_performance ?? null,
                        'admin_availability_status' => $targetAdmin ? ($targetAdmin->is_available ? 'available' : 'busy') : null,
                        'lead_timezone' => $lead->getTimezone(),
                        'lead_region' => $lead->getRegion(),
                        'admin_timezone' => $targetAdmin->time_zone ?? null,
                        'lead_source' => $lead->lead_source,
                        'department' => $targetAdmin->department ?? null,
                        'admin_group_id' => $targetAdmin->admin_group_id ?? null,
                        'bulk_assignment_id' => $bulkAssignmentId,
                        'bulk_assignment_batch_size' => count($leadIds),
                        'bulk_assignment_sequence' => $processedCount + 1,
                        'assignment_started_at' => now(),
                    ];

                    LeadAssignmentHistory::create($assignmentData);

                    $results['successful'][] = [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'previous_admin' => $previousAdminId ? $lead->assignedAdmin?->firstName . ' ' . $lead->assignedAdmin?->lastName : null,
                        'new_admin' => $targetAdmin ? $targetAdmin->firstName . ' ' . $targetAdmin->lastName : null
                    ];

                    $processedCount++;

                } catch (\Exception $e) {
                    Log::error('Bulk assignment - individual lead failed', [
                        'lead_id' => $lead->id,
                        'error' => $e->getMessage()
                    ]);

                    $results['failed'][] = [
                        'lead_id' => $lead->id,
                        'lead_name' => $lead->name,
                        'error' => 'İşlem hatası'
                    ];
                }
            }

            // Apply admin counter updates
            foreach ($adminCountUpdates as $adminId => $change) {
                if ($change > 0) {
                    Admin::where('id', $adminId)->increment('leads_assigned_count', $change);
                } elseif ($change < 0) {
                    Admin::where('id', $adminId)->decrement('leads_assigned_count', abs($change));
                }
            }

            // Clear relevant caches
            $affectedAdmins = array_unique(array_filter([
                $authAdmin->id,
                $newAdminId,
                ...array_keys($adminCountUpdates)
            ]));
            
            foreach ($affectedAdmins as $adminId) {
                $this->clearAssignmentCaches($authAdmin->id, $adminId);
            }

            DB::commit();

            $successCount = count($results['successful']);
            $failedCount = count($results['failed']);
            $skippedCount = count($results['skipped']);
            $totalCount = count($leadIds);

            Log::info('Bulk assignment completed', [
                'bulk_assignment_id' => $bulkAssignmentId,
                'admin_id' => $authAdmin->id,
                'target_admin_id' => $newAdminId,
                'total_requested' => $totalCount,
                'successful' => $successCount,
                'failed' => $failedCount,
                'skipped' => $skippedCount
            ]);

            return $this->successResponse([
                'bulk_assignment_id' => $bulkAssignmentId,
                'summary' => [
                    'total_requested' => $totalCount,
                    'successful' => $successCount,
                    'failed' => $failedCount,
                    'skipped' => $skippedCount
                ],
                'results' => $results
            ], "{$successCount} lead başarıyla atandı, {$failedCount} başarısız, {$skippedCount} atlandı");

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->errorResponse(
                'Validation hatası', 
                'VALIDATION_ERROR', 
                422, 
                $e->errors()
            );
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Bulk assignment failed', [
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse(
                'Toplu atama işlemi başarısız', 
                'BULK_ASSIGNMENT_FAILED', 
                500,
                config('app.debug') ? ['message' => $e->getMessage()] : null
            );
        }
    }

    /**
     * Get assignment history for a lead
     * GET /admin/dashboard/leads/api/{leadId}/assignment-history
     */
    public function getAssignmentHistory(Request $request, int $leadId): JsonResponse
    {
        try {
            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            $lead = User::where('id', $leadId)
                       ->where(function($q) {
                           $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                       })
                       ->first();

            if (!$lead) {
                return $this->errorResponse('Lead bulunamadı', 'LEAD_NOT_FOUND', 404);
            }

            // Check permission
            if (!$this->canViewLead($authAdmin, $lead)) {
                return $this->errorResponse('Bu lead\'in geçmişini görme yetkiniz yok', 'INSUFFICIENT_PERMISSIONS', 403);
            }

            $history = LeadAssignmentHistory::where('user_id', $leadId)
                                          ->with([
                                              'assignedFromAdmin:id,firstName,lastName,email',
                                              'assignedToAdmin:id,firstName,lastName,email',
                                              'assignedByAdmin:id,firstName,lastName,email'
                                          ])
                                          ->orderBy('assignment_started_at', 'desc')
                                          ->paginate(20);

            $formattedHistory = $history->getCollection()->map(function($assignment) {
                return [
                    'id' => $assignment->id,
                    'assignment_type' => $assignment->assignment_type,
                    'assignment_method' => $assignment->assignment_method,
                    'assignment_outcome' => $assignment->assignment_outcome,
                    'reason' => $assignment->reason,
                    'priority' => $assignment->priority,
                    'assigned_from_admin' => $assignment->assignedFromAdmin ? [
                        'id' => $assignment->assignedFromAdmin->id,
                        'name' => $assignment->assignedFromAdmin->firstName . ' ' . $assignment->assignedFromAdmin->lastName,
                        'email' => $assignment->assignedFromAdmin->email
                    ] : null,
                    'assigned_to_admin' => $assignment->assignedToAdmin ? [
                        'id' => $assignment->assignedToAdmin->id,
                        'name' => $assignment->assignedToAdmin->firstName . ' ' . $assignment->assignedToAdmin->lastName,
                        'email' => $assignment->assignedToAdmin->email
                    ] : null,
                    'assigned_by_admin' => $assignment->assignedByAdmin ? [
                        'id' => $assignment->assignedByAdmin->id,
                        'name' => $assignment->assignedByAdmin->firstName . ' ' . $assignment->assignedByAdmin->lastName,
                        'email' => $assignment->assignedByAdmin->email
                    ] : null,
                    'assignment_started_at' => $assignment->assignment_started_at?->toISOString(),
                    'assignment_ended_at' => $assignment->assignment_ended_at?->toISOString(),
                    'days_assigned' => $assignment->days_assigned,
                    'contacts_made' => $assignment->contacts_made,
                    'final_conversion_value' => $assignment->final_conversion_value,
                    'department' => $assignment->department,
                    'bulk_assignment_id' => $assignment->bulk_assignment_id,
                ];
            });

            return $this->successResponse([
                'history' => $formattedHistory,
                'pagination' => [
                    'current_page' => $history->currentPage(),
                    'per_page' => $history->perPage(),
                    'total' => $history->total(),
                    'last_page' => $history->lastPage(),
                ]
            ], 'Assignment geçmişi başarıyla getirildi');

        } catch (\Exception $e) {
            Log::error('Failed to fetch assignment history', [
                'lead_id' => $leadId,
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Assignment geçmişi getirilemedi', 
                'FETCH_HISTORY_FAILED', 
                500
            );
        }
    }

    /**
     * Get available admins for assignment
     * GET /admin/dashboard/leads/api/available-admins
     */
    public function getAvailableAdmins(Request $request): JsonResponse
    {
        try {
            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            $cacheKey = "available_admins_{$authAdmin->id}_" . ($authAdmin->type === 'Super Admin' ? 'super' : 'regular');
            
            $availableAdmins = Cache::remember($cacheKey, 300, function () use ($authAdmin) {
                $query = Admin::where('status', 'active')
                            ->where('is_available_for_assignment', true);

                // If not super admin, limit to own scope
                if ($authAdmin->type !== 'Super Admin') {
                    $subordinateIds = Admin::where('supervisor_id', $authAdmin->id)->pluck('id')->toArray();
                    $query->whereIn('id', array_merge([$authAdmin->id], $subordinateIds));
                }

                return $query->select([
                        'id', 'firstName', 'lastName', 'email', 'department',
                        'leads_assigned_count', 'max_leads_capacity', 'current_performance',
                        'is_available', 'time_zone'
                    ])
                    ->orderBy('leads_assigned_count', 'asc')
                    ->orderBy('current_performance', 'desc')
                    ->get()
                    ->map(function ($admin) {
                        $assignmentCapacity = $admin->max_leads_capacity > 0 ?
                            round(($admin->leads_assigned_count / $admin->max_leads_capacity) * 100, 1) : 0;

                        return [
                            'id' => $admin->id,
                            'name' => trim($admin->firstName . ' ' . $admin->lastName),
                            'email' => $admin->email,
                            'department' => $admin->department,
                            'current_leads' => $admin->leads_assigned_count,
                            'max_capacity' => $admin->max_leads_capacity,
                            'capacity_percentage' => $assignmentCapacity,
                            'performance_score' => $admin->current_performance,
                            'is_available' => $admin->is_available,
                            'time_zone' => $admin->time_zone,
                            'can_accept_assignments' => $admin->isAvailableForAssignment()
                        ];
                    });
            });

            return $this->successResponse([
                'admins' => $availableAdmins,
                'total_count' => $availableAdmins->count(),
                'cache_key' => $cacheKey
            ], 'Müsait adminler başarıyla getirildi');

        } catch (\Exception $e) {
            Log::error('Failed to fetch available admins', [
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Müsait adminler getirilemedi',
                'FETCH_AVAILABLE_ADMINS_FAILED',
                500
            );
        }
    }

    /**
     * Validate assignment before execution
     * POST /admin/dashboard/leads/api/validate-assignment
     */
    public function validateAssignment(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'lead_id' => 'required|integer|exists:users,id',
                'admin_id' => 'required|integer|exists:admins,id'
            ]);

            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            $lead = User::find($request->lead_id);
            $targetAdmin = Admin::find($request->admin_id);

            $validation = [
                'is_valid' => true,
                'warnings' => [],
                'errors' => []
            ];

            // Check lead validity
            if (!$lead) {
                $validation['errors'][] = 'Lead bulunamadı';
                $validation['is_valid'] = false;
            } elseif ($lead->cstatus === 'Customer') {
                $validation['errors'][] = 'Lead zaten müşteriye dönüştürülmüş';
                $validation['is_valid'] = false;
            }

            // Check admin validity
            if (!$targetAdmin) {
                $validation['errors'][] = 'Hedef admin bulunamadı';
                $validation['is_valid'] = false;
            } elseif (!$targetAdmin->isAvailableForAssignment()) {
                $validation['errors'][] = 'Seçilen admin şu anda atama için müsait değil';
                $validation['is_valid'] = false;
            }

            // Permission check
            if ($lead && !$this->canAssignLead($authAdmin, $lead)) {
                $validation['errors'][] = 'Bu lead\'i atama yetkiniz yok';
                $validation['is_valid'] = false;
            }

            // Capacity warnings
            if ($targetAdmin && $targetAdmin->max_leads_capacity > 0) {
                $capacityPercentage = ($targetAdmin->leads_assigned_count / $targetAdmin->max_leads_capacity) * 100;
                if ($capacityPercentage >= 90) {
                    $validation['warnings'][] = 'Admin kapasitesinin %' . round($capacityPercentage, 1) . '\'ına ulaşmış';
                } elseif ($capacityPercentage >= 75) {
                    $validation['warnings'][] = 'Admin kapasitesinin %' . round($capacityPercentage, 1) . '\'ında';
                }
            }

            // Same admin check
            if ($lead && $lead->assign_to == $request->admin_id) {
                $validation['warnings'][] = 'Lead zaten bu admin\'e atanmış';
            }

            return $this->successResponse($validation, 'Atama validasyonu tamamlandı');

        } catch (\Exception $e) {
            Log::error('Assignment validation failed', [
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Atama validasyonu başarısız',
                'VALIDATION_FAILED',
                500
            );
        }
    }

    /**
     * Get assignment statistics
     * GET /admin/dashboard/leads/api/assignment-stats
     */
    public function getAssignmentStats(Request $request): JsonResponse
    {
        try {
            $authAdmin = Auth::guard('admin')->user();
            if (!$authAdmin) {
                return $this->errorResponse('Yetkilendirme hatası', 'UNAUTHORIZED', 401);
            }

            $cacheKey = "admin_assignment_stats_{$authAdmin->id}";
            
            $stats = Cache::remember($cacheKey, 600, function () use ($authAdmin) {
                $now = now();
                $today = $now->copy()->startOfDay();
                $thisWeek = $now->copy()->startOfWeek();
                $thisMonth = $now->copy()->startOfMonth();

                // Get base query scope
                $baseLeadQuery = User::query()->where(function($q) {
                    $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                });

                if ($authAdmin->type !== 'Super Admin') {
                    $subordinateIds = Admin::where('supervisor_id', $authAdmin->id)->pluck('id')->toArray();
                    $scopedAdminIds = array_merge([$authAdmin->id], $subordinateIds);
                    $baseLeadQuery->whereIn('assign_to', $scopedAdminIds);
                }

                // Total leads in scope
                $totalLeads = (clone $baseLeadQuery)->count();
                $assignedLeads = (clone $baseLeadQuery)->whereNotNull('assign_to')->count();
                $unassignedLeads = $totalLeads - $assignedLeads;

                // Assignment activity stats
                $assignmentBaseQuery = LeadAssignmentHistory::query();
                if ($authAdmin->type !== 'Super Admin') {
                    $assignmentBaseQuery->where('assigned_by_admin_id', $authAdmin->id);
                }

                $todayAssignments = (clone $assignmentBaseQuery)->whereDate('assignment_started_at', $today)->count();
                $weekAssignments = (clone $assignmentBaseQuery)->where('assignment_started_at', '>=', $thisWeek)->count();
                $monthAssignments = (clone $assignmentBaseQuery)->where('assignment_started_at', '>=', $thisMonth)->count();

                // Admin utilization stats
                $adminScope = Admin::where('status', 'active');
                if ($authAdmin->type !== 'Super Admin') {
                    $subordinateIds = Admin::where('supervisor_id', $authAdmin->id)->pluck('id')->toArray();
                    $adminScope->whereIn('id', array_merge([$authAdmin->id], $subordinateIds));
                }

                $availableAdmins = (clone $adminScope)->where('is_available_for_assignment', true)->count();
                $totalAdmins = $adminScope->count();
                $busyAdmins = $totalAdmins - $availableAdmins;

                // Top performers
                $topPerformers = (clone $adminScope)
                    ->orderBy('current_performance', 'desc')
                    ->limit(5)
                    ->select(['id', 'firstName', 'lastName', 'current_performance', 'leads_assigned_count'])
                    ->get()
                    ->map(function($admin) {
                        return [
                            'id' => $admin->id,
                            'name' => trim($admin->firstName . ' ' . $admin->lastName),
                            'performance_score' => $admin->current_performance,
                            'leads_assigned' => $admin->leads_assigned_count
                        ];
                    });

                return [
                    'leads' => [
                        'total' => $totalLeads,
                        'assigned' => $assignedLeads,
                        'unassigned' => $unassignedLeads,
                        'assignment_rate' => $totalLeads > 0 ? round(($assignedLeads / $totalLeads) * 100, 1) : 0
                    ],
                    'assignments_activity' => [
                        'today' => $todayAssignments,
                        'this_week' => $weekAssignments,
                        'this_month' => $monthAssignments
                    ],
                    'admin_utilization' => [
                        'total_admins' => $totalAdmins,
                        'available_admins' => $availableAdmins,
                        'busy_admins' => $busyAdmins,
                        'availability_rate' => $totalAdmins > 0 ? round(($availableAdmins / $totalAdmins) * 100, 1) : 0
                    ],
                    'top_performers' => $topPerformers
                ];
            });

            return $this->successResponse($stats, 'Assignment istatistikleri başarıyla getirildi');

        } catch (\Exception $e) {
            Log::error('Failed to fetch assignment stats', [
                'admin_id' => $authAdmin->id ?? null,
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse(
                'Assignment istatistikleri getirilemedi',
                'FETCH_STATS_FAILED',
                500
            );
        }
    }

    /**
     * Check if admin can assign a specific lead
     */
    protected function canAssignLead(Admin $admin, User $lead): bool
    {
        // Super admin can assign any lead
        if ($admin->type === 'Super Admin') {
            return true;
        }

        // Check if lead is within admin's scope
        if ($lead->assign_to) {
            $currentAssignedAdmin = Admin::find($lead->assign_to);
            if ($currentAssignedAdmin) {
                // Can reassign if current admin is subordinate
                $subordinateIds = Admin::where('supervisor_id', $admin->id)->pluck('id')->toArray();
                return in_array($lead->assign_to, array_merge([$admin->id], $subordinateIds));
            }
        }

        // Can assign unassigned leads if has permission
        return $admin->hasPermission('lead_assign') ?? true;
    }

    /**
     * Check if admin can view a specific lead
     */
    protected function canViewLead(Admin $admin, User $lead): bool
    {
        // Super admin can view any lead
        if ($admin->type === 'Super Admin') {
            return true;
        }

        // Can view own assigned leads
        if ($lead->assign_to === $admin->id) {
            return true;
        }

        // Can view subordinates' leads
        $subordinateIds = Admin::where('supervisor_id', $admin->id)->pluck('id')->toArray();
        return in_array($lead->assign_to, $subordinateIds);
    }

    /**
     * End current assignment
     */
    protected function endCurrentAssignment(User $lead, string $outcome): void
    {
        $currentAssignment = LeadAssignmentHistory::where('user_id', $lead->id)
                                                 ->where('assignment_outcome', LeadAssignmentHistory::OUTCOME_ACTIVE)
                                                 ->whereNull('assignment_ended_at')
                                                 ->first();

        if ($currentAssignment) {
            $currentAssignment->assignment_ended_at = now();
            $currentAssignment->assignment_outcome = $outcome;
            $currentAssignment->days_assigned = $currentAssignment->assignment_started_at->diffInDays(now());
            $currentAssignment->save();
        }
    }

    /**
     * Format lead response for API
     */
    protected function formatLeadResponse(User $lead): array
    {
        return [
            'id' => $lead->id,
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'country' => $lead->country,
            'lead_status' => $lead->lead_status,
            'lead_score' => $lead->lead_score,
            'estimated_value' => $lead->estimated_value,
            'assigned_to' => $lead->assignedAdmin ? [
                'id' => $lead->assignedAdmin->id,
                'name' => $lead->assignedAdmin->firstName . ' ' . $lead->assignedAdmin->lastName,
                'email' => $lead->assignedAdmin->email
            ] : null,
            'created_at' => $lead->created_at->toISOString(),
            'updated_at' => $lead->updated_at->toISOString()
        ];
    }

    /**
     * Clear assignment-related caches
     */
    protected function clearAssignmentCaches(int $authAdminId, int $targetAdminId = null, int $previousAdminId = null): void
    {
        $adminIds = array_unique(array_filter([$authAdminId, $targetAdminId, $previousAdminId]));
        
        foreach ($adminIds as $adminId) {
            Cache::forget("admin_assignment_stats_{$adminId}");
            Cache::forget("available_admins_{$adminId}_super");
            Cache::forget("available_admins_{$adminId}_regular");
        }
        
        Cache::forget('assignable_admins_dropdown');
    }

    /**
     * Standard success response format
     */
    protected function successResponse($data, string $message = 'İşlem başarılı', array $meta = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => array_merge([
                'timestamp' => now()->toISOString(),
                'version' => '2.0'
            ], $meta)
        ]);
    }

    /**
     * Standard error response format
     */
    protected function errorResponse(string $message, string $errorCode = 'UNKNOWN_ERROR', int $statusCode = 500, $errorDetails = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'error_code' => $errorCode,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => '2.0'
            ]
        ];
        
        if ($errorDetails) {
            $response['error_details'] = $errorDetails;
        }
        
        return response()->json($response, $statusCode);
    }
}