<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Role and hierarchy fields
            $table->unsignedBigInteger('role_id')->nullable()->after('type');
            $table->unsignedBigInteger('admin_group_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('admin_group_id'); // Direct supervisor
            $table->json('subordinate_ids')->nullable()->after('supervisor_id'); // List of subordinates
            
            // Employment and hierarchy info
            $table->date('hired_at')->nullable()->after('subordinate_ids');
            $table->string('employee_id')->unique()->nullable()->after('hired_at');
            $table->string('department')->nullable()->after('employee_id'); // sales, retention, support
            $table->string('position')->nullable()->after('department'); // Job title
            $table->integer('hierarchy_level')->default(0)->after('position'); // 0 = highest
            
            // Performance and targets
            $table->decimal('monthly_target', 15, 2)->nullable()->after('hierarchy_level');
            $table->decimal('current_performance', 15, 2)->default(0)->after('monthly_target');
            $table->integer('leads_assigned_count')->default(0)->after('current_performance');
            $table->integer('leads_converted_count')->default(0)->after('leads_assigned_count');
            
            // Work schedule and availability
            $table->json('work_schedule')->nullable()->after('leads_converted_count'); // Working hours
            $table->string('time_zone')->default('UTC')->after('work_schedule');
            $table->boolean('is_available')->default(true)->after('time_zone'); // Currently available
            $table->timestamp('last_activity')->nullable()->after('is_available');
            
            // Lead assignment preferences
            $table->json('lead_assignment_rules')->nullable()->after('last_activity'); // Auto-assignment rules
            $table->integer('max_leads_per_day')->nullable()->after('lead_assignment_rules');
            $table->json('preferred_lead_sources')->nullable()->after('max_leads_per_day');
            $table->json('lead_categories')->nullable()->after('preferred_lead_sources'); // Which types of leads
            
            // Settings and preferences
            $table->json('notification_preferences')->nullable()->after('lead_categories');
            $table->json('dashboard_settings')->nullable()->after('notification_preferences');
            $table->string('language')->default('en')->after('dashboard_settings');
            
            // Security and audit
            $table->timestamp('last_login_at')->nullable()->after('language');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->boolean('two_factor_enabled')->default(false)->after('last_login_ip');
            $table->json('login_history')->nullable()->after('two_factor_enabled'); // Recent logins
            
            // Additional info
            $table->text('bio')->nullable()->after('login_history');
            $table->string('avatar')->nullable()->after('bio');
            $table->json('social_links')->nullable()->after('avatar');
            $table->json('emergency_contact')->nullable()->after('social_links');
            
            // Foreign key constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('admin_group_id')->references('id')->on('admin_groups')->onDelete('set null');
            $table->foreign('supervisor_id')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('role_id');
            $table->index('admin_group_id');
            $table->index('supervisor_id');
            $table->index('department');
            $table->index('hierarchy_level');
            $table->index('employee_id');
            $table->index(['role_id', 'admin_group_id']);
            $table->index(['department', 'hierarchy_level']);
            $table->index('is_available');
            $table->index('last_activity');
            $table->index('leads_assigned_count');
            $table->index(['department', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['role_id']);
            $table->dropForeign(['admin_group_id']);
            $table->dropForeign(['supervisor_id']);
            
            // Drop indexes
            $table->dropIndex(['role_id']);
            $table->dropIndex(['admin_group_id']);
            $table->dropIndex(['supervisor_id']);
            $table->dropIndex(['department']);
            $table->dropIndex(['hierarchy_level']);
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['role_id', 'admin_group_id']);
            $table->dropIndex(['department', 'hierarchy_level']);
            $table->dropIndex(['is_available']);
            $table->dropIndex(['last_activity']);
            $table->dropIndex(['leads_assigned_count']);
            $table->dropIndex(['department', 'is_available']);
            
            // Drop columns
            $table->dropColumn([
                'role_id',
                'admin_group_id',
                'supervisor_id',
                'subordinate_ids',
                'hired_at',
                'employee_id',
                'department',
                'position',
                'hierarchy_level',
                'monthly_target',
                'current_performance',
                'leads_assigned_count',
                'leads_converted_count',
                'work_schedule',
                'time_zone',
                'is_available',
                'last_activity',
                'lead_assignment_rules',
                'max_leads_per_day',
                'preferred_lead_sources',
                'lead_categories',
                'notification_preferences',
                'dashboard_settings',
                'language',
                'last_login_at',
                'last_login_ip',
                'two_factor_enabled',
                'login_history',
                'bio',
                'avatar',
                'social_links',
                'emergency_contact'
            ]);
        });
    }
};