<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class ForgotPasswordPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // User Forgot Password
            [
                'key' => 'auth.forgot.page_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi mi unuttunuz?',
                    2 => 'Забыли пароль?'
                ]
            ],
            [
                'key' => 'auth.forgot.main_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifremi Unuttum?',
                    2 => 'Забыл пароль?'
                ]
            ],
            [
                'key' => 'auth.forgot.description',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Endişelenmeyin! E-posta adresinizi girin ve ticaret hesabınızın şifresini sıfırlamak için güvenli bir bağlantı gönderelim.',
                    2 => 'Не волнуйтесь! Введите свой email-адрес, и мы отправим безопасную ссылку для сброса пароля вашего торгового счета.'
                ]
            ],
            [
                'key' => 'auth.forgot.email_help',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Ticaret hesabınızla ilişkili e-posta adresini girin',
                    2 => 'Введите email-адрес, связанный с вашим торговым счетом'
                ]
            ],
            [
                'key' => 'auth.forgot.send_reset_link',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Sıfırlama Bağlantısı Gönder',
                    2 => 'Отправить ссылку для сброса'
                ]
            ],
            [
                'key' => 'auth.forgot.remember_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi hatırlıyor musunuz?',
                    2 => 'Помните свой пароль?'
                ]
            ],
            [
                'key' => 'auth.forgot.back_to_login',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Girişe Dön',
                    2 => 'Вернуться к входу'
                ]
            ],
            [
                'key' => 'auth.forgot.no_account',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Hesabınız yok mu?',
                    2 => 'Нет аккаунта?'
                ]
            ],
            [
                'key' => 'auth.forgot.create_account',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Ticaret Hesabı Oluştur',
                    2 => 'Создать торговый счет'
                ]
            ],
            [
                'key' => 'auth.forgot.security_notice',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenlik nedeniyle şifre sıfırlama bağlantıları 60 dakika içinde geçerliliğini yitirir. Eğer e-posta alamadıysanız, spam klasörünüzü kontrol edin veya destek ile iletişime geçin.',
                    2 => 'По соображениям безопасности ссылки для сброса пароля действительны в течение 60 минут. Если вы не получили письмо, проверьте папку спам или обратитесь в службу поддержки.'
                ]
            ],

            // User Reset Password
            [
                'key' => 'auth.reset.page_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi sıfırlayın',
                    2 => 'Сбросить пароль'
                ]
            ],
            [
                'key' => 'auth.reset.main_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifre Sıfırlama',
                    2 => 'Сброс пароля'
                ]
            ],
            [
                'key' => 'auth.reset.description',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'E-posta adresinizi girin ve ticaret hesabınız için yeni güvenli bir şifre oluşturun.',
                    2 => 'Введите свой email-адрес и создайте новый безопасный пароль для торгового счета.'
                ]
            ],
            [
                'key' => 'auth.reset.new_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yeni Şifre',
                    2 => 'Новый пароль'
                ]
            ],
            [
                'key' => 'auth.reset.strong_password_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güçlü şifre oluşturun',
                    2 => 'Создайте надежный пароль'
                ]
            ],
            [
                'key' => 'auth.reset.confirm_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifreyi Onayla',
                    2 => 'Подтвердить пароль'
                ]
            ],
            [
                'key' => 'auth.reset.confirm_password_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi onaylayın',
                    2 => 'Подтвердите пароль'
                ]
            ],
            [
                'key' => 'auth.reset.password_requirements',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifre Gereksinimleri',
                    2 => 'Требования к паролю'
                ]
            ],
            [
                'key' => 'auth.reset.min_length_8',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'En az 8 karakter uzunluğunda',
                    2 => 'Минимум 8 символов'
                ]
            ],
            [
                'key' => 'auth.reset.mixed_case',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Büyük ve küçük harf içeriyor',
                    2 => 'Прописные и строчные буквы'
                ]
            ],
            [
                'key' => 'auth.reset.number_or_special',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'En az bir rakam veya özel karakter içeriyor',
                    2 => 'Минимум одна цифра или специальный символ'
                ]
            ],
            [
                'key' => 'auth.reset.reset_password_button',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifreyi Sıfırla',
                    2 => 'Сбросить пароль'
                ]
            ],
            [
                'key' => 'auth.reset.remember_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi hatırlıyor musunuz?',
                    2 => 'Помните свой пароль?'
                ]
            ],
            [
                'key' => 'auth.reset.back_to_login',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Girişe Dön',
                    2 => 'Вернуться к входу'
                ]
            ],
            [
                'key' => 'auth.reset.security_notice',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenliğiniz için bu şifre sıfırlama bağlantısı 60 dakika içinde geçerliliğini yitirecektir. Ticaret hesabınız için güçlü ve benzersiz bir şifre seçin.',
                    2 => 'Для вашей безопасности эта ссылка для сброса пароля истечет через 60 минут. Выберите надежный и уникальный пароль для торгового счета.'
                ]
            ],

            // Confirm Password
            [
                'key' => 'auth.confirm.page_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi onaylayın',
                    2 => 'Подтвердите пароль'
                ]
            ],
            [
                'key' => 'auth.confirm.secure_area_message',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Bu güvenli bir alandır. Devam etmeden önce lütfen şifrenizi onaylayın.',
                    2 => 'Это защищенная область. Пожалуйста, подтвердите пароль, прежде чем продолжить.'
                ]
            ],
            [
                'key' => 'auth.confirm.enter_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifre Girin',
                    2 => 'Введите пароль'
                ]
            ],
            [
                'key' => 'auth.confirm.confirm_button',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Onayla',
                    2 => 'Подтвердить'
                ]
            ],

            // Admin Forgot Password
            [
                'key' => 'auth.admin.forgot.page_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Şifre Kurtarma - Güvenli Erişim Kurtarma',
                    2 => 'Восстановление пароля администратора - Безопасное восстановление доступа'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.admin_recovery_badge',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Kurtarma',
                    2 => 'Восстановление администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.main_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi mi Unuttunuz?',
                    2 => 'Забыли пароль?'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.subtitle',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetimsel erişim için güvenli şifre kurtarma',
                    2 => 'Безопасное восстановление пароля для административного доступа'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.recovery_email_sent',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurtarma E-postası Gönderildi',
                    2 => 'Письмо для восстановления отправлено'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.recovery_process',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifre Kurtarma Süreci',
                    2 => 'Процесс восстановления пароля'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.recovery_instructions',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Aşağıya yönetici e-posta adresinizi girin. Şifrenizi sıfırlamak için kurtarma token ile güvenli talimatlar göndereceğiz.',
                    2 => 'Введите ниже email-адрес администратора. Мы отправим безопасные инструкции с токеном восстановления для сброса пароля.'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.admin_email',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici E-posta Adresi',
                    2 => 'Email администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.admin_email_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici e-posta adresinizi girin',
                    2 => 'Введите email администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.email_help',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici hesabınızla ilişkili e-posta adresini girin',
                    2 => 'Введите email-адрес, связанный с вашей учетной записью администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.security_notice_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenlik Bildirimi',
                    2 => 'Уведомление о безопасности'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.token_expires_15min',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurtarma token 15 dakika içinde süresi dolacak',
                    2 => 'Срок действия токена восстановления истекает через 15 минут'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.only_admin_emails',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Sadece yönetici e-postaları kurtarma talebinde bulunabilir',
                    2 => 'Только администраторские email-адреса могут запрашивать восстановление'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.all_attempts_logged',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Tüm kurtarma girişimleri günlüğe kaydedilir',
                    2 => 'Все попытки восстановления регистрируются'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.send_recovery_instructions',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurtarma Talimatlarını Gönder',
                    2 => 'Отправить инструкции по восстановлению'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.back_to_admin_login',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Girişine Geri Dön',
                    2 => 'Вернуться к входу администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.recovery_process_steps',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurtarma Süreci',
                    2 => 'Процесс восстановления'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.step_1',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici e-posta adresinizi girin',
                    2 => 'Введите email администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.step_2',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurtarma talimatları için e-postanızı kontrol edin',
                    2 => 'Проверьте email для получения инструкций по восстановлению'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.step_3',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi sıfırlamak için token kullanın',
                    2 => 'Используйте токен для сброса пароля'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.step_4',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yeni şifre ile yönetici hesabınıza erişin',
                    2 => 'Получите доступ к учетной записи администратора с новым паролем'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.enterprise_security',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurumsal yönetici güvenliği',
                    2 => 'Корпоративная безопасность администратора'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.encrypted',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrelenmiş',
                    2 => 'Зашифровано'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.time_limited',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Zaman Sınırlı',
                    2 => 'Ограничено по времени'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.audit_log',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Denetim Günlüğü',
                    2 => 'Журнал аудита'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.need_help',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Hemen yardıma ihtiyacınız var mı?',
                    2 => 'Нужна немедленная помощь?'
                ]
            ],
            [
                'key' => 'auth.admin.forgot.contact_admin_support',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Desteğiyle İletişime Geç',
                    2 => 'Связаться с поддержкой администратора'
                ]
            ],

            // Admin Reset Password
            [
                'key' => 'auth.admin.reset.page_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Şifre Sıfırlama - Güvenli Kurtarma',
                    2 => 'Сброс пароля администратора - Безопасное восстановление'
                ]
            ],
            [
                'key' => 'auth.admin.reset.admin_recovery_badge',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Kurtarma',
                    2 => 'Восстановление администратора'
                ]
            ],
            [
                'key' => 'auth.admin.reset.main_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Şifresini Sıfırla',
                    2 => 'Сбросить пароль администратора'
                ]
            ],
            [
                'key' => 'auth.admin.reset.subtitle',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetimsel erişim için güvenli şifre kurtarma',
                    2 => 'Безопасное восстановление пароля для административного доступа'
                ]
            ],
            [
                'key' => 'auth.admin.reset.success',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Başarı',
                    2 => 'Успех'
                ]
            ],
            [
                'key' => 'auth.admin.reset.info',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Bilgi',
                    2 => 'Информация'
                ]
            ],
            [
                'key' => 'auth.admin.reset.security_notice_title',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenlik Bildirimi',
                    2 => 'Уведомление о безопасности'
                ]
            ],
            [
                'key' => 'auth.admin.reset.security_instructions',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kayıtlı yönetici e-posta adresinize gönderilen token ile e-posta ve yeni şifrenizi kullanarak yönetici kimlik bilgilerinizi sıfırlayın.',
                    2 => 'Используйте токен, отправленный на ваш зарегистрированный email администратора, вместе с email и новым паролем для сброса учетных данных администратора.'
                ]
            ],
            [
                'key' => 'auth.admin.reset.admin_email',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici E-posta Adresi',
                    2 => 'Email администратора'
                ]
            ],
            [
                'key' => 'auth.admin.reset.admin_email_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'admin@bluetrade.com',
                    2 => 'admin@bluetrade.com'
                ]
            ],
            [
                'key' => 'auth.admin.reset.security_token',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenlik Token',
                    2 => 'Токен безопасности'
                ]
            ],
            [
                'key' => 'auth.admin.reset.token_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => '6 haneli token girin',
                    2 => 'Введите 6-значный токен'
                ]
            ],
            [
                'key' => 'auth.admin.reset.token_help',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => '6 haneli güvenlik token için yönetici e-postanızı kontrol edin',
                    2 => 'Проверьте email администратора для получения 6-значного токена безопасности'
                ]
            ],
            [
                'key' => 'auth.admin.reset.new_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yeni Şifre',
                    2 => 'Новый пароль'
                ]
            ],
            [
                'key' => 'auth.admin.reset.strong_password_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güçlü bir şifre oluşturun',
                    2 => 'Создайте надежный пароль'
                ]
            ],
            [
                'key' => 'auth.admin.reset.confirm_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yeni Şifreyi Onayla',
                    2 => 'Подтвердите новый пароль'
                ]
            ],
            [
                'key' => 'auth.admin.reset.confirm_password_placeholder',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifrenizi onaylayın',
                    2 => 'Подтвердите пароль'
                ]
            ],
            [
                'key' => 'auth.admin.reset.password_requirements',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Şifre Gereksinimleri',
                    2 => 'Требования к паролю'
                ]
            ],
            [
                'key' => 'auth.admin.reset.min_8_chars',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Minimum 8 karakter uzunluğunda',
                    2 => 'Минимум 8 символов'
                ]
            ],
            [
                'key' => 'auth.admin.reset.include_mixed_case',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Büyük ve küçük harfleri dahil edin',
                    2 => 'Включите заглавные и строчные буквы'
                ]
            ],
            [
                'key' => 'auth.admin.reset.include_number',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'En az bir sayı dahil edin',
                    2 => 'Включите хотя бы одну цифру'
                ]
            ],
            [
                'key' => 'auth.admin.reset.include_special_char',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'En az bir özel karakter dahil edin',
                    2 => 'Включите хотя бы один специальный символ'
                ]
            ],
            [
                'key' => 'auth.admin.reset.reset_admin_password',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Şifresini Sıfırla',
                    2 => 'Сбросить пароль администратора'
                ]
            ],
            [
                'key' => 'auth.admin.reset.back_to_admin_login',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Yönetici Girişine Geri Dön',
                    2 => 'Вернуться к входу администратора'
                ]
            ],
            [
                'key' => 'auth.admin.reset.enterprise_security',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Kurumsal düzeyde yönetici güvenliği',
                    2 => 'Безопасность администратора корпоративного уровня'
                ]
            ],
            [
                'key' => 'auth.admin.reset.admin_only',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Sadece Yönetici',
                    2 => 'Только администратор'
                ]
            ],
            [
                'key' => 'auth.admin.reset.token_verified',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Token Doğrulandı',
                    2 => 'Токен подтвержден'
                ]
            ],
            [
                'key' => 'auth.admin.reset.secure_reset',
                'group' => 'auth',
                'is_active' => true,
                'is_reviewed' => true,
                'usage_count' => 0,
                'translations' => [
                    1 => 'Güvenli Sıfırlama',
                    2 => 'Безопасный сброс'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or update phrase
            $phrase = Phrase::updateOrCreate(
                ['key' => $phraseData['key']],
                [
                    'group' => $phraseData['group'],
                    'is_active' => $phraseData['is_active'],
                    'usage_count' => $phraseData['usage_count'],
                ]
            );

            // Create or update translations
            foreach ($phraseData['translations'] as $languageId => $value) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId,
                    ],
                    [
                        'translation' => $value,
                        'is_reviewed' => true,
                    ]
                );
            }
        }

        $this->command->info('Forgot-password phrases seeded successfully! Added 57 new phrases.');
    }
}