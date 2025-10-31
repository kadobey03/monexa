<?php

namespace Database\Factories;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepositFactory extends Factory
{
    protected $model = Deposit::class;

    public function definition(): array
    {
        return [
            'user' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 10000),
            'payment_method' => $this->faker->randomElement(['crypto', 'bank_transfer', 'card']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'processed', 'failed']),
            'transaction_id' => $this->faker->uuid,
            'fees' => $this->faker->randomFloat(2, 0, 50),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function pending(): self
    {
        return $this->state(['status' => 'pending']);
    }

    public function processed(): self
    {
        return $this->state(['status' => 'processed']);
    }

    public function failed(): self
    {
        return $this->state(['status' => 'failed']);
    }

    public function withUser(User $user): self
    {
        return $this->state(['user' => $user->id]);
    }

    public function crypto(): self
    {
        return $this->state(['payment_method' => 'crypto']);
    }

    public function bankTransfer(): self
    {
        return $this->state(['payment_method' => 'bank_transfer']);
    }
}