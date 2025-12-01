<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AuthErrorMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds for authentication error messages.
     */
    public function run(): void
    {
        $phrases = [
            // Auth Error Messages (Laravel Auth Keys) - for FortifyServiceProvider
            'auth.failed' => [
                'tr' => 'Bu bilgiler kayıtlarımızla eşleşmiyor.',
                'ru' => 'Эти учетные данные не соответствуют нашим записям.',
            ],
            'auth.password' => [
                'tr' => 'Girdiğiniz şifre yanlış.',
                'ru' => 'Введенный пароль неверен.',
            ],
            'auth.throttle' => [
                'tr' => 'Çok fazla giriş denemesi yapıldı. Lütfen :seconds saniye sonra tekrar deneyin.',
                'ru' => 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.',
            ],
            'auth.email_not_exists' => [
                'tr' => 'Bu e-posta adresi ile kayıtlı hesap bulunamadı. Kayıt olmak için tıklayın.',
                'ru' => 'Учетная запись с этим адресом электронной почты не найдена. Нажмите, чтобы зарегистрироваться.',
            ],
            'auth.account_locked' => [
                'tr' => 'Hesabınız çok fazla başarısız giriş denemesi nedeniyle :minutes dakika boyunca kilitlenmiştir.',
                'ru' => 'Ваша учетная запись заблокирована на :minutes минут из-за слишком большого количества неудачных попыток входа.',
            ],
            'auth.registration_suggestion' => [
                'tr' => 'Bu e-posta adresi kayıtlı değil. Hesap oluşturmak ister misiniz?',
                'ru' => 'Этот адрес электронной почты не зарегистрирован. Хотите создать учетную запись?',
            ],
            
            // Ajax Login Success Messages
            'auth.login.success_message' => [
                'tr' => 'Giriş başarılı! Hoşgeldiniz, :name!',
                'ru' => 'Вход выполнен успешно! Добро пожаловать, :name!',
            ],
            'auth.login.redirecting_message' => [
                'tr' => "Dashboard'a yönlendiriliyorsunuz...",
                'ru' => 'Перенаправление в панель управления...',
            ],
            'auth.login.loading_text' => [
                'tr' => 'Giriş yapılıyor...',
                'ru' => 'Вход в систему...',
            ],
            
            // Ajax Error Messages
            'auth.ajax.general_error' => [
                'tr' => 'Bir hata oluştu. Lütfen tekrar deneyin.',
                'ru' => 'Произошла ошибка. Пожалуйста, попробуйте еще раз.',
            ],
            'auth.ajax.connection_error' => [
                'tr' => 'Bağlantı hatası. Lütfen tekrar deneyin.',
                'ru' => 'Ошибка подключения. Пожалуйста, попробуйте еще раз.',
            ],
            'auth.ajax.server_error' => [
                'tr' => 'Sunucu hatası. Lütfen daha sonra tekrar deneyin.',
                'ru' => 'Ошибка сервера. Пожалуйста, попробуйте позже.',
            ],
            
            // Login Form Messages
            'auth.forms.email' => [
                'tr' => 'E-posta',
                'ru' => 'Электронная Почта',
            ],
            'auth.forms.email_address' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Адрес Электронной Почты',
            ],
            'auth.forms.email_placeholder' => [
                'tr' => 'email@example.com',
                'ru' => 'email@example.com',
            ],
            'auth.forms.password' => [
                'tr' => 'Şifre',
                'ru' => 'Пароль',
            ],
            'auth.forms.password_placeholder' => [
                'tr' => 'Şifrenizi girin',
                'ru' => 'Введите ваш пароль',
            ],
            
            // Login Page Messages
            'auth.login.title' => [
                'tr' => 'Giriş Yap',
                'ru' => 'Войти',
            ],
            'auth.login.welcome' => [
                'tr' => 'Hoşgeldiniz',
                'ru' => 'Добро Пожаловать',
            ],
            'auth.login.login_to_platform' => [
                'tr' => ':site_name hesabınıza giriş yapın',
                'ru' => 'Войдите в свой аккаунт :site_name',
            ],
            'auth.login.remember_me' => [
                'tr' => 'Beni hatırla',
                'ru' => 'Запомнить меня',
            ],
            'auth.login.forgot_password' => [
                'tr' => 'Şifremi unuttum',
                'ru' => 'Забыли пароль?',
            ],
            'auth.login.login_button' => [
                'tr' => 'Giriş Yap',
                'ru' => 'Войти',
            ],
            'auth.login.no_account' => [
                'tr' => 'Hesabınız yok mu?',
                'ru' => 'Нет аккаунта?',
            ],
            'auth.login.register_link' => [
                'tr' => 'Kayıt olun',
                'ru' => 'Зарегистрироваться',
            ],
            
            // Validation Messages
            'auth.validation.email_required' => [
                'tr' => 'E-posta adresi gereklidir.',
                'ru' => 'Адрес электронной почты обязателен.',
            ],
            'auth.validation.email_format' => [
                'tr' => 'Geçerli bir e-posta adresi giriniz.',
                'ru' => 'Введите действующий адрес электронной почты.',
            ],
            'auth.validation.password_required' => [
                'tr' => 'Şifre gereklidir.',
                'ru' => 'Пароль обязателен.',
            ],
            
            // Login Error Messages
            'auth.errors.email_not_registered' => [
                'tr' => 'Bu e-posta adresiyle kayıtlı bir hesabımız bulunmamaktadır. <a href=":register_url" class="text-blue-600 hover:text-blue-500 underline font-semibold">Hemen hesap oluşturun</a>.',
                'ru' => 'У нас нет учетной записи, зарегистрированной с этим адресом электронной почты. <a href=":register_url" class="text-blue-600 hover:text-blue-500 underline font-semibold">Создать аккаунт сейчас</a>.',
            ],
            'auth.errors.account_locked_minutes' => [
                'tr' => 'Hesabınız kilitli. Lütfen :minutes dakika sonra tekrar deneyin.',
                'ru' => 'Ваш аккаунт заблокирован. Пожалуйста, попробуйте еще раз через :minutes минут.',
            ],
            'auth.errors.account_blocked' => [
                'tr' => 'Hesabınız yönetici tarafından engellenmiştir. Destek ekibi ile iletişime geçin.',
                'ru' => 'Ваш аккаунт заблокирован администратором. Обратитесь в службу поддержки.',
            ],
            'auth.errors.account_suspended' => [
                'tr' => 'Hesabınız geçici olarak askıya alınmıştır. Lütfen destek ekibi ile iletişime geçin.',
                'ru' => 'Ваш аккаунт временно приостановлен. Пожалуйста, свяжитесь со службой поддержки.',
            ],
            'auth.errors.account_inactive' => [
                'tr' => 'Hesabınız aktif durumda değil. Lütfen hesabınızı aktifleştirin.',
                'ru' => 'Ваш аккаунт неактивен. Пожалуйста, активируйте свой аккаунт.',
            ],
            'auth.errors.account_unusable' => [
                'tr' => 'Hesabınız kullanılamaz durumda.',
                'ru' => 'Ваш аккаунт недоступен для использования.',
            ],
            'auth.errors.password_failed_locked' => [
                'tr' => 'Şifreniz 3 kez yanlış girildi. Hesabınız 1 dakika boyunca kilitlendi. Lütfen daha sonra tekrar deneyin.',
                'ru' => 'Пароль введен неверно 3 раза. Ваш аккаунт заблокирован на 1 минуту. Пожалуйста, попробуйте позже.',
            ],
            'auth.errors.password_failed_attempts' => [
                'tr' => 'Şifreniz yanlış! Kalan deneme hakkınız: :attempts',
                'ru' => 'Неверный пароль! Осталось попыток: :attempts',
            ],
            'auth.errors.rate_limit_exceeded' => [
                'tr' => 'Güvenlik nedeniyle geçici olarak engellendiniz. Lütfen :minutes dakika sonra tekrar deneyin.',
                'ru' => 'Вы временно заблокированы по соображениям безопасности. Пожалуйста, попробуйте еще раз через :minutes минут.',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Check if phrase already exists, skip if it does
            $existingPhrase = Phrase::where('key', $key)->first();
            if ($existingPhrase) {
                $this->command->info("Phrase '{$key}' already exists, skipping...");
                continue;
            }

            // Create phrase record
            $phrase = Phrase::create([
                'key' => $key,
                'description' => ucfirst(str_replace(['auth.', '.', '_'], ['', ' ', ' '], $key)),
                'group' => 'auth', // All are auth error messages
                'is_active' => true,
                'context' => 'web',
                'usage_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create translations for each language
            foreach ($translations as $languageCode => $translation) {
                $langId = $languageCode === 'tr' ? 1 : 2; // Turkish = 1, Russian = 2
                
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

        $this->command->info('Authentication error messages seeded successfully! Total new phrases: ' . count($phrases));
    }
}