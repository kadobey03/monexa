<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin;
use App\Models\LeadStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * User Export Service
 * 
 * Handles user data export functionality with Excel format support
 */
class UserExportService
{
    /**
     * Export filtered users to Excel
     */
    public function exportUsers(Admin $admin, array $filters = []): array
    {
        try {
            // Validate export options
            $validation = $this->validateExportOptions($filters);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'error' => $validation['error'],
                ];
            }

            // Build user query with filters (same logic as manageusers method)
            $query = User::with(['leadStatus', 'assignedAdmin']);
            
            // Apply filters
            $query = $this->applyFilters($query, $filters);
            
            // Get total records count
            $totalRecords = $query->count();
            
            // Check export limits
            $maxRecords = $this->getMaxExportRecords($admin);
            if ($totalRecords > $maxRecords) {
                return [
                    'success' => false,
                    'error' => "Export limiti aşıldı. Maksimum {$maxRecords} kayıt izni var, {$totalRecords} kayıt bulundu.",
                ];
            }

            // Create export instance
            $export = new UserExport($query);
            
            // Generate filename
            $filename = $this->generateFilename($filters);
            
            // Store Excel file
            Excel::store($export, $filename, 'local');
            
            // Get file path
            $filePath = storage_path('app/' . $filename);
            
