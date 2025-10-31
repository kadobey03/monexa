<?php

namespace Tests\Performance;

use Tests\TestCase;
use App\Models\{User, Deposit};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DatabasePerformanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_deposits_query_performance(): void
    {
        // Arrange
        $user = User::factory()->create();
        Deposit::factory()->count(100)->create(['user' => $user->id]);

        // Act
        $startTime = microtime(true);

        $queryCount = DB::getQueryLog();
        DB::enableQueryLog();

        $deposits = $user->deposits()->latest()->paginate(20);

        $executionTime = (microtime(true) - $startTime) * 1000; // Convert to ms
        $queries = DB::getQueryLog();

        // Assert
        $this->assertLessThan(100, $executionTime, 'Query should execute in under 100ms');
        $this->assertCount(2, $queries, 'Should only execute 2 queries (data + count)');
    }

    /** @test */
    public function n_plus_one_problem_prevention(): void
    {
        // Arrange
        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            Deposit::factory()->count(5)->create(['user' => $user->id]);
        }

        // Act
        DB::enableQueryLog();

        $usersWithDeposits = User::with('deposits')->get();

        $queries = DB::getQueryLog();

        // Assert
        $this->assertCount(2, $queries, 'Should use eager loading to prevent N+1');
    }

    /** @test */
    public function user_repository_query_optimization(): void
    {
        // Arrange
        User::factory()->count(50)->create(['account_verify' => 'Verified']);
        User::factory()->count(50)->create(['account_verify' => 'Pending']);

        // Act
        $startTime = microtime(true);

        DB::enableQueryLog();
        $pendingUsers = app(\App\Repositories\UserRepositoryInterface::class)->getUsersWithPendingKyc();

        $executionTime = (microtime(true) - $startTime) * 1000;
        $queries = DB::getQueryLog();

        // Assert
        $this->assertLessThan(50, $executionTime, 'Repository query should be fast');
        $this->assertCount(1, $queries, 'Should execute only one query');
        $this->assertCount(50, $pendingUsers, 'Should return correct number of pending users');
    }

    /** @test */
    public function deposit_repository_bulk_operations_performance(): void
    {
        // Arrange
        $user = User::factory()->create();
        Deposit::factory()->count(200)->create(['user' => $user->id]);

        // Act
        $startTime = microtime(true);

        DB::enableQueryLog();
        $totalAmount = app(\App\Repositories\DepositRepositoryInterface::class)->getTotalDepositAmount($user->id);

        $executionTime = (microtime(true) - $startTime) * 1000;
        $queries = DB::getQueryLog();

        // Assert
        $this->assertLessThan(30, $executionTime, 'Bulk operation should be fast');
        $this->assertCount(1, $queries, 'Should use optimized aggregation query');
        $this->assertGreaterThan(0, $totalAmount, 'Should return total amount');
    }

    /** @test */
    public function complex_financial_report_performance(): void
    {
        // Arrange - Create realistic financial data
        $users = User::factory()->count(20)->create();
        foreach ($users as $user) {
            Deposit::factory()->count(10)->create([
                'user' => $user->id,
                'status' => 'Processed',
                'created_at' => now()->subDays(rand(0, 90))
            ]);
        }

        // Act
        $startTime = microtime(true);

        DB::enableQueryLog();

        // Simulate a complex financial report query
        $report = Deposit::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total')
                        ->where('status', 'Processed')
                        ->whereBetween('created_at', [now()->subDays(30), now()])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

        $executionTime = (microtime(true) - $startTime) * 1000;
        $queries = DB::getQueryLog();

        // Assert
        $this->assertLessThan(150, $executionTime, 'Complex report should execute within acceptable time');
        $this->assertCount(1, $queries, 'Should use single optimized query');
        $this->assertGreaterThan(0, $report->count(), 'Should return report data');
    }

    /** @test */
    public function database_index_effectiveness(): void
    {
        // Arrange
        User::factory()->count(100)->create();
        $users = User::all();

        foreach ($users as $user) {
            Deposit::factory()->count(5)->create(['user' => $user->id]);
        }

        // Act - Test indexed query performance
        $startTime = microtime(true);

        DB::enableQueryLog();
        $userDeposits = Deposit::where('user', $users->first()->id)->get();

        $executionTime = (microtime(true) - $startTime) * 1000;
        $queries = DB::getQueryLog();

        // Assert
        $this->assertLessThan(20, $executionTime, 'Indexed query should be very fast');
        $this->assertCount(1, $queries, 'Should execute single query');
        $this->assertCount(5, $userDeposits, 'Should return correct deposits');
    }

    /** @test */
    public function memory_usage_during_large_dataset_processing(): void
    {
        // Arrange
        $users = User::factory()->count(500)->create();

        // Act
        $startMemory = memory_get_usage();
        $startTime = microtime(true);

        $processedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'balance' => $user->account_bal
            ];
        });

        $executionTime = (microtime(true) - $startTime) * 1000;
        $endMemory = memory_get_usage();
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB

        // Assert
        $this->assertLessThan(100, $executionTime, 'Processing should be fast');
        $this->assertLessThan(50, $memoryUsed, 'Memory usage should be reasonable');
        $this->assertCount(500, $processedUsers, 'Should process all users');
    }

    /** @test */
    public function database_connection_pooling_simulation(): void
    {
        // Arrange
        $concurrentQueries = 10;

        // Act
        $startTime = microtime(true);

        $promises = [];
        for ($i = 0; $i < $concurrentQueries; $i++) {
            $promises[] = User::count();
        }

        $executionTime = (microtime(true) - $startTime) * 1000;

        // Assert
        $this->assertLessThan(500, $executionTime, 'Concurrent queries should complete within reasonable time');
    }
}