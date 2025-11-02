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
        Schema::table('users', function (Blueprint $table) {
            // Şirket bilgisi için alanlar ekleniyor
            $table->string('company_name', 255)->nullable()->after('phone');
            $table->string('organization', 255)->nullable()->after('company_name');
            
            // Performans için indexler ekleniyor
            $table->index('company_name');
            $table->index('organization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Indexleri kaldır
            $table->dropIndex(['company_name']);
            $table->dropIndex(['organization']);
            
            // Alanları kaldır
            $table->dropColumn(['company_name', 'organization']);
        });
    }
};
