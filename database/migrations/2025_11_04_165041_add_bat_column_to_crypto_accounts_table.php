<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crypto_accounts', function (Blueprint $table) {
            // Add 'bat' column only if it doesn't exist
            if (!Schema::hasColumn('crypto_accounts', 'bat')) {
                $table->float('bat', 8, 2)->default(0.00)->after('link');
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
        Schema::table('crypto_accounts', function (Blueprint $table) {
            $table->dropColumn('bat');
        });
    }
};