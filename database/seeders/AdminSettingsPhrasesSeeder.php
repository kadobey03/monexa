<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminSettingsPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // Referral Settings Phrases
                [
                    'key' => 'admin.settings.referral.direct_commission',
                    'tr' => 'Direkt Referral Komisyonu (%)',
                    'ru' => 'Прямая реферальная комиссия (%)'
                ],
                [
                    'key' => 'admin.settings.referral.indirect_commission_1',
                    'tr' => 'Dolaylı Referral Komisyonu 1 (%)',
                    'ru' => 'Косвенная реферальная комиссия 1 (%)'
                ],
                [
                    'key' => 'admin.settings.referral.indirect_commission_2',
                    'tr' => 'Dolaylı Referral Komisyonu 2 (%)',
                    'ru' => 'Косвенная реферальная комиссия 2 (%)'
                ],
                [
                    'key' => 'admin.settings.referral.indirect_commission_3',
                    'tr' => 'Dolaylı Referral Komisyonu 3 (%)',
                    'ru' => 'Косвенная реферальная комиссия 3 (%)'
                ],
                [
                    'key' => 'admin.settings.referral.indirect_commission_4',
                    'tr' => 'Dolaylı Referral Komisyonu 4 (%)',
                    'ru' => 'Косвенная реферальная комиссия 4 (%)'
                ],
                [
                    'key' => 'admin.settings.referral.indirect_commission_5',
                    'tr' => 'Dolaylı Referral Komisyonu 5 (%)',
                    'ru' => 'Косвенная реферальная комиссия 5 (%)'
                ],

                // Bonus Settings Phrases
                [
                    'key' => 'admin.settings.bonus.registration_bonus',
                    'tr' => 'Kayıt/Hoşgeldin Bonusu',
                    'ru' => 'Регистрационный/Приветственный бонус'
                ],
                [
                    'key' => 'admin.settings.bonus.registration_bonus_description',
                    'tr' => 'Yeni kayıt bonusu yeni kullanıcıların hesabına eklenir.',
                    'ru' => 'Бонус за новую регистрацию добавляется на счет новых пользователей.'
                ],
                [
                    'key' => 'admin.settings.bonus.deposit_bonus',
                    'tr' => 'Yatırım Bonusu (%)',
                    'ru' => 'Бонус за депозит (%)'
                ],
                [
                    'key' => 'admin.settings.bonus.deposit_bonus_description',
                    'tr' => 'Kullanıcı yatırımı için bonus miktarı belirleyebilirsiniz. Sistem, belirttiğiniz yüzde miktarını kullanıcının yatırım miktarıyla hesaplayıp bonus olarak ekler (Her yatırım için).',
                    'ru' => 'Вы можете указать сумму бонуса для депозита пользователя. Система рассчитывает указанный вами процент от суммы депозита пользователя и добавляет его в качестве бонуса (для каждого депозита).'
                ],

                // Crypto/Exchange Settings Phrases
                [
                    'key' => 'admin.settings.crypto.assets_exchange_settings',
                    'tr' => 'Kripto Varlıkları/Borsa Ayarları',
                    'ru' => 'Настройки криптовалют/биржи'
                ],
                [
                    'key' => 'admin.settings.crypto.use_feature',
                    'tr' => 'Bu Özelliği Kullan',
                    'ru' => 'Использовать эту функцию'
                ],
                [
                    'key' => 'admin.settings.crypto.service_disabled_notice',
                    'tr' => 'Kapatılırsa kullanıcılarınız bu servisi göremez/kullanamaz',
                    'ru' => 'Ваши пользователи не смогут видеть/использовать эту услугу, если она отключена'
                ],
                [
                    'key' => 'admin.settings.crypto.exchange_fee',
                    'tr' => 'Borsa Ücreti',
                    'ru' => 'Комиссия биржи'
                ],
                [
                    'key' => 'admin.settings.crypto.usd_rate',
                    'tr' => 'USD Oranı',
                    'ru' => 'Курс USD'
                ],
                [
                    'key' => 'admin.settings.crypto.rate_description',
                    'tr' => 'Bu oran, kullanıcılarınızın kripto eşdeğerini seçtiğiniz para biriminde hesaplamak için kullanılacaktır.',
                    'ru' => 'Этот курс будет использоваться для расчета криптоэквивалента ваших пользователей в выбранной вами валюте.'
                ],
                [
                    'key' => 'admin.settings.crypto.asset_name',
                    'tr' => 'Varlık Adı',
                    'ru' => 'Название актива'
                ],
                [
                    'key' => 'admin.settings.crypto.asset_symbol',
                    'tr' => 'Varlık Sembolü',
                    'ru' => 'Символ актива'
                ],
                [
                    'key' => 'admin.settings.crypto.disable_warning',
                    'tr' => 'Varlığı devre dışı bırakmadan önce, kullanıcılarınızın hiçbirinin varlık hesabında 0\'dan büyük bakiyesi olmadığından emin olun.',
                    'ru' => 'Убедитесь, что ни у одного из ваших пользователей нет баланса больше 0 на их счете актива, прежде чем отключать актив.'
                ],

                // Common Settings Phrases
                [
                    'key' => 'admin.settings.common.update_button',
                    'tr' => 'Güncelle',
                    'ru' => 'Обновить'
                ],
                [
                    'key' => 'admin.settings.common.save_button',
                    'tr' => 'Kaydet',
                    'ru' => 'Сохранить'
                ],
                [
                    'key' => 'admin.settings.common.on',
                    'tr' => 'Açık',
                    'ru' => 'Включено'
                ],
                [
                    'key' => 'admin.settings.common.off',
                    'tr' => 'Kapalı',
                    'ru' => 'Выключено'
                ],
                [
                    'key' => 'admin.settings.common.status',
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                [
                    'key' => 'admin.settings.common.option',
                    'tr' => 'Seçenek',
                    'ru' => 'Опция'
                ],
                [
                    'key' => 'admin.settings.common.success',
                    'tr' => 'Başarılı',
                    'ru' => 'Успешно'
                ],
                [
                    'key' => 'admin.settings.common.error',
                    'tr' => 'Hata',
                    'ru' => 'Ошибка'
                ],
                [
                    'key' => 'admin.settings.common.processing',
                    'tr' => 'İşleniyor',
                    'ru' => 'Обработка'
                ],
                [
                    'key' => 'admin.settings.common.error_occurred',
                    'tr' => 'Bir hata oluştu',
                    'ru' => 'Произошла ошибка'
                ],
                [
                    'key' => 'admin.settings.common.connection_error',
                    'tr' => 'Bağlantı hatası oluştu',
                    'ru' => 'Произошла ошибка соединения'
                ]
            ];

            foreach ($phrases as $phraseData) {
                // Create or find the phrase
                $phrase = Phrase::firstOrCreate([
                    'key' => $phraseData['key']
                ]);

                // Create Turkish translation (language_id = 1)
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 1
                    ],
                    [
                        'translation' => $phraseData['tr']
                    ]
                );

                // Create Russian translation (language_id = 2)  
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 2
                    ],
                    [
                        'translation' => $phraseData['ru']
                    ]
                );
            }
        });

        $this->command->info('Admin Settings phrases seeded successfully! Added ' . count($this->getPhrasesData()) . ' phrases with Turkish and Russian translations.');
    }

    private function getPhrasesData()
    {
        return [
            // This matches the phrases array above for counting purposes
            'admin.settings.referral.direct_commission',
            'admin.settings.referral.indirect_commission_1',
            'admin.settings.referral.indirect_commission_2',
            'admin.settings.referral.indirect_commission_3',
            'admin.settings.referral.indirect_commission_4',
            'admin.settings.referral.indirect_commission_5',
            'admin.settings.bonus.registration_bonus',
            'admin.settings.bonus.registration_bonus_description',
            'admin.settings.bonus.deposit_bonus',
            'admin.settings.bonus.deposit_bonus_description',
            'admin.settings.crypto.assets_exchange_settings',
            'admin.settings.crypto.use_feature',
            'admin.settings.crypto.service_disabled_notice',
            'admin.settings.crypto.exchange_fee',
            'admin.settings.crypto.usd_rate',
            'admin.settings.crypto.rate_description',
            'admin.settings.crypto.asset_name',
            'admin.settings.crypto.asset_symbol',
            'admin.settings.crypto.disable_warning',
            'admin.settings.common.update_button',
            'admin.settings.common.save_button',
            'admin.settings.common.on',
            'admin.settings.common.off',
            'admin.settings.common.status',
            'admin.settings.common.option',
            'admin.settings.common.success',
            'admin.settings.common.error',
            'admin.settings.common.processing',
            'admin.settings.common.error_occurred',
            'admin.settings.common.connection_error'
        ];
    }
}