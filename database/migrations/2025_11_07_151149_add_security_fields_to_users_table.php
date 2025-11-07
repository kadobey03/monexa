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
        Schema::table('users', function (Blueprint ) {
            // 2FA güvenlik alanları
            $table->boolean('enable_2fa')->default(false)->after('password');
            $table->string('token_2fa', 6)->nullable()->after('enable_2fa');
            $table->timestamp('token_2fa_expiry')->nullable()->after('token_2fa');
            $table->boolean('pass_2fa')->default(false)->after('token_2fa_expiry');
            
            // Brute force koruma alanları
            $table->integer('failed_login_attempts')->default(0)->after('pass_2fa');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');
            $table->timestamp('last_login_at')->nullable()->after('locked_until');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            
            // Güvenlik log alanları
            $table->json('security_events')->nullable()->after('last_login_ip');
            $table->timestamp('password_changed_at')->nullable()->after('security_events');
            
            // Index'ler - performans için
            $table->index(['email', 'failed_login_attempts'], 'users_email_failed_attempts_idx');
            $table->index('locked_until', 'users_locked_until_idx');
            $table->index('token_2fa_expiry', 'users_token_2fa_expiry_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint ) {
            $table->dropIndex('users_email_failed_attempts_idx');
            $table->dropIndex('users_locked_until_idx');
            $table->dropIndex('users_token_2fa_expiry_idx');
            
            $table->dropColumn([
                'enable_2fa',
                'token_2fa',
                'token_2fa_expiry',
                'pass_2fa',
                'failed_login_attempts',
                'locked_until',
                'last_login_at',
                'last_login_ip',
                'security_events',
                'password_changed_at'
            ]);
        });
    }
};
