<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\FinancialService;
use App\Contracts\Repositories\{
    DepositRepositoryInterface,
    WithdrawalRepositoryInterface,
    UserRepositoryInterface
};
use App\Services\NotificationService;
use App\Models\{User, Deposit, Settings, Wdmethod};
use App\Services\Results\DepositResult;
use Mockery;

class FinancialServiceTest extends TestCase
{
    private FinancialService $financialService;
    private $depositRepositoryMock;
    private $withdrawalRepositoryMock;
    private $userRepositoryMock;
    private $notificationServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->depositRepositoryMock = Mockery::mock(DepositRepositoryInterface::class);
        $this->withdrawalRepositoryMock = Mockery::mock(WithdrawalRepositoryInterface::class);
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->notificationServiceMock = Mockery::mock(NotificationService::class);

        $this->financialService = new FinancialService(
            $this->depositRepositoryMock,
            $this->withdrawalRepositoryMock,
            $this->userRepositoryMock,
            $this->notificationServiceMock
        );

        // Create settings for tests
        Settings::create([
            'id' => 1,
            'referral_commission' => 5.0,
            'enable_kyc' => 'yes',
            'deposit_bonus' => 10.0,
            'currency' => 'USD'
        ]);

        Wdmethod::create([
            'name' => 'Bank Transfer',
            'charges_type' => 'percentage',
            'charges_amount' => 2.5,
            'minimum' => 50
        ]);
    }

    /** @test */
    public function it_processes_deposit_successfully(): void
    {
        // Arrange
        $user = User::factory()->make(['id' => 1]);
        $depositData = [
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer'
        ];
        $deposit = Deposit::factory()->make([
            'id' => 1,
            'amount' => 100.00,
            'user' => $user->id,
            'status' => 'pending'
        ]);

        $this->depositRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with(array_merge($depositData, ['user' => $user->id, 'status' => 'pending']))
            ->andReturn($deposit);

        $this->userRepositoryMock
            ->shouldReceive('updateBalance')
            ->once()
            ->with($user->id, 110.00) // 100 + 10% bonus
            ->andReturn(true);

        $this->notificationServiceMock
            ->shouldReceive('sendDepositConfirmation')
            ->once()
            ->with($deposit)
            ->andReturn(true);

        // Act
        $result = $this->financialService->processDeposit($depositData, $user);

        // Assert
        $this->assertInstanceOf(DepositResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertEquals($deposit, $result->deposit);
        $this->assertNull($result->errorMessage);
    }

    /** @test */
    public function it_handles_deposit_processing_failure(): void
    {
        // Arrange
        $user = User::factory()->make(['id' => 1]);
        $depositData = [
            'amount' => 100.00,
            'payment_method' => 'Bank Transfer'
        ];

        $this->depositRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->andThrow(new \Exception('Database error'));

        // Act
        $result = $this->financialService->processDeposit($depositData, $user);

        // Assert
        $this->assertInstanceOf(DepositResult::class, $result);
        $this->assertFalse($result->success);
        $this->assertNull($result->deposit);
        $this->assertStringContains('error', strtolower($result->errorMessage));
    }

    /** @test */
    public function it_validates_minimum_deposit_amount(): void
    {
        // Arrange
        $user = User::factory()->make();
        $depositData = [
            'amount' => 5.00, // Below minimum
            'payment_method' => 'Bank Transfer'
        ];

        // Act
        $result = $this->financialService->processDeposit($depositData, $user);

        // Assert
        $this->assertFalse($result->success);
        $this->assertStringContains('minimum', strtolower($result->errorMessage));
    }

    /** @test */
    public function it_calculates_referral_commission_correctly(): void
    {
        // Arrange
        $user = User::factory()->make(['ref_by' => 2]);

        // Act
        $result = $this->financialService->calculateReferralCommission(1000.00, $user);

        // Assert
        $this->assertInstanceOf(\App\Services\Results\CommissionResult::class, $result);
        $this->assertEquals(50.0, $result->totalCommission); // 5% of 1000
    }

    /** @test */
    public function it_verifies_balance_sufficiency(): void
    {
        // Arrange
        $user = User::factory()->make(['account_bal' => 1000.00]);

        // Act & Assert
        $this->assertTrue($this->financialService->verifyBalanceSufficiency($user, 500.00));

        $this->expectException(\App\Exceptions\Business\FinancialException::class);
        $this->financialService->verifyBalanceSufficiency($user, 1500.00);
    }

    /** @test */
    public function it_processes_charges_for_percentage_type(): void
    {
        // Act
        $charges = $this->financialService->processCharges(1000.00, 'Bank Transfer');

        // Assert
        $this->assertInstanceOf(\App\Services\Results\ChargeResult::class, $charges);
        $this->assertEquals(25.0, $charges->totalCharges); // 2.5% of 1000
        $this->assertEquals('percentage', $charges->chargeType);
        $this->assertEquals(2.5, $charges->chargeAmount);
    }

    /** @test */
    public function it_throws_exception_for_invalid_payment_method(): void
    {
        // Act & Assert
        $this->expectException(\App\Exceptions\Business\FinancialException::class);
        $this->expectExceptionMessage('Invalid payment method');

        $this->financialService->processCharges(1000.00, 'Invalid Method');
    }

    /** @test */
    public function it_processes_withdrawal_successfully(): void
    {
        // Arrange
        $user = User::factory()->make([
            'id' => 1,
            'account_bal' => 1000.00,
            'account_verify' => 'Verified'
        ]);
        $withdrawalData = [
            'amount' => 100.00,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ];

        $withdrawal = \App\Models\Withdrawal::factory()->make([
            'id' => 1,
            'amount' => 100.00,
            'user' => $user->id,
            'status' => 'pending'
        ]);

        $this->withdrawalRepositoryMock
            ->shouldReceive('processWithdrawal')
            ->once()
            ->andReturn($withdrawal);

        $this->userRepositoryMock
            ->shouldReceive('updateBalance')
            ->once()
            ->with($user->id, 122.50, 'subtract') // 100 + 22.5 charges
            ->andReturn(true);

        $this->notificationServiceMock
            ->shouldReceive('sendWithdrawalStatus')
            ->once()
            ->with($withdrawal)
            ->andReturn(true);

        // Act
        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        // Assert
        $this->assertInstanceOf(\App\Services\Results\WithdrawalResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertEquals($withdrawal, $result->withdrawal);
    }

    /** @test */
    public function it_fails_withdrawal_with_insufficient_balance(): void
    {
        // Arrange
        $user = User::factory()->make([
            'account_bal' => 50.00,
            'account_verify' => 'Verified'
        ]);
        $withdrawalData = [
            'amount' => 100.00,
            'payment_mode' => 'Bank Transfer'
        ];

        // Act
        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        // Assert
        $this->assertFalse($result->success);
        $this->assertStringContains('insufficient balance', strtolower($result->errorMessage));
    }

    /** @test */
    public function it_fails_withdrawal_with_pending_kyc(): void
    {
        // Arrange
        $user = User::factory()->make([
            'account_bal' => 1000.00,
            'account_verify' => 'Pending'
        ]);
        $withdrawalData = [
            'amount' => 100.00,
            'payment_mode' => 'Bank Transfer'
        ];

        // Act
        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        // Assert
        $this->assertFalse($result->success);
        $this->assertStringContains('KYC verification required', $result->errorMessage);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}