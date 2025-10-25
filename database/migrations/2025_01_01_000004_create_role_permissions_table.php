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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->boolean('is_granted')->default(true); // İzin verildi mi?
            $table->json('constraints')->nullable(); // İlave kısıtlamalar (zaman, IP, vb.)
            $table->timestamp('granted_at')->nullable(); // İzin verilme zamanı
            $table->unsignedBigInteger('granted_by')->nullable(); // İzni veren admin
            $table->timestamp('expires_at')->nullable(); // İzin sona erme zamanı
            $table->text('notes')->nullable(); // İzin notları
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('granted_by')->references('id')->on('admins')->onDelete('set null');
            
            // Unique constraint to prevent duplicate role-permission pairs
            $table->unique(['role_id', 'permission_id'], 'role_permission_unique');
            
            // Indexes for better performance
            $table->index('role_id');
            $table->index('permission_id');
            $table->index('is_granted');
            $table->index('expires_at');
            $table->index(['role_id', 'is_granted']);
            $table->index(['permission_id', 'is_granted']);
        });
        
        // Assign default permissions to roles
        $this->assignDefaultPermissions();
    }
    
    /**
     * Assign default permissions to roles
     */
    private function assignDefaultPermissions()
    {
        // Super Admin - All permissions
        $superAdminRoleId = DB::table('roles')->where('name', 'super_admin')->first()->id;
        $allPermissions = DB::table('permissions')->pluck('id');
        
        foreach ($allPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $superAdminRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Head of Office - Management permissions
        $headOfOfficeRoleId = DB::table('roles')->where('name', 'head_of_office')->first()->id;
        $headOfOfficePermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_create', 'user_update', 'user_assign', 'user_bulk_assign', 'user_export',
            'admin_view_subordinates', 'admin_create', 'admin_update_subordinates',
            'lead_view', 'lead_create', 'lead_update', 'lead_assign', 'lead_bulk_assign', 'lead_export', 'lead_import',
            'group_view', 'group_create', 'group_update', 'group_manage_members',
            'role_view', 'role_assign',
            'system_reports', 'system_audit_logs',
            'notification_send', 'notification_view',
            'finance_view_deposits', 'finance_approve_deposits', 'finance_view_withdrawals', 'finance_approve_withdrawals'
        ])->pluck('id');
        
        foreach ($headOfOfficePermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $headOfOfficeRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Sales Head - Sales management permissions
        $salesHeadRoleId = DB::table('roles')->where('name', 'sales_head')->first()->id;
        $salesHeadPermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_assign', 'user_bulk_assign', 'user_export',
            'admin_view_subordinates', 'admin_update_subordinates',
            'lead_view', 'lead_create', 'lead_update', 'lead_assign', 'lead_bulk_assign', 'lead_export', 'lead_import',
            'group_view', 'group_manage_members',
            'system_reports',
            'notification_send', 'notification_view'
        ])->pluck('id');
        
        foreach ($salesHeadPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $salesHeadRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Team Leader - Team management permissions
        $teamLeaderRoleId = DB::table('roles')->where('name', 'team_leader')->first()->id;
        $teamLeaderPermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_assign', 'user_export',
            'admin_view_subordinates',
            'lead_view', 'lead_create', 'lead_update', 'lead_assign', 'lead_export',
            'group_view',
            'notification_view'
        ])->pluck('id');
        
        foreach ($teamLeaderPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $teamLeaderRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Sale - Basic permissions
        $saleRoleId = DB::table('roles')->where('name', 'sale')->first()->id;
        $salePermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_update',
            'lead_view', 'lead_update',
            'notification_view'
        ])->pluck('id');
        
        foreach ($salePermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $saleRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Retention Head - Retention management permissions
        $retentionHeadRoleId = DB::table('roles')->where('name', 'retention_head')->first()->id;
        $retentionHeadPermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_assign', 'user_bulk_assign', 'user_export',
            'admin_view_subordinates', 'admin_update_subordinates',
            'lead_view', 'lead_update', 'lead_assign', 'lead_bulk_assign', 'lead_export',
            'group_view', 'group_manage_members',
            'system_reports',
            'notification_send', 'notification_view',
            'finance_view_deposits', 'finance_view_withdrawals'
        ])->pluck('id');
        
        foreach ($retentionHeadPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $retentionHeadRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Retention Team Leader - Retention team permissions
        $retentionTeamLeaderRoleId = DB::table('roles')->where('name', 'retention_team_leader')->first()->id;
        $retentionTeamLeaderPermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_assign', 'user_export',
            'admin_view_subordinates',
            'lead_view', 'lead_update', 'lead_assign', 'lead_export',
            'group_view',
            'notification_view',
            'finance_view_deposits', 'finance_view_withdrawals'
        ])->pluck('id');
        
        foreach ($retentionTeamLeaderPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $retentionTeamLeaderRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Retention - Basic retention permissions
        $retentionRoleId = DB::table('roles')->where('name', 'retention')->first()->id;
        $retentionPermissions = DB::table('permissions')->whereIn('name', [
            'user_view', 'user_update',
            'lead_view', 'lead_update',
            'notification_view',
            'finance_view_deposits', 'finance_view_withdrawals'
        ])->pluck('id');
        
        foreach ($retentionPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $retentionRoleId,
                'permission_id' => $permissionId,
                'is_granted' => true,
                'granted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};