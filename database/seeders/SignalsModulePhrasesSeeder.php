<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class SignalsModulePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // Page Headers and Navigation
                'admin.signals.title' => [
                    'tr' => 'Trade Sinyalleri',
                    'ru' => 'Торговые Сигналы'
                ],
                'admin.signals.subtitle' => [
                    'tr' => 'Trading sinyallerini yönetin ve takip edin',
                    'ru' => 'Управляйте торговыми сигналами и отслеживайте их'
                ],
                'admin.signals.management_title' => [
                    'tr' => 'Sinyal Yönetimi',
                    'ru' => 'Управление Сигналами'
                ],
                'admin.signals.management_subtitle' => [
                    'tr' => 'Trading sinyallerini oluşturun ve yönetin',
                    'ru' => 'Создавайте торговые сигналы и управляйте ими'
                ],
                'admin.signals.active_title' => [
                    'tr' => 'Aktif Sinyaller',
                    'ru' => 'Активные Сигналы'
                ],
                'admin.signals.active_subtitle' => [
                    'tr' => 'Kullanıcı sinyal yatırımlarını görüntüleyin ve yönetin',
                    'ru' => 'Просматривайте и управляйте инвестициями пользователей в сигналы'
                ],

                // Buttons and Actions
                'admin.signals.add_new' => [
                    'tr' => 'Yeni Sinyal Ekle',
                    'ru' => 'Добавить Новый Сигнал'
                ],
                'admin.signals.add_signal' => [
                    'tr' => 'Sinyal Ekle',
                    'ru' => 'Добавить Сигнал'
                ],
                'admin.signals.create_signal' => [
                    'tr' => 'Sinyal Oluştur',
                    'ru' => 'Создать Сигнал'
                ],
                'admin.signals.update_signal' => [
                    'tr' => 'Update Signal',
                    'ru' => 'Обновить Сигнал'
                ],
                'admin.signals.publish' => [
                    'tr' => 'Yayınla',
                    'ru' => 'Опубликовать'
                ],
                'admin.signals.add_result' => [
                    'tr' => 'Sonuç Ekle',
                    'ru' => 'Добавить Результат'
                ],
                'admin.signals.publish_result' => [
                    'tr' => 'Sonucu Yayınla',
                    'ru' => 'Опубликовать Результат'
                ],
                'admin.signals.delete' => [
                    'tr' => 'Sil',
                    'ru' => 'Удалить'
                ],
                'admin.signals.edit' => [
                    'tr' => 'Düzenle',
                    'ru' => 'Редактировать'
                ],
                'admin.signals.back_to_signals' => [
                    'tr' => 'Sinyallere Dön',
                    'ru' => 'Вернуться к Сигналам'
                ],
                'admin.signals.preview' => [
                    'tr' => 'Önizle',
                    'ru' => 'Предварительный просмотр'
                ],
                'admin.signals.reset' => [
                    'tr' => 'Sıfırla',
                    'ru' => 'Сбросить'
                ],
                'admin.signals.cancel' => [
                    'tr' => 'İptal',
                    'ru' => 'Отменить'
                ],
                'admin.signals.actions' => [
                    'tr' => 'İşlemler',
                    'ru' => 'Действия'
                ],

                // Form Fields
                'admin.signals.signal_name' => [
                    'tr' => 'Sinyal Adı',
                    'ru' => 'Название Сигнала'
                ],
                'admin.signals.signal_price' => [
                    'tr' => 'Sinyal Fiyatı',
                    'ru' => 'Цена Сигнала'
                ],
                'admin.signals.return_rate' => [
                    'tr' => 'Getiri Oranı (%)',
                    'ru' => 'Доходность (%)'
                ],
                'admin.signals.signal_tag' => [
                    'tr' => 'Sinyal Etiketi (İsteğe Bağlı)',
                    'ru' => 'Тег Сигнала (Необязательно)'
                ],
                'admin.signals.trade_direction' => [
                    'tr' => 'İşlem Yönü',
                    'ru' => 'Направление Сделки'
                ],
                'admin.signals.currency_pair' => [
                    'tr' => 'Döviz Çifti',
                    'ru' => 'Валютная Пара'
                ],
                'admin.signals.price' => [
                    'tr' => 'Fiyat',
                    'ru' => 'Цена'
                ],
                'admin.signals.take_profit_1' => [
                    'tr' => 'Take Profit 1',
                    'ru' => 'Тейк Профит 1'
                ],
                'admin.signals.take_profit_2' => [
                    'tr' => 'Take Profit 2',
                    'ru' => 'Тейк Профит 2'
                ],
                'admin.signals.stop_loss' => [
                    'tr' => 'Stop Loss',
                    'ru' => 'Стоп Лосс'
                ],
                'admin.signals.result' => [
                    'tr' => 'Sonuç',
                    'ru' => 'Результат'
                ],

                // Table Headers
                'admin.signals.reference' => [
                    'tr' => 'Referans',
                    'ru' => 'Ссылка'
                ],
                'admin.signals.status' => [
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                'admin.signals.date_added' => [
                    'tr' => 'Eklenme Tarihi',
                    'ru' => 'Дата Добавления'
                ],
                'admin.signals.customer_name' => [
                    'tr' => 'Müşteri Adı',
                    'ru' => 'Имя Клиента'
                ],
                'admin.signals.asset' => [
                    'tr' => 'Varlık',
                    'ru' => 'Актив'
                ],
                'admin.signals.signal_status' => [
                    'tr' => 'Sinyal Durumu',
                    'ru' => 'Статус Сигнала'
                ],
                'admin.signals.order_type' => [
                    'tr' => 'İşlem Tipi',
                    'ru' => 'Тип Ордера'
                ],
                'admin.signals.investment_amount' => [
                    'tr' => 'Yatırım Tutarı',
                    'ru' => 'Сумма Инвестиций'
                ],
                'admin.signals.expiration' => [
                    'tr' => 'Son Kullanım',
                    'ru' => 'Истечение'
                ],
                'admin.signals.start_date' => [
                    'tr' => 'Başlangıç Tarihi',
                    'ru' => 'Дата Начала'
                ],

                // Statistics
                'admin.signals.total_signals' => [
                    'tr' => 'Toplam Sinyal',
                    'ru' => 'Всего Сигналов'
                ],
                'admin.signals.active_signals' => [
                    'tr' => 'Aktif Sinyal',
                    'ru' => 'Активные Сигналы'
                ],
                'admin.signals.average_return' => [
                    'tr' => 'Ortalama Getiri',
                    'ru' => 'Средняя Доходность'
                ],
                'admin.signals.average_price' => [
                    'tr' => 'Ortalama Fiyat',
                    'ru' => 'Средняя Цена'
                ],

                // Modal Titles
                'admin.signals.add_new_title' => [
                    'tr' => 'Yeni Sinyal Ekle',
                    'ru' => 'Добавить Новый Сигнал'
                ],
                'admin.signals.update_result_title' => [
                    'tr' => 'Sinyal Sonucunu Güncelle',
                    'ru' => 'Обновить Результат Сигнала'
                ],

                // Messages and Descriptions
                'admin.signals.new_signal_description' => [
                    'tr' => 'Yeni bir trading sinyali oluşturun ve kullanıcılarınıza sunun',
                    'ru' => 'Создайте новый торговый сигнал и предложите его своим пользователям'
                ],
                'admin.signals.signal_info_description' => [
                    'tr' => 'Trading sinyalinizin detaylarını girin',
                    'ru' => 'Введите детали вашего торгового сигнала'
                ],
                'admin.signals.trading_signal' => [
                    'tr' => 'Trading Sinyali',
                    'ru' => 'Торговый Сигнал'
                ],
                'admin.signals.signal_preview' => [
                    'tr' => 'Sinyal Önizleme',
                    'ru' => 'Предварительный просмотр сигнала'
                ],

                // Empty States
                'admin.signals.no_data_found' => [
                    'tr' => 'Veri Bulunamadı',
                    'ru' => 'Данные Не Найдены'
                ],
                'admin.signals.no_signals_yet' => [
                    'tr' => 'Henüz hiç sinyal eklenmemiş.',
                    'ru' => 'Сигналы еще не добавлены.'
                ],
                'admin.signals.no_signals_created' => [
                    'tr' => 'Henüz sinyal oluşturulmamış',
                    'ru' => 'Сигналы еще не созданы'
                ],
                'admin.signals.no_active_signals' => [
                    'tr' => 'Aktif Sinyal Bulunamadı',
                    'ru' => 'Активные Сигналы Не Найдены'
                ],
                'admin.signals.no_active_signals_desc' => [
                    'tr' => 'Henüz hiç aktif sinyal yok.',
                    'ru' => 'Пока нет активных сигналов.'
                ],
                'admin.signals.create_first_signal' => [
                    'tr' => 'İlk Sinyali Oluştur',
                    'ru' => 'Создать Первый Сигнал'
                ],
                'admin.signals.first_signal_description' => [
                    'tr' => 'İlk trading sinyalinizi oluşturmak için aşağıdaki butona tıklayın ve kullanıcılarınıza değerli trading sinyalleri sunmaya başlayın.',
                    'ru' => 'Нажмите кнопку ниже, чтобы создать свой первый торговый сигнал и начать предлагать ценные торговые сигналы своим пользователям.'
                ],

                // Signal Tags
                'admin.signals.tag_hot' => [
                    'tr' => '🔥 HOT',
                    'ru' => '🔥 ГОРЯЧИЙ'
                ],
                'admin.signals.tag_new' => [
                    'tr' => '🆕 YENİ',
                    'ru' => '🆕 НОВЫЙ'
                ],
                'admin.signals.tag_premium' => [
                    'tr' => '⭐ PREMİUM',
                    'ru' => '⭐ ПРЕМИУМ'
                ],
                'admin.signals.tag_popular' => [
                    'tr' => '📈 POPÜLER',
                    'ru' => '📈 ПОПУЛЯРНЫЙ'
                ],
                'admin.signals.tag_limited' => [
                    'tr' => '⏰ SINIRLI',
                    'ru' => '⏰ ОГРАНИЧЕННЫЙ'
                ],

                // Action Messages
                'admin.signals.delete_confirm' => [
                    'tr' => 'Bu sinyali silmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите удалить этот сигнал?'
                ],
                'admin.signals.delete_irreversible' => [
                    'tr' => 'Bu sinyali silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.',
                    'ru' => 'Вы уверены, что хотите удалить этот сигнал? Это действие необратимо.'
                ],
                'admin.signals.delete_signal' => [
                    'tr' => 'Sinyali Sil',
                    'ru' => 'Удалить Сигнал'
                ],
                'admin.signals.mark_as_expired' => [
                    'tr' => 'Süresi Dolmuş Olarak İşaretle',
                    'ru' => 'Отметить как Просроченный'
                ],
                'admin.signals.mark_as_active' => [
                    'tr' => 'Aktif Olarak İşaretle',
                    'ru' => 'Отметить как Активный'
                ],

                // Settings Page
                'admin.signals.settings_title' => [
                    'tr' => 'Trade Signals Settings',
                    'ru' => 'Настройки Торговых Сигналов'
                ],
                'admin.signals.settings_description' => [
                    'tr' => 'Set trade signal subscription fees',
                    'ru' => 'Установите тарифы на подписку на торговые сигналы'
                ],
                'admin.signals.monthly_fee' => [
                    'tr' => 'Monthly Fee',
                    'ru' => 'Месячная Плата'
                ],
                'admin.signals.quarterly_fee' => [
                    'tr' => 'Quaterly Fee',
                    'ru' => 'Квартальная Плата'
                ],
                'admin.signals.yearly_fee' => [
                    'tr' => 'Yearly Fee',
                    'ru' => 'Годовая Плата'
                ],
                'admin.signals.chat_id' => [
                    'tr' => 'Chat ID',
                    'ru' => 'ID Чата'
                ],
                'admin.signals.telegram_bot_api' => [
                    'tr' => 'Telegram Bot Api',
                    'ru' => 'API Telegram Бота'
                ],
                'admin.signals.get_id' => [
                    'tr' => 'Get ID',
                    'ru' => 'Получить ID'
                ],
                'admin.signals.delete_id' => [
                    'tr' => 'Delete ID',
                    'ru' => 'Удалить ID'
                ],
                'admin.signals.save' => [
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить'
                ],
                'admin.signals.settings_subtitle' => [
                    'tr' => 'Sinyal abonelik ücretlerini ayarlayın',
                    'ru' => 'Установить плату за подписку на сигналы'
                ],
                'admin.signals.back' => [
                    'tr' => 'Geri',
                    'ru' => 'Назад'
                ],
                'admin.signals.telegram_bot_instructions' => [
                    'tr' => 'Telegram bot API\'nizi girdiğinizden ve özel kanalınızda en az bir mesaj gönderdiğinizden emin olun. Ayrıca Chat ID\'yi almak için botu özel kanala admin olarak eklediğinizden emin olun.',
                    'ru' => 'Убедитесь, что вы ввели API вашего Telegram-бота и отправили хотя бы одно сообщение в вашем частном канале. Также убедитесь, что вы добавили бота как администратора в частный канал, чтобы получить Chat ID.'
                ],
                'admin.signals.see_how' => [
                    'tr' => 'Nasıl Yapılacağını Gör',
                    'ru' => 'Смотреть как'
                ],

                // Help Texts
                'admin.signals.increment_description' => [
                    'tr' => 'Artış (% cinsinden)',
                    'ru' => 'Прирост (в %)'
                ],
                'admin.signals.increment_rate' => [
                    'tr' => 'Artış Oranı (%)',
                    'ru' => 'Увеличение (%)'
                ],
                'admin.signals.enter_signal_name' => [
                    'tr' => 'Sinyal adı girin',
                    'ru' => 'Введите название сигнала'
                ],
                'admin.signals.enter_signal_price' => [
                    'tr' => 'Sinyal fiyatı girin',
                    'ru' => 'Введите цену сигнала'
                ],
                'admin.signals.price_description' => [
                    'tr' => 'Bu, kullanıcının bu sinyale dahil olmak için ödeyebileceği tutardır, değeri virgül (,) olmadan girin',
                    'ru' => 'Это сумма, которую пользователь может заплатить за этот сигнал, введите значение без запятой (,)'
                ],
                'admin.signals.increment_placeholder' => [
                    'tr' => 'Artış Tutarı',
                    'ru' => 'Сумма Прироста'
                ],
                'admin.signals.all_signals' => [
                    'tr' => 'Tüm Sinyaller',
                    'ru' => 'Все Сигналы'
                ],
                'admin.signals.active_signals_subtitle' => [
                    'tr' => 'Kullanıcı sinyal yatırımlarını görüntüleyin ve yönetin',
                    'ru' => 'Просмотр и управление пользовательскими инвестициями в сигналы'
                ],
                'admin.signals.no_active_signals_subtitle' => [
                    'tr' => 'Henüz hiç aktif sinyal yok.',
                    'ru' => 'Пока нет активных сигналов.'
                ],
                'admin.signals.mark_expired' => [
                    'tr' => 'Süresi Dolmuş Olarak İşaretle',
                    'ru' => 'Отметить как истекший'
                ],
                'admin.signals.mark_active' => [
                    'tr' => 'Aktif Olarak İşaretle',
                    'ru' => 'Отметить как активный'
                ],
                'admin.signals.confirm_delete' => [
                    'tr' => 'Bu sinyali silmek istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите удалить этот сигнал?'
                ],

                // Tips Section (from newsignal.blade.php)
                'admin.signals.tips_title' => [
                    'tr' => 'Başarılı Sinyal İpuçları',
                    'ru' => 'Советы по Успешным Сигналам'
                ],
                'admin.signals.tips_description' => [
                    'tr' => 'Daha etkili sinyaller oluşturmak için önerilerimiz',
                    'ru' => 'Наши рекомендации для создания более эффективных сигналов'
                ],
                'admin.signals.tip_clear_name' => [
                    'tr' => 'Net ve Açık İsim',
                    'ru' => 'Четкое и Ясное Название'
                ],
                'admin.signals.tip_realistic_return' => [
                    'tr' => 'Gerçekçi Getiri',
                    'ru' => 'Реалистичная Доходность'
                ],
                'admin.signals.tip_target_audience' => [
                    'tr' => 'Hedef Kitle',
                    'ru' => 'Целевая Аудитория'
                ],
                'admin.signals.tip_correct_tag' => [
                    'tr' => 'Doğru Etiket',
                    'ru' => 'Правильный Тег'
                ]
            ];

            foreach ($phrases as $key => $translations) {
                // Check if phrase already exists
                $existingPhrase = Phrase::where('key', $key)->first();
                
                if (!$existingPhrase) {
                    // Create new phrase
                    $phrase = Phrase::create([
                        'key' => $key,
                        'group' => 'admin'
                    ]);

                    // Add translations
                    foreach ($translations as $languageCode => $translation) {
                        $languageId = $languageCode === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian
                        
                        PhraseTranslation::create([
                            'phrase_id' => $phrase->id,
                            'language_id' => $languageId,
                            'translation' => $translation
                        ]);
                    }
                }
            }
        });
    }
}