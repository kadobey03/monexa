<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $statusCode;
    protected $errors;

    public function __construct(
        string $message = 'API Error',
        int $statusCode = 400,
        array $errors = [],
        ?Exception $previous = null
    ) {
        $this->statusCode = $statusCode;
        $this->errors = $errors;

        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function unauthorized(string $message = 'Unauthorized access'): self
    {
        return new static($message, 401);
    }

    public static function forbidden(string $message = 'Access forbidden'): self
    {
        return new static($message, 403);
    }

    public static function notFound(string $resource = 'Resource'): self
    {
        return new static("{$resource} not found", 404);
    }

    public static function validationFailed(array $errors): self
    {
        return new static('Validation failed', 422, $errors);
    }

    public static function rateLimitExceeded(): self
    {
        return new static('Rate limit exceeded', 429);
    }

    public static function serverError(string $message = 'Internal server error'): self
    {
        return new static($message, 500);
    }

    public static function serviceUnavailable(string $message = 'Service temporarily unavailable'): self
    {
        return new static($message, 503);
    }
}