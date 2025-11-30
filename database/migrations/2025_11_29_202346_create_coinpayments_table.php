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
        Schema::create('coinpayments', function (Blueprint $table) {
            $table->id();
            $table->string('cp_p_key')->nullable();
            $table->string('cp_pv_key')->nullable();
            $table->string('cp_m_id')->nullable();
            $table->string('cp_debug_email')->nullable();
            $table->string('cp_ipn_secret')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coinpayments');
    }
};
