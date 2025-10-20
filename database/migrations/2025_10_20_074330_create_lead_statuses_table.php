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
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('color', 7)->default('#6c757d'); // hex color code
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('lead_statuses')->insert([
            [
                'name' => 'new',
                'display_name' => 'Yeni Lead',
                'color' => '#17a2b8',
                'description' => 'Yeni kayıt olmuş potansiyel müşteri',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'contacted',
                'display_name' => 'İletişime Geçildi',
                'color' => '#ffc107',
                'description' => 'Müşteri ile ilk iletişim kuruldu',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'interested',
                'display_name' => 'İlgileniyor',
                'color' => '#fd7e14',
                'description' => 'Müşteri ürünlere ilgi gösteriyor',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'negotiation',
                'display_name' => 'Görüşme Aşamasında',
                'color' => '#6f42c1',
                'description' => 'Müşteri ile detaylı görüşmeler yapılıyor',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'converted',
                'display_name' => 'Müşteri Oldu',
                'color' => '#28a745',
                'description' => 'Lead başarılı şekilde müşteriye dönüştürüldü',
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'lost',
                'display_name' => 'Kaybedildi',
                'color' => '#dc3545',
                'description' => 'Lead kaybedildi, müşteri olmadı',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_statuses');
    }
};