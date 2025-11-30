<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class EmailServicesBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Email Index page phrases
            'admin.email.services' => [
                'tr' => 'E-posta Servisleri',
                'ru' => 'Почтовые сервисы'
            ],
            'admin.email.send_bulk_email_to_users' => [
                'tr' => 'Kullanıcılara toplu e-posta gönderin ve yönetin',
                'ru' => 'Отправляйте и управляйте массовыми рассылками пользователям'
            ],
            'admin.email.get_help' => [
                'tr' => 'Yardım Al',
                'ru' => 'Получить помощь'
            ],
            'admin.email.email_creation_form' => [
                'tr' => 'E-posta Oluşturma Formu',
                'ru' => 'Форма создания электронной почты'
            ],
            'admin.email.recipient_category' => [
                'tr' => 'Alıcı Kategorisi',
                'ru' => 'Категория получателей'
            ],
            'admin.email.select_user_group_for_email' => [
                'tr' => 'E-posta gönderilecek kullanıcı grubunu seçin',
                'ru' => 'Выберите группу пользователей для отправки электронной почты'
            ],
            'admin.email.all_users' => [
                'tr' => '🌐 Tüm Kullanıcılar',
                'ru' => '🌐 Все пользователи'
            ],
            'admin.email.users_without_active_plans' => [
                'tr' => '📊 Aktif yatırım planı olmayan kullanıcılar',
                'ru' => '📊 Пользователи без активных инвестиционных планов'
            ],
            'admin.email.users_without_any_investment' => [
                'tr' => '💰 Herhangi bir yatırımı olmayan kullanıcılar',
                'ru' => '💰 Пользователи без каких-либо инвестиций'
            ],
            'admin.email.select_users_manually' => [
                'tr' => '👤 Kullanıcıları Manuel Seç',
                'ru' => '👤 Выбрать пользователей вручную'
            ],
            'admin.email.user_selection' => [
                'tr' => 'Kullanıcı Seçimi',
                'ru' => 'Выбор пользователей'
            ],
            'admin.email.select_users_to_send' => [
                'tr' => 'Gönderilecek kullanıcıları seçin',
                'ru' => 'Выберите пользователей для отправки'
            ],
            'admin.email.users_selected' => [
                'tr' => 'kişi seçildi',
                'ru' => 'пользователей выбрано'
            ],
            'admin.email.select_users_placeholder' => [
                'tr' => 'Kullanıcıları seçin...',
                'ru' => 'Выберите пользователей...'
            ],
            'admin.email.search_user_placeholder' => [
                'tr' => 'Kullanıcı ara...',
                'ru' => 'Поиск пользователя...'
            ],
            'admin.email.greeting_and_title' => [
                'tr' => 'Selamlama ve Başlık',
                'ru' => 'Приветствие и заголовок'
            ],
            'admin.email.email_beginning_greeting' => [
                'tr' => 'E-postanın başlangıç selamlaması',
                'ru' => 'Приветствие в начале электронного письма'
            ],
            'admin.email.greeting_placeholder' => [
                'tr' => 'Selamlama (örn: Merhaba)',
                'ru' => 'Приветствие (например: Здравствуйте)'
            ],
            'admin.email.title_placeholder' => [
                'tr' => 'Başlık (örn: Değerli Yatırımcı)',
                'ru' => 'Заголовок (например: Уважаемый инвестор)'
            ],
            'admin.email.email_subject' => [
                'tr' => 'E-posta Konusu',
                'ru' => 'Тема письма'
            ],
            'admin.email.subject_line_recipients_will_see' => [
                'tr' => 'Alıcıların göreceği konu başlığı',
                'ru' => 'Строка темы, которую увидят получатели'
            ],
            'admin.email.email_subject_placeholder' => [
                'tr' => 'E-posta konusu...',
                'ru' => 'Тема электронного письма...'
            ],
            'admin.email.email_message' => [
                'tr' => 'E-posta Mesajı',
                'ru' => 'Сообщение электронной почты'
            ],
            'admin.email.email_content_to_send' => [
                'tr' => 'Gönderilecek e-posta içeriği',
                'ru' => 'Содержимое электронного письма для отправки'
            ],
            'admin.email.email_message_placeholder' => [
                'tr' => 'E-posta mesajınızı buraya yazın...',
                'ru' => 'Напишите ваше сообщение здесь...'
            ],
            'admin.email.send_email' => [
                'tr' => 'E-postayı Gönder',
                'ru' => 'Отправить письмо'
            ],
            'admin.email.sending' => [
                'tr' => 'Gönderiliyor...',
                'ru' => 'Отправка...'
            ],
            'admin.email.no_users_found' => [
                'tr' => 'Kullanıcı bulunamadı',
                'ru' => 'Пользователи не найдены'
            ],
            'admin.email.no_users_found_at_all' => [
                'tr' => 'Hiç kullanıcı bulunamadı',
                'ru' => 'Пользователи вообще не найдены'
            ],
            'admin.email.error_loading_users' => [
                'tr' => 'Kullanıcılar yüklenirken hata oluştu',
                'ru' => 'Ошибка при загрузке пользователей'
            ],
            'admin.email.try_again' => [
                'tr' => 'Tekrar dene',
                'ru' => 'Попробовать снова'
            ],
            'admin.email.loading_users' => [
                'tr' => 'Kullanıcılar yükleniyor...',
                'ru' => 'Загрузка пользователей...'
            ],
            'admin.email.please_select_at_least_one_user' => [
                'tr' => 'Lütfen en az bir kullanıcı seçin.',
                'ru' => 'Пожалуйста, выберите хотя бы одного пользователя.'
            ],
            'admin.email.rich_text_editor_ready' => [
                'tr' => 'Zengin metin editörü hazır! 📝',
                'ru' => 'Редактор богатого текста готов! 📝'
            ],
            'admin.email.editor_loading_problem' => [
                'tr' => 'Editör yüklenirken sorun oluştu. Sayfa yenilenirse düzelir. 🔄',
                'ru' => 'Проблема при загрузке редактора. Обновление страницы поможет. 🔄'
            ],
            'admin.email.rich_text_editor_not_loaded' => [
                'tr' => 'Zengin metin editörü yüklenemedi. İnternet bağlantınızı kontrol edin. 📶',
                'ru' => 'Редактор богатого текста не загрузился. Проверьте подключение к интернету. 📶'
            ],
            'admin.email.ckeditor_loaded_successfully' => [
                'tr' => '✅ CKEditor başarıyla yüklendi ve yapılandırıldı',
                'ru' => '✅ CKEditor успешно загружен и настроен'
            ],
            'admin.email.ckeditor_error' => [
                'tr' => '❌ CKEditor Hatası:',
                'ru' => '❌ Ошибка CKEditor:'
            ],
            'admin.email.ckeditor_library_not_loaded' => [
                'tr' => '❌ CKEditor kütüphanesi yüklenemedi',
                'ru' => '❌ Библиотека CKEditor не загружена'
            ],
            'admin.email.write_email_content_here' => [
                'tr' => 'E-posta içeriğinizi buraya yazın...',
                'ru' => 'Напишите содержимое электронного письма здесь...'
            ],

            // Email Settings phrases
            'admin.email_settings.email_configuration' => [
                'tr' => 'E-posta Yapılandırması',
                'ru' => 'Настройка электронной почты'
            ],
            'admin.email_settings.mail_server_selection' => [
                'tr' => 'Mail Sunucusu Seçimi',
                'ru' => 'Выбор почтового сервера'
            ],
            'admin.email_settings.sendmail' => [
                'tr' => 'Sendmail',
                'ru' => 'Sendmail'
            ],
            'admin.email_settings.smtp' => [
                'tr' => 'SMTP',
                'ru' => 'SMTP'
            ],
            'admin.email_settings.sendmail_uses_system_default' => [
                'tr' => 'Sendmail sistem varsayılan mail sunucusunu kullanır, SMTP özel ayarlar gerektirir.',
                'ru' => 'Sendmail использует системный почтовый сервер по умолчанию, SMTP требует специальных настроек.'
            ],
            'admin.email_settings.sender_email_address' => [
                'tr' => 'Gönderen E-posta Adresi',
                'ru' => 'Адрес электронной почты отправителя'
            ],
            'admin.email_settings.sender_name' => [
                'tr' => 'Gönderen Adı',
                'ru' => 'Имя отправителя'
            ],
            'admin.email_settings.smtp_server_settings' => [
                'tr' => 'SMTP Sunucu Ayarları',
                'ru' => 'Настройки SMTP сервера'
            ],
            'admin.email_settings.enter_required_info_for_smtp' => [
                'tr' => 'Gmail, Outlook, Yahoo gibi SMTP sunucuları için gerekli bilgileri girin',
                'ru' => 'Введите необходимую информацию для SMTP серверов, таких как Gmail, Outlook, Yahoo'
            ],
            'admin.email_settings.smtp_host' => [
                'tr' => 'SMTP Host',
                'ru' => 'SMTP хост'
            ],
            'admin.email_settings.smtp_port' => [
                'tr' => 'SMTP Port',
                'ru' => 'SMTP порт'
            ],
            'admin.email_settings.encryption_type' => [
                'tr' => 'Şifreleme Türü',
                'ru' => 'Тип шифрования'
            ],
            'admin.email_settings.tls' => [
                'tr' => 'TLS',
                'ru' => 'TLS'
            ],
            'admin.email_settings.ssl' => [
                'tr' => 'SSL',
                'ru' => 'SSL'
            ],
            'admin.email_settings.none' => [
                'tr' => 'Yok',
                'ru' => 'Нет'
            ],
            'admin.email_settings.smtp_username' => [
                'tr' => 'SMTP Kullanıcı Adı',
                'ru' => 'Имя пользователя SMTP'
            ],
            'admin.email_settings.smtp_password' => [
                'tr' => 'SMTP Şifresi',
                'ru' => 'Пароль SMTP'
            ],
            'admin.email_settings.enter_app_password_not_regular' => [
                'tr' => 'Gmail için uygulama şifresi, normal şifre değil',
                'ru' => 'Для Gmail используйте пароль приложения, а не обычный пароль'
            ],
            'admin.email_settings.google_login_credentials' => [
                'tr' => 'Google Giriş Kimlik Bilgileri',
                'ru' => 'Учетные данные для входа в Google'
            ],
            'admin.email_settings.google_client_id' => [
                'tr' => 'Google Client ID',
                'ru' => 'Google Client ID'
            ],
            'admin.email_settings.get_from_console_cloud_google' => [
                'tr' => 'console.cloud.google.com adresinden alın',
                'ru' => 'Получите с console.cloud.google.com'
            ],
            'admin.email_settings.google_client_secret' => [
                'tr' => 'Google Client Secret',
                'ru' => 'Google Client Secret'
            ],
            'admin.email_settings.oauth_redirect_url' => [
                'tr' => 'OAuth Yönlendirme URL\'si',
                'ru' => 'URL перенаправления OAuth'
            ],
            'admin.email_settings.add_url_to_oauth_redirect_uris' => [
                'tr' => 'Bu URL\'yi Google Cloud Console\'da OAuth Redirect URI\'ları bölümüne eklemeyi unutmayın. Domain adını kendi sitenizle değiştirin.',
                'ru' => 'Не забудьте добавить этот URL в раздел OAuth Redirect URIs в Google Cloud Console. Замените доменное имя на ваш собственный сайт.'
            ],
            'admin.email_settings.google_captcha_credentials' => [
                'tr' => 'Google Captcha Kimlik Bilgileri',
                'ru' => 'Учетные данные Google Captcha'
            ],
            'admin.email_settings.recaptcha_secret_key' => [
                'tr' => 'ReCaptcha Secret Key',
                'ru' => 'Секретный ключ ReCaptcha'
            ],
            'admin.email_settings.get_from_google_recaptcha_admin' => [
                'tr' => 'Google ReCaptcha admin panelinden alın',
                'ru' => 'Получите из админ-панели Google ReCaptcha'
            ],
            'admin.email_settings.recaptcha_site_key' => [
                'tr' => 'ReCaptcha Site Key',
                'ru' => 'Ключ сайта ReCaptcha'
            ],
            'admin.email_settings.recaptcha_setup_info' => [
                'tr' => 'ReCaptcha Kurulum Bilgisi',
                'ru' => 'Информация о настройке ReCaptcha'
            ],
            'admin.email_settings.go_to_google_recaptcha_admin' => [
                'tr' => 'Google ReCaptcha admin paneline',
                'ru' => 'В админ-панель Google ReCaptcha'
            ],
            'admin.email_settings.create_new_site_registration' => [
                'tr' => 'giderek yeni bir site kaydı oluşturun ve aldığınız anahtarları buraya girin.',
                'ru' => 'перейдите, чтобы создать новую регистрацию сайта и введите полученные ключи здесь.'
            ],
            'admin.email_settings.save_settings' => [
                'tr' => 'Ayarları Kaydet',
                'ru' => 'Сохранить настройки'
            ],

            // Common email terms
            'admin.email.hello_default' => [
                'tr' => 'Merhaba',
                'ru' => 'Здравствуйте'
            ],
            'admin.email.investor_default' => [
                'tr' => 'Yatırımcı',
                'ru' => 'Инвестор'
            ],
            'admin.email.monexa_finance_default' => [
                'tr' => 'Monexa Finans',
                'ru' => 'Monexa Финансы'
            ],

            // CKEditor Email Templates & Styles
            'admin.email.ckeditor.email_header' => [
                'tr' => '📧 E-posta Başlığı',
                'ru' => '📧 Заголовок письма'
            ],
            'admin.email.ckeditor.highlight_box' => [
                'tr' => '✨ Vurgu Kutusu',
                'ru' => '✨ Выделительная коробка'
            ],
            'admin.email.ckeditor.important_warning' => [
                'tr' => '⚠️ Önemli Uyarı',
                'ru' => '⚠️ Важное предупреждение'
            ],
            'admin.email.ckeditor.success_message' => [
                'tr' => '✅ Başarı Mesajı',
                'ru' => '✅ Сообщение об успехе'
            ],
            'admin.email.ckeditor.information' => [
                'tr' => 'ℹ️ Bilgilendirme',
                'ru' => 'ℹ️ Информация'
            ],
            'admin.email.ckeditor.button_style' => [
                'tr' => '🔗 Düğme Stili',
                'ru' => '🔗 Стиль кнопки'
            ],
            'admin.email.ckeditor.footnote' => [
                'tr' => '📝 Alt Yazı',
                'ru' => '📝 Сноска'
            ],

            // Form validation and placeholders
            'admin.email.noreply_example' => [
                'tr' => 'noreply@example.com',
                'ru' => 'noreply@example.com'
            ],
            'admin.email.smtp_gmail_example' => [
                'tr' => 'smtp.gmail.com',
                'ru' => 'smtp.gmail.com'
            ],
            'admin.email.port_587_example' => [
                'tr' => '587',
                'ru' => '587'
            ],
            'admin.email.your_email_gmail_example' => [
                'tr' => 'your-email@gmail.com',
                'ru' => 'ваша-почта@gmail.com'
            ],
            'admin.email.enter_app_password' => [
                'tr' => 'Uygulama şifrenizi girin',
                'ru' => 'Введите пароль приложения'
            ],
            'admin.email.google_client_id_example' => [
                'tr' => '123456789-abc.apps.googleusercontent.com',
                'ru' => '123456789-abc.apps.googleusercontent.com'
            ],
            'admin.email.google_secret_example' => [
                'tr' => 'GOCSPX-abcdef...',
                'ru' => 'GOCSPX-abcdef...'
            ],
            'admin.email.oauth_redirect_example' => [
                'tr' => 'https://yourdomain.com/auth/google/callback',
                'ru' => 'https://yourdomain.com/auth/google/callback'
            ],
            'admin.email.recaptcha_secret_example' => [
                'tr' => '6Ld...',
                'ru' => '6Ld...'
            ],
            'admin.email.recaptcha_site_example' => [
                'tr' => '6Le...',
                'ru' => '6Le...'
            ],

            // JavaScript Notifications and Messages
            'admin.email.editor_setup_guide' => [
                'tr' => 'E-posta içeriğinizi buraya yazın...',
                'ru' => 'Напишите содержимое электронной почты здесь...'
            ],
            'admin.email.user_selected_count' => [
                'tr' => '{count} kullanıcı seçildi',
                'ru' => '{count} пользователей выбрано'
            ],
            'admin.email.one_user_selected' => [
                'tr' => '1 kullanıcı seçildi',
                'ru' => '1 пользователь выбран'
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create or update translations for Turkish (language_id = 1)
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => 1, // Turkish
                ],
                [
                    'translation' => $translations['tr']
                ]
            );

            // Create or update translations for Russian (language_id = 2)
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => 2, // Russian
                ],
                [
                    'translation' => $translations['ru']
                ]
            );
        }

        $this->command->info('Email Services blade phrases seeded successfully! Total: ' . count($phrases) . ' phrases');
    }
}