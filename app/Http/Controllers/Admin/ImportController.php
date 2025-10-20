<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Response;

class ImportController extends Controller
{
    //
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
            \Log::error('Lead import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Import sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function downloadDoc()
    {
        $download_path = (public_path() .  '/storage/' . 'leads.xlsx');
        return (Response::download($download_path));
    }
}