<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class AdminEmailsPhrasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $phrases = [
                // Email Services Module
                [
                    'key' => 'admin.emails.title',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta Servisleri',
                        2 => 'Почтовые Сервисы'
                    ]
                ],
                [
                    'key' => 'admin.emails.description',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcılara toplu e-posta gönderin ve yönetin',
                        2 => 'Отправляйте массовые электронные письма пользователям и управляйте ими'
                    ]
                ],
                [
                    'key' => 'admin.emails.compose_form',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta Oluşturma Formu',
                        2 => 'Форма Создания Электронного Письма'
                    ]
                ],
                [
                    'key' => 'admin.emails.recipient_category',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Alıcı Kategorisi',
                        2 => 'Категория Получателей'
                    ]
                ],
                [
                    'key' => 'admin.emails.select_user_group',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta gönderilecek kullanıcı grubunu seçin',
                        2 => 'Выберите группу пользователей для отправки электронной почты'
                    ]
                ],
                [
                    'key' => 'admin.emails.all_users',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Tüm Kullanıcılar',
                        2 => 'Все Пользователи'
                    ]
                ],
                [
                    'key' => 'admin.emails.no_active_plans',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Aktif yatırım planı olmayan kullanıcılar',
                        2 => 'Пользователи без активных инвестиционных планов'
                    ]
                ],
                [
                    'key' => 'admin.emails.no_deposit',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Herhangi bir yatırımı olmayan kullanıcılar',
                        2 => 'Пользователи без каких-либо инвестиций'
                    ]
                ],
                [
                    'key' => 'admin.emails.select_users_manual',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcıları Manuel Seç',
                        2 => 'Выбрать Пользователей Вручную'
                    ]
                ],
                [
                    'key' => 'admin.emails.user_selection',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcı Seçimi',
                        2 => 'Выбор Пользователей'
                    ]
                ],
                [
                    'key' => 'admin.emails.select_users_to_send',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Gönderilecek kullanıcıları seçin',
                        2 => 'Выберите пользователей для отправки'
                    ]
                ],
                [
                    'key' => 'admin.emails.people_selected',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'kişi seçildi',
                        2 => 'человек выбрано'
                    ]
                ],
                [
                    'key' => 'admin.emails.select_users_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcıları seçin...',
                        2 => 'Выберите пользователей...'
                    ]
                ],
                [
                    'key' => 'admin.emails.search_user',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcı ara...',
                        2 => 'Поиск пользователя...'
                    ]
                ],
                [
                    'key' => 'admin.emails.greeting_and_title',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Selamlama ve Başlık',
                        2 => 'Приветствие и Заголовок'
                    ]
                ],
                [
                    'key' => 'admin.emails.email_opening_greeting',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-postanın başlangıç selamlaması',
                        2 => 'Начальное приветствие электронного письма'
                    ]
                ],
                [
                    'key' => 'admin.emails.default_greeting',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Merhaba',
                        2 => 'Привет'
                    ]
                ],
                [
                    'key' => 'admin.emails.default_title',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Yatırımcı',
                        2 => 'Инвестор'
                    ]
                ],
                [
                    'key' => 'admin.emails.greeting_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Selamlama (örn: Merhaba)',
                        2 => 'Приветствие (например: Привет)'
                    ]
                ],
                [
                    'key' => 'admin.emails.title_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Başlık (örn: Değerli Yatırımcı)',
                        2 => 'Заголовок (например: Уважаемый Инвестор)'
                    ]
                ],
                [
                    'key' => 'admin.emails.email_subject',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta Konusu',
                        2 => 'Тема Электронного Письма'
                    ]
                ],
                [
                    'key' => 'admin.emails.subject_recipients_see',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Alıcıların göreceği konu başlığı',
                        2 => 'Тема, которую увидят получатели'
                    ]
                ],
                [
                    'key' => 'admin.emails.subject_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta konusu...',
                        2 => 'Тема электронного письма...'
                    ]
                ],
                [
                    'key' => 'admin.emails.email_message',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta Mesajı',
                        2 => 'Сообщение Электронной Почты'
                    ]
                ],
                [
                    'key' => 'admin.emails.email_content_to_send',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Gönderilecek e-posta içeriği',
                        2 => 'Содержимое электронного письма для отправки'
                    ]
                ],
                [
                    'key' => 'admin.emails.message_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta mesajınızı buraya yazın...',
                        2 => 'Введите ваше сообщение здесь...'
                    ]
                ],
                [
                    'key' => 'admin.emails.send_email',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-postayı Gönder',
                        2 => 'Отправить Электронное Письмо'
                    ]
                ],
                [
                    'key' => 'admin.emails.editor_placeholder',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'E-posta içeriğinizi buraya yazın...',
                        2 => 'Введите содержимое вашего письма здесь...'
                    ]
                ],
                [
                    'key' => 'admin.emails.editor_ready',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Zengin metin editörü hazır! 📝',
                        2 => 'Редактор форматированного текста готов! 📝'
                    ]
                ],
                [
                    'key' => 'admin.emails.editor_loading_error',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Editör yüklenirken sorun oluştu. Sayfa yenilenirse düzelir. 🔄',
                        2 => 'Произошла проблема при загрузке редактора. Перезагрузка страницы исправит это. 🔄'
                    ]
                ],
                [
                    'key' => 'admin.emails.editor_load_failed',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Zengin metin editörü yüklenemedi. İnternet bağlantınızı kontrol edin. 📶',
                        2 => 'Не удалось загрузить редактор форматированного текста. Проверьте подключение к интернету. 📶'
                    ]
                ],
                [
                    'key' => 'admin.emails.select_at_least_one_user',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Lütfen en az bir kullanıcı seçin.',
                        2 => 'Пожалуйста, выберите хотя бы одного пользователя.'
                    ]
                ],
                [
                    'key' => 'admin.emails.sending',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Gönderiliyor',
                        2 => 'Отправляется'
                    ]
                ],
                [
                    'key' => 'admin.emails.no_user_found',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcı bulunamadı',
                        2 => 'Пользователь не найден'
                    ]
                ],
                [
                    'key' => 'admin.emails.one_user_selected',
                    'group' => 'admin',
                    'translations' => [
                        1 => '1 kullanıcı seçildi',
                        2 => '1 пользователь выбран'
                    ]
                ],
                [
                    'key' => 'admin.emails.users_selected',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'kullanıcı seçildi',
                        2 => 'пользователя выбрано'
                    ]
                ],
                [
                    'key' => 'admin.emails.loading_users',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcılar yükleniyor...',
                        2 => 'Загрузка пользователей...'
                    ]
                ],
                [
                    'key' => 'admin.emails.no_users_found',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Hiç kullanıcı bulunamadı',
                        2 => 'Пользователи не найдены'
                    ]
                ],
                [
                    'key' => 'admin.emails.users_loading_error',
                    'group' => 'admin',
                    'translations' => [
                        1 => 'Kullanıcılar yüklenirken hata oluştu',
                        2 => 'Ошибка при загрузке пользователей'
                    ]
                ],
                [
                    'key' => 'common.get_help',
                    'group' => 'common',
                    'translations' => [
                        1 => 'Yardım Al',
                        2 => 'Получить Помощь'
                    ]
                ],
                [
                    'key' => 'common.try_again',
                    'group' => 'common',
                    'translations' => [
                        1 => 'Tekrar dene',
                        2 => 'Попробовать снова'
                    ]
                ]
            ];

            foreach ($phrases as $phraseData) {
                // Create phrase
                $phrase = Phrase::firstOrCreate([
                    'key' => $phraseData['key'],
                    'group' => $phraseData['group']
                ]);

                // Add translations
                foreach ($phraseData['translations'] as $languageId => $translation) {
                    PhraseTranslation::updateOrCreate([
                        'phrase_id' => $phrase->id,
                        'language_id' => $languageId
                    ], [
                        'translation' => $translation
                    ]);
                }
            }
        });

        $this->command->info('✅ Admin Email Services phrases seeded successfully! (39 phrases)');
    }
}