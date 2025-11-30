<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use DB;

class PaymentSettingsPhrasesSeeder extends Seeder
{
    /**
     * Payment Settings phrases seeder for Turkish and Russian languages
     * Covers: withdrawal.blade.php, coinpayment.blade.php, editpaymethod.blade.php
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // === MAIN PAYMENT SETTINGS PAGE ===
                [
                    'key' => 'admin.payment_settings.title',
                    'tr' => 'Ödeme Ayarları',
                    'ru' => 'Настройки Платежей'
                ],
                [
                    'key' => 'admin.payment_settings.subtitle',
                    'tr' => 'Ödeme yöntemlerini ve ayarlarını yönetin',
                    'ru' => 'Управляйте способами оплаты и настройками'
                ],

                // === TABS SECTION ===
                [
                    'key' => 'admin.payment_settings.tabs.payment_methods',
                    'tr' => 'Ödeme Yöntemleri',
                    'ru' => 'Способы Оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.tabs.preferences',
                    'tr' => 'Tercihler',
                    'ru' => 'Настройки'
                ],
                [
                    'key' => 'admin.payment_settings.tabs.coinpayment',
                    'tr' => 'Coinpayment',
                    'ru' => 'Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.tabs.gateways',
                    'tr' => 'Ödeme Geçitleri',
                    'ru' => 'Платежные Шлюзы'
                ],
                [
                    'key' => 'admin.payment_settings.tabs.transfers',
                    'tr' => 'Transferler',
                    'ru' => 'Переводы'
                ],

                // === METHODS SECTION ===
                [
                    'key' => 'admin.payment_settings.methods.title',
                    'tr' => 'Ödeme Yöntemleri',
                    'ru' => 'Способы Оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.methods.subtitle',
                    'tr' => 'Mevcut ödeme yöntemlerini yönetin ve düzenleyin',
                    'ru' => 'Управляйте и редактируйте существующие способы оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.methods.add_new',
                    'tr' => 'Yeni Yöntem Ekle',
                    'ru' => 'Добавить Новый Способ'
                ],
                [
                    'key' => 'admin.payment_settings.methods.current_methods',
                    'tr' => 'Mevcut Yöntemler',
                    'ru' => 'Существующие Способы'
                ],

                // === TABLE HEADERS ===
                [
                    'key' => 'admin.payment_settings.methods.table.method_name',
                    'tr' => 'Yöntem Adı',
                    'ru' => 'Название Способа'
                ],
                [
                    'key' => 'admin.payment_settings.methods.table.type',
                    'tr' => 'Tür',
                    'ru' => 'Тип'
                ],
                [
                    'key' => 'admin.payment_settings.methods.table.usage_area',
                    'tr' => 'Kullanım Alanı',
                    'ru' => 'Область Использования'
                ],
                [
                    'key' => 'admin.payment_settings.methods.table.status',
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                
                // === MISSING PHRASES FROM WITHDRAWAL.BLADE.PHP ===
                [
                    'key' => 'admin.payment_settings.current',
                    'tr' => 'Mevcut',
                    'ru' => 'Текущий'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.deposit_option_help',
                    'tr' => 'Depozit onayı manuel veya otomatik olarak yapılacağını belirler',
                    'ru' => 'Определяет, будет ли подтверждение депозита выполняться вручную или автоматически'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.withdrawal_option_help',
                    'tr' => 'Çekim onayı manuel veya otomatik olarak yapılacağını belirler',
                    'ru' => 'Определяет, будет ли подтверждение вывода выполняться вручную или автоматически'
                ],
                [
                    'key' => 'admin.payment_settings.limits.minimum_investment',
                    'tr' => 'Minimum Yatırım Tutarı (:currency)',
                    'ru' => 'Минимальная Сумма Инвестиции (:currency)'
                ],
                [
                    'key' => 'admin.payment_settings.limits.minimum_investment_placeholder',
                    'tr' => 'Minimum tutarı girin',
                    'ru' => 'Введите минимальную сумму'
                ],
                [
                    'key' => 'admin.payment_settings.limits.minimum_investment_help',
                    'tr' => 'Kullanıcıların yapabileceği en düşük yatırım tutarı',
                    'ru' => 'Минимальная сумма инвестиции, которую могут сделать пользователи'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.deduction_timing',
                    'tr' => 'Kesinti Zamanlaması',
                    'ru' => 'Время Удержания'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.deduct_on_request',
                    'tr' => 'Talep Anında Kes',
                    'ru' => 'Удержать При Запросе'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.deduct_on_approval',
                    'tr' => 'Onay Anında Kes',
                    'ru' => 'Удержать При Одобрении'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.deduction_timing_help',
                    'tr' => 'Çekim tutarının kullanıcı bakiyesinden ne zaman kesileceğini belirler. "Talep Anında" seçeneği kullanıcı çekim talebinde bulunduğu anda kesinti yapar, "Onay Anında" ise admin onayından sonra kesinti yapar.',
                    'ru' => 'Определяет, когда сумма вывода будет списана с баланса пользователя. "При запросе" списывает сумму сразу при подаче заявки пользователем, "При одобрении" - после одобрения администратором.'
                ],

                // === WITHDRAWAL PREFERENCES SECTION ===
                [
                    'key' => 'admin.payment_settings.preferences.title',
                    'tr' => 'Ödeme Tercihleri',
                    'ru' => 'Настройки Платежей'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.subtitle', 
                    'tr' => 'Otomatik ve manuel ödeme seçeneklerini yapılandırın',
                    'ru' => 'Настройте автоматические и ручные варианты платежей'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.deposit_option',
                    'tr' => 'Yatırım Seçeneği',
                    'ru' => 'Опция Депозита'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.transaction_types',
                    'tr' => 'İşlem Türü Ayarları',
                    'ru' => 'Настройки Типов Транзакций'
                ],
                [
                    'key' => 'admin.payment_settings.preferences.auto_payment',
                    'tr' => 'Otomatik Ödeme',
                    'ru' => 'Автоматический Платеж'
                ],

                // === LIMITS SECTION ===
                [
                    'key' => 'admin.payment_settings.limits.title',
                    'tr' => 'Finansal Limitler',
                    'ru' => 'Финансовые Лимиты'
                ],
                [
                    'key' => 'admin.payment_settings.limits.minimum_deposit',
                    'tr' => 'Minimum Yatırım',
                    'ru' => 'Минимальный Депозит'
                ],
                [
                    'key' => 'admin.payment_settings.limits.maximum_deposit',
                    'tr' => 'Maksimum Yatırım',
                    'ru' => 'Максимальный Депозит'
                ],
                [
                    'key' => 'admin.payment_settings.limits.minimum_withdrawal',
                    'tr' => 'Minimum Çekim',
                    'ru' => 'Минимальный Вывод'
                ],
                [
                    'key' => 'admin.payment_settings.limits.maximum_withdrawal',
                    'tr' => 'Maksimum Çekim',
                    'ru' => 'Максимальный Вывод'
                ],

                // === PROVIDERS SECTION ===
                [
                    'key' => 'admin.payment_settings.providers.title',
                    'tr' => 'Ödeme Sağlayıcıları',
                    'ru' => 'Поставщики Платежей'
                ],
                [
                    'key' => 'admin.payment_settings.providers.usdt_provider',
                    'tr' => 'USDT Otomatik Ödeme Sağlayıcısı',
                    'ru' => 'Поставщик Автоматических USDT Платежей'
                ],
                [
                    'key' => 'admin.payment_settings.providers.credit_card_provider',
                    'tr' => 'Kredi Kartı Sağlayıcısı',
                    'ru' => 'Поставщик Кредитных Карт'
                ],

                // === WITHDRAWAL SECTION ===
                [
                    'key' => 'admin.payment_settings.withdrawal.title',
                    'tr' => 'Çekim İşlem Ayarları',
                    'ru' => 'Настройки Вывода'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.deduction_timing',
                    'tr' => 'Çekim Kesintisi Zamanı',
                    'ru' => 'Время Удержания При Выводе'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.before_processing',
                    'tr' => 'İşlem Öncesi',
                    'ru' => 'До Обработки'
                ],
                [
                    'key' => 'admin.payment_settings.withdrawal.after_processing',
                    'tr' => 'İşlem Sonrası',
                    'ru' => 'После Обработки'
                ],

                // === ACTIONS SECTION ===
                [
                    'key' => 'admin.payment_settings.actions.save',
                    'tr' => 'Ayarları Kaydet',
                    'ru' => 'Сохранить Настройки'
                ],
                [
                    'key' => 'admin.payment_settings.actions.saving',
                    'tr' => 'Kaydediliyor',
                    'ru' => 'Сохранение'
                ],

                // === COINPAYMENT SECTION ===
                [
                    'key' => 'admin.payment_settings.coinpayment.title',
                    'tr' => 'Coinpayment Ayarları',
                    'ru' => 'Настройки Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.subtitle',
                    'tr' => 'Coinpayment API entegrasyonunu yapılandırın',
                    'ru' => 'Настройте интеграцию Coinpayment API'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.api_configuration',
                    'tr' => 'Coinpayment API Yapılandırması',
                    'ru' => 'Конфигурация Coinpayment API'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.api_description',
                    'tr' => 'Kripto para ödemelerini otomatikleştirmek için gerekli bilgileri girin',
                    'ru' => 'Введите необходимую информацию для автоматизации криптоплатежей'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.api_keys',
                    'tr' => 'API Anahtarları',
                    'ru' => 'API Ключи'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.public_key',
                    'tr' => 'Public Key',
                    'ru' => 'Публичный Ключ'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.public_key_placeholder',
                    'tr' => 'Coinpayment Public Key\'inizi girin',
                    'ru' => 'Введите ваш Coinpayment Public Key'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.public_key_help',
                    'tr' => 'Coinpayment hesabınızdan alacağınız public key',
                    'ru' => 'Публичный ключ из вашего аккаунта Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.private_key',
                    'tr' => 'Private Key',
                    'ru' => 'Приватный Ключ'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.private_key_placeholder',
                    'tr' => 'Coinpayment Private Key\'inizi girin',
                    'ru' => 'Введите ваш Coinpayment Private Key'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.private_key_help',
                    'tr' => 'Güvenlik nedeniyle gizlenmiş. Coinpayment hesabınızdan alacağınız private key',
                    'ru' => 'Скрыто по соображениям безопасности. Приватный ключ из вашего аккаунта Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.merchant_info',
                    'tr' => 'Merchant Bilgileri',
                    'ru' => 'Информация о Торговце'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.merchant_id',
                    'tr' => 'Merchant ID',
                    'ru' => 'ID Торговца'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.merchant_id_placeholder',
                    'tr' => 'Merchant ID\'nizi girin',
                    'ru' => 'Введите ваш Merchant ID'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.merchant_id_help',
                    'tr' => 'Coinpayment hesabınızda bulunan benzersiz merchant kimliği',
                    'ru' => 'Уникальный идентификатор торговца из вашего аккаунта Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.debug_email',
                    'tr' => 'Debug E-posta',
                    'ru' => 'Debug Email'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.debug_email_placeholder',
                    'tr' => 'debug@example.com',
                    'ru' => 'debug@example.com'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.debug_email_help',
                    'tr' => 'Coinpayment hata bildirimleri bu adrese gönderilir',
                    'ru' => 'Уведомления об ошибках Coinpayment будут отправляться на этот адрес'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.ipn_security',
                    'tr' => 'IPN Güvenlik Ayarları',
                    'ru' => 'Настройки Безопасности IPN'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.ipn_secret',
                    'tr' => 'IPN Secret Key',
                    'ru' => 'Секретный Ключ IPN'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.ipn_secret_placeholder',
                    'tr' => 'IPN Secret Key\'inizi girin',
                    'ru' => 'Введите ваш IPN Secret Key'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.ipn_what_is',
                    'tr' => 'IPN Secret Key Nedir?',
                    'ru' => 'Что такое IPN Secret Key?'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.ipn_description',
                    'tr' => 'Instant Payment Notification (IPN) gizli anahtarı, ödeme bildirimlerinin güvenliğini sağlar. Bu anahtar, Coinpayment\'tan gelen bildirimlerin gerçek olduğunu doğrular ve güvenliğinizi artırır.',
                    'ru' => 'Секретный ключ Instant Payment Notification (IPN) обеспечивает безопасность уведомлений о платежах. Этот ключ подтверждает подлинность уведомлений от Coinpayment и повышает вашу безопасность.'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.important_info',
                    'tr' => 'Önemli Bilgiler',
                    'ru' => 'Важная Информация'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.note_1',
                    'tr' => 'Bu bilgileri Coinpayment hesabınızın API ayarlar bölümünden alabilirsiniz',
                    'ru' => 'Эту информацию можно получить из раздела настроек API вашего аккаунта Coinpayment'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.note_2',
                    'tr' => 'API anahtarlarınızı asla üçüncü şahıslarla paylaşmayın',
                    'ru' => 'Никогда не делитесь вашими API ключами с третьими лицами'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.note_3',
                    'tr' => 'Testnet ve mainnet için farklı API anahtarları kullanmanız gerekebilir',
                    'ru' => 'Вам может потребоваться использовать разные API ключи для testnet и mainnet'
                ],
                [
                    'key' => 'admin.payment_settings.coinpayment.note_4',
                    'tr' => 'IPN URL\'inizi Coinpayment hesabınızda doğru şekilde yapılandırın',
                    'ru' => 'Правильно настройте ваш IPN URL в вашем аккаунте Coinpayment'
                ],

                // === EDIT PAYMENT METHOD SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.title',
                    'tr' => 'Ödeme Yöntemi Güncelle',
                    'ru' => 'Обновить Способ Оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.subtitle',
                    'tr' => 'ödeme yöntemi ayarlarını düzenleyin',
                    'ru' => 'редактировать настройки способа оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.back',
                    'tr' => 'Geri Dön',
                    'ru' => 'Назад'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.usdt_warning_title',
                    'tr' => 'USDT Ödeme Yöntemi Hakkında Önemli Bilgi',
                    'ru' => 'Важная Информация о Способе Оплаты USDT'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.usdt_warning_text',
                    'tr' => 'Kullanıcılarınızın USDT ile para çekebilmeleri için, Binance merchant kullanıyor ve otomatik para çekme ayarlıyorsanız, IP adreslerini whitelist\'e almanız gerekir. Bunun için "Kullanıcı Yönetimi"nden giriş aktivitelerini kontrol edin, IP adreslerini toplayın ve Binance merchant dashboard\'ınızda whitelist\'e ekleyin.',
                    'ru' => 'Чтобы ваши пользователи могли выводить средства через USDT, если вы используете Binance merchant и настроили автоматический вывод средств, вам нужно добавить IP-адреса в белый список. Для этого проверьте активности входа в "Управление пользователями", соберите IP-адреса и добавьте их в белый список в вашем Binance merchant dashboard.'
                ],

                // === BASIC INFO SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.basic_info',
                    'tr' => 'Temel Bilgiler',
                    'ru' => 'Основная Информация'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.payment_method_name',
                    'tr' => 'Ödeme Yöntemi Adı',
                    'ru' => 'Название Способа Оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.payment_method_name_placeholder',
                    'tr' => 'Ödeme yöntemi adı',
                    'ru' => 'Название способа оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.default_payment_note',
                    'tr' => 'Bu varsayılan ödeme yöntemidir, adı değiştirilemez',
                    'ru' => 'Это способ оплаты по умолчанию, название изменить нельзя'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.important',
                    'tr' => 'Önemli',
                    'ru' => 'Важно'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.credit_card_note',
                    'tr' => 'Ödeme tercihleri sekmesinden bir kredi kartı sağlayıcısı seçtiğinizden emin olun. Bu yöntem zaten Paystack ve Stripe\'ı kullandığından, bunları ayrı olarak eklemeyin.',
                    'ru' => 'Убедитесь, что выбрали поставщика кредитных карт на вкладке настроек оплаты. Этот метод уже использует Paystack и Stripe, поэтому не добавляйте их отдельно.'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.payment_type',
                    'tr' => 'Ödeme Türü',
                    'ru' => 'Тип Оплаты'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.currency',
                    'tr' => 'Para Birimi',
                    'ru' => 'Валюта'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.crypto',
                    'tr' => 'Kripto Para',
                    'ru' => 'Криптовалюта'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.payment_type_help',
                    'tr' => 'Geleneksel para birimi veya kripto para seçin',
                    'ru' => 'Выберите традиционную валюту или криптовалюту'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.logo_url',
                    'tr' => 'Logo URL\'si',
                    'ru' => 'URL Логотипа'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.logo_url_placeholder',
                    'tr' => 'https://example.com/logo.png',
                    'ru' => 'https://example.com/logo.png'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.logo_url_help',
                    'tr' => 'Ödeme yöntemi logosu için URL (isteğe bağlı)',
                    'ru' => 'URL для логотипа способа оплаты (необязательно)'
                ],

                // === LIMITS & COMMISSIONS SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.limits_commissions',
                    'tr' => 'Limitler ve Komisyonlar',
                    'ru' => 'Лимиты и Комиссии'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.minimum_amount',
                    'tr' => 'Minimum Miktar',
                    'ru' => 'Минимальная Сумма'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.minimum_amount_placeholder',
                    'tr' => '10.00',
                    'ru' => '10.00'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.maximum_amount',
                    'tr' => 'Maximum Miktar',
                    'ru' => 'Максимальная Сумма'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.maximum_amount_placeholder',
                    'tr' => '1000.00',
                    'ru' => '1000.00'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.withdrawal_only',
                    'tr' => 'Sadece para çekme işlemleri için geçerlidir',
                    'ru' => 'Действительно только для операций вывода средств'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.commission_amount',
                    'tr' => 'Komisyon Miktarı',
                    'ru' => 'Сумма Комиссии'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.commission_amount_placeholder',
                    'tr' => '5.00',
                    'ru' => '5.00'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.commission_type',
                    'tr' => 'Komisyon Türü',
                    'ru' => 'Тип Комиссии'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.percentage',
                    'tr' => 'Yüzde (%)',
                    'ru' => 'Процент (%)'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.fixed',
                    'tr' => 'Sabit (:currency)',
                    'ru' => 'Фиксированная (:currency)'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.commission_type_help',
                    'tr' => 'Komisyon hesaplama türü',
                    'ru' => 'Тип расчета комиссии'
                ],

                // === BANK INFO SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.bank_info',
                    'tr' => 'Banka Bilgileri',
                    'ru' => 'Банковская Информация'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.bank_name',
                    'tr' => 'Banka Adı',
                    'ru' => 'Название Банка'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.bank_name_placeholder',
                    'tr' => 'Örnek: Ziraat Bankası',
                    'ru' => 'Пример: Сбербанк'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.account_holder',
                    'tr' => 'Hesap Sahibi',
                    'ru' => 'Владелец Счета'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.account_holder_placeholder',
                    'tr' => 'Örnek: Ahmet Yılmaz',
                    'ru' => 'Пример: Иван Иванов'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.account_number',
                    'tr' => 'Hesap Numarası',
                    'ru' => 'Номер Счета'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.account_number_placeholder',
                    'tr' => 'Örnek: 1234567890123456',
                    'ru' => 'Пример: 1234567890123456'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.swift_code',
                    'tr' => 'SWIFT/Diğer Kod',
                    'ru' => 'SWIFT/Другой Код'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.swift_code_placeholder',
                    'tr' => 'Örnek: TCZBTR2AXXX',
                    'ru' => 'Пример: SABRRUMM'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.swift_code_help',
                    'tr' => 'Uluslararası transferler için gerekli',
                    'ru' => 'Необходимо для международных переводов'
                ],

                // === CRYPTO INFO SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.crypto_info',
                    'tr' => 'Kripto Para Bilgileri',
                    'ru' => 'Информация о Криптовалюте'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.wallet_address',
                    'tr' => 'Cüzdan Adresi',
                    'ru' => 'Адрес Кошелька'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.wallet_address_placeholder',
                    'tr' => 'Kripto cüzdan adresinizi girin',
                    'ru' => 'Введите адрес вашего криптокошелька'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.qr_code',
                    'tr' => 'QR Kod (Barcode)',
                    'ru' => 'QR Код (Штрихкод)'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.qr_code_help',
                    'tr' => 'Cüzdan adresi için QR kod resmi (isteğe bağlı)',
                    'ru' => 'Изображение QR кода для адреса кошелька (необязательно)'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.network_type',
                    'tr' => 'Ağ Türü (Network)',
                    'ru' => 'Тип Сети (Network)'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.network_type_placeholder',
                    'tr' => 'Örnek: TRC20, ERC20, BSC',
                    'ru' => 'Пример: TRC20, ERC20, BSC'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.important_network_info',
                    'tr' => 'Önemli Network Bilgisi',
                    'ru' => 'Важная Информация о Сети'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.network_warning',
                    'tr' => 'USDT ödemeleri için ağ türünün her zaman TRC20, BUSD ödemeleri için ERC20 olması gerekir (otomatik ödeme ve coinpayment kullanıyorsanız). Manuel ödeme kullanıyorsanız istediğiniz ağı seçebilirsiniz.',
                    'ru' => 'Для платежей USDT тип сети всегда должен быть TRC20, для платежей BUSD - ERC20 (если используете автоматические платежи и coinpayment). При использовании ручных платежей можете выбрать любую сеть.'
                ],

                // === GENERAL SETTINGS SECTION ===
                [
                    'key' => 'admin.payment_settings.editpaymethod.general_settings',
                    'tr' => 'Genel Ayarlar',
                    'ru' => 'Общие Настройки'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.status',
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.active',
                    'tr' => 'Aktif',
                    'ru' => 'Активный'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.inactive',
                    'tr' => 'Pasif',
                    'ru' => 'Неактивный'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.usage_area',
                    'tr' => 'Kullanım Alanı',
                    'ru' => 'Область Использования'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.withdrawal',
                    'tr' => 'Para Çekme',
                    'ru' => 'Вывод Средств'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.deposit',
                    'tr' => 'Para Yatırma',
                    'ru' => 'Депозит'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.both',
                    'tr' => 'Her İkisi',
                    'ru' => 'Оба'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.optional_note',
                    'tr' => 'İsteğe Bağlı Not',
                    'ru' => 'Дополнительная Заметка'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.optional_note_placeholder',
                    'tr' => 'Örnek: İşlem 24 saate kadar sürebilir',
                    'ru' => 'Пример: Обработка может занять до 24 часов'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.optional_note_help',
                    'tr' => 'Kullanıcılara gösterilecek bilgi notu',
                    'ru' => 'Информационная заметка для отображения пользователям'
                ],
                [
                    'key' => 'admin.payment_settings.editpaymethod.save_changes',
                    'tr' => 'Değişiklikleri Kaydet',
                    'ru' => 'Сохранить Изменения'
                ],

                // === TRANSFERS SECTION ===
                [
                    'key' => 'admin.payment_settings.transfers.title',
                    'tr' => 'Transfer Ayarları',
                    'ru' => 'Настройки Переводов'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.subtitle',
                    'tr' => 'Kullanıcı transferi özelliklerini yapılandırın',
                    'ru' => 'Настройте функции пользовательских переводов'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.system_title',
                    'tr' => 'Kullanıcı Transfer Sistemi',
                    'ru' => 'Система Переводов Пользователей'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.system_description',
                    'tr' => 'Kullanıcılar arası para transferi özelliklerini yönetin',
                    'ru' => 'Управляйте функциями переводов между пользователями'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.status_title',
                    'tr' => 'Transfer Durumu',
                    'ru' => 'Статус Переводов'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.feature_label',
                    'tr' => 'Kullanıcı Transferi Özelliği',
                    'ru' => 'Функция Пользовательских Переводов'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.enabled',
                    'tr' => 'Açık',
                    'ru' => 'Включено'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.disabled',
                    'tr' => 'Kapalı',
                    'ru' => 'Отключено'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.feature_help',
                    'tr' => 'Bu özelliği kullanmak istiyorsanız açık, kullanmak istemiyorsanız kapalı olarak seçin.',
                    'ru' => 'Выберите "Включено", если хотите использовать эту функцию, или "Отключено", если не хотите.'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.limits_title',
                    'tr' => 'Transfer Limitleri ve Komisyonlar',
                    'ru' => 'Лимиты Переводов и Комиссии'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.minimum_amount',
                    'tr' => 'Minimum Transfer Miktarı',
                    'ru' => 'Минимальная Сумма Перевода'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.minimum_amount_help',
                    'tr' => 'Kullanıcıların yapabileceği minimum transfer miktarı',
                    'ru' => 'Минимальная сумма перевода, которую могут сделать пользователи'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.commission_rate',
                    'tr' => 'Komisyon Oranı (%)',
                    'ru' => 'Комиссионный Тариф (%)'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.commission_help',
                    'tr' => 'Komisyon almak istemiyorsanız 0 girin',
                    'ru' => 'Введите 0, если не хотите взимать комиссию'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_title',
                    'tr' => 'Transfer Özelliği Hakkında',
                    'ru' => 'О Функции Переводов'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_1',
                    'tr' => 'Kullanıcılar birbirlerine para transferi yapabilir',
                    'ru' => 'Пользователи могут переводить деньги друг другу'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_2',
                    'tr' => 'Minimum miktar belirleyerek küçük transferleri engelleyebilirsiniz',
                    'ru' => 'Установив минимальную сумму, вы можете предотвратить мелкие переводы'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_3',
                    'tr' => 'Komisyon oranı her transfer için uygulanır',
                    'ru' => 'Комиссионная ставка применяется к каждому переводу'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_4',
                    'tr' => 'Tüm transfer işlemleri güvenlik kontrollerinden geçer',
                    'ru' => 'Все операции перевода проходят проверку безопасности'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.info_5',
                    'tr' => 'Transfer geçmişi ve detayları admin panelinde görüntülenebilir',
                    'ru' => 'История переводов и подробности могут быть просмотрены в админ панели'
                ],
                [
                    'key' => 'admin.payment_settings.transfers.save_settings',
                    'tr' => 'Ayarları Kaydet',
                    'ru' => 'Сохранить Настройки'
                ]
            ];

            foreach ($phrases as $phraseData) {
                // Create or get phrase
                $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);

                // Create Turkish translation (id: 1)
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 1 // Turkish
                    ],
                    ['translation' => $phraseData['tr']]
                );

                // Create Russian translation (id: 2)
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 2 // Russian
                    ],
                    ['translation' => $phraseData['ru']]
                );
            }

            $this->command->info('Payment Settings phrases seeded successfully: ' . count($phrases) . ' phrases added');
        });
    }
}