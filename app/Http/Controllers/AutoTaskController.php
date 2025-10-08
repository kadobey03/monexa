<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\User_plans;
use App\Models\Investment;
use App\Models\User_copytradings;
use App\Models\Tp_Transaction;
use App\Models\Notification;
use App\Models\DemoTrade;
use App\Mail\NewRoi;
use App\Mail\endplan;
use App\Mail\NewNotification;
use App\Models\Mt4Details;
use App\Traits\BinanceApi;
use App\Traits\Coinpayment;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AutoTaskController extends Controller
{
    use Coinpayment, BinanceApi;
    /*
        Automatic toup
        calculate top up earnings and
        auto increment earnings after the increment time
    */

    /**
     * Helper method to create user notifications
     *
     * @param int $userId User ID to send notification to
     * @param string $title Notification title
     * @param string $message Notification message
     * @param string $type Notification type (profit, system, warning, etc)
     * @param int|null $sourceId Related source ID (transaction, plan, etc)
     * @param string|null $sourceType Related source model type
     * @return Notification
     */
    private function createUserNotification($userId, $title, $message, $type = 'success', $sourceId = null, $sourceType = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
            'source_id' => $sourceId,
            'source_type' => $sourceType
        ]);
    }

    public function autotopup()
    {
        // automatic roi for investment plans
        $this->automaticRoi();

        // automatic trading profit calculation
        $this->automaticTradingProfit();

        // automatic copy trading profit calculation
        $this->automaticCopyTradingProfits();

        // automatic bot trading profit calculation
        $this->automaticBotTradingProfits();

        // automatic demo trading updates
        $this->automaticDemoTradingUpdates();

        // check for subscription expiration

    }

    /**
     * Calculate and distribute automatic ROI for investment plans
     */
    public function automaticRoi()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            //get user investment plans
            $usersPlans = Investment::where('active', 'yes')->get();

            //get current date and time to be used for calculations of ROI
            $now = now();

            //logic to add auto roi
            foreach ($usersPlans as $plan) {
                //get plan
                $dplan = Plans::firstWhere('id', $plan->plan);
                if (!$dplan) continue; // Skip if plan doesn't exist

                //get user
                $user = User::firstWhere('id', $plan->user);
                if (!$user) continue; // Skip if user doesn't exist

                //know the plan increment interval
                if ($dplan->increment_interval == "Monthly") {
                    $nextDrop = $plan->last_growth->addDays(25);
                } elseif ($dplan->increment_interval == "Weekly") {
                    $nextDrop = $plan->last_growth->addDays(6);
                } elseif ($dplan->increment_interval == "Daily") {
                    $nextDrop = $plan->last_growth->addHours(20);
                } elseif ($dplan->increment_interval == "Hourly") {
                    $nextDrop = $plan->last_growth->addMinutes(49);
                } elseif ($dplan->increment_interval == "Every 30 Minutes") {
                    $nextDrop = $plan->last_growth->addMinutes(25);
                } else {
                    $nextDrop = $plan->last_growth->addMinutes(10);
                }

                //conditions
                $condition = $now->lessThanOrEqualTo($plan->expire_date) && $user->trade_mode == 'on';
                $condition2 = $now->greaterThan($plan->expire_date);

                //calculate increment
                if ($dplan->increment_type == "Percentage") {
                    $increment = (floatval($plan->amount) * floatval($dplan->increment_amount)) / 100;
                } else {
                    $increment = floatval($dplan->increment_amount);
                }

                if ($condition) {
                    if ($now->isWeekday() or $settings->weekend_trade == 'on') {
                        if ($now->greaterThanOrEqualTo($nextDrop)) {

                            User::where('id', $plan->user)
                                ->update([
                                    'roi' => $user->roi + $increment,
                                    'account_bal' => $user->account_bal + $increment,

                                ]);

                            //save to transactions history
                            $th = new Tp_Transaction();
                            $th->plan = $dplan->name;
                            $th->user = $user->id;
                            $th->amount = $increment;
                            $th->user_plan_id = $plan->id;
                            $th->type = "ROI";
                            $th->save();

                            Investment::where('id', $plan->id)
                                ->update([
                                    'last_growth' => $nextDrop,
                                     'profit_earned' => $plan->profit_earned + $increment,
                                ]);

                            // Create in-app notification for ROI earnings
                            $this->createUserNotification(
                                $user->id,
                                'ROI Earnings Received',
                                "You have received a return of {$user->currency}{$increment} from your investment in {$dplan->name}.",
                                'success',
                                $th->id,
                                'Tp_Transaction'
                            );

                            // if ($user->sendroiemail == 'Yes') {
                            //     //send email notification
                            //     $date = Carbon::now()->toDateTimeString();
                            //     Mail::to($user->email)->send(new NewRoi($user, $dplan->name, $increment, $date, 'New Return on Investment(ROI)'));
                            // }
                        }
                    }
                    if ($now->isWeekend() and $settings->weekend_trade != 'on') {
                        if ($now->greaterThanOrEqualTo($nextDrop)) {
                            Investment::where('id', $plan->id)
                                ->update([
                                    'last_growth' => $nextDrop,
                                ]);
                        }
                    }
                }

                if ($condition2) {
                    //release capital
                    if ($settings->return_capital) {
                        User::where('id', $plan->user)
                            ->update([
                                'account_bal' => $user->account_bal + $plan->amount,
                            ]);

                        //save to transactions history
                        $th = new Tp_transaction();
                        $th->plan = $dplan->name;
                        $th->user = $plan->user;
                        $th->amount = $plan->amount;
                        $th->type = "Investment capital";
                        $th->save();
                    }

                    //plan expired
                    Investment::where('id', $plan->id)
                        ->update([
                            'active' => "expired",
                        ]);

                    // Create in-app notification for plan expiration
                    $this->createUserNotification(
                        $user->id,
                        'Investment Plan Completed',
                        "Your investment plan '{$dplan->name}' has been completed. Total profit earned: {$user->currency}{$plan->profit_earned}",
                        'info',
                        $plan->id,
                        'Investment'
                    );

                    if ($user->sendinvplanemail == "Yes") {
                        //send email notification
                        $objDemo = new \stdClass();
                        $objDemo->receiver_email = $user->email;
                        $objDemo->receiver_plan = $dplan->name;
                        $objDemo->received_amount = "$user->currency$plan->amount";
                        $objDemo->sender = $settings->site_name;
                        $objDemo->receiver_name = $user->name;
                        $objDemo->date = \Carbon\Carbon::Now();
                        $objDemo->subject = "Investment plan closed";

                        try {
                            Mail::to($user->email)->send(new endplan($objDemo));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send investment plan completion email. User: ' . $user->name . ' (' . $user->email . '), Plan: ' . $dplan->name . ', Investment ID: ' . $plan->id . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate and distribute automatic trading profits for User_plans (trading)
     */
    public function automaticTradingProfit()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            // Get active trading plans (User_plans)
            $tradingPlans = User_plans::where('active', 'yes')->get();
            $now = now();

            foreach ($tradingPlans as $trade) {
                // Get user
                $user = User::firstWhere('id', $trade->user);
                if (!$user) continue;

                // Check if trade has expired
                $tradeExpired = $now->greaterThan($trade->expire_date);
                $tradeActive = $now->lessThanOrEqualTo($trade->expire_date) && $user->trade_mode == 'on';

                if ($tradeExpired) {
                    // Generate random profit/loss based on market conditions and leverage
                    $profitResult = $this->calculateTradingResult($trade);

                    // Update user ROI based on trading result
                    if ($profitResult['result'] == 'WIN') {
                        $profit = (floatval($trade->amount) * floatval($profitResult['percentage'])) / 100;

                        User::where('id', $trade->user)
                            ->update([
                                'roi' => $user->roi + $profit,
                                'account_bal' => $user->account_bal + $trade->amount + $profit, // Return capital + profit
                            ]);

                        // Update user_plans profit_earned column
                        User_plans::where('id', $trade->id)
                            ->update([
                                'profit_earned' => ($trade->profit_earned ?? 0) + $profit,
                            ]);

                        // Save transaction history
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $profit,
                            'type' => 'WIN',
                            'leverage' => $profitResult['percentage'],
                        ]);

                        // Return capital transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $trade->amount,
                            'type' => 'Trading capital return',
                            'leverage' => 0,
                        ]);

                    } else {
                        // LOSE - Calculate loss based on leverage and market movement
                        $actualLoss = (floatval($trade->amount) * floatval($profitResult['loss_percentage'])) / 100;
                        $refundAmount = floatval($trade->amount) - $actualLoss;

                        // Update user_plans profit_earned column with negative loss
                        User_plans::where('id', $trade->id)
                            ->update([
                                'profit_earned' => ($trade->profit_earned ?? 0) - $actualLoss,
                            ]);

                        // Refund the remaining amount to user account
                        if ($refundAmount > 0) {
                            User::where('id', $trade->user)
                                ->update([
                                    'account_bal' => $user->account_bal + $refundAmount,
                                ]);

                            // Record refund transaction
                            Tp_Transaction::create([
                                'user' => $user->id,
                                'plan' => $trade->assets,
                                'amount' => $refundAmount,
                                'type' => 'Trading capital refund',
                                'leverage' => 0,
                            ]);
                        }

                        // Record loss transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => $trade->assets,
                            'amount' => $actualLoss,
                            'type' => 'LOSE',
                            'leverage' => $profitResult['loss_percentage'],
                        ]);
                    }

                    // Mark trade as expired
                    User_plans::where('id', $trade->id)
                        ->update([
                            'active' => 'expired',
                        ]);

                    // Update user trade status
                    User::where('id', $trade->user)
                        ->update([
                            'trade' => 0,
                        ]);

                    // Create in-app notification based on trading result
                    if ($profitResult['result'] == 'WIN') {
                        $profit = (floatval($trade->amount) * floatval($profitResult['percentage'])) / 100;

                        $this->createUserNotification(
                            $user->id,
                            'Trading Profit Generated',
                            "Your {$trade->assets} trade has completed successfully with a profit of {$user->currency}{$profit} ({$profitResult['percentage']}%).",
                            'success',
                            $trade->id,
                            'User_plans'
                        );
                    } else {
                        $actualLoss = (floatval($trade->amount) * floatval($profitResult['loss_percentage'])) / 100;
                        $refundAmount = floatval($trade->amount) - $actualLoss;

                        $this->createUserNotification(
                            $user->id,
                            'Trading Loss',
                            "Your {$trade->assets} trade resulted in a {$profitResult['loss_percentage']}% loss ({$user->currency}{$actualLoss}). Due to leverage protection, {$user->currency}{$refundAmount} has been refunded to your account.",
                            'warning',
                            $trade->id,
                            'User_plans'
                        );
                    }

                    // Send notification email if enabled
                    if ($user->sendroiemail == 'Yes') {
                        $message = "Your {$trade->assets} trade has been completed with a {$profitResult['result']} result.";
                        $subject = "Trading Result: {$profitResult['result']}";

                        try {
                            Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send trading result notification email. User: ' . $user->name . ' (' . $user->email . '), Trade ID: ' . $trade->id . ', Asset: ' . $trade->assets . ', Result: ' . $profitResult['result'] . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate trading result based on market simulation and leverage
     * @param User_plans $trade
     * @return array
     */
    private function calculateTradingResult($trade)
    {
        $settings = Settings::find(1);
        // Simulate market conditions (60% win rate for realistic trading)
        $winChance = $settings->trading_winrate;
        $isWin = rand(1, 100) <= $winChance;

        if ($isWin) {
            // Calculate profit percentage based on leverage (more realistic returns)
            $baseProfitRate = rand(5, 15); // 5-15% base profit
            $leverageMultiplier = floatval($trade->leverage) / 10; // Leverage effect
            $profitPercentage = min($baseProfitRate * $leverageMultiplier, 200); // Cap at 200%

            return [
                'result' => 'WIN',
                'percentage' => round($profitPercentage, 2)
            ];
        } else {
            // Calculate loss based on leverage - higher leverage = higher potential loss but with stop-loss protection
            $leverage = floatval($trade->leverage);

            // Base loss percentage (what user actually loses from their investment)
            if ($leverage >= 100) {
                $lossPercentage = rand(40, 70); // High leverage: 40-70% loss, 30-60% refunded
            } elseif ($leverage >= 50) {
                $lossPercentage = rand(30, 50); // Medium-high leverage: 30-50% loss, 50-70% refunded
            } elseif ($leverage >= 20) {
                $lossPercentage = rand(20, 40); // Medium leverage: 20-40% loss, 60-80% refunded
            } elseif ($leverage >= 10) {
                $lossPercentage = rand(15, 30); // Low-medium leverage: 15-30% loss, 70-85% refunded
            } else {
                $lossPercentage = rand(10, 25); // Low leverage: 10-25% loss, 75-90% refunded
            }

            return [
                'result' => 'LOSE',
                'loss_percentage' => round($lossPercentage, 2),
                'percentage' => round($lossPercentage, 2) // For backward compatibility
            ];
        }
    }

    /**
     * Calculate and distribute copy trading profits automatically
     */
    public function automaticCopyTradingProfits()
    {
        $settings = Settings::find(1);

        if ($settings->trade_mode == 'on') {
            // Get all active copy trading plans
            $activeCopyTrades = User_copytradings::where('active', 'yes')->get();
            $now = Carbon::now();

            foreach ($activeCopyTrades as $copyTrade) {
                // Get user
                $user = User::find($copyTrade->user);
                if (!$user) continue;

                // Check if it's time to generate profit (every 2-8 hours)
                $lastProfit = $copyTrade->last_profit ? Carbon::parse($copyTrade->last_profit) : Carbon::parse($copyTrade->started_at ?? $copyTrade->created_at);
                $hoursToAdd = rand(2, 8); // Random interval between 2-8 hours
                $nextProfitTime = $lastProfit->addHours($hoursToAdd);

                if ($now->greaterThanOrEqualTo($nextProfitTime)) {
                    // Generate copy trading profit based on expert performance
                    $profitResult = $this->calculateCopyTradingProfit($copyTrade);

                    if ($profitResult['result'] == 'PROFIT') {
                        $profit = $profitResult['amount'];
                        $newBalance = ($copyTrade->current_balance ?? $copyTrade->price) + $profit;
                        $totalProfit = ($copyTrade->total_profit ?? 0) + $profit;
                        $winningTrades = ($copyTrade->winning_trades ?? 0) + 1;
                        $totalTrades = ($copyTrade->total_trades ?? 0) + 1;
                        $profitPercentage = (($newBalance - $copyTrade->price) / $copyTrade->price) * 100;

                        // Update user account with profit
                        User::where('id', $user->id)
                            ->update([
                                'roi' => $user->roi + $profit,
                                'account_bal' => $user->account_bal + $profit,
                            ]);

                        // Update copy trading record with comprehensive data
                        User_copytradings::where('id', $copyTrade->id)
                            ->update([
                                'current_balance' => $newBalance,
                                'total_profit' => $totalProfit,
                                'total_trades' => $totalTrades,
                                'winning_trades' => $winningTrades,
                                'profit_percentage' => round($profitPercentage, 2),
                                'last_profit' => $now,
                                'updated_at' => $now,
                            ]);

                        // Record transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => "Copy Trading - {$copyTrade->name}",
                            'amount' => $profit,
                            'type' => "Copy Trading Profit",
                            'leverage' => $profitResult['percentage'],
                            'status' => 'Processed',
                        ]);

                        // Create in-app notification for copy trading profit
                        $this->createUserNotification(
                            $user->id,
                            'Copy Trading Profit',
                            "Your copy trading with {$copyTrade->name} has generated a profit of {$user->currency}{$profit} ({$profitResult['percentage']}%).",
                            'success',
                            $copyTrade->id,
                            'User_copytradings'
                        );

                        // Send profit notification if enabled
                        if ($user->sendroiemail == 'Yes') {
                            try {
                                $message = "Great news! Your copy trading with {$copyTrade->name} has generated a profit of {$user->currency}{$profit}. Current balance: {$user->currency}{$newBalance}";
                                $subject = "Copy Trading Profit - {$copyTrade->name}";
                                //Mail::to($user->email)->send(new NewNotification($message, $subject, $user->name));
                            } catch (\Exception $e) {
                                \Log::error('Failed to send copy trading profit email: ' . $e->getMessage());
                            }
                        }
                    } else if ($profitResult['result'] == 'LOSS') {
                        // Handle losses
                        $loss = $profitResult['amount'];
                        $currentBalance = $copyTrade->current_balance ?? $copyTrade->price;
                        $newBalance = max(0, $currentBalance - $loss);
                        $totalProfit = ($copyTrade->total_profit ?? 0) - $loss;
                        $totalTrades = ($copyTrade->total_trades ?? 0) + 1;
                        $profitPercentage = (($newBalance - $copyTrade->price) / $copyTrade->price) * 100;

                        // Update copy trading record with loss data
                        User_copytradings::where('id', $copyTrade->id)
                            ->update([
                                'current_balance' => $newBalance,
                                'total_profit' => $totalProfit,
                                'total_trades' => $totalTrades,
                                'profit_percentage' => round($profitPercentage, 2),
                                'last_profit' => $now,
                                'updated_at' => $now,
                            ]);

                        // Record loss transaction
                        Tp_Transaction::create([
                            'user' => $user->id,
                            'plan' => "Copy Trading - {$copyTrade->name}",
                            'amount' => $loss,
                            'type' => "Copy Trading Loss",
                            'leverage' => $profitResult['percentage'],
                            'status' => 'Processed',
                        ]);
                    }
                }
            }
        }
    }

        /**
     * Calculate copy trading profit based on expert performance simulation
     * @param User_copytradings $copyTrade
     * @return array
     */
    private function calculateCopyTradingProfit($copyTrade)
    {
        // Get expert from copytrading table or use default win rate
        $expert = null;
        if (isset($copyTrade->cptrading)) {
            $expert = \App\Models\Copytrading::find($copyTrade->cptrading);
        }

        // Use expert's win rate or default to 75%
        $winRate = $expert ? $expert->win_rate : 75;
        $isProfit = rand(1, 100) <= $winRate;

        if ($isProfit) {
            // Profit: 0.5% to 4% of current balance
            $profitPercentage = rand(50, 400) / 100;
            $currentBalance = $copyTrade->current_balance ?? $copyTrade->price;
            $profitAmount = ($currentBalance * $profitPercentage) / 100;

            return [
                'result' => 'PROFIT',
                'amount' => round($profitAmount, 2),
                'percentage' => round($profitPercentage, 2)
            ];
        } else {
            // Loss: 0.2% to 2% of current balance
            $lossPercentage = rand(20, 200) / 100;
            $currentBalance = $copyTrade->current_balance ?? $copyTrade->price;
            $lossAmount = ($currentBalance * $lossPercentage) / 100;

            return [
                'result' => 'LOSS',
                'amount' => round($lossAmount, 2),
                'percentage' => round($lossPercentage, 2)
            ];
        }
    }

    /**
     * Calculate and distribute bot trading profits automatically
     */
    public function automaticBotTradingProfits()
    {
        $settings = \App\Models\Settings::find(1);

        if ($settings && $settings->trade_mode == 'on') {
            // Get all active bot investments
            $activeBotInvestments = \App\Models\UserBotInvestment::where('status', 'active')
                                                                ->where('expires_at', '>', now())
                                                                ->with(['user', 'bot'])
                                                                ->get();

            foreach ($activeBotInvestments as $investment) {
                // Check if it's time to generate profit
                if (!$investment->shouldGenerateProfit()) {
                    continue;
                }

                $user = $investment->user;
                $bot = $investment->bot;

                if (!$user || !$bot) {
                    continue;
                }

                // Generate trading result
                $tradingResult = $this->calculateBotTradingResult($investment);

                if ($tradingResult['result'] === 'PROFIT') {
                    $profit = $tradingResult['amount'];

                    // Update user account with profit
                    \App\Models\User::where('id', $user->id)->update([
                        'roi' => $user->roi + $profit,
                        'account_bal' => $user->account_bal + $profit,
                    ]);

                    // Update bot investment record
                    $investment->update([
                        'current_balance' => $investment->current_balance + $profit,
                        'total_profit' => $investment->total_profit + $profit,
                        'successful_trades' => $investment->successful_trades + 1,
                        'last_profit_at' => now(),
                    ]);

                    // Create trading history record
                    \App\Models\BotTradingHistory::create([
                        'user_bot_investment_id' => $investment->id,
                        'trade_type' => $tradingResult['trade_type'],
                        'trading_pair' => $tradingResult['trading_pair'],
                        'entry_price' => $tradingResult['entry_price'],
                        'exit_price' => $tradingResult['exit_price'],
                        'amount' => $investment->current_balance * 0.1, // 10% of balance per trade
                        'profit_loss' => $profit,
                        'profit_percentage' => $tradingResult['percentage'],
                        'result' => 'profit',
                        'strategy_used' => $tradingResult['strategy'],
                        'opened_at' => now()->subMinutes(rand(15, 180)), // Random trade duration
                        'closed_at' => now(),
                    ]);

                    // Record transaction
                    \App\Models\Tp_Transaction::create([
                        'user' => $user->id,
                        'plan' => "Bot Trading Profit - {$bot->name}",
                        'amount' => $profit,
                        'type' => "Bot Trading Profit",
                        'leverage' => $tradingResult['percentage'],
                    ]);

                    // Create in-app notification for bot trading profit
                    $this->createUserNotification(
                        $user->id,
                        'Bot Trading Profit',
                        "Your {$bot->name} trading bot has generated a profit of {$user->currency}{$profit} using {$tradingResult['strategy']} strategy on {$tradingResult['trading_pair']}.",
                        'success',
                        $investment->id,
                        'UserBotInvestment'
                    );

                    // Send profit notification if enabled
                    if ($user->sendroiemail == 'Yes') {
                        try {
                            $message = "Your {$bot->name} trading bot has generated a profit of \${$profit}. Keep investing and earning!";
                            $subject = "Bot Trading Profit Earned";
                            \Mail::to($user->email)->send(new \App\Mail\NewNotification($message, $subject, $user->name));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send bot trading profit email: ' . $e->getMessage());
                        }
                    }

                } elseif ($tradingResult['result'] === 'LOSS') {
                    $loss = $tradingResult['amount'];

                    // Update bot investment record (loss)
                    $investment->update([
                        'current_balance' => max(0, $investment->current_balance - $loss),
                        'total_loss' => $investment->total_loss + $loss,
                        'failed_trades' => $investment->failed_trades + 1,
                        'last_profit_at' => now(),
                    ]);

                    // Create trading history record
                    \App\Models\BotTradingHistory::create([
                        'user_bot_investment_id' => $investment->id,
                        'trade_type' => $tradingResult['trade_type'],
                        'trading_pair' => $tradingResult['trading_pair'],
                        'entry_price' => $tradingResult['entry_price'],
                        'exit_price' => $tradingResult['exit_price'],
                        'amount' => $investment->current_balance * 0.1,
                        'profit_loss' => -$loss,
                        'profit_percentage' => -$tradingResult['percentage'],
                        'result' => 'loss',
                        'strategy_used' => $tradingResult['strategy'],
                        'opened_at' => now()->subMinutes(rand(15, 180)),
                        'closed_at' => now(),
                    ]);

                    // Create in-app notification for bot trading loss (only for significant losses)
                    if ($tradingResult['percentage'] > 1.0) {
                        $this->createUserNotification(
                            $user->id,
                            'Bot Trading Alert',
                            "Your {$bot->name} bot had a trade loss of {$tradingResult['percentage']}% on {$tradingResult['trading_pair']}. The system has automatically adjusted the strategy.",
                            'warning',
                            $investment->id,
                            'UserBotInvestment'
                        );
                    }
                }

                // Update bot statistics
                $bot->update([
                    'last_trade' => now(),
                    'total_earned' => $bot->total_earned + ($tradingResult['result'] === 'PROFIT' ? $profit : 0),
                ]);
            }

            // Check for expired investments
            $expiredInvestments = \App\Models\UserBotInvestment::where('status', 'active')
                                                               ->where('expires_at', '<=', now())
                                                               ->with(['user', 'bot'])
                                                               ->get();

            foreach ($expiredInvestments as $investment) {
                $user = $investment->user;
                $bot = $investment->bot;

                if (!$user || !$bot) {
                    continue;
                }

                // Return remaining balance to user
                if ($investment->current_balance > 0) {
                    \App\Models\User::where('id', $user->id)->update([
                        'account_bal' => $user->account_bal + $investment->current_balance,
                    ]);

                    // Record transaction
                    \App\Models\Tp_Transaction::create([
                        'user' => $user->id,
                        'plan' => "Bot Investment Completed - {$bot->name}",
                        'amount' => $investment->current_balance,
                        'type' => "Bot Investment Return",
                        'status' => 'Processed',
                    ]);
                }

                // Update investment status
                $investment->update(['status' => 'completed']);

                // Calculate totals for notifications
                $totalReturn = $investment->current_balance;
                $totalProfit = $investment->total_profit - $investment->total_loss;
                $profitPercent = $investment->initial_balance > 0 ?
                    round(($totalProfit / $investment->initial_balance) * 100, 2) : 0;

                // Create in-app notification for completed bot investment
                $notificationType = $totalProfit > 0 ? 'success' : 'info';
                $this->createUserNotification(
                    $user->id,
                    'Bot Investment Completed',
                    "Your {$bot->name} bot investment has completed with a " .
                    ($totalProfit > 0 ? "profit of {$user->currency}{$totalProfit} ({$profitPercent}%)" : "final balance of {$user->currency}{$totalReturn}") .
                    ". The funds have been credited to your account balance.",
                    $notificationType,
                    $investment->id,
                    'UserBotInvestment'
                );

                // Send completion notification
                if ($user->sendroiemail == 'Yes') {
                    try {
                        $message = "Your {$bot->name} bot investment has completed. Total return: \${$totalReturn}, Net profit: \${$totalProfit}";
                        $subject = "Bot Investment Completed";
                        \Mail::to($user->email)->send(new \App\Mail\NewNotification($message, $subject, $user->name));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send bot completion email: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * Calculate bot trading result with realistic market simulation
     */
    private function calculateBotTradingResult($investment)
    {
        $bot = $investment->bot;

        // Bot trading has higher success rate than manual trading
        $successRate = $bot->success_rate ?? 80;
        $isProfit = rand(1, 100) <= $successRate;

        // Get random trading pair from bot's supported pairs
        $tradingPairs = $bot->trading_pairs ?? ['EUR/USD', 'GBP/USD', 'BTC/USD'];
        $tradingPair = $tradingPairs[array_rand($tradingPairs)];

        // Generate realistic entry and exit prices
        $basePrice = $this->getBasePriceForPair($tradingPair);
        $entryPrice = $basePrice * (1 + (rand(-100, 100) / 10000)); // ±1% variation

        $tradeType = rand(0, 1) ? 'BUY' : 'SELL';

        if ($isProfit) {
            // Profitable trade
            $profitPercentage = rand((int)($bot->daily_profit_min * 100), (int)($bot->daily_profit_max * 100)) / 100;
            $profitAmount = ($investment->current_balance * $profitPercentage) / 100;

            $exitPrice = $tradeType === 'BUY'
                ? $entryPrice * (1 + $profitPercentage / 100)
                : $entryPrice * (1 - $profitPercentage / 100);

            return [
                'result' => 'PROFIT',
                'amount' => round($profitAmount, 2),
                'percentage' => round($profitPercentage, 2),
                'trade_type' => $tradeType,
                'trading_pair' => $tradingPair,
                'entry_price' => round($entryPrice, 5),
                'exit_price' => round($exitPrice, 5),
                'strategy' => $this->getRandomStrategy($bot),
            ];
        } else {
            // Loss trade (smaller losses to maintain profitability)
            $lossPercentage = rand(50, 200) / 100; // 0.5% - 2% loss
            $lossAmount = ($investment->current_balance * $lossPercentage) / 100;

            $exitPrice = $tradeType === 'BUY'
                ? $entryPrice * (1 - $lossPercentage / 100)
                : $entryPrice * (1 + $lossPercentage / 100);

            return [
                'result' => 'LOSS',
                'amount' => round($lossAmount, 2),
                'percentage' => round($lossPercentage, 2),
                'trade_type' => $tradeType,
                'trading_pair' => $tradingPair,
                'entry_price' => round($entryPrice, 5),
                'exit_price' => round($exitPrice, 5),
                'strategy' => $this->getRandomStrategy($bot),
            ];
        }
    }

    /**
     * Get base price for trading pair
     */
    private function getBasePriceForPair($pair)
    {
        $basePrices = [
            'EUR/USD' => 1.0850,
            'GBP/USD' => 1.2650,
            'USD/JPY' => 149.50,
            'USD/CHF' => 0.8950,
            'AUD/USD' => 0.6750,
            'USD/CAD' => 1.3450,
            'BTC/USD' => 43500.00,
            'ETH/USD' => 2650.00,
            'BNB/USD' => 315.00,
            'ADA/USD' => 0.485,
            'SOL/USD' => 98.50,
            'DOT/USD' => 7.25,
            'AAPL' => 195.50,
            'GOOGL' => 2850.00,
            'MSFT' => 415.00,
            'AMZN' => 3250.00,
            'TSLA' => 248.50,
            'META' => 485.00,
            'GOLD' => 2025.50,
            'SILVER' => 24.85,
            'OIL' => 78.50,
            'COPPER' => 3.85,
            'WHEAT' => 6.45,
            'NATURAL_GAS' => 2.95,
            'S&P500' => 4785.50,
            'NASDAQ' => 15250.00,
            'DOW' => 37850.00,
            'FTSE' => 7650.00,
            'DAX' => 16850.00,
            'NIKKEI' => 33250.00,
        ];

        return $basePrices[$pair] ?? 1.0000;
    }

    /**
     * Get random trading strategy
     */
    private function getRandomStrategy($bot)
    {
        $strategies = [
            'Trend Following',
            'Scalping',
            'Momentum Trading',
            'Mean Reversion',
            'Breakout Strategy',
            'Support & Resistance',
            'RSI Divergence',
            'MACD Crossover',
            'Moving Average Strategy',
            'Fibonacci Retracement',
        ];

        return $strategies[array_rand($strategies)];
    }

    /**
     * Automatically update demo trading prices and handle trade lifecycles
     */
    public function automaticDemoTradingUpdates()
    {
        // Get all active demo trades
        $activeDemoTrades = \App\Models\DemoTrade::where('active', 'yes')->with('user')->get();
        $now = now();

        foreach ($activeDemoTrades as $trade) {
            if (!$trade->user) continue;

            // First check if trade has expired
            if ($this->checkDemoTradeExpired($trade, $now)) {
                continue; // Skip to next trade as this one is now closed
            }

            // Update current price with realistic market simulation
            $this->updateDemoTradePrice($trade);

            // Check if trade should be auto-closed for other reasons
            $this->checkDemoTradeAutoClose($trade, $now);
        }
    }

    /**
     * Update demo trade current price with market simulation
     */
    private function updateDemoTradePrice($trade)
    {
        // Skip if no entry price set
        if (!$trade->entry_price) {
            return;
        }

        // Calculate realistic price movement based on asset type
        $priceMovement = $this->calculatePriceMovement($trade->assets);

        // Apply movement to current price (or entry price if no current price set)
        $basePrice = $trade->current_price ?: $trade->entry_price;
        $newPrice = $basePrice * (1 + $priceMovement);

        // Update the demo trade with new price and last growth timestamp
        \App\Models\DemoTrade::where('id', $trade->id)->update([
            'current_price' => round($newPrice, 8),
            'last_growth' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Check if demo trade has expired based on user-selected expiration time
     */
    private function checkDemoTradeExpired($trade, $now)
    {
        // Check if trade has an expiration date and if it has passed
        if ($trade->expire_date && $now->gte($trade->expire_date)) {
            $this->expireDemoTrade($trade);
            return true;
        }

        return false;
    }

    /**
     * Calculate realistic price movement for different assets based on instrument data
     */
    private function calculatePriceMovement($asset)
    {
        // Try to get the instrument from database to determine asset type
        $instrument = \App\Models\Instrument::where('symbol', $asset)
            ->orWhere('name', $asset)
            ->first();

        // Define volatility ranges by asset type and specific symbols
        $volatilityRanges = [
            // Specific crypto assets
            'BTC/USD' => [-0.05, 0.05],    // ±5%
            'ETH/USD' => [-0.06, 0.06],    // ±6%
            'BNB/USD' => [-0.07, 0.07],    // ±7%
            'SOL/USD' => [-0.08, 0.08],    // ±8%
            'ADA/USD' => [-0.08, 0.08],    // ±8%

            // Specific stock symbols
            'AAPL' => [-0.03, 0.03],       // ±3%
            'GOOGL' => [-0.035, 0.035],    // ±3.5%
            'MSFT' => [-0.025, 0.025],     // ±2.5%
            'TSLA' => [-0.06, 0.06],       // ±6%
            'NVDA' => [-0.05, 0.05],       // ±5%

            // Specific forex pairs
            'EUR/USD' => [-0.015, 0.015],  // ±1.5%
            'GBP/USD' => [-0.02, 0.02],    // ±2%
            'USD/JPY' => [-0.015, 0.015],  // ±1.5%

            // Specific commodities
            'GOLD' => [-0.025, 0.025],     // ±2.5%
            'SILVER' => [-0.03, 0.03],     // ±3%
            'OIL' => [-0.04, 0.04],        // ±4%

            // Bonds
            'US10Y' => [-0.005, 0.005],    // ±0.5%
            'US30Y' => [-0.005, 0.005],    // ±0.5%
        ];

        // First, try exact symbol match
        if (isset($volatilityRanges[$asset])) {
            $range = $volatilityRanges[$asset];
        }
        // If instrument found, use type-based volatility
        else if ($instrument) {
            switch ($instrument->type) {
                case 'crypto':
                    $range = [-0.07, 0.07]; // ±7% for crypto
                    break;
                case 'stock':
                    $range = [-0.04, 0.04]; // ±4% for stocks
                    break;
                case 'forex':
                    $range = [-0.02, 0.02]; // ±2% for forex
                    break;
                case 'commodity':
                    $range = [-0.035, 0.035]; // ±3.5% for commodities
                    break;
                case 'bond':
                    $range = [-0.005, 0.005]; // ±0.5% for bonds
                    break;
                default:
                    $range = [-0.02, 0.02]; // ±2% default
            }
        }
        // Fallback: try to match by partial name
        else {
            // Check for crypto keywords
            if (stripos($asset, 'BTC') !== false || stripos($asset, 'bitcoin') !== false) {
                $range = [-0.05, 0.05];
            } elseif (stripos($asset, 'ETH') !== false || stripos($asset, 'ethereum') !== false) {
                $range = [-0.06, 0.06];
            } elseif (stripos($asset, 'BNB') !== false) {
                $range = [-0.07, 0.07];
            } elseif (stripos($asset, 'ADA') !== false || stripos($asset, 'cardano') !== false) {
                $range = [-0.08, 0.08];
            } elseif (stripos($asset, 'SOL') !== false || stripos($asset, 'solana') !== false) {
                $range = [-0.08, 0.08];
            }
            // Check for stock keywords
            elseif (stripos($asset, 'AAPL') !== false || stripos($asset, 'apple') !== false) {
                $range = [-0.03, 0.03];
            } elseif (stripos($asset, 'GOOGL') !== false || stripos($asset, 'google') !== false) {
                $range = [-0.035, 0.035];
            } elseif (stripos($asset, 'MSFT') !== false || stripos($asset, 'microsoft') !== false) {
                $range = [-0.025, 0.025];
            } elseif (stripos($asset, 'TSLA') !== false || stripos($asset, 'tesla') !== false) {
                $range = [-0.06, 0.06];
            } elseif (stripos($asset, 'NVDA') !== false || stripos($asset, 'nvidia') !== false) {
                $range = [-0.05, 0.05];
            }
            // Check for forex keywords
            elseif (stripos($asset, 'EUR') !== false || stripos($asset, 'USD') !== false || stripos($asset, 'GBP') !== false || stripos($asset, 'JPY') !== false) {
                $range = [-0.02, 0.02];
            }
            // Check for commodity keywords
            elseif (stripos($asset, 'GOLD') !== false || stripos($asset, 'gold') !== false) {
                $range = [-0.025, 0.025];
            } elseif (stripos($asset, 'SILVER') !== false || stripos($asset, 'silver') !== false) {
                $range = [-0.03, 0.03];
            } elseif (stripos($asset, 'OIL') !== false || stripos($asset, 'oil') !== false) {
                $range = [-0.04, 0.04];
            }
            // Default range
            else {
                $range = [-0.02, 0.02]; // ±2% default
            }
        }

        // Generate random movement within the range
        $minMovement = $range[0] * 100;
        $maxMovement = $range[1] * 100;
        $movement = rand($minMovement * 100, $maxMovement * 100) / 10000;

        return $movement;
    }

    /**
     * Check if demo trade should be automatically closed for extreme conditions
     */
    private function checkDemoTradeAutoClose($trade, $now)
    {
        $user = $trade->user;

        // Auto-close conditions (only for extreme cases, not normal expiration)
        $shouldClose = false;
        $closeReason = '';

        // 1. Check for extreme P&L (emergency stop loss / take profit)
        $currentPnL = $trade->calculatePnL();
        $pnlPercentage = ($currentPnL / $trade->amount) * 100;

        // Emergency auto close if loss exceeds 95% (extreme demo stop-loss)
        if ($pnlPercentage <= -95) {
            $shouldClose = true;
            $closeReason = 'Emergency Stop Loss (95% loss)';
        }

        // Emergency auto close if profit exceeds 1000% (extreme demo take-profit)
        elseif ($pnlPercentage >= 1000) {
            $shouldClose = true;
            $closeReason = 'Emergency Take Profit (1000% gain)';
        }

        // 2. Check for maximum trade duration (48 hours for demo safety)
        elseif ($trade->created_at->diffInHours($now) >= 48) {
            $shouldClose = true;
            $closeReason = 'Maximum safety duration reached (48 hours)';
        }

        if ($shouldClose) {
            $this->closeDemoTradeWithReason($trade, $closeReason);
        }
    }

    /**
     * Expire a demo trade when user-selected expiration time is reached
     */
    private function expireDemoTrade($trade)
    {
        // Get the user object by ID since the relationship might return just the ID
        $user = \App\Models\User::find($trade->user);

        if (!$user) {
            return; // Skip if user not found
        }

        // Ensure we have current price - if not, use entry price
        $currentPrice = $trade->current_price ?: $trade->entry_price;

        // Update current price one final time if needed
        if (!$trade->current_price) {
            \App\Models\DemoTrade::where('id', $trade->id)->update([
                'current_price' => $currentPrice,
            ]);
            // Refresh the trade object
            $trade->current_price = $currentPrice;
        }

        // Demo trading win rate: 65% win, 35% loss
        $randomOutcome = rand(1, 100);
        $isWin = $randomOutcome <= 65; // 65% chance to win

        // Calculate P&L based on win/loss outcome
        if ($isWin) {
            // WIN: Calculate profit using leverage and realistic price movement
            $profitPercent = rand(50, 800) / 10000; // 0.5% to 8% base profit
            $leverage = floatval($trade->leverage ?? 1);

            // Apply leverage to profit calculation
            $leveragedProfitPercent = $profitPercent * $leverage;

            // Cap maximum profit at reasonable levels based on leverage
            if ($leverage >= 10) {
                $leveragedProfitPercent = min($leveragedProfitPercent, 0.5); // Max 50% profit for high leverage
            } elseif ($leverage >= 5) {
                $leveragedProfitPercent = min($leveragedProfitPercent, 0.3); // Max 30% profit for medium leverage
            } else {
                $leveragedProfitPercent = min($leveragedProfitPercent, 0.2); // Max 20% profit for low leverage
            }

            $finalPnL = $trade->amount * $leveragedProfitPercent;

        } else {
            // LOSE: Calculate loss using leverage with stop-loss protection
            $lossPercent = rand(30, 400) / 10000; // 0.3% to 4% base loss
            $leverage = floatval($trade->leverage ?? 1);

            // Apply leverage to loss calculation but with protection
            $leveragedLossPercent = $lossPercent * $leverage;

            // Implement stop-loss protection - higher leverage = higher max loss but capped
            if ($leverage >= 20) {
                $leveragedLossPercent = min($leveragedLossPercent, 0.8); // Max 80% loss for very high leverage
            } elseif ($leverage >= 10) {
                $leveragedLossPercent = min($leveragedLossPercent, 0.6); // Max 60% loss for high leverage
            } elseif ($leverage >= 5) {
                $leveragedLossPercent = min($leveragedLossPercent, 0.4); // Max 40% loss for medium leverage
            } else {
                $leveragedLossPercent = min($leveragedLossPercent, 0.25); // Max 25% loss for low leverage
            }

            $finalPnL = -($trade->amount * $leveragedLossPercent);
        }

        // Update user demo balance with both original investment and profit/loss
        $totalReturn = $trade->amount + $finalPnL; // Original investment + P&L
        $newDemoBalance = $user->demo_balance + $totalReturn;

        \App\Models\User::where('id', $user->id)->update([
            'demo_balance' => max(0, $newDemoBalance), // Prevent negative balance
        ]);

        // Close the trade with calculated results
        \App\Models\DemoTrade::where('id', $trade->id)->update([
            'active' => 'expired',
            'result_type' => $isWin ? 'WIN' : 'LOSE',
            'profit_earned' => round($finalPnL, 8),
            'updated_at' => now(),
        ]);

        // Create transaction records for both investment return and profit/loss
        // 1. Return original investment
        \App\Models\Tp_Transaction::create([
            'user' => $user->id,
            'plan' => "Demo Trade - {$trade->assets}",
            'amount' => $trade->amount,
            'type' => 'Demo Investment Return',
            'status' => 'Processed',
        ]);

        // 2. Record profit/loss if any
        if ($finalPnL != 0) {
            \App\Models\Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Demo Trade - {$trade->assets}",
                'amount' => $finalPnL,
                'type' => $isWin ? 'Demo Profit' : 'Demo Loss',
                'status' => 'Processed',
            ]);
        }

        // Create notification
        $resultType = $isWin ? 'profit' : 'loss';
        $resultAmount = abs($finalPnL);
        $notificationType = $isWin ? 'success' : 'warning';

        $leverage = $trade->leverage ?? 1;
        $duration = $trade->inv_duration ?? 'Unknown';

        $this->createUserNotification(
            $user->id,
            'Demo Trade Completed',
            "Your {$duration} demo trade for {$trade->assets} (Leverage: {$leverage}x) has expired. Investment returned: \${$trade->amount}, {$resultType}: \${$resultAmount}. Total received: \${$totalReturn}. Your new demo balance is \${$newDemoBalance}.",
            $notificationType,
            $trade->id,
            'DemoTrade'
        );
    }

    /**
     * Close a demo trade for emergency reasons (extreme P&L or duration)
     */
    private function closeDemoTradeWithReason($trade, $reason)
    {
        // Get the user object by ID since the relationship might return just the ID
        $user = \App\Models\User::find($trade->user);

        if (!$user) {
            return; // Skip if user not found
        }
        $finalPnL = $trade->calculatePnL();
        $totalReturn = $trade->amount + $finalPnL; // Original investment + P&L

        // Update user demo balance with both original investment and profit/loss
        $newDemoBalance = $user->demo_balance + $totalReturn;
        \App\Models\User::where('id', $user->id)->update([
            'demo_balance' => max(0, $newDemoBalance), // Prevent negative balance
        ]);

        // Close the trade
        \App\Models\DemoTrade::where('id', $trade->id)->update([
            'active' => 'expired',
            'result_type' => $finalPnL >= 0 ? 'WIN' : 'LOSE',
            'profit_earned' => $finalPnL,
            'updated_at' => now(),
        ]);

        // Create transaction records for both investment return and profit/loss
        // 1. Return original investment
        \App\Models\Tp_Transaction::create([
            'user' => $user->id,
            'plan' => "Demo Trade - {$trade->assets}",
            'amount' => $trade->amount,
            'type' => 'Demo Investment Return',
            'status' => 'Processed',
        ]);

        // 2. Record profit/loss if any
        if ($finalPnL != 0) {
            \App\Models\Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Demo Trade - {$trade->assets}",
                'amount' => $finalPnL,
                'type' => $finalPnL >= 0 ? 'Demo Profit' : 'Demo Loss',
                'status' => 'Processed',
            ]);
        }

        // Create notification
        $resultType = $finalPnL >= 0 ? 'profit' : 'loss';
        $resultAmount = abs($finalPnL);
        $notificationType = $finalPnL >= 0 ? 'success' : 'warning';

        $this->createUserNotification(
            $user->id,
            'Demo Trade Auto-Closed',
            "Your demo trade for {$trade->assets} has been automatically closed. Investment returned: \${$trade->amount}, {$resultType}: \${$resultAmount}. Total received: \${$totalReturn}. Reason: {$reason}",
            $notificationType,
            $trade->id,
            'DemoTrade'
        );
    }
}
