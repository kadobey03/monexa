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
        Schema::table('roles', function (Blueprint $table) {
            // Only add deleted_at column if it doesn't already exist
            if (!Schema::hasColumn('roles', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable()->after('updated_at');
            }
        });

        Schema::table('permissions', function (Blueprint $table) {
            // Only add deleted_at column if it doesn't already exist
            if (!Schema::hasColumn('permissions', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable()->after('updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Only drop deleted_at column if it exists
            if (Schema::hasColumn('roles', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });

        Schema::table('permissions', function (Blueprint $table) {
            // Only drop deleted_at column if it exists
            if (Schema::hasColumn('permissions', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};