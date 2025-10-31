<?php

declare(strict_types=1);

namespace App\Services\Results;

use JsonSerializable;

/**
 * Base class for all service result objects
 *
 * Provides consistent interface for service operations with success/failure states,
 * data encapsulation, error handling, and JSON serialization support.
 *
 * @package App\Services\Results
 */
abstract class ServiceResult implements JsonSerializable
{
    protected bool $success;
    protected string $message;
    protected array $errors;
    protected mixed $data;
    protected ?string $errorCode;
    protected array $metadata;

    /**
     * Create a new ServiceResult instance
     */
    public function __construct(
        bool $success = true,
        string $message = '',
        mixed $data = null,
        array $errors = [],
        ?string $errorCode = null,
        array $metadata = []
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
        $this->errorCode = $errorCode;
        $this->metadata = $metadata;
    }

    /**
     * Check if the result is successful
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Check if the result is a failure
     */
    public function isFailure(): bool
    {
        return !$this->success;
    }

    /**
     * Get the result message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the result data
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Get the result errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the error code
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Get the metadata
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Create a successful result
     */
    public static function success(mixed $data = null, string $message = '', array $metadata = []): static
    {
        return new static(true, $message, $data, [], null, $metadata);
    }

    /**
     * Create a failure result
     */
    public static function failure(string $message, array $errors = [], ?string $errorCode = null): static
    {
        return new static(false, $message, null, $errors, $errorCode, []);
    }

    /**
     * Convert result to array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors,
            'error_code' => $this->errorCode,
            'metadata' => $this->metadata,
        ];
    }

    /**
     * JSON serialize the result
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * Check if result has data
     */
    public function hasData(): bool
    {
        return $this->data !== null;
    }

    /**
     * Check if result has errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Add metadata to the result
     */
    public function addMetadata(string $key, mixed $value): self
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    /**
     * Set a new message for the result
     */
    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set new data for the result
     */
    public function withData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }
}