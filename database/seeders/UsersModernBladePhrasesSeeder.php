<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UsersModernBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Notifications - Console/Debug Messages
            'admin.notifications.filtering_by_role' => [
                'tr' => 'Role göre filtreleniyor',
                'ru' => 'Фильтрация по роли',
            ],

            // User Status Management
            'admin.users.change_user_status' => [
                'tr' => 'Kullanıcı Durumunu Değiştir',
                'ru' => 'Изменить статус пользователя',
            ],
            'admin.users.confirm_change_user_status' => [
                'tr' => 'Bu kullanıcının durumunu değiştirmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите изменить статус этого пользователя?',
            ],
            'admin.actions.yes_change' => [
                'tr' => 'Evet, Değiştir',
                'ru' => 'Да, изменить',
            ],

            // User Deletion
            'admin.users.delete_user' => [
                'tr' => 'Kullanıcıyı Sil',
                'ru' => 'Удалить пользователя',
            ],
            'admin.users.confirm_delete_user_irreversible' => [
                'tr' => 'Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
                'ru' => 'Вы уверены, что хотите удалить этого пользователя? Это действие нельзя отменить!',
            ],
            'admin.actions.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, удалить',
            ],

            // Bulk Operations - Warnings
            'admin.notifications.warning' => [
                'tr' => 'Uyarı',
                'ru' => 'Предупреждение',
            ],
            'admin.users.please_select_at_least_one_user' => [
                'tr' => 'Lütfen en az bir kullanıcı seçin.',
                'ru' => 'Пожалуйста, выберите хотя бы одного пользователя.',
            ],

            // Bulk Activate
            'admin.users.bulk_activate' => [
                'tr' => 'Toplu Aktifleştir',
                'ru' => 'Групповая активация',
            ],
            'admin.users.users_to_activate_confirm' => [
                'tr' => 'kullanıcıyı aktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей активировать, вы уверены?',
            ],
            'admin.actions.yes_activate' => [
                'tr' => 'Evet, Aktifleştir',
                'ru' => 'Да, активировать',
            ],

            // Bulk Deactivate
            'admin.users.bulk_deactivate' => [
                'tr' => 'Toplu Deaktifleştir',
                'ru' => 'Групповая деактивация',
            ],
            'admin.users.users_to_deactivate_confirm' => [
                'tr' => 'kullanıcıyı deaktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей деактивировать, вы уверены?',
            ],
            'admin.actions.yes_deactivate' => [
                'tr' => 'Evet, Deaktifleştir',
                'ru' => 'Да, деактивировать',
            ],

            // Notifications - Info
            'admin.notifications.info' => [
                'tr' => 'Bilgi',
                'ru' => 'Информация',
            ],

            // Feature Status Messages
            'admin.features.export_feature_coming_soon' => [
                'tr' => 'Dışa aktarma özelliği yakında eklenecek.',
                'ru' => 'Функция экспорта скоро будет добавлена.',
            ],
            'admin.features.user_export_feature_coming_soon' => [
                'tr' => 'Kullanıcı dışa aktarma özelliği yakında eklenecek.',
                'ru' => 'Функция экспорта пользователей скоро будет добавлена.',
            ],

            // Bulk Delete
            'admin.users.delete_selected_users' => [
                'tr' => 'Seçilen Kullanıcıları Sil',
                'ru' => 'Удалить выбранных пользователей',
            ],
            'admin.users.users_to_delete_irreversible_confirm' => [
                'tr' => 'kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
                'ru' => 'пользователей удалить? Это действие нельзя отменить!',
            ],
        ];

        foreach ($phrases as $key => $translations) {
            // Create or update phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create or update translations
            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : 2; // 1 = Turkish, 2 = Russian
                
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

        $this->command->info('Users modern blade phrases seeded successfully! Total: ' . count($phrases));
    }
}