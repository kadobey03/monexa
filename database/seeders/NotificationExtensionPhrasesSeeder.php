<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class NotificationExtensionPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds for notification extension phrases.
     */
    public function run(): void
    {
        $phrases = [
            // Common notification phrases
            'admin.common.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            
            // Notification specific phrases
            'admin.notifications.no_notifications' => [
                'tr' => 'Bildirim yok',
                'ru' => 'Нет уведомлений'
            ],
            'admin.notifications.mark_all_read' => [
                'tr' => 'Tümünü Okundu Olarak İşaretle',
                'ru' => 'Отметить все как прочитанные'
            ],
            'admin.notifications.view_all' => [
                'tr' => 'Tümünü Görüntüle',
                'ru' => 'Просмотреть все'
            ],
            'admin.notifications.new_notification' => [
                'tr' => 'Yeni Bildirim',
                'ru' => 'Новое уведомление'
            ],
            'admin.notifications.unread_count' => [
                'tr' => 'Okunmamış',
                'ru' => 'Непрочитанные'
            ],
            'admin.notifications.read' => [
                'tr' => 'Okundu',
                'ru' => 'Прочитано'
            ],
            'admin.notifications.unread' => [
                'tr' => 'Okunmadı',
                'ru' => 'Не прочитано'
            ],
            'admin.notifications.clear_all' => [
                'tr' => 'Tümünü Temizle',
                'ru' => 'Очистить все'
            ],
            'admin.notifications.delete_all' => [
                'tr' => 'Tümünü Sil',
                'ru' => 'Удалить все'
            ],
            'admin.notifications.settings' => [
                'tr' => 'Bildirim Ayarları',
                'ru' => 'Настройки уведомлений'
            ],
            'admin.notifications.enable' => [
                'tr' => 'Bildirimleri Etkinleştir',
                'ru' => 'Включить уведомления'
            ],
            'admin.notifications.disable' => [
                'tr' => 'Bildirimleri Devre Dışı Bırak',
                'ru' => 'Отключить уведомления'
            ],
            'admin.notifications.filter' => [
                'tr' => 'Bildirim Filtresi',
                'ru' => 'Фильтр уведомлений'
            ],
            'admin.notifications.priority.high' => [
                'tr' => 'Yüksek Öncelik',
                'ru' => 'Высокий приоритет'
            ],
            'admin.notifications.priority.medium' => [
                'tr' => 'Orta Öncelik',
                'ru' => 'Средний приоритет'
            ],
            'admin.notifications.priority.low' => [
                'tr' => 'Düşük Öncelik',
                'ru' => 'Низкий приоритет'
            ],
            'admin.notifications.type.system' => [
                'tr' => 'Sistem Bildirimi',
                'ru' => 'Системное уведомление'
            ],
            'admin.notifications.type.user' => [
                'tr' => 'Kullanıcı Bildirimi',
                'ru' => 'Пользовательское уведомление'
            ],
            'admin.notifications.type.admin' => [
                'tr' => 'Admin Bildirimi',
                'ru' => 'Административное уведомление'
            ],
            'admin.notifications.empty_state' => [
                'tr' => 'Henüz hiç bildirim yok',
                'ru' => 'Пока нет никаких уведомлений'
            ],
            'admin.notifications.loading' => [
                'tr' => 'Bildirimler yükleniyor...',
                'ru' => 'Загрузка уведомлений...'
            ],
            'admin.notifications.error' => [
                'tr' => 'Bildirimler yüklenirken hata oluştu',
                'ru' => 'Ошибка при загрузке уведомлений'
            ],
            'admin.notifications.retry' => [
                'tr' => 'Tekrar Dene',
                'ru' => 'Повторить попытку'
            ],
            'admin.notifications.show_more' => [
                'tr' => 'Daha Fazla Göster',
                'ru' => 'Показать больше'
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

        echo "✅ Notification extension phrases seeded successfully! Added " . count($phrases) . " phrases.\n";
    }
}