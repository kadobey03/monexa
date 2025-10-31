<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\DepositRepository;
use App\Contracts\Repositories\DepositRepositoryInterface;
use App\Models\{User, Deposit, Settings, Wdmethod};
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepositRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private DepositRepositoryInterface $depositRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->depositRepository = app(DepositRepositoryInterface::class);

        // Create settings for referral calculations
        Settings::create([
            'id' => 1,
            'referral_commission' => 5.0,
            'referral_commission1' => 2.0,
            'referral_commission2' => 1.5,
            'deposit_bonus' => 10.0,
            'currency' => 'USD'
        ]);

        // Create payment method
        Wdmethod::create([
            'name' => 'Bank Transfer',
            'charges_type' => 'percentage',
            'charges_amount' => 2.5
        ]);
    }

    /** @test */
    public function it_can_create_deposit(): void
    {
        // Arrange
        $user = User::factory()->create();
        $depositData = [
            'user' => $user->id,
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer',
            'status' => 'pending'
        ];

        // Act
        $deposit = $this->depositRepository->create($depositData);

        // Assert
        $this->assertInstanceOf(Deposit::class, $deposit);
        $this->assertEquals(100.00, $deposit->amount);
        $this->assertEquals('Bank Transfer', $deposit->payment_method);
        $this->assertEquals('pending', $deposit->status);
    }

    /** @test */
    public function it_can_find_pending_deposits(): void
    {
        // Arrange
        $user = User::factory()->create();
        Deposit::factory()->count(2)->create([
            'user' => $user->id,
            'status' => 'Pending'
        ]);
        Deposit::factory()->create([
            'user' => $user->id,
            'status' => 'Processed'
        ]);

        // Act
        $pendingDeposits = $this->depositRepository->findPendingDeposits();

        // Assert
        $this->assertCount(2, $pendingDeposits);
        $pendingDeposits->each(function ($deposit) {
            $this->assertEquals('Pending', $deposit->status);
        });
    }

    /** @test */
    public function it_can_find_deposit_by_id(): void
    {
        // Arrange
        $user = User::factory()->create();
        $deposit = Deposit::factory()->create(['user' => $user->id]);

        // Act
        $foundDeposit = $this->depositRepository->findById($deposit->id);

        // Assert
        $this->assertNotNull($foundDeposit);
        $this->assertEquals($deposit->id, $foundDeposit->id);
        $this->assertEquals($user->id, $foundDeposit->user);
    }

    /** @test */
    public function it_returns_null_for_non_existent_deposit_id(): void
    {
        // Act
        $foundDeposit = $this->depositRepository->findById(999);

        // Assert
        $this->assertNull($foundDeposit);
    }

    /** @test */
    public function it_can_update_deposit_status(): void
    {
        // Arrange
        $deposit = Deposit::factory()->create(['status' => 'Pending']);

        // Act
        $result = $this->depositRepository->updateStatus($deposit->id, 'Processed');

        // Assert
        $this->assertTrue($result);
        $this->assertEquals('Processed', $deposit->fresh()->status);
    }

    /** @test */
    public function it_can_get_user_deposit_history(): void
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Deposit::factory()->count(3)->create(['user' => $user->id]);
        Deposit::factory()->count(2)->create(['user' => $otherUser->id]);

        // Act
        $userDeposits = $this->depositRepository->getUserDepositHistory($user->id);

        // Assert
        $this->assertCount(3, $userDeposits);
        $userDeposits->each(function ($deposit) use ($user) {
            $this->assertEquals($user->id, $deposit->user);
        });
    }

    /** @test */
    public function it_can_get_deposits_by_status(): void
    {
        // Arrange
        Deposit::factory()->count(3)->create(['status' => 'Processed']);
        Deposit::factory()->count(2)->create(['status' => 'Pending']);

        // Act
        $processedDeposits = $this->depositRepository->getDepositsByStatus('Processed');

        // Assert
        $this->assertCount(3, $processedDeposits);
        $processedDeposits->each(function ($deposit) {
            $this->assertEquals('Processed', $deposit->status);
        });
    }

    /** @test */
    public function it_can_get_total_deposit_amount_for_user(): void
    {
        // Arrange
        $user = User::factory()->create();

        Deposit::factory()->create([
            'user' => $user->id,
            'amount' => 100.00,
            'status' => 'Processed'
        ]);
        Deposit::factory()->create([
            'user' => $user->id,
            'amount' => 50.00,
            'status' => 'Processed'
        ]);
        Deposit::factory()->create([
            'user' => $user->id,
            'amount' => 25.00,
            'status' => 'Pending'
        ]);

        // Act
        $totalAmount = $this->depositRepository->getTotalDepositAmount($user->id);

        // Assert
        $this->assertEquals(150.00, $totalAmount);
    }

    /** @test */
    public function it_can_get_deposits_by_date_range(): void
    {
        // Arrange
        $user = User::factory()->create();

        Deposit::factory()->create([
            'user' => $user->id,
            'created_at' => '2024-01-01'
        ]);
        Deposit::factory()->create([
            'user' => $user->id,
            'created_at' => '2024-01-15'
        ]);
        Deposit::factory()->create([
            'user' => $user->id,
            'created_at' => '2024-02-01'
        ]);

        // Act
        $deposits = $this->depositRepository->getDepositsByDateRange(
            $user->id,
            '2024-01-01',
            '2024-01-31'
        );

        // Assert
        $this->assertCount(2, $deposits);
    }
}