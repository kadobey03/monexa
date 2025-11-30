<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AddAdminBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // JavaScript Console Log Messages
            'admin.notifications.add_admin_form_initialized' => [
                'tr' => 'Admin Ekleme formu Tailwind CSS ile başlatıldı',
                'ru' => 'Форма добавления администратора инициализирована с Tailwind CSS',
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

        $this->command->info('Add admin blade phrases seeded successfully! Total: ' . count($phrases));
    }
}