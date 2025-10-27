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
        Schema::create('lead_assignment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_to_admin_id')->nullable();
            $table->unsignedBigInteger('assigned_from_admin_id')->nullable();
            $table->unsignedBigInteger('assigned_by_admin_id')->nullable();
            $table->string('assignment_type')->nullable();
            $table->string('assignment_method')->nullable();
            $table->text('reason')->nullable();
            $table->string('priority')->default('normal');
            $table->unsignedTinyInteger('lead_status_at_assignment')->nullable();
            $table->decimal('lead_score_at_assignment', 5, 2)->nullable();
            $table->decimal('estimated_value_at_assignment', 10, 2)->nullable();
            $table->json('lead_tags_at_assignment')->nullable();
            $table->integer('admin_lead_count_before')->nullable();
            $table->integer('admin_lead_count_after')->nullable();
            $table->decimal('admin_performance_score', 5, 2)->nullable();
            $table->string('admin_availability_status')->nullable();
            $table->string('lead_timezone')->nullable();
            $table->string('lead_region')->nullable();
            $table->string('admin_timezone')->nullable();
            $table->json('assignment_rules_applied')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('department')->nullable();
            $table->unsignedBigInteger('admin_group_id')->nullable();
            $table->string('assignment_outcome')->default('active');
            $table->timestamp('assignment_started_at')->nullable();
            $table->timestamp('assignment_ended_at')->nullable();
            $table->integer('days_assigned')->nullable();
            $table->decimal('final_conversion_value', 10, 2)->nullable();
            $table->integer('contacts_made')->default(0);
            $table->timestamp('first_contact_at')->nullable();
            $table->timestamp('last_contact_at')->nullable();
            $table->json('communication_summary')->nullable();
            $table->decimal('response_time_hours', 8, 2)->nullable();
            $table->integer('follow_up_count')->default(0);
            $table->decimal('engagement_score_start', 5, 2)->nullable();
            $table->decimal('engagement_score_end', 5, 2)->nullable();
            $table->boolean('sla_met')->nullable();
            $table->boolean('was_automated')->default(false);
            $table->string('assignment_algorithm')->nullable();
            $table->json('algorithm_factors')->nullable();
            $table->decimal('assignment_confidence', 5, 2)->nullable();
            $table->string('bulk_assignment_id')->nullable();
            $table->integer('bulk_assignment_batch_size')->nullable();
            $table->integer('bulk_assignment_sequence')->nullable();
            $table->boolean('requires_manager_approval')->default(false);
            $table->unsignedBigInteger('approved_by_admin_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_compliant')->default(true);
            $table->text('compliance_notes')->nullable();
            $table->json('metadata')->nullable();
            $table->json('custom_fields')->nullable();
            $table->text('notes')->nullable();
            $table->json('flags')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'assignment_outcome', 'assignment_ended_at']);
            $table->index('assigned_to_admin_id');
            $table->index('assignment_type');
            $table->index('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_assignment_histories');
    }
};
