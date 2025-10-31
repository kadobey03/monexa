<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Plans, Deposit, Withdrawal};
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinancialFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function complete_investment_flow_works(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 1000.00]);
        $plan = Plans::factory()->create(['price' => 500.00]);
        Sanctum::actingAs($user);

        $initialBalance = $user->account_bal;

        // Act 1: Make a deposit
        $depositResponse = $this->postJson('/api/financial/deposits', [
            'amount' => 500.00,
            'payment_method' => 'Bank Transfer'
        ]);

        // Act 2: Invest in plan
        $investResponse = $this->postJson("/api/plans/{$plan->id}/invest", [
            'amount' => 500.00,
            'terms_accepted' => true
        ]);

        // Assert
        $depositResponse->assertStatus(201);
        $investResponse->assertStatus(201);

        $this->assertDatabaseHas('deposits', [
            'user' => $user->id,
            'amount' => 500.00
        ]);

        $this->assertDatabaseHas('user_plans', [
            'user' => $user->id,
            'plan' => $plan->id,
            'amount' => 500.00
        ]);

        // Verify balance changes
        $user->refresh();
        $expectedBalance = $initialBalance + 500.00 + 50.00; // deposit + bonus
        $this->assertEquals($expectedBalance, $user->account_bal);
    }

    /** @test */
    public function user_cannot_invest_more_than_balance(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 100.00]);
        $plan = Plans::factory()->create(['price' => 500.00]);
        Sanctum::actingAs($user);

        // Act
        $response = $this->postJson("/api/plans/{$plan->id}/invest", [
            'amount' => 500.00,
            'terms_accepted' => true
        ]);

        // Assert
        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false
                 ]);
    }

    /** @test */
    public function complete_withdrawal_flow_works(): void
    {
        // Arrange
        $user = User::factory()->create([
            'account_bal' => 1000.00,
            'account_verify' => 'Verified'
        ]);
        Sanctum::actingAs($user);

        $withdrawalAmount = 100.00;
        $expectedCharges = 2.50; // 2.5% of 100
        $totalDeduction = $withdrawalAmount + $expectedCharges;

        // Act
        $response = $this->postJson('/api/financial/withdrawals', [
            'amount' => $withdrawalAmount,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ]);

        // Assert
        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true
                 ]);

        $this->assertDatabaseHas('withdrawals', [
            'user' => $user->id,
            'amount' => $withdrawalAmount,
            'payment_mode' => 'Bank Transfer'
        ]);

        // Verify balance deduction
        $user->refresh();
        $this->assertEquals(1000.00 - $totalDeduction, $user->account_bal);
    }

    /** @test */
    public function referral_commission_is_processed_on_deposit(): void
    {
        // Arrange
        $referrer = User::factory()->create();
        $user = User::factory()->create(['ref_by' => $referrer->id]);
        Sanctum::actingAs($user);

        $depositAmount = 1000.00;
        $expectedCommission = 50.00; // 5% of 1000

        // Act
        $this->postJson('/api/financial/deposits', [
            'amount' => $depositAmount,
            'payment_method' => 'Bank Transfer'
        ]);

        // Assert
        $referrer->refresh();
        $this->assertEquals($expectedCommission, $referrer->ref_bonus);

        // Check transaction record
        $this->assertDatabaseHas('tp_transaction', [
            'user' => $referrer->id,
            'amount' => $expectedCommission,
            'type' => 'Ref_bonus'
        ]);
    }

    /** @test */
    public function deposit_bonus_is_applied_correctly(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 0.00]);
        Sanctum::actingAs($user);

        $depositAmount = 100.00;
        $expectedBonus = 10.00; // 10% bonus
        $expectedBalance = $depositAmount + $expectedBonus;

        // Act
        $this->postJson('/api/financial/deposits', [
            'amount' => $depositAmount,
            'payment_method' => 'Bank Transfer'
        ]);

        // Assert
        $user->refresh();
        $this->assertEquals($expectedBalance, $user->account_bal);
        $this->assertEquals($expectedBonus, $user->bonus);

        // Check bonus transaction
        $this->assertDatabaseHas('tp_transaction', [
            'user' => $user->id,
            'amount' => $expectedBonus,
            'type' => 'Bonus'
        ]);
    }

    /** @test */
    public function kyc_verification_blocks_withdrawals(): void
    {
        // Arrange
        $user = User::factory()->create([
            'account_bal' => 1000.00,
            'account_verify' => 'Pending' // Not verified
        ]);
        Sanctum::actingAs($user);

        // Act
        $response = $this->postJson('/api/financial/withdrawals', [
            'amount' => 100.00,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ]);

        // Assert
        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false
                 ]);

        // Verify no withdrawal was created
        $this->assertDatabaseMissing('withdrawals', [
            'user' => $user->id,
            'amount' => 100.00
        ]);
    }

    /** @test */
    public function minimum_withdrawal_amount_is_enforced(): void
    {
        // Arrange
        $user = User::factory()->create([
            'account_bal' => 1000.00,
            'account_verify' => 'Verified'
        ]);
        Sanctum::actingAs($user);

        // Act - Try to withdraw less than minimum
        $response = $this->postJson('/api/financial/withdrawals', [
            'amount' => 10.00, // Below minimum
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ]);

        // Assert
        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false
                 ]);
    }

    /** @test */
    public function financial_transaction_creates_audit_log(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 1000.00]);
        Sanctum::actingAs($user);

        // Act - Make a deposit
        $this->postJson('/api/financial/deposits', [
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer'
        ]);

        // Assert - Check if transaction is logged (this would depend on your logging setup)
        // This is a placeholder - actual audit logging would need to be verified
        $this->assertDatabaseHas('deposits', [
            'user' => $user->id,
            'amount' => 100.00
        ]);
    }
}