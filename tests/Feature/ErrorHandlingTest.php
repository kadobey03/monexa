<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Exceptions\FinancialException;
use App\Exceptions\ApiException;
use App\Services\ErrorResponseFormatter;
use App\Services\FinancialErrorHandler;

class ErrorHandlingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private ErrorResponseFormatter $errorFormatter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->errorFormatter = new ErrorResponseFormatter();
    }

    /** @test */
    public function it_handles_financial_exception_with_proper_response()
    {
        $exception = FinancialException::insufficientBalance(100.0, 500.0);
        
        $response = $this->errorFormatter->createJsonResponse($exception);
        $data = $response->getData(true);
        
        $this->assertFalse($data['success']);
        $this->assertEquals('financial', $data['error']['type']);
        $this->assertEquals('FINANCIAL_ERROR', $data['error']['code']);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals('tr', $data['locale']);
        $this->assertArrayHasKey('context', $data['error']);
        $this->assertArrayHasKey('recovery_suggestions', $data['error']);
    }

    /** @test */
    public function it_handles_api_exception_with_proper_response()
    {
        $exception = ApiException::unauthorized('Unauthorized access');
        
        $response = $this->errorFormatter->createJsonResponse($exception);
        $data = $response->getData(true);
        
        $this->assertFalse($data['success']);
        $this->assertEquals('api', $data['error']['type']);
        $this->assertEquals('Unauthorized access', $data['error']['message']);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('authentication', $data['error']['category']);
    }

    /** @test */
    public function it_handles_kyc_exception_with_proper_response()
    {
        $exception = new \App\Exceptions\KycException('KYC verification required', 'pending', ['identity_verification']);
        
        $response = $this->errorFormatter->createJsonResponse($exception);
        $data = $response->getData(true);
        
        $this->assertFalse($data['success']);
        $this->assertEquals('kyc', $data['error']['type']);
        $this->assertEquals('KYC verification required', $data['error']['message']);
        $this->assertEquals('pending', $data['error']['status']);
        $this->assertEquals(403, $response->getStatusCode());
    }

    /** @test */
    public function it_supports_english_error_messages()
    {
        $exception = FinancialException::insufficientBalance(100.0, 500.0);
        
        $response = $this->errorFormatter->createJsonResponse($exception, 'en');
        $data = $response->getData(true);
        
        $this->assertEquals('en', $data['locale']);
        $this->assertArrayHasKey('en', $data['error']['recovery_suggestions']);
    }

    /** @test */
    public function it_handles_web_requests_with_error_pages()
    {
        $response = $this->get('/non-existent-page');
        
        $response->assertStatus(404);
        $response->assertViewIs('errors.404');
        $response->assertSee('Sayfa Bulunamadı');
    }

    /** @test */
    public function it_handles_api_requests_with_json_errors()
    {
        $response = $this->json('GET', '/api/non-existent-endpoint');
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'timestamp',
            'locale',
            'request_id',
            'error' => [
                'type',
                'code',
                'message',
                'category'
            ],
            'status_code'
        ]);
        
        $data = $response->json();
        $this->assertFalse($data['success']);
        $this->assertEquals('api', $data['error']['type']);
    }

    /** @test */
    public function it_handles_financial_operation_errors()
    {
        $financialErrorHandler = app(FinancialErrorHandler::class);
        
        $result = $financialErrorHandler->executeWithErrorHandling(
            function() {
                throw new \Exception('Database connection failed');
            },
            $this->user,
            'withdrawal',
            ['amount' => 100]
        );
        
        $this->expectException(\App\Exceptions\FinancialException::class);
    }

    /** @test */
    public function it_validates_transaction_amounts()
    {
        $financialErrorHandler = app(FinancialErrorHandler::class);
        
        $this->expectException(\App\Exceptions\FinancialException::class);
        
        $financialErrorHandler->validateAmount(-100, 'withdrawal');
    }

    /** @test */
    public function it_verifies_user_balance()
    {
        $financialErrorHandler = app(FinancialErrorHandler::class);
        
        $this->user->update(['balance' => 50]);
        
        $this->expectException(\App\Exceptions\FinancialException::class);
        $financialErrorHandler->verifyBalance($this->user, 100, 'withdrawal');
    }

    /** @test */
    public function it_includes_debug_information_when_debug_enabled()
    {
        config(['app.debug' => true]);
        
        $exception = new \Exception('Test error');
        $response = $this->errorFormatter->createJsonResponse($exception);
        $data = $response->getData(true);
        
        $this->assertArrayHasKey('debug', $data);
        $this->assertArrayHasKey('exception_class', $data['debug']);
        $this->assertArrayHasKey('file', $data['debug']);
        $this->assertArrayHasKey('line', $data['debug']);
    }
}