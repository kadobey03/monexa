<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminGroup;

class AdminGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ana Satış Grubu
        AdminGroup::updateOrCreate(
            ['name' => 'sales_main'],
            [
                'display_name' => 'Ana Satış Grubu',
                'description' => 'Ana satış departmanı grubu',
                'department' => 'Sales',
                'is_active' => true,
                'max_members' => 20,
                'target_amount' => 100000.00,
                'region' => 'Turkey',
                'time_zone' => 'UTC+3',
                'working_hours' => [
                    'start' => '09:00',
                    'end' => '18:00',
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']
                ],
                'settings' => [
                    'auto_assign' => true,
                    'priority_level' => 'high'
                ]
            ]
        );

        // Premium Müşteriler Grubu
        AdminGroup::updateOrCreate(
            ['name' => 'premium_customers'],
            [
                'display_name' => 'Premium Müşteriler Grubu',
                'description' => 'Yüksek değerli müşteriler için özel grup',
                'department' => 'Sales',
                'is_active' => true,
                'max_members' => 10,
                'target_amount' => 250000.00,
                'region' => 'Europe',
                'time_zone' => 'UTC+3',
                'working_hours' => [
                    'start' => '08:00',
                    'end' => '20:00',
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
                ],
                'settings' => [
                    'auto_assign' => false,
                    'priority_level' => 'premium',
                    'response_time' => '1_hour'
                ]
            ]
        );

        // Müşteri Destek Grubu
        AdminGroup::updateOrCreate(
            ['name' => 'customer_support'],
            [
                'display_name' => 'Müşteri Destek Grubu',
                'description' => 'Müşteri destek ve teknik yardım grubu',
                'department' => 'Support',
                'is_active' => true,
                'max_members' => 15,
                'target_amount' => 50000.00,
                'region' => 'Turkey',
                'time_zone' => 'UTC+3',
                'working_hours' => [
                    'start' => '07:00',
                    'end' => '23:00',
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
                ],
                'settings' => [
                    'auto_assign' => true,
                    'priority_level' => 'medium',
                    '24_7_support' => false
                ]
            ]
        );

        // Yeni Müşteri Grubu
        AdminGroup::updateOrCreate(
            ['name' => 'new_customers'],
            [
                'display_name' => 'Yeni Müşteri Grubu',
                'description' => 'Yeni kayıt olan müşteriler için özel grup',
                'department' => 'Sales',
                'is_active' => true,
                'max_members' => 12,
                'target_amount' => 75000.00,
                'region' => 'Global',
                'time_zone' => 'UTC+3',
                'working_hours' => [
                    'start' => '09:00',
                    'end' => '17:00',
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']
                ],
                'settings' => [
                    'auto_assign' => true,
                    'priority_level' => 'high',
                    'welcome_call' => true
                ]
            ]
        );

        // VIP Müşteriler Grubu
        AdminGroup::updateOrCreate(
            ['name' => 'vip_customers'],
            [
                'display_name' => 'VIP Müşteriler Grubu',
                'description' => 'En yüksek değerli VIP müşteriler için özel grup',
                'department' => 'Sales',
                'is_active' => true,
                'max_members' => 5,
                'target_amount' => 500000.00,
                'region' => 'Global',
                'time_zone' => 'UTC+3',
                'working_hours' => [
                    'start' => '06:00',
                    'end' => '22:00',
                    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
                ],
                'settings' => [
                    'auto_assign' => false,
                    'priority_level' => 'vip',
                    'response_time' => '30_minutes',
                    'dedicated_manager' => true
                ]
            ]
        );
    }
}
