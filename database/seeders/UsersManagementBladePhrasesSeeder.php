<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class UsersManagementBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Users Management Page
            [
                'key' => 'admin.users.lead_status',
                'tr' => 'Lead Durumu',
                'ru' => 'Статус лида'
            ],
            [
                'key' => 'admin.users.assigned_admin',
                'tr' => 'Atanan Admin',
                'ru' => 'Назначенный администратор'
            ],
            [
                'key' => 'admin.filters.start',
                'tr' => 'Başlangıç',
                'ru' => 'Начало'
            ],
            [
                'key' => 'admin.filters.end',
                'tr' => 'Bitiş',
                'ru' => 'Конец'
            ],
            [
                'key' => 'admin.filters.filtered',
                'tr' => 'filtrelenmiş',
                'ru' => 'отфильтровано'
            ],
            [
                'key' => 'admin.users.admin',
                'tr' => 'Admin',
                'ru' => 'Администратор'
            ],
            [
                'key' => 'admin.users.status_short',
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            [
                'key' => 'admin.users.admin_short',
                'tr' => 'Admin',
                'ru' => 'Админ'
            ],
            [
                'key' => 'admin.forms.js_will_fill',
                'tr' => 'Bu alan JavaScript ile doldurulacak',
                'ru' => 'Эта область будет заполнена JavaScript'
            ],
            
            // Confirmation Messages
            [
                'key' => 'admin.users.confirm_block_user',
                'tr' => 'Bu kullanıcıyı engellemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите заблокировать этого пользователя?'
            ],
            [
                'key' => 'admin.users.confirm_unblock_user',
                'tr' => 'Bu kullanıcının engellemesini kaldırmak istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите разблокировать этого пользователя?'
            ],
            [
                'key' => 'admin.users.confirm_activate_users',
                'tr' => 'kullanıcıyı aktifleştirmek istediğinizden emin misiniz?',
                'ru' => 'пользователей активировать уверены?'
            ],
            [
                'key' => 'admin.users.confirm_block_users',
                'tr' => 'kullanıcıyı engellemek istediğinizden emin misiniz?',
                'ru' => 'пользователей заблокировать уверены?'
            ],
            
            // Selection Messages
            [
                'key' => 'admin.users.please_select_user',
                'tr' => 'Lütfen en az bir kullanıcı seçin.',
                'ru' => 'Пожалуйста, выберите хотя бы одного пользователя.'
            ],
            [
                'key' => 'admin.users.please_select_lead_status',
                'tr' => 'Lütfen bir lead status seçin.',
                'ru' => 'Пожалуйста, выберите статус лида.'
            ],
            
            // Action Messages
            [
                'key' => 'admin.users.user_action_starting',
                'tr' => 'kullanıcı :action işlemi başlatılıyor...',
                'ru' => 'пользователь :action операция начинается...'
            ],
            [
                'key' => 'admin.users.action_failed',
                'tr' => 'işlemi başarısız oldu.',
                'ru' => 'операция не удалась.'
            ],
            [
                'key' => 'admin.users.action_error',
                'tr' => 'işlemi sırasında bir hata oluştu: :error',
                'ru' => 'ошибка во время операции: :error'
            ],
            
            // Excel Export Messages
            [
                'key' => 'admin.users.excel_preparing',
                'tr' => 'Excel dosyası hazırlanıyor... Lütfen bekleyin.',
                'ru' => 'Excel файл готовится... Пожалуйста, подождите.'
            ],
            [
                'key' => 'admin.users.excel_created_successfully',
                'tr' => 'Excel dosyası başarıyla oluşturuldu ve indirilmeye başlandı.',
                'ru' => 'Excel файл успешно создан и начал загружаться.'
            ],
            [
                'key' => 'admin.users.excel_preparing_for_selected',
                'tr' => 'seçili kullanıcı için Excel dosyası hazırlanıyor...',
                'ru' => 'выбранных пользователей Excel файл готовится...'
            ],
            [
                'key' => 'admin.users.excel_created_for_selected',
                'tr' => 'Seçili kullanıcılar için Excel dosyası başarıyla oluşturuldu.',
                'ru' => 'Excel файл для выбранных пользователей успешно создан.'
            ],
            
            // List Messages
            [
                'key' => 'admin.users.and_more_people',
                'tr' => 've :count kişi daha...',
                'ru' => 'и еще :count человек...'
            ],
            
            // Lead Status Messages
            [
                'key' => 'admin.users.changing_lead_status',
                'tr' => 'kullanıcının lead status\'u :status olarak değiştiriliyor...',
                'ru' => 'статус лида пользователя изменяется на :status...'
            ],
            [
                'key' => 'admin.users.lead_status_change_failed',
                'tr' => 'Lead status değişimi başarısız oldu.',
                'ru' => 'Изменение статуса лида не удалось.'
            ],
            [
                'key' => 'admin.users.lead_status_change_error',
                'tr' => 'Lead status değişimi sırasında bir hata oluştu: :error',
                'ru' => 'Ошибка при изменении статуса лида: :error'
            ],
            [
                'key' => 'admin.users.lead_status_updated_successfully',
                'tr' => 'Lead status başarıyla güncellendi.',
                'ru' => 'Статус лида успешно обновлен.'
            ],
            
            // Admin Assignment Messages
            [
                'key' => 'admin.users.admin_assignment_updated_successfully',
                'tr' => 'Admin ataması başarıyla güncellendi!',
                'ru' => 'Назначение администратора успешно обновлено!'
            ],
            
            // General Error Messages
            [
                'key' => 'admin.users.an_error_occurred',
                'tr' => 'Bir hata oluştu.',
                'ru' => 'Произошла ошибка.'
            ]
        ];

        foreach ($phrases as $phraseData) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);
            
            // Add Turkish translation (language_id: 1)
            PhraseTranslation::updateOrCreate([
                'phrase_id' => $phrase->id,
                'language_id' => 1
            ], [
                'translation' => $phraseData['tr']
            ]);
            
            // Add Russian translation (language_id: 2)
            PhraseTranslation::updateOrCreate([
                'phrase_id' => $phrase->id,
                'language_id' => 2
            ], [
                'translation' => $phraseData['ru']
            ]);
        }

        $this->command->info('Users management blade phrases seeded successfully! Total: ' . count($phrases));
    }
}