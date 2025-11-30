<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class WithdrawalsBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Main withdrawals page (mwithdrawals.blade.php)
            'admin.withdrawals.customer_withdrawals' => [
                'tr' => 'Müşteri Çekimleri',
                'ru' => 'Выводы клиентов'
            ],
            'admin.withdrawals.manage_customer_withdrawals' => [
                'tr' => 'Müşteri Çekimlerini Yönet',
                'ru' => 'Управление выводами клиентов'
            ],
            'admin.withdrawals.manage_withdrawal_requests_description' => [
                'tr' => 'Tüm müşteri çekim taleplerini buradan yönetebilirsiniz',
                'ru' => 'Вы можете управлять всеми запросами на вывод средств клиентов отсюда'
            ],
            'admin.withdrawals.total_requests' => [
                'tr' => 'Toplam Talep',
                'ru' => 'Всего запросов'
            ],
            'admin.withdrawals.refresh' => [
                'tr' => 'Yenile',
                'ru' => 'Обновить'
            ],
            'admin.withdrawals.pending' => [
                'tr' => 'Bekleyen',
                'ru' => 'В ожидании'
            ],
            'admin.withdrawals.waiting_approval' => [
                'tr' => 'Onay bekliyor',
                'ru' => 'Ожидает одобрения'
            ],
            'admin.withdrawals.processed' => [
                'tr' => 'İşлenen',
                'ru' => 'Обработано'
            ],
            'admin.withdrawals.completed' => [
                'tr' => 'Tamamlananlar',
                'ru' => 'Завершенные'
            ],
            'admin.withdrawals.total_amount' => [
                'tr' => 'Toplam Tutar',
                'ru' => 'Общая сумма'
            ],
            'admin.withdrawals.all_withdrawals' => [
                'tr' => 'Tüm çekimler',
                'ru' => 'Все выводы'
            ],
            'admin.withdrawals.this_month' => [
                'tr' => 'Bu Ay',
                'ru' => 'Этот месяц'
            ],
            'admin.withdrawals.last_30_days' => [
                'tr' => 'Son 30 gün',
                'ru' => 'Последние 30 дней'
            ],
            'admin.withdrawals.withdrawal_requests' => [
                'tr' => 'Çekim Talepleri',
                'ru' => 'Запросы на вывод'
            ],
            'admin.withdrawals.search_withdrawal_placeholder' => [
                'tr' => 'Çekim ara...',
                'ru' => 'Поиск вывода...'
            ],
            'admin.withdrawals.customer_name' => [
                'tr' => 'Müşteri Adı',
                'ru' => 'Имя клиента'
            ],
            'admin.withdrawals.requested_amount' => [
                'tr' => 'Talep Edilen Tutar',
                'ru' => 'Запрашиваемая сумма'
            ],
            'admin.withdrawals.amount_plus_fees' => [
                'tr' => 'Tutar + Masraflar',
                'ru' => 'Сумма + Комиссии'
            ],
            'admin.withdrawals.payment_method' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ оплаты'
            ],
            'admin.withdrawals.email' => [
                'tr' => 'E-posta',
                'ru' => 'Электронная почта'
            ],
            'admin.withdrawals.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.withdrawals.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'admin.withdrawals.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.withdrawals.user_deleted' => [
                'tr' => 'Kullanıcı Silindi',
                'ru' => 'Пользователь удален'
            ],
            'admin.withdrawals.account_not_available' => [
                'tr' => 'Hesap mevcut değil',
                'ru' => 'Аккаунт недоступен'
            ],
            'admin.withdrawals.waiting' => [
                'tr' => 'Bekliyor',
                'ru' => 'Ожидает'
            ],
            'admin.withdrawals.view' => [
                'tr' => 'Görüntüle',
                'ru' => 'Просмотр'
            ],
            'admin.withdrawals.no_withdrawal_requests' => [
                'tr' => 'Henüz Çekim Talebi Yok',
                'ru' => 'Запросов на вывод пока нет'
            ],
            'admin.withdrawals.requests_will_be_listed_here' => [
                'tr' => 'Müşterilerden gelen çekim talepleri burada listelenecek.',
                'ru' => 'Запросы на вывод от клиентов будут перечислены здесь.'
            ],
            'admin.withdrawals.refresh_page' => [
                'tr' => 'Sayfayı Yenile',
                'ru' => 'Обновить страницу'
            ],
            'admin.withdrawals.table_refreshed' => [
                'tr' => 'Tablo yenilendi',
                'ru' => 'Таблица обновлена'
            ],

            // Process withdrawal page (pwithrdawal.blade.php)
            'admin.withdrawals.process_withdrawal_request' => [
                'tr' => 'Çekim Talebini İşle',
                'ru' => 'Обработать запрос на вывод'
            ],
            'admin.withdrawals.view_and_process_request_description' => [
                'tr' => 'Müşteri çekim talebini görüntüleyin ve işleme alın',
                'ru' => 'Просмотр и обработка запроса на вывод средств клиента'
            ],
            'admin.withdrawals.back' => [
                'tr' => 'Geri Dön',
                'ru' => 'Назад'
            ],
            'admin.withdrawals.edit_withdrawal_details' => [
                'tr' => 'Çekim Detaylarını Düzenle',
                'ru' => 'Редактировать детали вывода'
            ],
            'admin.withdrawals.toggle_edit_form' => [
                'tr' => 'Düzenle Formunu Aç/Kapat',
                'ru' => 'Показать/скрыть форму редактирования'
            ],
            'admin.withdrawals.current_amount' => [
                'tr' => 'Mevcut Tutar',
                'ru' => 'Текущая сумма'
            ],
            'admin.withdrawals.current_status' => [
                'tr' => 'Mevcut Durum',
                'ru' => 'Текущий статус'
            ],
            'admin.withdrawals.current_payment_method' => [
                'tr' => 'Mevcut Ödeme Yöntemi',
                'ru' => 'Текущий способ оплаты'
            ],
            'admin.withdrawals.creation_date' => [
                'tr' => 'Oluşturulma Tarihi',
                'ru' => 'Дата создания'
            ],
            'admin.withdrawals.payment_details' => [
                'tr' => 'Ödeme Detayları',
                'ru' => 'Детали платежа'
            ],
            'admin.withdrawals.not_specified' => [
                'tr' => 'Belirtilmemiş',
                'ru' => 'Не указано'
            ],
            'admin.withdrawals.amount' => [
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            'admin.withdrawals.rejected' => [
                'tr' => 'Reddedildi',
                'ru' => 'Отклонено'
            ],
            'admin.withdrawals.enter_payment_details_placeholder' => [
                'tr' => 'Ödeme detaylarını girin...',
                'ru' => 'Введите детали платежа...'
            ],
            'admin.withdrawals.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.withdrawals.update_withdrawal_details' => [
                'tr' => 'Çekim Detaylarını Güncelle',
                'ru' => 'Обновить детали вывода'
            ],
            'admin.withdrawals.payment_details_for_user' => [
                'tr' => ':user için Ödeme Detayları',
                'ru' => 'Детали платежа для :user'
            ],
            'admin.withdrawals.payment_completed' => [
                'tr' => 'Ödeme Tamamlandı',
                'ru' => 'Платеж завершен'
            ],
            'admin.withdrawals.btc_address' => [
                'tr' => 'BTC Adresi',
                'ru' => 'BTC Адрес'
            ],
            'admin.withdrawals.eth_address' => [
                'tr' => 'ETH Adresi',
                'ru' => 'ETH Адрес'
            ],
            'admin.withdrawals.ltc_address' => [
                'tr' => 'LTC Adresi',
                'ru' => 'LTC Адрес'
            ],
            'admin.withdrawals.usdt_address' => [
                'tr' => 'USDT Adresi',
                'ru' => 'USDT Адрес'
            ],
            'admin.withdrawals.busd_address' => [
                'tr' => 'BUSD Adresi',
                'ru' => 'BUSD Адрес'
            ],
            'admin.withdrawals.bank_name' => [
                'tr' => 'Banka Adı',
                'ru' => 'Название банка'
            ],
            'admin.withdrawals.account_name' => [
                'tr' => 'Hesap Adı',
                'ru' => 'Имя владельца счета'
            ],
            'admin.withdrawals.account_number' => [
                'tr' => 'Hesap Numarası',
                'ru' => 'Номер счета'
            ],
            'admin.withdrawals.swift_code' => [
                'tr' => 'Swift Kodu',
                'ru' => 'SWIFT Код'
            ],
            'admin.withdrawals.crypto_address' => [
                'tr' => ':currency Adresi',
                'ru' => ':currency Адрес'
            ],
            'admin.withdrawals.payment_details_for_method' => [
                'tr' => ':method Ödeme Detayları',
                'ru' => 'Детали платежа :method'
            ],
            'admin.withdrawals.perform_action' => [
                'tr' => 'İşlem Yapın',
                'ru' => 'Выполнить действие'
            ],
            'admin.withdrawals.action' => [
                'tr' => 'İşlem',
                'ru' => 'Действие'
            ],
            'admin.withdrawals.paid' => [
                'tr' => 'Ödendi',
                'ru' => 'Оплачено'
            ],
            'admin.withdrawals.reject' => [
                'tr' => 'Reddet',
                'ru' => 'Отклонить'
            ],
            'admin.withdrawals.send_email' => [
                'tr' => 'E-posta Gönder',
                'ru' => 'Отправить email'
            ],
            'admin.withdrawals.dont_send_email' => [
                'tr' => 'E-posta Gönderme',
                'ru' => 'Не отправлять email'
            ],
            'admin.withdrawals.subject' => [
                'tr' => 'Konu',
                'ru' => 'Тема'
            ],
            'admin.withdrawals.rejection_reason' => [
                'tr' => 'Reddetme Nedeni',
                'ru' => 'Причина отклонения'
            ],
            'admin.withdrawals.enter_rejection_reason_placeholder' => [
                'tr' => 'Reddetme nedenini buraya yazın...',
                'ru' => 'Укажите причину отклонения здесь...'
            ],
            'admin.withdrawals.complete_action' => [
                'tr' => 'İşlemi Tamamla',
                'ru' => 'Завершить действие'
            ],
            'admin.withdrawals.hide_form' => [
                'tr' => 'Formu Gizle',
                'ru' => 'Скрыть форму'
            ],
            'admin.withdrawals.amount_cannot_be_negative' => [
                'tr' => 'Tutar negatif olamaz',
                'ru' => 'Сумма не может быть отрицательной'
            ],
            'admin.withdrawals.update_withdrawal_confirmation' => [
                'tr' => 'Bu çekim talebini güncellemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите обновить этот запрос на вывод?'
            ],
            'admin.withdrawals.address_copied_to_clipboard' => [
                'tr' => 'Adres panoya kopyalandı!',
                'ru' => 'Адрес скопирован в буфер обмена!'
            ]
        ];

        foreach ($phrases as $key => $translations) {
            // Create or get the phrase
            $phrase = Phrase::firstOrCreate(['key' => $key]);

            // Create or update translations for Turkish (language_id = 1)
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => 1, // Turkish
                ],
                [
                    'translation' => $translations['tr']
                ]
            );

            // Create or update translations for Russian (language_id = 2)
            PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => 2, // Russian
                ],
                [
                    'translation' => $translations['ru']
                ]
            );
        }

        $this->command->info('Withdrawals blade phrases seeded successfully! Total: ' . count($phrases) . ' phrases');
    }
}