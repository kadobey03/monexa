<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class SecurityPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for security phrases only.
     */
    public function run(): void
    {
        $phrases = [
            // Auth Security Phrases
            'auth.security.warning_title' => [
                'tr' => 'Güvenlik Uyarısı',
                'ru' => 'Предупреждение безопасности',
            ],
            'auth.forgot.security_notice' => [
                'tr' => 'Güvenlik nedeniyle şifre sıfırlama bağlantıları 60 dakika içinde geçerliliğini yitirir. Eğer e-posta alamadıysanız, spam klasörünüzü kontrol edin veya destek ile iletişime geçin.',
                'ru' => 'По соображениям безопасности ссылки для сброса пароля действительны в течение 60 минут. Если вы не получили письмо, проверьте папку спам или обратитесь в службу поддержки.',
            ],
            'auth.security.ssl_secure' => [
                'tr' => 'SSL Güvenli',
                'ru' => 'SSL Защищено',
            ],
            'auth.security.encryption_256' => [
                'tr' => '256-bit Şifreleme',
                'ru' => '256-битное шифрование',
            ],
            'auth.security.regulated_platform' => [
                'tr' => 'Düzenlenmiş Platform',
                'ru' => 'Регулируемая платформа',
            ],
            'auth.security.licensed_platform' => [
                'tr' => 'Lisanslı ve düzenlenmiş ticaret platformu',
                'ru' => 'Лицензированная и регулируемая торговая платформа',
            ],
            'footer.copyright' => [
                'tr' => 'Tüm hakları saklıdır.',
                'ru' => 'Все права защищены.',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Check if phrase already exists, skip if it does
            $existingPhrase = Phrase::where('key', $key)->first();
            if ($existingPhrase) {
                $this->command->info("Skipping existing phrase: {$key}");
                continue;
            }

            // Create phrase record
            $phrase = Phrase::create([
                'key' => $key,
                'description' => ucfirst(str_replace(['auth.', 'footer.', '.', '_'], ['', '', ' ', ' '], $key)),
                'group' => explode('.', $key)[1] ?? 'security',
                'is_active' => true,
                'context' => 'web',
                'usage_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create translations for each language
            foreach ($translations as $languageId => $translation) {
                $langId = $languageId === 'tr' ? 1 : 2; // Turkish = 1, Russian = 2
                
                PhraseTranslation::create([
                    'phrase_id' => $phrase->id,
                    'language_id' => $langId,
                    'translation' => $translation,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->info("Added phrase: {$key}");
        }

        $this->command->info('Security phrases seeded successfully!');
    }
}