<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class AdminAppSettingsPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrasesAdded = 0;
        
        DB::transaction(function () use (&$phrasesAdded) {
            $phrases = [
                // Show.blade.php phrases
                'admin.settings.app.show.title' => [
                    'tr' => 'Uygulama Ayarları',
                    'ru' => 'Настройки приложения',
                ],
                'admin.settings.app.show.header' => [
                    'tr' => 'Uygulama Ayarları',
                    'ru' => 'Настройки приложения',
                ],
                'admin.settings.app.show.description' => [
                    'tr' => 'Sistem genelindeki ayarları ve konfigürasyonları yönetin',
                    'ru' => 'Управление системными настройками и конфигурациями',
                ],
                'admin.settings.app.show.site_information' => [
                    'tr' => 'Site Bilgileri',
                    'ru' => 'Информация о сайте',
                ],
                'admin.settings.app.show.preferences' => [
                    'tr' => 'Tercihler',
                    'ru' => 'Предпочтения',
                ],
                'admin.settings.app.show.email_google' => [
                    'tr' => 'E-posta & Google',
                    'ru' => 'Email & Google',
                ],
                'admin.settings.app.show.errors_occurred' => [
                    'tr' => 'Hatalar oluştu',
                    'ru' => 'Произошли ошибки',
                ],
                'admin.settings.app.show.currency_changed_to' => [
                    'tr' => 'Para birimi değiştirildi',
                    'ru' => 'Валюта изменена на',
                ],
                'admin.settings.app.show.success' => [
                    'tr' => 'Başarılı',
                    'ru' => 'Успешно',
                ],
                'admin.settings.app.show.error' => [
                    'tr' => 'Hata',
                    'ru' => 'Ошибка',
                ],
                'admin.settings.app.show.error_occurred' => [
                    'tr' => 'Bir hata oluştu',
                    'ru' => 'Произошла ошибка',
                ],

                // Webinfo.blade.php phrases
                'admin.settings.app.webinfo.basic_info' => [
                    'tr' => 'Temel Bilgiler',
                    'ru' => 'Основная информация',
                ],
                'admin.settings.app.webinfo.website_name' => [
                    'tr' => 'Web Sitesi Adı',
                    'ru' => 'Название сайта',
                ],
                'admin.settings.app.webinfo.website_title' => [
                    'tr' => 'Web Sitesi Başlığı',
                    'ru' => 'Заголовок сайта',
                ],
                'admin.settings.app.webinfo.website_keywords' => [
                    'tr' => 'Web Sitesi Anahtar Kelimeleri',
                    'ru' => 'Ключевые слова сайта',
                ],
                'admin.settings.app.webinfo.website_url' => [
                    'tr' => 'Web Sitesi URL\'si',
                    'ru' => 'URL сайта',
                ],
                'admin.settings.app.webinfo.website_description' => [
                    'tr' => 'Web Sitesi Açıklaması',
                    'ru' => 'Описание сайта',
                ],
                'admin.settings.app.webinfo.description_placeholder' => [
                    'tr' => 'Web sitenizin kısa açıklamasını girin...',
                    'ru' => 'Введите краткое описание вашего сайта...',
                ],
                'admin.settings.app.webinfo.contact_announcements' => [
                    'tr' => 'İletişim ve Duyurular',
                    'ru' => 'Контакты и объявления',
                ],
                'admin.settings.app.webinfo.site_announcement' => [
                    'tr' => 'Site Duyurusu',
                    'ru' => 'Объявление сайта',
                ],
                'admin.settings.app.webinfo.announcement_placeholder' => [
                    'tr' => 'Önemli duyuru veya güncelleme mesajınızı buraya yazın...',
                    'ru' => 'Напишите здесь важное объявление или сообщение об обновлении...',
                ],
                'admin.settings.app.webinfo.welcome_message' => [
                    'tr' => 'Hoşgeldin Mesajı',
                    'ru' => 'Приветственное сообщение',
                ],
                'admin.settings.app.webinfo.welcome_message_placeholder' => [
                    'tr' => 'Yeni kullanıcılar için hoşgeldin mesajını yazın...',
                    'ru' => 'Напишите приветственное сообщение для новых пользователей...',
                ],
                'admin.settings.app.webinfo.welcome_message_help' => [
                    'tr' => 'Bu mesaj yeni kayıt olan kullanıcılara gösterilir',
                    'ru' => 'Это сообщение показывается новым зарегистрированным пользователям',
                ],
                'admin.settings.app.webinfo.whatsapp_number' => [
                    'tr' => 'WhatsApp Numarası',
                    'ru' => 'Номер WhatsApp',
                ],
                'admin.settings.app.webinfo.tido_livechat_id' => [
                    'tr' => 'Tido Canlı Sohbet ID',
                    'ru' => 'Tido Live Chat ID',
                ],
                'admin.settings.app.webinfo.establishment_year' => [
                    'tr' => 'Kuruluş Yılı',
                    'ru' => 'Год основания',
                ],
                'admin.settings.app.webinfo.trading_system_settings' => [
                    'tr' => 'Trading Sistem Ayarları',
                    'ru' => 'Настройки торговой системы',
                ],
                'admin.settings.app.webinfo.trading_winrate' => [
                    'tr' => 'Trading Kazanç Oranı (%)',
                    'ru' => 'Процент выигрыша в торговле (%)',
                ],
                'admin.settings.app.webinfo.trading_winrate_help' => [
                    'tr' => '1-100 arasında değer girin (örnek: 75)',
                    'ru' => 'Введите значение от 1 до 100 (например: 75)',
                ],
                'admin.settings.app.webinfo.timezone' => [
                    'tr' => 'Zaman Dilimi',
                    'ru' => 'Часовой пояс',
                ],
                'admin.settings.app.webinfo.install_type' => [
                    'tr' => 'Kurulum Türü',
                    'ru' => 'Тип установки',
                ],
                'admin.settings.app.webinfo.main_domain' => [
                    'tr' => 'Ana Domain',
                    'ru' => 'Основной домен',
                ],
                'admin.settings.app.webinfo.sub_domain' => [
                    'tr' => 'Alt Domain',
                    'ru' => 'Поддомен',
                ],
                'admin.settings.app.webinfo.sub_folder' => [
                    'tr' => 'Alt Klasör',
                    'ru' => 'Подпапка',
                ],
                'admin.settings.app.webinfo.visual_settings' => [
                    'tr' => 'Görsel Ayarlar',
                    'ru' => 'Визуальные настройки',
                ],
                'admin.settings.app.webinfo.website_logo' => [
                    'tr' => 'Web Sitesi Logosu',
                    'ru' => 'Логотип сайта',
                ],
                'admin.settings.app.webinfo.logo_size_recommendation' => [
                    'tr' => 'Önerilen boyut: 200x80 piksel (PNG/JPG)',
                    'ru' => 'Рекомендуемый размер: 200x80 пикселей (PNG/JPG)',
                ],
                'admin.settings.app.webinfo.logo_not_uploaded' => [
                    'tr' => 'Logo yüklenmedi',
                    'ru' => 'Логотип не загружен',
                ],
                'admin.settings.app.webinfo.website_favicon' => [
                    'tr' => 'Web Sitesi Faviconu',
                    'ru' => 'Фавикон сайта',
                ],
                'admin.settings.app.webinfo.favicon_size_recommendation' => [
                    'tr' => 'Önerilen boyut: 32x32 piksel (ICO/PNG)',
                    'ru' => 'Рекомендуемый размер: 32x32 пикселя (ICO/PNG)',
                ],
                'admin.settings.app.webinfo.favicon_not_uploaded' => [
                    'tr' => 'Favicon yüklenmedi',
                    'ru' => 'Фавикон не загружен',
                ],
                'admin.settings.app.webinfo.save' => [
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить',
                ],

                // Webpreference.blade.php phrases
                'admin.settings.app.webpreference.basic_settings.title' => [
                    'tr' => 'Temel Ayarlar',
                    'ru' => 'Основные настройки',
                ],
                'admin.settings.app.webpreference.basic_settings.contact_email' => [
                    'tr' => 'İletişim E-postası',
                    'ru' => 'Контактный email',
                ],
                'admin.settings.app.webpreference.basic_settings.contact_email_help' => [
                    'tr' => 'Kullanıcılardan gelen mesajların gönderileceği e-posta adresi',
                    'ru' => 'Email адрес для получения сообщений от пользователей',
                ],
                'admin.settings.app.webpreference.basic_settings.currency' => [
                    'tr' => 'Para Birimi',
                    'ru' => 'Валюта',
                ],
                'admin.settings.app.webpreference.basic_settings.currency_help' => [
                    'tr' => 'Sistemde kullanılacak ana para birimi',
                    'ru' => 'Основная валюта, используемая в системе',
                ],
                'admin.settings.app.webpreference.basic_settings.custom_homepage' => [
                    'tr' => 'Özel Anasayfa URL\'si',
                    'ru' => 'Пользовательский URL главной страницы',
                ],
                'admin.settings.app.webpreference.basic_settings.custom_homepage_help' => [
                    'tr' => 'Farklı bir anasayfa kullanmak istiyorsanız URL\'yi girin',
                    'ru' => 'Введите URL, если хотите использовать другую главную страницу',
                ],
                'admin.settings.app.webpreference.basic_settings.optional' => [
                    'tr' => 'Opsiyonel',
                    'ru' => 'Необязательно',
                ],
                'admin.settings.app.webpreference.system_features.title' => [
                    'tr' => 'Sistem Özellikleri',
                    'ru' => 'Системные функции',
                ],
                'admin.settings.app.webpreference.system_features.announcements' => [
                    'tr' => 'Duyurular',
                    'ru' => 'Объявления',
                ],
                'admin.settings.app.webpreference.system_features.announcements_help' => [
                    'tr' => 'Site üzerinde duyuru gösterme özelliğini açar/kapatır',
                    'ru' => 'Включает/отключает показ объявлений на сайте',
                ],
                'admin.settings.app.webpreference.system_features.weekend_trade' => [
                    'tr' => 'Hafta Sonu Ticareti',
                    'ru' => 'Торговля в выходные',
                ],
                'admin.settings.app.webpreference.system_features.weekend_trade_help' => [
                    'tr' => 'Hafta sonları trading işlemlerine izin verir',
                    'ru' => 'Позволяет торговые операции в выходные дни',
                ],
                'admin.settings.app.webpreference.system_features.withdrawal' => [
                    'tr' => 'Para Çekme',
                    'ru' => 'Вывод средств',
                ],
                'admin.settings.app.webpreference.system_features.withdrawal_help' => [
                    'tr' => 'Devre dışı bırakılırsa, kullanıcılar para çekme talebi gönderemeyecek',
                    'ru' => 'Если отключено, пользователи не смогут отправлять запросы на вывод средств',
                ],
                'admin.settings.app.webpreference.system_features.google_recaptcha' => [
                    'tr' => 'Google ReCaptcha',
                    'ru' => 'Google ReCaptcha',
                ],
                'admin.settings.app.webpreference.system_features.recaptcha_help' => [
                    'tr' => 'Açık ise, kullanıcılar kayıt sırasında google recaptcha testini geçmek zorunda kalacak.',
                    'ru' => 'Если включено, пользователи должны пройти тест Google reCAPTCHA при регистрации.',
                ],
                'admin.settings.app.webpreference.system_features.how_to_setup' => [
                    'tr' => 'Nasıl yapılır',
                    'ru' => 'Как настроить',
                ],
                'admin.settings.app.webpreference.system_features.translation' => [
                    'tr' => 'Çeviri',
                    'ru' => 'Перевод',
                ],
                'admin.settings.app.webpreference.system_features.translation_help' => [
                    'tr' => 'Açık ise, kullanıcılar google çeviri aracılığıyla tercih ettikleri dili seçme seçeneğine sahip olacak',
                    'ru' => 'Если включено, пользователи смогут выбрать предпочитаемый язык через Google Translate',
                ],
                'admin.settings.app.webpreference.system_features.trade_mode' => [
                    'tr' => 'Ticaret Modu',
                    'ru' => 'Торговый режим',
                ],
                'admin.settings.app.webpreference.system_features.trade_mode_help' => [
                    'tr' => 'Kapalıysa, kullanıcılar ROI\'yi hiç almayacak',
                    'ru' => 'Если отключено, пользователи вообще не будут получать ROI',
                ],
                'admin.settings.app.webpreference.system_features.on' => [
                    'tr' => 'Açık',
                    'ru' => 'Включено',
                ],
                'admin.settings.app.webpreference.system_features.off' => [
                    'tr' => 'Kapalı',
                    'ru' => 'Отключено',
                ],
                'admin.settings.app.webpreference.system_features.enabled' => [
                    'tr' => 'Etkin',
                    'ru' => 'Активно',
                ],
                'admin.settings.app.webpreference.system_features.disabled' => [
                    'tr' => 'Devre Dışı',
                    'ru' => 'Неактивно',
                ],
                'admin.settings.app.webpreference.user_verification.title' => [
                    'tr' => 'Kullanıcı Doğrulama ve Güvenlik',
                    'ru' => 'Верификация пользователей и безопасность',
                ],
                'admin.settings.app.webpreference.user_verification.kyc' => [
                    'tr' => 'KYC (Doğrulama)',
                    'ru' => 'KYC (Верификация)',
                ],
                'admin.settings.app.webpreference.user_verification.kyc_help' => [
                    'tr' => 'Açık ise, kullanıcılar para çekme talebi göndermeden önce gerekli belgeleri göndermek zorunda kalacak',
                    'ru' => 'Если включено, пользователи должны отправить необходимые документы перед отправкой запроса на вывод средств',
                ],
                'admin.settings.app.webpreference.user_verification.kyc_registration' => [
                    'tr' => 'KYC Kayıt Sırasında',
                    'ru' => 'KYC при регистрации',
                ],
                'admin.settings.app.webpreference.user_verification.kyc_registration_help' => [
                    'tr' => 'Açık ise, kullanıcılar kayıt sırasında doğrulama sürecinden geçmek zorunda kalacak ve yönetici tarafından doğrulanana kadar sisteminizde hiçbir işlem yapmalarına izin verilmeyecek.',
                    'ru' => 'Если включено, пользователи должны пройти процесс верификации при регистрации и не смогут выполнять операции в системе до подтверждения администратором.',
                ],
                'admin.settings.app.webpreference.user_verification.kyc_registration_warning' => [
                    'tr' => 'Bir başvuru gönderdikten sonra, devam etmeden önce kullanıcıyı kendi tarafınızdan doğrulamak zorunda kalacaksınız.',
                    'ru' => 'После отправки заявки вы должны будете верифицировать пользователя самостоятельно, прежде чем он сможет продолжить.',
                ],
                'admin.settings.app.webpreference.user_verification.google_login' => [
                    'tr' => 'Google Girişi',
                    'ru' => 'Вход через Google',
                ],
                'admin.settings.app.webpreference.user_verification.google_login_help' => [
                    'tr' => 'Google Girişi, kullanıcıların google hesaplarıyla giriş yapmalarına/kayıt olmalarına izin verir',
                    'ru' => 'Вход через Google позволяет пользователям входить/регистрироваться с помощью учетных записей Google',
                ],
                'admin.settings.app.webpreference.user_verification.email_verification' => [
                    'tr' => 'E-posta Doğrulama',
                    'ru' => 'Подтверждение email',
                ],
                'admin.settings.app.webpreference.user_verification.email_verification_help' => [
                    'tr' => 'E-posta doğrulaması devre dışı bırakılırsa kullanıcılara e-posta adreslerini doğrulamaları sorulmayacak',
                    'ru' => 'Если подтверждение email отключено, пользователям не будет предложено подтверждать свои email адреса',
                ],
                'admin.settings.app.webpreference.user_verification.on' => [
                    'tr' => 'Açık',
                    'ru' => 'Включено',
                ],
                'admin.settings.app.webpreference.user_verification.off' => [
                    'tr' => 'Kapalı',
                    'ru' => 'Отключено',
                ],
                'admin.settings.app.webpreference.user_verification.enabled' => [
                    'tr' => 'Etkin',
                    'ru' => 'Активно',
                ],
                'admin.settings.app.webpreference.user_verification.disabled' => [
                    'tr' => 'Devre Dışı',
                    'ru' => 'Неактивно',
                ],
                'admin.settings.app.webpreference.investment_settings.title' => [
                    'tr' => 'Yatırım ve Plan Ayarları',
                    'ru' => 'Настройки инвестиций и планов',
                ],
                'admin.settings.app.webpreference.investment_settings.return_capital' => [
                    'tr' => 'Sermaye İadesi',
                    'ru' => 'Возврат капитала',
                ],
                'admin.settings.app.webpreference.investment_settings.return_capital_help' => [
                    'tr' => 'Sermaye iadesi Hayır ise, sistem yatırım planı süresi dolduktan sonra kullanıcıya sermayesini kredilendirmeyecek',
                    'ru' => 'Если возврат капитала "Нет", система не будет возвращать капитал пользователю после истечения срока инвестиционного плана',
                ],
                'admin.settings.app.webpreference.investment_settings.plan_cancellation' => [
                    'tr' => 'Plan İptali',
                    'ru' => 'Отмена плана',
                ],
                'admin.settings.app.webpreference.investment_settings.plan_cancellation_help' => [
                    'tr' => 'Kullanıcıların aktif yatırım planlarını iptal edebilmesini istiyorsanız açın. Planlarını iptal ettiklerinde sermayenin kullanıcı hesabına iade edileceğini unutmayın',
                    'ru' => 'Включите, если хотите, чтобы пользователи могли отменять активные инвестиционные планы. Помните, что при отмене планов капитал будет возвращен на счет пользователя',
                ],
                'admin.settings.app.webpreference.investment_settings.yes' => [
                    'tr' => 'Evet',
                    'ru' => 'Да',
                ],
                'admin.settings.app.webpreference.investment_settings.no' => [
                    'tr' => 'Hayır',
                    'ru' => 'Нет',
                ],
                'admin.settings.app.webpreference.investment_settings.on' => [
                    'tr' => 'Açık',
                    'ru' => 'Включено',
                ],
                'admin.settings.app.webpreference.investment_settings.off' => [
                    'tr' => 'Kapalı',
                    'ru' => 'Отключено',
                ],
                'admin.settings.app.webpreference.save' => [
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить',
                ],

                // Email.blade.php phrases
                'admin.settings.app.email.configuration' => [
                    'tr' => 'E-posta Konfigürasyonu',
                    'ru' => 'Конфигурация email',
                ],
                'admin.settings.app.email.server_selection' => [
                    'tr' => 'Mail Sunucusu Seçimi',
                    'ru' => 'Выбор почтового сервера',
                ],
                'admin.settings.app.email.sendmail_smtp_description' => [
                    'tr' => 'Sendmail basit kurulum, SMTP daha güvenli ve özelleştirilebilir',
                    'ru' => 'Sendmail - простая настройка, SMTP - более безопасный и настраиваемый',
                ],
                'admin.settings.app.email.sender_address' => [
                    'tr' => 'Gönderen E-posta Adresi',
                    'ru' => 'Адрес электронной почты отправителя',
                ],
                'admin.settings.app.email.sender_name' => [
                    'tr' => 'Gönderen Adı',
                    'ru' => 'Имя отправителя',
                ],
                'admin.settings.app.email.smtp_server_settings' => [
                    'tr' => 'SMTP Sunucu Ayarları',
                    'ru' => 'Настройки SMTP сервера',
                ],
                'admin.settings.app.email.smtp_providers_help' => [
                    'tr' => 'Gmail, Outlook, Yahoo gibi popüler e-posta sağlayıcılarının SMTP ayarlarını kullanabilirsiniz',
                    'ru' => 'Вы можете использовать настройки SMTP популярных поставщиков электронной почты, таких как Gmail, Outlook, Yahoo',
                ],
                'admin.settings.app.email.smtp_host' => [
                    'tr' => 'SMTP Sunucu Adresi',
                    'ru' => 'SMTP хост',
                ],
                'admin.settings.app.email.smtp_port' => [
                    'tr' => 'SMTP Port',
                    'ru' => 'SMTP порт',
                ],
                'admin.settings.app.email.encryption_type' => [
                    'tr' => 'Şifreleme Türü',
                    'ru' => 'Тип шифрования',
                ],
                'admin.settings.app.email.tls' => [
                    'tr' => 'TLS',
                    'ru' => 'TLS',
                ],
                'admin.settings.app.email.ssl' => [
                    'tr' => 'SSL',
                    'ru' => 'SSL',
                ],
                'admin.settings.app.email.none' => [
                    'tr' => 'Yok',
                    'ru' => 'Нет',
                ],
                'admin.settings.app.email.smtp_username' => [
                    'tr' => 'SMTP Kullanıcı Adı',
                    'ru' => 'SMTP имя пользователя',
                ],
                'admin.settings.app.email.smtp_password' => [
                    'tr' => 'SMTP Şifre',
                    'ru' => 'SMTP пароль',
                ],
                'admin.settings.app.email.gmail_app_password_help' => [
                    'tr' => 'Gmail için uygulama şifresi kullanmanız gerekebilir',
                    'ru' => 'Для Gmail может потребоваться использовать пароль приложения',
                ],
                'admin.settings.app.email.google_credentials' => [
                    'tr' => 'Google Kimlik Bilgileri',
                    'ru' => 'Учетные данные Google',
                ],
                'admin.settings.app.email.google_client_id' => [
                    'tr' => 'Google Client ID',
                    'ru' => 'Google Client ID',
                ],
                'admin.settings.app.email.google_client_secret' => [
                    'tr' => 'Google Client Secret',
                    'ru' => 'Google Client Secret',
                ],
                'admin.settings.app.email.get_from_google_console' => [
                    'tr' => 'Google Console\'dan alın',
                    'ru' => 'Получить из Google Console',
                ],
                'admin.settings.app.email.oauth_redirect_url' => [
                    'tr' => 'OAuth Yönlendirme URL\'si',
                    'ru' => 'URL перенаправления OAuth',
                ],
                'admin.settings.app.email.oauth_redirect_help' => [
                    'tr' => 'Bu URL\'yi Google Console\'da OAuth ayarlarınıza eklemeniz gerekir',
                    'ru' => 'Этот URL необходимо добавить в настройки OAuth в Google Console',
                ],
                'admin.settings.app.email.google_captcha_credentials' => [
                    'tr' => 'Google Captcha Kimlik Bilgileri',
                    'ru' => 'Учетные данные Google Captcha',
                ],
                'admin.settings.app.email.recaptcha_secret_key' => [
                    'tr' => 'ReCaptcha Gizli Anahtar',
                    'ru' => 'ReCaptcha секретный ключ',
                ],
                'admin.settings.app.email.recaptcha_site_key' => [
                    'tr' => 'ReCaptcha Site Anahtarı',
                    'ru' => 'ReCaptcha ключ сайта',
                ],
                'admin.settings.app.email.get_from_recaptcha_panel' => [
                    'tr' => 'ReCaptcha panelinden alın',
                    'ru' => 'Получить из панели ReCaptcha',
                ],
                'admin.settings.app.email.recaptcha_setup_info' => [
                    'tr' => 'ReCaptcha Kurulum Bilgisi',
                    'ru' => 'Информация о настройке ReCaptcha',
                ],
                'admin.settings.app.email.google_recaptcha_admin_panel' => [
                    'tr' => 'Google ReCaptcha Admin Paneli',
                    'ru' => 'Панель администратора Google ReCaptcha',
                ],
                'admin.settings.app.email.recaptcha_setup_instructions' => [
                    'tr' => 'adresinden anahtarlarınızı alabilir ve bu alanlara girebilirsiniz',
                    'ru' => 'вы можете получить свои ключи и ввести их в эти поля',
                ],
                'admin.settings.app.email.save_settings' => [
                    'tr' => 'Ayarları Kaydet',
                    'ru' => 'Сохранить настройки',
                ],

                // Social.blade.php phrases
                'admin.settings.app.social.choose_social_login' => [
                    'tr' => 'Sosyal Medya Girişi Seçin',
                    'ru' => 'Выберите социальный вход',
                ],
                'admin.settings.app.social.both' => [
                    'tr' => 'Her İkisi',
                    'ru' => 'Оба',
                ],
                'admin.settings.app.social.facebook' => [
                    'tr' => 'Facebook',
                    'ru' => 'Facebook',
                ],
                'admin.settings.app.social.google' => [
                    'tr' => 'Google',
                    'ru' => 'Google',
                ],
                'admin.settings.app.social.app_id' => [
                    'tr' => 'Uygulama ID\'si',
                    'ru' => 'ID приложения',
                ],
                'admin.settings.app.social.app_secret' => [
                    'tr' => 'Uygulama Gizli Anahtarı',
                    'ru' => 'Секретный ключ приложения',
                ],
                'admin.settings.app.social.redirect_url' => [
                    'tr' => 'Yönlendirme URL\'si',
                    'ru' => 'URL перенаправления',
                ],
                'admin.settings.app.social.from_facebook_developer' => [
                    'tr' => 'Facebook Developer\'dan alın',
                    'ru' => 'Получить от Facebook Developer',
                ],
                'admin.settings.app.social.redirect_url_help' => [
                    'tr' => 'Callback URL\'sini buraya girin',
                    'ru' => 'Введите здесь URL обратного вызова',
                ],
                'admin.settings.app.social.save' => [
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить',
                ],

                // Communication Integration Settings
                'admin.settings.app.webinfo.telegram_link' => [
                    'tr' => 'Telegram Linki',
                    'ru' => 'Ссылка Telegram',
                ],
                'admin.settings.app.webinfo.telegram_link_placeholder' => [
                    'tr' => 'https://t.me/yourtelegram',
                    'ru' => 'https://t.me/yourtelegram',
                ],
                'admin.settings.app.webinfo.tawk_to_code' => [
                    'tr' => 'Tawk.to Widget Kodu',
                    'ru' => 'Код виджета Tawk.to',
                ],
                'admin.settings.app.webinfo.tawk_to_code_placeholder' => [
                    'tr' => 'Tawk.to widget kodunuzu buraya yapıştırın',
                    'ru' => 'Вставьте сюда код виджета Tawk.to',
                ],
                'admin.settings.app.webinfo.tawk_to_help' => [
                    'tr' => 'Tawk.to admin panelinden aldığınız widget kodunu buraya yapıştırın. Bu kod canlı sohbet özelliğini etkinleştirecektir.',
                    'ru' => 'Вставьте код виджета, полученный из панели администратора Tawk.to. Этот код активирует функцию живого чата.',
                ],
                'admin.settings.app.webinfo.communication_integrations' => [
                    'tr' => 'İletişim Entegrasyonları',
                    'ru' => 'Интеграции связи',
                ],
            ];

            foreach ($phrases as $key => $translations) {
                $phrase = Phrase::updateOrCreate(
                    [
                        'key' => $key,
                        'group' => 'admin',
                    ],
                    [
                        'description' => 'Admin AppSettings translations - ' . $key,
                    ]
                );

                foreach ($translations as $langId => $translation) {
                    $languageId = $langId === 'tr' ? 1 : 2;
                    
                    PhraseTranslation::updateOrCreate(
                        [
                            'phrase_id' => $phrase->id,
                            'language_id' => $languageId,
                        ],
                        [
                            'translation' => $translation,
                        ]
                    );
                }
            }
            
            $phrasesAdded = count($phrases);
        });

        $this->command->info('Admin AppSettings phrases seeded successfully! Added ' . $phrasesAdded . ' phrases with Turkish and Russian translations.');
    }
}