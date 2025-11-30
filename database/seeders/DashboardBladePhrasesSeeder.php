<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class DashboardBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Dashboard-specific phrases
            'admin.dashboard.system_active' => [
                'tr' => 'Sistem Aktif',
                'ru' => 'Система Активна'
            ],
            'admin.dashboard.advanced_control_panel' => [
                'tr' => 'Gelişmiş Kontrol Paneli',
                'ru' => 'Расширенная Панель Управления'
            ],
            'admin.dashboard.welcome_admin' => [
                'tr' => 'Hoş geldiniz, :name',
                'ru' => 'Добро пожаловать, :name'
            ],
            'admin.dashboard.investments' => [
                'tr' => 'Yatırımlar',
                'ru' => 'Инвестиции'
            ],
            'admin.dashboard.withdrawals_short' => [
                'tr' => 'Çekimler',
                'ru' => 'Выводы'
            ],
            'admin.dashboard.user_management' => [
                'tr' => 'Kullanıcı Yönetimi',
                'ru' => 'Управление Пользователями'
            ],
            'admin.dashboard.financial_status_summary' => [
                'tr' => 'Mali Durum Özeti',
                'ru' => 'Сводка Финансового Статуса'
            ],
            'admin.dashboard.system_financial_status_description' => [
                'tr' => 'Sistem genelindeki finansal işlemlerin anlık durumu',
                'ru' => 'Текущий статус финансовых операций по всей системе'
            ],
            'admin.dashboard.total_investments' => [
                'tr' => 'Toplam Yatırımlar',
                'ru' => 'Общие Инвестиции'
            ],
            'admin.dashboard.pending_investments' => [
                'tr' => 'Bekleyen Yatırımlar',
                'ru' => 'Ожидающие Инвестиции'
            ],
            'admin.dashboard.user_statistics' => [
                'tr' => 'Kullanıcı İstatistikleri',
                'ru' => 'Статистика Пользователей'
            ],
            'admin.dashboard.platform_user_status' => [
                'tr' => 'Platform kullanıcılarının genel durumu',
                'ru' => 'Общий статус пользователей платформы'
            ],
            'admin.dashboard.all_registered_users' => [
                'tr' => 'Kayıtlı tüm kullanıcılar',
                'ru' => 'Все зарегистрированные пользователи'
            ],
            'admin.dashboard.currently_active' => [
                'tr' => 'Şu anda aktif',
                'ru' => 'В настоящее время активны'
            ],
            'admin.dashboard.suspended_accounts' => [
                'tr' => 'Askıya alınmış hesaplar',
                'ru' => 'Заблокированные аккаунты'
            ],
            'admin.dashboard.available_plans' => [
                'tr' => 'Mevcut planlar',
                'ru' => 'Доступные планы'
            ],
            'admin.dashboard.comprehensive_financial_analysis' => [
                'tr' => 'Kapsamlı finansal performans analizi ve trend görünümü',
                'ru' => 'Комплексный анализ финансовых показателей и просмотр трендов'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create translations
            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian

                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId,
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('Dashboard blade phrases have been seeded successfully.');
    }
}