<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class AdminLeadStatusesPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // Lead Status Specific Module - only NEW phrases not conflicting with existing admin.leads
                [
                    'key' => 'admin.lead_statuses.management',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Lead Status Yönetimi',
                        2 => 'Управление Статусами Лидов'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.management_desc',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Lead statuslarını oluşturun, düzenleyin ve yönetin',
                        2 => 'Создавайте, редактируйте и управляйте статусами лидов'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.add_new_status',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Yeni Status Ekle',
                        2 => 'Добавить Новый Статус'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.total_statuses',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Toplam Status',
                        2 => 'Всего Статусов'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.active_statuses',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Aktif Statuslar',
                        2 => 'Активные Статусы'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.inactive_statuses',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Pasif Statuslar',
                        2 => 'Неактивные Статусы'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.total_leads',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Toplam Leadler',
                        2 => 'Общее Количество Лидов'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.status_list',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Status Listesi',
                        2 => 'Список Статусов'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.display_name',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Görünen Ad',
                        2 => 'Отображаемое Имя'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.user_count',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcı',
                        2 => 'Пользователи'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.sort_order',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Sıra',
                        2 => 'Порядок'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.status_state',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Durum',
                        2 => 'Состояние'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.lead',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'lead',
                        2 => 'лид'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.confirm_delete_status',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Bu statusu silmek istediğinizden emin misiniz?',
                        2 => 'Вы уверены, что хотите удалить этот статус?'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.new_lead_status',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Yeni Lead Status',
                        2 => 'Новый Статус Лида'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.status_name_code',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Status Adı (Kod)',
                        2 => 'Имя Статуса (Код)'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.status_name_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'örnek: interested',
                        2 => 'например: interested'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.only_lowercase_underscore',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Sadece küçük harf ve alt çizgi kullanın',
                        2 => 'Используйте только строчные буквы и подчеркивания'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.display_name_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'İlgileniyor',
                        2 => 'Заинтересован'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.description_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Bu statusun açıklaması...',
                        2 => 'Описание этого статуса...'
                    ]
                ],
                [
                    'key' => 'admin.lead_statuses.edit_lead_status',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Lead Status Düzenle',
                        2 => 'Редактировать Статус Лида'
                    ]
                ]
            ];

            foreach ($phrases as $phraseData) {
                // Create phrase
                $phrase = Phrase::firstOrCreate([
                    'key' => $phraseData['key'],
                    'group' => $phraseData['group']
                ]);

                // Add translations
                foreach ($phraseData['translations'] as $languageId => $translation) {
                    PhraseTranslation::updateOrCreate([
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ], [
                        'translation' => $translation
                    ]);
                }
            }
        });

        $this->command->info('✅ Admin Lead Statuses phrases seeded successfully! (21 phrases)');
    }
}