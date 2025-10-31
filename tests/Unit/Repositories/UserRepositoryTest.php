<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\UserRepository;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepositoryInterface::class);
    }

    /** @test */
    public function it_can_find_user_by_email(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        // Act
        $foundUser = $this->userRepository->findByEmail('test@example.com');

        // Assert
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
        $this->assertEquals('test@example.com', $foundUser->email);
    }

    /** @test */
    public function it_returns_null_for_non_existent_email(): void
    {
        // Act
        $foundUser = $this->userRepository->findByEmail('nonexistent@example.com');

        // Assert
        $this->assertNull($foundUser);
    }

    /** @test */
    public function it_can_update_lead_status(): void
    {
        // Arrange
        $user = User::factory()->create(['lead_status' => 'new']);

        // Act
        $result = $this->userRepository->updateLeadStatus($user->id, 'qualified');

        // Assert
        $this->assertTrue($result);
        $this->assertEquals('qualified', $user->fresh()->lead_status);
    }

    /** @test */
    public function it_can_get_users_with_pending_kyc(): void
    {
        // Arrange
        User::factory()->count(3)->create(['account_verify' => 'Pending']);
        User::factory()->count(2)->create(['account_verify' => 'Verified']);

        // Act
        $pendingUsers = $this->userRepository->getUsersWithPendingKyc();

        // Assert
        $this->assertCount(3, $pendingUsers);
        $pendingUsers->each(function ($user) {
            $this->assertNotEquals('Verified', $user->account_verify);
        });
    }

    /** @test */
    public function it_can_find_user_by_id(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $foundUser = $this->userRepository->findById($user->id);

        // Assert
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    /** @test */
    public function it_returns_null_for_non_existent_user_id(): void
    {
        // Act
        $foundUser = $this->userRepository->findById(999);

        // Assert
        $this->assertNull($foundUser);
    }

    /** @test */
    public function it_can_update_user_balance_add(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 100.00]);

        // Act
        $result = $this->userRepository->updateBalance($user->id, 50.00, 'add');

        // Assert
        $this->assertTrue($result);
        $this->assertEquals(150.00, $user->fresh()->account_bal);
    }

    /** @test */
    public function it_can_update_user_balance_subtract(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 100.00]);

        // Act
        $result = $this->userRepository->updateBalance($user->id, 30.00, 'subtract');

        // Assert
        $this->assertTrue($result);
        $this->assertEquals(70.00, $user->fresh()->account_bal);
    }

    /** @test */
    public function it_fails_to_subtract_insufficient_balance(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 50.00]);

        // Act
        $result = $this->userRepository->updateBalance($user->id, 100.00, 'subtract');

        // Assert
        $this->assertFalse($result);
        $this->assertEquals(50.00, $user->fresh()->account_bal);
    }

    /** @test */
    public function it_handles_invalid_balance_update_type(): void
    {
        // Arrange
        $user = User::factory()->create(['account_bal' => 100.00]);

        // Act
        $result = $this->userRepository->updateBalance($user->id, 50.00, 'invalid');

        // Assert
        $this->assertFalse($result);
        $this->assertEquals(100.00, $user->fresh()->account_bal);
    }

    /** @test */
    public function it_returns_zero_referral_earnings_for_user_with_no_earnings(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $earnings = $this->userRepository->getReferralEarnings($user->id);

        // Assert
        $this->assertEquals(0.0, $earnings);
    }
}