<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminReferralSettingsPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Page Header
            'admin.referral.page_title' => [
                'tr' => 'Tavsiye/Bonus Ayarları',
                'ru' => 'Настройки рефералов/бонусов'
            ],
            'admin.referral.page_subtitle' => [
                'tr' => 'Referral komisyonları ve kullanıcı bonuslarını yapılandırın',
                'ru' => 'Настройте реферальные комиссии и пользовательские бонусы'
            ],
            'admin.referral.finance_system' => [
                'tr' => 'Finans Sistemi',
                'ru' => 'Финансовая система'
            ],

            // Commission Settings
            'admin.referral.commission_settings' => [
                'tr' => 'Referral Komisyon Ayarları',
                'ru' => 'Настройки реферальных комиссий'
            ],
            'admin.referral.commission_description' => [
                'tr' => '6 seviyeli komisyon sistemi yapılandırması',
                'ru' => 'Настройка 6-уровневой комиссионной системы'
            ],
            'admin.referral.commission_levels' => [
                'tr' => 'Komisyon Seviyeleri',
                'ru' => 'Уровни комиссий'
            ],

            // Commission Levels
            'admin.referral.level_1_direct' => [
                'tr' => '1. Seviye Komisyon (Direkt Referral)',
                'ru' => '1-й уровень комиссии (прямой реферал)'
            ],
            'admin.referral.level_1_description' => [
                'tr' => 'Doğrudan davet edilen kullanıcılardan',
                'ru' => 'От напрямую приглашенных пользователей'
            ],
            'admin.referral.level_2' => [
                'tr' => '2. Seviye Komisyon',
                'ru' => '2-й уровень комиссии'
            ],
            'admin.referral.level_2_description' => [
                'tr' => '2. seviye alt referrallardan',
                'ru' => 'От рефералов 2-го уровня'
            ],
            'admin.referral.level_3' => [
                'tr' => '3. Seviye Komisyon',
                'ru' => '3-й уровень комиссии'
            ],
            'admin.referral.level_3_description' => [
                'tr' => '3. seviye alt referrallardan',
                'ru' => 'От рефералов 3-го уровня'
            ],
            'admin.referral.level_4' => [
                'tr' => '4. Seviye Komisyon',
                'ru' => '4-й уровень комиссии'
            ],
            'admin.referral.level_4_description' => [
                'tr' => '4. seviye alt referrallardan',
                'ru' => 'От рефералов 4-го уровня'
            ],
            'admin.referral.level_5' => [
                'tr' => '5. Seviye Komisyon',
                'ru' => '5-й уровень комиссии'
            ],
            'admin.referral.level_5_description' => [
                'tr' => '5. seviye alt referrallardan',
                'ru' => 'От рефералов 5-го уровня'
            ],
            'admin.referral.level_6' => [
                'tr' => '6. Seviye Komisyon',
                'ru' => '6-й уровень комиссии'
            ],
            'admin.referral.level_6_description' => [
                'tr' => '6. seviye alt referrallardan',
                'ru' => 'От рефералов 6-го уровня'
            ],

            // System Information
            'admin.referral.system_info_title' => [
                'tr' => 'Referral Komisyon Sistemi',
                'ru' => 'Система реферальных комиссий'
            ],
            'admin.referral.system_info_description' => [
                'tr' => 'Her kullanıcı kendi referral ağından gelen yatırımlardan belirtilen yüzde oranında komisyon alır. Komisyonlar otomatik olarak hesaplanır ve kullanıcı bakiyesine eklenir.',
                'ru' => 'Каждый пользователь получает комиссию в указанном процентном соотношении с инвестиций, поступающих от его реферальной сети. Комиссии автоматически рассчитываются и добавляются к балансу пользователя.'
            ],
            'admin.referral.save_commission' => [
                'tr' => 'Komisyon Ayarlarını Kaydet',
                'ru' => 'Сохранить настройки комиссий'
            ],

            // Bonus Settings
            'admin.referral.bonus_settings' => [
                'tr' => 'Kullanıcı Bonus Ayarları',
                'ru' => 'Настройки пользовательских бонусов'
            ],
            'admin.referral.bonus_description' => [
                'tr' => 'Kayıt ve yatırım bonusları yapılandırması',
                'ru' => 'Настройка бонусов за регистрацию и инвестиции'
            ],
            'admin.referral.bonus_types' => [
                'tr' => 'Bonus Türleri',
                'ru' => 'Типы бонусов'
            ],

            // Signup Bonus
            'admin.referral.signup_bonus' => [
                'tr' => 'Kayıt Bonusu',
                'ru' => 'Бонус за регистрацию'
            ],
            'admin.referral.signup_bonus_desc' => [
                'tr' => 'Yeni kayıt olan kullanıcılara verilen hoş geldin bonusu',
                'ru' => 'Приветственный бонус для новых зарегистрированных пользователей'
            ],
            'admin.referral.bonus_amount' => [
                'tr' => 'Bonus Miktarı (:currency)',
                'ru' => 'Сумма бонуса (:currency)'
            ],
            'admin.referral.signup_bonus_note' => [
                'tr' => '0 girerseniz kayıt bonusu verilmez. Bu miktar yeni kayıt olan her kullanıcının hesabına otomatik eklenir.',
                'ru' => 'Если введете 0, бонус за регистрацию не предоставляется. Эта сумма автоматически добавляется на счет каждого нового зарегистрированного пользователя.'
            ],

            // Deposit Bonus
            'admin.referral.deposit_bonus' => [
                'tr' => 'Yatırım Bonusu',
                'ru' => 'Бонус за депозит'
            ],
            'admin.referral.deposit_bonus_desc' => [
                'tr' => 'Her yatırım için verilen yüzde bonus',
                'ru' => 'Процентный бонус за каждый депозит'
            ],
            'admin.referral.bonus_percentage' => [
                'tr' => 'Bonus Yüzdesi (%)',
                'ru' => 'Процент бонуса (%)'
            ],
            'admin.referral.deposit_bonus_note' => [
                'tr' => 'Sistem kullanıcı yatırım miktarının belirttiğiniz yüzdesi kadar bonusu hesaplayarak bakiyesine ekler (her yatırım için).',
                'ru' => 'Система рассчитывает бонус в указанном проценте от суммы инвестиции пользователя и добавляет его к балансу (за каждую инвестицию).'
            ],

            // Calculation Example
            'admin.referral.calculation_example' => [
                'tr' => 'Bonus Hesaplama Örneği',
                'ru' => 'Пример расчета бонуса'
            ],
            'admin.referral.calculation_example_text' => [
                'tr' => 'Yatırım bonusu %10 ise, kullanıcı $1000 yatırım yaptığında $100 bonus alacaktır. Kayıt bonusu $50 ise, her yeni kullanıcı kayıt olduktan sonra hesabında $50 bulacaktır.',
                'ru' => 'Если бонус за депозит составляет 10%, то при инвестиции $1000 пользователь получит $100 бонуса. Если бонус за регистрацию составляет $50, то каждый новый пользователь найдет $50 на своем счету после регистрации.'
            ],
            'admin.referral.save_bonus' => [
                'tr' => 'Bonus Ayarlarını Kaydet',
                'ru' => 'Сохранить настройки бонусов'
            ],

            // System Information Section
            'admin.referral.system_information' => [
                'tr' => 'Sistem Bilgileri',
                'ru' => 'Системная информация'
            ],
            'admin.referral.currency' => [
                'tr' => 'Para Birimi',
                'ru' => 'Валюта'
            ],
            'admin.referral.referral_system' => [
                'tr' => 'Referral Sistemi',
                'ru' => 'Реферальная система'
            ],
            'admin.referral.six_levels_active' => [
                'tr' => '6 Seviye Aktif',
                'ru' => '6 уровней активно'
            ],
            'admin.referral.bonus_system' => [
                'tr' => 'Bonus Sistemi',
                'ru' => 'Бонусная система'
            ],
            'admin.referral.automatic_calculation' => [
                'tr' => 'Otomatik Hesaplama',
                'ru' => 'Автоматический расчет'
            ],

            // Success Messages
            'admin.referral.commission_updated' => [
                'tr' => 'Referral komisyon ayarları başarıyla güncellendi!',
                'ru' => 'Настройки реферальных комиссий успешно обновлены!'
            ],
            'admin.referral.bonus_updated' => [
                'tr' => 'Bonus ayarları başarıyla güncellendi!',
                'ru' => 'Настройки бонусов успешно обновлены!'
            ],

            // Dynamic Example Text Parts (for JavaScript)
            'admin.referral.dynamic_example_text' => [
                'tr' => 'Yatırım bonusu %',
                'ru' => 'Бонус за депозит '
            ],
            'admin.referral.dynamic_example_middle' => [
                'tr' => ' ise, kullanıcı ',
                'ru' => '%, при инвестиции пользователем '
            ],
            'admin.referral.dynamic_example_end' => [
                'tr' => ' yatırım yaptığında ',
                'ru' => ' он получит '
            ],
            'admin.referral.dynamic_example_signup' => [
                'tr' => ' bonus alacaktır. Kayıt bonusu miktarı ne olarak ayarlandıysa, her yeni kullanıcı kayıt olduktan sonra hesabında o miktarı bulacaktır.',
                'ru' => ' бонуса. Какая бы сумма ни была установлена как бонус за регистрацию, каждый новый пользователь найдет эту сумму на своем счету после регистрации.'
            ]
        ];

        // Language mappings
        $languages = [
            'tr' => 1, // Turkish
            'ru' => 2  // Russian
        ];

        foreach ($phrases as $key => $translations) {
            try {
                // Create or update phrase
                $phrase = Phrase::updateOrCreate(
                    ['key' => $key, 'group' => 'admin'],
                    ['description' => 'Admin referral settings - ' . $key]
                );

                // Create or update translations
                foreach ($languages as $langCode => $langId) {
                    if (isset($translations[$langCode])) {
                        PhraseTranslation::updateOrCreate(
                            ['phrase_id' => $phrase->id, 'language_id' => $langId],
                            ['translation' => $translations[$langCode]]
                        );
                    }
                }

                echo "✓ Created/updated phrase: {$key}\n";
            } catch (\Exception $e) {
                echo "✗ Error creating phrase {$key}: " . $e->getMessage() . "\n";
            }
        }

        echo "\n" . count($phrases) . " referral settings phrases seeded successfully!\n";
    }
}