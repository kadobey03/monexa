<?php

namespace Database\Seeders;

use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Database\Seeder;

class TradingBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Trading Management - Index Page
            'admin.trading.management' => [
                'tr' => 'İşlem Yönetimi',
                'ru' => 'Управление Торговлей'
            ],
            'admin.trading.user_trades' => [
                'tr' => 'Kullanıcı İşlemleri',
                'ru' => 'Пользовательские Сделки'
            ],
            'admin.trading.overview_and_management' => [
                'tr' => 'Genel görünüm ve yönetim',
                'ru' => 'Обзор и управление'
            ],
            'admin.trading.total_trades' => [
                'tr' => 'Toplam İşlem',
                'ru' => 'Всего Сделок'
            ],
            'admin.trading.active_trades' => [
                'tr' => 'Aktif İşlemler',
                'ru' => 'Активные Сделки'
            ],
            'admin.trading.completed_trades' => [
                'tr' => 'Tamamlanan İşlemler',
                'ru' => 'Завершенные Сделки'
            ],
            'admin.trading.total_volume' => [
                'tr' => 'Toplam Hacim',
                'ru' => 'Общий Объем'
            ],
            'admin.trading.filter_trades' => [
                'tr' => 'İşlemleri Filtrele',
                'ru' => 'Фильтровать Сделки'
            ],
            'admin.trading.by_user' => [
                'tr' => 'Kullanıcıya Göre',
                'ru' => 'По Пользователю'
            ],
            'admin.trading.by_asset' => [
                'tr' => 'Varlığa Göre',
                'ru' => 'По Активу'
            ],
            'admin.trading.by_status' => [
                'tr' => 'Duruma Göre',
                'ru' => 'По Статусу'
            ],
            'admin.trading.search_by_user_email' => [
                'tr' => 'Kullanıcı e-postasına göre ara...',
                'ru' => 'Поиск по email пользователя...'
            ],
            'admin.trading.search_by_asset' => [
                'tr' => 'Varlık ara (BTC, ETH, vb.)',
                'ru' => 'Поиск актива (BTC, ETH, и т.д.)'
            ],
            'admin.trading.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все Статусы'
            ],
            'admin.trading.apply_filters' => [
                'tr' => 'Filtreleri Uygula',
                'ru' => 'Применить Фильтры'
            ],
            'admin.trading.clear_filters' => [
                'tr' => 'Filtreleri Temizle',
                'ru' => 'Очистить Фильтры'
            ],
            'admin.trading.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.trading.asset' => [
                'tr' => 'Varlık',
                'ru' => 'Актив'
            ],
            'admin.trading.symbol' => [
                'tr' => 'Sembol',
                'ru' => 'Символ'
            ],
            'admin.trading.type' => [
                'tr' => 'Tür',
                'ru' => 'Тип'
            ],
            'admin.trading.amount' => [
                'tr' => 'Miktar',
                'ru' => 'Сумма'
            ],
            'admin.trading.leverage' => [
                'tr' => 'Kaldıraç',
                'ru' => 'Кредитное Плечо'
            ],
            'admin.trading.profit_loss' => [
                'tr' => 'Kar/Zarar',
                'ru' => 'Прибыль/Убыток'
            ],
            'admin.trading.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.trading.created' => [
                'tr' => 'Oluşturulma',
                'ru' => 'Создано'
            ],
            'admin.trading.expiry' => [
                'tr' => 'Bitiş',
                'ru' => 'Истечение'
            ],
            'admin.trading.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.trading.buy' => [
                'tr' => 'Alış (Buy)',
                'ru' => 'Покупка (Buy)'
            ],
            'admin.trading.sell' => [
                'tr' => 'Satış (Sell)',
                'ru' => 'Продажа (Sell)'
            ],
            'admin.trading.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный'
            ],
            'admin.trading.completed' => [
                'tr' => 'Tamamlandı',
                'ru' => 'Завершено'
            ],
            'admin.trading.no_trades_found' => [
                'tr' => 'Hiç işlem bulunamadı',
                'ru' => 'Сделки не найдены'
            ],
            'admin.trading.no_trades_match_filters' => [
                'tr' => 'Filtreleme kriterlerinizle eşleşen işlem bulunamadı.',
                'ru' => 'Не найдено сделок, соответствующих вашим фильтрам.'
            ],
            'admin.trading.view_details' => [
                'tr' => 'Detayları Görüntüle',
                'ru' => 'Просмотреть Детали'
            ],
            'admin.trading.quick_profit_loss' => [
                'tr' => 'Hızlı Kar/Zarar',
                'ru' => 'Быстрая Прибыль/Убыток'
            ],
            'admin.trading.add_profit_loss_modal_title' => [
                'tr' => 'Kar/Zarar Ekle',
                'ru' => 'Добавить Прибыль/Убыток'
            ],
            'admin.trading.profit_loss_amount' => [
                'tr' => 'Kar/Zarar Miktarı ($)',
                'ru' => 'Сумма Прибыли/Убытка ($)'
            ],
            'admin.trading.enter_amount' => [
                'tr' => 'Miktar girin',
                'ru' => 'Введите сумму'
            ],
            'admin.trading.note_optional' => [
                'tr' => 'Not (İsteğe bağlı)',
                'ru' => 'Примечание (необязательно)'
            ],
            'admin.trading.add_note_placeholder' => [
                'tr' => 'Bu kar/zarar ekleme işlemi için not...',
                'ru' => 'Примечание для добавления прибыли/убытка...'
            ],
            'admin.trading.add_profit_loss' => [
                'tr' => 'Kar/Zarar Ekle',
                'ru' => 'Добавить Прибыль/Убыток'
            ],
            'admin.trading.trades' => [
                'tr' => 'İşlemler',
                'ru' => 'Сделки'
            ],

            // Trading Management - Edit Page
            'admin.trading.edit_trade' => [
                'tr' => 'İşlem Düzenle',
                'ru' => 'Редактировать Сделку'
            ],
            'admin.trading.update_trade_information' => [
                'tr' => 'İşlem bilgilerini güncelleyin',
                'ru' => 'Обновите информацию о сделке'
            ],
            'admin.trading.please_fix_errors' => [
                'tr' => 'Lütfen aşağıdaki hataları düzeltin:',
                'ru' => 'Пожалуйста, исправьте следующие ошибки:'
            ],
            'admin.trading.trade_owner_info' => [
                'tr' => 'İşlem Sahibi Bilgileri',
                'ru' => 'Информация о Владельце Сделки'
            ],
            'admin.trading.belongs_to_following_user' => [
                'tr' => 'Bu işlem aşağıdaki kullanıcıya ait',
                'ru' => 'Эта сделка принадлежит следующему пользователю'
            ],
            'admin.trading.full_name' => [
                'tr' => 'Ad Soyad',
                'ru' => 'Полное Имя'
            ],
            'admin.trading.user_not_found' => [
                'tr' => 'Kullanıcı Bulunamadı',
                'ru' => 'Пользователь Не Найден'
            ],
            'admin.trading.not_specified' => [
                'tr' => 'Belirtilmemiş',
                'ru' => 'Не Указано'
            ],
            'admin.trading.created_at' => [
                'tr' => 'Oluşturulma',
                'ru' => 'Создано'
            ],
            'admin.trading.edit_trade_information' => [
                'tr' => 'İşlem Bilgilerini Düzenle',
                'ru' => 'Редактировать Информацию о Сделке'
            ],
            'admin.trading.you_can_update_fields_below' => [
                'tr' => 'Aşağıdaki alanları güncelleyebilirsiniz',
                'ru' => 'Вы можете обновить поля ниже'
            ],
            'admin.trading.asset_example' => [
                'tr' => 'Örn: BTC, ETH, USD',
                'ru' => 'Пример: BTC, ETH, USD'
            ],
            'admin.trading.symbol_example' => [
                'tr' => 'Örn: BTC/USD, ETH/EUR',
                'ru' => 'Пример: BTC/USD, ETH/EUR'
            ],
            'admin.trading.trade_type' => [
                'tr' => 'İşlem Türü',
                'ru' => 'Тип Сделки'
            ],
            'admin.trading.select_type' => [
                'tr' => 'Tür Seçin',
                'ru' => 'Выберите Тип'
            ],
            'admin.trading.leverage_example' => [
                'tr' => 'Örn: 10',
                'ru' => 'Пример: 10'
            ],
            'admin.trading.leave_empty_if_no_leverage' => [
                'tr' => 'Kaldıraç kullanmıyorsanız boş bırakın',
                'ru' => 'Оставьте пустым, если не используете кредитное плечо'
            ],
            'admin.trading.positive_for_profit_negative_for_loss' => [
                'tr' => 'Kar için pozitif, zarar için negatif değer girin',
                'ru' => 'Введите положительное значение для прибыли, отрицательное для убытка'
            ],
            'admin.trading.expiry_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата Истечения'
            ],
            'admin.trading.quick_actions' => [
                'tr' => 'Hızlı İşlemler',
                'ru' => 'Быстрые Действия'
            ],
            'admin.trading.perform_additional_actions' => [
                'tr' => 'İşlem için ek eylemler gerçekleştirin',
                'ru' => 'Выполните дополнительные действия для сделки'
            ],
            'admin.trading.add_profit_loss_to_user_roi' => [
                'tr' => 'Kullanıcı ROI\'sine Kar/Zarar Ekle',
                'ru' => 'Добавить Прибыль/Убыток к ROI Пользователя'
            ],
            'admin.trading.delete_this_trade' => [
                'tr' => 'Bu İşlemi Sil',
                'ru' => 'Удалить Эту Сделку'
            ],
            'admin.trading.profit_loss_info' => [
                'tr' => 'Bu miktar hem işlemin kar/zarar bilgisine hem de kullanıcının ROI\'sine eklenecektir.',
                'ru' => 'Эта сумма будет добавлена как к информации о прибыли/убытке сделки, так и к ROI пользователя.'
            ],
            'admin.trading.enter_amount_to_add' => [
                'tr' => 'Eklenecek miktarı girin',
                'ru' => 'Введите сумму для добавления'
            ],
            'admin.trading.add_note_about_adjustment' => [
                'tr' => 'Bu kar/zarar düzenlemesi hakkında not ekleyin...',
                'ru' => 'Добавьте примечание об этой корректировке прибыли/убытка...'
            ],
            'admin.trading.delete_trade' => [
                'tr' => 'İşlemi Sil',
                'ru' => 'Удалить Сделку'
            ],
            'admin.trading.this_action_irreversible' => [
                'tr' => 'Bu işlem geri alınamaz',
                'ru' => 'Это действие необратимо'
            ],
            'admin.trading.confirm_delete_trade_message' => [
                'tr' => 'Bu işlemi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz ve tüm veriler kalıcı olarak silinecektir.',
                'ru' => 'Вы уверены, что хотите удалить эту сделку? Это действие необратимо и все данные будут удалены навсегда.'
            ],
            'admin.trading.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, Удалить'
            ],
            'admin.trading.deleting' => [
                'tr' => 'Siliniyor',
                'ru' => 'Удаление'
            ],
        ];

        foreach ($phrases as $key => $translations) {
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            foreach ($translations as $locale => $translation) {
                $languageId = $locale === 'tr' ? 1 : 2; // tr = 1, ru = 2
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId,
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('Trading management blade phrases created successfully!');
    }
}