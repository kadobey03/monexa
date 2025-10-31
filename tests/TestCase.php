<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable middleware for faster testing
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        // Set testing environment
        config(['app.env' => 'testing']);
    }

    /**
     * Create authenticated user for API testing
     */
    protected function createAuthenticatedUser(array $attributes = []): \App\Models\User
    {
        $user = \App\Models\User::factory()->create($attributes);
        \Laravel\Sanctum\Sanctum::actingAs($user);
        return $user;
    }

    /**
     * Create admin user for admin API testing
     */
    protected function createAuthenticatedAdmin(array $attributes = []): \App\Models\Admin
    {
        $admin = \App\Models\Admin::factory()->create($attributes);
        \Laravel\Sanctum\Sanctum::actingAs($admin);
        return $admin;
    }
}