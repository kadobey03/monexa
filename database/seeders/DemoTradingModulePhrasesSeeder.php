<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class DemoTradingModulePhrasesSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $phrases = [
                // Demo Trading Index Page
                'admin.demo.management' => [
                    'tr' => 'Demo Trading Yönetimi',
                    'ru' => 'Управление демо торговлей'
                ],
                'admin.demo.management_description' => [
                    'tr' => 'Demo trading hesaplarını ve işlemlerini yönetin',
                    'ru' => 'Управляйте демо торговыми счетами и сделками'
                ],
                'admin.demo.new_account' => [
                    'tr' => 'Yeni Demo Hesabı',
                    'ru' => 'Новый демо счет'
                ],
                'admin.demo.active_accounts' => [
                    'tr' => 'Aktif Demo Hesapları',
                    'ru' => 'Активные демо счета'
                ],
                'admin.demo.total_trades' => [
                    'tr' => 'Toplam İşlem',
                    'ru' => 'Всего сделок'
                ],
                'admin.demo.demo_balance' => [
                    'tr' => 'Demo Bakiye',
                    'ru' => 'Демо баланс'
                ],
                'admin.demo.active_trades' => [
                    'tr' => 'Aktif İşlemler',
                    'ru' => 'Активные сделки'
                ],
                'admin.demo.accounts' => [
                    'tr' => 'Demo Trading Hesapları',
                    'ru' => 'Демо торговые счета'
                ],
                'admin.demo.search_accounts' => [
                    'tr' => 'Hesap ara...',
                    'ru' => 'Поиск аккаунта...'
                ],
                'admin.demo.user' => [
                    'tr' => 'Kullanıcı',
                    'ru' => 'Пользователь'
                ],
                'admin.demo.open_trades' => [
                    'tr' => 'Açık İşlemler',
                    'ru' => 'Открытые сделки'
                ],
                'admin.demo.last_activity' => [
                    'tr' => 'Son Aktivite',
                    'ru' => 'Последняя активность'
                ],
                'admin.demo.status' => [
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                'admin.demo.actions' => [
                    'tr' => 'İşlemler',
                    'ru' => 'Действия'
                ],
                'admin.demo.no_accounts_yet' => [
                    'tr' => 'Henüz demo hesabı yok',
                    'ru' => 'Пока нет демо счетов'
                ],
                'admin.demo.accounts_will_display' => [
                    'tr' => 'Demo trading hesapları burada görüntülenecek',
                    'ru' => 'Демо торговые счета будут отображаться здесь'
                ],
                'admin.demo.create_first_account' => [
                    'tr' => 'İlk demo hesabını oluştur',
                    'ru' => 'Создать первый демо счет'
                ],

                // Demo Users Management
                'admin.demo.user_management' => [
                    'tr' => 'Demo Kullanıcı Yönetimi',
                    'ru' => 'Управление демо пользователями'
                ],
                'admin.demo.manage_and_control' => [
                    'tr' => 'Demo hesaplarını yönet ve kontrol et',
                    'ru' => 'Управляйте и контролируйте демо счета'
                ],
                'admin.demo.bulk_reset' => [
                    'tr' => 'Toplu Sıfırla',
                    'ru' => 'Массовый сброс'
                ],
                'admin.demo.demo_trades' => [
                    'tr' => 'Demo İşlemler',
                    'ru' => 'Демо сделки'
                ],
                'admin.demo.total_demo_users' => [
                    'tr' => 'Toplam Demo Kullanıcı',
                    'ru' => 'Всего демо пользователей'
                ],
                'admin.demo.active_demo_trades' => [
                    'tr' => 'Aktif Demo İşlem',
                    'ru' => 'Активные демо сделки'
                ],
                'admin.demo.avg_demo_balance' => [
                    'tr' => 'Ort. Demo Bakiye',
                    'ru' => 'Средний демо баланс'
                ],
                'admin.demo.total_demo_volume' => [
                    'tr' => 'Toplam Demo Hacim',
                    'ru' => 'Общий демо объем'
                ],
                'admin.demo.search_users' => [
                    'tr' => 'Demo Kullanıcı Ara',
                    'ru' => 'Поиск демо пользователей'
                ],
                'admin.demo.search_placeholder' => [
                    'tr' => 'İsim, e-posta veya kullanıcı adına göre arama yapın',
                    'ru' => 'Поиск по имени, email или имени пользователя'
                ],
                'admin.demo.search' => [
                    'tr' => 'Ara',
                    'ru' => 'Поиск'
                ],
                'admin.demo.clear' => [
                    'tr' => 'Temizle',
                    'ru' => 'Очистить'
                ],
                'admin.demo.users' => [
                    'tr' => 'Demo Kullanıcılar',
                    'ru' => 'Демо пользователи'
                ],
                'admin.demo.user_id' => [
                    'tr' => 'ID',
                    'ru' => 'ID'
                ],
                'admin.demo.username' => [
                    'tr' => 'Kullanıcı Adı',
                    'ru' => 'Имя пользователя'
                ],
                'admin.demo.email' => [
                    'tr' => 'E-posta',
                    'ru' => 'Email'
                ],
                'admin.demo.demo_mode' => [
                    'tr' => 'Demo Mod',
                    'ru' => 'Демо режим'
                ],
                'admin.demo.account_balance' => [
                    'tr' => 'Hesap Bakiyesi',
                    'ru' => 'Баланс счета'
                ],
                'admin.demo.registration_date' => [
                    'tr' => 'Kayıt Tarihi',
                    'ru' => 'Дата регистрации'
                ],
                'admin.demo.active' => [
                    'tr' => 'Aktif',
                    'ru' => 'Активен'
                ],
                'admin.demo.passive' => [
                    'tr' => 'Pasif',
                    'ru' => 'Неактивен'
                ],
                'admin.demo.edit' => [
                    'tr' => 'Düzenle',
                    'ru' => 'Редактировать'
                ],
                'admin.demo.reset' => [
                    'tr' => 'Sıfırla',
                    'ru' => 'Сбросить'
                ],
                'admin.demo.no_users_found' => [
                    'tr' => 'Kullanıcı bulunamadı',
                    'ru' => 'Пользователи не найдены'
                ],
                'admin.demo.no_matching_users' => [
                    'tr' => 'Mevcut arama kriterlerinizle eşleşen kullanıcı yok.',
                    'ru' => 'Нет пользователей, соответствующих критериям поиска.'
                ],
                'admin.demo.edit_balance' => [
                    'tr' => 'Demo Bakiye Düzenle',
                    'ru' => 'Редактировать демо баланс'
                ],
                'admin.demo.current_balance' => [
                    'tr' => 'Mevcut Demo Bakiye',
                    'ru' => 'Текущий демо баланс'
                ],
                'admin.demo.operation' => [
                    'tr' => 'İşlem',
                    'ru' => 'Операция'
                ],
                'admin.demo.set_balance' => [
                    'tr' => 'Bakiyeyi Ayarla',
                    'ru' => 'Установить баланс'
                ],
                'admin.demo.add_amount' => [
                    'tr' => 'Miktar Ekle',
                    'ru' => 'Добавить сумму'
                ],
                'admin.demo.subtract_amount' => [
                    'tr' => 'Miktar Çıkar',
                    'ru' => 'Вычесть сумму'
                ],
                'admin.demo.amount' => [
                    'tr' => 'Miktar',
                    'ru' => 'Сумма'
                ],
                'admin.demo.update' => [
                    'tr' => 'Güncelle',
                    'ru' => 'Обновить'
                ],
                'admin.demo.cancel' => [
                    'tr' => 'İptal',
                    'ru' => 'Отмена'
                ],

                // Demo Trades Management
                'admin.demo.trades_management' => [
                    'tr' => 'Demo Trades Management',
                    'ru' => 'Управление демо сделками'
                ],
                'admin.demo.manage_users' => [
                    'tr' => 'Manage Demo Users',
                    'ru' => 'Управление демо пользователями'
                ],
                'admin.demo.total_demo_trades' => [
                    'tr' => 'Total Demo Trades',
                    'ru' => 'Всего демо сделок'
                ],
                'admin.demo.filter_trades' => [
                    'tr' => 'Filter Demo Trades',
                    'ru' => 'Фильтр демо сделок'
                ],
                'admin.demo.all_status' => [
                    'tr' => 'All Status',
                    'ru' => 'Все статусы'
                ],
                'admin.demo.closed' => [
                    'tr' => 'Closed',
                    'ru' => 'Закрыт'
                ],
                'admin.demo.all_types' => [
                    'tr' => 'All Types',
                    'ru' => 'Все типы'
                ],
                'admin.demo.buy' => [
                    'tr' => 'Buy',
                    'ru' => 'Покупка'
                ],
                'admin.demo.sell' => [
                    'tr' => 'Sell',
                    'ru' => 'Продажа'
                ],
                'admin.demo.asset' => [
                    'tr' => 'Asset',
                    'ru' => 'Актив'
                ],
                'admin.demo.filter' => [
                    'tr' => 'Filter',
                    'ru' => 'Фильтр'
                ],
                'admin.demo.trade_id' => [
                    'tr' => 'Trade ID',
                    'ru' => 'ID сделки'
                ],
                'admin.demo.user_name' => [
                    'tr' => 'User Name',
                    'ru' => 'Имя пользователя'
                ],
                'admin.demo.user_email' => [
                    'tr' => 'User Email',
                    'ru' => 'Email пользователя'
                ],
                'admin.demo.type' => [
                    'tr' => 'Type',
                    'ru' => 'Тип'
                ],
                'admin.demo.leverage' => [
                    'tr' => 'Leverage',
                    'ru' => 'Кредитное плечо'
                ],
                'admin.demo.entry_price' => [
                    'tr' => 'Entry Price',
                    'ru' => 'Цена входа'
                ],
                'admin.demo.current_pnl' => [
                    'tr' => 'Current P&L',
                    'ru' => 'Текущий P&L'
                ],
                'admin.demo.date_created' => [
                    'tr' => 'Date Created',
                    'ru' => 'Дата создания'
                ],
                'admin.demo.option' => [
                    'tr' => 'Option',
                    'ru' => 'Опция'
                ],
                'admin.demo.user_not_found' => [
                    'tr' => 'Kullanıcı Bulunamadı',
                    'ru' => 'Пользователь не найден'
                ],
                'admin.demo.not_specified' => [
                    'tr' => 'Belirtilmemiş',
                    'ru' => 'Не указано'
                ],
                'admin.demo.close' => [
                    'tr' => 'Close',
                    'ru' => 'Закрыть'
                ],
                'admin.demo.view_user' => [
                    'tr' => 'View User',
                    'ru' => 'Просмотр пользователя'
                ],
                'admin.demo.no_trades_found' => [
                    'tr' => 'No demo trades found',
                    'ru' => 'Демо сделки не найдены'
                ],
                'admin.demo.no_trading_activity' => [
                    'tr' => 'No demo trading activity matches your current filters.',
                    'ru' => 'Нет демо торговой активности, соответствующей текущим фильтрам.'
                ],
                'admin.demo.total_volume' => [
                    'tr' => 'Total Volume',
                    'ru' => 'Общий объем'
                ],
                'admin.demo.profitable_trades' => [
                    'tr' => 'Profitable Trades',
                    'ru' => 'Прибыльные сделки'
                ],

                // Common fields and confirmations
                'admin.demo.confirm_bulk_reset' => [
                    'tr' => 'Tüm demo hesapları sıfırlamak istediğinizden emin misiniz? Bu işlem tüm kullanıcıları etkileyecek.',
                    'ru' => 'Вы уверены, что хотите сбросить все демо счета? Это действие затронет всех пользователей.'
                ],
                'admin.demo.confirm_user_reset' => [
                    'tr' => 'Bu kullanıcının demo hesabını sıfırlamak istediğinizden emin misiniz?',
                    'ru' => 'Вы уверены, что хотите сбросить демо счет этого пользователя?'
                ],
                'admin.demo.confirm_close_trade' => [
                    'tr' => 'Are you sure you want to close this demo trade?',
                    'ru' => 'Вы уверены, что хотите закрыть эту демо сделку?'
                ],
                'admin.demo.edit_balance_tooltip' => [
                    'tr' => 'Demo Bakiye Düzenle',
                    'ru' => 'Редактировать демо баланс'
                ],
                'admin.demo.reset_account_tooltip' => [
                    'tr' => 'Demo Hesap Sıfırla',
                    'ru' => 'Сбросить демо счет'
                ],
                'admin.demo.close_trade_tooltip' => [
                    'tr' => 'Close Trade',
                    'ru' => 'Закрыть сделку'
                ],
                'admin.demo.view_user_tooltip' => [
                    'tr' => 'View User',
                    'ru' => 'Просмотр пользователя'
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