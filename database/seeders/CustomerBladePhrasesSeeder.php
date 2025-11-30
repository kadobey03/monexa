<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class CustomerBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // General
            [
                'key' => 'admin.general.none',
                'tr' => 'Hiçbiri',
                'ru' => 'Нет'
            ],
            
            // Notifications
            [
                'key' => 'admin.notifications.page_loaded_successfully',
                'tr' => 'Müşteri yönetim sayfası başarıyla yüklendi',
                'ru' => 'Страница управления клиентами успешно загружена'
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);
            
            // Add Turkish translation (language_id: 1)
            PhraseTranslation::updateOrCreate([
                'phrase_id' => $phrase->id,
                'language_id' => 1
            ], [
                'translation' => $phraseData['tr']
            ]);
            
            // Add Russian translation (language_id: 2)
            PhraseTranslation::updateOrCreate([
                'phrase_id' => $phrase->id,
                'language_id' => 2
            ], [
                'translation' => $phraseData['ru']
            ]);
        }

        $this->command->info('Customer blade phrases seeded successfully! Total: ' . count($phrases));
    }
}