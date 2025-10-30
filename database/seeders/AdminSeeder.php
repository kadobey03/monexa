<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create super admin user
        $admin = Admin::create([
            'firstName' => 'Super',
            'lastName' => 'Admin',
            'email' => 'admin@monexa.com',
            'password' => Hash::make('admin123456'),
            'phone' => '+90 555 123 4567',
            'status' => Admin::STATUS_ACTIVE,
            'type' => Admin::TYPE_ADMIN,
            'department' => 'Management',
            'position' => 'System Administrator',
            'hierarchy_level' => 1,
            'is_available' => true,
            'current_performance' => 0.00,
            'leads_assigned_count' => 0,
            'leads_converted_count' => 0,
            'time_zone' => 'Europe/Istanbul',
            'language' => 'tr',
            'two_factor_enabled' => false,
            'dashboard_style' => 'default'
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: admin@monexa.com');
        $this->command->info('Password: admin123456');
        
        return $admin;
    }
}