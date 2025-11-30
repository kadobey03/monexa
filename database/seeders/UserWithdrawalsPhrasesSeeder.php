<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class UserWithdrawalsPhrasesSeeder extends Seeder
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
            // Page header and navigation
            'user.withdrawals.page_title' => [
                'tr' => 'Fon Çekimleri',
                'ru' => 'Вывод средств'
            ],
            'user.withdrawals.page_subtitle' => [
                'tr' => 'Çeşitli ödeme yöntemlerini kullanarak fonlarınızı güvenli bir şekilde çekin',
                'ru' => 'Безопасно выводите средства с помощью различных способов оплаты'
            ],
            'user.withdrawals.back_to_dashboard' => [
                'tr' => 'Gösterge Paneline Dön',
                'ru' => 'Вернуться к панели управления'
            ],
            'user.withdrawals.home' => [
                'tr' => 'Ana Sayfa',
                'ru' => 'Главная'
            ],
            'user.withdrawals.withdrawals' => [
                'tr' => 'Çekimler',
                'ru' => 'Выводы'
            ],

            // Security verification section
            'user.withdrawals.security_verification_required' => [
                'tr' => 'Güvenlik Doğrulaması Gerekli',
                'ru' => 'Требуется проверка безопасности'
            ],
            'user.withdrawals.additional_verification_needed' => [
                'tr' => 'Çekiminizi işlemek için ek doğrulama gerekli',
                'ru' => 'Для обработки вывода требуется дополнительная проверка'
            ],
            'user.withdrawals.withdrawal_code_required' => [
                'tr' => 'Çekim Kodu Gerekli',
                'ru' => 'Требуется код вывода'
            ],
            'user.withdrawals.security_code_description' => [
                'tr' => 'Güvenliğiniz için bu çekim bir doğrulama kodu gerektirir. Lütfen canlı sohbet veya e-posta yoluyla müşteri destek ekibimize başvurun',
                'ru' => 'Для вашей безопасности этот вывод требует проверочного кода. Пожалуйста, обратитесь к нашей службе поддержки через живой чат или электронную почту'
            ],
            'user.withdrawals.get_verification_code' => [
                'tr' => 'çekim doğrulama kodunuzu almak için.',
                'ru' => 'чтобы получить код подтверждения вывода.'
            ],
            'user.withdrawals.learn_about_security' => [
                'tr' => 'Çekim güvenliği hakkında bilgi edinin',
                'ru' => 'Узнайте о безопасности вывода'
            ],
            'user.withdrawals.why_codes_required' => [
                'tr' => 'Çekim kodlarının neden gerekli olduğu:',
                'ru' => 'Почему нужны коды вывода:'
            ],
            'user.withdrawals.advanced_security' => [
                'tr' => 'Hesabınızı yetkisiz erişimden korumak için gelişmiş güvenlik',
                'ru' => 'Расширенная безопасность для защиты вашего аккаунта от несанкционированного доступа'
            ],
            'user.withdrawals.verify_legitimate_requests' => [
                'tr' => 'Tüm çekim taleplerinin yasal ve yetkilendirilmiş olduğunun doğrulanması',
                'ru' => 'Проверка того, что все запросы на вывод являются законными и авторизованными'
            ],
            'user.withdrawals.additional_protection' => [
                'tr' => 'Sahte işlemlerden ek koruma katmanı',
                'ru' => 'Дополнительный уровень защиты от мошеннических транзакций'
            ],
            'user.withdrawals.compliance_regulations' => [
                'tr' => 'Finansal güvenlik düzenlemelerine ve en iyi uygulamalara uyumluluk',
                'ru' => 'Соответствие финансовым регулированиям и лучшим практикам безопасности'
            ],
            'user.withdrawals.enter_verification_code' => [
                'tr' => 'Çekim Doğrulama Kodunu Girin',
                'ru' => 'Введите код подтверждения вывода'
            ],
            'user.withdrawals.code_placeholder' => [
                'tr' => 'Doğrulama kodunuzu buraya girin',
                'ru' => 'Введите ваш код подтверждения сюда'
            ],
            'user.withdrawals.code_provided_by_support' => [
                'tr' => 'Bu kod müşteri destek ekibimiz tarafından sağlandı',
                'ru' => 'Этот код предоставлен нашей службой поддержки'
            ],
            'user.withdrawals.verify_and_continue' => [
                'tr' => 'Doğrula ve Devam Et',
                'ru' => 'Подтвердить и продолжить'
            ],

            // Withdrawal method selection
            'user.withdrawals.select_withdrawal_method' => [
                'tr' => 'Çekim Yöntemi Seçin',
                'ru' => 'Выберите способ вывода'
            ],
            'user.withdrawals.choose_payment_method' => [
                'tr' => 'Fon almak için tercih ettiğiniz ödeme yöntemini seçin',
                'ru' => 'Выберите предпочитаемый способ платежа для получения средств'
            ],
            'user.withdrawals.payment_method' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ платежа'
            ],
            'user.withdrawals.select_method_placeholder' => [
                'tr' => 'Bir çekim yöntemi seçin',
                'ru' => 'Выберите способ вывода'
            ],
            'user.withdrawals.no_methods_available' => [
                'tr' => 'Kullanılabilir çekim yöntemi yok',
                'ru' => 'Доступные способы вывода отсутствуют'
            ],
            'user.withdrawals.withdrawal' => [
                'tr' => 'Çekim',
                'ru' => 'Вывод'
            ],
            'user.withdrawals.method_selected_as_preferred' => [
                'tr' => 'tercih ettiğiniz çekim yöntemi olarak seçtiniz.',
                'ru' => 'выбран как предпочитаемый способ вывода.'
            ],
            'user.withdrawals.secure_encrypted_transaction' => [
                'tr' => 'Güvenli ve şifreli işlem',
                'ru' => 'Безопасная и зашифрованная транзакция'
            ],
            'user.withdrawals.proceed_to_withdrawal' => [
                'tr' => 'Çekime Geç',
                'ru' => 'Перейти к выводу'
            ],

            // Withdrawal history
            'user.withdrawals.withdrawal_history' => [
                'tr' => 'Çekim Geçmişi',
                'ru' => 'История выводов'
            ],
            'user.withdrawals.track_withdrawal_requests' => [
                'tr' => 'Çekim taleplerinizin durumunu ve ayrıntılarını izleyin',
                'ru' => 'Отслеживайте статус и детали ваших запросов на вывод'
            ],
            'user.withdrawals.amount' => [
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            'user.withdrawals.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'user.withdrawals.method' => [
                'tr' => 'Yöntem',
                'ru' => 'Способ'
            ],
            'user.withdrawals.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'user.withdrawals.withdrawal_amount' => [
                'tr' => 'Çekim Tutarı',
                'ru' => 'Сумма вывода'
            ],
            'user.withdrawals.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            'user.withdrawals.rejected' => [
                'tr' => 'Reddedildi',
                'ru' => 'Отклонен'
            ],
            'user.withdrawals.completed' => [
                'tr' => 'Tamamlandı',
                'ru' => 'Завершен'
            ],
            'user.withdrawals.no_withdrawals_yet' => [
                'tr' => 'Henüz çekim yok',
                'ru' => 'Выводов пока нет'
            ],
            'user.withdrawals.history_will_appear' => [
                'tr' => 'İlk talebinizi yaptıktan sonra çekim geçmişiniz burada görünecektir',
                'ru' => 'История выводов появится здесь после вашего первого запроса'
            ],

            // JavaScript dynamic content
            'user.withdrawals.hide_security_details' => [
                'tr' => 'Güvenlik ayrıntılarını gizle',
                'ru' => 'Скрыть детали безопасности'
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

        $this->command->info('User withdrawals phrases created successfully! Total phrases: ' . count($phrases));
    }
}