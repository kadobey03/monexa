<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;

class PlansBladePhrasesSeeder extends Seeder
{
    public function run()
    {
        $phrases = [
            // Common Plans Module phrases
            'admin.plans.investment_plans' => [
                'tr' => 'Yatırım Planları',
                'ru' => 'Инвестиционные планы'
            ],
            'admin.plans.system_plans' => [
                'tr' => 'Sistem Planları',
                'ru' => 'Системные планы'
            ],
            'admin.plans.view_and_manage_all_plans' => [
                'tr' => 'Tüm yatırım planlarını görüntüleyin ve yönetin',
                'ru' => 'Просмотр и управление всеми инвестиционными планами'
            ],
            'admin.plans.view_and_manage_plans' => [
                'tr' => 'Yatırım planlarını görüntüleyin ve yönetin',
                'ru' => 'Просмотр и управление инвестиционными планами'
            ],
            'admin.plans.plan_categories' => [
                'tr' => 'Plan Kategorileri',
                'ru' => 'Категории планов'
            ],
            'admin.plans.add_new_plan' => [
                'tr' => 'Yeni Plan Ekle',
                'ru' => 'Добавить новый план'
            ],
            'admin.plans.new_plan' => [
                'tr' => 'Yeni Plan',
                'ru' => 'Новый план'
            ],
            'admin.plans.total_plans' => [
                'tr' => 'Toplam Plan',
                'ru' => 'Всего планов'
            ],
            'admin.plans.active_plans' => [
                'tr' => 'Aktif Plan',
                'ru' => 'Активные планы'
            ],
            'admin.plans.featured_plans' => [
                'tr' => 'Öne Çıkan',
                'ru' => 'Рекомендуемые'
            ],
            'admin.plans.inactive_plans' => [
                'tr' => 'Pasif Plan',
                'ru' => 'Неактивные планы'
            ],
            'admin.plans.plan_list' => [
                'tr' => 'Plan Listesi',
                'ru' => 'Список планов'
            ],
            'admin.plans.search_plans_placeholder' => [
                'tr' => 'Plan ara...',
                'ru' => 'Поиск плана...'
            ],
            'admin.plans.plan_name' => [
                'tr' => 'Plan Adı',
                'ru' => 'Название плана'
            ],
            'admin.plans.category' => [
                'tr' => 'Kategori',
                'ru' => 'Категория'
            ],
            'admin.plans.price_range' => [
                'tr' => 'Fiyat Aralığı',
                'ru' => 'Диапазон цен'
            ],
            'admin.plans.roi_rate' => [
                'tr' => 'Getiri Oranı',
                'ru' => 'Доходность'
            ],
            'admin.plans.duration' => [
                'tr' => 'Süre',
                'ru' => 'Длительность'
            ],
            'admin.plans.status' => [
                'tr' => 'Durum',
                'ru' => 'Статус'
            ],
            'admin.plans.featured' => [
                'tr' => 'Öne Çıkan',
                'ru' => 'Рекомендуемый'
            ],
            'admin.plans.actions' => [
                'tr' => 'İşlemler',
                'ru' => 'Действия'
            ],
            'admin.plans.no_category' => [
                'tr' => 'Kategori Yok',
                'ru' => 'Нет категории'
            ],
            'admin.plans.active' => [
                'tr' => 'Aktif',
                'ru' => 'Активный'
            ],
            'admin.plans.inactive' => [
                'tr' => 'Pasif',
                'ru' => 'Неактивный'
            ],
            'admin.plans.no' => [
                'tr' => 'Hayır',
                'ru' => 'Нет'
            ],
            'admin.plans.edit' => [
                'tr' => 'Düzenle',
                'ru' => 'Редактировать'
            ],
            'admin.plans.delete' => [
                'tr' => 'Sil',
                'ru' => 'Удалить'
            ],
            'admin.plans.confirm_delete_plan' => [
                'tr' => 'Bu planı silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить этот план?'
            ],
            'admin.plans.no_investment_plans_found' => [
                'tr' => 'Yatırım Planı Bulunamadı',
                'ru' => 'Инвестиционные планы не найдены'
            ],
            'admin.plans.no_plans_created_yet' => [
                'tr' => 'Henüz hiç yatırım planı oluşturulmamış.',
                'ru' => 'Инвестиционные планы еще не созданы.'
            ],
            'admin.plans.create_first_plan' => [
                'tr' => 'İlk Planı Oluştur',
                'ru' => 'Создать первый план'
            ],

            // Plans.blade.php specific phrases
            'admin.plans.minimum_investment' => [
                'tr' => 'Minimum Yatırım',
                'ru' => 'Минимальная инвестиция'
            ],
            'admin.plans.maximum_investment' => [
                'tr' => 'Maksimum Yatırım',
                'ru' => 'Максимальная инвестиция'
            ],
            'admin.plans.return_rate' => [
                'tr' => 'Getiri Oranı',
                'ru' => 'Доходность'
            ],
            'admin.plans.gift_bonus' => [
                'tr' => 'Hediye Bonus',
                'ru' => 'Подарочный бонус'
            ],
            'admin.plans.no_plans_yet' => [
                'tr' => 'Henüz Plan Yok',
                'ru' => 'Планов пока нет'
            ],
            'admin.plans.no_investment_plans_currently' => [
                'tr' => 'Şu anda sistemde hiç yatırım planı bulunmuyor.',
                'ru' => 'В настоящее время в системе нет инвестиционных планов.'
            ],

            // Create.blade.php phrases
            'admin.plans.create_investment_plan' => [
                'tr' => 'Yatırım Planı Oluştur',
                'ru' => 'Создать инвестиционный план'
            ],
            'admin.plans.create_new_investment_plan' => [
                'tr' => 'Yeni Yatırım Planı Oluştur',
                'ru' => 'Создать новый инвестиционный план'
            ],
            'admin.plans.back_to_plans' => [
                'tr' => 'Planlara Geri Dön',
                'ru' => 'Вернуться к планам'
            ],
            'admin.plans.select_category' => [
                'tr' => 'Kategori Seçin',
                'ru' => 'Выберите категорию'
            ],
            'admin.plans.no_categories_found_create_first' => [
                'tr' => 'Kategori bulunamadı. Önce bir kategori oluşturun',
                'ru' => 'Категории не найдены. Сначала создайте категорию'
            ],
            'admin.plans.plan_icon_optional' => [
                'tr' => 'Plan İkonu (İsteğe bağlı)',
                'ru' => 'Икона плана (необязательно)'
            ],
            'admin.plans.recommended_size_64x64' => [
                'tr' => 'Önerilen boyut: 64x64px',
                'ru' => 'Рекомендуемый размер: 64x64px'
            ],
            'admin.plans.minimum_investment_required' => [
                'tr' => 'Minimum Yatırım *',
                'ru' => 'Минимальная инвестиция *'
            ],
            'admin.plans.maximum_investment_required' => [
                'tr' => 'Maksimum Yatırım *',
                'ru' => 'Максимальная инвестиция *'
            ],
            'admin.plans.roi_percentage' => [
                'tr' => 'Getiri Yüzdesi',
                'ru' => 'Процент доходности'
            ],
            'admin.plans.roi_interval' => [
                'tr' => 'Getiri Aralığı',
                'ru' => 'Интервал доходности'
            ],
            'admin.plans.hourly' => [
                'tr' => 'Saatlik',
                'ru' => 'Почасовой'
            ],
            'admin.plans.daily' => [
                'tr' => 'Günlük',
                'ru' => 'Дневной'
            ],
            'admin.plans.weekly' => [
                'tr' => 'Haftalık',
                'ru' => 'Еженедельный'
            ],
            'admin.plans.monthly' => [
                'tr' => 'Aylık',
                'ru' => 'Месячный'
            ],
            'admin.plans.plan_duration' => [
                'tr' => 'Plan Süresi',
                'ru' => 'Длительность плана'
            ],
            'admin.plans.hours' => [
                'tr' => 'Saat',
                'ru' => 'Часы'
            ],
            'admin.plans.days' => [
                'tr' => 'Gün',
                'ru' => 'Дни'
            ],
            'admin.plans.weeks' => [
                'tr' => 'Hafta',
                'ru' => 'Недели'
            ],
            'admin.plans.months' => [
                'tr' => 'Ay',
                'ru' => 'Месяцы'
            ],
            'admin.plans.featured_plan' => [
                'tr' => 'Öne Çıkan Plan',
                'ru' => 'Рекомендуемый план'
            ],
            'admin.plans.plan_description' => [
                'tr' => 'Plan Açıklaması',
                'ru' => 'Описание плана'
            ],
            'admin.plans.create_plan' => [
                'tr' => 'Plan Oluştur',
                'ru' => 'Создать план'
            ],

            // Edit.blade.php phrases
            'admin.plans.edit_investment_plan' => [
                'tr' => 'Yatırım Planı Düzenle',
                'ru' => 'Редактировать инвестиционный план'
            ],
            'admin.plans.update_plan' => [
                'tr' => 'Planı Güncelle',
                'ru' => 'Обновить план'
            ],
            'admin.plans.leave_empty_to_keep_current_icon' => [
                'tr' => 'Mevcut ikonu korumak için boş bırakın.',
                'ru' => 'Оставьте пустым, чтобы сохранить текущую иконку.'
            ],
            'admin.plans.plan_features' => [
                'tr' => 'Plan Özellikleri',
                'ru' => 'Особенности плана'
            ],
            'admin.plans.add_new_feature' => [
                'tr' => 'Yeni Özellik Ekle',
                'ru' => 'Добавить новую функцию'
            ],
            'admin.plans.feature_text' => [
                'tr' => 'Özellik Metni',
                'ru' => 'Текст функции'
            ],
            'admin.plans.add_feature' => [
                'tr' => 'Özellik Ekle',
                'ru' => 'Добавить функцию'
            ],
            'admin.plans.feature' => [
                'tr' => 'Özellik',
                'ru' => 'Функция'
            ],
            'admin.plans.no_features_added_yet' => [
                'tr' => 'Henüz özellik eklenmedi.',
                'ru' => 'Функции еще не добавлены.'
            ],
            'admin.plans.edit_feature' => [
                'tr' => 'Özellik Düzenle',
                'ru' => 'Редактировать функцию'
            ],
            'admin.plans.close' => [
                'tr' => 'Kapat',
                'ru' => 'Закрыть'
            ],
            'admin.plans.save_changes' => [
                'tr' => 'Değişiklikleri Kaydet',
                'ru' => 'Сохранить изменения'
            ],
            'admin.plans.confirm_delete_feature' => [
                'tr' => 'Bu özelliği silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту функцию?'
            ],

            // Categories.blade.php phrases
            'admin.plans.add_new_category' => [
                'tr' => 'Yeni Kategori Ekle',
                'ru' => 'Добавить новую категорию'
            ],
            'admin.plans.category_name' => [
                'tr' => 'Kategori Adı',
                'ru' => 'Название категории'
            ],
            'admin.plans.description_optional' => [
                'tr' => 'Açıklama (İsteğe bağlı)',
                'ru' => 'Описание (необязательно)'
            ],
            'admin.plans.add_category' => [
                'tr' => 'Kategori Ekle',
                'ru' => 'Добавить категорию'
            ],
            'admin.plans.plan_categories' => [
                'tr' => 'Plan Kategorileri',
                'ru' => 'Категории планов'
            ],
            'admin.plans.name' => [
                'tr' => 'İsim',
                'ru' => 'Название'
            ],
            'admin.plans.description' => [
                'tr' => 'Açıklama',
                'ru' => 'Описание'
            ],
            'admin.plans.plans' => [
                'tr' => 'Planlar',
                'ru' => 'Планы'
            ],
            'admin.plans.no_description' => [
                'tr' => 'Açıklama yok',
                'ru' => 'Нет описания'
            ],
            'admin.plans.confirm_delete_category' => [
                'tr' => 'Bu kategoriyi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту категорию?'
            ],

            // NewPlan.blade.php phrases
            'admin.plans.add_investment_plan' => [
                'tr' => 'Yatırım Planı Ekle',
                'ru' => 'Добавить инвестиционный план'
            ],
            'admin.plans.create_and_configure_new_plan' => [
                'tr' => 'Yeni yatırım planı oluşturun ve yapılandırın',
                'ru' => 'Создайте и настройте новый инвестиционный план'
            ],
            'admin.plans.go_back' => [
                'tr' => 'Geri Dön',
                'ru' => 'Вернуться'
            ],
            'admin.plans.plan_details' => [
                'tr' => 'Plan Detayları',
                'ru' => 'Детали плана'
            ],
            'admin.plans.enter_basic_plan_information' => [
                'tr' => 'Yatırım planının temel bilgilerini girin',
                'ru' => 'Введите основную информацию об инвестиционном плане'
            ],
            'admin.plans.enter_plan_name' => [
                'tr' => 'Plan adını girin',
                'ru' => 'Введите название плана'
            ],
            'admin.plans.plan_price_currency' => [
                'tr' => 'Plan Fiyatı (:currency)',
                'ru' => 'Цена плана (:currency)'
            ],
            'admin.plans.enter_plan_price' => [
                'tr' => 'Plan fiyatını girin',
                'ru' => 'Введите цену плана'
            ],
            'admin.plans.maximum_investment_amount_description' => [
                'tr' => 'Bu planda kullanıcıların yatırım yapabileceği maksimum tutar',
                'ru' => 'Максимальная сумма, которую пользователи могут инвестировать в этот план'
            ],
            'admin.plans.minimum_price_currency' => [
                'tr' => 'Minimum Fiyat (:currency)',
                'ru' => 'Минимальная цена (:currency)'
            ],
            'admin.plans.enter_minimum_amount' => [
                'tr' => 'Minimum tutarı girin',
                'ru' => 'Введите минимальную сумму'
            ],
            'admin.plans.minimum_investment_amount_description' => [
                'tr' => 'Bu planda yatırım yapılabilecek minimum tutar',
                'ru' => 'Минимальная сумма, которую можно инвестировать в этот план'
            ],
            'admin.plans.maximum_price_currency' => [
                'tr' => 'Maksimum Fiyat (:currency)',
                'ru' => 'Максимальная цена (:currency)'
            ],
            'admin.plans.enter_maximum_amount' => [
                'tr' => 'Maksimum tutarı girin',
                'ru' => 'Введите максимальную сумму'
            ],
            'admin.plans.same_as_plan_price_no_decimals' => [
                'tr' => 'Plan fiyatı ile aynı, virgüllü rakam kullanmayın',
                'ru' => 'То же, что и цена плана, не используйте десятичные числа'
            ],
            'admin.plans.minimum_return_percentage' => [
                'tr' => 'Minimum Getiri (%)',
                'ru' => 'Минимальная доходность (%)'
            ],
            'admin.plans.enter_minimum_return_rate' => [
                'tr' => 'Minimum getiri oranını girin',
                'ru' => 'Введите минимальную доходность'
            ],
            'admin.plans.minimum_roi_description' => [
                'tr' => 'Bu plan için minimum getiri oranı (ROI)',
                'ru' => 'Минимальная доходность (ROI) для этого плана'
            ],
            'admin.plans.maximum_return_percentage' => [
                'tr' => 'Maksimum Getiri (%)',
                'ru' => 'Максимальная доходность (%)'
            ],
            'admin.plans.enter_maximum_return_rate' => [
                'tr' => 'Maksimum getiri oranını girin',
                'ru' => 'Введите максимальную доходность'
            ],
            'admin.plans.maximum_roi_description' => [
                'tr' => 'Bu plan için maksimum getiri oranı (ROI)',
                'ru' => 'Максимальная доходность (ROI) для этого плана'
            ],
            'admin.plans.gift_bonus_currency' => [
                'tr' => 'Hediye Bonus (:currency)',
                'ru' => 'Подарочный бонус (:currency)'
            ],
            'admin.plans.enter_additional_bonus' => [
                'tr' => 'Ek bonus tutarını girin',
                'ru' => 'Введите сумму дополнительного бонуса'
            ],
            'admin.plans.optional_bonus_description' => [
                'tr' => 'Bu planı satın alan kullanıcıya verilecek isteğe bağlı bonus',
                'ru' => 'Дополнительный бонус для пользователей, покупающих этот план'
            ],
            'admin.plans.plan_tag' => [
                'tr' => 'Plan Etiketi',
                'ru' => 'Тег плана'
            ],
            'admin.plans.example_popular_vip_recommended' => [
                'tr' => 'Örn: Popüler, VIP, Önerilen',
                'ru' => 'Например: Популярный, VIP, Рекомендуемый'
            ],
            'admin.plans.optional_plan_tag_description' => [
                'tr' => 'İsteğe bağlı plan etiketi (Popüler, VIP vb.)',
                'ru' => 'Дополнительный тег плана (Популярный, VIP и т.д.)'
            ],
            'admin.plans.investment_type' => [
                'tr' => 'Yatırım Türü',
                'ru' => 'Тип инвестиций'
            ],
            'admin.plans.select_investment_type' => [
                'tr' => 'Yatırım türünü seçin',
                'ru' => 'Выберите тип инвестиций'
            ],
            'admin.plans.stock' => [
                'tr' => 'Hisse Senedi',
                'ru' => 'Акции'
            ],
            'admin.plans.crypto' => [
                'tr' => 'Kripto Para',
                'ru' => 'Криптовалюта'
            ],
            'admin.plans.real_estate' => [
                'tr' => 'Emlak',
                'ru' => 'Недвижимость'
            ],
            'admin.plans.investment_type_description' => [
                'tr' => 'Bu planın temsil ettiği yatırım türü',
                'ru' => 'Тип инвестиций, который представляет этот план'
            ],
            'admin.plans.payment_interval' => [
                'tr' => 'Ödeme Aralığı',
                'ru' => 'Интервал выплат'
            ],
            'admin.plans.profit_frequency_description' => [
                'tr' => 'Sistemin ne sıklıkla kar ekleyeceğini belirtir',
                'ru' => 'Указывает, как часто система будет добавлять прибыль'
            ],
            'admin.plans.payment_type' => [
                'tr' => 'Ödeme Türü',
                'ru' => 'Тип выплаты'
            ],
            'admin.plans.percentage' => [
                'tr' => 'Yüzde',
                'ru' => 'Процент'
            ],
            'admin.plans.fixed' => [
                'tr' => 'Sabit',
                'ru' => 'Фиксированный'
            ],
            'admin.plans.percentage_or_fixed_description' => [
                'tr' => 'Karın yüzde (%) mi sabit tutar mı olacağını belirtir',
                'ru' => 'Указывает, будет ли прибыль в процентах (%) или фиксированной сумме'
            ],
            'admin.plans.payment_amount_currency' => [
                'tr' => 'Ödeme Tutarı (% veya :currency)',
                'ru' => 'Сумма выплаты (% или :currency)'
            ],
            'admin.plans.enter_payment_amount' => [
                'tr' => 'Ödeme tutarını girin',
                'ru' => 'Введите сумму выплаты'
            ],
            'admin.plans.profit_amount_description' => [
                'tr' => 'Yukarıda seçilen türe göre kar olarak eklenecek tutar',
                'ru' => 'Сумма, которая будет добавлена как прибыль согласно выбранному выше типу'
            ],
            'admin.plans.investment_duration' => [
                'tr' => 'Yatırım Süresi',
                'ru' => 'Длительность инвестиций'
            ],
            'admin.plans.example_1_days_2_weeks' => [
                'tr' => 'Örn: 1 Days, 2 Weeks, 1 Months',
                'ru' => 'Например: 1 Days, 2 Weeks, 1 Months'
            ],
            'admin.plans.duration_setup_guide' => [
                'tr' => 'Süre ayarlama kılavuzu',
                'ru' => 'Руководство по настройке длительности'
            ],
            'admin.plans.duration_guide_title' => [
                'tr' => 'Süre Belirleme Kılavuzu',
                'ru' => 'Руководство по определению длительности'
            ],
            'admin.plans.important_rules' => [
                'tr' => 'Önemli Kurallar:',
                'ru' => 'Важные правила:'
            ],
            'admin.plans.duration_rule_1' => [
                'tr' => 'Zaman diliminden önce mutlaka bir rakam yazın (harfle değil)',
                'ru' => 'Обязательно напишите цифру перед временным периодом (не словами)'
            ],
            'admin.plans.duration_rule_2' => [
                'tr' => 'Rakamdan sonra mutlaka boşluk bırakın',
                'ru' => 'Обязательно оставьте пробел после цифры'
            ],
            'admin.plans.duration_rule_3' => [
                'tr' => 'Zaman diliminin ilk harfi büyük olmalı ve sonuna \'s\' ekleyin',
                'ru' => 'Первая буква периода должна быть заглавной и добавьте \'s\' в конце'
            ],
            'admin.plans.correct_examples' => [
                'tr' => 'Doğru Örnekler:',
                'ru' => 'Правильные примеры:'
            ],
            'admin.plans.wrong_examples' => [
                'tr' => 'Yanlış Örnekler:',
                'ru' => 'Неправильные примеры:'
            ],
            'admin.plans.number_written_in_letters' => [
                'tr' => 'Rakam harfle yazılmış',
                'ru' => 'Число написано словами'
            ],
            'admin.plans.no_space' => [
                'tr' => 'Boşluk yok',
                'ru' => 'Нет пробела'
            ],
            'admin.plans.no_s_at_end' => [
                'tr' => 'Sonunda \'s\' yok',
                'ru' => 'Нет \'s\' в конце'
            ],
            'admin.plans.understood' => [
                'tr' => 'Anladım',
                'ru' => 'Понял'
            ],

            // EditPlan.blade.php phrases
            'admin.plans.update_plan_title' => [
                'tr' => 'Plan Güncelle',
                'ru' => 'Обновить план'
            ],
            'admin.plans.back' => [
                'tr' => 'Geri',
                'ru' => 'Назад'
            ],
            'admin.plans.maximum_investment_description' => [
                'tr' => 'Bu planda kullanıcıların yatırım yapabileceği maksimum tutar',
                'ru' => 'Максимальная сумма, которую пользователи могут инвестировать в этот план'
            ],
            'admin.plans.minimum_investment_description' => [
                'tr' => 'Bu planda kullanıcıların yatırım yapabileceği minimum tutar',
                'ru' => 'Минимальная сумма, которую пользователи могут инвестировать в этот план'
            ],
            'admin.plans.same_as_plan_price' => [
                'tr' => 'Plan fiyatı ile aynı',
                'ru' => 'То же, что и цена плана'
            ],
            'admin.plans.minimum_return_roi_description' => [
                'tr' => 'Bu plan için minimum getiri (ROI)',
                'ru' => 'Минимальная доходность (ROI) для этого плана'
            ],
            'admin.plans.maximum_return_roi_description' => [
                'tr' => 'Bu plan için maksimum getiri (ROI)',
                'ru' => 'Максимальная доходность (ROI) для этого плана'
            ],
            'admin.plans.optional_bonus_user_description' => [
                'tr' => 'Bu planı satın alan kullanıcıya verilecek isteğe bağlı bonus.',
                'ru' => 'Дополнительный бонус для пользователя, покупающего этот план.'
            ],
            'admin.plans.plan_tag_description' => [
                'tr' => 'İsteğe bağlı plan etiketi. Bu her plan için etiketlerdir örn \'Popüler\', \'VIP\' vb',
                'ru' => 'Дополнительный тег плана. Это теги для каждого плана, например \'Популярный\', \'VIP\' и т.д.'
            ],
            'admin.plans.select_investment_type_description' => [
                'tr' => 'Bu planın temsil ettiği yatırım türünü seçin',
                'ru' => 'Выберите тип инвестиций, который представляет этот план'
            ],
            'admin.plans.topup_interval' => [
                'tr' => 'Ödeme Aralığı',
                'ru' => 'Интервал пополнения'
            ],
            'admin.plans.topup_interval_description' => [
                'tr' => 'Sistemin kullanıcı hesabına ne sıklıkla kar(ROI) ekleyeceğini belirtir.',
                'ru' => 'Указывает, как часто система будет добавлять прибыль(ROI) в аккаунт пользователя.'
            ],
            'admin.plans.topup_type' => [
                'tr' => 'Ödeme Türü',
                'ru' => 'Тип пополнения'
            ],
            'admin.plans.topup_type_description' => [
                'tr' => 'Sistemin karı yüzde(%) veya sabit tutar olarak ekleyip eklemeyeceğini belirtir.',
                'ru' => 'Указывает, будет ли система добавлять прибыль в процентах(%) или фиксированной сумме.'
            ],
            'admin.plans.topup_amount' => [
                'tr' => 'Ödeme Tutarı (% veya :currency olarak yukarıda belirtilen)',
                'ru' => 'Сумма пополнения (в % или :currency как указано выше)'
            ],
            'admin.plans.topup_amount_description' => [
                'tr' => 'Bu, sistemin kullanıcı hesabına kar olarak ekleyeceği tutardır, yukarıda seçtiğiniz ödeme türü ve ödeme aralığına göre.',
                'ru' => 'Это сумма, которую система добавит в аккаунт пользователя в качестве прибыли, на основе выбранного выше типа пополнения и интервала пополнения.'
            ],
            'admin.plans.investment_duration_guide' => [
                'tr' => 'Bu, yatırım planının ne kadar süreceğini belirtir. Lütfen yatırım süresini nasıl ayarlayacağınıza dair kılavuzu sıkı bir şekilde takip edin, aksi takdirde çalışmayabilir.',
                'ru' => 'Это указывает, как долго будет длиться инвестиционный план. Пожалуйста, строго следуйте руководству по настройке длительности инвестиций, иначе это может не сработать.'
            ],
            'admin.plans.how_to_setup_investment_duration' => [
                'tr' => 'yatırım süresini nasıl ayarlayacağınız',
                'ru' => 'как настроить длительность инвестиций'
            ],

            // ActiveInv.blade.php phrases
            'admin.plans.active_investment_plans' => [
                'tr' => 'Aktif Yatırım Planları',
                'ru' => 'Активные инвестиционные планы'
            ],
            'admin.plans.client_name' => [
                'tr' => 'Müşteri Adı',
                'ru' => 'Имя клиента'
            ],
            'admin.plans.investment_plan' => [
                'tr' => 'Yatırım Planı',
                'ru' => 'Инвестиционный план'
            ],
            'admin.plans.amount_invested' => [
                'tr' => 'Yatırım Miktarı',
                'ru' => 'Сумма инвестиций'
            ],
            'admin.plans.roi' => [
                'tr' => 'ROI',
                'ru' => 'ROI'
            ],
            'admin.plans.start_date' => [
                'tr' => 'Başlangıç Tarihi',
                'ru' => 'Дата начала'
            ],
            'admin.plans.expiration_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата окончания'
            ],
            'admin.plans.action' => [
                'tr' => 'İşlem',
                'ru' => 'Действие'
            ],
            'admin.plans.more_actions' => [
                'tr' => 'Daha Fazla İşlem',
                'ru' => 'Больше действий'
            ],

            // Investment.blade.php phrases
            'admin.plans.active_customer_transactions' => [
                'tr' => 'Aktif Müşteri İşlemleri',
                'ru' => 'Активные транзакции клиентов'
            ],
            'admin.plans.view_customer_investments_active_transactions' => [
                'tr' => 'Müşteri yatırımlarını ve aktif işlemlerini görüntüleyin',
                'ru' => 'Просмотр инвестиций клиентов и активных транзакций'
            ],
            'admin.plans.total_active_transactions' => [
                'tr' => 'Toplam Aktif İşlem',
                'ru' => 'Всего активных транзакций'
            ],
            'admin.plans.total_investment' => [
                'tr' => 'Toplam Yatırım',
                'ru' => 'Общие инвестиции'
            ],
            'admin.plans.total_profit' => [
                'tr' => 'Toplam Kâr',
                'ru' => 'Общая прибыль'
            ],
            'admin.plans.active_users' => [
                'tr' => 'Aktif Kullanıcı',
                'ru' => 'Активные пользователи'
            ],
            'admin.plans.active_investment_transactions' => [
                'tr' => 'Aktif Yatırım İşlemleri',
                'ru' => 'Активные инвестиционные транзакции'
            ],
            'admin.plans.search_placeholder' => [
                'tr' => 'Arama...',
                'ru' => 'Поиск...'
            ],
            'admin.plans.assets' => [
                'tr' => 'Varlıklar',
                'ru' => 'Активы'
            ],
            'admin.plans.investment_amount' => [
                'tr' => 'Yatırım Miktarı',
                'ru' => 'Сумма инвестиций'
            ],
            'admin.plans.profit_return' => [
                'tr' => 'Kâr Getirisi',
                'ru' => 'Прибыль'
            ],
            'admin.plans.end_date' => [
                'tr' => 'Bitiş Tarihi',
                'ru' => 'Дата окончания'
            ],
            'admin.plans.user_deleted' => [
                'tr' => 'Kullanıcı Silindi',
                'ru' => 'Пользователь удален'
            ],
            'admin.plans.confirm_delete_transaction' => [
                'tr' => 'Bu işlemi silmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите удалить эту транзакцию?'
            ],
            'admin.plans.user_details' => [
                'tr' => 'Kullanıcı Detayları',
                'ru' => 'Детали пользователя'
            ],
            'admin.plans.no_active_transactions_found' => [
                'tr' => 'Aktif İşlem Bulunamadı',
                'ru' => 'Активные транзакции не найдены'
            ],
            'admin.plans.no_active_investment_transactions' => [
                'tr' => 'Şu anda hiç aktif yatırım işlemi bulunmuyor.',
                'ru' => 'В настоящее время нет активных инвестиционных транзакций.'
            ],

            // Loans.blade.php phrases
            'admin.plans.requested_loans' => [
                'tr' => 'Talep Edilen Krediler',
                'ru' => 'Запрошенные кредиты'
            ],
            'admin.plans.amount_requested' => [
                'tr' => 'Talep Edilen Miktar',
                'ru' => 'Запрошенная сумма'
            ],
            'admin.plans.purpose' => [
                'tr' => 'Amaç',
                'ru' => 'Цель'
            ],
            'admin.plans.credit_facility' => [
                'tr' => 'Kredi Kolaylığı',
                'ru' => 'Кредитная линия'
            ],
            'admin.plans.date' => [
                'tr' => 'Tarih',
                'ru' => 'Дата'
            ],
            'admin.plans.pending' => [
                'tr' => 'Bekleyen',
                'ru' => 'В ожидании'
            ],
            'admin.plans.mark_as_paid' => [
                'tr' => 'Ödenmiş Olarak İşaretle',
                'ru' => 'Отметить как оплаченный'
            ],
            'admin.plans.mark_as_unpaid' => [
                'tr' => 'Ödenmemiş Olarak İşaretle',
                'ru' => 'Отметить как неоплаченный'
            ],

            // User Plan Details phrases
            'admin.plans.plan_investment_details' => [
                'tr' => 'Plan Yatırım Detayları',
                'ru' => 'Детали инвестиций в план'
            ],
            'admin.plans.investment_details' => [
                'tr' => 'Yatırım Detayları',
                'ru' => 'Детали инвестиций'
            ],
            'admin.plans.back_to_user_plans' => [
                'tr' => 'Kullanıcı Planlarına Dön',
                'ru' => 'Вернуться к планам пользователей'
            ],
            'admin.plans.investment_id' => [
                'tr' => 'Yatırım ID',
                'ru' => 'ID инвестиций'
            ],
            'admin.plans.investor' => [
                'tr' => 'Yatırımcı',
                'ru' => 'Инвестор'
            ],
            'admin.plans.user_not_found' => [
                'tr' => 'Kullanıcı bulunamadı',
                'ru' => 'Пользователь не найден'
            ],
            'admin.plans.not_available' => [
                'tr' => 'N/A',
                'ru' => 'Н/Д'
            ],
            'admin.plans.roi_per_interval' => [
                'tr' => ':percentage% per :interval',
                'ru' => ':percentage% за :interval'
            ],
            'admin.plans.completed' => [
                'tr' => 'Tamamlandı',
                'ru' => 'Завершено'
            ],
            'admin.plans.cancelled' => [
                'tr' => 'İptal Edildi',
                'ru' => 'Отменено'
            ],
            'admin.plans.not_started_yet' => [
                'tr' => 'Henüz başlamadı',
                'ru' => 'Еще не начато'
            ],
            'admin.plans.not_determined_yet' => [
                'tr' => 'Henüz belirlenmedi',
                'ru' => 'Еще не определено'
            ],
            'admin.plans.created' => [
                'tr' => 'Oluşturuldu',
                'ru' => 'Создано'
            ],
            'admin.plans.last_roi_payment' => [
                'tr' => 'Son ROI Ödemesi',
                'ru' => 'Последний платеж ROI'
            ],
            'admin.plans.no_roi_payment_yet' => [
                'tr' => 'Henüz ROI ödemesi yok',
                'ru' => 'Еще нет платежей ROI'
            ],
            'admin.plans.total_payouts' => [
                'tr' => 'Toplam Ödemeler',
                'ru' => 'Общие выплаты'
            ],
            'admin.plans.cancellation_reason' => [
                'tr' => 'İptal Nedeni',
                'ru' => 'Причина отмены'
            ],
            'admin.plans.no_reason_provided' => [
                'tr' => 'Neden belirtilmedi',
                'ru' => 'Причина не указана'
            ],
            'admin.plans.cancelled_at' => [
                'tr' => 'İptal Tarihi',
                'ru' => 'Дата отмены'
            ],
            'admin.plans.completed_at' => [
                'tr' => 'Tamamlanma Tarihi',
                'ru' => 'Дата завершения'
            ],
            'admin.plans.approve_investment' => [
                'tr' => 'Yatırımı Onayla',
                'ru' => 'Одобрить инвестицию'
            ],
            'admin.plans.investment_waiting_approval' => [
                'tr' => 'Bu yatırım onayınızı bekliyor.',
                'ru' => 'Эта инвестиция ожидает вашего одобрения.'
            ],
            'admin.plans.confirm_approve_investment' => [
                'tr' => 'Bu yatırımı onaylamak istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите одобрить эту инвестицию?'
            ],
            'admin.plans.approve_investment_button' => [
                'tr' => 'Yatırımı Onayla',
                'ru' => 'Одобрить инвестицию'
            ],
            'admin.plans.cancel_investment' => [
                'tr' => 'Yatırımı İptal Et',
                'ru' => 'Отменить инвестицию'
            ],
            'admin.plans.confirm_cancel_investment' => [
                'tr' => 'Bu yatırımı iptal etmek istediğinizden emin misiniz?',
                'ru' => 'Вы уверены, что хотите отменить эту инвестицию?'
            ],
            'admin.plans.cancel_investment_button' => [
                'tr' => 'Yatırımı İptal Et',
                'ru' => 'Отменить инвестицию'
            ],
            'admin.plans.add_manual_payout' => [
                'tr' => 'Manuel Ödeme Ekle',
                'ru' => 'Добавить ручную выплату'
            ],
            'admin.plans.amount' => [
                'tr' => 'Tutar',
                'ru' => 'Сумма'
            ],
            'admin.plans.notes_optional' => [
                'tr' => 'Notlar (İsteğe bağlı)',
                'ru' => 'Заметки (необязательно)'
            ],
            'admin.plans.add_manual_payout_button' => [
                'tr' => 'Manuel Ödeme Ekle',
                'ru' => 'Добавить ручную выплату'
            ],
            'admin.plans.payout_history' => [
                'tr' => 'Ödeme Geçmişi',
                'ru' => 'История выплат'
            ],
            'admin.plans.id' => [
                'tr' => 'ID',
                'ru' => 'ID'
            ],
            'admin.plans.type' => [
                'tr' => 'Tür',
                'ru' => 'Тип'
            ],
            'admin.plans.notes' => [
                'tr' => 'Notlar',
                'ru' => 'Заметки'
            ],
            'admin.plans.roi_payment' => [
                'tr' => 'ROI Ödemesi',
                'ru' => 'Платеж ROI'
            ],
            'admin.plans.manual_payment' => [
                'tr' => 'Manuel Ödeme',
                'ru' => 'Ручная выплата'
            ],
            'admin.plans.completion_bonus' => [
                'tr' => 'Tamamlama Bonusu',
                'ru' => 'Бонус за завершение'
            ],
            'admin.plans.no_payout_history_found' => [
                'tr' => 'Ödeme geçmişi bulunamadı.',
                'ru' => 'История выплат не найдена.'
            ],

            // User Plans phrases
            'admin.plans.user_investment_plans' => [
                'tr' => 'Kullanıcı Yatırım Planları',
                'ru' => 'Инвестиционные планы пользователей'
            ],
            'admin.plans.manage_plans' => [
                'tr' => 'Planları Yönet',
                'ru' => 'Управление планами'
            ],
            'admin.plans.filter_by_status' => [
                'tr' => 'Duruma Göre Filtrele',
                'ru' => 'Фильтр по статусу'
            ],
            'admin.plans.all_statuses' => [
                'tr' => 'Tüm Durumlar',
                'ru' => 'Все статусы'
            ],
            'admin.plans.filter_by_user_id' => [
                'tr' => 'Kullanıcı ID\'sine Göre Filtrele',
                'ru' => 'Фильтр по ID пользователя'
            ],
            'admin.plans.enter_user_id' => [
                'tr' => 'Kullanıcı ID Girin',
                'ru' => 'Введите ID пользователя'
            ],
            'admin.plans.apply_filters' => [
                'tr' => 'Filtreleri Uygula',
                'ru' => 'Применить фильтры'
            ],
            'admin.plans.reset' => [
                'tr' => 'Sıfırla',
                'ru' => 'Сбросить'
            ],
            'admin.plans.user' => [
                'tr' => 'Kullanıcı',
                'ru' => 'Пользователь'
            ],
            'admin.plans.plan' => [
                'tr' => 'Plan',
                'ru' => 'План'
            ],
            'admin.plans.total_paid' => [
                'tr' => 'Toplam Ödenen',
                'ru' => 'Всего выплачено'
            ],
            'admin.plans.details' => [
                'tr' => 'Detaylar',
                'ru' => 'Детали'
            ],
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

        $this->command->info('Plans blade phrases seeded successfully! Total: ' . count($phrases) . ' phrases');
    }
}