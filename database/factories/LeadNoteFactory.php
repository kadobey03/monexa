<?php

namespace Database\Factories;

use App\Models\LeadNote;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadNote>
 */
class LeadNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadNote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['follow_up', 'contact', 'meeting', 'investment', 'other'];
        $colors = ['blue', 'green', 'yellow', 'red', 'purple', 'gray'];

        return [
            'user_id' => User::factory(),
            'admin_id' => Admin::factory(),
            'title' => fake()->sentence(4),
            'content' => fake()->paragraph(),
            'category' => fake()->randomElement($categories),
            'color' => fake()->randomElement($colors),
            'pinned' => fake()->boolean(20), // 20% chance of being pinned
            'reminder_date' => fake()->optional(30)->dateTimeBetween('now', '+30 days'), // 30% chance of having reminder
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the note is pinned.
     *
     * @return static
     */
    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'pinned' => true,
        ]);
    }

    /**
     * Indicate that the note has a reminder.
     *
     * @return static
     */
    public function withReminder(): static
    {
        return $this->state(fn (array $attributes) => [
            'reminder_date' => fake()->dateTimeBetween('now', '+30 days'),
        ]);
    }

    /**
     * Indicate that the note belongs to a specific category.
     *
     * @param string $category
     * @return static
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }

    /**
     * Indicate that the note has a specific color.
     *
     * @param string $color
     * @return static
     */
    public function color(string $color): static
    {
        return $this->state(fn (array $attributes) => [
            'color' => $color,
        ]);
    }
}