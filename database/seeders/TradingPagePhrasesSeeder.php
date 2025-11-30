<?php

namespace Database\Seeders;

use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;
use Illuminate\Database\Seeder;

class TradingPagePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get languages
        $tr = Language::where('code', 'tr')->first();
        $ru = Language::where('code', 'ru')->first();

        if (!$tr || !$ru) {
            $this->command->error('Languages not found. Please run LanguagesSeeder first.');
            return;
        }

        $phrases = [
            // Page Headers
            [
                'key' => 'trade.page_title',
                'translations' => [
                    'tr' => 'İşlem Pazarları',
                    'ru' => 'Торговые Рынки'
                ]
            ],
            [
                'key' => 'trade.page_description',
                'translations' => [
                    'tr' => 'Çoklu varlık sınıflarında binlerce işlem enstrümanından seçin',
                    'ru' => 'Выберите из тысяч торговых инструментов в нескольких классах активов'
                ]
            ],
            
            // Search & UI Elements
            [
                'key' => 'trade.search_placeholder',
                'translations' => [
                    'tr' => 'Enstrüman ara...',
                    'ru' => 'Поиск инструментов...'
                ]
            ],
            [
                'key' => 'trade.instruments',
                'translations' => [
                    'tr' => 'Enstrümanlar',
                    'ru' => 'Инструменты'
                ]
            ],
            [
                'key' => 'trade.trading',
                'translations' => [
                    'tr' => 'İşlem',
                    'ru' => 'Торговля'
                ]
            ],
            
            // Market Types
            [
                'key' => 'trade.all_markets',
                'translations' => [
                    'tr' => 'Tüm Pazarlar',
                    'ru' => 'Все Рынки'
                ]
            ],
            [
                'key' => 'trade.crypto',
                'translations' => [
                    'tr' => 'Kripto Para',
                    'ru' => 'Криптовалюта'
                ]
            ],
            [
                'key' => 'trade.stocks',
                'translations' => [
                    'tr' => 'Hisseler',
                    'ru' => 'Акции'
                ]
            ],
            [
                'key' => 'trade.forex',
                'translations' => [
                    'tr' => 'Döviz',
                    'ru' => 'Форекс'
                ]
            ],
            [
                'key' => 'trade.commodities',
                'translations' => [
                    'tr' => 'Emtialar',
                    'ru' => 'Сырьевые Товары'
                ]
            ],
            [
                'key' => 'trade.bonds',
                'translations' => [
                    'tr' => 'Tahviller',
                    'ru' => 'Облигации'
                ]
            ],
            
            // Loading & Error States
            [
                'key' => 'trade.loading_instruments',
                'translations' => [
                    'tr' => 'Enstrümanlar yükleniyor...',
                    'ru' => 'Загрузка инструментов...'
                ]
            ],
            [
                'key' => 'trade.no_instruments_found',
                'translations' => [
                    'tr' => 'Enstrüman bulunamadı',
                    'ru' => 'Инструменты не найдены'
                ]
            ],
            [
                'key' => 'trade.no_instruments_help',
                'translations' => [
                    'tr' => 'Arama veya filtre kriterlerinizi ayarlamayı deneyin',
                    'ru' => 'Попробуйте изменить критерии поиска или фильтрации'
                ]
            ],
            
            // Table Elements
            [
                'key' => 'trade.instrument',
                'translations' => [
                    'tr' => 'enstrüman',
                    'ru' => 'инструмент'
                ]
            ],
            [
                'key' => 'trade.asset',
                'translations' => [
                    'tr' => 'Varlık',
                    'ru' => 'Актив'
                ]
            ],
            [
                'key' => 'trade.price',
                'translations' => [
                    'tr' => 'Fiyat',
                    'ru' => 'Цена'
                ]
            ],
            [
                'key' => 'trade.change_24h',
                'translations' => [
                    'tr' => '24s Değişim',
                    'ru' => 'Изменение 24ч'
                ]
            ],
            [
                'key' => 'trade.volume',
                'translations' => [
                    'tr' => 'Hacim',
                    'ru' => 'Объём'
                ]
            ],
            [
                'key' => 'trade.action',
                'translations' => [
                    'tr' => 'İşlem',
                    'ru' => 'Действие'
                ]
            ],
            [
                'key' => 'trade.trade_button',
                'translations' => [
                    'tr' => 'İşle',
                    'ru' => 'Торговать'
                ]
            ],
            
            // Market Type Full Names (for JavaScript)
            [
                'key' => 'trade.cryptocurrency',
                'translations' => [
                    'tr' => 'Kripto Paralar',
                    'ru' => 'Криптовалюты'
                ]
            ],
            [
                'key' => 'trade.stocks_full',
                'translations' => [
                    'tr' => 'Hisse Senetleri',
                    'ru' => 'Фондовый Рынок'
                ]
            ],
            [
                'key' => 'trade.foreign_exchange',
                'translations' => [
                    'tr' => 'Döviz Kurları',
                    'ru' => 'Валютный Рынок'
                ]
            ],
            [
                'key' => 'trade.commodities_full',
                'translations' => [
                    'tr' => 'Emtia Pazarları',
                    'ru' => 'Товарные Рынки'
                ]
            ],
            [
                'key' => 'trade.bonds_full',
                'translations' => [
                    'tr' => 'Tahvil Pazarları',
                    'ru' => 'Рынок Облигаций'
                ]
            ]
        ];

        $this->command->info('Creating Trading Page phrases...');

        foreach ($phrases as $phraseData) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['key']
            ]);

            // Add translations
            foreach ($phraseData['translations'] as $langCode => $translation) {
                $language = $langCode === 'tr' ? $tr : $ru;
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $language->id
                ], [
                    'translation' => $translation
                ]);
            }

            $this->command->line("✓ {$phraseData['key']}");
        }

        $this->command->info('Trading Page phrases seeding completed successfully! (' . count($phrases) . ' phrases)');
    }
}