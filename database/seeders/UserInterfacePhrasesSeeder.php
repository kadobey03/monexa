<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserInterfacePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for User Interface phrases.
     *
     * @return void
     */
    public function run()
    {
        $phrases = [
            // Navigation
            ['key' => 'user.navigation.home', 'tr' => 'Ana Sayfa', 'ru' => 'Главная'],
            ['key' => 'user.navigation.dashboard', 'tr' => 'Panel', 'ru' => 'Панель'],

            // Investment Plans (mplans.blade.php)
            ['key' => 'user.plans.navigation_title', 'tr' => 'Yatırım Planları', 'ru' => 'Инвестиционные планы'],
            ['key' => 'user.plans.page_title', 'tr' => 'Yatırım Planları', 'ru' => 'Инвестиционные планы'],
            ['key' => 'user.plans.page_subtitle', 'tr' => 'Yüksek getirili yatırım fırsatlarımızla hesabınızı yükseltin', 'ru' => 'Улучшите свой аккаунт с нашими высокодоходными инвестиционными возможностями'],
            ['key' => 'user.plans.grow_portfolio', 'tr' => 'Portföyünüzü Büyütün', 'ru' => 'Увеличьте свой портфель'],
            ['key' => 'user.plans.minimum', 'tr' => 'minimum', 'ru' => 'минимум'],
            ['key' => 'user.plans.min_investment', 'tr' => 'Min. Yatırım', 'ru' => 'Мин. инвестиция'],
            ['key' => 'user.plans.max_investment', 'tr' => 'Maks. Yatırım', 'ru' => 'Макс. инвестиция'],
            ['key' => 'user.plans.return_rate', 'tr' => 'Getiri Oranı', 'ru' => 'Доходность'],
            ['key' => 'user.plans.duration', 'tr' => 'Süre', 'ru' => 'Продолжительность'],
            ['key' => 'user.plans.investment_amount', 'tr' => 'Yatırım Tutarı', 'ru' => 'Сумма инвестиции'],
            ['key' => 'user.plans.enter_amount', 'tr' => 'Tutar girin', 'ru' => 'Введите сумму'],
            ['key' => 'user.plans.potential_return', 'tr' => 'Potansiyel Getiri', 'ru' => 'Потенциальный доход'],
            ['key' => 'user.plans.join_plan', 'tr' => 'Yatırım Planına Katıl', 'ru' => 'Присоединиться к плану'],
            ['key' => 'user.plans.no_plans_available', 'tr' => 'Yatırım Planı Mevcut Değil', 'ru' => 'Нет доступных планов'],
            ['key' => 'user.plans.no_plans_message', 'tr' => 'Yatırım planları şu anda güncelleniyor. Lütfen yeni yatırım fırsatları için daha sonra tekrar kontrol edin.', 'ru' => 'Инвестиционные планы обновляются. Пожалуйста, проверьте позже для новых возможностей.'],
            ['key' => 'user.plans.return_dashboard', 'tr' => 'Panele Dön', 'ru' => 'Вернуться к панели'],
            ['key' => 'user.plans.investment_guide', 'tr' => 'Yatırım Rehberi', 'ru' => 'Инвестиционный гид'],
            ['key' => 'user.plans.guide_choose', 'tr' => 'Planınızı seçin', 'ru' => 'Выберите план'],
            ['key' => 'user.plans.guide_choose_desc', 'tr' => 'Finansal hedefleriniz ve risk toleransınıza uygun yatırım planı seçin.', 'ru' => 'Выберите план, соответствующий вашим целям и толерантности к риску.'],
            ['key' => 'user.plans.guide_secure', 'tr' => 'Güvenli yatırım', 'ru' => 'Безопасные инвестиции'],
            ['key' => 'user.plans.guide_secure_desc', 'tr' => 'Fonlarınız son teknoloji yatırım stratejileri ile güvenle yönetilir.', 'ru' => 'Ваши средства надежно управляются передовыми стратегиями.'],
            ['key' => 'user.plans.guide_earn', 'tr' => 'Getiri kazanın', 'ru' => 'Получайте доходы'],
            ['key' => 'user.plans.guide_earn_desc', 'tr' => 'Yatırımınızın rekabetçi getirilerle büyüdüğünü izleyin, doğrudan hesabınıza aktarılır.', 'ru' => 'Наблюдайте за ростом инвестиций с конкурентной доходностью.'],
            ['key' => 'user.plans.modal_no_plans', 'tr' => 'Plan Mevcut Değil', 'ru' => 'Планы недоступны'],
            ['key' => 'user.plans.modal_no_plans_desc', 'tr' => 'Şu anda yatırım planı mevcut değil. Lütfen daha sonra tekrar kontrol edin.', 'ru' => 'В настоящее время планы недоступны. Проверьте позже.'],

            // Trading Signals (msignals.blade.php)
            ['key' => 'user.signals.page_title', 'tr' => 'Ticaret Sinyallerim', 'ru' => 'Мои торговые сигналы'],
            ['key' => 'user.signals.page_subtitle', 'tr' => 'Aktif ticaret sinyali aboneliklerinizi izleyin ve takip edin', 'ru' => 'Отслеживайте активные подписки на торговые сигналы'],
            ['key' => 'user.signals.current_plan', 'tr' => 'Mevcut Sinyal Planı', 'ru' => 'Текущий план сигналов'],
            ['key' => 'user.signals.no_active_plan', 'tr' => 'Aktif Plan Yok', 'ru' => 'Нет активного плана'],
            ['key' => 'user.signals.active', 'tr' => 'Aktif', 'ru' => 'Активный'],
            ['key' => 'user.signals.total_signals', 'tr' => 'Toplam Sinyal', 'ru' => 'Всего сигналов'],
            ['key' => 'user.signals.active_signals', 'tr' => 'Aktif Sinyaller', 'ru' => 'Активные сигналы'],
            ['key' => 'user.signals.total_trade_value', 'tr' => 'Toplam İşlem Değeri', 'ru' => 'Общая стоимость сделок'],
            ['key' => 'user.signals.signal_activity', 'tr' => 'Sinyal Aktivitesi', 'ru' => 'Активность сигналов'],
            ['key' => 'user.signals.all_status', 'tr' => 'Tüm Durumlar', 'ru' => 'Все статусы'],
            ['key' => 'user.signals.closed', 'tr' => 'Kapalı', 'ru' => 'Закрыт'],
            ['key' => 'user.signals.all_orders', 'tr' => 'Tüm Emirler', 'ru' => 'Все ордера'],
            ['key' => 'user.signals.buy_orders', 'tr' => 'Alış Emirleri', 'ru' => 'Ордера на покупку'],
            ['key' => 'user.signals.sell_orders', 'tr' => 'Satış Emirleri', 'ru' => 'Ордера на продажу'],
            ['key' => 'user.signals.signal_details', 'tr' => 'Sinyal Detayları', 'ru' => 'Детали сигнала'],
            ['key' => 'user.signals.asset', 'tr' => 'Varlık', 'ru' => 'Актив'],
            ['key' => 'user.signals.order_type', 'tr' => 'Emir Tipi', 'ru' => 'Тип ордера'],
            ['key' => 'user.signals.amount', 'tr' => 'Tutar', 'ru' => 'Сумма'],
            ['key' => 'user.signals.leverage', 'tr' => 'Kaldıraç', 'ru' => 'Кредитное плечо'],
            ['key' => 'user.signals.status', 'tr' => 'Durum', 'ru' => 'Статус'],
            ['key' => 'user.signals.date', 'tr' => 'Tarih', 'ru' => 'Дата'],
            ['key' => 'user.signals.plan', 'tr' => 'Plan', 'ru' => 'План'],
            ['key' => 'user.signals.trade_amount', 'tr' => 'İşlem Tutarı', 'ru' => 'Сумма сделки'],
            ['key' => 'user.signals.date_added', 'tr' => 'Eklenme Tarihi', 'ru' => 'Дата добавления'],
            ['key' => 'user.signals.signal_plan', 'tr' => 'Sinyal Planı', 'ru' => 'План сигналов'],
            ['key' => 'user.signals.no_signals', 'tr' => 'Ticaret Sinyali Yok', 'ru' => 'Нет торговых сигналов'],
            ['key' => 'user.signals.no_signals_message', 'tr' => 'Henüz ticaret sinyaliniz yok. Profesyonel ticaret önerilerini almaya başlamak için bir sinyal planına abone olun.', 'ru' => 'У вас пока нет торговых сигналов. Подпишитесь на план для получения рекомендаций.'],
            ['key' => 'user.signals.subscribe_signals', 'tr' => 'Sinyallere Abone Ol', 'ru' => 'Подписаться на сигналы'],

            // My Plans (myplans.blade.php)
            ['key' => 'user.my_plans.page_title', 'tr' => 'Yatırım Planlarım', 'ru' => 'Мои инвестиционные планы'],
            ['key' => 'user.my_plans.page_subtitle', 'tr' => 'Aktif yatırım portföyünüzü takip edin ve yönetin', 'ru' => 'Отслеживайте и управляйте активным портфелем'],
            ['key' => 'user.my_plans.new_investment', 'tr' => 'Yeni Yatırım', 'ru' => 'Новая инвестиция'],
            ['key' => 'user.my_plans.total_plans', 'tr' => 'Toplam Plan', 'ru' => 'Всего планов'],
            ['key' => 'user.my_plans.active', 'tr' => 'Aktif', 'ru' => 'Активные'],
            ['key' => 'user.my_plans.expired', 'tr' => 'Süresi Dolmuş', 'ru' => 'Истекшие'],
            ['key' => 'user.my_plans.total_invested', 'tr' => 'Toplam Yatırım', 'ru' => 'Общие инвестиции'],
            ['key' => 'user.my_plans.filter_status', 'tr' => 'Duruma göre filtrele', 'ru' => 'Фильтр по статусу'],
            ['key' => 'user.my_plans.all_plans', 'tr' => 'Tüm Planlar', 'ru' => 'Все планы'],
            ['key' => 'user.my_plans.active_plans', 'tr' => 'Aktif Planlar', 'ru' => 'Активные планы'],
            ['key' => 'user.my_plans.expired_plans', 'tr' => 'Süresi Dolmuş Planlar', 'ru' => 'Истекшие планы'],
            ['key' => 'user.my_plans.showing_plans', 'tr' => ':count / :total plan gösteriliyor', 'ru' => 'Показано :count из :total планов'],
            ['key' => 'user.my_plans.investment_amount', 'tr' => 'Yatırım Tutarı', 'ru' => 'Сумма инвестиции'],
            ['key' => 'user.my_plans.expected_roi', 'tr' => 'Beklenen Getiri', 'ru' => 'Ожидаемая доходность'],
            ['key' => 'user.my_plans.expiration', 'tr' => 'Bitiş', 'ru' => 'Истечение'],
            ['key' => 'user.my_plans.start_date', 'tr' => 'Başlangıç Tarihi', 'ru' => 'Дата начала'],
            ['key' => 'user.my_plans.end_date', 'tr' => 'Bitiş Tarihi', 'ru' => 'Дата окончания'],
            ['key' => 'user.my_plans.inactive', 'tr' => 'Pasif', 'ru' => 'Неактивный'],
            ['key' => 'user.my_plans.status', 'tr' => 'Durum', 'ru' => 'Статус'],
            ['key' => 'user.my_plans.view_details', 'tr' => 'Detayları Görüntüle', 'ru' => 'Посмотреть детали'],
            ['key' => 'user.my_plans.investment_progress', 'tr' => 'Yatırım İlerlemesi', 'ru' => 'Прогресс инвестиции'],
            ['key' => 'user.my_plans.days_remaining', 'tr' => ':days gün kaldı', 'ru' => 'Осталось :days дней'],
            ['key' => 'user.my_plans.progress_complete', 'tr' => ':progress% tamamlandı', 'ru' => ':progress% завершено'],
            ['key' => 'user.my_plans.total_days', 'tr' => 'toplam :days gün', 'ru' => 'всего :days дней'],
            ['key' => 'user.my_plans.no_plans_found', 'tr' => 'Yatırım Planı Bulunamadı', 'ru' => 'Планы не найдены'],
            ['key' => 'user.my_plans.no_plans_message', 'tr' => 'Şu anda yatırım planınız yok veya mevcut filtre kriterlerinizle eşleşen plan bulunmuyor.', 'ru' => 'У вас нет планов или они не соответствуют фильтру.'],
            ['key' => 'user.my_plans.start_first_investment', 'tr' => 'İlk Yatırımınızı Başlatın', 'ru' => 'Начните первую инвестицию'],
            ['key' => 'user.my_plans.showing_investment_plans', 'tr' => ':first - :last arası :total yatırım planından gösteriliyor', 'ru' => 'Показано :first - :last из :total инвестиционных планов'],

            // Payment (payment.blade.php)
            ['key' => 'user.payment.bank_name', 'tr' => 'Banka Adı', 'ru' => 'Название банка'],
            ['key' => 'user.payment.account_name', 'tr' => 'Hesap Adı', 'ru' => 'Имя счета'],
            ['key' => 'user.payment.account_number', 'tr' => 'Hesap Numarası', 'ru' => 'Номер счета'],
            ['key' => 'user.payment.swift_code', 'tr' => 'Swift Kodu', 'ru' => 'SWIFT код'],
            ['key' => 'user.payment.network', 'tr' => 'Ağ', 'ru' => 'Сеть'],
            ['key' => 'user.payment.support_247', 'tr' => '7/24 Destek', 'ru' => 'Поддержка 24/7'],
            ['key' => 'user.payment.support_desc', 'tr' => 'Yardım mı lazım? Destek ekibimiz 24 saat hizmet veriyor', 'ru' => 'Нужна помощь? Наша поддержка работает 24 часа'],
            ['key' => 'user.payment.instant_processing', 'tr' => 'Anında İşleme', 'ru' => 'Мгновенная обработка'],
            ['key' => 'user.payment.instant_processing_desc', 'tr' => 'Yatırımlar onaydan sonraki dakikalar içinde işlenir', 'ru' => 'Инвестиции обрабатываются в течение минут после подтверждения'],
            ['key' => 'user.payment.bank_level_security', 'tr' => 'Banka Seviyesi Güvenlik', 'ru' => 'Банковский уровень безопасности'],
            ['key' => 'user.payment.bank_level_security_desc', 'tr' => 'Fonlarınız ve verileriniz kurumsal güvenlik önlemleriyle korunur', 'ru' => 'Ваши средства и данные защищены корпоративными мерами безопасности'],

            // Plan Details (plandetails.blade.php)
            ['key' => 'user.plan_details.page_title', 'tr' => 'Plan Detayları', 'ru' => 'Детали плана'],
            ['key' => 'user.plan_details.page_subtitle', 'tr' => 'Yatırım performansı ve işlemler', 'ru' => 'Эффективность инвестиций и транзакции'],
            ['key' => 'user.plan_details.active', 'tr' => 'Aktif', 'ru' => 'Активный'],
            ['key' => 'user.plan_details.expired', 'tr' => 'Süresi Dolmuş', 'ru' => 'Истекший'],
            ['key' => 'user.plan_details.inactive', 'tr' => 'Pasif', 'ru' => 'Неактивный'],
            ['key' => 'user.plan_details.cancel_plan', 'tr' => 'Planı İptal Et', 'ru' => 'Отменить план'],
            ['key' => 'user.plan_details.financial_overview', 'tr' => 'Mali Durum Özeti', 'ru' => 'Финансовый обзор'],
            ['key' => 'user.plan_details.invested_amount', 'tr' => 'Yatırım Tutarı', 'ru' => 'Инвестированная сумма'],
            ['key' => 'user.plan_details.profit_earned', 'tr' => 'Kazanılan Kar', 'ru' => 'Заработанная прибыль'],
            ['key' => 'user.plan_details.total_return', 'tr' => 'Toplam Getiri', 'ru' => 'Общий доход'],
            ['key' => 'user.plan_details.plan_details', 'tr' => 'Plan Detayları', 'ru' => 'Детали плана'],
            ['key' => 'user.plan_details.duration', 'tr' => 'Süre', 'ru' => 'Продолжительность'],
            ['key' => 'user.plan_details.start_date', 'tr' => 'Başlangıç Tarihi', 'ru' => 'Дата начала'],
            ['key' => 'user.plan_details.end_date', 'tr' => 'Bitiş Tarihi', 'ru' => 'Дата окончания'],
            ['key' => 'user.plan_details.roi_interval', 'tr' => 'Getiri Aralığı', 'ru' => 'Интервал доходности'],
            ['key' => 'user.plan_details.minimum_return', 'tr' => 'Minimum Getiri', 'ru' => 'Минимальный доход'],
            ['key' => 'user.plan_details.maximum_return', 'tr' => 'Maksimum Getiri', 'ru' => 'Максимальный доход'],
            ['key' => 'user.plan_details.transaction_history', 'tr' => 'İşlem Geçmişi', 'ru' => 'История транзакций'],
            ['key' => 'user.plan_details.profit', 'tr' => 'Kar', 'ru' => 'Прибыль'],
            ['key' => 'user.plan_details.no_transactions', 'tr' => 'Henüz işlem kaydı bulunamadı', 'ru' => 'Записи транзакций пока не найдены'],
            ['key' => 'user.plan_details.type', 'tr' => 'Tip', 'ru' => 'Тип'],
            ['key' => 'user.plan_details.date', 'tr' => 'Tarih', 'ru' => 'Дата'],
            ['key' => 'user.plan_details.amount', 'tr' => 'Tutar', 'ru' => 'Сумма'],
            ['key' => 'user.plan_details.cancel_investment_plan', 'tr' => 'Yatırım Planını İptal Et', 'ru' => 'Отменить инвестиционный план'],
            ['key' => 'user.plan_details.cancel_confirmation', 'tr' => ':plan planınızı iptal etmek istediğinizden emin misiniz?', 'ru' => 'Вы уверены, что хотите отменить план :plan?'],
            ['key' => 'user.plan_details.confirm_cancellation', 'tr' => 'İptali Onayla', 'ru' => 'Подтвердить отмену'],

            // Common UI Elements
            ['key' => 'user.common.close', 'tr' => 'Kapat', 'ru' => 'Закрыть'],
            ['key' => 'user.common.previous', 'tr' => 'Önceki', 'ru' => 'Предыдущий'],
            ['key' => 'user.common.next', 'tr' => 'Sonraki', 'ru' => 'Следующий'],
            ['key' => 'user.common.showing_results', 'tr' => ':first - :last arası :total sonuçtan gösteriliyor', 'ru' => 'Показано :first - :last из :total результатов'],
            ['key' => 'user.common.showing', 'tr' => 'Gösteriliyor', 'ru' => 'Показано'],
            ['key' => 'user.common.to', 'tr' => '-', 'ru' => '-'],
            ['key' => 'user.common.of', 'tr' => '/', 'ru' => 'из'],
            ['key' => 'user.common.results', 'tr' => 'sonuç', 'ru' => 'результатов'],
            ['key' => 'user.common.page_of', 'tr' => 'Sayfa :page / :total', 'ru' => 'Страница :page из :total'],
            ['key' => 'user.common.cancel', 'tr' => 'İptal', 'ru' => 'Отмена'],
        ];

        foreach ($phrases as $phraseData) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);
            
            // Add Turkish translation (language_id = 1)
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => 1],
                ['translation' => $phraseData['tr']]
            );
            
            // Add Russian translation (language_id = 2)
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => 2],
                ['translation' => $phraseData['ru']]
            );
        }

        $this->command->info('User Interface phrases have been seeded successfully!');
        $this->command->info('Total phrases added: ' . count($phrases));
    }
}