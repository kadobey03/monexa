-- Test Admin Users and Groups Data
-- Generated: 2025-10-25
-- Purpose: Create comprehensive test users for Admin Panel testing

-- Test Admin Groups
INSERT IGNORE INTO `admin_groups` (`id`, `name`, `description`, `department`, `region`, `is_active`, `group_leader_id`, `parent_group_id`, `created_at`, `updated_at`) VALUES
(1, 'Test Merkez Ofis', 'Ana merkez ofis test grubu', 'management', 'istanbul', 1, NULL, NULL, NOW(), NOW()),
(2, 'Test Satış Takımı', 'Satış ekibi test grubu', 'sales', 'istanbul', 1, NULL, 1, NOW(), NOW()),
(3, 'Test Destek Takımı', 'Müşteri destek test grubu', 'support', 'ankara', 1, NULL, 1, NOW(), NOW()),
(4, 'Test Junior Satış', 'Junior satış elemanları test grubu', 'sales', 'izmir', 1, NULL, 2, NOW(), NOW());

-- Test Admin Users with Hierarchical Structure
INSERT IGNORE INTO `admins` (`id`, `firstName`, `lastName`, `email`, `phone_number`, `password`, `role_id`, `admin_group_id`, `supervisor_id`, `subordinate_ids`, `employee_id`, `department`, `position`, `hierarchy_level`, `time_zone`, `work_schedule`, `is_available`, `last_activity`, `last_login_at`, `leads_assigned_count`, `leads_converted_count`, `monthly_target`, `current_performance`, `performance_rating`, `login_count`, `two_factor`, `status`, `type`, `created_at`, `updated_at`) VALUES
-- Super Admin (Level 0)
(100, 'Super', 'Admin', 'superadmin@test.com', '+90 555 100 0001', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, NULL, '[101,102,103]', 'EMP001', 'management', 'Sistem Yöneticisi', 0, 'Europe/Istanbul', '{"monday":"09:00-18:00","tuesday":"09:00-18:00","wednesday":"09:00-18:00","thursday":"09:00-18:00","friday":"09:00-18:00"}', 1, NOW(), DATE_SUB(NOW(), INTERVAL 2 HOUR), 0, 0, 0, 100.0, 'excellent', 50, 0, 1, 'Super Admin', NOW(), NOW()),

-- Office Head (Level 1)
(101, 'Ahmet', 'Yönetici', 'ahmet.yonetici@test.com', '+90 555 100 0002', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, 100, '[102,103,104,105]', 'EMP002', 'management', 'Ofis Müdürü', 1, 'Europe/Istanbul', '{"monday":"08:30-17:30","tuesday":"08:30-17:30","wednesday":"08:30-17:30","thursday":"08:30-17:30","friday":"08:30-17:30"}', 1, DATE_SUB(NOW(), INTERVAL 30 MINUTE), DATE_SUB(NOW(), INTERVAL 1 HOUR), 25, 8, 30, 85.5, 'good', 42, 0, 1, 'Manager', NOW(), NOW()),

-- Department Heads (Level 2)
(102, 'Mehmet', 'Satış Müdürü', 'mehmet.satis@test.com', '+90 555 100 0003', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 2, 101, '[104,105,106]', 'EMP003', 'sales', 'Satış Müdürü', 2, 'Europe/Istanbul', '{"monday":"09:00-18:00","tuesday":"09:00-18:00","wednesday":"09:00-18:00","thursday":"09:00-18:00","friday":"09:00-18:00"}', 1, DATE_SUB(NOW(), INTERVAL 15 MINUTE), DATE_SUB(NOW(), INTERVAL 45 MINUTE), 45, 18, 50, 92.0, 'excellent', 38, 0, 1, 'Sales Manager', NOW(), NOW()),

(103, 'Fatma', 'Destek Müdürü', 'fatma.destek@test.com', '+90 555 100 0004', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 3, 101, '[107,108]', 'EMP004', 'support', 'Destek Müdürü', 2, 'Europe/Istanbul', '{"monday":"08:00-17:00","tuesday":"08:00-17:00","wednesday":"08:00-17:00","thursday":"08:00-17:00","friday":"08:00-17:00"}', 1, DATE_SUB(NOW(), INTERVAL 1 HOUR), DATE_SUB(NOW(), INTERVAL 3 HOUR), 35, 12, 40, 78.5, 'good', 28, 0, 1, 'Support Manager', NOW(), NOW()),

-- Senior Level (Level 3)
(104, 'Ali', 'Senior Satış', 'ali.satis@test.com', '+90 555 100 0005', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 2, 102, '[106,109]', 'EMP005', 'sales', 'Senior Satış Temsilcisi', 3, 'Europe/Istanbul', '{"monday":"09:30-18:30","tuesday":"09:30-18:30","wednesday":"09:30-18:30","thursday":"09:30-18:30","friday":"09:30-18:30"}', 1, DATE_SUB(NOW(), INTERVAL 5 MINUTE), DATE_SUB(NOW(), INTERVAL 10 MINUTE), 55, 22, 60, 95.5, 'excellent', 45, 0, 1, 'Senior Sales', NOW(), NOW()),

