<?php

namespace Database\Seeders;

use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Database\Seeder;

class UserCryptoPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Navigation & Breadcrumb
            'user.crypto.home' => [
                'tr' => 'Ana Sayfa',
                'ru' => 'Главная'
            ],
            'user.crypto.investment_plans' => [
                'tr' => 'Yatırım Planları',
                'ru' => 'Инвестиционные планы'
            ],
            'user.crypto.cryptocurrency' => [
                'tr' => 'Kripto Para',
                'ru' => 'Криптовалюта'
            ],

            // Page Header
            'user.crypto.page_title' => [
                'tr' => 'Kripto Para Yatırımı',
                'ru' => 'Инвестиции в криптовалюту'
            ],
            'user.crypto.page_subtitle' => [
                'tr' => 'En popüler kripto para birimlerinde güvenli yatırım fırsatları keşfedin',
                'ru' => 'Откройте для себя безопасные инвестиционные возможности в самых популярных криптовалютах'
            ],

            // Feature Badges
            'user.crypto.high_returns' => [
                'tr' => 'Yüksek Getiri',
                'ru' => 'Высокие доходы'
            ],
            'user.crypto.quick_profits' => [
                'tr' => 'Hızlı Kar',
                'ru' => 'Быстрая прибыль'
            ],
            'user.crypto.secure_trading' => [
                'tr' => 'Güvenli İşlem',
                'ru' => 'Безопасная торговля'
            ],
            'user.crypto.daily_returns' => [
                'tr' => 'Günlük Getiri',
                'ru' => 'Ежедневный доход'
            ],

            // Market Insights
            'user.crypto.market_insights' => [
                'tr' => 'Piyasa Görüşleri',
                'ru' => 'Рыночная аналитика'
            ],
            'user.crypto.total_market_cap' => [
                'tr' => 'Toplam Piyasa Değeri',
                'ru' => 'Общая капитализация'
            ],
            'user.crypto.trading_hours' => [
                'tr' => 'İşlem Saatleri',
                'ru' => 'Торговые часы'
            ],
            'user.crypto.active_coins' => [
                'tr' => 'Aktif Coinler',
                'ru' => 'Активные монеты'
            ],
            'user.crypto.global_users' => [
                'tr' => 'Küresel Kullanıcılar',
                'ru' => 'Мировые пользователи'
            ],

            // Investment Plan Details
            'user.crypto.minimum' => [
                'tr' => 'minimum',
                'ru' => 'минимум'
            ],
            'user.crypto.duration' => [
                'tr' => 'Süre',
                'ru' => 'Продолжительность'
            ],
            'user.crypto.days' => [
                'tr' => 'gün',
                'ru' => 'дней'
            ],
            'user.crypto.investment_range' => [
                'tr' => 'Yatırım Aralığı',
                'ru' => 'Диапазон инвестиций'
            ],
            'user.crypto.return_rate' => [
                'tr' => 'Getiri Oranı',
                'ru' => 'Норма прибыли'
            ],
            'user.crypto.total_expected_return' => [
                'tr' => 'Toplam Beklenen Getiri',
                'ru' => 'Общий ожидаемый доход'
            ],
            'user.crypto.welcome_bonus' => [
                'tr' => 'Hoş Geldin Bonusu',
                'ru' => 'Приветственный бонус'
            ],

            // Investment Form
            'user.crypto.investment_amount' => [
                'tr' => 'Yatırım Tutarı',
                'ru' => 'Сумма инвестиций'
            ],
            'user.crypto.enter_amount' => [
                'tr' => 'Tutarı girin',
                'ru' => 'Введите сумму'
            ],
            'user.crypto.min' => [
                'tr' => 'Min',
                'ru' => 'Мин'
            ],
            'user.crypto.max' => [
                'tr' => 'Maks',
                'ru' => 'Макс'
            ],
            'user.crypto.expected_profit' => [
                'tr' => 'Beklenen Kar',
                'ru' => 'Ожидаемая прибыль'
            ],

            // Action Buttons
            'user.crypto.invest_now' => [
                'tr' => 'Şimdi Yatırım Yap',
                'ru' => 'Инвестировать сейчас'
            ],
            'user.crypto.invest_in_crypto' => [
                'tr' => 'Kripto Para Yatırımı',
                'ru' => 'Инвестировать в криптовалюту'
            ],

            // Empty State
            'user.crypto.no_plans_available' => [
                'tr' => 'Kripto Para Planı Bulunmuyor',
                'ru' => 'Нет доступных крипто-планов'
            ],
            'user.crypto.no_plans_description' => [
                'tr' => 'Kripto para yatırım planları şu anda güncelleniyor. Lütfen yeni kripto yatırım fırsatları için daha sonra kontrol edin.',
                'ru' => 'Планы криптовалютных инвестиций в настоящее время обновляются. Пожалуйста, проверьте позже новые возможности для криптоинвестиций.'
            ],
            'user.crypto.view_all_plans' => [
                'tr' => 'Tüm Planları Görüntüle',
                'ru' => 'Просмотреть все планы'
            ],

            // Education Section
            'user.crypto.why_choose_crypto' => [
                'tr' => 'Neden Kripto Yatırımı?',
                'ru' => 'Почему выбирают криптоинвестиции?'
            ],
            'user.crypto.crypto_advantages' => [
                'tr' => 'Kripto para yatırımının avantajlarını keşfedin ve dünya çapında milyonlarca yatırımcıya katılın',
                'ru' => 'Откройте для себя преимущества инвестиций в криптовалюту и присоединитесь к миллионам инвесторов по всему миру'
            ],
            'user.crypto.why_choose_crypto_investment' => [
                'tr' => 'Neden Kripto Para Yatırımı Seçmelisiniz?',
                'ru' => 'Почему стоит выбрать криптовалютные инвестиции?'
            ],

            // Benefits
            'user.crypto.high_liquidity' => [
                'tr' => 'Yüksek Likidite',
                'ru' => 'Высокая ликвидность'
            ],
            'user.crypto.liquidity_description' => [
                'tr' => 'Anında alım satım imkanları ile 7/24 küresel piyasa erişimi',
                'ru' => 'Круглосуточный доступ к глобальному рынку с возможностью мгновенной покупки и продажи'
            ],
            'user.crypto.portfolio_diversification' => [
                'tr' => 'Portföy Çeşitlendirmesi',
                'ru' => 'Диверсификация портфеля'
            ],
            'user.crypto.diversification_description' => [
                'tr' => 'Riski farklı kripto para birimlerinde dağıtın ve getirileri maksimize edin',
                'ru' => 'Распределите риски между различными криптовалютами и максимизируйте доходы'
            ],
            'user.crypto.advanced_security' => [
                'tr' => 'Gelişmiş Güvenlik',
                'ru' => 'Передовая безопасность'
            ],
            'user.crypto.security_description' => [
                'tr' => 'Askeri düzey şifreleme ve çoklu imza cüzdan koruması',
                'ru' => 'Военное шифрование и защита кошелька с мультиподписью'
            ],
            'user.crypto.expert_analysis' => [
                'tr' => 'Uzman Analizi',
                'ru' => 'Экспертный анализ'
            ],
            'user.crypto.analysis_description' => [
                'tr' => 'Profesyonel piyasa görüşleri ve ticaret tavsiyeleri',
                'ru' => 'Профессиональная рыночная аналитика и торговые рекомендации'
            ],
            'user.crypto.high_growth_potential' => [
                'tr' => 'Yüksek Büyüme Potansiyeli',
                'ru' => 'Высокий потенциал роста'
            ],
            'user.crypto.growth_description' => [
                'tr' => 'Kripto para, önemli getiri potansiyeli ile istisnai büyüme fırsatları sunar.',
                'ru' => 'Криптовалюта предлагает исключительные возможности роста с потенциалом значительной доходности.'
            ],
            'user.crypto.twentyfour_trading' => [
                'tr' => '7/24 İşlem',
                'ru' => 'Торговля 24/7'
            ],
            'user.crypto.trading_description' => [
                'tr' => 'Geleneksel piyasalardan farklı olarak, kripto piyasaları hiç kapanmaz ve sürekli işlem fırsatları sunar.',
                'ru' => 'В отличие от традиционных рынков, криптовалютные рынки никогда не закрываются, предоставляя непрерывные торговые возможности.'
            ],
            'user.crypto.global_access' => [
                'tr' => 'Küresel Erişim',
                'ru' => 'Глобальный доступ'
            ],
            'user.crypto.global_description' => [
                'tr' => 'Coğrafi kısıtlamalar veya geleneksel bankacılık sınırlamaları olmadan küresel kripto para piyasalarına erişim.',
                'ru' => 'Доступ к глобальным криптовалютным рынкам без географических ограничений или традиционных банковских ограничений.'
            ],

            // Portfolio Section
            'user.crypto.our_portfolio' => [
                'tr' => 'Kripto Para Portföyümüz',
                'ru' => 'Наш криптовалютный портфель'
            ],

            // Risk Warning
            'user.crypto.risk_notice_title' => [
                'tr' => 'Önemli Risk Uyarısı',
                'ru' => 'Важное предупреждение о рисках'
            ],
            'user.crypto.risk_notice_description' => [
                'tr' => 'Kripto para yatırımları oldukça volatildir ve önemli risk taşır. Fiyatlar kısa sürelerde dramatik olarak dalgalanabilir. Sadece kaybetmeyi göze alabileceğiniz kadarını yatırın. Geçmiş performans gelecekteki sonuçları garanti etmez.',
                'ru' => 'Инвестиции в криптовалюту крайне волатильны и несут значительный риск. Цены могут резко колебаться в короткие периоды. Инвестируйте только то, что можете позволить себе потерять. Прошлые показатели не гарантируют будущие результаты.'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(
                ['key' => $key],
                ['description' => 'User crypto investment page: ' . $key]
            );

            // Create or update translations for Turkish and Russian
            foreach ($translations as $locale => $translation) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $locale === 'tr' ? 1 : 2, // 1 for Turkish, 2 for Russian
                    ],
                    [
                        'translation' => $translation
                    ]
                );
            }
        }

        $this->command->info('✅ User crypto phrases created successfully! Total: ' . count($phrases) . ' phrases');
    }
}