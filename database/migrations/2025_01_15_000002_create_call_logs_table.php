<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('phone_number', 50);
            $table->enum('call_type', ['direct', 'webrtc', 'whatsapp', 'system'])->default('direct');
            $table->enum('status', ['attempted', 'answered', 'busy', 'no_answer', 'failed', 'sent'])->default('attempted');
            $table->integer('duration')->nullable()->comment('Duration in seconds');
            $table->text('notes')->nullable();
            $table->timestamp('call_started_at');
            $table->timestamp('call_ended_at')->nullable();
            $table->string('external_call_id', 100)->nullable();
            $table->json('call_metadata')->nullable();
            $table->timestamps();

            $table->index(['lead_id', 'created_at'], 'idx_call_lead_created');
            $table->index(['admin_id', 'created_at'], 'idx_call_admin_created');
            $table->index(['call_started_at'], 'idx_call_started');
            $table->index(['status'], 'idx_call_status');
            $table->index(['call_type'], 'idx_call_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_logs');
    }
};