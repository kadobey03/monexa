<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class ReferUserBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Form Email Placeholder
            'admin.forms.email_placeholder' => [
                'tr' => 'email@ornek.com',
                'ru' => 'email@example.com',
            ],

            // Password Visibility Notifications (JavaScript Comments)
            'admin.notifications.password_visible' => [
                'tr' => 'Şifre görünür',
                'ru' => 'Пароль виден',
            ],
            'admin.notifications.password_hidden' => [
                'tr' => 'Şifre gizli',
                'ru' => 'Пароль скрыт',
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

        $this->command->info('Refer user blade phrases seeded successfully! Total: ' . count($phrases));
    }
}