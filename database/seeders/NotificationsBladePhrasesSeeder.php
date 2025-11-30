<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class NotificationsBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Core Notifications Management
            'admin.notifications.admin_notifications' => [
                'tr' => 'Admin Bildirimleri',
                'ru' => 'Админ Уведомления'
            ],
            'admin.notifications.monexa_admin' => [
                'tr' => 'Monexa Admin',
                'ru' => 'Monexa Админ'
            ],
            'admin.notifications.notification_management' => [
                'tr' => 'Bildirim Yönetimi',
                'ru' => 'Управление Уведомлениями'
            ],
            'admin.notifications.notifications' => [
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            'admin.notifications.view_and_manage_notifications' => [
                'tr' => 'Sistem bildirimlerini görüntüleyin ve yönetin',
                'ru' => 'Просмотр и управление системными уведомлениями'
            ],

            // Navigation & Interface
            'admin.notifications.dashboard' => [
                'tr' => 'Dashboard',
                'ru' => 'Панель управления'
            ],
            'admin.notifications.users' => [
                'tr' => 'Kullanıcılar',
                'ru' => 'Пользователи'
            ],
            'admin.notifications.leads' => [
                'tr' => 'Leads',
                'ru' => 'Лиды'
            ],
            'admin.notifications.back_to_notifications' => [
                'tr' => 'Bildirimlere Dön',
                'ru' => 'Вернуться к уведомлениям'
            ],

            // Search & Filtering
            'admin.notifications.search_notifications' => [
                'tr' => 'Bildirimler ara...',
                'ru' => 'Поиск уведомлений...'
            ],
            'admin.notifications.filter_notifications' => [
                'tr' => 'Bildirimleri Filtrele',
                'ru' => 'Фильтрация уведомлений'
            ],
            'admin.notifications.all_types' => [
                'tr' => 'Tüm Tipler',
                'ru' => 'Все типы'
            ],
            'admin.notifications.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все статусы'
            ],

            // Status & Types
            'admin.notifications.info' => [
                'tr' => 'Bilgi',
                'ru' => 'Информация'
            ],
            'admin.notifications.success' => [
                'tr' => 'Başarılı',
                'ru' => 'Успех'
            ],
            'admin.notifications.warning' => [
                'tr' => 'Uyarı',
                'ru' => 'Предупреждение'
            ],
            'admin.notifications.important' => [
                'tr' => 'Önemli',
                'ru' => 'Важно'
            ],
            'admin.notifications.read' => [
                'tr' => 'Okunmuş',
                'ru' => 'Прочитано'
            ],
            'admin.notifications.unread' => [
                'tr' => 'Okunmamış',
                'ru' => 'Непрочитано'
            ],
            'admin.notifications.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный'
            ],
            'admin.notifications.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивный'
            ],

            // Statistics
            'admin.notifications.total_notifications' => [
                'tr' => 'Toplam Bildirim',
                'ru' => 'Всего уведомлений'
            ],
            'admin.notifications.today' => [
                'tr' => 'Bugün',
                'ru' => 'Сегодня'
            ],

            // Actions
            'admin.notifications.mark_all_as_read' => [
                'tr' => 'Tümünü Okundu İşaretle',
                'ru' => 'Отметить все как прочитанные'
            ],
            'admin.notifications.mark_read' => [
                'tr' => 'Okundu',
                'ru' => 'Прочитано'
            ],
            'admin.notifications.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.notifications.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.notifications.preview' => [
                'tr' => 'Önizle',
                'ru' => 'Предварительный просмотр'
            ],
            'admin.notifications.action' => [
                'tr' => 'İşlem',
                'ru' => 'Действие'
            ],

            // Send Message Page
            'admin.notifications.send_message_to_user' => [
                'tr' => 'Kullanıcıya Mesaj Gönder',
                'ru' => 'Отправить сообщение пользователю'
            ],
            'admin.notifications.send_custom_notification_message' => [
                'tr' => 'Seçtiğiniz kullanıcıya özel bildirim mesajı gönderin',
                'ru' => 'Отправьте пользовательское уведомление выбранному пользователю'
            ],
            'admin.notifications.create_message' => [
                'tr' => 'Mesaj Oluştur',
                'ru' => 'Создать сообщение'
            ],
            'admin.notifications.prepare_notification_for_user' => [
                'tr' => 'Kullanıcıya gönderilecek bildirimi hazırlayın',
                'ru' => 'Подготовьте уведомление для отправки пользователю'
            ],
            'admin.notifications.recipient_user' => [
                'tr' => 'Alıcı Kullanıcı',
                'ru' => 'Пользователь-получатель'
            ],
            'admin.notifications.select_user' => [
                'tr' => 'Kullanıcı seçiniz...',
                'ru' => 'Выберите пользователя...'
            ],
            'admin.notifications.select_user_to_send_message' => [
                'tr' => 'Mesaj gönderilecek kullanıcıyı seçin',
                'ru' => 'Выберите пользователя для отправки сообщения'
            ],
            'admin.notifications.message_type' => [
                'tr' => 'Mesaj Türü',
                'ru' => 'Тип сообщения'
            ],
            'admin.notifications.message_title' => [
                'tr' => 'Mesaj Başlığı',
                'ru' => 'Заголовок сообщения'
            ],
            'admin.notifications.enter_message_title' => [
                'tr' => 'Mesaj başlığını giriniz...',
                'ru' => 'Введите заголовок сообщения...'
            ],
            'admin.notifications.write_short_clear_title' => [
                'tr' => 'Kısa ve açık bir başlık yazın',
                'ru' => 'Напишите краткий и понятный заголовок'
            ],
            'admin.notifications.message_content' => [
                'tr' => 'Mesaj İçeriği',
                'ru' => 'Содержание сообщения'
            ],
            'admin.notifications.enter_message_to_send' => [
                'tr' => 'Kullanıcıya gönderilecek mesajı yazınız...',
                'ru' => 'Напишите сообщение для отправки пользователю...'
            ],
            'admin.notifications.write_detailed_clear_message' => [
                'tr' => 'Detaylı ve anlaşılır bir mesaj yazın',
                'ru' => 'Напишите подробное и понятное сообщение'
            ],
            'admin.notifications.message_preview' => [
                'tr' => 'Mesaj Önizleme',
                'ru' => 'Предварительный просмотр сообщения'
            ],
            'admin.notifications.send_message' => [
                'tr' => 'Mesaj Gönder',
                'ru' => 'Отправить сообщение'
            ],
            'admin.notifications.message_content_here' => [
                'tr' => 'Mesaj içeriği buraya gelecek...',
                'ru' => 'Содержание сообщения будет здесь...'
            ],
            'admin.notifications.recipient' => [
                'tr' => 'Alıcı',
                'ru' => 'Получатель'
            ],
            'admin.notifications.no_recipient_selected' => [
                'tr' => 'Alıcı seçilmedi',
                'ru' => 'Получатель не выбран'
            ],
            'admin.notifications.sending' => [
                'tr' => 'Gönderiliyor...',
                'ru' => 'Отправка...'
            ],

            // Message Templates
            'admin.notifications.quick_message_templates' => [
                'tr' => 'Hızlı Mesaj Şablonları',
                'ru' => 'Быстрые шаблоны сообщений'
            ],
            'admin.notifications.select_frequently_used_templates' => [
                'tr' => 'Sık kullanılan mesaj şablonlarını seçin',
                'ru' => 'Выберите часто используемые шаблоны сообщений'
            ],
            'admin.notifications.welcome_message' => [
                'tr' => 'Hoş Geldin Mesajı',
                'ru' => 'Приветственное сообщение'
            ],
            'admin.notifications.welcome_message_description' => [
                'tr' => 'Yeni kullanıcılar için karşılama mesajı',
                'ru' => 'Приветственное сообщение для новых пользователей'
            ],
            'admin.notifications.security_warning' => [
                'tr' => 'Güvenlik Uyarısı',
                'ru' => 'Предупреждение безопасности'
            ],
            'admin.notifications.security_warning_description' => [
                'tr' => 'Güvenlik ile ilgili önemli bildirim',
                'ru' => 'Важное уведомление о безопасности'
            ],
            'admin.notifications.maintenance_notification' => [
                'tr' => 'Bakım Bildirimi',
                'ru' => 'Уведомление о техобслуживании'
            ],
            'admin.notifications.maintenance_notification_description' => [
                'tr' => 'Sistem bakımı hakkında bilgilendirme',
                'ru' => 'Информация о техническом обслуживании системы'
            ],
            'admin.notifications.promotion_notification' => [
                'tr' => 'Promosyon Bildirimi',
                'ru' => 'Рекламное уведомление'
            ],
            'admin.notifications.promotion_notification_description' => [
                'tr' => 'Özel kampanya ve fırsatlar',
                'ru' => 'Специальные кампании и предложения'
            ],

            // Template Content
            'admin.notifications.welcome_template_title' => [
                'tr' => 'Hoş Geldiniz!',
                'ru' => 'Добро пожаловать!'
            ],
            'admin.notifications.welcome_template_message' => [
                'tr' => 'Platformumuza hoş geldiniz! Hesabınız başarıyla oluşturulmuştur. Herhangi bir sorunuz olursa destek ekibimizle iletişime geçebilirsiniz.',
                'ru' => 'Добро пожаловать на нашу платформу! Ваш аккаунт успешно создан. Если у вас есть вопросы, обратитесь к нашей службе поддержки.'
            ],
            'admin.notifications.security_template_title' => [
                'tr' => 'Güvenlik Uyarısı',
                'ru' => 'Предупреждение безопасности'
            ],
            'admin.notifications.security_template_message' => [
                'tr' => 'Hesabınızın güvenliği için lütfen şifrenizi düzenli olarak değiştirin ve iki faktörlü kimlik doğrulamayı aktif hale getirin.',
                'ru' => 'Для безопасности вашего аккаунта регулярно меняйте пароль и активируйте двухфакторную аутентификацию.'
            ],
            'admin.notifications.maintenance_template_title' => [
                'tr' => 'Sistem Bakımı',
                'ru' => 'Техническое обслуживание'
            ],
            'admin.notifications.maintenance_template_message' => [
                'tr' => 'Sistemimizde planlı bakım çalışması yapılacaktır. Bakım süresince hizmetlerimizde kısa süreli kesintiler yaşanabilir.',
                'ru' => 'В нашей системе будет проводиться плановое техническое обслуживание. Во время обслуживания возможны кратковременные перерывы в работе сервисов.'
            ],
            'admin.notifications.promotion_template_title' => [
                'tr' => 'Özel Kampanya!',
                'ru' => 'Специальная кампания!'
            ],
            'admin.notifications.promotion_template_message' => [
                'tr' => 'Size özel hazırladığımız kampanyalardan yararlanmak için hesabınıza giriş yapın ve fırsatları kaçırmayın!',
                'ru' => 'Войдите в свой аккаунт, чтобы воспользоваться специально подготовленными для вас кампаниями и не упустить возможности!'
            ],

            // Detail View
            'admin.notifications.notification_details' => [
                'tr' => 'Bildirim Detayları',
                'ru' => 'Детали уведомления'
            ],
            'admin.notifications.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.notifications.message' => [
                'tr' => 'Mesaj',
                'ru' => 'Сообщение'
            ],
            'admin.notifications.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'admin.notifications.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.notifications.related_information' => [
                'tr' => 'İlgili Bilgiler',
                'ru' => 'Связанная информация'
            ],
            'admin.notifications.amount' => [
                'tr' => 'Miktar',
                'ru' => 'Сумма'
            ],
            'admin.notifications.payment_mode' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ оплаты'
            ],
            'admin.notifications.asset' => [
                'tr' => 'Varlık',
                'ru' => 'Актив'
            ],
            'admin.notifications.current_balance' => [
                'tr' => 'Mevcut Bakiye',
                'ru' => 'Текущий баланс'
            ],

            // View Actions
            'admin.notifications.view_deposit' => [
                'tr' => 'Para Yatırma İşlemini Görüntüle',
                'ru' => 'Просмотр депозита'
            ],
            'admin.notifications.view_withdrawal' => [
                'tr' => 'Para Çekme İşlemini Görüntüle',
                'ru' => 'Просмотр вывода средств'
            ],
            'admin.notifications.view_plan' => [
                'tr' => 'Planı Görüntüle',
                'ru' => 'Просмотр плана'
            ],
            'admin.notifications.view_bot_investment' => [
                'tr' => 'Bot Yatırımını Görüntüle',
                'ru' => 'Просмотр инвестиций бота'
            ],

            // Empty States & Messages
            'admin.notifications.no_notifications_found' => [
                'tr' => 'Bildirim bulunamadı',
                'ru' => 'Уведомления не найдены'
            ],
            'admin.notifications.no_notifications_received_yet' => [
                'tr' => 'Henüz hiç bildirim almadınız.',
                'ru' => 'Вы еще не получили уведомлений.'
            ],
            'admin.notifications.send_new_message' => [
                'tr' => 'Yeni Mesaj Gönder',
                'ru' => 'Отправить новое сообщение'
            ],
            'admin.notifications.no_detailed_information' => [
                'tr' => 'Detaylı bilgi mevcut değil.',
                'ru' => 'Подробная информация недоступна.'
            ],
            'admin.notifications.no_related_information' => [
                'tr' => 'İlgili bilgi mevcut değil.',
                'ru' => 'Связанная информация недоступна.'
            ],

            // System Messages & Processing
            'admin.notifications.processing' => [
                'tr' => 'İşleniyor...',
                'ru' => 'Обработка...'
            ],
            'admin.notifications.delete_notification' => [
                'tr' => 'Bildirimi Sil',
                'ru' => 'Удалить уведомление'
            ],
            'admin.notifications.delete_confirmation' => [
                'tr' => 'Bu bildirimi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.',
                'ru' => 'Вы уверены, что хотите удалить это уведомление? Это действие нельзя отменить.'
            ],
            'admin.notifications.confirm_delete_notification' => [
                'tr' => 'Bu bildirimi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить это уведомление?'
            ],
            'admin.notifications.confirm_mark_all_as_read' => [
                'tr' => 'Tüm bildirimleri okundu olarak işaretlemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите отметить все уведомления как прочитанные?'
            ],

            // Error Messages
            'admin.notifications.error_marking_as_read' => [
                'tr' => 'Bildirim okundu olarak işaretlenirken hata oluştu',
                'ru' => 'Ошибка при отметке уведомления как прочитанного'
            ],
            'admin.notifications.error_marking_notifications' => [
                'tr' => 'Bildirimler işaretlenirken hata oluştu',
                'ru' => 'Ошибка при отметке уведомлений'
            ],
            'admin.notifications.error_deleting_notification' => [
                'tr' => 'Bildirim silinirken hata oluştu',
                'ru' => 'Ошибка при удалении уведомления'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);
            
            // Add Turkish translation (language_id = 1)
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => 1],
                ['translation' => $translations['tr']]
            );
            
            // Add Russian translation (language_id = 2)  
            PhraseTranslation::updateOrCreate(
                ['phrase_id' => $phrase->id, 'language_id' => 2],
                ['translation' => $translations['ru']]
            );
        }

        $this->command->info('✅ Notifications blade phrases have been seeded successfully.');
        $this->command->info('📊 Total phrases added: ' . count($phrases));
    }
}