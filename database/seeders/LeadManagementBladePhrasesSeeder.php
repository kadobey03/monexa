<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class LeadManagementBladePhrasesSeeder extends Seeder
{
    public function run(): void
    {
        $phrases = [
            // Lead Management Core
            'admin.leads.lead_management' => [
                'tr' => 'Lead Yönetimi',
                'ru' => 'Управление Лидами',
            ],
            'admin.leads.lead_assignment_system' => [
                'tr' => 'Lead assignment ve yönetim sistemi',
                'ru' => 'Система назначения и управления лидами',
            ],
            'admin.leads.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт',
            ],
            'admin.leads.import' => [
                'tr' => 'İçe Aktar',
                'ru' => 'Импорт',
            ],
            'admin.leads.new_lead' => [
                'tr' => 'Yeni Lead',
                'ru' => 'Новый Лид',
            ],
            'admin.leads.add_new_lead' => [
                'tr' => 'Yeni Lead Ekle',
                'ru' => 'Добавить Нового Лида',
            ],
            'admin.leads.system_loading' => [
                'tr' => 'Lead assignment sistemi yükleniyor...',
                'ru' => 'Система назначения лидов загружается...',
            ],
            'admin.leads.lead_detail' => [
                'tr' => 'Lead Detayı',
                'ru' => 'Детали Лида',
            ],
            'admin.leads.leads' => [
                'tr' => 'Lead\'ler',
                'ru' => 'Лиды',
            ],
            'admin.leads.lead' => [
                'tr' => 'lead',
                'ru' => 'лид',
            ],

            // Lead Status Management
            'admin.leads.status_management' => [
                'tr' => 'Lead Status Yönetimi',
                'ru' => 'Управление Статусами Лидов',
            ],
            'admin.leads.status_management_desc' => [
                'tr' => 'Lead durumlarını oluşturun, düzenleyin ve yönetin',
                'ru' => 'Создавайте, редактируйте и управляйте статусами лидов',
            ],
            'admin.leads.add_new_status' => [
                'tr' => 'Yeni Status Ekle',
                'ru' => 'Добавить Новый Статус',
            ],
            'admin.leads.total_statuses' => [
                'tr' => 'Toplam Status',
                'ru' => 'Всего Статусов',
            ],
            'admin.leads.active_statuses' => [
                'tr' => 'Aktif Status',
                'ru' => 'Активные Статусы',
            ],
            'admin.leads.inactive_statuses' => [
                'tr' => 'Pasif Status',
                'ru' => 'Неактивные Статусы',
            ],
            'admin.leads.status_list' => [
                'tr' => 'Status Listesi',
                'ru' => 'Список Статусов',
            ],

            // Lead Assignment & Members
            'admin.leads.assigned_members' => [
                'tr' => 'Atanan Üyeler',
                'ru' => 'Назначенные Участники',
            ],
            'admin.leads.assigned_members_desc' => [
                'tr' => 'Bana atanan yeni üyeleri yönet ve takip et',
                'ru' => 'Управляйте и отслеживайте назначенных мне новых участников',
            ],
            'admin.leads.assigned_member' => [
                'tr' => 'Atanmış Üye',
                'ru' => 'Назначенный Участник',
            ],
            'admin.leads.new_members' => [
                'tr' => 'Yeni Üyeler',
                'ru' => 'Новые Участники',
            ],
            'admin.leads.assigned_to' => [
                'tr' => 'Atanan',
                'ru' => 'Назначен',
            ],
            'admin.leads.unassigned' => [
                'tr' => 'Atanmamış',
                'ru' => 'Не Назначен',
            ],

            // Lead Actions
            'admin.leads.converted' => [
                'tr' => 'Dönüştürüldü',
                'ru' => 'Конвертирован',
            ],
            'admin.leads.convert' => [
                'tr' => 'Dönüştür',
                'ru' => 'Конвертировать',
            ],
            'admin.leads.edit_status' => [
                'tr' => 'Durum Düzenle',
                'ru' => 'Редактировать Статус',
            ],
            'admin.leads.refresh' => [
                'tr' => 'Yenile',
                'ru' => 'Обновить',
            ],
            'admin.leads.excel' => [
                'tr' => 'Excel',
                'ru' => 'Excel',
            ],

            // Lead Statistics
            'admin.leads.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего',
            ],
            'admin.leads.total_lead' => [
                'tr' => 'Toplam Lead',
                'ru' => 'Всего Лидов',
            ],
            'admin.leads.total_leads' => [
                'tr' => 'Toplam Lead',
                'ru' => 'Всего Лидов',
            ],
            'admin.leads.this_week' => [
                'tr' => 'Bu Hafta',
                'ru' => 'На Этой Неделе',
            ],
            'admin.leads.high_score' => [
                'tr' => 'Yüksek Puan',
                'ru' => 'Высокий Балл',
            ],

            // User Information (if not already exists)
            'admin.users.id' => [
                'tr' => 'ID',
                'ru' => 'ID',
            ],
            'admin.users.balance' => [
                'tr' => 'Bakiye',
                'ru' => 'Баланс',
            ],
            'admin.users.first_name' => [
                'tr' => 'Ad',
                'ru' => 'Имя',
            ],
            'admin.users.last_name' => [
                'tr' => 'Soyad',
                'ru' => 'Фамилия',
            ],
            'admin.users.email' => [
                'tr' => 'Email',
                'ru' => 'Email',
            ],
            'admin.users.phone' => [
                'tr' => 'Telefon',
                'ru' => 'Телефон',
            ],
            'admin.users.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус',
            ],
            'admin.users.registration_date' => [
                'tr' => 'Kayıt Tarihi',
                'ru' => 'Дата Регистрации',
            ],

            // Plan Information (if not already exists)
            'admin.plans.investment_plan' => [
                'tr' => 'Yatırım Planı',
                'ru' => 'Инвестиционный План',
            ],
            'admin.plans.no_plan' => [
                'tr' => 'Plan Yok',
                'ru' => 'Нет Плана',
            ],

            // Actions (if not already exists)
            'admin.actions.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or find the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Add translations
            foreach ($translations as $langCode => $translation) {
                $languageId = $langCode === 'tr' ? 1 : 2; // 1 for Turkish, 2 for Russian
                
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

        $this->command->info('Lead Management blade phrases seeded successfully! Added ' . count($phrases) . ' phrases with Turkish and Russian translations.');
    }
}