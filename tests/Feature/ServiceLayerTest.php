<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Services\FinancialService;
use App\Services\UserService;
use App\Services\PlanService;
use App\Services\Results\DepositResult;
use App\Services\Results\WithdrawalResult;
use App\Services\Results\KycResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ServiceLayerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private FinancialService $financialService;
    private UserService $userService;
    private PlanService $planService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->financialService = app(FinancialService::class);
        $this->userService = app(UserService::class);
        $this->planService = app(PlanService::class);

        // Create test settings
        Settings::create([
            'id' => 1,
            'contact_email' => 'test@example.com',
            'currency' => 'USD',
            'referral_commission' => 5.0,
            'enable_kyc' => 'yes',
            'deposit_bonus' => 10.0
        ]);

        // Create test payment method
        Wdmethod::create([
            'name' => 'Bank Transfer',
            'charges_type' => 'percentage',
            'charges_amount' => 2.5,
            'minimum' => 50,
            'methodtype' => 'currency'
        ]);
    }

    /** @test */
    public function financial_service_processes_deposit_successfully()
    {
        $user = User::factory()->create([
            'account_bal' => 1000,
            'cstatus' => 'Customer'
        ]);

        $depositData = [
            'amount' => 500,
            'payment_mode' => 'Bank Transfer',
            'status' => 'Processed'
        ];

        $result = $this->financialService->processDeposit($depositData, $user);

        $this->assertInstanceOf(DepositResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertInstanceOf(Deposit::class, $result->deposit);
        $this->assertEquals(500, $result->deposit->amount);

        // Verify balance update
        $user->refresh();
        $this->assertEquals(1510, $user->account_bal); // 1000 + 500 + 10% bonus
        $this->assertEquals(50, $user->bonus); // 10% of 500
    }

    /** @test */
    public function financial_service_processes_withdrawal_successfully()
    {
        $user = User::factory()->create([
            'account_bal' => 1000,
            'cstatus' => 'Customer',
            'account_verify' => 'Verified'
        ]);

        $withdrawalData = [
            'amount' => 100,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ];

        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        $this->assertInstanceOf(WithdrawalResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertInstanceOf(Withdrawal::class, $result->withdrawal);
        $this->assertEquals(100, $result->withdrawal->amount);
        $this->assertEquals(2.5, $result->charges->totalCharges); // 2.5% of 100
    }

    /** @test */
    public function financial_service_fails_withdrawal_insufficient_balance()
    {
        $user = User::factory()->create([
            'account_bal' => 50,
            'cstatus' => 'Customer',
            'account_verify' => 'Verified'
        ]);

        $withdrawalData = [
            'amount' => 100,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ];

        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        $this->assertFalse($result->success);
        $this->assertStringContains($result->errorMessage, 'Insufficient balance');
    }

    /** @test */
    public function financial_service_fails_withdrawal_kyc_required()
    {
        $user = User::factory()->create([
            'account_bal' => 1000,
            'cstatus' => 'Customer',
            'account_verify' => 'Pending'
        ]);

        $withdrawalData = [
            'amount' => 100,
            'payment_mode' => 'Bank Transfer',
            'paydetails' => 'Test account details'
        ];

        $result = $this->financialService->processWithdrawal($withdrawalData, $user);

        $this->assertFalse($result->success);
        $this->assertStringContains($result->errorMessage, 'KYC verification required');
    }

    /** @test */
    public function user_service_calculates_lead_score()
    {
        $user = User::factory()->create([
            'email_verified_at' => now()
        ]);

        // Create some deposits for the user
        Deposit::factory()->count(3)->create([
            'user' => $user->id,
            'status' => 'Processed',
            'amount' => 100
        ]);

        $score = $this->userService->calculateLeadScore($user);

        // Base 10 + Email verification 20 + Deposits bonus (3*5=15) = 45
        $this->assertEquals(45.0, $score);
    }

    /** @test */
    public function user_service_validates_kyc_success()
    {
        $user = User::factory()->create([
            'account_verify' => 'Verified'
        ]);

        $result = $this->userService->validateKyc($user);

        $this->assertInstanceOf(KycResult::class, $result);
        $this->assertTrue($result->isVerified);
        $this->assertEquals('KYC already verified', $result->message);
    }

    /** @test */
    public function user_service_validates_kyc_pending()
    {
        $user = User::factory()->create([
            'account_verify' => 'Pending'
        ]);

        $result = $this->userService->validateKyc($user);

        $this->assertFalse($result->isVerified);
        $this->assertEquals('KYC verification pending', $result->message);
    }

    /** @test */
    public function financial_service_calculates_referral_commission()
    {
        $user = User::factory()->create();

        $commission = $this->financialService->calculateReferralCommission(1000, $user);

        $this->assertInstanceOf(\App\Services\Results\CommissionResult::class, $commission);
        $this->assertEquals(50.0, $commission->totalCommission); // 5% of 1000
    }

    /** @test */
    public function financial_service_verifies_balance_sufficiency()
    {
        $user = User::factory()->create(['account_bal' => 1000]);

        // Should not throw exception
        $result = $this->financialService->verifyBalanceSufficiency($user, 500);
        $this->assertTrue($result);

        // Should throw exception for insufficient balance
        $this->expectException(\App\Exceptions\Business\FinancialException::class);
        $this->financialService->verifyBalanceSufficiency($user, 1500);
    }

    /** @test */
    public function financial_service_processes_charges()
    {
        $charges = $this->financialService->processCharges(1000, 'Bank Transfer');

        $this->assertInstanceOf(\App\Services\Results\ChargeResult::class, $charges);
        $this->assertEquals(25.0, $charges->totalCharges); // 2.5% of 1000
        $this->assertEquals('percentage', $charges->chargeType);
        $this->assertEquals(2.5, $charges->chargeAmount);
    }

    /** @test */
    public function financial_service_throws_exception_for_invalid_payment_method()
    {
        $this->expectException(\App\Exceptions\Business\FinancialException::class);
        $this->expectExceptionMessage('Invalid payment method');

        $this->financialService->processCharges(1000, 'Invalid Method');
    }
}