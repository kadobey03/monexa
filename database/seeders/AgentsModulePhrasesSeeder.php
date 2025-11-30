<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class AgentsModulePhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phrases = [
                // Main Page Headers
                'admin.agents.title' => [
                    'tr' => 'Temsilci Yönetimi',
                    'ru' => 'Управление Агентами'
                ],
                'admin.agents.description' => [
                    'tr' => 'Sistem temsilcilerini ve performanslarını yönetin',
                    'ru' => 'Управляйте системными агентами и их производительностью'
                ],
                'admin.agents.add_agent' => [
                    'tr' => 'Temsilci Ekle',
                    'ru' => 'Добавить Агента'
                ],

                // Statistics Cards
                'admin.agents.total_agents' => [
                    'tr' => 'Toplam Temsilci',
                    'ru' => 'Всего Агентов'
                ],
                'admin.agents.total_referrals' => [
                    'tr' => 'Toplam Yönlendirme',
                    'ru' => 'Всего Рефералов'
                ],
                'admin.agents.average_performance' => [
                    'tr' => 'Ortalama Performans',
                    'ru' => 'Средняя Эффективность'
                ],
                'admin.agents.top_performance' => [
                    'tr' => 'En İyi Performans',
                    'ru' => 'Лучшая Эффективность'
                ],

                // Table Headers
                'admin.agents.agent_list' => [
                    'tr' => 'Temsilci Listesi',
                    'ru' => 'Список Агентов'
                ],
                'admin.agents.search_placeholder' => [
                    'tr' => 'Temsilci ara...',
                    'ru' => 'Поиск агента...'
                ],
                'admin.agents.agent' => [
                    'tr' => 'Temsilci',
                    'ru' => 'Агент'
                ],
                'admin.agents.referred_customers' => [
                    'tr' => 'Yönlendirilen Müşteriler',
                    'ru' => 'Привлеченные Клиенты'
                ],
                'admin.agents.performance' => [
                    'tr' => 'Performans',
                    'ru' => 'Эффективность'
                ],
                'admin.agents.actions' => [
                    'tr' => 'İşlemler',
                    'ru' => 'Действия'
                ],

                // Performance Labels
                'admin.agents.performance_excellent' => [
                    'tr' => 'Mükemmel',
                    'ru' => 'Отлично'
                ],
                'admin.agents.performance_good' => [
                    'tr' => 'İyi',
                    'ru' => 'Хорошо'
                ],
                'admin.agents.performance_low' => [
                    'tr' => 'Düşük',
                    'ru' => 'Низко'
                ],

                // Action Buttons
                'admin.agents.remove' => [
                    'tr' => 'Kaldır',
                    'ru' => 'Удалить'
                ],
                'admin.agents.remove_title' => [
                    'tr' => 'Temsilciyi Kaldır',
                    'ru' => 'Удалить Агента'
                ],

                // Empty State
                'admin.agents.no_agents_yet' => [
                    'tr' => 'Henüz Temsilci Bulunmuyor',
                    'ru' => 'Пока Нет Агентов'
                ],
                'admin.agents.add_first_agent' => [
                    'tr' => 'İlk temsilcinizi eklemek için yukarıdaki butonu kullanın.',
                    'ru' => 'Используйте кнопку выше, чтобы добавить вашего первого агента.'
                ],

                // Add Agent Modal
                'admin.agents.add_new_agent' => [
                    'tr' => 'Yeni Temsilci Ekle',
                    'ru' => 'Добавить Нового Агента'
                ],
                'admin.agents.select_user' => [
                    'tr' => 'Kullanıcı Seç',
                    'ru' => 'Выбрать Пользователя'
                ],
                'admin.agents.select_user_placeholder' => [
                    'tr' => 'Temsilci olacak kullanıcıyı seçin',
                    'ru' => 'Выберите пользователя, который станет агентом'
                ],
                'admin.agents.initial_referrals' => [
                    'tr' => 'Başlangıç Yönlendirme Sayısı',
                    'ru' => 'Начальное Количество Рефералов'
                ],
                'admin.agents.referrals_placeholder' => [
                    'tr' => 'Yönlendirilen kullanıcı sayısını girin',
                    'ru' => 'Введите количество привлеченных пользователей'
                ],
                'admin.agents.initial_referrals_note' => [
                    'tr' => 'Temsilcinin mevcut performansını yansıtmak için başlangıç değeri',
                    'ru' => 'Начальное значение для отражения текущей производительности агента'
                ],

                // Delete Confirmation Modal
                'admin.agents.remove_agent_title' => [
                    'tr' => 'Temsilciyi Kaldır',
                    'ru' => 'Удалить Агента'
                ],
                'admin.agents.are_you_sure' => [
                    'tr' => 'Emin misiniz?',
                    'ru' => 'Вы уверены?'
                ],
                'admin.agents.confirm_remove_message' => [
                    'tr' => 'isimli temsilciyi kaldırmak istediğinizden emin misiniz?',
                    'ru' => 'действительно хотите удалить агента?'
                ],
                'admin.agents.action_irreversible' => [
                    'tr' => 'Bu işlem geri alınamaz!',
                    'ru' => 'Это действие необратимо!'
                ],
                'admin.agents.yes_remove' => [
                    'tr' => 'Evet, Kaldır',
                    'ru' => 'Да, Удалить'
                ],
                'admin.agents.cancel' => [
                    'tr' => 'İptal',
                    'ru' => 'Отмена'
                ],

                // Agent View Page (additional phrases)
                'admin.agents.agent_customers' => [
                    'tr' => 'Temsilci Müşterileri',
                    'ru' => 'Клиенты Агента'
                ],
                'admin.agents.agent_customer_list' => [
                    'tr' => 'tarafından yönlendirilen müşteriler',
                    'ru' => 'клиенты, привлеченные'
                ],
                'admin.agents.total_earnings' => [
                    'tr' => 'Toplam Kazanç',
                    'ru' => 'Общий Доход'
                ],
                'admin.agents.no_assigned_customers' => [
                    'tr' => 'Bu temsilciye henüz atanmış müşteri bulunmuyor',
                    'ru' => 'Этому агенту еще не назначены клиенты'
                ]
            ];

        DB::transaction(function () use ($phrases) {
            foreach ($phrases as $key => $translations) {
                // Check if phrase already exists
                $phrase = Phrase::where('key', $key)->first();
                
                if (!$phrase) {
                    // Create new phrase
                    $phrase = Phrase::create([
                        'key' => $key,
                        'group' => 'admin'
                    ]);
                    
                    // Add translations
                    foreach ($translations as $languageId => $translation) {
                        $langId = $languageId === 'tr' ? 1 : 2; // 1=Turkish, 2=Russian
                        
                        PhraseTranslation::create([
                            'phrase_id' => $phrase->id,
                            'language_id' => $langId,
                            'translation' => $translation
                        ]);
                    }
                }
            }
        });
        
        $this->command->info('✅ Agents module phrases seeded successfully!');
        $this->command->info('📝 Added ' . count($phrases) . ' phrases with Turkish and Russian translations');
    }
}