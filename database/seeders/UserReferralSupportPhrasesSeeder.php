<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserReferralSupportPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Referral System Phrases
            'user.referral.program_title' => [
                'tr' => 'Referans Programı',
                'ru' => 'Реферальная программа',
            ],
            'user.referral.program_description' => [
                'tr' => ':site_name ile ağınızı büyütün ve ödüller kazanın',
                'ru' => 'Развивайте свою сеть с :site_name и зарабатывайте награды',
            ],
            'user.referral.share_program' => [
                'tr' => 'Programı Paylaş',
                'ru' => 'Поделиться программой',
            ],
            'user.referral.qr_code' => [
                'tr' => 'QR Kod',
                'ru' => 'QR-код',
            ],
            'user.referral.total_referrals' => [
                'tr' => 'Toplam Referans',
                'ru' => 'Всего рефералов',
            ],
            'user.referral.this_month_growth' => [
                'tr' => 'Bu ay +:percentage%',
                'ru' => 'В этом месяце +:percentage%',
            ],
            'user.referral.total_earnings' => [
                'tr' => 'Toplam Kazanç',
                'ru' => 'Общий доход',
            ],
            'user.referral.your_level' => [
                'tr' => 'Seviyeniz',
                'ru' => 'Ваш уровень',
            ],
            'user.referral.level_elite' => [
                'tr' => 'Elit',
                'ru' => 'Элита',
            ],
            'user.referral.level_gold' => [
                'tr' => 'Altın',
                'ru' => 'Золото',
            ],
            'user.referral.level_silver' => [
                'tr' => 'Gümüş',
                'ru' => 'Серебро',
            ],
            'user.referral.level_bronze' => [
                'tr' => 'Bronz',
                'ru' => 'Бронза',
            ],
            'user.referral.level_starter' => [
                'tr' => 'Başlangıç',
                'ru' => 'Начальный',
            ],
            'user.referral.referred_by' => [
                'tr' => 'Referans Veren',
                'ru' => 'Пригласил',
            ],
            'user.referral.direct_registration' => [
                'tr' => 'Doğrudan Kayıt',
                'ru' => 'Прямая регистрация',
            ],
            'user.referral.referral_tools' => [
                'tr' => 'Referans Araçları',
                'ru' => 'Инструменты рефералов',
            ],
            'user.referral.your_referral_link' => [
                'tr' => 'Referans Bağlantınız',
                'ru' => 'Ваша реферальная ссылка',
            ],
            'user.referral.link_copied' => [
                'tr' => 'Bağlantı panoya kopyalandı!',
                'ru' => 'Ссылка скопирована в буфер обмена!',
            ],
            'user.referral.your_referral_id' => [
                'tr' => 'Referans Kimliğiniz',
                'ru' => 'Ваш реферальный ID',
            ],
            'user.referral.scan_to_use' => [
                'tr' => 'Referans bağlantısını kullanmak için tarayın',
                'ru' => 'Сканируйте для использования реферальной ссылки',
            ],
            'user.referral.overview' => [
                'tr' => 'Genel Bakış',
                'ru' => 'Обзор',
            ],
            'user.referral.my_referrals' => [
                'tr' => 'Referanslarım',
                'ru' => 'Мои рефералы',
            ],
            'user.referral.how_it_works' => [
                'tr' => 'Nasıl Çalışır',
                'ru' => 'Как это работает',
            ],
            'user.referral.step1_title' => [
                'tr' => 'Bağlantınızı Paylaşın',
                'ru' => 'Поделитесь ссылкой',
            ],
            'user.referral.step1_description' => [
                'tr' => 'Benzersiz referans bağlantınızı arkadaşlarınız ve ailenizle paylaşın',
                'ru' => 'Поделитесь своей уникальной реферальной ссылкой с друзьями и семьей',
            ],
            'user.referral.step2_title' => [
                'tr' => 'Katılırlar',
                'ru' => 'Они присоединяются',
            ],
            'user.referral.step2_description' => [
                'tr' => 'Birisi bağlantınızı kullanarak kaydolduğunda, referansınız olur',
                'ru' => 'Когда кто-то регистрируется по вашей ссылке, он становится вашим рефералом',
            ],
            'user.referral.step3_title' => [
                'tr' => 'Ödüller Kazanın',
                'ru' => 'Зарабатывайте награды',
            ],
            'user.referral.step3_description' => [
                'tr' => 'Ticaret faaliyetlerinden ve işlemlerinden komisyon alın',
                'ru' => 'Получайте комиссию от торговой деятельности и транзакций',
            ],
            'user.referral.referral_levels' => [
                'tr' => 'Referans Seviyeleri',
                'ru' => 'Уровни рефералов',
            ],
            'user.referral.referral_range_starter' => [
                'tr' => '0-9 referans',
                'ru' => '0-9 рефералов',
            ],
            'user.referral.commission_rate' => [
                'tr' => ':rate% komisyon',
                'ru' => ':rate% комиссия',
            ],
            'user.referral.referral_range_bronze' => [
                'tr' => '10-24 referans',
                'ru' => '10-24 реферала',
            ],
            'user.referral.referral_range_silver' => [
                'tr' => '25-49 referans',
                'ru' => '25-49 рефералов',
            ],
            'user.referral.referral_range_gold' => [
                'tr' => '50-99 referans',
                'ru' => '50-99 рефералов',
            ],
            'user.referral.referral_range_elite' => [
                'tr' => '100+ referans',
                'ru' => '100+ рефералов',
            ],
            'user.referral.search_referrals' => [
                'tr' => 'Referansları ara...',
                'ru' => 'Поиск рефералов...',
            ],
            'user.referral.customer_name' => [
                'tr' => 'Müşteri Adı',
                'ru' => 'Имя клиента',
            ],
            'user.referral.level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень',
            ],
            'user.referral.parent' => [
                'tr' => 'Üst',
                'ru' => 'Родитель',
            ],
            'user.referral.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус',
            ],
            'user.referral.registration_date' => [
                'tr' => 'Kayıt Tarihi',
                'ru' => 'Дата регистрации',
            ],
            'user.referral.email' => [
                'tr' => 'E-posta',
                'ru' => 'Email',
            ],
            'user.referral.joined' => [
                'tr' => 'Katıldı',
                'ru' => 'Присоединился',
            ],
            'user.referral.no_referrals_yet' => [
                'tr' => 'Henüz referans yok',
                'ru' => 'Пока нет рефералов',
            ],
            'user.referral.start_sharing_to_build_network' => [
                'tr' => 'Ağınızı oluşturmak için referans bağlantınızı paylaşmaya başlayın',
                'ru' => 'Начните делиться реферальной ссылкой для создания сети',
            ],
            'user.referral.copy_referral_link' => [
                'tr' => 'Referans Bağlantısını Kopyala',
                'ru' => 'Скопировать реферальную ссылку',
            ],
            'user.referral.share_referral_program' => [
                'tr' => 'Referans Programını Paylaş',
                'ru' => 'Поделиться реферальной программой',
            ],
            'user.referral.twitter' => [
                'tr' => 'Twitter',
                'ru' => 'Twitter',
            ],
            'user.referral.facebook' => [
                'tr' => 'Facebook',
                'ru' => 'Facebook',
            ],
            'user.referral.linkedin' => [
                'tr' => 'LinkedIn',
                'ru' => 'LinkedIn',
            ],
            'user.referral.whatsapp' => [
                'tr' => 'WhatsApp',
                'ru' => 'WhatsApp',
            ],
            'user.referral.close' => [
                'tr' => 'Kapat',
                'ru' => 'Закрыть',
            ],
            'user.referral.successfully_shared' => [
                'tr' => 'Başarıyla paylaşıldı!',
                'ru' => 'Успешно поделились!',
            ],

            // Support System Phrases
            'user.support.support_center' => [
                'tr' => 'Destek Merkezi',
                'ru' => 'Центр поддержки',
            ],
            'user.support.we_are_here_to_help' => [
                'tr' => 'Herhangi bir soru veya endişeniz için buradayız',
                'ru' => 'Мы здесь, чтобы помочь с любыми вопросами или заботами',
            ],
            'user.support.email_support' => [
                'tr' => 'E-posta Desteği',
                'ru' => 'Поддержка по email',
            ],
            'user.support.get_help_via_email' => [
                'tr' => 'E-posta yoluyla yardım alın',
                'ru' => 'Получите помощь по email',
            ],
            'user.support.detailed_email_communication' => [
                'tr' => 'Ayrıntılı sorular ve destek talepleri için doğrudan e-posta iletişimi.',
                'ru' => 'Прямое общение по email для подробных вопросов и запросов поддержки.',
            ],
            'user.support.send_us_message' => [
                'tr' => 'Bize Mesaj Gönderin',
                'ru' => 'Отправьте нам сообщение',
            ],
            'user.support.contact_form_description' => [
                'tr' => 'Belirli bir sorunuz mu var veya yardıma mı ihtiyacınız var? Aşağıdaki formu doldurun ve destek ekibimiz en kısa sürede size geri dönecek.',
                'ru' => 'У вас есть конкретный вопрос или нужна помощь? Заполните форму ниже, и наша команда поддержки свяжется с вами в ближайшее время.',
            ],
            'user.support.your_name' => [
                'tr' => 'Adınız',
                'ru' => 'Ваше имя',
            ],
            'user.support.your_email' => [
                'tr' => 'E-posta Adresiniz',
                'ru' => 'Ваш email',
            ],
            'user.support.message' => [
                'tr' => 'Mesaj',
                'ru' => 'Сообщение',
            ],
            'user.support.message_placeholder' => [
                'tr' => 'Lütfen sorunuzu veya sorununuzu detaylı olarak açıklayın...',
                'ru' => 'Пожалуйста, опишите ваш вопрос или проблему подробно...',
            ],
            'user.support.provide_details_help' => [
                'tr' => 'Size daha iyi yardımcı olmak için lütfen mümkün olduğunca fazla detay sağlayın.',
                'ru' => 'Пожалуйста, предоставьте как можно больше деталей, чтобы мы могли лучше помочь вам.',
            ],
            'user.support.send_message' => [
                'tr' => 'Mesaj Gönder',
                'ru' => 'Отправить сообщение',
            ],
            'user.support.sending' => [
                'tr' => 'Gönderiliyor...',
                'ru' => 'Отправляется...',
            ],
            'user.support.response_time' => [
                'tr' => 'Genellikle iş günlerinde 24 saat içinde yanıt veririz.',
                'ru' => 'Обычно мы отвечаем в течение 24 часов в рабочие дни.',
            ],
            'user.support.live_chat_support' => [
                'tr' => 'Canlı Sohbet Desteği',
                'ru' => 'Поддержка в реальном времени',
            ],
            'user.support.live_chat_coming_soon' => [
                'tr' => 'Canlı sohbet özelliğimiz yakında gelecek! Şimdilik lütfen iletişim formunu kullanın veya doğrudan bize e-posta gönderin.',
                'ru' => 'Функция живого чата скоро появится! А пока, пожалуйста, используйте контактную форму или отправьте нам email напрямую.',
            ],
            'user.support.close' => [
                'tr' => 'Kapat',
                'ru' => 'Закрыть',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or update the phrase
            $phrase = Phrase::firstOrCreate([
                'key' => $key,
            ]);

            // Create or update translations
            foreach ($translations as $locale => $translation) {
                $languageId = $locale === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId,
                ], [
                    'translation' => $translation,
                ]);
            }
        }
        
        $this->command->info('Referral and Support phrases have been seeded successfully! Total: ' . count($phrases) . ' phrases');
    }
}