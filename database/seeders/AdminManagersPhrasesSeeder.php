<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminManagersPhrasesSeeder extends Seeder
{
    /**
     * Admin Managers Pages için phrase'ları ekle
     * Türkçe (language_id: 1) ve Rusça (language_id: 2) çeviriler ile
     */
    public function run(): void
    {
        $this->command->info('🚀 Admin Managers Phrases Seeder başlatılıyor...');

        $phrases = [
            // === NAVIGATION & MENU PHRASES ===
            'admin.navigation.managers' => [
                'tr' => 'Yöneticiler',
                'ru' => 'Менеджеры'
            ],
            'admin.navigation.managers_list' => [
                'tr' => 'Yönetici Listesi',
                'ru' => 'Список менеджеров'
            ],
            'admin.navigation.add_manager' => [
                'tr' => 'Yönetici Ekle',
                'ru' => 'Добавить менеджера'
            ],
            'admin.navigation.manager_management' => [
                'tr' => 'Yönetici Yönetimi',
                'ru' => 'Управление менеджерами'
            ],

            // === PAGE TITLES ===
            'admin.managers.title' => [
                'tr' => 'Yönetici Paneli',
                'ru' => 'Панель менеджеров'
            ],
            'admin.managers.list_title' => [
                'tr' => 'Tüm Yöneticiler',
                'ru' => 'Все менеджеры'
            ],
            'admin.managers.create_title' => [
                'tr' => 'Yeni Yönetici Ekle',
                'ru' => 'Добавить нового менеджера'
            ],
            'admin.managers.edit_title' => [
                'tr' => 'Yönetici Düzenle',
                'ru' => 'Редактировать менеджера'
            ],
            'admin.managers.view_title' => [
                'tr' => 'Yönetici Detayları',
                'ru' => 'Детали менеджера'
            ],

            // === BUTTONS & ACTIONS ===
            'admin.managers.add_new' => [
                'tr' => 'Yeni Yönetici Ekle',
                'ru' => 'Добавить нового менеджера'
            ],
            'admin.managers.actions.view' => [
                'tr' => 'Görüntüle',
                'ru' => 'Просмотр'
            ],
            'admin.managers.actions.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.managers.actions.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.managers.actions.activate' => [
                'tr' => 'Etkinleştir',
                'ru' => 'Активировать'
            ],
            'admin.managers.actions.deactivate' => [
                'tr' => 'Devre Dışı Bırak',
                'ru' => 'Деактивировать'
            ],
            'admin.managers.actions.reset_password' => [
                'tr' => 'Şifreyi Sıfırla',
                'ru' => 'Сбросить пароль'
            ],
            'admin.managers.actions.manage_permissions' => [
                'tr' => 'İzinleri Yönet',
                'ru' => 'Управлять разрешениями'
            ],

            // === TABLE HEADERS ===
            'admin.managers.table.name' => [
                'tr' => 'İsim',
                'ru' => 'Имя'
            ],
            'admin.managers.table.email' => [
                'tr' => 'E-posta',
                'ru' => 'Электронная почта'
            ],
            'admin.managers.table.role' => [
                'tr' => 'Rol',
                'ru' => 'Роль'
            ],
            'admin.managers.table.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.managers.table.created_at' => [
                'tr' => 'Oluşturma Tarihi',
                'ru' => 'Дата создания'
            ],
            'admin.managers.table.last_login' => [
                'tr' => 'Son Giriş',
                'ru' => 'Последний вход'
            ],
            'admin.managers.table.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.managers.table.permissions' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],

            // === FORM LABELS ===
            'admin.managers.form.name' => [
                'tr' => 'Ad Soyad',
                'ru' => 'Полное имя'
            ],
            'admin.managers.form.firstname' => [
                'tr' => 'Ad',
                'ru' => 'Имя'
            ],
            'admin.managers.form.lastname' => [
                'tr' => 'Soyad',
                'ru' => 'Фамилия'
            ],
            'admin.managers.form.email' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Адрес электронной почты'
            ],
            'admin.managers.form.password' => [
                'tr' => 'Şifre',
                'ru' => 'Пароль'
            ],
            'admin.managers.form.password_confirmation' => [
                'tr' => 'Şifre Onayı',
                'ru' => 'Подтверждение пароля'
            ],
            'admin.managers.form.role' => [
                'tr' => 'Yönetici Rolü',
                'ru' => 'Роль менеджера'
            ],
            'admin.managers.form.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.managers.form.permissions' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.managers.form.phone' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона'
            ],
            'admin.managers.form.notes' => [
                'tr' => 'Notlar',
                'ru' => 'Примечания'
            ],

            // === FORM PLACEHOLDERS ===
            'admin.managers.placeholders.name' => [
                'tr' => 'Yönetici adını girin',
                'ru' => 'Введите имя менеджера'
            ],
            'admin.managers.placeholders.email' => [
                'tr' => 'ornek@email.com',
                'ru' => 'пример@email.com'
            ],
            'admin.managers.placeholders.password' => [
                'tr' => 'Güçlü bir şifre girin',
                'ru' => 'Введите надежный пароль'
            ],
            'admin.managers.placeholders.phone' => [
                'tr' => 'Telefon numarasını girin',
                'ru' => 'Введите номер телефона'
            ],
            'admin.managers.placeholders.notes' => [
                'tr' => 'Yönetici hakkında notlar...',
                'ru' => 'Примечания о менеджере...'
            ],
            'admin.managers.placeholders.search' => [
                'tr' => 'Yönetici ara...',
                'ru' => 'Поиск менеджера...'
            ],

            // === FORM BUTTONS ===
            'admin.managers.buttons.save' => [
                'tr' => 'Kaydet',
                'ru' => 'Сохранить'
            ],
            'admin.managers.buttons.update' => [
                'tr' => 'Güncelle',
                'ru' => 'Обновить'
            ],
            'admin.managers.buttons.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отменить'
            ],
            'admin.managers.buttons.create' => [
                'tr' => 'Oluştur',
                'ru' => 'Создать'
            ],
            'admin.managers.buttons.back' => [
                'tr' => 'Geri',
                'ru' => 'Назад'
            ],

            // === STATUS VALUES ===
            'admin.managers.status.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный'
            ],
            'admin.managers.status.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивный'
            ],
            'admin.managers.status.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            'admin.managers.status.suspended' => [
                'tr' => 'Askıya Alınmış',
                'ru' => 'Приостановлено'
            ],

            // === ROLE VALUES ===
            'admin.managers.roles.super_admin' => [
                'tr' => 'Süper Yönetici',
                'ru' => 'Супер администратор'
            ],
            'admin.managers.roles.admin' => [
                'tr' => 'Yönetici',
                'ru' => 'Администратор'
            ],
            'admin.managers.roles.manager' => [
                'tr' => 'Müdür',
                'ru' => 'Менеджер'
            ],
            'admin.managers.roles.moderator' => [
                'tr' => 'Moderatör',
                'ru' => 'Модератор'
            ],
            'admin.managers.roles.support' => [
                'tr' => 'Destek Uzmanı',
                'ru' => 'Специалист поддержки'
            ],

            // === SUCCESS MESSAGES ===
            'admin.managers.messages.created_successfully' => [
                'tr' => 'Yönetici başarıyla oluşturuldu',
                'ru' => 'Менеджер успешно создан'
            ],
            'admin.managers.messages.updated_successfully' => [
                'tr' => 'Yönetici bilgileri başarıyla güncellendi',
                'ru' => 'Информация о менеджере успешно обновлена'
            ],
            'admin.managers.messages.deleted_successfully' => [
                'tr' => 'Yönetici başarıyla silindi',
                'ru' => 'Менеджер успешно удален'
            ],
            'admin.managers.messages.activated_successfully' => [
                'tr' => 'Yönetici başarıyla etkinleştirildi',
                'ru' => 'Менеджер успешно активирован'
            ],
            'admin.managers.messages.deactivated_successfully' => [
                'tr' => 'Yönetici başarıyla devre dışı bırakıldı',
                'ru' => 'Менеджер успешно деактивирован'
            ],
            'admin.managers.messages.password_reset_successfully' => [
                'tr' => 'Şifre başarıyla sıfırlandı',
                'ru' => 'Пароль успешно сброшен'
            ],
            'admin.managers.messages.permissions_updated_successfully' => [
                'tr' => 'İzinler başarıyla güncellendi',
                'ru' => 'Разрешения успешно обновлены'
            ],

            // === ERROR MESSAGES ===
            'admin.managers.errors.creation_failed' => [
                'tr' => 'Yönetici oluşturulurken bir hata oluştu',
                'ru' => 'Произошла ошибка при создании менеджера'
            ],
            'admin.managers.errors.update_failed' => [
                'tr' => 'Yönetici güncellenirken bir hata oluştu',
                'ru' => 'Произошла ошибка при обновлении менеджера'
            ],
            'admin.managers.errors.deletion_failed' => [
                'tr' => 'Yönetici silinirken bir hata oluştu',
                'ru' => 'Произошла ошибка при удалении менеджера'
            ],
            'admin.managers.errors.not_found' => [
                'tr' => 'Yönetici bulunamadı',
                'ru' => 'Менеджер не найден'
            ],
            'admin.managers.errors.email_already_exists' => [
                'tr' => 'Bu e-posta adresi zaten kullanılıyor',
                'ru' => 'Этот адрес электронной почты уже используется'
            ],
            'admin.managers.errors.invalid_permissions' => [
                'tr' => 'Geçersiz izin seçimi',
                'ru' => 'Неверный выбор разрешений'
            ],
            'admin.managers.errors.cannot_delete_self' => [
                'tr' => 'Kendi hesabınızı silemezsiniz',
                'ru' => 'Вы не можете удалить свой собственный аккаунт'
            ],

            // === CONFIRMATION MESSAGES ===
            'admin.managers.confirmations.delete_manager' => [
                'tr' => 'Bu yöneticiyi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить этого менеджера?'
            ],
            'admin.managers.confirmations.activate_manager' => [
                'tr' => 'Bu yöneticiyi etkinleştirmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите активировать этого менеджера?'
            ],
            'admin.managers.confirmations.deactivate_manager' => [
                'tr' => 'Bu yöneticiyi devre dışı bırakmak istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите деактивировать этого менеджера?'
            ],
            'admin.managers.confirmations.reset_password' => [
                'tr' => 'Bu yöneticinin şifresini sıfırlamak istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите сбросить пароль этого менеджера?'
            ],

            // === SEARCH & FILTER ===
            'admin.managers.search.no_results' => [
                'tr' => 'Aramanızla eşleşen yönetici bulunamadı',
                'ru' => 'Менеджеров, соответствующих вашему поиску, не найдено'
            ],
            'admin.managers.search.results_count' => [
                'tr' => ':count yönetici bulundu',
                'ru' => 'Найдено :count менеджеров'
            ],
            'admin.managers.filter.all' => [
                'tr' => 'Tümü',
                'ru' => 'Все'
            ],
            'admin.managers.filter.by_role' => [
                'tr' => 'Role Göre Filtrele',
                'ru' => 'Фильтр по роли'
            ],
            'admin.managers.filter.by_status' => [
                'tr' => 'Duruma Göre Filtrele',
                'ru' => 'Фильтр по статусу'
            ],

            // === EMPTY STATES ===
            'admin.managers.empty.no_managers' => [
                'tr' => 'Henüz hiç yönetici eklenmemiş',
                'ru' => 'Пока не добавлено ни одного менеджера'
            ],
            'admin.managers.empty.add_first_manager' => [
                'tr' => 'İlk yöneticinizi ekleyin',
                'ru' => 'Добавьте своего первого менеджера'
            ],
            'admin.managers.empty.get_started' => [
                'tr' => 'Başlayın',
                'ru' => 'Начать'
            ],

            // === VALIDATION MESSAGES ===
            'admin.managers.validation.name_required' => [
                'tr' => 'İsim alanı zorunludur',
                'ru' => 'Поле имени обязательно'
            ],
            'admin.managers.validation.email_required' => [
                'tr' => 'E-posta alanı zorunludur',
                'ru' => 'Поле электронной почты обязательно'
            ],
            'admin.managers.validation.email_invalid' => [
                'tr' => 'Geçerli bir e-posta adresi girin',
                'ru' => 'Введите действительный адрес электронной почты'
            ],
            'admin.managers.validation.password_required' => [
                'tr' => 'Şifre alanı zorunludur',
                'ru' => 'Поле пароля обязательно'
            ],
            'admin.managers.validation.password_min_length' => [
                'tr' => 'Şifre en az 8 karakter olmalıdır',
                'ru' => 'Пароль должен содержать не менее 8 символов'
            ],
            'admin.managers.validation.password_confirmation' => [
                'tr' => 'Şifreler eşleşmiyor',
                'ru' => 'Пароли не совпадают'
            ],

            // === PERMISSIONS ===
            'admin.managers.permissions.dashboard_access' => [
                'tr' => 'Pano Erişimi',
                'ru' => 'Доступ к панели управления'
            ],
            'admin.managers.permissions.user_management' => [
                'tr' => 'Kullanıcı Yönetimi',
                'ru' => 'Управление пользователями'
            ],
            'admin.managers.permissions.financial_operations' => [
                'tr' => 'Mali İşlemler',
                'ru' => 'Финансовые операции'
            ],
            'admin.managers.permissions.report_access' => [
                'tr' => 'Rapor Erişimi',
                'ru' => 'Доступ к отчетам'
            ],
            'admin.managers.permissions.system_settings' => [
                'tr' => 'Sistem Ayarları',
                'ru' => 'Системные настройки'
            ],

            // === TOOLTIPS & HELP TEXT ===
            'admin.managers.help.role_selection' => [
                'tr' => 'Yöneticinin sistemdeki yetkilerini belirler',
                'ru' => 'Определяет полномочия менеджера в системе'
            ],
            'admin.managers.help.status_selection' => [
                'tr' => 'Yöneticinin sisteme erişim durumu',
                'ru' => 'Статус доступа менеджера к системе'
            ],
            'admin.managers.help.permissions_info' => [
                'tr' => 'Özel izinler role ek olarak verilebilir',
                'ru' => 'Особые разрешения могут быть предоставлены в дополнение к роли'
            ]
        ];

        // Phrase'leri oluştur
        $createdCount = 0;
        $updatedCount = 0;

        foreach ($phrases as $key => $translations) {
            // Phrase oluştur veya güncelle
            $phrase = Phrase::updateOrCreate([
                'key' => $key
            ], [
                'group' => 'admin',
                'is_active' => true
            ]);

            if ($phrase->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $updatedCount++;
            }

            // Türkçe çeviri (language_id: 1)
            if (isset($translations['tr'])) {
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => 1
                ], [
                    'translation' => $translations['tr'],
                    'is_reviewed' => true
                ]);
            }

            // Rusça çeviri (language_id: 2)
            if (isset($translations['ru'])) {
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => 2
                ], [
                    'translation' => $translations['ru'],
                    'is_reviewed' => true
                ]);
            }
        }

        $this->command->info("✅ Admin Managers Phrases Seeder tamamlandı!");
        $this->command->info("📊 Toplam Phrase: " . count($phrases));
        $this->command->info("📈 Yeni Phrase: {$createdCount}");
        $this->command->info("🔄 Güncellenen: {$updatedCount}");
        $this->command->info("🌐 Türkçe ve Rusça çeviriler eklendi");
    }
}