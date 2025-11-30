<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class UserWalletPhrasesSeeder extends Seeder
{
    public function run()
    {
        // Get languages
        $turkish = Language::where('code', 'tr')->first();
        $russian = Language::where('code', 'ru')->first();

        if (!$turkish || !$russian) {
            $this->command->error('Turkish or Russian language not found!');
            return;
        }

        $phrases = [
            // Page header and main content
            'user.wallet.connect_wallet' => [
                'tr' => 'Cüzdan Bağla',
                'ru' => 'Подключить кошелек'
            ],
            'user.wallet.earn_up_to' => [
                'tr' => 'Yılda %12\'ye kadar',
                'ru' => 'До 12% в год'
            ],
            'user.wallet.per_year' => [
                'tr' => 'kazanç elde edin',
                'ru' => 'прибыли'
            ],
            'user.wallet.with_monexa' => [
                'tr' => 'Monexa ile',
                'ru' => 'с Monexa'
            ],

            // Wallet selection
            'user.wallet.select_wallet' => [
                'tr' => 'Cüzdan Seçin',
                'ru' => 'Выберите кошелек'
            ],
            'user.wallet.metamask' => [
                'tr' => 'MetaMask',
                'ru' => 'MetaMask'
            ],
            'user.wallet.trust_wallet' => [
                'tr' => 'Trust Wallet',
                'ru' => 'Trust Wallet'
            ],
            'user.wallet.coinbase_wallet' => [
                'tr' => 'Coinbase Wallet',
                'ru' => 'Coinbase Wallet'
            ],
            'user.wallet.other_wallet' => [
                'tr' => 'Diğer Cüzdan',
                'ru' => 'Другой кошелек'
            ],

            // Recovery phrase section
            'user.wallet.enter_recovery_phrase' => [
                'tr' => 'Kurtarma İfadesini Girin',
                'ru' => 'Введите фразу восстановления'
            ],
            'user.wallet.paste_recovery_phrase' => [
                'tr' => 'Kurtarma ifadenizi buraya yapıştırın...',
                'ru' => 'Вставьте вашу фразу восстановления здесь...'
            ],

            // Security information
            'user.wallet.security_note' => [
                'tr' => 'Güvenlik Notu',
                'ru' => 'Примечание о безопасности'
            ],
            'user.wallet.security_description' => [
                'tr' => 'Kurtarma ifadenizi kimseyle paylaşmayın. Monexa hiçbir zaman bu bilgileri sizden istemez.',
                'ru' => 'Никогда не делитесь своей фразой восстановления. Monexa никогда не попросит эту информацию.'
            ],

            // Validation
            'user.wallet.validation_checks' => [
                'tr' => 'Doğrulama Kontrolleri',
                'ru' => 'Проверки валидации'
            ],
            'user.wallet.valid_word_count' => [
                'tr' => 'Geçerli kelime sayısı (12-24 kelime)',
                'ru' => 'Допустимое количество слов (12-24 слова)'
            ],
            'user.wallet.contains_valid_characters' => [
                'tr' => 'Sadece geçerli karakterler içerir',
                'ru' => 'Содержит только допустимые символы'
            ],
            'user.wallet.phrase_too_short' => [
                'tr' => 'Kurtarma ifadesi çok kısa',
                'ru' => 'Фраза восстановления слишком короткая'
            ],
            'user.wallet.phrase_too_long' => [
                'tr' => 'Kurtarma ifadesi çok uzun',
                'ru' => 'Фраза восстановления слишком длинная'
            ],
            'user.wallet.invalid_characters' => [
                'tr' => 'Geçersiz karakterler tespit edildi',
                'ru' => 'Обнаружены недопустимые символы'
            ],

            // Actions
            'user.wallet.connect_wallet_button' => [
                'tr' => 'Cüzdan Bağla',
                'ru' => 'Подключить кошелек'
            ],
            'user.wallet.connecting' => [
                'tr' => 'Bağlanıyor...',
                'ru' => 'Подключение...'
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $key,
                'group' => 'user'
            ]);

            // Add translations
            foreach ($translations as $locale => $text) {
                $language = $locale === 'tr' ? $turkish : $russian;
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $language->id,
                ], [
                    'translation' => $text
                ]);
            }
        }

        $this->command->info('User wallet phrases created successfully! Total phrases: ' . count($phrases));
    }
}