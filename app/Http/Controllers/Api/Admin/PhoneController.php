<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\PhoneIntegrationService;
use App\Services\LeadAuthorizationService;
use App\Models\User;
use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PhoneController extends Controller
{
    protected $phoneService;
    protected $authService;

    public function __construct(
        PhoneIntegrationService $phoneService,
        LeadAuthorizationService $authService
    ) {
        $this->phoneService = $phoneService;
        $this->authService = $authService;
    }

    /**
     * Get phone actions for a lead.
     */
    public function getPhoneActions(int $leadId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($leadId);

            // DEAKTIF: Permission kontrolü admin middleware zaten koruyor
            // if (!$this->authService->canViewLead($admin, $lead)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You do not have permission to access this lead.',
            //     ], 403);
            // }

            $phoneActions = $this->phoneService->getPhoneActions($lead, $admin);

            return response()->json([
                'success' => true,
                'data' => $phoneActions,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get phone actions', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $leadId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get phone actions.',
            ], 500);
        }
    }

    /**
     * Validate and format phone number.
     */
    public function validatePhone(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string',
                'country' => 'sometimes|string|size:2',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $phone = $request->input('phone');
            $country = $request->input('country', 'US');

            $validation = $this->phoneService->validateAndFormatPhone($phone, $country);

            return response()->json([
                'success' => true,
                'data' => $validation,
            ]);

        } catch (\Exception $e) {
            Log::error('Phone validation failed', [
                'admin_id' => auth('admin')->id(),
                'phone' => $request->input('phone'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Phone validation failed.',
            ], 500);
        }
    }

    /**
     * Initiate a call to a lead.
     */
    public function initiateCall(Request $request, int $leadId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($leadId);

            // Validate request
            $validator = Validator::make($request->all(), [
                'method' => 'sometimes|string|in:click_to_call,softphone,manual',
                'notes' => 'sometimes|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // DEAKTIF: Permission kontrolü admin middleware zaten koruyor
            // if (!$this->authService->canViewLead($admin, $lead)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You do not have permission to call this lead.',
            //     ], 403);
            // }

            $options = [
                'method' => $request->input('method', 'click_to_call'),
                'notes' => $request->input('notes'),
            ];

            $result = $this->phoneService->initiateCall($admin, $lead, $options);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Failed to initiate call', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $leadId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate call.',
            ], 500);
        }
    }

    /**
     * Update call status (webhook endpoint).
     */
    public function updateCallStatus(Request $request, int $callLogId): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|in:initiated,ringing,answered,completed,failed,no_answer,busy',
                'duration' => 'sometimes|integer|min:0',
                'reason' => 'sometimes|string|max:255',
                'notes' => 'sometimes|string|max:1000',
                'recording_url' => 'sometimes|url',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $status = $request->input('status');
            $data = $request->only(['duration', 'reason', 'notes', 'recording_url']);

            $success = $this->phoneService->updateCallStatus($callLogId, $status, $data);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Call status updated successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update call status.',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Failed to update call status', [
                'call_log_id' => $callLogId,
                'status' => $request->input('status'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update call status.',
            ], 500);
        }
    }

    /**
     * Get call history for a lead.
     */
    public function getCallHistory(int $leadId, Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($leadId);

            // DEAKTIF: Permission kontrolü admin middleware zaten koruyor
            // if (!$this->authService->canViewLead($admin, $lead)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You do not have permission to view call history for this lead.',
            //     ], 403);
            // }

            $limit = min($request->input('limit', 20), 100);
            $callHistory = $this->phoneService->getCallHistory($lead, $limit);

            return response()->json([
                'success' => true,
                'data' => $callHistory,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get call history', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $leadId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get call history.',
            ], 500);
        }
    }

    /**
     * Generate WhatsApp link for lead.
     */
    public function generateWhatsAppLink(Request $request, int $leadId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $lead = User::findOrFail($leadId);

            // DEAKTIF: Permission kontrolü admin middleware zaten koruyor
            // if (!$this->authService->canViewLead($admin, $lead)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'You do not have permission to contact this lead.',
            //     ], 403);
            // }

            // Validate request
            $validator = Validator::make($request->all(), [
                'message' => 'sometimes|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $message = $request->input('message');
            $result = $this->phoneService->generateWhatsAppLink($lead, $message);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Failed to generate WhatsApp link', [
                'admin_id' => auth('admin')->id(),
                'lead_id' => $leadId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate WhatsApp link.',
            ], 500);
        }
    }

    /**
     * Get call statistics for current admin.
     */
    public function getCallStatistics(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'period' => 'sometimes|string|in:today,7_days,30_days,90_days,this_month,last_month',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid period specified.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $period = $request->input('period', '30_days');
            $statistics = $this->phoneService->getCallStatistics($admin, $period);

            return response()->json([
                'success' => true,
                'data' => $statistics,
                'period' => $period,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get call statistics', [
                'admin_id' => auth('admin')->id(),
                'period' => $request->input('period'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get call statistics.',
            ], 500);
        }
    }

    /**
     * Get recent call logs for admin.
     */
    public function getRecentCalls(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'limit' => 'sometimes|integer|min:1|max:100',
                'status' => 'sometimes|string|in:all,completed,failed,missed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $limit = $request->input('limit', 20);
            $status = $request->input('status', 'all');

            $query = CallLog::where('admin_id', $admin->id)
                ->with(['lead:id,name,email,phone', 'admin:id,firstName,lastName'])
                ->orderBy('initiated_at', 'desc');

            if ($status !== 'all') {
                switch ($status) {
                    case 'completed':
                        $query->where('call_status', 'completed');
                        break;
                    case 'failed':
                        $query->where('call_status', 'failed');
                        break;
                    case 'missed':
                        $query->whereIn('call_status', ['no_answer', 'busy']);
                        break;
                }
            }

            $calls = $query->limit($limit)->get();

            $formattedCalls = $calls->map(function($call) {
                return [
                    'id' => $call->id,
                    'lead' => [
                        'id' => $call->lead->id,
                        'name' => $call->lead->name,
                        'email' => $call->lead->email,
                    ],
                    'phone_number' => $call->formatted_phone,
                    'call_type' => $call->call_type,
                    'call_status' => $call->call_status,
                    'duration' => $call->duration_seconds,
                    'duration_formatted' => $call->duration_seconds ? $this->formatDuration($call->duration_seconds) : null,
                    'initiated_at' => $call->initiated_at,
                    'ended_at' => $call->ended_at,
                    'notes' => $call->notes,
                    'recording_url' => $call->recording_url,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedCalls,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get recent calls', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get recent calls.',
            ], 500);
        }
    }

    /**
     * Add notes to call log.
     */
    public function addCallNotes(Request $request, int $callLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'notes' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $callLog = CallLog::where('id', $callLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$callLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Call log not found or access denied.',
                ], 404);
            }

            $callLog->update(['notes' => $request->input('notes')]);

            Log::info('Call notes updated', [
                'admin_id' => $admin->id,
                'call_log_id' => $callLogId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Call notes updated successfully.',
                'data' => $callLog,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to add call notes', [
                'admin_id' => auth('admin')->id(),
                'call_log_id' => $callLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add call notes.',
            ], 500);
        }
    }

    /**
     * Get call recording (if available).
     */
    public function getCallRecording(int $callLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            $callLog = CallLog::where('id', $callLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$callLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Call log not found or access denied.',
                ], 404);
            }

            if (!$callLog->recording_url) {
                return response()->json([
                    'success' => false,
                    'message' => 'No recording available for this call.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'recording_url' => $callLog->recording_url,
                    'call_duration' => $callLog->duration_seconds,
                    'call_date' => $callLog->initiated_at,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get call recording', [
                'admin_id' => auth('admin')->id(),
                'call_log_id' => $callLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get call recording.',
            ], 500);
        }
    }

    /**
     * Clear phone cache.
     */
    public function clearCache(Request $request): JsonResponse
    {
        try {
            $phone = $request->input('phone');
            $this->phoneService->clearCache($phone);

            return response()->json([
                'success' => true,
                'message' => 'Phone cache cleared successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to clear phone cache', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to clear phone cache.',
            ], 500);
        }
    }

    /**
     * Format duration in human readable format.
     */
    protected function formatDuration(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . 's';
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            return $minutes . 'm ' . $remainingSeconds . 's';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return $hours . 'h ' . $remainingMinutes . 'm ' . $remainingSeconds . 's';
    }
}