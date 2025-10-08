<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DemoTrade;
use App\Models\User;
use App\Models\Instrument;
use App\Models\Tp_Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\NotificationTrait;

class DemoTradingController extends Controller
{
    use NotificationTrait;

    /**
     * Show demo trading dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get active demo trades (handle both current and legacy status values)
        $activeTrades = DemoTrade::where('user', $user->id)
            ->where('active', 'yes')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get recent demo trades
        $recentTrades = DemoTrade::where('user', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate statistics
        $totalTrades = DemoTrade::where('user', $user->id)->count();
        $profitableTrades = DemoTrade::where('user', $user->id)
            ->where('profit_earned', '>', 0)
            ->count();

        $winRate = $totalTrades > 0 ? round(($profitableTrades / $totalTrades) * 100, 2) : 0;

        $totalProfit = DemoTrade::where('user', $user->id)
            ->sum('profit_earned');

        $title = 'Demo Trading Dashboard';

        return view('user.demo.dashboard', compact(
            'activeTrades',
            'recentTrades',
            'totalTrades',
            'winRate',
            'totalProfit',
            'title'
        ));
    }

    /**
     * Show demo trading interface
     */
    public function trade()
    {
        // Get instruments with prices, prioritizing crypto and stocks for demo trading
        $instruments = Instrument::whereNotNull('price')
            ->where('price', '>', 0)
            ->whereIn('type', ['crypto', 'stock', 'forex', 'commodity'])
            ->orderByRaw("FIELD(type, 'crypto', 'stock', 'forex', 'commodity')")
            ->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        // If no instruments with prices found, get all instruments and assign random prices
        if ($instruments->isEmpty()) {
            $allInstruments = Instrument::whereIn('type', ['crypto', 'stock', 'forex', 'commodity'])
                ->orderByRaw("FIELD(type, 'crypto', 'stock', 'forex', 'commodity')")
                ->get();

            // Assign random prices based on asset type
            foreach ($allInstruments as $instrument) {
                if (!$instrument->price || $instrument->price <= 0) {
                    $instrument->price = $this->generateRandomPrice($instrument);
                    $instrument->save();
                }
            }

            $instruments = $allInstruments;
        }

        $title = 'Demo Trading';

        return view('user.demo.trade', compact('instruments', 'title'));
    }

