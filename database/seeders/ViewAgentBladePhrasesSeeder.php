<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class ViewAgentBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Customer Plural Forms
            'admin.customers.customers' => [
                'tr' => 'müşteri',
                'ru' => 'клиенты',
            ],

            // Customer Showing (Singular)  
            'admin.customers.customer_showing' => [
                'tr' => 'müşteri gösteriliyor',
                'ru' => 'клиент показан',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or update phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create or update translations
            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : 2; // 1 = Turkish, 2 = Russian
                
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

        $this->command->info('View agent blade phrases seeded successfully! Total: ' . count($phrases));
    }
}