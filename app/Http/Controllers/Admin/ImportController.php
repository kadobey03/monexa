<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    /**
     * Show the advanced import page with column mapping
     */
    public function showImportPage()
    {
        // Get lead statuses from database (active statuses only)
        $leadStatuses = \App\Models\LeadStatus::active()
            ->get()
            ->pluck('display_name', 'name')
            ->toArray();

        // Add fallback if no statuses found in database
        if (empty($leadStatuses)) {
            $leadStatuses = [
                'new' => 'Yeni',
                'contacted' => 'İletişimde',
                'interested' => 'İlgileniyor',
                'qualified' => 'Nitelikli',
                'converted' => 'Dönüştürülmüş',
                'lost' => 'Kayıp'
            ];
        }

        return view('admin.Users.import', compact('leadStatuses'));
    }

    /**
     * Legacy simple file import (backward compatibility)
     */
    public function fileImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $import = new UsersImport();
            Excel::import($import, $request->file('file'));
            
            $stats = $import->getImportStats();
            $failures = $import->failures();
            
            $message = "Import tamamlandı! ";
            $message .= "{$stats['imported']} lead başarıyla eklendi";
            
            if ($stats['skipped'] > 0) {
                $message .= ", {$stats['skipped']} lead atlandı";
            }
            
            if (count($failures) > 0) {
                $message .= ", " . count($failures) . " satırda hata oluştu";
                
                // Store errors in session for display
                session(['import_errors' => array_slice($failures, 0, 10)]); // Show first 10 errors
            }
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Lead import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Import sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Preview uploaded Excel file and extract columns
     */
    public function previewFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $fileName = 'temp_import_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('temp_imports', $fileName, 'local');
            
            // Read Excel file
            $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
            
            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Excel dosyası boş görünüyor.'
                ], 400);
            }

            // Get headers and sample data
            $headers = array_shift($data); // First row as headers
            $sampleData = array_slice($data, 0, 5); // First 5 rows as sample
            
            // Clean up temp file
            Storage::disk('local')->delete($filePath);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'headers' => $headers,
                    'sample' => $sampleData,
                    'total_rows' => count($data) + 1 // +1 for header row
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('File preview error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Dosya önizlemesi sırasında hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process import with column mappings
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:10240',
            'mappings' => 'required|json',
            'settings' => 'required|json'
        ]);

        try {
            $mappings = json_decode($request->input('mappings'), true);
            $settings = json_decode($request->input('settings'), true);
            
            // Validate required mappings - flexible name validation
            $hasName = isset($mappings['name']);
            $hasFirstAndLastName = isset($mappings['first_name']) && isset($mappings['last_name']);
            $hasEmail = isset($mappings['email']);
            
            if (!$hasEmail) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-posta alanı zorunludur.'
                ], 400);
            }
            
            if (!$hasName && !$hasFirstAndLastName) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ad Soyad alanı veya Ad (Ayrı) + Soyad (Ayrı) alanları zorunludur.'
                ], 400);
            }

            // Create advanced import with mappings
            $import = new UsersImport($mappings, $settings);
            Excel::import($import, $request->file('file'));
            
            $stats = $import->getImportStats();
            $failures = $import->failures();
            
            // Prepare detailed results
            $results = [
                'total' => $stats['total'] ?? 0,
                'imported' => $stats['imported'] ?? 0,
                'skipped' => $stats['skipped'] ?? 0,
                'errors' => count($failures),
                'duplicates' => $stats['duplicates'] ?? 0,
                'errorDetails' => [],
                'duplicateDetails' => $stats['duplicate_details'] ?? [],
                'duplicateFile' => $import->getDuplicateFile()
            ];

            // Format error details
            if (!empty($failures)) {
                foreach ($failures as $failure) {
                    $results['errorDetails'][] = [
                        'row' => $failure->row(),
                        'errors' => $failure->errors()
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'İçe aktarma başarıyla tamamlandı.',
                'results' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Advanced import error: ' . $e->getMessage(), [
                'file' => $request->file('file')?->getClientOriginalName(),
                'mappings' => $request->input('mappings'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'İçe aktarma sırasında hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download sample Excel template
     */
    public function downloadTemplate()
    {
        try {
            $templatePath = storage_path('app/templates/users_import_template.xlsx');
            
            // Create template if it doesn't exist
            if (!file_exists($templatePath)) {
                $this->createImportTemplate($templatePath);
            }
            
            return Response::download($templatePath, 'kullanici_import_sablonu.xlsx');
            
        } catch (\Exception $e) {
            Log::error('Template download error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Şablon dosyası indirilemedi.');
        }
    }

    /**
     * Legacy method for backward compatibility
     */
    public function downloadDoc()
    {
        return $this->downloadTemplate();
    }

    /**
     * Create Excel import template
     */
    private function createImportTemplate($templatePath)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $headers = [
            'Ad Soyad',
            'E-posta',
            'Telefon',
            'Ülke',
            'Kullanıcı Adı',
            'Tahmini Değer',
            'Lead Durumu',
            'Notlar'
        ];
        
        foreach ($headers as $index => $header) {
            $sheet->setCellValue(chr(65 + $index) . '1', $header);
        }
        
        // Add sample data
        $sampleData = [
            ['Ahmet Yılmaz', 'ahmet@example.com', '+90 555 123 4567', 'Türkiye', 'ahmetyilmaz', '50000', 'Yeni Lead', 'Potansiyel müşteri'],
            ['Ayşe Demir', 'ayse@example.com', '+90 555 987 6543', 'Türkiye', 'aysedemir', '75000', 'Arandı', 'İlk görüşme yapıldı'],
            ['Mehmet Kaya', 'mehmet@example.com', '+90 555 456 7890', 'Türkiye', 'mehmetkaya', '100000', 'Potansiyel', 'Yüksek potansiyelli']
        ];
        
        foreach ($sampleData as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $sheet->setCellValue(chr(65 + $colIndex) . ($rowIndex + 2), $value);
            }
        }
        
        // Style the header row
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50']
            ]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        
        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Ensure directory exists
        $directory = dirname($templatePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Save template
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($templatePath);
    }

    /**
     * Download duplicate users Excel file
     */
    public function downloadDuplicates($fileName)
    {
        try {
            $filePath = storage_path('app/exports/' . $fileName);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'Duplicate dosyası bulunamadı.');
            }
            
            return Response::download($filePath, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ])->deleteFileAfterSend();
            
        } catch (\Exception $e) {
            Log::error('Duplicate file download error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Dosya indirilemedi.');
        }
    }
}