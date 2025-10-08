<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoTrade;
use App\Models\User;
use App\Models\Tp_Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DemoManagementController extends Controller
{
    /**
     * Display demo trading overview
     */
    public function index(Request $request)
    {
        $query = DemoTrade::with('user');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }

        if ($request->filled('asset')) {
            $query->where('assets', 'like', "%{$request->asset}%");
        }

        // Get paginated demo trades
        $demoTrades = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $stats = [
            'total_demo_trades' => DemoTrade::count(),
            'active_demo_trades' => DemoTrade::where('active', 'yes')->count(),
            'demo_users' => User::where('demo_balance', '>', 0)->count(),
            'total_demo_volume' => DemoTrade::sum('amount')
        ];

        $title = 'Demo Trading Management';

        return view('admin.demo.index', compact('demoTrades', 'stats', 'title'));
    }

    /**
     * Show demo users management
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Get users with demo balance info
        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate demo trade statistics separately
        $demoStats = [
            'total_users' => User::count(),
            'active_demo_trades' => DemoTrade::where('active', 'yes')->count(),
            'avg_demo_balance' => User::avg('demo_balance') ?: 0,
            'total_demo_volume' => User::sum('demo_balance') ?: 0,
            'users_with_demo_mode' => User::where('demo_mode', true)->count(),
            'total_demo_trades' => DemoTrade::count(),
        ];

        $title = 'Demo Users Management';

        return view('admin.demo.users', compact('users', 'demoStats', 'title'));
    }

    /**
     * Show demo trades management
     */
    public function trades(Request $request)
    {
        $query = DemoTrade::with('user');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('assets', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('asset')) {
            $query->where('assets', 'like', "%{$request->asset}%");
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get paginated demo trades
        $demoTrades = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics for this view - Create separate query instances
        $totalQuery = DemoTrade::query();
        $activeQuery = DemoTrade::where('active', 'yes');
        $volumeQuery = DemoTrade::query();

        // Apply same filters for accurate stats
        if ($request->filled('search')) {
            $search = $request->search;
            $totalQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('assets', 'like', "%{$search}%");

            $activeQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('assets', 'like', "%{$search}%");

            $volumeQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('assets', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $totalQuery->where('active', $request->status);
            $volumeQuery->where('active', $request->status);
        }

        if ($request->filled('type')) {
            $totalQuery->where('type', $request->type);
            $activeQuery->where('type', $request->type);
            $volumeQuery->where('type', $request->type);
        }

        if ($request->filled('asset')) {
            $totalQuery->where('assets', 'like', "%{$request->asset}%");
            $activeQuery->where('assets', 'like', "%{$request->asset}%");
            $volumeQuery->where('assets', 'like', "%{$request->asset}%");
        }

        if ($request->filled('date_from')) {
            $totalQuery->whereDate('created_at', '>=', $request->date_from);
            $activeQuery->whereDate('created_at', '>=', $request->date_from);
            $volumeQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $totalQuery->whereDate('created_at', '<=', $request->date_to);
            $activeQuery->whereDate('created_at', '<=', $request->date_to);
            $volumeQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Calculate profitable trades by getting all trades and checking P&L
        $allFilteredTrades = $totalQuery->get();
        $profitableTrades = $allFilteredTrades->filter(function($trade) {
            return $trade->calculatePnL() > 0;
        })->count();

        $stats = [
            'total_trades' => $totalQuery->count(),
            'active_trades' => $activeQuery->count(),
            'total_volume' => $volumeQuery->sum('amount'),
            'profitable_trades' => $profitableTrades,
        ];

        $title = 'Demo Trades Management';

        return view('admin.demo.trades', compact('demoTrades', 'stats', 'title'));
    }

    /**
     * Update user demo balance
     */
    public function updateDemoBalance(Request $request, $userId)
    {
        $request->validate([
            'demo_balance' => 'required|numeric|min:0|max:10000000',
            'action' => 'required|in:set,add,subtract'
        ]);

        try {
            $user = User::findOrFail($userId);
            $newBalance = $request->demo_balance;
            $currentBalance = $user->demo_balance;

            switch ($request->action) {
                case 'set':
                    $finalBalance = $newBalance;
                    $action = 'Set demo balance to';
                    break;
                case 'add':
                    $finalBalance = $currentBalance + $newBalance;
                    $action = 'Added to demo balance';
                    break;
                case 'subtract':
                    $finalBalance = max(0, $currentBalance - $newBalance);
                    $action = 'Subtracted from demo balance';
                    break;
            }

            $user->update(['demo_balance' => $finalBalance]);

            // Create transaction record
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => 'Admin Demo Balance Update',
                'amount' => $newBalance,
                'type' => 'Demo Balance ' . ucfirst($request->action),
                'status' => 'Processed',
            ]);

            // Log admin action
            Log::info('Admin updated user demo balance', [
                'admin_id' => auth()->id(),
                'user_id' => $userId,
                'action' => $request->action,
                'amount' => $newBalance,
                'previous_balance' => $currentBalance,
                'new_balance' => $finalBalance
            ]);

            return redirect()->back()->with('success',
                "{$action} $" . number_format($newBalance, 2) .
                ". New balance: $" . number_format($finalBalance, 2)
            );

        } catch (\Exception $e) {
            Log::error('Error updating demo balance: ' . $e->getMessage(), [
                'user_id' => $userId,
                'request_data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Failed to update demo balance. Please try again.');
        }
    }

    /**
     * Reset user demo account
     */
    public function resetUserDemo($userId)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($userId);

            // Close all active demo trades for this user
            DemoTrade::where('user', $userId)
                ->where('active', 'yes')
                ->update(['active' => 'expired']);

            // Reset demo balance to default
            $user->update(['demo_balance' => 100000.00]);

            // Create transaction record
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => 'Admin Demo Account Reset',
                'amount' => 100000.00,
                'type' => 'Demo Reset',
                'status' => 'Processed',
            ]);

            DB::commit();

            // Log admin action
            Log::info('Admin reset user demo account', [
                'admin_id' => auth()->id(),
                'user_id' => $userId,
                'user_email' => $user->email
            ]);

            return redirect()->back()->with('success',
                "Demo account reset for {$user->name}. Balance set to $100,000 and all active trades closed."
            );

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error resetting user demo account: ' . $e->getMessage(), [
                'user_id' => $userId
            ]);

            return redirect()->back()->with('error', 'Failed to reset demo account. Please try again.');
        }
    }

    /**
     * Bulk reset all demo accounts
     */
    public function bulkResetDemo()
    {
        try {
            DB::beginTransaction();

            // Close all active demo trades
            DemoTrade::where('active', 'yes')->update(['active' => 'expired']);

            // Reset all user demo balances
            User::query()->update(['demo_balance' => 100000.00]);

            // Create bulk transaction records
            $users = User::all();
            $transactions = [];
            foreach ($users as $user) {
                $transactions[] = [
                    'user' => $user->id,
                    'plan' => 'Admin Bulk Demo Reset',
                    'amount' => 100000.00,
                    'type' => 'Demo Bulk Reset',
                    'status' => 'Processed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Tp_Transaction::insert($transactions);

            DB::commit();

            // Log admin action
            Log::info('Admin performed bulk demo reset', [
                'admin_id' => auth()->id(),
                'affected_users' => $users->count()
            ]);

            return redirect()->back()->with('success',
                'All demo accounts have been reset. ' . $users->count() . ' users affected.'
            );

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk demo reset: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to perform bulk reset. Please try again.');
        }
    }

    /**
     * Get demo trading statistics
     */
    public function statistics()
    {
        $stats = [
            'total_demo_users' => User::where('demo_balance', '>', 0)->count(),
            'active_demo_trades' => DemoTrade::where('active', 'yes')->count(),
            'total_demo_trades' => DemoTrade::count(),
            'total_demo_volume' => DemoTrade::sum('amount'),
            'avg_demo_balance' => User::avg('demo_balance'),
            'profitable_demo_trades' => DemoTrade::where('profit_earned', '>', 0)->count(),
            'losing_demo_trades' => DemoTrade::where('profit_earned', '<', 0)->count(),
        ];

        // Calculate win rate
        $totalClosedTrades = DemoTrade::where('active', 'expired')->count();
        $stats['demo_win_rate'] = $totalClosedTrades > 0
            ? round(($stats['profitable_demo_trades'] / $totalClosedTrades) * 100, 2)
            : 0;

        // Get top demo traders
        $topTraders = User::leftJoin('demo_trades', 'users.id', '=', 'demo_trades.user')
            ->select('users.*', DB::raw('SUM(demo_trades.profit_earned) as total_demo_profit'))
            ->groupBy('users.id')
            ->orderBy('total_demo_profit', 'desc')
            ->take(10)
            ->get();

        $title = 'Demo Trading Statistics';

        return view('admin.demo.statistics', compact('stats', 'topTraders', 'title'));
    }

    /**
     * Close a demo trade (admin action)
     */
    public function closeDemoTrade($id)
    {
        $trade = DemoTrade::findOrFail($id);

        if ($trade->active !== 'yes') {
            return redirect()->back()->with('error', 'This demo trade is already closed.');
        }

        try {
            DB::beginTransaction();

            $user = $trade->user;

            // Calculate final P&L
            $pnl = $trade->calculatePnL();
            $finalValue = $trade->getCurrentValue();

            // Update trade status
            $trade->update([
                'active' => 'expired',
                'profit_earned' => $pnl,
                'result_type' => $pnl > 0 ? 'WIN' : 'LOSE'
            ]);

            // Add final value back to demo balance
            User::where('id', $user->id)->update([
                'demo_balance' => DB::raw("demo_balance + {$finalValue}")
            ]);

            DB::commit();

            // Log admin action
            Log::info('Admin closed demo trade', [
                'admin_id' => auth()->id(),
                'demo_trade_id' => $id,
                'user_id' => $user->id,
                'pnl' => $pnl,
                'final_value' => $finalValue
            ]);

            $message = $pnl > 0
                ? "Demo trade closed with profit of $" . number_format($pnl, 2)
                : "Demo trade closed with loss of $" . number_format(abs($pnl), 2);

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error closing demo trade: ' . $e->getMessage(), [
                'demo_trade_id' => $id
            ]);

            return redirect()->back()->with('error', 'Failed to close demo trade. Please try again.');
        }
    }
}
