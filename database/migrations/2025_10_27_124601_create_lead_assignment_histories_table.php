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
        // Only create table if it doesn't already exist
        if (!Schema::hasTable('lead_assignment_histories')) {
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
            
            // Indexes for better performance - using custom shorter names
            $table->index(['user_id', 'assignment_outcome', 'assignment_ended_at'], 'lah_user_outcome_ended_idx');
            $table->index('assigned_to_admin_id', 'lah_assigned_to_admin_idx');
            $table->index('assignment_type', 'lah_assignment_type_idx');
            $table->index('department', 'lah_department_idx');
            });
        }
        
        // Add indexes if table exists but indexes might not exist
        if (Schema::hasTable('lead_assignment_histories')) {
            Schema::table('lead_assignment_histories', function (Blueprint $table) {
                // Check if indexes don't exist before adding them
                try {
                    $indexes = \DB::select("SHOW INDEX FROM lead_assignment_histories");
                    $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
                    
                    if (!in_array('lah_user_outcome_ended_idx', $existingIndexes)) {
                        $table->index(['user_id', 'assignment_outcome', 'assignment_ended_at'], 'lah_user_outcome_ended_idx');
                    }
                    if (!in_array('lah_assigned_to_admin_idx', $existingIndexes)) {
                        $table->index('assigned_to_admin_id', 'lah_assigned_to_admin_idx');
                    }
                    if (!in_array('lah_assignment_type_idx', $existingIndexes)) {
                        $table->index('assignment_type', 'lah_assignment_type_idx');
                    }
                    if (!in_array('lah_department_idx', $existingIndexes)) {
                        $table->index('department', 'lah_department_idx');
                    }
                } catch (\Exception $e) {
                    // Ignore if there are any issues checking indexes
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_assignment_histories');
    }
};
