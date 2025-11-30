<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserSubtradePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Page Header
            [
                'key' => 'user.subtrade.page_title',
                'translations' => [
                    1 => 'Trading Hesapları',
                    2 => 'Торговые счета'
                ]
            ],
            [
                'key' => 'user.subtrade.page_description',
                'translations' => [
                    1 => 'Otomatik trading aboneliklerinizi yönetin',
                    2 => 'Управляйте подписками автоматической торговли'
                ]
            ],

            // Introduction Card
            [
                'key' => 'user.subtrade.account_manager',
                'translations' => [
                    1 => 'Hesap Yöneticisi',
                    2 => 'Менеджер счета'
                ]
            ],
            [
                'key' => 'user.subtrade.service_description',
                'translations' => [
                    1 => 'Trading yapmaya vaktiniz yok mu veya nasıl trading yapacağınızı öğrenmeye mi? Hesap Yönetim Servisimiz sizin için En İyi Karlı Trading Seçeneğidir. Basit bir abonelik modeliyle finansal piyasada hesabınızı yönetmenize yardımcı olabiliriz.',
                    2 => 'Нет времени на торговлю или изучение? Наш сервис управления счетом - лучший выгодный вариант торговли для вас. Мы поможем управлять вашим счетом на финансовом рынке с простой моделью подписки.'
                ]
            ],
            [
                'key' => 'user.subtrade.terms_conditions_apply',
                'translations' => [
                    1 => 'Şartlar ve Koşullar geçerlidir',
                    2 => 'Применяются условия и положения'
                ]
            ],
            [
                'key' => 'user.subtrade.subscribe_now',
                'translations' => [
                    1 => 'Şimdi Abone Ol',
                    2 => 'Подписаться сейчас'
                ]
            ],

            // Trading Accounts Section
            [
                'key' => 'user.subtrade.my_trading_accounts',
                'translations' => [
                    1 => 'Trading Hesaplarım',
                    2 => 'Мои торговые счета'
                ]
            ],
            [
                'key' => 'user.subtrade.account',
                'translations' => [
                    1 => 'Hesap',
                    2 => 'Счет'
                ]
            ],

            // Account Details
            [
                'key' => 'user.subtrade.currency',
                'translations' => [
                    1 => 'Para Birimi',
                    2 => 'Валюта'
                ]
            ],
            [
                'key' => 'user.subtrade.leverage',
                'translations' => [
                    1 => 'Kaldıraç',
                    2 => 'Кредитное плечо'
                ]
            ],
            [
                'key' => 'user.subtrade.server',
                'translations' => [
                    1 => 'Sunucu',
                    2 => 'Сервер'
                ]
            ],
            [
                'key' => 'user.subtrade.duration',
                'translations' => [
                    1 => 'Süre',
                    2 => 'Продолжительность'
                ]
            ],
            [
                'key' => 'user.subtrade.password',
                'translations' => [
                    1 => 'Şifre',
                    2 => 'Пароль'
                ]
            ],
            [
                'key' => 'user.subtrade.submitted',
                'translations' => [
                    1 => 'Gönderildi',
                    2 => 'Отправлено'
                ]
            ],
            [
                'key' => 'user.subtrade.expires',
                'translations' => [
                    1 => 'Bitiş Tarihi',
                    2 => 'Истекает'
                ]
            ],
            [
                'key' => 'user.subtrade.not_started',
                'translations' => [
                    1 => 'Başlamadı',
                    2 => 'Не начато'
                ]
            ],

            // Actions
            [
                'key' => 'user.subtrade.cancel',
                'translations' => [
                    1 => 'İptal Et',
                    2 => 'Отменить'
                ]
            ],
            [
                'key' => 'user.subtrade.renew',
                'translations' => [
                    1 => 'Yenile',
                    2 => 'Обновить'
                ]
            ],

            // Empty State
            [
                'key' => 'user.subtrade.no_trading_accounts',
                'translations' => [
                    1 => 'Trading Hesabı Yok',
                    2 => 'Нет торговых счетов'
                ]
            ],
            [
                'key' => 'user.subtrade.no_accounts_description',
                'translations' => [
                    1 => 'Şu anda hiç trading hesabınız bulunmamaktadır.',
                    2 => 'У вас пока нет торговых счетов.'
                ]
            ],
            [
                'key' => 'user.subtrade.add_first_account',
                'translations' => [
                    1 => 'İlk Hesabınızı Ekleyin',
                    2 => 'Добавить первый счет'
                ]
            ],

            // Trading Platform
            [
                'key' => 'user.subtrade.trading_platform',
                'translations' => [
                    1 => 'Trading Platformu',
                    2 => 'Торговая платформа'
                ]
            ],
            [
                'key' => 'user.subtrade.monitor_activities',
                'translations' => [
                    1 => 'Trading aktivitelerinizi gerçek zamanlı olarak izleyin',
                    2 => 'Отслеживайте торговую активность в режиме реального времени'
                ]
            ],
            [
                'key' => 'user.subtrade.connect_instructions',
                'translations' => [
                    1 => 'Trading hesaplarınızdaki aktiviteleri izlemek için trading hesabınıza bağlanın.',
                    2 => 'Подключитесь к торговому счету для мониторинга активности на ваших торговых счетах.'
                ]
            ],
            [
                'key' => 'user.subtrade.webtrader_title',
                'translations' => [
                    1 => 'MQL5 WebTrader',
                    2 => 'MQL5 WebTrader'
                ]
            ],

            // JavaScript Messages
            [
                'key' => 'user.subtrade.error_title',
                'translations' => [
                    1 => 'Hata!',
                    2 => 'Ошибка!'
                ]
            ],
            [
                'key' => 'user.subtrade.cancel_instructions',
                'translations' => [
                    1 => 'MT4 bilgilerinizi iptal ettirmek için :email adresine e-posta gönderin.',
                    2 => 'Отправьте электронное письмо на :email для отмены данных MT4.'
                ]
            ],
            [
                'key' => 'user.subtrade.okay',
                'translations' => [
                    1 => 'Tamam',
                    2 => 'Хорошо'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            $phrase = Phrase::firstOrCreate(
                ['key' => $phraseData['key']],
                ['key' => $phraseData['key']]
            );

            foreach ($phraseData['translations'] as $languageId => $translation) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ],
                    [
                        'translation' => $translation
                    ]
                );
            }
        }

        $this->command->info('✅ User Subtrade phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}