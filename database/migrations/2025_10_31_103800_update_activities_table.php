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
            // Add missing columns for activity logging
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->string('ip_address', 45)->nullable()->after('user_id');
            $table->string('device')->nullable()->after('ip_address');
            $table->string('browser')->nullable()->after('device');
            $table->string('os')->nullable()->after('browser');
            $table->string('activity_type')->nullable()->after('os');
            $table->text('description')->nullable()->after('activity_type');
            $table->json('metadata')->nullable()->after('description');
            
            // Add foreign key constraint if users table exists
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            // Add indexes for better performance
            $table->index('user_id');
            $table->index('ip_address');
            $table->index('activity_type');
            $table->index('created_at');
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