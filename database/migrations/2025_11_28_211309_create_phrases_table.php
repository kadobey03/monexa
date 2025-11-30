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
        Schema::create('phrases', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255)->unique()->comment('Çeviri anahtarı: auth.login, dashboard.welcome');
            $table->string('group', 100)->default('general')->comment('Grup adı: auth, dashboard, email');
            $table->text('description')->nullable()->comment('Açıklama ve kullanım alanı');
            $table->json('parameters')->nullable()->comment('Çeviride kullanılan parametreler: {name, count}');
            $table->boolean('is_active')->default(true)->comment('Aktif durumu');
            $table->enum('context', ['web', 'email', 'sms', 'api', 'all'])
                  ->default('all')->comment('Kullanım bağlamı');
            $table->timestamp('last_used_at')->nullable()->comment('Son kullanım tarihi');
            $table->integer('usage_count')->default(0)->comment('Kullanım sayısı');
            $table->timestamps();
            
            // Indexes
            $table->index('key', 'idx_phrases_key');
            $table->index('group', 'idx_phrases_group');
            $table->index('is_active', 'idx_phrases_active');
            $table->index('context', 'idx_phrases_context');
            $table->index('last_used_at', 'idx_phrases_last_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phrases');
    }
};
