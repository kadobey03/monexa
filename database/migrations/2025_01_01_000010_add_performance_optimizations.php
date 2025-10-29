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
     * Check if index exists on table
     */
    private function indexExists($table, $indexName): bool
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Add performance-specific indexes to existing tables
     */
    private function addPerformanceIndexes(): void
    {
        // Users table performance indexes
        Schema::table('users', function (Blueprint $table) {
            // Lead assignment performance - only add if columns exist and index doesn't exist
            $columns = ['assigned_to_admin_id'];
            if (Schema::hasColumn('users', 'lead_status_id')) {
                $columns[] = 'lead_status_id';
            }
            if (Schema::hasColumn('users', 'lead_score')) {
                $columns[] = 'lead_score';
            }
            if (count($columns) > 1 && !$this->indexExists('users', 'users_assignment_performance_idx')) {
                $table->index($columns, 'users_assignment_performance_idx');
            }
            
            // Geographic and priority indexes - check column existence
            $geoColumns = [];
            if (Schema::hasColumn('users', 'lead_region')) $geoColumns[] = 'lead_region';
            if (Schema::hasColumn('users', 'lead_timezone')) $geoColumns[] = 'lead_timezone';
            if (Schema::hasColumn('users', 'priority_level')) $geoColumns[] = 'priority_level';
            if (count($geoColumns) >= 2 && !$this->indexExists('users', 'users_geographic_priority_idx')) {
                $table->index($geoColumns, 'users_geographic_priority_idx');
            }
            
            // Stage and engagement indexes
            $stageColumns = [];
            if (Schema::hasColumn('users', 'current_stage')) $stageColumns[] = 'current_stage';
            if (Schema::hasColumn('users', 'last_contact_date')) $stageColumns[] = 'last_contact_date';
            if (Schema::hasColumn('users', 'engagement_score')) $stageColumns[] = 'engagement_score';
            if (count($stageColumns) >= 2 && !$this->indexExists('users', 'users_stage_engagement_idx')) {
                $table->index($stageColumns, 'users_stage_engagement_idx');
            }
            
            // Hot lead priority indexes
            $hotColumns = [];
            if (Schema::hasColumn('users', 'is_hot_lead')) $hotColumns[] = 'is_hot_lead';
            if (Schema::hasColumn('users', 'priority_level')) $hotColumns[] = 'priority_level';
            if (Schema::hasColumn('users', 'lead_quality_score')) $hotColumns[] = 'lead_quality_score';
            if (count($hotColumns) >= 2 && !$this->indexExists('users', 'users_hot_priority_quality_idx')) {
                $table->index($hotColumns, 'users_hot_priority_quality_idx');
            }
            
            // Campaign tracking indexes
            $campaignColumns = [];
            if (Schema::hasColumn('users', 'campaign_id')) $campaignColumns[] = 'campaign_id';
            if (Schema::hasColumn('users', 'utm_source')) $campaignColumns[] = 'utm_source';
            $campaignColumns[] = 'created_at'; // This always exists
            if (count($campaignColumns) >= 2 && !$this->indexExists('users', 'users_campaign_tracking_idx')) {
                $table->index($campaignColumns, 'users_campaign_tracking_idx');
            }
            
            // Time-based performance indexes
            if (Schema::hasColumn('users', 'assigned_to_admin_id') && !$this->indexExists('users', 'users_created_assigned_idx')) {
                $table->index(['created_at', 'assigned_to_admin_id'], 'users_created_assigned_idx');
            }
            if (Schema::hasColumn('users', 'current_stage') && !$this->indexExists('users', 'users_updated_stage_idx')) {
                $table->index(['updated_at', 'current_stage'], 'users_updated_stage_idx');
            }
            if (Schema::hasColumn('users', 'last_contact_date') && Schema::hasColumn('users', 'next_follow_up_date') && !$this->indexExists('users', 'users_contact_followup_idx')) {
                $table->index(['last_contact_date', 'next_follow_up_date'], 'users_contact_followup_idx');
            }
        });
        
        // Admins table performance indexes - only if table exists
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                // Hierarchy and assignment performance
                if (!$this->indexExists('admins', 'admins_role_group_available_idx')) {
                    $table->index(['role_id', 'admin_group_id', 'is_available'], 'admins_role_group_available_idx');
                }
                if (!$this->indexExists('admins', 'admins_dept_hierarchy_leads_idx')) {
                    $table->index(['department', 'hierarchy_level', 'leads_assigned_count'], 'admins_dept_hierarchy_leads_idx');
                }
                if (!$this->indexExists('admins', 'admins_supervisor_activity_idx')) {
                    $table->index(['supervisor_id', 'is_available', 'last_activity'], 'admins_supervisor_activity_idx');
                }
                if (!$this->indexExists('admins', 'admins_timezone_dept_available_idx')) {
                    $table->index(['time_zone', 'department', 'is_available'], 'admins_timezone_dept_available_idx');
                }
                
                // Performance tracking indexes
                if (!$this->indexExists('admins', 'admins_performance_idx')) {
                    $table->index(['leads_assigned_count', 'leads_converted_count'], 'admins_performance_idx');
                }
                if (!$this->indexExists('admins', 'admins_target_performance_idx')) {
                    $table->index(['monthly_target', 'current_performance'], 'admins_target_performance_idx');
                }
                if (!$this->indexExists('admins', 'admins_login_available_idx')) {
                    $table->index(['last_login_at', 'is_available'], 'admins_login_available_idx');
                }
            });
        }
        
        // Lead assignment history performance indexes - only if table exists
        if (Schema::hasTable('lead_assignment_history')) {
            Schema::table('lead_assignment_history', function (Blueprint $table) {
                // Date range queries
                if (!$this->indexExists('lead_assignment_history', 'history_date_range_idx')) {
                    $table->index(['assignment_started_at', 'assignment_ended_at'], 'history_date_range_idx');
                }
                if (!$this->indexExists('lead_assignment_history', 'history_created_outcome_idx')) {
                    $table->index(['created_at', 'assignment_outcome'], 'history_created_outcome_idx');
                }
                
                // Performance analysis indexes
                if (!$this->indexExists('lead_assignment_history', 'history_admin_outcome_days_idx')) {
                    $table->index(['assigned_to_admin_id', 'assignment_outcome', 'days_assigned'], 'history_admin_outcome_days_idx');
                }
                if (!$this->indexExists('lead_assignment_history', 'history_dept_method_date_idx')) {
                    $table->index(['department', 'assignment_method', 'assignment_started_at'], 'history_dept_method_date_idx');
                }
                if (!$this->indexExists('lead_assignment_history', 'history_auto_confidence_outcome_idx')) {
                    $table->index(['was_automated', 'assignment_confidence', 'assignment_outcome'], 'history_auto_confidence_outcome_idx');
                }
            });
        }
        
        // Admin audit logs performance indexes - only if table exists
        if (Schema::hasTable('admin_audit_logs')) {
            Schema::table('admin_audit_logs', function (Blueprint $table) {
                // Time-based queries with filtering
                if (!$this->indexExists('admin_audit_logs', 'audit_time_admin_action_idx')) {
                    $table->index(['occurred_at', 'admin_id', 'action'], 'audit_time_admin_action_idx');
                }
                if (!$this->indexExists('admin_audit_logs', 'audit_category_severity_time_idx')) {
                    $table->index(['category', 'severity', 'occurred_at'], 'audit_category_severity_time_idx');
                }
                if (!$this->indexExists('admin_audit_logs', 'audit_entity_time_idx')) {
                    $table->index(['entity_type', 'entity_id', 'occurred_at'], 'audit_entity_time_idx');
                }
                if (!$this->indexExists('admin_audit_logs', 'audit_session_time_idx')) {
                    $table->index(['session_id', 'occurred_at'], 'audit_session_time_idx');
                }
                if (!$this->indexExists('admin_audit_logs', 'audit_ip_time_idx')) {
                    $table->index(['ip_address', 'occurred_at'], 'audit_ip_time_idx');
                }
            });
        }
        
        // Role permissions performance indexes - only if table exists
        if (Schema::hasTable('role_permissions')) {
            Schema::table('role_permissions', function (Blueprint $table) {
                if (!$this->indexExists('role_permissions', 'role_perms_granted_expires_idx')) {
                    $table->index(['role_id', 'is_granted', 'expires_at'], 'role_perms_granted_expires_idx');
                }
                if (!$this->indexExists('role_permissions', 'role_perms_permission_granted_idx')) {
                    $table->index(['permission_id', 'is_granted'], 'role_perms_permission_granted_idx');
                }
            });
        }
        
        // Admin groups performance indexes
        if (Schema::hasTable('admin_groups')) {
            Schema::table('admin_groups', function (Blueprint $table) {
                if (!$this->indexExists('admin_groups', 'groups_dept_active_region_idx')) {
                    $table->index(['department', 'is_active', 'region'], 'groups_dept_active_region_idx');
                }
                if (!$this->indexExists('admin_groups', 'groups_parent_active_idx')) {
                    $table->index(['parent_group_id', 'is_active'], 'groups_parent_active_idx');
                }
            });
        }
    }
    
    /**
     * Create performance-optimized database views
     */
    private function createPerformanceViews(): void
    {
        // Build dynamic view for active lead assignments with admin info
        $viewColumns = [
            'u.id as lead_id',
            'u.name as lead_name',
            'u.email as lead_email',
            'u.assigned_to_admin_id'
        ];
        
        // Add admin columns if available
        if (Schema::hasTable('admins')) {
            $adminColumns = Schema::getColumnListing('admins');
            if (in_array('firstName', $adminColumns)) $viewColumns[] = 'a.firstName as admin_first_name';
            if (in_array('lastName', $adminColumns)) $viewColumns[] = 'a.lastName as admin_last_name';
            if (in_array('email', $adminColumns)) $viewColumns[] = 'a.email as admin_email';
            if (in_array('department', $adminColumns)) $viewColumns[] = 'a.department as admin_department';
        }
        
        // Add group and role info if tables exist
        if (Schema::hasTable('admin_groups')) $viewColumns[] = 'ag.name as admin_group_name';
        if (Schema::hasTable('roles')) $viewColumns[] = 'r.name as admin_role_name';
        
        // Add lead-specific columns if they exist
        $userColumns = Schema::getColumnListing('users');
        if (in_array('lead_status_id', $userColumns)) $viewColumns[] = 'u.lead_status_id';
        if (Schema::hasTable('lead_statuses') && in_array('lead_status_id', $userColumns)) {
            $viewColumns[] = 'ls.name as lead_status_name';
        }
        if (in_array('lead_score', $userColumns)) $viewColumns[] = 'u.lead_score';
        if (in_array('priority_level', $userColumns)) $viewColumns[] = 'u.priority_level';
        if (in_array('current_stage', $userColumns)) $viewColumns[] = 'u.current_stage';
        if (in_array('last_contact_date', $userColumns)) $viewColumns[] = 'u.last_contact_date';
        if (in_array('next_follow_up_date', $userColumns)) $viewColumns[] = 'u.next_follow_up_date';
        if (in_array('engagement_score', $userColumns)) $viewColumns[] = 'u.engagement_score';
        
        $viewColumns[] = 'u.assigned_to_admin_id IS NOT NULL as is_assigned';
        
        // Add computed columns if base columns exist
        if (in_array('current_assigned_at', $userColumns)) {
            $viewColumns[] = 'DATEDIFF(NOW(), u.current_assigned_at) as days_with_current_admin';
        }
        
        if (in_array('next_follow_up_date', $userColumns)) {
            $viewColumns[] = "CASE
                WHEN u.next_follow_up_date < NOW() THEN 'overdue'
                WHEN u.next_follow_up_date <= DATE_ADD(NOW(), INTERVAL 1 DAY) THEN 'due_soon'
                ELSE 'on_track'
            END as follow_up_status";
        }
        
        $columnsSQL = implode(",\n                ", $viewColumns);
        
        // Build JOIN clauses
        $joins = [];
        if (Schema::hasTable('admins')) {
            $joins[] = 'LEFT JOIN admins a ON u.assigned_to_admin_id = a.id';
        }
        if (Schema::hasTable('admin_groups') && Schema::hasTable('admins')) {
            $joins[] = 'LEFT JOIN admin_groups ag ON a.admin_group_id = ag.id';
        }
        if (Schema::hasTable('roles') && Schema::hasTable('admins')) {
            $joins[] = 'LEFT JOIN roles r ON a.role_id = r.id';
        }
        if (Schema::hasTable('lead_statuses') && in_array('lead_status_id', $userColumns)) {
            $joins[] = 'LEFT JOIN lead_statuses ls ON u.lead_status_id = ls.id';
        }
        
        $joinsSQL = implode("\n            ", $joins);
        
        DB::statement("
            CREATE OR REPLACE VIEW active_lead_assignments AS
            SELECT
                {$columnsSQL}
            FROM users u
            {$joinsSQL}
            WHERE u.assigned_to_admin_id IS NOT NULL
        ");
        
        // Build dynamic admin performance metrics view
        if (Schema::hasTable('admins')) {
            $adminColumns = Schema::getColumnListing('admins');
            $userColumns = Schema::getColumnListing('users');
            
            $perfColumns = ['a.id as admin_id'];
            
            // Add basic admin info if columns exist
            if (in_array('firstName', $adminColumns)) $perfColumns[] = 'a.firstName';
            if (in_array('lastName', $adminColumns)) $perfColumns[] = 'a.lastName';
            if (in_array('email', $adminColumns)) $perfColumns[] = 'a.email';
            if (in_array('department', $adminColumns)) $perfColumns[] = 'a.department';
            
            // Add role and group info if tables exist
            if (Schema::hasTable('roles')) $perfColumns[] = 'r.name as role_name';
            if (Schema::hasTable('admin_groups')) $perfColumns[] = 'ag.name as group_name';
            
            // Add performance metrics if columns exist
            if (in_array('leads_assigned_count', $adminColumns)) {
                $perfColumns[] = 'a.leads_assigned_count';
            }
            if (in_array('leads_converted_count', $adminColumns)) {
                $perfColumns[] = 'a.leads_converted_count';
            }
            
            // Add conversion rate calculation if both columns exist
            if (in_array('leads_assigned_count', $adminColumns) && in_array('leads_converted_count', $adminColumns)) {
                $perfColumns[] = "CASE
                    WHEN a.leads_assigned_count > 0
                    THEN ROUND((a.leads_converted_count / a.leads_assigned_count) * 100, 2)
                    ELSE 0
                END as conversion_rate";
            }
            
            // Add target metrics if columns exist
            if (in_array('monthly_target', $adminColumns)) $perfColumns[] = 'a.monthly_target';
            if (in_array('current_performance', $adminColumns)) $perfColumns[] = 'a.current_performance';
            
            if (in_array('monthly_target', $adminColumns) && in_array('current_performance', $adminColumns)) {
                $perfColumns[] = "CASE
                    WHEN a.monthly_target > 0
                    THEN ROUND((a.current_performance / a.monthly_target) * 100, 2)
                    ELSE 0
                END as target_achievement_rate";
            }
            
            // Add dynamic user-based counts if columns exist
            if (in_array('assigned_to_admin_id', $userColumns)) {
                if (in_array('is_hot_lead', $userColumns)) {
                    $perfColumns[] = '(SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.is_hot_lead = 1) as hot_leads_count';
                }
                if (in_array('priority_level', $userColumns)) {
                    $perfColumns[] = "(SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.priority_level = 'urgent') as urgent_leads_count";
                }
                if (in_array('next_follow_up_date', $userColumns)) {
                    $perfColumns[] = '(SELECT COUNT(*) FROM users u WHERE u.assigned_to_admin_id = a.id AND u.next_follow_up_date < NOW()) as overdue_followups_count';
                }
            }
            
            // Add availability and activity if columns exist
            if (in_array('is_available', $adminColumns)) $perfColumns[] = 'a.is_available';
            if (in_array('last_activity', $adminColumns)) {
                $perfColumns[] = 'a.last_activity';
                $perfColumns[] = "CASE
                    WHEN a.last_activity >= DATE_SUB(NOW(), INTERVAL 1 HOUR) THEN 'active'
                    WHEN a.last_activity >= DATE_SUB(NOW(), INTERVAL 1 DAY) THEN 'recent'
                    ELSE 'inactive'
                END as activity_status";
            }
            
            $perfColumnsSQL = implode(",\n                ", $perfColumns);
            
            // Build joins
            $perfJoins = [];
            if (Schema::hasTable('roles')) {
                $perfJoins[] = 'LEFT JOIN roles r ON a.role_id = r.id';
            }
            if (Schema::hasTable('admin_groups')) {
                $perfJoins[] = 'LEFT JOIN admin_groups ag ON a.admin_group_id = ag.id';
            }
            
            $perfJoinsSQL = implode("\n            ", $perfJoins);
            
            $whereClause = '';
            if (in_array('role_id', $adminColumns)) {
                $whereClause = 'WHERE a.role_id IS NOT NULL';
            }
            
            DB::statement("
                CREATE OR REPLACE VIEW admin_performance_metrics AS
                SELECT
                    {$perfColumnsSQL}
                FROM admins a
                {$perfJoinsSQL}
                {$whereClause}
            ");
        }
        
        // Build dynamic lead distribution summary view
        if (Schema::hasTable('admins')) {
            $adminColumns = Schema::getColumnListing('admins');
            $userColumns = Schema::getColumnListing('users');
            
            $distColumns = ['a.id as admin_id'];
            $groupBy = ['a.id'];
            
            // Add basic admin info
            if (in_array('firstName', $adminColumns)) {
                $distColumns[] = 'a.firstName';
                $groupBy[] = 'a.firstName';
            }
            if (in_array('lastName', $adminColumns)) {
                $distColumns[] = 'a.lastName';
                $groupBy[] = 'a.lastName';
            }
            if (in_array('department', $adminColumns)) {
                $distColumns[] = 'a.department';
                $groupBy[] = 'a.department';
            }
            
            // Add role info if table exists
            if (Schema::hasTable('roles')) {
                $distColumns[] = 'r.name as role_name';
                $groupBy[] = 'r.name';
            }
            
            // Add user-based counts if assigned_to_admin_id exists
            if (in_array('assigned_to_admin_id', $userColumns)) {
                $distColumns[] = 'COUNT(u.id) as total_leads';
                
                if (in_array('priority_level', $userColumns)) {
                    $distColumns[] = "COUNT(CASE WHEN u.priority_level = 'high' THEN 1 END) as high_priority_leads";
                    $distColumns[] = "COUNT(CASE WHEN u.priority_level = 'urgent' THEN 1 END) as urgent_leads";
                }
                
                if (in_array('is_hot_lead', $userColumns)) {
                    $distColumns[] = 'COUNT(CASE WHEN u.is_hot_lead = 1 THEN 1 END) as hot_leads';
                }
                
                if (in_array('current_stage', $userColumns)) {
                    $distColumns[] = "COUNT(CASE WHEN u.current_stage = 'new' THEN 1 END) as new_leads";
                    $distColumns[] = "COUNT(CASE WHEN u.current_stage = 'contacted' THEN 1 END) as contacted_leads";
                    $distColumns[] = "COUNT(CASE WHEN u.current_stage = 'qualified' THEN 1 END) as qualified_leads";
                }
                
                if (in_array('lead_score', $userColumns)) {
                    $distColumns[] = 'AVG(u.lead_score) as avg_lead_score';
                }
                
                if (in_array('engagement_score', $userColumns)) {
                    $distColumns[] = 'AVG(u.engagement_score) as avg_engagement_score';
                }
                
                if (in_array('current_assigned_at', $userColumns)) {
                    $distColumns[] = 'MIN(u.current_assigned_at) as first_assignment_date';
                    $distColumns[] = 'MAX(u.current_assigned_at) as last_assignment_date';
                }
            }
            
            $distColumnsSQL = implode(",\n                ", $distColumns);
            $groupBySQL = implode(', ', $groupBy);
            
            // Build joins
            $distJoins = [];
            if (Schema::hasTable('roles')) {
                $distJoins[] = 'LEFT JOIN roles r ON a.role_id = r.id';
            }
            if (in_array('assigned_to_admin_id', $userColumns)) {
                $distJoins[] = 'LEFT JOIN users u ON a.id = u.assigned_to_admin_id';
            }
            
            $distJoinsSQL = implode("\n            ", $distJoins);
            
            DB::statement("
                CREATE OR REPLACE VIEW lead_distribution_summary AS
                SELECT
                    {$distColumnsSQL}
                FROM admins a
                {$distJoinsSQL}
                GROUP BY {$groupBySQL}
            ");
        }
        
        // Build dynamic daily assignment statistics view only if table exists
        if (Schema::hasTable('lead_assignment_history')) {
            $lahColumns = Schema::getColumnListing('lead_assignment_history');
            
            $statsColumns = [];
            $groupBy = [];
            
            if (in_array('assignment_started_at', $lahColumns)) {
                $statsColumns[] = 'DATE(lah.assignment_started_at) as assignment_date';
                $groupBy[] = 'DATE(lah.assignment_started_at)';
            }
            
            if (in_array('department', $lahColumns)) {
                $statsColumns[] = 'lah.department';
                $groupBy[] = 'lah.department';
            }
            
            if (in_array('assignment_method', $lahColumns)) {
                $statsColumns[] = 'lah.assignment_method';
                $groupBy[] = 'lah.assignment_method';
            }
            
            if (in_array('assignment_type', $lahColumns)) {
                $statsColumns[] = 'lah.assignment_type';
                $groupBy[] = 'lah.assignment_type';
            }
            
            $statsColumns[] = 'COUNT(*) as total_assignments';
            
            if (in_array('was_automated', $lahColumns)) {
                $statsColumns[] = 'COUNT(CASE WHEN lah.was_automated = 1 THEN 1 END) as automated_assignments';
            }
            
            if (in_array('assignment_outcome', $lahColumns)) {
                $statsColumns[] = "COUNT(CASE WHEN lah.assignment_outcome = 'converted' THEN 1 END) as conversions";
                $statsColumns[] = "COUNT(CASE WHEN lah.assignment_outcome = 'reassigned' THEN 1 END) as reassignments";
            }
            
            if (in_array('days_assigned', $lahColumns)) {
                $statsColumns[] = 'AVG(lah.days_assigned) as avg_days_assigned';
            }
            
            if (in_array('response_time_hours', $lahColumns)) {
                $statsColumns[] = 'AVG(lah.response_time_hours) as avg_response_time_hours';
            }
            
            if (in_array('engagement_score_end', $lahColumns) && in_array('engagement_score_start', $lahColumns)) {
                $statsColumns[] = 'AVG(lah.engagement_score_end - lah.engagement_score_start) as avg_engagement_improvement';
            }
            
            if (in_array('final_conversion_value', $lahColumns)) {
                $statsColumns[] = 'SUM(lah.final_conversion_value) as total_conversion_value';
            }
            
            $statsColumnsSQL = implode(",\n                ", $statsColumns);
            $groupBySQL = implode(', ', $groupBy);
            
            $whereClause = '';
            if (in_array('assignment_started_at', $lahColumns)) {
                $whereClause = 'WHERE lah.assignment_started_at >= DATE_SUB(NOW(), INTERVAL 90 DAY)';
            }
            
            $groupClause = $groupBySQL ? "GROUP BY {$groupBySQL}" : '';
            
            DB::statement("
                CREATE OR REPLACE VIEW daily_assignment_stats AS
                SELECT
                    {$statsColumnsSQL}
                FROM lead_assignment_history lah
                {$whereClause}
                {$groupClause}
            ");
        }
    }
    
    /**
     * Add computed columns for better performance
     */
    private function addComputedColumns(): void
    {
        // Add computed columns to users table for faster queries
        Schema::table('users', function (Blueprint $table) {
            // Only add columns if they don't already exist
            if (!Schema::hasColumn('users', 'days_since_last_contact')) {
                $table->integer('days_since_last_contact')->nullable()->after('last_contact_date');
            }
            if (!Schema::hasColumn('users', 'days_until_follow_up')) {
                $table->integer('days_until_follow_up')->nullable()->after('next_follow_up_date');
            }
            if (!Schema::hasColumn('users', 'combined_priority_score')) {
                $table->decimal('combined_priority_score', 8, 3)->nullable()->after('engagement_score');
            }
        });
        
        // Add computed columns to admins table - only if table exists
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                // Only add columns if they don't already exist
                if (!Schema::hasColumn('admins', 'workload_score')) {
                    $table->decimal('workload_score', 5, 2)->nullable()->after('leads_converted_count');
                }
                if (!Schema::hasColumn('admins', 'efficiency_score')) {
                    $table->decimal('efficiency_score', 5, 2)->nullable()->after('workload_score');
                }
            });
        }
        
        // Add indexes for computed columns
        Schema::table('users', function (Blueprint $table) {
            try { $table->index('days_since_last_contact'); } catch (\Exception $e) {}
            try { $table->index('days_until_follow_up'); } catch (\Exception $e) {}
            try { $table->index('combined_priority_score'); } catch (\Exception $e) {}
            try { $table->index(['combined_priority_score', 'assigned_to_admin_id']); } catch (\Exception $e) {}
        });
        
        if (Schema::hasTable('admins')) {
            Schema::table('admins', function (Blueprint $table) {
                try { $table->index('workload_score'); } catch (\Exception $e) {}
                try { $table->index('efficiency_score'); } catch (\Exception $e) {}
                try { $table->index(['workload_score', 'is_available']); } catch (\Exception $e) {}
            });
        }
    }
    
    /**
     * Add full-text search indexes for better search performance
     */
    private function addFullTextIndexes(): void
    {
        // Add full-text search to users table
        try {
            DB::statement('ALTER TABLE users ADD FULLTEXT(name, email) WITH PARSER ngram');
        } catch (\Exception $e) {
            // Full-text index already exists or columns don't exist
        }
        
        // Add full-text search to admin audit logs - only if table exists
        if (Schema::hasTable('admin_audit_logs')) {
            try {
                DB::statement('ALTER TABLE admin_audit_logs ADD FULLTEXT(description, notes) WITH PARSER ngram');
            } catch (\Exception $e) {
                // Full-text index already exists or columns don't exist
            }
        }
        
        // Add full-text search to admin settings - only if table exists
        if (Schema::hasTable('admin_settings')) {
            try {
                DB::statement('ALTER TABLE admin_settings ADD FULLTEXT(display_name, description, help_text) WITH PARSER ngram');
            } catch (\Exception $e) {
                // Full-text index already exists or columns don't exist
            }
        }
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