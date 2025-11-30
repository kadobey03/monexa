<?php

namespace Database\Seeders;

use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Database\Seeder;

class BotTradingBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Bot Trading - General
            'admin.bots.bot_trading' => [
                'tr' => 'Bot Trading',
                'ru' => 'Бот-Трейдинг'
            ],
            'admin.bots.trading_bot' => [
                'tr' => 'Trading Bot',
                'ru' => 'Торговый Бот'
            ],
            'admin.bots.management' => [
                'tr' => 'Bot Yönetimi',
                'ru' => 'Управление Ботами'
            ],
            'admin.bots.analytics' => [
                'tr' => 'Bot Analitiği',
                'ru' => 'Аналитика Ботов'
            ],

            // Bot Trading - Statistics & Metrics
            'admin.bots.total_bots' => [
                'tr' => 'Toplam Bot',
                'ru' => 'Всего Ботов'
            ],
            'admin.bots.active_bots' => [
                'tr' => 'Aktif Botlar',
                'ru' => 'Активные Боты'
            ],
            'admin.bots.total_investments' => [
                'tr' => 'Toplam Yatırım',
                'ru' => 'Общие Инвестиции'
            ],
            'admin.bots.total_profits' => [
                'tr' => 'Toplam Kar',
                'ru' => 'Общая Прибыль'
            ],
            'admin.bots.active_investments' => [
                'tr' => 'Aktif Yatırımlar',
                'ru' => 'Активные Инвестиции'
            ],
            'admin.bots.completed_investments' => [
                'tr' => 'Tamamlanan Yatırımlar',
                'ru' => 'Завершенные Инвестиции'
            ],
            'admin.bots.daily_profits_last_30_days' => [
                'tr' => 'Günlük Kar (Son 30 Gün)',
                'ru' => 'Ежедневная Прибыль (Последние 30 Дней)'
            ],
            'admin.bots.daily_profits_usd' => [
                'tr' => 'Günlük Kar ($)',
                'ru' => 'Ежедневная Прибыль ($)'
            ],
            'admin.bots.top_performing_bots' => [
                'tr' => 'En İyi Performans Gösteren Botlar',
                'ru' => 'Лучшие Боты'
            ],

            // Bot Trading - Basic Fields
            'admin.bots.bot' => [
                'tr' => 'Bot',
                'ru' => 'Бот'
            ],
            'admin.bots.bot_name' => [
                'tr' => 'Bot Adı',
                'ru' => 'Имя Бота'
            ],
            'admin.bots.market' => [
                'tr' => 'Piyasa',
                'ru' => 'Рынок'
            ],
            'admin.bots.market_type' => [
                'tr' => 'Piyasa Türü',
                'ru' => 'Тип Рынка'
            ],
            'admin.bots.trading_market' => [
                'tr' => 'Trading Piyasası',
                'ru' => 'Торговый Рынок'
            ],
            'admin.bots.description' => [
                'tr' => 'Açıklama',
                'ru' => 'Описание'
            ],
            'admin.bots.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.bots.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный'
            ],
            'admin.bots.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивный'
            ],
            'admin.bots.maintenance' => [
                'tr' => 'Bakım',
                'ru' => 'Техническое Обслуживание'
            ],

            // Bot Trading - Investment & Performance
            'admin.bots.investment_range' => [
                'tr' => 'Yatırım Aralığı',
                'ru' => 'Диапазон Инвестиций'
            ],
            'admin.bots.minimum_investment_usd' => [
                'tr' => 'Minimum Yatırım ($)',
                'ru' => 'Минимальная Инвестиция ($)'
            ],
            'admin.bots.maximum_investment_usd' => [
                'tr' => 'Maksimum Yatırım ($)',
                'ru' => 'Максимальная Инвестиция ($)'
            ],
            'admin.bots.min_investment' => [
                'tr' => 'Min Yatırım',
                'ru' => 'Мин Инвестиция'
            ],
            'admin.bots.max_investment' => [
                'tr' => 'Max Yatırım',
                'ru' => 'Макс Инвестиция'
            ],
            'admin.bots.success_rate' => [
                'tr' => 'Başarı Oranı',
                'ru' => 'Процент Успеха'
            ],
            'admin.bots.success_rate_percent' => [
                'tr' => 'Başarı Oranı (%)',
                'ru' => 'Процент Успеха (%)'
            ],
            'admin.bots.investors' => [
                'tr' => 'Yatırımcılar',
                'ru' => 'Инвесторы'
            ],

            // Bot Trading - Profit & Loss
            'admin.bots.profit' => [
                'tr' => 'Kar',
                'ru' => 'Прибыль'
            ],
            'admin.bots.loss' => [
                'tr' => 'Zarar',
                'ru' => 'Убыток'
            ],
            'admin.bots.profit_loss' => [
                'tr' => 'Kar/Zarar',
                'ru' => 'Прибыль/Убыток'
            ],
            'admin.bots.profit_range' => [
                'tr' => 'Kar Aralığı',
                'ru' => 'Диапазон Прибыли'
            ],
            'admin.bots.daily_profit_min_percent' => [
                'tr' => 'Günlük Kar Min (%)',
                'ru' => 'Ежедневная Прибыль Мин (%)'
            ],
            'admin.bots.daily_profit_max_percent' => [
                'tr' => 'Günlük Kar Max (%)',
                'ru' => 'Ежедневная Прибыль Макс (%)'
            ],
            'admin.bots.daily_profit_min' => [
                'tr' => 'Günlük Kar Min',
                'ru' => 'Ежедневная Прибыль Мин'
            ],
            'admin.bots.daily_profit_max' => [
                'tr' => 'Günlük Kar Max',
                'ru' => 'Ежедневная Прибыль Макс'
            ],
            'admin.bots.total_earned' => [
                'tr' => 'Toplam Kazanç',
                'ru' => 'Общий Заработок'
            ],

            // Bot Trading - Time & Duration
            'admin.bots.duration' => [
                'tr' => 'Süre',
                'ru' => 'Продолжительность'
            ],
            'admin.bots.duration_days' => [
                'tr' => 'Süre (Gün)',
                'ru' => 'Продолжительность (Дни)'
            ],
            'admin.bots.days' => [
                'tr' => 'gün',
                'ru' => 'дней'
            ],
            'admin.bots.last_trade' => [
                'tr' => 'Son İşlem',
                'ru' => 'Последняя Сделка'
            ],
            'admin.bots.never' => [
                'tr' => 'Hiçbir zaman',
                'ru' => 'Никогда'
            ],
            'admin.bots.created' => [
                'tr' => 'Oluşturulma',
                'ru' => 'Создано'
            ],
            'admin.bots.updated' => [
                'tr' => 'Güncellenme',
                'ru' => 'Обновлено'
            ],
            'admin.bots.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],

            // Bot Trading - Actions & Operations
            'admin.bots.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.bots.create_bot' => [
                'tr' => 'Bot Oluştur',
                'ru' => 'Создать Бот'
            ],
            'admin.bots.create_trading_bot' => [
                'tr' => 'Trading Bot Oluştur',
                'ru' => 'Создать Торговый Бот'
            ],
            'admin.bots.create_new_trading_bot' => [
                'tr' => 'Yeni Trading Bot Oluştur',
                'ru' => 'Создать Новый Торговый Бот'
            ],
            'admin.bots.add_new_bot' => [
                'tr' => 'Yeni Bot Ekle',
                'ru' => 'Добавить Новый Бот'
            ],
            'admin.bots.edit_trading_bot' => [
                'tr' => 'Trading Bot Düzenle',
                'ru' => 'Редактировать Торговый Бот'
            ],
            'admin.bots.edit_bot' => [
                'tr' => 'Bot Düzenle',
                'ru' => 'Редактировать Бот'
            ],
            'admin.bots.edit_bot_name' => [
                'tr' => ':name Düzenle',
                'ru' => 'Редактировать :name'
            ],
            'admin.bots.update_bot' => [
                'tr' => 'Bot Güncelle',
                'ru' => 'Обновить Бот'
            ],
            'admin.bots.delete_bot' => [
                'tr' => 'Bot Sil',
                'ru' => 'Удалить Бот'
            ],
            'admin.bots.view_details' => [
                'tr' => 'Detayları Görüntüle',
                'ru' => 'Просмотреть Детали'
            ],

            // Bot Trading - Configuration & Settings
            'admin.bots.configuration' => [
                'tr' => 'Bot Konfigürasyonu',
                'ru' => 'Конфигурация Бота'
            ],
            'admin.bots.performance_statistics' => [
                'tr' => 'Bot Performans İstatistikleri',
                'ru' => 'Статистика Производительности Бота'
            ],
            'admin.bots.trading_pairs' => [
                'tr' => 'Trading Çiftleri',
                'ru' => 'Торговые Пары'
            ],
            'admin.bots.trading_pairs_example' => [
                'tr' => 'Örn: EUR/USD, BTC/USD',
                'ru' => 'Пример: EUR/USD, BTC/USD'
            ],
            'admin.bots.add_pair' => [
                'tr' => 'Çift Ekle',
                'ru' => 'Добавить Пару'
            ],
            'admin.bots.add_trading_pairs_description' => [
                'tr' => 'Bu botun işlem yapacağı trading çiftlerini ekleyin',
                'ru' => 'Добавьте торговые пары для этого бота'
            ],
            'admin.bots.remove' => [
                'tr' => 'Kaldır',
                'ru' => 'Удалить'
            ],

            // Bot Trading - Image & Avatar
            'admin.bots.bot_avatar_optional' => [
                'tr' => 'Bot Avatarı (İsteğe bağlı)',
                'ru' => 'Аватар Бота (Необязательно)'
            ],
            'admin.bots.upload_image_max_2mb' => [
                'tr' => 'Bot için resim yükleyin (max 2MB)',
                'ru' => 'Загрузите изображение для бота (макс 2МБ)'
            ],
            'admin.bots.upload_new_image_max_2mb' => [
                'tr' => 'Mevcut resmi değiştirmek için yeni resim yükleyin (max 2MB)',
                'ru' => 'Загрузите новое изображение для замены текущего (макс 2МБ)'
            ],
            'admin.bots.current_bot_image' => [
                'tr' => 'Mevcut Bot Resmi',
                'ru' => 'Текущее Изображение Бота'
            ],

            // Bot Trading - Form Fields
            'admin.bots.enter_bot_name' => [
                'tr' => 'Bot adını girin',
                'ru' => 'Введите имя бота'
            ],
            'admin.bots.enter_bot_description' => [
                'tr' => 'Bot açıklamasını girin',
                'ru' => 'Введите описание бота'
            ],
            'admin.bots.select_market' => [
                'tr' => 'Piyasa Seçin',
                'ru' => 'Выберите Рынок'
            ],

            // Bot Trading - Trading Activity
            'admin.bots.trading_bots' => [
                'tr' => 'Trading Botları',
                'ru' => 'Торговые Боты'
            ],
            'admin.bots.recent_trading_activity' => [
                'tr' => 'Son Trading Aktivitesi',
                'ru' => 'Недавняя Торговая Активность'
            ],
            'admin.bots.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.bots.investment' => [
                'tr' => 'Yatırım',
                'ru' => 'Инвестиция'
            ],
            'admin.bots.pair' => [
                'tr' => 'Çift',
                'ru' => 'Пара'
            ],
            'admin.bots.result' => [
                'tr' => 'Sonuç',
                'ru' => 'Результат'
            ],
            'admin.bots.total_users' => [
                'tr' => 'Toplam Kullanıcı',
                'ru' => 'Всего Пользователей'
            ],

            // Bot Trading - Bulk Operations
            'admin.bots.generate_20_trades_per_bot' => [
                'tr' => 'Her Bot İçin 20 İşlem Oluştur',
                'ru' => 'Сгенерировать 20 Сделок на Бот'
            ],
            'admin.bots.generate_bulk_trades' => [
                'tr' => 'Toplu İşlem Oluştur',
                'ru' => 'Сгенерировать Массовые Сделки'
            ],
            'admin.bots.bulk_trades_confirmation' => [
                'tr' => 'Bu işlem her aktif bot yatırımı için 20 işlem oluşturacaktır. Emin misiniz?',
                'ru' => 'Это создаст 20 сделок для каждой активной инвестиции в бот. Вы уверены?'
            ],
            'admin.bots.yes_generate_trades' => [
                'tr' => 'Evet, İşlemleri Oluştur!',
                'ru' => 'Да, Сгенерировать Сделки!'
            ],
            'admin.bots.generating_trades' => [
                'tr' => 'İşlemler Oluşturuluyor',
                'ru' => 'Генерация Сделок'
            ],
            'admin.bots.generated_trades_success' => [
                'tr' => ':investments bot yatırımında :trades işlem oluşturuldu',
                'ru' => 'Создано :trades сделок для :investments инвестиций в боты'
            ],

            // Bot Trading - Messages & Alerts
            'admin.bots.no_trading_bots_found' => [
                'tr' => 'Hiç trading botu bulunamadı',
                'ru' => 'Торговые боты не найдены'
            ],
            'admin.bots.create_first_trading_bot' => [
                'tr' => 'Başlamak için ilk trading botunuzu oluşturun',
                'ru' => 'Создайте свой первый торговый бот, чтобы начать'
            ],
            'admin.bots.are_you_sure' => [
                'tr' => 'Emin misiniz?',
                'ru' => 'Вы уверены?'
            ],
            'admin.bots.delete_bot_confirmation' => [
                'tr' => 'Bu işlem trading botunu ve tüm ilişkili verileri kalıcı olarak silecektir!',
                'ru' => 'Это навсегда удалит торговый бот и все связанные данные!'
            ],
            'admin.bots.yes_delete' => [
                'tr' => 'Evet, sil!',
                'ru' => 'Да, удалить!'
            ],
            'admin.bots.success' => [
                'tr' => 'Başarılı',
                'ru' => 'Успешно'
            ],
            'admin.bots.error' => [
                'tr' => 'Hata',
                'ru' => 'Ошибка'
            ],
            'admin.bots.failed_to_generate_trades' => [
                'tr' => 'İşlemler oluşturulamadı',
                'ru' => 'Не удалось сгенерировать сделки'
            ],
            'admin.bots.network_error' => [
                'tr' => 'İşlemler oluşturulurken ağ hatası oluştu',
                'ru' => 'Произошла сетевая ошибка при генерации сделок'
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

        $this->command->info('Bot Trading blade phrases created successfully!');
    }
}