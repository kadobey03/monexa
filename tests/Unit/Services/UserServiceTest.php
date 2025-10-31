<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\UserService;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Services\Results\KycResult;
use Mockery;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    /** @test */
    public function it_updates_lead_status_successfully(): void
    {
        // Arrange
        $user = User::factory()->make(['id' => 1]);

        $this->userRepositoryMock
            ->shouldReceive('updateLeadStatus')
            ->once()
            ->with(1, 'qualified')
            ->andReturn(true);

        // Act
        $result = $this->userService->updateLeadStatus($user, 'qualified');

        // Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function it_validates_kyc_successfully_when_verified(): void
    {
        // Arrange
        $user = User::factory()->make(['account_verify' => 'Verified']);

        // Act
        $result = $this->userService->validateKyc($user);

        // Assert
        $this->assertInstanceOf(KycResult::class, $result);
        $this->assertTrue($result->isVerified);
        $this->assertEquals('KYC already verified', $result->message);
    }

    /** @test */
    public function it_validates_kyc_as_pending(): void
    {
        // Arrange
        $user = User::factory()->make(['account_verify' => 'Pending']);

        // Act
        $result = $this->userService->validateKyc($user);

        // Assert
        $this->assertFalse($result->isVerified);
        $this->assertEquals('KYC verification pending', $result->message);
    }

    /** @test */
    public function it_validates_kyc_as_required_when_null(): void
    {
        // Arrange
        $user = User::factory()->make(['account_verify' => null]);

        // Act
        $result = $this->userService->validateKyc($user);

        // Assert
        $this->assertFalse($result->isVerified);
        $this->assertEquals('KYC verification required', $result->message);
    }

    /** @test */
    public function it_calculates_lead_score_correctly(): void
    {
        // Arrange
        $user = User::factory()->make([
            'account_bal' => 1000.00,
            'email_verified_at' => now()->subDays(5)
        ]);

        $this->userRepositoryMock
            ->shouldReceive('getTotalDepositAmount')
            ->once()
            ->with($user->id)
            ->andReturn(500.00);

        $this->userRepositoryMock
            ->shouldReceive('getUserDepositHistory')
            ->once()
            ->with($user->id)
            ->andReturn(collect([1, 2, 3])); // 3 deposits

        // Act
        $score = $this->userService->calculateLeadScore($user);

        // Assert
        // Base 10 + Email verification 20 + Deposit bonus (min(500/100, 30) = 5) + Activity bonus (min(3*5, 20) = 15) = 50
        $this->assertEquals(50.0, $score);
    }

    /** @test */
    public function it_calculates_lead_score_with_maximum_deposit_bonus(): void
    {
        // Arrange
        $user = User::factory()->make([
            'account_bal' => 5000.00,
            'email_verified_at' => now()
        ]);

        $this->userRepositoryMock
            ->shouldReceive('getTotalDepositAmount')
            ->once()
            ->with($user->id)
            ->andReturn(10000.00); // High deposits for max bonus

        $this->userRepositoryMock
            ->shouldReceive('getUserDepositHistory')
            ->once()
            ->with($user->id)
            ->andReturn(collect([1, 2, 3, 4, 5, 6])); // 6 deposits for max activity

        // Act
        $score = $this->userService->calculateLeadScore($user);

        // Assert
        // Base 10 + Email 20 + Deposit bonus 30 (max) + Activity bonus 20 (max) = 80
        $this->assertEquals(80.0, $score);
    }

    /** @test */
    public function it_processes_user_verification_successfully(): void
    {
        // Arrange
        $user = User::factory()->make(['account_verify' => 'Pending']);
        $documents = [
            'id_card' => 'path/to/id.jpg',
            'proof_of_address' => 'path/to/address.pdf'
        ];

        // Act
        $result = $this->userService->processUserVerification($user, $documents);

        // Assert
        $this->assertInstanceOf(\App\Services\Results\VerificationResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertEquals('Verification completed successfully', $result->message);
        $this->assertEquals('Verified', $user->account_verify);
    }

    /** @test */
    public function it_fails_verification_with_missing_documents(): void
    {
        // Arrange
        $user = User::factory()->make();
        $documents = []; // Empty documents

        // Act
        $result = $this->userService->processUserVerification($user, $documents);

        // Assert
        $this->assertFalse($result->success);
        $this->assertStringContains('No documents provided', $result->message);
    }

    /** @test */
    public function it_fails_verification_with_missing_required_document(): void
    {
        // Arrange
        $user = User::factory()->make();
        $documents = [
            'id_card' => 'path/to/id.jpg'
            // Missing proof_of_address
        ];

        // Act
        $result = $this->userService->processUserVerification($user, $documents);

        // Assert
        $this->assertFalse($result->success);
        $this->assertStringContains('Missing required document: proof_of_address', $result->message);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}