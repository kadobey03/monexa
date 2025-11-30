<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $languages = [
            ['code' => 'tr', 'name' => 'Türkçe', 'native_name' => 'Türkçe', 'flag' => '🇹🇷'],
            ['code' => 'ru', 'name' => 'Russian', 'native_name' => 'Русский', 'flag' => '🇷🇺'],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag' => '🇺🇸'],
            ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch', 'flag' => '🇩🇪'],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'flag' => '🇫🇷'],
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'flag' => '🇪🇸'],
            ['code' => 'it', 'name' => 'Italian', 'native_name' => 'Italiano', 'flag' => '🇮🇹'],
            ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية', 'flag' => '🇸🇦'],
        ];

        $language = $this->faker->randomElement($languages);

        return [
            'code' => $language['code'],
            'name' => $language['name'],
            'native_name' => $language['native_name'],
            'flag' => $language['flag'],
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'is_default' => false, // Will be overridden in specific cases
            'sort_order' => $this->faker->numberBetween(1, 100),
            'completion_percentage' => $this->faker->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Mark the language as active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Mark the language as inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Mark the language as default.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    /**
     * Set specific language code.
     */
    public function withCode(string $code): static
    {
        $languageMap = [
            'tr' => ['name' => 'Türkçe', 'native_name' => 'Türkçe', 'flag' => '🇹🇷'],
            'ru' => ['name' => 'Russian', 'native_name' => 'Русский', 'flag' => '🇷🇺'],
            'en' => ['name' => 'English', 'native_name' => 'English', 'flag' => '🇺🇸'],
            'de' => ['name' => 'German', 'native_name' => 'Deutsch', 'flag' => '🇩🇪'],
            'fr' => ['name' => 'French', 'native_name' => 'Français', 'flag' => '🇫🇷'],
            'es' => ['name' => 'Spanish', 'native_name' => 'Español', 'flag' => '🇪🇸'],
            'it' => ['name' => 'Italian', 'native_name' => 'Italiano', 'flag' => '🇮🇹'],
            'ar' => ['name' => 'Arabic', 'native_name' => 'العربية', 'flag' => '🇸🇦'],
        ];

        $language = $languageMap[$code] ?? $languageMap['en'];

        return $this->state(fn (array $attributes) => [
            'code' => $code,
            'name' => $language['name'],
            'native_name' => $language['native_name'],
            'flag' => $language['flag'],
        ]);
    }

    /**
     * Create Turkish language.
     */
    public function turkish(): static
    {
        return $this->withCode('tr')->default();
    }

    /**
     * Create Russian language.
     */
    public function russian(): static
    {
        return $this->withCode('ru')->active()->state([
            'sort_order' => 2,
        ]);
    }

    /**
     * Create English language.
     */
    public function english(): static
    {
        return $this->withCode('en')->active()->state([
            'sort_order' => 3,
        ]);
    }

    /**
     * Set completion percentage.
     */
    public function withCompletion(int $percentage): static
    {
        return $this->state(fn (array $attributes) => [
            'completion_percentage' => min(100, max(0, $percentage)),
        ]);
    }

    /**
     * Set sort order.
     */
    public function withSortOrder(int $order): static
    {
        return $this->state(fn (array $attributes) => [
            'sort_order' => $order,
        ]);
    }
}