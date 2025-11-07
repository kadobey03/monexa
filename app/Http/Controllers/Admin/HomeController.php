<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Signal;
use App\Models\SettingsCont;
use App\Models\Agent;
use App\Models\Loan;
use App\Models\User_plans;
use App\Models\User_signal;
use App\Models\Investment;
use App\Models\Mt4Details;
use App\Models\Admin;
use App\Models\Faq;
use App\Models\Images;
use App\Models\Testimony;
use App\Models\Content;
use App\Models\Asset;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\Cp_transaction;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Kyc;
use App\Models\OrdersP2p;
use App\Models\Task;
use App\Models\Wallets;
use Illuminate\Support\Facades\Cache;
use App\Services\UserExportService;
use App\Services\LeadAuthorizationService;
use App\Models\AdminAuditLog;

class HomeController extends Controller
{
    /**
     * Show Admin Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get current admin and authorization service
        $currentAdmin = auth('admin')->user();
        $leadAuthService = app(LeadAuthorizationService::class);
        
        // Get authorized users query based on current admin's level
        $authorizedUsersQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
        
        // ROLE-BASED STATISTICS: Only show data for authorized users
        if ($currentAdmin->hasBypassPrivileges()) {
            // Super admin and head of office see all statistics
            $userIds = User::pluck('id')->toArray();
        } else {
            // Other admins see only their authorized users' statistics
            $userIds = $authorizedUsersQuery->pluck('id')->toArray();
        }
        
        // Calculate role-based financial statistics
        if (empty($userIds)) {
            // No authorized users - show zero statistics
            $total_deposited = collect([['count' => 0]]);
            $pending_deposited = collect([['count' => 0]]);
            $total_withdrawn = collect([['count' => 0]]);
            $pending_withdrawn = collect([['count' => 0]]);
            $chart_pdepsoit = 0;
            $chart_pendepsoit = 0;
            $chart_pwithdraw = 0;
            $chart_pendwithdraw = 0;
        } else {
            // Calculate statistics for authorized users only
            $total_deposited = DB::table('deposits')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('status', 'Processed')
                ->whereIn('user', $userIds)
                ->get();
                
            $pending_deposited = DB::table('deposits')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('status', 'Pending')
                ->whereIn('user', $userIds)
                ->get();
                
            $total_withdrawn = DB::table('withdrawals')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('status', 'Processed')
                ->whereIn('user', $userIds)
                ->get();
                
            $pending_withdrawn = DB::table('withdrawals')
                ->select(DB::raw("SUM(amount) as count"))
                ->where('status', 'Pending')
                ->whereIn('user', $userIds)
                ->get();

            $chart_pdepsoit = DB::table('deposits')
                ->where('status', 'Processed')
                ->whereIn('user', $userIds)
                ->sum('amount');
                
            $chart_pendepsoit = DB::table('deposits')
                ->where('status', 'Pending')
                ->whereIn('user', $userIds)
                ->sum('amount');
                
            $chart_pwithdraw = DB::table('withdrawals')
                ->where('status', 'Processed')
                ->whereIn('user', $userIds)
                ->sum('amount');
                
            $chart_pendwithdraw = DB::table('withdrawals')
                ->where('status', 'Pending')
                ->whereIn('user', $userIds)
                ->sum('amount');
        }

        // ROLE-BASED USER STATISTICS: Use authorized query
        $userlist = $authorizedUsersQuery->count();
        $activeusers = (clone $authorizedUsersQuery)->where('status', 'active')->count();
        $blockeusers = (clone $authorizedUsersQuery)->where('status', 'blocked')->count();
        $unverifiedusers = (clone $authorizedUsersQuery)->where('account_verify', '!=', 'yes')->count();

        // Plans count remains global (not user-specific)
        $plans = Plans::count();
        
        // Tp_Transaction calculation - role-based if possible
        if ($currentAdmin->hasBypassPrivileges()) {
            $chart_trans = Tp_Transaction::sum('amount');
        } else {
            // For non-bypass users, calculate based on their users if tp_transactions has user field
            $chart_trans = empty($userIds) ? 0 :
                (Schema::hasColumn('tp_transactions', 'user') ?
                    Tp_Transaction::whereIn('user', $userIds)->sum('amount') :
                    0);
        }
        
        // Debug logging for dashboard statistics
        \Log::info('Dashboard Statistics - Role-based filtering applied', [
            'admin_id' => $currentAdmin->id,
            'admin_name' => $currentAdmin->getDisplayName(),
            'has_bypass' => $currentAdmin->hasBypassPrivileges(),
            'authorized_users_count' => count($userIds),
            'stats' => [
                'userlist' => $userlist,
                'activeusers' => $activeusers,
                'blockeusers' => $blockeusers,
                'unverifiedusers' => $unverifiedusers,
                'total_deposited' => $total_deposited[0]->count ?? 0,
                'total_withdrawn' => $total_withdrawn[0]->count ?? 0,
            ]
        ]);

        return view('admin.dashboard-modern', [
            'title' => 'Admin Dashboard',
            'settings' => Settings::find(1),
            'total_deposited' => $total_deposited,
            'pending_deposited' => $pending_deposited,
            'total_withdrawn' => $total_withdrawn,
            'pending_withdrawn' => $pending_withdrawn,
            'user_count' => $userlist,
            'plans' => $plans,
            'chart_pdepsoit' => $chart_pdepsoit,
            'chart_pendepsoit' => $chart_pendepsoit,
            'chart_pwithdraw' => $chart_pwithdraw,
            'chart_pendwithdraw' => $chart_pendwithdraw,
            'chart_trans' => $chart_trans,
            'activeusers' => $activeusers,
            'blockeusers' => $blockeusers,
            'unverifiedusers' => $unverifiedusers,
        ]);
    }

    /**
     * Get dashboard data for AJAX requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardData(Request $request)
    {
        try {
            // Get current admin and authorization service for AJAX role-based filtering
            $currentAdmin = auth('admin')->user();
            $leadAuthService = app(LeadAuthorizationService::class);
            
            $range = $request->input('range', '30days');
            
            // Calculate date range
            $dateRanges = [
                '7days' => now()->subDays(7),
                '30days' => now()->subDays(30),
                '90days' => now()->subDays(90),
                '1year' => now()->subYear(),
            ];
            
            $startDate = $dateRanges[$range] ?? now()->subDays(30);
            
            // Get authorized users query based on current admin's level - ROLE-BASED AJAX
            $authorizedUsersQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
            
            // ROLE-BASED STATISTICS for AJAX
            if ($currentAdmin->hasBypassPrivileges()) {
                // Super admin and head of office see all statistics
                $userIds = User::pluck('id')->toArray();
                $userQuery = User::query();
                $leadsQuery = User::query()->where(function($q) {
                    $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                });
            } else {
                // Other admins see only their authorized users' statistics
                $userIds = $authorizedUsersQuery->pluck('id')->toArray();
                $userQuery = clone $authorizedUsersQuery;
                $leadsQuery = clone $authorizedUsersQuery;
                $leadsQuery->where(function($q) {
                    $q->whereNull('cstatus')->orWhere('cstatus', '!=', 'Customer');
                });
            }
            
            // Get role-based statistics
            $stats = [
                'users' => [
                    'value' => $userQuery->count(),
                    'change' => $this->calculatePercentageChange(
                        $userQuery->where('created_at', '>=', $startDate)->count(),
                        $userQuery->where('created_at', '>=', $startDate->copy()->subDays($startDate->diffInDays(now())))->count()
                    )
                ],
                'revenue' => [
                    'value' => empty($userIds) ? 0 : DB::table('deposits')->where('status', 'Processed')->whereIn('user', $userIds)->sum('amount'),
                    'change' => empty($userIds) ? 0 : $this->calculatePercentageChange(
                        DB::table('deposits')->where('status', 'Processed')->whereIn('user', $userIds)->where('created_at', '>=', $startDate)->sum('amount'),
                        DB::table('deposits')->where('status', 'Processed')->whereIn('user', $userIds)
                            ->whereBetween('created_at', [$startDate->copy()->subDays($startDate->diffInDays(now())), $startDate])
                            ->sum('amount')
                    )
                ],
                'leads' => [
                    'value' => $leadsQuery->count(),
                    'change' => $this->calculatePercentageChange(
                        $leadsQuery->where('created_at', '>=', $startDate)->count(),
                        $leadsQuery->whereBetween('created_at', [$startDate->copy()->subDays($startDate->diffInDays(now())), $startDate])->count()
                    )
                ]
            ];

            // Get role-based chart data
            $charts = [
                'revenue' => $this->getRevenueChartData($startDate, $userIds),
                'users' => $this->getUsersChartData($userIds),
                'activity' => $this->getActivityChartData($startDate, $userIds)
            ];

            // Get role-based recent activities
            $recentActivities = $this->getRecentActivities($userIds);

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'charts' => $charts,
                    'recentActivities' => $recentActivities,
                    'notifications' => []
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Dashboard data error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Dashboard verileri yüklenirken hata oluştu'
            ], 500);
        }
    }

    /**
     * Calculate percentage change between two values
     */
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 2);
    }

    /**
     * Get revenue chart data (role-based)
     */
    private function getRevenueChartData($startDate, $userIds = null)
    {
        $query = DB::table('deposits')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->where('status', 'Processed')
            ->where('created_at', '>=', $startDate);
            
        // Apply role-based filtering
        if ($userIds !== null && !empty($userIds)) {
            $query->whereIn('user', $userIds);
        } elseif ($userIds !== null && empty($userIds)) {
            // No authorized users - return empty data
            return [
                'labels' => [],
                'values' => []
            ];
        }
        
        $deposits = $query->groupBy('date')->orderBy('date')->get();

        return [
            'labels' => $deposits->pluck('date')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('d.m');
            })->toArray(),
            'values' => $deposits->pluck('total')->toArray()
        ];
    }

    /**
     * Get users chart data (pie chart) (role-based)
     */
    private function getUsersChartData($userIds = null)
    {
        if ($userIds !== null && empty($userIds)) {
            // No authorized users - return empty data
            return [
                'labels' => ['Aktif', 'Engellenmiş', 'Doğrulanmamış', 'Müşteri'],
                'values' => [0, 0, 0, 0]
            ];
        }
        
        $baseQuery = $userIds !== null ? User::whereIn('id', $userIds) : User::query();
        
        return [
            'labels' => ['Aktif', 'Engellenmiş', 'Doğrulanmamış', 'Müşteri'],
            'values' => [
                (clone $baseQuery)->where('status', 'active')->count(),
                (clone $baseQuery)->where('status', 'blocked')->count(),
                (clone $baseQuery)->where('account_verify', '!=', 'yes')->count(),
                (clone $baseQuery)->where('cstatus', 'Customer')->count()
            ]
        ];
    }

    /**
     * Get activity chart data (role-based)
     */
    private function getActivityChartData($startDate, $userIds = null)
    {
        if ($userIds !== null && empty($userIds)) {
            // No authorized users - return empty data
            $dates = collect();
            for ($date = $startDate->copy(); $date <= now(); $date->addDay()) {
                $dates->push([
                    'date' => $date->format('d.m'),
                    'count' => 0
                ]);
            }
            
            return [
                'labels' => $dates->pluck('date')->toArray(),
                'values' => $dates->pluck('count')->toArray()
            ];
        }
        
        $activities = collect();
        
        // Combine different activities with role-based filtering
        $userQuery = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate);
            
        $depositQuery = DB::table('deposits')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate);
            
        // Apply role-based filtering if needed
        if ($userIds !== null) {
            $userQuery->whereIn('id', $userIds);
            $depositQuery->whereIn('user', $userIds);
        }
        
        $userRegistrations = $userQuery->groupBy('date')->orderBy('date')->get();
        $deposits = $depositQuery->groupBy('date')->orderBy('date')->get();

        // Merge and process data
        $dates = collect();
        for ($date = $startDate->copy(); $date <= now(); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $userCount = $userRegistrations->where('date', $dateStr)->first()->count ?? 0;
            $depositCount = $deposits->where('date', $dateStr)->first()->count ?? 0;
            
            $dates->push([
                'date' => $date->format('d.m'),
                'count' => $userCount + $depositCount
            ]);
        }

        return [
            'labels' => $dates->pluck('date')->toArray(),
            'values' => $dates->pluck('count')->toArray()
        ];
    }

    /**
     * Get recent activities (role-based)
     */
    private function getRecentActivities($userIds = null)
    {
        if ($userIds !== null && empty($userIds)) {
            // No authorized users - return empty activities
            return [];
        }
        
        $activities = collect();

        // Recent user registrations with role-based filtering
        $userQuery = User::latest()->take(5);
        if ($userIds !== null) {
            $userQuery->whereIn('id', $userIds);
        }
        
        $recentUsers = $userQuery->get()->map(function($user) {
            return [
                'message' => $user->name . ' sisteme kayıt oldu',
                'created_at' => $user->created_at->toISOString(),
                'importance' => 'normal'
            ];
        });

        // Recent deposits with role-based filtering
        $depositQuery = Deposit::with('duser')->latest()->take(5);
        if ($userIds !== null) {
            $depositQuery->whereIn('user', $userIds);
        }
        
        $recentDeposits = $depositQuery->get()->map(function($deposit) {
            return [
                'message' => ($deposit->duser->name ?? 'Kullanıcı') . ' ' . number_format($deposit->amount, 2) . ' TL yatırdı',
                'created_at' => $deposit->created_at->toISOString(),
                'importance' => 'high'
            ];
        });

        return $activities->merge($recentUsers)->merge($recentDeposits)
            ->sortByDesc('created_at')
            ->take(10)
            ->values()
            ->toArray();
    }
    //Plans route
    public function plans()
    {
        return view('admin.Plans.plans')
            ->with(array(
                'title' => 'System Plans',
                'plans' => Plans::where('type', 'Main')->orderby('created_at', 'ASC')->get(),
                'pplans' => Plans::where('type', 'Promo')->get(),

            ));
    }

    public function newplan()
    {
        return view('admin.Plans.newplan')
            ->with(array(
                'title' => 'Add Investment Plan',

            ));
    }

    public function editplan($id)
    {
        return view('admin.Plans.editplan')
            ->with(array(
                'title' => 'Edit Investment Plan',
                'plan' => Plans::where('id', $id)->first(),

            ));
    }




    //signal routes

    public function signals()
    {
        return view('admin.Signals.signals')
            ->with(array(
                'title' => 'System Signals',
                'signals' => Signal::where('type', 'Main')->orderby('created_at', 'ASC')->get(),
                'ssignals' => Signal::where('type', 'Promo')->get(),

            ));
    }

    public function newsignal()
    {
        return view('admin.Signals.newsignal')
            ->with(array(
                'title' => 'Add Trading Signals',

            ));
    }

    public function editsignal($id)
    {
        return view('admin.Signals.editsignal')
            ->with(array(
                'title' => 'Edit Trading Signals',
                'signal' => Signal::where('id', $id)->first(),

            ));

    }

    public function activesignals()
    {
        return view('admin.Signals.activesingnals', [
            'title' => 'Active Trading Signals',
            'signals' => User_signal::orderByDesc('id')->with(['dsignal', 'suser'])->get(),
        ]);
    }

    //ennd signals
    //Return manage users route
    public function manageusers(Request $request)
    {
        try {
            // Input validation - FIX: status should validate against name field, not id
            $validated = $request->validate([
                'status' => 'nullable|string|exists:lead_statuses,name',
                'admin' => 'nullable|exists:admins,id',
                'date_from' => 'nullable|date|before_or_equal:today',
                'date_to' => 'nullable|date|after_or_equal:date_from|before_or_equal:today',
                'per_page' => 'nullable|in:25,50,75,100,all',
                'page' => 'nullable|integer|min:1'
            ]);

            // Session management for filter persistence
            $this->manageFilterSession($request, $validated);

            // Get authorized users query based on current admin's level
            $currentAdmin = auth('admin')->user();
            $leadAuthService = app(LeadAuthorizationService::class);
            $query = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
            
            // Eager load relationships
            $query->with(['leadStatus', 'assignedAdmin']);
            
            // Apply status filter - FIXED: Now correctly filters by lead_status field
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }
            
            // Apply admin assignment filter
            if ($request->filled('admin')) {
                $query->where('assign_to', $request->admin);
            }
            
            // Apply date from filter
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            // Apply date to filter
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Default ordering
            $query->orderBy('id', 'desc');

            // Handle pagination with session persistence
            $perPage = $validated['per_page'] ?? session('user_management_per_page', 25);
            
            if ($perPage === 'all') {
                $users = $query->get();
                $users->appends = collect($request->query())->toArray(); // For URL consistency
            } else {
                $users = $query->paginate($perPage)->appends($request->query());
            }

            // İstatistikler - filtrelenmiş veriye göre (FIXED: Authorization-based statistics)
            $filteredQuery = clone $query;
            $filtered_count = $filteredQuery->count(); // Filtrelenmiş kullanıcı sayısı
            
            // CRITICAL FIX: Use LeadAuthorizationService for all statistics
            $baseQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
            $user_count = $baseQuery->count(); // Yetkili kullanıcı sayısı
            $active_users = (clone $baseQuery)->where('status', 'active')->count();
            $blocked_users = (clone $baseQuery)->where('status', 'blocked')->count();
            $pending_verification = (clone $baseQuery)->where('account_verify', '!=', 'yes')->count();

            // Dropdown data
            $leadStatuses = \App\Models\LeadStatus::active()->get();
            
            // Get filtered admins based on current admin's authorization level
            $currentAdmin = auth('admin')->user();
            $leadAuthService = app(LeadAuthorizationService::class);
            $admins = $leadAuthService->getAvailableAdminsForAssignment($currentAdmin);
            
            // TEMPORARY DEBUG: Log admin collection to understand the issue
            \Log::info('HomeController manageusers() - Admin Collection Debug', [
                'current_admin_id' => $currentAdmin->id,
                'current_admin_name' => $currentAdmin->firstName . ' ' . $currentAdmin->lastName,
                'current_admin_type' => $currentAdmin->type,
                'admins_count' => $admins ? collect($admins)->count() : 0,
                'admins_data' => $admins ? collect($admins)->toArray() : 'null/empty',
                'is_super_admin' => $currentAdmin->isSuperAdmin(),
                'is_sales_representative' => $currentAdmin->isSalesRepresentative(),
                'has_bypass_privileges' => $currentAdmin->hasBypassPrivileges()
            ]);
            
            // FALLBACK: If admins collection is empty and current admin is sales rep, include self
            if ((!$admins || $admins->isEmpty()) && $currentAdmin->isSalesRepresentative()) {
                \Log::warning('HomeController - Fallback: Adding current sales admin to empty admins collection', [
                    'admin_id' => $currentAdmin->id,
                    'admin_name' => $currentAdmin->getDisplayName()
                ]);
                $admins = collect([$currentAdmin]);
            }

            // Current filter values for form persistence
            $currentFilters = [
                'status' => $request->get('status'),
                'admin' => $request->get('admin'),
                'date_from' => $request->get('date_from'),
                'date_to' => $request->get('date_to'),
                'per_page' => $perPage,
            ];

            return view('admin.users-management', [
                'title' => 'All users',
                'users' => $users,
                'user_count' => $user_count,
                'filtered_count' => $filtered_count,
                'active_users' => $active_users,
                'blocked_users' => $blocked_users,
                'pending_verification' => $pending_verification,
                'leadStatuses' => $leadStatuses,
                'admins' => $admins,
                'currentFilters' => $currentFilters,
                'hasFilters' => $request->hasAny(['status', 'admin', 'date_from', 'date_to']),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Geçersiz filtre parametreleri.');

        } catch (\Exception $e) {
            \Log::error('User management filter error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user' => auth('admin')->user()?->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Kullanıcı listesi yüklenirken bir hata oluştu.')
                ->withInput();
        }
    }

    /**
     * Manage filter session for user management
     */
    private function manageFilterSession(Request $request, array $validated): void
    {
        // Store filter preferences if any filters are applied
        $filters = array_filter([
            'status' => $validated['status'] ?? null,
            'admin' => $validated['admin'] ?? null,
            'date_from' => $validated['date_from'] ?? null,
            'date_to' => $validated['date_to'] ?? null,
        ]);
        
        if (!empty($filters)) {
            session(['user_management_filters' => $filters]);
        }
        
        // Store pagination preference
        if ($request->filled('per_page')) {
            session(['user_management_per_page' => $validated['per_page']]);
        }
    }

    /**
     * Clear all user management filters
     */
    public function clearUserFilters()
    {
        session()->forget(['user_management_filters', 'user_management_per_page']);
        
        return redirect()->route('manageusers')->with('success', 'Filtreler temizlendi.');
    }

    public function activeInvestments()
    {
        return view('admin.Plans.activeinv', [
            'title' => 'Active Trades plans',
            'plans' => User_plans::where('active', 'yes')->orderByDesc('id')->with(['dplan', 'duser'])->get(),
        ]);
    }

    public function activeLoans()
    {
        return view('admin.Plans.loans', [
            'title' => 'Active Loans',
            'plans' => Loan::where('active', 'Pending')->orderByDesc('id')->with([ 'luser'])->get(),
        ]);
    }
    public function Investments()
    {
        $plans = investment::where('active', 'yes')->orderByDesc('id')->with(['uplan', 'puser'])->get();

        return view('admin.Plans.investment', [
            'title' => 'Active investment plans',
            'plans' => investment::where('active', 'yes')->orderByDesc('id')->with(['uplan', 'puser'])->get(),
        ]);
    }

    //Return search subscription route
    public function searchsub(Request $request)
    {
        $searchItem = $request['searchItem'];
        if ($request['type'] == 'subscription') {
            $result = Mt4Details::whereRaw("MATCH(mt4_id,account_type,server) AGAINST('$searchItem')")->paginate(10);
        }
        return view('admin.msubtrade')
            ->with(array(
                'title' => 'Subscription search result',
                'subscriptions' => $result,

            ));
    }

    //Return search route for Withdrawals
    public function searchWt(Request $request)
    {
        $dp = Withdrawal::all();
        $searchItem = $request['wtquery'];

        $result = Withdrawal::where('user', $searchItem)
            ->orwhere('amount', $searchItem)
            ->orwhere('payment_mode', $searchItem)
            ->orwhere('status', $searchItem)
            ->paginate(10);

        return view('admin.mwithdrawals')
            ->with(array(
                'dp' => $dp,
                'title' => 'Withdrawals search result',
                'withdrawals' => $result,

            ));
    }


    //Return manage withdrawals route
    public function mwithdrawals()
    {
        // Get current admin and authorization service for role-based withdrawal filtering
        $currentAdmin = auth('admin')->user();
        $leadAuthService = app(\App\Services\LeadAuthorizationService::class);
        
        // Get authorized users query based on current admin's level
        $authorizedUsersQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
        
        // ROLE-BASED WITHDRAWAL FILTERING: Show only withdrawals from authorized users
        if ($currentAdmin->hasBypassPrivileges()) {
            // Super admin and head of office see all withdrawals
            $withdrawalsQuery = Withdrawal::with('duser');
        } else {
            // Other admins see only withdrawals from their authorized users
            $userIds = $authorizedUsersQuery->pluck('id')->toArray();
            $withdrawalsQuery = Withdrawal::with('duser')->whereIn('user', $userIds);
        }
        
        // Debug logging for withdrawal filtering
        \Log::info('Manage Withdrawals - Role-based filtering applied', [
            'admin_id' => $currentAdmin->id,
            'admin_name' => $currentAdmin->getDisplayName(),
            'has_bypass' => $currentAdmin->hasBypassPrivileges(),
            'authorized_users_count' => $currentAdmin->hasBypassPrivileges() ? 'all' : count($userIds ?? []),
            'withdrawals_query_applied' => !$currentAdmin->hasBypassPrivileges()
        ]);

        return view('admin.Withdrawals.mwithdrawals')
            ->with(array(
                'title' => 'Manage users withdrawals',
                'withdrawals' => $withdrawalsQuery->orderBy('id', 'desc')->get(),
            ));
    }

    //Return manage deposits route
    public function mdeposits()
    {
        // Get current admin and authorization service for role-based deposit filtering
        $currentAdmin = auth('admin')->user();
        $leadAuthService = app(\App\Services\LeadAuthorizationService::class);
        
        // Get authorized users query based on current admin's level
        $authorizedUsersQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
        
        // ROLE-BASED DEPOSIT FILTERING: Show only deposits from authorized users
        if ($currentAdmin->hasBypassPrivileges()) {
            // Super admin and head of office see all deposits
            $depositsQuery = Deposit::with('duser');
        } else {
            // Other admins see only deposits from their authorized users
            $userIds = $authorizedUsersQuery->pluck('id')->toArray();
            $depositsQuery = Deposit::with('duser')->whereIn('user', $userIds);
        }
        
        // Debug logging for deposit filtering
        \Log::info('Manage Deposits - Role-based filtering applied', [
            'admin_id' => $currentAdmin->id,
            'admin_name' => $currentAdmin->getDisplayName(),
            'has_bypass' => $currentAdmin->hasBypassPrivileges(),
            'authorized_users_count' => $currentAdmin->hasBypassPrivileges() ? 'all' : count($userIds ?? []),
            'deposits_query_applied' => !$currentAdmin->hasBypassPrivileges()
        ]);

        return view('admin.Deposits.mdeposits')
            ->with(array(
                'title' => 'Manage users deposits',
                'deposits' => $depositsQuery->orderBy('id', 'desc')->paginate(15),
            ));
    }

    //Return agents route
    public function agents()
    {
        return view('admin.agents')
            ->with(array(
                'title' => 'Manage agents',
                'users' => User::orderBy('id', 'desc')->get(),
                'agents' => Agent::all(),
            ));
    }

    public function aboutonlinetrade()
    {
        return view('admin.about')
            ->with(array(
                'title' => 'About Remedy Algo trade script',

            ));
    }

    public function emailServices()
    {
        return view('admin.email.index', [
            'title' =>  "Email services"
        ]);
    }

    //Return view agent route
    public function viewagent($agent)
    {
        return view('admin.viewagent')
            ->with(array(
                'title' => 'Agent record',
                'agent' => User::where('id', $agent)->first(),
                'ag_r' => User::where('ref_by', $agent)->get(),

            ));
    }

    //return settings form
    public function settings(Request $request)
    {
        include 'currencies.php';
        return view('admin.settings')->with(array(

            'wmethods' => Wdmethod::where('type', 'withdrawal')->get(),
            'assets' => Asset::all(),
            //'markets' => markets::all(),
            'cpd' => Cp_transaction::where('id', '=', '1')->first(),
            'currencies' => $currencies,
            'title' => 'System Settings'
        ));
        //return view('settings')->with(array('title' =>'System Settings'));
    }




 //connectwallet
 public function mwalletdelete($id)
 {
     Wallets::where('id', $id)->delete();
     return redirect()->back()->with('success', 'Wallet deleted Sucessful!');
 }

    //Return manage mwalletconnect route
    public function mwalletconnect()
    {
        return view('admin.wallet.mwalletconnect')
            ->with(array(
                'title' => 'Manage users wallet connect',

                'wallets' => Wallets::with('wuser')->orderBy('id', 'desc')->get(),

            ));
    }



    //Return manage mwalletsettings route
    public function mwalletsettings()
    {
        return view('admin.wallet.mwalletsettings')
            ->with(array(
                'title' => 'Manage users wallet connect settings',
                'settings' => Settings::where('id',1)->first(),

            ));
    }



      // connect wallet settings

      public function mwalletconnectsave(Request $request){

        $this->validate($request, [
            'min_balance' => 'required|max:255',
            'min_return' => 'required|max:255',
            'wallet_status' => 'required'

        ]);


	Settings::where('id', '1')
            ->update([
                'min_balance' => $request['min_balance'],
                'min_return' => $request['min_return'],
                'wallet_status' => $request['wallet_status'],
            ]);

        return redirect()->back()
          ->with('success', 'Updated added Sucessfull!y');
    }



    //end conect wallet

    public function msubtrade()
    {
        return view('admin.subscription.msubtrade')
            ->with(array(
                'subscriptions' => Mt4Details::with('tuser')->orderBy('id', 'desc')->paginate(10),
                'title' => 'Manage Subscription',

            ));
    }

    public function userplans($id)
    {
        return view('admin.Users.user_plans')
            ->with(array(
                'plans' => User_plans::where('user', $id)->orderBy('id', 'desc')->get(),
                'user' => User::where('id', $id)->first(),
                'title' => 'User Investment trades',

            ));
    }


    public function investmentplans($id)
    {
        return view('admin.Users.user_investments')
            ->with(array(
                'plans' => investment::where('user', $id)->orderBy('id', 'desc')->get(),
                'user' => User::where('id', $id)->first(),
                'title' => 'User Investment Plan(s)',

            ));
    }




    //return front end management page
    public function frontpage()
    {
        return view('admin.Settings.FrontendSettings.frontpage', [
            'title' => 'Front page management',
            'faqs' => Faq::orderByDesc('id')->get(),
            'images' => Images::orderBy('id', 'desc')->get(),
            'testimonies' => Testimony::orderBy('id', 'desc')->get(),
            'contents' => Content::orderBy('id', 'desc')->get(),
        ]);
    }


    public function adduser()
    {
        return view('admin.referuser')->with(array(
            'title' => 'Add new Users',
            'settings' => Settings::where('id', '=', '1')->first()
        ));
    }

    public function addmanager()
    {
        return view('admin.addadmin')->with(array(
            'title' => 'Add new manager',
            'settings' => Settings::where('id', '=', '1')->first()
        ));
    }
    public function madmin()
    {
        // Redirect to modern managers module
        return redirect()->route('admin.managers.index');
    }

    //Return KYC route
    public function kyc()
    {
        // Get current admin and authorization service for role-based KYC filtering
        $currentAdmin = auth('admin')->user();
        $leadAuthService = app(\App\Services\LeadAuthorizationService::class);
        
        // Get authorized users query based on current admin's level
        $authorizedUsersQuery = $leadAuthService->getAuthorizedLeadsQuery($currentAdmin);
        
        // ROLE-BASED KYC FILTERING: Show only KYC applications from authorized users
        if ($currentAdmin->hasBypassPrivileges()) {
            // Super admin and head of office see all KYC applications
            $kycsQuery = Kyc::with(['user']);
        } else {
            // Other admins see only KYC applications from their authorized users
            $userIds = $authorizedUsersQuery->pluck('id')->toArray();
            $kycsQuery = Kyc::with(['user'])->whereIn('user_id', $userIds);
        }
        
        // Debug logging for KYC filtering
        \Log::info('KYC Applications - Role-based filtering applied', [
            'admin_id' => $currentAdmin->id,
            'admin_name' => $currentAdmin->getDisplayName(),
            'has_bypass' => $currentAdmin->hasBypassPrivileges(),
            'authorized_users_count' => $currentAdmin->hasBypassPrivileges() ? 'all' : count($userIds ?? []),
            'kyc_query_applied' => !$currentAdmin->hasBypassPrivileges()
        ]);

        return view('admin.kyc', [
            'title' => 'KYC Applications',
            'settings' => Settings::find(1),
            'kycs' => $kycsQuery->orderByDesc('id')->get(),
        ]);
    }

    public function viewKycApplication($id)
    {

        return view('admin.kyc-applications', [
            'title' => 'View KYC Application',
            'kyc' => Kyc::where('id', $id)->with(['user'])->first(),
        ]);
    }

    public function adminprofile()
    {
        return view('admin.Profile.profile')
            ->with(array(
                'title' => 'Admin Profile',


            ));
    }

    public function managecryptoasset()
    {

        return view('admin.Settings.Crypto.pageview', [
            'title' => 'Manage Crypto Asset',
            'moresettings' => SettingsCont::find(1),
        ]);
    }


    public function p2pView()
    {
        return view('admin.p2p.show', [
            'title' => 'Manage P2P transactions',
        ]);
    }


    public function showtaskpage()
    {
        return view('admin.task')
            ->with(array(
                'admin' => Admin::orderby('id', 'desc')->get(),
                'title' => 'Create a New Task',

            ));
    }

    public function mtask()
    {
        return view('admin.mtask')
            ->with(array(
                'admin' => Admin::orderby('id', 'desc')->get(),
                'tasks' => Task::orderby('id', 'desc')->get(),
                'title' => 'Manage Task',

            ));
    }
    public function viewtask()
    {
        return view('admin.vtask')
            ->with(array(
                'tasks' => Task::orderby('id', 'desc')->where('designation', Auth('admin')->User()->id)->get(),
                'title' => 'View my Task',

            ));
    }

    public function leads()
    {
        return view('admin.leads')
            ->with(array(
                'admin' => Admin::orderBy('id', 'desc')->get(),
                'users' => User::select('*', 'company_name', 'organization')
                    ->orderby('id', 'desc')
                    ->where('cstatus', NULL)
                    ->get(),
                'title' => 'Manage New Registered Clients',
            ));
    }

    /**
     * Show detailed lead information page
     */
    public function showLead($id)
    {
        $adminUser = Auth::guard('admin')->user();
        $isSuperAdmin = $adminUser->type === 'Super Admin';

        $query = User::with([
            'leadStatus',
            'assignedAdmin',
            'leadNotes' => function($q) {
                $q->orderBy('is_pinned', 'desc')
                  ->orderBy('created_at', 'desc');
            },
            'leadCommunications' => function($q) {
                $q->orderBy('created_at', 'desc')
                  ->limit(50);
            },
            'leadScoreHistory' => function($q) {
                $q->orderBy('created_at', 'desc')
                  ->limit(30);
            }
        ])
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
                  ->orWhereNull('assign_to');
            });
        }

        $lead = $query->firstOrFail();

        // Calculate lead score and analytics
        $scoringService = app(LeadScoringService::class);
        $scoreData = $scoringService->calculateLeadScore($lead);

        // Get lead statuses for dropdown
        $leadStatuses = LeadStatus::active()->get();

        // Get admin users for assignment dropdown
        $admins = $isSuperAdmin ?
            Admin::where('status', 'Active')->orderBy('firstName')->get() :
            Admin::where(function($q) use ($adminUser) {
                $q->where('id', $adminUser->id)
                  ->orWhere('parent_id', $adminUser->id);
            })->where('status', 'Active')->orderBy('firstName')->get();

        // Prepare analytics data
        $analyticsData = $this->prepareAnalyticsData($lead, $scoreData);

        // Prepare chart data for trends
        $chartData = $this->prepareChartData($lead);

        // Prepare performance metrics
        $performanceMetrics = $this->preparePerformanceMetrics($lead);

        // Prepare note categories
        $noteCategories = [
            'important' => 'Önemli',
            'general' => 'Genel',
            'technical' => 'Teknik',
            'financial' => 'Finansal'
        ];

        // Prepare communication stats
        $communicationStats = $this->prepareCommunicationStats($lead);

        // Prepare available actions for sidebar
        $availableActions = $this->prepareAvailableActions($adminUser, $lead);

        // Prepare user permissions
        $userPermissions = $this->prepareUserPermissions($adminUser, $lead);

        // Prepare mobile data (simplified version for mobile view)
        $mobileData = $this->prepareMobileData($lead, $scoreData);

        return view('admin.leads.show', [
            'lead' => $lead,
            'leadStatuses' => $leadStatuses,
            'admins' => $admins,
            'scoreData' => $scoreData,
            'analyticsData' => $analyticsData,
            'chartData' => $chartData,
            'performanceMetrics' => $performanceMetrics,
            'noteCategories' => $noteCategories,
            'communicationStats' => $communicationStats,
            'availableActions' => $availableActions,
            'userPermissions' => $userPermissions,
            'mobileData' => $mobileData,
            'title' => 'Lead Detayı - ' . $lead->name
        ]);
    }

    private function prepareAnalyticsData(User $lead, array $scoreData): array
    {
        return [
            'demographic_score' => $scoreData['breakdown']['demographic_score'],
            'engagement_score' => $scoreData['breakdown']['engagement_score'],
            'contact_score' => $scoreData['breakdown']['contact_score'],
            'value_score' => $scoreData['breakdown']['value_score'],
            'days_active' => $lead->created_at->diffInDays(),
            'contact_count' => $lead->leadCommunications->count(),
            'score_trend' => $lead->leadScoreHistory->count() > 1 ? $this->calculateScoreTrend($lead) : 0,
        ];
    }

    private function prepareChartData(User $lead): array
    {
        // Score trend data for chart
        $scoreHistory = $lead->leadScoreHistory->take(30)->reverse();

        return [
            'score_trend' => [
                'labels' => $scoreHistory->pluck('created_at')->map(function($date) {
                    return $date->format('d.m');
                })->toArray(),
                'data' => $scoreHistory->pluck('new_score')->toArray()
            ],
            'communication_frequency' => $this->calculateCommunicationFrequency($lead),
            'engagement_heatmap' => $this->calculateEngagementHeatmap($lead)
        ];
    }

    private function preparePerformanceMetrics(User $lead): array
    {
        $communications = $lead->leadCommunications;
        $lastCommunication = $communications->first();

        return [
            'avg_response_time' => $this->calculateAverageResponseTime($communications),
            'call_success_rate' => $this->calculateCallSuccessRate($communications),
            'email_open_rate' => $this->calculateEmailOpenRate($communications),
            'engagement_trend' => $this->calculateEngagementTrend($lead)
        ];
    }

    private function prepareCommunicationStats(User $lead): array
    {
        $communications = $lead->leadCommunications;

        return [
            'total_communications' => $communications->count(),
            'last_communication_date' => $communications->first()?->created_at?->format('d.m.Y H:i'),
            'communication_types' => $communications->groupBy('communication_type')->map->count()->toArray()
        ];
    }

    private function prepareAvailableActions(Admin $admin, User $lead): array
    {
        // This would be expanded based on admin permissions and lead status
        return [
            'can_edit' => $admin->hasPermission('lead_edit'),
            'can_call' => $admin->hasPermission('lead_call'),
            'can_email' => $admin->hasPermission('lead_email'),
            'can_message' => $admin->hasPermission('lead_message'),
            'can_assign' => $admin->hasPermission('lead_assign'),
            'can_block' => $admin->hasPermission('lead_block'),
            'can_credit_debit' => $admin->hasPermission('lead_financial_manage'),
            'can_manual_transaction' => $admin->hasPermission('lead_manual_transaction'),
            'can_create_alert' => $admin->hasPermission('lead_alert_create'),
            'can_tax_calculation' => $admin->hasPermission('lead_tax_calculate'),
            'can_withdrawal_code' => $admin->hasPermission('lead_withdrawal_manage'),
            'can_set_limits' => $admin->hasPermission('lead_limit_manage'),
            'can_admin_switch' => $admin->hasPermission('lead_admin_switch'),
        ];
    }

    private function prepareUserPermissions(Admin $admin, User $lead): array
    {
        return [
            'can_view' => true, // Basic permission checked at route level
            'can_update' => $admin->hasPermission('lead_edit'),
            'can_delete' => $admin->hasPermission('lead_delete'),
            'can_assign' => $admin->hasPermission('lead_assign'),
            'can_call' => $admin->hasPermission('lead_call'),
            'can_email' => $admin->hasPermission('lead_email'),
            'can_message' => $admin->hasPermission('lead_message'),
            'can_add_notes' => $admin->hasPermission('lead_notes_create'),
            'can_manage_financial' => $admin->hasPermission('lead_financial_manage'),
            'can_admin_switch' => $admin->hasPermission('lead_admin_switch')
        ];
    }

    private function prepareMobileData(User $lead, array $scoreData): array
    {
        return [
            'quick_stats' => [
                'score' => $scoreData['total_score'],
                'contact_count' => $lead->leadCommunications->count(),
                'days_active' => $lead->created_at->diffInDays(),
                'engagement_level' => $scoreData['level']['label']
            ],
            'recent_notes' => $lead->leadNotes->take(5)->map(function($note) {
                return [
                    'id' => $note->id,
                    'title' => $note->note_title ?: 'Başlıksız Not',
                    'content' => Str::limit($note->note_content, 100),
                    'created_at' => $note->created_at->diffForHumans(),
                    'admin_name' => $note->admin->firstName . ' ' . $note->admin->lastName
                ];
            })->toArray(),
            'recent_communications' => $lead->leadCommunications->take(10)->map(function($comm) {
                return [
                    'id' => $comm->id,
                    'type' => $comm->communication_type,
                    'subject' => $comm->communication_subject,
                    'created_at' => $comm->created_at->diffForHumans(),
                    'admin_name' => $comm->admin?->firstName . ' ' . $comm->admin?->lastName
                ];
            })->toArray()
        ];
    }

    private function calculateScoreTrend(User $lead): int
    {
        $scores = $lead->leadScoreHistory->take(10)->pluck('new_score')->toArray();
        if (count($scores) < 2) return 0;

        $recent = array_slice($scores, -5); // Last 5 scores
        $older = array_slice($scores, 0, 5); // Previous 5 scores

        $recentAvg = array_sum($recent) / count($recent);
        $olderAvg = array_sum($older) / count($older);

        return intval(($recentAvg - $olderAvg) / $olderAvg * 100);
    }

    private function calculateCommunicationFrequency(User $lead): array
    {
        $communications = $lead->leadCommunications->where('created_at', '>=', now()->subDays(30));
        $weeklyData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = $communications->whereBetween('created_at', [
                $date->startOfDay(),
                $date->endOfDay()
            ])->count();
            $weeklyData[] = $count;
        }

        return [
            'labels' => ['6g', '5g', '4g', '3g', '2g', '1g', 'Bugün'],
            'data' => $weeklyData
        ];
    }

    private function calculateEngagementHeatmap(User $lead): array
    {
        // Simplified heatmap data
        $communications = $lead->leadCommunications->where('created_at', '>=', now()->subDays(30));

        $heatmap = [];
        for ($i = 0; $i < 7; $i++) {
            $day = now()->subDays($i);
            $count = $communications->whereDate('created_at', $day->toDateString())->count();
            $heatmap[] = [
                'day' => $day->format('D'),
                'count' => $count,
                'intensity' => min($count, 4) // Max intensity of 4
            ];
        }

        return array_reverse($heatmap); // Most recent first
    }

    private function calculateAverageResponseTime($communications): string
    {
        // Simplified calculation - would need more complex logic for real response time
        $avgHours = $communications->avg('created_at.diffInHours') ?? 24;
        return number_format($avgHours, 1) . 'h';
    }

    private function calculateCallSuccessRate($communications): int
    {
        $calls = $communications->where('communication_type', 'call');
        if ($calls->isEmpty()) return 0;

        $successful = $calls->where('status', 'completed')->count();
        return intval(($successful / $calls->count()) * 100);
    }

    private function calculateEmailOpenRate($communications): int
    {
        $emails = $communications->where('communication_type', 'email');
        if ($emails->isEmpty()) return 0;

        // This would need tracking data from email service
        return rand(30, 70); // Placeholder
    }

    private function calculateEngagementTrend(User $lead): int
    {
        $recent = $lead->leadCommunications->where('created_at', '>=', now()->subWeek())->count();
        $previous = $lead->leadCommunications->whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek()
        ])->count();

        if ($previous == 0) return $recent > 0 ? 100 : 0;

        return intval((($recent - $previous) / $previous) * 100);
    }
    public function leadsassign()
    {
        return view('admin.lead_asgn')
            ->with(array(
                'usersAssigned' => User::orderby('id', 'desc')->where([
                    ['assign_to', Auth('admin')->User()->id],
                    ['cstatus', NULL]
                ])->get(),

                'title' => 'Manage New Registered Clients',

            ));
    }


    public function customer()
    {
        return view('admin.customer')
            ->with(array(
                'users' => User::orderby('id', 'desc')->where('cstatus', 'Customer')->get(),
                'title' => 'Manage New Registered Clients',

            ));
    }

    /**
     * Handle CKEditor file upload
     */
    public function ckeditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Uploads klasörünü oluştur
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Dosyayı kaydet
            $file->move($uploadPath, $filename);
            
            $url = asset('uploads/' . $filename);
            
            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }
        
        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Upload failed'
            ]
        ]);
    }

    /**
     * Kullanıcının lead status'unu güncelle (AJAX)
     */
    public function updateLeadStatus(\Illuminate\Http\Request $request, $id)
    {
        try {
            // Validation
            $request->validate([
                'lead_status' => 'required|string|max:50'
            ]);

            // Kullanıcıyı bul
            $user = User::findOrFail($id);
            
            // Lead status'u güncelle
            $oldStatus = $user->lead_status;
            $user->lead_status = $request->lead_status;
            $user->save();
            
            // CRITICAL FIX: Refresh model and clear relationship cache
            $user->refresh();
            $user->unsetRelation('leadStatus');
            
            // Fresh load with relationship to ensure UI gets updated data
            $user = $user->fresh(['leadStatus']);

            // Log işlem
            \Log::info('Lead Status Updated', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'old_status' => $oldStatus,
                'new_status' => $request->lead_status,
                'updated_by' => auth('admin')->user()->id ?? null,
                'updated_by_name' => auth('admin')->user()->firstName ?? 'System'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead status başarıyla güncellendi.',
                'data' => [
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->lead_status,
                    'current_status_display' => $user->leadStatus?->display_name ?? $user->lead_status,
                    'leadStatus' => $user->leadStatus ? [
                        'name' => $user->leadStatus->name,
                        'display_name' => $user->leadStatus->display_name,
                        'color' => $user->leadStatus->color,
                    ] : null,
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri gönderildi.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı bulunamadı.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Lead Status Update Error', [
                'user_id' => $id,
                'lead_status' => $request->lead_status ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lead status güncellenirken bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Kullanıcının atanan admin'ini güncelle (AJAX)
     */
    public function updateAssignedAdmin(\Illuminate\Http\Request $request, $userId)
    {
        try {
            // Validation
            $request->validate([
                'admin_id' => 'required|exists:admins,id'
            ]);

            // Kullanıcıyı bul
            $user = User::findOrFail($userId);
            
            // Admin'i bul
            $admin = Admin::findOrFail($request->admin_id);
            
            // Eski admin ID'si
            $oldAdminId = $user->assign_to;
            
            // Yeni admin ataması
            $user->assign_to = $request->admin_id;
            $user->save();

            // Log işlem
            \Log::info('Admin Assignment Updated', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'old_admin_id' => $oldAdminId,
                'old_admin_name' => $oldAdminId ? Admin::find($oldAdminId)?->getDisplayName() : null,
                'new_admin_id' => $request->admin_id,
                'new_admin_name' => $admin->getDisplayName(),
                'updated_by' => auth('admin')->user()->id ?? null,
                'updated_by_name' => auth('admin')->user()->firstName ?? 'System'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin ataması başarıyla güncellendi!',
                'data' => [
                    'user_id' => $user->id,
                    'old_admin_id' => $oldAdminId,
                    'new_admin_id' => $request->admin_id,
                    'new_admin_name' => $admin->getDisplayName()
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz admin seçimi.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı veya admin bulunamadı.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Admin Assignment Update Error', [
                'user_id' => $userId,
                'admin_id' => $request->admin_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Admin ataması güncellenirken bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Export users to Excel
     */
    public function exportUsers(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);
        
        try {
            // Get current admin
            $admin = auth('admin')->user();
            
            // Validate export parameters (same as manageusers filters)
            $validated = $request->validate([
                'status' => 'nullable|string|exists:lead_statuses,name',
                'admin' => 'nullable|exists:admins,id',
                'date_from' => 'nullable|date|before_or_equal:today',
                'date_to' => 'nullable|date|after_or_equal:date_from|before_or_equal:today',
                'export_type' => 'nullable|string|in:selected,all',
                'selected_users' => 'nullable|array|max:1000',
                'selected_users.*' => 'integer|exists:users,id',
            ]);

            // Debug export request için log
            if ($request->input('export_type') === 'selected') {
                \Log::info('Export Selected Users Request', [
                    'export_type' => $request->input('export_type'),
                    'selected_users_count' => $request->has('selected_users') ? count($request->input('selected_users', [])) : 0,
                    'selected_users' => $request->input('selected_users', []),
                    'admin_id' => auth('admin')->id(),
                    'validation_data' => $validated
                ]);
            }

            // Initialize UserExportService
            $exportService = new UserExportService();
            
            // Check if this is a selected users export
            if ($request->input('export_type') === 'selected' && $request->has('selected_users')) {
                // Export only selected users
                $result = $exportService->exportSelectedUsers($admin, $validated['selected_users']);
            } else {
                // Export users with current filters
                $result = $exportService->exportUsers($admin, $validated);
            }
            
            if (!$result['success']) {
                // Log failed export
                AdminAuditLog::logAction([
                    'admin_id' => $admin->id,
                    'admin_name' => $admin->firstName . ' ' . $admin->lastName,
                    'admin_email' => $admin->email,
                    'action' => 'export',
                    'entity_type' => 'User',
                    'category' => AdminAuditLog::CATEGORIES['data_export'],
                    'description' => 'User export failed',
                    'status' => AdminAuditLog::STATUS_FAILED,
                    'severity' => AdminAuditLog::SEVERITY_WARNING,
                    'is_sensitive' => true,
                    'metadata' => [
                        'filters' => $validated,
                        'error' => $result['error']
                    ],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'session_id' => session()->getId(),
                ]);
                
                return back()->with('error', $result['error']);
            }
            
            // Calculate performance metrics
            $executionTime = intval((microtime(true) - $startTime) * 1000);
            $memoryUsage = intval((memory_get_usage(true) - $startMemory) / 1024 / 1024);
            
            // Log successful export
            AdminAuditLog::logAction([
                'admin_id' => $admin->id,
                'admin_name' => $admin->firstName . ' ' . $admin->lastName,
                'admin_email' => $admin->email,
                'action' => 'export',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['data_export'],
                'description' => 'User data exported successfully',
                'status' => AdminAuditLog::STATUS_SUCCESS,
                'severity' => AdminAuditLog::SEVERITY_INFO,
                'is_sensitive' => true,
                'affected_count' => $result['total_records'] ?? 0,
                'execution_time_ms' => $executionTime,
                'memory_usage_mb' => $memoryUsage,
                'performance_metrics' => [
                    'file_size_mb' => isset($result['file_path']) ? round(filesize($result['file_path']) / 1024 / 1024, 2) : 0,
                    'records_exported' => $result['total_records'] ?? 0,
                ],
                'metadata' => [
                    'filters' => $validated,
                    'filename' => basename($result['filename'] ?? ''),
                    'file_format' => 'xlsx'
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            // Return file download response
            return response()->download(
                $result['file_path'],
                basename($result['filename']),
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . basename($result['filename']) . '"'
                ]
            )->deleteFileAfterSend(true);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation error
            AdminAuditLog::logAction([
                'admin_id' => auth('admin')->id(),
                'admin_name' => auth('admin')->user()?->firstName . ' ' . auth('admin')->user()?->lastName,
                'admin_email' => auth('admin')->user()?->email,
                'action' => 'export',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['data_export'],
                'description' => 'User export failed - validation error',
                'status' => AdminAuditLog::STATUS_FAILED,
                'severity' => AdminAuditLog::SEVERITY_WARNING,
                'is_sensitive' => true,
                'metadata' => [
                    'validation_errors' => $e->errors(),
                    'request_data' => $request->all()
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Geçersiz export parametreleri.');
                
        } catch (\Exception $e) {
            // Log general error
            AdminAuditLog::logAction([
                'admin_id' => auth('admin')->id(),
                'admin_name' => auth('admin')->user()?->firstName . ' ' . auth('admin')->user()?->lastName,
                'admin_email' => auth('admin')->user()?->email,
                'action' => 'export',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['data_export'],
                'description' => 'User export failed - system error',
                'status' => AdminAuditLog::STATUS_FAILED,
                'severity' => AdminAuditLog::SEVERITY_ERROR,
                'is_sensitive' => true,
                'metadata' => [
                    'error_message' => $e->getMessage(),
                    'request_data' => $request->all()
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            \Log::error('User Export Error', [
                'admin_id' => auth('admin')->id(),
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Export işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update user lead status
     */
    public function bulkUpdateStatus(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'user_ids' => 'required|array|min:1|max:100',
                'user_ids.*' => 'required|exists:users,id',
                'new_status' => 'required|string|exists:lead_statuses,name'
            ]);
            
            $admin = auth('admin')->user();
            $userIds = $validated['user_ids'];
            $newStatus = $validated['new_status'];
            
            // Start database transaction
            DB::beginTransaction();
            
            // Get users before update for audit log
            $users = User::whereIn('id', $userIds)->get();
            
            // Bulk update status
            $updatedCount = User::whereIn('id', $userIds)
                ->update(['lead_status' => $newStatus]);
            
            // Log bulk operation
            \Log::info('Bulk Status Update', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->getDisplayName(),
                'user_ids' => $userIds,
                'new_status' => $newStatus,
                'updated_count' => $updatedCount,
                'old_statuses' => $users->pluck('lead_status', 'id')->toArray()
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} kullanıcının lead status'u '{$newStatus}' olarak güncellendi.",
                'updated_count' => $updatedCount
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri gönderildi.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Bulk Status Update Error', [
                'admin_id' => auth('admin')->id(),
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Toplu durum güncelleme sırasında bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Bulk assign admin to users
     */
    public function bulkAssignAdmin(Request $request)
    {
        $startTime = microtime(true);
        $operationId = uniqid('bulk_assign_');
        
        try {
            // Validation
            $validated = $request->validate([
                'user_ids' => 'required|array|min:1|max:100',
                'user_ids.*' => 'required|exists:users,id',
                'admin_id' => 'nullable|exists:admins,id'
            ]);
            
            $currentAdmin = auth('admin')->user();
            $userIds = $validated['user_ids'];
            $newAdminId = $validated['admin_id'];
            $newAdmin = null;
            
            // Validate new admin is active if provided
            if ($newAdminId) {
                $newAdmin = Admin::where('id', $newAdminId)
                    ->where('status', 'Active')
                    ->first();
                    
                if (!$newAdmin) {
                    // Log validation error
                    AdminAuditLog::logAction([
                        'admin_id' => $currentAdmin->id,
                        'admin_name' => $currentAdmin->firstName . ' ' . $currentAdmin->lastName,
                        'admin_email' => $currentAdmin->email,
                        'action' => 'bulk_assign',
                        'entity_type' => 'User',
                        'category' => AdminAuditLog::CATEGORIES['user_management'],
                        'description' => 'Bulk admin assignment failed - invalid target admin',
                        'status' => AdminAuditLog::STATUS_FAILED,
                        'severity' => AdminAuditLog::SEVERITY_WARNING,
                        'is_bulk_operation' => true,
                        'operation_id' => $operationId,
                        'metadata' => [
                            'target_admin_id' => $newAdminId,
                            'error' => 'Admin not found or inactive'
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                        'session_id' => session()->getId(),
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Seçilen admin bulunamadı veya aktif değil.'
                    ], 422);
                }
            }
            
            // Start database transaction
            DB::beginTransaction();
            
            // Get users before update for audit log
            $users = User::whereIn('id', $userIds)->get();
            
            // Bulk assign admin
            $updatedCount = User::whereIn('id', $userIds)
                ->update(['assign_to' => $newAdminId]);
            
            // Calculate execution time
            $executionTime = intval((microtime(true) - $startTime) * 1000);
            
            // Log successful bulk operation
            AdminAuditLog::logAction([
                'admin_id' => $currentAdmin->id,
                'admin_name' => $currentAdmin->firstName . ' ' . $currentAdmin->lastName,
                'admin_email' => $currentAdmin->email,
                'action' => 'bulk_assign',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['user_management'],
                'description' => $newAdminId ?
                    "Bulk admin assignment to {$newAdmin->firstName} {$newAdmin->lastName}" :
                    "Bulk admin unassignment",
                'status' => AdminAuditLog::STATUS_SUCCESS,
                'severity' => AdminAuditLog::SEVERITY_INFO,
                'is_bulk_operation' => true,
                'operation_id' => $operationId,
                'affected_count' => $updatedCount,
                'affected_entities' => $userIds,
                'execution_time_ms' => $executionTime,
                'old_values' => $users->pluck('assign_to', 'id')->toArray(),
                'new_values' => array_fill_keys($userIds, $newAdminId),
                'metadata' => [
                    'operation_type' => 'admin_assignment',
                    'target_admin_id' => $newAdminId,
                    'target_admin_name' => $newAdminId ? ($newAdmin->getDisplayName() ?? 'Unknown') : 'Unassigned',
                    'affected_user_count' => count($userIds)
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            // Log bulk operation (backward compatibility)
            \Log::info('Bulk Admin Assignment', [
                'current_admin_id' => $currentAdmin->id,
                'current_admin_name' => $currentAdmin->getDisplayName(),
                'user_ids' => $userIds,
                'new_admin_id' => $newAdminId,
                'new_admin_name' => $newAdminId ? ($newAdmin->getDisplayName() ?? 'Unknown') : 'Unassigned',
                'updated_count' => $updatedCount,
                'old_assignments' => $users->pluck('assign_to', 'id')->toArray(),
                'operation_id' => $operationId
            ]);
            
            DB::commit();
            
            $adminName = $newAdminId ? ($newAdmin->getDisplayName() ?? 'Admin') : 'Atanmamış';
            
            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} kullanıcı '{$adminName}' adminına atandı.",
                'updated_count' => $updatedCount,
                'admin_name' => $adminName
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            // Log validation error
            AdminAuditLog::logAction([
                'admin_id' => auth('admin')->id(),
                'admin_name' => auth('admin')->user()?->firstName . ' ' . auth('admin')->user()?->lastName,
                'admin_email' => auth('admin')->user()?->email,
                'action' => 'bulk_assign',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['user_management'],
                'description' => 'Bulk admin assignment failed - validation error',
                'status' => AdminAuditLog::STATUS_FAILED,
                'severity' => AdminAuditLog::SEVERITY_WARNING,
                'is_bulk_operation' => true,
                'operation_id' => $operationId,
                'metadata' => [
                    'validation_errors' => $e->errors(),
                    'request_data' => $request->all()
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veri gönderildi.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log general error
            AdminAuditLog::logAction([
                'admin_id' => auth('admin')->id(),
                'admin_name' => auth('admin')->user()?->firstName . ' ' . auth('admin')->user()?->lastName,
                'admin_email' => auth('admin')->user()?->email,
                'action' => 'bulk_assign',
                'entity_type' => 'User',
                'category' => AdminAuditLog::CATEGORIES['user_management'],
                'description' => 'Bulk admin assignment failed - system error',
                'status' => AdminAuditLog::STATUS_FAILED,
                'severity' => AdminAuditLog::SEVERITY_ERROR,
                'is_bulk_operation' => true,
                'operation_id' => $operationId,
                'metadata' => [
                    'error_message' => $e->getMessage(),
                    'request_data' => $request->all()
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId(),
            ]);
            
            \Log::error('Bulk Admin Assignment Error', [
                'admin_id' => auth('admin')->id(),
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'operation_id' => $operationId
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Toplu admin ataması sırasında bir hata oluştu.'
            ], 500);
        }
    }
}
