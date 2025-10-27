<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeadExportService;
use App\Services\LeadAuthorizationService;
use App\Models\LeadExportLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    protected $exportService;
    protected $authService;

    public function __construct(
        LeadExportService $exportService,
        LeadAuthorizationService $authService
    ) {
        $this->exportService = $exportService;
        $this->authService = $authService;
    }

    /**
     * Start export process.
     */
    public function startExport(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'format' => 'sometimes|string|in:csv,xlsx,xls',
                'template' => 'sometimes|string|in:basic,standard,comprehensive,sales_report,marketing_report',
                'custom_columns' => 'sometimes|array',
                'custom_columns.*' => 'string',
                'filters' => 'sometimes|array',
                'search' => 'sometimes|string|max:255',
                'sort_column' => 'sometimes|string',
                'sort_direction' => 'sometimes|string|in:asc,desc',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $options = $request->only([
                'format', 'template', 'custom_columns', 'filters', 
                'search', 'sort_column', 'sort_direction'
            ]);

            $result = $this->exportService->startExport($admin, $options);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Export start failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
                'options' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to start export.',
            ], 500);
        }
    }

    /**
     * Process export (usually called by queue job).
     */
    public function processExport(Request $request, int $exportLogId): JsonResponse
    {
        try {
            // Validate that request is authorized (could be from queue or admin)
            $admin = auth('admin')->user();
            
            // Verify access if called by admin
            if ($admin) {
                $exportLog = LeadExportLog::where('id', $exportLogId)
                    ->where('admin_id', $admin->id)
                    ->first();

                if (!$exportLog) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Export not found or access denied.',
                    ], 404);
                }
            }

            $result = $this->exportService->processExport($exportLogId);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Export processing failed', [
                'admin_id' => auth('admin')->id() ?? 'system',
                'export_log_id' => $exportLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Export processing failed.',
            ], 500);
        }
    }

    /**
     * Get export status.
     */
    public function getExportStatus(int $exportLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Verify access
            $exportLog = LeadExportLog::where('id', $exportLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$exportLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Export not found or access denied.',
                ], 404);
            }

            $status = $this->exportService->getExportStatus($exportLogId);

            return response()->json([
                'success' => true,
                'data' => $status,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get export status', [
                'admin_id' => auth('admin')->id(),
                'export_log_id' => $exportLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get export status.',
            ], 500);
        }
    }

    /**
     * Download exported file.
     */
    public function downloadExport(Request $request): JsonResponse|Response
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'file' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file parameter.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Decode file path
            $filePath = base64_decode($request->input('file'));
            
            // Find export log by file path
            $exportLog = LeadExportLog::where('admin_id', $admin->id)
                ->where('file_path', $filePath)
                ->where('status', 'completed')
                ->first();

            if (!$exportLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Export file not found or access denied.',
                ], 404);
            }

            $result = $this->exportService->downloadExport($exportLog->id, $admin);

            if (!$result['success']) {
                return response()->json($result, 400);
            }

            // Stream file download
            $filePath = $result['file_path'];
            $filename = $result['filename'];

            if (!Storage::disk('exports')->exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Export file not found.',
                ], 404);
            }

            $fileContents = Storage::disk('exports')->get($filePath);
            $mimeType = Storage::disk('exports')->mimeType($filePath);

            return Response::make($fileContents, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($fileContents),
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
                'Pragma' => 'public',
            ]);

        } catch (\Exception $e) {
            Log::error('Export download failed', [
                'admin_id' => auth('admin')->id(),
                'file' => $request->input('file'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to download export.',
            ], 500);
        }
    }

    /**
     * Get export history for admin.
     */
    public function getExportHistory(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'limit' => 'sometimes|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $limit = $request->input('limit', 20);
            $history = $this->exportService->getExportHistory($admin, $limit);

            return response()->json([
                'success' => true,
                'data' => $history,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get export history', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get export history.',
            ], 500);
        }
    }

    /**
     * Get export templates and options.
     */
    public function getExportTemplates(): JsonResponse
    {
        try {
            $templates = $this->exportService->getExportTemplates();
            $formats = $this->exportService->getSupportedFormats();

            return response()->json([
                'success' => true,
                'data' => [
                    'templates' => $templates,
                    'formats' => $formats,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get export templates', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get export templates.',
            ], 500);
        }
    }

    /**
     * Get export statistics for admin.
     */
    public function getExportStatistics(Request $request): JsonResponse
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
            $statistics = $this->exportService->getExportStatistics($admin, $period);

            return response()->json([
                'success' => true,
                'data' => $statistics,
                'period' => $period,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get export statistics', [
                'admin_id' => auth('admin')->id(),
                'period' => $request->input('period'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get export statistics.',
            ], 500);
        }
    }

    /**
     * Preview export data (first few rows).
     */
    public function previewExport(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'template' => 'sometimes|string|in:basic,standard,comprehensive,sales_report,marketing_report',
                'custom_columns' => 'sometimes|array',
                'custom_columns.*' => 'string',
                'filters' => 'sometimes|array',
                'search' => 'sometimes|string|max:255',
                'limit' => 'sometimes|integer|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get authorized leads query
            $query = $this->authService->getAuthorizedLeadsQuery($admin);
            
            // Apply filters if provided
            $filters = $request->input('filters', []);
            if (!empty($filters)) {
                $query = $this->authService->applyFilters($query, $filters);
            }

            // Apply search if provided
            $search = $request->input('search');
            if (!empty($search)) {
                $query = $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }

            // Get preview data
            $limit = $request->input('limit', 5);
            $leads = $query->with([
                'assignedAdmin:id,firstName,lastName',
                'leadStatus:id,name,color',
                'country:id,name,code',
            ])->limit($limit)->get();

            // Get columns for preview
            $template = $request->input('template', 'standard');
            $customColumns = $request->input('custom_columns');
            
            $templates = $this->exportService->getExportTemplates();
            $columns = $customColumns ?? ($templates[$template]['columns'] ?? $templates['standard']['columns']);

            // Format preview data
            $previewData = $leads->map(function($lead) use ($columns) {
                $row = [];
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'assigned_admin':
                            $row[$column] = $lead->assignedAdmin ? $lead->assignedAdmin->getFullName() : '';
                            break;
                        case 'lead_status':
                            $row[$column] = $lead->leadStatus ? $lead->leadStatus->name : '';
                            break;
                        case 'created_at':
                        case 'last_contact_date':
                        case 'next_follow_up_date':
                            $row[$column] = $lead->$column ? $lead->$column->format('Y-m-d H:i:s') : '';
                            break;
                        default:
                            $row[$column] = $lead->$column ?? '';
                            break;
                    }
                }
                return $row;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'columns' => $columns,
                    'preview_data' => $previewData,
                    'total_records' => $query->count(),
                    'preview_count' => $leads->count(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to preview export', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to preview export data.',
            ], 500);
        }
    }

    /**
     * Delete/cancel export.
     */
    public function deleteExport(int $exportLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Find export log
            $exportLog = LeadExportLog::where('id', $exportLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$exportLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Export not found or access denied.',
                ], 404);
            }

            // Delete file if exists
            if ($exportLog->file_path && Storage::disk('exports')->exists($exportLog->file_path)) {
                Storage::disk('exports')->delete($exportLog->file_path);
            }

            // Update export log status
            $exportLog->update([
                'status' => 'cancelled',
                'file_path' => null,
                'download_url' => null,
            ]);

            Log::info('Export deleted', [
                'admin_id' => $admin->id,
                'export_log_id' => $exportLogId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export deleted successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete export', [
                'admin_id' => auth('admin')->id(),
                'export_log_id' => $exportLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete export.',
            ], 500);
        }
    }

    /**
     * Cleanup expired exports (admin endpoint).
     */
    public function cleanupExpired(): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Check if user has admin permissions for cleanup
            if (!$admin->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient permissions to perform cleanup.',
                ], 403);
            }

            $cleanedCount = $this->exportService->cleanupExpiredExports();

            return response()->json([
                'success' => true,
                'message' => "Cleaned up {$cleanedCount} expired exports.",
                'cleaned_count' => $cleanedCount,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to cleanup expired exports', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cleanup expired exports.',
            ], 500);
        }
    }

    /**
     * Get available columns for export.
     */
    public function getAvailableColumns(): JsonResponse
    {
        try {
            // Define all possible export columns
            $columns = [
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'phone' => 'Phone',
                'country' => 'Country',
                'lead_status' => 'Status',
                'assigned_admin' => 'Assigned To',
                'lead_source' => 'Source',
                'lead_score' => 'Score',
                'lead_priority' => 'Priority',
                'created_at' => 'Created',
                'updated_at' => 'Updated',
                'last_contact_date' => 'Last Contact',
                'next_follow_up_date' => 'Next Follow Up',
                'lead_notes' => 'Notes',
                'company' => 'Company',
                'position' => 'Position',
                'website' => 'Website',
                'address' => 'Address',
                'city' => 'City',
                'state' => 'State',
                'zip' => 'ZIP',
                'age' => 'Age',
                'gender' => 'Gender',
            ];

            return response()->json([
                'success' => true,
                'data' => $columns,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get available columns', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get available columns.',
            ], 500);
        }
    }
}