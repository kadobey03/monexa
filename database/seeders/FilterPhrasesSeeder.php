<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class FilterPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for filter phrases.
     */
    public function run(): void
    {
        $phrases = [
            // Filter phrases
            'admin.filters.search_users' => [
                'tr' => 'Kullanıcılarda ara...',
                'ru' => 'Поиск пользователей...'
            ],
            'admin.filters.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все статусы'
            ],
            'admin.filters.all_roles' => [
                'tr' => 'Tüm Roller',
                'ru' => 'Все роли'
            ],
            'admin.filters.advanced_filtering' => [
                'tr' => 'Gelişmiş Filtreleme',
                'ru' => 'Расширенная фильтрация'
            ],
            'admin.filters.filter_users_by_status_admin_date' => [
                'tr' => 'Kullanıcıları duruma, yöneticiye ve tarihe göre filtreleyin',
                'ru' => 'Фильтр пользователей по статусу, администратору и дате'
            ],
            'admin.filters.active_filters' => [
                'tr' => 'Aktif Filtreler',
                'ru' => 'Активные фильтры'
            ],
            'admin.filters.all_admins' => [
                'tr' => 'Tüm Yöneticiler',
                'ru' => 'Все администраторы'
            ],
            'admin.filters.start_date' => [
                'tr' => 'Başlangıç Tarihi',
                'ru' => 'Дата начала'
            ],
            'admin.filters.end_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата окончания'
            ],
            'admin.filters.search_by_name_email_phone' => [
                'tr' => 'İsim, e-posta veya telefona göre ara',
                'ru' => 'Поиск по имени, email или телефону'
            ],
            'admin.filters.clear_filters' => [
                'tr' => 'Filtreleri Temizle',
                'ru' => 'Очистить фильтры'
            ],
            'admin.filters.search_member' => [
                'tr' => 'Üye ara...',
                'ru' => 'Поиск участника...'
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

        echo "✅ Filter phrases seeded successfully! Added " . count($phrases) . " phrases.\n";
    }
}