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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Dil kodu: tr, ru, en');
            $table->string('name', 100)->comment('Dil adı: Türkçe, Русский, English');
            $table->string('native_name', 100)->comment('Yerel dil adı');
            $table->string('flag_icon', 50)->nullable()->comment('Bayrak ikonu: flag-tr, flag-ru');
            $table->boolean('is_active')->default(true)->comment('Dil aktif durumu');
            $table->boolean('is_default')->default(false)->comment('Varsayılan dil mi');
            $table->integer('sort_order')->default(0)->comment('Sıralama değeri');
            $table->timestamps();
            
            // Indexes
            $table->index('code', 'idx_languages_code');
            $table->index('is_active', 'idx_languages_active');
            $table->index('is_default', 'idx_languages_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
