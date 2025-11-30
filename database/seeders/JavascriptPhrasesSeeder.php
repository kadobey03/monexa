<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class JavascriptPhrasesSeeder extends Seeder
{
    /**
     * Run the JavaScript phrases database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🚀 JavaScript Phrase Seeder başlıyor...');

        // Get or create languages
        $turkish = Language::firstOrCreate(
            ['code' => 'tr'],
            [
                'name' => 'Turkish',
                'native_name' => 'Türkçe',
                'flag_icon' => '🇹🇷',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1
            ]
        );

        $russian = Language::firstOrCreate(
            ['code' => 'ru'],
            [
                'name' => 'Russian',
                'native_name' => 'Русский',
                'flag_icon' => '🇷🇺',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2
            ]
        );

        $this->command->info("✅ Diller hazırlandı: TR (ID: {$turkish->id}), RU (ID: {$russian->id})");

        // Start database transaction
        DB::transaction(function () use ($turkish, $russian) {
            
            $totalPhrases = 0;
            $totalTranslations = 0;

            // 1. JavaScript Success Messages
            $successPhrases = [
                'js.success.operation_completed' => [
                    'tr' => 'İşlem başarıyla tamamlandı',
                    'ru' => 'Операция успешно завершена'
                ],
                'js.success.data_saved' => [
                    'tr' => 'Veriler başarıyla kaydedildi',
                    'ru' => 'Данные успешно сохранены'
                ],
                'js.success.data_updated' => [
                    'tr' => 'Veriler başarıyla güncellendi',
                    'ru' => 'Данные успешно обновлены'
                ],
                'js.success.data_deleted' => [
                    'tr' => 'Veriler başarıyla silindi',
                    'ru' => 'Данные успешно удалены'
                ],
                'js.success.file_uploaded' => [
                    'tr' => 'Dosya başarıyla yüklendi',
                    'ru' => 'Файл успешно загружен'
                ],
                'js.success.email_sent' => [
                    'tr' => 'E-posta başarıyla gönderildi',
                    'ru' => 'Электронная почта успешно отправлена'
                ],
                'js.success.changes_saved' => [
                    'tr' => 'Değişiklikler kaydedildi',
                    'ru' => 'Изменения сохранены'
                ],
                'js.success.settings_updated' => [
                    'tr' => 'Ayarlar güncellendi',
                    'ru' => 'Настройки обновлены'
                ],
                'js.success.profile_updated' => [
                    'tr' => 'Profil güncellendi',
                    'ru' => 'Профиль обновлен'
                ],
                'js.success.password_changed' => [
                    'tr' => 'Şifre başarıyla değiştirildi',
                    'ru' => 'Пароль успешно изменен'
                ],
                'js.success.registration_successful' => [
                    'tr' => 'Kayıt işlemi başarıyla tamamlandı',
                    'ru' => 'Регистрация успешно завершена'
                ],
                'js.success.login_successful' => [
                    'tr' => 'Giriş başarılı, yönlendiriliyorsunuz',
                    'ru' => 'Вход выполнен успешно, перенаправление'
                ],
                'js.success.logout_successful' => [
                    'tr' => 'Güvenli çıkış yapıldı',
                    'ru' => 'Безопасный выход выполнен'
                ],
                'js.success.copy_successful' => [
                    'tr' => 'Başarıyla kopyalandı',
                    'ru' => 'Успешно скопировано'
                ],
                'js.success.action_completed' => [
                    'tr' => 'İşlem tamamlandı',
                    'ru' => 'Действие завершено'
                ],
                'js.success.admin_status_updated' => [
                    'tr' => 'Yönetici durumu başarıyla güncellendi',
                    'ru' => 'Статус администратора успешно обновлен'
                ],
                'js.success.dom_elements_found' => [
                    'tr' => 'Tüm gerekli DOM elementleri bulundu',
                    'ru' => 'Все необходимые DOM элементы найдены'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($successPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($successPhrases) * 2;

            // 2. JavaScript Error Messages
            $errorPhrases = [
                'js.errors.server_error' => [
                    'tr' => 'Sunucu hatası oluştu',
                    'ru' => 'Произошла ошибка сервера'
                ],
                'js.errors.network_error' => [
                    'tr' => 'Ağ bağlantı hatası',
                    'ru' => 'Ошибка сетевого подключения'
                ],
                'js.errors.timeout_error' => [
                    'tr' => 'İstek zaman aşımına uğradı',
                    'ru' => 'Время ожидания запроса истекло'
                ],
                'js.errors.unknown_error' => [
                    'tr' => 'Bilinmeyen hata oluştu',
                    'ru' => 'Произошла неизвестная ошибка'
                ],
                'js.errors.permission_denied' => [
                    'tr' => 'Bu işlem için yetkiniz yok',
                    'ru' => 'У вас нет разрешения на это действие'
                ],
                'js.errors.invalid_response' => [
                    'tr' => 'Geçersiz sunucu yanıtı',
                    'ru' => 'Недействительный ответ сервера'
                ],
                'js.errors.file_too_large' => [
                    'tr' => 'Dosya boyutu çok büyük',
                    'ru' => 'Размер файла слишком большой'
                ],
                'js.errors.invalid_file_type' => [
                    'tr' => 'Geçersiz dosya türü',
                    'ru' => 'Недопустимый тип файла'
                ],
                'js.errors.connection_lost' => [
                    'tr' => 'Bağlantı kesildi',
                    'ru' => 'Соединение потеряно'
                ],
                'js.errors.session_expired' => [
                    'tr' => 'Oturum süresi doldu',
                    'ru' => 'Сессия истекла'
                ],
                'js.errors.access_denied' => [
                    'tr' => 'Erişim reddedildi',
                    'ru' => 'Доступ запрещен'
                ],
                'js.errors.operation_failed' => [
                    'tr' => 'İşlem başarısız',
                    'ru' => 'Операция не удалась'
                ],
                'js.errors.loading_failed' => [
                    'tr' => 'Yükleme başarısız',
                    'ru' => 'Загрузка не удалась'
                ],
                'js.errors.processing_error' => [
                    'tr' => 'İşlem hatası oluştu',
                    'ru' => 'Произошла ошибка обработки'
                ],
                'js.errors.authentication_failed' => [
                    'tr' => 'Kimlik doğrulama başarısız',
                    'ru' => 'Аутентификация не удалась'
                ],
                'js.errors.dom_elements_missing' => [
                    'tr' => 'Bazı DOM elementleri bulunamadı',
                    'ru' => 'Некоторые DOM элементы не найдены'
                ],
                'js.errors.connection_error' => [
                    'tr' => 'Bağlantı hatası. İnternet bağlantınızı kontrol edin.',
                    'ru' => 'Ошибка подключения. Проверьте интернет-соединение.'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($errorPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($errorPhrases) * 2;

            // 3. JavaScript Validation Messages
            $validationPhrases = [
                'js.validation.required_field' => [
                    'tr' => 'Bu alan zorunludur',
                    'ru' => 'Это поле обязательно'
                ],
                'js.validation.invalid_email' => [
                    'tr' => 'Geçersiz e-posta adresi',
                    'ru' => 'Недействительный адрес электронной почты'
                ],
                'js.validation.invalid_phone' => [
                    'tr' => 'Geçersiz telefon numarası',
                    'ru' => 'Недействительный номер телефона'
                ],
                'js.validation.password_mismatch' => [
                    'tr' => 'Şifreler eşleşmiyor',
                    'ru' => 'Пароли не совпадают'
                ],
                'js.validation.min_length' => [
                    'tr' => 'En az :min karakter giriniz',
                    'ru' => 'Введите минимум :min символов'
                ],
                'js.validation.max_length' => [
                    'tr' => 'En fazla :max karakter girebilirsiniz',
                    'ru' => 'Вы можете ввести максимум :max символов'
                ],
                'js.validation.numeric_only' => [
                    'tr' => 'Sadece sayısal değer girebilirsiniz',
                    'ru' => 'Вы можете вводить только числовые значения'
                ],
                'js.validation.invalid_amount' => [
                    'tr' => 'Geçersiz miktar',
                    'ru' => 'Недействительная сумма'
                ],
                'js.validation.invalid_date' => [
                    'tr' => 'Geçersiz tarih formatı',
                    'ru' => 'Неверный формат даты'
                ],
                'js.validation.future_date_required' => [
                    'tr' => 'Gelecek bir tarih seçiniz',
                    'ru' => 'Выберите будущую дату'
                ],
                'js.validation.past_date_required' => [
                    'tr' => 'Geçmiş bir tarih seçiniz',
                    'ru' => 'Выберите прошлую дату'
                ],
                'js.validation.numeric_required' => [
                    'tr' => 'Sayısal değer gerekli',
                    'ru' => 'Требуется числовое значение'
                ],
                'js.validation.invalid_format' => [
                    'tr' => 'Geçersiz format',
                    'ru' => 'Неверный формат'
                ],
                'js.validation.field_too_long' => [
                    'tr' => 'Alan çok uzun',
                    'ru' => 'Поле слишком длинное'
                ],
                'js.validation.field_too_short' => [
                    'tr' => 'Alan çok kısa',
                    'ru' => 'Поле слишком короткое'
                ],
                'js.validation.invalid_selection' => [
                    'tr' => 'Geçersiz seçim',
                    'ru' => 'Неверный выбор'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($validationPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($validationPhrases) * 2;

            // 4. JavaScript Financial Messages
            $financialPhrases = [
                'js.financial.deposit_successful' => [
                    'tr' => 'Para yatırma işlemi başarılı',
                    'ru' => 'Операция пополнения прошла успешно'
                ],
                'js.financial.withdrawal_successful' => [
                    'tr' => 'Para çekme işlemi başarılı',
                    'ru' => 'Операция вывода прошла успешно'
                ],
                'js.financial.insufficient_balance' => [
                    'tr' => 'Yetersiz bakiye',
                    'ru' => 'Недостаточный баланс'
                ],
                'js.financial.transaction_processing' => [
                    'tr' => 'İşleminiz işleniyor...',
                    'ru' => 'Ваша транзакция обрабатывается...'
                ],
                'js.financial.payment_failed' => [
                    'tr' => 'Ödeme işlemi başarısız',
                    'ru' => 'Платеж не прошел'
                ],
                'js.financial.order_placed' => [
                    'tr' => 'Emir başarıyla verildi',
                    'ru' => 'Ордер успешно размещен'
                ],
                'js.financial.position_opened' => [
                    'tr' => 'Pozisyon açıldı',
                    'ru' => 'Позиция открыта'
                ],
                'js.financial.position_closed' => [
                    'tr' => 'Pozisyon kapatıldı',
                    'ru' => 'Позиция закрыта'
                ],
                'js.financial.margin_call' => [
                    'tr' => 'Margin call uyarısı',
                    'ru' => 'Предупреждение о марже'
                ],
                'js.financial.stop_loss_triggered' => [
                    'tr' => 'Stop loss tetiklendi',
                    'ru' => 'Стоп-лосс активирован'
                ],
                'js.financial.take_profit_triggered' => [
                    'tr' => 'Kar al tetiklendi',
                    'ru' => 'Тейк-профит активирован'
                ],
                'js.financial.balance_updated' => [
                    'tr' => 'Bakiyeniz güncellendi',
                    'ru' => 'Ваш баланс обновлен'
                ],
                'js.financial.currency_converted' => [
                    'tr' => 'Para birimi çevirme işlemi tamamlandı',
                    'ru' => 'Конвертация валюты завершена'
                ],
                'js.financial.transfer_completed' => [
                    'tr' => 'Transfer işlemi tamamlandı',
                    'ru' => 'Перевод завершен'
                ],
                'js.financial.investment_created' => [
                    'tr' => 'Yatırım başarıyla oluşturuldu',
                    'ru' => 'Инвестиция успешно создана'
                ],
                'js.financial.plan_activated' => [
                    'tr' => 'Plan aktifleştirildi',
                    'ru' => 'План активирован'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($financialPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($financialPhrases) * 2;

            // 5. JavaScript Trading Interface Messages
            $tradingPhrases = [
                'js.trading.market_closed' => [
                    'tr' => 'Piyasa kapalı',
                    'ru' => 'Рынок закрыт'
                ],
                'js.trading.order_pending' => [
                    'tr' => 'Emir beklemede',
                    'ru' => 'Ордер в ожидании'
                ],
                'js.trading.order_executed' => [
                    'tr' => 'Emir gerçekleştirildi',
                    'ru' => 'Ордер исполнен'
                ],
                'js.trading.order_cancelled' => [
                    'tr' => 'Emir iptal edildi',
                    'ru' => 'Ордер отменен'
                ],
                'js.trading.price_updated' => [
                    'tr' => 'Fiyat güncellendi',
                    'ru' => 'Цена обновлена'
                ],
                'js.trading.connection_lost' => [
                    'tr' => 'Piyasa bağlantısı kesildi',
                    'ru' => 'Связь с рынком потеряна'
                ],
                'js.trading.reconnecting' => [
                    'tr' => 'Yeniden bağlanıyor...',
                    'ru' => 'Переподключение...'
                ],
                'js.trading.connected' => [
                    'tr' => 'Piyasaya bağlandı',
                    'ru' => 'Подключено к рынку'
                ],
                'js.trading.volume_too_low' => [
                    'tr' => 'Hacim çok düşük',
                    'ru' => 'Объем слишком низкий'
                ],
                'js.trading.spread_too_high' => [
                    'tr' => 'Spread çok yüksek',
                    'ru' => 'Спред слишком высокий'
                ],
                'js.trading.insufficient_margin' => [
                    'tr' => 'Yetersiz margin',
                    'ru' => 'Недостаточная маржа'
                ],
                'js.trading.trademode_none_desc' => [
                    'tr' => 'Bu modda işlem boyutu korunur',
                    'ru' => 'В этом режиме размер сделки сохраняется'
                ],
                'js.trading.trademode_balance_desc' => [
                    'tr' => 'Bakiyeye göre işlem boyutu ölçeklenir',
                    'ru' => 'Размер сделки масштабируется по балансу'
                ],
                'js.trading.enter_fixed_volume' => [
                    'tr' => 'Sabit işlem hacmi girin',
                    'ru' => 'Введите фиксированный объем сделки'
                ],
                'js.trading.enter_math_expression' => [
                    'tr' => 'Math.js ifadesi girin',
                    'ru' => 'Введите выражение Math.js'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($tradingPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($tradingPhrases) * 2;

            // 6. JavaScript Confirmation Messages
            $confirmationPhrases = [
                'js.confirmations.delete_item' => [
                    'tr' => 'Bu öğeyi silmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите удалить этот элемент?'
                ],
                'js.confirmations.admin_status_change' => [
                    'tr' => 'Yöneticinin durumunu değiştirmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите изменить статус администратора?'
                ],
                'js.confirmations.delete_admin' => [
                    'tr' => 'Yönetici Silme',
                    'ru' => 'Удаление администратора'
                ],
                'js.confirmations.yes_delete' => [
                    'tr' => 'Evet, Sil',
                    'ru' => 'Да, удалить'
                ],
                'js.confirmations.cancel_order' => [
                    'tr' => 'Bu emri iptal etmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите отменить этот ордер?'
                ],
                'js.confirmations.close_position' => [
                    'tr' => 'Bu pozisyonu kapatmak istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите закрыть эту позицию?'
                ],
                'js.confirmations.logout' => [
                    'tr' => 'Çıkış yapmak istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите выйти?'
                ],
                'js.confirmations.discard_changes' => [
                    'tr' => 'Değişiklikleri kaydetmeden çıkmak istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите выйти без сохранения изменений?'
                ],
                'js.confirmations.reset_form' => [
                    'tr' => 'Formu sıfırlamak istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите сбросить форму?'
                ],
                'js.confirmations.delete_account' => [
                    'tr' => 'Hesabınızı silmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите удалить свой аккаунт?'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($confirmationPhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($confirmationPhrases) * 2;

            // 7. JavaScript Real-time Messages
            $realtimePhrases = [
                'js.realtime.connecting' => [
                    'tr' => 'Bağlanıyor...',
                    'ru' => 'Подключение...'
                ],
                'js.realtime.connected' => [
                    'tr' => 'Bağlandı',
                    'ru' => 'Подключено'
                ],
                'js.realtime.disconnected' => [
                    'tr' => 'Bağlantı kesildi',
                    'ru' => 'Отключено'
                ],
                'js.realtime.reconnecting' => [
                    'tr' => 'Yeniden bağlanıyor...',
                    'ru' => 'Переподключение...'
                ],
                'js.realtime.new_message' => [
                    'tr' => 'Yeni mesaj',
                    'ru' => 'Новое сообщение'
                ],
                'js.realtime.new_notification' => [
                    'tr' => 'Yeni bildirim',
                    'ru' => 'Новое уведомление'
                ],
                'js.realtime.update_available' => [
                    'tr' => 'Güncelleme mevcut',
                    'ru' => 'Доступно обновление'
                ],
                'js.realtime.data_refreshed' => [
                    'tr' => 'Veriler yenilendi',
                    'ru' => 'Данные обновлены'
                ],
                'js.realtime.live_updates' => [
                    'tr' => 'Canlı güncellemeler',
                    'ru' => 'Живые обновления'
                ],
                'js.realtime.sync_completed' => [
                    'tr' => 'Senkronizasyon tamamlandı',
                    'ru' => 'Синхронизация завершена'
                ],
            ];

            $totalPhrases += $this->createPhrasesFromArray($realtimePhrases, 'javascript', $turkish, $russian);
            $totalTranslations += count($realtimePhrases) * 2;

            $this->command->info("✅ JavaScript Phrase Seeder tamamlandı!");
            $this->command->info("📊 Toplam Phrase: {$totalPhrases}");
            $this->command->info("📊 Toplam Translation: {$totalTranslations}");
            
        });

        $this->command->info('🎉 JavaScript Phrase Seeder başarıyla tamamlandı!');
    }

    /**
     * Create phrases and translations from array
     *
     * @param array $phrasesArray
     * @param string $group
     * @param Language $turkish
     * @param Language $russian
     * @return int
     */
    private function createPhrasesFromArray(array $phrasesArray, string $group, Language $turkish, Language $russian): int
    {
        $count = 0;
        
        foreach ($phrasesArray as $key => $translations) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate(
                ['key' => $key],
                [
                    'group' => $group,
                    'description' => "JavaScript localization for {$key}",
                    'is_active' => true,
                    'context' => 'web',
                    'usage_count' => 0
                ]
            );

            // Create translations for both languages
            foreach ($translations as $languageCode => $translation) {
                $language = $languageCode === 'tr' ? $turkish : $russian;
                
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $language->id
                    ],
                    [
                        'translation' => $translation,
                        'is_reviewed' => true,
                        'needs_update' => false,
                        'reviewer' => 'system-seeder'
                    ]
                );
            }

            $count++;
        }

        return $count;
    }
}