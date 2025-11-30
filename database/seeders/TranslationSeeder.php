<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data in proper order (child first, then parent)
        PhraseTranslation::truncate();
        Phrase::truncate();
        Language::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Languages
        $this->createLanguages();
        
        // Create Basic Phrases
        $this->createBasicPhrases();
        
        // Create Authentication Phrases
        $this->createAuthPhrases();
        
        // Create Dashboard Phrases
        $this->createDashboardPhrases();
        
        // Create Validation Phrases
        $this->createValidationPhrases();
        
        // Create Common UI Phrases
        $this->createCommonPhrases();
        
        // Create Financial Phrases
        $this->createFinancialPhrases();
        
        $this->command->info('Translation seeder completed successfully!');
    }

    /**
     * Create supported languages
     */
    private function createLanguages(): void
    {
        $languages = [
            [
                'code' => 'tr',
                'name' => 'Türkçe',
                'native_name' => 'Türkçe',
                'flag_icon' => 'flag-tr',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'native_name' => 'Русский',
                'flag_icon' => 'flag-ru',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2
            ]
        ];

        foreach ($languages as $languageData) {
            Language::create($languageData);
        }
        
        $this->command->info('Languages created: TR, RU');
    }

    /**
     * Create basic phrases
     */
    private function createBasicPhrases(): void
    {
        $phrases = [
            ['key' => 'welcome', 'group' => 'general', 'description' => 'Welcome message'],
            ['key' => 'hello', 'group' => 'general', 'description' => 'Greeting'],
            ['key' => 'goodbye', 'group' => 'general', 'description' => 'Farewell'],
            ['key' => 'thank_you', 'group' => 'general', 'description' => 'Thank you message'],
            ['key' => 'please_wait', 'group' => 'general', 'description' => 'Please wait message'],
            ['key' => 'loading', 'group' => 'general', 'description' => 'Loading indicator'],
        ];

        $translations = [
            'tr' => [
                'welcome' => 'Hoş Geldiniz',
                'hello' => 'Merhaba',
                'goodbye' => 'Güle güle',
                'thank_you' => 'Teşekkürler',
                'please_wait' => 'Lütfen bekleyiniz',
                'loading' => 'Yükleniyor...',
            ],
            'ru' => [
                'welcome' => 'Добро пожаловать',
                'hello' => 'Привет',
                'goodbye' => 'До свидания',
                'thank_you' => 'Спасибо',
                'please_wait' => 'Пожалуйста, подождите',
                'loading' => 'Загрузка...',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Create authentication phrases
     */
    private function createAuthPhrases(): void
    {
        $phrases = [
            ['key' => 'login', 'group' => 'auth', 'description' => 'Login button/form'],
            ['key' => 'register', 'group' => 'auth', 'description' => 'Register button/form'],
            ['key' => 'logout', 'group' => 'auth', 'description' => 'Logout action'],
            ['key' => 'forgot_password', 'group' => 'auth', 'description' => 'Forgot password link'],
            ['key' => 'reset_password', 'group' => 'auth', 'description' => 'Reset password form'],
            ['key' => 'email', 'group' => 'auth', 'description' => 'Email field'],
            ['key' => 'password', 'group' => 'auth', 'description' => 'Password field'],
            ['key' => 'confirm_password', 'group' => 'auth', 'description' => 'Confirm password field'],
            ['key' => 'remember_me', 'group' => 'auth', 'description' => 'Remember me checkbox'],
            ['key' => 'login_failed', 'group' => 'auth', 'description' => 'Login failed message'],
        ];

        $translations = [
            'tr' => [
                'login' => 'Giriş Yap',
                'register' => 'Kayıt Ol',
                'logout' => 'Çıkış Yap',
                'forgot_password' => 'Şifremi Unuttum',
                'reset_password' => 'Şifre Sıfırla',
                'email' => 'E-posta',
                'password' => 'Şifre',
                'confirm_password' => 'Şifre Tekrar',
                'remember_me' => 'Beni Hatırla',
                'login_failed' => 'Giriş başarısız. Lütfen bilgilerinizi kontrol edin.',
            ],
            'ru' => [
                'login' => 'Войти',
                'register' => 'Регистрация',
                'logout' => 'Выйти',
                'forgot_password' => 'Забыл пароль',
                'reset_password' => 'Сброс пароля',
                'email' => 'Эл. почта',
                'password' => 'Пароль',
                'confirm_password' => 'Подтвердить пароль',
                'remember_me' => 'Запомнить меня',
                'login_failed' => 'Вход не удался. Пожалуйста, проверьте свои данные.',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Create dashboard phrases
     */
    private function createDashboardPhrases(): void
    {
        $phrases = [
            ['key' => 'dashboard', 'group' => 'dashboard', 'description' => 'Dashboard title'],
            ['key' => 'home', 'group' => 'navigation', 'description' => 'Home navigation'],
            ['key' => 'profile', 'group' => 'navigation', 'description' => 'Profile navigation'],
            ['key' => 'settings', 'group' => 'navigation', 'description' => 'Settings navigation'],
            ['key' => 'account', 'group' => 'navigation', 'description' => 'Account navigation'],
            ['key' => 'investments', 'group' => 'navigation', 'description' => 'Investments navigation'],
            ['key' => 'trading', 'group' => 'navigation', 'description' => 'Trading navigation'],
            ['key' => 'balance', 'group' => 'dashboard', 'description' => 'Account balance'],
            ['key' => 'total_invested', 'group' => 'dashboard', 'description' => 'Total invested amount'],
            ['key' => 'total_profit', 'group' => 'dashboard', 'description' => 'Total profit amount'],
        ];

        $translations = [
            'tr' => [
                'dashboard' => 'Panel',
                'home' => 'Ana Sayfa',
                'profile' => 'Profil',
                'settings' => 'Ayarlar',
                'account' => 'Hesap',
                'investments' => 'Yatırımlar',
                'trading' => 'İşlem',
                'balance' => 'Bakiye',
                'total_invested' => 'Toplam Yatırım',
                'total_profit' => 'Toplam Kar',
            ],
            'ru' => [
                'dashboard' => 'Панель',
                'home' => 'Главная',
                'profile' => 'Профиль',
                'settings' => 'Настройки',
                'account' => 'Аккаунт',
                'investments' => 'Инвестиции',
                'trading' => 'Торговля',
                'balance' => 'Баланс',
                'total_invested' => 'Всего инвестировано',
                'total_profit' => 'Общая прибыль',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Create validation phrases
     */
    private function createValidationPhrases(): void
    {
        $phrases = [
            ['key' => 'required', 'group' => 'validation', 'description' => 'Field is required'],
            ['key' => 'email_invalid', 'group' => 'validation', 'description' => 'Invalid email format'],
            ['key' => 'min_length', 'group' => 'validation', 'description' => 'Minimum length validation'],
            ['key' => 'max_length', 'group' => 'validation', 'description' => 'Maximum length validation'],
            ['key' => 'numeric_only', 'group' => 'validation', 'description' => 'Numeric only validation'],
            ['key' => 'passwords_not_match', 'group' => 'validation', 'description' => 'Passwords do not match'],
        ];

        $translations = [
            'tr' => [
                'required' => 'Bu alan zorunludur',
                'email_invalid' => 'Geçersiz e-posta formatı',
                'min_length' => 'En az :min karakter olmalıdır',
                'max_length' => 'En fazla :max karakter olmalıdır',
                'numeric_only' => 'Sadece sayı girebilirsiniz',
                'passwords_not_match' => 'Şifreler eşleşmiyor',
            ],
            'ru' => [
                'required' => 'Это поле обязательно',
                'email_invalid' => 'Неверный формат электронной почты',
                'min_length' => 'Должно быть не менее :min символов',
                'max_length' => 'Должно быть не более :max символов',
                'numeric_only' => 'Можно вводить только цифры',
                'passwords_not_match' => 'Пароли не совпадают',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Create common UI phrases
     */
    private function createCommonPhrases(): void
    {
        $phrases = [
            ['key' => 'save', 'group' => 'common', 'description' => 'Save button'],
            ['key' => 'cancel', 'group' => 'common', 'description' => 'Cancel button'],
            ['key' => 'delete', 'group' => 'common', 'description' => 'Delete button'],
            ['key' => 'edit', 'group' => 'common', 'description' => 'Edit button'],
            ['key' => 'create', 'group' => 'common', 'description' => 'Create button'],
            ['key' => 'update', 'group' => 'common', 'description' => 'Update button'],
            ['key' => 'close', 'group' => 'common', 'description' => 'Close button'],
            ['key' => 'submit', 'group' => 'common', 'description' => 'Submit button'],
            ['key' => 'search', 'group' => 'common', 'description' => 'Search function'],
            ['key' => 'filter', 'group' => 'common', 'description' => 'Filter function'],
            ['key' => 'yes', 'group' => 'common', 'description' => 'Yes confirmation'],
            ['key' => 'no', 'group' => 'common', 'description' => 'No confirmation'],
            ['key' => 'confirm', 'group' => 'common', 'description' => 'Confirm action'],
            ['key' => 'success', 'group' => 'common', 'description' => 'Success message'],
            ['key' => 'error', 'group' => 'common', 'description' => 'Error message'],
            ['key' => 'warning', 'group' => 'common', 'description' => 'Warning message'],
            ['key' => 'info', 'group' => 'common', 'description' => 'Information message'],
        ];

        $translations = [
            'tr' => [
                'save' => 'Kaydet',
                'cancel' => 'İptal',
                'delete' => 'Sil',
                'edit' => 'Düzenle',
                'create' => 'Oluştur',
                'update' => 'Güncelle',
                'close' => 'Kapat',
                'submit' => 'Gönder',
                'search' => 'Ara',
                'filter' => 'Filtrele',
                'yes' => 'Evet',
                'no' => 'Hayır',
                'confirm' => 'Onayla',
                'success' => 'Başarılı',
                'error' => 'Hata',
                'warning' => 'Uyarı',
                'info' => 'Bilgi',
            ],
            'ru' => [
                'save' => 'Сохранить',
                'cancel' => 'Отмена',
                'delete' => 'Удалить',
                'edit' => 'Редактировать',
                'create' => 'Создать',
                'update' => 'Обновить',
                'close' => 'Закрыть',
                'submit' => 'Отправить',
                'search' => 'Поиск',
                'filter' => 'Фильтр',
                'yes' => 'Да',
                'no' => 'Нет',
                'confirm' => 'Подтвердить',
                'success' => 'Успешно',
                'error' => 'Ошибка',
                'warning' => 'Предупреждение',
                'info' => 'Информация',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Create financial/trading phrases
     */
    private function createFinancialPhrases(): void
    {
        $phrases = [
            ['key' => 'deposit', 'group' => 'financial', 'description' => 'Deposit action'],
            ['key' => 'withdraw', 'group' => 'financial', 'description' => 'Withdraw action'],
            ['key' => 'amount', 'group' => 'financial', 'description' => 'Amount field'],
            ['key' => 'currency', 'group' => 'financial', 'description' => 'Currency selection'],
            ['key' => 'investment_plan', 'group' => 'financial', 'description' => 'Investment plan'],
            ['key' => 'profit', 'group' => 'financial', 'description' => 'Profit amount'],
            ['key' => 'loss', 'group' => 'financial', 'description' => 'Loss amount'],
            ['key' => 'pending', 'group' => 'financial', 'description' => 'Pending status'],
            ['key' => 'completed', 'group' => 'financial', 'description' => 'Completed status'],
            ['key' => 'cancelled', 'group' => 'financial', 'description' => 'Cancelled status'],
            ['key' => 'minimum_amount', 'group' => 'financial', 'description' => 'Minimum amount required'],
            ['key' => 'maximum_amount', 'group' => 'financial', 'description' => 'Maximum amount allowed'],
        ];

        $translations = [
            'tr' => [
                'deposit' => 'Para Yatır',
                'withdraw' => 'Para Çek',
                'amount' => 'Miktar',
                'currency' => 'Para Birimi',
                'investment_plan' => 'Yatırım Planı',
                'profit' => 'Kar',
                'loss' => 'Zarar',
                'pending' => 'Beklemede',
                'completed' => 'Tamamlandı',
                'cancelled' => 'İptal Edildi',
                'minimum_amount' => 'Minimum miktar: :amount',
                'maximum_amount' => 'Maximum miktar: :amount',
            ],
            'ru' => [
                'deposit' => 'Депозит',
                'withdraw' => 'Вывести',
                'amount' => 'Сумма',
                'currency' => 'Валюта',
                'investment_plan' => 'Инвестиционный план',
                'profit' => 'Прибыль',
                'loss' => 'Убыток',
                'pending' => 'В ожидании',
                'completed' => 'Завершено',
                'cancelled' => 'Отменено',
                'minimum_amount' => 'Минимальная сумма: :amount',
                'maximum_amount' => 'Максимальная сумма: :amount',
            ]
        ];

        $this->createPhrasesWithTranslations($phrases, $translations);
    }

    /**
     * Helper method to create phrases with translations
     */
    private function createPhrasesWithTranslations(array $phrases, array $translations): void
    {
        $languages = Language::all()->keyBy('code');

        foreach ($phrases as $phraseData) {
            // Create phrase
            $phrase = Phrase::create([
                'key' => $phraseData['key'],
                'group' => $phraseData['group'],
                'description' => $phraseData['description'],
                'is_active' => true,
                'context' => 'all',
                'usage_count' => 0
            ]);

            // Create translations for each language
            foreach ($languages as $langCode => $language) {
                if (isset($translations[$langCode][$phraseData['key']])) {
                    PhraseTranslation::create([
                        'phrase_id' => $phrase->id,
                        'language_id' => $language->id,
                        'translation' => $translations[$langCode][$phraseData['key']],
                        'is_reviewed' => true,
                        'needs_update' => false,
                        'reviewer' => 'system',
                        'reviewed_at' => now()
                    ]);
                }
            }
        }
    }
}