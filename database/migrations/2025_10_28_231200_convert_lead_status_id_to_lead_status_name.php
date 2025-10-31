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
        // İlk olarak yeni lead_status sütununu ekle (sadece yoksa)
        if (!Schema::hasColumn('users', 'lead_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('lead_status', 50)->default('new');
            });
        }

        // Mevcut lead_status_id verilerini lead_status name'e çevir (sadece lead_status_id varsa)
        if (Schema::hasColumn('users', 'lead_status_id')) {
            $statusMappings = [
                1 => 'new',
                2 => 'contacted',
                3 => 'interested',
                4 => 'negotiation',
                5 => 'converted',
                6 => 'lost'
            ];

            foreach ($statusMappings as $statusId => $statusName) {
                DB::table('users')
                    ->where('lead_status_id', $statusId)
                    ->update(['lead_status' => $statusName]);
            }

            // NULL olan lead_status_id değerlerini de 'new' yap
            DB::table('users')
                ->whereNull('lead_status_id')
                ->update(['lead_status' => 'new']);
        } else {
            // lead_status_id yoksa, tüm users için default değeri set et
            DB::table('users')
                ->whereNull('lead_status')
                ->orWhere('lead_status', '')
                ->update(['lead_status' => 'new']);
        }

        // lead_status_id sütununu kaldır (sadece varsa) - Basitleştirilmiş versiyon
        if (Schema::hasColumn('users', 'lead_status_id')) {
            // SQLite'da direkt drop column yapmaya çalış - eğer hata verirse devam et
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('lead_status_id');
                });
            } catch (\Exception $e) {
                // SQLite'da column drop edilemiyorsa, sadece devam et
                // Çünkü lead_status sütunu zaten mevcut ve kullanılabilir
            }
        }

        // Index ekle performance için
        Schema::table('users', function (Blueprint $table) {
            $table->index('lead_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Geri alma: lead_status_id sütununu tekrar ekle
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_status_id')->nullable()->after('lead_status');
            $table->foreign('lead_status_id')->references('id')->on('lead_statuses')->onDelete('set null');
        });

        // lead_status name'lerini tekrar ID'lere çevir
        $statusMappings = [
            'new' => 1,
            'contacted' => 2,
            'interested' => 3,
            'negotiation' => 4,
            'converted' => 5,
            'lost' => 6
        ];

        foreach ($statusMappings as $statusName => $statusId) {
            DB::table('users')
                ->where('lead_status', $statusName)
                ->update(['lead_status_id' => $statusId]);
        }

        // lead_status sütununu kaldır
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['lead_status']);
            $table->dropColumn('lead_status');
        });
    }
};