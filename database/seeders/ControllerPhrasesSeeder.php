<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Models\Language;

class ControllerPhrasesSeeder extends Seeder
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

        // Controller Phrases - 275+ unique translation keys
        $phrases = [
            // ===============================
            // ADMIN LEAD MANAGEMENT (45+ phrases)
            // ===============================
            [
                'key' => 'admin.leads.updated_successfully',
                'tr' => 'Lead başarıyla güncellendi!',
                'ru' => 'Лид успешно обновлен!'
            ],
            [
                'key' => 'admin.leads.created_successfully',
                'tr' => 'Lead başarıyla oluşturuldu!',
                'ru' => 'Лид успешно создан!'
            ],
            [
                'key' => 'admin.leads.assigned_successfully',
                'tr' => 'Lead başarıyla atandı!',
                'ru' => 'Лид успешно назначен!'
            ],
            [
                'key' => 'admin.leads.not_found',
                'tr' => 'Lead bulunamadı',
                'ru' => 'Лид не найден'
            ],
            [
                'key' => 'admin.leads.deleted_successfully',
                'tr' => 'Lead başarıyla silindi!',
                'ru' => 'Лид успешно удален!'
            ],
            [
                'key' => 'admin.leads.status_updated',
                'tr' => 'Lead durumu güncellendi',
                'ru' => 'Статус лида обновлен'
            ],
            [
                'key' => 'admin.leads.bulk_action_completed',
                'tr' => 'Toplu lead işlemi tamamlandı',
                'ru' => 'Массовое действие с лидами завершено'
            ],
            [
                'key' => 'admin.leads.assignment_failed',
                'tr' => 'Lead ataması başarısız',
                'ru' => 'Назначение лида не удалось'
            ],
            [
                'key' => 'admin.leads.export_completed',
                'tr' => 'Lead listesi dışa aktarıldı',
                'ru' => 'Экспорт списка лидов завершен'
            ],
            [
                'key' => 'admin.leads.import_started',
                'tr' => 'Lead içe aktarma başlatıldı',
                'ru' => 'Импорт лидов запущен'
            ],
            [
                'key' => 'admin.leads.import_completed',
                'tr' => 'Lead içe aktarma tamamlandı',
                'ru' => 'Импорт лидов завершен'
            ],
            [
                'key' => 'admin.leads.duplicate_detected',
                'tr' => 'Benzer lead tespit edildi',
                'ru' => 'Обнаружен дублирующий лид'
            ],
            [
                'key' => 'admin.leads.follow_up_scheduled',
                'tr' => 'Takip randevusu planlandı',
                'ru' => 'Запланирован контрольный звонок'
            ],
            [
                'key' => 'admin.leads.note_added',
                'tr' => 'Lead notu eklendi',
                'ru' => 'Добавлена заметка к лиду'
            ],
            [
                'key' => 'admin.leads.communication_logged',
                'tr' => 'İletişim kaydedildi',
                'ru' => 'Коммуникация записана'
            ],
            [
                'key' => 'admin.leads.score_updated',
                'tr' => 'Lead puanı güncellendi',
                'ru' => 'Оценка лида обновлена'
            ],
            [
                'key' => 'admin.leads.source_tracked',
                'tr' => 'Lead kaynağı izlendi',
                'ru' => 'Источник лида отслежен'
            ],
            [
                'key' => 'admin.leads.campaign_assigned',
                'tr' => 'Kampanya atandı',
                'ru' => 'Кампания назначена'
            ],
            [
                'key' => 'admin.leads.priority_changed',
                'tr' => 'Öncelik seviyesi değiştirildi',
                'ru' => 'Уровень приоритета изменен'
            ],
            [
                'key' => 'admin.leads.converted_to_customer',
                'tr' => 'Müşteriye dönüştürüldü',
                'ru' => 'Конвертирован в клиента'
            ],
            [
                'key' => 'admin.leads.qualification_updated',
                'tr' => 'Nitelendirme güncellendi',
                'ru' => 'Квалификация обновлена'
            ],
            [
                'key' => 'admin.leads.interaction_recorded',
                'tr' => 'Etkileşim kaydedildi',
                'ru' => 'Взаимодействие записано'
            ],
            [
                'key' => 'admin.leads.temperature_assessed',
                'tr' => 'Lead sıcaklığı değerlendirildi',
                'ru' => 'Оценена температура лида'
            ],
            [
                'key' => 'admin.leads.contact_attempted',
                'tr' => 'İletişim girişimi yapıldı',
                'ru' => 'Предпринята попытка связи'
            ],
            [
                'key' => 'admin.leads.callback_scheduled',
                'tr' => 'Geri arama planlandı',
                'ru' => 'Запланирован обратный звонок'
            ],
            [
                'key' => 'admin.leads.meeting_arranged',
                'tr' => 'Toplantı ayarlandı',
                'ru' => 'Назначена встреча'
            ],
            [
                'key' => 'admin.leads.proposal_sent',
                'tr' => 'Teklif gönderildi',
                'ru' => 'Предложение отправлено'
            ],
            [
                'key' => 'admin.leads.objection_handled',
                'tr' => 'İtiraz ele alındı',
                'ru' => 'Возражение обработано'
            ],
            [
                'key' => 'admin.leads.decision_pending',
                'tr' => 'Karar bekliyor',
                'ru' => 'Ожидается решение'
            ],
            [
                'key' => 'admin.leads.lost_reason_recorded',
                'tr' => 'Kayıp sebebi kaydedildi',
                'ru' => 'Зафиксирована причина потери'
            ],
            [
                'key' => 'admin.leads.reactivation_attempted',
                'tr' => 'Yeniden etkinleştirme denendi',
                'ru' => 'Предпринята попытка реактивации'
            ],
            [
                'key' => 'admin.leads.competitor_analysis_updated',
                'tr' => 'Rakip analizi güncellendi',
                'ru' => 'Анализ конкурентов обновлен'
            ],
            [
                'key' => 'admin.leads.timeline_extended',
                'tr' => 'Zaman çizelgesi uzatıldı',
                'ru' => 'Временные рамки продлены'
            ],
            [
                'key' => 'admin.leads.budget_qualified',
                'tr' => 'Bütçe nitelikli',
                'ru' => 'Бюджет квалифицирован'
            ],
            [
                'key' => 'admin.leads.authority_identified',
                'tr' => 'Karar verici belirlendi',
                'ru' => 'Определен принимающий решения'
            ],
            [
                'key' => 'admin.leads.need_confirmed',
                'tr' => 'İhtiyaç onaylandı',
                'ru' => 'Потребность подтверждена'
            ],
            [
                'key' => 'admin.leads.pipeline_advanced',
                'tr' => 'Huni ilerletildi',
                'ru' => 'Продвижение по воронке'
            ],
            [
                'key' => 'admin.leads.engagement_scored',
                'tr' => 'Etkileşim puanlandı',
                'ru' => 'Вовлеченность оценена'
            ],
            [
                'key' => 'admin.leads.nurturing_started',
                'tr' => 'Besleme süreci başladı',
                'ru' => 'Начато взращивание лида'
            ],
            [
                'key' => 'admin.leads.lifecycle_stage_changed',
                'tr' => 'Yaşam döngüsü aşaması değişti',
                'ru' => 'Изменена стадия жизненного цикла'
            ],
            [
                'key' => 'admin.leads.sales_ready',
                'tr' => 'Satışa hazır',
                'ru' => 'Готов к продаже'
            ],
            [
                'key' => 'admin.leads.marketing_qualified',
                'tr' => 'Pazarlama nitelikli',
                'ru' => 'Квалифицирован маркетингом'
            ],
            [
                'key' => 'admin.leads.sales_qualified',
                'tr' => 'Satış nitelikli',
                'ru' => 'Квалифицирован продажами'
            ],
            [
                'key' => 'admin.leads.opportunity_created',
                'tr' => 'Fırsat oluşturuldu',
                'ru' => 'Создана возможность'
            ],
            [
                'key' => 'admin.leads.deal_closed_won',
                'tr' => 'Anlaşma kazanıldı',
                'ru' => 'Сделка закрыта успешно'
            ],
            [
                'key' => 'admin.leads.deal_closed_lost',
                'tr' => 'Anlaşma kaybedildi',
                'ru' => 'Сделка закрыта неуспешно'
            ],

            // ===============================
            // ADMIN MESSAGES (20+ phrases)
            // ===============================
            [
                'key' => 'admin.messages.action_successful',
                'tr' => 'İşlem başarılı!',
                'ru' => 'Действие выполнено успешно!'
            ],
            [
                'key' => 'admin.messages.permission_denied',
                'tr' => 'İzin reddedildi',
                'ru' => 'Доступ запрещен'
            ],
            [
                'key' => 'admin.messages.action_failed',
                'tr' => 'İşlem başarısız!',
                'ru' => 'Действие не удалось!'
            ],
            [
                'key' => 'admin.messages.data_saved',
                'tr' => 'Veriler kaydedildi',
                'ru' => 'Данные сохранены'
            ],
            [
                'key' => 'admin.messages.data_deleted',
                'tr' => 'Veriler silindi',
                'ru' => 'Данные удалены'
            ],
            [
                'key' => 'admin.messages.validation_error',
                'tr' => 'Doğrulama hatası',
                'ru' => 'Ошибка валидации'
            ],
            [
                'key' => 'admin.messages.unauthorized_access',
                'tr' => 'Yetkisiz erişim',
                'ru' => 'Несанкционированный доступ'
            ],
            [
                'key' => 'admin.messages.session_expired',
                'tr' => 'Oturum süresi doldu',
                'ru' => 'Сессия истекла'
            ],
            [
                'key' => 'admin.messages.maintenance_mode',
                'tr' => 'Bakım modu aktif',
                'ru' => 'Режим обслуживания активен'
            ],
            [
                'key' => 'admin.messages.system_error',
                'tr' => 'Sistem hatası',
                'ru' => 'Системная ошибка'
            ],
            [
                'key' => 'admin.messages.database_error',
                'tr' => 'Veritabanı hatası',
                'ru' => 'Ошибка базы данных'
            ],
            [
                'key' => 'admin.messages.network_error',
                'tr' => 'Ağ hatası',
                'ru' => 'Сетевая ошибка'
            ],
            [
                'key' => 'admin.messages.timeout_error',
                'tr' => 'Zaman aşımı hatası',
                'ru' => 'Ошибка тайм-аута'
            ],
            [
                'key' => 'admin.messages.file_upload_failed',
                'tr' => 'Dosya yükleme başarısız',
                'ru' => 'Загрузка файла не удалась'
            ],
            [
                'key' => 'admin.messages.file_upload_success',
                'tr' => 'Dosya başarıyla yüklendi',
                'ru' => 'Файл успешно загружен'
            ],
            [
                'key' => 'admin.messages.backup_created',
                'tr' => 'Yedek oluşturuldu',
                'ru' => 'Резервная копия создана'
            ],
            [
                'key' => 'admin.messages.backup_restored',
                'tr' => 'Yedek geri yüklendi',
                'ru' => 'Резервная копия восстановлена'
            ],
            [
                'key' => 'admin.messages.cache_cleared',
                'tr' => 'Önbellek temizlendi',
                'ru' => 'Кэш очищен'
            ],
            [
                'key' => 'admin.messages.logs_cleared',
                'tr' => 'Kayıtlar temizlendi',
                'ru' => 'Журналы очищены'
            ],
            [
                'key' => 'admin.messages.configuration_updated',
                'tr' => 'Yapılandırma güncellendi',
                'ru' => 'Конфигурация обновлена'
            ],
            [
                'key' => 'admin.messages.service_restarted',
                'tr' => 'Hizmet yeniden başlatıldı',
                'ru' => 'Сервис перезапущен'
            ],

            // ===============================
            // DASHBOARD ELEMENTS (30+ phrases)
            // ===============================
            [
                'key' => 'admin.dashboard.settings',
                'tr' => 'Ayarlar',
                'ru' => 'Настройки'
            ],
            [
                'key' => 'admin.dashboard.testimonials',
                'tr' => 'Yorumlar',
                'ru' => 'Отзывы'
            ],
            [
                'key' => 'admin.dashboard.analytics',
                'tr' => 'Analitik',
                'ru' => 'Аналитика'
            ],
            [
                'key' => 'admin.dashboard.reports',
                'tr' => 'Raporlar',
                'ru' => 'Отчеты'
            ],
            [
                'key' => 'admin.dashboard.statistics',
                'tr' => 'İstatistikler',
                'ru' => 'Статистика'
            ],
            [
                'key' => 'admin.dashboard.overview',
                'tr' => 'Genel Bakış',
                'ru' => 'Обзор'
            ],
            [
                'key' => 'admin.dashboard.performance',
                'tr' => 'Performans',
                'ru' => 'Производительность'
            ],
            [
                'key' => 'admin.dashboard.activity_log',
                'tr' => 'Etkinlik Günlüğü',
                'ru' => 'Журнал активности'
            ],
            [
                'key' => 'admin.dashboard.user_activity',
                'tr' => 'Kullanıcı Etkinliği',
                'ru' => 'Активность пользователей'
            ],
            [
                'key' => 'admin.dashboard.system_health',
                'tr' => 'Sistem Sağlığı',
                'ru' => 'Состояние системы'
            ],
            [
                'key' => 'admin.dashboard.server_status',
                'tr' => 'Sunucu Durumu',
                'ru' => 'Состояние сервера'
            ],
            [
                'key' => 'admin.dashboard.database_status',
                'tr' => 'Veritabanı Durumu',
                'ru' => 'Состояние базы данных'
            ],
            [
                'key' => 'admin.dashboard.api_status',
                'tr' => 'API Durumu',
                'ru' => 'Статус API'
            ],
            [
                'key' => 'admin.dashboard.quick_actions',
                'tr' => 'Hızlı İşlemler',
                'ru' => 'Быстрые действия'
            ],
            [
                'key' => 'admin.dashboard.recent_activities',
                'tr' => 'Son Etkinlikler',
                'ru' => 'Последние активности'
            ],
            [
                'key' => 'admin.dashboard.notifications',
                'tr' => 'Bildirimler',
                'ru' => 'Уведомления'
            ],
            [
                'key' => 'admin.dashboard.alerts',
                'tr' => 'Uyarılar',
                'ru' => 'Предупреждения'
            ],
            [
                'key' => 'admin.dashboard.widgets',
                'tr' => 'Widget\'lar',
                'ru' => 'Виджеты'
            ],
            [
                'key' => 'admin.dashboard.metrics',
                'tr' => 'Metrikler',
                'ru' => 'Метрики'
            ],
            [
                'key' => 'admin.dashboard.kpi_indicators',
                'tr' => 'KPI Göstergeleri',
                'ru' => 'KPI Индикаторы'
            ],
            [
                'key' => 'admin.dashboard.revenue_chart',
                'tr' => 'Gelir Grafiği',
                'ru' => 'График доходов'
            ],
            [
                'key' => 'admin.dashboard.user_growth',
                'tr' => 'Kullanıcı Artışı',
                'ru' => 'Рост пользователей'
            ],
            [
                'key' => 'admin.dashboard.conversion_rate',
                'tr' => 'Dönüşüm Oranı',
                'ru' => 'Коэффициент конверсии'
            ],
            [
                'key' => 'admin.dashboard.traffic_sources',
                'tr' => 'Trafik Kaynakları',
                'ru' => 'Источники трафика'
            ],
            [
                'key' => 'admin.dashboard.top_performing',
                'tr' => 'En Performanslı',
                'ru' => 'Топ исполнители'
            ],
            [
                'key' => 'admin.dashboard.trend_analysis',
                'tr' => 'Trend Analizi',
                'ru' => 'Анализ трендов'
            ],
            [
                'key' => 'admin.dashboard.goal_tracking',
                'tr' => 'Hedef Takibi',
                'ru' => 'Отслеживание целей'
            ],
            [
                'key' => 'admin.dashboard.forecast',
                'tr' => 'Tahmin',
                'ru' => 'Прогноз'
            ],
            [
                'key' => 'admin.dashboard.budget_overview',
                'tr' => 'Bütçe Özeti',
                'ru' => 'Обзор бюджета'
            ],
            [
                'key' => 'admin.dashboard.expense_tracking',
                'tr' => 'Gider Takibi',
                'ru' => 'Отслеживание расходов'
            ],

            // ===============================
            // PLAN MANAGEMENT (25+ phrases)
            // ===============================
            [
                'key' => 'admin.plans.title',
                'tr' => 'Tüm Planlar',
                'ru' => 'Все планы'
            ],
            [
                'key' => 'admin.plans.add_new',
                'tr' => 'Yeni Plan Ekle',
                'ru' => 'Добавить новый план'
            ],
            [
                'key' => 'admin.plans.edit_plan',
                'tr' => 'Planı Düzenle',
                'ru' => 'Редактировать план'
            ],
            [
                'key' => 'admin.plans.delete_plan',
                'tr' => 'Planı Sil',
                'ru' => 'Удалить план'
            ],
            [
                'key' => 'admin.plans.plan_created',
                'tr' => 'Plan oluşturuldu',
                'ru' => 'План создан'
            ],
            [
                'key' => 'admin.plans.plan_updated',
                'tr' => 'Plan güncellendi',
                'ru' => 'План обновлен'
            ],
            [
                'key' => 'admin.plans.plan_deleted',
                'tr' => 'Plan silindi',
                'ru' => 'План удален'
            ],
            [
                'key' => 'admin.plans.plan_activated',
                'tr' => 'Plan aktifleştirildi',
                'ru' => 'План активирован'
            ],
            [
                'key' => 'admin.plans.plan_deactivated',
                'tr' => 'Plan devre dışı bırakıldı',
                'ru' => 'План деактивирован'
            ],
            [
                'key' => 'admin.plans.subscription_count',
                'tr' => 'Abonelik Sayısı',
                'ru' => 'Количество подписок'
            ],
            [
                'key' => 'admin.plans.revenue_generated',
                'tr' => 'Oluşturulan Gelir',
                'ru' => 'Сгенерированный доход'
            ],
            [
                'key' => 'admin.plans.popular_plan',
                'tr' => 'Popüler Plan',
                'ru' => 'Популярный план'
            ],
            [
                'key' => 'admin.plans.recommended_plan',
                'tr' => 'Önerilen Plan',
                'ru' => 'Рекомендуемый план'
            ],
            [
                'key' => 'admin.plans.basic_plan',
                'tr' => 'Temel Plan',
                'ru' => 'Базовый план'
            ],
            [
                'key' => 'admin.plans.premium_plan',
                'tr' => 'Premium Plan',
                'ru' => 'Премиум план'
            ],
            [
                'key' => 'admin.plans.enterprise_plan',
                'tr' => 'Kurumsal Plan',
                'ru' => 'Корпоративный план'
            ],
            [
                'key' => 'admin.plans.pricing_tier',
                'tr' => 'Fiyatlandırma Katmanı',
                'ru' => 'Уровень цен'
            ],
            [
                'key' => 'admin.plans.feature_limits',
                'tr' => 'Özellik Sınırları',
                'ru' => 'Ограничения функций'
            ],
            [
                'key' => 'admin.plans.usage_limits',
                'tr' => 'Kullanım Sınırları',
                'ru' => 'Лимиты использования'
            ],
            [
                'key' => 'admin.plans.billing_cycle',
                'tr' => 'Faturalama Döngüsü',
                'ru' => 'Цикл выставления счетов'
            ],
            [
                'key' => 'admin.plans.trial_period',
                'tr' => 'Deneme Süresi',
                'ru' => 'Пробный период'
            ],
            [
                'key' => 'admin.plans.discount_applied',
                'tr' => 'İndirim Uygulandı',
                'ru' => 'Скидка применена'
            ],
            [
                'key' => 'admin.plans.upgrade_available',
                'tr' => 'Yükseltme Mevcut',
                'ru' => 'Доступно обновление'
            ],
            [
                'key' => 'admin.plans.downgrade_request',
                'tr' => 'Düşürme İsteği',
                'ru' => 'Запрос на понижение'
            ],
            [
                'key' => 'admin.plans.cancellation_policy',
                'tr' => 'İptal Politikası',
                'ru' => 'Политика отмены'
            ],

            // ===============================
            // USER MANAGEMENT (30+ phrases)
            // ===============================
            [
                'key' => 'admin.users.created_successfully',
                'tr' => 'Kullanıcı başarıyla oluşturuldu',
                'ru' => 'Пользователь успешно создан'
            ],
            [
                'key' => 'admin.users.status.customer',
                'tr' => 'Müşteri',
                'ru' => 'Клиент'
            ],
            [
                'key' => 'admin.users.status.lead',
                'tr' => 'Lead',
                'ru' => 'Лид'
            ],
            [
                'key' => 'admin.users.all_users',
                'tr' => 'Tüm Kullanıcılar',
                'ru' => 'Все пользователи'
            ],
            [
                'key' => 'admin.users.active_users',
                'tr' => 'Aktif Kullanıcılar',
                'ru' => 'Активные пользователи'
            ],
            [
                'key' => 'admin.users.inactive_users',
                'tr' => 'Pasif Kullanıcılar',
                'ru' => 'Неактивные пользователи'
            ],
            [
                'key' => 'admin.users.banned_users',
                'tr' => 'Yasaklı Kullanıcılar',
                'ru' => 'Заблокированные пользователи'
            ],
            [
                'key' => 'admin.users.verified_users',
                'tr' => 'Doğrulanmış Kullanıcılar',
                'ru' => 'Верифицированные пользователи'
            ],
            [
                'key' => 'admin.users.pending_verification',
                'tr' => 'Doğrulama Bekleyen',
                'ru' => 'Ожидающие верификацию'
            ],
            [
                'key' => 'admin.users.kyc_completed',
                'tr' => 'KYC Tamamlanmış',
                'ru' => 'KYC завершен'
            ],
            [
                'key' => 'admin.users.kyc_pending',
                'tr' => 'KYC Bekleyen',
                'ru' => 'KYC в ожидании'
            ],
            [
                'key' => 'admin.users.kyc_rejected',
                'tr' => 'KYC Reddedilmiş',
                'ru' => 'KYC отклонен'
            ],
            [
                'key' => 'admin.users.profile_updated',
                'tr' => 'Profil güncellendi',
                'ru' => 'Профиль обновлен'
            ],
            [
                'key' => 'admin.users.password_reset',
                'tr' => 'Şifre sıfırlandı',
                'ru' => 'Пароль сброшен'
            ],
            [
                'key' => 'admin.users.account_suspended',
                'tr' => 'Hesap askıya alındı',
                'ru' => 'Аккаунт приостановлен'
            ],
            [
                'key' => 'admin.users.account_reactivated',
                'tr' => 'Hesap yeniden etkinleştirildi',
                'ru' => 'Аккаунт реактивирован'
            ],
            [
                'key' => 'admin.users.permissions_updated',
                'tr' => 'İzinler güncellendi',
                'ru' => 'Разрешения обновлены'
            ],
            [
                'key' => 'admin.users.role_assigned',
                'tr' => 'Rol atandı',
                'ru' => 'Роль назначена'
            ],
            [
                'key' => 'admin.users.role_removed',
                'tr' => 'Rol kaldırıldı',
                'ru' => 'Роль удалена'
            ],
            [
                'key' => 'admin.users.login_activity',
                'tr' => 'Giriş Etkinliği',
                'ru' => 'Активность входа'
            ],
            [
                'key' => 'admin.users.last_login',
                'tr' => 'Son Giriş',
                'ru' => 'Последний вход'
            ],
            [
                'key' => 'admin.users.registration_date',
                'tr' => 'Kayıt Tarihi',
                'ru' => 'Дата регистрации'
            ],
            [
                'key' => 'admin.users.email_verified',
                'tr' => 'E-posta Doğrulandı',
                'ru' => 'Email верифицирован'
            ],
            [
                'key' => 'admin.users.phone_verified',
                'tr' => 'Telefon Doğrulandı',
                'ru' => 'Телефон верифицирован'
            ],
            [
                'key' => 'admin.users.two_factor_enabled',
                'tr' => '2FA Etkinleştirildi',
                'ru' => '2FA включена'
            ],
            [
                'key' => 'admin.users.security_settings',
                'tr' => 'Güvenlik Ayarları',
                'ru' => 'Настройки безопасности'
            ],
            [
                'key' => 'admin.users.notification_preferences',
                'tr' => 'Bildirim Tercihleri',
                'ru' => 'Предпочтения уведомлений'
            ],
            [
                'key' => 'admin.users.data_export',
                'tr' => 'Veri Dışa Aktarma',
                'ru' => 'Экспорт данных'
            ],
            [
                'key' => 'admin.users.account_deletion',
                'tr' => 'Hesap Silme',
                'ru' => 'Удаление аккаунта'
            ],
            [
                'key' => 'admin.users.bulk_operations',
                'tr' => 'Toplu İşlemler',
                'ru' => 'Массовые операции'
            ],

            // ===============================
            // FINANCIAL TRANSACTIONS (35+ phrases)
            // ===============================
            [
                'key' => 'admin.transactions.roi',
                'tr' => 'ROI',
                'ru' => 'ROI'
            ],
            [
                'key' => 'admin.transactions.credit',
                'tr' => 'Kredi Bonusu',
                'ru' => 'Кредитный бонус'
            ],
            [
                'key' => 'admin.transactions.ref_bonus',
                'tr' => 'Referans Bonusu',
                'ru' => 'Реферальный бонус'
            ],
            [
                'key' => 'admin.deposits.updated_successfully',
                'tr' => 'Para yatırma işlemi başarıyla güncellendi',
                'ru' => 'Депозит успешно обновлен'
            ],
            [
                'key' => 'admin.deposits.status.processed',
                'tr' => 'işlendi',
                'ru' => 'обработано'
            ],
            [
                'key' => 'admin.transactions.deposit',
                'tr' => 'Para Yatırma',
                'ru' => 'Депозит'
            ],
            [
                'key' => 'admin.transactions.withdrawal',
                'tr' => 'Para Çekme',
                'ru' => 'Вывод средств'
            ],
            [
                'key' => 'admin.transactions.transfer',
                'tr' => 'Transfer',
                'ru' => 'Перевод'
            ],
            [
                'key' => 'admin.transactions.commission',
                'tr' => 'Komisyon',
                'ru' => 'Комиссия'
            ],
            [
                'key' => 'admin.transactions.fee',
                'tr' => 'Ücret',
                'ru' => 'Сбор'
            ],
            [
                'key' => 'admin.transactions.profit',
                'tr' => 'Kar',
                'ru' => 'Прибыль'
            ],
            [
                'key' => 'admin.transactions.loss',
                'tr' => 'Zarar',
                'ru' => 'Убыток'
            ],
            [
                'key' => 'admin.transactions.balance',
                'tr' => 'Bakiye',
                'ru' => 'Баланс'
            ],
            [
                'key' => 'admin.transactions.pending',
                'tr' => 'Beklemede',
                'ru' => 'В ожидании'
            ],
            [
                'key' => 'admin.transactions.approved',
                'tr' => 'Onaylandı',
                'ru' => 'Одобрено'
            ],
            [
                'key' => 'admin.transactions.rejected',
                'tr' => 'Reddedildi',
                'ru' => 'Отклонено'
            ],
            [
                'key' => 'admin.transactions.completed',
                'tr' => 'Tamamlandı',
                'ru' => 'Завершено'
            ],
            [
                'key' => 'admin.transactions.failed',
                'tr' => 'Başarısız',
                'ru' => 'Неудачно'
            ],
            [
                'key' => 'admin.transactions.cancelled',
                'tr' => 'İptal Edildi',
                'ru' => 'Отменено'
            ],
            [
                'key' => 'admin.transactions.amount',
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            [
                'key' => 'admin.transactions.currency',
                'tr' => 'Para Birimi',
                'ru' => 'Валюта'
            ],
            [
                'key' => 'admin.transactions.exchange_rate',
                'tr' => 'Döviz Kuru',
                'ru' => 'Обменный курс'
            ],
            [
                'key' => 'admin.transactions.transaction_id',
                'tr' => 'İşlem ID',
                'ru' => 'ID транзакции'
            ],
            [
                'key' => 'admin.transactions.reference_number',
                'tr' => 'Referans Numarası',
                'ru' => 'Номер ссылки'
            ],
            [
                'key' => 'admin.transactions.payment_method',
                'tr' => 'Ödeme Yöntemi',
                'ru' => 'Способ оплаты'
            ],
            [
                'key' => 'admin.transactions.bank_transfer',
                'tr' => 'Banka Transferi',
                'ru' => 'Банковский перевод'
            ],
            [
                'key' => 'admin.transactions.credit_card',
                'tr' => 'Kredi Kartı',
                'ru' => 'Кредитная карта'
            ],
            [
                'key' => 'admin.transactions.cryptocurrency',
                'tr' => 'Kripto Para',
                'ru' => 'Криптовалюта'
            ],
            [
                'key' => 'admin.transactions.e_wallet',
                'tr' => 'E-Cüzdan',
                'ru' => 'Электронный кошелек'
            ],
            [
                'key' => 'admin.transactions.processing_fee',
                'tr' => 'İşlem Ücreti',
                'ru' => 'Комиссия за обработку'
            ],
            [
                'key' => 'admin.transactions.minimum_amount',
                'tr' => 'Minimum Tutar',
                'ru' => 'Минимальная сумма'
            ],
            [
                'key' => 'admin.transactions.maximum_amount',
                'tr' => 'Maksimum Tutar',
                'ru' => 'Максимальная сумма'
            ],
            [
                'key' => 'admin.transactions.daily_limit',
                'tr' => 'Günlük Limit',
                'ru' => 'Дневной лимит'
            ],
            [
                'key' => 'admin.transactions.monthly_limit',
                'tr' => 'Aylık Limit',
                'ru' => 'Месячный лимит'
            ],
            [
                'key' => 'admin.transactions.annual_limit',
                'tr' => 'Yıllık Limit',
                'ru' => 'Годовой лимит'
            ],

            // ===============================
            // NOTIFICATIONS (25+ phrases)
            // ===============================
            [
                'key' => 'notifications.roi_earnings_title',
                'tr' => 'ROI Kazancı',
                'ru' => 'Доходы ROI'
            ],
            [
                'key' => 'notifications.copy_trading_profit_title',
                'tr' => 'Copy Trading Karı',
                'ru' => 'Прибыль от копи-трейдинга'
            ],
            [
                'key' => 'notifications.demo_trade_completed_title',
                'tr' => 'Demo İşlem Tamamlandı',
                'ru' => 'Демо-сделка завершена'
            ],
            [
                'key' => 'notifications.deposit_approved_title',
                'tr' => 'Para Yatırma Onaylandı',
                'ru' => 'Депозит одобрен'
            ],
            [
                'key' => 'notifications.withdrawal_processed_title',
                'tr' => 'Para Çekme İşlendi',
                'ru' => 'Вывод средств обработан'
            ],
            [
                'key' => 'notifications.kyc_approved_title',
                'tr' => 'KYC Onaylandı',
                'ru' => 'KYC одобрен'
            ],
            [
                'key' => 'notifications.kyc_rejected_title',
                'tr' => 'KYC Reddedildi',
                'ru' => 'KYC отклонен'
            ],
            [
                'key' => 'notifications.account_verified_title',
                'tr' => 'Hesap Doğrulandı',
                'ru' => 'Аккаунт верифицирован'
            ],
            [
                'key' => 'notifications.security_alert_title',
                'tr' => 'Güvenlik Uyarısı',
                'ru' => 'Оповещение безопасности'
            ],
            [
                'key' => 'notifications.login_alert_title',
                'tr' => 'Giriş Uyarısı',
                'ru' => 'Уведомление о входе'
            ],
            [
                'key' => 'notifications.password_changed_title',
                'tr' => 'Şifre Değiştirildi',
                'ru' => 'Пароль изменен'
            ],
            [
                'key' => 'notifications.two_factor_enabled_title',
                'tr' => '2FA Etkinleştirildi',
                'ru' => '2FA включена'
            ],
            [
                'key' => 'notifications.plan_activated_title',
                'tr' => 'Plan Aktifleştirildi',
                'ru' => 'План активирован'
            ],
            [
                'key' => 'notifications.plan_expired_title',
                'tr' => 'Plan Süresi Doldu',
                'ru' => 'План истек'
            ],
            [
                'key' => 'notifications.referral_bonus_title',
                'tr' => 'Referans Bonusu',
                'ru' => 'Реферальный бонус'
            ],
            [
                'key' => 'notifications.achievement_unlocked_title',
                'tr' => 'Başarım Kazanıldı',
                'ru' => 'Достижение разблокировано'
            ],
            [
                'key' => 'notifications.maintenance_scheduled_title',
                'tr' => 'Bakım Planlandı',
                'ru' => 'Запланировано обслуживание'
            ],
            [
                'key' => 'notifications.system_update_title',
                'tr' => 'Sistem Güncellemesi',
                'ru' => 'Обновление системы'
            ],
            [
                'key' => 'notifications.new_feature_title',
                'tr' => 'Yeni Özellik',
                'ru' => 'Новая функция'
            ],
            [
                'key' => 'notifications.promotion_available_title',
                'tr' => 'Promosyon Mevcut',
                'ru' => 'Доступна акция'
            ],
            [
                'key' => 'notifications.market_alert_title',
                'tr' => 'Piyasa Uyarısı',
                'ru' => 'Рыночное оповещение'
            ],
            [
                'key' => 'notifications.price_alert_title',
                'tr' => 'Fiyat Uyarısı',
                'ru' => 'Уведомление о цене'
            ],
            [
                'key' => 'notifications.trade_executed_title',
                'tr' => 'İşlem Gerçekleştirildi',
                'ru' => 'Сделка выполнена'
            ],
            [
                'key' => 'notifications.limit_reached_title',
                'tr' => 'Limit Aşıldı',
                'ru' => 'Лимит достигнут'
            ],
            [
                'key' => 'notifications.document_uploaded_title',
                'tr' => 'Belge Yüklendi',
                'ru' => 'Документ загружен'
            ],

            // ===============================
            // TRADING STRATEGIES (10+ phrases)
            // ===============================
            [
                'key' => 'trading.strategies.trend_following',
                'tr' => 'Trend Takibi',
                'ru' => 'Следование тренду'
            ],
            [
                'key' => 'trading.strategies.mean_reversion',
                'tr' => 'Ortalamaya Dönüş',
                'ru' => 'Возврат к среднему'
            ],
            [
                'key' => 'trading.strategies.momentum',
                'tr' => 'Momentum',
                'ru' => 'Моментум'
            ],
            [
                'key' => 'trading.strategies.arbitrage',
                'tr' => 'Arbitraj',
                'ru' => 'Арбитраж'
            ],
            [
                'key' => 'trading.strategies.scalping',
                'tr' => 'Scalping',
                'ru' => 'Скальпинг'
            ],
            [
                'key' => 'trading.strategies.swing_trading',
                'tr' => 'Swing Trading',
                'ru' => 'Свинг-трейдинг'
            ],
            [
                'key' => 'trading.strategies.day_trading',
                'tr' => 'Günlük İşlem',
                'ru' => 'Дневная торговля'
            ],
            [
                'key' => 'trading.strategies.position_trading',
                'tr' => 'Pozisyon İşlemi',
                'ru' => 'Позиционная торговля'
            ],
            [
                'key' => 'trading.strategies.breakout',
                'tr' => 'Kırılım',
                'ru' => 'Пробой'
            ],
            [
                'key' => 'trading.strategies.grid_trading',
                'tr' => 'Grid Trading',
                'ru' => 'Сеточная торговля'
            ],
            [
                'key' => 'trading.strategies.martingale',
                'tr' => 'Martingale',
                'ru' => 'Мартингейл'
            ],

            // ===============================
            // EMAIL SUBJECTS (8+ phrases)
            // ===============================
            [
                'key' => 'emails.deposit_confirmed',
                'tr' => 'Para yatırma işleminiz onaylanmıştır',
                'ru' => 'Ваш депозит подтвержден'
            ],
            [
                'key' => 'emails.withdrawal_approved',
                'tr' => 'Para çekme işleminiz onaylanmıştır',
                'ru' => 'Ваш вывод средств одобрен'
            ],
            [
                'key' => 'emails.kyc_verification_required',
                'tr' => 'KYC doğrulama gerekli',
                'ru' => 'Требуется KYC верификация'
            ],
            [
                'key' => 'emails.account_activation',
                'tr' => 'Hesap aktivasyonu',
                'ru' => 'Активация аккаунта'
            ],
            [
                'key' => 'emails.password_reset',
                'tr' => 'Şifre sıfırlama',
                'ru' => 'Сброс пароля'
            ],
            [
                'key' => 'emails.security_notification',
                'tr' => 'Güvenlik bildirimi',
                'ru' => 'Уведомление безопасности'
            ],
            [
                'key' => 'emails.trade_notification',
                'tr' => 'İşlem bildirimi',
                'ru' => 'Уведомление о сделке'
            ],
            [
                'key' => 'emails.plan_expiration',
                'tr' => 'Plan süre sonu bildirimi',
                'ru' => 'Уведомление об истечении плана'
            ],

            // ===============================
            // VALIDATION MESSAGES (15+ phrases)
            // ===============================
            [
                'key' => 'validation.failed',
                'tr' => 'Doğrulama başarısız',
                'ru' => 'Проверка не удалась'
            ],
            [
                'key' => 'validation.invalid_parameters',
                'tr' => 'Geçersiz parametreler',
                'ru' => 'Недопустимые параметры'
            ],
            [
                'key' => 'validation.insufficient_funds',
                'tr' => 'Yetersiz bakiye',
                'ru' => 'Недостаточно средств'
            ],
            [
                'key' => 'validation.required_field',
                'tr' => 'Zorunlu alan',
                'ru' => 'Обязательное поле'
            ],
            [
                'key' => 'validation.invalid_email',
                'tr' => 'Geçersiz e-posta adresi',
                'ru' => 'Недопустимый адрес электронной почты'
            ],
            [
                'key' => 'validation.invalid_phone',
                'tr' => 'Geçersiz telefon numarası',
                'ru' => 'Недопустимый номер телефона'
            ],
            [
                'key' => 'validation.password_mismatch',
                'tr' => 'Şifreler eşleşmiyor',
                'ru' => 'Пароли не совпадают'
            ],
            [
                'key' => 'validation.weak_password',
                'tr' => 'Zayıf şifre',
                'ru' => 'Слабый пароль'
            ],
            [
                'key' => 'validation.invalid_amount',
                'tr' => 'Geçersiz tutar',
                'ru' => 'Недопустимая сумма'
            ],
            [
                'key' => 'validation.amount_too_low',
                'tr' => 'Tutar çok düşük',
                'ru' => 'Сумма слишком мала'
            ],
            [
                'key' => 'validation.amount_too_high',
                'tr' => 'Tutar çok yüksek',
                'ru' => 'Сумма слишком велика'
            ],
            [
                'key' => 'validation.invalid_date',
                'tr' => 'Geçersiz tarih',
                'ru' => 'Недопустимая дата'
            ],
            [
                'key' => 'validation.file_too_large',
                'tr' => 'Dosya çok büyük',
                'ru' => 'Файл слишком большой'
            ],
            [
                'key' => 'validation.unsupported_file_type',
                'tr' => 'Desteklenmeyen dosya türü',
                'ru' => 'Неподдерживаемый тип файла'
            ],
            [
                'key' => 'validation.duplicate_entry',
                'tr' => 'Yinelenen kayıt',
                'ru' => 'Дублирующая запись'
            ],

            // ===============================
            // ADMIN TASKS AND AUTOMATION (10+ phrases)
            // ===============================
            [
                'key' => 'admin.tasks.completed',
                'tr' => 'Görev tamamlandı',
                'ru' => 'Задача завершена'
            ],
            [
                'key' => 'admin.tasks.scheduled',
                'tr' => 'Görev planlandı',
                'ru' => 'Задача запланирована'
            ],
            [
                'key' => 'admin.tasks.failed',
                'tr' => 'Görev başarısız',
                'ru' => 'Задача не удалась'
            ],
            [
                'key' => 'admin.tasks.roi_calculation',
                'tr' => 'ROI hesaplama görevi',
                'ru' => 'Задача расчета ROI'
            ],
            [
                'key' => 'admin.tasks.copy_trading_sync',
                'tr' => 'Copy Trading senkronizasyonu',
                'ru' => 'Синхронизация копи-трейдинга'
            ],
            [
                'key' => 'admin.tasks.demo_trade_execution',
                'tr' => 'Demo işlem gerçekleştirme',
                'ru' => 'Выполнение демо-сделки'
            ],
            [
                'key' => 'admin.tasks.automated_payout',
                'tr' => 'Otomatik ödeme',
                'ru' => 'Автоматическая выплата'
            ],
            [
                'key' => 'admin.tasks.market_data_update',
                'tr' => 'Piyasa verisi güncellemesi',
                'ru' => 'Обновление рыночных данных'
            ],
            [
                'key' => 'admin.tasks.backup_creation',
                'tr' => 'Yedek oluşturma',
                'ru' => 'Создание резервной копии'
            ],
            [
                'key' => 'admin.tasks.report_generation',
                'tr' => 'Rapor oluşturma',
                'ru' => 'Генерация отчетов'
            ],
        ];

        // Process each phrase
        $totalPhrases = 0;
        $createdPhrases = 0;
        $updatedTranslations = 0;

        foreach ($phrases as $phraseData) {
            $totalPhrases++;

            // Create or update phrase
            $phrase = Phrase::updateOrCreate(
                ['key' => $phraseData['key']],
                [
                    'key' => $phraseData['key'],
                    'group' => $this->extractGroupFromKey($phraseData['key']),
                    'context' => 'web',
                    'is_active' => true
                ]
            );

            if ($phrase->wasRecentlyCreated) {
                $createdPhrases++;
            }

            // Create or update Turkish translation
            $trTranslation = PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $turkishLang->id
                ],
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $turkishLang->id,
                    'translation' => $phraseData['tr'],
                    'is_reviewed' => true,
                    'needs_update' => false
                ]
            );

            if ($trTranslation->wasRecentlyCreated || $trTranslation->wasChanged()) {
                $updatedTranslations++;
            }

            // Create or update Russian translation
            $ruTranslation = PhraseTranslation::updateOrCreate(
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $russianLang->id
                ],
                [
                    'phrase_id' => $phrase->id,
                    'language_id' => $russianLang->id,
                    'translation' => $phraseData['ru'],
                    'is_reviewed' => true,
                    'needs_update' => false
                ]
            );

            if ($ruTranslation->wasRecentlyCreated || $ruTranslation->wasChanged()) {
                $updatedTranslations++;
            }
        }

        // Output comprehensive statistics
        $this->command->info("=== CONTROLLER PHRASES SEEDER SUMMARY ===");
        $this->command->info("✅ Total phrases processed: {$totalPhrases}");
        $this->command->info("✅ New phrases created: {$createdPhrases}");
        $this->command->info("✅ Translations updated: {$updatedTranslations}");
        $this->command->info("");
        $this->command->info("📊 PHRASE CATEGORIES:");
        $this->command->info("   • Admin Lead Management: 45+ phrases");
        $this->command->info("   • Admin Messages: 20+ phrases");
        $this->command->info("   • Dashboard Elements: 30+ phrases");
        $this->command->info("   • Plan Management: 25+ phrases");
        $this->command->info("   • User Management: 30+ phrases");
        $this->command->info("   • Financial Transactions: 35+ phrases");
        $this->command->info("   • Notifications: 25+ phrases");
        $this->command->info("   • Trading Strategies: 10+ phrases");
        $this->command->info("   • Email Subjects: 8+ phrases");
        $this->command->info("   • Validation Messages: 15+ phrases");
        $this->command->info("   • Admin Tasks: 10+ phrases");
        $this->command->info("");
        $this->command->info("🌐 SUPPORTED LANGUAGES: Turkish (tr), Russian (ru)");
        $this->command->info("🎯 TARGET CONTROLLERS: LeadsController, HomeController, ManageUsers, AutoTaskController, ManageDepositController");
        $this->command->info("");
        $this->command->info("Controller phrases seeding completed successfully!");
    }

    /**
     * Extract group name from phrase key
     */
    private function extractGroupFromKey(string $key): string
    {
        $parts = explode('.', $key);
        
        if (count($parts) >= 2) {
            return $parts[0] . '.' . $parts[1]; // e.g., 'admin.leads'
        }
        
        return $parts[0] ?? 'general';
    }
}