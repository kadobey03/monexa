<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminTestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Test Admin Groups
        $groups = [
            [
                'id' => 1,
                'name' => 'Test Merkez Ofis',
                'description' => 'Ana merkez ofis test grubu',
                'department' => 'management',
                'region' => 'istanbul',
                'is_active' => true,
                'group_leader_id' => null, // Will be set later
                'parent_group_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Test Satış Takımı',
                'description' => 'Satış ekibi test grubu',
                'department' => 'sales',
                'region' => 'istanbul',
                'is_active' => true,
                'group_leader_id' => null, // Will be set later
                'parent_group_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Test Destek Takımı',
                'description' => 'Müşteri destek test grubu',
                'department' => 'support',
                'region' => 'ankara',
                'is_active' => true,
                'group_leader_id' => null, // Will be set later
                'parent_group_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Test Junior Satış',
                'description' => 'Junior satış elemanları test grubu',
                'department' => 'sales',
                'region' => 'izmir',
                'is_active' => true,
                'group_leader_id' => null, // Will be set later
                'parent_group_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert admin groups
        foreach ($groups as $group) {
            DB::table('admin_groups')->updateOrInsert(['id' => $group['id']], $group);
        }

        // Test Admin Users with hierarchy
        $testAdmins = [
            [
                'id' => 100,
                'firstName' => 'Super',
                'lastName' => 'Admin',
                'email' => 'superadmin@test.com',
                'phone_number' => '+90 555 100 0001',
                'password' => Hash::make('Test123!'),
                'role_id' => 1, // super_admin
                'admin_group_id' => 1,
                'supervisor_id' => null,
                'subordinate_ids' => json_encode([101, 102, 103]),
                'employee_id' => 'EMP001',
                'department' => 'management',
                'position' => 'Sistem Yöneticisi',
                'hierarchy_level' => 0,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '09:00-18:00', 'tuesday' => '09:00-18:00', 'wednesday' => '09:00-18:00', 'thursday' => '09:00-18:00', 'friday' => '09:00-18:00']),
                'is_available' => true,
                'last_activity' => $now,
                'last_login_at' => $now->subHours(2),
                'leads_assigned_count' => 0,
                'leads_converted_count' => 0,
                'monthly_target' => 0,
                'current_performance' => 100.0,
                'performance_rating' => 'excellent',
                'login_count' => 50,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Super Admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 101,
                'firstName' => 'Ahmet',
                'lastName' => 'Yönetici',
                'email' => 'ahmet.yonetici@test.com',
                'phone_number' => '+90 555 100 0002',
                'password' => Hash::make('Test123!'),
                'role_id' => 2, // head_of_office
                'admin_group_id' => 1,
                'supervisor_id' => 100,
                'subordinate_ids' => json_encode([102, 103, 104, 105]),
                'employee_id' => 'EMP002',
                'department' => 'management',
                'position' => 'Ofis Müdürü',
                'hierarchy_level' => 1,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '08:30-17:30', 'tuesday' => '08:30-17:30', 'wednesday' => '08:30-17:30', 'thursday' => '08:30-17:30', 'friday' => '08:30-17:30']),
                'is_available' => true,
                'last_activity' => $now->subMinutes(30),
                'last_login_at' => $now->subHours(1),
                'leads_assigned_count' => 25,
                'leads_converted_count' => 8,
                'monthly_target' => 30,
                'current_performance' => 85.5,
                'performance_rating' => 'good',
                'login_count' => 42,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 102,
                'firstName' => 'Mehmet',
                'lastName' => 'Satış Müdürü',
                'email' => 'mehmet.satis@test.com',
                'phone_number' => '+90 555 100 0003',
                'password' => Hash::make('Test123!'),
                'role_id' => 3, // sales_head
                'admin_group_id' => 2,
                'supervisor_id' => 101,
                'subordinate_ids' => json_encode([104, 105, 106]),
                'employee_id' => 'EMP003',
                'department' => 'sales',
                'position' => 'Satış Müdürü',
                'hierarchy_level' => 2,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '09:00-18:00', 'tuesday' => '09:00-18:00', 'wednesday' => '09:00-18:00', 'thursday' => '09:00-18:00', 'friday' => '09:00-18:00']),
                'is_available' => true,
                'last_activity' => $now->subMinutes(15),
                'last_login_at' => $now->subMinutes(45),
                'leads_assigned_count' => 45,
                'leads_converted_count' => 18,
                'monthly_target' => 50,
                'current_performance' => 92.0,
                'performance_rating' => 'excellent',
                'login_count' => 38,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Sales Manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 103,
                'firstName' => 'Fatma',
                'lastName' => 'Destek Müdürü',
                'email' => 'fatma.destek@test.com',
                'phone_number' => '+90 555 100 0004',
                'password' => Hash::make('Test123!'),
                'role_id' => 4, // support_head
                'admin_group_id' => 3,
                'supervisor_id' => 101,
                'subordinate_ids' => json_encode([107, 108]),
                'employee_id' => 'EMP004',
                'department' => 'support',
                'position' => 'Destek Müdürü',
                'hierarchy_level' => 2,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '08:00-17:00', 'tuesday' => '08:00-17:00', 'wednesday' => '08:00-17:00', 'thursday' => '08:00-17:00', 'friday' => '08:00-17:00']),
                'is_available' => true,
                'last_activity' => $now->subHours(1),
                'last_login_at' => $now->subHours(3),
                'leads_assigned_count' => 35,
                'leads_converted_count' => 12,
                'monthly_target' => 40,
                'current_performance' => 78.5,
                'performance_rating' => 'good',
                'login_count' => 28,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Support Manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 104,
                'firstName' => 'Ali',
                'lastName' => 'Senior Satış',
                'email' => 'ali.satis@test.com',
                'phone_number' => '+90 555 100 0005',
                'password' => Hash::make('Test123!'),
                'role_id' => 5, // senior_sales
                'admin_group_id' => 2,
                'supervisor_id' => 102,
                'subordinate_ids' => json_encode([106, 109]),
                'employee_id' => 'EMP005',
                'department' => 'sales',
                'position' => 'Senior Satış Temsilcisi',
                'hierarchy_level' => 3,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '09:30-18:30', 'tuesday' => '09:30-18:30', 'wednesday' => '09:30-18:30', 'thursday' => '09:30-18:30', 'friday' => '09:30-18:30']),
                'is_available' => true,
                'last_activity' => $now->subMinutes(5),
                'last_login_at' => $now->subMinutes(10),
                'leads_assigned_count' => 55,
                'leads_converted_count' => 22,
                'monthly_target' => 60,
                'current_performance' => 95.5,
                'performance_rating' => 'excellent',
                'login_count' => 45,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Senior Sales',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 105,
                'firstName' => 'Zeynep',
                'lastName' => 'Satış Temsilcisi',
                'email' => 'zeynep.satis@test.com',
                'phone_number' => '+90 555 100 0006',
                'password' => Hash::make('Test123!'),
                'role_id' => 6, // sales_representative
                'admin_group_id' => 2,
                'supervisor_id' => 102,
                'subordinate_ids' => null,
                'employee_id' => 'EMP006',
                'department' => 'sales',
                'position' => 'Satış Temsilcisi',
                'hierarchy_level' => 3,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '09:00-18:00', 'tuesday' => '09:00-18:00', 'wednesday' => '09:00-18:00', 'thursday' => '09:00-18:00', 'friday' => '09:00-18:00']),
                'is_available' => false, // Currently busy
                'last_activity' => $now->subMinutes(20),
                'last_login_at' => $now->subMinutes(25),
                'leads_assigned_count' => 42,
                'leads_converted_count' => 15,
                'monthly_target' => 45,
                'current_performance' => 88.0,
                'performance_rating' => 'good',
                'login_count' => 33,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Sales Rep',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 106,
                'firstName' => 'Emre',
                'lastName' => 'Junior Satış',
                'email' => 'emre.junior@test.com',
                'phone_number' => '+90 555 100 0007',
                'password' => Hash::make('Test123!'),
                'role_id' => 7, // junior_sales
                'admin_group_id' => 4,
                'supervisor_id' => 104,
                'subordinate_ids' => null,
                'employee_id' => 'EMP007',
                'department' => 'sales',
                'position' => 'Junior Satış Temsilcisi',
                'hierarchy_level' => 4,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '10:00-19:00', 'tuesday' => '10:00-19:00', 'wednesday' => '10:00-19:00', 'thursday' => '10:00-19:00', 'friday' => '10:00-19:00']),
                'is_available' => true,
                'last_activity' => $now->subHours(2),
                'last_login_at' => $now->subHours(4),
                'leads_assigned_count' => 28,
                'leads_converted_count' => 7,
                'monthly_target' => 30,
                'current_performance' => 72.0,
                'performance_rating' => 'average',
                'login_count' => 20,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Junior Sales',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 107,
                'firstName' => 'Ayşe',
                'lastName' => 'Destek Uzmanı',
                'email' => 'ayse.destek@test.com',
                'phone_number' => '+90 555 100 0008',
                'password' => Hash::make('Test123!'),
                'role_id' => 8, // support_specialist
                'admin_group_id' => 3,
                'supervisor_id' => 103,
                'subordinate_ids' => null,
                'employee_id' => 'EMP008',
                'department' => 'support',
                'position' => 'Destek Uzmanı',
                'hierarchy_level' => 3,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '08:00-17:00', 'tuesday' => '08:00-17:00', 'wednesday' => '08:00-17:00', 'thursday' => '08:00-17:00', 'friday' => '08:00-17:00', 'saturday' => '10:00-15:00']),
                'is_available' => true,
                'last_activity' => $now->subMinutes(40),
                'last_login_at' => $now->subHours(1),
                'leads_assigned_count' => 38,
                'leads_converted_count' => 9,
                'monthly_target' => 35,
                'current_performance' => 81.5,
                'performance_rating' => 'good',
                'login_count' => 31,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Support',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 108,
                'firstName' => 'Burak',
                'lastName' => 'Teknik Destek',
                'email' => 'burak.teknik@test.com',
                'phone_number' => '+90 555 100 0009',
                'password' => Hash::make('Test123!'),
                'role_id' => 8, // support_specialist
                'admin_group_id' => 3,
                'supervisor_id' => 103,
                'subordinate_ids' => null,
                'employee_id' => 'EMP009',
                'department' => 'support',
                'position' => 'Teknik Destek Uzmanı',
                'hierarchy_level' => 3,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '10:00-19:00', 'tuesday' => '10:00-19:00', 'wednesday' => '10:00-19:00', 'thursday' => '10:00-19:00', 'friday' => '10:00-19:00']),
                'is_available' => false, // Offline
                'last_activity' => $now->subHours(12),
                'last_login_at' => $now->subHours(18),
                'leads_assigned_count' => 22,
                'leads_converted_count' => 4,
                'monthly_target' => 25,
                'current_performance' => 68.0,
                'performance_rating' => 'needs_improvement',
                'login_count' => 15,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Technical Support',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 109,
                'firstName' => 'Deniz',
                'lastName' => 'Trainee',
                'email' => 'deniz.trainee@test.com',
                'phone_number' => '+90 555 100 0010',
                'password' => Hash::make('Test123!'),
                'role_id' => 9, // trainee
                'admin_group_id' => 4,
                'supervisor_id' => 104,
                'subordinate_ids' => null,
                'employee_id' => 'EMP010',
                'department' => 'sales',
                'position' => 'Stajyer',
                'hierarchy_level' => 5,
                'time_zone' => 'Europe/Istanbul',
                'work_schedule' => json_encode(['monday' => '09:00-17:00', 'tuesday' => '09:00-17:00', 'wednesday' => '09:00-17:00', 'thursday' => '09:00-17:00', 'friday' => '09:00-17:00']),
                'is_available' => true,
                'last_activity' => $now->subMinutes(60),
                'last_login_at' => $now->subHours(2),
                'leads_assigned_count' => 12,
                'leads_converted_count' => 2,
                'monthly_target' => 15,
                'current_performance' => 55.0,
                'performance_rating' => 'learning',
                'login_count' => 8,
                'two_factor' => 0,
                'status' => 1,
                'type' => 'Trainee',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert test admin users
        foreach ($testAdmins as $admin) {
            DB::table('admins')->updateOrInsert(['id' => $admin['id']], $admin);
        }

        // Update group leaders
        DB::table('admin_groups')->where('id', 1)->update(['group_leader_id' => 101]); // Ahmet Yönetici
        DB::table('admin_groups')->where('id', 2)->update(['group_leader_id' => 102]); // Mehmet Satış Müdürü
        DB::table('admin_groups')->where('id', 3)->update(['group_leader_id' => 103]); // Fatma Destek Müdürü
        DB::table('admin_groups')->where('id', 4)->update(['group_leader_id' => 104]); // Ali Senior Satış

        // Add some audit log entries for testing
        $auditLogs = [
            [
                'admin_id' => 100,
                'admin_name' => 'Super Admin',
                'admin_email' => 'superadmin@test.com',
                'action' => 'login',
                'entity_type' => 'admin',
                'entity_id' => 100,
                'description' => 'Super admin logged in successfully',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'occurred_at' => $now->subHours(2),
                'severity' => 'info',
                'category' => 'authentication',
                'created_at' => $now->subHours(2),
                'updated_at' => $now->subHours(2),
            ],
            [
                'admin_id' => 101,
                'admin_name' => 'Ahmet Yönetici',
                'admin_email' => 'ahmet.yonetici@test.com',
                'action' => 'create',
                'entity_type' => 'user',
                'entity_id' => 1234,
                'description' => 'Created new user account',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'occurred_at' => $now->subMinutes(30),
                'severity' => 'info',
                'category' => 'user_management',
                'created_at' => $now->subMinutes(30),
                'updated_at' => $now->subMinutes(30),
            ],
            [
                'admin_id' => 102,
                'admin_name' => 'Mehmet Satış Müdürü',
                'admin_email' => 'mehmet.satis@test.com',
                'action' => 'assign_lead',
                'entity_type' => 'lead',
                'entity_id' => 5678,
                'description' => 'Assigned lead to junior sales representative',
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'occurred_at' => $now->subMinutes(15),
                'severity' => 'info',
                'category' => 'lead_management',
                'created_at' => $now->subMinutes(15),
                'updated_at' => $now->subMinutes(15),
            ],
        ];

        foreach ($auditLogs as $log) {
            DB::table('admin_audit_logs')->insert($log);
        }

        $this->command->info('✅ Test admin users, groups, and audit logs created successfully!');
        $this->printLoginCredentials();
    }

    private function printLoginCredentials(): void
    {
        $this->command->info("\n🔐 TEST KULLANICI GİRİŞ BİLGİLERİ:");
        $this->command->info("=====================================");
        
        $credentials = [
            [
                'role' => 'Super Admin (Tüm İzinler)',
                'name' => 'Super Admin', 
                'email' => 'superadmin@test.com',
                'password' => 'Test123!',
                'department' => 'Management',
                'level' => '0 - En Üst Seviye'
            ],
            [
                'role' => 'Ofis Müdürü',
                'name' => 'Ahmet Yönetici',
                'email' => 'ahmet.yonetici@test.com', 
                'password' => 'Test123!',
                'department' => 'Management',
                'level' => '1 - Yönetim'
            ],
            [
                'role' => 'Satış Müdürü',
                'name' => 'Mehmet Satış Müdürü',
                'email' => 'mehmet.satis@test.com',
                'password' => 'Test123!', 
                'department' => 'Sales',
                'level' => '2 - Departman Müdürü'
            ],
            [
                'role' => 'Destek Müdürü', 
                'name' => 'Fatma Destek Müdürü',
                'email' => 'fatma.destek@test.com',
                'password' => 'Test123!',
                'department' => 'Support', 
                'level' => '2 - Departman Müdürü'
            ],
            [
                'role' => 'Senior Satış',
                'name' => 'Ali Senior Satış',
                'email' => 'ali.satis@test.com',
                'password' => 'Test123!',
                'department' => 'Sales',
                'level' => '3 - Senior Seviye'
            ],
            [
                'role' => 'Satış Temsilcisi',
                'name' => 'Zeynep Satış Temsilcisi', 
                'email' => 'zeynep.satis@test.com',
                'password' => 'Test123!',
                'department' => 'Sales',
                'level' => '3 - Orta Seviye'
            ],
            [
                'role' => 'Junior Satış',
                'name' => 'Emre Junior Satış',
                'email' => 'emre.junior@test.com',
                'password' => 'Test123!', 
                'department' => 'Sales',
                'level' => '4 - Junior Seviye'
            ],
            [
                'role' => 'Destek Uzmanı',
                'name' => 'Ayşe Destek Uzmanı',
                'email' => 'ayse.destek@test.com',
                'password' => 'Test123!',
                'department' => 'Support',
                'level' => '3 - Uzman Seviye'
            ],
            [
                'role' => 'Teknik Destek',
                'name' => 'Burak Teknik Destek',
                'email' => 'burak.teknik@test.com', 
                'password' => 'Test123!',
                'department' => 'Support',
                'level' => '3 - Uzman Seviye'
            ],
            [
                'role' => 'Stajyer',
                'name' => 'Deniz Trainee',
                'email' => 'deniz.trainee@test.com',
                'password' => 'Test123!',
                'department' => 'Sales',
                'level' => '5 - Giriş Seviyesi'
            ]
        ];

        foreach ($credentials as $cred) {
            $this->command->info("👤 {$cred['role']} - {$cred['name']}");
            $this->command->info("   📧 Email: {$cred['email']}");
            $this->command->info("   🔑 Şifre: {$cred['password']}");
            $this->command->info("   🏢 Departman: {$cred['department']}");
            $this->command->info("   📊 Seviye: {$cred['level']}");
            $this->command->info("   ---");
        }
        
        $this->command->info("\n🌟 HİYERARŞİK YAPI:");
        $this->command->info("Super Admin (100) → Ofis Müdürü (101)");  
        $this->command->info("  ├── Satış Müdürü (102)");
        $this->command->info("  │   ├── Senior Satış (104) → Junior Satış (106), Stajyer (109)");
        $this->command->info("  │   └── Satış Temsilcisi (105)");
        $this->command->info("  └── Destek Müdürü (103)");
        $this->command->info("      ├── Destek Uzmanı (107)");
        $this->command->info("      └── Teknik Destek (108)");
        
        $this->command->info("\n📝 TEST ÖNERİLERİ:");
        $this->command->info("• Farklı seviyedeki kullanıcılarla giriş yapıp izin kısıtlamalarını test edin");
        $this->command->info("• Hiyerarşi görünümünde organizasyon yapısını inceleyin");
        $this->command->info("• İzin matrisinde rol-izin ilişkilerini test edin"); 
        $this->command->info("• Alt seviyedeki kullanıcıların üst seviyedekileri göremediğini doğrulayın");
        $this->command->info("• Bulk operations ve filtreleme özelliklerini deneyin");
    }
}