<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class AdminMiscPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Calendar Management
            'admin.misc.calendar.page_title' => [
                'tr' => 'Takvim',
                'ru' => 'Календарь'
            ],
            'admin.misc.calendar.page_description' => [
                'tr' => 'Etkinlik ve görev takvimi',
                'ru' => 'Календарь событий и задач'
            ],
            'admin.misc.calendar.calendar_view' => [
                'tr' => 'Takvim Görünümü',
                'ru' => 'Вид календаря'
            ],
            'admin.misc.calendar.tip_title' => [
                'tr' => 'İpucu',
                'ru' => 'Совет'
            ],
            'admin.misc.calendar.tip_description' => [
                'tr' => 'Takvim üzerinde tıklayarak yeni etkinlik ekleyebilirsiniz',
                'ru' => 'Вы можете добавить новое событие, нажав на календарь'
            ],

            // Top Menu Navigation
            'admin.topmenu.admin_panel' => [
                'tr' => 'Yönetim',
                'ru' => 'Админ'
            ],
            'admin.topmenu.search_placeholder' => [
                'tr' => 'Ara...',
                'ru' => 'Поиск...'
            ],
            'admin.topmenu.search_placeholder_full' => [
                'tr' => 'Kullanıcılar, işlemler veya ayarları arayın...',
                'ru' => 'Поиск пользователей, транзакций или настроек...'
            ],
            'admin.topmenu.quick_actions' => [
                'tr' => 'Hızlı İşlemler',
                'ru' => 'Быстрые действия'
            ],
            'admin.topmenu.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            'admin.topmenu.view_all_notifications' => [
                'tr' => 'Tümünü Görüntüle',
                'ru' => 'Показать все'
            ],
            'admin.topmenu.no_notifications' => [
                'tr' => 'Yeni bildirim yok',
                'ru' => 'Нет новых уведомлений'
            ],
            'admin.topmenu.settings' => [
                'tr' => 'Ayarlar',
                'ru' => 'Настройки'
            ],

            // Quick Actions
            'admin.topmenu.actions.add_user' => [
                'tr' => 'Kullanıcı Ekle',
                'ru' => 'Добавить пользователя'
            ],
            'admin.topmenu.actions.new_deposit' => [
                'tr' => 'Yeni Depozit',
                'ru' => 'Новый депозит'
            ],
            'admin.topmenu.actions.process_withdrawal' => [
                'tr' => 'Para Çekme İşlemi',
                'ru' => 'Обработка вывода'
            ],
            'admin.topmenu.actions.send_message' => [
                'tr' => 'Mesaj Gönder',
                'ru' => 'Отправить сообщение'
            ],

            // About & Info Pages  
            'admin.misc.about.page_title' => [
                'tr' => 'Hakkında',
                'ru' => 'О программе'
            ],
            'admin.misc.about.system_info' => [
                'tr' => 'Sistem Bilgileri',
                'ru' => 'Информация о системе'
            ],
            'admin.misc.about.version' => [
                'tr' => 'Versiyon',
                'ru' => 'Версия'
            ],
            'admin.misc.about.last_updated' => [
                'tr' => 'Son Güncelleme',
                'ru' => 'Последнее обновление'
            ],

            // General Misc Terms
            'admin.misc.loading' => [
                'tr' => 'Yükleniyor...',
                'ru' => 'Загрузка...'
            ],
            'admin.misc.please_wait' => [
                'tr' => 'Lütfen bekleyin',
                'ru' => 'Пожалуйста, подождите'
            ],
            'admin.misc.refresh' => [
                'tr' => 'Yenile',
                'ru' => 'Обновить'
            ],
            'admin.misc.close' => [
                'tr' => 'Kapat',
                'ru' => 'Закрыть'
            ],
            'admin.misc.continue' => [
                'tr' => 'Devam',
                'ru' => 'Продолжить'
            ],
            'admin.misc.back' => [
                'tr' => 'Geri',
                'ru' => 'Назад'
            ],
            'admin.misc.next' => [
                'tr' => 'İleri',
                'ru' => 'Далее'
            ],
            'admin.misc.previous' => [
                'tr' => 'Önceki',
                'ru' => 'Предыдущий'
            ],
            'admin.misc.finish' => [
                'tr' => 'Bitir',
                'ru' => 'Завершить'
            ],
            'admin.misc.skip' => [
                'tr' => 'Atla',
                'ru' => 'Пропустить'
            ],

            // Status Messages
            'admin.misc.status.online' => [
                'tr' => 'Çevrimiçi',
                'ru' => 'В сети'
            ],
            'admin.misc.status.offline' => [
                'tr' => 'Çevrimdışı',
                'ru' => 'Не в сети'
            ],
            'admin.misc.status.busy' => [
                'tr' => 'Meşgul',
                'ru' => 'Занят'
            ],
            'admin.misc.status.away' => [
                'tr' => 'Uzakta',
                'ru' => 'Отошел'
            ],

            // Time & Date
            'admin.misc.time.today' => [
                'tr' => 'Bugün',
                'ru' => 'Сегодня'
            ],
            'admin.misc.time.yesterday' => [
                'tr' => 'Dün',
                'ru' => 'Вчера'
            ],
            'admin.misc.time.tomorrow' => [
                'tr' => 'Yarın',
                'ru' => 'Завтра'
            ],
            'admin.misc.time.this_week' => [
                'tr' => 'Bu Hafta',
                'ru' => 'На этой неделе'
            ],
            'admin.misc.time.last_week' => [
                'tr' => 'Geçen Hafta',
                'ru' => 'На прошлой неделе'
            ],
            'admin.misc.time.this_month' => [
                'tr' => 'Bu Ay',
                'ru' => 'В этом месяце'
            ],
            'admin.misc.time.last_month' => [
                'tr' => 'Geçen Ay',
                'ru' => 'В прошлом месяце'
            ],

            // File & Data Operations
            'admin.misc.file.upload' => [
                'tr' => 'Dosya Yükle',
                'ru' => 'Загрузить файл'
            ],
            'admin.misc.file.download' => [
                'tr' => 'İndir',
                'ru' => 'Скачать'
            ],
            'admin.misc.file.delete' => [
                'tr' => 'Dosya Sil',
                'ru' => 'Удалить файл'
            ],
            'admin.misc.data.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            'admin.misc.data.import' => [
                'tr' => 'İçe Aktar',
                'ru' => 'Импорт'
            ],
            'admin.misc.data.backup' => [
                'tr' => 'Yedekle',
                'ru' => 'Резервная копия'
            ],
            'admin.misc.data.restore' => [
                'tr' => 'Geri Yükle',
                'ru' => 'Восстановить'
            ],

            // System Messages
            'admin.misc.system.maintenance' => [
                'tr' => 'Sistem Bakımda',
                'ru' => 'Техническое обслуживание'
            ],
            'admin.misc.system.update_available' => [
                'tr' => 'Güncelleme Mevcut',
                'ru' => 'Доступно обновление'
            ],
            'admin.misc.system.connection_lost' => [
                'tr' => 'Bağlantı Kesildi',
                'ru' => 'Соединение потеряно'
            ],
            'admin.misc.system.reconnecting' => [
                'tr' => 'Yeniden Bağlanıyor',
                'ru' => 'Переподключение'
            ],
            'admin.misc.system.connected' => [
                'tr' => 'Bağlandı',
                'ru' => 'Подключено'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or update phrase
            $phrase = Phrase::updateOrCreate(
                ['key' => $key],
                ['key' => $key]
            );

            // Create or update translations
            foreach ($translations as $langCode => $translation) {
                $languageId = $langCode === 'tr' ? 1 : 2; // Turkish=1, Russian=2
                
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ],
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId,
                        'translation' => $translation
                    ]
                );
            }
        }

        $this->command->info('Admin misc phrases seeded successfully! Total phrases: ' . count($phrases));
    }
}