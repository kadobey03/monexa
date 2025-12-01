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
        // Languages tablosuna varsayılan dil kayıtlarını ekle
        DB::table('languages')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Turkish',
                'code' => 'tr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Russian', 
                'code' => 'ru',
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
        // Migration geri alınırsa bu kayıtları sil
        DB::table('languages')->whereIn('id', [1, 2])->delete();
    }
};