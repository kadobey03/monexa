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
        Schema::create('lead_assignment_history', function (Blueprint $table) {
            $table->id();
            
            // Core assignment info
            $table->unsignedBigInteger('user_id'); // Lead (user) ID
            $table->unsignedBigInteger('assigned_from_admin_id')->nullable(); // Previously assigned admin
            $table->unsignedBigInteger('assigned_to_admin_id'); // Newly assigned admin
            $table->unsignedBigInteger('assigned_by_admin_id')->nullable(); // Admin who performed assignment
            
            // Assignment details
            $table->string('assignment_type'); // initial, reassignment, bulk_assignment, auto_assignment
            $table->string('assignment_method'); // manual, round_robin, load_based, skill_based, geographic
            $table->text('reason')->nullable(); // Reason for assignment/reassignment
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            
            // Lead state at assignment time
            $table->string('lead_status_at_assignment')->nullable(); // Lead status when assigned
            $table->decimal('lead_score_at_assignment', 5, 2)->nullable(); // Lead score when assigned
            $table->decimal('estimated_value_at_assignment', 15, 2)->nullable(); // Estimated value when assigned
            $table->json('lead_tags_at_assignment')->nullable(); // Lead tags when assigned
            
            // Admin workload at assignment time
            $table->integer('admin_lead_count_before')->default(0); // Admin's lead count before assignment
            $table->integer('admin_lead_count_after')->default(0); // Admin's lead count after assignment
            $table->decimal('admin_performance_score', 5, 2)->nullable(); // Admin's performance at assignment time
            $table->string('admin_availability_status')->nullable(); // available, busy, offline
            
            // Geographic and timing info
            $table->string('lead_timezone')->nullable(); // Lead's timezone
            $table->string('lead_region')->nullable(); // Lead's region
            $table->string('admin_timezone')->nullable(); // Admin's timezone
            $table->json('assignment_rules_applied')->nullable(); // Which rules were applied
            
            // Business context
            $table->string('campaign_id')->nullable(); // Campaign associated with lead
            $table->string('lead_source')->nullable(); // Source of the lead
            $table->string('department')->nullable(); // sales, retention, support
            $table->unsignedBigInteger('admin_group_id')->nullable(); // Admin group at assignment time
            
            // Assignment outcome tracking
            $table->timestamp('assignment_started_at'); // When assignment was made
            $table->timestamp('assignment_ended_at')->nullable(); // When assignment ended (reassigned/converted/lost)
            $table->integer('days_assigned')->nullable(); // How many days lead was with this admin
            $table->string('assignment_outcome')->nullable(); // converted, reassigned, lost, active
            $table->decimal('final_conversion_value', 15, 2)->nullable(); // Final conversion value if converted
            
            // Communication and activity tracking
            $table->integer('contacts_made')->default(0); // Contacts made during this assignment
            $table->timestamp('first_contact_at')->nullable(); // First contact during this assignment
            $table->timestamp('last_contact_at')->nullable(); // Last contact during this assignment
            $table->json('communication_summary')->nullable(); // Summary of communications
            
            // Performance metrics
            $table->decimal('response_time_hours', 8, 2)->nullable(); // Time to first response
            $table->integer('follow_up_count')->default(0); // Number of follow-ups
            $table->decimal('engagement_score_start', 5, 2)->nullable(); // Lead engagement at start
            $table->decimal('engagement_score_end', 5, 2)->nullable(); // Lead engagement at end
            $table->boolean('sla_met')->nullable(); // Was SLA met during this assignment
            
            // System and automation info
            $table->boolean('was_automated')->default(false); // Was assignment automated
            $table->string('assignment_algorithm')->nullable(); // Algorithm used for auto-assignment
            $table->json('algorithm_factors')->nullable(); // Factors considered by algorithm
            $table->decimal('assignment_confidence', 5, 2)->nullable(); // Confidence score for assignment
            
            // Bulk assignment tracking
            $table->string('bulk_assignment_id')->nullable(); // Group ID for bulk assignments
            $table->integer('bulk_assignment_batch_size')->nullable(); // Size of bulk assignment batch
            $table->integer('bulk_assignment_sequence')->nullable(); // Sequence in bulk assignment
            
            // Quality and compliance
            $table->boolean('requires_manager_approval')->default(false); // Required approval
            $table->unsignedBigInteger('approved_by_admin_id')->nullable(); // Who approved assignment
            $table->timestamp('approved_at')->nullable(); // When approved
            $table->boolean('is_compliant')->nullable(); // Assignment follows compliance rules
            $table->text('compliance_notes')->nullable(); // Compliance notes
            
            // Additional metadata
            $table->json('metadata')->nullable(); // Additional data
            $table->json('custom_fields')->nullable(); // Custom tracking fields
            $table->text('notes')->nullable(); // Assignment notes
            $table->json('flags')->nullable(); // Special flags or markers
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_from_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('assigned_to_admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('assigned_by_admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('admin_group_id')->references('id')->on('admin_groups')->onDelete('set null');
            $table->foreign('approved_by_admin_id')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('user_id');
            $table->index('assigned_to_admin_id');
            $table->index('assigned_by_admin_id');
            $table->index('assigned_from_admin_id');
            $table->index('assignment_started_at');
            $table->index('assignment_ended_at');
            $table->index('assignment_type');
            $table->index('assignment_method');
            $table->index('assignment_outcome');
            $table->index('department');
            $table->index('admin_group_id');
            $table->index('bulk_assignment_id');
            $table->index('campaign_id');
            $table->index('lead_source');
            
            // Composite indexes for common queries
            $table->index(['user_id', 'assignment_started_at'], 'user_assignment_time_idx');
            $table->index(['assigned_to_admin_id', 'assignment_started_at'], 'admin_assignment_time_idx');
            $table->index(['assignment_type', 'assignment_started_at'], 'type_assignment_time_idx');
            $table->index(['department', 'assignment_outcome'], 'dept_outcome_idx');
            $table->index(['assigned_to_admin_id', 'assignment_outcome'], 'admin_outcome_idx');
            $table->index(['was_automated', 'assignment_started_at'], 'auto_assignment_time_idx');
            $table->index(['priority', 'assignment_started_at'], 'priority_time_idx');
            $table->index(['lead_region', 'assignment_started_at'], 'region_time_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_assignment_history');
    }
};