<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\CreateLeadRequest;
use App\Http\Requests\Admin\Lead\UpdateLeadRequest;
use App\Http\Requests\Admin\Lead\BulkLeadRequest;
use App\Http\Resources\Admin\LeadResource;
use App\Http\Resources\Admin\LeadCollection;
use App\Services\LeadAuthorizationService;
use App\Services\LeadTableService;
use App\Services\PhoneIntegrationService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    protected $authService;
    protected $tableService;
    protected $phoneService;

    public function __construct(
        LeadAuthorizationService $authService,
        LeadTableService $tableService,
        PhoneIntegrationService $phoneService
    ) {
        $this->authService = $authService;
        $this->tableService = $tableService;
        $this->phoneService = $phoneService;
    }

    /**
     * Get leads list with advanced filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            
            // Get table configuration
            $tableConfig = $this->tableService->getTableConfiguration($admin);
            
            // Prepare parameters
            $params = [
                'page' => $request->get('page', 1),
                'per_page' => $request->get('per_page', 25),
                'sort_column' => $request->get('sort_column', 'created_at'),
                'sort_direction' => $request->get('sort_direction', 'desc'),
                'search' => $request->get('search'),
                'filters' => $request->get('filters', []),
            ];

            // Get leads data
            $leadsData = $this->tableService->getLeadsData($admin, $params);
            
            // Enhance leads with phone actions
            $enhancedLeads = collect($leadsData['data'])->map(function($lead) use ($admin) {
                $leadModel = User::find($lead['id']);
                $phoneActions = $this->phoneService->getPhoneActions($leadModel, $admin);
                
                return array_merge($lead, [
                    'phone_actions' => $phoneActions,
                    'can_edit' => $this->authService->canEditLead($admin, $leadModel),
                    'can_delete' => $this->authService->canDeleteLead($admin, $leadModel),
                    'can_assign' => $this->authService->canAssignLead($admin, $leadModel),
                ]);
            });

            return response()->json([
                'success' => true,
                'data' => $enhancedLeads,
                'pagination' => $leadsData['pagination'],
                'meta' => array_merge($leadsData['meta'], [
                    'table_config' => $tableConfig,
                    'statistics' => $this->authService->getLeadStatistics($admin),
                ]),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch leads', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
                'params' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch leads.',
                'error' => app()->hasDebugModeEnabled() ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get single lead details.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::with([
                'assignedAdmin:id,firstName,lastName',
                'leadStatus:id,name,color',
            ])->findOrFail($id);

            // Check permissions
            if (!$this->authService->canViewLead($admin, $lead)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to view this lead.',
                ], 403);
            }

            // Get phone actions and call history
            $phoneActions = $this->phoneService->getPhoneActions($lead, $admin);
            $callHistory = $this->phoneService->getCallHistory($lead, 10);

            return response()->json([
                'success' => true,
                'data' => array_merge($lead->toArray(), [
                    'phone_actions' => $phoneActions,
                    'call_history' => $callHistory,
                    'permissions' => [
                        'can_edit' => $this->authService->canEditLead($admin, $lead),
                        'can_delete' => $this->authService->canDeleteLead($admin, $lead),
                        'can_assign' => $this->authService->canAssignLead($admin, $lead),
                    ],
                ]),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch lead details', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch lead details.',
            ], 500);
        }
    }

    /**
     * Create new lead.
     */
    public function store(CreateLeadRequest $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $validatedData = $request->validated();

            DB::beginTransaction();

            // Set default values
            $leadData = array_merge($validatedData, [
                'account_type' => 'lead',
                'created_by_admin_id' => $admin->id,
                'lead_status_id' => $validatedData['lead_status_id'] ?? 1, // Default status
            ]);

            // Create lead
            $lead = User::create($leadData);

            // Log creation
            Log::info('Lead created', [
                'admin_id' => $admin->id,
                'lead_id' => $lead->id,
                'lead_name' => $lead->name,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead created successfully.',
                'data' => new LeadResource($lead->load([
                    'assignedAdmin:id,firstName,lastName',
                    'leadStatus:id,name,color',
                ])),
            ], 201);

        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create lead', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create lead.',
            ], 500);
        }
    }

    /**
     * Update existing lead.
     */
    public function update(UpdateLeadRequest $request, int $id): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($id);

            // Check permissions
            if (!$this->authService->canEditLead($admin, $lead)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to edit this lead.',
                ], 403);
            }

            $validatedData = $request->validated();

            DB::beginTransaction();

            // Track changes for logging
            $originalData = $lead->getOriginal();
            
            // Update lead
            $lead->update($validatedData);

            // Log changes
            $changes = array_diff_assoc($lead->getAttributes(), $originalData);
            if (!empty($changes)) {
                Log::info('Lead updated', [
                    'admin_id' => $admin->id,
                    'lead_id' => $lead->id,
                    'changes' => $changes,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully.',
                'data' => new LeadResource($lead->fresh([
                    'assignedAdmin:id,firstName,lastName',
                    'leadStatus:id,name,color',
                ])),
            ]);

        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to update lead', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update lead.',
            ], 500);
        }
    }

    /**
     * Delete lead.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($id);

            // Check permissions
            if (!$this->authService->canDeleteLead($admin, $lead)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete this lead.',
                ], 403);
            }

            DB::beginTransaction();

            $leadName = $lead->name;
            $leadId = $lead->id;

            // Soft delete lead
            $lead->delete();

            // Log deletion
            Log::info('Lead deleted', [
                'admin_id' => $admin->id,
                'lead_id' => $leadId,
                'lead_name' => $leadName,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead deleted successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to delete lead', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lead.',
            ], 500);
        }
    }

    /**
     * Bulk operations on leads.
     */
    public function bulk(BulkLeadRequest $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $validatedData = $request->validated();
            
            $action = $validatedData['action'];
            $leadIds = $validatedData['lead_ids'];
            $options = $validatedData['options'] ?? [];

            // Get leads and check permissions
            $leads = User::whereIn('id', $leadIds)->get();
            
            $results = [
                'successful' => 0,
                'failed' => 0,
                'errors' => [],
            ];

            DB::beginTransaction();

            foreach ($leads as $lead) {
                try {
                    switch ($action) {
                        case 'delete':
                            if ($this->authService->canDeleteLead($admin, $lead)) {
                                $lead->delete();
                                $results['successful']++;
                            } else {
                                $results['failed']++;
                                $results['errors'][] = "Permission denied for lead {$lead->name} ({$lead->id})";
                            }
                            break;

                        case 'assign':
                            if ($this->authService->canAssignLead($admin, $lead)) {
                                $lead->update(['assign_to' => $options['assign_to']]);
                                $results['successful']++;
                            } else {
                                $results['failed']++;
                                $results['errors'][] = "Cannot assign lead {$lead->name} ({$lead->id})";
                            }
                            break;

                        case 'update_status':
                            if ($this->authService->canEditLead($admin, $lead)) {
                                $lead->update(['lead_status_id' => $options['status_id']]);
                                $results['successful']++;
                            } else {
                                $results['failed']++;
                                $results['errors'][] = "Cannot update status for lead {$lead->name} ({$lead->id})";
                            }
                            break;

                        case 'update_priority':
                            if ($this->authService->canEditLead($admin, $lead)) {
                                $lead->update(['lead_priority' => $options['priority']]);
                                $results['successful']++;
                            } else {
                                $results['failed']++;
                                $results['errors'][] = "Cannot update priority for lead {$lead->name} ({$lead->id})";
                            }
                            break;

                        default:
                            $results['failed']++;
                            $results['errors'][] = "Unknown action: {$action}";
                    }

                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = "Error processing lead {$lead->name} ({$lead->id}): " . $e->getMessage();
                }
            }

            // Log bulk operation
            Log::info('Bulk lead operation completed', [
                'admin_id' => $admin->id,
                'action' => $action,
                'total_leads' => count($leadIds),
                'successful' => $results['successful'],
                'failed' => $results['failed'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Bulk operation completed. {$results['successful']} successful, {$results['failed']} failed.",
                'results' => $results,
            ]);

        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Bulk lead operation failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bulk operation failed.',
            ], 500);
        }
    }

    /**
     * Get dropdown options for filters and forms.
     */
    public function options(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $field = $request->get('field');

            $options = [];

            if (!$field) {
                // Return all dropdown options
                $options = [
                    'lead_status' => $this->tableService->getDropdownOptions($admin, 'lead_status'),
                    'assigned_admin' => $this->tableService->getDropdownOptions($admin, 'assigned_admin'),
                    'lead_priority' => $this->tableService->getDropdownOptions($admin, 'lead_priority'),
                    'countries' => Cache::remember('countries_list', 3600, function() {
                        return \App\Models\Country::orderBy('name')->get(['id', 'name', 'code'])->toArray();
                    }),
                    'lead_sources' => Cache::remember('lead_sources', 3600, function() {
                        return User::where('account_type', 'lead')
                            ->whereNotNull('lead_source')
                            ->distinct()
                            ->pluck('lead_source')
                            ->filter()
                            ->sort()
                            ->values()
                            ->toArray();
                    }),
                ];
            } else {
                // Return specific field options
                $options = $this->tableService->getDropdownOptions($admin, $field);
            }

            return response()->json([
                'success' => true,
                'data' => $options,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch dropdown options', [
                'admin_id' => auth('admin')->id(),
                'field' => $request->get('field'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch options.',
            ], 500);
        }
    }

    /**
     * Search leads with autocomplete.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $query = $request->get('q', '');
            $limit = min($request->get('limit', 10), 50);

            if (strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }

            // Get authorized leads query
            $leadsQuery = $this->authService->getAuthorizedLeadsQuery($admin);
            
            // Apply search
            $leads = $leadsQuery->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'email', 'phone', 'country')
            ->limit($limit)
            ->get();

            return response()->json([
                'success' => true,
                'data' => $leads->map(function($lead) {
                    return [
                        'id' => $lead->id,
                        'name' => $lead->name,
                        'email' => $lead->email,
                        'phone' => $lead->phone,
                        'country' => $lead->country,
                        'display_text' => $lead->name . ' (' . $lead->email . ')',
                    ];
                }),
            ]);

        } catch (\Exception $e) {
            Log::error('Lead search failed', [
                'admin_id' => auth('admin')->id(),
                'query' => $request->get('q'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Search failed.',
            ], 500);
        }
    }

    /**
     * Get lead statistics dashboard.
     */
    public function statistics(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $period = $request->get('period', '30_days');

            // Get basic statistics
            $basicStats = $this->authService->getLeadStatistics($admin);
            
            // Get time-based statistics
            $timeBasedStats = $this->getTimeBasedStatistics($admin, $period);
            
            // Get conversion statistics
            $conversionStats = $this->getConversionStatistics($admin, $period);

            return response()->json([
                'success' => true,
                'data' => [
                    'basic' => $basicStats,
                    'time_based' => $timeBasedStats,
                    'conversion' => $conversionStats,
                    'period' => $period,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch lead statistics', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics.',
            ], 500);
        }
    }

    /**
     * Get time-based statistics.
     */
    protected function getTimeBasedStatistics($admin, string $period): array
    {
        $startDate = $this->getStartDateForPeriod($period);
        $query = $this->authService->getAuthorizedLeadsQuery($admin);
        
        return [
            'new_leads' => $query->where('created_at', '>=', $startDate)->count(),
            'contacted_leads' => $query->where('last_contact_date', '>=', $startDate)->count(),
            'converted_leads' => $query->whereHas('leadStatus', function($q) {
                $q->where('is_conversion', true);
            })->where('updated_at', '>=', $startDate)->count(),
        ];
    }

    /**
     * Get conversion statistics.
     */
    protected function getConversionStatistics($admin, string $period): array
    {
        $startDate = $this->getStartDateForPeriod($period);
        $query = $this->authService->getAuthorizedLeadsQuery($admin);
        
        $totalLeads = $query->count();
        $convertedLeads = $query->whereHas('leadStatus', function($q) {
            $q->where('is_conversion', true);
        })->count();
        
        return [
            'total_leads' => $totalLeads,
            'converted_leads' => $convertedLeads,
            'conversion_rate' => $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0,
        ];
    }

    /**
     * Get start date for period.
     */
    protected function getStartDateForPeriod(string $period)
    {
        switch ($period) {
            case 'today':
                return now()->startOfDay();
            case '7_days':
                return now()->subDays(7);
            case '30_days':
                return now()->subDays(30);
            case '90_days':
                return now()->subDays(90);
            case 'this_month':
                return now()->startOfMonth();
            case 'last_month':
                return now()->subMonth()->startOfMonth();
            default:
                return now()->subDays(30);
        }
    }
}