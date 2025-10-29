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
        Schema::table('users', function (Blueprint $table) {
            // Assignment tracking fields
            if (!Schema::hasColumn('users', 'assigned_to_admin_id')) {
                $table->unsignedBigInteger('assigned_to_admin_id')->nullable()->after('contact_history');
            }
            if (!Schema::hasColumn('users', 'previous_assigned_admin_id')) {
                $table->unsignedBigInteger('previous_assigned_admin_id')->nullable()->after('assigned_to_admin_id');
            }
            if (!Schema::hasColumn('users', 'first_assigned_at')) {
                $table->timestamp('first_assigned_at')->nullable()->after('previous_assigned_admin_id');
            }
            if (!Schema::hasColumn('users', 'current_assigned_at')) {
                $table->timestamp('current_assigned_at')->nullable()->after('first_assigned_at');
            }
            if (!Schema::hasColumn('users', 'last_reassigned_at')) {
                $table->timestamp('last_reassigned_at')->nullable()->after('current_assigned_at');
            }
            if (!Schema::hasColumn('users', 'assignment_count')) {
                $table->integer('assignment_count')->default(0)->after('last_reassigned_at'); // How many times reassigned
            }
            
            // Assignment performance tracking
            if (!Schema::hasColumn('users', 'days_with_current_admin')) {
                $table->integer('days_with_current_admin')->default(0)->after('assignment_count');
            }
            if (!Schema::hasColumn('users', 'conversion_probability')) {
                $table->decimal('conversion_probability', 5, 2)->nullable()->after('days_with_current_admin'); // AI prediction
            }
            if (!Schema::hasColumn('users', 'assignment_method')) {
                $table->string('assignment_method')->nullable()->after('conversion_probability'); // auto, manual, bulk
            }
            if (!Schema::hasColumn('users', 'assigned_by_admin_id')) {
                $table->unsignedBigInteger('assigned_by_admin_id')->nullable()->after('assignment_method'); // Who assigned
            }
            if (!Schema::hasColumn('users', 'assignment_reason')) {
                $table->text('assignment_reason')->nullable()->after('assigned_by_admin_id'); // Why assigned
            }
            
            // Lead lifecycle tracking
            if (!Schema::hasColumn('users', 'current_stage')) {
                $table->string('current_stage')->nullable()->after('assignment_reason'); // new, contacted, qualified, etc.
            }
            if (!Schema::hasColumn('users', 'stage_history')) {
                $table->json('stage_history')->nullable()->after('current_stage'); // Track stage changes
            }
            if (!Schema::hasColumn('users', 'last_stage_change')) {
                $table->timestamp('last_stage_change')->nullable()->after('stage_history');
            }
            if (!Schema::hasColumn('users', 'days_in_current_stage')) {
                $table->integer('days_in_current_stage')->default(0)->after('last_stage_change');
            }
            
            // Communication tracking
            if (!Schema::hasColumn('users', 'total_contact_attempts')) {
                $table->integer('total_contact_attempts')->default(0)->after('days_in_current_stage');
            }
            if (!Schema::hasColumn('users', 'successful_contacts')) {
                $table->integer('successful_contacts')->default(0)->after('total_contact_attempts');
            }
            if (!Schema::hasColumn('users', 'last_successful_contact')) {
                $table->timestamp('last_successful_contact')->nullable()->after('successful_contacts');
            }
            if (!Schema::hasColumn('users', 'communication_log')) {
                $table->json('communication_log')->nullable()->after('last_successful_contact'); // Detailed comm log
            }
            
            // Business metrics
            if (!Schema::hasColumn('users', 'potential_revenue')) {
                $table->decimal('potential_revenue', 15, 2)->nullable()->after('communication_log');
            }
            if (!Schema::hasColumn('users', 'priority_level')) {
                $table->string('priority_level')->default('normal')->after('potential_revenue'); // low, normal, high, urgent
            }
            if (!Schema::hasColumn('users', 'is_hot_lead')) {
                $table->boolean('is_hot_lead')->default(false)->after('priority_level');
            }
            if (!Schema::hasColumn('users', 'engagement_score')) {
                $table->decimal('engagement_score', 5, 2)->default(0)->after('is_hot_lead'); // 0-100
            }
            
            // Assignment rules and automation
            if (!Schema::hasColumn('users', 'assignment_criteria')) {
                $table->json('assignment_criteria')->nullable()->after('engagement_score'); // Auto-assignment criteria
            }
            if (!Schema::hasColumn('users', 'auto_reassign_enabled')) {
                $table->boolean('auto_reassign_enabled')->default(false)->after('assignment_criteria');
            }
            if (!Schema::hasColumn('users', 'max_days_with_admin')) {
                $table->integer('max_days_with_admin')->nullable()->after('auto_reassign_enabled'); // Auto-reassign after X days
            }
            if (!Schema::hasColumn('users', 'reassignment_triggers')) {
                $table->json('reassignment_triggers')->nullable()->after('max_days_with_admin'); // Conditions for reassignment
            }
            
            // Quality and compliance
            if (!Schema::hasColumn('users', 'lead_quality_score')) {
                $table->decimal('lead_quality_score', 5, 2)->nullable()->after('reassignment_triggers'); // 0-100
            }
            if (!Schema::hasColumn('users', 'requires_manager_approval')) {
                $table->boolean('requires_manager_approval')->default(false)->after('lead_quality_score');
            }
            if (!Schema::hasColumn('users', 'is_compliance_checked')) {
                $table->boolean('is_compliance_checked')->default(false)->after('requires_manager_approval');
            }
            if (!Schema::hasColumn('users', 'compliance_checked_at')) {
                $table->timestamp('compliance_checked_at')->nullable()->after('is_compliance_checked');
            }
            
            // Regional and timezone info
            if (!Schema::hasColumn('users', 'lead_timezone')) {
                $table->string('lead_timezone')->nullable()->after('compliance_checked_at');
            }
            if (!Schema::hasColumn('users', 'lead_region')) {
                $table->string('lead_region')->nullable()->after('lead_timezone');
            }
            if (!Schema::hasColumn('users', 'best_contact_times')) {
                $table->json('best_contact_times')->nullable()->after('lead_region'); // Preferred contact hours
            }
            
            // Campaign and source tracking
            if (!Schema::hasColumn('users', 'campaign_id')) {
                $table->string('campaign_id')->nullable()->after('best_contact_times');
            }
            if (!Schema::hasColumn('users', 'utm_source')) {
                $table->string('utm_source')->nullable()->after('campaign_id');
            }
            if (!Schema::hasColumn('users', 'utm_medium')) {
                $table->string('utm_medium')->nullable()->after('utm_source');
            }
            if (!Schema::hasColumn('users', 'utm_campaign')) {
                $table->string('utm_campaign')->nullable()->after('utm_medium');
            }
            if (!Schema::hasColumn('users', 'marketing_attribution')) {
                $table->json('marketing_attribution')->nullable()->after('utm_campaign');
            }
            
            // Foreign key constraints
            $table->foreign('assigned_to_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('previous_assigned_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('assigned_by_admin_id')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('assigned_to_admin_id');
            $table->index('previous_assigned_admin_id');
            $table->index('assigned_by_admin_id');
            $table->index('first_assigned_at');
            $table->index('current_assigned_at');
            $table->index('last_reassigned_at');
            $table->index('assignment_count');
            $table->index('current_stage');
            $table->index('priority_level');
            $table->index('is_hot_lead');
            $table->index('engagement_score');
            $table->index('lead_quality_score');
            $table->index(['assigned_to_admin_id', 'current_stage']);
            $table->index(['priority_level', 'is_hot_lead']);
            $table->index(['lead_region', 'lead_timezone']);
            $table->index('campaign_id');
            $table->index(['utm_source', 'utm_medium']);
            $table->index(['assignment_method', 'current_assigned_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['assigned_to_admin_id']);
            $table->dropForeign(['previous_assigned_admin_id']);
            $table->dropForeign(['assigned_by_admin_id']);
            
            // Drop indexes
            $table->dropIndex(['assigned_to_admin_id']);
            $table->dropIndex(['previous_assigned_admin_id']);
            $table->dropIndex(['assigned_by_admin_id']);
            $table->dropIndex(['first_assigned_at']);
            $table->dropIndex(['current_assigned_at']);
            $table->dropIndex(['last_reassigned_at']);
            $table->dropIndex(['assignment_count']);
            $table->dropIndex(['current_stage']);
            $table->dropIndex(['priority_level']);
            $table->dropIndex(['is_hot_lead']);
            $table->dropIndex(['engagement_score']);
            $table->dropIndex(['lead_quality_score']);
            $table->dropIndex(['assigned_to_admin_id', 'current_stage']);
            $table->dropIndex(['priority_level', 'is_hot_lead']);
            $table->dropIndex(['lead_region', 'lead_timezone']);
            $table->dropIndex(['campaign_id']);
            $table->dropIndex(['utm_source', 'utm_medium']);
            $table->dropIndex(['assignment_method', 'current_assigned_at']);
            
            // Drop columns
            $table->dropColumn([
                'assigned_to_admin_id',
                'previous_assigned_admin_id',
                'first_assigned_at',
                'current_assigned_at',
                'last_reassigned_at',
                'assignment_count',
                'days_with_current_admin',
                'conversion_probability',
                'assignment_method',
                'assigned_by_admin_id',
                'assignment_reason',
                'current_stage',
                'stage_history',
                'last_stage_change',
                'days_in_current_stage',
                'total_contact_attempts',
                'successful_contacts',
                'last_successful_contact',
                'communication_log',
                'potential_revenue',
                'priority_level',
                'is_hot_lead',
                'engagement_score',
                'assignment_criteria',
                'auto_reassign_enabled',
                'max_days_with_admin',
                'reassignment_triggers',
                'lead_quality_score',
                'requires_manager_approval',
                'is_compliance_checked',
                'compliance_checked_at',
                'lead_timezone',
                'lead_region',
                'best_contact_times',
                'campaign_id',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'marketing_attribution'
            ]);
        });
    }
};