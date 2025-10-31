<?php

namespace Database\Factories;

use App\Models\Plans;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlansFactory extends Factory
{
    protected $model = Plans::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'increment_amount' => $this->faker->randomFloat(2, 10, 500),
            'increment_interval' => $this->faker->numberBetween(1, 30),
            'increment_type' => $this->faker->randomElement(['daily', 'weekly', 'monthly']),
            'total_return' => $this->faker->randomFloat(2, 110, 6000),
            'total_duration' => $this->faker->numberBetween(30, 365),
            'description' => $this->faker->paragraph(),
            'features' => json_encode([
                'roi_percentage' => $this->faker->numberBetween(5, 25),
                'min_investment' => $this->faker->numberBetween(50, 500),
                'max_investment' => $this->faker->numberBetween(1000, 10000),
            ]),
            'status' => 'active',
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function active(): self
    {
        return $this->state(['status' => 'active']);
    }

    public function inactive(): self
    {
        return $this->state(['status' => 'inactive']);
    }

    public function highReturn(): self
    {
        return $this->state([
            'total_return' => $this->faker->randomFloat(2, 2000, 10000),
            'increment_amount' => $this->faker->randomFloat(2, 100, 1000),
        ]);
    }

    public function lowRisk(): self
    {
        return $this->state([
            'increment_amount' => $this->faker->randomFloat(2, 5, 20),
            'increment_interval' => 30, // Monthly
        ]);
    }

    public function highRisk(): self
    {
        return $this->state([
            'increment_amount' => $this->faker->randomFloat(2, 50, 200),
            'increment_interval' => 1, // Daily
        ]);
    }
}