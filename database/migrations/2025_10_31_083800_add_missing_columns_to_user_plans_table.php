<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToUserPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_plans', function (Blueprint $table) {
            // Add 'active' column only if it doesn't exist
            if (!Schema::hasColumn('user_plans', 'active')) {
                $table->string('active')->default('yes')->after('amount');
            }
            
            // Add 'assets' column only if it doesn't exist
            if (!Schema::hasColumn('user_plans', 'assets')) {
                $table->string('assets')->nullable()->after('active');
            }
            
            // Add 'leverage' column only if it doesn't exist
            if (!Schema::hasColumn('user_plans', 'leverage')) {
                $table->string('leverage')->nullable()->after('assets');
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
        Schema::table('user_plans', function (Blueprint $table) {
            $table->dropColumn(['active', 'assets', 'leverage']);
        });
    }
}