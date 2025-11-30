<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserDashboardPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            'user.dashboard.welcome_new' => [
                'tr' => 'Merhaba :name! Hoş geldiniz!',
                'ru' => 'Привет :name! Добро пожаловать!'
            ],
            'user.dashboard.welcome_back' => [
                'tr' => 'Tekrar hoş geldiniz :name!',
                'ru' => 'С возвращением :name!'
            ],
            'user.dashboard.overview_description' => [
                'tr' => 'Hesap özetiniz ve son aktiviteleriniz',
                'ru' => 'Обзор вашего аккаунта и последние активности'
            ],
            'user.dashboard.connect_wallet' => [
                'tr' => 'Cüzdan Bağla',
                'ru' => 'Подключить кошелек'
            ],
            'user.dashboard.wallet_connected' => [
                'tr' => 'Cüzdan Bağlandı',
                'ru' => 'Кошелек подключен'
            ],
            'user.dashboard.invest_now' => [
                'tr' => 'Şimdi Yatırım Yap',
                'ru' => 'Инвестировать сейчас'
            ],
            'user.dashboard.weak_signal' => [
                'tr' => 'Zayıf',
                'ru' => 'Слабый'
            ],
            'user.dashboard.medium_signal' => [
                'tr' => 'Orta',
                'ru' => 'Средний'
            ],
            'user.dashboard.strong_signal' => [
                'tr' => 'Güçlü',
                'ru' => 'Сильный'
            ],
            'user.dashboard.signal_strength' => [
                'tr' => 'Sinyal Gücü',
                'ru' => 'Сила сигнала'
            ],
            'user.dashboard.signal_weak_label' => [
                'tr' => 'Zayıf',
                'ru' => 'Слабый'
            ],
            'user.dashboard.signal_medium_label' => [
                'tr' => 'Orta',
                'ru' => 'Средний'
            ],
            'user.dashboard.signal_strong_label' => [
                'tr' => 'Güçlü',
                'ru' => 'Сильный'
            ],
            'user.dashboard.signal_warning_low' => [
                'tr' => 'Sinyal gücü düşük. Dikkatli olun.',
                'ru' => 'Сила сигнала низкая. Будьте осторожны.'
            ],
            'user.dashboard.signal_warning_medium' => [
                'tr' => 'Orta sinyal gücü. Fırsatları değerlendirin.',
                'ru' => 'Средняя сила сигнала. Оценивайте возможности.'
            ],
            'user.dashboard.signal_warning_high' => [
                'tr' => 'Güçlü sinyal! İyi fırsatlar mevcut.',
                'ru' => 'Сильный сигнал! Доступны хорошие возможности.'
            ],
            'user.dashboard.account_balance' => [
                'tr' => 'Hesap Bakiyesi',
                'ru' => 'Баланс счета'
            ],
            'user.dashboard.available_funds' => [
                'tr' => 'Mevcut Fonlar',
                'ru' => 'Доступные средства'
            ],
            'user.dashboard.available_withdrawal' => [
                'tr' => 'Çekim İçin Hazır',
                'ru' => 'Готово к выводу'
            ],
            'user.dashboard.verified_account' => [
                'tr' => 'Doğrulanmış Hesap',
                'ru' => 'Верифицированный аккаунт'
            ],
            'user.dashboard.under_review' => [
                'tr' => 'İnceleme Altında',
                'ru' => 'На рассмотрении'
            ],
            'user.dashboard.not_verified' => [
                'tr' => 'Doğrulanmamış',
                'ru' => 'Не верифицирован'
            ],
            'user.dashboard.last_update' => [
                'tr' => 'Son Güncelleme',
                'ru' => 'Последнее обновление'
            ],
            'user.dashboard.deposit' => [
                'tr' => 'Para Yatır',
                'ru' => 'Депозит'
            ],
            'user.dashboard.withdraw' => [
                'tr' => 'Para Çek',
                'ru' => 'Вывод'
            ],
            'user.dashboard.total_profit' => [
                'tr' => 'Toplam Kar',
                'ru' => 'Общая прибыль'
            ],
            'user.dashboard.total_investment' => [
                'tr' => 'Toplam Yatırım',
                'ru' => 'Общие инвестиции'
            ],
            'user.dashboard.total_withdrawal' => [
                'tr' => 'Toplam Çekim',
                'ru' => 'Общий вывод'
            ],
            'user.dashboard.reward' => [
                'tr' => 'Ödül',
                'ru' => 'Награда'
            ],
            'user.dashboard.recent_period' => [
                'tr' => 'Son Dönem',
                'ru' => 'Последний период'
            ],
            'user.dashboard.all_time' => [
                'tr' => 'Tüm Zamanlar',
                'ru' => 'За все время'
            ],
            'user.dashboard.account_verified' => [
                'tr' => 'Hesap Doğrulandı',
                'ru' => 'Аккаунт верифицирован'
            ],
            'user.dashboard.identity_verified_message' => [
                'tr' => 'Kimliğiniz başarıyla doğrulandı ve hesabınız tamamen aktif.',
                'ru' => 'Ваша личность успешно верифицирована и ваш аккаунт полностью активен.'
            ],
            'user.dashboard.verified' => [
                'tr' => 'Doğrulandı',
                'ru' => 'Верифицирован'
            ],
            'user.dashboard.identity_verification' => [
                'tr' => 'Kimlik Doğrulama',
                'ru' => 'Верификация личности'
            ],
            'user.dashboard.complete_verification_message' => [
                'tr' => 'Hesabınızı doğrulamak için kimlik belgelerinizi gönderin.',
                'ru' => 'Отправьте ваши документы удостоверяющие личность для верификации аккаунта.'
            ],
            'user.dashboard.view_details' => [
                'tr' => 'Detayları Görüntüle',
                'ru' => 'Посмотреть детали'
            ],
            'user.dashboard.documents_under_review_message' => [
                'tr' => 'Belgeleriniz inceleniyor. Lütfen 24-48 saat bekleyin.',
                'ru' => 'Ваши документы рассматриваются. Пожалуйста подождите 24-48 часов.'
            ],
            'user.dashboard.submitted' => [
                'tr' => 'Gönderildi',
                'ru' => 'Отправлено'
            ],
            'user.dashboard.completed' => [
                'tr' => 'Tamamlandı',
                'ru' => 'Завершено'
            ],
            'user.dashboard.complete_verification' => [
                'tr' => 'Doğrulamayı Tamamla',
                'ru' => 'Завершить верификацию'
            ],
            'user.dashboard.verification_benefits_message' => [
                'tr' => 'Hesap doğrulaması ile daha yüksek limitler ve gelişmiş özellikler kazanın.',
                'ru' => 'Получите более высокие лимиты и расширенные функции с верификацией аккаунта.'
            ],
            'user.dashboard.advanced_security' => [
                'tr' => 'Gelişmiş Güvenlik',
                'ru' => 'Расширенная безопасность'
            ],
            'user.dashboard.higher_limits' => [
                'tr' => 'Yüksek Limitler',
                'ru' => 'Высокие лимиты'
            ],
            'user.dashboard.start_verification' => [
                'tr' => 'Doğrulamayı Başlat',
                'ru' => 'Начать верификацию'
            ],
            'user.dashboard.connect_wallet_earnings' => [
                'tr' => 'Cüzdan Bağlayın ve Kazanmaya Başlayın',
                'ru' => 'Подключите кошелек и начните зарабатывать'
            ],
            'user.dashboard.daily_earnings_message' => [
                'tr' => 'Günlük :amount kazanç elde edebilirsiniz.',
                'ru' => 'Вы можете заработать :amount в день.'
            ],
            'user.dashboard.connect_wallet_now' => [
                'tr' => 'Şimdi Cüzdan Bağla',
                'ru' => 'Подключить кошелек сейчас'
            ],
            'user.dashboard.investment' => [
                'tr' => 'Yatırım',
                'ru' => 'Инвестиции'
            ],
            'user.dashboard.withdrawal' => [
                'tr' => 'Çekim',
                'ru' => 'Вывод'
            ],
            'user.dashboard.market_overview' => [
                'tr' => 'Piyasa Özeti',
                'ru' => 'Обзор рынка'
            ],
            'user.dashboard.view_history' => [
                'tr' => 'Geçmişi Görüntüle',
                'ru' => 'Посмотреть историю'
            ],
            'user.dashboard.forex' => [
                'tr' => 'Forex',
                'ru' => 'Форекс'
            ],
            'user.dashboard.crypto' => [
                'tr' => 'Kripto',
                'ru' => 'Крипто'
            ],
            'user.dashboard.stocks' => [
                'tr' => 'Hisse Senetleri',
                'ru' => 'Акции'
            ],
            'user.dashboard.commodities' => [
                'tr' => 'Emtialar',
                'ru' => 'Товары'
            ],
            'user.dashboard.indices' => [
                'tr' => 'Endeksler',
                'ru' => 'Индексы'
            ],
            'user.dashboard.quick_trade' => [
                'tr' => 'Hızlı İşlem',
                'ru' => 'Быстрая торговля'
            ],
            'user.dashboard.quick_trade_description' => [
                'tr' => 'Anında işlem yapın',
                'ru' => 'Торгуйте мгновенно'
            ],
            'user.dashboard.place_trade' => [
                'tr' => 'İşlem Yap',
                'ru' => 'Разместить сделку'
            ],
            'user.dashboard.asset' => [
                'tr' => 'Varlık',
                'ru' => 'Актив'
            ],
            'user.dashboard.amount' => [
                'tr' => 'Miktar',
                'ru' => 'Сумма'
            ],
            'user.dashboard.investment_amount_placeholder' => [
                'tr' => 'Yatırım Miktarı (0.00)',
                'ru' => 'Сумма инвестиций (0.00)'
            ],
            'user.dashboard.min_max_limits' => [
                'tr' => 'En Az: 50, En Çok: 500.000',
                'ru' => 'Минимум: 50, Максимум: 500,000'
            ],
            'user.dashboard.leverage' => [
                'tr' => 'Kaldıraç',
                'ru' => 'Кредитное плечо'
            ],
            'user.dashboard.expiry' => [
                'tr' => 'Son Kullanma',
                'ru' => 'Истечение'
            ],
            'user.dashboard.seven_days' => [
                'tr' => '7 Gün',
                'ru' => '7 дней'
            ],
            'user.dashboard.buy' => [
                'tr' => 'SATIN AL',
                'ru' => 'КУПИТЬ'
            ],
            'user.dashboard.sell' => [
                'tr' => 'SAT',
                'ru' => 'ПРОДАТЬ'
            ],
            'user.dashboard.latest_trades' => [
                'tr' => 'Son İşlemler',
                'ru' => 'Последние сделки'
            ],
            'user.dashboard.details' => [
                'tr' => 'Detaylar',
                'ru' => 'Детали'
            ],
            'user.dashboard.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'user.dashboard.profit' => [
                'tr' => 'KAZANÇ',
                'ru' => 'ПРИБЫЛЬ'
            ],
            'user.dashboard.loss' => [
                'tr' => 'KAYIP',
                'ru' => 'УБЫТОК'
            ],
            'user.dashboard.view_all' => [
                'tr' => 'Tümünü Görüntüle',
                'ru' => 'Посмотреть все'
            ],
            'user.dashboard.referrals' => [
                'tr' => 'Referanslar',
                'ru' => 'Рефералы'
            ],
            'user.dashboard.referral_description' => [
                'tr' => 'Projemizi ağınıza sunun ve finansal avantajlardan yararlanın. Ortaklık komisyonları kazanmak için aktif bir yatırıma ihtiyacınız yok.',
                'ru' => 'Представьте наш проект своей сети и получите финансовые преимущества. Вам не нужны активные инвестиции для получения партнерских комиссий.'
            ],
            'user.dashboard.learn_more' => [
                'tr' => 'Daha Fazla Öğrenin',
                'ru' => 'Узнать больше'
            ],
            'user.dashboard.personal_referral_link' => [
                'tr' => 'Kişisel Referans Bağlantısı',
                'ru' => 'Персональная реферальная ссылка'
            ],
            'user.dashboard.copy' => [
                'tr' => 'Kopyala',
                'ru' => 'Копировать'
            ],
            'user.dashboard.copied_to_clipboard' => [
                'tr' => 'Panoya kopyalandı!',
                'ru' => 'Скопировано в буфер обмена!'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $key
            ]);

            // Add translations
            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : ($languageCode === 'ru' ? 2 : 3);
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('Dashboard phrases seeded successfully! Added ' . count($phrases) . ' phrases with Turkish and Russian translations.');
    }
}