            // Log export operation
            Log::info('User Export Completed', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->firstName . ' ' . $admin->lastName,
                'total_records' => $totalRecords,
                'filters' => $filters,
                'filename' => $filename,
                'file_size' => file_exists($filePath) ? filesize($filePath) : 0,
            ]);

            return [
                'success' => true,
                'file_path' => $filePath,
                'filename' => $filename,
                'total_records' => $totalRecords,
                'message' => "{$totalRecords} kullanıcı başarıyla export edildi.",
            ];

        } catch (\Exception $e) {
            Log::error('User Export Failed', [
                'admin_id' => $admin->id,
                'filters' => $filters,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Export işlemi sırasında bir hata oluştu: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Export selected users by their IDs
     */
    public function exportSelectedUsers(Admin $admin, array $userIds = []): array
    {
        try {
            // Validate user IDs
            if (empty($userIds)) {
                return [
                    'success' => false,
                    'error' => 'Hiç kullanıcı seçilmedi.',
                ];
            }

            // Validate and clean user IDs
            $cleanUserIds = array_filter(array_map('intval', $userIds), function($id) {
                return $id > 0;
            });

            if (empty($cleanUserIds)) {
                return [
                    'success' => false,
                    'error' => 'Geçerli kullanıcı ID\'si bulunamadı.',
                ];
            }

            // Build query for selected users
            $query = User::with(['leadStatus', 'assignedAdmin'])
                ->whereIn('id', $cleanUserIds);
            
            // Get total records count
            $totalRecords = $query->count();
            
            if ($totalRecords === 0) {
                return [
                    'success' => false,
                    'error' => 'Seçili kullanıcılar bulunamadı.',
                ];
            }

            // Check export limits
            $maxRecords = $this->getMaxExportRecords($admin);
            if ($totalRecords > $maxRecords) {
                return [
                    'success' => false,
                    'error' => "Export limiti aşıldı. Maksimum {$maxRecords} kayıt izni var, {$totalRecords} kayıt seçildi.",
                ];
            }

            // Create export instance
            $export = new UserExport($query);
            
            // Generate filename for selected users
            $filename = $this->generateSelectedUsersFilename($totalRecords);
            
            // Store Excel file
            Excel::store($export, $filename, 'local');
            
            // Get file path
            $filePath = storage_path('app/' . $filename);
            
            // Log export operation
            Log::info('Selected Users Export Completed', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->firstName . ' ' . $admin->lastName,
                'selected_user_ids' => $cleanUserIds,
                'total_records' => $totalRecords,
                'filename' => $filename,
                'file_size' => file_exists($filePath) ? filesize($filePath) : 0,
            ]);

            return [
                'success' => true,
                'file_path' => $filePath,
                'filename' => $filename,
                'total_records' => $totalRecords,
                'message' => "{$totalRecords} seçili kullanıcı başarıyla export edildi.",
            ];

        } catch (\Exception $e) {
            Log::error('Selected Users Export Failed', [
                'admin_id' => $admin->id,
                'user_ids' => $userIds ?? [],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Seçili kullanıcılar export işlemi sırasında bir hata oluştu: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Apply filters to the user query
     */
    protected function applyFilters(Builder $query, array $filters): Builder
    {
        // Status filter
        if (!empty($filters['status'])) {
            $query->where('lead_status', $filters['status']);
        }
        
        // Admin assignment filter
        if (!empty($filters['admin'])) {
            $query->where('assign_to', $filters['admin']);
        }
        
        // Date from filter
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        
        // Date to filter
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Default ordering
        $query->orderBy('id', 'desc');

        return $query;
    }

    /**
     * Validate export options
     */
    protected function validateExportOptions(array $filters): array
    {
        try {
            // Validate status
            if (!empty($filters['status'])) {
                $statusExists = LeadStatus::where('name', $filters['status'])->exists();
                if (!$statusExists) {
                    return [
                        'valid' => false,
                        'error' => 'Geçersiz lead status seçimi.',
                    ];
                }
            }

            // Validate admin
            if (!empty($filters['admin'])) {
                $adminExists = Admin::where('id', $filters['admin'])->where('status', 'Active')->exists();
                if (!$adminExists) {
                    return [
                        'valid' => false,
                        'error' => 'Geçersiz admin seçimi.',
                    ];
                }
            }

            // Validate dates
            if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
                if (strtotime($filters['date_from']) > strtotime($filters['date_to'])) {
                    return [
                        'valid' => false,
                        'error' => 'Başlangıç tarihi bitiş tarihinden büyük olamaz.',
                    ];
                }
            }

            return ['valid' => true];

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'error' => 'Filter validasyon hatası: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get maximum allowed export records for admin
     */
    protected function getMaxExportRecords(Admin $admin): int
    {
        // Super Admin can export unlimited (but we set a high limit)
        if ($admin->type === 'Super Admin') {
            return 10000;
        }

        // Regular admins have lower limits
        return 1000;
    }

    /**
     * Generate export filename
     */
    protected function generateFilename(array $filters): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filterString = '';
        
        if (!empty($filters['status'])) {
            $filterString .= '_status-' . $filters['status'];
        }
        
        if (!empty($filters['admin'])) {
            $filterString .= '_admin-' . $filters['admin'];
        }
        
        if (!empty($filters['date_from'])) {
            $filterString .= '_from-' . str_replace('-', '', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $filterString .= '_to-' . str_replace('-', '', $filters['date_to']);
        }

        return "user_export_{$timestamp}{$filterString}.xlsx";
    }

    /**
     * Generate filename for selected users export
     */
    protected function generateSelectedUsersFilename(int $recordCount): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return "selected_users_export_{$timestamp}_{$recordCount}_records.xlsx";
    }

    /**
     * Clean up old export files
     */
    public function cleanupExpiredExports(): int
    {
        $exportPath = storage_path('app/');
        $cleanedCount = 0;
        
        // Delete files older than 24 hours
        $files = glob($exportPath . 'user_export_*.xlsx');
        $expireTime = time() - (24 * 60 * 60); // 24 hours
        
        foreach ($files as $file) {
            if (file_exists($file) && filemtime($file) < $expireTime) {
                if (unlink($file)) {
                    $cleanedCount++;
                }
            }
        }
        
        Log::info('User Export Cleanup', [
            'cleaned_files' => $cleanedCount,
            'total_checked' => count($files),
        ]);
        
        return $cleanedCount;
    }
}

/**
 * User Export Class for Excel generation
 */
class UserExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * Get the query for export
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Define Excel column headings
     */
    public function headings(): array
    {
        return [
            'ID',
            'Ad Soyad',
            'E-posta',
            'Telefon',
            'Kayıt Tarihi',
            'Lead Status',
            'Atanan Admin',
            'Durum',
            'E-posta Doğrulama',
            'Son Giriş',
        ];
    }

    /**
     * Map user data to Excel rows
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name ?? 'Ad Soyad Yok',
            $user->email ?? '',
            $user->phone ?? '',
            $user->created_at ? $user->created_at->format('d.m.Y H:i') : '',
            $user->leadStatus ? ($user->leadStatus->display_name ?: $user->leadStatus->name) : ($user->lead_status ?: 'Belirtilmemiş'),
            $user->assignedAdmin ? $user->assignedAdmin->getDisplayName() : 'Atanmamış',
            ucfirst($user->status ?? 'active'),
            $user->email_verified_at ? 'Doğrulandı' : 'Bekliyor',
            $user->last_login_at ? $user->last_login_at->format('d.m.Y H:i') : 'Hiç giriş yapmamış',
        ];
    }

    /**
     * Apply styles to the Excel sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F46E5'], // Indigo color
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Data rows styling
        $highestRow = $sheet->getHighestRow();
        if ($highestRow > 1) {
            $sheet->getStyle('A2:J' . $highestRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'E5E7EB'],
                    ],
                ],
            ]);

            // Alternate row colors
            for ($row = 2; $row <= $highestRow; $row += 2) {
                $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'F9FAFB'],
                    ],
                ]);
            }
        }

        return $sheet;
    }
}