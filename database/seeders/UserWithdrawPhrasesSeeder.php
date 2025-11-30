<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserWithdrawPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Main Header
            [
                'key' => 'user.withdraw.title',
                'translations' => [
                    1 => 'Fon Çek',
                    2 => 'Вывод средств'
                ]
            ],
            [
                'key' => 'user.withdraw.description',
                'translations' => [
                    1 => 'Fonlarınızı hızlı ve güvenli bir şekilde çekin',
                    2 => 'Быстрый и безопасный вывод ваших средств'
                ]
            ],

            // Navigation
            [
                'key' => 'user.withdraw.back_to_dashboard',
                'translations' => [
                    1 => 'Gösterge Paneline Dön',
                    2 => 'Вернуться к панели управления'
                ]
            ],
            [
                'key' => 'user.withdraw.home',
                'translations' => [
                    1 => 'Ana Sayfa',
                    2 => 'Главная'
                ]
            ],
            [
                'key' => 'user.withdraw.withdrawal',
                'translations' => [
                    1 => 'Çekim',
                    2 => 'Вывод'
                ]
            ],

            // Withdrawal Form
            [
                'key' => 'user.withdraw.complete_request',
                'translations' => [
                    1 => 'Çekim talebinizi tamamlayın',
                    2 => 'Завершите запрос на вывод'
                ]
            ],
            [
                'key' => 'user.withdraw.amount_label',
                'translations' => [
                    1 => 'Çekilecek tutar',
                    2 => 'Сумма для вывода'
                ]
            ],
            [
                'key' => 'user.withdraw.amount_placeholder',
                'translations' => [
                    1 => 'Çekilecek tutarı girin',
                    2 => 'Введите сумму для вывода'
                ]
            ],
            [
                'key' => 'user.withdraw.available_balance',
                'translations' => [
                    1 => 'Kullanılabilir bakiye',
                    2 => 'Доступный баланс'
                ]
            ],

            // Bank Transfer Fields
            [
                'key' => 'user.withdraw.bank_details',
                'translations' => [
                    1 => 'Bank Detayları',
                    2 => 'Банковские реквизиты'
                ]
            ],
            [
                'key' => 'user.withdraw.bank_name',
                'translations' => [
                    1 => 'Bank Adı',
                    2 => 'Название банка'
                ]
            ],
            [
                'key' => 'user.withdraw.bank_name_placeholder',
                'translations' => [
                    1 => 'Bank adını girin',
                    2 => 'Введите название банка'
                ]
            ],
            [
                'key' => 'user.withdraw.account_name',
                'translations' => [
                    1 => 'Hesap Adı',
                    2 => 'Имя владельца счета'
                ]
            ],
            [
                'key' => 'user.withdraw.account_name_placeholder',
                'translations' => [
                    1 => 'Hesap adını girin',
                    2 => 'Введите имя владельца счета'
                ]
            ],
            [
                'key' => 'user.withdraw.account_number',
                'translations' => [
                    1 => 'Hesap Numarası',
                    2 => 'Номер счета'
                ]
            ],
            [
                'key' => 'user.withdraw.account_number_placeholder',
                'translations' => [
                    1 => 'Hesap numarasını girin',
                    2 => 'Введите номер счета'
                ]
            ],
            [
                'key' => 'user.withdraw.swift_code',
                'translations' => [
                    1 => 'Swift Kodu',
                    2 => 'SWIFT код'
                ]
            ],
            [
                'key' => 'user.withdraw.swift_code_placeholder',
                'translations' => [
                    1 => 'Swift kodunu girin',
                    2 => 'Введите SWIFT код'
                ]
            ],

            // Crypto Wallet Fields
            [
                'key' => 'user.withdraw.wallet_address',
                'translations' => [
                    1 => 'Wallet Address',
                    2 => 'Адрес кошелька'
                ]
            ],
            [
                'key' => 'user.withdraw.wallet_placeholder',
                'translations' => [
                    1 => 'cüzdan adresini girin',
                    2 => 'введите адрес кошелька'
                ]
            ],
            [
                'key' => 'user.withdraw.wallet_warning',
                'translations' => [
                    1 => 'Fon kaybından kaçınmak için lütfen doğru cüzdan adresini girdiğinizden emin olun',
                    2 => 'Пожалуйста, убедитесь, что вы вводите правильный адрес кошелька, чтобы избежать потери средств'
                ]
            ],

            // Submit Button
            [
                'key' => 'user.withdraw.complete_withdrawal',
                'translations' => [
                    1 => 'Çekimi Tamamla',
                    2 => 'Завершить вывод'
                ]
            ],

            // Withdrawal Information
            [
                'key' => 'user.withdraw.withdrawal_info',
                'translations' => [
                    1 => 'Çekim Bilgileri',
                    2 => 'Информация о выводе'
                ]
            ],
            [
                'key' => 'user.withdraw.processing_time',
                'translations' => [
                    1 => 'Çekimler genellikle 24 saat içinde işlenir',
                    2 => 'Выводы обычно обрабатываются в течение 24 часов'
                ]
            ],
            [
                'key' => 'user.withdraw.minimum_amount',
                'translations' => [
                    1 => 'Minimum çekim tutarı',
                    2 => 'Минимальная сумма вывода'
                ]
            ],
            [
                'key' => 'user.withdraw.fee_info',
                'translations' => [
                    1 => 'Tüm çekimlere',
                    2 => 'Ко всем выводам применяется комиссия в размере'
                ]
            ],
            [
                'key' => 'user.withdraw.fee_applied',
                'translations' => [
                    1 => 'ücret uygulanır',
                    2 => ''
                ]
            ],

            // Confirmation Modal
            [
                'key' => 'user.withdraw.confirm_withdrawal',
                'translations' => [
                    1 => 'Çekimi Onayla',
                    2 => 'Подтвердить вывод'
                ]
            ],
            [
                'key' => 'user.withdraw.confirm_message',
                'translations' => [
                    1 => 'tutarı',
                    2 => 'сумму'
                ]
            ],
            [
                'key' => 'user.withdraw.to_account',
                'translations' => [
                    1 => 'hesabınıza çekmek istediğinizden emin misiniz',
                    2 => 'на ваш счет, вы уверены'
                ]
            ],
            [
                'key' => 'user.withdraw.cancel',
                'translations' => [
                    1 => 'İptal',
                    2 => 'Отмена'
                ]
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or find phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $phraseData['key']
            ], [
                'description' => 'User Withdraw Page - ' . $phraseData['key']
            ]);

            // Add translations for each language
            foreach ($phraseData['translations'] as $languageId => $translation) {
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('✅ User Withdraw phrases seeder completed successfully!');
        $this->command->info('📊 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}