<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\{User, Deposit};
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepositApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_deposit(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $depositData = [
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer',
            'currency' => 'USD'
        ];

        // Act
        $response = $this->postJson('/api/financial/deposits', $depositData);

        // Assert
        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Deposit processed successfully'
                 ])
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'amount',
                         'payment_method',
                         'status',
                         'created_at'
                     ]
                 ]);

        $this->assertDatabaseHas('deposits', [
            'user' => $user->id,
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer'
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_deposit(): void
    {
        // Arrange
        $depositData = [
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer'
        ];

        // Act
        $response = $this->postJson('/api/financial/deposits', $depositData);

        // Assert
        $response->assertStatus(401);
    }

    /** @test */
    public function deposit_creation_validates_required_fields(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Test missing amount
        $response = $this->postJson('/api/financial/deposits', [
            'payment_method' => 'Bank Transfer'
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['amount']);

        // Test missing payment_method
        $response = $this->postJson('/api/financial/deposits', [
            'amount' => 100.00
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['payment_method']);

        // Test invalid amount (negative)
        $response = $this->postJson('/api/financial/deposits', [
            'amount' => -100.00,
            'payment_method' => 'Bank Transfer'
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['amount']);
    }

    /** @test */
    public function user_can_get_their_deposits(): void
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Deposit::factory()->count(3)->create(['user' => $user->id]);
        Deposit::factory()->count(2)->create(['user' => $otherUser->id]);

        Sanctum::actingAs($user);

        // Act
        $response = $this->getJson('/api/financial/deposits');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'amount',
                             'payment_method',
                             'status'
                         ]
                     ]
                 ]);

        $this->assertCount(3, $response->json('data'));
    }

    /** @test */
    public function user_can_get_specific_deposit(): void
    {
        // Arrange
        $user = User::factory()->create();
        $deposit = Deposit::factory()->create(['user' => $user->id]);

        Sanctum::actingAs($user);

        // Act
        $response = $this->getJson("/api/financial/deposits/{$deposit->id}");

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $deposit->id,
                         'amount' => $deposit->amount,
                         'payment_method' => $deposit->payment_method
                     ]
                 ]);
    }

    /** @test */
    public function user_cannot_access_other_users_deposit(): void
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $deposit = Deposit::factory()->create(['user' => $otherUser->id]);

        Sanctum::actingAs($user);

        // Act
        $response = $this->getJson("/api/financial/deposits/{$deposit->id}");

        // Assert
        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false
                 ]);
    }

    /** @test */
    public function deposit_creation_handles_minimum_amount_validation(): void
    {
        // Arrange
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $depositData = [
            'amount' => 1.00, // Very small amount
            'payment_method' => 'Bank Transfer'
        ];

        // Act
        $response = $this->postJson('/api/financial/deposits', $depositData);

        // Assert - This should fail due to business rules (minimum amount)
        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false
                 ]);
    }

    /** @test */
    public function deposit_creation_updates_user_balance(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 100.00]);
        Sanctum::actingAs($user);

        $depositAmount = 50.00;
        $expectedBonus = $depositAmount * 0.10; // 10% bonus
        $expectedBalance = 100.00 + $depositAmount + $expectedBonus;

        $depositData = [
            'amount' => $depositAmount,
            'payment_method' => 'Bank Transfer'
        ];

        // Act
        $this->postJson('/api/financial/deposits', $depositData);

        // Assert
        $user->refresh();
        $this->assertEquals($expectedBalance, $user->account_bal);
    }
}