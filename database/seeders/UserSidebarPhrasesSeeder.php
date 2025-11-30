<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class UserSidebarPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get language IDs
        $turkishId = Language::where('code', 'tr')->first()->id;
        $russianId = Language::where('code', 'ru')->first()->id;

        $sidebarPhrases = [
            // Genel Navigasyon
            'user.sidebar.overview' => [
                'tr' => 'Genel Bakış',
                'ru' => 'Обзор'
            ],
            'user.sidebar.dashboard' => [
                'tr' => 'Ana Sayfa',
                'ru' => 'Главная'
            ],
            'user.sidebar.account_summary' => [
                'tr' => 'Hesap Özeti',
                'ru' => 'Сводка счета'
            ],
            'user.sidebar.transaction_history' => [
                'tr' => 'İşlem Geçmişi',
                'ru' => 'История транзакций'
            ],
            'user.sidebar.account_history' => [
                'tr' => 'Hesap Geçmişi',
                'ru' => 'История счета'
            ],

            // İşlem ve Yatırım
            'user.sidebar.trading_investment' => [
                'tr' => 'İşlem ve Yatırım',
                'ru' => 'Торговля и инвестиции'
            ],
            'user.sidebar.deposits' => [
                'tr' => 'Para Yatırma',
                'ru' => 'Депозиты'
            ],
            'user.sidebar.withdrawals' => [
                'tr' => 'Para Çekme',
                'ru' => 'Вывод средств'
            ],
            'user.sidebar.live_trading' => [
                'tr' => 'Canlı İşlem',
                'ru' => 'Живая торговля'
            ],
            'user.sidebar.make_trade' => [
                'tr' => 'İşlem Yap',
                'ru' => 'Сделать сделку'
            ],
            'user.sidebar.open_trade' => [
                'tr' => 'İşlem Aç',
                'ru' => 'Открыть сделку'
            ],
            'user.sidebar.market_trading' => [
                'tr' => 'Piyasa İşlemleri',
                'ru' => 'Рыночная торговля'
            ],

            // Hesap Yönetimi
            'user.sidebar.account_management' => [
                'tr' => 'Hesap Yönetimi',
                'ru' => 'Управление счетом'
            ],
            'user.sidebar.profile_settings' => [
                'tr' => 'Profil Ayarları',
                'ru' => 'Настройки профиля'
            ],
            'user.sidebar.profile' => [
                'tr' => 'Profil',
                'ru' => 'Профиль'
            ],
            'user.sidebar.kyc_verification' => [
                'tr' => 'Kimlik Doğrulama',
                'ru' => 'Верификация KYC'
            ],

            // KYC Durumları
            'user.sidebar.account_verified' => [
                'tr' => 'Hesap Doğrulandı',
                'ru' => 'Аккаунт верифицирован'
            ],
            'user.sidebar.kyc_under_review' => [
                'tr' => 'Doğrulamanız inceleniyor',
                'ru' => 'Ваша верификация на рассмотрении'
            ],
            'user.sidebar.processing' => [
                'tr' => 'İşleniyor',
                'ru' => 'Обрабатывается'
            ],
            'user.sidebar.kyc_required_message' => [
                'tr' => 'Tüm ticaret özelliklerini kullanmak için kimlik doğrulaması tamamlayın',
                'ru' => 'Завершите верификацию личности для использования всех торговых функций'
            ],
            'user.sidebar.verify_now' => [
                'tr' => 'Şimdi Doğrula',
                'ru' => 'Верифицировать сейчас'
            ],

            // Ödüller ve Referral
            'user.sidebar.rewards' => [
                'tr' => 'Ödüller',
                'ru' => 'Награды'
            ],
            'user.sidebar.growth_rewards' => [
                'tr' => 'Büyüme ve Ödüller',
                'ru' => 'Рост и награды'
            ],
            'user.sidebar.referral_program' => [
                'tr' => 'Tavsiye Programı',
                'ru' => 'Реферальная программа'
            ],
            'user.sidebar.commission_percent' => [
                'tr' => '5% Komisyon',
                'ru' => '5% Комиссия'
            ],
            'user.sidebar.earn_commission' => [
                'tr' => 'Tavsiyelerden :percentage% komisyon kazanın',
                'ru' => 'Зарабатывайте :percentage% комиссии с рефералов'
            ],
            'user.sidebar.invite_friend' => [
                'tr' => 'Arkadaş Tavsiye Et',
                'ru' => 'Пригласить друга'
            ],

            // Destek
            'user.sidebar.support' => [
                'tr' => 'Destek',
                'ru' => 'Поддержка'
            ],
            'user.sidebar.support_center' => [
                'tr' => 'Destek Merkezi',
                'ru' => 'Центр поддержки'
            ],
            'user.sidebar.support_help' => [
                'tr' => 'Destek ve Yardım',
                'ru' => 'Поддержка и помощь'
            ],
            'user.sidebar.get_help_message' => [
                'tr' => 'Destek ekibimizden yardım alın',
                'ru' => 'Получите помощь от нашей службы поддержки'
            ],

            // Bildirimler
            'user.sidebar.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            'user.sidebar.no_notifications' => [
                'tr' => 'Bildirim yok',
                'ru' => 'Нет уведомлений'
            ],
            'user.sidebar.notification_message' => [
                'tr' => 'Bir şey olduğunda size haber vereceğiz',
                'ru' => 'Мы сообщим вам, когда что-то произойдет'
            ],
            'user.sidebar.view_all_notifications' => [
                'tr' => 'Tüm bildirimleri görüntüle',
                'ru' => 'Просмотреть все уведомления'
            ],

            // Cüzdan ve Bakiye
            'user.sidebar.wallet_funds' => [
                'tr' => 'Cüzdan ve Fonlar',
                'ru' => 'Кошелек и средства'
            ],
            'user.sidebar.account_balance' => [
                'tr' => 'Hesap Bakiyesi',
                'ru' => 'Баланс счета'
            ],
            'user.sidebar.balance' => [
                'tr' => 'Bakiye',
                'ru' => 'Баланс'
            ],

            // Diğer
            'user.sidebar.professional_trading' => [
                'tr' => 'Profesyonel Ticaret',
                'ru' => 'Профессиональная торговля'
            ],
            'user.sidebar.quick_actions' => [
                'tr' => 'Hızlı İşlem',
                'ru' => 'Быстрые действия'
            ],
            'user.sidebar.trading_account' => [
                'tr' => 'Ticaret Hesabı',
                'ru' => 'Торговый счет'
            ],
            'user.sidebar.live' => [
                'tr' => 'Canlı',
                'ru' => 'В прямом эфире'
            ],
            'user.sidebar.homepage' => [
                'tr' => 'Anasayfa',
                'ru' => 'Главная страница'
            ],

            // Sistem
            'user.sidebar.logout' => [
                'tr' => 'Güvenli Çıkış',
                'ru' => 'Безопасный выход'
            ]
        ];

        foreach ($sidebarPhrases as $key => $translations) {
            // Create or update phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create or update Turkish translation
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => $turkishId],
                ['translation' => $translations['tr']]
            );

            // Create or update Russian translation  
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => $russianId],
                ['translation' => $translations['ru']]
            );
        }

        $this->command->info('User sidebar navigation phrases have been seeded successfully! Total: ' . count($sidebarPhrases) . ' phrases');
    }
}