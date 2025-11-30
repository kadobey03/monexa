<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class UserHistoryPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $turkish = Language::where('code', 'tr')->first();
        $russian = Language::where('code', 'ru')->first();

        if (!$turkish || !$russian) {
            $this->command->error('Turkish or Russian language not found in database!');
            return;
        }

        $phrases = [
            // Page Headers
            'user.history.transaction_history' => [
                'tr' => 'İşlem Geçmişi',
                'ru' => 'История транзакций'
            ],
            'user.history.track_your_activities' => [
                'tr' => 'İşlem aktivitelerinizi takip edin',
                'ru' => 'Отслеживайте свои торговые активности'
            ],
            'user.history.transaction_overview' => [
                'tr' => 'İşlem Genel Bakışı',
                'ru' => 'Обзор транзакций'
            ],
            'user.history.track_your_performance' => [
                'tr' => 'İşlem performansınızı takip edin',
                'ru' => 'Отслеживайте свою торговую эффективность'
            ],

            // Statistics
            'user.history.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего'
            ],
            'user.history.wins' => [
                'tr' => 'Kazançlar',
                'ru' => 'Победы'
            ],
            'user.history.losses' => [
                'tr' => 'Kayıplar',
                'ru' => 'Потери'
            ],
            'user.history.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активные'
            ],

            // Filter Buttons
            'user.history.all' => [
                'tr' => 'Tümü',
                'ru' => 'Все'
            ],
            'user.history.buy' => [
                'tr' => 'Alış',
                'ru' => 'Покупка'
            ],
            'user.history.sell' => [
                'tr' => 'Satış',
                'ru' => 'Продажа'
            ],
            'user.history.monitor' => [
                'tr' => 'Monitör',
                'ru' => 'Монитор'
            ],

            // Empty State
            'user.history.no_transaction_history' => [
                'tr' => 'İşlem geçmişi yok',
                'ru' => 'Нет истории транзакций'
            ],
            'user.history.transaction_activities_will_appear_here' => [
                'tr' => 'İşlem aktiviteleriniz burada görünecek',
                'ru' => 'Ваши торговые активности появятся здесь'
            ],
            'user.history.back_to_homepage' => [
                'tr' => 'Ana Sayfaya Dön',
                'ru' => 'Вернуться на главную'
            ],

            // Pagination
            'user.history.showing' => [
                'tr' => 'Gösterilen',
                'ru' => 'Показаны'
            ],
            'user.history.to' => [
                'tr' => 'ile',
                'ru' => 'по'
            ],
            'user.history.of' => [
                'tr' => 'toplam',
                'ru' => 'из'
            ],
            'user.history.transactions' => [
                'tr' => 'işlem',
                'ru' => 'транзакций'
            ],
            'user.history.previous' => [
                'tr' => 'Önceki',
                'ru' => 'Предыдущая'
            ],
            'user.history.next' => [
                'tr' => 'Sonraki',
                'ru' => 'Следующая'
            ],

            // Mobile Page Selector
            'user.history.go_to_page' => [
                'tr' => 'Sayfaya git',
                'ru' => 'Перейти к странице'
            ],
            'user.history.page_of_pages' => [
                'tr' => ':page. sayfa / :total sayfa',
                'ru' => 'Страница :page из :total'
            ],

            // Performance Metrics
            'user.history.items_per_page' => [
                'tr' => 'Sayfa başına :count öğe',
                'ru' => ':count элементов на странице'
            ],
            'user.history.page_of_total_pages' => [
                'tr' => ':total sayfanın :current. sayfası',
                'ru' => 'Страница :current из :total'
            ],
            'user.history.more_items' => [
                'tr' => ':count daha fazla öğe',
                'ru' => 'Еще :count элементов'
            ]
        ];

        $this->command->info('Creating user history translation phrases...');
        $createdCount = 0;

        foreach ($phrases as $key => $translations) {
            try {
                // Create or update phrase
                $phrase = Phrase::firstOrCreate(['key' => $key]);
                
                // Create or update Turkish translation
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $turkish->id,
                    ],
                    ['translation' => $translations['tr']]
                );

                // Create or update Russian translation
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $russian->id,
                    ],
                    ['translation' => $translations['ru']]
                );

                $createdCount++;
                $this->command->info("✓ Created phrase: {$key}");

            } catch (\Exception $e) {
                $this->command->error("✗ Failed to create phrase {$key}: " . $e->getMessage());
            }
        }

        $this->command->info("User history phrases seeding completed! Created {$createdCount} phrases.");
    }
}