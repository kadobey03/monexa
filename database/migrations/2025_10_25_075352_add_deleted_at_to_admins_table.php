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
        Schema::table('admins', function (Blueprint $table) {
            // Only add deleted_at column if it doesn't already exist
            if (!Schema::hasColumn('admins', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Only drop deleted_at column if it exists
            if (Schema::hasColumn('admins', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};
