<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserAssetPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Asset Exchange Page - Crypto Trading Interface
            [
                'key' => 'user.asset.exchange_title',
                'translations' => [
                    'tr' => 'Kripto Borsası',
                    'ru' => 'Криптовалютная Биржа'
                ]
            ],
            [
                'key' => 'user.asset.exchange_description',
                'translations' => [
                    'tr' => 'Sabit oranlar ve düşük ücretlerle kripto para birimleri ticareti yapın',
                    'ru' => 'Торговля криптовалютами по фиксированным курсам и низким комиссиям'
                ]
            ],
            [
                'key' => 'user.asset.transaction_history',
                'translations' => [
                    'tr' => 'İşlem Geçmişi',
                    'ru' => 'История Транзакций'
                ]
            ],
            [
                'key' => 'user.asset.account_balance',
                'translations' => [
                    'tr' => 'Hesap Bakiyesi',
                    'ru' => 'Баланс Счета'
                ]
            ],

            // Instant Swap Section
            [
                'key' => 'user.asset.instant_swap',
                'translations' => [
                    'tr' => 'Anında Takas',
                    'ru' => 'Мгновенный Обмен'
                ]
            ],
            [
                'key' => 'user.asset.swap_description',
                'translations' => [
                    'tr' => 'Garantili sabit oranlarla kripto para birimleri takas edin',
                    'ru' => 'Обменивайте криптовалюты по гарантированным фиксированным курсам'
                ]
            ],
            [
                'key' => 'user.asset.from_currency',
                'translations' => [
                    'tr' => 'Hangi Para Biriminden',
                    'ru' => 'Из Валюты'
                ]
            ],
            [
                'key' => 'user.asset.to_currency',
                'translations' => [
                    'tr' => 'Hangi Para Birimine',
                    'ru' => 'В Валюту'
                ]
            ],
            [
                'key' => 'user.asset.enter_amount',
                'translations' => [
                    'tr' => 'Miktar girin',
                    'ru' => 'Введите сумму'
                ]
            ],
            [
                'key' => 'user.asset.available',
                'translations' => [
                    'tr' => 'Kullanılabilir',
                    'ru' => 'Доступно'
                ]
            ],

            // Exchange Details
            [
                'key' => 'user.asset.exchange_rate',
                'translations' => [
                    'tr' => 'Döviz Kuru',
                    'ru' => 'Курс Обмена'
                ]
            ],
            [
                'key' => 'user.asset.fee',
                'translations' => [
                    'tr' => 'Ücret',
                    'ru' => 'Комиссия'
                ]
            ],
            [
                'key' => 'user.asset.swap_now',
                'translations' => [
                    'tr' => 'Şimdi Takas Et',
                    'ru' => 'Обменять Сейчас'
                ]
            ],
            [
                'key' => 'user.asset.terms_agreement',
                'translations' => [
                    'tr' => 'Devam ederek, takas şartlarımızı ve koşullarımızı kabul ediyorsunuz.',
                    'ru' => 'Продолжая, вы соглашаетесь с нашими условиями обмена.'
                ]
            ],

            // Market Chart
            [
                'key' => 'user.asset.market_chart',
                'translations' => [
                    'tr' => 'Piyasa Grafiği',
                    'ru' => 'Рыночный График'
                ]
            ],

            // Account Balance Swap Section
            [
                'key' => 'user.asset.account_balance_swap',
                'translations' => [
                    'tr' => 'Hesap Bakiyesi Takası',
                    'ru' => 'Обмен Баланса Счета'
                ]
            ],
            [
                'key' => 'user.asset.balance_swap_description',
                'translations' => [
                    'tr' => 'Hesap bakiyeniz ve kripto varlıklar arasında anında çevrim yapın',
                    'ru' => 'Мгновенно конвертируйте между балансом счета и криптоактивами'
                ]
            ],
            [
                'key' => 'user.asset.fixed_rates_info',
                'translations' => [
                    'tr' => 'Garantili çevrim için sabit oranlar kullanılıyor. Kayma yok, sürpriz yok.',
                    'ru' => 'Используются фиксированные курсы для гарантированных конверсий. Никаких проскальзываний, никаких сюрпризов.'
                ]
            ],

            // Buy/Sell Crypto
            [
                'key' => 'user.asset.buy_crypto',
                'translations' => [
                    'tr' => 'Kripto Satın Al',
                    'ru' => 'Купить Криpto'
                ]
            ],
            [
                'key' => 'user.asset.sell_crypto',
                'translations' => [
                    'tr' => 'Kripto Sat',
                    'ru' => 'Продать Криpto'
                ]
            ],
            [
                'key' => 'user.asset.amount_to_convert',
                'translations' => [
                    'tr' => 'Çevrilecek Miktar',
                    'ru' => 'Сумма для Конвертации'
                ]
            ],
            [
                'key' => 'user.asset.max',
                'translations' => [
                    'tr' => 'MAX',
                    'ru' => 'МАКС'
                ]
            ],
            [
                'key' => 'user.asset.select_cryptocurrency',
                'translations' => [
                    'tr' => 'Kripto Para Seç',
                    'ru' => 'Выберите Криптовалюту'
                ]
            ],
            [
                'key' => 'user.asset.current',
                'translations' => [
                    'tr' => 'Mevcut',
                    'ru' => 'Текущий'
                ]
            ],
            [
                'key' => 'user.asset.youll_receive',
                'translations' => [
                    'tr' => 'Alacağınız Miktar',
                    'ru' => 'Вы Получите'
                ]
            ],
            [
                'key' => 'user.asset.buy_crypto_now',
                'translations' => [
                    'tr' => 'Şimdi Kripto Satın Al',
                    'ru' => 'Купить Криpto Сейчас'
                ]
            ],
            [
                'key' => 'user.asset.select_crypto_to_sell',
                'translations' => [
                    'tr' => 'Satılacak Kripto Seç',
                    'ru' => 'Выберите Криpto для Продажи'
                ]
            ],
            [
                'key' => 'user.asset.amount_to_sell',
                'translations' => [
                    'tr' => 'Satılacak Miktar',
                    'ru' => 'Сумма для Продажи'
                ]
            ],
            [
                'key' => 'user.asset.sell_crypto_now',
                'translations' => [
                    'tr' => 'Şimdi Kripto Sat',
                    'ru' => 'Продать Криpto Сейчас'
                ]
            ],
            [
                'key' => 'user.asset.current_rates',
                'translations' => [
                    'tr' => 'Güncel Kurlar',
                    'ru' => 'Текущие Курсы'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or get the phrase
            $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);

            // Add translations
            foreach ($phraseData['translations'] as $locale => $value) {
                $languageId = $locale === 'tr' ? 1 : 2; // tr=1, ru=2
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId,
                    ],
                    ['translation' => $value]
                );
            }
        }

        $this->command->info('✅ User Asset phrases seeder completed! Added ' . count($phrases) . ' phrases with Turkish and Russian translations.');
    }
}