<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class ProfileModulePhrasesSeeder extends Seeder
{
    public function run()
    {
        echo "\n=== PROFILE MODULE PHRASES SEEDER ===\n";
        
        $phrases = [
            // Page Headers
            'admin.profile.title' => [
                'tr' => 'Hesap Profil Bilgileri',
                'ru' => 'Информация профиля аккаунта'
            ],
            'admin.profile.description' => [
                'tr' => 'Kişisel bilgilerinizi ve güvenlik ayarlarınızı yönetin',
                'ru' => 'Управляйте вашей личной информацией и настройками безопасности'
            ],
            'admin.profile.form_title' => [
                'tr' => 'Profil Bilgileri',
                'ru' => 'Информация профиля'
            ],
            
            // Form Fields
            'admin.profile.first_name' => [
                'tr' => 'Ad',
                'ru' => 'Имя'
            ],
            'admin.profile.last_name' => [
                'tr' => 'Soyad',
                'ru' => 'Фамилия'
            ],
            'admin.profile.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона'
            ],
            'admin.profile.two_factor_auth' => [
                'tr' => 'İki Faktörlü Kimlik Doğrulama',
                'ru' => 'Двухфакторная аутентификация'
            ],
            
            // Placeholders
            'admin.profile.first_name_placeholder' => [
                'tr' => 'Adınızı girin',
                'ru' => 'Введите ваше имя'
            ],
            'admin.profile.last_name_placeholder' => [
                'tr' => 'Soyadınızı girin',
                'ru' => 'Введите вашу фамилию'
            ],
            'admin.profile.phone_placeholder' => [
                'tr' => '+90 555 123 45 67',
                'ru' => '+7 999 123 45 67'
            ],
            
            // Select Options
            'admin.profile.enable_2fa' => [
                'tr' => 'Etkinleştir',
                'ru' => 'Включить'
            ],
            'admin.profile.disable_2fa' => [
                'tr' => 'Devre Dışı Bırak',
                'ru' => 'Отключить'
            ],
            'admin.profile.2fa_info' => [
                'tr' => 'Ek güvenlik için iki faktörlü kimlik doğrulamayı etkinleştirin',
                'ru' => 'Включите двухфакторную аутентификацию для дополнительной безопасности'
            ],
            
            // Buttons
            'admin.profile.reset_button' => [
                'tr' => 'Sıfırla',
                'ru' => 'Сбросить'
            ],
            'admin.profile.update_button' => [
                'tr' => 'Güncelle',
                'ru' => 'Обновить'
            ],
            'admin.profile.updating_button' => [
                'tr' => 'Güncelliyor...',
                'ru' => 'Обновляется...'
            ],
            
            // Security Info
            'admin.profile.security_info_title' => [
                'tr' => 'Güvenlik Bilgisi',
                'ru' => 'Информация о безопасности'
            ],
            'admin.profile.security_tip_1' => [
                'tr' => 'Profil bilgilerinizi güncel tutun',
                'ru' => 'Держите информацию профиля актуальной'
            ],
            'admin.profile.security_tip_2' => [
                'tr' => 'Güvenliğiniz için iki faktörlü kimlik doğrulamayı etkinleştirin',
                'ru' => 'Включите двухфакторную аутентификацию для безопасности'
            ],
            'admin.profile.security_tip_3' => [
                'tr' => 'Telefon numaranızın doğru olduğundan emin olun',
                'ru' => 'Убедитесь, что ваш номер телефона правильный'
            ],
            
            // Validation Messages
            'admin.profile.validation.required' => [
                'tr' => 'Bu alan zorunludur.',
                'ru' => 'Это поле обязательно.'
            ],
            'admin.profile.validation.invalid_phone' => [
                'tr' => 'Geçerli bir telefon numarası girin.',
                'ru' => 'Введите действительный номер телефона.'
            ],
            
            // Top Menu Profile Dropdown
            'admin.profile.dropdown.account_settings' => [
                'tr' => 'Hesap Ayarları',
                'ru' => 'Настройки аккаунта'
            ],
            'admin.profile.dropdown.change_password' => [
                'tr' => 'Şifre Değiştir',
                'ru' => 'Сменить пароль'
            ],
            'admin.profile.dropdown.logout' => [
                'tr' => 'Çıkış Yap',
                'ru' => 'Выйти'
            ],
            
            // Top Menu Search & Notifications
            'admin.topmenu.search_placeholder' => [
                'tr' => 'Kullanıcıları ara...',
                'ru' => 'Поиск пользователей...'
            ],
            'admin.topmenu.sidebar_toggle' => [
                'tr' => 'Menüyü aç/kapat',
                'ru' => 'Открыть/закрыть меню'
            ],
            'admin.topmenu.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            'admin.topmenu.no_notifications' => [
                'tr' => 'Yeni bildirim yok',
                'ru' => 'Новых уведомлений нет'
            ],
            'admin.topmenu.view_all_notifications' => [
                'tr' => 'Tüm bildirimleri görüntüle',
                'ru' => 'Посмотреть все уведомления'
            ],
            
            // Language Names
            'admin.topmenu.language.turkish' => [
                'tr' => 'Türkçe',
                'ru' => 'Турецкий'
            ],
            'admin.topmenu.language.russian' => [
                'tr' => 'Русский',
                'ru' => 'Русский'
            ]
        ];

        $processedCount = 0;
        $newTranslationsCount = 0;
        
        // Language ID mapping
        $languageIds = [
            'tr' => 1,  // Turkish
            'ru' => 2   // Russian
        ];

        DB::beginTransaction();

        try {
            foreach ($phrases as $key => $translations) {
                // Create or get phrase
                $phrase = Phrase::firstOrCreate([
                    'key' => $key
                ], [
                    'group' => 'admin.profile',
                    'description' => "Profile management phrase: {$key}"
                ]);

                foreach ($translations as $langCode => $translation) {
                    $languageId = $languageIds[$langCode];
                    
                    // Check if translation already exists
                    $existingTranslation = PhraseTranslation::where([
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ])->first();

                    if (!$existingTranslation) {
                        PhraseTranslation::create([
                            'phrase_id' => $phrase->id,
                            'language_id' => $languageId,
                            'translation' => $translation
                        ]);
                        $newTranslationsCount++;
                    }
                }
                
                $processedCount++;
            }

            DB::commit();
            
            echo "Total phrases processed: {$processedCount}\n";
            echo "New phrase translations added: {$newTranslationsCount}\n";
            echo "Categories covered: admin.profile\n";
            echo "✅ Profile Module phrases seeded successfully!\n";
            
        } catch (\Exception $e) {
            DB::rollback();
            echo "❌ Error seeding phrases: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}