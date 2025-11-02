<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // user_view, admin_create, etc.
            $table->string('display_name'); // Gösterim adı
            $table->text('description')->nullable(); // Permission açıklaması
            $table->string('category'); // user, admin, role, lead, system, etc.
            $table->string('resource'); // users, admins, roles, leads, etc.
            $table->string('action'); // view, create, update, delete, assign, etc.
            $table->boolean('is_active')->default(true); // Aktif/pasif durumu
            $table->integer('priority')->default(0); // Permission önceliği
            $table->json('constraints')->nullable(); // İlave kısıtlamalar
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('name');
            $table->index('category');
            $table->index(['category', 'resource']);
            $table->index(['is_active', 'category']);
            $table->index('priority');
        });
        
        // Insert default permissions
        $permissions = [
            // USER PERMISSIONS
            [
                'name' => 'user_view',
                'display_name' => 'View Users',
                'description' => 'View user profiles and information',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'view',
                'priority' => 1,
            ],
            [
                'name' => 'user_create',
                'display_name' => 'Create Users',
                'description' => 'Create new user accounts',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'create',
                'priority' => 2,
            ],
            [
                'name' => 'user_update',
                'display_name' => 'Update Users',
                'description' => 'Update user profiles and information',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'update',
                'priority' => 3,
            ],
            [
                'name' => 'user_delete',
                'display_name' => 'Delete Users',
                'description' => 'Delete user accounts',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'delete',
                'priority' => 4,
            ],
            [
                'name' => 'user_assign',
                'display_name' => 'Assign Users',
                'description' => 'Assign users to teams or groups',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'assign',
                'priority' => 5,
            ],
            [
                'name' => 'user_bulk_assign',
                'display_name' => 'Bulk Assign Users',
                'description' => 'Bulk assign multiple users',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'bulk_assign',
                'priority' => 6,
            ],
            [
                'name' => 'user_export',
                'display_name' => 'Export Users',
                'description' => 'Export user data',
                'category' => 'user',
                'resource' => 'users',
                'action' => 'export',
                'priority' => 7,
            ],
            
            // ADMIN PERMISSIONS
            [
                'name' => 'admin_view_subordinates',
                'display_name' => 'View Subordinate Admins',
                'description' => 'View admins under hierarchy',
                'category' => 'admin',
                'resource' => 'admins',
                'action' => 'view_subordinates',
                'priority' => 10,
            ],
            [
                'name' => 'admin_create',
                'display_name' => 'Create Admins',
                'description' => 'Create new admin accounts',
                'category' => 'admin',
                'resource' => 'admins',
                'action' => 'create',
                'priority' => 11,
            ],
            [
                'name' => 'admin_update_subordinates',
                'display_name' => 'Update Subordinate Admins',
                'description' => 'Update subordinate admin information',
                'category' => 'admin',
                'resource' => 'admins',
                'action' => 'update_subordinates',
                'priority' => 12,
            ],
            [
                'name' => 'admin_delete_subordinates',
                'display_name' => 'Delete Subordinate Admins',
                'description' => 'Delete subordinate admin accounts',
                'category' => 'admin',
                'resource' => 'admins',
                'action' => 'delete_subordinates',
                'priority' => 13,
            ],
            [
                'name' => 'admin_view_all',
                'display_name' => 'View All Admins',
                'description' => 'View all admin accounts',
                'category' => 'admin',
                'resource' => 'admins',
                'action' => 'view_all',
                'priority' => 14,
            ],
            
            // ROLE PERMISSIONS
            [
                'name' => 'role_view',
                'display_name' => 'View Roles',
                'description' => 'View system roles',
                'category' => 'role',
                'resource' => 'roles',
                'action' => 'view',
                'priority' => 20,
            ],
            [
                'name' => 'role_create',
                'display_name' => 'Create Roles',
                'description' => 'Create new system roles',
                'category' => 'role',
                'resource' => 'roles',
                'action' => 'create',
                'priority' => 21,
            ],
            [
                'name' => 'role_update',
                'display_name' => 'Update Roles',
                'description' => 'Update system roles',
                'category' => 'role',
                'resource' => 'roles',
                'action' => 'update',
                'priority' => 22,
            ],
            [
                'name' => 'role_delete',
                'display_name' => 'Delete Roles',
                'description' => 'Delete system roles',
                'category' => 'role',
                'resource' => 'roles',
                'action' => 'delete',
                'priority' => 23,
            ],
            [
                'name' => 'role_assign',
                'display_name' => 'Assign Roles',
                'description' => 'Assign roles to admins',
                'category' => 'role',
                'resource' => 'roles',
                'action' => 'assign',
                'priority' => 24,
            ],
            
            // LEAD PERMISSIONS
            [
                'name' => 'lead_view',
                'display_name' => 'View Leads',
                'description' => 'View lead information',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'view',
                'priority' => 30,
            ],
            [
                'name' => 'lead_create',
                'display_name' => 'Create Leads',
                'description' => 'Create new leads',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'create',
                'priority' => 31,
            ],
            [
                'name' => 'lead_update',
                'display_name' => 'Update Leads',
                'description' => 'Update lead information',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'update',
                'priority' => 32,
            ],
            [
                'name' => 'lead_delete',
                'display_name' => 'Delete Leads',
                'description' => 'Delete leads',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'delete',
                'priority' => 33,
            ],
            [
                'name' => 'lead_assign',
                'display_name' => 'Assign Leads',
                'description' => 'Assign leads to team members',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'assign',
                'priority' => 34,
            ],
            [
                'name' => 'lead_bulk_assign',
                'display_name' => 'Bulk Assign Leads',
                'description' => 'Bulk assign multiple leads',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'bulk_assign',
                'priority' => 35,
            ],
            [
                'name' => 'lead_export',
                'display_name' => 'Export Leads',
                'description' => 'Export lead data',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'export',
                'priority' => 36,
            ],
            [
                'name' => 'lead_import',
                'display_name' => 'Import Leads',
                'description' => 'Import lead data',
                'category' => 'lead',
                'resource' => 'leads',
                'action' => 'import',
                'priority' => 37,
            ],
            
            // GROUP PERMISSIONS
            [
                'name' => 'group_view',
                'display_name' => 'View Groups',
                'description' => 'View admin groups',
                'category' => 'group',
                'resource' => 'groups',
                'action' => 'view',
                'priority' => 40,
            ],
            [
                'name' => 'group_create',
                'display_name' => 'Create Groups',
                'description' => 'Create new admin groups',
                'category' => 'group',
                'resource' => 'groups',
                'action' => 'create',
                'priority' => 41,
            ],
            [
                'name' => 'group_update',
                'display_name' => 'Update Groups',
                'description' => 'Update admin groups',
                'category' => 'group',
                'resource' => 'groups',
                'action' => 'update',
                'priority' => 42,
            ],
            [
                'name' => 'group_delete',
                'display_name' => 'Delete Groups',
                'description' => 'Delete admin groups',
                'category' => 'group',
                'resource' => 'groups',
                'action' => 'delete',
                'priority' => 43,
            ],
            [
                'name' => 'group_manage_members',
                'display_name' => 'Manage Group Members',
                'description' => 'Add/remove members from groups',
                'category' => 'group',
                'resource' => 'groups',
                'action' => 'manage_members',
                'priority' => 44,
            ],
            
            // SYSTEM PERMISSIONS
            [
                'name' => 'system_settings',
                'display_name' => 'System Settings',
                'description' => 'Manage system settings',
                'category' => 'system',
                'resource' => 'system',
                'action' => 'settings',
                'priority' => 50,
            ],
            [
                'name' => 'system_audit_logs',
                'display_name' => 'View Audit Logs',
                'description' => 'View system audit logs',
                'category' => 'system',
                'resource' => 'audit_logs',
                'action' => 'view',
                'priority' => 51,
            ],
            [
                'name' => 'system_reports',
                'display_name' => 'System Reports',
                'description' => 'Generate and view system reports',
                'category' => 'system',
                'resource' => 'reports',
                'action' => 'view',
                'priority' => 52,
            ],
            [
                'name' => 'system_backup',
                'display_name' => 'System Backup',
                'description' => 'Perform system backup operations',
                'category' => 'system',
                'resource' => 'system',
                'action' => 'backup',
                'priority' => 53,
            ],
            [
                'name' => 'system_maintenance',
                'display_name' => 'System Maintenance',
                'description' => 'Perform system maintenance',
                'category' => 'system',
                'resource' => 'system',
                'action' => 'maintenance',
                'priority' => 54,
            ],
            
            // PERMISSION PERMISSIONS
            [
                'name' => 'permission_view',
                'display_name' => 'View Permissions',
                'description' => 'View system permissions',
                'category' => 'permission',
                'resource' => 'permissions',
                'action' => 'view',
                'priority' => 60,
            ],
            [
                'name' => 'permission_assign',
                'display_name' => 'Assign Permissions',
                'description' => 'Assign permissions to roles',
                'category' => 'permission',
                'resource' => 'permissions',
                'action' => 'assign',
                'priority' => 61,
            ],
            
            // NOTIFICATION PERMISSIONS
            [
                'name' => 'notification_send',
                'display_name' => 'Send Notifications',
                'description' => 'Send notifications to users',
                'category' => 'notification',
                'resource' => 'notifications',
                'action' => 'send',
                'priority' => 70,
            ],
            [
                'name' => 'notification_view',
                'display_name' => 'View Notifications',
                'description' => 'View system notifications',
                'category' => 'notification',
                'resource' => 'notifications',
                'action' => 'view',
                'priority' => 71,
            ],
            
            // FINANCIAL PERMISSIONS
            [
                'name' => 'finance_view_deposits',
                'display_name' => 'View Deposits',
                'description' => 'View user deposits',
                'category' => 'finance',
                'resource' => 'deposits',
                'action' => 'view',
                'priority' => 80,
            ],
            [
                'name' => 'finance_approve_deposits',
                'display_name' => 'Approve Deposits',
                'description' => 'Approve user deposits',
                'category' => 'finance',
                'resource' => 'deposits',
                'action' => 'approve',
                'priority' => 81,
            ],
            [
                'name' => 'finance_view_withdrawals',
                'display_name' => 'View Withdrawals',
                'description' => 'View user withdrawals',
                'category' => 'finance',
                'resource' => 'withdrawals',
                'action' => 'view',
                'priority' => 82,
            ],
            [
                'name' => 'finance_approve_withdrawals',
                'display_name' => 'Approve Withdrawals',
                'description' => 'Approve user withdrawals',
                'category' => 'finance',
                'resource' => 'withdrawals',
                'action' => 'approve',
                'priority' => 83,
            ],
        ];
        
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert(array_merge($permission, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};