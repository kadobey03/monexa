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
        Schema::table('user_table_settings', function (Blueprint $table) {
            // Add missing columns for enhanced dynamic table functionality
            if (!Schema::hasColumn('user_table_settings', 'pinned_columns')) {
                $table->json('pinned_columns')->nullable()->after('column_order');
            }
            
            if (!Schema::hasColumn('user_table_settings', 'default_sort_column')) {
                $table->string('default_sort_column', 100)->default('created_at')->after('sort_direction');
            }
            
            if (!Schema::hasColumn('user_table_settings', 'default_sort_direction')) {
                $table->enum('default_sort_direction', ['asc', 'desc'])->default('desc')->after('default_sort_column');
            }
            
            if (!Schema::hasColumn('user_table_settings', 'default_per_page')) {
                $table->integer('default_per_page')->default(25)->after('default_sort_direction');
            }
            
            if (!Schema::hasColumn('user_table_settings', 'filter_preferences')) {
                $table->json('filter_preferences')->nullable()->after('default_per_page');
            }
            
            // Remove old columns that are duplicated
            if (Schema::hasColumn('user_table_settings', 'page_size')) {
                $table->dropColumn('page_size');
            }
            
            if (Schema::hasColumn('user_table_settings', 'sort_column')) {
                $table->dropColumn('sort_column');
            }
            
            if (Schema::hasColumn('user_table_settings', 'sort_direction')) {
                $table->dropColumn('sort_direction');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_table_settings', function (Blueprint $table) {
            // Add back old columns
            $table->integer('page_size')->default(25)->after('filters');
            $table->string('sort_column', 100)->default('created_at')->after('page_size');
            $table->enum('sort_direction', ['asc', 'desc'])->default('desc')->after('sort_column');
            
            // Remove new columns
            $table->dropColumn([
                'pinned_columns',
                'default_sort_column',
                'default_sort_direction', 
                'default_per_page',
                'filter_preferences'
            ]);
        });
    }
};