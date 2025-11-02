<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ComprehensiveSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('tr_TR');
        $now = Carbon::now();
        
        $this->command->info('🌱 Comprehensive seeding başlatılıyor...');
        
        // Settings
        $this->seedSettings($now);
        
        // Skip Users - already 292 users exist
        $this->command->info('ℹ️  Users skipped - 292 users already exist');
        
        // Skip Plans - already exist
        $this->command->info('ℹ️  Plans skipped - already exist');
        
        // Skip Investments - already exist
        $this->command->info('ℹ️  Investments skipped - already exist');
        
        // Deposits & Withdrawals
        $this->seedDepositsWithdrawals($faker, $now);
        
        // Trading Bots
        $this->seedTradingBots($faker, $now);
        
        // Copy Trading
        $this->seedCopyTrading($faker, $now);
        
        // Signals
        $this->seedSignals($faker, $now);
        
        // Instruments & Trades
        $this->seedInstrumentsAndTrades($faker, $now);
        
        // Notifications
        $this->seedNotifications($faker, $now);
        
        // KYC Applications
        $this->seedKyc($faker, $now);
        
        $this->command->info('✅ Comprehensive seeding tamamlandı!');
    }
    
    private function seedSettings($now): void
    {
        $settings = [
            'site_name' => 'Monexa Finans',
            'site_title' => 'Profesyonel Trading Platformu - Monexa Finans',
            'description' => 'Güvenli ve profesyonel trading deneyimi sunan platform',
            'currency' => 'USD',
            's_currency' => '$',
            'contact_email' => 'info@monexafinans.com',
            'withdrawal_option' => 'manual',
            'deposit_option' => 'manual',
            'referral_commission' => '10',
            'referral_commission1' => '5',
            'referral_commission2' => '3',
            'referral_commission3' => '2',
            'signup_bonus' => '100',
            'site_address' => 'https://monexafinans.com',
            'location' => 'İstanbul, Türkiye',
            'enable_2fa' => 'no',
            'enable_kyc' => 'yes',
            'enable_verification' => 'true',
            'welcome_message' => 'Monexa Finans\'a Hoş Geldiniz - Profesyonel Trading Platformu',
            'updated_at' => $now,
        ];

        DB::table('settings')->updateOrInsert(['id' => 1], $settings);
        $this->command->info('✅ Settings updated');
    }
    
    private function seedUsers($faker, $now): void
    {
        $users = [];
        $adminIds = [100, 101, 102, 103, 104, 105, 106, 107, 108, 109];
        
        // Lead Users (potansiyel müşteriler)
        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->email(),
                'password' => Hash::make('password'),
                'phone' => $faker->phoneNumber(),
                'country' => $faker->randomElement(['Turkey', 'Germany', 'France', 'UK', 'USA']),
                'account_bal' => $faker->numberBetween(0, 5000),
                'demo_balance' => $faker->randomFloat(2, 50000, 150000),
                'status' => $faker->randomElement(['active', 'blocked', 'pending']),
                'account_type' => 'lead',
                'lead_source' => $faker->randomElement(['website', 'facebook', 'google', 'referral', 'cold_call']),
                'lead_score' => $faker->numberBetween(1, 100),
                'estimated_value' => $faker->randomFloat(2, 1000, 50000),
                'assigned_to_admin_id' => $faker->randomElement($adminIds),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $now,
            ];
        }
        
        // Customer Users (aktif müşteriler)
        for ($i = 1; $i <= 25; $i++) {
            $users[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->email(),
                'password' => Hash::make('password'),
                'phone' => $faker->phoneNumber(),
                'country' => $faker->randomElement(['Turkey', 'Germany', 'France', 'UK', 'USA']),
                'account_bal' => $faker->numberBetween(5000, 50000),
                'demo_balance' => $faker->randomFloat(2, 100000, 200000),
                'status' => 'active',
                'account_type' => 'customer',
                'account_verify' => 'verified',
                'assigned_to_admin_id' => $faker->randomElement($adminIds),
                'created_at' => $faker->dateTimeBetween('-6 months', '-1 month'),
                'updated_at' => $now,
            ];
        }
        
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
        
        $this->command->info('✅ 75 Users (50 leads + 25 customers) seeded');
    }
    
    private function seedPlans($now): void
    {
        $plans = [
            [
                'name' => 'Başlangıç Planı',
                'price' => '500',
                'min_price' => '500',
                'max_price' => '2500',
                'minr' => '8',
                'maxr' => '15',
                'expected_return' => '12',
                'type' => 'Daily',
                'expiration' => '7',
                'increment_interval' => '1',
                'increment_type' => 'Daily',
                'increment_amount' => '10',
                'gift' => '50',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Standart Plan',
                'price' => '2500',
                'min_price' => '2500',
                'max_price' => '10000',
                'minr' => '12',
                'maxr' => '20',
                'expected_return' => '16',
                'type' => 'Daily',
                'expiration' => '14',
                'increment_interval' => '1',
                'increment_type' => 'Daily',
                'increment_amount' => '15',
                'gift' => '100',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Premium Plan',
                'price' => '10000',
                'min_price' => '10000',
                'max_price' => '50000',
                'minr' => '18',
                'maxr' => '28',
                'expected_return' => '23',
                'type' => 'Daily',
                'expiration' => '30',
                'increment_interval' => '1',
                'increment_type' => 'Daily',
                'increment_amount' => '20',
                'gift' => '500',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        foreach ($plans as $plan) {
            DB::table('plans')->updateOrInsert(['name' => $plan['name']], $plan);
        }
        
        $this->command->info('✅ 3 Investment Plans seeded');
    }
    
    private function seedInvestments($faker, $now): void
    {
        $investments = [];
        $planIds = [1, 2, 3];
        $userIds = range(1, 75);
        
        for ($i = 1; $i <= 40; $i++) {
            $planId = $faker->randomElement($planIds);
            $amount = $faker->randomFloat(2, 500, 25000);
            $duration = $faker->numberBetween(7, 30);
            $createdAt = $faker->dateTimeBetween('-2 months', 'now');
            
            $investments[] = [
                'user' => $faker->randomElement($userIds),
                'plan' => $planId,
                'amount' => $amount,
                'active' => $faker->randomElement(['active', 'completed', 'cancelled']),
                'inv_duration' => $duration,
                'activated_at' => $createdAt,
                'expire_date' => date('Y-m-d H:i:s', strtotime($createdAt->format('Y-m-d H:i:s') . " +{$duration} days")),
                'last_growth' => $faker->dateTimeBetween($createdAt, 'now'),
                'created_at' => $createdAt,
                'updated_at' => $now,
            ];
        }
        
        foreach ($investments as $investment) {
            DB::table('investments')->insert($investment);
        }
        
        $this->command->info('✅ 40 Investments seeded');
    }
    
    private function seedDepositsWithdrawals($faker, $now): void
    {
        // Deposits
        $deposits = [];
        $userIds = range(1, 75);
        $planIds = [1, 2, 3];
        
        for ($i = 1; $i <= 60; $i++) {
            $userId = $faker->randomElement($userIds);
            $deposits[] = [
                'txn_id' => 'TXN' . $faker->unique()->numberBetween(100000, 999999),
                'user' => $userId,
                'uname' => $faker->userName(),
                'amount' => $faker->randomFloat(2, 100, 10000),
                'payment_mode' => $faker->randomElement(['bank_transfer', 'credit_card', 'crypto', 'paypal']),
                'plan' => $faker->randomElement($planIds),
                'status' => $faker->randomElement(['Processed', 'Pending', 'Cancelled']),
                'proof' => 'proof_' . $i . '.jpg',
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => $now,
            ];
        }
        
        foreach ($deposits as $deposit) {
            DB::table('deposits')->insert($deposit);
        }
        
        // Withdrawals
        $withdrawals = [];
        
        for ($i = 1; $i <= 30; $i++) {
            $userId = $faker->randomElement($userIds);
            $amount = $faker->randomFloat(2, 200, 5000);
            $withdrawals[] = [
                'txn_id' => 'WTX' . $faker->unique()->numberBetween(100000, 999999),
                'user' => $userId,
                'uname' => $faker->userName(),
                'amount' => $amount,
                'to_deduct' => $faker->randomFloat(2, 5, 50), // withdrawal fee
                'status' => $faker->randomElement(['Processed', 'Pending', 'Cancelled']),
                'payment_mode' => $faker->randomElement(['bank_transfer', 'crypto', 'paypal']),
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'updated_at' => $now,
            ];
        }
        
        foreach ($withdrawals as $withdrawal) {
            DB::table('withdrawals')->insert($withdrawal);
        }
        
        $this->command->info('✅ 60 Deposits + 30 Withdrawals seeded');
    }
    
    private function seedTradingBots($faker, $now): void
    {
        $bots = [
            [
                'name' => 'Forex Scalper Pro',
                'bot_type' => 'forex',
                'description' => 'Hızlı forex scalping stratejisi ile dakikalar içinde kar elde edin',
                'image' => 'bot1.jpg',
                'min_investment' => '1000.00',
                'max_investment' => '50000.00',
                'daily_profit_min' => '0.80',
                'daily_profit_max' => '2.50',
                'success_rate' => 87,
                'duration_days' => 30,
                'total_earned' => '125000.50',
                'total_users' => 156,
                'status' => 'active',
                'trading_pairs' => json_encode(['EURUSD', 'GBPUSD', 'USDJPY', 'AUDUSD']),
                'risk_settings' => json_encode(['max_daily_loss' => 5, 'stop_loss' => 1.5, 'take_profit' => 2.5]),
                'strategy_details' => json_encode(['type' => 'scalping', 'timeframe' => '1m', 'indicators' => ['RSI', 'MACD', 'EMA']]),
                'last_trade' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Crypto Trend Follower',
                'bot_type' => 'crypto',
                'description' => 'Kripto para trend takip botu ile güçlü trendleri yakalayın',
                'image' => 'bot2.jpg',
                'min_investment' => '500.00',
                'max_investment' => '25000.00',
                'daily_profit_min' => '1.20',
                'daily_profit_max' => '4.50',
                'success_rate' => 82,
                'duration_days' => 45,
                'total_earned' => '89750.25',
                'total_users' => 203,
                'status' => 'active',
                'trading_pairs' => json_encode(['BTCUSD', 'ETHUSD', 'ADAUSD', 'DOTUSD']),
                'risk_settings' => json_encode(['max_daily_loss' => 8, 'stop_loss' => 2.0, 'take_profit' => 4.0]),
                'strategy_details' => json_encode(['type' => 'trend_following', 'timeframe' => '15m', 'indicators' => ['MA', 'Bollinger', 'Volume']]),
                'last_trade' => $faker->dateTimeBetween('-2 hours', 'now'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Safe Harbor Bot',
                'bot_type' => 'commodities',
                'description' => 'Düşük riskli güvenli trading ile stabil gelir elde edin',
                'image' => 'bot3.jpg',
                'min_investment' => '2000.00',
                'max_investment' => '100000.00',
                'daily_profit_min' => '0.30',
                'daily_profit_max' => '1.20',
                'success_rate' => 95,
                'duration_days' => 60,
                'total_earned' => '67890.75',
                'total_users' => 89,
                'status' => 'active',
                'trading_pairs' => json_encode(['XAUUSD', 'XAGUSD', 'OILUSD', 'NATGAS']),
                'risk_settings' => json_encode(['max_daily_loss' => 3, 'stop_loss' => 1.0, 'take_profit' => 1.5]),
                'strategy_details' => json_encode(['type' => 'conservative', 'timeframe' => '1h', 'indicators' => ['SMA', 'RSI', 'Support_Resistance']]),
                'last_trade' => $faker->dateTimeBetween('-1 hour', 'now'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        foreach ($bots as $bot) {
            DB::table('trading_bots')->updateOrInsert(['name' => $bot['name']], $bot);
        }
        
        $this->command->info('✅ 3 Trading Bots seeded');
    }
    
    private function seedCopyTrading($faker, $now): void
    {
        $experts = [
            [
                'name' => 'Alex Thompson',
                'photo' => 'expert1.jpg',
                'rating' => 5,
                'followers' => 287,
                'equity' => '85750.50',
                'total_profit' => '125890.75',
                'status' => 'active',
                'description' => 'Profesyonel forex trader. 8 yıllık deneyim ile tutarlı kar elde eden uzman.',
                'win_rate' => 87,
                'total_trades' => 1245,
                'tag' => 'Forex Expert',
                'price' => '299.99',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maria Rodriguez',
                'photo' => 'expert2.jpg',
                'rating' => 5,
                'followers' => 156,
                'equity' => '67200.25',
                'total_profit' => '89650.30',
                'status' => 'active',
                'description' => 'Kripto para uzmanı. Swing trading stratejileri ile yüksek performans.',
                'win_rate' => 83,
                'total_trades' => 892,
                'tag' => 'Crypto Specialist',
                'price' => '399.99',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'James Wilson',
                'photo' => 'expert3.jpg',
                'rating' => 4,
                'followers' => 203,
                'equity' => '92100.80',
                'total_profit' => '156780.90',
                'status' => 'active',
                'description' => 'Commodities trading uzmanı. Altın ve petrol analizleri konusunda deneyimli.',
                'win_rate' => 91,
                'total_trades' => 678,
                'tag' => 'Commodities Pro',
                'price' => '249.99',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        foreach ($experts as $expert) {
            DB::table('copytradings')->updateOrInsert(['name' => $expert['name']], $expert);
        }
        
        $this->command->info('✅ Copy Trading Experts seeded');
    }
    
    private function seedSignals($faker, $now): void
    {
        $signals = [
            [
                'name' => 'VIP Forex Signals',
                'price' => '99.99',
                'type' => 'Monthly',
                'increment_amount' => '10',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Premium Crypto Signals',
                'price' => '149.99',
                'type' => 'Monthly',
                'increment_amount' => '15',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gold Trading Signals',
                'price' => '79.99',
                'type' => 'Weekly',
                'increment_amount' => '5',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Scalping Signals Pro',
                'price' => '199.99',
                'type' => 'Monthly',
                'increment_amount' => '20',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        foreach ($signals as $signal) {
            DB::table('signals')->updateOrInsert(['name' => $signal['name']], $signal);
        }
        
        $this->command->info('✅ Signal Services seeded');
    }
    
    private function seedInstrumentsAndTrades($faker, $now): void
    {
        // Market Instruments
        $instruments = [
            [
                'symbol' => 'EURUSD',
                'name' => 'Euro/US Dollar',
                'type' => 'forex',
                'open' => '1.0840',
                'high' => '1.0875',
                'low' => '1.0820',
                'close' => '1.0850',
                'price' => '1.0850',
                'percent_change_24h' => '0.12',
                'change' => '0.0010',
                'market_cap' => null,
                'volume' => '1250000000.00',
                'logo' => 'eurusd.png',
            ],
            [
                'symbol' => 'BTCUSD',
                'name' => 'Bitcoin/US Dollar',
                'type' => 'crypto',
                'open' => '67200.00',
                'high' => '68500.50',
                'low' => '66800.25',
                'close' => '67500.50',
                'price' => '67500.50',
                'percent_change_24h' => '0.45',
                'change' => '300.50',
                'market_cap' => '1325000000000.00',
                'volume' => '25000000000.00',
                'logo' => 'bitcoin.png',
            ],
            [
                'symbol' => 'XAUUSD',
                'name' => 'Gold/US Dollar',
                'type' => 'commodity',
                'open' => '2680.00',
                'high' => '2690.50',
                'low' => '2675.25',
                'close' => '2685.30',
                'price' => '2685.30',
                'percent_change_24h' => '0.20',
                'change' => '5.30',
                'market_cap' => null,
                'volume' => '850000000.00',
                'logo' => 'gold.png',
            ],
        ];
        
        foreach ($instruments as $instrument) {
            DB::table('instruments')->updateOrInsert(
                ['symbol' => $instrument['symbol']],
                array_merge($instrument, ['created_at' => $now, 'updated_at' => $now])
            );
        }
        
        $this->command->info('✅ Market Instruments seeded (skipped trades - table structure check needed)');
    }
    
    private function seedNotifications($faker, $now): void
    {
        $notifications = [];
        $userIds = range(1, 292);
        $adminIds = [100, 101, 102, 103, 104, 105, 106, 107, 108, 109];
        
        for ($i = 1; $i <= 50; $i++) {
            $notifications[] = [
                'user_id' => $faker->randomElement($userIds),
                'admin_id' => $faker->randomElement($adminIds),
                'title' => $faker->randomElement([
                    'Yatırım Onaylandı',
                    'Para Çekme İsteği',
                    'Yeni Trading Sinyali',
                    'Hesap Güncelleme',
                    'Bonus Eklendi'
                ]),
                'message' => $faker->sentence(10),
                'type' => $faker->randomElement(['investment', 'withdrawal', 'signal', 'account', 'bonus']),
                'is_read' => $faker->randomElement([0, 1]),
                'source_id' => $faker->numberBetween(1, 100),
                'source_type' => $faker->randomElement(['investment', 'deposit', 'withdrawal']),
                'created_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
                'updated_at' => $now,
            ];
        }
        
        foreach ($notifications as $notification) {
            DB::table('notifications')->insert($notification);
        }
        
        $this->command->info('✅ 50 Notifications seeded');
    }
    
    private function seedKyc($faker, $now): void
    {
        $kycs = [];
        $userIds = array_slice(range(1, 292), 0, 30); // İlk 30 kullanıcı için KYC
        
        // Mevcut kullanıcıların email adreslerini al
        $existingUsers = DB::table('users')->whereIn('id', $userIds)->pluck('email', 'id')->toArray();
        
        foreach ($userIds as $userId) {
            // Mevcut kullanıcının email'ini kullan, yoksa unique email üret
            $email = isset($existingUsers[$userId])
                ? $existingUsers[$userId]
                : 'kyc_user_' . $userId . '_' . $faker->unique()->numberBetween(1000, 9999) . '@test.com';
                
            $kyc = [
                'user_id' => $userId,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $email,
                'phone_number' => $faker->phoneNumber(),
                'dob' => $faker->date('Y-m-d', '-18 years'),
                'social_media' => '@' . $faker->userName(),
                'address' => $faker->address(),
                'city' => $faker->city(),
                'state' => $faker->randomElement(['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Gaziantep']),
                'country' => $faker->country(),
                'document_type' => $faker->randomElement(['passport', 'id_card', 'driving_license']),
                'frontimg' => 'kyc_front_' . $userId . '.jpg',
                'backimg' => 'kyc_back_' . $userId . '.jpg',
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => $now,
            ];
            
            // Duplicate hatalarını önlemek için updateOrInsert kullan
            DB::table('kycs')->updateOrInsert(['user_id' => $userId], $kyc);
        }
        
        $this->command->info('✅ 30 KYC Applications seeded (duplicate-safe)');
    }
}