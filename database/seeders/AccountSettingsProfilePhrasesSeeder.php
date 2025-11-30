<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class AccountSettingsProfilePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get language IDs
        $turkish = Language::where('code', 'tr')->first();
        $russian = Language::where('code', 'ru')->first();

        if (!$turkish || !$russian) {
            $this->command->error('Languages not found. Please run language seeder first.');
            return;
        }

        $phrases = [
            // Profile Information Form
            'user.profile.form.full_name' => [
                'tr' => 'Tam Ad',
                'ru' => 'Полное имя'
            ],
            'user.profile.form.display_name' => [
                'tr' => 'Platformdaki görünen adınız',
                'ru' => 'Ваше отображаемое имя на платформе'
            ],
            'user.profile.form.full_name_error' => [
                'tr' => 'Lütfen tam adınızı girin',
                'ru' => 'Пожалуйста, введите ваше полное имя'
            ],
            'user.profile.form.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона'
            ],
            'user.profile.form.phone_description' => [
                'tr' => 'Hesap doğrulaması için kullanılır',
                'ru' => 'Используется для проверки аккаунта'
            ],
            'user.profile.form.email_address' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Адрес электронной почты'
            ],
            'user.profile.form.email_description' => [
                'tr' => 'Birincil iletişim e-postanız',
                'ru' => 'Ваш основной контактный email'
            ],
            'user.profile.form.email_readonly' => [
                'tr' => 'E-posta adresi değiştirilemez',
                'ru' => 'Email адрес не может быть изменен'
            ],
            'user.profile.form.country' => [
                'tr' => 'Ülke',
                'ru' => 'Страна'
            ],
            'user.profile.form.country_description' => [
                'tr' => 'Mevcut konumunuz',
                'ru' => 'Ваше текущее местоположение'
            ],
            'user.profile.form.username' => [
                'tr' => 'Kullanıcı Adı',
                'ru' => 'Имя пользователя'
            ],
            'user.profile.form.username_description' => [
                'tr' => 'Benzersiz tanımlayıcınız',
                'ru' => 'Ваш уникальный идентификатор'
            ],
            'user.profile.form.username_readonly' => [
                'tr' => 'Kullanıcı adı değiştirilemez',
                'ru' => 'Имя пользователя не может быть изменено'
            ],
            'user.profile.form.save_changes' => [
                'tr' => 'Değişiklikleri Kaydet',
                'ru' => 'Сохранить изменения'
            ],
            'user.profile.form.processing' => [
                'tr' => 'İşleniyor...',
                'ru' => 'Обработка...'
            ],
            'user.profile.form.update_error' => [
                'tr' => 'Profil güncellenemedi. Lütfen tekrar deneyin.',
                'ru' => 'Профиль не может быть обновлен. Пожалуйста, попробуйте еще раз.'
            ],

            // Password Form
            'user.profile.password.security_intro' => [
                'tr' => 'Şifrenizi düzenli olarak güncellemek hesabınızın güvenliğini sağlar. Başka yerde kullanmadığınız güçlü bir şifre oluşturun.',
                'ru' => 'Регулярное обновление пароля обеспечивает безопасность вашего аккаунта. Создайте надежный пароль, который вы не используете в других местах.'
            ],
            'user.profile.password.current_password' => [
                'tr' => 'Mevcut Şifre',
                'ru' => 'Текущий пароль'
            ],
            'user.profile.password.current_password_placeholder' => [
                'tr' => 'Mevcut şifreyi girin',
                'ru' => 'Введите текущий пароль'
            ],
            'user.profile.password.new_password' => [
                'tr' => 'Yeni Şifre',
                'ru' => 'Новый пароль'
            ],
            'user.profile.password.new_password_placeholder' => [
                'tr' => 'Yeni şifre girin',
                'ru' => 'Введите новый пароль'
            ],
            'user.profile.password.strength' => [
                'tr' => 'Şifre Gücü',
                'ru' => 'Сила пароля'
            ],
            'user.profile.password.confirm_password' => [
                'tr' => 'Yeni Şifreyi Onayla',
                'ru' => 'Подтвердите новый пароль'
            ],
            'user.profile.password.confirm_password_placeholder' => [
                'tr' => 'Yeni şifreyi onaylayın',
                'ru' => 'Подтвердите новый пароль'
            ],
            'user.profile.password.update_button' => [
                'tr' => 'Şifreyi Güncelle',
                'ru' => 'Обновить пароль'
            ],
            'user.profile.password.requirements_title' => [
                'tr' => 'Şifre Gereksinimleri',
                'ru' => 'Требования к паролю'
            ],
            'user.profile.password.requirement_length' => [
                'tr' => 'Minimum 8 karakter uzunluğunda - ne kadar çok olursa o kadar iyi',
                'ru' => 'Минимум 8 символов - чем больше, тем лучше'
            ],
            'user.profile.password.requirement_lowercase' => [
                'tr' => 'En az bir küçük harf',
                'ru' => 'Минимум одна строчная буква'
            ],
            'user.profile.password.requirement_uppercase' => [
                'tr' => 'En az bir büyük harf',
                'ru' => 'Минимум одна заглавная буква'
            ],
            'user.profile.password.requirement_number' => [
                'tr' => 'En az bir sayı veya özel sembol',
                'ru' => 'Минимум одна цифра или специальный символ'
            ],
            'user.profile.password.strength_very_weak' => [
                'tr' => 'Çok Zayıf',
                'ru' => 'Очень слабый'
            ],
            'user.profile.password.strength_weak' => [
                'tr' => 'Zayıf',
                'ru' => 'Слабый'
            ],
            'user.profile.password.strength_medium' => [
                'tr' => 'Orta',
                'ru' => 'Средний'
            ],
            'user.profile.password.strength_strong' => [
                'tr' => 'Güçlü',
                'ru' => 'Сильный'
            ],
        ];

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($phrases as $key => $translations) {
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            if ($phrase->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $updatedCount++;
            }

            // Turkish translation
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $turkish->id,
                ],
                [
                    'translation' => $translations['tr']
                ]
            );

            // Russian translation
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

        $this->command->info("Account Settings Profile Phrases Seeder completed!");
        $this->command->info("Created {$createdCount} new phrases, updated {$updatedCount} existing phrases");
        $this->command->info("Total phrases: " . count($phrases));
    }
}