<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Trading Platform',
                'site_title' => 'Trading Platform - Your Investment Partner',
                'description' => 'Professional trading platform for investments',
                'currency' => 'USD',
                'scurrency' => '$',
                'contact_email' => 'admin@tradingplatform.com',
                'referral_commission' => '10',
                'referral_commission1' => '5',
                'referral_commission2' => '3',
                'referral_commission3' => '2',
                'referral_commission4' => '1',
                'referral_commission5' => '1',
                'signup_bonus' => '0',
                'trade_mode' => 'on',
                'weekend_trade' => 'on',
                'enable_2fa' => 'no',
                'enable_kyc' => 'no',
                'enable_verification' => 'true',
                'withdrawal_option' => 'auto',
                'dashboard_option' => 'dark',
                'site_preference' => 'user',
                'enable_annoc' => 'no',
                'commission_type' => 'percentage',
                'commission_fee' => '5',
                'monthlyfee' => '0',
                'quarterlyfee' => '0',
                'yearlyfee' => '0',
                'google_translate' => 'no',
                'captcha' => 'no',
                'enable_with' => 'yes',
                'location' => 'Global',
                'site_address' => '123 Trading Street, Finance City',
                'keywords' => 'trading, investment, forex, crypto, stocks',
            ]
        );
    }
}