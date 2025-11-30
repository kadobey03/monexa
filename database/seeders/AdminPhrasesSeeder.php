<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Get languages
            $turkish = Language::where('code', 'tr')->first();
            $russian = Language::where('code', 'ru')->first();
            
            if (!$turkish || !$russian) {
                $this->command->error('Turkish or Russian language not found in database!');
                return;
            }

            $this->command->info('Adding admin interface phrases...');

            // Admin interface phrases with Turkish and Russian translations
            $phrases = [
                // Admin Navigation
                'admin.navigation.dashboard' => [
                    'tr' => 'Kontrol Paneli',
                    'ru' => 'Панель управления'
                ],
                'admin.navigation.users' => [
                    'tr' => 'Kullanıcılar',
                    'ru' => 'Пользователи'
                ],
                'admin.navigation.deposits' => [
                    'tr' => 'Yatırımlar',
                    'ru' => 'Депозиты'
                ],
                'admin.navigation.withdrawals' => [
                    'tr' => 'Çekimler',
                    'ru' => 'Выводы'
                ],
                'admin.navigation.business_management' => [
                    'tr' => 'İş Yönetimi',
                    'ru' => 'Управление бизнесом'
                ],
                'admin.navigation.investment_plans' => [
                    'tr' => 'Yatırım Planları',
                    'ru' => 'Инвестиционные планы'
                ],
                'admin.navigation.copy_trading' => [
                    'tr' => 'Copy Trading',
                    'ru' => 'Копи-трейдинг'
                ],
                'admin.navigation.bot_trading' => [
                    'tr' => 'Bot Trading',
                    'ru' => 'Бот-трейдинг'
                ],
                'admin.navigation.advanced_trading' => [
                    'tr' => 'Gelişmiş Trading',
                    'ru' => 'Продвинутый трейдинг'
                ],
                'admin.navigation.content_management' => [
                    'tr' => 'İçerik Yönetimi',
                    'ru' => 'Управление контентом'
                ],
                'admin.navigation.tasks' => [
                    'tr' => 'Görevler',
                    'ru' => 'Задачи'
                ],
                'admin.navigation.system_management' => [
                    'tr' => 'Sistem Yönetimi',
                    'ru' => 'Управление системой'
                ],
                'admin.navigation.managers' => [
                    'tr' => 'Yöneticiler',
                    'ru' => 'Менеджеры'
                ],
                'admin.navigation.permissions_roles' => [
                    'tr' => 'Yetki ve Roller',
                    'ru' => 'Права и роли'
                ],
                'admin.navigation.settings' => [
                    'tr' => 'Ayarlar',
                    'ru' => 'Настройки'
                ],
                'admin.navigation.notifications' => [
                    'tr' => 'Bildirimler',
                    'ru' => 'Уведомления'
                ],
                'admin.navigation.profile' => [
                    'tr' => 'Profil',
                    'ru' => 'Профиль'
                ],

                // Admin Common
                'admin.common.admin_panel' => [
                    'tr' => 'Yönetim Paneli',
                    'ru' => 'Панель администратора'
                ],
                'admin.common.welcome' => [
                    'tr' => 'Hoş Geldiniz',
                    'ru' => 'Добро пожаловать'
                ],
                'admin.common.logout' => [
                    'tr' => 'Çıkış',
                    'ru' => 'Выйти'
                ],
                'admin.common.language' => [
                    'tr' => 'Dil',
                    'ru' => 'Язык'
                ],

                // Admin Dashboard
                'admin.dashboard.welcome' => [
                    'tr' => 'Hoş Geldiniz!',
                    'ru' => 'Добро пожаловать!'
                ],
                'admin.dashboard.control_panel' => [
                    'tr' => 'Kontrol Paneli',
                    'ru' => 'Панель управления'
                ],
                'admin.dashboard.welcome_message' => [
                    'tr' => 'Hoş geldiniz, :name',
                    'ru' => 'Добро пожаловать, :name'
                ],
                'admin.dashboard.total_deposits' => [
                    'tr' => 'Toplam Yatırımlar',
                    'ru' => 'Всего депозитов'
                ],
                'admin.dashboard.pending_deposits' => [
                    'tr' => 'Bekleyen Yatırımlar',
                    'ru' => 'Ожидающие депозиты'
                ],
                'admin.dashboard.total_withdrawals' => [
                    'tr' => 'Toplam Çekimler',
                    'ru' => 'Всего выводов'
                ],
                'admin.dashboard.pending_withdrawals' => [
                    'tr' => 'Bekleyen Çekimler',
                    'ru' => 'Ожидающие выводы'
                ],
                'admin.dashboard.total_users' => [
                    'tr' => 'Toplam Kullanıcılar',
                    'ru' => 'Всего пользователей'
                ],
                'admin.dashboard.active_users' => [
                    'tr' => 'Aktif Kullanıcılar',
                    'ru' => 'Активные пользователи'
                ],
                'admin.dashboard.blocked_users' => [
                    'tr' => 'Engellenen Kullanıcılar',
                    'ru' => 'Заблокированные пользователи'
                ],
                'admin.dashboard.investment_plans' => [
                    'tr' => 'Yatırım Planları',
                    'ru' => 'Инвестиционные планы'
                ],
                'admin.dashboard.all_time_total' => [
                    'tr' => 'Tüm zamanlar toplamı',
                    'ru' => 'Общая сумма за все время'
                ],
                'admin.dashboard.awaiting_approval' => [
                    'tr' => 'Onay bekliyor',
                    'ru' => 'Ожидает подтверждения'
                ],
                'admin.dashboard.processing' => [
                    'tr' => 'İşleniyor',
                    'ru' => 'Обрабатывается'
                ],
                'admin.dashboard.registered_user' => [
                    'tr' => 'Kayıtlı kullanıcı',
                    'ru' => 'Зарегистрированный пользователь'
                ],
                'admin.dashboard.currently_online' => [
                    'tr' => 'Şu anda çevrimiçi',
                    'ru' => 'Сейчас онлайн'
                ],
                'admin.dashboard.suspended' => [
                    'tr' => 'Askıya alınmış hesaplar',
                    'ru' => 'Приостановленные аккаунты'
                ],
                'admin.dashboard.active_plan' => [
                    'tr' => 'Mevcut planlar',
                    'ru' => 'Доступные планы'
                ],
                'admin.dashboard.system_analytics' => [
                    'tr' => 'Sistem Analitiği',
                    'ru' => 'Системная аналитика'
                ],
                'admin.dashboard.financial_overview' => [
                    'tr' => 'Finansal genel bakış ve işlem analitiği',
                    'ru' => 'Финансовый обзор и анализ транзакций'
                ],
                'admin.dashboard.today' => [
                    'tr' => 'Bugün',
                    'ru' => 'Сегодня'
                ],
                'admin.dashboard.this_week' => [
                    'tr' => 'Bu Hafta',
                    'ru' => 'На этой неделе'
                ],
                'admin.dashboard.this_month' => [
                    'tr' => 'Bu Ay',
                    'ru' => 'В этом месяце'
                ],
                'admin.dashboard.this_year' => [
                    'tr' => 'Bu Yıl',
                    'ru' => 'В этом году'
                ],
                'admin.dashboard.transactions' => [
                    'tr' => 'İşlemler',
                    'ru' => 'Транзакции'
                ],
                'admin.dashboard.total_transactions' => [
                    'tr' => 'Toplam İşlemler',
                    'ru' => 'Всего транзакций'
                ],
                'admin.dashboard.amount' => [
                    'tr' => 'Tutar',
                    'ru' => 'Сумма'
                ],
                'admin.dashboard.last_30_days' => [
                    'tr' => 'Son 30 gün',
                    'ru' => 'Последние 30 дней'
                ],

                // Additional modern dashboard phrases
                'admin.dashboard.active' => [
                    'tr' => 'Aktif',
                    'ru' => 'Активный'
                ],
                'admin.dashboard.pending' => [
                    'tr' => 'Bekliyor',
                    'ru' => 'Ожидает'
                ],
                'admin.dashboard.completed' => [
                    'tr' => 'Tamamlandı',
                    'ru' => 'Завершено'
                ],
                'admin.dashboard.completed_transactions' => [
                    'tr' => 'Tamamlanan işlemler',
                    'ru' => 'Завершенные транзакции'
                ],
                'admin.dashboard.under_review' => [
                    'tr' => 'İnceleniyor',
                    'ru' => 'На рассмотрении'
                ],
                'admin.dashboard.total' => [
                    'tr' => 'Toplam',
                    'ru' => 'Всего'
                ],
                'admin.dashboard.all_registered_users' => [
                    'tr' => 'Kayıtlı tüm kullanıcılar',
                    'ru' => 'Все зарегистрированные пользователи'
                ],
                'admin.dashboard.online' => [
                    'tr' => 'Çevrimiçi',
                    'ru' => 'Онлайн'
                ],
                'admin.dashboard.currently_active' => [
                    'tr' => 'Şu anda aktif',
                    'ru' => 'Сейчас активен'
                ],
                'admin.dashboard.blocked' => [
                    'tr' => 'Engelli',
                    'ru' => 'Заблокирован'
                ],
                'admin.dashboard.plans' => [
                    'tr' => 'Planlar',
                    'ru' => 'Планы'
                ],
                'admin.dashboard.advanced_system_analytics' => [
                    'tr' => 'Gelişmiş Sistem Analitiği',
                    'ru' => 'Расширенная системная аналитика'
                ],
                'admin.dashboard.comprehensive_financial_analysis' => [
                    'tr' => 'Kapsamlı finansal performans analizi ve trend görünümü',
                    'ru' => 'Комплексный анализ финансовых показателей и обзор трендов'
                ],

                // Admin Buttons
                'admin.buttons.save' => [
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить'
                ],
                'admin.buttons.cancel' => [
                    'tr' => 'İptal',
                    'ru' => 'Отменить'
                ],
                'admin.buttons.edit' => [
                    'tr' => 'Düzenle',
                    'ru' => 'Редактировать'
                ],
                'admin.buttons.delete' => [
                    'tr' => 'Sil',
                    'ru' => 'Удалить'
                ],
                'admin.buttons.view' => [
                    'tr' => 'Görüntüle',
                    'ru' => 'Просмотреть'
                ],
                'admin.buttons.create' => [
                    'tr' => 'Oluştur',
                    'ru' => 'Создать'
                ],

                // Admin Forms
                'admin.forms.name' => [
                    'tr' => 'Ad',
                    'ru' => 'Имя'
                ],
                'admin.forms.email' => [
                    'tr' => 'E-posta',
                    'ru' => 'Email'
                ],
                'admin.forms.password' => [
                    'tr' => 'Şifre',
                    'ru' => 'Пароль'
                ],
                'admin.forms.status' => [
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                'admin.forms.date' => [
                    'tr' => 'Tarih',
                    'ru' => 'Дата'
                ],
                'admin.forms.amount' => [
                    'tr' => 'Tutar',
                    'ru' => 'Сумма'
                ],

                // Admin Notifications
                'admin.notifications.success' => [
                    'tr' => 'İşlem başarıyla tamamlandı',
                    'ru' => 'Операция успешно завершена'
                ],
                'admin.notifications.error' => [
                    'tr' => 'Bir hata oluştu',
                    'ru' => 'Произошла ошибка'
                ],
                'admin.notifications.warning' => [
                    'tr' => 'Uyarı',
                    'ru' => 'Предупреждение'
                ],
                'admin.notifications.info' => [
                    'tr' => 'Bilgi',
                    'ru' => 'Информация'
                ],
            ];

            foreach ($phrases as $key => $translations) {
                // Create or update phrase
                $phrase = Phrase::firstOrCreate(['key' => $key]);
                
                // Create translations
                foreach ($translations as $langCode => $text) {
                    $language = $langCode === 'tr' ? $turkish : $russian;
                    
                    PhraseTranslation::updateOrCreate(
                        ['phrase_id' => $phrase->id, 'language_id' => $language->id],
                        ['translation' => $text]
                    );
                }
            }

            $this->command->info('✅ Admin phrases seeded successfully! Added ' . count($phrases) . ' phrases with Turkish and Russian translations.');
        });
    }
}