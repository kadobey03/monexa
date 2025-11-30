<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserPlanInvestmentPhrasesSeeder extends Seeder
{
    public function run(): void
    {
        $phrases = [
            // my-plans.blade.php phrases
            'user.plans.my_investment_plans' => [
                'tr' => 'Yatırım Planlarım',
                'ru' => 'Мои Инвестиционные Планы'
            ],
            'user.plans.total_invested' => [
                'tr' => 'Toplam Yatırım',
                'ru' => 'Общие Инвестиции'
            ],
            'user.plans.active_plans' => [
                'tr' => 'Aktif Planlar',
                'ru' => 'Активные Планы'
            ],
            'user.plans.total_profit' => [
                'tr' => 'Toplam Kar',
                'ru' => 'Общая Прибыль'
            ],
            'user.plans.all_plans' => [
                'tr' => 'Tüm Planlar',
                'ru' => 'Все Планы'
            ],
            'user.plans.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активные'
            ],
            'user.plans.completed' => [
                'tr' => 'Tamamlanan',
                'ru' => 'Завершенные'
            ],
            'user.plans.cancelled' => [
                'tr' => 'İptal Edilen',
                'ru' => 'Отмененные'
            ],
            'user.plans.no_investments_message' => [
                'tr' => 'Henüz hiç yatırımınız yok. İlk yatırımınızı yapmak için mevcut planlarımıza göz atın.',
                'ru' => 'У вас пока нет инвестиций. Ознакомьтесь с нашими доступными планами, чтобы сделать первую инвестицию.'
            ],
            'user.plans.invest_now' => [
                'tr' => 'Şimdi Yatırım Yap',
                'ru' => 'Инвестировать Сейчас'
            ],
            'user.plans.plan_name' => [
                'tr' => 'Plan Adı',
                'ru' => 'Название Плана'
            ],
            'user.plans.amount' => [
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            'user.plans.duration' => [
                'tr' => 'Süre',
                'ru' => 'Продолжительность'
            ],
            'user.plans.return_rate' => [
                'tr' => 'Getiri Oranı',
                'ru' => 'Доходность'
            ],
            'user.plans.status_text' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'user.plans.expected_return' => [
                'tr' => 'Beklenen Getiri',
                'ru' => 'Ожидаемая Прибыль'
            ],
            'user.plans.maturity_date' => [
                'tr' => 'Vade Tarihi',
                'ru' => 'Дата Погашения'
            ],
            'user.plans.days_left' => [
                'tr' => 'Kalan Gün',
                'ru' => 'Дней Осталось'
            ],
            'user.plans.view_details' => [
                'tr' => 'Detayları Görüntüle',
                'ru' => 'Посмотреть Детали'
            ],
            'user.plans.day' => [
                'tr' => 'Gün',
                'ru' => 'День'
            ],
            'user.plans.days' => [
                'tr' => 'Gün',
                'ru' => 'Дня'
            ],
            'user.plans.hour' => [
                'tr' => 'Saat',
                'ru' => 'Час'
            ],
            'user.plans.hours' => [
                'tr' => 'Saat',
                'ru' => 'Часа'
            ],
            'user.plans.minute' => [
                'tr' => 'Dakika',
                'ru' => 'Минута'
            ],
            'user.plans.minutes' => [
                'tr' => 'Dakika',
                'ru' => 'Минуты'
            ],

            // invest.blade.php phrases
            'user.plans.home' => [
                'tr' => 'Anasayfa',
                'ru' => 'Главная'
            ],
            'user.plans.investment_plans' => [
                'tr' => 'Yatırım Planları',
                'ru' => 'Инвестиционные Планы'
            ],
            'user.plans.invest' => [
                'tr' => 'Yatırım Yap',
                'ru' => 'Инвестировать'
            ],
            'user.plans.invest_in_plan' => [
                'tr' => ':name Planına Yatırım Yap',
                'ru' => 'Инвестировать в План :name'
            ],
            'user.plans.complete_investment_details' => [
                'tr' => 'Yatırım detaylarınızı aşağıdan tamamlayın',
                'ru' => 'Заполните детали вашей инвестиции ниже'
            ],
            'user.plans.investment_amount' => [
                'tr' => 'Yatırım Tutarı',
                'ru' => 'Сумма Инвестиции'
            ],
            'user.plans.select_investment_amount' => [
                'tr' => 'Yatırım Tutarını Seçin',
                'ru' => 'Выберите Сумму Инвестиции'
            ],
            'user.plans.available_balance' => [
                'tr' => 'Mevcut Bakiye',
                'ru' => 'Доступный Баланс'
            ],
            'user.plans.payment_method' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ Оплаты'
            ],
            'user.plans.wallet_balance' => [
                'tr' => 'Cüzdan Bakiyesi',
                'ru' => 'Баланс Кошелька'
            ],
            'user.plans.use_existing_balance' => [
                'tr' => 'Mevcut hesap bakiyenizi kullanın',
                'ru' => 'Используйте существующий баланс счета'
            ],
            'user.plans.cryptocurrency' => [
                'tr' => 'Kripto Para',
                'ru' => 'Криптовалюта'
            ],
            'user.plans.pay_with_crypto' => [
                'tr' => 'Bitcoin, Ethereum vb. ile ödeyin',
                'ru' => 'Оплатите Bitcoin, Ethereum и т.д.'
            ],
            'user.plans.investment_options' => [
                'tr' => 'Yatırım Seçenekleri',
                'ru' => 'Опции Инвестиции'
            ],
            'user.plans.enable_compound_interest' => [
                'tr' => 'Bileşik Faizi Etkinleştir',
                'ru' => 'Включить Сложные Проценты'
            ],
            'user.plans.compound_interest_description' => [
                'tr' => 'Bileşik faiz, kazançlarınızı yeniden yatırarak getirinizi potansiyel olarak artırır.',
                'ru' => 'Сложные проценты реинвестируют ваши доходы для потенциального увеличения прибыли.'
            ],
            'user.plans.auto_renew_after_maturity' => [
                'tr' => 'Vade Sonrası Otomatik Yenileme',
                'ru' => 'Автообновление После Погашения'
            ],
            'user.plans.auto_renew_description' => [
                'tr' => 'Vadeye ulaştıktan sonra bu plana otomatik olarak yeniden yatırım yapın.',
                'ru' => 'Автоматически реинвестировать в этот план после достижения срока погашения.'
            ],
            'user.plans.referral_code_optional' => [
                'tr' => 'Referans Kodu (İsteğe Bağlı)',
                'ru' => 'Реферальный Код (Опционально)'
            ],
            'user.plans.do_you_have_referral_code' => [
                'tr' => 'Referans Kodunuz Var mı?',
                'ru' => 'У вас есть реферальный код?'
            ],
            'user.plans.enter_referral_code' => [
                'tr' => 'Referans kodunu girin',
                'ru' => 'Введите реферальный код'
            ],
            'user.plans.referral_code_description' => [
                'tr' => 'Birisi sizi yönlendirdiyse, kodunu buraya girin. %:bonus bonus alacaklar.',
                'ru' => 'Если кто-то вас направил, введите код здесь. Они получат :bonus% бонус.'
            ],
            'user.plans.agree_to_terms_and_privacy' => [
                'tr' => 'Kullanım Koşulları ve Gizlilik Politikasını kabul ediyorum',
                'ru' => 'Я согласен с Условиями использования и Политикой конфиденциальности'
            ],
            'user.plans.complete_investment' => [
                'tr' => 'Yatırımı Tamamla',
                'ru' => 'Завершить Инвестицию'
            ],
            'user.plans.investment_summary' => [
                'tr' => 'Yatırım Özeti',
                'ru' => 'Сводка Инвестиции'
            ],
            'user.plans.selected_plan' => [
                'tr' => 'Seçilen Plan',
                'ru' => 'Выбранный План'
            ],
            'user.plans.total_return' => [
                'tr' => 'Toplam Getiri',
                'ru' => 'Общая Прибыль'
            ],
            'user.plans.final_amount' => [
                'tr' => 'Nihai Tutar',
                'ru' => 'Окончательная Сумма'
            ],
            'user.plans.need_help' => [
                'tr' => 'Yardıma İhtiyacınız Var mı?',
                'ru' => 'Нужна помощь?'
            ],
            'user.plans.support_available_247' => [
                'tr' => 'Bu yatırım planı hakkında sorularınız varsa, destek ekibimiz 7/24 hizmetinizdedir.',
                'ru' => 'Если у вас есть вопросы об этом инвестиционном плане, наша команда поддержки доступна 24/7.'
            ],
            'user.plans.contact_support' => [
                'tr' => 'Destekle İletişime Geç',
                'ru' => 'Связаться с Поддержкой'
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

        $this->command->info('User plan investment phrases seeded successfully! Total phrases: ' . count($phrases));
    }
}