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
        // İlk olarak yeni lead_status sütununu ekle
        Schema::table('users', function (Blueprint $table) {
            $table->string('lead_status', 50)->default('new')->after('lead_status_id');
        });

        // Mevcut lead_status_id verilerini lead_status name'e çevir
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

        // Şimdi lead_status_id sütununu kaldır
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['lead_status_id']);
            $table->dropColumn('lead_status_id');
        });

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