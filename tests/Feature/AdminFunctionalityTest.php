<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Admin};
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_user_list(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        User::factory()->count(5)->create();

        Sanctum::actingAs($admin);

        // Act
        $response = $this->getJson('/api/admin/users');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'email', 'lead_info']
                     ]
                 ]);
    }

    /** @test */
    public function admin_can_assign_lead(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $user = User::factory()->create(['lead_status' => 'new']);

        Sanctum::actingAs($admin);

        // Act
        $response = $this->postJson("/api/admin/users/{$user->id}/assign-lead", [
            'lead_status' => 'qualified',
            'notes' => 'High potential lead'
        ]);

        // Assert
        $response->assertStatus(200);

        $this->assertEquals('qualified', $user->fresh()->lead_status);
    }

    /** @test */
    public function admin_can_view_deposit_history(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $users = User::factory()->count(3)->create();
        $users->each(function ($user) {
            \App\Models\Deposit::factory()->count(2)->create(['user' => $user->id]);
        });

        Sanctum::actingAs($admin);

        // Act
        $response = $this->getJson('/api/admin/deposits');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'user',
                             'amount',
                             'status'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function admin_can_process_deposit(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $deposit = \App\Models\Deposit::factory()->create(['status' => 'Pending']);

        Sanctum::actingAs($admin);

        // Act
        $response = $this->postJson("/api/admin/deposits/{$deposit->id}/process", [
            'status' => 'Processed'
        ]);

        // Assert
        $response->assertStatus(200);

        $this->assertEquals('Processed', $deposit->fresh()->status);
    }

    /** @test */
    public function admin_can_view_withdrawal_requests(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $users = User::factory()->count(2)->create();
        $users->each(function ($user) {
            \App\Models\Withdrawal::factory()->create([
                'user' => $user->id,
                'status' => 'Pending'
            ]);
        });

        Sanctum::actingAs($admin);

        // Act
        $response = $this->getJson('/api/admin/withdrawals');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'user',
                             'amount',
                             'status'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function admin_can_approve_withdrawal(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $withdrawal = \App\Models\Withdrawal::factory()->create(['status' => 'Pending']);

        Sanctum::actingAs($admin);

        // Act
        $response = $this->postJson("/api/admin/withdrawals/{$withdrawal->id}/approve");

        // Assert
        $response->assertStatus(200);

        $this->assertEquals('Approved', $withdrawal->fresh()->status);
    }

    /** @test */
    public function admin_can_reject_withdrawal(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $withdrawal = \App\Models\Withdrawal::factory()->create(['status' => 'Pending']);

        Sanctum::actingAs($admin);

        // Act
        $response = $this->postJson("/api/admin/withdrawals/{$withdrawal->id}/reject", [
            'reason' => 'Invalid documents'
        ]);

        // Assert
        $response->assertStatus(200);

        $this->assertEquals('Rejected', $withdrawal->fresh()->status);
    }

    /** @test */
    public function admin_can_view_dashboard_statistics(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        User::factory()->count(10)->create();
        \App\Models\Deposit::factory()->count(5)->create(['status' => 'Processed']);
        \App\Models\Withdrawal::factory()->count(3)->create(['status' => 'Approved']);

        Sanctum::actingAs($admin);

        // Act
        $response = $this->getJson('/api/admin/dashboard/stats');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'total_users',
                         'total_deposits',
                         'total_withdrawals',
                         'pending_deposits',
                         'pending_withdrawals'
                     ]
                 ]);
    }

    /** @test */
    public function admin_can_export_user_data(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        User::factory()->count(5)->create();

        Sanctum::actingAs($admin);

        // Act
        $response = $this->getJson('/api/admin/export/users');

        // Assert
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true
                 ]);
    }

    /** @test */
    public function admin_can_manage_lead_statuses(): void
    {
        // Arrange
        $admin = Admin::factory()->create();
        $users = User::factory()->count(3)->create(['lead_status' => 'new']);

        Sanctum::actingAs($admin);

        // Act - Bulk update lead statuses
        $response = $this->postJson('/api/admin/leads/bulk-update', [
            'user_ids' => $users->pluck('id')->toArray(),
            'lead_status' => 'contacted'
        ]);

        // Assert
        $response->assertStatus(200);

        $users->each(function ($user) {
            $this->assertEquals('contacted', $user->fresh()->lead_status);
        });
    }
}