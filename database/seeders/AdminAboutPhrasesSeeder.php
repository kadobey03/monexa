<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminAboutPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Page Header
            'admin.about.page_title' => [
                'tr' => 'Hakkında Remedy Technology',
                'ru' => 'О Remedy Technology'
            ],
            'admin.about.subtitle' => [
                'tr' => 'Profesyonel PHP Script Geliştirme ve Destek Hizmetleri',
                'ru' => 'Профессиональная разработка PHP-скриптов и служба поддержки'
            ],

            // Hero Section
            'admin.about.company_name' => [
                'tr' => 'Remedy Teknoloji',
                'ru' => 'Remedy Технология'
            ],
            'admin.about.hero_subtitle' => [
                'tr' => 'Uzman Laravel PHP Script Geliştirme ve Profesyonel Destek Hizmetleri',
                'ru' => 'Экспертная разработка Laravel PHP-скриптов и профессиональные службы поддержки'
            ],
            'admin.about.hero_description' => [
                'tr' => 'Özel Laravel PHP uygulamaları oluşturma, profesyonel kurulum hizmetleri sağlama ve dünya çapındaki işletmeler için sürekli destek sunma konusunda uzmanız.',
                'ru' => 'Мы специализируемся на создании пользовательских Laravel PHP-приложений, предоставлении профессиональных услуг по установке и непрерывной поддержке для компаний по всему миру.'
            ],
            'admin.about.get_support' => [
                'tr' => 'Destek Al',
                'ru' => 'Получить поддержку'
            ],
            'admin.about.visit_website' => [
                'tr' => 'Web Sitesini Ziyaret Et',
                'ru' => 'Посетить веб-сайт'
            ],

            // Services Grid
            'admin.about.custom_development' => [
                'tr' => 'Özel Geliştirme',
                'ru' => 'Кастомная разработка'
            ],
            'admin.about.custom_development_desc' => [
                'tr' => 'İşletmenizin ihtiyaçlarına göre uyarlanmış Laravel PHP Script Geliştirme',
                'ru' => 'Разработка Laravel PHP-скриптов, адаптированных под потребности вашего бизнеса'
            ],
            'admin.about.custom_solutions' => [
                'tr' => 'Özel Çözümler',
                'ru' => 'Кастомные решения'
            ],

            'admin.about.installation_setup' => [
                'tr' => 'Kurulum ve Ayarlar',
                'ru' => 'Установка и настройки'
            ],
            'admin.about.installation_setup_desc' => [
                'tr' => 'Profesyonel script kurulumu ve sunucu yapılandırması',
                'ru' => 'Профессиональная установка скриптов и настройка серверов'
            ],
            'admin.about.quick_installation' => [
                'tr' => 'Hızlı Kurulum',
                'ru' => 'Быстрая установка'
            ],

            'admin.about.lifetime_support' => [
                'tr' => 'Ömür Boyu Destek',
                'ru' => 'Пожизненная поддержка'
            ],
            'admin.about.lifetime_support_desc' => [
                'tr' => 'Devam eden destek, güncellemeler ve güvenlik iyileştirmeleri',
                'ru' => 'Постоянная поддержка, обновления и улучшения безопасности'
            ],
            'admin.about.support_247' => [
                'tr' => '7/24 Destek',
                'ru' => 'Поддержка 24/7'
            ],

            'admin.about.website_customization' => [
                'tr' => 'Web Sitesi Özelleştirme',
                'ru' => 'Кастомизация веб-сайтов'
            ],
            'admin.about.website_customization_desc' => [
                'tr' => 'Özel markalama ve UI/UX tasarım iyileştirmeleri',
                'ru' => 'Кастомный брендинг и улучшения UI/UX дизайна'
            ],
            'admin.about.custom_design' => [
                'tr' => 'Özel Tasarım',
                'ru' => 'Кастомный дизайн'
            ],

            // Detailed Services
            'admin.about.custom_laravel_development' => [
                'tr' => 'Özel Laravel PHP Script Geliştirme',
                'ru' => 'Кастомная разработка Laravel PHP-скриптов'
            ],
            'admin.about.custom_laravel_desc' => [
                'tr' => 'Benzersiz bir özellik veya özel yapım bir Laravel PHP script\'e mi ihtiyacınız var? Uzman geliştiricilerimiz mevcut script\'leri değiştirebilir veya işletmenizin ihtiyaçlarına uygun tamamen yeni çözümler oluşturabilir.',
                'ru' => 'Нужна уникальная функция или кастомный Laravel PHP-скрипт? Наши эксперты-разработчики могут модифицировать существующие скрипты или создать полностью новые решения, соответствующие потребностям вашего бизнеса.'
            ],

            'admin.about.expertise' => [
                'tr' => 'Uzmanlıklar:',
                'ru' => 'Экспертиза:'
            ],
            'admin.about.bitcoin_platforms' => [
                'tr' => 'Bitcoin Yatırım Platformları',
                'ru' => 'Платформы для инвестиций в Bitcoin'
            ],
            'admin.about.online_banking' => [
                'tr' => 'Çevrimiçi Bankacılık Sistemleri',
                'ru' => 'Системы онлайн-банкинга'
            ],
            'admin.about.crypto_exchange' => [
                'tr' => 'Kripto Borsası Platformları',
                'ru' => 'Платформы криптовалютных бирж'
            ],
            'admin.about.delivery_tracking' => [
                'tr' => 'Kurye Takip Yazılımı',
                'ru' => 'ПО для отслеживания курьеров'
            ],

            'admin.about.custom_feature_integration' => [
                'tr' => '✅ Özel Özellik Entegrasyonu',
                'ru' => '✅ Интеграция кастомных функций'
            ],
            'admin.about.responsive_secure' => [
                'tr' => '✅ Tamamen Duyarlı ve Güvenli',
                'ru' => '✅ Полностью адаптивный и безопасный'
            ],
            'admin.about.fast_delivery' => [
                'tr' => '✅ Hızlı Teslimat',
                'ru' => '✅ Быстрая поставка'
            ],

            // Installation Service
            'admin.about.installation_service_title' => [
                'tr' => 'Script Kurulum ve Ayarlar Hizmeti',
                'ru' => 'Услуги по установке и настройке скриптов'
            ],
            'admin.about.installation_service_desc' => [
                'tr' => 'Sunucu kurulumları veya script yüklemeleri konusunda deneyimli değil misiniz? Her şeyi ekibimize bırakın! Profesyonel script kurulum hizmetleri sunuyoruz.',
                'ru' => 'Не имеете опыта в настройке серверов или установке скриптов? Оставьте все нашей команде! Мы предоставляем профессиональные услуги по установке скриптов.'
            ],
            'admin.about.whats_included' => [
                'tr' => 'Nelerin Dahil Olduğu:',
                'ru' => 'Что включено:'
            ],
            'admin.about.fast_secure_installation' => [
                'tr' => 'Hızlı ve Güvenli Kurulum',
                'ru' => 'Быстрая и безопасная установка'
            ],
            'admin.about.database_configuration' => [
                'tr' => 'Veritabanı Yapılandırması',
                'ru' => 'Настройка базы данных'
            ],
            'admin.about.bug_fixes_optimization' => [
                'tr' => 'Hata Düzeltmeleri ve Optimizasyon',
                'ru' => 'Исправление ошибок и оптимизация'
            ],
            'admin.about.ssl_installation' => [
                'tr' => 'SSL Sertifikası Kurulumu',
                'ru' => 'Установка SSL-сертификата'
            ],
            'admin.about.hassle_free' => [
                'tr' => 'Sorunsuz:',
                'ru' => 'Без проблем:'
            ],
            'admin.about.hassle_free_desc' => [
                'tr' => ' Herhangi bir teknik baş ağrısı olmadan script\'inizi kullanmaya başlayın!',
                'ru' => ' Начните использовать свой скрипт без каких-либо технических проблем!'
            ],

            // Lifetime Support
            'admin.about.lifetime_support_title' => [
                'tr' => 'Ömür Boyu Destek ve Güncellemeler',
                'ru' => 'Пожизненная поддержка и обновления'
            ],
            'admin.about.lifetime_support_full_desc' => [
                'tr' => 'PHP script\'lerimiz için ömür boyu destek ve periyodik güncellemeler sağlıyoruz, böylece güvenli, hızlı kalır ve en son teknolojilerle uyumlu kalır.',
                'ru' => 'Мы обеспечиваем пожизненную поддержку и периодические обновления для наших PHP-скриптов, чтобы они оставались безопасными, быстрыми и совместимыми с новейшими технологиями.'
            ],
            'admin.about.support_coverage' => [
                'tr' => 'Destek Kapsamına Dahil:',
                'ru' => 'Включено в поддержку:'
            ],
            'admin.about.technical_support' => [
                'tr' => 'Küçük Sorunlar için Teknik Destek',
                'ru' => 'Техническая поддержка по мелким вопросам'
            ],
            'admin.about.bug_fixes_performance' => [
                'tr' => 'Hata Düzeltmeleri ve Performans İyileştirmeleri',
                'ru' => 'Исправления ошибок и улучшения производительности'
            ],
            'admin.about.security_feature_updates' => [
                'tr' => 'Güvenlik ve Özellik Güncellemeleri',
                'ru' => 'Обновления безопасности и функций'
            ],
            'admin.about.expert_guidance' => [
                'tr' => 'Uzman Rehberlik ve Danışmanlık',
                'ru' => 'Экспертное руководство и консультации'
            ],
            'admin.about.always_updated_secure' => [
                'tr' => 'Her Zaman Güncel ve Güvenli',
                'ru' => 'Всегда актуально и безопасно'
            ],

            // Website Customization
            'admin.about.website_customization_title' => [
                'tr' => 'Web Sitesi Özelleştirme ve Markalama',
                'ru' => 'Кастомизация и брендинг веб-сайтов'
            ],
            'admin.about.website_customization_full_desc' => [
                'tr' => 'Web sitenize profesyonel ve benzersiz bir görünüm vermek mi istiyorsunuz? İşletmenizin kimliğine uygun özel markalama ve UI/UX iyileştirmeleri sunuyoruz.',
                'ru' => 'Хотите придать своему веб-сайту профессиональный и уникальный вид? Мы предлагаем кастомный брендинг и улучшения UI/UX, соответствующие идентичности вашего бизнеса.'
            ],
            'admin.about.design_services' => [
                'tr' => 'Tasarım Hizmetleri:',
                'ru' => 'Дизайн-услуги:'
            ],
            'admin.about.custom_logo_branding' => [
                'tr' => 'Özel Logo ve Markalama',
                'ru' => 'Кастомный логотип и брендинг'
            ],
            'admin.about.ui_ux_improvements' => [
                'tr' => 'UI/UX İyileştirmeleri',
                'ru' => 'Улучшения UI/UX'
            ],
            'admin.about.mobile_seo_optimization' => [
                'tr' => 'Mobil ve SEO Optimizasyonu',
                'ru' => 'Мобильная и SEO оптимизация'
            ],
            'admin.about.modern_responsive_design' => [
                'tr' => 'Modern Duyarlı Tasarım',
                'ru' => 'Современный адаптивный дизайн'
            ],
            'admin.about.target' => [
                'tr' => 'Hedef:',
                'ru' => 'Цель:'
            ],
            'admin.about.target_desc' => [
                'tr' => ' Markanızı gerçekten temsil eden bir web sitesi oluşturun!',
                'ru' => ' Создайте веб-сайт, который действительно представляет ваш бренд!'
            ],

            // Contact Section
            'admin.about.ready_to_start' => [
                'tr' => 'Başlamaya Hazır mısınız?',
                'ru' => 'Готовы начать?'
            ],
            'admin.about.ready_to_start_desc' => [
                'tr' => 'Kişiselleştirilmiş bir teklif ve danışmanlık için bugün bizimle iletişime geçin',
                'ru' => 'Свяжитесь с нами сегодня для персонализированного предложения и консультации'
            ],
            'admin.about.telegram_support' => [
                'tr' => 'Telegram Destek',
                'ru' => 'Поддержка в Telegram'
            ],
            'admin.about.join_channel' => [
                'tr' => 'Kanala Katıl',
                'ru' => 'Присоединиться к каналу'
            ],
            'admin.about.visit_website_title' => [
                'tr' => 'Web Sitesini Ziyaret Et',
                'ru' => 'Посетить веб-сайт'
            ],
            'admin.about.phone_support' => [
                'tr' => 'Telefon Desteği',
                'ru' => 'Телефонная поддержка'
            ],
            'admin.about.contact_us' => [
                'tr' => 'İletişime Geç',
                'ru' => 'Связаться с нами'
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
                    ['description' => 'Admin about page - ' . $key]
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

        echo "\n" . count($phrases) . " about page phrases seeded successfully!\n";
    }
}