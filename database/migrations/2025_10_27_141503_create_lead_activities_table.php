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
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('activity_type', [
                'created', 'updated', 'status_changed', 'assigned', 'contacted',
                'note_added', 'follow_up_scheduled', 'email_sent', 'call_made', 
                'meeting_scheduled', 'converted', 'lost', 'imported'
            ]);
            $table->string('activity_title', 255);
            $table->text('activity_description')->nullable();
            $table->json('activity_data')->nullable(); // Store additional data like old/new values
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('is_system_generated')->default(false);
            $table->boolean('is_visible_to_lead')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('lead_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index(['lead_id', 'created_at'], 'idx_lead_activities');
            $table->index(['admin_id', 'created_at'], 'idx_admin_activities');
            $table->index(['activity_type', 'created_at'], 'idx_activity_type');
            $table->index(['is_system_generated'], 'idx_system_generated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
    }
};