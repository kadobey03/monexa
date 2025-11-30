<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use DB;

class UserManagementPhrasesSeeder extends Seeder
{
    /**
     * User Management phrases seeder for Turkish and Russian languages
     * Covers general user management, customers, referrals, agents, investments, activities
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // === USER MANAGEMENT GENERAL ===
                [
                    'key' => 'admin.users.list',
                    'tr' => 'Kullanıcı Listesi',
                    'ru' => 'Список Пользователей'
                ],
                [
                    'key' => 'admin.users.add_new',
                    'tr' => 'Yeni Kullanıcı Ekle',
                    'ru' => 'Добавить Нового Пользователя'
                ],
                [
                    'key' => 'admin.users.status',
                    'tr' => 'Durum',
                    'ru' => 'Статус'
                ],
                [
                    'key' => 'admin.users.balance',
                    'tr' => 'Bakiye',
                    'ru' => 'Баланс'
                ],
                [
                    'key' => 'admin.users.demo_balance',
                    'tr' => 'Demo Bakiye',
                    'ru' => 'Демо Баланс'
                ],
                [
                    'key' => 'admin.users.total_invested',
                    'tr' => 'Toplam Yatırım',
                    'ru' => 'Общие Инвестиции'
                ],
                [
                    'key' => 'admin.users.total_withdrawn',
                    'tr' => 'Toplam Çekim',
                    'ru' => 'Общий Вывод'
                ],
                [
                    'key' => 'admin.users.registration_date',
                    'tr' => 'Kayıt Tarihi',
                    'ru' => 'Дата Регистрации'
                ],
                [
                    'key' => 'admin.users.last_activity',
                    'tr' => 'Son Aktivite',
                    'ru' => 'Последняя Активность'
                ],
                [
                    'key' => 'admin.users.email_verified',
                    'tr' => 'E-posta Doğrulandı',
                    'ru' => 'Email Подтвержден'
                ],
                [
                    'key' => 'admin.users.phone_verified',
                    'tr' => 'Telefon Doğrulandı',
                    'ru' => 'Телефон Подтвержден'
                ],

                // === CUSTOMER MANAGEMENT ===
                [
                    'key' => 'admin.customers.kyc_status',
                    'tr' => 'KYC Durumu',
                    'ru' => 'Статус KYC'
                ],
                [
                    'key' => 'admin.customers.kyc_pending',
                    'tr' => 'KYC Beklemede',
                    'ru' => 'KYC Ожидает'
                ],
                [
                    'key' => 'admin.customers.kyc_approved',
                    'tr' => 'KYC Onaylandı',
                    'ru' => 'KYC Одобрено'
                ],
                [
                    'key' => 'admin.customers.kyc_rejected',
                    'tr' => 'KYC Reddedildi',
                    'ru' => 'KYC Отклонено'
                ],
                [
                    'key' => 'admin.customers.document_upload',
                    'tr' => 'Belge Yükleme',
                    'ru' => 'Загрузка Документов'
                ],
                [
                    'key' => 'admin.customers.identity_verification',
                    'tr' => 'Kimlik Doğrulama',
                    'ru' => 'Верификация Личности'
                ],
                [
                    'key' => 'admin.customers.address_verification',
                    'tr' => 'Adres Doğrulama',
                    'ru' => 'Верификация Адреса'
                ],

                // === REFERRAL SYSTEM ===
                [
                    'key' => 'admin.referrals.commission',
                    'tr' => 'Komisyon',
                    'ru' => 'Комиссия'
                ],
                [
                    'key' => 'admin.referrals.referred_by',
                    'tr' => 'Refere Eden',
                    'ru' => 'Реферер'
                ],
                [
                    'key' => 'admin.referrals.total_referrals',
                    'tr' => 'Toplam Referal',
                    'ru' => 'Всего Рефералов'
                ],
                [
                    'key' => 'admin.referrals.referral_earnings',
                    'tr' => 'Referal Kazançları',
                    'ru' => 'Доходы от Рефералов'
                ],
                [
                    'key' => 'admin.referrals.referral_code',
                    'tr' => 'Referal Kodu',
                    'ru' => 'Реферальный Код'
                ],
                [
                    'key' => 'admin.referrals.commission_rate',
                    'tr' => 'Komisyon Oranı',
                    'ru' => 'Ставка Комиссии'
                ],

                // === AGENT MANAGEMENT ===
                [
                    'key' => 'admin.agents.agent_level',
                    'tr' => 'Agent Seviyesi',
                    'ru' => 'Уровень Агента'
                ],
                [
                    'key' => 'admin.agents.assigned_customers',
                    'tr' => 'Atanan Müşteriler',
                    'ru' => 'Назначенные Клиенты'
                ],
                [
                    'key' => 'admin.agents.total_sales',
                    'tr' => 'Toplam Satış',
                    'ru' => 'Общие Продажи'
                ],
                [
                    'key' => 'admin.agents.performance',
                    'tr' => 'Performans',
                    'ru' => 'Производительность'
                ],
                [
                    'key' => 'admin.agents.lead_conversion',
                    'tr' => 'Lead Dönüşüm',
                    'ru' => 'Конверсия Лидов'
                ],

                // === INVESTMENTS ===
                [
                    'key' => 'admin.investments.profit',
                    'tr' => 'Kar',
                    'ru' => 'Прибыль'
                ],
                [
                    'key' => 'admin.investments.loss',
                    'tr' => 'Zarar',
                    'ru' => 'Убыток'
                ],
                [
                    'key' => 'admin.investments.roi',
                    'tr' => 'ROI',
                    'ru' => 'ROI'
                ],
                [
                    'key' => 'admin.investments.investment_plan',
                    'tr' => 'Yatırım Planı',
                    'ru' => 'Инвестиционный План'
                ],
                [
                    'key' => 'admin.investments.maturity_date',
                    'tr' => 'Vade Tarihi',
                    'ru' => 'Дата Погашения'
                ],
                [
                    'key' => 'admin.investments.compound_interest',
                    'tr' => 'Bileşik Faiz',
                    'ru' => 'Сложные Проценты'
                ],
                [
                    'key' => 'admin.investments.investment_duration',
                    'tr' => 'Yatırım Süresi',
                    'ru' => 'Срок Инвестиций'
                ],

                // === ACCOUNTS ===
                [
                    'key' => 'admin.accounts.account_type',
                    'tr' => 'Hesap Türü',
                    'ru' => 'Тип Счета'
                ],
                [
                    'key' => 'admin.accounts.account_number',
                    'tr' => 'Hesap Numarası',
                    'ru' => 'Номер Счета'
                ],
                [
                    'key' => 'admin.accounts.account_status',
                    'tr' => 'Hesap Durumu',
                    'ru' => 'Статус Счета'
                ],
                [
                    'key' => 'admin.accounts.account_balance',
                    'tr' => 'Hesap Bakiyesi',
                    'ru' => 'Баланс Счета'
                ],
                [
                    'key' => 'admin.accounts.available_balance',
                    'tr' => 'Kullanılabilir Bakiye',
                    'ru' => 'Доступный Баланс'
                ],
                [
                    'key' => 'admin.accounts.frozen_balance',
                    'tr' => 'Dondurulmuş Bakiye',
                    'ru' => 'Замороженный Баланс'
                ],

                // === ACTIVITIES ===
                [
                    'key' => 'admin.activities.login_activity',
                    'tr' => 'Giriş Aktivitesi',
                    'ru' => 'Активность Входа'
                ],
                [
                    'key' => 'admin.activities.transaction_history',
                    'tr' => 'İşlem Geçmişi',
                    'ru' => 'История Транзакций'
                ],
                [
                    'key' => 'admin.activities.deposit_history',
                    'tr' => 'Yatırım Geçmişi',
                    'ru' => 'История Депозитов'
                ],
                [
                    'key' => 'admin.activities.withdrawal_history',
                    'tr' => 'Çekim Geçmişi',
                    'ru' => 'История Выводов'
                ],
                [
                    'key' => 'admin.activities.login_attempts',
                    'tr' => 'Giriş Denemeleri',
                    'ru' => 'Попытки Входа'
                ],
                [
                    'key' => 'admin.activities.failed_logins',
                    'tr' => 'Başarısız Girişler',
                    'ru' => 'Неудачные Входы'
                ],
                [
                    'key' => 'admin.activities.ip_address',
                    'tr' => 'IP Adresi',
                    'ru' => 'IP Адрес'
                ],
                [
                    'key' => 'admin.activities.user_agent',
                    'tr' => 'Kullanıcı Ajanı',
                    'ru' => 'Пользовательский Агент'
                ],
                [
                    'key' => 'admin.activities.session_duration',
                    'tr' => 'Oturum Süresi',
                    'ru' => 'Продолжительность Сессии'
                ],

                // === LEAD MANAGEMENT ===
                [
                    'key' => 'admin.leads.lead_status',
                    'tr' => 'Lead Durumu',
                    'ru' => 'Статус Лида'
                ],
                [
                    'key' => 'admin.leads.lead_score',
                    'tr' => 'Lead Puanı',
                    'ru' => 'Оценка Лида'
                ],
                [
                    'key' => 'admin.leads.lead_source',
                    'tr' => 'Lead Kaynağı',
                    'ru' => 'Источник Лида'
                ],
                [
                    'key' => 'admin.leads.follow_up_date',
                    'tr' => 'Takip Tarihi',
                    'ru' => 'Дата Следующего Контакта'
                ],
                [
                    'key' => 'admin.leads.last_contact',
                    'tr' => 'Son İletişim',
                    'ru' => 'Последний Контакт'
                ],
                [
                    'key' => 'admin.leads.assigned_to',
                    'tr' => 'Atanan',
                    'ru' => 'Назначен'
                ],
                [
                    'key' => 'admin.leads.conversion_rate',
                    'tr' => 'Dönüşüm Oranı',
                    'ru' => 'Коэффициент Конверсии'
                ],

                // === COMMON ACTIONS ===
                [
                    'key' => 'admin.actions.view',
                    'tr' => 'Görüntüle',
                    'ru' => 'Просмотр'
                ],
                [
                    'key' => 'admin.actions.edit',
                    'tr' => 'Düzenle',
                    'ru' => 'Редактировать'
                ],
                [
                    'key' => 'admin.actions.delete',
                    'tr' => 'Sil',
                    'ru' => 'Удалить'
                ],
                [
                    'key' => 'admin.actions.activate',
                    'tr' => 'Aktifleştir',
                    'ru' => 'Активировать'
                ],
                [
                    'key' => 'admin.actions.deactivate',
                    'tr' => 'Deaktif Et',
                    'ru' => 'Деактивировать'
                ],
                [
                    'key' => 'admin.actions.approve',
                    'tr' => 'Onayla',
                    'ru' => 'Одобрить'
                ],
                [
                    'key' => 'admin.actions.reject',
                    'tr' => 'Reddet',
                    'ru' => 'Отклонить'
                ],
                [
                    'key' => 'admin.actions.suspend',
                    'tr' => 'Askıya Al',
                    'ru' => 'Приостановить'
                ],
                [
                    'key' => 'admin.actions.restore',
                    'tr' => 'Geri Yükle',
                    'ru' => 'Восстановить'
                ],
                [
                    'key' => 'admin.actions.export',
                    'tr' => 'Dışa Aktar',
                    'ru' => 'Экспорт'
                ],
                [
                    'key' => 'admin.actions.import',
                    'tr' => 'İçe Aktar',
                    'ru' => 'Импорт'
                ],
                [
                    'key' => 'admin.actions.filter',
                    'tr' => 'Filtrele',
                    'ru' => 'Фильтр'
                ],
                [
                    'key' => 'admin.actions.search',
                    'tr' => 'Ara',
                    'ru' => 'Поиск'
                ],
                [
                    'key' => 'admin.actions.reset',
                    'tr' => 'Sıfırla',
                    'ru' => 'Сброс'
                ],

                // === STATUSES ===
                [
                    'key' => 'admin.status.active',
                    'tr' => 'Aktif',
                    'ru' => 'Активный'
                ],
                [
                    'key' => 'admin.status.inactive',
                    'tr' => 'Pasif',
                    'ru' => 'Неактивный'
                ],
                [
                    'key' => 'admin.status.pending',
                    'tr' => 'Beklemede',
                    'ru' => 'В Ожидании'
                ],
                [
                    'key' => 'admin.status.approved',
                    'tr' => 'Onaylandı',
                    'ru' => 'Одобрено'
                ],
                [
                    'key' => 'admin.status.rejected',
                    'tr' => 'Reddedildi',
                    'ru' => 'Отклонено'
                ],
                [
                    'key' => 'admin.status.suspended',
                    'tr' => 'Askıya Alındı',
                    'ru' => 'Приостановлено'
                ],
                [
                    'key' => 'admin.status.verified',
                    'tr' => 'Doğrulandı',
                    'ru' => 'Подтверждено'
                ],
                [
                    'key' => 'admin.status.unverified',
                    'tr' => 'Doğrulanmadı',
                    'ru' => 'Не Подтверждено'
                ],

                // === FINANCIAL TERMS ===
                [
                    'key' => 'admin.financial.currency',
                    'tr' => 'Para Birimi',
                    'ru' => 'Валюта'
                ],
                [
                    'key' => 'admin.financial.amount',
                    'tr' => 'Miktar',
                    'ru' => 'Сумма'
                ],
                [
                    'key' => 'admin.financial.fee',
                    'tr' => 'Ücret',
                    'ru' => 'Комиссия'
                ],
                [
                    'key' => 'admin.financial.interest_rate',
                    'tr' => 'Faiz Oranı',
                    'ru' => 'Процентная Ставка'
                ],
                [
                    'key' => 'admin.financial.minimum_deposit',
                    'tr' => 'Minimum Yatırım',
                    'ru' => 'Минимальный Депозит'
                ],
                [
                    'key' => 'admin.financial.maximum_deposit',
                    'tr' => 'Maksimum Yatırım',
                    'ru' => 'Максимальный Депозит'
                ],
                [
                    'key' => 'admin.financial.minimum_withdrawal',
                    'tr' => 'Minimum Çekim',
                    'ru' => 'Минимальный Вывод'
                ],
                [
                    'key' => 'admin.financial.maximum_withdrawal',
                    'tr' => 'Maksimum Çekim',
                    'ru' => 'Максимальный Вывод'
                ]
            ];

            foreach ($phrases as $phraseData) {
                // Create or get phrase
                $phrase = Phrase::firstOrCreate(['key' => $phraseData['key']]);

                // Create Turkish translation (id: 1)
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 1 // Turkish
                    ],
                    ['translation' => $phraseData['tr']]
                );

                // Create Russian translation (id: 2)
                PhraseTranslation::updateOrCreate(
                    [
                        'phrase_id' => $phrase->id,
                        'language_id' => 2 // Russian
                    ],
                    ['translation' => $phraseData['ru']]
                );
            }

            $this->command->info('User Management phrases seeded successfully: ' . count($phrases) . ' phrases added');
        });
    }
}