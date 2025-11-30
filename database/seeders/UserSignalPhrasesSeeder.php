<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserSignalPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeder for user signal phrases.
     */
    public function run(): void
    {
        $phrases = [
            'user.signal.dashboard' => [
                'tr' => 'Gösterge Paneli',
                'ru' => 'Панель Управления'
            ],
            'user.signal.trading_signals' => [
                'tr' => 'İşlem Sinyalleri',
                'ru' => 'Торговые Сигналы'
            ],
            'user.signal.premium_trading_signals' => [
                'tr' => 'Premium İşlem Sinyalleri',
                'ru' => 'Премиум Торговые Сигналы'
            ],
            'user.signal.subscribe_description' => [
                'tr' => 'Profesyonel işlem sinyallerine abone olun ve işlem başarınızı artırın',
                'ru' => 'Подпишитесь на профессиональные торговые сигналы и повысьте свой торговый успех'
            ],
            'user.signal.available_signals' => [
                'tr' => 'Mevcut Sinyaller',
                'ru' => 'Доступные Сигналы'
            ],
            'user.signal.premium' => [
                'tr' => 'Premium',
                'ru' => 'Премиум'
            ],
            'user.signal.per_month' => [
                'tr' => '/aylık',
                'ru' => '/месяц'
            ],
            'user.signal.professional_subscription' => [
                'tr' => 'Profesyonel işlem sinyalleri aboneliği',
                'ru' => 'Подписка на профессиональные торговые сигналы'
            ],
            'user.signal.success_rate' => [
                'tr' => 'Başarı Oranı',
                'ru' => 'Процент Успеха'
            ],
            'user.signal.realtime_notifications' => [
                'tr' => 'Gerçek zamanlı bildirimler',
                'ru' => 'Уведомления в реальном времени'
            ],
            'user.signal.expert_analysis' => [
                'tr' => 'Uzman analizi',
                'ru' => 'Экспертный анализ'
            ],
            'user.signal.support_24_7' => [
                'tr' => '7/24 destek',
                'ru' => 'Поддержка 24/7'
            ],
            'user.signal.subscribe_now' => [
                'tr' => 'Şimdi Abone Ol',
                'ru' => 'Подписаться Сейчас'
            ],
            'user.signal.no_signals_available' => [
                'tr' => 'Sinyal Bulunmuyor',
                'ru' => 'Сигналы Недоступны'
            ],
            'user.signal.no_signals_description' => [
                'tr' => 'Şu anda mevcut işlem sinyali bulunmamaktadır. Premium sinyal abonelikleri için lütfen daha sonra tekrar kontrol edin.',
                'ru' => 'В настоящее время нет доступных торговых сигналов. Пожалуйста, проверьте позже для подписок на премиум сигналы.'
            ],
            'user.signal.back_to_dashboard' => [
                'tr' => 'Gösterge Paneline Dön',
                'ru' => 'Вернуться к Панели Управления'
            ],
            'user.signal.subscribe_to_signal' => [
                'tr' => 'Sinyale Abone Ol',
                'ru' => 'Подписаться на Сигнал'
            ],
            'user.signal.payment_method' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ Оплаты'
            ],
            'user.signal.choose_payment_method' => [
                'tr' => 'Ödeme Yöntemi Seçin',
                'ru' => 'Выберите Способ Оплаты'
            ],
            'user.signal.no_payment_method_available' => [
                'tr' => 'Şu anda ödeme yöntemi bulunmamaktadır',
                'ru' => 'В настоящее время способы оплаты недоступны'
            ],
            'user.signal.subscription_amount' => [
                'tr' => 'Abonelik Tutarı',
                'ru' => 'Сумма Подписки'
            ],
            'user.signal.recurring_subscription' => [
                'tr' => 'Yinelenen aylık abonelik',
                'ru' => 'Повторяющаяся ежемесячная подписка'
            ],
            'user.signal.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'user.signal.complete_subscription' => [
                'tr' => 'Aboneliği Tamamla',
                'ru' => 'Завершить Подписку'
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

        $this->command->info('✅ User Signal phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}