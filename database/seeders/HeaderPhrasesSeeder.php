<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class HeaderPhrasesSeeder extends Seeder
{
    /**
     * Header components için çeviri phrase'lerini ekle.
     */
    public function run(): void
    {
        $phrases = [
            // Admin Header
            [
                'key' => 'admin.header.notifications',
                'group' => 'admin',
                'description' => 'Admin header bildirimler başlığı',
                'context' => 'web',
                'translations' => [
                    1 => 'Bildirimler',
                    2 => 'Уведомления'
                ]
            ],
            [
                'key' => 'admin.header.no_notifications',
                'group' => 'admin',
                'description' => 'Admin header bildirim yok mesajı',
                'context' => 'web',
                'translations' => [
                    1 => 'Yeni bildirim yok',
                    2 => 'Нет новых уведомлений'
                ]
            ],
            [
                'key' => 'admin.header.account_settings',
                'group' => 'admin',
                'description' => 'Admin header hesap ayarları',
                'context' => 'web',
                'translations' => [
                    1 => 'Hesap Ayarları',
                    2 => 'Настройки Аккаунта'
                ]
            ],
            [
                'key' => 'admin.header.logout',
                'group' => 'admin',
                'description' => 'Admin header çıkış yap',
                'context' => 'web',
                'translations' => [
                    1 => 'Çıkış Yap',
                    2 => 'Выйти'
                ]
            ],

            // User Dashboard Header
            [
                'key' => 'user.dashboard.market_open',
                'group' => 'user',
                'description' => 'Dashboard piyasa açık durumu',
                'context' => 'web',
                'translations' => [
                    1 => 'Piyasa Açık',
                    2 => 'Рынок Открыт'
                ]
            ],
            [
                'key' => 'user.dashboard.account_balance',
                'group' => 'user',
                'description' => 'Dashboard hesap bakiyesi',
                'context' => 'web',
                'translations' => [
                    1 => 'Hesap Bakiyesi',
                    2 => 'Баланс Счета'
                ]
            ],
            [
                'key' => 'user.dashboard.notifications',
                'group' => 'user',
                'description' => 'Dashboard bildirimler',
                'context' => 'web',
                'translations' => [
                    1 => 'Bildirimler',
                    2 => 'Уведомления'
                ]
            ],
            [
                'key' => 'user.dashboard.mark_all_read',
                'group' => 'user',
                'description' => 'Tüm bildirimleri okundu işaretle',
                'context' => 'web',
                'translations' => [
                    1 => 'Hepsini Okundu İşaretle',
                    2 => 'Отметить все как прочитанные'
                ]
            ],
            [
                'key' => 'user.dashboard.mark_as_read',
                'group' => 'user',
                'description' => 'Okundu işaretle',
                'context' => 'web',
                'translations' => [
                    1 => 'Okundu İşaretle',
                    2 => 'Отметить как прочитанное'
                ]
            ],
            [
                'key' => 'user.dashboard.no_notifications_yet',
                'group' => 'user',
                'description' => 'Henüz bildirim yok',
                'context' => 'web',
                'translations' => [
                    1 => 'Henüz bildirim yok',
                    2 => 'Пока нет уведомлений'
                ]
            ],
            [
                'key' => 'user.dashboard.new_notifications_here',
                'group' => 'user',
                'description' => 'Yeni bildirimler burada görünecek',
                'context' => 'web',
                'translations' => [
                    1 => 'Yeni bildirimler burada görünecek',
                    2 => 'Новые уведомления появятся здесь'
                ]
            ],
            [
                'key' => 'user.dashboard.view_all_notifications',
                'group' => 'user',
                'description' => 'Tüm bildirimleri görüntüle',
                'context' => 'web',
                'translations' => [
                    1 => 'Tüm Bildirimleri Görüntüle',
                    2 => 'Просмотреть все уведомления'
                ]
            ],
            [
                'key' => 'user.dashboard.quick_actions',
                'group' => 'user',
                'description' => 'Hızlı işlemler',
                'context' => 'web',
                'translations' => [
                    1 => 'Hızlı İşlem',
                    2 => 'Быстрые Действия'
                ]
            ],
            [
                'key' => 'user.dashboard.deposit',
                'group' => 'user',
                'description' => 'Para yatırma',
                'context' => 'web',
                'translations' => [
                    1 => 'Para Yatırma',
                    2 => 'Депозит'
                ]
            ],
            [
                'key' => 'user.dashboard.deposit_desc',
                'group' => 'user',
                'description' => 'Para yatırma açıklaması',
                'context' => 'web',
                'translations' => [
                    1 => 'Hesabınıza para ekleyin',
                    2 => 'Добавить деньги на счет'
                ]
            ],
            [
                'key' => 'user.dashboard.withdrawal',
                'group' => 'user',
                'description' => 'Para çekme',
                'context' => 'web',
                'translations' => [
                    1 => 'Para Çekme',
                    2 => 'Вывод средств'
                ]
            ],
            [
                'key' => 'user.dashboard.withdrawal_desc',
                'group' => 'user',
                'description' => 'Para çekme açıklaması',
                'context' => 'web',
                'translations' => [
                    1 => 'Kazançlarınızı çekin',
                    2 => 'Выводите свою прибыль'
                ]
            ],
            [
                'key' => 'user.dashboard.live_trading',
                'group' => 'user',
                'description' => 'Canlı işlem',
                'context' => 'web',
                'translations' => [
                    1 => 'Canlı İşlem',
                    2 => 'Живая торговля'
                ]
            ],
            [
                'key' => 'user.dashboard.live_trading_desc',
                'group' => 'user',
                'description' => 'Canlı işlem açıklaması',
                'context' => 'web',
                'translations' => [
                    1 => 'Piyasada işlem yapın',
                    2 => 'Торговля на рынке'
                ]
            ],
            [
                'key' => 'user.dashboard.profile_settings',
                'group' => 'user',
                'description' => 'Profil ayarları',
                'context' => 'web',
                'translations' => [
                    1 => 'Profil Ayarları',
                    2 => 'Настройки Профиля'
                ]
            ],
            [
                'key' => 'user.dashboard.account_history',
                'group' => 'user',
                'description' => 'Hesap geçmişi',
                'context' => 'web',
                'translations' => [
                    1 => 'Hesap Geçmişi',
                    2 => 'История Счета'
                ]
            ],
            [
                'key' => 'user.dashboard.support_center',
                'group' => 'user',
                'description' => 'Destek merkezi',
                'context' => 'web',
                'translations' => [
                    1 => 'Destek Merkezi',
                    2 => 'Центр Поддержки'
                ]
            ],
            [
                'key' => 'user.dashboard.secure_logout',
                'group' => 'user',
                'description' => 'Güvenli çıkış',
                'context' => 'web',
                'translations' => [
                    1 => 'Güvenli Çıkış',
                    2 => 'Безопасный Выход'
                ]
            ],

            // User Top Menu
            [
                'key' => 'user.topmenu.verified',
                'group' => 'user',
                'description' => 'Doğrulandı durumu',
                'context' => 'web',
                'translations' => [
                    1 => 'Doğrulandı',
                    2 => 'Подтвержден'
                ]
            ],
            [
                'key' => 'user.topmenu.kyc_verification',
                'group' => 'user',
                'description' => 'KYC doğrulama',
                'context' => 'web',
                'translations' => [
                    1 => 'KYC Doğrulama',
                    2 => 'Верификация KYC'
                ]
            ],
            [
                'key' => 'user.topmenu.submission_under_review',
                'group' => 'user',
                'description' => 'Gönderim inceleme altında',
                'context' => 'web',
                'translations' => [
                    1 => 'Gönderiminiz inceleme altında',
                    2 => 'Ваша заявка рассматривается'
                ]
            ],
            [
                'key' => 'user.topmenu.verify_account',
                'group' => 'user',
                'description' => 'Hesabı doğrula',
                'context' => 'web',
                'translations' => [
                    1 => 'Hesabı Doğrula',
                    2 => 'Подтвердить Аккаунт'
                ]
            ],
            [
                'key' => 'user.topmenu.hello',
                'group' => 'user',
                'description' => 'Merhaba mesajı (parametreli)',
                'context' => 'web',
                'parameters' => 'name',
                'translations' => [
                    1 => 'Merhaba, :name!',
                    2 => 'Привет, :name!'
                ]
            ],
            [
                'key' => 'user.topmenu.my_profile',
                'group' => 'user',
                'description' => 'Profilim',
                'context' => 'web',
                'translations' => [
                    1 => 'Profilim',
                    2 => 'Мой Профиль'
                ]
            ],
            [
                'key' => 'user.topmenu.logout',
                'group' => 'user',
                'description' => 'Çıkış',
                'context' => 'web',
                'translations' => [
                    1 => 'Çıkış',
                    2 => 'Выход'
                ]
            ],
            [
                'key' => 'user.topmenu.notifications',
                'group' => 'user',
                'description' => 'Bildirimler',
                'context' => 'web',
                'translations' => [
                    1 => 'Bildirimler',
                    2 => 'Уведомления'
                ]
            ],
            [
                'key' => 'user.topmenu.mark_all_read',
                'group' => 'user',
                'description' => 'Tümünü okundu işaretle',
                'context' => 'web',
                'translations' => [
                    1 => 'Tümünü okundu olarak işaretle',
                    2 => 'Отметить все как прочитанные'
                ]
            ],
            [
                'key' => 'user.topmenu.no_notifications',
                'group' => 'user',
                'description' => 'Bildirim yok',
                'context' => 'web',
                'translations' => [
                    1 => 'Bildirim yok',
                    2 => 'Нет уведомлений'
                ]
            ],
            [
                'key' => 'user.topmenu.view_all_notifications',
                'group' => 'user',
                'description' => 'Tüm bildirimleri görüntüle',
                'context' => 'web',
                'translations' => [
                    1 => 'Tüm bildirimleri görüntüle',
                    2 => 'Просмотреть все уведомления'
                ]
            ]
        ];

        $this->command->info('Header phrases ekleniyor...');

        foreach ($phrases as $phraseData) {
            $phrase = Phrase::create([
                'key' => $phraseData['key'],
                'group' => $phraseData['group'],
                'description' => $phraseData['description'],
                'context' => $phraseData['context'],
                'parameters' => $phraseData['parameters'] ?? null,
                'is_active' => true,
                'usage_count' => 0,
                'last_used_at' => null,
            ]);

            foreach ($phraseData['translations'] as $languageId => $translation) {
                PhraseTranslation::create([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId,
                    'translation' => $translation,
                    'plural_translation' => null,
                    'metadata' => null,
                    'is_reviewed' => true,
                    'needs_update' => false,
                ]);
            }

            $this->command->line("✓ {$phraseData['key']}");
        }

        $totalPhrases = count($phrases);
        $this->command->info("Toplam {$totalPhrases} header phrase başarıyla eklendi.");
    }
}