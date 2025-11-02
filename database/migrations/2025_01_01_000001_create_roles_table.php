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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // super_admin, head_of_office, sales_head, etc.
            $table->string('display_name'); // Gösterim adı
            $table->text('description')->nullable(); // Rol açıklaması
            $table->integer('hierarchy_level')->default(0); // Hiyerarşi seviyesi (0 en üst)
            $table->unsignedBigInteger('parent_role_id')->nullable(); // Parent rol için self-referencing
            $table->boolean('is_active')->default(true); // Aktif/pasif durumu
            $table->json('settings')->nullable(); // Rol özel ayarları
            $table->timestamps();
            
            // Foreign key constraint for parent role
            $table->foreign('parent_role_id')->references('id')->on('roles')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('name');
            $table->index('hierarchy_level');
            $table->index('parent_role_id');
            $table->index(['is_active', 'hierarchy_level']);
        });
        
        // Insert default roles with hierarchy
        DB::table('roles')->insert([
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'System super administrator with full access',
                'hierarchy_level' => 0,
                'parent_role_id' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'head_of_office',
                'display_name' => 'Head of Office',
                'description' => 'Office head with regional management authority',
                'hierarchy_level' => 1,
                'parent_role_id' => 1, // super_admin
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sales_head',
                'display_name' => 'Sales Head',
                'description' => 'Head of sales department',
                'hierarchy_level' => 2,
                'parent_role_id' => 2, // head_of_office
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'team_leader',
                'display_name' => 'Team Leader',
                'description' => 'Sales team leader',
                'hierarchy_level' => 3,
                'parent_role_id' => 3, // sales_head
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sale',
                'display_name' => 'Sales Representative',
                'description' => 'Sales representative',
                'hierarchy_level' => 4,
                'parent_role_id' => 4, // team_leader
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention_head',
                'display_name' => 'Retention Head',
                'description' => 'Head of retention department',
                'hierarchy_level' => 2,
                'parent_role_id' => 2, // head_of_office
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention_team_leader',
                'display_name' => 'Retention Team Leader',
                'description' => 'Retention team leader',
                'hierarchy_level' => 3,
                'parent_role_id' => 6, // retention_head
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'retention',
                'display_name' => 'Retention Specialist',
                'description' => 'Retention specialist',
                'hierarchy_level' => 4,
                'parent_role_id' => 7, // retention_team_leader
                'is_active' => true,
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
        Schema::dropIfExists('roles');
    }
};