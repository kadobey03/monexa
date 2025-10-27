<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('display_name', 100);
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'sort_order'], 'idx_active_sources');
        });

        // Insert default lead sources
        DB::table('lead_sources')->insert([
            [
                'name' => 'website_form',
                'display_name' => 'Website Form',
                'description' => 'Website contact form submissions',
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manual_entry',
                'display_name' => 'Manuel Giriş',
                'description' => 'Admin tarafından manuel olarak eklenen leadler',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'import',
                'display_name' => 'Import',
                'description' => 'Excel/CSV import ile eklenen leadler',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'referral',
                'display_name' => 'Referans',
                'description' => 'Mevcut müşterilerden gelen referanslar',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'social_media',
                'display_name' => 'Sosyal Medya',
                'description' => 'Sosyal medya kanallarından gelen leadler',
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'advertising',
                'display_name' => 'Reklam',
                'description' => 'Google Ads, Facebook Ads vb. reklamlardan gelen leadler',
                'color' => '#F97316',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'phone_call',
                'display_name' => 'Telefon',
                'description' => 'Direkt telefon ile gelen leadler',
                'color' => '#06B6D4',
                'is_active' => true,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'other',
                'display_name' => 'Diğer',
                'description' => 'Diğer kaynaklardan gelen leadler',
                'color' => '#6B7280',
                'is_active' => true,
                'sort_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        // Add foreign key to users table if lead_source_id exists
        if (Schema::hasColumn('users', 'lead_source_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('lead_source_id')
                      ->references('id')
                      ->on('lead_sources')
                      ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key first if it exists
        if (Schema::hasColumn('users', 'lead_source_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['lead_source_id']);
            });
        }
        
        Schema::dropIfExists('lead_sources');
    }
};