<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;
use Carbon\Carbon;

class LeadsController extends Controller
{
    /**
     * Display leads dashboard
     */
    public function index(Request $request)
    {
        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';
        
        // Base query for leads (users who are not customers yet)
        $query = User::with(['leadStatus', 'assignedAdmin'])
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Admin level filtering
        if (!$isSuperAdmin) {
            // Regular admin can only see leads assigned to them or their subordinates
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            
            $query->whereIn('assign_to', $allowedAdminIds);
        }

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('lead_status_id', $request->status);
        }

        if ($request->has('assigned') && $request->assigned !== '') {
            if ($request->assigned === 'unassigned') {
                $query->whereNull('assign_to');
            } else {
                $query->where('assign_to', $request->assigned);
            }
        }

        if ($request->has('source') && $request->source !== '') {
            $query->where('lead_source', $request->source);
        }

        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        if ($sortBy === 'lead_score') {
            $query->orderBy('lead_score', $sortDirection);
        } elseif ($sortBy === 'last_contact') {
            $query->orderBy('last_contact_date', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $leads = $query->paginate(25)->withQueryString();

        // Get statistics
        $stats = $this->getLeadsStatistics($isSuperAdmin, $adminUser);

        // Get filter options
        $leadStatuses = LeadStatus::active()->get();
        $admins = $isSuperAdmin ? Admin::orderBy('firstName')->get() : 
                 Admin::where('id', $adminUser->id)
                      ->orWhere('parent_id', $adminUser->id)
                      ->orderBy('firstName')->get();

        return view('admin.leads.index', [
            'title' => 'Lead Yönetimi',
            'leads' => $leads,
            'stats' => $stats,
            'leadStatuses' => $leadStatuses,
            'admins' => $admins,
            'currentFilters' => $request->all(),
            'isSuperAdmin' => $isSuperAdmin
        ]);
    }

    /**
     * Show lead details
     */
    public function show($id)
    {
        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';
        
        $query = User::with(['leadStatus', 'assignedAdmin'])
                    ->where('id', $id)
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Admin level access control
        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            
            $query->where(function($q) use ($allowedAdminIds) {
                $q->whereIn('assign_to', $allowedAdminIds)
                  ->orWhereNull('assign_to'); // Allow viewing unassigned leads
            });
        }

        $lead = $query->firstOrFail();

        $leadStatuses = LeadStatus::active()->get();
        $admins = $isSuperAdmin ? Admin::orderBy('firstName')->get() : 
                 Admin::where('id', $adminUser->id)
                      ->orWhere('parent_id', $adminUser->id)
                      ->orderBy('firstName')->get();

        return view('admin.leads.show', [
            'title' => 'Lead Detayları - ' . $lead->name,
            'lead' => $lead,
            'leadStatuses' => $leadStatuses,
            'admins' => $admins,
            'isSuperAdmin' => $isSuperAdmin
        ]);
    }

    /**
     * Update lead information
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lead_status_id' => 'nullable|exists:lead_statuses,id',
            'assign_to' => 'nullable|exists:admins,id',
            'lead_notes' => 'nullable|string',
            'next_follow_up_date' => 'nullable|date|after:today',
            'estimated_value' => 'nullable|numeric|min:0',
            'preferred_contact_method' => 'nullable|in:phone,email,whatsapp,sms',
            'lead_tags' => 'nullable|array',
            'lead_tags.*' => 'string|max:50'
        ]);

        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';

        $query = User::where('id', $id)
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Admin level access control
        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            
            $query->where(function($q) use ($allowedAdminIds) {
                $q->whereIn('assign_to', $allowedAdminIds)
                  ->orWhereNull('assign_to');
            });
        }

        $lead = $query->firstOrFail();

        // Track changes for contact history
        $changes = [];
        $updateData = $request->only([
            'lead_status_id', 'assign_to', 'lead_notes', 'next_follow_up_date',
            'estimated_value', 'preferred_contact_method', 'lead_tags'
        ]);

        if ($request->lead_status_id && $lead->lead_status_id != $request->lead_status_id) {
            $oldStatus = $lead->leadStatus ? $lead->leadStatus->display_name : 'Belirlenmemiş';
            $newStatus = LeadStatus::find($request->lead_status_id)->display_name;
            $changes[] = "Status değiştirildi: {$oldStatus} → {$newStatus}";
        }

        if ($request->assign_to && $lead->assign_to != $request->assign_to) {
            $oldAdmin = $lead->assignedAdmin ? $lead->assignedAdmin->firstName . ' ' . $lead->assignedAdmin->lastName : 'Atanmamış';
            $newAdmin = Admin::find($request->assign_to);
            $newAdminName = $newAdmin->firstName . ' ' . $newAdmin->lastName;
            $changes[] = "Atama değiştirildi: {$oldAdmin} → {$newAdminName}";
        }

        $lead->update($updateData);

        // Add contact history if there are changes
        if (!empty($changes)) {
            $lead->addContactHistory(
                'update',
                'Lead bilgileri güncellendi: ' . implode(', ', $changes),
                $adminUser->id
            );
        }

        // Recalculate lead score
        $lead->calculateLeadScore();

        return redirect()->back()->with('success', 'Lead bilgileri başarıyla güncellendi.');
    }

    /**
     * Add contact note
     */
    public function addContact(Request $request, $id)
    {
        $request->validate([
            'contact_type' => 'required|in:call,email,meeting,note,sms,whatsapp',
            'contact_note' => 'required|string|max:1000',
            'next_follow_up_date' => 'nullable|date|after:today'
        ]);

        $adminUser = Auth::guard('admin')->user();
        $lead = User::findOrFail($id);

        $lead->addContactHistory(
            $request->contact_type,
            $request->contact_note,
            $adminUser->id
        );

        if ($request->next_follow_up_date) {
            $lead->next_follow_up_date = $request->next_follow_up_date;
            $lead->save();
        }

        return redirect()->back()->with('success', 'İletişim kaydı başarıyla eklendi.');
    }

