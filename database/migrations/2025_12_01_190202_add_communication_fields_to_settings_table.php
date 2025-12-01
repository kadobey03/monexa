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
        Schema::table('settings', function (Blueprint $table) {
            // Only add columns that don't exist
            if (!Schema::hasColumn('settings', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('tawk_to');
            }
            if (!Schema::hasColumn('settings', 'telegram')) {
                $table->string('telegram')->nullable()->after('tawk_to');
            }
            if (!Schema::hasColumn('settings', 'tido')) {
                $table->string('tido')->nullable()->after('tawk_to');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('settings', 'whatsapp')) {
                $columns[] = 'whatsapp';
            }
            if (Schema::hasColumn('settings', 'telegram')) {
                $columns[] = 'telegram';
            }
            if (Schema::hasColumn('settings', 'tido')) {
                $columns[] = 'tido';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};