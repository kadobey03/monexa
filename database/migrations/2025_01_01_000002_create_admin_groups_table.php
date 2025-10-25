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
        Schema::create('admin_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // sales_team_1, retention_team_a, etc.
            $table->string('display_name'); // Gösterim adı
            $table->text('description')->nullable(); // Grup açıklaması
            $table->string('department'); // sales, retention, support, etc.
            $table->unsignedBigInteger('group_leader_id')->nullable(); // Grup lideri
            $table->unsignedBigInteger('parent_group_id')->nullable(); // Parent grup için self-referencing
            $table->json('settings')->nullable(); // Grup özel ayarları
            $table->boolean('is_active')->default(true); // Aktif/pasif durumu
            $table->integer('max_members')->nullable(); // Maksimum üye sayısı
            $table->decimal('target_amount', 15, 2)->nullable(); // Hedef tutar
            $table->string('region')->nullable(); // Bölge bilgisi
            $table->string('time_zone')->default('UTC'); // Zaman dilimi
            $table->json('working_hours')->nullable(); // Çalışma saatleri
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('group_leader_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('parent_group_id')->references('id')->on('admin_groups')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('name');
            $table->index('department');
            $table->index('group_leader_id');
            $table->index('parent_group_id');
            $table->index(['is_active', 'department']);
            $table->index('region');
        });
        
        // Insert default groups
        DB::table('admin_groups')->insert([
            [
                'name' => 'sales_main',
                'display_name' => 'Main Sales Team',
                'description' => 'Primary sales team',
                'department' => 'sales',
                'group_leader_id' => null,
                'parent_group_id' => null,
                'is_active' => true,
                'max_members' => 50,
                'region' => 'global',
                'time_zone' => 'UTC',
                'working_hours' => json_encode(['start' => '09:00', 'end' => '18:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sales_team_a',
                'display_name' => 'Sales Team A',
                'description' => 'Sales Team A - New Leads',
                'department' => 'sales',
                'group_leader_id' => null,
                'parent_group_id' => 1,
                'is_active' => true,
                'max_members' => 10,
                'region' => 'europe',
                'time_zone' => 'UTC+1',
                'working_hours' => json_encode(['start' => '08:00', 'end' => '17:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sales_team_b',
                'display_name' => 'Sales Team B',
                'description' => 'Sales Team B - Warm Leads',
                'department' => 'sales',
                'group_leader_id' => null,
                'parent_group_id' => 1,
                'is_active' => true,
                'max_members' => 10,
                'region' => 'asia',
                'time_zone' => 'UTC+3',
                'working_hours' => json_encode(['start' => '09:00', 'end' => '18:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention_main',
                'display_name' => 'Main Retention Team',
                'description' => 'Primary retention team',
                'department' => 'retention',
                'group_leader_id' => null,
                'parent_group_id' => null,
                'is_active' => true,
                'max_members' => 30,
                'region' => 'global',
                'time_zone' => 'UTC',
                'working_hours' => json_encode(['start' => '09:00', 'end' => '18:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention_team_alpha',
                'display_name' => 'Retention Team Alpha',
                'description' => 'Retention Team Alpha - High Value Customers',
                'department' => 'retention',
                'group_leader_id' => null,
                'parent_group_id' => 4,
                'is_active' => true,
                'max_members' => 8,
                'region' => 'europe',
                'time_zone' => 'UTC+1',
                'working_hours' => json_encode(['start' => '08:00', 'end' => '17:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention_team_beta',
                'display_name' => 'Retention Team Beta',
                'description' => 'Retention Team Beta - Standard Customers',
                'department' => 'retention',
                'group_leader_id' => null,
                'parent_group_id' => 4,
                'is_active' => true,
                'max_members' => 12,
                'region' => 'asia',
                'time_zone' => 'UTC+3',
                'working_hours' => json_encode(['start' => '10:00', 'end' => '19:00', 'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_groups');
    }
};