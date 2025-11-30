<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserPlanDetailsPhrasesSeeder extends Seeder
{
    public function run(): void
    {
        $phrases = [
            // plan-details.blade.php specific phrases  
            'user.plans.my_investments' => [
                'tr' => 'Yatırımlarım',
                'ru' => 'Мои Инвестиции'
            ],
            'user.plans.investment_plan_details' => [
                'tr' => 'Yatırım Planı Detayları',
                'ru' => 'Детали Инвестиционного Плана'
            ],
            'user.plans.track_performance' => [
                'tr' => 'Yatırımınızın performansını takip edin',
                'ru' => 'Отслеживайте эффективность ваших инвестиций'
            ],
            'user.plans.back_to_investments' => [
                'tr' => 'Yatırımlara Geri Dön',
                'ru' => 'Вернуться к Инвестициям'
            ],
            'user.plans.invested_amount' => [
                'tr' => 'Yatırım Tutarı',
                'ru' => 'Инвестированная Сумма'
            ],
            'user.plans.current_value' => [
                'tr' => 'Güncel Değer',
                'ru' => 'Текущая Стоимость'
            ],
            'user.plans.progress' => [
                'tr' => 'İlerleme',
                'ru' => 'Прогресс'
            ],
            'user.plans.started_on' => [
                'tr' => 'Başlangıç Tarihi',
                'ru' => 'Дата Начала'
            ],
            'user.plans.ends_on' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата Окончания'
            ],
            'user.plans.complete_payment' => [
                'tr' => 'Ödemeyi Tamamla',
                'ru' => 'Завершить Оплату'
            ],
            'user.plans.cancel_confirm' => [
                'tr' => 'Bu planı iptal etmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите отменить этот план?'
            ],
            'user.plans.cancel' => [
                'tr' => 'İptal Et',
                'ru' => 'Отменить'
            ],
            'user.plans.reinvest_profits' => [
                'tr' => 'Karları Yeniden Yatır',
                'ru' => 'Реинвестировать Прибыль'
            ],
            'user.plans.compound_interest' => [
                'tr' => 'Bileşik Faiz',
                'ru' => 'Сложные Проценты'
            ],
            'user.plans.withdraw_profits' => [
                'tr' => 'Karları Çek',
                'ru' => 'Вывести Прибыль'
            ],
            'user.plans.view_contract' => [
                'tr' => 'Sözleşmeyi Görüntüle',
                'ru' => 'Посмотреть Договор'
            ],
            'user.plans.print_details' => [
                'tr' => 'Detayları Yazdır',
                'ru' => 'Печать Деталей'
            ],
            'user.plans.plan_features' => [
                'tr' => 'Plan Özellikleri',
                'ru' => 'Особенности Плана'
            ],
            'user.plans.about_this_plan' => [
                'tr' => 'Bu Plan Hakkında',
                'ru' => 'Об Этом Плане'
            ],
            'user.plans.investment_information' => [
                'tr' => 'Yatırım Bilgileri',
                'ru' => 'Информация об Инвестиции'
            ],
            'user.plans.risk_level' => [
                'tr' => 'Risk Seviyesi',
                'ru' => 'Уровень Риска'
            ],
            'user.plans.low' => [
                'tr' => 'Düşük',
                'ru' => 'Низкий'
            ],
            'user.plans.medium' => [
                'tr' => 'Orта',
                'ru' => 'Средний'
            ],
            'user.plans.high' => [
                'tr' => 'Yüksek',
                'ru' => 'Высокий'
            ],
            'user.plans.category' => [
                'tr' => 'Kategori',
                'ru' => 'Категория'
            ],
            'user.plans.plan_details' => [
                'tr' => 'Plan Detayları',
                'ru' => 'Детали Плана'
            ],
            'user.plans.min_investment' => [
                'tr' => 'Minimum Yatırım',
                'ru' => 'Минимальная Инвестиция'
            ],
            'user.plans.max_investment' => [
                'tr' => 'Maksimum Yatırım',
                'ru' => 'Максимальная Инвестиция'
            ],
            'user.plans.return_period' => [
                'tr' => 'Getiri Periyodu',
                'ru' => 'Период Возврата'
            ],
            'user.plans.referral_bonus' => [
                'tr' => 'Referans Bonusu',
                'ru' => 'Реферальный Бонус'
            ],
            'user.plans.earning_history' => [
                'tr' => 'Kazanç Geçmişi',
                'ru' => 'История Доходов'
            ],
            'user.plans.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'user.plans.type' => [
                'tr' => 'Tip',
                'ru' => 'Тип'
            ],
            'user.plans.no_earnings_yet' => [
                'tr' => 'Henüz Kazanç Yok',
                'ru' => 'Пока Нет Доходов'
            ],
            'user.plans.no_payouts_message' => [
                'tr' => 'Bu yatırım için henüz herhangi bir ödeme almadınız.',
                'ru' => 'Вы еще не получили никаких выплат по этой инвестиции.'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            // Add translations for each language
            foreach ($translations as $langCode => $translation) {
                $languageId = ($langCode === 'tr') ? 1 : 2; // Turkish = 1, Russian = 2
                
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ],
                    [
                        'translation' => $translation
                    ]
                );
            }
        }

        $this->command->info('User plan details phrases seeded successfully! Total phrases: ' . count($phrases));
    }
}