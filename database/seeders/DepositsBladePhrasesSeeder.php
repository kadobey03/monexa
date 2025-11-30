<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class DepositsBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Main deposits page (mdeposits.blade.php)
            'admin.deposits.customer_investments' => [
                'tr' => 'Müşteri Yatırımları',
                'ru' => 'Инвестиции клиентов'
            ],
            'admin.deposits.manage_customer_investments' => [
                'tr' => 'Müşteri Yatırımlarını Yönet',
                'ru' => 'Управление инвестициями клиентов'
            ],
            'admin.deposits.view_approve_manage_description' => [
                'tr' => 'Sistemdeki tüm müşteri yatırımlarını görüntüleyin, onaylayın ve yönetin',
                'ru' => 'Просмотр, одобрение и управление всеми клиентскими инвестициями в системе'
            ],
            'admin.deposits.total_records' => [
                'tr' => 'Toplam Kayıt',
                'ru' => 'Всего записей'
            ],
            'admin.deposits.refresh' => [
                'tr' => 'Yenile',
                'ru' => 'Обновить'
            ],
            'admin.deposits.total_amount' => [
                'tr' => 'Toplam Tutar',
                'ru' => 'Общая сумма'
            ],
            'admin.deposits.all_investments' => [
                'tr' => 'Tüm yatırımlar',
                'ru' => 'Все инвестиции'
            ],
            'admin.deposits.processed' => [
                'tr' => 'İşlenmiş',
                'ru' => 'Обработано'
            ],
            'admin.deposits.approved_transactions' => [
                'tr' => 'Onaylanmış işlemler',
                'ru' => 'Одобренные транзакции'
            ],
            'admin.deposits.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            'admin.deposits.waiting_approval' => [
                'tr' => 'Onay bekliyor',
                'ru' => 'Ожидает одобрения'
            ],
            'admin.deposits.active_users' => [
                'tr' => 'Aktif Kullanıcı',
                'ru' => 'Активные пользователи'
            ],
            'admin.deposits.unique_users' => [
                'tr' => 'Benzersiz kullanıcılar',
                'ru' => 'Уникальные пользователи'
            ],
            'admin.deposits.investment_list' => [
                'tr' => 'Yatırım Listesi',
                'ru' => 'Список инвестиций'
            ],
            'admin.deposits.search_placeholder' => [
                'tr' => 'Müşteri, tutar veya durum ara...',
                'ru' => 'Поиск по клиенту, сумме или статусу...'
            ],
            'admin.deposits.all' => [
                'tr' => 'Tümü',
                'ru' => 'Все'
            ],
            'admin.deposits.investment_payment' => [
                'tr' => 'Yatırım Ödemesi',
                'ru' => 'Инвестиционный платеж'
            ],
            'admin.deposits.signal_payment' => [
                'tr' => 'Sinyal Ödemesi',
                'ru' => 'Сигнальный платеж'
            ],
            'admin.deposits.customer' => [
                'tr' => 'Müşteri',
                'ru' => 'Клиент'
            ],
            'admin.deposits.email' => [
                'tr' => 'E-posta',
                'ru' => 'Электронная почта'
            ],
            'admin.deposits.amount' => [
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            'admin.deposits.payment_method' => [
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ оплаты'
            ],
            'admin.deposits.investment_type' => [
                'tr' => 'Yatırım Türü',
                'ru' => 'Тип инвестиции'
            ],
            'admin.deposits.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.deposits.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'admin.deposits.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.deposits.user_deleted' => [
                'tr' => 'Kullanıcı silinmiş',
                'ru' => 'Пользователь удален'
            ],
            'admin.deposits.view' => [
                'tr' => 'Görüntüle',
                'ru' => 'Просмотр'
            ],
            'admin.deposits.approve' => [
                'tr' => 'Onayla',
                'ru' => 'Одобрить'
            ],
            'admin.deposits.delete_confirmation' => [
                'tr' => 'Bu yatırımı silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту инвестицию?'
            ],
            'admin.deposits.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.deposits.no_investment_records' => [
                'tr' => 'Henüz Yatırım Kaydı Bulunmuyor',
                'ru' => 'Записи об инвестициях пока не найдены'
            ],
            'admin.deposits.records_will_appear' => [
                'tr' => 'Müşteriler yatırım yaptığında kayıtlar burada görünecektir.',
                'ru' => 'Записи будут отображаться здесь, когда клиенты сделают инвестиции.'
            ],
            'admin.deposits.refresh_page' => [
                'tr' => 'Sayfayı Yenile',
                'ru' => 'Обновить страницу'
            ],
            'admin.deposits.showing' => [
                'tr' => 'Gösterilen',
                'ru' => 'Показано'
            ],
            'admin.deposits.total' => [
                'tr' => 'Toplam',
                'ru' => 'Всего'
            ],
            'admin.deposits.per_page' => [
                'tr' => 'Sayfa başına',
                'ru' => 'На страницу'
            ],

            // Deposit image page (depositimg.blade.php)
            'admin.deposits.investment_screenshot' => [
                'tr' => 'Yatırım Ekran Görüntüsü',
                'ru' => 'Скриншот инвестиции'
            ],
            'admin.deposits.view_edit_investment_proof' => [
                'tr' => 'Müşteri yatırım kanıtını görüntüleyin ve düzenleyin',
                'ru' => 'Просмотр и редактирование доказательств инвестиций клиента'
            ],
            'admin.deposits.back' => [
                'tr' => 'Geri Dön',
                'ru' => 'Назад'
            ],
            'admin.deposits.edit_investment_details' => [
                'tr' => 'Yatırım Detaylarını Düzenle',
                'ru' => 'Редактировать детали инвестиции'
            ],
            'admin.deposits.toggle_edit_form' => [
                'tr' => 'Düzenle Formunu Aç/Kapat',
                'ru' => 'Показать/скрыть форму редактирования'
            ],
            'admin.deposits.current_amount' => [
                'tr' => 'Mevcut Tutar',
                'ru' => 'Текущая сумма'
            ],
            'admin.deposits.current_status' => [
                'tr' => 'Mevcut Durum',
                'ru' => 'Текущий статус'
            ],
            'admin.deposits.current_payment_method' => [
                'tr' => 'Mevcut Ödeme Yöntemi',
                'ru' => 'Текущий способ оплаты'
            ],
            'admin.deposits.creation_date' => [
                'tr' => 'Oluşturulma Tarihi',
                'ru' => 'Дата создания'
            ],
            'admin.deposits.rejected' => [
                'tr' => 'Reddedildi',
                'ru' => 'Отклонено'
            ],
            'admin.deposits.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.deposits.update_investment_details' => [
                'tr' => 'Yatırım Detaylarını Güncelle',
                'ru' => 'Обновить детали инвестиции'
            ],
            'admin.deposits.investment_proof_screenshot' => [
                'tr' => 'Yatırım Kanıt Ekran Görüntüsü',
                'ru' => 'Скриншот доказательства инвестиции'
            ],
            'admin.deposits.payment_proof' => [
                'tr' => 'Ödeme Kanıtı',
                'ru' => 'Доказательство платежа'
            ],
            'admin.deposits.enlarged_image' => [
                'tr' => 'Büyütülmüş Görüntü',
                'ru' => 'Увеличенное изображение'
            ],
            'admin.deposits.hide_form' => [
                'tr' => 'Formu Gizle',
                'ru' => 'Скрыть форму'
            ],
            'admin.deposits.amount_cannot_be_negative' => [
                'tr' => 'Tutar negatif olamaz',
                'ru' => 'Сумма не может быть отрицательной'
            ],
            'admin.deposits.update_investment_confirmation' => [
                'tr' => 'Bu yatırım talebini güncellemek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите обновить эту заявку на инвестицию?'
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

        $this->command->info('Deposits blade phrases seeded successfully! Total: ' . count($phrases) . ' phrases');
    }
}