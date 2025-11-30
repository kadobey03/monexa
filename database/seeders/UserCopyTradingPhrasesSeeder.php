<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserCopyTradingPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeder for user copy trading phrases.
     */
    public function run(): void
    {
        $phrases = [
            'user.copytrading.live_copy_trading' => [
                'tr' => 'Canlı Kopya Ticaret',
                'ru' => 'Копи-трейдинг в Реальном Времени'
            ],
            'user.copytrading.copy_trading' => [
                'tr' => 'Kopya Ticaret',
                'ru' => 'Копи-трейдинг'
            ],
            'user.copytrading.hub' => [
                'tr' => 'Merkez',
                'ru' => 'Центр'
            ],
            'user.copytrading.description' => [
                'tr' => 'En iyi performans gösteren tüccarları takip edin ve kazanma stratejilerini otomatik olarak kopyalayın.',
                'ru' => 'Следите за лучшими трейдерами и автоматически копируйте их выигрышные стратегии.'
            ],
            'user.copytrading.back_to_dashboard' => [
                'tr' => 'Gösterge Paneline Dön',
                'ru' => 'Вернуться к Панели Управления'
            ],
            'user.copytrading.secure' => [
                'tr' => 'Güvenli',
                'ru' => 'Безопасно'
            ],
            'user.copytrading.profitable' => [
                'tr' => 'Kârlı',
                'ru' => 'Прибыльно'
            ],
            'user.copytrading.expert_traders' => [
                'tr' => 'Uzman Tüccarlar',
                'ru' => 'Экспертные Трейдеры'
            ],
            'user.copytrading.active_verified' => [
                'tr' => 'Aktif ve Doğrulanmış',
                'ru' => 'Активные и Проверенные'
            ],
            'user.copytrading.success_rate' => [
                'tr' => 'Başarı Oranı',
                'ru' => 'Процент Успеха'
            ],
            'user.copytrading.profitable_trades' => [
                'tr' => 'Kârlı İşlemler',
                'ru' => 'Прибыльные Сделки'
            ],
            'user.copytrading.min_investment' => [
                'tr' => 'Min. Yatırım',
                'ru' => 'Мин. Инвестиции'
            ],
            'user.copytrading.start_small' => [
                'tr' => 'Küçük Başla',
                'ru' => 'Начните с Малого'
            ],
            'user.copytrading.followers' => [
                'tr' => 'Takipçiler',
                'ru' => 'Подписчики'
            ],
            'user.copytrading.profit_rate' => [
                'tr' => 'Kâr Oranı',
                'ru' => 'Процент Прибыли'
            ],
            'user.copytrading.min_capital' => [
                'tr' => 'Min. Sermaye',
                'ru' => 'Мин. Капитал'
            ],
            'user.copytrading.total_profit' => [
                'tr' => 'Toplam Kâr',
                'ru' => 'Общая Прибыль'
            ],
            'user.copytrading.stop_copying' => [
                'tr' => 'Kopyalamayı Durdur',
                'ru' => 'Остановить Копирование'
            ],
            'user.copytrading.copy_expert' => [
                'tr' => 'Uzmanı Kopyala',
                'ru' => 'Копировать Эксперта'
            ],
            'user.copytrading.copy' => [
                'tr' => 'Kopyala',
                'ru' => 'Копировать'
            ],
            'user.copytrading.investment_amount' => [
                'tr' => 'Yatırım Tutarı',
                'ru' => 'Сумма Инвестиций'
            ],
            'user.copytrading.enter_amount' => [
                'tr' => 'Tutarı girin',
                'ru' => 'Введите сумму'
            ],
            'user.copytrading.minimum_investment' => [
                'tr' => 'Minimum yatırım',
                'ru' => 'Минимальные инвестиции'
            ],
            'user.copytrading.copy_description' => [
                'tr' => 'Bu uzman tüccardan tüm işlemleri otomatik olarak kopyalayacaksınız.',
                'ru' => 'Вы автоматически скопируете все сделки этого экспертного трейдера.'
            ],
            'user.copytrading.start_copying' => [
                'tr' => 'Kopyalamaya Başla',
                'ru' => 'Начать Копирование'
            ],
            'user.copytrading.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'user.copytrading.validation_message' => [
                'tr' => 'Lütfen en az şu tutarda bir miktar girin:',
                'ru' => 'Пожалуйста, введите сумму не менее:'
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or update phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            foreach ($translations as $languageCode => $translation) {
                // Map language code to language_id
                $languageId = $languageCode === 'tr' ? 1 : 2; // Turkish = 1, Russian = 2
                
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId,
                    ],
                    [
                        'translation' => $translation,
                    ]
                );
            }
        }

        $this->command->info('✅ User Copy Trading phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}