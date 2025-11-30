<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserProfilePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Profile Settings Header
            [
                'key' => 'user.profile.settings_title',
                'translations' => [
                    1 => 'Profil Ayarları', // Turkish
                    2 => 'Настройки профиля' // Russian
                ]
            ],
            [
                'key' => 'user.profile.settings_description',
                'translations' => [
                    1 => 'Hesap bilgilerinizi ve güvenlik tercihlerinizi yönetin',
                    2 => 'Управляйте информацией об аккаунте и настройками безопасности'
                ]
            ],
            [
                'key' => 'user.profile.back_to_dashboard',
                'translations' => [
                    1 => 'Dashboard\'a Geri Dön',
                    2 => 'Назад к панели управления'
                ]
            ],

            // Breadcrumb Navigation
            [
                'key' => 'user.profile.breadcrumb_home',
                'translations' => [
                    1 => 'Ana Sayfa',
                    2 => 'Главная страница'
                ]
            ],
            [
                'key' => 'user.profile.breadcrumb_profile',
                'translations' => [
                    1 => 'Profil',
                    2 => 'Профиль'
                ]
            ],

            // Tab Navigation
            [
                'key' => 'user.profile.tab_personal_info',
                'translations' => [
                    1 => 'Kişisel Bilgiler',
                    2 => 'Личная информация'
                ]
            ],
            [
                'key' => 'user.profile.tab_security',
                'translations' => [
                    1 => 'Güvenlik',
                    2 => 'Безопасность'
                ]
            ],

            // Help Messages
            [
                'key' => 'user.profile.personal_info_help',
                'translations' => [
                    1 => 'Kişisel bilgileriniz deneyiminizi kişiselleştirmemize yardımcı olur. Lütfen tüm ayrıntıların doğru ve güncel olduğundan emin olun.',
                    2 => 'Ваша личная информация помогает нам персонализировать ваш опыт. Пожалуйста, убедитесь, что все данные точны и актуальны.'
                ]
            ],
            [
                'key' => 'user.profile.security_help',
                'translations' => [
                    1 => 'Güçlü şifreler hesabınızı korumaya yardımcı olur. Rakam, harf ve özel karakterler içeren benzersiz bir şifre kullanın.',
                    2 => 'Надёжные пароли помогают защитить ваш аккаунт. Используйте уникальный пароль, содержащий цифры, буквы и специальные символы.'
                ]
            ],

            // Recent Activities Section
            [
                'key' => 'user.profile.recent_activities',
                'translations' => [
                    1 => 'Son Aktiviteler',
                    2 => 'Последняя активность'
                ]
            ],
            [
                'key' => 'user.profile.recent_activities_desc',
                'translations' => [
                    1 => 'Hesabınızdaki son işlemler',
                    2 => 'Последние операции на вашем счёте'
                ]
            ],

            // Activity Items
            [
                'key' => 'user.profile.activity_login',
                'translations' => [
                    1 => 'Hesap Girişi',
                    2 => 'Вход в аккаунт'
                ]
            ],
            [
                'key' => 'user.profile.activity_last_login',
                'translations' => [
                    1 => 'Son giriş',
                    2 => 'Последний вход'
                ]
            ],
            [
                'key' => 'user.profile.activity_profile_updated',
                'translations' => [
                    1 => 'Profil Güncellendi',
                    2 => 'Профиль обновлён'
                ]
            ],
            [
                'key' => 'user.profile.activity_profile_updated_desc',
                'translations' => [
                    1 => 'Profil bilgilerinizi güncellediniz',
                    2 => 'Вы обновили информацию профиля'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or find phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['key']
            ], [
                'description' => 'User Profile Page - ' . $phraseData['key']
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

        $this->command->info('✅ User Profile phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with translations');
    }
}