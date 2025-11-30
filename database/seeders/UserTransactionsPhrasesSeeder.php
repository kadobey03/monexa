<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserTransactionsPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Main Transaction Page
            [
                'key' => 'user.transactions.title',
                'translations' => [
                    1 => 'İşlem Geçmişi',
                    2 => 'История транзакций'
                ]
            ],
            [
                'key' => 'user.transactions.description',
                'translations' => [
                    1 => 'Tüm finansal faaliyetlerinizi izleyin',
                    2 => 'Отслеживайте всю свою финансовую деятельность'
                ]
            ],

            // Tab Navigation
            [
                'key' => 'user.transactions.tab_deposits',
                'translations' => [
                    1 => 'Yatırımlar',
                    2 => 'Депозиты'
                ]
            ],
            [
                'key' => 'user.transactions.tab_withdrawals',
                'translations' => [
                    1 => 'Çekimler',
                    2 => 'Вывод средств'
                ]
            ],
            [
                'key' => 'user.transactions.tab_others',
                'translations' => [
                    1 => 'Diğerleri',
                    2 => 'Прочие'
                ]
            ],

            // Common Table Headers
            [
                'key' => 'user.transactions.amount',
                'translations' => [
                    1 => 'Miktar',
                    2 => 'Сумма'
                ]
            ],
            [
                'key' => 'user.transactions.payment_method',
                'translations' => [
                    1 => 'Ödeme Yöntemi',
                    2 => 'Способ оплаты'
                ]
            ],
            [
                'key' => 'user.transactions.status',
                'translations' => [
                    1 => 'Durum',
                    2 => 'Статус'
                ]
            ],
            [
                'key' => 'user.transactions.date',
                'translations' => [
                    1 => 'Tarih',
                    2 => 'Дата'
                ]
            ],

            // Deposits Section
            [
                'key' => 'user.transactions.deposits.title',
                'translations' => [
                    1 => 'Yatırım Geçmişi',
                    2 => 'История депозитов'
                ]
            ],
            [
                'key' => 'user.transactions.deposits.description',
                'translations' => [
                    1 => 'Yatırım işlemlerinizi takip edin',
                    2 => 'Отслеживайте свои депозитные операции'
                ]
            ],
            [
                'key' => 'user.transactions.deposits.search_placeholder',
                'translations' => [
                    1 => 'Yatırımları ara...',
                    2 => 'Поиск депозитов...'
                ]
            ],
            [
                'key' => 'user.transactions.deposits.label',
                'translations' => [
                    1 => 'Yatırım',
                    2 => 'Депозит'
                ]
            ],
            [
                'key' => 'user.transactions.deposits.no_deposits',
                'translations' => [
                    1 => 'Henüz yatırım yok',
                    2 => 'Депозитов пока нет'
                ]
            ],
            [
                'key' => 'user.transactions.deposits.no_deposits_desc',
                'translations' => [
                    1 => 'Yatırım geçmişiniz burada görünecek',
                    2 => 'История ваших депозитов будет отображаться здесь'
                ]
            ],

            // Withdrawals Section
            [
                'key' => 'user.transactions.withdrawals.title',
                'translations' => [
                    1 => 'Çekim Geçmişi',
                    2 => 'История вывода'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.description',
                'translations' => [
                    1 => 'Çekim işlemlerinizi takip edin',
                    2 => 'Отслеживайте операции вывода средств'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.search_placeholder',
                'translations' => [
                    1 => 'Çekimleri ara...',
                    2 => 'Поиск выводов...'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.label',
                'translations' => [
                    1 => 'Çekim',
                    2 => 'Вывод'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.total_deducted',
                'translations' => [
                    1 => 'Toplam Kesilen',
                    2 => 'Всего списано'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.requested_amount',
                'translations' => [
                    1 => 'Talep Edilen Miktar',
                    2 => 'Запрашиваемая сумма'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.fees_included',
                'translations' => [
                    1 => 'Ücretler dahil',
                    2 => 'Включая комиссии'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.no_withdrawals',
                'translations' => [
                    1 => 'Henüz çekim yok',
                    2 => 'Выводов пока нет'
                ]
            ],
            [
                'key' => 'user.transactions.withdrawals.no_withdrawals_desc',
                'translations' => [
                    1 => 'Çekim geçmişiniz burada görünecek',
                    2 => 'История ваших выводов будет отображаться здесь'
                ]
            ],

            // Others Section
            [
                'key' => 'user.transactions.others.title',
                'translations' => [
                    1 => 'Diğer İşlemler',
                    2 => 'Другие транзакции'
                ]
            ],
            [
                'key' => 'user.transactions.others.description',
                'translations' => [
                    1 => 'Ek işlem geçmişi',
                    2 => 'Дополнительная история транзакций'
                ]
            ],
            [
                'key' => 'user.transactions.others.search_placeholder',
                'translations' => [
                    1 => 'İşlemleri ara...',
                    2 => 'Поиск транзакций...'
                ]
            ],
            [
                'key' => 'user.transactions.others.label',
                'translations' => [
                    1 => 'İşlem',
                    2 => 'Транзакция'
                ]
            ],
            [
                'key' => 'user.transactions.others.description_label',
                'translations' => [
                    1 => 'Açıklama',
                    2 => 'Описание'
                ]
            ],
            [
                'key' => 'user.transactions.others.type',
                'translations' => [
                    1 => 'Tür',
                    2 => 'Тип'
                ]
            ],
            [
                'key' => 'user.transactions.others.not_available',
                'translations' => [
                    1 => 'Yok',
                    2 => 'Не доступно'
                ]
            ],
            [
                'key' => 'user.transactions.others.no_transactions',
                'translations' => [
                    1 => 'Diğer işlem yok',
                    2 => 'Других транзакций нет'
                ]
            ],
            [
                'key' => 'user.transactions.others.no_transactions_desc',
                'translations' => [
                    1 => 'Ek işlemler burada görünecek',
                    2 => 'Дополнительные транзакции будут отображаться здесь'
                ]
            ],

            // Pagination
            [
                'key' => 'user.transactions.pagination.previous',
                'translations' => [
                    1 => 'Önceki',
                    2 => 'Предыдущая'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.next',
                'translations' => [
                    1 => 'Sonraki',
                    2 => 'Следующая'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.from',
                'translations' => [
                    1 => 'den',
                    2 => ' с'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.to',
                'translations' => [
                    1 => 'e kadar',
                    2 => ' по'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.total_deposits',
                'translations' => [
                    1 => 'toplam yatırım',
                    2 => 'всего депозитов'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.deposits_showing',
                'translations' => [
                    1 => 'yatırım gösteriliyor',
                    2 => 'депозитов отображается'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.total_withdrawals',
                'translations' => [
                    1 => 'toplam çekim',
                    2 => 'всего выводов'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.withdrawals_showing',
                'translations' => [
                    1 => 'çekim gösteriliyor',
                    2 => 'выводов отображается'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.total_transactions',
                'translations' => [
                    1 => 'toplam işlem',
                    2 => 'всего транзакций'
                ]
            ],
            [
                'key' => 'user.transactions.pagination.transactions_showing',
                'translations' => [
                    1 => 'işlem gösteriliyor',
                    2 => 'транзакций отображается'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or find phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['key']
            ], [
                'description' => 'User Transactions Page - ' . $phraseData['key']
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

        $this->command->info('✅ User Transactions phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}