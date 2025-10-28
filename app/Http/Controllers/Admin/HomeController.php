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
use Illuminate\Http\Request;
use App\Models\Kyc;
use App\Models\OrdersP2p;
use App\Models\Task;
use App\Models\Wallets;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show Admin Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sum total deposited
        $total_deposited = DB::table('deposits')->select(DB::raw("SUM(amount) as count"))->where('status', 'Processed')->get();
        $pending_deposited = DB::table('deposits')->select(DB::raw("SUM(amount) as count"))->where('status', 'Pending')->get();
        $total_withdrawn = DB::table('withdrawals')->select(DB::raw("SUM(amount) as count"))->where('status', 'Processed')->get();
        $pending_withdrawn = DB::table('withdrawals')->select(DB::raw("SUM(amount) as count"))->where('status', 'Pending')->get();

        $userlist = User::count();
        $activeusers = User::where('status', 'active')->count();
        $blockeusers = User::where('status', 'blocked')->count();
        $plans = Plans::count();
        $unverifiedusers = User::where('account_verify', '!=', 'yes')->count();

        $chart_pdepsoit = DB::table('deposits')->where('status', 'Processed')->sum('amount');
        $chart_pendepsoit = DB::table('deposits')->where('status', 'Pending')->sum('amount');
        $chart_pwithdraw = DB::table('withdrawals')->where('status', 'Processed')->sum('amount');
        $chart_pendwithdraw = DB::table('withdrawals')->where('status', 'Pending')->sum('amount');
        $chart_trans = Tp_Transaction::sum('amount');

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
    public function manageusers()
    {
        // Kullanıcı listesi (sayfalı)
        $users = User::orderBy('id', 'desc')->paginate(15);
        
        // İstatistikler
        $user_count = User::count();
        $active_users = User::where('status', 'active')->count();
        $blocked_users = User::where('status', 'blocked')->count();
        $pending_verification = User::where('account_verify', '!=', 'yes')->count();

        return view('admin.users-modern', [
            'title' => 'All users',
            'users' => $users,
            'user_count' => $user_count,
            'active_users' => $active_users,
            'blocked_users' => $blocked_users,
            'pending_verification' => $pending_verification,
        ]);
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
        return view('admin.Withdrawals.mwithdrawals')
            ->with(array(
                'title' => 'Manage users withdrawals',
                'withdrawals' => Withdrawal::with('duser')->orderBy('id', 'desc')->get(),

            ));
    }

    //Return manage deposits route
    public function mdeposits()
    {
        return view('admin.Deposits.mdeposits')
            ->with(array(
                'title' => 'Manage users deposits',
                'deposits' => Deposit::with('duser')->orderBy('id', 'desc')->paginate(15),
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
        return view('admin.kyc', [
            'title' => 'KYC Applications',
            'settings' => Settings::find(1),
            'kycs' => Kyc::orderByDesc('id')->with(['user'])->get(),
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
                'users' => User::orderby('id', 'desc')->where('cstatus', NULL)->get(),
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
}
