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
        Schema::create('phrase_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phrase_id')->constrained('phrases')->onDelete('cascade')
                  ->comment('Phrases tablosuna referans');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade')
                  ->comment('Languages tablosuna referans');
            $table->text('translation')->comment('Çeviri metni');
            $table->text('plural_translation')->nullable()
                  ->comment('Çoğul formu çevirisi (count parametresi için)');
            $table->json('metadata')->nullable()
                  ->comment('Ek bilgiler: tone, context, notes');
            $table->boolean('is_reviewed')->default(false)
                  ->comment('Çeviri gözden geçirildi mi');
            $table->boolean('needs_update')->default(false)
                  ->comment('Güncelleme gerekiyor mu');
            $table->string('reviewer', 100)->nullable()
                  ->comment('Gözden geçiren admin');
            $table->timestamp('reviewed_at')->nullable()
                  ->comment('Gözden geçirilme tarihi');
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['phrase_id', 'language_id'], 'uk_phrase_language');
            
            // Indexes
            $table->index('phrase_id', 'idx_phrase_translations_phrase');
            $table->index('language_id', 'idx_phrase_translations_language');
            $table->index('is_reviewed', 'idx_phrase_translations_reviewed');
            $table->index('needs_update', 'idx_phrase_translations_needs_update');
            $table->index('reviewed_at', 'idx_phrase_translations_reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phrase_translations');
    }
};
