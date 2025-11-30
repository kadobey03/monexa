<?php

namespace Database\Factories;

use App\Models\Phrase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phrase>
 */
class PhraseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phrase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groups = ['general', 'auth', 'validation', 'navigation', 'errors', 'forms', 'buttons', 'messages'];
        
        $sampleKeys = [
            'general' => ['welcome.message', 'goodbye.message', 'thank_you', 'please_wait', 'loading', 'success'],
            'auth' => ['login.title', 'register.title', 'logout', 'forgot_password', 'reset_password', 'email_verified'],
            'validation' => ['required', 'email', 'min_length', 'max_length', 'numeric', 'confirmed'],
            'navigation' => ['home', 'about', 'contact', 'services', 'portfolio', 'blog'],
            'errors' => ['404.title', '500.title', 'access_denied', 'not_found', 'server_error'],
            'forms' => ['name', 'email', 'phone', 'message', 'submit', 'cancel'],
            'buttons' => ['save', 'edit', 'delete', 'create', 'update', 'close'],
            'messages' => ['success.created', 'success.updated', 'success.deleted', 'error.general']
        ];

        $group = $this->faker->randomElement($groups);
        $keyBase = $this->faker->randomElement($sampleKeys[$group]);
        
        return [
            'key' => $keyBase . '.' . $this->faker->unique()->word,
            'group' => $group,
            'description' => $this->faker->sentence(),
            'metadata' => json_encode([
                'context' => $this->faker->words(2, true),
                'max_length' => $this->faker->numberBetween(50, 500),
                'allow_html' => $this->faker->boolean(20),
            ]),
            'usage_count' => $this->faker->numberBetween(0, 1000),
            'last_used_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Set specific key.
     */
    public function withKey(string $key): static
    {
        return $this->state(fn (array $attributes) => [
            'key' => $key,
        ]);
    }

    /**
     * Set specific group.
     */
    public function withGroup(string $group): static
    {
        return $this->state(fn (array $attributes) => [
            'group' => $group,
        ]);
    }

    /**
     * Set description.
     */
    public function withDescription(string $description): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => $description,
        ]);
    }

    /**
     * Mark as frequently used.
     */
    public function frequentlyUsed(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => $this->faker->numberBetween(500, 5000),
            'last_used_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Mark as rarely used.
     */
    public function rarelyUsed(): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => $this->faker->numberBetween(0, 10),
            'last_used_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 year', '-1 month'),
        ]);
    }

    /**
     * Set usage count.
     */
    public function withUsageCount(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'usage_count' => $count,
        ]);
    }

    /**
     * Set metadata.
     */
    public function withMetadata(array $metadata): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => json_encode($metadata),
        ]);
    }

    /**
     * General group phrase.
     */
    public function general(): static
    {
        return $this->withGroup('general');
    }

    /**
     * Auth group phrase.
     */
    public function auth(): static
    {
        return $this->withGroup('auth');
    }

    /**
     * Validation group phrase.
     */
    public function validation(): static
    {
        return $this->withGroup('validation');
    }

    /**
     * Navigation group phrase.
     */
    public function navigation(): static
    {
        return $this->withGroup('navigation');
    }

    /**
     * Error group phrase.
     */
    public function errors(): static
    {
        return $this->withGroup('errors');
    }

    /**
     * Form group phrase.
     */
    public function forms(): static
    {
        return $this->withGroup('forms');
    }

    /**
     * Button group phrase.
     */
    public function buttons(): static
    {
        return $this->withGroup('buttons');
    }

    /**
     * Message group phrase.
     */
    public function messages(): static
    {
        return $this->withGroup('messages');
    }

    /**
     * Allow HTML in metadata.
     */
    public function allowHtml(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => json_encode(array_merge(
                json_decode($attributes['metadata'] ?? '{}', true),
                ['allow_html' => true]
            )),
        ]);
    }

    /**
     * Set max length in metadata.
     */
    public function withMaxLength(int $length): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => json_encode(array_merge(
                json_decode($attributes['metadata'] ?? '{}', true),
                ['max_length' => $length]
            )),
        ]);
    }
}