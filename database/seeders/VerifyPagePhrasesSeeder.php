<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class VerifyPagePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get languages
        $turkish = Language::where('code', 'tr')->first();
        $russian = Language::where('code', 'ru')->first();

        if (!$turkish || !$russian) {
            $this->command->error('Turkish and Russian languages must exist before running this seeder');
            return;
        }

        $phrases = [
            'user.verify.verification_required' => [
                'tr' => 'Doğrulama Gerekli',
                'ru' => 'Требуется Верификация'
            ],
            'user.verify.kyc_verification' => [
                'tr' => 'KYC Doğrulama',
                'ru' => 'KYC Верификация'
            ],
            'user.verify.complete_verification_description' => [
                'tr' => 'Tüm platform özelliklerini açmak için kimlik doğrulamanızı tamamlayın',
                'ru' => 'Завершите верификацию личности для доступа ко всем функциям платформы'
            ],
            'user.verify.identity_verification_required' => [
                'tr' => 'Kimlik Doğrulama Gerekli',
                'ru' => 'Требуется Верификация Личности'
            ],
            'user.verify.compliance_access_description' => [
                'tr' => 'Düzenlemelere uymak ve tüm özelliklere erişmek için KYC doğrulamanızı tamamlayın.',
                'ru' => 'Завершите KYC верификацию для соответствия требованиям и доступа ко всем функциям.'
            ],
            'user.verify.verified' => [
                'tr' => 'Doğrulandı',
                'ru' => 'Верифицировано'
            ],
            'user.verify.account_verified_success' => [
                'tr' => 'Hesabınız başarıyla doğrulandı!',
                'ru' => 'Ваш аккаунт успешно верифицирован!'
            ],
            'user.verify.under_review' => [
                'tr' => 'İncelemede',
                'ru' => 'На Рассмотрении'
            ],
            'user.verify.documents_under_review' => [
                'tr' => 'Belgeleriniz inceleniyor. Lütfen ekibimizin doğrulamanızı işlemesini bekleyin.',
                'ru' => 'Ваши документы рассматриваются. Пожалуйста, дождитесь обработки верификации нашей командой.'
            ],
            'user.verify.complete_verification' => [
                'tr' => 'Doğrulamayı Tamamla',
                'ru' => 'Завершить Верификацию'
            ],
            'user.verify.more_info' => [
                'tr' => 'Daha Fazla Bilgi',
                'ru' => 'Подробнее'
            ],
            'user.verify.what_is_kyc' => [
                'tr' => 'KYC Doğrulama Nedir?',
                'ru' => 'Что такое KYC Верификация?'
            ],
            'user.verify.security_compliance' => [
                'tr' => 'Güvenlik ve Uyumluluk',
                'ru' => 'Безопасность и Соответствие'
            ],
            'user.verify.security_compliance_desc' => [
                'tr' => 'Platform güvenliğini ve düzenleyici uyumluluğu sağlar',
                'ru' => 'Обеспечивает безопасность платформы и соответствие требованиям'
            ],
            'user.verify.identity_protection' => [
                'tr' => 'Kimlik Koruması',
                'ru' => 'Защита Личности'
            ],
            'user.verify.identity_protection_desc' => [
                'tr' => 'Kimliğinizi korur ve dolandırıcılığı önler',
                'ru' => 'Защищает вашу личность и предотвращает мошенничество'
            ],
            'user.verify.full_access' => [
                'tr' => 'Tam Erişim',
                'ru' => 'Полный Доступ'
            ],
            'user.verify.full_access_desc' => [
                'tr' => 'Tüm ticaret ve yatırım özelliklerini açar',
                'ru' => 'Открывает все торговые и инвестиционные функции'
            ],
            'user.verify.fast_process' => [
                'tr' => 'Hızlı Süreç',
                'ru' => 'Быстрый Процесс'
            ],
            'user.verify.fast_process_desc' => [
                'tr' => 'Basit 3 adımlı doğrulama süreci',
                'ru' => 'Простой 3-этапный процесс верификации'
            ],
            'user.verify.need_help' => [
                'tr' => 'Yardıma İhtiyacınız Var mı?',
                'ru' => 'Нужна Помощь?'
            ],
            'user.verify.support_team_ready' => [
                'tr' => 'Destek ekibimiz doğrulama süreciyle ilgili size yardımcı olmaya hazır.',
                'ru' => 'Наша команда поддержки готова помочь вам с процессом верификации.'
            ],
            'user.verify.live_chat' => [
                'tr' => 'Canlı Sohbet',
                'ru' => 'Онлайн Чат'
            ],
            'user.verify.email_support' => [
                'tr' => 'E-posta Desteği',
                'ru' => 'Поддержка по Email'
            ],
            'user.verify.available_24_7' => [
                'tr' => '7/24 Mevcut',
                'ru' => 'Доступно 24/7'
            ],
            'user.verify.get_support' => [
                'tr' => 'Destek Al',
                'ru' => 'Получить Поддержку'
            ],
            'user.verify.hide_details' => [
                'tr' => 'Ayrıntıları Gizle',
                'ru' => 'Скрыть Детали'
            ]
        ];

        $createdCount = 0;
        $updatedCount = 0;

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            if ($phrase->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $updatedCount++;
            }

            // Handle Turkish translation
            if (isset($translations['tr'])) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $turkish->id,
                    ],
                    [
                        'translation' => $translations['tr']
                    ]
                );
            }

            // Handle Russian translation
            if (isset($translations['ru'])) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $russian->id,
                    ],
                    [
                        'translation' => $translations['ru']
                    ]
                );
            }
        }

        $this->command->info("Verify Page Phrases Seeder completed!");
        $this->command->info("Created {$createdCount} new phrases, updated {$updatedCount} existing phrases.");
    }
}