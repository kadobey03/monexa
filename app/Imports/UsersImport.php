<?php

namespace App\Imports;

use App\Models\User;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class UsersImport implements ToCollection, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use SkipsFailures;
    
    protected $columnMappings = [];
    protected $importSettings = [];
    protected $importStats = [
        'total' => 0,
        'imported' => 0,
        'skipped' => 0,
        'duplicates' => 0,
        'errors' => [],
        'duplicate_details' => []
    ];
    protected $duplicateRecords = [];
    protected $originalRowData = [];

    /**
     * Constructor with column mappings and settings
     */
    public function __construct($columnMappings = [], $importSettings = [])
    {
        $this->columnMappings = $columnMappings;
        $this->importSettings = array_merge([
            'skipDuplicates' => true,
            'sendWelcomeEmail' => false,
            'defaultLeadStatus' => 'new',
            'batchSize' => 100
        ], $importSettings);
    }

    /**
     * Process the collection with flexible column mapping
     */
    public function collection(Collection $rows)
    {
        $this->importStats['total'] = $rows->count();

        // Store original row data for duplicate export
        $this->originalRowData = $rows->toArray();

        foreach ($rows as $rowIndex => $row) {
            try {
                $mappedData = $this->mapRowData($row->toArray(), $rowIndex + 2); // +2 for header and 0-indexing
                
                if ($mappedData) {
                    $user = $this->createUser($mappedData, $rowIndex);
                    if ($user) {
                        $this->importStats['imported']++;
                        
                        // Send welcome email if enabled
                        if ($this->importSettings['sendWelcomeEmail']) {
                            try {
                                Mail::to($user->email)->queue(new WelcomeEmail($user));
                            } catch (\Exception $e) {
                                Log::warning('Welcome email failed for user: ' . $user->email, ['error' => $e->getMessage()]);
                            }
                        }
                    }
                } else {
                    $this->importStats['skipped']++;
                }
            } catch (\Exception $e) {
                $this->importStats['skipped']++;
                $this->importStats['errors'][] = [
                    'row' => $rowIndex + 2,
                    'errors' => [$e->getMessage()]
                ];
                Log::error('Import error on row ' . ($rowIndex + 2), ['error' => $e->getMessage()]);
            }
        }

        // Generate duplicate Excel file if duplicates found
        if (!empty($this->duplicateRecords)) {
            $this->generateDuplicateExcel();
        }
    }

    /**
     * Map row data using column mappings
     */
    private function mapRowData(array $row, int $rowNumber): ?array
    {
        $mappedData = [];
        
        foreach ($this->columnMappings as $systemField => $mapping) {
            $columnIndex = $mapping['index'];
            $value = $row[$columnIndex] ?? null;
            
            // Skip empty values for optional fields
            if (empty($value) && !in_array($systemField, ['name', 'email', 'first_name', 'last_name'])) {
                continue;
            }
            
            $mappedData[$systemField] = $value;
        }
        
        // Handle name combination from first_name and last_name
        if (!empty($mappedData['first_name']) && !empty($mappedData['last_name'])) {
            $mappedData['name'] = trim($mappedData['first_name'] . ' ' . $mappedData['last_name']);
        }
        
        // Validate required fields
        $hasName = !empty($mappedData['name']);
        $hasFirstAndLastName = !empty($mappedData['first_name']) && !empty($mappedData['last_name']);
        
        if ((!$hasName && !$hasFirstAndLastName) || empty($mappedData['email'])) {
            throw new \Exception("Ad Soyad (veya Ad+Soyad ayrı) ve E-posta alanları zorunludur.");
        }
        
        return $mappedData;
    }

    /**
     * Create user from mapped data
     */
    private function createUser(array $mappedData, int $rowIndex = 0): ?User
    {
        $email = strtolower(trim($mappedData['email']));
        $phone = $this->cleanPhone($mappedData['phone'] ?? null);
        
        // Check for email duplicates
        $emailExists = User::where('email', $email)->exists();
        
        // Check for phone duplicates (if phone is provided)
        $phoneExists = false;
        if ($phone) {
            $phoneExists = User::where('phone', $phone)->exists();
        }
        
        // If duplicates found, record them for export
        if ($emailExists || $phoneExists) {
            $duplicateInfo = [
                'row_index' => $rowIndex,
                'data' => $mappedData,
                'original_row' => $this->originalRowData[$rowIndex] ?? [],
                'duplicate_type' => []
            ];
            
            if ($emailExists) {
                $duplicateInfo['duplicate_type'][] = 'E-posta';
            }
            if ($phoneExists) {
                $duplicateInfo['duplicate_type'][] = 'Telefon';
            }
            
            $this->duplicateRecords[] = $duplicateInfo;
            $this->importStats['duplicates']++;
            $this->importStats['duplicate_details'][] = [
                'row' => $rowIndex + 2,
                'email' => $email,
                'phone' => $phone,
                'type' => implode(' + ', $duplicateInfo['duplicate_type'])
            ];
            
            // Skip if setting enabled
            if ($this->importSettings['skipDuplicates']) {
                return null;
            }
        }
        
        // Generate random password
        $randomPassword = $this->generateRandomPassword();
        
        // Get lead status
        $leadStatus = $this->importSettings['defaultLeadStatus'] ?? 'new';
        
        // Generate username if not provided
        $username = $mappedData['username'] ?? $this->generateUsername($mappedData['name'], $email);
        
        // UTM değerlerini belirle - önce Excel'den, sonra manuel değerler
        $utmSource = $mappedData['utm_source'] ?? $this->importSettings['manualUtmSource'] ?? null;
        $utmCampaign = $mappedData['utm_campaign'] ?? $this->importSettings['manualUtmCampaign'] ?? null;
        
        $userData = [
            'name' => $this->cleanName($mappedData['name']),
            'email' => $email,
            'password' => Hash::make($randomPassword),
            'email_verified_at' => now(),
            'username' => $username,
            'country' => $mappedData['country'] ?? null,
            'phone' => $this->cleanPhone($mappedData['phone'] ?? null),
            'status' => 'active',
            'lead_source' => 'import',
            'lead_status' => $leadStatus,
            'lead_score' => 10,
            'lead_notes' => 'Excel dosyasından içe aktarıldı: ' . now()->format('d.m.Y H:i'),
            'lead_tags' => ['imported', 'excel'],
            'estimated_value' => is_numeric($mappedData['estimated_value'] ?? null) ? $mappedData['estimated_value'] : null,
            'utm_source' => $utmSource,
            'utm_campaign' => $utmCampaign,
            'preferred_contact_method' => $this->determinePreferredContact($mappedData),
            'contact_history' => [[
                'type' => 'import',
                'note' => 'Lead Excel dosyasından içe aktarıldı',
                'admin_id' => auth('admin')->id(),
                'created_at' => now()->toISOString(),
            ]],
        ];
        
        return User::create($userData);
    }

    /**
     * Validation rules (dynamic based on mappings)
     */
    public function rules(): array
    {
        $rules = [];
        
        // Check if we have name OR first_name+last_name combination
        $hasName = isset($this->columnMappings['name']);
        $hasFirstAndLastName = isset($this->columnMappings['first_name']) && isset($this->columnMappings['last_name']);
        
        // Add rules based on mapped columns
        foreach ($this->columnMappings as $systemField => $mapping) {
            $columnIndex = $mapping['index'];
            
            switch ($systemField) {
                case 'name':
                    // Name is required only if we don't have first_name + last_name
                    $rules[$columnIndex] = ($hasFirstAndLastName ? 'nullable' : 'required') . '|string|max:255';
                    break;
                case 'first_name':
                    // First name is required only if we don't have name field
                    $rules[$columnIndex] = ($hasName ? 'nullable' : 'required') . '|string|max:100';
                    break;
                case 'last_name':
                    // Last name is required only if we don't have name field
                    $rules[$columnIndex] = ($hasName ? 'nullable' : 'required') . '|string|max:100';
                    break;
                case 'email':
                    $rules[$columnIndex] = 'required|email|max:255';
                    // Remove unique constraint to allow duplicate detection in createUser method
                    break;
                case 'phone':
                    $rules[$columnIndex] = 'nullable|string|max:20';
                    break;
                case 'country':
                    $rules[$columnIndex] = 'nullable|string|max:100';
                    break;
                case 'username':
                    $rules[$columnIndex] = 'nullable|string|max:255|unique:users,username';
                    break;
                case 'estimated_value':
                    $rules[$columnIndex] = 'nullable|numeric|min:0';
                    break;
                case 'utm_source':
                    $rules[$columnIndex] = 'nullable|string|max:255';
                    break;
                case 'utm_campaign':
                    $rules[$columnIndex] = 'nullable|string|max:255';
                    break;
            }
        }
        
        return $rules;
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            '*.required' => 'Bu alan zorunludur.',
            '*.email' => 'Geçerli bir e-posta adresi girin.',
            '*.unique' => 'Bu değer zaten sistemde kayıtlı.',
            '*.numeric' => 'Bu alan sayısal olmalıdır.',
            '*.min' => 'Bu alan minimum :min değerinde olmalıdır.',
            '*.max' => 'Bu alan maksimum :max karakter olabilir.',
        ];
    }

    /**
     * Chunk size for processing
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Batch size for inserts
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Clean and format name
     */
    private function cleanName($name)
    {
        return trim(ucwords(strtolower($name)));
    }

    /**
     * Clean and format phone number
     */
    private function cleanPhone($phone)
    {
        if (!$phone) return null;
        
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Add country code if missing (assuming Turkey +90)
        if (strlen($phone) == 10 && !str_starts_with($phone, '+')) {
            $phone = '+90' . $phone;
        }
        
        return $phone;
    }

    /**
     * Generate username from name and email
     */
    private function generateUsername($name, $email)
    {
        $emailPrefix = explode('@', $email)[0];
        $baseUsername = strtolower(Str::slug($name . '_' . $emailPrefix, '_'));
        
        // Ensure uniqueness
        $username = $baseUsername;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }
        
        return $username;
    }

    /**
     * Generate random password
     */
    private function generateRandomPassword()
    {
        return Str::random(8) . rand(10, 99); // 8 chars + 2 numbers
    }

    /**
     * Determine preferred contact method from mapped data
     */
    private function determinePreferredContact($mappedData)
    {
        // If phone exists, prefer phone, otherwise email
        if (!empty($mappedData['phone'])) {
            return 'phone';
        }
        return 'email';
    }

    /**
     * Get import statistics
     */
    public function getImportStats()
    {
        return $this->importStats;
    }

    /**
     * Handle failed rows
     */
    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->importStats['errors'][] = [
                'row' => $failure->row(),
                'errors' => $failure->errors()
            ];
            $this->importStats['skipped']++;
        }
    }

    /**
     * Get column mappings
     */
    public function getColumnMappings()
    {
        return $this->columnMappings;
    }

    /**
     * Get import settings
     */
    public function getImportSettings()
    {
        return $this->importSettings;
    }

    /**
     * Set column mappings (for testing or dynamic updates)
     */
    public function setColumnMappings(array $mappings)
    {
        $this->columnMappings = $mappings;
        return $this;
    }

    /**
     * Set import settings (for testing or dynamic updates)
     */
    public function setImportSettings(array $settings)
    {
        $this->importSettings = array_merge($this->importSettings, $settings);
        return $this;
    }

    /**
     * Generate Excel file with duplicate records
     */
    private function generateDuplicateExcel()
    {
        if (empty($this->duplicateRecords)) {
            return;
        }

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set title
            $sheet->setTitle('Duplicate Kullanıcılar');
            
            // Get column headers from mappings
            $headers = $this->getDuplicateExcelHeaders();
            
            // Add extra columns for duplicate info
            $headers[] = 'Duplicate Türü';
            $headers[] = 'Satır No';
            $headers[] = 'Import Tarihi';
            
            // Set headers
            foreach ($headers as $index => $header) {
                $sheet->setCellValue($this->getExcelColumn($index) . '1', $header);
            }
            
            // Add duplicate data
            $rowNum = 2;
            foreach ($this->duplicateRecords as $duplicate) {
                $colIndex = 0;
                
                // Add original data
                foreach ($duplicate['original_row'] as $cellValue) {
                    $sheet->setCellValue($this->getExcelColumn($colIndex) . $rowNum, $cellValue);
                    $colIndex++;
                }
                
                // Add duplicate info
                $sheet->setCellValue($this->getExcelColumn($colIndex++) . $rowNum, implode(' + ', $duplicate['duplicate_type']));
                $sheet->setCellValue($this->getExcelColumn($colIndex++) . $rowNum, $duplicate['row_index'] + 2);
                $sheet->setCellValue($this->getExcelColumn($colIndex++) . $rowNum, now()->format('d.m.Y H:i'));
                
                $rowNum++;
            }
            
            // Style the header row
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE74C3C']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $sheet->getStyle('A1:' . $this->getExcelColumn(count($headers) - 1) . '1')->applyFromArray($headerStyle);
            
            // Auto-size columns
            foreach (range('A', $this->getExcelColumn(count($headers) - 1)) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Save file
            $fileName = 'duplicate_kullanicilar_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
            $filePath = storage_path('app/exports/' . $fileName);
            
            // Ensure directory exists
            $directory = dirname($filePath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($filePath);
            
            // Store file info for download
            $this->importStats['duplicate_file'] = [
                'path' => $filePath,
                'name' => $fileName,
                'url' => '/admin/dashboard/users/import/download-duplicates/' . $fileName
            ];
            
            Log::info('Duplicate Excel file generated: ' . $fileName, [
                'duplicates_count' => count($this->duplicateRecords),
                'file_path' => $filePath
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generating duplicate Excel: ' . $e->getMessage());
        }
    }

    /**
     * Get headers for duplicate Excel file
     */
    private function getDuplicateExcelHeaders(): array
    {
        // Use original Excel headers if available
        if (!empty($this->originalRowData) && !empty($this->originalRowData[0])) {
            return array_keys($this->originalRowData[0]);
        }
        
        // Fallback to mapped fields
        $headers = [];
        foreach ($this->columnMappings as $systemField => $mapping) {
            $headers[] = $mapping['name'] ?? ucfirst(str_replace('_', ' ', $systemField));
        }
        
        return $headers;
    }

    /**
     * Convert column index to Excel column letter
     */
    private function getExcelColumn(int $index): string
    {
        $column = '';
        while ($index >= 0) {
            $column = chr(65 + ($index % 26)) . $column;
            $index = intval($index / 26) - 1;
        }
        return $column;
    }

    /**
     * Get duplicate records for export
     */
    public function getDuplicateRecords(): array
    {
        return $this->duplicateRecords;
    }

    /**
     * Get duplicate file info
     */
    public function getDuplicateFile(): ?array
    {
        return $this->importStats['duplicate_file'] ?? null;
    }
}