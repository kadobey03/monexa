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
        // Add performance indexes to existing tables
        $this->addPerformanceIndexes();
        
        // Create performance-optimized views
        $this->createPerformanceViews();
        
        // Add computed columns for better performance
        $this->addComputedColumns();
        
        // Create full-text search indexes
        $this->addFullTextIndexes();
    }
    
    /**
     * Add performance-specific indexes to existing tables
     */
    private function addPerformanceIndexes(): void
    {
        // Users table performance indexes
        Schema::table('users', function (Blueprint $table) {
            // Lead assignment performance
            $table->index(['assigned_to_admin_id', 'lead_status_id', 'lead_score'], 'users_assignment_performance_idx');
            $table->index(['lead_region', 'lead_timezone', 'priority_level'], 'users_geographic_priority_idx');
            $table->index(['current_stage', 'last_contact_date', 'engagement_score'], 'users_stage_engagement_idx');
            $table->index(['is_hot_lead', 'priority_level', 'lead_quality_score'], 'users_hot_priority_quality_idx');
            $table->index(['campaign_id', 'utm_source', 'created_at'], 'users_campaign_tracking_idx');
            
            // Time-based performance indexes
            $table->index(['created_at', 'assigned_to_admin_id'], 'users_created_assigned_idx');
            $table->index(['updated_at', 'current_stage'], 'users_updated_stage_idx');
            $table->index(['last_contact_date', 'next_follow_up_date'], 'users_contact_followup_idx');
        });
        
        // Admins table performance indexes
        Schema::table('admins', function (Blueprint $table) {
            // Hierarchy and assignment performance
            $table->index(['role_id', 'admin_group_id', 'is_available'], 'admins_role_group_available_idx');
            $table->index(['department', 'hierarchy_level', 'leads_assigned_count'], 'admins_dept_hierarchy_leads_idx');
            $table->index(['supervisor_id', 'is_available', 'last_activity'], 'admins_supervisor_activity_idx');
            $table->index(['time_zone', 'department', 'is_available'], 'admins_timezone_dept_available_idx');
            
            // Performance tracking indexes
            $table->index(['leads_assigned_count', 'leads_converted_count'], 'admins_performance_idx');
            $table->index(['monthly_target', 'current_performance'], 'admins_target_performance_idx');
            $table->index(['last_login_at', 'is_available'], 'admins_login_available_idx');
        });
        
        // Lead assignment history performance indexes
        Schema::table('lead_assignment_history', function (Blueprint $table) {
            // Date range queries
            $table->index(['assignment_started_at', 'assignment_ended_at'], 'history_date_range_idx');
            $table->index(['created_at', 'assignment_outcome'], 'history_created_outcome_idx');
            
            // Performance analysis indexes
            $table->index(['assigned_to_admin_id', 'assignment_outcome', 'days_assigned'], 'history_admin_outcome_days_idx');
            $table->index(['department', 'assignment_method', 'assignment_started_at'], 'history_dept_method_date_idx');
            $table->index(['was_automated', 'assignment_confidence', 'assignment_outcome'], 'history_auto_confidence_outcome_idx');
        });
        
        // Admin audit logs performance indexes
        Schema::table('admin_audit_logs', function (Blueprint $table) {
            // Time-based queries with filtering
            $table->index(['occurred_at', 'admin_id', 'action'], 'audit_time_admin_action_idx');
            $table->index(['category', 'severity', 'occurred_at'], 'audit_category_severity_time_idx');
            $table->index(['entity_type', 'entity_id', 'occurred_at'], 'audit_entity_time_idx');
            $table->index(['session_id', 'occurred_at'], 'audit_session_time_idx');
            $table->index(['ip_address', 'occurred_at'], 'audit_ip_time_idx');
        });
        
        // Role permissions performance indexes
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->index(['role_id', 'is_granted', 'expires_at'], 'role_perms_granted_expires_idx');
            $table->index(['permission_id', 'is_granted'], 'role_perms_permission_granted_idx');
        });
        
        // Admin groups performance indexes
        Schema::table('admin_groups', function (Blueprint $table) {
            $table->index(['department', 'is_active', 'region'], 'groups_dept_active_region_idx');
            $table->index(['parent_group_id', 'is_active'], 'groups_parent_active_idx');
        });
    }
    
    /**
     * Create performance-optimized database views
     */
    private function createPerformanceViews(): void
    {
        // View for active lead assignments with admin info
        DB::statement("
            CREATE OR REPLACE VIEW active_lead_assignments AS
            SELECT 
                u.id as lead_id,
                u.name as lead_name,
                u.email as lead_email,
                u.assigned_to_admin_id,
                a.firstName as admin_first_name,
                a.lastName as admin_last_name,
                a.email as admin_email,
                a.department as admin_department,
                ag.name as admin_group_name,
                r.name as admin_role_name,
                u.lead_status_id,
                ls.name as lead_status_name,
                u.lead_score,
                u.priority_level,
                u.current_stage,
                u.last_contact_date,
                u.next_follow_up_date,
                u.engagement_score,
                u.assigned_to_admin_id IS NOT NULL as is_assigned,
                DATEDIFF(NOW(), u.current_assigned_at) as days_with_current_admin,
                CASE 
                    WHEN u.next_follow_up_date < NOW() THEN 'overdue'
                    WHEN u.next_follow_up_date <= DATE_ADD(NOW(), INTERVAL 1 DAY) THEN 'due_soon'
                    ELSE 'on_track'
                END as follow_up_status
            FROM users u
            LEFT JOIN admins a ON u.assigned_to_admin_id = a.id
            LEFT JOIN admin_groups ag ON a.admin_group_id = ag.id
            LEFT JOIN roles r ON a.role_id = r.id
            LEFT JOIN lead_statuses ls ON u.lead_status_id = ls.id
            WHERE u.assigned_to_admin_id IS NOT NULL
        ");
        
        // View for admin performance metrics
        DB::statement("
            CREATE OR REPLACE VIEW admin_performance_metrics AS
            SELECT 
                a.id as admin_id,
                a.firstName,
                a.lastName,
                a.email,
                a.department,
                r.name as role_name,
                ag.name as group_name,
                a.leads_assigned_count,
                a.leads_converted_count,
                CASE 
                    WHEN a.leads_assigned_count > 0 
                    THEN ROUND((a.leads_converted_count / a.leads_assigned_count) * 100, 2)
                    ELSE 0 
                END as conversion_rate,
                a.monthly_target,
                a.current_performance,
                CASE 
                    WHEN a.monthly_target > 0 
                    THEN ROUND((a.current_performance / a.monthly_target) * 100, 2)
                    ELSE 0 
                END as target_achievement_rate,
                (SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.is_hot_lead = 1) as hot_leads_count,
                (SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.priority_level = 'urgent') as urgent_leads_count,
                (SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.next_follow_up_date < NOW()) as overdue_followups_count,
                a.is_available,
                a.last_activity,
                CASE 
                    WHEN a.last_activity >= DATE_SUB(NOW(), INTERVAL 1 HOUR) THEN 'active'
                    WHEN a.last_activity >= DATE_SUB(NOW(), INTERVAL 1 DAY) THEN 'recent'
                    ELSE 'inactive'
                END as activity_status
            FROM admins a
            LEFT JOIN roles r ON a.role_id = r.id
            LEFT JOIN admin_groups ag ON a.admin_group_id = ag.id
            WHERE a.role_id IS NOT NULL
        ");
        
        // View for lead distribution by admin
        DB::statement("
            CREATE OR REPLACE VIEW lead_distribution_summary AS
            SELECT 
                a.id as admin_id,
                a.firstName,
                a.lastName,
                a.department,
                r.name as role_name,
                COUNT(u.id) as total_leads,
                COUNT(CASE WHEN u.priority_level = 'high' THEN 1 END) as high_priority_leads,
                COUNT(CASE WHEN u.priority_level = 'urgent' THEN 1 END) as urgent_leads,
                COUNT(CASE WHEN u.is_hot_lead = 1 THEN 1 END) as hot_leads,
                COUNT(CASE WHEN u.current_stage = 'new' THEN 1 END) as new_leads,
                COUNT(CASE WHEN u.current_stage = 'contacted' THEN 1 END) as contacted_leads,
                COUNT(CASE WHEN u.current_stage = 'qualified' THEN 1 END) as qualified_leads,
                AVG(u.lead_score) as avg_lead_score,
                AVG(u.engagement_score) as avg_engagement_score,
                MIN(u.current_assigned_at) as first_assignment_date,
                MAX(u.current_assigned_at) as last_assignment_date
            FROM admins a
            LEFT JOIN roles r ON a.role_id = r.id
            LEFT JOIN users u ON a.id = u.assigned_to_admin_id
            GROUP BY a.id, a.firstName, a.lastName, a.department, r.name
        ");
        
        // View for daily assignment statistics
        DB::statement("
            CREATE OR REPLACE VIEW daily_assignment_stats AS
            SELECT 
                DATE(lah.assignment_started_at) as assignment_date,
                lah.department,
                lah.assignment_method,
                lah.assignment_type,
                COUNT(*) as total_assignments,
                COUNT(CASE WHEN lah.was_automated = 1 THEN 1 END) as automated_assignments,
                COUNT(CASE WHEN lah.assignment_outcome = 'converted' THEN 1 END) as conversions,
                COUNT(CASE WHEN lah.assignment_outcome = 'reassigned' THEN 1 END) as reassignments,
                AVG(lah.days_assigned) as avg_days_assigned,
                AVG(lah.response_time_hours) as avg_response_time_hours,
                AVG(lah.engagement_score_end - lah.engagement_score_start) as avg_engagement_improvement,
                SUM(lah.final_conversion_value) as total_conversion_value
            FROM lead_assignment_history lah
            WHERE lah.assignment_started_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)
            GROUP BY DATE(lah.assignment_started_at), lah.department, lah.assignment_method, lah.assignment_type
        ");
    }
    
    /**
     * Add computed columns for better performance
     */
    private function addComputedColumns(): void
    {
        // Add computed columns to users table for faster queries
        Schema::table('users', function (Blueprint $table) {
            // Days since last contact (computed daily via job)
            $table->integer('days_since_last_contact')->nullable()->after('last_contact_date');
            
            // Days until next follow-up (computed daily via job)
            $table->integer('days_until_follow_up')->nullable()->after('next_follow_up_date');
            
            // Combined priority score (computed when lead data changes)
            $table->decimal('combined_priority_score', 8, 3)->nullable()->after('engagement_score');
        });
        
        // Add computed columns to admins table
        Schema::table('admins', function (Blueprint $table) {
            // Workload score (computed when assignments change)
            $table->decimal('workload_score', 5, 2)->nullable()->after('leads_converted_count');
            
            // Efficiency score (computed daily)
            $table->decimal('efficiency_score', 5, 2)->nullable()->after('workload_score');
        });
        
        // Add indexes for computed columns
        Schema::table('users', function (Blueprint $table) {
            $table->index('days_since_last_contact');
            $table->index('days_until_follow_up');
            $table->index('combined_priority_score');
            $table->index(['combined_priority_score', 'assigned_to_admin_id']);
        });
        
        Schema::table('admins', function (Blueprint $table) {
            $table->index('workload_score');
            $table->index('efficiency_score');
            $table->index(['workload_score', 'is_available']);
        });
    }
    
    /**
     * Add full-text search indexes for better search performance
     */
    private function addFullTextIndexes(): void
    {
        // Add full-text search to users table
        DB::statement('ALTER TABLE users ADD FULLTEXT(name, email) WITH PARSER ngram');
        
        // Add full-text search to admin audit logs
        DB::statement('ALTER TABLE admin_audit_logs ADD FULLTEXT(description, notes) WITH PARSER ngram');
        
        // Add full-text search to admin settings
        DB::statement('ALTER TABLE admin_settings ADD FULLTEXT(display_name, description, help_text) WITH PARSER ngram');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop views
        DB::statement('DROP VIEW IF EXISTS active_lead_assignments');
        DB::statement('DROP VIEW IF EXISTS admin_performance_metrics');
        DB::statement('DROP VIEW IF EXISTS lead_distribution_summary');
        DB::statement('DROP VIEW IF EXISTS daily_assignment_stats');
        
        // Drop full-text indexes
        try {
            DB::statement('ALTER TABLE users DROP INDEX name');
            DB::statement('ALTER TABLE admin_audit_logs DROP INDEX description');
            DB::statement('ALTER TABLE admin_settings DROP INDEX display_name');
        } catch (\Exception $e) {
            // Indexes might not exist, ignore errors
        }
        
        // Drop computed columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['days_since_last_contact']);
            $table->dropIndex(['days_until_follow_up']);
            $table->dropIndex(['combined_priority_score']);
            $table->dropIndex(['combined_priority_score', 'assigned_to_admin_id']);
            
            $table->dropColumn([
                'days_since_last_contact',
                'days_until_follow_up',
                'combined_priority_score'
            ]);
        });
        
        // Drop computed columns from admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['workload_score']);
            $table->dropIndex(['efficiency_score']);
            $table->dropIndex(['workload_score', 'is_available']);
            
            $table->dropColumn([
                'workload_score',
                'efficiency_score'
            ]);
        });
        
        // Drop performance indexes - Users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['users_assignment_performance_idx']);
            $table->dropIndex(['users_geographic_priority_idx']);
            $table->dropIndex(['users_stage_engagement_idx']);
            $table->dropIndex(['users_hot_priority_quality_idx']);
            $table->dropIndex(['users_campaign_tracking_idx']);
            $table->dropIndex(['users_created_assigned_idx']);
            $table->dropIndex(['users_updated_stage_idx']);
            $table->dropIndex(['users_contact_followup_idx']);
        });
        
        // Drop performance indexes - Admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['admins_role_group_available_idx']);
            $table->dropIndex(['admins_dept_hierarchy_leads_idx']);
            $table->dropIndex(['admins_supervisor_activity_idx']);
            $table->dropIndex(['admins_timezone_dept_available_idx']);
            $table->dropIndex(['admins_performance_idx']);
            $table->dropIndex(['admins_target_performance_idx']);
            $table->dropIndex(['admins_login_available_idx']);
        });
        
        // Drop other performance indexes
        Schema::table('lead_assignment_history', function (Blueprint $table) {
            $table->dropIndex(['history_date_range_idx']);
            $table->dropIndex(['history_created_outcome_idx']);
            $table->dropIndex(['history_admin_outcome_days_idx']);
            $table->dropIndex(['history_dept_method_date_idx']);
            $table->dropIndex(['history_auto_confidence_outcome_idx']);
        });
        
        Schema::table('admin_audit_logs', function (Blueprint $table) {
            $table->dropIndex(['audit_time_admin_action_idx']);
            $table->dropIndex(['audit_category_severity_time_idx']);
            $table->dropIndex(['audit_entity_time_idx']);
            $table->dropIndex(['audit_session_time_idx']);
            $table->dropIndex(['audit_ip_time_idx']);
        });
        
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropIndex(['role_perms_granted_expires_idx']);
            $table->dropIndex(['role_perms_permission_granted_idx']);
        });
        
        Schema::table('admin_groups', function (Blueprint $table) {
            $table->dropIndex(['groups_dept_active_region_idx']);
            $table->dropIndex(['groups_parent_active_idx']);
        });
    }
};