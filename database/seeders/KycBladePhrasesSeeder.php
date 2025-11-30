<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class KycBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // KYC Applications Management - General
            'admin.kyc.applications_management' => [
                'tr' => 'KYC Başvuru Yönetimi',
                'ru' => 'Управление KYC Заявками'
            ],
            'admin.kyc.manage_user_verification' => [
                'tr' => 'Kullanıcı kimlik doğrulama başvurularını yönetin',
                'ru' => 'Управляйте заявками на верификацию пользователей'
            ],
            'admin.kyc.total_applications' => [
                'tr' => 'Toplam Başvuru',
                'ru' => 'Всего заявок'
            ],
            'admin.kyc.approved' => [
                'tr' => 'Onaylanmış',
                'ru' => 'Одобрено'
            ],
            'admin.kyc.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            'admin.kyc.rejected' => [
                'tr' => 'Reddedilmiş',
                'ru' => 'Отклонено'
            ],
            'admin.kyc.applications_list' => [
                'tr' => 'KYC Başvuru Listesi',
                'ru' => 'Список KYC заявок'
            ],
            'admin.kyc.review_manage_applications' => [
                'tr' => 'Kullanıcı kimlik doğrulama başvurularını inceleyin ve yönetin',
                'ru' => 'Просматривайте и управляйте заявками на верификацию пользователей'
            ],
            'admin.kyc.status' => [
                'tr' => 'KYC Durumu',
                'ru' => 'Статус KYC'
            ],
            'admin.kyc.verified' => [
                'tr' => 'Doğrulandı',
                'ru' => 'Подтверждено'
            ],
            'admin.kyc.view_application' => [
                'tr' => 'Başvuruyu Görüntüle',
                'ru' => 'Просмотреть заявку'
            ],
            'admin.kyc.no_applications_yet' => [
                'tr' => 'Henüz başvuru yok',
                'ru' => 'Пока нет заявок'
            ],
            'admin.kyc.no_applications_submitted' => [
                'tr' => 'KYC başvurusu yapılmamış.',
                'ru' => 'Заявки KYC не поданы.'
            ],

            // KYC Application Details
            'admin.kyc.application_details' => [
                'tr' => 'KYC Başvuru Detayları',
                'ru' => 'Детали KYC заявки'
            ],
            'admin.kyc.identity_verification_application' => [
                'tr' => 'KYC Kimlik Doğrulama Başvurusu',
                'ru' => 'Заявка на верификацию личности KYC'
            ],
            'admin.kyc.perform_action' => [
                'tr' => 'KYC İşlemi Yap',
                'ru' => 'Выполнить действие KYC'
            ],

            // Personal Information
            'admin.kyc.personal_information' => [
                'tr' => 'Kişisel Bilgiler',
                'ru' => 'Личная информация'
            ],
            'admin.kyc.user_identity_contact_info' => [
                'tr' => 'Kullanıcının kimlik ve iletişim bilgileri',
                'ru' => 'Идентификационная и контактная информация пользователя'
            ],
            'admin.kyc.first_name' => [
                'tr' => 'Ad',
                'ru' => 'Имя'
            ],
            'admin.kyc.last_name' => [
                'tr' => 'Soyad',
                'ru' => 'Фамилия'
            ],
            'admin.kyc.phone_number' => [
                'tr' => 'Telefon Numarası',
                'ru' => 'Номер телефона'
            ],
            'admin.kyc.date_of_birth' => [
                'tr' => 'Doğum Tarihi',
                'ru' => 'Дата рождения'
            ],
            'admin.kyc.social_media' => [
                'tr' => 'Sosyal Medya',
                'ru' => 'Социальные сети'
            ],
            'admin.kyc.not_specified' => [
                'tr' => 'Belirtilmemiş',
                'ru' => 'Не указано'
            ],

            // Address Information
            'admin.kyc.address_information' => [
                'tr' => 'Adres Bilgileri',
                'ru' => 'Адресная информация'
            ],
            'admin.kyc.user_registered_address_info' => [
                'tr' => 'Kullanıcının kayıtlı adres bilgileri',
                'ru' => 'Зарегистрированная адресная информация пользователя'
            ],
            'admin.kyc.address' => [
                'tr' => 'Adres',
                'ru' => 'Адрес'
            ],
            'admin.kyc.city' => [
                'tr' => 'Şehir',
                'ru' => 'Город'
            ],
            'admin.kyc.state_province' => [
                'tr' => 'Eyalet/İl',
                'ru' => 'Штат/Область'
            ],
            'admin.kyc.country' => [
                'tr' => 'Ülke',
                'ru' => 'Страна'
            ],

            // Document Information
            'admin.kyc.identity_documents' => [
                'tr' => 'Kimlik Belgeleri',
                'ru' => 'Документы удостоверяющие личность'
            ],
            'admin.kyc.uploaded_verification_documents' => [
                'tr' => 'Yüklenen kimlik doğrulama belgeleri',
                'ru' => 'Загруженные документы для верификации'
            ],
            'admin.kyc.document_type' => [
                'tr' => 'Belge Türü',
                'ru' => 'Тип документа'
            ],
            'admin.kyc.document_front_side' => [
                'tr' => 'Belgenin Ön Yüzü',
                'ru' => 'Лицевая сторона документа'
            ],
            'admin.kyc.document_back_side' => [
                'tr' => 'Belgenin Arka Yüzü',
                'ru' => 'Обратная сторона документа'
            ],

            // KYC Actions
            'admin.kyc.kyc_action' => [
                'tr' => 'KYC İşlemi',
                'ru' => 'Действие KYC'
            ],
            'admin.kyc.approve_or_reject_application' => [
                'tr' => 'Başvuruyu onaylayın veya reddedin',
                'ru' => 'Одобрить или отклонить заявку'
            ],
            'admin.kyc.action_type' => [
                'tr' => 'İşlem Türü',
                'ru' => 'Тип действия'
            ],
            'admin.kyc.accept_and_verify_user' => [
                'tr' => 'Kullanıcıyı kabul et ve doğrula',
                'ru' => 'Принять и подтвердить пользователя'
            ],
            'admin.kyc.reject_and_keep_unverified' => [
                'tr' => 'Reddet ve doğrulanmamış bırak',
                'ru' => 'Отклонить и оставить неподтвержденным'
            ],
            'admin.kyc.email_subject' => [
                'tr' => 'E-posta Konusu',
                'ru' => 'Тема электронной почты'
            ],
            'admin.kyc.account_successfully_verified' => [
                'tr' => 'Hesap başarıyla doğrulandı',
                'ru' => 'Аккаунт успешно подтвержден'
            ],
            'admin.kyc.message_to_user' => [
                'tr' => 'Kullanıcıya Gönderilecek Mesaj',
                'ru' => 'Сообщение пользователю'
            ],
            'admin.kyc.enter_message' => [
                'tr' => 'Mesaj Girin',
                'ru' => 'Введите сообщение'
            ],
            'admin.kyc.default_verification_message' => [
                'tr' => 'Belgeleri inceledikten sonra hesabınız doğrulandı. Artık tüm hizmetlerimizden kısıtlama olmadan yararlanabilirsiniz. Teşekkürler!!',
                'ru' => 'После проверки ваших документов ваш аккаунт был подтвержден. Теперь вы можете пользоваться всеми нашими услугами без ограничений. Спасибо!!'
            ],
            'admin.kyc.confirm_action' => [
                'tr' => 'İşlemi Onayla',
                'ru' => 'Подтвердить действие'
            ],
            'admin.kyc.processing' => [
                'tr' => 'İşlem Yapılıyor',
                'ru' => 'Обработка'
            ]
        ];

        $languages = [
            'tr' => 1,
            'ru' => 2
        ];

        foreach ($phrases as $key => $translations) {
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            foreach ($translations as $languageCode => $translation) {
                if (isset($languages[$languageCode])) {
                    PhraseTranslation::updateOrCreate([
                        'phrase_id' => $phrase->id,
                        'language_id' => $languages[$languageCode],
                    ], [
                        'translation' => $translation
                    ]);
                }
            }
        }

        $this->command->info('KYC Blade phrases seeded successfully. Total: ' . count($phrases) . ' phrases');
    }
}