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
            if (!Schema::hasColumn('settings', 'timezone')) {
                $table->string('timezone', 50)->nullable()->default('UTC')->after('contact_email');
            }
            if (!Schema::hasColumn('settings', 'install_type')) {
                $table->string('install_type')->nullable()->after('timezone');
            }
            if (!Schema::hasColumn('settings', 'merchant_key')) {
                $table->string('merchant_key')->nullable()->after('install_type');
            }
            if (!Schema::hasColumn('settings', 'welcome_message')) {
                $table->string('welcome_message')->nullable()->after('merchant_key');
            }
            if (!Schema::hasColumn('settings', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('welcome_message');
            }
            if (!Schema::hasColumn('settings', 'twak')) {
                $table->string('twak')->nullable()->after('whatsapp');
            }
            if (!Schema::hasColumn('settings', 'tido')) {
                $table->string('tido')->nullable()->after('twak');
            }
            if (!Schema::hasColumn('settings', 'trading_winrate')) {
                $table->string('trading_winrate')->nullable()->after('tido');
            }
            if (!Schema::hasColumn('settings', 'usertheme')) {
                $table->string('usertheme')->nullable()->after('trading_winrate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'timezone',
                'install_type',
                'merchant_key',
                'welcome_message',
                'whatsapp',
                'twak',
                'tido',
                'trading_winrate',
                'usertheme'
            ]);
        });
    }
};
