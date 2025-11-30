<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class VerificationPageMissingPhraseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phrases = [
            [
                'phrase_key' => 'user.verification.username_placeholder',
                'translations' => [
                    'tr' => '@kullanıcıadı',
                    'ru' => '@имяпользователя',
                ]
            ],
        ];

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($phrases as $phraseData) {
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['phrase_key']
            ]);

            $isNewPhrase = $phrase->wasRecentlyCreated;
            if ($isNewPhrase) {
                $createdCount++;
            } else {
                $updatedCount++;
            }

            foreach ($phraseData['translations'] as $languageCode => $translationValue) {
                // Language ID'yi bul
                $language = \App\Models\Language::where('code', $languageCode)->first();
                if ($language) {
                    PhraseTranslation::updateOrCreate(
                        [
                            'phrase_id' => $phrase->id,
                            'language_id' => $language->id,
                        ],
                        [
                            'translation' => $translationValue
                        ]
                    );
                }
            }
        }

        $this->command->info("Verification Page Missing Phrase Seeder completed!");
        $this->command->info("Created {$createdCount} new phrases, updated {$updatedCount} existing phrases");
    }
}