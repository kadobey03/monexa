<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserDepositsPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Main Headers
            [
                'key' => 'user.deposits.title',
                'translations' => [
                    1 => 'Hesabınızı Yatırın',
                    2 => 'Пополните свой счет'
                ]
            ],
            [
                'key' => 'user.deposits.description',
                'translations' => [
                    1 => 'Alım satım yapmaya başlamak için güvenli yatırımlar',
                    2 => 'Безопасные депозиты для начала торговли'
                ]
            ],

            // Quick Amount Section
            [
                'key' => 'user.deposits.quick_amounts',
                'translations' => [
                    1 => 'Hızlı miktarlar',
                    2 => 'Быстрые суммы'
                ]
            ],

            // Deposit Form
            [
                'key' => 'user.deposits.make_deposit',
                'translations' => [
                    1 => 'Yatırım Yapın',
                    2 => 'Сделать депозит'
                ]
            ],
            [
                'key' => 'user.deposits.secure',
                'translations' => [
                    1 => 'Güvenli',
                    2 => 'Безопасно'
                ]
            ],
            [
                'key' => 'user.deposits.payment_method',
                'translations' => [
                    1 => 'Ödeme Yöntemi',
                    2 => 'Способ оплаты'
                ]
            ],
            [
                'key' => 'user.deposits.no_payment_methods',
                'translations' => [
                    1 => 'Şu anda hiçbir ödeme yöntemi etkin değil, lütfen daha sonra tekrar kontrol edin.',
                    2 => 'В настоящее время нет активных способов оплаты, пожалуйста, проверьте позже.'
                ]
            ],

            // Amount Section
            [
                'key' => 'user.deposits.amount',
                'translations' => [
                    1 => 'Yatırım Miktarı',
                    2 => 'Сумма депозита'
                ]
            ],
            [
                'key' => 'user.deposits.amount_placeholder',
                'translations' => [
                    1 => '0.00',
                    2 => '0.00'
                ]
            ],
            [
                'key' => 'user.deposits.amount_help',
                'translations' => [
                    1 => 'Yatırmak istediğiniz miktarı girin',
                    2 => 'Введите сумму, которую хотите внести'
                ]
            ],

            // Submit Button
            [
                'key' => 'user.deposits.proceed_button',
                'translations' => [
                    1 => 'Yatırım İle İlerle',
                    2 => 'Продолжить с депозитом'
                ]
            ],

            // Sidebar - Payment Methods Card
            [
                'key' => 'user.deposits.payment_methods_title',
                'translations' => [
                    1 => 'Ödeme Yöntemleri',
                    2 => 'Способы оплаты'
                ]
            ],

            // Sidebar - Deposit Guide Card
            [
                'key' => 'user.deposits.guide_title',
                'translations' => [
                    1 => 'Nasıl Yatırım Yapılır',
                    2 => 'Как сделать депозит'
                ]
            ],
            [
                'key' => 'user.deposits.guide_step1',
                'translations' => [
                    1 => 'Ödeme yönteminizi seçin',
                    2 => 'Выберите способ оплаты'
                ]
            ],
            [
                'key' => 'user.deposits.guide_step2',
                'translations' => [
                    1 => 'Yatırım miktarını girin',
                    2 => 'Введите сумму депозита'
                ]
            ],
            [
                'key' => 'user.deposits.guide_step3',
                'translations' => [
                    1 => 'Güvenli ödemeyi tamamlayın',
                    2 => 'Завершите безопасный платеж'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or find phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['key']
            ], [
                'description' => 'User Deposits Page - ' . $phraseData['key']
            ]);

            // Add translations for each language
            foreach ($phraseData['translations'] as $languageId => $translation) {
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('✅ User Deposits phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}