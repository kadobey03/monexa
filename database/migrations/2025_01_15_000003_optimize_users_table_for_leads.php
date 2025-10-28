<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('users', 'contact_count')) {
                $table->integer('contact_count')->default(0)->after('contact_history');
            }
            
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->string('account_type', 20)->default('lead')->after('status');
            }

            if (!Schema::hasColumn('users', 'lead_priority')) {
                $table->enum('lead_priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('lead_score');
            }

            if (!Schema::hasColumn('users', 'conversion_probability')) {
                $table->decimal('conversion_probability', 5, 2)->nullable()->after('lead_priority');
            }

            // Improve existing phone field length if needed
            $table->string('phone', 50)->nullable()->change();
            
            // Add performance indexes for lead queries
            $table->index(['account_type', 'created_at'], 'idx_account_type_created');
            $table->index(['assign_to', 'account_type'], 'idx_assign_account_type');
            $table->index(['lead_status_id', 'created_at'], 'idx_lead_status_created');
            $table->index(['country', 'account_type'], 'idx_country_account_type');
            $table->index(['lead_source', 'created_at'], 'idx_lead_source_created');
            $table->index(['lead_score', 'account_type'], 'idx_lead_score_account');
            $table->index(['last_contact_date'], 'idx_last_contact_date');
            $table->index(['next_follow_up_date'], 'idx_next_follow_up_date');
            $table->index(['created_at', 'account_type'], 'idx_created_account_type');
            $table->index(['estimated_value', 'account_type'], 'idx_estimated_value_account');
            
            // Composite indexes for complex lead queries
            $table->index(['assign_to', 'lead_status_id', 'created_at'], 'idx_assign_status_created');
            $table->index(['country', 'lead_source', 'account_type'], 'idx_country_source_account');
            $table->index(['lead_priority', 'lead_score', 'account_type'], 'idx_priority_score_account');
        });

        // Add full-text search index for better search performance (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            try {
                DB::statement('ALTER TABLE users ADD FULLTEXT fulltext_lead_search (name, email, lead_notes)');
            } catch (\Exception $e) {
                // Ignore if fulltext index already exists or not supported
            }
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove new columns
            $columns = ['contact_count', 'account_type', 'lead_priority', 'conversion_probability'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Remove indexes
            $indexes = [
                'idx_account_type_created',
                'idx_assign_account_type',
                'idx_lead_status_created',
                'idx_country_account_type',
                'idx_lead_source_created',
                'idx_lead_score_account',
                'idx_last_contact_date',
                'idx_next_follow_up_date',
                'idx_created_account_type',
                'idx_estimated_value_account',
                'idx_assign_status_created',
                'idx_country_source_account',
                'idx_priority_score_account'
            ];
            
            foreach ($indexes as $index) {
                try {
                    $table->dropIndex($index);
                } catch (\Exception $e) {
                    // Ignore if index doesn't exist
                }
            }
        });

        // Remove full-text index
        if (DB::getDriverName() === 'mysql') {
            try {
                DB::statement('ALTER TABLE users DROP INDEX fulltext_lead_search');
            } catch (\Exception $e) {
                // Ignore if index doesn't exist
            }
        }
    }
};