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
            // Lead status fields
            $table->unsignedBigInteger('lead_status_id')->nullable();
            $table->text('lead_notes')->nullable()->after('lead_status_id');
            $table->timestamp('last_contact_date')->nullable()->after('lead_notes');
            $table->timestamp('next_follow_up_date')->nullable()->after('last_contact_date');
            $table->string('lead_source')->nullable()->after('next_follow_up_date'); // import, manual, web_form, etc.
            $table->json('lead_tags')->nullable()->after('lead_source'); // flexible tagging system
            $table->decimal('estimated_value', 15, 2)->nullable()->after('lead_tags');
            $table->integer('lead_score')->default(0)->after('estimated_value'); // lead scoring system
            $table->string('preferred_contact_method')->nullable()->after('lead_score'); // phone, email, whatsapp
            $table->json('contact_history')->nullable()->after('preferred_contact_method'); // log of all contacts
            
            // Lead assignment field - DÜZELTME: Eksik olan sütun eklendi
            $table->unsignedBigInteger('assign_to')->nullable()->after('contact_history')->comment('Admin ID for lead assignment');
            
            // Add foreign key constraints
            $table->foreign('lead_status_id')->references('id')->on('lead_statuses')->onDelete('set null');
            $table->foreign('assign_to')->references('id')->on('admins')->onDelete('set null');
            
            // Add indexes for better performance
            $table->index('lead_status_id');
            $table->index('assign_to');
            $table->index(['lead_status_id', 'assign_to']);
            $table->index('last_contact_date');
            $table->index('next_follow_up_date');
            $table->index('lead_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['lead_status_id']);
            $table->dropIndex(['lead_status_id']);
            $table->dropIndex(['assign_to']);
            $table->dropIndex(['lead_status_id', 'assign_to']);
            $table->dropIndex(['last_contact_date']);
            $table->dropIndex(['next_follow_up_date']);
            $table->dropIndex(['lead_score']);
            
            $table->dropForeign(['assign_to']);
            
            $table->dropColumn([
                'lead_status_id',
                'lead_notes',
                'last_contact_date',
                'next_follow_up_date',
                'lead_source',
                'lead_tags',
                'estimated_value',
                'lead_score',
                'preferred_contact_method',
                'contact_history',
                'assign_to'
            ]);
        });
    }
};