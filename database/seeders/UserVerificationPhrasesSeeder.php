<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UserVerificationPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // KYC Verification Page
            'user.verification.secure_verification_process' => [
                'tr' => 'Güvenli Doğrulama Süreci',
                'ru' => 'Безопасный процесс верификации',
            ],
            'user.verification.account_verification' => [
                'tr' => 'Hesap Doğrulama',
                'ru' => 'Верификация аккаунта',
            ],
            'user.verification.complete_kyc_message' => [
                'tr' => 'Tam ticaret özelliklerini açmak ve hesap güvenliğini sağlamak için KYC doğrulamanızı tamamlayın',
                'ru' => 'Завершите KYC-верификацию для разблокировки всех торговых функций и обеспечения безопасности аккаунта',
            ],
            'user.verification.verification_progress' => [
                'tr' => 'Doğrulama İlerlemesi',
                'ru' => 'Прогресс верификации',
            ],
            'user.verification.step_counter' => [
                'tr' => 'Adım :current / :total',
                'ru' => 'Шаг :current из :total',
            ],
            'user.verification.personal_information' => [
                'tr' => 'Kişisel Bilgiler',
                'ru' => 'Личная информация',
            ],
            'user.verification.address' => [
                'tr' => 'Adres',
                'ru' => 'Адрес',
            ],
            'user.verification.documents' => [
                'tr' => 'Belgeler',
                'ru' => 'Документы',
            ],
            'user.verification.identity_verification' => [
                'tr' => 'Kimlik Doğrulama',
                'ru' => 'Верификация личности',
            ],
            'user.verification.secure_account_message' => [
                'tr' => 'Devlet tarafından verilen kimlik doğrulamasıyla hesabınızı güvence altına alın',
                'ru' => 'Обеспечьте безопасность своего аккаунта с помощью государственной идентификации',
            ],
            'user.verification.provide_personal_info_message' => [
                'tr' => 'Kimliğinizde göründüğü gibi kişisel bilgilerinizi sağlayın',
                'ru' => 'Предоставьте личную информацию, как она указана в ваших документах',
            ],
            'user.verification.important_notice' => [
                'tr' => 'Önemli Uyarı',
                'ru' => 'Важное уведомление',
            ],
            'user.verification.match_id_warning' => [
                'tr' => 'Lütfen tüm bilgilerin devlet tarafından verilen kimliğinizle tam olarak eşleştiğinden emin olun. Gönderimden sonra ayrıntılar değiştirilemez.',
                'ru' => 'Пожалуйста, убедитесь, что вся информация точно соответствует вашему государственному удостоверению личности. Данные нельзя изменить после отправки.',
            ],
            'user.verification.first_name' => [
                'tr' => 'İlk Ad',
                'ru' => 'Имя',
            ],
            'user.verification.last_name' => [
                'tr' => 'Soyadı',
                'ru' => 'Фамилия',
            ],
            'user.verification.email_address' => [
                'tr' => 'E-posta Adresi',
                'ru' => 'Электронная почта',
            ],
            'user.verification.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона',
            ],
            'user.verification.date_of_birth' => [
                'tr' => 'Doğum Tarihi',
                'ru' => 'Дата рождения',
            ],
            'user.verification.social_media_username' => [
                'tr' => 'Sosyal Medya Kullanıcı Adı (İsteğe Bağlı)',
                'ru' => 'Имя пользователя в социальных сетях (необязательно)',
            ],
            'user.verification.continue_to_address' => [
                'tr' => 'Adrese Devam Et',
                'ru' => 'Перейти к адресу',
            ],
            'user.verification.address_information' => [
                'tr' => 'Adres Bilgileri',
                'ru' => 'Информация об адресе',
            ],
            'user.verification.current_residence_address' => [
                'tr' => 'Doğrulama için mevcut ikamet adresiniz',
                'ru' => 'Ваш текущий адрес проживания для верификации',
            ],
            'user.verification.address_verification' => [
                'tr' => 'Adres Doğrulama',
                'ru' => 'Верификация адреса',
            ],
            'user.verification.address_match_warning' => [
                'tr' => 'Adresinizin destekleyici belgelerinizle tam olarak eşleştiğinden emin olun.',
                'ru' => 'Убедитесь, что ваш адрес точно соответствует подтверждающим документам.',
            ],
            'user.verification.street_address' => [
                'tr' => 'Sokak Adresi',
                'ru' => 'Адрес улицы',
            ],
            'user.verification.enter_full_street_address' => [
                'tr' => 'Tam sokak adresinizi girin',
                'ru' => 'Введите полный адрес улицы',
            ],
            'user.verification.city' => [
                'tr' => 'Şehir',
                'ru' => 'Город',
            ],
            'user.verification.enter_city' => [
                'tr' => 'Şehrinizi girin',
                'ru' => 'Введите ваш город',
            ],
            'user.verification.state_province' => [
                'tr' => 'Eyalet/İl',
                'ru' => 'Штат/Область',
            ],
            'user.verification.enter_state_province' => [
                'tr' => 'Eyaletinizi veya ilinizi girin',
                'ru' => 'Введите штат или область',
            ],
            'user.verification.country_nationality' => [
                'tr' => 'Ülke/Uyruk',
                'ru' => 'Страна/Национальность',
            ],
            'user.verification.enter_country' => [
                'tr' => 'Ülkenizi girin',
                'ru' => 'Введите вашу страну',
            ],
            'user.verification.previous' => [
                'tr' => 'Önceki',
                'ru' => 'Предыдущий',
            ],
            'user.verification.continue_to_documents' => [
                'tr' => 'Belgelere Devam Et',
                'ru' => 'Перейти к документам',
            ],
            'user.verification.document_upload' => [
                'tr' => 'Belge Yükleme',
                'ru' => 'Загрузка документов',
            ],
            'user.verification.upload_clear_photos_message' => [
                'tr' => 'Devlet tarafından verilen kimliğinizin net fotoğraflarını yükleyin',
                'ru' => 'Загрузите четкие фотографии вашего государственного удостоверения личности',
            ],
            'user.verification.select_document_type' => [
                'tr' => 'Belge Türünü Seçin',
                'ru' => 'Выберите тип документа',
            ],
            'user.verification.international_passport' => [
                'tr' => 'Uluslararası Pasaport',
                'ru' => 'Международный паспорт',
            ],
            'user.verification.most_accepted_worldwide' => [
                'tr' => 'Dünya çapında en çok kabul edilen',
                'ru' => 'Наиболее принимаемый во всем мире',
            ],
            'user.verification.national_id_card' => [
                'tr' => 'Ulusal Kimlik Kartı',
                'ru' => 'Национальное удостоверение личности',
            ],
            'user.verification.government_issued_id' => [
                'tr' => 'Devlet tarafından verilen kimlik',
                'ru' => 'Государственное удостоверение личности',
            ],
            'user.verification.drivers_license' => [
                'tr' => 'Ehliyet',
                'ru' => 'Водительские права',
            ],
            'user.verification.valid_drivers_license' => [
                'tr' => 'Geçerli ehliyet',
                'ru' => 'Действительные водительские права',
            ],
            'user.verification.document_requirements' => [
                'tr' => 'Belge Gereksinimleri',
                'ru' => 'Требования к документам',
            ],
            'user.verification.not_expired_damaged' => [
                'tr' => 'Süresi dolmamış veya hasar görmemiş',
                'ru' => 'Не просрочен и не поврежден',
            ],
            'user.verification.all_text_clearly_visible' => [
                'tr' => 'Tüm metin net şekilde görünür',
                'ru' => 'Весь текст четко виден',
            ],
            'user.verification.no_glare_shadows' => [
                'tr' => 'Parlama veya gölge yok',
                'ru' => 'Нет бликов или теней',
            ],
            'user.verification.high_resolution_image' => [
                'tr' => 'Yüksek çözünürlüklü resim',
                'ru' => 'Изображение высокого разрешения',
            ],
            'user.verification.front_side' => [
                'tr' => 'Ön Yüz',
                'ru' => 'Лицевая сторона',
            ],
            'user.verification.upload_front_side' => [
                'tr' => 'Ön Yüzü Yükle',
                'ru' => 'Загрузить лицевую сторону',
            ],
            'user.verification.png_jpg_up_to_10mb' => [
                'tr' => 'PNG, JPG 10MB\'ye kadar',
                'ru' => 'PNG, JPG до 10МБ',
            ],
            'user.verification.front_side_uploaded' => [
                'tr' => 'Ön yüz yüklendi',
                'ru' => 'Лицевая сторона загружена',
            ],
            'user.verification.back_side' => [
                'tr' => 'Arka Yüz',
                'ru' => 'Обратная сторона',
            ],
            'user.verification.upload_back_side' => [
                'tr' => 'Arka Yüzü Yükle',
                'ru' => 'Загрузить обратную сторону',
            ],
            'user.verification.back_side_uploaded' => [
                'tr' => 'Arka yüz yüklendi',
                'ru' => 'Обратная сторона загружена',
            ],
            'user.verification.i_confirm_information_accurate' => [
                'tr' => 'Sağlanan tüm bilgilerin doğru ve belgelerin orijinal olduğunu onaylıyorum.',
                'ru' => 'Подтверждаю, что вся предоставленная информация является точной, а документы — подлинными.',
            ],
            'user.verification.understand_false_info_consequences' => [
                'tr' => 'Yanlış bilgi sağlamanın hesap askıya alınmasıyla sonuçlanabileceğini anlıyorum ve',
                'ru' => 'Понимаю, что предоставление ложной информации может привести к приостановке аккаунта, и',
            ],
            'user.verification.terms_of_service' => [
                'tr' => 'Hizmet Şartları',
                'ru' => 'Условия обслуживания',
            ],
            'user.verification.and' => [
                'tr' => 've',
                'ru' => 'и',
            ],
            'user.verification.privacy_policy' => [
                'tr' => 'Gizlilik Politikası',
                'ru' => 'Политика конфиденциальности',
            ],
            'user.verification.under_review' => [
                'tr' => 'İnceleniyor',
                'ru' => 'На рассмотрении',
            ],
            'user.verification.submit_application' => [
                'tr' => 'Başvuru Gönder',
                'ru' => 'Отправить заявку',
            ],
            'user.verification.your_privacy_protected' => [
                'tr' => 'Gizliliğiniz Korunuyor',
                'ru' => 'Ваша конфиденциальность защищена',
            ],
            'user.verification.documents_encrypted_message' => [
                'tr' => 'Belgeleriniz şifrelenir ve güvenli bir şekilde saklanır. Kişisel bilgilerinizi korumak ve uluslararası veri koruma düzenlemelerine uymak için banka seviyesinde güvenlik önlemleri kullanıyoruz.',
                'ru' => 'Ваши документы шифруются и хранятся безопасно. Мы используем банковский уровень безопасности для защиты ваших личных данных и соблюдения международных норм защиты данных.',
            ],
            'user.verification.submitting' => [
                'tr' => 'Gönderiliyor...',
                'ru' => 'Отправка...',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create translations
            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian
                
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId,
                    ],
                    [
                        'translation' => $translation,
                    ]
                );
            }
        }

        $this->command->info('✅ User Verification phrases have been successfully seeded!');
        $this->command->info('📊 Total phrases processed: ' . count($phrases));
    }
}