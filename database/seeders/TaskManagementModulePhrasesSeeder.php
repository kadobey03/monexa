<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class TaskManagementModulePhrasesSeeder extends Seeder
{
    public function run()
    {
        echo "\n=== TASK MANAGEMENT MODULE PHRASES SEEDER ===\n";
        
        $phrases = [
            // Page Titles
            'admin.tasks.management_title' => [
                'tr' => 'Görev Yönetimi',
                'ru' => 'Управление задачами'
            ],
            'admin.tasks.create_new_title' => [
                'tr' => 'Yeni Görev Oluştur',
                'ru' => 'Создать новую задачу'
            ],
            'admin.tasks.my_tasks_title' => [
                'tr' => 'Görevlerim',
                'ru' => 'Мои задачи'
            ],
            
            // Descriptions
            'admin.tasks.management_description' => [
                'tr' => 'Tüm görevleri yönetin ve takip edin',
                'ru' => 'Управляйте и отслеживайте все задачи'
            ],
            'admin.tasks.create_description' => [
                'tr' => 'Sistemde yeni görev tanımlayın ve yöneticiye atayın',
                'ru' => 'Определите новую задачу в системе и назначьте менеджеру'
            ],
            'admin.tasks.my_tasks_description' => [
                'tr' => 'Bana atanan görevleri görüntüle ve yönet',
                'ru' => 'Просматривать и управлять задачами, назначенными мне'
            ],
            
            // Table Headers
            'admin.tasks.table.task_title' => [
                'tr' => 'Görev Başlığı',
                'ru' => 'Название задачи'
            ],
            'admin.tasks.table.assigned_person' => [
                'tr' => 'Atanan Kişi',
                'ru' => 'Назначенное лицо'
            ],
            'admin.tasks.table.assignee' => [
                'tr' => 'Atayan',
                'ru' => 'Назначивший'
            ],
            'admin.tasks.table.start_date' => [
                'tr' => 'Başlangıç',
                'ru' => 'Начало'
            ],
            'admin.tasks.table.end_date' => [
                'tr' => 'Bitiş',
                'ru' => 'Конец'
            ],
            'admin.tasks.table.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.tasks.table.created_at' => [
                'tr' => 'Oluşturulma',
                'ru' => 'Создано'
            ],
            'admin.tasks.table.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.tasks.table.note' => [
                'tr' => 'Not',
                'ru' => 'Примечание'
            ],
            
            // Form Labels
            'admin.tasks.form.task_title' => [
                'tr' => 'Görev Başlığı',
                'ru' => 'Название задачи'
            ],
            'admin.tasks.form.task_description' => [
                'tr' => 'Görev Açıklaması',
                'ru' => 'Описание задачи'
            ],
            'admin.tasks.form.responsible_manager' => [
                'tr' => 'Sorumlu Yönetici',
                'ru' => 'Ответственный менеджер'
            ],
            'admin.tasks.form.task_assignment' => [
                'tr' => 'Görev Ataması',
                'ru' => 'Назначение задачи'
            ],
            'admin.tasks.form.start_date' => [
                'tr' => 'Başlangıç Tarihi',
                'ru' => 'Дата начала'
            ],
            'admin.tasks.form.end_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата окончания'
            ],
            'admin.tasks.form.priority' => [
                'tr' => 'Öncelik',
                'ru' => 'Приоритет'
            ],
            'admin.tasks.form.priority_level' => [
                'tr' => 'Öncelik Seviyesi',
                'ru' => 'Уровень приоритета'
            ],
            'admin.tasks.form.note' => [
                'tr' => 'Not',
                'ru' => 'Примечание'
            ],
            
            // Placeholders
            'admin.tasks.placeholder.task_title' => [
                'tr' => 'Görev başlığını buraya yazın...',
                'ru' => 'Введите название задачи здесь...'
            ],
            'admin.tasks.placeholder.task_description' => [
                'tr' => 'Görev ile ilgili detaylı açıklamayı buraya yazın...',
                'ru' => 'Введите подробное описание задачи здесь...'
            ],
            'admin.tasks.placeholder.select_manager' => [
                'tr' => 'Yönetici seçin...',
                'ru' => 'Выберите менеджера...'
            ],
            'admin.tasks.placeholder.select_priority' => [
                'tr' => 'Öncelik seviyesi seçin...',
                'ru' => 'Выберите уровень приоритета...'
            ],
            
            // Priority Levels
            'admin.tasks.priority.immediately' => [
                'tr' => '🚨 Hemen - Kritik',
                'ru' => '🚨 Немедленно - Критично'
            ],
            'admin.tasks.priority.high' => [
                'tr' => '🔥 Yüksek - Acil',
                'ru' => '🔥 Высокий - Срочно'
            ],
            'admin.tasks.priority.medium' => [
                'tr' => '⚡ Orta - Normal',
                'ru' => '⚡ Средний - Нормально'
            ],
            'admin.tasks.priority.low' => [
                'tr' => '⏰ Düşük - Ertelenebilir',
                'ru' => '⏰ Низкий - Можно отложить'
            ],
            
            // Status Messages
            'admin.tasks.status.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            'admin.tasks.status.completed' => [
                'tr' => 'Tamamlandı',
                'ru' => 'Завершено'
            ],
            
            // Buttons
            'admin.tasks.button.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.tasks.button.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.tasks.button.create_task' => [
                'tr' => 'Görev Oluştur',
                'ru' => 'Создать задачу'
            ],
            'admin.tasks.button.save_changes' => [
                'tr' => 'Değişiklikleri Kaydet',
                'ru' => 'Сохранить изменения'
            ],
            'admin.tasks.button.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.tasks.button.mark_completed' => [
                'tr' => 'Tamamlandı İşaretle',
                'ru' => 'Отметить как выполненное'
            ],
            
            // Modal Titles
            'admin.tasks.modal.edit_task' => [
                'tr' => 'Görev Düzenle',
                'ru' => 'Редактировать задачу'
            ],
            'admin.tasks.modal.task_info' => [
                'tr' => 'Görev Bilgileri',
                'ru' => 'Информация о задаче'
            ],
            
            // Statistics & Summary
            'admin.tasks.stats.total_tasks' => [
                'tr' => 'Toplam Görevler',
                'ru' => 'Всего задач'
            ],
            'admin.tasks.stats.pending_tasks' => [
                'tr' => 'Bekleyen',
                'ru' => 'В ожидании'
            ],
            'admin.tasks.stats.completed_tasks' => [
                'tr' => 'Tamamlanan',
                'ru' => 'Завершенные'
            ],
            'admin.tasks.stats.task_count' => [
                'tr' => 'Görev',
                'ru' => 'задач'
            ],
            'admin.tasks.stats.completion_rate' => [
                'tr' => 'Tamamlama oranı',
                'ru' => 'Коэффициент завершения'
            ],
            'admin.tasks.stats.showing_total' => [
                'tr' => 'Toplam {count} görev gösteriliyor',
                'ru' => 'Показано всего {count} задач'
            ],
            
            // Empty States
            'admin.tasks.empty.no_tasks' => [
                'tr' => 'Henüz görev yok',
                'ru' => 'Пока нет задач'
            ],
            'admin.tasks.empty.no_tasks_description' => [
                'tr' => 'Yeni görevler oluşturduğunuzda burada görünecek.',
                'ru' => 'Новые задачи будут отображаться здесь после создания.'
            ],
            'admin.tasks.empty.assigned_tasks_description' => [
                'tr' => 'Size atanan görevler burada görünecek.',
                'ru' => 'Назначенные вам задачи будут отображаться здесь.'
            ],
            
            // Section Titles
            'admin.tasks.section.task_list' => [
                'tr' => 'Görev Listesi',
                'ru' => 'Список задач'
            ],
            'admin.tasks.section.task_details' => [
                'tr' => 'Görev Detayları',
                'ru' => 'Детали задачи'
            ],
            
            // Confirmations
            'admin.tasks.confirm.delete' => [
                'tr' => 'Bu görevi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту задачу?'
            ],
            'admin.tasks.confirm.mark_completed' => [
                'tr' => 'Bu görevi tamamlandı olarak işaretlemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите отметить эту задачу как выполненную?'
            ],
            
            // Form Descriptions
            'admin.tasks.desc.task_title' => [
                'tr' => 'Görev için açıklayıcı başlık',
                'ru' => 'Описательное название задачи'
            ],
            'admin.tasks.desc.responsible_manager' => [
                'tr' => 'Görev atanacak yönetici',
                'ru' => 'Менеджер, которому будет назначена задача'
            ],
            'admin.tasks.desc.start_date' => [
                'tr' => 'Görev başlangıç zamanı',
                'ru' => 'Время начала задачи'
            ],
            'admin.tasks.desc.end_date' => [
                'tr' => 'Görev bitiş zamanı',
                'ru' => 'Время окончания задачи'
            ],
            'admin.tasks.desc.priority' => [
                'tr' => 'Görevin aciliyet derecesi',
                'ru' => 'Степень срочности задачи'
            ]
        ];

        $processedCount = 0;
        $newTranslationsCount = 0;
        
        // Language ID mapping
        $languageIds = [
            'tr' => 1,  // Turkish
            'ru' => 2   // Russian
        ];

        DB::beginTransaction();

        try {
            foreach ($phrases as $key => $translations) {
                // Create or get phrase
                $phrase = Phrase::firstOrCreate([
                    'key' => $key
                ], [
                    'group' => 'admin.tasks',
                    'description' => "Task management phrase: {$key}"
                ]);

                foreach ($translations as $langCode => $translation) {
                    $languageId = $languageIds[$langCode];
                    
                    // Check if translation already exists
                    $existingTranslation = PhraseTranslation::where([
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ])->first();

                    if (!$existingTranslation) {
                        PhraseTranslation::create([
                            'phrase_id' => $phrase->id,
                            'language_id' => $languageId,
                            'translation' => $translation
                        ]);
                        $newTranslationsCount++;
                    }
                }
                
                $processedCount++;
            }

            DB::commit();
            
            echo "Total phrases processed: {$processedCount}\n";
            echo "New phrase translations added: {$newTranslationsCount}\n";
            echo "Categories covered: admin.tasks\n";
            echo "✅ Task Management Module phrases seeded successfully!\n";
            
        } catch (\Exception $e) {
            DB::rollback();
            echo "❌ Error seeding phrases: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}