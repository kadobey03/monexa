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
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Setting anahtarı
            $table->string('category')->default('general'); // general, lead_assignment, notifications, etc.
            $table->string('type')->default('string'); // string, integer, boolean, json, array, etc.
            $table->text('value')->nullable(); // Setting değeri
            $table->text('default_value')->nullable(); // Default değer
            $table->text('description')->nullable(); // Setting açıklaması
            $table->string('display_name'); // Gösterim adı
            
            // Validation and constraints
            $table->json('validation_rules')->nullable(); // Validation kuralları
            $table->json('options')->nullable(); // Dropdown options if applicable
            $table->text('help_text')->nullable(); // Help text for users
            $table->boolean('is_required')->default(false); // Required setting mi?
            $table->boolean('is_encrypted')->default(false); // Şifreli saklanacak mı?
            
            // Access control
            $table->json('allowed_roles')->nullable(); // Hangi roller bu ayarı değiştirebilir
            $table->json('view_roles')->nullable(); // Hangi roller bu ayarı görebilir
            $table->boolean('is_system')->default(false); // System setting (değiştirilemez)
            $table->boolean('requires_restart')->default(false); // Sistem yeniden başlatılması gerekli mi?
            
            // UI and grouping
            $table->string('group_name')->nullable(); // Ayarları gruplamak için
            $table->integer('sort_order')->default(0); // Sıralama
            $table->boolean('is_visible')->default(true); // UI'da gösterilecek mi?
            $table->string('input_type')->default('text'); // text, select, checkbox, textarea, etc.
            
            // Environment and context
            $table->json('environment_specific')->nullable(); // Ortam özel değerler
            $table->boolean('affects_performance')->default(false); // Performance etkiler mi?
            $table->boolean('affects_security')->default(false); // Güvenlik etkiler mi?
            $table->json('dependencies')->nullable(); // Bağımlı olduğu diğer ayarlar
            
            // Change tracking
            $table->unsignedBigInteger('modified_by')->nullable(); // Son değiştiren admin
            $table->timestamp('last_modified')->nullable(); // Son değişiklik zamanı
            $table->json('change_history')->nullable(); // Değişiklik geçmişi
            $table->text('change_reason')->nullable(); // Değişiklik sebebi
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('modified_by')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('key');
            $table->index('category');
            $table->index('type');
            $table->index('group_name');
            $table->index('sort_order');
            $table->index(['category', 'group_name']);
            $table->index(['is_visible', 'sort_order']);
            $table->index('modified_by');
            $table->index('last_modified');
        });
        
        // Insert default admin settings
        $this->insertDefaultSettings();
    }
    
    /**
     * Insert default admin settings
     */
    private function insertDefaultSettings()
    {
        $settings = [
            // Lead Assignment Settings
            [
                'key' => 'lead_assignment_method',
                'category' => 'lead_assignment',
                'type' => 'string',
                'value' => 'round_robin',
                'default_value' => 'round_robin',
                'display_name' => 'Lead Assignment Method',
                'description' => 'Default method for assigning leads to admins',
                'group_name' => 'assignment_rules',
                'input_type' => 'select',
                'options' => json_encode(['round_robin' => 'Round Robin', 'load_based' => 'Load Based', 'manual' => 'Manual Only']),
                'sort_order' => 1,
            ],
            [
                'key' => 'max_leads_per_admin',
                'category' => 'lead_assignment',
                'type' => 'integer',
                'value' => '50',
                'default_value' => '50',
                'display_name' => 'Max Leads Per Admin',
                'description' => 'Maximum number of leads an admin can have at once',
                'group_name' => 'assignment_limits',
                'input_type' => 'number',
                'sort_order' => 2,
            ],
            [
                'key' => 'auto_reassign_inactive_days',
                'category' => 'lead_assignment',
                'type' => 'integer',
                'value' => '7',
                'default_value' => '7',
                'display_name' => 'Auto Reassign After (Days)',
                'description' => 'Automatically reassign leads after X days of inactivity',
                'group_name' => 'reassignment_rules',
                'input_type' => 'number',
                'sort_order' => 3,
            ],
            
            // Notification Settings
            [
                'key' => 'email_notifications_enabled',
                'category' => 'notifications',
                'type' => 'boolean',
                'value' => 'true',
                'default_value' => 'true',
                'display_name' => 'Email Notifications',
                'description' => 'Enable email notifications for admins',
                'group_name' => 'email_settings',
                'input_type' => 'checkbox',
                'sort_order' => 10,
            ],
            [
                'key' => 'sms_notifications_enabled',
                'category' => 'notifications',
                'type' => 'boolean',
                'value' => 'false',
                'default_value' => 'false',
                'display_name' => 'SMS Notifications',
                'description' => 'Enable SMS notifications for admins',
                'group_name' => 'sms_settings',
                'input_type' => 'checkbox',
                'sort_order' => 11,
            ],
            
            // Security Settings
            [
                'key' => 'session_timeout_minutes',
                'category' => 'security',
                'type' => 'integer',
                'value' => '60',
                'default_value' => '60',
                'display_name' => 'Session Timeout (Minutes)',
                'description' => 'Admin session timeout in minutes',
                'group_name' => 'session_management',
                'input_type' => 'number',
                'affects_security' => true,
                'sort_order' => 20,
            ],
            [
                'key' => 'require_two_factor',
                'category' => 'security',
                'type' => 'boolean',
                'value' => 'false',
                'default_value' => 'false',
                'display_name' => 'Require Two-Factor Authentication',
                'description' => 'Require 2FA for all admin accounts',
                'group_name' => 'authentication',
                'input_type' => 'checkbox',
                'affects_security' => true,
                'sort_order' => 21,
            ],
            
            // Performance Settings
            [
                'key' => 'leads_per_page',
                'category' => 'performance',
                'type' => 'integer',
                'value' => '25',
                'default_value' => '25',
                'display_name' => 'Leads Per Page',
                'description' => 'Number of leads to show per page',
                'group_name' => 'pagination',
                'input_type' => 'select',
                'options' => json_encode(['10' => '10', '25' => '25', '50' => '50', '100' => '100']),
                'affects_performance' => true,
                'sort_order' => 30,
            ],
            
            // Reporting Settings
            [
                'key' => 'default_report_period',
                'category' => 'reporting',
                'type' => 'string',
                'value' => '30_days',
                'default_value' => '30_days',
                'display_name' => 'Default Report Period',
                'description' => 'Default time period for reports',
                'group_name' => 'report_defaults',
                'input_type' => 'select',
                'options' => json_encode(['7_days' => '7 Days', '30_days' => '30 Days', '90_days' => '90 Days', '1_year' => '1 Year']),
                'sort_order' => 40,
            ],
            
            // System Settings
            [
                'key' => 'maintenance_mode',
                'category' => 'system',
                'type' => 'boolean',
                'value' => 'false',
                'default_value' => 'false',
                'display_name' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode',
                'group_name' => 'system_status',
                'input_type' => 'checkbox',
                'is_system' => true,
                'allowed_roles' => json_encode(['super_admin']),
                'requires_restart' => true,
                'sort_order' => 50,
            ],
        ];
        
        foreach ($settings as $setting) {
            DB::table('admin_settings')->insert(array_merge($setting, [
                'is_visible' => $setting['is_visible'] ?? true,
                'is_required' => $setting['is_required'] ?? false,
                'is_encrypted' => $setting['is_encrypted'] ?? false,
                'is_system' => $setting['is_system'] ?? false,
                'affects_performance' => $setting['affects_performance'] ?? false,
                'affects_security' => $setting['affects_security'] ?? false,
                'requires_restart' => $setting['requires_restart'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};