<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class PhrasesModulePhrasesSeeder extends Seeder
{
    public function run()
    {
        echo "\n=== PHRASES MODULE PHRASES SEEDER ===\n";
        
        $phrases = [
            // Page Headers
            'admin.translations.title' => [
                'tr' => 'Dil/Çeviri Yönetimi',
                'ru' => 'Управление языками/переводами'
            ],
            'admin.translations.description' => [
                'tr' => 'Sistem genelinde kullanılan tüm çevirileri yönetin ve düzenleyin',
                'ru' => 'Управляйте и редактируйте все переводы, используемые в системе'
            ],
            
            // Action Buttons
            'admin.translations.new_translation' => [
                'tr' => 'Yeni Çeviri',
                'ru' => 'Новый перевод'
            ],
            'admin.translations.import_export' => [
                'tr' => 'Aktarım',
                'ru' => 'Импорт/Экспорт'
            ],
            'admin.translations.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            'admin.translations.import' => [
                'tr' => 'İçe Aktar',
                'ru' => 'Импорт'
            ],
            'admin.translations.clear_cache' => [
                'tr' => 'Önbellek Temizle',
                'ru' => 'Очистить кеш'
            ],
            
            // Statistics
            'admin.translations.stats.total_phrases' => [
                'tr' => 'Toplam İfade',
                'ru' => 'Всего фраз'
            ],
            'admin.translations.stats.translated' => [
                'tr' => 'Çevrildi',
                'ru' => 'Переведено'
            ],
            'admin.translations.stats.untranslated' => [
                'tr' => 'Çevrilmedi',
                'ru' => 'Не переведено'
            ],
            'admin.translations.stats.needs_review' => [
                'tr' => 'İnceleme Bekliyor',
                'ru' => 'Ожидает проверки'
            ],
            'admin.translations.completion_rate' => [
                'tr' => 'Çeviri Tamamlanma Oranı',
                'ru' => 'Процент завершения перевода'
            ],
            
            // Search and Filters
            'admin.translations.search_placeholder' => [
                'tr' => 'İfade veya çeviri ara...',
                'ru' => 'Поиск фразы или перевода...'
            ],
            'admin.translations.filters.all_groups' => [
                'tr' => 'Tüm Gruplar',
                'ru' => 'Все группы'
            ],
            'admin.translations.filters.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все статусы'
            ],
            'admin.translations.filters.translated' => [
                'tr' => 'Çevrildi',
                'ru' => 'Переведено'
            ],
            'admin.translations.filters.untranslated' => [
                'tr' => 'Çevrilmedi',
                'ru' => 'Не переведено'
            ],
            'admin.translations.filters.needs_review' => [
                'tr' => 'İnceleme Bekliyor',
                'ru' => 'Ожидает проверки'
            ],
            'admin.translations.per_page' => [
                'tr' => 'kayıt',
                'ru' => 'записей'
            ],
            'admin.translations.filter_button' => [
                'tr' => 'Filtrele',
                'ru' => 'Фильтр'
            ],
            
            // Table
            'admin.translations.select_all' => [
                'tr' => 'Tümünü Seç',
                'ru' => 'Выбрать все'
            ],
            'admin.translations.translations_found' => [
                'tr' => 'çeviri bulundu',
                'ru' => 'переводов найдено'
            ],
            'admin.translations.selected_items' => [
                'tr' => 'Seçili öğeler:',
                'ru' => 'Выбранные элементы:'
            ],
            'admin.translations.bulk.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.translations.bulk.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            
            // Table Headers
            'admin.translations.table.key' => [
                'tr' => 'İfade Anahtarı',
                'ru' => 'Ключ фразы'
            ],
            'admin.translations.table.translation' => [
                'tr' => 'Çeviri',
                'ru' => 'Перевод'
            ],
            'admin.translations.table.group' => [
                'tr' => 'Grup',
                'ru' => 'Группа'
            ],
            'admin.translations.table.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.translations.table.last_update' => [
                'tr' => 'Son Güncelleme',
                'ru' => 'Последнее обновление'
            ],
            'admin.translations.table.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            
            // Status Labels
            'admin.translations.no_translation' => [
                'tr' => 'Çeviri yok',
                'ru' => 'Нет перевода'
            ],
            'admin.translations.status.translated' => [
                'tr' => 'Çevrildi',
                'ru' => 'Переведено'
            ],
            'admin.translations.status.untranslated' => [
                'tr' => 'Çevrilmedi',
                'ru' => 'Не переведено'
            ],
            'admin.translations.status.needs_review' => [
                'tr' => 'İnceleme Bekliyor',
                'ru' => 'Ожидает проверки'
            ],
            
            // Empty State
            'admin.translations.empty.title' => [
                'tr' => 'Çeviri bulunamadı',
                'ru' => 'Переводы не найдены'
            ],
            'admin.translations.empty.description' => [
                'tr' => 'Seçilen kriterlere uygun çeviri bulunamadı.',
                'ru' => 'Не найдено переводов, соответствующих выбранным критериям.'
            ],
            'admin.translations.empty.add_first' => [
                'tr' => 'İlk Çeviriyi Ekle',
                'ru' => 'Добавить первый перевод'
            ],
            
            // Modal Titles
            'admin.translations.modal.add.title' => [
                'tr' => 'Yeni Çeviri Ekle',
                'ru' => 'Добавить новый перевод'
            ],
            'admin.translations.modal.quick.title' => [
                'tr' => 'Hızlı Çeviri',
                'ru' => 'Быстрый перевод'
            ],
            
            // Form Fields
            'admin.translations.form.key' => [
                'tr' => 'İfade Anahtarı',
                'ru' => 'Ключ фразы'
            ],
            'admin.translations.form.key_placeholder' => [
                'tr' => 'örn: auth.login_button',
                'ru' => 'например: auth.login_button'
            ],
            'admin.translations.form.group' => [
                'tr' => 'Grup',
                'ru' => 'Группа'
            ],
            'admin.translations.form.language' => [
                'tr' => 'Dil',
                'ru' => 'Язык'
            ],
            'admin.translations.form.description' => [
                'tr' => 'Açıklama (İsteğe Bağlı)',
                'ru' => 'Описание (необязательно)'
            ],
            'admin.translations.form.description_placeholder' => [
                'tr' => 'Bu çevirinin ne için kullanıldığını açıklayın',
                'ru' => 'Опишите, для чего используется этот перевод'
            ],
            'admin.translations.form.translation' => [
                'tr' => 'Çeviri',
                'ru' => 'Перевод'
            ],
            'admin.translations.form.translation_placeholder' => [
                'tr' => 'Çeviri metnini girin...',
                'ru' => 'Введите текст перевода...'
            ],
            'admin.translations.form.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.translations.form.save' => [
                'tr' => 'Çeviri Ekle',
                'ru' => 'Добавить перевод'
            ],
            
            // Form Groups
            'admin.translations.groups.general' => [
                'tr' => 'Genel',
                'ru' => 'Общее'
            ],
            'admin.translations.groups.auth' => [
                'tr' => 'Kimlik Doğrulama',
                'ru' => 'Аутентификация'
            ],
            'admin.translations.groups.validation' => [
                'tr' => 'Doğrulama',
                'ru' => 'Валидация'
            ],
            'admin.translations.groups.emails' => [
                'tr' => 'E-postalar',
                'ru' => 'Электронная почта'
            ],
            'admin.translations.groups.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            
            // Notification Messages
            'admin.translations.notifications.updated' => [
                'tr' => 'Çeviri başarıyla güncellendi!',
                'ru' => 'Перевод успешно обновлен!'
            ],
            'admin.translations.notifications.added' => [
                'tr' => 'Çeviri başarıyla eklendi!',
                'ru' => 'Перевод успешно добавлен!'
            ],
            'admin.translations.notifications.deleted' => [
                'tr' => 'Çeviri başarıyla silindi!',
                'ru' => 'Перевод успешно удален!'
            ],
            'admin.translations.notifications.error' => [
                'tr' => 'Bir hata oluştu',
                'ru' => 'Произошла ошибка'
            ],
            'admin.translations.notifications.empty_translation' => [
                'tr' => 'Çeviri boş olamaz!',
                'ru' => 'Перевод не может быть пустым!'
            ],
            'admin.translations.notifications.confirm_delete' => [
                'tr' => 'Bu çeviriyi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить этот перевод?'
            ],
            'admin.translations.notifications.confirm_bulk_delete' => [
                'tr' => 'çeviriyi silmek istediğinizden emin misiniz?',
                'ru' => 'переводов удалить?'
            ],
            'admin.translations.notifications.confirm_cache_clear' => [
                'tr' => 'Çeviri önbelleğini temizlemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите очистить кеш переводов?'
            ],
            'admin.translations.notifications.bulk_delete_not_implemented' => [
                'tr' => 'Toplu silme işlemi henüz implementasyona alınmadı',
                'ru' => 'Массовое удаление еще не реализовано'
            ],
            'admin.translations.notifications.bulk_export_not_implemented' => [
                'tr' => 'Toplu dışa aktarma işlemi henüz implementasyona alınmadı',
                'ru' => 'Массовый экспорт еще не реализован'
            ],
            'admin.translations.notifications.export_not_implemented' => [
                'tr' => 'Dışa aktarma işlemi henüz implementasyona alınmadı',
                'ru' => 'Экспорт еще не реализован'
            ],
            'admin.translations.notifications.cache_clear_not_implemented' => [
                'tr' => 'Önbellek temizleme işlemi henüz implementasyona alınmadı',
                'ru' => 'Очистка кеша еще не реализована'
            ],
            
            // Additional status messages  
            'admin.translations.admin_prefix' => [
                'tr' => 'Admin:',
                'ru' => 'Админ:'
            ],
            'admin.translations.system' => [
                'tr' => 'Sistem',
                'ru' => 'Система'
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
                    'group' => 'admin.translations',
                    'description' => "Translation management phrase: {$key}"
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
            echo "Categories covered: admin.translations\n";
            echo "✅ Phrases Module phrases seeded successfully!\n";
            
        } catch (\Exception $e) {
            DB::rollback();
            echo "❌ Error seeding phrases: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}