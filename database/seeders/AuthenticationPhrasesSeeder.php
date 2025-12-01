<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AuthenticationPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for authentication phrases.
     */
    public function run(): void
    {
        $phrases = [
            // Auth Login Phrases
            'auth.login.welcome' => [
                'tr' => 'Hoş Geldiniz',
                'ru' => 'Добро пожаловать',
            ],
            'auth.login.login_to_platform' => [
                'tr' => 'Ticaret platformuna giriş yapın',
                'ru' => 'Войдите в торговую платформу',
            ],
            'auth.login.remember_me' => [
                'tr' => 'Beni hatırla',
                'ru' => 'Запомнить меня',
            ],
            'auth.login.forgot_password' => [
                'tr' => 'Şifremi Unuttum',
                'ru' => 'Забыли пароль',
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
                'tr' => 'Buradan kayıt olun',
                'ru' => 'Зарегистрируйтесь здесь',
            ],

            // Auth Forms Common Phrases
            'auth.forms.email_address' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Адрес электронной почты',
            ],
            'auth.forms.password' => [
                'tr' => 'Şifre',
                'ru' => 'Пароль',
            ],
            'auth.forms.full_name' => [
                'tr' => 'Ad Soyad',
                'ru' => 'Полное имя',
            ],
            'auth.forms.username' => [
                'tr' => 'Kullanıcı Adı',
                'ru' => 'Имя пользователя',
            ],
            'auth.forms.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона',
            ],
            'auth.forms.country' => [
                'tr' => 'Ülke',
                'ru' => 'Страна',
            ],
            'auth.forms.trading_username' => [
                'tr' => 'Ticaret Kullanıcı Adı',
                'ru' => 'Торговое имя пользователя',
            ],
            'auth.forms.choose_username' => [
                'tr' => 'Kullanıcı adı seçin',
                'ru' => 'Выберите имя пользователя',
            ],
            'auth.forms.enter_full_name' => [
                'tr' => 'Ad soyad giriniz',
                'ru' => 'Введите полное имя',
            ],
            'auth.forms.email_example' => [
                'tr' => 'eposta@ornek.com',
                'ru' => 'email@example.com',
            ],
            'auth.forms.phone_example' => [
                'tr' => '+90 (555) 123-4567',
                'ru' => '+7 (999) 123-4567',
            ],
            'auth.forms.select_country' => [
                'tr' => 'Ülkenizi seçin',
                'ru' => 'Выберите вашу страну',
            ],
            'auth.forms.create_strong_password' => [
                'tr' => 'Güçlü şifre oluşturun',
                'ru' => 'Создайте надежный пароль',
            ],
            'auth.forms.confirm_password' => [
                'tr' => 'Şifreyi Onayla',
                'ru' => 'Подтвердите пароль',
            ],
            'auth.forms.confirm_password_placeholder' => [
                'tr' => 'Şifrenizi onaylayın',
                'ru' => 'Подтвердите пароль',
            ],
            'auth.forms.email_placeholder' => [
                'tr' => 'E-posta adresinizi girin',
                'ru' => 'Введите ваш email',
            ],
            'auth.forms.password_placeholder' => [
                'tr' => 'Şifrenizi girin',
                'ru' => 'Введите ваш пароль',
            ],

            // Auth Register Phrases
            'auth.register.title' => [
                'tr' => 'Hesap Oluştur',
                'ru' => 'Создать аккаунт',
            ],
            'auth.register.join_platform' => [
                'tr' => ':site_name\'a Katılın',
                'ru' => 'Присоединиться к :site_name',
            ],
            'auth.register.start_trading_journey' => [
                'tr' => 'Profesyonel ticaret yolculuğunuza başlayın',
                'ru' => 'Начните свой путь в профессиональной торговле',
            ],
            'auth.register.investor_count' => [
                'tr' => '1M+ Yatırımcı',
                'ru' => '1М+ Инвесторов',
            ],
            'auth.register.community' => [
                'tr' => 'Topluluk',
                'ru' => 'Сообщество',
            ],
            'auth.register.please_fix_issues' => [
                'tr' => 'Lütfen Bu Sorunları Düzeltin:',
                'ru' => 'Пожалуйста, исправьте эти проблемы:',
            ],
            'auth.register.scroll_fix_fields' => [
                'tr' => 'Lütfen aşağı kaydırarak vurgulanan alanları düzeltin, ardından tekrar deneyin.',
                'ru' => 'Пожалуйста, прокрутите вниз и исправьте выделенные поля, затем повторите попытку.',
            ],
            'auth.register.personal_info' => [
                'tr' => 'Kişisel Bilgiler',
                'ru' => 'Личная информация',
            ],
            'auth.register.create_trading_profile' => [
                'tr' => 'Ticaret profilinizi oluşturun',
                'ru' => 'Создайте свой торговый профиль',
            ],
            'auth.register.location' => [
                'tr' => 'Konum',
                'ru' => 'Местоположение',
            ],
            'auth.register.regional_trading_preferences' => [
                'tr' => 'Bölgesel ticaret tercihlerinizi ayarlayın',
                'ru' => 'Настройте ваши региональные торговые предпочтения',
            ],
            'auth.register.regional_trading_info' => [
                'tr' => 'Bölgesel Ticaret Bilgileri',
                'ru' => 'Информация о региональной торговле',
            ],
            'auth.register.location_benefits' => [
                'tr' => 'Konumunuz, bölgeye özel özellikler, uyumluluk ve daha hızlı ticaret yürütme için optimum sunucu bağlantıları sağlamamıza yardımcı olur.',
                'ru' => 'Ваше местоположение помогает нам предоставить региональные функции, соответствие требованиям и оптимальные серверные соединения для более быстрого выполнения торгов.',
            ],
            'auth.register.account_security' => [
                'tr' => 'Hesap Güvenliği',
                'ru' => 'Безопасность аккаунта',
            ],
            'auth.register.secure_trading_account' => [
                'tr' => 'Ticaret hesabınızı güvenceye alın',
                'ru' => 'Обезопасьте свой торговый аккаунт',
            ],
            'auth.register.math_verification' => [
                'tr' => 'Basit Matematik Doğrulama',
                'ru' => 'Простая математическая проверка',
            ],
            'auth.register.math_question' => [
                'tr' => 'Bu basit matematiğin cevabı nedir?',
                'ru' => 'Каков ответ на эту простую математику?',
            ],
            'auth.register.math_answer_placeholder' => [
                'tr' => 'Cevabı giriniz (sadece rakamlar)',
                'ru' => 'Введите ответ (только цифры)',
            ],
            'auth.register.math_helper_text' => [
                'tr' => 'İnsan olduğunuzu doğrulamak için bu basit matematik problemini çözün. Rastgele kodlar yazmaktan çok daha kolay!',
                'ru' => 'Решите эту простую математическую задачу, чтобы подтвердить, что вы человек. Намного проще, чем писать случайные коды!',
            ],
            'auth.register.password_requirements' => [
                'tr' => 'Şifre Gereksinimleri:',
                'ru' => 'Требования к паролю:',
            ],
            'auth.register.password_min_length' => [
                'tr' => 'En az 8 karakter uzunluğunda',
                'ru' => 'Минимум 8 символов в длину',
            ],
            'auth.register.password_mixed_case' => [
                'tr' => 'Büyük ve küçük harf içerir',
                'ru' => 'Содержит заглавные и строчные буквы',
            ],
            'auth.register.password_special_char' => [
                'tr' => 'En az bir rakam veya özel karakter içerir',
                'ru' => 'Содержит хотя бы одну цифру или специальный символ',
            ],
            'auth.register.terms_accept_start' => [
                'tr' => ':site_name\'ın',
                'ru' => ':site_name',
            ],
            'auth.register.terms_conditions' => [
                'tr' => 'Şartlar ve Koşullarını',
                'ru' => 'Условия и положения',
            ],
            'auth.register.terms_accept_and' => [
                'tr' => 'kabul ediyorum ve',
                'ru' => 'Я принимаю и',
            ],
            'auth.register.privacy_policy' => [
                'tr' => 'Gizlilik Politikasını',
                'ru' => 'Политика конфиденциальности',
            ],
            'auth.register.terms_accept_end' => [
                'tr' => 'okuduğumu ve anladığımı beyan ediyorum',
                'ru' => 'Я прочитал и понял',
            ],
            'auth.register.age_market_consent' => [
                'tr' => 'Hesap oluşturarak en az 18 yaşında olduğunuzu ve ticaret güncellemeleri ile piyasa analizleri almayı kabul ettiğinizi onaylarsınız.',
                'ru' => 'Создавая аккаунт, вы подтверждаете, что вам исполнилось 18 лет и вы согласны получать торговые обновления и рыночную аналитику.',
            ],
            'auth.register.previous_step' => [
                'tr' => 'Önceki Adım',
                'ru' => 'Предыдущий шаг',
            ],
            'auth.register.step_indicator' => [
                'tr' => 'Adım :current / :total',
                'ru' => 'Шаг :current из :total',
            ],
            'auth.register.continue' => [
                'tr' => 'Devam Et',
                'ru' => 'Продолжить',
            ],
            'auth.register.create_trading_account' => [
                'tr' => 'Ticaret Hesabı Oluştur',
                'ru' => 'Создать торговый аккаунт',
            ],
            'auth.register.already_have_account' => [
                'tr' => 'Zaten hesabınız var mı?',
                'ru' => 'Уже есть аккаунт?',
            ],
            'auth.register.login_here' => [
                'tr' => 'Buradan giriş yapın',
                'ru' => 'Войдите здесь',
            ],
            'auth.register.ssl_security' => [
                'tr' => 'SSL Güvenliği',
                'ru' => 'SSL Безопасность',
            ],
            'auth.register.encryption_256bit' => [
                'tr' => '256-bit Şifreleme',
                'ru' => '256-битное шифрование',
            ],
            'auth.register.regulated_platform' => [
                'tr' => 'Düzenlenmiş Platform',
                'ru' => 'Регулируемая платформа',
            ],
            'auth.register.copyright' => [
                'tr' => '© :year :site_name. Tüm hakları saklıdır.',
                'ru' => '© :year :site_name. Все права защищены.',
            ],
            'auth.register.licensed_platform' => [
                'tr' => 'Lisanslı ve düzenlenmiş ticaret platformu.',
                'ru' => 'Лицензированная и регулируемая торговая платформа.',
            ],
            'auth.register.basic_info' => [
                'tr' => 'Temel bilgiler',
                'ru' => 'Основная информация',
            ],
            'auth.register.regional_settings' => [
                'tr' => 'Bölgesel ayarlar',
                'ru' => 'Региональные настройки',
            ],
            'auth.register.security' => [
                'tr' => 'Güvenlik',
                'ru' => 'Безопасность',
            ],
            'auth.register.account_protection' => [
                'tr' => 'Hesap koruması',
                'ru' => 'Защита аккаунта',
            ],
            'auth.register.step' => [
                'tr' => 'Adım',
                'ru' => 'Шаг',
            ],
            'auth.register.terms_acceptance' => [
                'tr' => 'Şartlar ve Koşullar Kabulü',
                'ru' => 'Принятие условий и положений',
            ],
            'auth.register.creating_account' => [
                'tr' => 'Hesap Oluşturuluyor...',
                'ru' => 'Создается аккаунт...',
            ],

            // Auth Validation Messages
            'auth.validation.valid_email_format' => [
                'tr' => 'Geçerli E-posta Formatı',
                'ru' => 'Действительный формат электронной почты',
            ],
            'auth.validation.password_min_8_chars' => [
                'tr' => 'Şifre (minimum 8 karakter)',
                'ru' => 'Пароль (минимум 8 символов)',
            ],
            'auth.validation.please_provide' => [
                'tr' => 'Lütfen sağlayın',
                'ru' => 'Пожалуйста, предоставьте',
            ],
            'auth.validation.please_fill_fields' => [
                'tr' => 'Lütfen bu alanları doldurun',
                'ru' => 'Пожалуйста, заполните эти поля',
            ],
            'auth.validation.required_fields' => [
                'tr' => 'Gerekli Alanları Doldurun',
                'ru' => 'Заполните обязательные поля',
            ],
            
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

            // Auth Error Messages (Laravel Auth Keys)
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
        ];

        foreach ($phrases as $key => $translations) {
            // Create phrase record
            $phrase = Phrase::create([
                'key' => $key,
                'description' => ucfirst(str_replace(['auth.', '.', '_'], ['', ' ', ' '], $key)),
                'group' => explode('.', $key)[1] ?? 'auth', // login, register, forms, validation
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
        }

        $this->command->info('Authentication phrases seeded successfully! Total phrases: ' . count($phrases));
    }
}