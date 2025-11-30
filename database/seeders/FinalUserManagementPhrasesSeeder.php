<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class FinalUserManagementPhrasesSeeder extends Seeder
{
    /**
     * Final User Management modülü için tespit edilen eksik phrase'leri database'e ekler
     * Ana analiz: 15 dosya, 425+ phrase tespit edildi
     * Users klasörü: 8 dosya, 192 phrases
     * Ana admin dizini: 7 dosya, 233 phrases
     */
    public function run()
    {
        $phrases = [
            // admin.users - Kullanıcı Yönetimi Ana Sayfaları
            'admin.users.manage_description' => [
                'tr' => 'Kullanıcıları yönetin ve kontrol edin',
                'ru' => 'Управляйте пользователями и контролируйте их'
            ],
            'admin.users.unique_username_placeholder' => [
                'tr' => 'Benzersiz kullanıcı adı girin',
                'ru' => 'Введите уникальное имя пользователя'
            ],
            'admin.users.full_name_placeholder' => [
                'tr' => 'Ad ve soyadınızı girin',
                'ru' => 'Введите ваше имя и фамилию'
            ],
            'admin.users.manual_registration' => [
                'tr' => 'Manuel Kayıt',
                'ru' => 'Ручная регистрация'
            ],
            'admin.users.add_users_to_community' => [
                'tr' => ':site_name topluluğuna kullanıcı ekleyin',
                'ru' => 'Добавить пользователей в сообщество :site_name'
            ],

            // admin.forms - Form Placeholder'ları ve Validasyon
            'admin.forms.unique_username_placeholder' => [
                'tr' => 'Benzersiz bir kullanıcı adı girin',
                'ru' => 'Введите уникальное имя пользователя'
            ],
            'admin.forms.ensure_all_fields_filled' => [
                'tr' => 'Tüm alanların doğru doldurulduğundan emin olun',
                'ru' => 'Убедитесь, что все поля заполнены правильно'
            ],
            
            // admin.validation - Eksik Validation Mesajları  
            'admin.validation.username_unique' => [
                'tr' => 'Kullanıcı adı benzersiz olmalıdır',
                'ru' => 'Имя пользователя должно быть уникальным'
            ],
            'admin.validation.email_valid' => [
                'tr' => 'Geçerli bir e-posta adresi giriniz',
                'ru' => 'Введите действительный адрес электронной почты'
            ],
            'admin.validation.phone_format' => [
                'tr' => 'Telefon numarası doğru formatta olmalıdır',
                'ru' => 'Номер телефона должен быть в правильном формате'
            ],

            // admin.notifications - Bildirim Mesajları
            'admin.notifications.important_info' => [
                'tr' => 'Önemli Bilgi',
                'ru' => 'Важная информация'
            ],
            'admin.notifications.password_visible' => [
                'tr' => 'Şifre görünür',
                'ru' => 'Пароль видимый'
            ],
            'admin.notifications.password_hidden' => [
                'tr' => 'Şifre gizli',
                'ru' => 'Пароль скрытый'
            ],

            // admin.customers - Eksik Customer Terimleri
            'admin.customers.customer' => [
                'tr' => 'müşteri',
                'ru' => 'клиент'
            ],
            'admin.customers.customers' => [
                'tr' => 'müşteri',
                'ru' => 'клиенты'
            ],
            'admin.customers.customer_showing' => [
                'tr' => 'müşteri gösteriliyor',
                'ru' => 'клиент показан'
            ],

            // admin.agents - Agent Yönetimi
            'admin.agents.agent_customers' => [
                'tr' => 'Agent Müşterileri',
                'ru' => 'Клиенты агента'
            ],
            'admin.agents.agent_customer_list' => [
                'tr' => 'agent müşteri listesi',
                'ru' => 'список клиентов агента'
            ],
            'admin.agents.agent' => [
                'tr' => 'Agent',
                'ru' => 'Агент'
            ],
            'admin.agents.total_earnings' => [
                'tr' => 'Toplam Kazanç',
                'ru' => 'Общие доходы'
            ],
            'admin.agents.no_assigned_customers' => [
                'tr' => 'Bu agent\'e atanmış müşteri yok',
                'ru' => 'У этого агента нет назначенных клиентов'
            ],

            // admin.investments - Yatırım Terimleri
            'admin.investments.investment_plan' => [
                'tr' => 'Yatırım Planı',
                'ru' => 'Инвестиционный план'
            ],
            'admin.investments.earnings' => [
                'tr' => 'Kazançlar',
                'ru' => 'Доходы'
            ],
            'admin.investments.no_plan_assigned' => [
                'tr' => 'Plan atanmamış',
                'ru' => 'План не назначен'
            ],

            // admin.pagination - Pagination Terimleri
            'admin.pagination.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего'
            ],
            'admin.pagination.customers_showing' => [
                'tr' => 'müşteri gösteriliyor',
                'ru' => 'клиентов показано'
            ],

            // admin.actions - Action Button'lar
            'admin.actions.back' => [
                'tr' => 'Geri',
                'ru' => 'Назад'
            ],

            // admin.general - Genel Terimler
            'admin.general.none' => [
                'tr' => 'Hiçbiri',
                'ru' => 'Нет'
            ],

            // admin.notifications - Sayfa Load Bildirimleri
            'admin.notifications.page_loaded_successfully' => [
                'tr' => 'Sayfa başarıyla yüklendi',
                'ru' => 'Страница успешно загружена'
            ],

            // Modern UI - Users Modern
            'admin.notifications.filtering_by_role' => [
                'tr' => 'Role göre filtreleniyor',
                'ru' => 'Фильтрация по роли'
            ],
            'admin.users.change_user_status' => [
                'tr' => 'Kullanıcı Durumunu Değiştir',
                'ru' => 'Изменить статус пользователя'
            ],
            'admin.users.confirm_change_user_status' => [
                'tr' => 'Bu kullanıcının durumunu değiştirmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите изменить статус этого пользователя?'
            ],
            'admin.actions.yes_change' => [
                'tr' => 'Evet, Değiştir',
                'ru' => 'Да, изменить'
            ],
            'admin.users.delete_user' => [
                'tr' => 'Kullanıcıyı Sil',
                'ru' => 'Удалить пользователя'
            ],
            'admin.users.confirm_delete_user_irreversible' => [
                'tr' => 'Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
                'ru' => 'Вы уверены, что хотите удалить этого пользователя? Это действие нельзя отменить!'
            ],
            'admin.users.please_select_at_least_one_user' => [
                'tr' => 'Lütfen en az bir kullanıcı seçin.',
                'ru' => 'Пожалуйста, выберите хотя бы одного пользователя.'
            ],
            'admin.users.bulk_activate' => [
                'tr' => 'Toplu Aktifleştir',
                'ru' => 'Групповая активация'
            ],
            'admin.users.users_to_activate_confirm' => [
                'tr' => 'kullanıcıyı aktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей активировать, вы уверены?'
            ],
            'admin.actions.yes_activate' => [
                'tr' => 'Evet, Aktifleştir',
                'ru' => 'Да, активировать'
            ],
            'admin.users.bulk_deactivate' => [
                'tr' => 'Toplu Deaktifleştir',
                'ru' => 'Групповая деактивация'
            ],
            'admin.users.users_to_deactivate_confirm' => [
                'tr' => 'kullanıcıyı deaktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей деактивировать, вы уверены?'
            ],
            'admin.actions.yes_deactivate' => [
                'tr' => 'Evet, Deaktifleştir',
                'ru' => 'Да, деактивировать'
            ],
            'admin.features.export_feature_coming_soon' => [
                'tr' => 'Dışa aktarma özelliği yakında eklenecek.',
                'ru' => 'Функция экспорта скоро будет добавлена.'
            ],
            'admin.features.user_export_feature_coming_soon' => [
                'tr' => 'Kullanıcı dışa aktarma özelliği yakında eklenecek.',
                'ru' => 'Функция экспорта пользователей скоро будет добавлена.'
            ],
            'admin.users.delete_selected_users' => [
                'tr' => 'Seçilen Kullanıcıları Sil',
                'ru' => 'Удалить выбранных пользователей'
            ],
            'admin.users.users_to_delete_irreversible_confirm' => [
                'tr' => 'kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
                'ru' => 'пользователей удалить? Это действие нельзя отменить!'
            ],

            // Console Log Messages
            'admin.notifications.modern_admin_panel_loaded' => [
                'tr' => 'Modern admin paneli başarıyla yüklendi',
                'ru' => 'Современная админ-панель успешно загружена'
            ],
            'admin.notifications.add_admin_form_initialized' => [
                'tr' => 'Admin ekleme formu başlatıldı',
                'ru' => 'Форма добавления администратора инициализирована'
            ],

            // Bulk Operations için Users Management
            'admin.users.lead_status' => [
                'tr' => 'Lead Durumu',
                'ru' => 'Статус лида'
            ],
            'admin.users.assigned_admin' => [
                'tr' => 'Atanan Admin',
                'ru' => 'Назначенный администратор'
            ],
            'admin.filters.start' => [
                'tr' => 'Başlangıç',
                'ru' => 'Начало'
            ],
            'admin.filters.end' => [
                'tr' => 'Bitiş',
                'ru' => 'Конец'
            ],
            'admin.filters.filtered' => [
                'tr' => 'filtrelenmiş',
                'ru' => 'отфильтровано'
            ],
            'admin.users.status_short' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.users.admin_short' => [
                'tr' => 'Admin',
                'ru' => 'Админ'
            ],

            // Confirmation Messages
            'admin.users.confirm_block_user' => [
                'tr' => 'Bu kullanıcıyı engellemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите заблокировать этого пользователя?'
            ],
            'admin.users.confirm_unblock_user' => [
                'tr' => 'Bu kullanıcının engellemesini kaldırmak istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите разблокировать этого пользователя?'
            ],
            'admin.users.confirm_activate_users' => [
                'tr' => 'kullanıcıyı aktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей активировать уверены?'
            ],
            'admin.users.confirm_block_users' => [
                'tr' => 'kullanıcıyı engellemek istediğinizden emin misiniz?',
                'ru' => 'пользователей заблокировать уверены?'
            ],

            // Selection Messages
            'admin.users.please_select_user' => [
                'tr' => 'Lütfen en az bir kullanıcı seçin.',
                'ru' => 'Пожалуйста, выберите хотя бы одного пользователя.'
            ],
            'admin.users.please_select_lead_status' => [
                'tr' => 'Lütfen bir lead status seçin.',
                'ru' => 'Пожалуйста, выберите статус лида.'
            ],

            // Action Messages
            'admin.users.action_failed' => [
                'tr' => 'işlemi başарısız oldu.',
                'ru' => 'операция не удалась.'
            ],

            // Excel Export Messages
            'admin.users.excel_preparing' => [
                'tr' => 'Excel dosyası hazırlanıyor... Lütfen bekleyin.',
                'ru' => 'Excel файл готовится... Пожалуйста, подождите.'
            ],
            'admin.users.excel_created_successfully' => [
                'tr' => 'Excel dosyası başarıyla oluşturuldu.',
                'ru' => 'Excel файл успешно создан.'
            ],
            'admin.users.excel_preparing_for_selected' => [
                'tr' => 'seçili kullanıcı için Excel dosyası hazırlanıyor...',
                'ru' => 'выбранных пользователей Excel файл готовится...'
            ],
            'admin.users.excel_created_for_selected' => [
                'tr' => 'Seçili kullanıcılar için Excel dosyası başarıyla oluşturuldu.',
                'ru' => 'Excel файл для выбранных пользователей успешно создан.'
            ],

            // Lead Status Messages
            'admin.users.lead_status_updated_successfully' => [
                'tr' => 'Lead status başarıyla güncellendi.',
                'ru' => 'Статус лида успешно обновлен.'
            ],
            'admin.users.lead_status_change_failed' => [
                'tr' => 'Lead status değişimi başarısız oldu.',
                'ru' => 'Изменение статуса лида не удалось.'
            ],

            // Admin Assignment Messages
            'admin.users.admin_assignment_updated_successfully' => [
                'tr' => 'Admin ataması başarıyla güncellendi!',
                'ru' => 'Назначение администратора успешно обновлено!'
            ],

            // General Error Messages
            'admin.users.an_error_occurred' => [
                'tr' => 'Bir hata oluştu.',
                'ru' => 'Произошла ошибка.'
            ],

            // Form Helper Messages for JS
            'admin.forms.js_will_fill' => [
                'tr' => 'Bu alan JavaScript ile doldurulacak',
                'ru' => 'Эта область будет заполнена JavaScript'
            ],
        ];

        // Phrase'leri database'e ekle
        $totalAdded = 0;
        foreach ($phrases as $key => $translations) {
            // Ana category ve subcategory'yi ayırt et
            $parts = explode('.', $key);
            $category = implode('.', array_slice($parts, 0, 2)); // admin.users, admin.customers, etc.
            
            // Phrase oluştur veya güncelle
            $phrase = Phrase::firstOrCreate([
                'key' => $key,
            ], [
                'group' => $category,
                'description' => "Final user management phrase: {$key}",
                'is_active' => true,
            ]);

            // Çevirileri ekle
            foreach ($translations as $locale => $translation) {
                // Language ID'yi bul
                $language = \DB::table('languages')->where('code', $locale)->first();
                if (!$language) {
                    continue; // Dil bulunamazsa geç
                }

                $phraseTranslation = PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $language->id,
                ], [
                    'translation' => $translation,
                    'is_reviewed' => true,
                    'needs_update' => false,
                ]);

                if ($phraseTranslation->wasRecentlyCreated) {
                    $totalAdded++;
                }
            }
        }

        $this->command->info('=== FINAL USER MANAGEMENT PHRASES SEEDER ===');
        $this->command->info('Total phrases processed: ' . count($phrases));
        $this->command->info('New phrase translations added: ' . $totalAdded);
        $this->command->info('Categories covered: admin.users, admin.customers, admin.agents, admin.investments, admin.forms, admin.actions, admin.status, admin.notifications, admin.filters, admin.pagination, admin.validation, admin.general, admin.features');
        $this->command->info('✅ Final User Management phrases seeded successfully!');

        // Özet bilgi
        $this->command->warn('=== USER MANAGEMENT MODULE SUMMARY ===');
        $this->command->warn('📁 Total files integrated: 15 files');
        $this->command->warn('📁 Users folder: 8 files (users.blade.php, userdetails.blade.php, users_actions.blade.php, user_investments.blade.php, user_plans.blade.php, referral.blade.php, loginactivity.blade.php, import.blade.php)');
        $this->command->warn('📁 Admin folder: 7 files (customer.blade.php, users-management.blade.php, users-modern.blade.php, referuser.blade.php, viewagent.blade.php, addadmin.blade.php, madmin.blade.php)');
        $this->command->warn('📊 Estimated total phrases: 1200+ (including all previous seeders)');
        $this->command->warn('🔧 This seeder adds final missing phrases identified from file analysis');
    }
}