    /**
     * Execute a demo trade
     */
    public function executeTrade(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'asset' => 'required|string',
            'order_type' => 'required|string|in:Buy,Sell',
            'leverage' => 'required|numeric|min:1|max:100',
            'expire' => 'required|string',
        ]);

        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->back()->with('message', 'User not found.');
        }

        $amount = floatval($request->amount);
        $asset = $request->asset;
        $symbol = $request->symbol ?? $asset;
        $type = $request->order_type;
        $leverage = floatval($request->leverage);

        // Check if the user demo balance can cover this trade
        if ($user->demo_balance < $amount) {
            return redirect()->back()
                ->with('message', 'Your demo account is insufficient for this trade. Demo Balance: $' . number_format($user->demo_balance, 2));
        }

        // Parse expiration date
        try {
            $expiration = explode(" ", $request->expire);
            if (count($expiration) < 2) {
                return redirect()->back()->with('message', 'Invalid expiration format.');
            }

            $digit = intval($expiration[0]);
            $frame = strtolower($expiration[1]);

            $frameMap = [
                'minutes' => 'addMinutes',
                'minute' => 'addMinutes',
                'mins' => 'addMinutes',
                'min' => 'addMinutes',
                'hours' => 'addHours',
                'hour' => 'addHours',
                'hrs' => 'addHours',
                'hr' => 'addHours',
                'days' => 'addDays',
                'day' => 'addDays',
                'weeks' => 'addWeeks',
                'week' => 'addWeeks',
                'months' => 'addMonths',
                'month' => 'addMonths',
            ];

            if (!isset($frameMap[$frame])) {
                return redirect()->back()->with('message', 'Invalid time frame.');
            }

            $carbonMethod = $frameMap[$frame];
            $end_at = Carbon::now()->$carbonMethod($digit);

        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Error calculating expiration date.');
        }

        // Get current price for the asset from instrument
        $instrument = Instrument::where('symbol', $asset)
            ->orWhere('name', $asset)
            ->first();

        // Use instrument price if available, otherwise generate a random price
        if ($instrument && $instrument->price > 0) {
            $entryPrice = $instrument->price;
        } else {
            // If no instrument found or no price, create/update one with random price
            if (!$instrument) {
                // Try to determine asset type from symbol/name
                $assetType = $this->determineAssetType($asset);
                $instrument = Instrument::create([
                    'symbol' => $asset,
                    'name' => $asset,
                    'type' => $assetType,
                    'price' => 0,
                    'volume' => 0,
                    'market_cap' => 0,
                ]);
            }

            $entryPrice = $this->generateRandomPrice($instrument);
            $instrument->update(['price' => $entryPrice]);
        }

        try {
            DB::beginTransaction();

            // Debit user demo balance
            $updatedUser = User::where('id', $user->id)
                ->update([
                    'demo_balance' => $user->demo_balance - $amount,
                ]);

            if (!$updatedUser) {
                throw new \Exception('Failed to update user demo balance');
            }

            // Create demo trade
            $demoTradeId = DemoTrade::create([
                'plan' => 1,
                'user' => $user->id,
                'amount' => $amount,
                'active' => 'yes',
                'assets' => $asset,
                'symbol' => $symbol,
                'leverage' => $leverage,
                'inv_duration' => $request->expire,
                'type' => $type,
                'entry_price' => $entryPrice,
                'current_price' => $entryPrice,
                'expire_date' => $end_at,
                'activated_at' => Carbon::now(),
                'last_growth' => Carbon::now(),
            ]);

            if (!$demoTradeId) {
                throw new \Exception('Failed to create demo trade');
            }

            // Create demo transaction history
            $transaction = Tp_Transaction::create([
                'user' => $user->id,
                'plan' => 'Demo - ' . $asset,
                'amount' => $amount,
                'type' => 'Demo ' . $type,
                'leverage' => $leverage,
                'status' => 'Processed',
            ]);

            DB::commit();

            // Create success notification
            $this->createUserNotification(
                $user->id,
                'Demo Trade Opened',
                "Demo trade opened for {$asset} with {$leverage}x leverage. Amount: $" . number_format($amount, 2),
                'success'
            );

            return redirect()->route('demo.dashboard')
                ->with('success', 'Demo trade executed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Failed to execute demo trade: ' . $e->getMessage());
        }
    }

    /**
     * Close a demo trade
     */
    public function closeTrade($id)
    {
        $trade = DemoTrade::where('id', $id)
            ->where('user', Auth::id())
            ->where('active', 'yes')
            ->first();

        if (!$trade) {
            return redirect()->back()->with('error', 'Demo trade not found or already closed.');
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();

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
            $user->update([
                'demo_balance' => $user->demo_balance + $finalValue
            ]);

            // Create transaction record
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => 'Demo Trade Closed - ' . $trade->assets,
                'amount' => $finalValue,
                'type' => 'Demo Trade Close',
                'status' => 'Processed',
            ]);

            DB::commit();

            $message = $pnl > 0
                ? "Demo trade closed with profit of $" . number_format($pnl, 2)
                : "Demo trade closed with loss of $" . number_format(abs($pnl), 2);

            // Create notification
            $this->createUserNotification(
                $user->id,
                'Demo Trade Closed',
                $message . ". Final value: $" . number_format($finalValue, 2),
                $pnl > 0 ? 'success' : 'info'
            );

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to close demo trade: ' . $e->getMessage());
        }
    }

    /**
     * Get demo trade history with pagination and filters
     */
    public function history(Request $request)
    {
        $query = DemoTrade::where('user', Auth::id());

        // Apply filters
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('active', 'yes');
            } elseif ($request->status === 'closed') {
                $query->where('active', 'no');
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('result')) {
            $query->where('result_type', $request->result);
        }

        if ($request->filled('asset')) {
            $query->where('assets', 'like', '%' . $request->asset . '%');
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get per page value (default 20, max 100)
        $perPage = min((int) $request->get('per_page', 20), 100);

        $trades = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        $title = 'Demo Trading History';

        return view('user.demo.history', compact('trades', 'title'));
    }

    /**
     * Reset demo account
     */
    public function resetAccount()
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Close all active demo trades
            DemoTrade::where('user', $user->id)
                ->where('active', 'yes')
                ->update(['active' => 'expired']);

            // Reset demo balance to default
            $user->update([
                'demo_balance' => 100000.00
            ]);

            // Create transaction record
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => 'Demo Account Reset',
                'amount' => 100000.00,
                'type' => 'Demo Reset',
                'status' => 'Processed',
            ]);

            DB::commit();

            // Create notification
            $this->createUserNotification(
                $user->id,
                'Demo Account Reset',
                'Your demo account has been reset to $100,000. All active trades have been closed.',
                'info'
            );

            return redirect()->route('demo.dashboard')
                ->with('success', 'Demo account reset successfully! You now have $100,000 to practice trading.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to reset demo account: ' . $e->getMessage());
        }
    }

    /**
     * Toggle demo mode
     */
    public function toggleDemoMode()
    {
        $user = Auth::user();

        $newMode = !$user->demo_mode;
        $user->update(['demo_mode' => $newMode]);

        $message = $newMode
            ? 'Switched to Demo Trading Mode. You are now using virtual money.'
            : 'Switched to Live Trading Mode. You are now using real money.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Generate random price for instruments without prices based on asset type
     */
    private function generateRandomPrice($instrument)
    {
        switch ($instrument->type) {
            case 'crypto':
                // Crypto prices vary widely
                if (stripos($instrument->symbol, 'BTC') !== false) {
                    return rand(40000, 50000) + (rand(0, 99) / 100); // $40,000 - $50,000
                } elseif (stripos($instrument->symbol, 'ETH') !== false) {
                    return rand(2000, 3000) + (rand(0, 99) / 100); // $2,000 - $3,000
                } elseif (stripos($instrument->symbol, 'BNB') !== false) {
                    return rand(250, 350) + (rand(0, 99) / 100); // $250 - $350
                } elseif (stripos($instrument->symbol, 'SOL') !== false) {
                    return rand(80, 120) + (rand(0, 99) / 100); // $80 - $120
                } elseif (stripos($instrument->symbol, 'ADA') !== false) {
                    return rand(30, 70) / 100; // $0.30 - $0.70
                } else {
                    // Other cryptocurrencies
                    return rand(1, 100) + (rand(0, 99) / 100); // $1 - $100
                }

            case 'stock':
                // Stock prices typically range from $10 to $500
                if (stripos($instrument->symbol, 'AAPL') !== false) {
                    return rand(150, 200) + (rand(0, 99) / 100); // $150 - $200
                } elseif (stripos($instrument->symbol, 'GOOGL') !== false) {
                    return rand(120, 160) + (rand(0, 99) / 100); // $120 - $160
                } elseif (stripos($instrument->symbol, 'MSFT') !== false) {
                    return rand(350, 400) + (rand(0, 99) / 100); // $350 - $400
                } elseif (stripos($instrument->symbol, 'TSLA') !== false) {
                    return rand(200, 300) + (rand(0, 99) / 100); // $200 - $300
                } elseif (stripos($instrument->symbol, 'NVDA') !== false) {
                    return rand(800, 1000) + (rand(0, 99) / 100); // $800 - $1,000
                } else {
                    // Other stocks
                    return rand(20, 300) + (rand(0, 99) / 100); // $20 - $300
                }

            case 'forex':
                // Forex rates are typically between 0.5 and 200
                if (stripos($instrument->symbol, 'EUR/USD') !== false) {
                    return 1 + (rand(5, 15) / 100); // 1.05 - 1.15
                } elseif (stripos($instrument->symbol, 'GBP/USD') !== false) {
                    return 1.2 + (rand(0, 10) / 100); // 1.20 - 1.30
                } elseif (stripos($instrument->symbol, 'USD/JPY') !== false) {
                    return rand(140, 160) + (rand(0, 99) / 100); // 140 - 160
                } else {
                    // Other forex pairs
                    return rand(50, 200) / 100; // 0.50 - 2.00
                }

            case 'commodity':
                // Commodity prices vary by type
                if (stripos($instrument->symbol, 'GOLD') !== false || stripos($instrument->name, 'Gold') !== false) {
                    return rand(1900, 2100) + (rand(0, 99) / 100); // $1,900 - $2,100
                } elseif (stripos($instrument->symbol, 'SILVER') !== false || stripos($instrument->name, 'Silver') !== false) {
                    return rand(20, 30) + (rand(0, 99) / 100); // $20 - $30
                } elseif (stripos($instrument->symbol, 'OIL') !== false || stripos($instrument->name, 'Oil') !== false) {
                    return rand(70, 90) + (rand(0, 99) / 100); // $70 - $90
                } else {
                    // Other commodities
                    return rand(10, 100) + (rand(0, 99) / 100); // $10 - $100
                }

            case 'bond':
                // Bond yields are typically between 2% and 6%
                return rand(200, 600) / 100; // 2.00% - 6.00%

            default:
                // Default random price
                return rand(10, 100) + (rand(0, 99) / 100); // $10 - $100
        }
    }

    /**
     * Determine asset type based on symbol or name
     */
    private function determineAssetType($asset)
    {
        $asset = strtoupper($asset);

        // Check for crypto patterns
        if (strpos($asset, 'BTC') !== false || strpos($asset, 'ETH') !== false ||
            strpos($asset, 'BNB') !== false || strpos($asset, 'ADA') !== false ||
            strpos($asset, 'SOL') !== false || strpos($asset, 'DOGE') !== false ||
            strpos($asset, 'USDT') !== false || strpos($asset, 'USDC') !== false) {
            return 'crypto';
        }

        // Check for forex patterns (contains slash or common currency codes)
        if (strpos($asset, '/') !== false ||
            (strpos($asset, 'USD') !== false && strpos($asset, 'EUR') !== false) ||
            (strpos($asset, 'USD') !== false && strpos($asset, 'GBP') !== false) ||
            (strpos($asset, 'USD') !== false && strpos($asset, 'JPY') !== false)) {
            return 'forex';
        }

        // Check for commodity patterns
        if (strpos($asset, 'GOLD') !== false || strpos($asset, 'SILVER') !== false ||
            strpos($asset, 'OIL') !== false || strpos($asset, 'COPPER') !== false ||
            strpos($asset, 'WHEAT') !== false || strpos($asset, 'GAS') !== false) {
            return 'commodity';
        }

        // Check for bond patterns
        if (strpos($asset, 'BOND') !== false || strpos($asset, 'TREASURY') !== false ||
            preg_match('/US\d+Y/', $asset)) {
            return 'bond';
        }

        // Default to stock for company symbols
        return 'stock';
    }
}
