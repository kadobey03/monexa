<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdditionalFormPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for additional form phrases.
     */
    public function run(): void
    {
        $phrases = [
            // Note form phrases
            'admin.forms.note_title' => [
                'tr' => 'Not Başlığı',
                'ru' => 'Заголовок заметки'
            ],
            'admin.forms.note_title_placeholder' => [
                'tr' => 'Not başlığını girin...',
                'ru' => 'Введите заголовок заметки...'
            ],
            'admin.forms.note_content' => [
                'tr' => 'Not İçeriği',
                'ru' => 'Содержание заметки'
            ],
            'admin.forms.note_content_placeholder' => [
                'tr' => 'Not içeriğini yazın...',
                'ru' => 'Напишите содержание заметки...'
            ],
            'admin.forms.category' => [
                'tr' => 'Kategori',
                'ru' => 'Категория'
            ],
            'admin.forms.select_category' => [
                'tr' => 'Kategori seçin',
                'ru' => 'Выберите категорию'
            ],
            'admin.forms.color' => [
                'tr' => 'Renk',
                'ru' => 'Цвет'
            ],
            'admin.forms.colors.blue' => [
                'tr' => 'Mavi',
                'ru' => 'Синий'
            ],
            'admin.forms.colors.red' => [
                'tr' => 'Kırmızı',
                'ru' => 'Красный'
            ],
            'admin.forms.colors.green' => [
                'tr' => 'Yeşil',
                'ru' => 'Зеленый'
            ],
            'admin.forms.colors.yellow' => [
                'tr' => 'Sarı',
                'ru' => 'Желтый'
            ],
            'admin.forms.colors.purple' => [
                'tr' => 'Mor',
                'ru' => 'Фиолетовый'
            ],
            'admin.forms.colors.orange' => [
                'tr' => 'Turuncu',
                'ru' => 'Оранжевый'
            ],
            'admin.forms.colors.gray' => [
                'tr' => 'Gri',
                'ru' => 'Серый'
            ],
            'admin.forms.important_note_pinned' => [
                'tr' => 'Önemli not sabitlendi',
                'ru' => 'Важная заметка закреплена'
            ],
            'admin.forms.reminder_date' => [
                'tr' => 'Hatırlatma Tarihi',
                'ru' => 'Дата напоминания'
            ],
            
            // Character limit messages
            'admin.forms.character_limit_100' => [
                'tr' => '0/100 karakter',
                'ru' => '0/100 символов'
            ],
            'admin.forms.character_limit_1000' => [
                'tr' => '0/1000 karakter',
                'ru' => '0/1000 символов'
            ],
            'admin.forms.character_limit_250' => [
                'tr' => '0/250 karakter',
                'ru' => '0/250 символов'
            ],
            'admin.forms.character_limit_500' => [
                'tr' => '0/500 karakter',
                'ru' => '0/500 символов'
            ],
            
            // Additional form elements
            'admin.forms.priority' => [
                'tr' => 'Öncelik',
                'ru' => 'Приоритет'
            ],
            'admin.forms.priority.low' => [
                'tr' => 'Düşük',
                'ru' => 'Низкий'
            ],
            'admin.forms.priority.medium' => [
                'tr' => 'Orta',
                'ru' => 'Средний'
            ],
            'admin.forms.priority.high' => [
                'tr' => 'Yüksek',
                'ru' => 'Высокий'
            ],
            'admin.forms.priority.urgent' => [
                'tr' => 'Acil',
                'ru' => 'Срочно'
            ],
            'admin.forms.tags' => [
                'tr' => 'Etiketler',
                'ru' => 'Теги'
            ],
            'admin.forms.add_tag' => [
                'tr' => 'Etiket ekle',
                'ru' => 'Добавить тег'
            ],
            'admin.forms.is_private' => [
                'tr' => 'Özel Not',
                'ru' => 'Частная заметка'
            ],
            'admin.forms.is_public' => [
                'tr' => 'Genel Not',
                'ru' => 'Публичная заметка'
            ],
            'admin.forms.visibility' => [
                'tr' => 'Görünürlük',
                'ru' => 'Видимость'
            ],
            'admin.forms.created_by' => [
                'tr' => 'Oluşturan',
                'ru' => 'Создано пользователем'
            ],
            'admin.forms.updated_by' => [
                'tr' => 'Güncelleyen',
                'ru' => 'Обновлено пользователем'
            ],
            'admin.forms.attachment' => [
                'tr' => 'Ek Dosya',
                'ru' => 'Вложение'
            ],
            'admin.forms.upload_file' => [
                'tr' => 'Dosya Yükle',
                'ru' => 'Загрузить файл'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Phrase oluştur
            $phrase = Phrase::firstOrCreate([
                'key' => $key
            ]);

            // Çeviriler ekle
            foreach ($translations as $lang => $translation) {
                $languageId = $lang === 'tr' ? 1 : 2; // tr=1, ru=2
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation,
                    'is_reviewed' => true
                ]);
            }
        }

        echo "✅ Additional form phrases seeded successfully! Added " . count($phrases) . " phrases.\n";
    }
}