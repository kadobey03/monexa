<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class AccountBlockedPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get languages
        $turkish = Language::where('code', 'tr')->first();
        $russian = Language::where('code', 'ru')->first();

        if (!$turkish || !$russian) {
            $this->command->error('Turkish and Russian languages must exist before running this seeder');
            return;
        }

        $phrases = [
            'auth.account_blocked.your_account' => [
                'tr' => 'Hesabınız',
                'ru' => 'Ваш Аккаунт'
            ],
            'auth.account_blocked.temporarily_locked' => [
                'tr' => 'Geçici Olarak Kilitlendi',
                'ru' => 'Временно Заблокирован'
            ],
            'auth.account_blocked.dear_user' => [
                'tr' => 'Sevgili Değerli Kullanıcı',
                'ru' => 'Уважаемый Пользователь'
            ],
            'auth.account_blocked.fraud_detection_message' => [
                'tr' => 'Hesabınızda potansiyel olarak fraudulent bir işlem fark ettik ve güvenliğiniz için geçici olarak kilitledik.',
                'ru' => 'Мы обнаружили потенциально мошенническую активность в вашем аккаунте и временно заблокировали его для вашей безопасности.'
            ],
            'auth.account_blocked.contact_us_message' => [
                'tr' => 'Etkinliği doğrulamak ve erişiminizi geri yüklemek için lütfen en kısa sürede bizimle iletişime geçin',
                'ru' => 'Для подтверждения активности и восстановления доступа, пожалуйста, свяжитесь с нами как можно скорее'
            ],
            'auth.account_blocked.contact_methods' => [
                'tr' => 'adresinden veya canlı sohbet yoluyla.',
                'ru' => 'по указанному адресу электронной почты или через онлайн-чат.'
            ],
            'auth.account_blocked.email_support' => [
                'tr' => 'E-posta Desteği',
                'ru' => 'Поддержка по Email'
            ],
            'auth.account_blocked.live_chat' => [
                'tr' => 'Canlı Sohbet',
                'ru' => 'Онлайн Чат'
            ],
            'auth.account_blocked.available_24_7' => [
                'tr' => '7/24 Mevcut',
                'ru' => 'Доступно 24/7'
            ],
            'auth.account_blocked.contact_support_now' => [
                'tr' => 'Şimdi Destekle İletişime Geç',
                'ru' => 'Связаться с Поддержкой Сейчас'
            ],
            'auth.account_blocked.return_home' => [
                'tr' => 'Ana Sayfaya Dön',
                'ru' => 'Вернуться на Главную'
            ],
            'auth.account_blocked.security_notice' => [
                'tr' => 'Güvenlik Bildirimi',
                'ru' => 'Уведомление Безопасности'
            ],
            'auth.account_blocked.security_message' => [
                'tr' => 'Bu geçici kilitlenme korumanız içindir. Hesap güvenliğini ciddiye alıyoruz ve doğrulama tamamlandıktan sonra erişimi geri yükleyeceğiz.',
                'ru' => 'Эта временная блокировка для вашей защиты. Мы серьезно относимся к безопасности аккаунта и восстановим доступ после завершения верификации.'
            ]
        ];

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            if ($phrase->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $updatedCount++;
            }

            // Handle Turkish translation
            if (isset($translations['tr'])) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $turkish->id,
                    ],
                    [
                        'translation' => $translations['tr']
                    ]
                );
            }

            // Handle Russian translation
            if (isset($translations['ru'])) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $russian->id,
                    ],
                    [
                        'translation' => $translations['ru']
                    ]
                );
            }
        }

        $this->command->info("Account Blocked Phrases Seeder completed!");
        $this->command->info("Created {$createdCount} new phrases, updated {$updatedCount} existing phrases.");
    }
}