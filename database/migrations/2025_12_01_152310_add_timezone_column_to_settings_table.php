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
            $table->string('timezone', 50)->nullable()->default('UTC')->after('contact_email');
            $table->string('install_type')->nullable()->after('timezone');
            $table->string('merchant_key')->nullable()->after('install_type');
            $table->string('welcome_message')->nullable()->after('merchant_key');
            $table->string('whatsapp')->nullable()->after('welcome_message');
            $table->string('twak')->nullable()->after('whatsapp');
            $table->string('tido')->nullable()->after('twak');
            $table->string('trading_winrate')->nullable()->after('tido');
            $table->string('usertheme')->nullable()->after('trading_winrate');
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
