<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            // Add missing columns for activity logging with conditional checks
            if (!Schema::hasColumn('activities', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('activities', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('activities', 'device')) {
                $table->string('device')->nullable()->after('ip_address');
            }
            
            if (!Schema::hasColumn('activities', 'browser')) {
                $table->string('browser')->nullable()->after('device');
            }
            
            if (!Schema::hasColumn('activities', 'os')) {
                $table->string('os')->nullable()->after('browser');
            }
            
            if (!Schema::hasColumn('activities', 'activity_type')) {
                $table->string('activity_type')->nullable()->after('os');
            }
            
            if (!Schema::hasColumn('activities', 'description')) {
                $table->text('description')->nullable()->after('activity_type');
            }
            
            if (!Schema::hasColumn('activities', 'metadata')) {
                $table->json('metadata')->nullable()->after('description');
            }
        });
        
        // Add foreign key and indexes in a separate schema operation to avoid conflicts
        Schema::table('activities', function (Blueprint $table) {
            // Add foreign key constraint if users table exists and foreign key doesn't exist
            if (Schema::hasTable('users') && Schema::hasColumn('activities', 'user_id')) {
                // Check if foreign key constraint already exists
                $foreignKeyExists = \DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.KEY_COLUMN_USAGE
                    WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = 'activities'
                    AND CONSTRAINT_NAME = 'activities_user_id_foreign'
                ");
                
                if (!$foreignKeyExists[0]->count) {
                    try {
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    } catch (\Exception $e) {
                        // Foreign key might already exist, ignore the error
                    }
                }
            }
            
            // Add indexes safely by checking existence first
            if (Schema::hasColumn('activities', 'user_id')) {
                $indexExists = \DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.statistics
                    WHERE table_schema = DATABASE()
                    AND table_name = 'activities'
                    AND index_name = 'activities_user_id_index'
                ");
                if (!$indexExists[0]->count) {
                    $table->index('user_id');
                }
            }
            
            if (Schema::hasColumn('activities', 'ip_address')) {
                $indexExists = \DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.statistics
                    WHERE table_schema = DATABASE()
                    AND table_name = 'activities'
                    AND index_name = 'activities_ip_address_index'
                ");
                if (!$indexExists[0]->count) {
                    $table->index('ip_address');
                }
            }
            
            if (Schema::hasColumn('activities', 'activity_type')) {
                $indexExists = \DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.statistics
                    WHERE table_schema = DATABASE()
                    AND table_name = 'activities'
                    AND index_name = 'activities_activity_type_index'
                ");
                if (!$indexExists[0]->count) {
                    $table->index('activity_type');
                }
            }
            
            if (Schema::hasColumn('activities', 'created_at')) {
                $indexExists = \DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.statistics
                    WHERE table_schema = DATABASE()
                    AND table_name = 'activities'
                    AND index_name = 'activities_created_at_index'
                ");
                if (!$indexExists[0]->count) {
                    $table->index('created_at');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            // Drop foreign key if it exists
            if (Schema::hasTable('users')) {
                $table->dropForeign(['user_id']);
            }
            
            // Drop added columns
            $table->dropColumn([
                'user_id',
                'ip_address',
                'device', 
                'browser',
                'os',
                'activity_type',
                'description',
                'metadata'
            ]);
        });
    }
}