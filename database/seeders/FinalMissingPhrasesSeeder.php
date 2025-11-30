<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class FinalMissingPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for final missing phrases.
     */
    public function run(): void
    {
        $phrases = [
            // Modal başlıkları
            'admin.users.topup_modal_title' => [
                'tr' => ':name için Bakiye Artırma',
                'ru' => 'Пополнение баланса для :name'
            ],
            'admin.users.edit_user_modal_title' => [
                'tr' => ':name Kullanıcısını Düzenle',
                'ru' => 'Редактировать пользователя :name'
            ],
            'admin.users.trading_modal_title' => [
                'tr' => ':name için Trading Ayarları',
                'ru' => 'Настройки торговли для :name'
            ],
            'admin.users.email_modal_title' => [
                'tr' => ':name\'ye E-posta Gönder',
                'ru' => 'Отправить email пользователю :name'
            ],
            'admin.users.delete_user_account' => [
                'tr' => 'Kullanıcı Hesabını Sil',
                'ru' => 'Удалить аккаунт пользователя'
            ],
            'admin.users.reset_user_password' => [
                'tr' => 'Kullanıcı Şifresini Sıfırla',
                'ru' => 'Сбросить пароль пользователя'
            ],
            'admin.users.user_tax_modal_title' => [
                'tr' => ':name için Vergi Ayarları',
                'ru' => 'Налоговые настройки для :name'
            ],
            'admin.users.withdrawal_code_modal_title' => [
                'tr' => ':name için Çekim Kodu',
                'ru' => 'Код вывода для :name'
            ],
            'admin.users.dashboard_notification_title' => [
                'tr' => ':username için Dashboard Bildirimi',
                'ru' => 'Уведомление панели для :username'
            ],
            'admin.users.trades_modal_title' => [
                'tr' => ':name\'nin İşlemleri',
                'ru' => 'Сделки пользователя :name'
            ],
            'admin.users.signal_modal_title' => [
                'tr' => ':name için Sinyal Ayarları',
                'ru' => 'Настройки сигналов для :name'
            ],
            'admin.users.switch_user_modal_title' => [
                'tr' => ':name Olarak Giriş Yap',
                'ru' => 'Войти как :name'
            ],
            'admin.users.add_note_modal_title' => [
                'tr' => ':name için Not Ekle',
                'ru' => 'Добавить заметку для :name'
            ],
            'admin.users.edit_note_modal_title' => [
                'tr' => ':name\'nin Notunu Düzenle',
                'ru' => 'Редактировать заметку для :name'
            ],

            // Diğer eksik user phrase'leri
            'admin.users.user_details_title' => [
                'tr' => 'Kullanıcı Detayları',
                'ru' => 'Детали пользователя'
            ],
            'admin.users.user_details_description' => [
                'tr' => 'Kullanıcı profili ve işlem geçmişini görüntüle',
                'ru' => 'Просмотр профиля пользователя и истории операций'
            ],
            'admin.users.no_transactions_yet' => [
                'tr' => 'Henüz işlem yok',
                'ru' => 'Пока нет транзакций'
            ],
            'admin.users.no_transactions_description' => [
                'tr' => 'Bu kullanıcının henüz herhangi bir işlemi bulunmuyor',
                'ru' => 'У этого пользователя пока нет никаких операций'
            ],
            'admin.users.user_information' => [
                'tr' => 'Kullanıcı Bilgileri',
                'ru' => 'Информация о пользователе'
            ],
            'admin.users.assigned_admin' => [
                'tr' => 'Atanan Yönetici',
                'ru' => 'Назначенный администратор'
            ],
            'admin.users.never' => [
                'tr' => 'Hiçbir zaman',
                'ru' => 'Никогда'
            ],
            'admin.users.user_not_found' => [
                'tr' => 'Kullanıcı bulunamadı',
                'ru' => 'Пользователь не найден'
            ],
            'admin.users.no_users_added_yet' => [
                'tr' => 'Henüz kullanıcı eklenmemiş',
                'ru' => 'Пользователи пока не добавлены'
            ],
            'admin.users.users_selected' => [
                'tr' => 'kullanıcı seçildi',
                'ru' => 'пользователей выбрано'
            ],
            'admin.users.add_new_user' => [
                'tr' => 'Yeni Kullanıcı Ekle',
                'ru' => 'Добавить нового пользователя'
            ],
            'admin.users.add_user' => [
                'tr' => 'Kullanıcı Ekle',
                'ru' => 'Добавить пользователя'
            ],
            'admin.users.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.users.premium' => [
                'tr' => 'Premium',
                'ru' => 'Премиум'
            ],
            'admin.users.vip' => [
                'tr' => 'VIP',
                'ru' => 'ВИП'
            ],
            'admin.users.role' => [
                'tr' => 'Rol',
                'ru' => 'Роль'
            ],
            'admin.users.verified' => [
                'tr' => 'Doğrulanmış',
                'ru' => 'Верифицирован'
            ],
            'admin.users.unassigned' => [
                'tr' => 'Atanmamış',
                'ru' => 'Не назначен'
            ],
            'admin.users.source' => [
                'tr' => 'Kaynak',
                'ru' => 'Источник'
            ],
            'admin.users.campaign' => [
                'tr' => 'Kampanya',
                'ru' => 'Кампания'
            ],
            'admin.users.no_utm_info' => [
                'tr' => 'UTM bilgisi yok',
                'ru' => 'Нет UTM информации'
            ],
            'admin.users.no_users_added_or_found' => [
                'tr' => 'Henüz kullanıcı eklenmemiş veya bulunamadı',
                'ru' => 'Пользователи не добавлены или не найдены'
            ],
            'admin.users.admin_assignment' => [
                'tr' => 'Yönetici Atama',
                'ru' => 'Назначение администратора'
            ],
            'admin.users.remove_assignment' => [
                'tr' => 'Atamayı Kaldır',
                'ru' => 'Убрать назначение'
            ],
            'admin.users.admin_selection' => [
                'tr' => 'Yönetici Seçimi',
                'ru' => 'Выбор администратора'
            ],
            'admin.users.selected_users' => [
                'tr' => 'Seçili Kullanıcılar',
                'ru' => 'Выбранные пользователи'
            ],
            'admin.users.bulk_status_change' => [
                'tr' => 'Toplu Durum Değişikliği',
                'ru' => 'Массовое изменение статуса'
            ],
            'admin.users.new_lead_status' => [
                'tr' => 'Yeni Lead Durumu',
                'ru' => 'Новый статус лида'
            ],
            
            // Admin yönetim phrase'leri
            'admin.users.admin_panel' => [
                'tr' => 'Yönetici Paneli',
                'ru' => 'Административная панель'
            ],
            'admin.users.manage_and_control_admins' => [
                'tr' => 'Yöneticileri yönet ve kontrol et',
                'ru' => 'Управление и контроль администраторов'
            ],
            'admin.users.no_phone' => [
                'tr' => 'Telefon yok',
                'ru' => 'Нет телефона'
            ],
            'admin.users.type' => [
                'tr' => 'Tip',
                'ru' => 'Тип'
            ],
            'admin.users.super_admin' => [
                'tr' => 'Süper Yönetici',
                'ru' => 'Супер администратор'
            ],
            'admin.users.admin' => [
                'tr' => 'Yönetici',
                'ru' => 'Администратор'
            ],
            'admin.users.conversion_agent' => [
                'tr' => 'Dönüşüm Aracısı',
                'ru' => 'Агент конверсии'
            ],
            'admin.users.add_new_admin' => [
                'tr' => 'Yeni Yönetici Ekle',
                'ru' => 'Добавить нового администратора'
            ],
            'admin.users.add_new_admin_description' => [
                'tr' => 'Sisteme yeni yönetici ekleyerek yetkilendirin',
                'ru' => 'Добавьте нового администратора в систему'
            ],
            'admin.users.email_address' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Email адрес'
            ],
            'admin.users.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона'
            ],
            'admin.users.admin_type' => [
                'tr' => 'Yönetici Türü',
                'ru' => 'Тип администратора'
            ],
            'admin.users.super_admin_description' => [
                'tr' => 'Tüm yetkilere sahip',
                'ru' => 'Полные права доступа'
            ],
            'admin.users.admin_description' => [
                'tr' => 'Sınırlı yetkiler',
                'ru' => 'Ограниченные права'
            ],
            'admin.users.conversion_agent_description' => [
                'tr' => 'Lead dönüştürme yetkisi',
                'ru' => 'Права конверсии лидов'
            ],
            'admin.users.save_user' => [
                'tr' => 'Kullanıcıyı Kaydet',
                'ru' => 'Сохранить пользователя'
            ],
            'admin.users.add_users_to_community' => [
                'tr' => ':site_name topluluğuna kullanıcı ekleyin',
                'ru' => 'Добавить пользователей в сообщество :site_name'
            ],
            'admin.users.manual_registration' => [
                'tr' => 'Manuel Kayıt',
                'ru' => 'Ручная регистрация'
            ],

            // Agent ve customer phrase'leri
            'admin.users.average_balance' => [
                'tr' => 'Ortalama Bakiye',
                'ru' => 'Средний баланс'
            ],
            'admin.users.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего'
            ],
            'admin.users.id' => [
                'tr' => 'ID',
                'ru' => 'ID'
            ],
            'admin.users.member' => [
                'tr' => 'Üye',
                'ru' => 'Участник'
            ],
            'admin.users.contact' => [
                'tr' => 'İletişim',
                'ru' => 'Контакт'
            ],
            'admin.users.none' => [
                'tr' => 'Yok',
                'ru' => 'Нет'
            ],
            'admin.users.user_status' => [
                'tr' => 'Kullanıcı Durumu',
                'ru' => 'Статус пользователя'
            ],

            // Ek user management phrase'leri
            'admin.users.view_and_manage_platform_users' => [
                'tr' => 'Platform kullanıcılarını görüntüle ve yönet',
                'ru' => 'Просмотр и управление пользователями платформы'
            ],
            'admin.users.new_user' => [
                'tr' => 'Yeni Kullanıcı',
                'ru' => 'Новый пользователь'
            ],
            'admin.users.total_users' => [
                'tr' => 'Toplam Kullanıcı',
                'ru' => 'Всего пользователей'
            ],
            'admin.users.active_users' => [
                'tr' => 'Aktif Kullanıcılar',
                'ru' => 'Активные пользователи'
            ],
            'admin.users.pending_verification' => [
                'tr' => 'Doğrulama Bekleyen',
                'ru' => 'Ожидают верификации'
            ],
            'admin.users.registration_date' => [
                'tr' => 'Kayıt Tarihi',
                'ru' => 'Дата регистрации'
            ],
            'admin.users.last_activity' => [
                'tr' => 'Son Aktivite',
                'ru' => 'Последняя активность'
            ],
            'admin.users.view_edit_manage_users' => [
                'tr' => 'Kullanıcıları görüntüle, düzenle ve yönet',
                'ru' => 'Просмотр, редактирование и управление пользователями'
            ],
            'admin.users.user_list' => [
                'tr' => 'Kullanıcı Listesi',
                'ru' => 'Список пользователей'
            ],
            'admin.users.users_found' => [
                'tr' => 'kullanıcı bulundu',
                'ru' => 'пользователей найдено'
            ],
            'admin.users.users_showing' => [
                'tr' => 'kullanıcı gösteriliyor',
                'ru' => 'пользователей показано'
            ],
            'admin.users.import_users' => [
                'tr' => 'Kullanıcıları İçe Aktar',
                'ru' => 'Импорт пользователей'
            ],
            'admin.users.no_name' => [
                'tr' => 'İsim yok',
                'ru' => 'Нет имени'
            ],
            'admin.users.utm_source' => [
                'tr' => 'UTM Kaynak',
                'ru' => 'UTM источник'
            ],
            'admin.users.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],

            // Form phrase'leri
            'admin.forms.select_admin_type' => [
                'tr' => 'Yönetici türünü seçin',
                'ru' => 'Выберите тип администратора'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Phrase oluştur
            $phrase = Phrase::firstOrCreate([
                'key' => $key
            ]);

            // Çeviriler ekle
            foreach ($translations as $lang => $translation) {
                $languageId = $lang === 'tr' ? 1 : 2; // tr=1, ru=2
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation,
                    'is_reviewed' => true
                ]);
            }
        }

        echo "✅ Final missing phrases seeded successfully! Added " . count($phrases) . " phrases.\n";
    }
}