<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class NavigationPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            'navigation.language_turkish' => [
                1 => 'Türkçe',      // TR language_id = 1
                2 => 'Турецкий',    // RU language_id = 2
            ],
            'navigation.language_russian' => [
                1 => 'Rusça',       // TR language_id = 1
                2 => 'Русский',     // RU language_id = 2
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            // Add translations for each language
            foreach ($translations as $languageId => $value) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ],
                    [
                        'translation' => $value,
                        'is_reviewed' => true,
                        'reviewer' => 'system',
                        'reviewed_at' => now()
                    ]
                );
            }
            
            echo "✅ Navigation phrase '{$key}' added with translations\n";
        }
        
        echo "🎯 Navigation phrases seeder completed successfully!\n";
    }
}