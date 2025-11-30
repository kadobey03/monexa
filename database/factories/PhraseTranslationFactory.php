<?php

namespace Database\Factories;

use App\Models\PhraseTranslation;
use App\Models\Phrase;
use App\Models\Language;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhraseTranslation>
 */
class PhraseTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhraseTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sampleTranslations = [
            'tr' => [
                'Hoş geldiniz', 'Merhaba', 'Güle güle', 'Teşekkürler', 'Lütfen bekleyiniz',
                'Başarılı', 'Hata', 'Kaydet', 'İptal', 'Düzenle', 'Sil', 'Oluştur',
                'Güncelle', 'Kapat', 'Ana Sayfa', 'Hakkında', 'İletişim', 'Hizmetler',
                'Giriş Yap', 'Kayıt Ol', 'Şifremi Unuttum', 'E-posta', 'Ad Soyad'
            ],
            'ru' => [
                'Добро пожаловать', 'Привет', 'До свидания', 'Спасибо', 'Пожалуйста, подождите',
                'Успешно', 'Ошибка', 'Сохранить', 'Отмена', 'Редактировать', 'Удалить', 'Создать',
                'Обновить', 'Закрыть', 'Главная', 'О нас', 'Контакты', 'Услуги',
                'Войти', 'Регистрация', 'Забыл пароль', 'Эл. почта', 'Имя'
            ],
            'en' => [
                'Welcome', 'Hello', 'Goodbye', 'Thank you', 'Please wait',
                'Success', 'Error', 'Save', 'Cancel', 'Edit', 'Delete', 'Create',
                'Update', 'Close', 'Home', 'About', 'Contact', 'Services',
                'Login', 'Register', 'Forgot Password', 'Email', 'Name'
            ]
        ];

        $reviewStatuses = ['pending', 'approved', 'rejected', 'needs_review'];
        
        return [
            'phrase_id' => Phrase::factory(),
            'language_id' => Language::factory(),
            'translation' => $this->faker->randomElement($sampleTranslations['tr']),
            'plural_translation' => $this->faker->optional(0.3)->randomElement($sampleTranslations['tr']),
            'review_status' => $this->faker->randomElement($reviewStatuses),
            'quality_score' => $this->faker->numberBetween(70, 100),
            'translated_by' => $this->faker->optional(0.7)->numberBetween(1, 10),
            'reviewed_by' => $this->faker->optional(0.5)->numberBetween(1, 10),
            'reviewed_at' => $this->faker->optional(0.5)->dateTimeBetween('-1 month', 'now'),
            'notes' => $this->faker->optional(0.3)->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Set specific phrase.
     */
    public function forPhrase(Phrase $phrase): static
    {
        return $this->state(fn (array $attributes) => [
            'phrase_id' => $phrase->id,
        ]);
    }

    /**
     * Set specific language.
     */
    public function forLanguage(Language $language): static
    {
        // Get appropriate translation based on language
        $sampleTranslations = [
            'tr' => [
                'Hoş geldiniz', 'Merhaba', 'Güle güle', 'Teşekkürler', 'Lütfen bekleyiniz',
                'Başarılı', 'Hata', 'Kaydet', 'İptal', 'Düzenle', 'Sil', 'Oluştur'
            ],
            'ru' => [
                'Добро пожаловать', 'Привет', 'До свидания', 'Спасибо', 'Пожалуйста, подождите',
                'Успешно', 'Ошибка', 'Сохранить', 'Отмена', 'Редактировать', 'Удалить', 'Создать'
            ],
            'en' => [
                'Welcome', 'Hello', 'Goodbye', 'Thank you', 'Please wait',
                'Success', 'Error', 'Save', 'Cancel', 'Edit', 'Delete', 'Create'
            ]
        ];

        $translations = $sampleTranslations[$language->code] ?? $sampleTranslations['en'];

        return $this->state(fn (array $attributes) => [
            'language_id' => $language->id,
            'translation' => $this->faker->randomElement($translations),
        ]);
    }

    /**
     * Set specific translation text.
     */
    public function withTranslation(string $translation): static
    {
        return $this->state(fn (array $attributes) => [
            'translation' => $translation,
        ]);
    }

    /**
     * Set plural translation.
     */
    public function withPluralTranslation(string $pluralTranslation): static
    {
        return $this->state(fn (array $attributes) => [
            'plural_translation' => $pluralTranslation,
        ]);
    }

    /**
     * Set review status.
     */
    public function withReviewStatus(string $status): static
    {
        return $this->state(fn (array $attributes) => [
            'review_status' => $status,
        ]);
    }

    /**
     * Mark as pending review.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'review_status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);
    }

    /**
     * Mark as approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'review_status' => 'approved',
            'reviewed_by' => $this->faker->numberBetween(1, 10),
            'reviewed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'quality_score' => $this->faker->numberBetween(85, 100),
        ]);
    }

    /**
     * Mark as rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'review_status' => 'rejected',
            'reviewed_by' => $this->faker->numberBetween(1, 10),
            'reviewed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'quality_score' => $this->faker->numberBetween(20, 60),
            'notes' => 'Translation needs improvement: ' . $this->faker->sentence(),
        ]);
    }

    /**
     * Mark as needing review.
     */
    public function needsReview(): static
    {
        return $this->state(fn (array $attributes) => [
            'review_status' => 'needs_review',
            'notes' => 'Requires attention: ' . $this->faker->sentence(),
        ]);
    }

    /**
     * Set quality score.
     */
    public function withQualityScore(int $score): static
    {
        return $this->state(fn (array $attributes) => [
            'quality_score' => min(100, max(0, $score)),
        ]);
    }

    /**
     * Set high quality.
     */
    public function highQuality(): static
    {
        return $this->state(fn (array $attributes) => [
            'quality_score' => $this->faker->numberBetween(90, 100),
            'review_status' => 'approved',
        ]);
    }

    /**
     * Set low quality.
     */
    public function lowQuality(): static
    {
        return $this->state(fn (array $attributes) => [
            'quality_score' => $this->faker->numberBetween(20, 50),
            'review_status' => 'needs_review',
        ]);
    }

    /**
     * Set translator.
     */
    public function translatedBy($translatorId): static
    {
        return $this->state(fn (array $attributes) => [
            'translated_by' => $translatorId,
        ]);
    }

    /**
     * Set reviewer.
     */
    public function reviewedBy($reviewerId): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewed_by' => $reviewerId,
            'reviewed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Set notes.
     */
    public function withNotes(string $notes): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => $notes,
        ]);
    }

    /**
     * Turkish translation.
     */
    public function turkish(): static
    {
        $translations = [
            'Hoş geldiniz', 'Merhaba', 'Güle güle', 'Teşekkürler', 'Lütfen bekleyiniz',
            'Başarılı', 'Hata', 'Kaydet', 'İptal', 'Düzenle', 'Sil', 'Oluştur',
            'Ana Sayfa', 'Hakkında', 'İletişim', 'Giriş Yap', 'Kayıt Ol'
        ];

        return $this->state(fn (array $attributes) => [
            'translation' => $this->faker->randomElement($translations),
        ]);
    }

    /**
     * Russian translation.
     */
    public function russian(): static
    {
        $translations = [
            'Добро пожаловать', 'Привет', 'До свидания', 'Спасибо', 'Пожалуйста, подождите',
            'Успешно', 'Ошибка', 'Сохранить', 'Отмена', 'Редактировать', 'Удалить', 'Создать',
            'Главная', 'О нас', 'Контакты', 'Войти', 'Регистрация'
        ];

        return $this->state(fn (array $attributes) => [
            'translation' => $this->faker->randomElement($translations),
        ]);
    }

    /**
     * English translation.
     */
    public function english(): static
    {
        $translations = [
            'Welcome', 'Hello', 'Goodbye', 'Thank you', 'Please wait',
            'Success', 'Error', 'Save', 'Cancel', 'Edit', 'Delete', 'Create',
            'Home', 'About', 'Contact', 'Login', 'Register'
        ];

        return $this->state(fn (array $attributes) => [
            'translation' => $this->faker->randomElement($translations),
        ]);
    }

    /**
     * Recently updated.
     */
    public function recentlyUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'updated_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Old translation.
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
        ]);
    }
}