(105, 'Zeynep', 'Satış Temsilcisi', 'zeynep.satis@test.com', '+90 555 100 0006', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 6, 2, 102, NULL, 'EMP006', 'sales', 'Satış Temsilcisi', 3, 'Europe/Istanbul', '{"monday":"09:00-18:00","tuesday":"09:00-18:00","wednesday":"09:00-18:00","thursday":"09:00-18:00","friday":"09:00-18:00"}', 0, DATE_SUB(NOW(), INTERVAL 20 MINUTE), DATE_SUB(NOW(), INTERVAL 25 MINUTE), 42, 15, 45, 88.0, 'good', 33, 0, 1, 'Sales Rep', NOW(), NOW()),

(107, 'Ayşe', 'Destek Uzmanı', 'ayse.destek@test.com', '+90 555 100 0008', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 8, 3, 103, NULL, 'EMP008', 'support', 'Destek Uzmanı', 3, 'Europe/Istanbul', '{"monday":"08:00-17:00","tuesday":"08:00-17:00","wednesday":"08:00-17:00","thursday":"08:00-17:00","friday":"08:00-17:00","saturday":"10:00-15:00"}', 1, DATE_SUB(NOW(), INTERVAL 40 MINUTE), DATE_SUB(NOW(), INTERVAL 1 HOUR), 38, 9, 35, 81.5, 'good', 31, 0, 1, 'Support', NOW(), NOW()),

(108, 'Burak', 'Teknik Destek', 'burak.teknik@test.com', '+90 555 100 0009', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 8, 3, 103, NULL, 'EMP009', 'support', 'Teknik Destek Uzmanı', 3, 'Europe/Istanbul', '{"monday":"10:00-19:00","tuesday":"10:00-19:00","wednesday":"10:00-19:00","thursday":"10:00-19:00","friday":"10:00-19:00"}', 0, DATE_SUB(NOW(), INTERVAL 12 HOUR), DATE_SUB(NOW(), INTERVAL 18 HOUR), 22, 4, 25, 68.0, 'needs_improvement', 15, 0, 1, 'Technical Support', NOW(), NOW()),

-- Junior Level (Level 4-5)
(106, 'Emre', 'Junior Satış', 'emre.junior@test.com', '+90 555 100 0007', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 7, 4, 104, NULL, 'EMP007', 'sales', 'Junior Satış Temsilcisi', 4, 'Europe/Istanbul', '{"monday":"10:00-19:00","tuesday":"10:00-19:00","wednesday":"10:00-19:00","thursday":"10:00-19:00","friday":"10:00-19:00"}', 1, DATE_SUB(NOW(), INTERVAL 2 HOUR), DATE_SUB(NOW(), INTERVAL 4 HOUR), 28, 7, 30, 72.0, 'average', 20, 0, 1, 'Junior Sales', NOW(), NOW()),

(109, 'Deniz', 'Trainee', 'deniz.trainee@test.com', '+90 555 100 0010', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 9, 4, 104, NULL, 'EMP010', 'sales', 'Stajyer', 5, 'Europe/Istanbul', '{"monday":"09:00-17:00","tuesday":"09:00-17:00","wednesday":"09:00-17:00","thursday":"09:00-17:00","friday":"09:00-17:00"}', 1, DATE_SUB(NOW(), INTERVAL 1 HOUR), DATE_SUB(NOW(), INTERVAL 2 HOUR), 12, 2, 15, 55.0, 'learning', 8, 0, 1, 'Trainee', NOW(), NOW());

-- Update group leaders
UPDATE `admin_groups` SET `group_leader_id` = 101 WHERE `id` = 1;
UPDATE `admin_groups` SET `group_leader_id` = 102 WHERE `id` = 2;
UPDATE `admin_groups` SET `group_leader_id` = 103 WHERE `id` = 3;
UPDATE `admin_groups` SET `group_leader_id` = 104 WHERE `id` = 4;

-- Add some audit log entries for testing
INSERT IGNORE INTO `admin_audit_logs` (`admin_id`, `admin_name`, `admin_email`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `user_agent`, `occurred_at`, `severity`, `category`, `created_at`, `updated_at`) VALUES
(100, 'Super Admin', 'superadmin@test.com', 'login', 'admin', 100, 'Super admin logged in successfully', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', DATE_SUB(NOW(), INTERVAL 2 HOUR), 'info', 'authentication', DATE_SUB(NOW(), INTERVAL 2 HOUR), DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(101, 'Ahmet Yönetici', 'ahmet.yonetici@test.com', 'create', 'user', 1234, 'Created new user account', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', DATE_SUB(NOW(), INTERVAL 30 MINUTE), 'info', 'user_management', DATE_SUB(NOW(), INTERVAL 30 MINUTE), DATE_SUB(NOW(), INTERVAL 30 MINUTE)),
(102, 'Mehmet Satış Müdürü', 'mehmet.satis@test.com', 'assign_lead', 'lead', 5678, 'Assigned lead to junior sales representative', '192.168.1.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', DATE_SUB(NOW(), INTERVAL 15 MINUTE), 'info', 'lead_management', DATE_SUB(NOW(), INTERVAL 15 MINUTE), DATE_SUB(NOW(), INTERVAL 15 MINUTE));

-- Display success message
SELECT '✅ Test Users Created Successfully!' as Status;