<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Models\LeadImportLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LeadImportService
{
    protected $phoneService;
    protected $authService;
    
    /**
     * Supported import formats.
     */
    protected $supportedFormats = [
        'csv' => ['text/csv', 'application/csv', 'text/plain'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'xls' => ['application/vnd.ms-excel'],
    ];

    /**
     * Required columns mapping.
     */
    protected $requiredColumns = [
        'name' => ['name', 'full_name', 'fullname', 'customer_name', 'client_name'],
        'email' => ['email', 'email_address', 'mail'],
        'phone' => ['phone', 'telephone', 'mobile', 'cell', 'phone_number'],
    ];

    /**
     * Optional columns mapping.
     */
    protected $optionalColumns = [
        'country' => ['country', 'country_name', 'country_code'],
        'lead_source' => ['source', 'lead_source', 'utm_source', 'referrer'],
        'lead_notes' => ['notes', 'comments', 'remarks', 'description'],
        'lead_score' => ['score', 'lead_score', 'rating'],
        'lead_priority' => ['priority', 'lead_priority', 'importance'],
        'assign_to' => ['assigned_to', 'assign_to', 'agent', 'sales_rep'],
        'lead_status' => ['status', 'lead_status', 'stage'],
        'next_follow_up_date' => ['follow_up', 'next_follow_up', 'callback_date'],
        'created_at' => ['created', 'created_at', 'date_created', 'registration_date'],
        'company' => ['company', 'company_name', 'organization'],
        'position' => ['position', 'job_title', 'title'],
        'website' => ['website', 'url', 'web_address'],
        'address' => ['address', 'street_address', 'location'],
        'city' => ['city', 'town'],
        'state' => ['state', 'province', 'region'],
        'zip' => ['zip', 'postal_code', 'postcode'],
        'age' => ['age', 'birth_year'],
        'gender' => ['gender', 'sex'],
    ];

    /**
     * Maximum batch size for processing.
     */
    protected $batchSize = 100;

    public function __construct(
        PhoneIntegrationService $phoneService,
        LeadAuthorizationService $authService
    ) {
        $this->phoneService = $phoneService;
        $this->authService = $authService;
    }

    /**
     * Start import process.
     */
    public function startImport(Admin $admin, UploadedFile $file, array $options = []): array
    {
        Log::info('🪲 IMPORT DEBUG: startImport called', [
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_size_mb' => round($file->getSize() / 1024 / 1024, 2),
            'mime_type' => $file->getMimeType(),
            'file_extension' => $file->getClientOriginalExtension(),
            'options' => $options
        ]);

        try {
            // Validate file
            Log::info('🪲 IMPORT DEBUG: Starting file validation');
            $validation = $this->validateFile($file);
            Log::info('🪲 IMPORT DEBUG: File validation result', [
                'validation_valid' => $validation['valid'],
                'validation_error' => $validation['error'] ?? null
            ]);
            
            if (!$validation['valid']) {
                Log::warning('🪲 IMPORT DEBUG: File validation failed', $validation);
                return [
                    'success' => false,
                    'error' => $validation['error'],
                ];
            }

            // Store file temporarily
            Log::info('🪲 IMPORT DEBUG: Storing file temporarily');
            $filePath = $this->storeTemporaryFile($file);
            Log::info('🪲 IMPORT DEBUG: File stored successfully', [
                'file_path' => $filePath,
                'full_storage_path' => Storage::path($filePath)
            ]);
            
            // Create import log
            Log::info('🪲 IMPORT DEBUG: Creating import log record');
            $importLog = LeadImportLog::create([
                'admin_id' => $admin->id,
                'filename' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_path' => $filePath,
                'status' => 'pending',
                'total_rows' => 0,
                'processed_rows' => 0,
                'successful_imports' => 0,
                'failed_imports' => 0,
                'duplicate_count' => 0,
                'import_options' => $options,
                'started_at' => now(),
            ]);
            Log::info('🪲 IMPORT DEBUG: Import log created', [
                'import_log_id' => $importLog->id,
                'import_log_status' => $importLog->status
            ]);

            // Analyze file structure
            Log::info('🪲 IMPORT DEBUG: Starting file analysis');
            $analysis = $this->analyzeFile($filePath);
            Log::info('🪲 IMPORT DEBUG: File analysis result', [
                'analysis_success' => $analysis['success'],
                'analysis_error' => $analysis['error'] ?? null,
                'analysis_total_rows' => $analysis['total_rows'] ?? 0,
                'analysis_headers' => $analysis['headers'] ?? [],
                'analysis_suggested_mapping' => $analysis['suggested_mapping'] ?? []
            ]);
            
            if (!$analysis['success']) {
                Log::error('🪲 IMPORT DEBUG: File analysis failed', [
                    'analysis_error' => $analysis['error'],
                    'import_log_id' => $importLog->id
                ]);
                
                $importLog->update([
                    'status' => 'failed',
                    'error_message' => $analysis['error'],
                    'completed_at' => now(),
                ]);

                return [
                    'success' => false,
                    'error' => $analysis['error'],
                ];
            }

            // Update import log with analysis
            Log::info('🪲 IMPORT DEBUG: Updating import log with analysis results');
            $importLog->update([
                'total_rows' => $analysis['total_rows'],
                'column_mapping' => $analysis['suggested_mapping'],
                'file_structure' => $analysis['structure'],
            ]);
            Log::info('🪲 IMPORT DEBUG: Import log updated', [
                'import_log_id' => $importLog->id,
                'updated_total_rows' => $analysis['total_rows'],
                'updated_status' => $importLog->fresh()->status
            ]);

            Log::info('🪲 IMPORT DEBUG: startImport completed successfully', [
                'import_log_id' => $importLog->id,
                'total_rows' => $analysis['total_rows'],
                'suggested_mapping_count' => count($analysis['suggested_mapping'] ?? []),
                'preview_data_count' => count($analysis['preview_data'] ?? [])
            ]);

            Log::info('Import started', [
                'admin_id' => $admin->id,
                'import_log_id' => $importLog->id,
                'filename' => $file->getClientOriginalName(),
                'total_rows' => $analysis['total_rows'],
            ]);

            return [
                'success' => true,
                'import_log_id' => $importLog->id,
                'total_rows' => $analysis['total_rows'],
                'suggested_mapping' => $analysis['suggested_mapping'],
                'preview_data' => $analysis['preview_data'] ?? [],
            ];

        } catch (\Exception $e) {
            Log::error('🪲 IMPORT DEBUG: startImport failed - Exception caught', [
                'admin_id' => $admin->id,
                'file_name' => $file->getClientOriginalName(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            Log::error('Import initialization failed', [
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            return [
                'success' => false,
                'error' => 'Failed to initialize import: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Process import with custom mapping.
     */
    public function processImport(Admin $admin, int $importLogId, array $columnMapping, array $options = []): array
    {
        try {
            $importLog = LeadImportLog::findOrFail($importLogId);
            
            // Verify admin owns this import
            if ($importLog->admin_id !== $admin->id) {
                return [
                    'success' => false,
                    'error' => 'Unauthorized access to import log.',
                ];
            }

            // Update status
            $importLog->update([
                'status' => 'processing',
                'column_mapping' => $columnMapping,
                'import_options' => array_merge($importLog->import_options ?? [], $options),
            ]);

            // Process file in batches
            $result = $this->processFileInBatches($importLog, $columnMapping, $options);

            // Update final status
            $importLog->update([
                'status' => $result['success'] ? 'completed' : 'failed',
                'processed_rows' => $result['processed_rows'],
                'successful_imports' => $result['successful_imports'],
                'failed_imports' => $result['failed_imports'],
                'duplicate_count' => $result['duplicate_count'],
                'error_message' => $result['error'] ?? null,
                'validation_errors' => $result['validation_errors'] ?? [],
                'completed_at' => now(),
            ]);

            // Clean up temporary file if successful
            if ($result['success'] && !($options['keep_file'] ?? false)) {
                Storage::delete($importLog->file_path);
            }

            Log::info('Import completed', [
                'import_log_id' => $importLogId,
                'success' => $result['success'],
                'total_processed' => $result['processed_rows'],
                'successful' => $result['successful_imports'],
                'failed' => $result['failed_imports'],
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('Import processing failed', [
                'import_log_id' => $importLogId,
                'error' => $e->getMessage(),
            ]);

            if (isset($importLog)) {
                $importLog->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }

            return [
                'success' => false,
                'error' => 'Import processing failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Validate uploaded file.
     */
    protected function validateFile(UploadedFile $file): array
    {
        // Check file size (max 50MB)
        $maxSize = 50 * 1024 * 1024; // 50MB
        if ($file->getSize() > $maxSize) {
            return [
                'valid' => false,
                'error' => 'File size exceeds maximum limit of 50MB.',
            ];
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType();

        if (!isset($this->supportedFormats[$extension])) {
            return [
                'valid' => false,
                'error' => 'Unsupported file format. Please upload CSV, XLS, or XLSX files.',
            ];
        }

        if (!in_array($mimeType, $this->supportedFormats[$extension])) {
            return [
                'valid' => false,
                'error' => 'Invalid file type. The file appears to be corrupted or not in the expected format.',
            ];
        }

        return ['valid' => true];
    }

    /**
     * Store file temporarily.
     */
    protected function storeTemporaryFile(UploadedFile $file): string
    {
        $filename = 'imports/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('temp', $filename);
        return 'temp/' . $filename;
    }

    /**
     * Analyze file structure and suggest column mapping.
     */
    protected function analyzeFile(string $filePath): array
    {
        try {
            $fullPath = Storage::path($filePath);
            $data = Excel::toArray([], $fullPath);
            
            if (empty($data) || empty($data[0])) {
                return [
                    'success' => false,
                    'error' => 'File appears to be empty or corrupted.',
                ];
            }

            $rows = $data[0];
            $headers = array_map('trim', array_map('strtolower', $rows[0] ?? []));
            $totalRows = count($rows) - 1; // Exclude header row

            if ($totalRows <= 0) {
                return [
                    'success' => false,
                    'error' => 'File contains only headers or is empty.',
                ];
            }

            // Suggest column mapping
            $suggestedMapping = $this->suggestColumnMapping($headers);

            // Get preview data (first 5 rows)
            $previewData = [];
            for ($i = 1; $i <= min(5, count($rows) - 1); $i++) {
                $row = [];
                foreach ($headers as $index => $header) {
                    $row[$header] = $rows[$i][$index] ?? '';
                }
                $previewData[] = $row;
            }

            return [
                'success' => true,
                'total_rows' => $totalRows,
                'headers' => $headers,
                'suggested_mapping' => $suggestedMapping,
                'preview_data' => $previewData,
                'structure' => [
                    'has_headers' => true,
                    'column_count' => count($headers),
                    'estimated_leads' => $totalRows,
                ],
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Failed to analyze file: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Suggest column mapping based on headers.
     */
    protected function suggestColumnMapping(array $headers): array
    {
        $mapping = [];
        
        // Check required columns first
        foreach ($this->requiredColumns as $dbColumn => $possibleHeaders) {
            foreach ($possibleHeaders as $possibleHeader) {
                if (in_array($possibleHeader, $headers)) {
                    $mapping[$dbColumn] = $possibleHeader;
                    break;
                }
            }
        }

        // Check optional columns
        foreach ($this->optionalColumns as $dbColumn => $possibleHeaders) {
            if (!isset($mapping[$dbColumn])) {
                foreach ($possibleHeaders as $possibleHeader) {
                    if (in_array($possibleHeader, $headers)) {
                        $mapping[$dbColumn] = $possibleHeader;
                        break;
                    }
                }
            }
        }

        return $mapping;
    }

    /**
     * Process file in batches.
     */
    protected function processFileInBatches(LeadImportLog $importLog, array $columnMapping, array $options): array
    {
        try {
            $fullPath = Storage::path($importLog->file_path);
            $data = Excel::toArray([], $fullPath);
            $rows = $data[0];
            
            // Remove header row
            array_shift($rows);

            $totalRows = count($rows);
            $processedRows = 0;
            $successfulImports = 0;
            $failedImports = 0;
            $duplicateCount = 0;
            $validationErrors = [];

            $batches = array_chunk($rows, $this->batchSize);

            foreach ($batches as $batchIndex => $batch) {
                $batchResult = $this->processBatch(
                    $importLog->admin_id,
                    $batch,
                    $columnMapping,
                    $options,
                    $batchIndex
                );

                $processedRows += $batchResult['processed'];
                $successfulImports += $batchResult['successful'];
                $failedImports += $batchResult['failed'];
                $duplicateCount += $batchResult['duplicates'];
                
                if (!empty($batchResult['errors'])) {
                    $validationErrors = array_merge($validationErrors, $batchResult['errors']);
                }

                // Update progress
                $importLog->update([
                    'processed_rows' => $processedRows,
                    'successful_imports' => $successfulImports,
                    'failed_imports' => $failedImports,
                    'duplicate_count' => $duplicateCount,
                ]);

                // Limit validation errors to prevent memory issues
                if (count($validationErrors) > 1000) {
                    $validationErrors = array_slice($validationErrors, 0, 1000);
                    $validationErrors[] = [
                        'row' => 'system',
                        'error' => 'Too many validation errors. Only first 1000 errors are shown.',
                    ];
                    break;
                }
            }

            return [
                'success' => true,
                'processed_rows' => $processedRows,
                'successful_imports' => $successfulImports,
                'failed_imports' => $failedImports,
                'duplicate_count' => $duplicateCount,
                'validation_errors' => $validationErrors,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'processed_rows' => $processedRows ?? 0,
                'successful_imports' => $successfulImports ?? 0,
                'failed_imports' => $failedImports ?? 0,
                'duplicate_count' => $duplicateCount ?? 0,
                'validation_errors' => $validationErrors ?? [],
            ];
        }
    }

    /**
     * Process single batch of rows.
     */
    protected function processBatch(int $adminId, array $batch, array $columnMapping, array $options, int $batchIndex): array
    {
        $processed = 0;
        $successful = 0;
        $failed = 0;
        $duplicates = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            Log::info('🪲 IMPORT DEBUG: Starting batch processing', [
                'batch_index' => $batchIndex,
                'batch_size' => count($batch),
                'admin_id' => $adminId,
                'options' => $options
            ]);

            foreach ($batch as $rowIndex => $row) {
                $actualRowIndex = ($batchIndex * $this->batchSize) + $rowIndex + 2; // +2 for header and 0-based index
                
                Log::info('🪲 IMPORT DEBUG: Processing row', [
                    'row_index' => $actualRowIndex,
                    'raw_row_data' => $row
                ]);
                
                $leadData = $this->mapRowToLeadData($row, $columnMapping);
                
                Log::info('🪲 IMPORT DEBUG: Mapped lead data', [
                    'row_index' => $actualRowIndex,
                    'mapped_data' => $leadData
                ]);
                
                $validation = $this->validateLeadData($leadData, $actualRowIndex);
                
                Log::info('🪲 IMPORT DEBUG: Validation result', [
                    'row_index' => $actualRowIndex,
                    'validation_valid' => $validation['valid'],
                    'validation_errors' => $validation['errors'] ?? []
                ]);
                
                if (!$validation['valid']) {
                    Log::warning('🪲 IMPORT DEBUG: Row failed validation', [
                        'row_index' => $actualRowIndex,
                        'validation_errors' => $validation['errors'],
                        'lead_data' => $leadData
                    ]);
                    $errors[] = [
                        'row' => $actualRowIndex,
                        'errors' => $validation['errors'],
                        'data' => $leadData,
                    ];
                    $failed++;
                    $processed++;
                    continue;
                }

                // Check for duplicates
                $existingLead = $this->findExistingLead($leadData, $options);
                
                Log::info('🪲 IMPORT DEBUG: Duplicate check result', [
                    'row_index' => $actualRowIndex,
                    'existing_lead_found' => $existingLead ? true : false,
                    'existing_lead_id' => $existingLead ? $existingLead->id : null,
                    'duplicate_action' => $options['duplicate_action'] ?? 'skip',
                    'duplicate_fields' => $options['duplicate_fields'] ?? ['email']
                ]);
                
                if ($existingLead) {
                    if ($options['duplicate_action'] ?? 'skip' === 'skip') {
                        Log::info('🪲 IMPORT DEBUG: Row skipped - duplicate found', [
                            'row_index' => $actualRowIndex,
                            'existing_lead_id' => $existingLead->id,
                            'existing_email' => $existingLead->email
                        ]);
                        $duplicates++;
                        $processed++;
                        continue;
                    } elseif ($options['duplicate_action'] === 'update') {
                        Log::info('🪲 IMPORT DEBUG: Updating existing lead', [
                            'row_index' => $actualRowIndex,
                            'existing_lead_id' => $existingLead->id
                        ]);
                        $this->updateExistingLead($existingLead, $leadData, $options);
                        $successful++;
                        $processed++;
                        continue;
                    }
                }

                // Create new lead
                $leadData['imported_by'] = $adminId;
                $leadData['import_source'] = 'file_import';
                $leadData['account_type'] = 'lead';
                
                // Set default values if not provided
                if (empty($leadData['assign_to']) && !empty($options['default_assignee'])) {
                    $leadData['assign_to'] = $options['default_assignee'];
                }
                
                if (empty($leadData['lead_status']) && !empty($options['default_status'])) {
                    $leadData['lead_status'] = $options['default_status'];
                }

                if (empty($leadData['lead_source']) && !empty($options['default_source'])) {
                    $leadData['lead_source'] = $options['default_source'];
                }

                Log::info('🪲 IMPORT DEBUG: Creating new user', [
                    'row_index' => $actualRowIndex,
                    'final_lead_data' => $leadData
                ]);

                User::create($leadData);
                
                Log::info('🪲 IMPORT DEBUG: User created successfully', [
                    'row_index' => $actualRowIndex
                ]);
                
                $successful++;
                $processed++;
            }

            Log::info('🪲 IMPORT DEBUG: Batch processing completed', [
                'batch_index' => $batchIndex,
                'processed' => $processed,
                'successful' => $successful,
                'failed' => $failed,
                'duplicates' => $duplicates
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Batch processing failed', [
                'batch_index' => $batchIndex,
                'admin_id' => $adminId,
                'error' => $e->getMessage(),
            ]);

            // Mark all remaining rows in batch as failed
            $failed += (count($batch) - $processed);
            $processed = count($batch);
            
            $errors[] = [
                'row' => 'batch_' . $batchIndex,
                'errors' => ['Batch processing failed: ' . $e->getMessage()],
            ];
        }

        return [
            'processed' => $processed,
            'successful' => $successful,
            'failed' => $failed,
            'duplicates' => $duplicates,
            'errors' => $errors,
        ];
    }

    /**
     * Map row data to lead attributes.
     */
    protected function mapRowToLeadData(array $row, array $columnMapping): array
    {
        $leadData = [];
        
        Log::info('🪲 MAPPING DEBUG: Starting row mapping', [
            'row_data' => $row,
            'column_mapping' => $columnMapping,
            'row_count' => count($row)
        ]);
        
        foreach ($columnMapping as $dbColumn => $mappingValue) {
            if (!empty($mappingValue)) {
                $value = '';
                
                // Handle frontend object format {index: 0, name: "Column"}
                if (is_array($mappingValue) && isset($mappingValue['index'])) {
                    $columnIndex = (int) $mappingValue['index'];
                    $columnName = $mappingValue['name'] ?? "Column {$columnIndex}";
                    $value = isset($row[$columnIndex]) ? trim($row[$columnIndex] ?? '') : '';
                    
                    Log::info('🪲 MAPPING DEBUG: Object mapping processed', [
                        'db_column' => $dbColumn,
                        'column_index' => $columnIndex,
                        'column_name' => $columnName,
                        'raw_value' => $row[$columnIndex] ?? 'NOT_SET',
                        'trimmed_value' => $value
                    ]);
                } else {
                    // Legacy string mapping (fallback)
                    $columnIndex = array_search($mappingValue, array_keys($row));
                    $value = $columnIndex !== false ? trim($row[$mappingValue] ?? '') : '';
                    
                    Log::info('🪲 MAPPING DEBUG: String mapping processed', [
                        'db_column' => $dbColumn,
                        'mapping_value' => $mappingValue,
                        'column_index' => $columnIndex,
                        'value' => $value
                    ]);
                }
                
                // Apply data transformations
                $transformedValue = $this->transformColumnValue($dbColumn, $value);
                $leadData[$dbColumn] = $transformedValue;
                
                Log::info('🪲 MAPPING DEBUG: Value transformation', [
                    'db_column' => $dbColumn,
                    'original_value' => $value,
                    'transformed_value' => $transformedValue
                ]);
            }
        }

        $finalData = array_filter($leadData, function($value) {
            return $value !== null && $value !== '';
        });
        
        Log::info('🪲 MAPPING DEBUG: Row mapping completed', [
            'raw_lead_data' => $leadData,
            'filtered_lead_data' => $finalData,
            'filtered_fields_count' => count($finalData)
        ]);

        return $finalData;
    }

    /**
     * Transform column value based on type.
     */
    protected function transformColumnValue(string $column, $value)
    {
        if (empty($value)) {
            return null;
        }

        switch ($column) {
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? strtolower($value) : null;

            case 'phone':
                // Clean phone number
                return preg_replace('/[^+\d]/', '', $value);

            case 'lead_score':
            case 'age':
                return is_numeric($value) ? (int)$value : null;

            case 'created_at':
            case 'next_follow_up_date':
                try {
                    return Carbon::parse($value)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return null;
                }

            case 'name':
            case 'company':
            case 'position':
                return ucwords(strtolower($value));

            case 'country':
                return strtoupper(substr($value, 0, 2)); // Convert to country code

            case 'lead_priority':
                $priorities = ['low', 'medium', 'high', 'urgent'];
                $lowerValue = strtolower($value);
                return in_array($lowerValue, $priorities) ? $lowerValue : 'medium';

            case 'gender':
                $lowerValue = strtolower($value);
                return in_array($lowerValue, ['male', 'female', 'other']) ? $lowerValue : null;

            default:
                return $value;
        }
    }

    /**
     * Validate lead data.
     */
    protected function validateLeadData(array $leadData, int $rowIndex): array
    {
        $errors = [];

        // Required field validation
        if (empty($leadData['name'])) {
            $errors[] = 'Name is required';
        }

        if (empty($leadData['email']) && empty($leadData['phone'])) {
            $errors[] = 'Either email or phone is required';
        }

        // Email validation
        if (!empty($leadData['email']) && !filter_var($leadData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // Phone validation
        if (!empty($leadData['phone'])) {
            $phoneValidation = $this->phoneService->validateAndFormatPhone($leadData['phone']);
            if (!$phoneValidation['is_valid']) {
                $errors[] = 'Invalid phone number format';
            }
        }

        // Name length validation
        if (!empty($leadData['name']) && strlen($leadData['name']) > 255) {
            $errors[] = 'Name is too long (maximum 255 characters)';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Find existing lead to check for duplicates.
     */
    protected function findExistingLead(array $leadData, array $options)
    {
        $query = User::where('account_type', 'lead');

        // Check duplicate criteria based on options
        $duplicateFields = $options['duplicate_fields'] ?? ['email'];
        $conditions = [];

        foreach ($duplicateFields as $field) {
            if (!empty($leadData[$field])) {
                $conditions[] = [$field, $leadData[$field]];
            }
        }

        if (empty($conditions)) {
            return null;
        }

        return $query->where(function($q) use ($conditions) {
            foreach ($conditions as $condition) {
                $q->orWhere($condition[0], $condition[1]);
            }
        })->first();
    }

    /**
     * Update existing lead with new data.
     */
    protected function updateExistingLead(User $lead, array $newData, array $options): void
    {
        $updateableFields = $options['updateable_fields'] ?? ['lead_notes', 'lead_source', 'lead_score'];
        
        $updateData = [];
        foreach ($updateableFields as $field) {
            if (isset($newData[$field]) && !empty($newData[$field])) {
                $updateData[$field] = $newData[$field];
            }
        }

        if (!empty($updateData)) {
            $updateData['updated_at'] = now();
            $lead->update($updateData);
        }
    }

    /**
     * Get import status.
     */
    public function getImportStatus(int $importLogId): array
    {
        $importLog = LeadImportLog::find($importLogId);
        
        if (!$importLog) {
            return [
                'found' => false,
                'error' => 'Import log not found',
            ];
        }

        return [
            'found' => true,
            'status' => $importLog->status,
            'progress' => $importLog->total_rows > 0 ? 
                round(($importLog->processed_rows / $importLog->total_rows) * 100, 2) : 0,
            'total_rows' => $importLog->total_rows,
            'processed_rows' => $importLog->processed_rows,
            'successful_imports' => $importLog->successful_imports,
            'failed_imports' => $importLog->failed_imports,
            'duplicate_count' => $importLog->duplicate_count,
            'error_message' => $importLog->error_message,
            'validation_errors' => $importLog->validation_errors,
            'started_at' => $importLog->started_at,
            'completed_at' => $importLog->completed_at,
        ];
    }

    /**
     * Get import history for admin.
     */
    public function getImportHistory(Admin $admin, int $limit = 20): array
    {
        $imports = LeadImportLog::where('admin_id', $admin->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $imports->map(function($import) {
            return [
                'id' => $import->id,
                'filename' => $import->filename,
                'status' => $import->status,
                'total_rows' => $import->total_rows,
                'successful_imports' => $import->successful_imports,
                'failed_imports' => $import->failed_imports,
                'duplicate_count' => $import->duplicate_count,
                'created_at' => $import->created_at,
                'completed_at' => $import->completed_at,
                'duration' => $import->started_at && $import->completed_at ? 
                    $import->started_at->diffInSeconds($import->completed_at) : null,
            ];
        })->toArray();
    }

    /**
     * Cancel running import.
     */
    public function cancelImport(int $importLogId, Admin $admin): bool
    {
        try {
            $importLog = LeadImportLog::where('id', $importLogId)
                ->where('admin_id', $admin->id)
                ->where('status', 'processing')
                ->first();

            if (!$importLog) {
                return false;
            }

            $importLog->update([
                'status' => 'cancelled',
                'completed_at' => now(),
            ]);

            // Clean up temporary file
            if ($importLog->file_path) {
                Storage::delete($importLog->file_path);
            }

            Log::info('Import cancelled', [
                'import_log_id' => $importLogId,
                'admin_id' => $admin->id,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to cancel import', [
                'import_log_id' => $importLogId,
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}