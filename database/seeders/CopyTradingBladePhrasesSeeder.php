<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class CopyTradingBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Copy Trading Ana Terimleri
            'admin.copy.copy_trading' => [
                'tr' => 'Kopya Ticaret',
                'ru' => 'Копи-трейдинг',
            ],
            'admin.copy.active_trades' => [
                'tr' => 'Aktif İşlemler',
                'ru' => 'Активные сделки',
            ],
            'admin.copy.statistics' => [
                'tr' => 'İstatistikler',
                'ru' => 'Статистика',
            ],
            'admin.copy.manage_expert_traders_system' => [
                'tr' => 'Uzman yatırımcıları ve kopya ticaret sistemini yönetin',
                'ru' => 'Управление экспертными трейдерами и системой копи-трейдинга',
            ],
            'admin.copy.add_expert' => [
                'tr' => 'Uzman Ekle',
                'ru' => 'Добавить эксперта',
            ],
            'admin.copy.back_to_list' => [
                'tr' => 'Listeye Dön',
                'ru' => 'Вернуться к списку',
            ],

            // Expert Trader Bilgileri
            'admin.copy.expert_traders' => [
                'tr' => 'Uzman Yatırımcılar',
                'ru' => 'Экспертные трейдеры',
            ],
            'admin.copy.manage_all_expert_traders' => [
                'tr' => 'Sistemdeki tüm uzman yatırımcıları yönetin',
                'ru' => 'Управление всеми экспертными трейдерами в системе',
            ],
            'admin.copy.expert_trader_information' => [
                'tr' => 'Uzman Yatırımcı Bilgileri',
                'ru' => 'Информация об экспертном трейдере',
            ],
            'admin.copy.expert' => [
                'tr' => 'Uzman',
                'ru' => 'Эксперт',
            ],
            'admin.copy.expert_name' => [
                'tr' => 'Uzman Adı',
                'ru' => 'Имя эксперта',
            ],
            'admin.copy.expert_tag' => [
                'tr' => 'Uzman Etiketi',
                'ru' => 'Тег эксперта',
            ],

            // Performance ve İstatistikler
            'admin.copy.performance' => [
                'tr' => 'Performans',
                'ru' => 'Производительность',
            ],
            'admin.copy.followers' => [
                'tr' => 'Takipçiler',
                'ru' => 'Подписчики',
            ],
            'admin.copy.total_followers' => [
                'tr' => 'toplam takipçi',
                'ru' => 'всего подписчиков',
            ],
            'admin.copy.active_copiers' => [
                'tr' => 'aktif kopyacı',
                'ru' => 'активные копировщики',
            ],
            'admin.copy.win_rate' => [
                'tr' => 'Kazanma Oranı',
                'ru' => 'Доходность',
            ],
            'admin.copy.profit' => [
                'tr' => 'Kar',
                'ru' => 'Прибыль',
            ],
            'admin.copy.trades' => [
                'tr' => 'işlem',
                'ru' => 'сделок',
            ],
            'admin.copy.equity' => [
                'tr' => 'özkaynak',
                'ru' => 'собственный капитал',
            ],
            'admin.copy.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего',
            ],

            // Positions ve Activity
            'admin.copy.active_positions' => [
                'tr' => 'Aktif Pozisyonlar',
                'ru' => 'Активные позиции',
            ],
            'admin.copy.position' => [
                'tr' => 'Pozisyon',
                'ru' => 'Позиция',
            ],
            'admin.copy.copier' => [
                'tr' => 'Kopyacı',
                'ru' => 'Копировщик',
            ],
            'admin.copy.amount' => [
                'tr' => 'Miktar',
                'ru' => 'Сумма',
            ],
            'admin.copy.investment_amount' => [
                'tr' => 'Yatırım Miktarı',
                'ru' => 'Сумма инвестиций',
            ],
            'admin.copy.current_value' => [
                'tr' => 'Mevcut Değer',
                'ru' => 'Текущая стоимость',
            ],

            // Status ve Actions
            'admin.copy.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус',
            ],
            'admin.copy.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия',
            ],
            'admin.copy.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный',
            ],
            'admin.copy.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивный',
            ],
            'admin.copy.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать',
            ],
            'admin.copy.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить',
            ],
            'admin.copy.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь',
            ],
            'admin.copy.date_created' => [
                'tr' => 'Oluşturma Tarihi',
                'ru' => 'Дата создания',
            ],

            // Form Fields ve Labels
            'admin.copy.trader_name' => [
                'tr' => 'Yatırımcı Adı',
                'ru' => 'Имя трейдера',
            ],
            'admin.copy.enter_expert_trader_name' => [
                'tr' => 'Uzman Yatırımcı Adını Girin',
                'ru' => 'Введите имя экспертного трейдера',
            ],
            'admin.copy.expert_trader_tag' => [
                'tr' => 'Uzman Yatırımcı Etiketi (MID/PRO)',
                'ru' => 'Тег экспертного трейдера (MID/PRO)',
            ],
            'admin.copy.enter_expert_trader_tag' => [
                'tr' => 'Uzman Yatırımcı Etiketini Girin',
                'ru' => 'Введите тег экспертного трейдера',
            ],
            'admin.copy.expert_trader_followers' => [
                'tr' => 'Uzman Yatırımcı Takipçi Sayısı',
                'ru' => 'Количество подписчиков экспертного трейдера',
            ],
            'admin.copy.enter_expert_followers' => [
                'tr' => 'Uzman Takipçi Sayısını Girin',
                'ru' => 'Введите количество подписчиков эксперта',
            ],
            'admin.copy.followers_description' => [
                'tr' => 'Bu, şu anda uzmanla işlem yapan takipçi sayısıdır',
                'ru' => 'Это количество подписчиков, которые в настоящее время торгуют с экспертом',
            ],

            // Min Investment ve Amounts
            'admin.copy.min_investment' => [
                'tr' => 'Min Yatırım',
                'ru' => 'Мин. инвестиции',
            ],
            'admin.copy.startup_amount' => [
                'tr' => 'Başlangıç Miktarı',
                'ru' => 'Стартовая сумма',
            ],
            'admin.copy.startup_amount_description' => [
                'tr' => 'Bu, bu Kopya Ticaretin fiyatıdır',
                'ru' => 'Это цена данного копи-трейдинга',
            ],
            'admin.copy.enter_expert_total_profit' => [
                'tr' => 'Uzman Toplam Karını Girin',
                'ru' => 'Введите общую прибыль эксперта',
            ],
            'admin.copy.total_profit_description' => [
                'tr' => 'Bu, bu uzman yatırımcı tarafından elde edilen toplam kardır',
                'ru' => 'Это общая прибыль, полученная данным экспертным трейдером',
            ],

            // Copy Trade Types
            'admin.copy.copy_trade_type' => [
                'tr' => 'Kopya Ticaret Türü (Kopyala/Satın Al)',
                'ru' => 'Тип копи-трейдинга (Копировать/Купить)',
            ],
            'admin.copy.copy' => [
                'tr' => 'Kopyala',
                'ru' => 'Копировать',
            ],
            'admin.copy.buy' => [
                'tr' => 'Satın Al',
                'ru' => 'Купить',
            ],

            // Active Days ve Time
            'admin.copy.expert_trader_active_days' => [
                'tr' => 'Uzman Yatırımcı Aktif Günleri',
                'ru' => 'Активные дни экспертного трейдера',
            ],
            'admin.copy.enter_active_days' => [
                'tr' => 'Aktif Günleri Girin',
                'ru' => 'Введите активные дни',
            ],
            'admin.copy.active_days_description' => [
                'tr' => 'Bu, yatırımcının mevcut olacağı beklenen gün sayısıdır',
                'ru' => 'Это ожидаемое количество дней, когда трейдер будет доступен',
            ],
            'admin.copy.active_days' => [
                'tr' => 'Aktif Günler',
                'ru' => 'Активные дни',
            ],
            'admin.copy.days' => [
                'tr' => 'Gün',
                'ru' => 'дней',
            ],

            // Equity ve Winning Rate
            'admin.copy.equity_winning_rate' => [
                'tr' => 'Özkaynak (Kazanma oranı)',
                'ru' => 'Капитал (Процент побед)',
            ],
            'admin.copy.enter_expert_equity' => [
                'tr' => 'Uzman Ticaret Özkaynak Girin',
                'ru' => 'Введите капитал экспертной торговли',
            ],
            'admin.copy.equity_description' => [
                'tr' => 'Bu, uzman kazanma oranıdır',
                'ru' => 'Это процент побед эксперта',
            ],

            // Rating System
            'admin.copy.expert_trader_rating' => [
                'tr' => 'Uzman Yatırımcı Puanı',
                'ru' => 'Рейтинг экспертного трейдера',
            ],
            'admin.copy.expert_ratings' => [
                'tr' => 'Uzman puanları',
                'ru' => 'Рейтинги экспертов',
            ],
            'admin.copy.rating_description' => [
                'tr' => 'Bu, uzman yatırımcı puanıdır',
                'ru' => 'Это рейтинг экспертного трейдера',
            ],
            'admin.copy.rating_max_description' => [
                'tr' => 'Bu uzman yatırımcı puanı (Maksimum 5 yıldız)',
                'ru' => 'Этот рейтинг экспертного трейдера (Максимум 5 звезд)',
            ],

            // Photo ve Media
            'admin.copy.expert_trader_photo' => [
                'tr' => 'Uzman Yatırımcı Fotoğrafı',
                'ru' => 'Фото экспертного трейдера',
            ],
            'admin.copy.photo_description' => [
                'tr' => 'Bu uzman yatırımcı fotoğrafıdır',
                'ru' => 'Это фото экспертного трейдера',
            ],

            // Statistics Page Specific
            'admin.copy.overview_performance_metrics' => [
                'tr' => 'Kopya ticaret sistemi performansı ve metriklere genel bakış',
                'ru' => 'Обзор производительности системы копи-трейдинга и метрик',
            ],
            'admin.copy.total_experts' => [
                'tr' => 'Toplam Uzmanlar',
                'ru' => 'Всего экспертов',
            ],
            'admin.copy.total_copiers' => [
                'tr' => 'Toplam Kopyacılar',
                'ru' => 'Всего копировщиков',
            ],
            'admin.copy.currently_active' => [
                'tr' => 'şu anda aktif',
                'ru' => 'в настоящее время активны',
            ],
            'admin.copy.total_volume' => [
                'tr' => 'Toplam Hacim',
                'ru' => 'Общий объем',
            ],
            'admin.copy.active_volume' => [
                'tr' => 'Aktif Hacim',
                'ru' => 'Активный объем',
            ],
            'admin.copy.all_time_copied_amount' => [
                'tr' => 'Tüm zamanların kopyalanan miktarı',
                'ru' => 'Общая скопированная сумма за все время',
            ],
            'admin.copy.currently_being_copied' => [
                'tr' => 'Şu anda kopyalanıyor',
                'ru' => 'В настоящее время копируется',
            ],

            // Top Experts
            'admin.copy.top_performing_experts' => [
                'tr' => 'En İyi Performanslı Uzmanlar',
                'ru' => 'Лучшие эксперты по результативности',
            ],
            'admin.copy.most_popular_experts' => [
                'tr' => 'En Popüler Uzmanlar',
                'ru' => 'Самые популярные эксперты',
            ],
            'admin.copy.based_on_profit_percentage' => [
                'tr' => 'Toplam kar yüzdesine göre',
                'ru' => 'На основе общего процента прибыли',
            ],
            'admin.copy.based_on_active_copiers' => [
                'tr' => 'Aktif kopyacı sayısına göre',
                'ru' => 'На основе количества активных копировщиков',
            ],
            'admin.copy.no_expert_performance_data' => [
                'tr' => 'Uzman performans verisi mevcut değil',
                'ru' => 'Данные о производительности экспертов недоступны',
            ],
            'admin.copy.no_popularity_data' => [
                'tr' => 'Popülerlik verisi mevcut değil',
                'ru' => 'Данные о популярности недоступны',
            ],

            // Recent Activity
            'admin.copy.recent_activity' => [
                'tr' => 'Son Kopya Ticaret Aktivitesi',
                'ru' => 'Недавняя активность копи-трейдинга',
            ],
            'admin.copy.latest_transactions_updates' => [
                'tr' => 'En son kopya ticaret işlemleri ve güncellemeleri',
                'ru' => 'Последние транзакции и обновления копи-трейдинга',
            ],
            'admin.copy.started_copying' => [
                'tr' => 'Kopyalamaya başladı',
                'ru' => 'Начал копировать',
            ],
            'admin.copy.stopped_copying' => [
                'tr' => 'Kopyalamayı durdurdu',
                'ru' => 'Прекратил копировать',
            ],
            'admin.copy.unknown_user' => [
                'tr' => 'Bilinmeyen Kullanıcı',
                'ru' => 'Неизвестный пользователь',
            ],
            'admin.copy.unknown_expert' => [
                'tr' => 'Bilinmeyen Uzman',
                'ru' => 'Неизвестный эксперт',
            ],
            'admin.copy.no_recent_activity' => [
                'tr' => 'Son kopya ticaret aktivitesi yok',
                'ru' => 'Нет недавней активности копи-трейдинга',
            ],

            // Empty States
            'admin.copy.no_expert_traders' => [
                'tr' => 'Uzman Yatırımcı Yok',
                'ru' => 'Нет экспертных трейдеров',
            ],
            'admin.copy.get_started_first_expert' => [
                'tr' => 'Sisteme ilk uzman yatırımcınızı ekleyerek başlayın.',
                'ru' => 'Начните с добавления первого экспертного трейдера в систему.',
            ],
            'admin.copy.add_first_expert' => [
                'tr' => 'İlk Uzmanı Ekle',
                'ru' => 'Добавить первого эксперта',
            ],
            'admin.copy.na' => [
                'tr' => 'Mevcut Değil',
                'ru' => 'Н/Д',
            ],

            // Action Buttons ve Messages
            'admin.copy.cannot_delete_has_copiers' => [
                'tr' => 'Silinemiyor - aktif kopyacıları var',
                'ru' => 'Невозможно удалить - есть активные копировщики',
            ],
            'admin.copy.delete_expert_trader' => [
                'tr' => 'Uzman Yatırımcıyı Sil?',
                'ru' => 'Удалить экспертного трейдера?',
            ],
            'admin.copy.delete_confirmation_message' => [
                'tr' => 'Bu işlem geri alınamaz. Uzman yatırımcı kalıcı olarak kaldırılacaktır.',
                'ru' => 'Это действие нельзя отменить. Экспертный трейдер будет удален навсегда.',
            ],
            'admin.copy.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, удалить',
            ],
            'admin.copy.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена',
            ],

            // Legacy copytrading klasörü phrases
            'admin.copy.active_trade_copying' => [
                'tr' => 'Aktif İşlem Kopyalama',
                'ru' => 'Активное копирование сделок',
            ],
            'admin.copy.system_copy_trading_plans' => [
                'tr' => 'Sistem Kopya Ticaret Planları',
                'ru' => 'Системные планы копи-трейдинга',
            ],
            'admin.copy.new_copy_trading_plans' => [
                'tr' => 'Yeni Kopya Ticaret Planları',
                'ru' => 'Новые планы копи-трейдинга',
            ],
            'admin.copy.copy_trading_price' => [
                'tr' => 'Kopya Ticaret Fiyatı',
                'ru' => 'Цена копи-трейдинга',
            ],
            'admin.copy.expert_total_followers' => [
                'tr' => 'Uzman Toplam Takipçileri',
                'ru' => 'Общее количество подписчиков эксперта',
            ],
            'admin.copy.expert_total_profit' => [
                'tr' => 'Uzman Toplam Karı',
                'ru' => 'Общая прибыль эксперта',
            ],
            'admin.copy.no_copytrading_plan_message' => [
                'tr' => 'Şu anda Kopya ticaret Planı yok, Kopya ticaret eklemek için yukarıdaki düğmeye tıklayın.',
                'ru' => 'На данный момент нет планов копи-трейдинга, нажмите кнопку выше, чтобы добавить копи-трейдинг.',
            ],

            // Add/Update Forms
            'admin.copy.add_copy_trading_plan' => [
                'tr' => 'Kopya Ticaret Planı Ekle',
                'ru' => 'Добавить план копи-трейдинга',
            ],
            'admin.copy.update_copy_trading_plan' => [
                'tr' => 'Kopya Ticaret Planını Güncelle',
                'ru' => 'Обновить план копи-трейдинга',
            ],
            'admin.copy.add_new_copy_trading_plan' => [
                'tr' => 'Yeni Kopya Ticaret Planı Ekle',
                'ru' => 'Добавить новый план копи-трейдинга',
            ],

            // Duration Modal
            'admin.copy.duration_modal_text' => [
                'tr' => 'İLK OLARAK, zaman diliminin önüne her zaman bir rakam koyun, yani sayıyı harflerle yazmayın, <br> <br> İKİNCİ OLARAK, sayıdan sonra her zaman boşluk bırakın, <br> <br> SON OLARAK, zaman diliminin ilk harfi BÜYÜK olmalı ve süreniz sadece bir gün, ay veya yıl olsa bile zaman dilimine her zaman \'s\' ekleyin.',
                'ru' => 'ВО-ПЕРВЫХ, всегда предшествуйте временному интервалу цифрой, то есть не пишите число буквами, <br> <br> ВО-ВТОРЫХ, всегда добавляйте пробел после числа, <br> <br> НАКОНЕЦ, первая буква временного интервала должна быть заглавной и всегда добавляйте \'s\' к временному интервалу, даже если ваша продолжительность всего один день, месяц или год.',
            ],
            'admin.copy.duration_examples' => [
                'tr' => 'Örneğin, 1 Days, 3 Weeks, 1 Hours, 48 Hours, 4 Months, 1 Years, 9 Months',
                'ru' => 'Например, 1 Days, 3 Weeks, 1 Hours, 48 Hours, 4 Months, 1 Years, 9 Months',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            foreach ($translations as $language => $translation) {
                $languageId = $language === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian
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

        $this->command->info('✅ Copy Trading blade phrases seeded successfully!');
        $this->command->info('📊 Total phrases added: ' . count($phrases));
        $this->command->info('📁 Files covered: 9 blade files (copy + copytrading folders)');
        $this->command->info('🌐 Languages: Turkish (tr) and Russian (ru)');
    }
}