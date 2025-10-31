<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Results;

use App\Services\Results\ServiceResult;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ServiceResult base functionality
 */
class ServiceResultTest extends TestCase
{
    /**
     * Test successful result creation
     */
    public function test_success_result_creation(): void
    {
        $result = ConcreteServiceResult::success('Test data', 'Success message');

        $this->assertTrue($result->isSuccess());
        $this->assertFalse($result->isFailure());
        $this->assertEquals('Success message', $result->getMessage());
        $this->assertEquals('Test data', $result->getData());
        $this->assertEmpty($result->getErrors());
        $this->assertNull($result->getErrorCode());
        $this->assertIsArray($result->getMetadata());
    }

    /**
     * Test failure result creation
     */
    public function test_failure_result_creation(): void
    {
        $errors = ['Field is required'];
        $result = ConcreteServiceResult::failure('Validation failed', $errors, 'VALIDATION_ERROR');

        $this->assertFalse($result->isSuccess());
        $this->assertTrue($result->isFailure());
        $this->assertEquals('Validation failed', $result->getMessage());
        $this->assertNull($result->getData());
        $this->assertEquals($errors, $result->getErrors());
        $this->assertEquals('VALIDATION_ERROR', $result->getErrorCode());
    }

    /**
     * Test toArray conversion
     */
    public function test_to_array_conversion(): void
    {
        $metadata = ['timestamp' => '2024-01-01'];
        $result = ConcreteServiceResult::success('Test data', 'Success', $metadata);

        $array = $result->toArray();

        $this->assertIsArray($array);
        $this->assertEquals(true, $array['success']);
        $this->assertEquals('Success', $array['message']);
        $this->assertEquals('Test data', $array['data']);
        $this->assertEquals([], $array['errors']);
        $this->assertNull($array['error_code']);
        $this->assertEquals($metadata, $array['metadata']);
    }

    /**
     * Test JSON serialization
     */
    public function test_json_serialization(): void
    {
        $result = ConcreteServiceResult::success('Test data', 'Success message');

        $json = json_encode($result);
        $decoded = json_decode($json, true);

        $this->assertIsArray($decoded);
        $this->assertEquals(true, $decoded['success']);
        $this->assertEquals('Success message', $decoded['message']);
        $this->assertEquals('Test data', $decoded['data']);
    }

    /**
     * Test data presence checks
     */
    public function test_data_presence_checks(): void
    {
        $resultWithData = ConcreteServiceResult::success('Test data');
        $resultWithoutData = ConcreteServiceResult::success();

        $this->assertTrue($resultWithData->hasData());
        $this->assertFalse($resultWithoutData->hasData());
    }

    /**
     * Test error presence checks
     */
    public function test_error_presence_checks(): void
    {
        $resultWithErrors = ConcreteServiceResult::failure('Error', ['Field required']);
        $resultWithoutErrors = ConcreteServiceResult::success();

        $this->assertTrue($resultWithErrors->hasErrors());
        $this->assertFalse($resultWithoutErrors->hasErrors());
    }

    /**
     * Test metadata management
     */
    public function test_metadata_management(): void
    {
        $result = ConcreteServiceResult::success();

        $result->addMetadata('timestamp', '2024-01-01');
        $result->addMetadata('user_id', 123);

        $metadata = $result->getMetadata();
        $this->assertEquals('2024-01-01', $metadata['timestamp']);
        $this->assertEquals(123, $metadata['user_id']);
    }

    /**
     * Test fluent interface
     */
    public function test_fluent_interface(): void
    {
        $result = ConcreteServiceResult::success()
            ->withMessage('Updated message')
            ->withData('Updated data')
            ->addMetadata('key', 'value');

        $this->assertEquals('Updated message', $result->getMessage());
        $this->assertEquals('Updated data', $result->getData());
        $this->assertEquals(['key' => 'value'], $result->getMetadata());
    }

    /**
     * Test constructor with all parameters
     */
    public function test_constructor_with_all_parameters(): void
    {
        $data = ['key' => 'value'];
        $errors = ['Error 1', 'Error 2'];
        $metadata = ['meta' => 'data'];

        $result = new ConcreteServiceResult(
            success: false,
            message: 'Test message',
            data: $data,
            errors: $errors,
            errorCode: 'TEST_ERROR',
            metadata: $metadata
        );

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('Test message', $result->getMessage());
        $this->assertEquals($data, $result->getData());
        $this->assertEquals($errors, $result->getErrors());
        $this->assertEquals('TEST_ERROR', $result->getErrorCode());
        $this->assertEquals($metadata, $result->getMetadata());
    }
}

/**
 * Concrete implementation for testing abstract ServiceResult
 */
class ConcreteServiceResult extends ServiceResult
{
    // Concrete implementation for testing
}