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
            // Add missing fields for dynamic table functionality
            if (!Schema::hasColumn('users', 'lead_priority')) {
                $table->enum('lead_priority', ['low', 'medium', 'high', 'urgent'])
                      ->default('medium')
                      ->after('lead_score');
            }
            
            if (!Schema::hasColumn('users', 'conversion_probability')) {
                $table->integer('conversion_probability')
                      ->default(0)
                      ->after('lead_priority')
                      ->comment('Conversion probability percentage 0-100');
            }
            
            if (!Schema::hasColumn('users', 'lead_source_id')) {
                $table->unsignedBigInteger('lead_source_id')
                      ->nullable()
                      ->after('conversion_probability');
            }
            
            // Add performance indexes for dynamic table
            $table->index(['lead_priority', 'lead_score'], 'idx_priority_score_dynamic');
            $table->index(['conversion_probability'], 'idx_conversion_prob_v2');
            $table->index(['lead_source', 'created_at'], 'idx_source_created_v2');
            $table->index(['cstatus', 'lead_status_id'], 'idx_cstatus_leadstatus_v2');
            
            // Composite indexes for complex queries (renamed to avoid conflicts)
            $table->index(['assign_to', 'lead_status_id', 'created_at'], 'idx_assign_status_created_v2');
            $table->index(['lead_priority', 'assign_to'], 'idx_priority_assign_v2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['idx_priority_score_dynamic']);
            $table->dropIndex(['idx_conversion_prob_v2']);
            $table->dropIndex(['idx_source_created_v2']);
            $table->dropIndex(['idx_cstatus_leadstatus_v2']);
            $table->dropIndex(['idx_assign_status_created_v2']);
            $table->dropIndex(['idx_priority_assign_v2']);
            
            $table->dropColumn([
                'lead_priority',
                'conversion_probability', 
                'lead_source_id'
            ]);
        });
    }
};