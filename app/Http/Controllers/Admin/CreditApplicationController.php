<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CreditApplicationController extends Controller
{
    /**
     * Display a listing of credit applications.
     */
    public function index(Request $request)
    {
        $query = DB::table('credit_applications as ca')
            ->leftJoin('users as u', 'ca.user_id', '=', 'u.id')
            ->select([
                'ca.*',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone'
            ]);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('ca.status', $request->status);
        }

        if ($request->filled('amount_range')) {
            switch ($request->amount_range) {
                case '0-5000':
                    $query->whereBetween('ca.amount', [0, 5000]);
                    break;
                case '5000-10000':
                    $query->whereBetween('ca.amount', [5000, 10000]);
                    break;
                case '10000+':
                    $query->where('ca.amount', '>', 10000);
                    break;
            }
        }

        if ($request->filled('application_date')) {
            $query->whereDate('ca.created_at', $request->application_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('u.name', 'like', "%{$search}%")
                  ->orWhere('u.email', 'like', "%{$search}%")
                  ->orWhere('ca.application_number', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('ca.created_at', 'desc')
                             ->paginate(20);

        // Get statistics
        $statistics = $this->getStatistics();

        return view('admin.credit.index', [
            'title' => 'Kredi Başvuruları',
            'applications' => $applications,
            'statistics' => $statistics,
            'filters' => $request->all()
        ]);
    }

    /**
     * Display the specified credit application.
     */
    public function show($id)
    {
        $application = DB::table('credit_applications as ca')
            ->leftJoin('users as u', 'ca.user_id', '=', 'u.id')
            ->select([
                'ca.*',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'u.created_at as user_registration_date'
            ])
            ->where('ca.id', $id)
            ->first();

        if (!$application) {
            return redirect()->route('admin.credit-applications')
                           ->with('error', 'Kredi başvurusu bulunamadı.');
        }

        return view('admin.credit.show', [
            'title' => 'Kredi Başvurusu Detayı',
            'application' => $application
        ]);
    }

    /**
     * Update the specified credit application.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::table('credit_applications')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'admin_notes' => $request->admin_notes,
                    'reviewed_by' => auth('admin')->id(),
                    'reviewed_at' => now(),
                    'updated_at' => now()
                ]);

            // Send notification to user if status changed to approved/rejected
            if (in_array($request->status, ['approved', 'rejected'])) {
                $this->sendStatusNotification($id, $request->status);
            }

            return response()->json([
                'success' => true,
                'message' => 'Başvuru durumu başarıyla güncellendi.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Güncelleme sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve credit application.
     */
    public function approve($id)
    {
        try {
            DB::table('credit_applications')
                ->where('id', $id)
                ->update([
                    'status' => 'approved',
                    'approved_by' => auth('admin')->id(),
                    'approved_at' => now(),
                    'updated_at' => now()
                ]);

            $this->sendStatusNotification($id, 'approved');

            return response()->json([
                'success' => true,
                'message' => 'Kredi başvurusu onaylandı.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Onaylama sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject credit application.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::table('credit_applications')
                ->where('id', $id)
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'rejected_by' => auth('admin')->id(),
                    'rejected_at' => now(),
                    'updated_at' => now()
                ]);

            $this->sendStatusNotification($id, 'rejected');

            return response()->json([
                'success' => true,
                'message' => 'Kredi başvurusu reddedildi.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reddetme sırasında bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export credit applications to Excel.
     */
    public function export(Request $request)
    {
        // This would typically use Laravel Excel or similar package
        // For now, return a simple CSV response
        
        $query = DB::table('credit_applications as ca')
            ->leftJoin('users as u', 'ca.user_id', '=', 'u.id')
            ->select([
                'ca.application_number',
                'u.name as user_name',
                'u.email as user_email',
                'ca.amount',
                'ca.term_months',
                'ca.status',
                'ca.created_at'
            ]);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('ca.status', $request->status);
        }

        $applications = $query->orderBy('ca.created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="kredi_basvurulari_' . date('Y_m_d') . '.csv"',
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for proper Turkish character display in Excel
            fputs($file, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($file, [
                'Başvuru No',
                'Kullanıcı Adı',
                'E-posta',
                'Tutar',
                'Vade (Ay)',
                'Durum',
                'Başvuru Tarihi'
            ]);

            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->application_number,
                    $app->user_name,
                    $app->user_email,
                    '$' . number_format($app->amount, 2),
                    $app->term_months,
                    $this->getStatusText($app->status),
                    Carbon::parse($app->created_at)->format('d.m.Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get credit applications statistics.
     */
    private function getStatistics()
    {
        return [
            'new_applications' => DB::table('credit_applications')
                ->where('status', 'pending')
                ->whereDate('created_at', today())
                ->count(),
            
            'under_review' => DB::table('credit_applications')
                ->where('status', 'under_review')
                ->count(),
                
            'approved' => DB::table('credit_applications')
                ->where('status', 'approved')
                ->count(),
                
            'rejected' => DB::table('credit_applications')
                ->where('status', 'rejected')
                ->count(),
                
            'total_amount_approved' => DB::table('credit_applications')
                ->where('status', 'approved')
                ->sum('amount'),
                
            'average_amount' => DB::table('credit_applications')
                ->avg('amount'),
        ];
    }

    /**
     * Send status notification to user.
     */
    private function sendStatusNotification($applicationId, $status)
    {
        // Get application and user details
        $application = DB::table('credit_applications as ca')
            ->leftJoin('users as u', 'ca.user_id', '=', 'u.id')
            ->select(['ca.*', 'u.name', 'u.email'])
            ->where('ca.id', $applicationId)
            ->first();

        if ($application && $application->email) {
            try {
                // Here you would send an email notification
                // For now, just log the notification
                \Log::info("Credit application {$status} notification sent", [
                    'application_id' => $applicationId,
                    'user_email' => $application->email,
                    'status' => $status
                ]);
                
            } catch (\Exception $e) {
                \Log::error("Failed to send credit application notification", [
                    'application_id' => $applicationId,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Get status text in Turkish.
     */
    private function getStatusText($status)
    {
        $statusTexts = [
            'pending' => 'Beklemede',
            'under_review' => 'İnceleme Aşamasında',
            'approved' => 'Onaylandı',
            'rejected' => 'Reddedildi'
        ];

        return $statusTexts[$status] ?? $status;
    }
}