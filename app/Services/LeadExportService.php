<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Models\LeadExportLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LeadExportService
{
    protected $authService;
    protected $tableService;
    
    /**
     * Supported export formats.
     */
    protected $supportedFormats = [
        'csv' => 'CSV',
        'xlsx' => 'Excel (XLSX)',
        'xls' => 'Excel (XLS)',
    ];

    /**
     * Export templates.
     */
    protected $exportTemplates = [
        'basic' => [
            'name' => 'Basic Lead Information',
            'description' => 'Essential lead data only',
            'columns' => ['name', 'email', 'phone', 'country', 'created_at'],
        ],
        'standard' => [
            'name' => 'Standard Lead Export',
            'description' => 'Commonly used lead fields',
            'columns' => ['name', 'email', 'phone', 'country', 'lead_status', 'assigned_admin', 'lead_source', 'created_at'],
        ],
        'comprehensive' => [
            'name' => 'Comprehensive Export',
            'description' => 'All available lead data',
            'columns' => ['name', 'email', 'phone', 'country', 'lead_status', 'assigned_admin', 'lead_source', 'lead_score', 'lead_priority', 'created_at', 'last_contact_date', 'next_follow_up_date', 'lead_notes'],
        ],
        'sales_report' => [
            'name' => 'Sales Report',
            'description' => 'Lead data optimized for sales analysis',
            'columns' => ['name', 'email', 'phone', 'lead_status', 'assigned_admin', 'lead_source', 'lead_score', 'created_at', 'last_contact_date'],
        ],
        'marketing_report' => [
            'name' => 'Marketing Report',
            'description' => 'Lead data for marketing analysis',
            'columns' => ['name', 'email', 'country', 'lead_source', 'lead_score', 'created_at'],
        ],
    ];

    public function __construct(
        LeadAuthorizationService $authService,
        LeadTableService $tableService
    ) {
        $this->authService = $authService;
        $this->tableService = $tableService;
    }

    /**
     * Start export process.
     */
    public function startExport(Admin $admin, array $options = []): array
    {
        try {
            // Validate export options
            $validation = $this->validateExportOptions($options);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'error' => $validation['error'],
                ];
            }

            // Get authorized leads query
            $query = $this->authService->getAuthorizedLeadsQuery($admin);
            
            // Apply filters if provided
            if (!empty($options['filters'])) {
                $query = $this->authService->applyFilters($query, $options['filters']);
            }

            // Apply search if provided
            if (!empty($options['search'])) {
                $query = $this->tableService->applyGlobalSearch($query, $options['search']);
            }

            // Count total records for export
            $totalRecords = $query->count();

            if ($totalRecords === 0) {
                return [
                    'success' => false,
                    'error' => 'No leads found matching the specified criteria.',
                ];
            }

            // Check export limits
            $maxRecords = $this->getMaxExportRecords($admin);
            if ($totalRecords > $maxRecords) {
                return [
                    'success' => false,
                    'error' => "Export limit exceeded. Maximum {$maxRecords} records allowed, found {$totalRecords} records.",
                ];
            }

            // Create export log
            $exportLog = LeadExportLog::create([
                'admin_id' => $admin->id,
                'status' => 'pending',
                'format' => $options['format'] ?? 'xlsx',
                'template' => $options['template'] ?? 'standard',
                'total_records' => $totalRecords,
                'export_filters' => $options['filters'] ?? [],
                'export_search' => $options['search'] ?? null,
                'export_options' => $options,
                'started_at' => now(),
            ]);

            // Generate filename
            $filename = $this->generateFilename($admin, $options);
            $exportLog->update(['filename' => $filename]);

            Log::info('Export started', [
                'admin_id' => $admin->id,
                'export_log_id' => $exportLog->id,
                'total_records' => $totalRecords,
                'format' => $options['format'] ?? 'xlsx',
            ]);

            return [
                'success' => true,
                'export_log_id' => $exportLog->id,
                'total_records' => $totalRecords,
                'estimated_size' => $this->estimateFileSize($totalRecords, $options),
            ];

        } catch (\Exception $e) {
            Log::error('Export initialization failed', [
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
                'options' => $options,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to initialize export: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Process export.
     */
    public function processExport(int $exportLogId): array
    {
        try {
            $exportLog = LeadExportLog::findOrFail($exportLogId);
            
            // Update status
            $exportLog->update(['status' => 'processing']);

            // Get admin and rebuild query
            $admin = Admin::findOrFail($exportLog->admin_id);
            $query = $this->authService->getAuthorizedLeadsQuery($admin);
            
            // Reapply filters
            if (!empty($exportLog->export_filters)) {
                $query = $this->authService->applyFilters($query, $exportLog->export_filters);
            }

            if (!empty($exportLog->export_search)) {
                $query = $this->tableService->applyGlobalSearch($query, $exportLog->export_search);
            }

            // Apply sorting if specified
            $options = $exportLog->export_options ?? [];
            if (!empty($options['sort_column'])) {
                $query = $this->tableService->applySorting(
                    $query, 
                    $options['sort_column'], 
                    $options['sort_direction'] ?? 'desc'
                );
            }

            // Get columns to export
            $columns = $this->getExportColumns($exportLog->template, $options);

            // Create export instance
            $export = new LeadExport($query, $columns, $options);

            // Generate file
            $filePath = $this->generateFilePath($exportLog->filename, $exportLog->format);
            
            Excel::store($export, $filePath, 'exports');

            // Update export log
            $fileSize = Storage::disk('exports')->size($filePath);
            $downloadUrl = $this->generateDownloadUrl($filePath);

            $exportLog->update([
                'status' => 'completed',
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'download_url' => $downloadUrl,
                'completed_at' => now(),
                'expires_at' => now()->addDays(7), // Files expire after 7 days
            ]);

            Log::info('Export completed', [
                'export_log_id' => $exportLogId,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'records_exported' => $exportLog->total_records,
            ]);

            return [
                'success' => true,
                'file_path' => $filePath,
                'download_url' => $downloadUrl,
                'file_size' => $fileSize,
                'records_exported' => $exportLog->total_records,
            ];

        } catch (\Exception $e) {
            if (isset($exportLog)) {
                $exportLog->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }

            Log::error('Export processing failed', [
                'export_log_id' => $exportLogId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Export processing failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get export templates.
     */
    public function getExportTemplates(): array
    {
        return $this->exportTemplates;
    }

    /**
     * Get supported formats.
     */
    public function getSupportedFormats(): array
    {
        return $this->supportedFormats;
    }

    /**
     * Validate export options.
     */
    protected function validateExportOptions(array $options): array
    {
        $errors = [];

        // Validate format
        if (!empty($options['format']) && !isset($this->supportedFormats[$options['format']])) {
            $errors[] = 'Invalid export format specified.';
        }

        // Validate template
        if (!empty($options['template']) && !isset($this->exportTemplates[$options['template']])) {
            $errors[] = 'Invalid export template specified.';
        }

        return [
            'valid' => empty($errors),
            'error' => implode(' ', $errors),
        ];
    }

    /**
     * Get maximum export records allowed for admin.
     */
    protected function getMaxExportRecords(Admin $admin): int
    {
        $roleName = $admin->role?->name;
        
        // Define limits based on role
        $limits = [
            'super_admin' => 100000,
            'head_of_office' => 50000,
            'sales_head' => 25000,
            'retention_head' => 25000,
            'team_leader' => 10000,
            'retention_team_leader' => 10000,
            'sales_agent' => 5000,
            'retention_agent' => 5000,
        ];

        return $limits[$roleName] ?? 1000;
    }

    /**
     * Generate export filename.
     */
    protected function generateFilename(Admin $admin, array $options): string
    {
        $template = $options['template'] ?? 'standard';
        $format = $options['format'] ?? 'xlsx';
        $timestamp = now()->format('Y-m-d_H-i-s');
        $adminName = Str::slug($admin->getFullName());
        
        return "leads_export_{$template}_{$adminName}_{$timestamp}.{$format}";
    }

    /**
     * Generate file path for storage.
     */
    protected function generateFilePath(string $filename, string $format): string
    {
        $date = now()->format('Y/m/d');
        return "leads/{$date}/{$filename}";
    }

    /**
     * Generate download URL.
     */
    protected function generateDownloadUrl(string $filePath): string
    {
        return route('admin.leads.export.download', [
            'file' => base64_encode($filePath)
        ]);
    }

    /**
     * Estimate file size.
     */
    protected function estimateFileSize(int $totalRecords, array $options): string
    {
        $format = $options['format'] ?? 'xlsx';
        $avgBytesPerRecord = $format === 'csv' ? 150 : 300; // Rough estimate
        
        $estimatedBytes = $totalRecords * $avgBytesPerRecord;
        
        if ($estimatedBytes < 1024) {
            return $estimatedBytes . ' B';
        } elseif ($estimatedBytes < 1024 * 1024) {
            return round($estimatedBytes / 1024, 1) . ' KB';
        } else {
            return round($estimatedBytes / (1024 * 1024), 1) . ' MB';
        }
    }

    /**
     * Get columns for export based on template and options.
     */
    protected function getExportColumns(string $template, array $options): array
    {
        if (!empty($options['custom_columns'])) {
            return $options['custom_columns'];
        }

        if (isset($this->exportTemplates[$template])) {
            return $this->exportTemplates[$template]['columns'];
        }

        return $this->exportTemplates['standard']['columns'];
    }

    /**
     * Get export status.
     */
    public function getExportStatus(int $exportLogId): array
    {
        $exportLog = LeadExportLog::find($exportLogId);
        
        if (!$exportLog) {
            return [
                'found' => false,
                'error' => 'Export log not found',
            ];
        }

        $result = [
            'found' => true,
            'status' => $exportLog->status,
            'total_records' => $exportLog->total_records,
            'filename' => $exportLog->filename,
            'format' => $exportLog->format,
            'template' => $exportLog->template,
            'started_at' => $exportLog->started_at,
            'completed_at' => $exportLog->completed_at,
            'expires_at' => $exportLog->expires_at,
        ];

        if ($exportLog->status === 'completed') {
            $result['download_url'] = $exportLog->download_url;
            $result['file_size'] = $exportLog->file_size;
            $result['file_size_formatted'] = $this->formatFileSize($exportLog->file_size);
        }

        if ($exportLog->status === 'failed') {
            $result['error_message'] = $exportLog->error_message;
        }

        return $result;
    }

    /**
     * Get export history for admin.
     */
    public function getExportHistory(Admin $admin, int $limit = 20): array
    {
        $exports = LeadExportLog::where('admin_id', $admin->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $exports->map(function($export) {
            return [
                'id' => $export->id,
                'filename' => $export->filename,
                'status' => $export->status,
                'format' => $export->format,
                'template' => $export->template,
                'total_records' => $export->total_records,
                'file_size_formatted' => $export->file_size ? $this->formatFileSize($export->file_size) : null,
                'download_url' => $export->status === 'completed' ? $export->download_url : null,
                'created_at' => $export->created_at,
                'completed_at' => $export->completed_at,
                'expires_at' => $export->expires_at,
                'is_expired' => $export->expires_at && $export->expires_at->isPast(),
                'duration' => $export->started_at && $export->completed_at ? 
                    $export->started_at->diffInSeconds($export->completed_at) : null,
            ];
        })->toArray();
    }

    /**
     * Download export file.
     */
    public function downloadExport(int $exportLogId, Admin $admin): array
    {
        try {
            $exportLog = LeadExportLog::where('id', $exportLogId)
                ->where('admin_id', $admin->id)
                ->where('status', 'completed')
                ->first();

            if (!$exportLog) {
                return [
                    'success' => false,
                    'error' => 'Export not found or not accessible.',
                ];
            }

            // Check if file has expired
            if ($exportLog->expires_at && $exportLog->expires_at->isPast()) {
                return [
                    'success' => false,
                    'error' => 'Export file has expired.',
                ];
            }

            // Check if file exists
            if (!Storage::disk('exports')->exists($exportLog->file_path)) {
                return [
                    'success' => false,
                    'error' => 'Export file not found.',
                ];
            }

            // Update download count
            $exportLog->increment('download_count');
            $exportLog->update(['last_downloaded_at' => now()]);

            return [
                'success' => true,
                'file_path' => $exportLog->file_path,
                'filename' => $exportLog->filename,
                'file_size' => $exportLog->file_size,
            ];

        } catch (\Exception $e) {
            Log::error('Export download failed', [
                'export_log_id' => $exportLogId,
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Failed to download export: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Clean up expired exports.
     */
    public function cleanupExpiredExports(): int
    {
        $expiredExports = LeadExportLog::where('expires_at', '<', now())
            ->where('status', 'completed')
            ->get();

        $cleanedCount = 0;

        foreach ($expiredExports as $export) {
            try {
                // Delete file from storage
                if ($export->file_path && Storage::disk('exports')->exists($export->file_path)) {
                    Storage::disk('exports')->delete($export->file_path);
                }

                // Update export log
                $export->update([
                    'status' => 'expired',
                    'file_path' => null,
                    'download_url' => null,
                ]);

                $cleanedCount++;

            } catch (\Exception $e) {
                Log::error('Failed to cleanup expired export', [
                    'export_log_id' => $export->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Expired exports cleanup completed', [
            'cleaned_count' => $cleanedCount,
            'total_expired' => $expiredExports->count(),
        ]);

        return $cleanedCount;
    }

    /**
     * Format file size in human readable format.
     */
    protected function formatFileSize(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        } elseif ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1) . ' KB';
        } elseif ($bytes < 1024 * 1024 * 1024) {
            return round($bytes / (1024 * 1024), 1) . ' MB';
        } else {
            return round($bytes / (1024 * 1024 * 1024), 1) . ' GB';
        }
    }

    /**
     * Get export statistics.
     */
    public function getExportStatistics(Admin $admin, string $period = '30_days'): array
    {
        $startDate = $this->getStartDateForPeriod($period);
        
        $query = LeadExportLog::where('admin_id', $admin->id)
            ->where('created_at', '>=', $startDate);

        return [
            'total_exports' => $query->count(),
            'completed_exports' => $query->where('status', 'completed')->count(),
            'failed_exports' => $query->where('status', 'failed')->count(),
            'total_records_exported' => $query->where('status', 'completed')->sum('total_records'),
            'total_file_size' => $query->where('status', 'completed')->sum('file_size'),
            'most_used_format' => $query->groupBy('format')
                ->selectRaw('format, count(*) as count')
                ->orderByDesc('count')
                ->first()?->format,
            'most_used_template' => $query->groupBy('template')
                ->selectRaw('template, count(*) as count')
                ->orderByDesc('count')
                ->first()?->template,
        ];
    }

    /**
     * Get start date for period.
     */
    protected function getStartDateForPeriod(string $period): Carbon
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

/**
 * Lead Export Class for Excel generation.
 */
class LeadExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;
    protected $columns;
    protected $options;
    protected $columnLabels = [
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

    public function __construct(Builder $query, array $columns, array $options = [])
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->options = $options;
    }

    public function query()
    {
        return $this->query->with(['assignedAdmin:id,firstName,lastName', 'leadStatus:id,name']);
    }

    public function headings(): array
    {
        return array_map(function($column) {
            return $this->columnLabels[$column] ?? ucwords(str_replace('_', ' ', $column));
        }, $this->columns);
    }

    public function map($lead): array
    {
        $row = [];
        
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'assigned_admin':
                    $row[] = $lead->assignedAdmin ? $lead->assignedAdmin->getFullName() : '';
                    break;
                case 'lead_status':
                    $row[] = $lead->leadStatus ? $lead->leadStatus->name : '';
                    break;
                case 'created_at':
                case 'last_contact_date':
                case 'next_follow_up_date':
                    $row[] = $lead->$column ? $lead->$column->format('Y-m-d H:i:s') : '';
                    break;
                case 'lead_notes':
                    $row[] = Str::limit($lead->$column ?? '', 500);
                    break;
                default:
                    $row[] = $lead->$column ?? '';
                    break;
            }
        }
        
        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '366092'],
                ],
            ],
        ];
    }
}