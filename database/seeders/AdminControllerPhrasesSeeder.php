<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class AdminControllerPhrasesSeeder extends Seeder
{
    public function run()
    {
        // Get language IDs
        $turkishLang = Language::where('code', 'tr')->first();
        $russianLang = Language::where('code', 'ru')->first();

        if (!$turkishLang || !$russianLang) {
            $this->command->error('Turkish or Russian language not found. Please run LanguagesTableSeeder first.');
            return;
        }

        // Admin Controller Phrases
        $phrases = [
            // Admin Messages - General
            [
                'key' => 'admin.messages.action_successful',
                'tr' => 'İşlem başarılı!',
                'ru' => 'Операция успешна!'
            ],
            [
                'key' => 'admin.messages.changed',
                'tr' => 'Değiştirildi',
                'ru' => 'Изменено'
            ],
            [
                'key' => 'admin.messages.message_sent',
                'tr' => 'Mesajınız başarıyla gönderildi!',
                'ru' => 'Ваше сообщение успешно отправлено!'
            ],
            [
                'key' => 'admin.messages.access_denied',
                'tr' => 'Bu sayfaya erişim yetkiniz bulunmamaktadır.',
                'ru' => 'У вас нет доступа к этой странице.'
            ],

            // Admin Manager Management
            [
                'key' => 'admin.messages.manager_blocked',
                'tr' => 'Yönetici engellendi',
                'ru' => 'Менеджер заблокирован'
            ],
            [
                'key' => 'admin.messages.manager_unblocked',
                'tr' => 'Yöneticinin engeli kaldırıldı',
                'ru' => 'Менеджер разблокирован'
            ],
            [
                'key' => 'admin.messages.manager_deleted',
                'tr' => 'Yönetici silindi!',
                'ru' => 'Менеджер был удален!'
            ],
            [
                'key' => 'admin.messages.account_updated',
                'tr' => 'Hesap başarıyla güncellendi!',
                'ru' => 'Аккаунт успешно обновлен!'
            ],
            [
                'key' => 'admin.messages.manager_added',
                'tr' => 'Yönetici başarıyla eklendi!',
                'ru' => 'Менеджер успешно добавлен!'
            ],
            [
                'key' => 'admin.messages.incorrect_old_password',
                'tr' => 'Eski şifre hatalı',
                'ru' => 'Неверный старый пароль'
            ],
            [
                'key' => 'admin.messages.password_changed',
                'tr' => 'Şifre başarıyla değiştirildi',
                'ru' => 'Пароль успешно изменен'
            ],

            // Lead Status Management
            [
                'key' => 'admin.messages.lead_status_created',
                'tr' => 'Yeni lead status başarıyla oluşturuldu.',
                'ru' => 'Новый статус лида успешно создан.'
            ],
            [
                'key' => 'admin.messages.lead_status_updated',
                'tr' => 'Lead status başarıyla güncellendi.',
                'ru' => 'Статус лида успешно обновлен.'
            ],
            [
                'key' => 'admin.messages.lead_status_deleted',
                'tr' => 'Lead status başarıyla silindi.',
                'ru' => 'Статус лида успешно удален.'
            ],
            [
                'key' => 'admin.messages.status_in_use_cannot_delete',
                'tr' => 'Bu status kullanan kullanıcılar bulunduğu için silinemez.',
                'ru' => 'Нельзя удалить, поскольку есть пользователи с этим статусом.'
            ],
            [
                'key' => 'admin.messages.default_status_cannot_delete',
                'tr' => 'Sistem varsayılan statusleri silinemez.',
                'ru' => 'Системные статусы по умолчанию нельзя удалить.'
            ],
            [
                'key' => 'admin.messages.critical_status_cannot_deactivate',
                'tr' => 'Sistem kritik statusleri deaktif edilemez.',
                'ru' => 'Критические статусы системы нельзя деактивировать.'
            ],
            [
                'key' => 'admin.messages.status_toggled',
                'tr' => 'Lead status başarıyla :status hale getirildi.',
                'ru' => 'Статус лида успешно переведен в состояние :status.'
            ],
            [
                'key' => 'admin.messages.order_updated',
                'tr' => 'Sıralama güncellendi.',
                'ru' => 'Порядок обновлен.'
            ],

            // Withdrawal Management
            [
                'key' => 'admin.messages.withdrawal_updated',
                'tr' => 'Para çekme detayları başarıyla güncellendi!',
                'ru' => 'Детали вывода средств успешно обновлены!'
            ],

            // Trade Management
            [
                'key' => 'admin.messages.control_error',
                'tr' => 'Kontrol sırasında hata oluştu',
                'ru' => 'Ошибка при проверке'
            ],
            [
                'key' => 'admin.messages.fix_error',
                'tr' => 'Düzeltme sırasında hata oluştu',
                'ru' => 'Ошибка при исправлении'
            ],
            [
                'key' => 'admin.messages.trade_not_found',
                'tr' => 'İşlem bulunamadı',
                'ru' => 'Сделка не найдена'
            ],
            [
                'key' => 'admin.messages.trade_updated',
                'tr' => 'İşlem başarıyla güncellendi!',
                'ru' => 'Сделка успешно обновлена!'
            ],
            [
                'key' => 'admin.messages.trade_update_failed',
                'tr' => 'İşlem güncellenemedi. Lütfen tekrar deneyin.',
                'ru' => 'Не удалось обновить сделку. Попробуйте еще раз.'
            ],
            [
                'key' => 'admin.messages.user_not_found_for_trade',
                'tr' => 'Bu işlem için kullanıcı bulunamadı',
                'ru' => 'Пользователь для этой сделки не найден'
            ],
            [
                'key' => 'admin.messages.profit_added_successfully',
                'tr' => 'Kar başarıyla eklendi! Kullanıcı ROI güncellendi.',
                'ru' => 'Прибыль успешно добавлена! ROI пользователя обновлен.'
            ],
            [
                'key' => 'admin.messages.profit_add_failed',
                'tr' => 'Kar eklenemedi. Lütfen tekrar deneyin.',
                'ru' => 'Не удалось добавить прибыль. Попробуйте еще раз.'
            ],
            [
                'key' => 'admin.messages.trade_deleted',
                'tr' => 'İşlem başarıyla silindi!',
                'ru' => 'Сделка успешно удалена!'
            ],
            [
                'key' => 'admin.messages.trade_delete_failed',
                'tr' => 'İşlem silinemedi. Lütfen tekrar deneyin.',
                'ru' => 'Не удалось удалить сделку. Попробуйте еще раз.'
            ],
            [
                'key' => 'admin.messages.export_failed',
                'tr' => 'Dışa aktarma başarısız. Lütfen tekrar deneyin.',
                'ru' => 'Экспорт не удался. Попробуйте еще раз.'
            ],
            [
                'key' => 'admin.messages.stats_fetch_failed',
                'tr' => 'İstatistikler alınamadı',
                'ru' => 'Не удалось получить статистику'
            ],
            [
                'key' => 'admin.messages.bulk_action_completed',
                'tr' => 'Toplu işlem başarıyla tamamlandı!',
                'ru' => 'Групповое действие успешно завершено!'
            ],
            [
                'key' => 'admin.messages.bulk_action_failed',
                'tr' => 'Toplu işlem başarısız. Lütfen tekrar deneyin.',
                'ru' => 'Групповое действие не удалось. Попробуйте еще раз.'
            ],

            // Admin Titles
            [
                'key' => 'admin.titles.change_password',
                'tr' => 'Şifre Değiştir',
                'ru' => 'Изменить пароль'
            ],
            [
                'key' => 'admin.titles.lead_status_management',
                'tr' => 'Lead Status Yönetimi',
                'ru' => 'Управление статусами лидов'
            ],
            [
                'key' => 'admin.titles.process_withdrawal_request',
                'tr' => 'Para Çekme İsteğini İşle',
                'ru' => 'Обработать запрос на вывод средств'
            ],
            [
                'key' => 'admin.titles.user_trades_management',
                'tr' => 'Kullanıcı İşlemleri Yönetimi',
                'ru' => 'Управление пользовательскими сделками'
            ],
            [
                'key' => 'admin.titles.edit_trade',
                'tr' => 'İşlemi Düzenle',
                'ru' => 'Редактировать сделку'
            ],

            // Admin Validation Messages
            [
                'key' => 'admin.validation.status_name_format',
                'tr' => 'Status adı sadece küçük harf ve alt çizgi içerebilir.',
                'ru' => 'Имя статуса может содержать только строчные буквы и подчеркивания.'
            ],
            [
                'key' => 'admin.validation.color_hex_format',
                'tr' => 'Renk geçerli bir hex kodu olmalıdır (örn: #ff0000).',
                'ru' => 'Цвет должен быть правильным hex-кодом (например: #ff0000).'
            ],

            // Admin Status
            [
                'key' => 'admin.status.active',
                'tr' => 'aktif',
                'ru' => 'активный'
            ],
            [
                'key' => 'admin.status.inactive',
                'tr' => 'pasif',
                'ru' => 'неактивный'
            ],
        ];

        foreach ($phrases as $phraseData) {
            // Create or update phrase
            $phrase = Phrase::updateOrCreate(
                ['key' => $phraseData['key']],
                ['key' => $phraseData['key']]
            );

            // Create or update Turkish translation
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $turkishLang->id
                ],
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $turkishLang->id,
                    'translation' => $phraseData['tr']
                ]
            );

            // Create or update Russian translation
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $russianLang->id
                ],
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $russianLang->id,
                    'translation' => $phraseData['ru']
                ]
            );
        }

        $this->command->info('Admin Controller phrases seeded successfully! Total phrases: ' . count($phrases));
    }
}