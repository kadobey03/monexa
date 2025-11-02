<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\AdminGroup;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SalesAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sales admin groups
        $salesGroups = AdminGroup::whereIn('name', [
            'sales_main', 'sales_team_a', 'sales_team_b'
        ])->get();
        
        // Get sales role (assuming there's a sales role, otherwise create one)
        $salesRole = Role::firstOrCreate([
            'name' => 'Sales Agent'
        ], [
            'display_name' => 'Sales Agent',
            'description' => 'Sales team member with lead management permissions',
            'is_active' => true
        ]);

        // Create 10 sales admins
        $salesAdmins = [
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 1',
                'email' => 'sale1@monexa.com',
                'password' => 'sale1',
                'group' => 'sales_main'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 2', 
                'email' => 'sale2@monexa.com',
                'password' => 'Sale2',
                'group' => 'sales_main'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 3',
                'email' => 'sale3@monexa.com', 
                'password' => 'sale3',
                'group' => 'sales_team_a'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 4',
                'email' => 'sale4@monexa.com',
                'password' => 'Sale4',
                'group' => 'sales_team_a'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 5',
                'email' => 'sale5@monexa.com',
                'password' => 'sale5', 
                'group' => 'sales_team_a'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 6',
                'email' => 'sale6@monexa.com',
                'password' => 'Sale6',
                'group' => 'sales_team_b'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 7',
                'email' => 'sale7@monexa.com',
                'password' => 'sale7',
                'group' => 'sales_team_b'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 8',
                'email' => 'sale8@monexa.com',
                'password' => 'Sale8',
                'group' => 'sales_team_b'
            ],
            [
                'firstName' => 'Sales',
                'lastName' => 'Agent 9',
                'email' => 'sale9@monexa.com',
                'password' => 'sale9',
                'group' => 'sales_main'
            ],
            [
                'firstName' => 'Sales', 
                'lastName' => 'Agent 10',
                'email' => 'sale10@monexa.com',
                'password' => 'Sale10',
                'group' => 'sales_main'
            ]
        ];

        foreach ($salesAdmins as $adminData) {
            $group = $salesGroups->where('name', $adminData['group'])->first();
            
            if (!$group) {
                echo "Warning: Admin group {$adminData['group']} not found, using sales_main\n";
                $group = $salesGroups->where('name', 'sales_main')->first();
            }

            Admin::updateOrCreate([
                'email' => $adminData['email']
            ], [
                'firstName' => $adminData['firstName'],
                'lastName' => $adminData['lastName'],
                'password' => Hash::make($adminData['password']),
                'role_id' => $salesRole->id,
                'admin_group_id' => $group ? $group->id : null,
                'department' => 'Sales',
                'is_available' => true,
                'status' => 'active',
                'hierarchy_level' => 2, // Junior sales level
                'leads_assigned_count' => 0,
                'leads_converted_count' => 0,
                'monthly_target' => 50, // 50 leads per month target
                'current_performance' => 0,
                'last_login_at' => now(),
                'last_activity' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            echo "Created sales admin: {$adminData['email']} (Password: {$adminData['password']}) in group: {$adminData['group']}\n";
        }

        echo "\n✅ Successfully created 10 sales admins!\n";
        echo "Login credentials:\n";
        echo "- sale1@monexa.com / sale1\n";
        echo "- sale2@monexa.com / Sale2\n"; 
        echo "- sale3@monexa.com / sale3\n";
        echo "- sale4@monexa.com / Sale4\n";
        echo "- sale5@monexa.com / sale5\n";
        echo "- sale6@monexa.com / Sale6\n";
        echo "- sale7@monexa.com / sale7\n";
        echo "- sale8@monexa.com / Sale8\n";
        echo "- sale9@monexa.com / sale9\n";
        echo "- sale10@monexa.com / Sale10\n";
    }
}