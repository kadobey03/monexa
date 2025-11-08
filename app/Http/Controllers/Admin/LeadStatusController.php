<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadStatusController extends Controller
{
    /**
     * Constructor - Only Super Admin can access this controller
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth('admin')->check() && auth('admin')->user()->type !== 'Super Admin') {
                abort(403, 'Bu sayfaya erişim yetkiniz bulunmamaktadır.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of lead statuses.
     */
    public function index()
    {
        $statuses = LeadStatus::ordered()->get();
        
        // Add user counts for each status
        foreach ($statuses as $status) {
            $status->user_count = $status->getUserCount();
        }
        
        return view('admin.leads.statuses.index', [
            'title' => 'Lead Status Yönetimi',
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created lead status.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:lead_statuses,name|regex:/^[a-z_]+$/',
            'display_name' => 'required|string|max:255',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'required|integer|min:0'
        ], [
            'name.regex' => 'Status adı sadece küçük harf ve alt çizgi içerebilir.',
            'color.regex' => 'Renk geçerli bir hex kodu olmalıdır (örn: #ff0000).',
        ]);

        // Check if sort_order already exists and adjust
        $existingStatus = LeadStatus::where('sort_order', $request->sort_order)->first();
        if ($existingStatus) {
            // Shift other statuses up
            LeadStatus::where('sort_order', '>=', $request->sort_order)
                     ->increment('sort_order');
        }

        LeadStatus::create($request->all());

        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', 'Yeni lead status başarıyla oluşturuldu.');
    }

    /**
     * Update the specified lead status.
     */
    public function update(Request $request, LeadStatus $leadStatus)
    {
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                'regex:/^[a-z_]+$/',
                Rule::unique('lead_statuses')->ignore($leadStatus->id)
            ],
            'display_name' => 'required|string|max:255',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'name.regex' => 'Status adı sadece küçük harf ve alt çizgi içerebilir.',
            'color.regex' => 'Renk geçerli bir hex kodu olmalıdır (örn: #ff0000).',
        ]);

        // Handle sort order changes
        if ($leadStatus->sort_order != $request->sort_order) {
            $oldOrder = $leadStatus->sort_order;
            $newOrder = $request->sort_order;
            
            if ($newOrder > $oldOrder) {
                // Moving down: decrease sort_order of items between old and new position
                LeadStatus::where('sort_order', '>', $oldOrder)
                         ->where('sort_order', '<=', $newOrder)
                         ->where('id', '!=', $leadStatus->id)
                         ->decrement('sort_order');
            } else {
                // Moving up: increase sort_order of items between new and old position
                LeadStatus::where('sort_order', '>=', $newOrder)
                         ->where('sort_order', '<', $oldOrder)
                         ->where('id', '!=', $leadStatus->id)
                         ->increment('sort_order');
            }
        }

        $leadStatus->update($request->all());

        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', 'Lead status başarıyla güncellendi.');
    }

    /**
     * Remove the specified lead status.
     */
    public function destroy(LeadStatus $leadStatus)
    {
        // Check if status is being used by any users
        if ($leadStatus->users()->count() > 0) {
            return redirect()->route('admin.lead-statuses.index')
                           ->with('error', 'Bu status kullanan kullanıcılar bulunduğu için silinemez.');
        }

        // Prevent deletion of default statuses
        if (in_array($leadStatus->name, ['new', 'converted', 'lost'])) {
            return redirect()->route('admin.lead-statuses.index')
                           ->with('error', 'Sistem varsayılan statusleri silinemez.');
        }

        $sortOrder = $leadStatus->sort_order;
        $leadStatus->delete();

        // Adjust sort orders of remaining statuses
        LeadStatus::where('sort_order', '>', $sortOrder)
                 ->decrement('sort_order');

        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', 'Lead status başarıyla silindi.');
    }

    /**
     * Toggle active status of a lead status.
     */
    public function toggleStatus(LeadStatus $leadStatus)
    {
        // Prevent deactivating critical statuses
        if (in_array($leadStatus->name, ['new', 'converted', 'lost']) && $leadStatus->is_active) {
            return redirect()->route('admin.lead-statuses.index')
                           ->with('error', 'Sistem kritik statusleri deaktif edilemez.');
        }

        $leadStatus->update(['is_active' => !$leadStatus->is_active]);

        $status = $leadStatus->is_active ? 'aktif' : 'pasif';
        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', "Lead status başarıyla {$status} hale getirildi.");
    }

    /**
     * Get all active statuses for API/AJAX requests.
     */
    public function getActiveStatuses()
    {
        $statuses = LeadStatus::active()->get();
        return response()->json($statuses);
    }

    /**
     * Move status up in order.
     */
    public function moveUp(LeadStatus $leadStatus)
    {
        $previousStatus = LeadStatus::where('sort_order', '<', $leadStatus->sort_order)
                                  ->orderBy('sort_order', 'desc')
                                  ->first();

        if ($previousStatus) {
            $tempOrder = $leadStatus->sort_order;
            $leadStatus->sort_order = $previousStatus->sort_order;
            $previousStatus->sort_order = $tempOrder;
            
            $leadStatus->save();
            $previousStatus->save();
        }

        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', 'Sıralama güncellendi.');
    }

    /**
     * Move status down in order.
     */
    public function moveDown(LeadStatus $leadStatus)
    {
        $nextStatus = LeadStatus::where('sort_order', '>', $leadStatus->sort_order)
                               ->orderBy('sort_order', 'asc')
                               ->first();

        if ($nextStatus) {
            $tempOrder = $leadStatus->sort_order;
            $leadStatus->sort_order = $nextStatus->sort_order;
            $nextStatus->sort_order = $tempOrder;
            
            $leadStatus->save();
            $nextStatus->save();
        }

        return redirect()->route('admin.lead-statuses.index')
                        ->with('success', 'Sıralama güncellendi.');
    }
}