    /**
     * Bulk assign leads
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array|min:1',
            'lead_ids.*' => 'exists:users,id',
            'admin_id' => 'required|exists:admins,id'
        ]);

        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';

        // Check if admin has permission to assign to the selected admin
        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            
            if (!in_array($request->admin_id, $allowedAdminIds)) {
                return redirect()->back()->with('error', 'Bu admin\'e atama yapma yetkiniz yok.');
            }
        }

        $assignedAdmin = Admin::find($request->admin_id);
        $assignedCount = 0;

        foreach ($request->lead_ids as $leadId) {
            $lead = User::where('id', $leadId)
                       ->where(function($q) {
                           $q->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                       })
                       ->first();

            if ($lead) {
                $lead->update(['assign_to' => $request->admin_id]);
                $lead->addContactHistory(
                    'assignment',
                    "Lead {$assignedAdmin->firstName} {$assignedAdmin->lastName} tarafından atandı",
                    $adminUser->id
                );
                $assignedCount++;
            }
        }

        return redirect()->back()->with('success', "{$assignedCount} lead başarıyla {$assignedAdmin->firstName} {$assignedAdmin->lastName} adlı admin'e atandı.");
    }

    /**
     * Export leads
     */
    public function export(Request $request)
    {
        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';

        if (!$isSuperAdmin) {
            return redirect()->back()->with('error', 'Export işlemi için süper admin yetkisi gereklidir.');
        }

        return Excel::download(new LeadsExport($request->all()), 'leads-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Get leads statistics
     */
    private function getLeadsStatistics($isSuperAdmin, $adminUser)
    {
        $baseQuery = User::where(function($q) {
            $q->whereNull('cstatus')
              ->orWhere('cstatus', '!=', 'Customer');
        });

        if (!$isSuperAdmin) {
            $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
            $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
            $baseQuery->whereIn('assign_to', $allowedAdminIds);
        }

        return [
            'total_leads' => (clone $baseQuery)->count(),
            'unassigned_leads' => (clone $baseQuery)->whereNull('assign_to')->count(),
            'new_leads_today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
            'new_leads_this_week' => (clone $baseQuery)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'high_score_leads' => (clone $baseQuery)->where('lead_score', '>=', 80)->count(),
            'follow_ups_today' => (clone $baseQuery)->whereDate('next_follow_up_date', today())->count(),
            'overdue_follow_ups' => (clone $baseQuery)->where('next_follow_up_date', '<', now())->count(),
            'status_breakdown' => LeadStatus::with(['users' => function($query) use ($baseQuery, $isSuperAdmin, $adminUser) {
                if (!$isSuperAdmin) {
                    $subordinateIds = Admin::where('parent_id', $adminUser->id)->pluck('id')->toArray();
                    $allowedAdminIds = array_merge([$adminUser->id], $subordinateIds);
                    $query->whereIn('assign_to', $allowedAdminIds);
                }
                $query->where(function($q) {
                    $q->whereNull('cstatus')
                      ->orWhere('cstatus', '!=', 'Customer');
                });
            }])->get()->map(function($status) {
                return [
                    'name' => $status->display_name,
                    'count' => $status->users->count(),
                    'color' => $status->color
                ];
            })
        ];
    }

    /**
     * Get leads assigned to current admin
     */
    public function myLeads(Request $request)
    {
        $adminUser = Auth::guard('admin')->user();
        
        $query = User::with(['leadStatus', 'assignedAdmin'])
                    ->where('assign_to', $adminUser->id)
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Apply same filters as index
        if ($request->has('status') && $request->status !== '') {
            $query->where('lead_status_id', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $leads = $query->paginate(25)->withQueryString();

        $leadStatuses = LeadStatus::active()->get();

        return view('admin.leads.my-leads', [
            'title' => 'Benim Leadlerim',
            'leads' => $leads,
            'leadStatuses' => $leadStatuses,
            'currentFilters' => $request->all()
        ]);
    }
}