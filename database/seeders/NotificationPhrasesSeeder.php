<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class NotificationPhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Notification Messages
            'admin.notifications.notification_will_appear_in_dashboard' => ':name kullanıcısının dashboard\'ında görünecek bildirim',
            'admin.notifications.dashboard_notification_status' => 'Dashboard Bildirim Durumu',
            'admin.notifications.cannot_debit_deposits' => 'Mevduat hesaplarından para çekemezsiniz',
            'admin.notifications.email_will_be_sent_to' => 'E-posta :name kullanıcısına gönderilecek',
            'admin.notifications.remember_to_inform_user' => 'Kullanıcıyı yeni şifre hakkında bilgilendirmeyi unutmayın',
            
            // Form Labels
            'admin.forms.notification_message' => 'Bildirim Mesajı',
            'admin.forms.notification_message_placeholder' => 'Kullanıcıya gösterilecek mesajı girin...',
            'admin.forms.email_subject' => 'E-posta Konusu',
            'admin.forms.email_subject_placeholder' => 'E-posta konusunu girin...',
            'admin.forms.message_content' => 'Mesaj İçeriği',
            'admin.forms.message_placeholder' => 'Mesajınızı buraya yazın...',
            'admin.forms.withdrawal_code_status' => 'Para Çekme Kodu Durumu',
            'admin.forms.withdrawal_code' => 'Para Çekme Kodu',
            'admin.forms.tax_rate' => 'Vergi Oranı (%)',
            'admin.forms.trades_before_withdrawal' => 'Para Çekme Öncesi İşlem Sayısı',
            'admin.forms.min_trades_description' => 'Kullanıcının para çekebilmesi için yapması gereken minimum işlem sayısı',
            'admin.forms.enter_signal_amount' => ':currency cinsinden sinyal tutarını girin',
            
            // Actions
            'admin.actions.send_notification' => 'Bildirimi Gönder',
            'admin.actions.send_email' => 'E-posta Gönder',
            'admin.actions.set_user_tax' => 'Kullanıcı Vergisini Ayarla',
            'admin.actions.set_withdrawal_code' => 'Para Çekme Kodunu Ayarla',
            'admin.actions.set_trades_for_withdrawal' => 'Para Çekme İçin İşlem Sayısını Ayarla',
            'admin.actions.create_signal' => 'Sinyal Oluştur',
            
            // Modal Titles
            'admin.users.dashboard_notification_title' => ':username için Dashboard Bildirimi',
            'admin.users.user_tax_modal_title' => ':name için Kullanıcı Vergi Ayarları',
            'admin.users.withdrawal_code_modal_title' => ':name için Para Çekme Kodu',
            'admin.users.trades_modal_title' => ':name için İşlem Sayısı Ayarları',
            'admin.users.signal_modal_title' => ':name için Sinyal Oluştur',
        ];

        foreach ($phrases as $key => $value) {
            // Create phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Add Turkish translation (language_id: 1)
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => 1
                ],
                [
                    'translation' => $value,
                    'is_reviewed' => true
                ]
            );

            // Add Russian translation (language_id: 2)
            $russianTranslations = [
                // Notification Messages
                'admin.notifications.notification_will_appear_in_dashboard' => 'Уведомление появится в панели управления пользователя :name',
                'admin.notifications.dashboard_notification_status' => 'Статус уведомлений панели управления',
                'admin.notifications.cannot_debit_deposits' => 'Нельзя списывать с депозитных счетов',
                'admin.notifications.email_will_be_sent_to' => 'Email будет отправлен пользователю :name',
                'admin.notifications.remember_to_inform_user' => 'Не забудьте уведомить пользователя о новом пароле',
                
                // Form Labels
                'admin.forms.notification_message' => 'Сообщение уведомления',
                'admin.forms.notification_message_placeholder' => 'Введите сообщение для пользователя...',
                'admin.forms.email_subject' => 'Тема письма',
                'admin.forms.email_subject_placeholder' => 'Введите тему письма...',
                'admin.forms.message_content' => 'Содержание сообщения',
                'admin.forms.message_placeholder' => 'Напишите ваше сообщение здесь...',
                'admin.forms.withdrawal_code_status' => 'Статус кода вывода',
                'admin.forms.withdrawal_code' => 'Код вывода',
                'admin.forms.tax_rate' => 'Налоговая ставка (%)',
                'admin.forms.trades_before_withdrawal' => 'Сделок перед выводом',
                'admin.forms.min_trades_description' => 'Минимальное количество сделок для вывода средств',
                'admin.forms.enter_signal_amount' => 'Введите сумму сигнала в :currency',
                
                // Actions
                'admin.actions.send_notification' => 'Отправить уведомление',
                'admin.actions.send_email' => 'Отправить email',
                'admin.actions.set_user_tax' => 'Установить налог пользователя',
                'admin.actions.set_withdrawal_code' => 'Установить код вывода',
                'admin.actions.set_trades_for_withdrawal' => 'Установить сделки для вывода',
                'admin.actions.create_signal' => 'Создать сигнал',
                
                // Modal Titles
                'admin.users.dashboard_notification_title' => 'Уведомление панели для :username',
                'admin.users.user_tax_modal_title' => 'Налоговые настройки для :name',
                'admin.users.withdrawal_code_modal_title' => 'Код вывода для :name',
                'admin.users.trades_modal_title' => 'Настройки сделок для :name',
                'admin.users.signal_modal_title' => 'Создать сигнал для :name',
            ];

            if (isset($russianTranslations[$key])) {
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 2
                    ],
                    [
                        'translation' => $russianTranslations[$key],
                        'is_reviewed' => true
                    ]
                );
            }
        }

        echo "NotificationPhrasesSeeder: " . count($phrases) . " phrases added successfully!\n";
    }
}