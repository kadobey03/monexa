<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeadImportService;
use App\Services\LeadAuthorizationService;
use App\Models\LeadImportLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class ImportController extends Controller
{
    protected $importService;
    protected $authService;

    public function __construct(
        LeadImportService $importService,
        LeadAuthorizationService $authService
    ) {
        $this->importService = $importService;
        $this->authService = $authService;
    }

    /**
     * Upload and analyze import file.
     */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate file upload
            $validator = Validator::make($request->all(), [
                'file' => 'required|file|mimes:csv,xlsx,xls|max:51200', // 50MB max
                'duplicate_action' => 'sometimes|string|in:skip,update,create_new',
                'default_assignee' => 'sometimes|integer|exists:admins,id',
                'default_status' => 'sometimes|integer|exists:lead_statuses,id',
                'default_source' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $file = $request->file('file');
            $options = $request->only([
                'duplicate_action', 
                'default_assignee', 
                'default_status', 
                'default_source'
            ]);

            $result = $this->importService->startImport($admin, $file, $options);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Import file upload failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'File upload failed.',
            ], 500);
        }
    }

    /**
     * Process import with column mapping.
     */
    public function processImport(Request $request, int $importLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'column_mapping' => 'required|array',
                'duplicate_action' => 'sometimes|string|in:skip,update,create_new',
                'duplicate_fields' => 'sometimes|array',
                'duplicate_fields.*' => 'string|in:email,phone,name',
                'updateable_fields' => 'sometimes|array',
                'default_assignee' => 'sometimes|integer|exists:admins,id',
                'default_status' => 'sometimes|integer|exists:lead_statuses,id',
                'default_source' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $columnMapping = $request->input('column_mapping');
            $options = $request->except(['column_mapping']);

            $result = $this->importService->processImport($admin, $importLogId, $columnMapping, $options);

            return response()->json($result, $result['success'] ? 200 : 400);

        } catch (\Exception $e) {
            Log::error('Import processing failed', [
                'admin_id' => auth('admin')->id(),
                'import_log_id' => $importLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Import processing failed.',
            ], 500);
        }
    }

    /**
     * Get import status.
     */
    public function getImportStatus(int $importLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Verify access
            $importLog = LeadImportLog::where('id', $importLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$importLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Import not found or access denied.',
                ], 404);
            }

            $status = $this->importService->getImportStatus($importLogId);

            return response()->json([
                'success' => true,
                'data' => $status,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get import status', [
                'admin_id' => auth('admin')->id(),
                'import_log_id' => $importLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get import status.',
            ], 500);
        }
    }

    /**
     * Cancel running import.
     */
    public function cancelImport(int $importLogId): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $success = $this->importService->cancelImport($importLogId, $admin);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Import cancelled successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel import or import not found.',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Failed to cancel import', [
                'admin_id' => auth('admin')->id(),
                'import_log_id' => $importLogId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel import.',
            ], 500);
        }
    }

    /**
     * Get import history for admin.
     */
    public function getImportHistory(Request $request): JsonResponse
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
            $history = $this->importService->getImportHistory($admin, $limit);

            return response()->json([
                'success' => true,
                'data' => $history,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get import history', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get import history.',
            ], 500);
        }
    }

    /**
     * Get import templates and column suggestions.
     */
    public function getImportTemplate(): JsonResponse
    {
        try {
            // Define import template structure
            $template = [
                'required_columns' => [
                    'name' => [
                        'label' => 'Full Name',
                        'description' => 'Lead\'s full name (required)',
                        'example' => 'John Doe',
                        'possible_headers' => ['name', 'full_name', 'fullname', 'customer_name', 'client_name'],
                    ],
                    'email' => [
                        'label' => 'Email Address',
                        'description' => 'Lead\'s email address (required if no phone)',
                        'example' => 'john.doe@example.com',
                        'possible_headers' => ['email', 'email_address', 'mail'],
                    ],
                    'phone' => [
                        'label' => 'Phone Number',
                        'description' => 'Lead\'s phone number (required if no email)',
                        'example' => '+1-555-123-4567',
                        'possible_headers' => ['phone', 'telephone', 'mobile', 'cell', 'phone_number'],
                    ],
                ],
                'optional_columns' => [
                    'country' => [
                        'label' => 'Country',
                        'description' => 'Lead\'s country (2-letter code)',
                        'example' => 'US',
                        'possible_headers' => ['country', 'country_name', 'country_code'],
                    ],
                    'lead_source' => [
                        'label' => 'Lead Source',
                        'description' => 'How the lead was acquired',
                        'example' => 'Website, Facebook, Google Ads',
                        'possible_headers' => ['source', 'lead_source', 'utm_source', 'referrer'],
                    ],
                    'lead_notes' => [
                        'label' => 'Notes',
                        'description' => 'Additional information about the lead',
                        'example' => 'Interested in premium plans',
                        'possible_headers' => ['notes', 'comments', 'remarks', 'description'],
                    ],
                    'lead_score' => [
                        'label' => 'Lead Score',
                        'description' => 'Lead quality score (0-100)',
                        'example' => '75',
                        'possible_headers' => ['score', 'lead_score', 'rating'],
                    ],
                    'lead_priority' => [
                        'label' => 'Priority',
                        'description' => 'Lead priority level',
                        'example' => 'high, medium, low',
                        'possible_headers' => ['priority', 'lead_priority', 'importance'],
                    ],
                    'company' => [
                        'label' => 'Company',
                        'description' => 'Lead\'s company name',
                        'example' => 'Acme Corp',
                        'possible_headers' => ['company', 'company_name', 'organization'],
                    ],
                    'position' => [
                        'label' => 'Job Title',
                        'description' => 'Lead\'s job position',
                        'example' => 'Marketing Director',
                        'possible_headers' => ['position', 'job_title', 'title'],
                    ],
                    'website' => [
                        'label' => 'Website',
                        'description' => 'Lead\'s website URL',
                        'example' => 'https://www.example.com',
                        'possible_headers' => ['website', 'url', 'web_address'],
                    ],
                ],
                'sample_data' => [
                    [
                        'name' => 'John Doe',
                        'email' => 'john.doe@example.com',
                        'phone' => '+1-555-123-4567',
                        'country' => 'US',
                        'lead_source' => 'Website',
                        'lead_score' => '85',
                        'company' => 'Tech Solutions Inc',
                        'position' => 'CTO',
                    ],
                    [
                        'name' => 'Jane Smith',
                        'email' => 'jane.smith@company.com',
                        'phone' => '+44-20-1234-5678',
                        'country' => 'GB',
                        'lead_source' => 'Facebook Ads',
                        'lead_score' => '72',
                        'company' => 'Digital Marketing Ltd',
                        'position' => 'Marketing Manager',
                    ],
                ],
            ];

            return response()->json([
                'success' => true,
                'data' => $template,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get import template', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get import template.',
            ], 500);
        }
    }

    /**
     * Download sample import file.
     */
    public function downloadSample(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'format' => 'sometimes|string|in:csv,xlsx',
                'template' => 'sometimes|string|in:basic,standard,comprehensive',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $format = $request->input('format', 'xlsx');
            $template = $request->input('template', 'standard');

            // Define template columns
            $templates = [
                'basic' => ['name', 'email', 'phone'],
                'standard' => ['name', 'email', 'phone', 'country', 'lead_source', 'lead_score'],
                'comprehensive' => [
                    'name', 'email', 'phone', 'country', 'lead_source', 'lead_score', 
                    'lead_priority', 'company', 'position', 'website', 'lead_notes'
                ],
            ];

            $columns = $templates[$template] ?? $templates['standard'];

            // Create sample data
            $sampleData = [
                [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'phone' => '+1-555-123-4567',
                    'country' => 'US',
                    'lead_source' => 'Website',
                    'lead_score' => 85,
                    'lead_priority' => 'high',
                    'company' => 'Tech Solutions Inc',
                    'position' => 'CTO',
                    'website' => 'https://techsolutions.com',
                    'lead_notes' => 'Interested in enterprise solutions',
                ],
                [
                    'name' => 'Jane Smith',
                    'email' => 'jane.smith@company.com',
                    'phone' => '+44-20-1234-5678',
                    'country' => 'GB',
                    'lead_source' => 'Facebook Ads',
                    'lead_score' => 72,
                    'lead_priority' => 'medium',
                    'company' => 'Digital Marketing Ltd',
                    'position' => 'Marketing Manager',
                    'website' => 'https://digitalmarketing.co.uk',
                    'lead_notes' => 'Requested demo call',
                ],
            ];

            // Filter data based on selected columns
            $filteredData = array_map(function($row) use ($columns) {
                return array_intersect_key($row, array_flip($columns));
            }, $sampleData);

            // Generate filename
            $filename = "lead_import_sample_{$template}_{$format}_" . now()->format('Y-m-d') . ".{$format}";

            return response()->json([
                'success' => true,
                'data' => [
                    'filename' => $filename,
                    'columns' => $columns,
                    'sample_data' => $filteredData,
                    'download_url' => route('admin.import.sample.download', [
                        'format' => $format,
                        'template' => $template,
                    ]),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate sample download', [
                'admin_id' => auth('admin')->id(),
                'format' => $request->input('format'),
                'template' => $request->input('template'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate sample file.',
            ], 500);
        }
    }

    /**
     * Validate import data before processing.
     */
    public function validateImportData(Request $request): JsonResponse
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'import_log_id' => 'required|integer|exists:lead_import_logs,id',
                'column_mapping' => 'required|array',
                'sample_rows' => 'sometimes|integer|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $admin = auth('admin')->user();
            $importLogId = $request->input('import_log_id');
            $columnMapping = $request->input('column_mapping');
            $sampleRows = $request->input('sample_rows', 5);

            // Verify access
            $importLog = LeadImportLog::where('id', $importLogId)
                ->where('admin_id', $admin->id)
                ->first();

            if (!$importLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Import not found or access denied.',
                ], 404);
            }

            // For this demo, we'll return a mock validation result
            // In a real implementation, you would validate sample rows from the file
            $validationResult = [
                'valid_rows' => $sampleRows - 1,
                'invalid_rows' => 1,
                'warnings' => [
                    'Row 3: Phone number format may be invalid',
                    'Row 5: Email format needs verification',
                ],
                'errors' => [
                    'Row 2: Missing required field "name"',
                ],
                'suggestions' => [
                    'Consider setting a default value for missing countries',
                    'Phone numbers will be automatically formatted',
                ],
            ];

            return response()->json([
                'success' => true,
                'data' => $validationResult,
            ]);

        } catch (\Exception $e) {
            Log::error('Import data validation failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
            ], 500);
        }
    }
}