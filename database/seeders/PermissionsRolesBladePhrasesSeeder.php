<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class PermissionsRolesBladePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
            // Permissions Index
            'admin.permissions.index.title' => [
                'tr' => 'Yetki Yönetimi',
                'ru' => 'Управление Разрешениями'
            ],
            'admin.permissions.index.description' => [
                'tr' => 'Sistem yetki ve rol yönetimi',
                'ru' => 'Управление системными разрешениями и ролями'
            ],
            'admin.permissions.index.bulk_assign' => [
                'tr' => 'Toplu Atama',
                'ru' => 'Массовое Назначение'
            ],
            'admin.permissions.index.matrix_view' => [
                'tr' => 'Matrix',
                'ru' => 'Матрица'
            ],
            'admin.permissions.index.hierarchy' => [
                'tr' => 'Hiyerarşi',
                'ru' => 'Иерархия'
            ],
            'admin.permissions.index.audit_logs' => [
                'tr' => 'Denetim Logları',
                'ru' => 'Журналы Аудита'
            ],
            'admin.permissions.index.total_permissions' => [
                'tr' => 'Toplam İzin',
                'ru' => 'Всего Разрешений'
            ],
            'admin.permissions.index.granted_permissions' => [
                'tr' => 'Verilen İzin',
                'ru' => 'Выданные Разрешения'
            ],
            'admin.permissions.index.active_roles' => [
                'tr' => 'Aktif Rol',
                'ru' => 'Активные Роли'
            ],
            'admin.permissions.index.total_admins' => [
                'tr' => 'Toplam Admin',
                'ru' => 'Всего Админов'
            ],
            'admin.permissions.index.search' => [
                'tr' => 'İzin, rol veya admin ara...',
                'ru' => 'Поиск разрешений, ролей или админов...'
            ],
            'admin.permissions.index.filter_by_category' => [
                'tr' => 'Kategoriye Göre Filtrele',
                'ru' => 'Фильтр по Категории'
            ],
            'admin.permissions.index.all_categories' => [
                'tr' => 'Tüm Kategoriler',
                'ru' => 'Все Категории'
            ],
            'admin.permissions.index.filter_by_role' => [
                'tr' => 'Role Göre Filtrele',
                'ru' => 'Фильтр по Роли'
            ],
            'admin.permissions.index.all_roles' => [
                'tr' => 'Tüm Roller',
                'ru' => 'Все Роли'
            ],
            'admin.permissions.index.permission_name' => [
                'tr' => 'İzin Adı',
                'ru' => 'Название Разрешения'
            ],
            'admin.permissions.index.category' => [
                'tr' => 'Kategori',
                'ru' => 'Категория'
            ],
            'admin.permissions.index.roles' => [
                'tr' => 'Roller',
                'ru' => 'Роли'
            ],
            'admin.permissions.index.admins' => [
                'tr' => 'Adminler',
                'ru' => 'Админы'
            ],
            'admin.permissions.index.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.permissions.index.granted' => [
                'tr' => 'Verildi',
                'ru' => 'Выдано'
            ],
            'admin.permissions.index.not_granted' => [
                'tr' => 'Verilmedi',
                'ru' => 'Не Выдано'
            ],

            // Role Permissions
            'admin.permissions.role_permissions.title' => [
                'tr' => 'Rol İzinleri',
                'ru' => 'Разрешения Роли'
            ],
            'admin.permissions.role_permissions.level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень'
            ],
            'admin.permissions.role_permissions.permission_management' => [
                'tr' => 'İzin Yönetimi',
                'ru' => 'Управление Разрешениями'
            ],
            'admin.permissions.role_permissions.inheritance_hierarchy' => [
                'tr' => 'Miras Hiyerarşisi',
                'ru' => 'Иерархия Наследования'
            ],
            'admin.permissions.role_permissions.save_changes' => [
                'tr' => 'Değişiklikleri Kaydet',
                'ru' => 'Сохранить Изменения'
            ],
            'admin.permissions.role_permissions.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],

            // Audit
            'admin.permissions.audit.title' => [
                'tr' => 'İzin Denetim Logları',
                'ru' => 'Журналы Аудита Разрешений'
            ],
            'admin.permissions.audit.description' => [
                'tr' => 'Sistem izin değişikliklerinin detaylı kayıtları',
                'ru' => 'Подробные записи изменений разрешений системы'
            ],
            'admin.permissions.audit.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            'admin.permissions.audit.date_range' => [
                'tr' => 'Başlangıç Tarihi',
                'ru' => 'Дата Начала'
            ],
            'admin.permissions.audit.end_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата Окончания'
            ],
            'admin.permissions.audit.action_type' => [
                'tr' => 'İşlem Tipi',
                'ru' => 'Тип Действия'
            ],
            'admin.permissions.audit.all' => [
                'tr' => 'Tümü',
                'ru' => 'Все'
            ],
            'admin.permissions.audit.granted' => [
                'tr' => 'Verildi',
                'ru' => 'Выдано'
            ],
            'admin.permissions.audit.revoked' => [
                'tr' => 'Geri Alındı',
                'ru' => 'Отозвано'
            ],
            'admin.permissions.audit.updated' => [
                'tr' => 'Güncellendi',
                'ru' => 'Обновлено'
            ],
            'admin.permissions.audit.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.permissions.audit.search_user' => [
                'tr' => 'Kullanıcı ara...',
                'ru' => 'Поиск пользователя...'
            ],
            'admin.permissions.audit.clear' => [
                'tr' => 'Temizle',
                'ru' => 'Очистить'
            ],
            'admin.permissions.audit.filter' => [
                'tr' => 'Filtrele',
                'ru' => 'Фильтр'
            ],
            'admin.permissions.audit.records' => [
                'tr' => 'Kayıtlar',
                'ru' => 'Записи'
            ],
            'admin.permissions.audit.datetime' => [
                'tr' => 'Tarih/Saat',
                'ru' => 'Дата/Время'
            ],
            'admin.permissions.audit.action' => [
                'tr' => 'İşlem',
                'ru' => 'Действие'
            ],
            'admin.permissions.audit.role' => [
                'tr' => 'Rol',
                'ru' => 'Роль'
            ],
            'admin.permissions.audit.permission' => [
                'tr' => 'İzin',
                'ru' => 'Разрешение'
            ],
            'admin.permissions.audit.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.permissions.audit.ip_address' => [
                'tr' => 'IP Adresi',
                'ru' => 'IP Адрес'
            ],
            'admin.permissions.audit.no_records' => [
                'tr' => 'Kayıt Bulunamadı',
                'ru' => 'Записи не Найдены'
            ],
            'admin.permissions.audit.no_matching_records' => [
                'tr' => 'Filtrelere uygun kayıt bulunamadı',
                'ru' => 'Записи, соответствующие фильтрам, не найдены'
            ],
            'admin.permissions.audit.previous' => [
                'tr' => 'Önceki',
                'ru' => 'Предыдущая'
            ],
            'admin.permissions.audit.next' => [
                'tr' => 'Sonraki',
                'ru' => 'Следующая'
            ],
            'admin.permissions.audit.showing_between' => [
                'tr' => 'arası gösteriliyor, toplam',
                'ru' => 'показано между, всего'
            ],
            'admin.permissions.audit.records_total' => [
                'tr' => 'kayıt',
                'ru' => 'записей'
            ],
            'admin.permissions.audit.load_error' => [
                'tr' => 'Veri yükleme hatası',
                'ru' => 'Ошибка загрузки данных'
            ],
            'admin.permissions.audit.export_error' => [
                'tr' => 'Dışa aktarma hatası',
                'ru' => 'Ошибка экспорта'
            ],
            'admin.permissions.audit.export_failed' => [
                'tr' => 'Dışa aktarma başarısız oldu',
                'ru' => 'Экспорт не удался'
            ],

            // Hierarchy
            'admin.permissions.hierarchy.title' => [
                'tr' => 'İzin Hiyerarşisi',
                'ru' => 'Иерархия Разрешений'
            ],
            'admin.permissions.hierarchy.description' => [
                'tr' => 'Rol ve izin hiyerarşi yapısını görüntüleyin ve yönetin',
                'ru' => 'Просмотр и управление структурой иерархии ролей и разрешений'
            ],
            'admin.permissions.hierarchy.tree' => [
                'tr' => 'Ağaç',
                'ru' => 'Дерево'
            ],
            'admin.permissions.hierarchy.organization' => [
                'tr' => 'Organizasyon',
                'ru' => 'Организация'
            ],
            'admin.permissions.hierarchy.matrix' => [
                'tr' => 'Matrix',
                'ru' => 'Матрица'
            ],
            'admin.permissions.hierarchy.export' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            'admin.permissions.hierarchy.restructure' => [
                'tr' => 'Yeniden Yapılandır',
                'ru' => 'Реструктурировать'
            ],
            'admin.permissions.hierarchy.total_levels' => [
                'tr' => 'Toplam Seviye',
                'ru' => 'Всего Уровней'
            ],
            'admin.permissions.hierarchy.active_roles' => [
                'tr' => 'Aktif Roller',
                'ru' => 'Активные Роли'
            ],
            'admin.permissions.hierarchy.departments' => [
                'tr' => 'Departmanlar',
                'ru' => 'Департаменты'
            ],
            'admin.permissions.hierarchy.users' => [
                'tr' => 'Kullanıcılar',
                'ru' => 'Пользователи'
            ],
            'admin.permissions.hierarchy.conflicts' => [
                'tr' => 'Çakışmalar',
                'ru' => 'Конфликты'
            ],
            'admin.permissions.hierarchy.hierarchy_tree' => [
                'tr' => 'Hiyerarşi Ağacı',
                'ru' => 'Дерево Иерархии'
            ],
            'admin.permissions.hierarchy.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активные'
            ],
            'admin.permissions.hierarchy.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивные'
            ],
            'admin.permissions.hierarchy.pending' => [
                'tr' => 'Beklemede',
                'ru' => 'Ожидающие'
            ],
            'admin.permissions.hierarchy.level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень'
            ],
            'admin.permissions.hierarchy.user_count' => [
                'tr' => 'kullanıcı',
                'ru' => 'пользователь'
            ],
            'admin.permissions.hierarchy.permission_count' => [
                'tr' => 'izin',
                'ru' => 'разрешение'
            ],
            'admin.permissions.hierarchy.organization_chart' => [
                'tr' => 'Organizasyon Şeması',
                'ru' => 'Организационная Схема'
            ],
            'admin.permissions.hierarchy.role_count' => [
                'tr' => 'rol',
                'ru' => 'роль'
            ],
            'admin.permissions.hierarchy.hierarchy_matrix' => [
                'tr' => 'Hiyerarşi Matrisi',
                'ru' => 'Матрица Иерархии'
            ],
            'admin.permissions.hierarchy.parent_role' => [
                'tr' => 'Üst Rol',
                'ru' => 'Родительская Роль'
            ],
            'admin.permissions.hierarchy.child_role' => [
                'tr' => 'Alt Rol',
                'ru' => 'Дочерняя Роль'
            ],
            'admin.permissions.hierarchy.independent' => [
                'tr' => 'Bağımsız',
                'ru' => 'Независимая'
            ],
            'admin.permissions.hierarchy.roles' => [
                'tr' => 'Roller',
                'ru' => 'Роли'
            ],
            'admin.permissions.hierarchy.role_details' => [
                'tr' => 'Rol Detayları',
                'ru' => 'Детали Роли'
            ],
            'admin.permissions.hierarchy.select_role' => [
                'tr' => 'Detayları görüntülemek için bir rol seçin',
                'ru' => 'Выберите роль для просмотра деталей'
            ],
            'admin.permissions.hierarchy.restructure_hierarchy' => [
                'tr' => 'Hiyerarşiyi Yeniden Yapılandır',
                'ru' => 'Реструктурировать Иерархию'
            ],
            'admin.permissions.hierarchy.configuration_options' => [
                'tr' => 'Yapılandırma Seçenekleri',
                'ru' => 'Варианты Конфигурации'
            ],
            'admin.permissions.hierarchy.department_based' => [
                'tr' => 'Departman Bazlı',
                'ru' => 'На Основе Департаментов'
            ],
            'admin.permissions.hierarchy.organize_by_departments' => [
                'tr' => 'Departmanlara göre organize et',
                'ru' => 'Организовать по департаментам'
            ],
            'admin.permissions.hierarchy.function_based' => [
                'tr' => 'Fonksiyon Bazlı',
                'ru' => 'На Основе Функций'
            ],
            'admin.permissions.hierarchy.organize_by_functions' => [
                'tr' => 'Fonksiyonlara göre organize et',
                'ru' => 'Организовать по функциям'
            ],
            'admin.permissions.hierarchy.permission_based' => [
                'tr' => 'İzin Bazlı',
                'ru' => 'На Основе Разрешений'
            ],
            'admin.permissions.hierarchy.organize_by_permissions' => [
                'tr' => 'İzinlere göre organize et',
                'ru' => 'Организовать по разрешениям'
            ],
            'admin.permissions.hierarchy.custom_configuration' => [
                'tr' => 'Özel Yapılandırma',
                'ru' => 'Пользовательская Конфигурация'
            ],
            'admin.permissions.hierarchy.manual_hierarchy_editing' => [
                'tr' => 'Manuel hiyerarşi düzenleme',
                'ru' => 'Ручное редактирование иерархии'
            ],
            'admin.permissions.hierarchy.change_preview' => [
                'tr' => 'Değişiklik Önizlemesi',
                'ru' => 'Предварительный Просмотр Изменений'
            ],
            'admin.permissions.hierarchy.preview_description' => [
                'tr' => 'Seçilen yapılandırma türüne göre önizleme burada gösterilecek',
                'ru' => 'Здесь будет показан предварительный просмотр в соответствии с выбранным типом конфигурации'
            ],
            'admin.permissions.hierarchy.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.permissions.hierarchy.apply' => [
                'tr' => 'Uygula',
                'ru' => 'Применить'
            ],
            'admin.permissions.hierarchy.loading' => [
                'tr' => 'Yükleniyor...',
                'ru' => 'Загрузка...'
            ],
            'admin.permissions.hierarchy.role_data_failed' => [
                'tr' => 'Rol verileri yüklenemedi',
                'ru' => 'Не удалось загрузить данные роли'
            ],
            'admin.permissions.hierarchy.no_description' => [
                'tr' => 'Açıklama yok',
                'ru' => 'Нет описания'
            ],
            'admin.permissions.hierarchy.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.permissions.hierarchy.permission' => [
                'tr' => 'İzin',
                'ru' => 'Разрешение'
            ],
            'admin.permissions.hierarchy.parent_roles' => [
                'tr' => 'Üst Roller',
                'ru' => 'Родительские Роли'
            ],
            'admin.permissions.hierarchy.child_roles' => [
                'tr' => 'Alt Roller',
                'ru' => 'Дочерние Роли'
            ],
            'admin.permissions.hierarchy.view_permissions' => [
                'tr' => 'İzinleri Görüntüle',
                'ru' => 'Просмотр Разрешений'
            ],
            'admin.permissions.hierarchy.edit_role' => [
                'tr' => 'Rolü Düzenle',
                'ru' => 'Редактировать Роль'
            ],
            'admin.permissions.hierarchy.manage_users' => [
                'tr' => 'Kullanıcıları Yönet',
                'ru' => 'Управление Пользователями'
            ],
            'admin.permissions.hierarchy.restructure_confirmation' => [
                'tr' => 'Bu işlem mevcut hiyerarşiyi değiştirecek. Devam etmek istediğinizden emin misiniz?',
                'ru' => 'Эта операция изменит существующую иерархию. Вы уверены, что хотите продолжить?'
            ],
            'admin.permissions.hierarchy.yes_apply' => [
                'tr' => 'Evet, Uygula',
                'ru' => 'Да, Применить'
            ],
            'admin.permissions.hierarchy.success' => [
                'tr' => 'Başarılı',
                'ru' => 'Успешно'
            ],
            'admin.permissions.hierarchy.hierarchy_restructured' => [
                'tr' => 'Hiyerarşi başarıyla yeniden yapılandırıldı',
                'ru' => 'Иерархия успешно реструктурирована'
            ],
            'admin.permissions.hierarchy.error' => [
                'tr' => 'Hata',
                'ru' => 'Ошибка'
            ],
            'admin.permissions.hierarchy.an_error_occurred' => [
                'tr' => 'Bir hata oluştu',
                'ru' => 'Произошла ошибка'
            ],
            'admin.permissions.hierarchy.export_hierarchy' => [
                'tr' => 'Hiyerarşiyi Dışa Aktar',
                'ru' => 'Экспорт Иерархии'
            ],

            // Roles Create
            'admin.roles.create.title' => [
                'tr' => 'Yeni Rol Oluştur',
                'ru' => 'Создать Новую Роль'
            ],
            'admin.roles.create.basic_information' => [
                'tr' => 'Temel Bilgiler',
                'ru' => 'Основная Информация'
            ],
            'admin.roles.create.role_name' => [
                'tr' => 'Rol Adı',
                'ru' => 'Название Роли'
            ],
            'admin.roles.create.role_name_placeholder' => [
                'tr' => 'Örn: customer_support',
                'ru' => 'Например: customer_support'
            ],
            'admin.roles.create.role_name_help' => [
                'tr' => 'Benzersiz rol tanımlayıcısı (snake_case formatında)',
                'ru' => 'Уникальный идентификатор роли (в формате snake_case)'
            ],
            'admin.roles.create.display_name' => [
                'tr' => 'Görünen Ad',
                'ru' => 'Отображаемое Имя'
            ],
            'admin.roles.create.display_name_placeholder' => [
                'tr' => 'Örn: Müşteri Desteği',
                'ru' => 'Например: Служба Поддержки'
            ],
            'admin.roles.create.display_name_help' => [
                'tr' => 'Kullanıcı arayüzünde gösterilecek isim',
                'ru' => 'Имя, которое будет отображаться в пользовательском интерфейсе'
            ],
            'admin.roles.create.description' => [
                'tr' => 'Açıklama',
                'ru' => 'Описание'
            ],
            'admin.roles.create.description_placeholder' => [
                'tr' => 'Bu rolün sorumluluklarını açıklayın...',
                'ru' => 'Опишите обязанности этой роли...'
            ],
            'admin.roles.create.description_help' => [
                'tr' => 'Bu rolün amacını ve sorumluluklarını açıklayın',
                'ru' => 'Опишите назначение и обязанности этой роли'
            ],
            'admin.roles.create.hierarchy_settings' => [
                'tr' => 'Hiyerarşi Ayarları',
                'ru' => 'Настройки Иерархии'
            ],
            'admin.roles.create.hierarchy_level' => [
                'tr' => 'Hiyerarşi Seviyesi',
                'ru' => 'Уровень Иерархии'
            ],
            'admin.roles.create.hierarchy_level_help' => [
                'tr' => 'Düşük sayı = Üst düzey rol (0=En üst)',
                'ru' => 'Меньшее число = Роль высокого уровня (0=Высший)'
            ],
            'admin.roles.create.parent_role' => [
                'tr' => 'Üst Rol',
                'ru' => 'Родительская Роль'
            ],
            'admin.roles.create.select_parent_role' => [
                'tr' => 'Üst rol seçin (isteğe bağlı)',
                'ru' => 'Выберите родительскую роль (необязательно)'
            ],
            'admin.roles.create.parent_role_help' => [
                'tr' => 'Bu rol hangi rolün altında yer alacak?',
                'ru' => 'Под какой ролью будет находиться эта роль?'
            ],
            'admin.roles.create.additional_settings' => [
                'tr' => 'Ek Ayarlar',
                'ru' => 'Дополнительные Настройки'
            ],
            'admin.roles.create.is_active' => [
                'tr' => 'Aktif',
                'ru' => 'Активная'
            ],
            'admin.roles.create.is_active_help' => [
                'tr' => 'Bu rol aktif olarak kullanılabilir durumda olsun',
                'ru' => 'Сделать эту роль активной и доступной для использования'
            ],
            'admin.roles.create.is_system_role' => [
                'tr' => 'Sistem Rolü',
                'ru' => 'Системная Роль'
            ],
            'admin.roles.create.is_system_role_help' => [
                'tr' => 'Sistem rolleri silinemez ve kritik ayarlara sahiptir',
                'ru' => 'Системные роли нельзя удалить, они имеют критические настройки'
            ],
            'admin.roles.create.department' => [
                'tr' => 'Departman',
                'ru' => 'Департамент'
            ],
            'admin.roles.create.department_placeholder' => [
                'tr' => 'Departman adı',
                'ru' => 'Название департамента'
            ],
            'admin.roles.create.department_help' => [
                'tr' => 'Bu rolün ait olduğu departman',
                'ru' => 'Департамент, к которому принадлежит эта роль'
            ],
            'admin.roles.create.permissions_section' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.roles.create.permissions_help' => [
                'tr' => 'Bu role atanacak izinleri seçin',
                'ru' => 'Выберите разрешения, которые будут назначены этой роли'
            ],
            'admin.roles.create.select_all' => [
                'tr' => 'Tümünü Seç',
                'ru' => 'Выбрать Все'
            ],
            'admin.roles.create.deselect_all' => [
                'tr' => 'Seçimi Kaldır',
                'ru' => 'Снять Выделение'
            ],
            'admin.roles.create.form_actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.roles.create.create_role' => [
                'tr' => 'Rol Oluştur',
                'ru' => 'Создать Роль'
            ],
            'admin.roles.create.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],

            // Roles Index
            'admin.roles.index.title' => [
                'tr' => 'Rol Yönetimi',
                'ru' => 'Управление Ролями'
            ],
            'admin.roles.index.create_role' => [
                'tr' => 'Rol Oluştur',
                'ru' => 'Создать Роль'
            ],
            'admin.roles.index.import_roles' => [
                'tr' => 'İçe Aktar',
                'ru' => 'Импорт'
            ],
            'admin.roles.index.export_roles' => [
                'tr' => 'Dışa Aktar',
                'ru' => 'Экспорт'
            ],
            'admin.roles.index.total_roles' => [
                'tr' => 'Toplam Rol',
                'ru' => 'Всего Ролей'
            ],
            'admin.roles.index.active_roles' => [
                'tr' => 'Aktif Rol',
                'ru' => 'Активные Роли'
            ],
            'admin.roles.index.hierarchy_levels' => [
                'tr' => 'Hiyerarşi Seviyesi',
                'ru' => 'Уровни Иерархии'
            ],
            'admin.roles.index.system_roles' => [
                'tr' => 'Sistem Rolü',
                'ru' => 'Системные Роли'
            ],
            'admin.roles.index.search_roles' => [
                'tr' => 'Rollerde ara...',
                'ru' => 'Поиск в ролях...'
            ],
            'admin.roles.index.filter_by_department' => [
                'tr' => 'Departman',
                'ru' => 'Департамент'
            ],
            'admin.roles.index.all_departments' => [
                'tr' => 'Tüm Departmanlar',
                'ru' => 'Все Департаменты'
            ],
            'admin.roles.index.filter_by_level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень'
            ],
            'admin.roles.index.all_levels' => [
                'tr' => 'Tüm Seviyeler',
                'ru' => 'Все Уровни'
            ],
            'admin.roles.index.filter_by_status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.roles.index.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все Статусы'
            ],
            'admin.roles.index.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активные'
            ],
            'admin.roles.index.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивные'
            ],
            'admin.roles.index.view_list' => [
                'tr' => 'Liste',
                'ru' => 'Список'
            ],
            'admin.roles.index.view_grid' => [
                'tr' => 'Kart',
                'ru' => 'Карточки'
            ],
            'admin.roles.index.view_hierarchy' => [
                'tr' => 'Hiyerarşi',
                'ru' => 'Иерархия'
            ],
            'admin.roles.index.role_name' => [
                'tr' => 'Rol Adı',
                'ru' => 'Название Роли'
            ],
            'admin.roles.index.display_name' => [
                'tr' => 'Görünen Ad',
                'ru' => 'Отображаемое Имя'
            ],
            'admin.roles.index.department' => [
                'tr' => 'Departman',
                'ru' => 'Департамент'
            ],
            'admin.roles.index.level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень'
            ],
            'admin.roles.index.permissions' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.roles.index.admins' => [
                'tr' => 'Adminler',
                'ru' => 'Админы'
            ],
            'admin.roles.index.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.roles.index.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.roles.index.view' => [
                'tr' => 'Görüntüle',
                'ru' => 'Просмотр'
            ],
            'admin.roles.index.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.roles.index.permissions_action' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.roles.index.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.roles.index.system_role' => [
                'tr' => 'SİSTEM',
                'ru' => 'СИСТЕМА'
            ],
            'admin.roles.index.delete_confirmation_title' => [
                'tr' => 'Rolü Sil?',
                'ru' => 'Удалить Роль?'
            ],
            'admin.roles.index.delete_confirmation_text' => [
                'tr' => 'Bu rolü silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту роль?'
            ],
            'admin.roles.index.delete_with_admins_text' => [
                'tr' => 'Bu role sahip adminler varsayılan role geçecek.',
                'ru' => 'Админы с этой ролью будут переведены на роль по умолчанию.'
            ],
            'admin.roles.index.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, Удалить'
            ],
            'admin.roles.index.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],

            // Roles Edit
            'admin.roles.edit.title' => [
                'tr' => 'Rol Düzenle',
                'ru' => 'Редактировать Роль'
            ],
            'admin.roles.edit.editing_role' => [
                'tr' => 'Düzenleniyor',
                'ru' => 'Редактирование'
            ],
            'admin.roles.edit.basic_information' => [
                'tr' => 'Temel Bilgiler',
                'ru' => 'Основная Информация'
            ],
            'admin.roles.edit.role_name' => [
                'tr' => 'Rol Adı',
                'ru' => 'Название Роли'
            ],
            'admin.roles.edit.role_name_help' => [
                'tr' => 'Benzersiz rol tanımlayıcısı (değiştirilemez)',
                'ru' => 'Уникальный идентификатор роли (не может быть изменен)'
            ],
            'admin.roles.edit.display_name' => [
                'tr' => 'Görünen Ad',
                'ru' => 'Отображаемое Имя'
            ],
            'admin.roles.edit.display_name_placeholder' => [
                'tr' => 'Örn: Müşteri Desteği',
                'ru' => 'Например: Служба Поддержки'
            ],
            'admin.roles.edit.description' => [
                'tr' => 'Açıklama',
                'ru' => 'Описание'
            ],
            'admin.roles.edit.description_placeholder' => [
                'tr' => 'Bu rolün sorumluluklarını açıklayın...',
                'ru' => 'Опишите обязанности этой роли...'
            ],
            'admin.roles.edit.hierarchy_and_settings' => [
                'tr' => 'Hiyerarşi ve Ayarlar',
                'ru' => 'Иерархия и Настройки'
            ],
            'admin.roles.edit.hierarchy_level' => [
                'tr' => 'Hiyerarşi Seviyesi',
                'ru' => 'Уровень Иерархии'
            ],
            'admin.roles.edit.hierarchy_level_help' => [
                'tr' => 'Düşük sayı = Üst düzey rol (0=En üst)',
                'ru' => 'Меньшее число = Роль высокого уровня (0=Высший)'
            ],
            'admin.roles.edit.parent_role' => [
                'tr' => 'Üst Rol',
                'ru' => 'Родительская Роль'
            ],
            'admin.roles.edit.select_parent_role' => [
                'tr' => 'Üst rol seçin (isteğe bağlı)',
                'ru' => 'Выберите родительскую роль (необязательно)'
            ],
            'admin.roles.edit.is_active' => [
                'tr' => 'Aktif Durum',
                'ru' => 'Активное Состояние'
            ],
            'admin.roles.edit.is_active_help' => [
                'tr' => 'Bu rol aktif olarak kullanılabilir durumda olsun',
                'ru' => 'Сделать эту роль активной и доступной для использования'
            ],
            'admin.roles.edit.is_system_role' => [
                'tr' => 'Sistem Rolü',
                'ru' => 'Системная Роль'
            ],
            'admin.roles.edit.is_system_role_help' => [
                'tr' => 'Sistem rolleri kritik ayarlara sahiptir',
                'ru' => 'Системные роли имеют критические настройки'
            ],
            'admin.roles.edit.department' => [
                'tr' => 'Departman',
                'ru' => 'Департамент'
            ],
            'admin.roles.edit.department_placeholder' => [
                'tr' => 'Departman adı',
                'ru' => 'Название департамента'
            ],
            'admin.roles.edit.current_statistics' => [
                'tr' => 'Mevcut İstatistikler',
                'ru' => 'Текущая Статистика'
            ],
            'admin.roles.edit.assigned_admins' => [
                'tr' => 'Atanmış Admin',
                'ru' => 'Назначенные Админы'
            ],
            'admin.roles.edit.granted_permissions' => [
                'tr' => 'Verilen İzin',
                'ru' => 'Предоставленные Разрешения'
            ],
            'admin.roles.edit.child_roles' => [
                'tr' => 'Alt Rol',
                'ru' => 'Дочерние Роли'
            ],
            'admin.roles.edit.last_updated' => [
                'tr' => 'Son Güncellenme',
                'ru' => 'Последнее Обновление'
            ],
            'admin.roles.edit.permissions_section' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.roles.edit.permissions_help' => [
                'tr' => 'Bu role atanacak izinleri seçin',
                'ru' => 'Выберите разрешения, которые будут назначены этой роли'
            ],
            'admin.roles.edit.select_all' => [
                'tr' => 'Tümünü Seç',
                'ru' => 'Выбрать Все'
            ],
            'admin.roles.edit.deselect_all' => [
                'tr' => 'Seçimi Kaldır',
                'ru' => 'Снять Выделение'
            ],
            'admin.roles.edit.form_actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.roles.edit.update_role' => [
                'tr' => 'Rolü Güncelle',
                'ru' => 'Обновить Роль'
            ],
            'admin.roles.edit.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],

            // Roles Show
            'admin.roles.show.description' => [
                'tr' => 'Rol detayları ve izin yapısı',
                'ru' => 'Детали роли и структура разрешений'
            ],
            'admin.roles.show.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активная'
            ],
            'admin.roles.show.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивная'
            ],
            'admin.roles.show.level' => [
                'tr' => 'Seviye',
                'ru' => 'Уровень'
            ],
            'admin.roles.show.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.roles.show.back' => [
                'tr' => 'Geri',
                'ru' => 'Назад'
            ],
            'admin.roles.show.total_admins' => [
                'tr' => 'Toplam Admin',
                'ru' => 'Всего Админов'
            ],
            'admin.roles.show.permission_count' => [
                'tr' => 'İzin Sayısı',
                'ru' => 'Количество Разрешений'
            ],
            'admin.roles.show.child_roles' => [
                'tr' => 'Alt Roller',
                'ru' => 'Дочерние Роли'
            ],
            'admin.roles.show.created' => [
                'tr' => 'Oluşturulma',
                'ru' => 'Создание'
            ],
            'admin.roles.show.granted' => [
                'tr' => 'verilen',
                'ru' => 'предоставлено'
            ],
            'admin.roles.show.and_others' => [
                'tr' => 've :count diğer',
                'ru' => 'и еще :count'
            ],
            'admin.roles.show.no_child_roles' => [
                'tr' => 'Alt rol yok',
                'ru' => 'Нет дочерних ролей'
            ],
            'admin.roles.show.role_information' => [
                'tr' => 'Rol Bilgileri',
                'ru' => 'Информация о Роли'
            ],
            'admin.roles.show.role_name' => [
                'tr' => 'Rol Adı',
                'ru' => 'Название Роли'
            ],
            'admin.roles.show.display_name' => [
                'tr' => 'Görünen Ad',
                'ru' => 'Отображаемое Имя'
            ],
            'admin.roles.show.description_label' => [
                'tr' => 'Açıklama',
                'ru' => 'Описание'
            ],
            'admin.roles.show.no_description' => [
                'tr' => 'Açıklama yok',
                'ru' => 'Нет описания'
            ],
            'admin.roles.show.hierarchy_level' => [
                'tr' => 'Hiyerarşi Seviyesi',
                'ru' => 'Уровень Иерархии'
            ],
            'admin.roles.show.department' => [
                'tr' => 'Departman',
                'ru' => 'Департамент'
            ],
            'admin.roles.show.not_specified' => [
                'tr' => 'Belirtilmemiş',
                'ru' => 'Не указано'
            ],
            'admin.roles.show.parent_role' => [
                'tr' => 'Üst Rol',
                'ru' => 'Родительская Роль'
            ],
            'admin.roles.show.permissions' => [
                'tr' => 'İzinler',
                'ru' => 'Разрешения'
            ],
            'admin.roles.show.only_granted_permissions' => [
                'tr' => 'Sadece Verilen İzinler',
                'ru' => 'Только Предоставленные Разрешения'
            ],
            'admin.roles.show.show_all_permissions' => [
                'tr' => 'Tüm İzinleri Göster',
                'ru' => 'Показать Все Разрешения'
            ],
            'admin.roles.show.no_permissions_assigned' => [
                'tr' => 'Bu role henüz izin atanmamış',
                'ru' => 'Этой роли еще не назначены разрешения'
            ],
            'admin.roles.show.add_permission' => [
                'tr' => 'İzin Ekle',
                'ru' => 'Добавить Разрешение'
            ],
            'admin.roles.show.hierarchy' => [
                'tr' => 'Hiyerarşi',
                'ru' => 'Иерархия'
            ],
            'admin.roles.show.admins' => [
                'tr' => 'admin',
                'ru' => 'админ'
            ],
            'admin.roles.show.and_other_child_roles' => [
                'tr' => 've :count diğer alt rol...',
                'ru' => 'и еще :count дочерних ролей...'
            ],
            'admin.roles.show.no_hierarchy_connection' => [
                'tr' => 'Hiyerarşi bağlantısı yok',
                'ru' => 'Нет иерархических связей'
            ],
            'admin.roles.show.admins_in_role' => [
                'tr' => 'Bu Roldeki Adminler',
                'ru' => 'Админы в Этой Роли'
            ],
            'admin.roles.show.view_all' => [
                'tr' => 'Tümünü Gör',
                'ru' => 'Просмотреть Все'
            ],
            'admin.roles.show.quick_actions' => [
                'tr' => 'Hızlı İşlemler',
                'ru' => 'Быстрые Действия'
            ],
            'admin.roles.show.edit_role' => [
                'tr' => 'Rolü Düzenle',
                'ru' => 'Редактировать Роль'
            ],
            'admin.roles.show.manage_permissions' => [
                'tr' => 'İzinleri Yönet',
                'ru' => 'Управление Разрешениями'
            ],
            'admin.roles.show.add_admin' => [
                'tr' => 'Admin Ekle',
                'ru' => 'Добавить Админа'
            ],
            'admin.roles.show.delete_role' => [
                'tr' => 'Rolü Sil',
                'ru' => 'Удалить Роль'
            ],
            'admin.roles.show.delete_role_title' => [
                'tr' => 'Rolü Sil?',
                'ru' => 'Удалить Роль?'
            ],
            'admin.roles.show.delete_role_warning' => [
                'tr' => 'Bu işlem geri alınamaz. Role atanmış tüm adminler varsayılan role geçecek.',
                'ru' => 'Это действие нельзя отменить. Все админы, назначенные на эту роль, будут переведены на роль по умолчанию.'
            ],
            'admin.roles.show.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, Удалить'
            ],
            'admin.roles.show.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],

            // Tree Components
            'admin.roles.tree.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активная'
            ],
            'admin.roles.tree.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивная'
            ],
            'admin.roles.tree.admins' => [
                'tr' => 'admin',
                'ru' => 'админ'
            ],
            'admin.roles.tree.permissions' => [
                'tr' => 'izin',
                'ru' => 'разрешение'
            ],
            'admin.roles.tree.child_roles' => [
                'tr' => 'alt rol',
                'ru' => 'дочерняя роль'
            ],
            'admin.roles.tree.view_details' => [
                'tr' => 'Detayları Görüntüle',
                'ru' => 'Просмотр Деталей'
            ],
            'admin.roles.tree.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.roles.tree.manage_permissions' => [
                'tr' => 'İzinleri Yönet',
                'ru' => 'Управление Разрешениями'
            ],
            'admin.roles.tree.deactivate' => [
                'tr' => 'Pasif Yap',
                'ru' => 'Деактивировать'
            ],
            'admin.roles.tree.activate' => [
                'tr' => 'Aktif Yap',
                'ru' => 'Активировать'
            ],
            'admin.roles.tree.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.roles.tree.activate_title' => [
                'tr' => 'Rolü Aktif Yap?',
                'ru' => 'Активировать Роль?'
            ],
            'admin.roles.tree.deactivate_title' => [
                'tr' => 'Rolü Pasif Yap?',
                'ru' => 'Деактивировать Роль?'
            ],
            'admin.roles.tree.activate_message' => [
                'tr' => 'Bu rol aktif hale getirilecek ve adminler bu rolün izinlerini kullanabilecek.',
                'ru' => 'Эта роль будет активирована, и админы смогут использовать разрешения этой роли.'
            ],
            'admin.roles.tree.deactivate_message' => [
                'tr' => 'Bu rol pasif hale getirilecek ve adminler geçici olarak kısıtlanacak.',
                'ru' => 'Эта роль будет деактивирована, и админы будут временно ограничены.'
            ],
            'admin.roles.tree.yes_activate' => [
                'tr' => 'Evet, Aktif Yap',
                'ru' => 'Да, Активировать'
            ],
            'admin.roles.tree.yes_deactivate' => [
                'tr' => 'Evet, Pasif Yap',
                'ru' => 'Да, Деактивировать'
            ],
            'admin.roles.tree.cancel' => [
                'tr' => 'İptal',
                'ru' => 'Отмена'
            ],
            'admin.roles.tree.success' => [
                'tr' => 'Başarılı',
                'ru' => 'Успешно'
            ],
            'admin.roles.tree.error' => [
                'tr' => 'Hata',
                'ru' => 'Ошибка'
            ],
            'admin.roles.tree.delete_title' => [
                'tr' => 'Rolü Sil?',
                'ru' => 'Удалить Роль?'
            ],
            'admin.roles.tree.delete_message' => [
                'tr' => 'Bu işlem geri alınamaz. Rol kalıcı olarak silinecek.',
                'ru' => 'Это действие нельзя отменить. Роль будет удалена навсегда.'
            ],
            'admin.roles.tree.yes_delete' => [
                'tr' => 'Evet, Sil',
                'ru' => 'Да, Удалить'
            ],
            'admin.roles.tree.no_roles_created' => [
                'tr' => 'Henüz Rol Oluşturulmamış',
                'ru' => 'Роли Еще Не Созданы'
            ],
            'admin.roles.tree.create_first_role' => [
                'tr' => 'Hiyerarşik rol yapısını oluşturmak için ilk rolü ekleyin.',
                'ru' => 'Добавьте первую роль для создания иерархической структуры ролей.'
            ],
            'admin.roles.tree.create_first_role_button' => [
                'tr' => 'İlk Rolü Oluştur',
                'ru' => 'Создать Первую Роль'
            ],
        ];

        foreach ($phrases as $key => $translations) {
            $phrase = Phrase::firstOrCreate([
                'key' => $key,
                'group' => 'admin'
            ]);

            foreach ($translations as $languageCode => $translation) {
                $languageId = $languageCode === 'tr' ? 1 : ($languageCode === 'ru' ? 2 : 1);
                
                PhraseTranslation::updateOrCreate([
                    'phrase_id' => $phrase->id,
                    'language_id' => $languageId
                ], [
                    'translation' => $translation
                ]);
            }
        }

        $this->command->info('Permissions & Roles blade phrases seeded successfully!');
        $this->command->info('Total phrases created: ' . count($phrases));
    }
}